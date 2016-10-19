<?php

require_once '/secure/constants.php';

class Mysql {
	private $conn;

	function __construct() {
		$this->conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME) or
					  die('There was a problem connecting to the database.');
	}

	function verify_Username_and_Pass($un, $pwd) {

		$query = "SELECT *
				FROM users
				WHERE username = ? AND password = ?
				LIMIT 1";

		if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param('ss', $un, $pwd);
			$stmt->execute();

			if($stmt->fetch()) {
				$stmt->close();
				return true;
			}
		}
	}

	function verify_f1($un) {

		$query = "SELECT f1_access
				FROM users
				WHERE username = ? and f1_access = 1
				LIMIT 1";

		if($stmt = $this->conn->prepare($query)) {
			$stmt->bind_param('s', $un);
			$stmt->execute();

			if($stmt->fetch()) {
				$stmt->close();
				return true;
			}
		}
	}

	function insert_photos($files, $album)
	{
		#query template
		$query = "INSERT INTO photos (filename, album) VALUES (?,?)";
		$file_ids = array();

		if($stmt = $this->conn->prepare($query))
		{
			$stmt->bind_param('si',$filename,$album);

			foreach($files as $filename)
			{
				echo "Inserting $filename into $album<BR>\n";

				#generate file extension
				$extension = strtoupper(substr($filename,strlen($filename)-4,4));
				echo "Extension: ".$extension."<BR>\n";

				$stmt->execute() or die('Unable to execute statement.');

				#get insert id
				$new_id = $this->conn->insert_id;
				echo "New Filename:".$new_id.$extension."<BR><BR>\n";
				$count = sizeof($file_names);
				$file_names[$count]['new_name'] = $new_id.$extension;
				$file_names[$count]['old_name'] = $filename;
			}
		}

		$stmt->close();
		return $file_names;
	}

	function check_album_exists($album) {
		$query = "SELECT id FROM albums WHERE name = ? LIMIT 1";
		if($stmt = $this->conn->prepare($query))
		{
			$stmt->bind_param('s',$album);
			$stmt->execute();

			if($stmt->fetch())
			{
				$stmt->close;
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	function create_album($album) {
		$query = "INSERT INTO albums (name) VALUES (?)";
		$album_id = false;
		if($stmt = $this->conn->prepare($query))
		{
			$stmt->bind_param('s',$album);
			$stmt->execute() or die('unable to create album');
			$album_id = $this->conn->insert_id;
			$stmt->close();
		}
		return $album_id;
	}

	function get_album_id($album) {
		$query = "SELECT id FROM albums WHERE name = ? LIMIT 1";
		$album_id = false;
		if($stmt = $this->conn->prepare($query))
		{
			$stmt->bind_param('s',$album);
			$stmt->execute();
			$stmt->bind_result($album_id);
			if($stmt->fetch())
			{
				$stmt->close();
			}
		}
		return $album_id;
	}

	function get_album_title($album) {
		$query = "SELECT name FROM albums WHERE id = ? LIMIT 1";
		$album_title = false;
		if($stmt = $this->conn->prepare($query))
		{
			$stmt->bind_param('i',$album);
			$stmt->execute();
			$stmt->bind_result($album_title);
			if($stmt->fetch())
			{
				$stmt->close();
			}
		}
		return $album_title;
	}

	function get_filename($file) {
		$query = "SELECT filename FROM photos WHERE id = ? LIMIT 1";
		$filename = false;
		if($stmt = $this->conn->prepare($query))
		{
			$stmt->bind_param('i',$file);
			$stmt->execute();
			$stmt->bind_result($filename);
			if($stmt->fetch())
			{
				$stmt->close();
			}
		}
		return $filename;
	}


	function get_thumbs($album,$order,$limit) {

		#query template
		$query = "SELECT id FROM photos WHERE album = ? ORDER BY $order";
		if($limit > 0) { $query .= " LIMIT $limit"; }

		#send template to server
		if($stmt = $this->conn->prepare($query)) {

			#bind parameters to query
			$stmt->bind_param('i',$album);

			#execute the full query
			$stmt->execute();

			#bind the results to our variables
			$stmt->bind_result($id);

			#build an array of the results
			$row_array = array();
			$key=1;
			while($stmt->fetch()) {
				$row_array[$key]=$id;
				$key++;
			}


			#return that array
			return $row_array;
		}
		else
		{
			echo "statement failed.<BR>";
		}
	}


	function fetch_table_rows($table,$field) {

		#query template
		$query = "SELECT id, $field FROM $table ORDER BY -time";

		#send template to server
		if($stmt = $this->conn->prepare($query)) {

			#execute the full query
			$stmt->execute();

			#bind the results to our variables
			$stmt->bind_result($id, $col);

			#build an array of the results
			$row_array = array();
			while($stmt->fetch()) {
				$row_array[$id]=$col;
			}


			#return that array
			return $row_array;
		}
		else
		{
			echo "statement failed.<BR>";
		}
	}
}

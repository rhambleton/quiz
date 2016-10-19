<?php

class imagegallery {

	private $db;
	
	function __construct() {
		$this->db = new Mysql();
	}
		
	function check_for_uploads() {
		$upload_dir = opendir(UPLOAD_DIR);
		$file_count = 0;
		
		while (false !== ($file = readdir($upload_dir))) {
			if($file != "." and $file != "..") {
				$file_count++;
			}
		}
	
		if($file_count > 0) {
		
			#redirect to upload management page
			header("location: new_photos.php");	
			
		}
	}
	
	function create_album($album) {
		
		$mysql = $this->db;
		
		#verify album doesn't exist
		if(!$mysql->check_album_exists($album))
		{
			echo "Album does NOT exist - Creating...<BR>\n";			
			if($album_id = $mysql->create_album($album))
			{
				echo "...Created.<BR>$album&nbsp;$album_id<BR><BR>\n";
				return $album_id;
			}
			else
			{
				echo "...Failed.<BR><BR>\n";				
				return false;
			}
		}
		else
		{
			echo "Album already exists - Adding images to existing album.<BR><BR>\n";			

			#get id of existing album
			$album_id = $mysql->get_album_id($album);			
			return $album_id;
		}

	}

	function process_uploads($album) {
		$mysql = $this->db;
		
		#open uploads folder
		$upload_dir = opendir(UPLOAD_DIR);
		$files = array();
		
		echo "Scanning Folder...<BR>\n";		

		while (false !== ($file = readdir($upload_dir))) {
			
			$full_path = UPLOAD_DIR."/".$file;
			$original_path = ORIGINAL_DIR."/".$file;
			$thumb_path = THUMB_DIR."/".$file;
			$large_path = LARGE_DIR."/".$file;

			if($file != "." && $file != ".." && is_file($full_path))
			{
				echo $full_path."<BR>\n";
				$file_count = sizeof($files);				
				$files[$file_count] = $file;
			}
		}

		$new_files = $mysql->insert_photos($files,$album);

		
		echo "Processing Complete.<BR>\n";
		print_r($new_files);

		#copying files

		foreach($new_files as $file)
		{
			$thumb_path = THUMB_DIR."/".$file['new_name'];
			$large_path = LARGE_DIR."/".$file['new_name'];
			$original_path = ORIGINAL_DIR."/".$file['new_name'];
			$uploaded_path = UPLOAD_DIR."/".$file['old_name'];

			#move original from uploaded folder to permanent home on server with new filename
			if(copy($uploaded_path,$original_path))
			{
				#create thumbnail and place it in appropriate place on server
				if($this->copy_resized($uploaded_path,$thumb_path,MAX_THUMB_HEIGHT,MAX_THUMB_WIDTH))
				{
					#create large sized image and place in in appropriate place on server
					if($this->copy_resized($uploaded_path,$large_path,MAX_LARGE_HEIGHT,MAX_LARGE_WIDTH))
					{
						echo "Resized Files Created.<BR>$large_path<BR>$thumb_path<BR>$uploaded_path<BR><BR>\n";
						unlink($uploaded_path);
					}
					else
					{
						echo "unable to create large sized image<BR>$uploaded_path<BR><BR>";
					}
				}
				else
				{
					echo "unable to create thumbnail<BR>$uploaded_path<BR><BR>";
				}
			}
			else
			{
				echo "unable to copy image<BR>$uploaded_path<BR><BR>";
			}
		}
	} 
	
	function copy_resized($orig_path,$dest_path,$max_height,$max_width) {

		#open original image
		$img = imagecreatefromjpeg($orig_path);

		#get original height and width
		$img_width = imagesx($img);
		$img_height = imagesy($img);

		#calculate reduction ratios
		$width_ratio = $max_width/$img_width;
		$height_ratio = $max_height/$img_height;


		#reduce to fit box max_width x max_height
		if($width_ratio < $height_ratio)
		{
			$new_width = $max_width;
			$new_height = $img_height * $width_ratio;
		}
		else
		{
			$new_height = $max_height;
			$new_width = $img_width * $height_ratio;	
		}

		$output_img = @imagecreatetruecolor($new_width,$new_height);
    		if(@imagecopyresampled($output_img, $img, 0, 0, 0, 0, $new_width, $new_height, $img_width, $img_height))
		{
    			if(@imagejpeg($output_img,$dest_path))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function get_albums() {
	
		$mysql = $this->db;
		$album_array = $mysql->fetch_table_rows("albums","id");
		return $album_array;	
	}

	function get_album_names() {
	
		$mysql = $this->db;
		$album_array = $mysql->fetch_table_rows("albums","name");
		return $album_array;	
	}

	function get_title($album) {
		$mysql = $this->db;
		$album_title = $mysql->get_album_title($album);
		return $album_title;
	}

	function get_previews($album) {
		$mysql = $this->db;
		$previews = $mysql->get_thumbs($album, "time",PREVIEW_THUMB_COUNT);
		return $previews;
	}

	function get_thumbs($album) {
		$mysql = $this->db;
		$thumbs = $mysql->get_thumbs($album,"time",0);
		return $thumbs;

	}

	function get_filename($file) {
		$mysql = $this->db;
		$filename = $mysql->get_filename($file);
		return $filename;
	}
}

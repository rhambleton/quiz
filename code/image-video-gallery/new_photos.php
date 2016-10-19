<?php

require_once 'classes/Membership.php';
$membership = New Membership();
$membership->confirm_Member();

require_once 'classes/imagegallery.php';
$gallery = New imagegallery();

if(!empty($_POST['submit'])) {

	if($_POST['new_album'] != "") {
		$album_name = $_POST['new_album'];
		echo "New Album Requested: ".$album_name."<BR><BR>\n";
		$album = $gallery->create_album($album_name);
		echo "Album created - id: ".$album."<BR><BR>\n";

	}
	else
	{
		$album = $_POST['old_album'];
	}
	set_time_limit(600);	
	$gallery->process_uploads($album);

}
else
{

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/reset.css" />

<!--[if lt IE 7]>
<script type="text/javascript" src="js/DD_belatedPNG_0.0.7a-min.js"></script>
<![endif]-->


<title>Untitled Document</title>



</head>

<body>

<div id="container">
	<form action="new_photos.php" method="post">
	New Images have been uploaded to the server.<BR>
	You may add them to an existing album, or enter the name of a new album.<BR>
	<BR>
	<table border="0" cellpadding="0" cellspacing="0">
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td>Existing album:&nbsp;</td>
			<td>
				<select name="old_album">
					<option value=""></option>
					<?php
						
						$albums = $gallery->get_album_names();
					
						foreach($albums as $key => $this_album)
						{
							?><option value="<?=$key;?>"><?=$this_album;?></option><?php
						}
					?>
				</select><BR>
			</td>
		</tr>
		<tr>
			<td>New Album:&nbsp;</td>
			<td><input size="20" name="new_album"></td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td><input type="submit" value="submit" name="submit"></td>
			<td>&nbsp;</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
	</table>
	</form>
	<p><a href="login.php?status=loggedout">Log Out</a></p>
</div><!--end container-->

</body>
</html>
<?php
}
?>

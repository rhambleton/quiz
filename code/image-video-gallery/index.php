<?php

require_once 'classes/Membership.php';
$membership = New Membership();

$membership->confirm_Member();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/default.css" />

<!--[if lt IE 7]>
<script type="text/javascript" src="js/DD_belatedPNG_0.0.7a-min.js"></script>
<![endif]-->


<title>Untitled Document</title>



</head>

<body>

<div id="content_space">
	<h2>Please select from the list below</h2>
	<p><a href="photos.php">Photo Gallery</a><p>
	<p><a href="videos.php">Video Gallery</a><p>
	<p><a href="login.php?status=loggedout">Log Out</a></p>
</div><!--end container-->

</body>
</html>

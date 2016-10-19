<?php

require_once 'classes/Membership.php';
$membership = New Membership();
$membership->confirm_Member();

require_once 'classes/imagegallery.php';
$gallery = New imagegallery();
$album = $_GET['album'];
$thumbs = $gallery->get_thumbs($album);

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

<div id="container">
		<table border="0" cellpadding="0" cellspacing="0" width="800">
			<tr>
				<td width="200" align="left"><a href="photos.php">< Back</a></td>
				<td>&nbsp;</td>
				<td width="200" align="right"><a href="login.php?status=loggedout">Log Out</a></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="0" width="800">
			<tr height='102'>
				<td width="36">&nbsp;</td>
			<?php	
				$thumb_count = 0;		
				foreach($thumbs as $thumb)
				{
					?><td width="102" align="center"><a href="view_img.php?file=<?=$thumb;?>&album=<?=$album;?>"><img src="img.php?file=<?=$thumb;?>&size=thumb" width="<?=INDEX_THUMB_WIDTH;?>" height="<?=INDEX_THUMB_HEIGHT;?>" border=0></a></td><?php
					$thumb_count++;

					if($thumb_count % INDEX_THUMB_COUNT == 0)
					{
						echo "<td width='36'>&nbsp;</td></tr><tr height='104'><td width='50'>&nbsp;</td>";
					}
					
				}
			?>
				<td width="36">&nbsp;</td>
			</tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="0" width="800">
			<tr>
				<td width="200" align="left"><a href="photos.php">< Back</a></td>
				<td>&nbsp;</td>
				<td width="200" align="right"><a href="login.php?status=loggedout">Log Out</a></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
		</table>

</div><!--end container-->

</body>
</html>

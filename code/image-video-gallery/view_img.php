<?php

require_once 'classes/Membership.php';
$membership = New Membership();
$membership->confirm_Member();

require_once 'classes/imagegallery.php';
$gallery = New imagegallery();
$file = $_GET['file'];
$album = $_GET['album'];
$thumbs = $gallery->get_thumbs($album);
$this_id = array_search($file,$thumbs);
$next_id = $this_id + 1;
$last_id = $this_id - 1;

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
		<table border="0" cellpadding="0" cellspacing="0">
			<tr><td align="center"><a href="img.php?file=<?=$file;?>&size=original"><img src="img.php?file=<?=$file;?>&size=large" border="0"></a></td></tr>
			<tr>
				<td>
					<?php
						$next = $thumbs[$next_id];
						$last = $thumbs[$last_id];
					?>
					<table width="<?=MAX_LARGE_WIDTH;?>" border=1>
						<tr>
							<td width="<?=MAX_THUMB_WIDTH;?>">
								<a href="view_img.php?file=<?=$last;?>&album=<?=$album;?>"><img src="img.php?file=<?=$last;?>&size=thumb" border="0"></a>
							</td>
							<td>
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr><td align="center">Click Image Above To Save Full Sized Version</td></tr>
									<!-- <tr><td align="center">Rotate</td></tr> -->
									<tr><td align="center"><a href="view_album.php?album=<?=$album;?>">Album Index</a></td></tr>
									<tr><td align="center"><a href="login.php?status=loggedout">Log Out</a></td></tr>
								</table>
							</td>
							<td width="<?=MAX_THUMB_WIDTH;?>">
								<a href="view_img.php?file=<?=$next;?>&album=<?=$album;?>"><img src="img.php?file=<?=$next;?>&size=thumb" border="0"></a>
							</td>
						</tr>
					<table>
				</td>
			</tr>
		</table>
</div><!--end container-->

</body>
</html>

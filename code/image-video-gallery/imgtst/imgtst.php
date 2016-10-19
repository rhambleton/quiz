<?php
	if (!isset($_GET['URL']))
	{
		?>
		<form action="imgtst.php" method="GET">
			<input name="URL" type="text" size="15"><BR>
			<input type="submit" value="Submit" name="submit">
		</form>
		<?php

	}
	else
	{
		$pageurl = $_GET['URL'];
		$pagecontents = file_get_contents($pageurl);
				preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',$pagecontents, $urls);
		$urls = $urls[0];

		foreach($urls as $img)
		{
			#site specific cludge to get full size images
			if(strpos($img,"/images/thumb/"))
			{
				$img = str_replace("/images/thumb/","/images/full/",$img);
				?>Url: <?=$img;?><BR><img src="<?=$img;?>"><BR><?php
			}
		}

	}
?>

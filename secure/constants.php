<?php

// Define constants here

// mysql constants
define('DB_SERVER', 'db');								# mysql server hostname/ip address
define('DB_USER', 'gallery_user');                      # mysql access credential (must be a valid username on the mysql server)
define('DB_PASSWORD', 'gallery_pass');                  # mysql access credential
define('DB_NAME', 'image-video-gallery-db');			# mysql database used to store gallery data
define('ALBUM_TBL', 'albums');							# mysql table used to store album data
define('PHOTO_TBL','photos');							# mysql table used to store photo data

// image gallery constants
define('PREVIEW_THUMB_COUNT',6);						# the number of thumbnail previews to display on the album list
define('PREVIEW_THUMB_WIDTH',50);						# the width of the thumbnail previews displayed on the album list
define('PREVIEW_THUMB_HEIGHT',50);						# the height of the thumbnail previews displayed on the album list

define('INDEX_THUMB_COUNT',7);							# the number of thumbnail previews to display on each row when viewing an album
define('INDEX_THUMB_WIDTH',75);						# set the display width of thumbnails
define('INDEX_THUMB_HEIGHT',75);						# set the display height of thumbnails

# image upload constants
define('THUMB_FORCE_SQUARE',0);							# TODO - crop thumbnails after resize to make them squar
define('LARGE_FORCE_SQUARE',0);							# TODO - crop large images after resize to make them square
define('MAX_LARGE_HEIGHT',600);							# set the maximum height of large images
define('MAX_LARGE_WIDTH',800);							# set the maximum width of large images
define('MAX_THUMB_WIDTH',100);                     		# set the max width of thumbnails
define('MAX_THUMB_HEIGHT',100);                    		# set the maximum height of thumbnails
define('UPLOAD_DIR', '/secure/photos/uploaded');		# location to drop new files (via FTP)
define('THUMB_DIR', '/secure/photos/thumb');			# location to store thumbnails
define('ORIGINAL_DIR', '/secure/photos/original');		# location to store copies of the original images
define('LARGE_DIR', '/secure/photos/large');			# location to store large sized images


?>

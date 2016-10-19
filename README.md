# image/video gallery
Simple Image/Video Gallery

File Structure Overview
-----------------------
./database.sql - sql file to created database structure within mysql
./docker-compose.yml - docker-compose file to setup enviornment (3 docker containers)
./README.md - this file
./site.conf - custom configuration parameters for NGINX
./code - webroot folder
./code/image-video-gallery/login.php - basic login page
./code/image-video-gallery/index.php - functions as a main menu for the gallery
./code/image-video-gallery/img.php - reads in specificed image and passes it through to the browser
./code/image-video-gallery/photos.php - presents index of all albums with preview images
./code/image-video-gallery/view_album.php - presents thumbnails of all images within the album
./code/image-video-gallery/view_img.php - displays a large copy of the image with navigation controls to scroll through images within the album
./code/image-video-gallery/videos.php - presents a list of available videos (currently hard coded with no thumbnails)
./code/image-video-gallery/new_photos.php - used to create new galleries and upload files
./code/image-video-gallery/imagegallery.php - function definitions for displaying the image gallery
./code/image-video-gallery/membership.php - function definitions for handling login and authentication
./code/image-video-gallery/mysql.php - function definitions for handling mysql database connection and queries
./code/image-video-gallery/css/default.css - css definitions to control layout
./code/image-video-gallery/css/reset.css - ??
./code/image-video-gallery/imgtst/imgtst.php - unrelated script for ripping all images from a website
./code/image-video-gallery/js/main.js - javascript file - currently only used to fade login error message
./code/image-video-gallery/js/DD_belatedPNG_0.0.7a-min.js - some sort of IE 7 work around
./mysql - persistent data store for mysql server
./php_image - contains dockerfile for building the modified php image (with GD and MYSQLI support enabled)
./secure - none web accessible storage of images and videos
./secure/constants.php - user defined constants and configuration parameters for the image gallery

Note: Image-Video-Gallery requires PHP with GD and MYSQLI extensions available (GD must have jpeg support)

Getting Started
- ensure the following are installed locally: docker, docker-compose, mysql client
- execute docker-compose up
- use mysql client to connect to the mysql server
- use the mysql client to execute database.sql - this will build the tables and create a default user
	- username: user
	- password: password
- additional users can be added to the table users (use md5 function to insert the password)
- upload some images to /secure/photos/uploaded
- visit the image gallery using your web browser and login
- navigate to /image-videogallery/new_photos.php
- enter the name of a new gallery and continue
- the gallery will be created and populated with the images from the uploaded folder
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Quiz v0.0.1</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>
    
  	<div id="quiz_master" class="container">
  		<div id = "title_row" class="row"></div>
    </div>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  
<script>

 	<!-- set everything up when the page loads -->
 	$(document).ready(function() {

	 	<!-- begin local session -->

			//check for a question variable, otherwise use default
			question_id = $_GET('question_id');
			if(question_id == undefined) {
				question_id = "start";
			}

	 		//check if we have a quiz variable
	 		quiz_id = $_GET('quiz_id');
	 		if (quiz_id == "undefined") {

	 			//generate a unique ID (unique to this session)

	 			//read in data from remote storage
	 			quiz = fetch_remote_data();

	 			//store quiz data in session storage

	 		}
	 		else
	 		{
	 			//check if quiz_id is valid

	 				//if it is - use it to retrieve quiz information

	 					//read in data from local storage

	 				//if it isn't, generate a new one and start over

	 					//generate a unique ID

	 					//read in data from remote storage
	 					quiz = fetch_remote_data();

	 					//drop content to persistent local storage

	 		}


	 		if(question_id == "last") {

	 			<!-- quiz complete placeholder code -->

		  		//insert the div that contains the question text
		  		$("<div></div>").attr( { id : "question_master" , class : "col-xs-5 text-center" } ).appendTo('#title_row');
		  		
		  		//insert the <h4> block that contains and formats the actual text
		  		$("<h4></h4>").attr( { id : "question_text" } ).appendTo('#question_master');
		  		$("<a></a>").attr( { href : "default.php?question_id=1" , id : "start_over_link" } ).appendTo('#question_master');

		  		//set the text
		  		$("#question_text").text("You have finished the quiz. Thanks.");
		  		$("#start_over_link").text("Try Again");

		  		//insert a spacer to comple the row
		  		$("<div>&nbsp;</div>").attr( { class : "col-xs-6" } ).appendTo('#title_row');


	 			<!-- display completion message -->
	 			<!-- display final score -->
	 			<!-- display facebook links, etc. -->

	 		} else if (question_id == "start") {

	 			<!-- quiz start page placeholder code -->

		  		//insert the div that contains the question text
		  		$("<div></div>").attr( { id : "question_master" , class : "col-xs-5 text-center" } ).appendTo('#title_row');
		  		
		  		//insert the <h4> block that contains and formats the actual text
		  		$("<h4></h4>").attr( { id : "question_text" } ).appendTo('#question_master');
		  		$("<a></a>").attr( { href : "default.php?question_id=1" , id : "start_over_link" } ).appendTo('#question_master');

		  		//set the text
		  		$("#question_text").text("Are you ready to start the quiz?");
		  		$("#start_over_link").text("Let's Go!");

		  		//insert a spacer to comple the row
		  		$("<div>&nbsp;</div>").attr( { class : "col-xs-6" } ).appendTo('#title_row');


	 		}
	 		else
	 		{


			  	<!-- populate content into page template -->

		  		<!-- update the question text -->

		  		//insert the div that contains the question text
		  		$("<div></div>").attr( { id : "question_master" , class : "col-xs-5 text-center" } ).appendTo('#title_row');
		  		
		  		//insert the <h4> block that contains and formats the actual text
		  		$("<h4></h4>").attr( { id : "question_text" } ).appendTo('#question_master');

		  		//set the text
		  		$("#question_text").text(quiz[question_id]['text']);

		  		//insert a spacer to comple the row
		  		$("<div>&nbsp;</div>").attr( { class : "col-xs-6" } ).appendTo('#title_row');

		  		//loop over all the options and generate rows and divs for them
		  		this_option = 1;
		  		while(this_option <= quiz[question_id]["option_count"])
		  		{
		  			//generate javascript id's for the new elements
		  			row_id = "row_option_"+this_option;
		  			option_id = "div_option_"+this_option;
		  			button_id = "btn_option_"+this_option;
		  			onclick_text = "validate_answer("+this_option+")";

		  			//create row
					$("<div></div>").attr( { id : row_id , class : "row" } ).appendTo('#quiz_master');    

					//create spacer div
					$("<div></div>").attr('class' , "col-xs-1").appendTo('#'+row_id);    

					//create option div
					$("<div></div>").attr( { id : option_id , class : "col-sm-3" } ).appendTo('#'+row_id);    

					//create button
					$("<button></button>").attr( { id : button_id , class : "btn btn-default btn-block" , onclick : onclick_text } ).appendTo('#'+option_id);

					//create spacer
					$("<div></div>").attr('class' , "col-xs-8").appendTo('#'+row_id);    

					//update button text
					$("#"+button_id).text(quiz[question_id][this_option]);

		  			this_option++;
		  		}

			  	<!-- template populated -->
	  		}
 	});


  	<!-- validate answer from user -->
  	function validate_answer(option)
  	{
  		//build question id
  		question_id = $_GET('question_id');

  		//loop over all the options and mark the clicked one with the appropriate color
  		this_option = 1;
  		while(this_option <= quiz[question_id]["option_count"])
  		{
			//build button id
			button_id = "#btn_option_"+this_option;

  			if(this_option == option) {

  				//remove default class
  				$(button_id).removeClass("btn-default",0);

  				//apply correct class based on quiz type
  				switch(quiz[0]["type"]) {

		  			case "knowledge":
		  				if(option == quiz[question_id]["correct"]) {
		  					$(button_id).addClass( "btn-success");
		  					$(button_id).text("CORRECT!");
		  				}
		  				else
		  				{
		  					$(button_id).addClass( "btn-danger");
		  					$(button_id).text("WRONG!");
		  				}
		  				break;

		  			case "personality":
		  				$(button_id).addClass( "btn-primary");
		  				break;
		  		}
 			}
 			else
 			{
 				//disable all the other buttons
 				$(button_id).addClass("disabled");
 				$(button_id).prop('onclick',null).off('click');
 			}

  			this_option++;
  		}

  		//update score

  		//get id of next question
  		next_question = +question_id+1;
  		
  		//if question doesn't exist load results page
  		if(next_question > quiz[0]['question_count']) {
  			next_question = "last";
  		}

  		window.setTimeout(function() {
  			window.location.href = "default.php?question_id="+next_question;
  		},200);
  	}

  	function $_GET(part) {
		//parse URL for get variables
	 	var parts = window.location.search.substr(1).split("&");
		var $_PARTS = {};
		for (var i = 0; i < parts.length; i++) {
    		var temp = parts[i].split("=");
		   	$_PARTS[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
		}
		return $_PARTS[part];
	}

 	function fetch_remote_data() {

 		//place holder function for interfacing with server side quiz storage
		var new_quiz = {

			0 : {type : "knowledge" , question_count : 5},
			1 : {text : "What is the airspeed velocity of an unladed swallow?", option_count : 5, 1 : "11 m/s" , 2 : "22 m/s" , 3 : "33 m/s" , 4 : "44 m/s" , 5 : "African or European?", correct : 5},
			2 : {text : "How will you answer this question?", option_count : 3 , 1 : "Correctly" , 2 : "Incorrectly" , 3 : "I don't know.", correct : 2},
			3 : {text : "Is this a real question?" , option_count : 2 , 1 : "Yes" , 2 : "No" , correct : 2},
			4 : {text : "Is this statement false?" , option_count : 2 , 1 : "Yes" , 2 : "No" , correct : 2},
			5 : {text : "Why?" , option_count : 4, 1 : "Why not?", 2 : "Because." , 3 : "I said so, that's why!", 4 : "Shutup.", correct : 2, 8 : 0}
		};
		return new_quiz;
 	} 	

  	</script>

  </body>
</html>

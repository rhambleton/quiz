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
    
<<<<<<< HEAD
  	<div id="quiz_master" class="container"></div>
=======
  	<div id="quiz_master" class="container">
  		<div id = "title_row" class="row"></div>

      <div id="question"></div>
      <div id="answers"></div>
    </div>
>>>>>>> 7bdabff3a1b5b6ed0059dcc16ab47da63ede2287
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  
<script>

<<<<<<< HEAD
 	var quiz = new Object();
 	var show_progress = 1;
 	var scored = 0;

 	$(document).ready(function() {

		//check for a question variable, otherwise use default
		question_id = $_GET('question_id');
		if(question_id == undefined) {
			question_id = "start";
		} // end if

 		//check if we should display the progress indicator
 		show_progress = $_GET('show_progress');
 		if(show_progress == undefined) {
 			show_progress = 0;
 		} // end if

 		//check if we have a quiz variable
 		quiz_id = $_GET('quiz_id');
 		if (quiz_id == undefined) {

 			//generate a unique ID (unique to this session)
 			quiz_id = generate_id();

 			//reload page with new quiz_id
 			window.location.href = "default.php?quiz_id="+quiz_id+"&question_id="+question_id+"&show_progress="+show_progress;
 		} // end if

		//check if quiz data has already been stored locally
		local_id = "Quiz_"+quiz_id;
		if (sessionStorage.getItem(local_id) === null) {
				
			//data has not been stored locally so fetch it remotely
			quiz = fetch_remote_data();

			//store the data locally for later use
			sessionStorage.setItem(local_id, JSON.stringify(quiz));

		} // end remote data collection + storage
		else
		{

			//data exists locally - load the data from local storage
			var quiz_string = sessionStorage.getItem(local_id);
			quiz = JSON.parse(quiz_string);

		} //end loading of local data

 		if(question_id == "last") {

 			// figure out what format the summary page should have
 			switch(quiz.meta.type) {

 				case "knowledge" :

		 			// loop through all questions calculate maximum score
		 			max_score = 0;
		 			for(this_question in quiz.questions) {
		 				question_max = 0;
		 				for(this_option in quiz.questions[this_question].options) {
		 					question_max = Math.max(quiz.questions[this_question].options[this_option].value, question_max);
		 				} // end for loop over options
		 				max_score += question_max;
		 			} // end for loop over questions

		 			//knowledge tests have 1 category so the category 1 score is the quiz score
		 			user_score = quiz.categories[1].score;

		 			//grab quiz specific text for this score
		 			score_text = quiz.categories[1].score_text[user_score];

			  		//insert the div that contains the question text
			  		output_html = "";
			  		output_html += "<div id=\"question_row\" class=\"row\">";
			  		output_html += "	<div id='question_master' class='col-xs-5 text-center'>";
			  		output_html += "		<h3>"+score_text+"</h3>";
			  		output_html += "		<h4 id='question_text'>";
			  		output_html += "			You scored "+quiz.categories[1].score+" out of "+max_score;
			  		output_html += "		</h4>";
			  		output_html += "		<a href=\"default.php?question_id=1&show_progress="+show_progress+"\" id=\"start_over_link\">";
			  		output_html += "			Try Again";
			  		output_html += "		</a>";
			  		output_html += "	</div>";
			  		output_html += "	<div class=\"col-xs-6\">&nbsp;</div>";
			  		output_html += "</div>"

			  		$('#quiz_master').html(output_html);
 					break;

 				case "personality" :

 					break;

 				case "price_quiz" :

 					break;

 			}// end switch (summary page format selector)

 		} else if (question_id == "start") {

 			// display the quiz's start page
 			output_html = "";
 			output_html += "<div id=\"question_row\" class=\"row\">";
 			output_html += "	<div id=\"question_master\" class=\"col-xs-5 text-center\">";
 			output_html += "		<h3>";
 			output_html += 				quiz.meta.title;
 			output_html += "		</h3>";
 			output_html += "		<h4>";
 			output_html += 				quiz.meta.intro_text;
 			output_html += "		</h4>";
 			output_html += "		<a href=\"default.php?quiz_id="+quiz_id+"&question_id=1&show_progress="+show_progress+"\" id=\"start_over_link\">";
 			output_html += 				quiz.meta.start_link_text;
 			output_html += "		</a>";
 			output_html += "	</div>";
 			output_html += "	<div class=\"col-xs-7\">&nbsp;</div>";
 			output_html += "</div>";

	  		$('#quiz_master').html(output_html);

 		}
 		else
 		{

			// display question
 			output_html = "";
 			output_html += "<div id=\"question_row\" class=\"row\">";
 			output_html += "	<div id=\"question_master\" class=\"col-xs-5 text-center\">";
 			output_html += "		<h4 id=\"question_text\">";
 			output_html += 				quiz.questions[question_id].text;
 			output_html += "		</h4>";
 			output_html += "	</div>";
 			output_html += "	<div class=\"col-xs-7\">&nbsp;</div>";
 			output_html += "</div>";

 			// display options
	  		for(this_option in quiz.questions[question_id].options)
	  		{
	  			//generate javascript id's for the new elements
	  			row_id = "row_option_"+this_option;
	  			option_id = "div_option_"+this_option;
	  			button_id = "btn_option_"+this_option;
	  			onclick_text = "validate_answer("+this_option+")";

	  			//create row
	  			output_html += "<div id=\""+row_id+"\" class=\"row\">";
	  			output_html += "	<div class=\"col-xs-1\">&nbsp;</div>";
	  			output_html += "	<div id=\""+option_id+"\" class=\"col-sm-3\">";
	  			output_html += "		<button id=\""+button_id+"\" class=\"btn btn-default btn-block\" onclick=\""+onclick_text+"\">";
	  			output_html += 				quiz.questions[question_id].options[this_option].label;
	  			output_html += "		</button>"
	  			output_html += "	</div>";
	  			output_html += "	<div class=\"col-xs-8\">&nbsp;</div>";
	  			output_html += "</div>";
	  		}
=======
 	// Set everything up when the page loads

  var heyRichard = 'Hi!';

  // If you want to be a super nazi
  // Self invoking anon function
  // Closure hell
  /*
  ;(function($){
    var heyRichard = 'Inside function';
    console.log(heyRichard);

    console.log('Watch!  jQuery!');
    console.log($);
    var quiz = 'balls';

  })(jQuery);

  console.log(heyRichard);
  */

 	var quiz = {};

  var QuizNit = function() {

    this.$_GET = function() {
      console.log('GET VAR');
    },

    this.quiz = {
      stuff: 'balls'
    }, // END :quiz {}

    // This function sets up all of the HTML for the quiz
    this.setInitialState = function() {
      var steveQuiz = getQuiz();
      
      if(steveQuiz['meta']['progressBar']) {
        this.setProgressBar();
      }

      $('#question').html('<div>' + steveQuiz['meta']['title'] + '</div>');

      var steve = {is:'amazing', yes: 'seriously'};

      var answers = '<ul>';
      for(var i=0; i< steveQuiz.questions[0]['options'].length; i++) {
        answers += '<li><a data-steve=\''+ JSON.stringify(steve) +'\' data-question_value="' + steveQuiz.questions[0]['options'][i]['value'] + '"class="question_link" href="#">' + steveQuiz.questions[0]['options'][i]['label'] + '</a></li>';
      }
      answers += '</ul>';

      $('#answers').html(answers);
    }, // END : setInitialState()

    this.setEventHandlers = function() {
      $('a.question_link').on('click',function(){
        console.log($(this).data('steve')['is']);
      });
    }, // END : setEventHandlers()

    this.setProgressBar = function() {
      $('#question').before('<div id="progress-bar">PROGRESS BAR</div>')
    }

  } // END : QuizNit

 	$(document).ready(function() {

    var Quiznit = new QuizNit();

    Quiznit.setInitialState();
    Quiznit.setEventHandlers();


	 	// begin local session

			//check for a question variable, otherwise use default
			question_id = $_GET('question_id');
			if(question_id == undefined) {
				question_id = "start";
			}

	 		//check if we have a quiz variable
	 		quiz_id = $_GET('quiz_id');
	 		if (quiz_id == undefined) {

	 			//generate a unique ID (unique to this session)
	 			quiz_id = generate_id();

	 			//reload page with new quiz_id
	 			window.location.href = "default.php?quiz_id="+quiz_id+"&question_id="+question_id;

	 		}

 			//check if quiz data has already been stored locally
 			local_id = "Quiz_"+quiz_id;
 			if (sessionStorage.getItem(local_id) === null) {
					
 				//data has not been stored locally so fetch it remotely
				quiz = fetch_remote_data();

				//store the data locally for later use
				sessionStorage.setItem(local_id, JSON.stringify(quiz));

			}
			else
			{

				//load the data from local storage
				var quiz_string = sessionStorage.getItem(local_id);
				quiz = JSON.parse(quiz_string);

			}


	 		if(question_id == "last") {

	 			<!-- quiz complete placeholder code -->

	 			//calculate maximum score
	 			this_question = 1;
	 			max_score = 0;

        // Never use while loops ever under any circumstance ever even if Jesus tells you to.
	 			while (this_question <= quiz[0]['question_count'])
	 			{
	 				//find maximum score for this question
	 				possible_scores = quiz[this_question]["weights"];
					var max = -Infinity, x;
					for( x in possible_scores) {
					    if( possible_scores[x] > max) max = possible_scores[x];
					}
					max_score += max;

	 				this_question++;
	 			}

          var quizHeader = '';





		  		//insert the div that contains the question text
		  		$("<div id='question_master' class='col-xs-5 text-center'></div>").appendTo('#title_row');

		  		//insert the <h4> block that contains and formats the actual text
		  		$("<h4></h4>").attr( { id : "question_text" } ).appendTo('#question_master');
		  		$("<h5></h5>").attr( { id : "score" } ).appendTo('#question_master');
		  		$("<a></a>").attr( { href : "default.php?question_id=1" , id : "start_over_link" } ).appendTo('#question_master');

		  		//set the text
		  		$("#question_text").text("You have finished the quiz!");
		  		$("#score").text("You scored "+quiz[0]["current_score"]+" out of "+max_score);
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
		  		$("<a></a>").attr( { href : "default.php?quiz_id="+quiz_id+"&question_id=1" , id : "start_over_link" } ).appendTo('#question_master');

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
>>>>>>> 7bdabff3a1b5b6ed0059dcc16ab47da63ede2287

	  		$('#quiz_master').html(output_html);

<<<<<<< HEAD
 			//display progress bar if selected
	  		if(show_progress == 1) {
=======
		  		//loop over all the options and generate rows and divs for them
		  		this_option = 1;

          var questions = '';

          questions += '<ul>';

          /*
          for(var i=0; i<window.theQuiz['questions'][0]['options'].length;i++) {
            console.log(window.theQuiz.questions[0].options[i]);

            questions += '<li>';
              questions += '<button>' + window.theQuiz.questions[0].options[i]['text'] + '</button>';
            questions += '</li>';
          }
          */

          // $('#questions_container').html(questions);

		  		while(this_option <= quiz[question_id]["option_count"])
		  		{

		  			//generate javascript id's for the new elements
		  			row_id = "row_option_"+this_option;
		  			option_id = "div_option_"+this_option;
		  			button_id = "btn_option_"+this_option;
		  			onclick_text = "validate_answer("+this_option+")";
>>>>>>> 7bdabff3a1b5b6ed0059dcc16ab47da63ede2287

	  			question_count = quiz.meta.question_count;
	  			progress = 100*(question_id-1) / question_count;


	  			output_html = "";
	 			output_html += "<div id=\"progress_spacer_row\" class=\"row\">";
	  			output_html += "	<div class=\"col-xs-12 text-center\">&nbsp;</div>";
	  			output_html += "</div>";

	  			output_html += "<div id=\"progress_row\" class=\"row\">";
	  			output_html += "	<div class=\"col-xs-1\">&nbsp;</div>";
	  			output_html += "	<div class=\"col-xs-3\">";
	  			output_html += " 		<div class=\"progress\">";
	  			output_html += "			<div class=\"progress-bar progress-bar-success\" role=\"progressbar\" aria-valuenow=\""+progress+"\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: "+progress+"%\">";
	  			output_html += "				<span>"+progress+"% Complete</span>";
	  			output_html += "			</div>";
	  			output_html += "		</div>";
	  			output_html += "	</div>";
	  			output_html += "	<div class=\"col-xs-8\">&nbsp;</div>";
	  			output_html += "</div>";

	  			$('#quiz_master').append(output_html);

	  		} // end if (progress bar display yes/no)

  		} // end page selector (first/last/question)

<<<<<<< HEAD
 	}); // end ready function
=======
          questions += '</ul>';

			  	<!-- template populated -->
	  		}
 	});
>>>>>>> 7bdabff3a1b5b6ed0059dcc16ab47da63ede2287


  	<!-- validate answer from user -->
  	function validate_answer(clicked_option)
  	{
  		//build question id
  		question_id = $_GET('question_id');

  		//loop over all the options and mark the clicked one with the appropriate color
  		for(this_option in quiz.questions[question_id].options)
  		{
  			//build button id
			button_id = "#btn_option_"+this_option;
			console.log(button_id);

  			if(this_option == clicked_option) {

  				//remove default class
  				$(button_id).removeClass("btn-default",0);

  				//apply correct class based on quiz type
  				switch(quiz.meta.type) {

		  			case "knowledge":
		  				if(quiz.questions[question_id].options[clicked_option].value == 1) {
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

		  			case "price_quiz":

		  				break;
		  		} // end button highlighting selector

  				//update score with the weight of the clicked button
  				if (scored == 0) {
  					
  					clicked_category = quiz.questions[question_id].options[clicked_option].category;

  					//score the quiz based on its type
  					switch (quiz.meta.type) {

  						case "knowledge" :
		  					quiz.categories[clicked_category].score += quiz.questions[question_id].options[clicked_option].value;
  							break;

  						case "personality" :
  							quiz.categories[clicked_category].score += quiz.questions[question_id].options[clicked_option].value;
  							break;

  						case "price_quiz" :

  							break;

  					} // end switch (score calculation selector)

  					scored = 1;	

  				} // end check if previously scored
  				
 			} // end if (this is the selected button)
 			else
 			{
 				//disable all the other buttons
 				$(button_id).addClass("disabled");
 				$(button_id).prop('onclick',null).off('click');
 
 			} // end if (this is not the slected button)

  			this_option++;

  		} // end loop over all options

  		//update score
		sessionStorage.setItem(local_id, JSON.stringify(quiz));

  		//get id of next question
  		next_question = +question_id+1;
  		
  		//if question doesn't exist load results page
  		if(next_question > quiz.meta.question_count) {
  			next_question = "last";
  		}

  		window.setTimeout(function() {
  			window.location.href = "default.php?quiz_id="+quiz_id+"&question_id="+next_question+"&show_progress="+show_progress;
  		},200);

  	} // end validate_answers functino

  	function $_GET(part) {
		//parse URL for get variables
	 	var parts = window.location.search.substr(1).split("&");
		var $_PARTS = {};

		for (var i = 0; i < parts.length; i++) {
    		var temp = parts[i].split("=");
		   	$_PARTS[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
		} // ends loop over URI parts
		return $_PARTS[part];
	} // ends $_GET function

	function generate_id() {
		var now = new Date();
		id = now.getFullYear().toString() + now.getMonth().toString() + now.getDate().toString() + now.getHours().toString() + now.getMinutes().toString() + now.getSeconds().toString() + now.getMilliseconds();
		return id;
	} // ends generate_id functin

  function getQuiz() {
    return theQuiz = {
      meta: {
        'type': 'knowledge',
        'title': 'An Impossible Logic Quiz',
        'progressBar': true
      },
      questions: [
        {
          'text': 'What is the airspeed velocity of an unladed swallow?',
          'options': [
            {
              'label': '11 m/s',
              'value': 11
            },
            {
              'label': '12 m/s',
              'value': 12
            },
            {
              'label': '13 m/s',
              'value': 13
            }
          ]
        },
        {
          'text': 'Balls'
        },
        {
          'text': 'In the mouth'
        },
      ]
    }
  }

 	function fetch_remote_data() {

		//this is place holder function for interfacing with server side quiz storage
 		//temporary variables for testing (0=knowledge, 1=personality)
 		personality_test = 0;

 		if (personality_test == 1) {

	 		
			var new_quiz = {
				meta : {

					type : "knowledge" ,
					question_count : 5,
					title : "Loopy Logic",
					intro_text : "Are you ready to feel stupid?",
					start_link_text : "Let's Go!"
				},

				//categories allow for several scores to be calculated in parallel
				categories : {

					category_count : 1,
					show_comparison : 0,
					win_by_category : 0,

					1 : {
						label : "right answers",
						score : 0,
						score_text : {

							0 : "Wow - you know nothing.",
							1 : "Well, ya got 1 right.  At least there's that.",
							2 : "2 out of 3 ain't bad.  Too bad there were 5 questions.",
							3 : "Not bad.",
							4 : "Oh man! You only missed 1. So close!",
							5 : "Wow! You really know your stuff!"
						}
					}

				},

				questions : {

					1 : {
					
						text : "What is the airspeed velocity of an unladed swallow?",
						option_count: 5,					
						options: {

							1 : {
								label : "11 m/s",
								value : 1,
								category : 1	
							}, // end option 1

							2 : {
								label : "22 m/s",
								value : 0,
								category : 1
							}, // end option 2

							3 : {
								label : "33 m/s",
								value : 0,
								category : 1
							}, // end option 3

							4 : {
								label : "44 m/s",
								value : 0,
								category : 1
							}, // end option 4

							5 : {
								label : "African or European?",
								value : 1,
								category : 1
							}

						} // end options for quesetion 1

					}, // end question 1

					2 : {
					
						text : "How will you anwer this question?",
						option_count : 3,
						options: {

							1 : {
								label : "Correctly",
								value : 1,
								category : 1	
							}, // end option 1

							2 : {
								label : "Incorrectly",
								value : 0,
								category : 1
							}, // end option 2

<<<<<<< HEAD
							3 : {
								label : "I don't know",
								value : 0,
								category : 1
							}, // end option 3

						} // end options for question 2

					}, // end question 1

					3 : {

						text : "Is this a real question?",
						option_count : 2,
						options: {

							1 : {
								label : "Yes",
								value : 1,
								category : 1	
							}, // end option 1

							2 : {
								label : "No",
								value : 0,
								category : 1
							}, // end option 2

						} // end options for question 3

					}, // end question 1

					

					4 : {

						text : "Is this statement false?",
						option_count : 2,
						options: {

							1 : {
								label : "Yes",
								value : 0,
								category : 1	
							}, // end option 1

							2 : {
								label : "No",
								value : 1,
								category : 1
							} // end option 2

						} // end options for quesetion 4

					}, // end question 4

					5 : {
					
						text : "Why?",
						option_count : 4,
						options: {

							1 : {
								label : "Why not?",
								value : 0,
								category : 1	
							}, // end option 1

							2 : {
								label : "Because.",
								value : 0,
								category : 1
							}, // end option 2

							3 : {
								label : "I said so, that's why!",
								value : 0,
								category : 1
							}, // end option 3

							4 : {
								label : "Shutup.",
								value : 1,
								category : 1
							} // end option 4

						} // end options for quesetion 5

					} // end question 5

				} // end questions[]

			}; // ends quiz object

		} // end if - select sample knowledge quiz
		else
		{

			var new_quiz = {
				meta : {

					type : "personality" ,
					question_count : 5,
					title : "Crazy Cars",
					intro_text : "If you were a car, what model would you be?",
					start_link_text : "Answer a few questions to find out!"
				},

				//categories allow for several scores to be calculated in parallel
				categories : {

					category_count : 3,
					show_comparison : 0,
					win_by_category : 1,

					1 : {
						label : "Hyundai Elantra",
						score : 0,
						score_text : "A trusty, reliable, Hyundai Elantra!"
					}, // end category 1

					2 : {
						label : "Aston Martin DB9",
						score : 0,
						score_text : "A Sleek, Sexy, Aston Martin DB9"
					}, // end category 2

					3 : {
						label : "BMW M5",
						score : 0,
						score_text : "A luxury family car, with the heart of a racing machine."
					} // end category 3
				},

				questions : {

					1 : {
					
						text : "Would you rather take it steady, or hit the fast lane?",
						option_count: 3,					
						options: {

							1 : {
								label : "Take it steady.",
								value : 1,
								category : 1	
							}, // end option 1

							2 : {
								label : "Hit the fast lane.",
								value : 1,
								category : 2
							}, // end option 2

							3 : {
								label : "It depends on the day.",
								value : 1,
								category : 3
							}, // end option 3

						} // end options for quesetion 1

					}, // end question 1

					2 : {
					
						text : "Bring the kids?",
						option_count : 3,
						options: {

							1 : {
								label : "Always.  They are the most important thing in my life",
								value : 1,
								category : 1	
							}, // end option 1

							2 : {
								label : "Sure.  They love it when I roll the windows down and hit the gas.",
								value : 1,
								category : 3
							}, // end option 2

							3 : {
								label : "What kids?",
								value : 1,
								category : 2
							}, // end option 3

						} // end options for question 2

					}, // end question 2

					3 : {

						text : "Get there fast, or get there safe?",
						option_count : 3,
						options: {

							1 : {
								label : "Get there fast.  Really Fast.",
								value : 1,
								category : 3	
							}, // end option 1

							2 : {
								label : "It doesn't matter how fast we go, if we don't get there at all.",
								value : 1,
								category : 1
							}, // end option 2

							2 : {
								label : "Hit the gas, but take the long way.  It's all about the journey.",
								value : 1,
								category : 2
							} // end option 3

						} // end options for question 3

					}, // end question 1

					

					4 : {

						text : "Bringing the golf clubs?",
						option_count : 3,
						options: {

							1 : {
								label : "Sure.  As long as we can fit them in.",
								value : 1,
								category : 2	
							}, // end option 1

							2 : {
								label : "Golf? Do you have any idea how much that game costs?",
								value : 1,
								category : 1
							}, // end option 2

							2 : {
								label : "Sure thing. What time do we tee off?",
								value : 1,
								category : 3
							} // end option 3

						} // end options for quesetion 4

					}, // end question 4

					5 : {
					
						text : "Do you live to work, or work to live?",
						option_count : 3,
						options: {

							1 : {
								label : "I live to work.  My job is everything to me.",
								value : 1,
								category : 3	
							}, // end option 1

							2 : {
								label : "Work?  What is this work you speak of?",
								value : 1,
								category : 2
							}, // end option 2

							3 : {
								label : "I work to live..but it seems like I'm always working.",
								value : 1,
								category : 1
							}, // end option 3

						} // end options for quesetion 5

					} // end question 5

				} // end questions[]

			}; // ends quiz object


		} // end if - select sample personality quiz
 
=======
			0 : {type : "knowledge" , question_count : 5, title : "An Impossible Logic Quiz", current_score : 0},
			1 : {text : "What is the airspeed velocity of an unladed swallow?", option_count : 5, 1 : "11 m/s" , 2 : "22 m/s" , 3 : "33 m/s" , 4 : "44 m/s" , 5 : "African or European?", weights : {1:1,2:0,3:0,4:0,5:0}},
			2 : {text : "How will you answer this question?", option_count : 3 , 1 : "Correctly" , 2 : "Incorrectly" , 3 : "I don't know.", weights : {1:1,2:1,3:0}},
			3 : {text : "Is this a real question?" , option_count : 2 , 1 : "Yes" , 2 : "No" , weights : {1:1,2:0}},
			4 : {text : "Is this statement false?" , option_count : 2 , 1 : "Yes" , 2 : "No" , weights : {1:0,2:1}},
			5 : {text : "Why?" , option_count : 4, 1 : "Why not?", 2 : "Because." , 3 : "I said so, that's why!", 4 : "Shutup.", weights : {1:0,2:0,3:0,4:1}}
		};


>>>>>>> 7bdabff3a1b5b6ed0059dcc16ab47da63ede2287
		return new_quiz;

 	} // ends fetch_remote_data function 	


  	</script>

  </body>
</html>

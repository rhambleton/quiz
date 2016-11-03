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

      <div id="question"></div>
      <div id="answers"></div>
    </div>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  
<script>

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

		  		//insert a spacer to comple the row
		  		$("<div>&nbsp;</div>").attr( { class : "col-xs-6" } ).appendTo('#title_row');

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

          questions += '</ul>';

			  	<!-- template populated -->
	  		}
 	});


  	<!-- validate answer from user -->
  	function validate_answer(clicked_option)
  	{
  		//build question id
  		question_id = $_GET('question_id');

  		//loop over all the options and mark the clicked one with the appropriate color
  		this_option = 1;
  		while(this_option <= quiz[question_id]["option_count"])
  		{
			//build button id
			button_id = "#btn_option_"+this_option;

  			if(this_option == clicked_option) {

  				//remove default class
  				$(button_id).removeClass("btn-default",0);

  				//apply correct class based on quiz type
  				switch(quiz[0]["type"]) {

		  			case "knowledge":
		  				if(quiz[question_id]["weights"][clicked_option] == 1) {
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

  				//update score with the weight of the clicked button
  				quiz[0]['current_score'] += quiz[question_id]["weights"][clicked_option];
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
		sessionStorage.setItem(local_id, JSON.stringify(quiz));

  		//get id of next question
  		next_question = +question_id+1;
  		
  		//if question doesn't exist load results page
  		if(next_question > quiz[0]['question_count']) {
  			next_question = "last";
  		}

  		window.setTimeout(function() {
  			window.location.href = "default.php?quiz_id="+quiz_id+"&question_id="+next_question;
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

	function generate_id() {
		var now = new Date();
		id = now.getFullYear().toString() + now.getMonth().toString() + now.getDate().toString() + now.getHours().toString() + now.getMinutes().toString() + now.getSeconds().toString() + now.getMilliseconds();
		return id;
	}

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

 		//place holder function for interfacing with server side quiz storage
		var new_quiz = {

			0 : {type : "knowledge" , question_count : 5, title : "An Impossible Logic Quiz", current_score : 0},
			1 : {text : "What is the airspeed velocity of an unladed swallow?", option_count : 5, 1 : "11 m/s" , 2 : "22 m/s" , 3 : "33 m/s" , 4 : "44 m/s" , 5 : "African or European?", weights : {1:1,2:0,3:0,4:0,5:0}},
			2 : {text : "How will you answer this question?", option_count : 3 , 1 : "Correctly" , 2 : "Incorrectly" , 3 : "I don't know.", weights : {1:1,2:1,3:0}},
			3 : {text : "Is this a real question?" , option_count : 2 , 1 : "Yes" , 2 : "No" , weights : {1:1,2:0}},
			4 : {text : "Is this statement false?" , option_count : 2 , 1 : "Yes" , 2 : "No" , weights : {1:0,2:1}},
			5 : {text : "Why?" , option_count : 4, 1 : "Why not?", 2 : "Because." , 3 : "I said so, that's why!", 4 : "Shutup.", weights : {1:0,2:0,3:0,4:1}}
		};


		return new_quiz;
 	} 	


  	</script>

  </body>
</html>

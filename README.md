# quiz

## To Do
- Create an Nginx Path so we can have pretty URLs http://localhost:8080/what-personality-are-you/
- Parse off the "/what-personality-are-you/" (window.location.pathname)
- Homepage with multiple quizzes
- Ability to add image to quiz (Featured image)





## Way later
- We are going to need a stupid API (Php!!  Yay!) (I will help with this what actually serves the quiz data)
- // Redis SET quiz:what-personality-are-you {QuizObject}
- // Redis GET quiz:what-personality-are-you // If it doesn't exist, throw a 404!
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
        #projects .button {
    background-color:burlywood; /* Green */
    border: none;
    padding: 25px 45px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 5px 3px;
    transition-duration: 0.4s;
    cursor: pointer;
    
  }
 #projects .button1 {
    color: black;
    border: 2px solid black;
    border-radius: 12px;
    width: 200px;
    padding: 10px;
    margin-left:5px;
  }
  
#projects .button1:hover {
    background-color: #f4e7e38e;
    color: rgb(19, 14, 14);
  }
    </style>
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <section id="projects">
         <div class="all-projects">
        
          <button class="button button1" onclick="myFunction()">GO TO WEBSITE</button>
    <script>
function myFunction() {
location.replace("http://localhost:8080/miniproject/front_page/index.html")
}
</script>
</div>
</section>
    </p>
</body>
</html>





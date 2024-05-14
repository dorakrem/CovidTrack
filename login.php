<?php   
 
 // Starting the session, necessary
 // for using session variables
 session_start();
   
 // Declaring and hoisting the variables
 $username = "";
 $email    = "";
 $errors = array();
 $_SESSION['success'] = "";
   
 // DBMS connection code -> hostname,
 // username, password, database name
 $db = mysqli_connect('localhost', 'root', '', 'covidtrack',3310);

 // User login
 if (isset($_POST['login_user'])) {
      
     // Data sanitization to prevent SQL injection
     $username = mysqli_real_escape_string($db, $_POST['username']);
     $password = mysqli_real_escape_string($db, $_POST['password']);
   
     // Error message if the input field is left blank
     if (empty($username)) {
         array_push($errors, "Username is required");
     }
     if (empty($password)) {
         array_push($errors, "Password is required");
     }
   
     // Checking for the errors
     if (count($errors) == 0) {
          
         // Password matching
         #$password = md5($password);
          
         $query = "SELECT * FROM user WHERE username=
                 '$username' AND password='$password'";
         $results = mysqli_query($db, $query);
        
         $query1 = "SELECT * FROM admin WHERE username='$username'
         AND password='$password'";
         $results1= mysqli_query($db,$query1);

         // $results = 1 means that one user with the
         // entered username exists
         if (mysqli_num_rows($results) == 1) {
              
             // Storing username in session variable
             $_SESSION['username'] = $username;
              
             // Welcome message
             $_SESSION['success'] = "You have logged in!";
              
             // Page on which the user is sent
             // to after logging in
             header('location: map.php');
         }
         elseif(mysqli_num_rows($results1) == 1) {
             // Storing username in session variable
             $_SESSION['username'] = $username;
              
             // Welcome message
             $_SESSION['success'] = "You have logged in!";
              
             // Page on which the user is sent
             // to after logging in
             header('location: adminpage.php');

         }
         else {
              
             // If the username and password doesn't match
             array_push($errors, "Username or password incorrect");
         }
     }
 }
   
 ?>
<!DOCTYPE html>
<html>
<head>
    <title>CovidTrack | Log In</title>
    <link rel="icon" href="pandemic.ico" type="image/ico">

    <link rel="stylesheet" type="text/css"
            href="style.css">
</head>
<body>
    <div class="header">
        <h2>Login</h2>
    </div>
      
    <form method="post" action="login.php">
  
        <?php include('errors.php'); ?>
  
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" >
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password">
        </div>
        <div class="input-group">
            <button type="submit" class="btn"
                        name="login_user">
                Log In
            </button>
        </div>
         
 
 
<p>
            Don't have an account? 
            <a href="register.php">
                Click here to sign up
            </a>
        </p>
 
 
 
    </form>
</body>
 
</html>
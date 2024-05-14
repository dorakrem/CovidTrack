
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
   
 // Registration code
 if (isset($_POST['reg_user'])) {
   
     // Receiving the values entered and storing
     // in the variables
     // Data sanitization is done to prevent
     // SQL injections
     $username = mysqli_real_escape_string($db, $_POST['username']);
     $email = mysqli_real_escape_string($db, $_POST['email']);
     $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
     $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
   
     // Ensuring that the user has not left any input field blank
     // error messages will be displayed for every blank input
     if (empty($username)) { array_push($errors, "Username is required"); }
     if (empty($email)) { array_push($errors, "Email is required"); }
     if (empty($password_1)) { array_push($errors, "Password is required"); }
   
     if ($password_1 != $password_2) {
         array_push($errors, "Passwords do not match");
         // Checking if the passwords match
     }
     $query2 = "SELECT * FROM user WHERE username='$username'";
     $query3 = "SELECT * FROM user WHERE email='$email'";
     
     $res2 = mysqli_query($db,$query2);
     $res3 = mysqli_query($db,$query3);
     
     if(mysqli_num_rows($res2) >0 ){
        array_push($errors, "Username is already taken");
     }
     elseif(mysqli_num_rows($res3) >0 ){
        array_push($errors, "Email is already taken");
     }
     // If the form is error free, then register the user
     if (count($errors) == 0) {
          
         // Password encryption to increase data security
         #$password = md5($password_1);
          
         // Inserting data into table
         $query = "INSERT INTO user (username, password, email )
                   VALUES('$username','$password_2','$email')";
          
         mysqli_query($db, $query);
   
         // Storing username of the logged in user,
         // in the session variable
         $_SESSION['username'] = $username;
          
         // Welcome message
         $_SESSION['success'] = "You have logged in";
          
         // Page on which the user will be
         // redirected after logging in
         header("Location: map.php");
     }
 } 
 ?>
<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="pandemic.ico" type="image/ico">
    <title>CovidTrack | Create Account</title>
    <link rel="stylesheet" type="text/css"
                    href="style.css">
</head>
 
<body>
    <div class="header">
        <h2>Create Account</h2>
    </div>
      
    <form method="post" action="register.php">
  
        <?php include('errors.php'); ?>
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username"
                value="<?php echo $username; ?>">
        </div>
        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email"
                value="<?php echo $email; ?>">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password_1" pattern= "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" title=" Password must contain at least one number, one special character, one uppercase letter and must be at least 8 characters long.">
        </div>
        <div class="input-group">
            <label>Confirm password</label>
            <input type="password" name="password_2">
        </div>
        <div class="input-group">
            <button type="submit" class="btn"
                                name="reg_user">
                Sign Up
            </button>
        </div>
         
 
 
<p>
            Already have an account?
            <a href="login.php">
                Log in
            </a>
        </p>
 
 
 
    </form>
</body>
</html>
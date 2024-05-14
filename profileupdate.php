<?php
session_start();
error_reporting(E_ALL ^ E_WARNING);;
?>
<?php
  $username = "";
  $email    = "";
  $errors = array();
  $_SESSION['success'] = "";
    
  // DBMS connection code -> hostname,
  // username, password, database name
  $db = mysqli_connect('localhost', 'root', '', 'covidtrack',3310);
    

    $username = $_SESSION["username"];

      $sql = "SELECT * FROM user WHERE username='$username'";
      $result = mysqli_query($db,$sql);
      if( mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
      }
    

?>

<!-- HTML Code --> 
<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="pandemic.ico" type="image/ico">
	<title>CovidTrack | Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="styleupdateprof.css">
    <!-- Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
  <div class="container">
  <form method="POST">
    
      <h4 class="display-5 text-center">Edit Profile</h4>
      <br>
      <?php if (isset($_GET['error'])){ ?>
        <div class="alert alert-danger" role="alert">
        <?php echo $_GET['error']; ?>
        </div>
		    <?php } ?>
        <?php if (isset($_GET['success'])){ ?>
        <div class="alert alert-success" role="alert">
        <?php echo $_GET['success']; ?>
        </div>
		    <?php } ?>
        
        
      
      <br>
      <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" id="disabledInput" type="text" name="username1" value='<?=$row['username']?>' >
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="text" class="form-control" id="password" name="password" value='<?=$row['password']?>'>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="text" class="form-control" id="email" name="email" value='<?=$row['email']?>'>
      </div>
      <br>
      <button type="submit" class="btn" name="update">Update</button>
      <a href="editprofile.php" class="btn btn-danger " role="button">Back</a>
  </form>
   <!-- Database Connection and Query -->
   <?php
 $db = mysqli_connect('localhost', 'root', '', 'covidtrack',3310);

    
     if(isset($_POST['update'])){

        $username = $_SESSION["username"];
        $username1 = $_POST[ 'username1'];
        $password = $_POST[ 'password'];
        $email = $_POST[ 'email'];

      // echo $userdate;
      if(empty($username1) && empty($password) && empty($email)){
        header("Location: profileupdate.php?error=Username, password and email cannot be blank.");}
        elseif(empty($username1)){
        header("Location: profileupdate.php?error=Username cannot be blank.");}
      else if(empty($password)){
        header("Location: profileupdate.php?error=Password cannot be blank.");
      }else if(empty($email)){
        header("Location: profileupdate.php?error=Email cannot be blank.");
      }else{
        $sql = "UPDATE user SET  username='$username', password ='$password', email='$email' WHERE username='$username'";
        $result = mysqli_query($db,$sql);
        if($result){
          header("Location: profileupdate.php?success=User profile updated successfully.");
        }
      }
    }
    
    ?>
  </div>
      
  


    
</body>
</html>

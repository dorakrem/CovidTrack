<?php
 
 session_start();
 $username = "";
 $email    = "";
 $errors = array();
 $_SESSION['success'] = "";
   
 // DBMS connection code -> hostname,
 // username, password, database name
 $db = mysqli_connect('localhost', 'root', '', 'covidtrack',3310);
 if (isset($_POST['editprofile'])) {

    $username=$_SESSION['username'];
    echo $_SESSION['username'];
    $username=$_POST['username'];
    
    $password=$_POST['password'];
    $email=$_POST['email'];
    $select= "select * from user where username='$username'";
    $sql = mysqli_query($db,$select);
    $row = mysqli_fetch_assoc($sql);
    $res= $row['username'];
    if($res === $username)
    {
   
       $update = "update user set username='$username',password='$password',email='$email' where username='$username'";
       $sql2=mysqli_query($db,$update);
if($sql2)
       { 
           /*Successful*/
           echo "Your profile has been updated succesfully.";
           header('location:map.php');
       }
       else
       {
           /*sorry your profile is not update*/
           header('location:editprofile.php');
       }
    }
    else
    {
        /*sorry your id is not match*/
        header('location:editprofile.php');
      } 
 }
?>

<!-- HTML Code --> 
<!DOCTYPE html>
<html>
<head>
	<title>CovidTrack | Profile
  </title>
    <!-- Responsive -->
    <link rel="icon" href="pandemic.ico" type="image/ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>
<body>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'>
<link rel="stylesheet" type="text/css"
            href="profilestyle.css">
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="ajax-script2.js"></script> 
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="ajax-script1.js"></script>
<div class="topnav">
        <a href="map.php" ><i class="fa fa-globe"></i>  User's Live Location</a>
        <a href="testaddcase.php"><i class="fas fa-virus"></i>  Covid Case</a>
        <a href="covidcontact.php"><i class="fas fa-users"></i>  Possible Covid Contact</a>
        <a class="active"><i class="fas fa-user-circle"></i> Profile</a>
        <a href="index.php?logout='1'" style="color: red;"><i class="fa fa-sign-out"></i> Logout </a>
        
      </div>
      <style>
        /* Add a black background color to the top navigation bar */
    .topnav {
    overflow: hidden;
    background-color: #e9e9e9;
    width:100%;
    }

    /* Style the links inside the navigation bar */
    .topnav a {
    float: left;
    display: block;
    color: black;
    text-align: center;
    padding: 10px 16px;
    text-decoration: none;
    font-size: 17px;
    font-family: "Times New Roman", Times, serif;
    }

    /* Change the color of links on hover */
    .topnav a:hover {
    background-color: #ddd;
    color: black;
    }

    /* Style the "active" element to highlight the current page */
    .topnav a.active {
    background-color: #2196F3;
    color: white;
    }

    /* Style the search box inside the navigation bar */
    .topnav input[type=text] {
    float: right;
    padding: 6px;
    border: none;
    margin-top: 8px;
    margin-right: 16px;
    font-size: 17px;
    }

    /* When the screen is less than 600px wide, stack the links and the search field vertically instead of horizontally */
    @media screen and (max-width: 600px) {
    .topnav a, .topnav input[type=text] {
        float: none;
        display: block;
        text-align: left;
        width: 100%;
        margin: 0;
        padding: 14px;
    }
    .topnav input[type=text] {
        border: 1px solid #ccc;
    }
    }
    </style>
  <div class="container">
            <?php

        $username = $_SESSION["username"];
        $sql = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($db,$sql);
       
    
    ?>

    <div class='box'>
      <h4 class="display-5 text-center">User Profile</h4>
      <br>
      <?php if (mysqli_num_rows($result)) {
      ?>
      <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Usename</th>
              <th scope="col">Password</th>
              <th scope="col">Email</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
             $i=0;
              while($rows = mysqli_fetch_assoc($result)){
              $i++;
            ?>
            <tr>
              <td><?=$rows['username']?></td>
              <td><?=$rows['password']?></td>
              <td><?=$rows['email']?></td>
              <td><a href='profileupdate.php?id=<?=$rows['username']?>'
                  class="btn" style="width:100px;height:35px;">Edit</button></td>
            </tr>
            <?php } ?>
          </tbody>
      </table>
      <?php } ?>
  </div>

<br>
<br>

        <button button class="btn" id="showvisits" style="width:150px;height:45px;">View your visits</button>
        <div class='box'>
      <h4 class="display-5 text-center">Visits</h4>
      <br>
            <table class="table">
          <thead class="thead-dark">
                <tr>  
            
                <th scope="col">Username</th>
              <th scope="col">Point Of Interest ID</th>
              <th scope="col">Point Of Interest Name</th>
              <th scope="col">Date and Time Of Visit</th>
                </tr>
                <tbody id="data1">

                </tbody>
                </thead>
            </table>
            </div>
        <br>
        <br> 

      <button class="btn" id="showcases" style="width:200px;height:45px;">View your Covid cases</button>
    <div class='box'>
      <h4 class="display-5 text-center">Covid cases </h4>
      <br>
            <table class="table">
          <thead class="thead-dark">
                <tr>  
            
                <th scope="col">Username</th>
              <th scope="col">Date and Time of Diagnosis</th>
                </tr>
                <tbody id="data2">

                </tbody>
                </thead>
            </table>
            </div>
  <br>
  <br>
  <br>
  </div>

</body>
</html>
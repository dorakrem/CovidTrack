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
 $recentdate = "";

 if (isset($_POST['addcase'])) {
    $username = $username = $_SESSION["username"];
    $timeofdiagnosis = mysqli_real_escape_string($db, $_POST['timeofdiagnosis']);
    
    $myquery = "SELECT MAX(timeofdiagnosis) AS recentdate FROM covidcase 
    WHERE username= '$username' ";

    $result = mysqli_query($db, $myquery);
    $i=0;
    while($rows = mysqli_fetch_assoc($result)){
        $i++;
        $recentdate= $rows['recentdate'];
    }
  #  echo $recentdate;
    $date_for_database = date ('Y-m-d H:i:s', strtotime($timeofdiagnosis));
 #   echo $date_for_database;
    $date1=date('Y-m-d H:i:s', strtotime($recentdate. ' - 14 days'));
  #  echo $date1;
    $date2=date('Y-m-d H:i:s', strtotime($recentdate. ' + 14 days'));
   # echo $date2;
   
   
   if($date_for_database=='1970-01-01 01:00:00'){
        array_push($errors, "Date is required");

    }
    elseif($recentdate=="")
    {
         $query = "INSERT INTO covidcase (username, timeofdiagnosis)
                        VALUES('$username','$date_for_database')";
                    
             $res = mysqli_query($db, $query);
             if($res)
             {
                header("Location: testaddcase.php?success=Covid case added successfully.");
                 }
        
    }
    else if($date_for_database < $date1){
        array_push($errors, "Date is not over 14 days before covid inflection!");
    }else if($date_for_database < $date2){
        array_push($errors, "Date is not over 14 days after covid inflection!");
    }
    else{
    $query = "INSERT INTO covidcase (username, timeofdiagnosis)
                    VALUES('$username','$date_for_database')";
            
            $res = mysqli_query($db, $query);
            if($res)
            {
                header("Location: testaddcase.php?success=Covid case added successfully.");
            }

        }
 }
 ?>
<!DOCTYPE html>
<html>
<head>
    <title>CovidTrack | Add Case</title>
     
    <link rel="stylesheet" type="text/css"
            href="stylecase.css">
            <link rel="icon" href="pandemic.ico" type="image/ico">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>
<body>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'>
<div class="topnav">
        <a href="map.php" ><i class="fa fa-globe"></i>  User's Live Location</a>
        <a class="active"><i class="fas fa-virus"></i>  Covid Case</a>
        <a href="covidcontact.php"><i class="fas fa-users"></i>  Possible Covid Contact</a>
        <a href="editprofile.php"><i class="fas fa-user-circle"></i> Profile</a>
        <a href="index.php?logout='1'" style="color: red;"><i class="fa fa-sign-out"></i> Logout </a>
        
      </div>
      <style>
        /* Add a black background color to the top navigation bar */
    .topnav {
    overflow: hidden;
    background-color: #e9e9e9;
    width:100%;
    top: 0;
    position:absolute;
    left: 0;
    }

    /* Style the links inside the navigation bar */
    .topnav a {
    float: left;
    display: block;
    color: black;
    text-align: center;
    padding: 14px 16px;
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

    <div class="header">
        <h2>Add a new Covid case</h2>
    </div>
      
    <form method="post" action="testaddcase.php">
     <?php include('errors.php'); ?>
        <div class="input-group">
            <label>Date of diagnosis</label>
            <input type="datetime-local" name="timeofdiagnosis">
               
        </div>
        <div class="input-group">
            <button type="submit" class="btn"
                        name="addcase">
                Add case
            </button>
        </div>
 
 
        <?php if (isset($_GET['success'])){ ?>
        <div class="alert alert-success" role="alert">
        <?php echo $_GET['success']; ?>
        </div>
		    <?php } ?>
        
    </form>
      
</body>
 
</html>

        <?php
session_start();
error_reporting(E_ALL ^ E_WARNING);;
?>

<!-- HTML Code --> 
<!DOCTYPE html>
<html>
<head>
<title>CovidTrack | Possible Contact</title>
  <link rel="stylesheet" type="text/css"
            href="stylecontact.css">
    <!-- Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->      
    <link rel="icon" href="pandemic.ico" type="image/ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="ajax-script.js"></script>
        <div class="topnav">
        <a href="map.php" ><i class="fa fa-globe"></i>  User's Live Location</a>
        <a href="testaddcase.php"><i class="fas fa-virus"></i>  Covid Case</a>
        <a class="active"><i class="fas fa-users"></i>  Possible Covid Contact</a>
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
    padding: 10.5px 16px;
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
              </br>
</br>
</br>
    <button class="btn"id="showData"style="width:200px;height:45px;">View Possible Contacts</button>
    <div class="header">
    </div>
    <div class='box'>
      <h4 class="display-5 text-center">Possible Contact with Positive Covid Cases </h4>
      <br>
            <table class="table">
          <thead class="thead-dark">
                <tr>  
            
                <th scope="col">POI id</th>
              <th scope="col">POI name</th>
              <th scope="col">Date and time of visit</th>
                </tr>
                <tbody id="data">

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
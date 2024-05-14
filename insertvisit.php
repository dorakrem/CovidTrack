
<?php
session_start();
error_reporting(E_ALL ^ E_WARNING);;
$errors = array();
?>
<?php
   // Database Settings
   $db = mysqli_connect('localhost', 'root', '', 'covidtrack',3310);
  
   $username = $_SESSION["username"];
   $id=$_GET['id'];
   if(isset($_GET['id'])){

    $sql1 = "SELECT * FROM pointofinterest WHERE id='$id'";
    $result = mysqli_query($db,$sql1);
    if( mysqli_num_rows($result)>0){
      $row = mysqli_fetch_assoc($result);
    }
  

      $sql = "SELECT name AS poiname FROM pointofinterest WHERE id='$id'";
    
      $result = mysqli_query($db, $sql);
      $i=0;
      while($rows = mysqli_fetch_assoc($result)){
          $i++;
          $poiname= $rows['poiname'];
      
    }
  
}
?>

<!-- HTML Code --> 
<!DOCTYPE html>
<html>
<head>
	<title>CovidTrack | Insert Visit</title>
    <link rel="icon" href="pandemic.ico" type="image/ico">
    <link rel="stylesheet" type="text/css" href="stylevisit.css">
    <!-- Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

<div class="header">
        <h4 class="display-5 text-center">Insert a Visit</h4>
       
    </div>
    
  <form method="POST" action="insertvisit.php">
 
  <?php if (isset($_GET['success'])){ ?>
        <div class="alert alert-success" role="alert">
        <?php echo $_GET['success']; ?>
        </div>
		    <?php } ?>
        
        
      
        <?php if (isset($_GET['error'])){ ?>
        <div class="alert alert-error" role="alert">
        <?php echo $_GET['error']; ?>
        </div>
		    <?php } ?>

      <br>
      <div class="form-group">
     
        <label>Username:</label>
        <input class="form-control" id="disabledInput" type="text" value='<?=$username?>' disabled>
      </div>
      <label>POI Name:</label>
        <input type="text" class="form-control" id="disabledInput" name='poi' value='<?=$poiname?>'disabled>
      </div>
      <br>
        <label>Confirm the POI's name:</label>
        <input type="text" class="form-control" name='poiconfirmname'>
      </div>
      <br>
      <button type="submit"  class="btn" name="addvisit">Add Visit</button>
      <a href="map.php" class="btn btn-danger " role="button">Back to Map</a>

     

  </form>
  <?php
   // Database Settings
   $db = mysqli_connect('localhost', 'root', '', 'covidtrack',3310);
  
  if(isset($_POST['addvisit'])){
  
    $poiconfirmname = mysqli_real_escape_string($db, $_POST['poiconfirmname']);

    if (empty($poiconfirmname)) { 
     header("Location: insertvisit.php?error=Please confirm POI name to insert the visit."); }
 
     else{
 
     
 
     $query="SELECT id AS poi_id FROM pointofinterest WHERE name='$poiconfirmname'";
     
     $result = mysqli_query($db, $query);
     $i=0;
     while($rows = mysqli_fetch_assoc($result)){
         $i++;
         $poiid= $rows['poi_id'];
     }
 
 
     $sql = "INSERT INTO visit (username,poi,timeofvisit) VALUES ('$username','$poiid',CURRENT_TIMESTAMP())";
     $result = mysqli_query($db,$sql);
     header("Location: insertvisit.php?success=Visit added successfully.");
 }
 
     }
     

    ?>

    
</body>
</html>

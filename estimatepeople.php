
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
	<title>CovidTrack | Estimate Popularity</title>
    <link rel="icon" href="pandemic.ico" type="image/ico">
    <link rel="stylesheet" type="text/css" href="stylevisit.css">
    <!-- Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

<div class="header">
        <h4 class="display-5 text-center">Estimate popularity in POI</h4>
       
    </div>
    
  <form method="POST" action="estimatepeople.php">
 
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
        <label>Estimate number of people in this POI:</label>
        <input type="text" class="form-control" name='popestimation'>
      </div>
      <br>
      <button type="submit"  class="btn" name="addestimation">Add your Estimation</button>
      <a href="map.php" class="btn btn-danger " role="button">Back to Map</a>

     

  </form>
  <?php
   // Database Settings
   $db = mysqli_connect('localhost', 'root', '', 'covidtrack',3310);
 // echo $poiname;
  if(isset($_POST['addestimation'])){
    echo $poiname;
    $popestimation = (int) $_POST['popestimation'];
    $poiconfirmname = mysqli_real_escape_string($db, $_POST['poiconfirmname']);

    if (empty($popestimation)) { 
     header("Location: estimatepeople.php?error=Popularity estimation is required."); }
 
     else{
        $sql1 = "SELECT id AS poiid FROM pointofinterest WHERE name='$poiconfirmname'";
    
        $result = mysqli_query($db, $sql1);
        $i=0;
        while($rows = mysqli_fetch_assoc($result)){
            $i++;
            $poiid= $rows['poiid'];
        
      }
      $query4="SELECT * FROM visit WHERE poi= '$poiid' and username ='$username'";
      
     $result4 = mysqli_query($db, $query4);
     if (mysqli_num_rows($result4) == 0) {
      header("Location: estimatepeople.php?error=You need to visit this POI in order to add popularity estimation."); }
      else{
     $query="UPDATE visit SET  estimatedvisitors= '$popestimation' WHERE poi= '$poiid' and username ='$username'";
     
     $result = mysqli_query($db, $query);


          //get the average value of users estimation and insert into current_popularity field of table pointofinterest 
          $query2=" SELECT AVG(T.estimatedvisitors) as avgpopularity FROM (SELECT DISTINCT estimatedvisitors, username FROM visit WHERE poi='$poiid') as T";
         
          $result2 = mysqli_query($db, $query2);
          
            
            
          $i=0;
          while($rows = mysqli_fetch_assoc($result2)){
              $i++;
              $avgpopularity= $rows['avgpopularity'];
          
        }
        $avg_popularity = (int)  $avgpopularity;
     
        $query3="UPDATE pointofinterest SET  current_popularity= '$avg_popularity' WHERE name= '$poiconfirmname'";
        $result3 = mysqli_query($db, $query3);
     header("Location: estimatepeople.php?success=Popularity estimation added succesfully.");
      }
     


 }
 
     }
     

    ?>

    
</body>
</html>

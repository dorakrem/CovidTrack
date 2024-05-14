<?php
// connect to db

session_start();
error_reporting(E_ALL ^ E_WARNING);;
$db = mysqli_connect('localhost', 'root', '', 'covidtrack',3310);
$username = $_SESSION["username"];
//$results = $db->query("SELECT * FROM visit WHERE username='$username'");
$sql = "SELECT * FROM visit WHERE username = '$username' GROUP BY timeofvisit DESC";
$result = mysqli_query($db,$sql);
$i=0;
if (mysqli_num_rows($result) > 0) {

    while ($data = $result->fetch_assoc()): 
     $poi = $data['poi'];
     
  $sql3 = "SELECT name FROM pointofinterest WHERE id = '$poi'";
  $result3 = mysqli_query($db,$sql3);
  if (mysqli_num_rows($result3)) {
    $rowss = mysqli_fetch_assoc($result3);}
    ?>
     
        <tr>
            <td><?php echo $data['username'] ?></td>
            <td><?php echo $data['poi'] ?></td>
            <td><?php echo $rowss['name'] ?></td>
            <td><?php echo $data['timeofvisit'] ?></td>
        </tr>
        <?php endwhile; }
    else{
        echo 'There are not any visits.';
     }?>
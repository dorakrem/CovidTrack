<?php
// connect to db
session_start();
error_reporting(E_ALL ^ E_WARNING);;
$db = mysqli_connect('localhost', 'root', '', 'covidtrack',3310);


$username = $_SESSION["username"];
$sql = "SELECT pointofinterest.id,pointofinterest.name, visit.timeofvisit
FROM visit 
INNER JOIN pointofinterest ON visit.poi=pointofinterest.id
INNER JOIN covidcase ON visit.timeofvisit >= covidcase.timeofdiagnosis 
WHERE DATEDIFF((covidcase.timeofdiagnosis), (visit.timeofvisit)) <= 7 AND visit.username='$username' AND visit.username <> covidcase.username AND covidcase.username 
IN (select visit.username FROM visit WHERE visit.poi = pointofinterest.id)"  ;

$results = mysqli_query($db,$sql);
if (mysqli_num_rows($results) > 0) {
while ($data = $results->fetch_assoc()): ?>

    <tr>
        <td><?php echo $data['id'] ?></td>
        <td><?php echo $data['name'] ?></td>
        <td><?php echo $data['timeofvisit'] ?></td>
    </tr>
<?php endwhile; 
}
else{
    echo 'There are not any prossible covid contacts.';
 }?>
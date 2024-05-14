<?php

// connect to db
session_start();
error_reporting(E_ALL ^ E_WARNING);;
$db = mysqli_connect('localhost', 'root', '', 'covidtrack',3310);
$username = $_SESSION["username"];

$results = $db->query("SELECT * FROM covidcase WHERE username='$username'");


if (mysqli_num_rows($results) > 0) {
while ($data = $results->fetch_assoc()): ?>

    <tr>
        <td><?php echo $data['username'] ?></td>
        <td><?php echo $data['timeofdiagnosis'] ?></td>
    </tr>
<?php endwhile; 
}
else{
    echo 'There are not any covid cases.';
 }?>
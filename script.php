<?php

 session_start();
$db = mysqli_connect('localhost', 'root', '', 'covidtrack',3310);
//start mysql connection

$i = 1; //counter
$n = 5; //number of users to make

while ($i <= $n){

$user = "User";
$user .= $i;


$password =  "User";
$password .= $i;
$password .= "!pass";

$email = "user";
$email .= $i;
$email .= "@gmail.com";

//make queries
$query1 = "INSERT INTO user (username,password,email) VALUES ('$user','$password','$email')";

//enter to database
$res1 = mysqli_query($db,$query1);
$i++;
};

?>
<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    echo  $id;

    // Connecto to DB
    require('db_connect.php');
    
    $sql = "DELETE FROM pointofinterest WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location:adminDelete.php?success=POI successfully deleted");
        exit();
    } else {
        header("Location:adminDelete.php?error=unknown error occurred");
    }
} else {
    header("Location:adminDelete.php");
}

?>
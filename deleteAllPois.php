<?php
    // Connecto to DB
    require('db_connect.php');
    
    $sql = "DELETE FROM pointofinterest";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location:adminDelete.php?success=All POIs successfully deleted");
        exit();
    } else {
        header("Location:adminDelete.php?error=unknown error occurred");
    }
?>
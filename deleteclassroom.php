<?php

include 'connection.php';
$id = $_GET['name'];
$q = mysqli_query(
    $con,
    "DELETE FROM classrooms WHERE name = '$id' "
);
if ($q) {

    header("Location:addclassrooms.php");
} else {
    echo 'Error';
}

<?php

include 'connection.php';
$id = $_GET['name'];
$q = mysqli_query(
    $con,
    "DELETE FROM subjects WHERE subject_code = '$id' "
);
if ($q) {

    header("Location:addsubjects.php");
} else {
    echo 'Error';
}

<?php
if (isset($_POST['admin_login'])) {
    if (isset($_POST['UN']) && isset($_POST['PASS'])) {
        $id = $_POST['UN'];
        $password = $_POST['PASS'];
    } else {
        die();
    }
    $q = mysqli_query($con, "SELECT name FROM admin WHERE name = '$id' and password = '$password' ");
    if (mysqli_num_rows($q) == 1) {
        header("Location:addteachers.php");
    } else {
        $message = "Username and/or Password incorrect.\\nTry again.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
if (isset($_POST['faculty_login'])) {
    session_start();
    if (isset($_POST['FN'])) {
        $fac = $_POST['FN'];
    } else {
        die();
    }
    $q = mysqli_query($con, "SELECT name FROM teachers WHERE faculty_number = '$fac'");
    if (mysqli_num_rows($q) == 1) {
        $row = mysqli_fetch_assoc($q);
        $_SESSION['loggedin_name'] = $row['name'];
        $_SESSION['loggedin_id'] = $fac;
        header("Location:facultypage.php");
    } else {
        $message = "Username incorrect.\\nTry again.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
    if (mysqli_num_rows($q) == 1) {
        $row = mysqli_fetch_assoc($q);
        echo 'welcome ' . $row['name'];
    } else {
        $message = "Invalid Faculty Number.\\nTry again.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}

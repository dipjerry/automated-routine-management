<?php
require("./connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $methods = $_POST['method'];
    $tab = 'Teachers_list';
    if ($methods == "load") {
        load($con);
    } elseif ($methods == "remove") {
        remove($_POST['id'], $con);
    } elseif ($methods == "add") {
        add($_POST['name'], $con);
    }
}
function load($conn)
{
    $sql = "SELECT * FROM classrooms";
    $result = mysqli_query($conn, $sql) or die("SQL Query Failed.");
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>{$row['name']}</td>
            <td>
            <button Class='delete-btn btn btn-sm btn-danger' data-cid='{$row["name"]}'>Delete</button>
        </td>
                    </tr>\n";
        }
        mysqli_close($conn);
        // echo $output;
    } else {
        echo "<h2>No Record Found.</h2>";
    }
}
function remove($name, $conn)
{
    $sql = "DELETE FROM classrooms WHERE name = '$name' ";
    if (mysqli_query($conn, $sql)) {
        echo 1;
    } else {
        echo 0;
    }
}
function add($name, $conn)
{
    $sql = "INSERT INTO classrooms VALUES ('$name',0)";
    if (mysqli_query($conn, $sql)) {
        echo 1;
    } else {
        echo 0;
    }
}

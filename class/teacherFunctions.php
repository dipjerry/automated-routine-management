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
        add($_POST['id'], $con);
    }
}
function load($conn)
{
    $sql = "SELECT * FROM teachers ORDER BY faculty_number ASC";
    $result = mysqli_query($conn, $sql) or die("SQL Query Failed.");
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
            <tr><td>{$row['faculty_number']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['alias']}</td>
                    <td>{$row['designation']}</td>
                    <td>{$row['contact_number']}</td>
                    <td>{$row['emailid']}</td>
                   <td>
                   <button Class='delete-btn btn btn-sm btn-danger' data-tid='{$row["faculty_number"]}'>Delete</button>
                   </td>
                    </tr>\n";
        }
        mysqli_close($conn);
        // echo $output;
    } else {
        echo "<h2>No Record Found.</h2>";
    }
}
function remove($student_id, $conn)
{
    $sql = "DELETE FROM `teachers` WHERE faculty_number = '$student_id'";
    if (mysqli_query($conn, $sql)) {
        echo 1;
    } else {
        echo 0;
    }
}
function add($student_id, $conn)
{
    $sql = "DELETE FROM `teachers` WHERE faculty_number = '$student_id'";
    if (mysqli_query($conn, $sql)) {
        echo 1;
    } else {
        echo 0;
    }
}

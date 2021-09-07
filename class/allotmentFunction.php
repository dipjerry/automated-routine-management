<?php
require("./connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $methods = $_POST['method'];
    if ($methods == "load_classroom") {
        load_classroom($con);
    } elseif ($methods == "remove_classroom") {
        remove_classroom($_POST['id'], $con);
    } elseif ($methods == "load_theory") {
        load_theory($con);
    } elseif ($methods == "remove_theory") {
        remove_theory($_POST['id'], $con);
    } elseif ($methods == "load_practical") {
        load_practical($con);
    } elseif ($methods == "remove_practical") {
        remove_practical($_POST['id'], $con);
    }
}
function load_classroom($conn)
{
    $result = mysqli_query(
        $conn,
        "SELECT * FROM classrooms "
    );
    $courses = array('2nd Year', '3rd Year');
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['status'] == 0)
                continue;
            echo "<tr><td>{$row['name']}</td>
            <td>{$courses[$row['status'] - 2]}</td>
        <td><button Class='delete-btn btn btn-sm btn-danger' data-cid='{$row["name"]}'>Delete</button></td>
            </tr>\n";
        }
        mysqli_close($conn);
        // echo $output;
    } else {
        echo "<h2>No Record Found.</h2>";
    }
}
function remove_classroom($name, $conn)
{
    $sql = "UPDATE classrooms  SET status = '0' WHERE name = '$name'";
    // $sql = "DELETE FROM classrooms WHERE name = '$name'";
    if (mysqli_query($conn, $sql)) {
        echo 1;
    } else {
        echo 0;
    }
}
function load_theory($conn)
{
    $sql = "SELECT * FROM subjects  ORDER BY semester ASC";
    $result = mysqli_query($conn, $sql) or die("SQL Query Failed.");
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['isAlloted'] == 0 || $row['course_type'] == 'LAB')
                continue;
            $teacher_id = $row['allotedto'];
            $t = mysqli_query(
                $conn,
                "SELECT name FROM teachers WHERE faculty_number = '$teacher_id'"
            );
            $trow = mysqli_fetch_assoc($t);
            echo "<tr>
                <td>{$row['semester']}</td>
                <td>{$row['subject_code']}</td>
                <td>{$row['subject_name']}</td>
                <td>{$row['department']}</td>
                <td>{$row['allotedto']}</td>
                <td>{$trow['name']}</td>
               <td>
               <button Class='delete-btn btn btn-sm btn-danger' data-cid='{$row["subject_code"]}'>Delete</button></td>
                </tr>\n";
        }
    } else {
        echo "<h2>No Record Found.</h2>";
    }
}
function remove_theory($id, $conn)
{
    $sql = "UPDATE subjects  SET isAlloted = '0' , allotedto = '',allotedto2 = '',allotedto3 = '' WHERE subject_code = '$id' ";
    if (mysqli_query($conn, $sql)) {
        echo 1;
    } else {
        echo 0;
    }
}
function load_practical($conn)
{
    $result = mysqli_query(
        $conn,
        "SELECT * FROM subjects"
    );
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['isAlloted'] == 0)
                continue;
            if (!($row['course_type'] == "LAB"))
                continue;
            $teacher_id1 = $row['allotedto'];
            $teacher_id2 = $row['allotedto2'];
            $teacher_id3 = $row['allotedto3'];
            $t1 = mysqli_query(
                $conn,
                "SELECT name FROM teachers WHERE faculty_number = '$teacher_id1'"
            );
            $trow1 = mysqli_fetch_assoc($t1);
            $t2 = mysqli_query(
                $conn,
                "SELECT name FROM teachers WHERE faculty_number = '$teacher_id2'"
            );
            $trow2 = mysqli_fetch_assoc($t2);
            $t3 = mysqli_query(
                $conn,
                "SELECT name FROM teachers WHERE faculty_number = '$teacher_id3'"
            );
            $trow3 = mysqli_fetch_assoc($t3);
            echo "<tr><td>{$row['subject_code']}</td>
                <td>{$row['subject_name']}</td>
                <td>{$row['allotedto']}</td>
                <td>{$trow1['name']}</td>
                <td>{$row['allotedto2']}</td>
                <td>{$trow2['name']}</td>
                <td>{$row['allotedto3']}</td>
                <td>{$trow3['name']}</td>
               <td>
               <button Class='delete-btn btn btn-sm btn-danger' data-cid='{$row["subject_code"]}'>Delete</button>
                </tr>\n";
        }
        mysqli_close($conn);
        // echo $output;
    } else {
        echo "<h2>No Record Found.</h2>";
    }
}
function remove_practical($id, $conn)
{
    $sql = "UPDATE subjects  SET isAlloted = '0' , allotedto = '',allotedto2 = '',allotedto3 = '' WHERE subject_code = '$id' ";
    if (mysqli_query($conn, $sql)) {
        echo 1;
    } else {
        echo 0;
    }
}

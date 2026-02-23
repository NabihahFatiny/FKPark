<?php
include '../DB_FKPark/dbcon.php';

if(isset($_GET['id'])) {
    $student_ID = $_GET['id'];
    $query = "SELECT * FROM student WHERE student_ID = '$student_ID'";
    $result = mysqli_query($con, $query);

    if(!$result) {
        die("Query failed: " . mysqli_error($con));
    } else {
        $student = mysqli_fetch_assoc($result);
        echo json_encode($student);
    }
}
mysqli_close($con);
?>

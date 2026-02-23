<?php
ob_start(); // Start output buffering
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>List of Registration</title>
    <style>
        table.center {
            margin-left: auto; 
            margin-right: auto;
            width: 900px;
            margin-top: 70px;
        }
    </style>
</head>
    <body>
    <?php include '../Layout/adminHeader.php'; ?>
    <?php include '../DB_FKPark/dbcon.php'; // Include the database connection file. ?>


    <?php
// Include the database connection
ob_start();
include '../DB_FKPark/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_student_id'])) {
        $student_id_to_delete = $_POST['delete_student_id'];
        
        // Delete the student from the student table
        $deleteQuery = "DELETE FROM student WHERE student_ID = ?";
        $stmt = mysqli_prepare($con, $deleteQuery);
        mysqli_stmt_bind_param($stmt, 'i', $student_id_to_delete);
        $deleteResult = mysqli_stmt_execute($stmt);

        if (!$deleteResult) {
            die("Deletion failed: " . mysqli_error($con));
        } else {
            header('Location: ../ManageRegistration/viewRegistration.php?delete_msg=You deleted the data!');
            exit;
        }
    }
}
?>


    <?php include '../Layout/allUserFooter.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
<?php
ob_end_flush(); // Flush the output buffer and send the output to the browser
?>

<?php
// Include the database connection
ob_start();
include '../DB_FKPark/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_vehicle_numPlate'])) {
        $vehicle_numPlate_to_delete = $_POST['delete_vehicle_numPlate'];
        $student_ID = $_POST['student_ID'];
        
        // Delete the vehicle from the Vehicle table
        $deleteQuery = "DELETE FROM Vehicle WHERE vehicle_numPlate = ? AND student_ID = ?";
        $stmt = mysqli_prepare($con, $deleteQuery);
        mysqli_stmt_bind_param($stmt, 'si', $vehicle_numPlate_to_delete, $student_ID);
        $deleteResult = mysqli_stmt_execute($stmt);

        if (!$deleteResult) {
            die("Deletion failed: " . mysqli_error($con));
        } else {
            header('Location: ../ManageRegistration/VehicleApproval.php?message=Vehicle has been deleted successfully');
            exit;
        }
    }
}
?>

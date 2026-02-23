<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: ../Manage Login/login.html");
    exit;
}

$studentID = $_SESSION['userID'];

if (!isset($_GET['bookingID'])) {
    echo "No booking ID provided.";
    exit;
}

$bookingID = $_GET['bookingID'];

$con = mysqli_connect("localhost", "root", "", "fkpark");
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

// Step 1: Delete inbox messages related to this booking
$deleteInboxQuery = "DELETE FROM inbox WHERE booking_ID = ?";
$deleteInboxStmt = mysqli_prepare($con, $deleteInboxQuery);
mysqli_stmt_bind_param($deleteInboxStmt, 'i', $bookingID);
mysqli_stmt_execute($deleteInboxStmt);

// Step 2: Delete the booking itself
$query = "DELETE FROM booking WHERE booking_ID = ? AND student_ID = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'ii', $bookingID, $studentID);

if (mysqli_stmt_execute($stmt)) {
    header('Location: viewBooking.php');
    exit;
} else {
    echo "Error cancelling the booking: " . mysqli_error($con);
}

mysqli_close($con);
?>

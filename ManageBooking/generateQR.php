<?php
    session_start();

    if (!isset($_GET['bookingID'])) {
        die('Booking ID is required');
    }

    $bookingID = $_GET['bookingID'];
    $userID = $_SESSION['userID']; // Assuming the user ID is stored in the session

    // Connect to the database
    $con = mysqli_connect("localhost", "root", "", "fkpark");
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    // Retrieve the booking information
    $query = "SELECT booking_ID, parkingSlot_name, booking_date, booking_startTime, booking_endTime 
            FROM booking 
            JOIN parkingSlot ON booking.parkingSlot_ID = parkingSlot.parkingSlot_ID 
            WHERE booking_ID = ? AND student_ID = ?";

    $stmt = $con->prepare($query);
    $stmt->bind_param("ii", $bookingID, $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows != 1) {
        die('Invalid booking ID or you do not have permission to view this booking');
    }

    $row = $result->fetch_assoc();
    $bookingData = json_encode($row);

    // Include the phpqrcode library
    include 'phpqrcode/qrlib.php';

    // Generate QR code and output it directly to the browser
    header('Content-Type: image/png');
    QRcode::png($bookingData, false, QR_ECLEVEL_L, 10);

    $stmt->close();
    $con->close();
?>

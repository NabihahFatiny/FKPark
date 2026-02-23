<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: ../Manage Login/login.html");
    exit;
}

$studentID = $_SESSION['userID'];

// Check if booking ID is passed
// if (!isset($_GET['bookingID'])) {
//     echo "No booking ID provided.";
//     exit;
// }

$bookingID = $_GET['bookingID'];

// Connect to the database
$con = mysqli_connect("localhost", "root", "", "fkpark");
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

// Retrieve the booking details
$query = "SELECT * FROM booking WHERE booking_ID = '$bookingID' AND student_ID = '$studentID'";
$result = mysqli_query($con, $query);
$booking = mysqli_fetch_assoc($result);

if (!$booking) {
    echo "Booking not found or you do not have permission to edit this booking.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    // Calculate booking duration
    $startDateTime = new DateTime($date . ' ' . $startTime);
    $endDateTime = new DateTime($date . ' ' . $endTime);
    $bookingDuration = $startDateTime->diff($endDateTime)->h;

    // Check if the student has already booked for the selected date
    $existingBookingQuery = "SELECT * FROM booking WHERE booking_date = ? AND student_ID = ? AND booking_ID != ?";
    $stmt = mysqli_prepare($con, $existingBookingQuery);
    mysqli_stmt_bind_param($stmt, 'sii', $date, $studentID, $bookingID);
    mysqli_stmt_execute($stmt);
    $existingBookingResult = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($existingBookingResult) > 0) {
        $error = "You have already booked a parking spot for the selected date.";
    } elseif ($bookingDuration > 10) {
        $error = "You can only book a maximum of 10 hours per day.";
    } else {
        // No existing booking and duration is within limit, proceed with booking
        $qrCode = 'Generated QR Code'; // You need to generate the QR code
        $updateQuery = "UPDATE booking SET booking_startTime = ?, booking_endTime = ?, booking_date = ?, booking_QRCode = ? WHERE booking_ID = ? AND student_ID = ?";
        $stmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($stmt, 'ssssii', $startTime, $endTime, $date, $qrCode, $bookingID, $studentID);

        if (mysqli_stmt_execute($stmt)) {
            header('Location: viewBooking.php'); // Redirect to viewBooking.php after successful edit
            exit;
        } else {
            $error = "Error updating the booking: " . mysqli_error($con);
        }
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="confirmBooking.css">
    <title>Edit Booking Form</title>
</head>
<body>
    <?php include '../Layout/studentHeader.php'; ?>

    <main>
        <div class="booking-form-container">
            <h1>Edit Booking Form</h1>
            <?php if (isset($error)) { echo '<p style="color: red; text-align: center;">' . $error . '</p>'; } ?>
            <form id="bookingForm" action="" method="POST">
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" value="<?php echo $booking['booking_date']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="startTime">Start Time:</label>
                    <input type="time" id="startTime" name="startTime" value="<?php echo $booking['booking_startTime']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="endTime">End Time:</label>
                    <input type="time" id="endTime" name="endTime" value="<?php echo $booking['booking_endTime']; ?>" required>
                </div>
                <div class="form-buttons">
                    <button type="button" class="back-button" onclick="confirmBack()">Back</button>
                    <button type="button" class="confirm-button" onclick="confirmBooking()">Confirm Booking</button>
                </div>
            </form>
        </div>
    </main>

    <?php include '../Layout/allUserFooter.php'; ?>

    <script>
        function confirmBack() {
            if (confirm("Are you sure you want to go back?")) {
                window.history.back();
            }
        }

        function confirmBooking() {
            if (confirm("Are you sure you want to confirm this booking?")) {
                document.getElementById("bookingForm").submit();
            }
        }
    </script>
</body>
</html>

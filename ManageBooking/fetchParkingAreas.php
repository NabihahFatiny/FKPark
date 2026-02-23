<?php
    include '../DB_FKPark/dbcon.php';

    // Function to fetch today's bookings
    function getTodayBookings($con) {
        $today = date('Y-m-d');
        $query = "SELECT parkingSlot_ID FROM booking WHERE booking_date = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 's', $today);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $todayBookings = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $todayBookings[] = $row['parkingSlot_ID'];
        }
        return $todayBookings;
    }

    $query = "SELECT * FROM `parkingArea`";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query Failed" . mysqli_error($con));
    }

    $parkingAreas = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $parkingAreas[] = $row;
    }

    // Add today's bookings to the parking areas data
    $todayBookings = getTodayBookings($con);
    foreach ($parkingAreas as &$area) {
        $area['todayBookings'] = $todayBookings;
    }
?>

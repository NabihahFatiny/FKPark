<?php
session_start();
include '../DB_FKPark/dbh.php';

if (isset($_POST['form_submitted'])) {
    $veh_plate = $_POST['vehicleNumPlate'];
    $violation = $_POST['violation'];
    $location = $_POST['location'];
    $datetime = $_POST['datetime'];
    $remarks = $_POST['remarks'] ?? '';
    $imagePath = '';

    if (isset($_FILES['carImage']) && $_FILES['carImage']['error'] === UPLOAD_ERR_OK) {
        $imageTmp = $_FILES['carImage']['tmp_name'];
        $imageName = time() . "_" . basename($_FILES['carImage']['name']);
        $targetDir = '../uploads/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $imagePath = $targetDir . $imageName;
        move_uploaded_file($imageTmp, $imagePath);
    }

    // Determine demerit
    $summon_demerit = 0;
    if ($violation == "Speeding") {
        $summon_demerit = 10;
    } elseif ($violation == "Not Complying") {
        $summon_demerit = 15;
    } elseif ($violation == "Accident") {
        $summon_demerit = 20;
    }

    // Get ukID from session
    $ukID = $_SESSION['userID'] ?? null;
    if ($ukID === null) {
        die("Unit Keselamatan Staff ID not found in session. Please login again.");
    }

    // Get student_ID linked to the vehicle
    $querystudentid = "SELECT `student_ID` FROM `vehicle` WHERE vehicle_numPlate = '$veh_plate'";
    $getstid = mysqli_query($con, $querystudentid);
    $student_row = mysqli_fetch_row($getstid);
    if (!$student_row) {
        die("Vehicle not found in database.");
    }
    $student_id = $student_row[0];

    // Update student's total demerit
    $querydemtot = "UPDATE `student` SET `student_demtot` = `student_demtot` + $summon_demerit WHERE `student_ID` = $student_id";
    $upstdemtot = mysqli_query($con, $querydemtot);

    if (!$veh_plate || !$violation || !$location || !$datetime) {
        header('location:ManageSummons.php?message=You need to fill in the required information!');
    } else {

    // Insert summon with remarks and image
    $stmt = $con->prepare("INSERT INTO `summon` 
        (`vehicle_numPlate`, `summon_violation`, `summon_datetime`, `summon_location`, `summon_demerit`, `uk_ID`, `summon_remarks`, `summon_image`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisss", $veh_plate, $violation, $datetime, $location, $summon_demerit, $ukID, $remarks, $imagePath);
    $result = $stmt->execute();

    if (!$result || !$upstdemtot) {
        die("Query Failed: " . $stmt->error);
    } else {
        $inboxMessage = "You have violated 1 traffic rule.";
        $inboxInsert = $con->prepare("INSERT INTO inbox (student_ID, message, time, is_read) VALUES (?, ?, NOW(), 0)");
        $inboxInsert->bind_param("is", $student_id, $inboxMessage);
        $inboxInsert->execute();

        if ($inboxInsert->affected_rows > 0) {
           echo "Inbox message inserted successfully.";
        } else {
          echo "Failed to insert inbox message: " . $inboxInsert->error;
        }

        $_SESSION['message'] = "Your data has been added successfully!";
        header('location:ManageSummons.php');
        exit;
    }
   }
    
} else {
    echo "Mak Kau Hijau";
}
?>

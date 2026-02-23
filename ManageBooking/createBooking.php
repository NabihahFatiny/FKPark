<?php
    session_start();
    ob_start();

    if (!isset($_SESSION['userID'])) {
        header("Location: ../Manage Login/login.html");
        exit;
    }

    $studentID = $_SESSION['userID'];

    $con = mysqli_connect("localhost", "root", "", "fkpark");
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    $queryApp = "SELECT * FROM approval WHERE student_ID = '$studentID'";
    $resultApp = mysqli_query($con, $queryApp);

    if ($resultApp) {
        $row = mysqli_fetch_assoc($resultApp);
        if ($row['approval_status'] != 'Successful') {
            echo "<script>alert('You need to register your vehicle first.'); window.location.href='../ManageRegistration/RegistrationVehicle.php';</script>";
            exit; // Stop further execution of the script
        }
    } else {
        echo "Error checking approval status: " . mysqli_error($con);
        exit; // Stop further execution of the script in case of an error
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="createBooking.js"></script>
    <script src="https://kit.fontawesome.com/449b7d4b66.js" crossorigin="anonymous"></script>
    <title>Booking Page</title>

    <link rel="stylesheet" href="createBooking.css">

</head>
<body>
    <?php include '../Layout/studentHeader.php'; ?>

    <main>
        <div class="create-booking">
            <div class="parking-layout">
                <h1>Select Your Parking</h1>
                <img src="../resource/FKPark_Map.png" alt="Parking Layout">
            </div>

            <div class="booking-filter">
                <div class="filter-bar">
                    <a href="filteredCreateBooking.php" id="show-vacant-btn"><i class="fa-solid fa-filter" style="padding-right: 8px"></i>Show vacant slots today</a>
                </div>
            </div>

            <div class="tabs">
                <button class="tab-button tab-active" data-section="sectionA" onclick="showTab('sectionA', this)">Parking Section B1</button>
                <button class="tab-button" data-section="sectionB" onclick="showTab('sectionB', this)">Parking Section B2</button>
                <button class="tab-button" data-section="sectionC" onclick="showTab('sectionC', this)">Parking Section B3</button>
                <button class="tab-button" data-section="sectionD" onclick="showTab('sectionD', this)">Parking Section M1</button>
                <div class="tab-indicator"></div>
            </div>

            <div id="sectionA" class="tab-content active">
                <table>
                    <tr>
                        <th>Parking Spot</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        $result = mysqli_query($con, "SELECT * FROM parkingSlot WHERE parkingSlot_name LIKE 'B1%' AND parkingSlot_status = 'AVAILABLE'");
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $isAvailable = ($row['parkingSlot_status'] == 'AVAILABLE') ? 'true' : 'false';
                                echo "<tr data-available='{$isAvailable}'>";
                                echo "<td>" . $row['parkingSlot_name'] . "</td>";
                                echo "<td><a href='confirmBooking.php?parkingSpot=" . $row['parkingSlot_name'] . "' class='book-link'>Book</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>No parking spots available.</td></tr>";
                        }
                    ?>
                </table>
            </div>

            <div id="sectionB" class="tab-content active">
                <table>
                    <tr>
                        <th>Parking Spot</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        $result = mysqli_query($con, "SELECT * FROM parkingSlot WHERE parkingSlot_name LIKE 'B2%' AND parkingSlot_status = 'AVAILABLE'");
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $isAvailable = ($row['parkingSlot_status'] == 'AVAILABLE') ? 'true' : 'false';
                                echo "<tr data-available='{$isAvailable}'>";
                                echo "<td>" . $row['parkingSlot_name'] . "</td>";
                                echo "<td><a href='confirmBooking.php?parkingSpot=" . $row['parkingSlot_name'] . "' class='book-link'>Book</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>No parking spots available.</td></tr>";
                        }
                    ?>

                </table>
            </div>

            <div id="sectionC" class="tab-content active">
                <table>
                    <tr>
                        <th>Parking Spot</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        $result = mysqli_query($con, "SELECT * FROM parkingSlot WHERE parkingSlot_name LIKE 'B3%' AND parkingSlot_status = 'AVAILABLE'");
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $isAvailable = ($row['parkingSlot_status'] == 'AVAILABLE') ? 'true' : 'false';
                                echo "<tr data-available='{$isAvailable}'>";
                                echo "<td>" . $row['parkingSlot_name'] . "</td>";
                                echo "<td><a href='confirmBooking.php?parkingSpot=" . $row['parkingSlot_name'] . "' class='book-link'>Book</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>No parking spots available.</td></tr>";
                        }
                    ?>
                </table>
            </div>

            <div id="sectionD" class="tab-content active">
                <table>
                    <tr>
                        <th>Parking Spot</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        $result = mysqli_query($con, "SELECT * FROM parkingSlot WHERE parkingSlot_name LIKE 'M1%' AND parkingSlot_status = 'AVAILABLE'");
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $isAvailable = ($row['parkingSlot_status'] == 'AVAILABLE') ? 'true' : 'false';
                                echo "<tr data-available='{$isAvailable}'>";
                                echo "<td>" . $row['parkingSlot_name'] . "</td>";
                                echo "<td><a href='confirmBooking.php?parkingSpot=" . $row['parkingSlot_name'] . "' class='book-link'>Book</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>No parking spots available.</td></tr>";
                        }
                    ?>
                </table>
            </div>
        </div>
    </main>

    <?php include '../Layout/allUserFooter.php'; ?>
</body>
</html>

<?php
    ob_end_flush();
?>
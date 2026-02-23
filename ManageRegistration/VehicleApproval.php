<?php
// Include the database connection
ob_start();
include '../Layout/UKHeader.php'; 
include '../DB_FKPark/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['approve_vehicle_numPlate'])) {
        $vehicle_numPlate_to_approve = $_POST['approve_vehicle_numPlate'];
        $student_ID = $_POST['student_ID'];
        
        // Update the approval status to 'Successful'
        $approveQuery = "INSERT INTO approval (vehicle_grant, approval_status, student_ID)
                         VALUES ('$vehicle_numPlate_to_approve', 'Successful', '$student_ID')
                         ON DUPLICATE KEY UPDATE approval_status='Successful'";
        $approveResult = mysqli_query($con, $approveQuery);

        if (!$approveResult) {
            die("Approval failed: " . mysqli_error($con));
        } else {
            header('Location: ../ManageRegistration/VehicleApproval.php?message=Vehicle has been approved successfully');
            exit;
        }
    } elseif (isset($_POST['cancel_vehicle_numPlate'])) {
        $vehicle_numPlate_to_cancel = $_POST['cancel_vehicle_numPlate'];
        $student_ID = $_POST['student_ID'];
        
        // Update the approval status to 'Unsuccessful'
        $cancelQuery = "INSERT INTO approval (vehicle_grant, approval_status, student_ID)
                        VALUES ('$vehicle_numPlate_to_cancel', 'Unsuccessful', '$student_ID')
                        ON DUPLICATE KEY UPDATE approval_status='Unsuccessful'";
        $cancelResult = mysqli_query($con, $cancelQuery);

        if (!$cancelResult) {
            die("Cancellation failed: " . mysqli_error($con));
        } else {
            header('Location: ../ManageRegistration/VehicleApproval.php?message=Vehicle registration has been cancelled');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags and CSS links -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="viewRegistration.css">
    <title>List of Vehicles</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
        }
        footer {
            background: #333;
            color: #fff;
            padding: 20px 0;
        }
        footer .container {
            display: flex;
            justify-content: space-between;
        }
        footer .container div {
            flex: 1;
            padding: 0 50px;
            text-align: center;
        }
        footer h5 {
            margin-top: 0;

        }
        footer ul {
            list-style: none;
            padding: 0;

        }
        footer ul li {
            margin: 5px 0;

        }
        footer ul li a {
            color: #fff;
            text-decoration: none;

        }
        footer ul li a:hover {
            text-decoration: underline;
        }

        .view-container {
            text-align: center;
            padding: 50px;
        }
    </style>
</head>
<body>

    <main>
        <h1 id="main_title">List Of Vehicles</h1>
        <div class="view-container">
            <table class="table table-hover table-bordered table-striped">
                <thead>
                    <tr class="view-table-header">
                        <th>Number Plate</th>
                        <th>Type</th>
                        <th>Brand</th>
                        <th>Transmission</th>
                        <th>Grant</th>
                        <th>Student ID</th>
                        <th>Approve</th>
                        <th>Decline</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM Vehicle";
                    $result = mysqli_query($con, $query);

                    if (!$result) {
                        die("Query failed: " . mysqli_error($con));
                    } else {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['vehicle_numPlate']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['vehicle_type']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['vehicle_brand']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['vehicle_transmission']) . '</td>';
                            echo '<td><img src="' . htmlspecialchars($row['vehicle_grant']) . '" alt="Vehicle Grant" width="100"></td>';
                            echo '<td>' . htmlspecialchars($row['student_ID']) . '</td>';
                            echo '<td><button type="button" class="btn btn-success approve-button" data-id="' . htmlspecialchars($row['vehicle_numPlate']) . '" data-student="' . htmlspecialchars($row['student_ID']) . '">Approve</button></td>';
                            echo '<td><button type="button" class="btn btn-danger cancel-button" data-id="' . htmlspecialchars($row['vehicle_numPlate']) . '" data-student="' . htmlspecialchars($row['student_ID']) . '">Decline</button></td>';
                            echo '<td>
                                    <form method="POST" action="deleteVehicle.php" onsubmit="return confirm(\'Are you sure you want to delete this vehicle?\');">
                                        <input type="hidden" name="delete_vehicle_numPlate" value="' . htmlspecialchars($row['vehicle_numPlate']) . '">
                                        <input type="hidden" name="student_ID" value="' . htmlspecialchars($row['student_ID']) . '">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                  </td>';
                            echo '</tr>';
                            echo '</tr>';
                        }
                    }
                    mysqli_close($con);
                   ?>
                </tbody>
            </table>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var approveButtons = document.querySelectorAll('.approve-button');
                approveButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        var vehicleNumPlate = this.getAttribute('data-id');
                        var studentID = this.getAttribute('data-student');
                        var form = document.createElement('form');
                        form.method = 'POST';
                        form.action = 'VehicleApproval.php';
                        var input1 = document.createElement('input');
                        input1.type = 'hidden';
                        input1.name = 'approve_vehicle_numPlate';
                        input1.value = vehicleNumPlate;
                        form.appendChild(input1);
                        var input2 = document.createElement('input');
                        input2.type = 'hidden';
                        input2.name = 'student_ID';
                        input2.value = studentID;
                        form.appendChild(input2);
                        document.body.appendChild(form);
                        form.submit();
                    });
                });

                var cancelButtons = document.querySelectorAll('.cancel-button');
                cancelButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        var vehicleNumPlate = this.getAttribute('data-id');
                        var studentID = this.getAttribute('data-student');
                        var form = document.createElement('form');
                        form.method = 'POST';
                        form.action = 'VehicleApproval.php';
                        var input1 = document.createElement('input');
                        input1.type = 'hidden';
                        input1.name = 'cancel_vehicle_numPlate';
                        input1.value = vehicleNumPlate;
                        form.appendChild(input1);
                        var input2 = document.createElement('input');
                        input2.type = 'hidden';
                        input2.name = 'student_ID';
                        input2.value = studentID;
                        form.appendChild(input2);
                        document.body.appendChild(form);
                        form.submit();
                    });
                });
            });
        </script>
    </main>
    <footer>
        <div class="container">
            <div>
                <h5>About FKPark</h5>
                <p>FKPark is a premier parking management system providing seamless and efficient parking solutions.</p>
            </div>
            <div>
                <h5>Quick Links</h5>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Booking</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div>
                <h5>Contact Us</h5>
                <p>Email: info@fkpark.com<br>Phone: +123 456 7890</p>
            </div>
        </div>
    </footer></body>
</html>

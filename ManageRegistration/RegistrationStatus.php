<?php
session_start(); // Ensure the session is started
include '../Layout/studentHeader.php';
include '../DB_FKPark/dbcon.php';

if (!isset($_SESSION['userID'])) {
    // Redirect to login if the user is not logged in
    header("Location: Login.php");
    exit();
}

$userID = $_SESSION['userID'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags and CSS links -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="viewRegistration.css">
    <title>Vehicle Registration Status</title>
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
        <h1 id="main_title">Vehicle Registration Status</h1>
        <div class="view-container">
            <?php
            if (isset($_GET['message'])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_GET['message']) . '</div>';
            }
            ?>
            <table class="table table-hover table-bordered table-striped">
                <thead>
                    <tr class="view-table-header">
                        <th>Number Plate</th>
                        <th>Type</th>
                        <th>Brand</th>
                        <th>Transmission</th>
                        <th>Grant</th>
                        <th>Student ID</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT v.*, COALESCE(a.approval_status, 'Pending') AS approval_status
                              FROM Vehicle v
                              LEFT JOIN approval a ON v.vehicle_numPlate = a.vehicle_grant AND v.student_ID = a.student_ID
                              WHERE v.student_ID = ?";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("s", $userID);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['vehicle_numPlate']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['vehicle_type']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['vehicle_brand']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['vehicle_transmission']) . '</td>';
                            echo '<td><img src="' . htmlspecialchars($row['vehicle_grant']) . '" alt="Vehicle Grant" width="100"></td>';
                            echo '<td>' . htmlspecialchars($row['student_ID']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['approval_status']) . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<div class="alert alert-info">No records found for your registration status.</div>';
                    }
                    $stmt->close();
                    $con->close();
                    ?>
                </tbody>
            </table>
        </div>
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
    </footer>
</body>
</html>

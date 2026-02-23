<?php
// Include the database connection
include '../Layout/studentHeader.php'; 
include '../DB_FKPark/dbcon.php';
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
        .vehicle-sticker {
            display: none;
            margin-top: 20px;
            text-align: left;
        }
        .vehicle-sticker img {
            width: 200px;
            height: 200px;
        }
        .vehicle-sticker table {
            width: 100%;
        }
        .vehicle-sticker th, .vehicle-sticker td {
            padding: 10px;
            text-align: left;
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
                        <th>Sticker</th>
                        <th>Student ID</th>
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
                            echo '<td><a href="#" class="number-plate" data-id="' . htmlspecialchars($row['vehicle_numPlate']) . '">' . htmlspecialchars($row['vehicle_numPlate']) . '</a></td>';
                            echo '<td>' . htmlspecialchars($row['vehicle_type']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['vehicle_brand']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['vehicle_transmission']) . '</td>';
                            echo '<td><img src="../ alt="Vehicle Grant" width="100"></td>';
                            echo '<td>' . htmlspecialchars($row['student_ID']) . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="vehicle-sticker" id="vehicle-sticker">
            <h2>Vehicle Sticker Information</h2>
            <table border="1">
                <tr>
                    <th rowspan="4"><img src="" alt="sticker" id="sticker-image"></th>
                    <th colspan="2">Vehicle Information</th>
                </tr>
                <tr>
                    <td>Vehicle Type</td>
                    <td id="vehicle-type">&nbsp;</td>
                </tr>
                <tr>
                    <td>Vehicle Number Plate</td>
                    <td id="vehicle-numPlate">&nbsp;</td>
                </tr>
                <tr>
                    <td>Transmission</td>
                    <td id="vehicle-transmission">&nbsp;</td>
                </tr>
            </table>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.number-plate').forEach(function(element) {
                    element.addEventListener('click', function(event) {
                        event.preventDefault();
                        var vehicleNumPlate = this.getAttribute('data-id');

                        fetchVehicleSticker(vehicleNumPlate);
                    });
                });
            });

            function fetchVehicleSticker(vehicleNumPlate) {
                // Fetch the vehicle sticker details using AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'fetchVehicleSticker.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        document.getElementById('sticker-image').src = response.vehicle_grant;
                        document.getElementById('vehicle-type').innerText = response.vehicle_type;
                        document.getElementById('vehicle-numPlate').innerText = response.vehicle_numPlate;
                        document.getElementById('vehicle-transmission').innerText = response.vehicle_transmission;

                        document.getElementById('vehicle-sticker').style.display = 'block';
                    }
                };
                xhr.send('vehicle_numPlate=' + vehicleNumPlate);
            }
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
    </footer>

    <?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vehicle_numPlate'])) {
    $vehicle_numPlate = $_POST['vehicle_numPlate'];

    $query = "SELECT vehicle_type, vehicle_numPlate, vehicle_transmission, vehicle_grant FROM Vehicle WHERE vehicle_numPlate = ?";
    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param("s", $vehicle_numPlate);
        $stmt->execute();
        $stmt->bind_result($vehicle_type, $vehicle_numPlate, $vehicle_transmission, $vehicle_grant);
        $stmt->fetch();
        
        $response = [
            'vehicle_type' => $vehicle_type,
            'vehicle_numPlate' => $vehicle_numPlate,
            'vehicle_transmission' => $vehicle_transmission,
            'vehicle_grant' => $vehicle_grant
        ];

        echo json_encode($response);
        $stmt->close();
    }
    mysqli_close($con);
}
?>

</body>
</html>

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Registration</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            background-color: #f4f4f4;
        }

        .container2 {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .center-table {
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .center-table h1 {
            margin: 0;
            padding: 20px;
            background-color: #BE8A62;
            color: #fff;
            text-align: center;
        }

        .center-table img {
            display: block;
            margin: 0 auto;
            margin-top: 20px;
        }

        .center-middle {
            padding: 0px 30px;
        }

        .center-middle p {
            font-weight: bold;
            font-size: 18px;
            color: #333;
            text-align: center;
            margin-bottom: 10px;
        }

        .radio-group {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .radio-group label {
            padding-top: 8px;
            margin-left: 10px;
            margin-right: 20px;
            font-size: 16px;
            color: #333;
        }

        .radio-group input[type="radio"] {
            margin-left: 10px;
        }

        label {
            display: block;
            font-size: 16px;
            color: #333;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="file"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="file"] {
            
        }

        .submit-btn {
            text-align: center;
            padding-bottom: 20px;
        }

        .submit-btn input[type="submit"] {
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: bold;
        }

        .submit-btn input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Basic styling for the select element */
        .select {
            padding: 8px; /* Adjust padding as needed */
            font-size: 16px; /* Adjust font size */
            border: 1px solid #ccc; /* Border color */
            border-radius: 4px; /* Rounded corners */
            appearance: none; /* Remove default arrow icon on some browsers */
            -webkit-appearance: none; /* Remove default arrow icon for Safari/Chrome */
            -moz-appearance: none; /* Remove default arrow icon for Firefox */
            background-color: #fff; /* Background color */
            width: 100%; /* Full width */
            max-width: 300px; /* Limit maximum width if needed */
        }

        /* Hover and focus states */
        .select:hover,
        .select:focus {
            border-color: #246dec; /* Highlight border color on hover/focus */
        }

        /* Arrow icon */
        .select::after {
            content: '\25BC'; /* Unicode character for down arrow */
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            pointer-events: none;
            color: #555; /* Arrow color */
        }

    </style>
</head>
<body>
    <?php include '../Layout/studentHeader.php'; ?>

    <div class="container2">
        <table border="0" cellspacing="0" cellpadding="0" class="center-table">
            <tr>
                <td colspan="2">
                    <h1>Vehicle Registration Form</h1>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <img src="../resource/illustration.jpg" alt="parking" width="200" height="200">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                <form action="RegistrationVehicle.php" method="post" enctype="multipart/form-data">
                    <div class="center-middle">
                        <p>Select Vehicle Type</p>
                        <div class="radio-group">
                            <input type="radio" id="car" name="vehicleType" value="Car" required>
                            <label for="car">Car</label>
                            <input type="radio" id="motorcycle" name="vehicleType" value="Motorcycle" required>
                            <label for="motorcycle">Motorcycle</label>
                        </div>
                        <label for="numPlate">Number Plate:</label>
                        <input type="text" id="numPlate" name="numPlate" required>
                        <label for="brand">Brand:</label>
                        <select id="brand" name="brand" required>
                            <option value="Toyota">Toyota</option>
                            <option value="Honda">Honda</option>
                            <option value="Ford">Ford</option>
                            <option value="Chevrolet">Chevrolet</option>
                            <option value="Nissan">Nissan</option>
                            <option value="BMW">BMW</option>
                            <option value="Mercedes-Benz">Mercedes-Benz</option>
                            <option value="Audi">Audi</option>
                            <option value="Volkswagen">Volkswagen</option>
                            <option value="Hyundai">Hyundai</option>
                            <option value="Mazda">Mazda</option>
                            <option value="Kia">Kia</option>
                            <option value="Subaru">Subaru</option>
                            <option value="Proton">Proton</option>
                            <option value="Perodua">Perodua</option>
                        </select>
                        <label for="trans">Transmission:</label>
                        <input type="text" id="trans" name="trans" required>
                        <label for="grantFile">Upload Grant File:</label>
                        <input type="file" id="grantFile" name="grantFile" required>
                    </div>
                    <div class="submit-btn">
                        <input type="submit" value="Submit">
                    </div>
                </form>

                </td>
            </tr>
        </table>
    </div>

    <?php include '../Layout/allUserFooter.php'; ?>
</body>
</html>

<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $con = mysqli_connect("localhost", "root", "", "fkpark");
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    mysqli_select_db($con, "fkpark") or die(mysqli_error($con));

    // Retrieve student ID from session
    $studentID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
    if ($studentID === null) {
        die('Student ID not found in session. Please login again.');
    }

    // Retrieve other form data
    $vehicleType = mysqli_real_escape_string($con, $_POST["vehicleType"]);
    $numPlate = mysqli_real_escape_string($con, $_POST["numPlate"]);
    $brand = mysqli_real_escape_string($con, $_POST["brand"]);
    $trans = mysqli_real_escape_string($con, $_POST["trans"]);

    // Handle file upload
    $grantFile = $_FILES["grantFile"];
    $grantFileName = basename($grantFile["name"]);
    $targetDir = "uploads/";
    $targetFilePath = $targetDir . $grantFileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'pdf');
    if (in_array($fileType, $allowTypes)) {
        if (move_uploaded_file($grantFile["tmp_name"], $targetFilePath)) {
            // Check if the vehicle_numPlate already exists
            $checkQuery = "SELECT * FROM vehicle WHERE vehicle_numPlate = '$numPlate'";
            $checkResult = mysqli_query($con, $checkQuery);

            if (mysqli_num_rows($checkResult) > 0) {
                // If a record with the same vehicle_numPlate exists, update the record
                $updateQuery = "UPDATE vehicle SET 
                    vehicle_type='$vehicleType', 
                    vehicle_brand='$brand', 
                    vehicle_transmission='$trans', 
                    student_ID='$studentID', 
                    vehicle_grant='$targetFilePath' 
                    WHERE vehicle_numPlate='$numPlate'";
                
                if (mysqli_query($con, $updateQuery)) {
                    echo "<script>alert('Vehicle record updated successfully');</script>";
                } else {
                    echo "Update failed: " . mysqli_error($con);
                }
            } else {
                // If no record with the same vehicle_numPlate exists, insert the new record
                $insertQuery = "INSERT INTO vehicle(vehicle_numPlate, vehicle_type, vehicle_brand, vehicle_transmission, student_ID, vehicle_grant) VALUES('$numPlate','$vehicleType','$brand','$trans','$studentID','$targetFilePath')";
                
                if (mysqli_query($con, $insertQuery)) {
                    echo "<script>alert('Vehicle registration successful!');</script>";
                } else {
                    echo "Insertion failed: " . mysqli_error($con);
                }
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG, & PDF files are allowed.";
    }

    mysqli_close($con);
}
?>




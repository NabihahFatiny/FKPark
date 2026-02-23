<?php
    session_start();

    if (!isset($_SESSION['userID'])) {
        header("Location: ../Manage Login/login.php"); // Redirect to the login page
        exit;
    }

    include '../DB_FKPark/dbh.php';

    $summon_id = $_GET['summon_id'];

    $query = "SELECT s.* ,v.*, st.*, uks.*
              FROM summon s
              JOIN vehicle v ON s.vehicle_numPlate = v.vehicle_numPlate
              JOIN student st ON v.student_ID = st.student_ID
              JOIN unitkeselamatanstaff uks ON s.uk_ID = uks.uk_ID
              WHERE s.summon_id = $summon_id";

    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    } else {
        $row = mysqli_fetch_assoc($result);

        $summon_ID = $row['summon_ID'];
        $summon_violation = $row['summon_violation'];
        $summon_datetime = $row['summon_datetime'];
        $summon_demerit = $row['summon_demerit'];
        $summon_location = $row['summon_location'];
        

        $vehicle_numPlate = $row['vehicle_numPlate'];
        $vehicle_type = $row['vehicle_type'];
        $vehicle_brand = $row['vehicle_brand'];
        $vehicle_transmission = $row['vehicle_transmission'];

        $student_username = $row['student_username'];
        $student_phoneNum = $row['student_phoneNum'];
        $student_demtot = $row['student_demtot'];
        
        $uk_ID = $row['uk_ID'];
        $uk_username = $row['uk_username'];

        $enforcement = '';
        if($student_demtot < 20){
            $enforcement = 'Warning is issued!';
        }
        else if($student_demtot < 50){
            $enforcement = 'Campus Vehicle Permission Revoked for 1 semester!';
        }
        else if($student_demtot < 80){
            $enforcement = 'Campus Vehicle Permission Revoked for 2 semesters!';
        }else{
            $enforcement = 'Campus Vehicle Permission Revoked Indefinitely!';
        }


        $qrData = "Vehicle Number Plate: $vehicle_numPlate | DateTime: $summon_datetime | Violation: $summon_violation | Student: $student_username ";
        $qrDataEncoded = urlencode($qrData);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="ManageSummons.css" rel="stylesheet">
    <title>Manage Summons Page</title>
</head>
<style>

.qr-container {
    text-align: center;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.qr-container h2{
    margin-bottom: 20px;
    font-weight: bold;
}

.summonDetails {
    margin-top: 20px;
    display: flex;
    justify-content: center;
}

.summonDetails table {
    width: 100%;
    max-width: 1000px;
    border-collapse: collapse;
    margin: 0 auto;
}

.summonDetails th,
.summonDetails td {
    padding: 8px;
    border: 1px solid black;
}

.summonDetails th {
    background-color: #463FA7;
    color: white;
    font-weight: bold;
}

.summonDetails td {
    background-color: #fff;
}

.sidetitle {
    width: 200px;
    font-weight: bold;
    text-align: left;
}

.back-button {
    width: 100%;
    max-width: 200px;
    padding: 8px;
    text-decoration: none;
    background-color: #007bff;
    color: white;
    border-radius: 4px;
    text-align: center;
    font-weight: bold;
    cursor: pointer;
    border: none;
    margin-top: 20px;
}

.back-button:hover {
    transition: 0.3s;
    background-color: #005fc4;
}

</style>
<body>

    <?php include '../Layout/UKHeader.php'; ?>

    <main>
    
    <div class="qr-container">
        <h2>Summon <?php echo $summon_ID ?> Details</h2>
        <img style="width:10%" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $qrDataEncoded; ?>" alt="QR Code">
        <div class="summonDetails" style="margin-top: 20px;">
            <table>
                <tr>
                    <th  colspan="2">Summon Details</th>
                </tr>
                <tr>
                    <th class="sidetitle">Issued By:</th>
                    <td style="background-color:#ADA7FF" ><?php echo $uk_username ?></td>
                </tr>
                <tr>
                    <th class="sidetitle">Vehicle Number Plate:</th>
                    <td><?php echo $vehicle_numPlate ?></td>
                </tr>
                <tr>
                    <th class="sidetitle">Vehicle Type:</th>
                    <td><?php echo $vehicle_type ?>: <?php echo $vehicle_brand?></td>
                </tr>
                <tr>
                    <th class="sidetitle">Violation:</th>
                    <td><?php echo $summon_violation?></td>
                </tr>
                <tr>
                    <th class="sidetitle">DateTime of Summons:</th>
                    <td><?php echo $summon_datetime ?></td>
                </tr>
                <tr>
                    <th class="sidetitle">Demerit Point:</th>
                    <td><?php echo $summon_demerit ?></td>
                </tr>
                
                <tr>
                    <th class="sidetitle">Student Username:</th>
                    <td><?php echo $student_username ?></td>
                </tr>
                <tr>
                    <th class="sidetitle">Student Phone Number:</th>
                    <td><?php echo $student_phoneNum ?></td>
                </tr>
                <tr>
                    <th class="sidetitle">Student Total Demerit:</th>
                    <td><?php echo $student_demtot ?></td>
                </tr>
                <tr>
                    <th colspan="2"><strong>Enforcement:</strong></th>
                </tr>
                <tr>
                    <td style="color: #FF4919; font-weight: bold;" colspan="2"><?php echo $enforcement ?></td>
                </tr>
            </table>
         </div>
        <button type="button" class="back-button" onclick="confirmBack()">Back</button>
    </div>          


    
    </main>


    <?php include '../Layout/allUserFooter.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function confirmBack() {
            window.location.href = 'ManageSummons.php';
        }
    </script>
</body>
</html>



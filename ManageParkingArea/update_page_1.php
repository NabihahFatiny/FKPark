<?php
ob_start(); // Start output buffering
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Parking Booking Form</title>
    <style>
        table.center {
            margin-left: auto; 
            margin-right: auto;
            width: 900px;
            margin-top: 70px;
        }
    </style>
</head>
<body>
<?php include '../Layout/adminHeader.php'; ?>
<?php include '../DB_FKPark/dbcon.php'; // Include the database connection file. ?>

<h2 style="text-align:center">Update Parking</h2>

<form action="" method="POST">
    <table class="center">
        <tbody>
            <?php
            $row = [];
            $p_area = ""; 

            if(isset($_GET['id'])){
                $p_area = $_GET['id'];
                $query = "SELECT pa.*, e.event_ID, e.event_name FROM `parkingArea` pa LEFT JOIN `event` e ON pa.event_ID = e.event_ID WHERE pa.parkingArea_ID = '$p_area'"; 

                $result = mysqli_query($con, $query);

                if(!$result){
                    die("Query failed: " . mysqli_error($con));
                } else {
                    $row = mysqli_fetch_assoc($result);

                    // Fetch events for the dropdown
                    $events = [];
                    $event_query = "SELECT * FROM `event`";
                    $event_result = mysqli_query($con, $event_query);

                    if(!$event_result){
                        die("Query failed: " . mysqli_error($con));
                    } else {
                        while($event = mysqli_fetch_assoc($event_result)) {
                            $events[] = $event;
                        }
                    }

                    if($row !== null) {
                        ?>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label for="p_area">Parking Area</label>
                                    <select name="p_area" class="form-control">
                                        <option value="B1" <?php echo ($row['parkingArea_name'] == 'B1') ? 'selected' : ''; ?>>B1</option>
                                        <option value="B2" <?php echo ($row['parkingArea_name'] == 'B2') ? 'selected' : ''; ?>>B2</option>
                                        <option value="B3" <?php echo ($row['parkingArea_name'] == 'B3') ? 'selected' : ''; ?>>B3</option>
                                        <option value="M1" <?php echo ($row['parkingArea_name'] == 'M1') ? 'selected' : ''; ?>>M1</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label for="event_name">Event Name</label>
                                    <select name="event_name" id="event_name" class="form-control" onchange="updateParkingStatus()">
                                        <?php foreach ($events as $event): ?>
                                            <option value="<?php echo $event['event_ID']; ?>" <?php echo ($row['event_ID'] == $event['event_ID']) ? 'selected' : ''; ?>><?php echo $event['event_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="hidden" name="event_ID" id="event_ID" value="<?php echo $row['event_ID']; ?>">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label for="p_status">Parking Status</label>
                                    <input type="text" name="p_status" id="p_status" class="form-control" readonly value="<?php echo $row['parkingArea_status']; ?>">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><input style="margin-top:20px;" type="submit" class="btn btn-success" name="update_parking" value="UPDATE"></td>
                        </tr>
                        <?php
                    } else {
                        echo "No data found for the given parking area.";
                    }
                }
            }

            if(isset($_POST['update_parking'])){
                $update_p_area = $_POST['p_area'];
                $update_p_status = $_POST['p_status'];
                $update_event_ID = $_POST['event_ID'];

                $query = "UPDATE `parkingArea` SET `parkingArea_name` = '$update_p_area', 
                                                  `parkingArea_status` = '$update_p_status',
                                                  `event_ID` = '$update_event_ID' 
                          WHERE `parkingArea_ID` = '$p_area'";

                $result1 = mysqli_query($con, $query);
                if(!$result1){
                    die("Query failed: " . mysqli_error($con));
                }

                $query1 = "UPDATE `parkingSlot` SET `parkingSlot_status` = '$update_p_status' 
                           WHERE `parkingArea_ID` = '$p_area'";

                $result2 = mysqli_query($con, $query1);
                if(!$result2){
                    die("Query failed: " . mysqli_error($con));
                }

                if($result1 && $result2){
                    header('location:../ManageParkingArea/ManageParking.php?update_msg=You have successfully updated the data!');
                    exit;
                }
            }
            ?>
        </tbody>
    </table>
</form>
<?php include '../Layout/allUserFooter.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    function updateParkingStatus() {
        var eventNameSelect = document.getElementById('event_name');
        var eventIDInput = document.getElementById('event_ID');
        var parkingStatus = document.getElementById('p_status');

        var selectedEventID = eventNameSelect.options[eventNameSelect.selectedIndex].value;
        var selectedEventName = eventNameSelect.options[eventNameSelect.selectedIndex].text;

        eventIDInput.value = selectedEventID;

        if (selectedEventName === 'NO EVENT') {
            parkingStatus.value = 'AVAILABLE';
        } else {
            parkingStatus.value = 'UNAVAILABLE';
        }
    }

    window.onload = function() {
        updateParkingStatus();
    };
</script>

</body>
</html>

<?php
ob_end_flush(); // Flush the output buffer and send the output to the browser
?>

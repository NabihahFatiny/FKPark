<?php
session_start();
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

<body>

    <?php include '../Layout/UKHeader.php'; ?>
    <?php include '../DB_FKPark/dbh.php'; ?>

    <main>
    <div class="logoUK">
        <img src="../resource/logUK1.png" alt="Logo Unit Keselamatan UMPSA">
    </div>

    <div class="container-summonslist">
        <div class="box1">
            <h2>List of Summon</h2>
            <div class="button-container" >
            <button type="submit" class="button btn-primary "data-bs-toggle="modal" data-bs-target="#summonsModal">Create New Summon</button>
            </div>
        </div>

        <div id="list">
        <table class="table table-hover table-bordered table-striped" >
            <tr>
                <th style="width:100px;">Summon ID</th>
                <th style="width:300px;">Vehicle Plate</th>
                <th style="width:180px;">Violation</th>
                <th style="width:380px;">Date Time</th>
                <th style="width:180px;">Action</th>
                <th style="width:280px;">QR Code</th>
            </tr>

            <tbody>
            <?php         
                $query = "SELECT s.summon_ID, s.vehicle_numPlate, s.summon_violation, s.summon_datetime, s.summon_location,
                          v.student_ID, st.student_username
                          FROM summon s
                          JOIN vehicle v ON s.vehicle_numPlate = v.vehicle_numPlate
                          JOIN student st ON v.student_ID = st.student_ID
                          ORDER BY s.summon_ID";

                $result = mysqli_query($con, $query);

                if (!$result) {
                    die("Query failed: " . mysqli_error($con));
                } else {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?php echo$row['summon_ID']; ?></td>
                        <td><?php echo$row['vehicle_numPlate']; ?></td>
                        <td><?php echo$row['summon_violation']; ?></td>
                        <td><?php echo $row['summon_datetime'];; ?></td>

                        <td style="border-collapse: collapse;display: flex; align-items: center;">
                                <div style="margin:10px 10px;" class="button-container">
                                    <a href="viewSummons_data.php?summon_id=<?php echo $row['summon_ID']; ?>" >
                                        <button type="view">View</button>
                                    </a>
                                </div>

                                <button type="submit" class="button btn btn-success" data-bs-toggle="modal" data-bs-target="#updateSummonsModal"
                                onclick="populateUpdateModal('<?php echo $row['summon_ID']; ?>','<?php echo $row['vehicle_numPlate']; ?>','<?php echo $row['summon_violation']; ?>',
                                '<?php echo $row['summon_datetime']; ?>','<?php echo $row['summon_location']; ?>')" style="margin-right: 40px;">Update</button>

                                <a href="#" class="button btn btn-danger" onclick="confirmDelete('<?php echo $row['summon_ID']; ?>', '<?php echo $row['vehicle_numPlate']; ?>')">Delete</a>
                        </td>
                        <td>
                        <div style="padding-left:20px;" id="imgBox">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=50x50&data=<?php echo urlencode
                            ('Plate: ' . $row['vehicle_numPlate'] . '|Violation: ' . $row['summon_violation'] . 
                            '|Student: ' . $row['student_username']); ?>" alt="qrImage">
                        </div> 
                        </td>
                    </tr>
                <?php
                    }
                  }else{
                    echo "<tr><td colspan='6'>No Summons available.</td></tr>";
                  }
                }
                ?>

            </tbody>

        </table>


        </div>

        <?php
                if(isset($_SESSION['message'])){
                    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
                    unset($_SESSION['message']); // Clear the session message
                }
            ?>

        <?php
                if(isset($_SESSION['up_message'])){
                    echo "<script>alert('" . $_SESSION['up_message'] . "');</script>";
                    unset($_SESSION['up_message']); // Clear the session message
                }
            ?>

        <?php
                if(isset($_SESSION['del_message'])){
                    echo "<script>alert('" . $_SESSION['del_message'] . "');</script>";
                    unset($_SESSION['del_message']); // Clear the session message
                }
            ?>

        <?php
                if(isset($_GET['delete_msg'])){
                    echo "<h6>" .$_GET['delete_msg'] . "</h6>";
                }
            ?>

        <?php
        if (isset($_GET['insert_msg'])) {
            echo "<h6>" . $_GET['insert_msg'] . "</h6>";
            if (isset($_GET['qr_image'])) {
                echo "<h6>QR Code:</h6>";
                echo "<img src='../resource/" . $_GET['qr_image'] . "'>";
            }
        }
        ?>

    </div>
                


    
    </main>


    <?php include '../Layout/allUserFooter.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="ManageSummons.js"></script>

 <!-- Modal Create Summons -->
 <form id="summonsForm" action="insertSummons_data.php" onsubmit="return validateVehicleNumPlate('summonsForm')" method="POST" enctype="multipart/form-data">
 <div class="modal fade" id="summonsModal" tabindex="-1" role="dialog" aria-labelledby="summonsModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
  
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" >Create New Summon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         
        </button>
      </div>
      <div class="modal-body">
      <input type="hidden" name="form_submitted" value="1">
            <div class="form-group">
                <label for="vehicleNumPlate">Vehicle Number Plate</label>
                <input type="text" id="vehicleNumPlate" name="vehicleNumPlate" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="violation">Violation</label>
                <select id="violation" name="violation" class="form-control" required>
                    <option value="" disabled selected>Select an option</option>
                    <option value="Speeding">Speeding</option>
                    <option value="Not Complying">Not Complying</option>
                    <option value="Accident">Accident</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="location">Location</label>
                <select id="update_location" name="location" class="form-control" required>
                    <option value="" disabled selected>Select parking area</option>
                    <option value="A1">B1</option>
                    <option value="A2">B2</option>
                    <option value="A3">B3</option>
                    <option value="A5">M1</option>
                    <option value="B1">B1</option>
                    <option value="B2">B2</option>
                    <option value="B3">B3</option>
                    <option value="M1">M1</option>
                    <option value="M2">M2</option>
                </select>
            </div>


            <div class="form-group">
                <label for="datetime">Date and Time</label>
                <input type="datetime-local" id="datetime" name="datetime" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="remarks">Remarks</label>
                <textarea id="remarks" name="remarks" class="form-control" placeholder="Enter remarks here..."></textarea>
            </div>

            <div class="form-group">
               <label for="carImage">Upload Car Image</label>
               <input type="file" id="carImage" name="carImage" class="form-control" accept="image/*">
            </div>
               
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-success" name="add_summons" value="CREATE" >
      </div>
    </div>
  </div>
</div>
</form>

<!-- Modal Update Summons -->
<form id="updateSummonsForm" action="updateSummons_data.php"  method="POST" >
    <div class="modal fade" id="updateSummonsModal" tabindex="-1" role="dialog" aria-labelledby="updateSummonsModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="form_submitted" value="1">
                    <input type="hidden" id="update_summon_id" name="summon_id">

                    <div class="form-group">
                        <label for="update_vehicleNumPlate">Vehicle Number Plate</label>
                        <input type="text" id="update_vehicleNumPlate" name="vehicleNumPlate" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="update_violation">Violation</label>
                        <select id="update_violation" name="violation" class="form-control" required>
                            <option value="" disabled selected>Select an option</option>
                            <option value="Speeding">Speeding</option>
                            <option value="Not Complying">Not Complying</option>
                            <option value="Accident">Accident</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="update_location">Location</label>
                        <select id="update_location" name="location" class="form-control" required>
                             <option value="A1">B1</option>
                             <option value="A2">B2</option>
                             <option value="A3">B3</option>
                             <option value="A5">M1</option>
                             <option value="B1">B1</option>
                             <option value="B2">B2</option>
                             <option value="B3">B3</option>
                             <option value="M1">M1</option>
                             <option value="M2">M2</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="update_datetime">Date and Time</label>
                        <input type="datetime-local" id="update_datetime" name="datetime" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-success" name="update_summons" value="UPDATE">
                </div>
            </div>
        </div>
    </div>
</form>

</body>



</html>
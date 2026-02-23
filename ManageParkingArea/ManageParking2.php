<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Booking Page</title>
    <style>
        table.center {
          margin-left: auto; 
          margin-right: auto;
        }

        .button-container {
                display: flex;
                justify-content: center;
                margin-top: 5px;
                
            }

            .button-container button {
                margin: 0 10px;
                padding: 10px 10px;
                font-size: 16px;
                background-color:  #17252A;
                color: white;
                font-weight: bold;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }


            .button-container button[type="submit"]:hover {
                background-color: green;
            }

            .button-container button[type="view"] {
                background-color: #0000FF;
                width:70px;
                height:40px;
                margin-right:40px;
                font-weight: normal;
            }

            #list{
                margin-top:30px;

            }
            td{
                justify-content:center;
                text-align:center;
                
            }
            th{
                text-align:center;
            }
            
            .box1 h2{
                float:left;
            }
            .box1 button{
                float:right;
            }

            h6{
                text-align:center;
                color:red;
            }

    </style>
</head>
<body>

    <?php include '../Layout/adminHeader.php'; ?>
    <?php include '../DB_FKPark/dbcon.php'; ?>
    <main>


    <div class="box1" style="display: flex; align-items: center; justify-content:center;padding-top:50px;">
        <h2 style="margin-right:500px;">List of Parking</h2>
        <div class="button-container" >
                    <a href="#" >
                              <button type="submit" class="button btn-primary "data-bs-toggle="modal" data-bs-target="#parkingexampleModal" onclick="generateQR()" >Add New Parking</button>
                          </a>
        </div>
        <div class="button-container">
                        <a href="viewParkingSlot.php" >
                                <button type="submit">View Parking Slot</button>
                        </a>
            </div>
        <div class=" button-container" >
                    <a href="#" >
                              <button type="submit" data-bs-toggle="modal" data-bs-target="#eventexampleModal">Add Event</button>
                          </a>
        </div>

    </div>

    <div id="list">
        <div class="container">
        <table class="table table-hover table-bordered table-striped" >
            <tr>
                <th style="width:280px;">Area</th>
                <th style="width:300px;">Action</th>
                <th style="width:180px;">Status</th>
            </tr>

            <tbody>
            <?php
            $query = "SELECT pa.*, e.event_name FROM `parkingArea` pa LEFT JOIN `event` e ON pa.event_ID = e.event_ID";

            $result = mysqli_query($con, $query);

            if (!$result) {
                die("Query Failed: " . mysqli_error($con));
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td style="padding-top:30px;"><?php echo $row['parkingArea_name']; ?></td>
                        <td style="border-collapse: collapse; display: flex; align-items: center;">
                            <a href="../ManageParkingArea/update_page_1.php?id=<?php echo $row['parkingArea_ID']; ?>" class="btn btn-success" style="margin-right:40px;">Update</a>
                            <a href="../ManageParkingArea/delete_page.php?id=<?php echo $row['parkingArea_ID']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                            <div style="padding-left:20px;" id="imgBox">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=50x50&data=<?php echo urlencode('Parking Area: ' . $row['parkingArea_name'] . '|Event: ' . $row['event_name'] . '|Status: ' . $row['parkingArea_status']); ?>" alt="qrImage">
                        </div>
                        </td>
                        <td style="padding-top:30px;"><?php echo $row['parkingArea_status']; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>

            </tbody>

        </table>

           

        </div>

        <?php
                if(isset($_GET['message'])){
                    echo "<h6>" . $_GET['message'] . "</h6>";
                }
                if(isset($_GET['insert_msg'])){
                    echo "<h6>" . $_GET['insert_msg'] . "</h6>";
                }
                if(isset($_GET['update_msg'])){
                    echo "<h6>" . $_GET['update_msg'] . "</h6>";
                }
                if(isset($_GET['delete_msg'])){
                    echo "<h6>" . $_GET['delete_msg'] . "</h6>";
                }
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

 <!-- Modal -->
 <form action="../DB_FKPark/insert_data.php" method="post" onsubmit="return handleSubmit();">
 <div class="modal fade" id="parkingexampleModal" tabindex="-1" role="dialog" aria-labelledby="parkingexampleModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
  
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" >Add New Parking</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         
        </button>
      </div>
      <div class="modal-body">
        
            <div class="form-group">
            <label for="p_area">Parking Area Name</label>
                <select name="p_area" class="form-control">
                    <option value="B1">B1</option>
                    <option value="B2">B2</option>
                    <option value="B3">B3</option>
                    <option value="M1">M1</option>
                </select>
            </div>
            <!--div class="form-group">
                <label for="p_availability" >Parking Availability</label>
                <input type="text" name="p_availability" class="form-control">
            </div-->
            <div class="form-group">
                <label for="event_name" >Event Name</label>
                <select name="event_name" id="event_name" class="form-control" onchange="updateParkingStatus()">
                    <?php foreach ($events as $event): ?>
                        <option value="<?php echo $event['event_name']; ?>"><?php echo $event['event_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="p_status">Parking Status</label>
                <input type="text" name="p_status" id="p_status" class="form-control" readonly >
            </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-success" name="add_parking" value="ADD">
      </div>
    </div>
  </div>
</div>
</form>

 <!-- Modal -->
 <form action="../DB_FKPark/insert_data.php" method="post">
 <div class="modal fade" id="eventexampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" >Add Event</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         
        </button>
      </div>
      <div class="modal-body">
        
            <div class="form-group">
                <label for="event_name" >Event Name</label>
                <input type="text" name="event_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="event_date" >Event Date</label>
                <input type="date" name="event_date" class="form-control">
            </div>
            <div class="form-group">
                <label for="event_start" >Event Start</label>
                <input type="time" name="event_start" class="form-control">
            </div>
            <div class="form-group">
                <label for="event_end" >Event End</label>
                <input type="time" name="event_end" class="form-control">
            </div>
            <div class="form-group">
                <label for="event_place" >Event Place</label>
                <input type="text" name="event_place" class="form-control">
            </div>
            <div class="form-group">
                <label for="event_description" >Event Description</label>
                <input type="text" name="event_description" class="form-control">
            </div>
                
            
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-success" name="add_event" value="ADD">
      </div>
    </div>
  </div>
</div>
</form>
<script>
  function updateParkingStatus() {
    var eventName = document.getElementById('event_name').value;
    var parkingStatus = document.getElementById('p_status');
    
    if (eventName === 'NO EVENT') {
      parkingStatus.value = 'AVAILABLE';
    } else {
      parkingStatus.value = 'UNAVAILABLE';
    }
  }

  function generateQR(){

    let imgBox = document.getElementById("ImgBox");
    let qrImage = document.getElementById("qrImage");
    
    var eventName = document.getElementById('event_name').value;
    var parkingAreaName = document.querySelector('select[name="p_area"]').value;
    var parkingStatus = document.getElementById('p_status').value;

    var qrText = parkingAreaName + ' ' + eventName + ' ' + parkingStatus;


   imgBox.innerHTML = '<img src="https://api.qrserver.com/v1/create-qr-code/?size=50x50&data=' + encodeURIComponent(qrText) + '" alt="qrImage">';
  }

  // Function to check for duplicate parking names
  function checkDuplicateParking() {
    var selectedParking = document.querySelector('select[name="p_area"]').value;
    var existingParkings = document.querySelectorAll('#list td:first-child');
    for (var i = 0; i < existingParkings.length; i++) {
      if (existingParkings[i].innerText.trim() === selectedParking) {
        alert("Parking area already exists!");
        return false;
      }
    }
    return true;
  }

  // Function to handle form submission
  function handleSubmit() {
    if (checkDuplicateParking()) {
      generateQR();
      return true; // Allow form submission
    } else {
      return false; // Prevent form submission
    }
  }

</script>
</body>


</html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
      background-color: #17252A;
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
      width: 70px;
      height: 40px;
      margin-right: 40px;
      font-weight: normal;
    }

    #list {
      margin-top: 30px;
    }

    td, th {
      text-align: center;
    }

    .box1 h2 {
      float: left;
    }

    .box1 button {
      float: right;
    }

    h6 {
      text-align: center;
      color: red;
    }

    .nav-tabs .nav-link {
      font-weight: bold;
      color: #000;
      border: 1px solid #ccc;
      margin-right: 5px;
      border-radius: 5px;
    }

    .nav-tabs .nav-link.active {
      background-color: #17252A;
      color: white;
    }
  </style>
</head>
<body>
<?php include '../Layout/adminHeader.php'; ?>
<?php include '../DB_FKPark/dbcon.php'; ?>
<main>

<div class="box1" style="display: flex; align-items: center; justify-content:center; padding-top:50px;">
  <h2 style="margin-right:500px;">List of Parking</h2>
  <ul class="nav nav-tabs" id="parkingTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="available-tab" type="button" onclick="filterStatus('AVAILABLE')">Available</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="unavailable-tab" type="button" onclick="filterStatus('UNAVAILABLE')">Unavailable</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="all-tab" type="button" onclick="filterStatus('ALL')">All</button>
    </li>
  </ul>

  <div class="button-container">
    <a href="#">
      <button type="submit" class="button btn-primary" data-bs-toggle="modal" data-bs-target="#parkingexampleModal" onclick="generateQR()">Add New Parking</button>
    </a>
  </div>
</div>

<div id="list">
  <div class="container">
    <table class="table table-hover table-bordered table-striped">
      <thead>
        <tr>
          <th style="width:280px;">Area</th>
          <th style="width:300px;">Action</th>
          <th style="width:180px;">Status</th>
        </tr>
      </thead>
      <tbody id="parkingTable">
        <?php
        $query = "SELECT pa.*, e.event_name FROM `parkingArea` pa LEFT JOIN `event` e ON pa.event_ID = e.event_ID";
        $result = mysqli_query($con, $query);

        if (!$result) {
          die("Query Failed: " . mysqli_error($con));
        } else {
          while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr class="parking-row" data-status="<?php echo $row['parkingArea_status']; ?>">
          <td style="padding-top:30px;"><?php echo $row['parkingArea_name']; ?></td>
          <td style="display: flex; align-items: center;">
            <a href="../ManageParkingArea/update_page_1.php?id=<?php echo $row['parkingArea_ID']; ?>" class="btn btn-success" style="margin-right:40px;">Update</a>
            <a href="../ManageParkingArea/delete_page.php?id=<?php echo $row['parkingArea_ID']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')" style="margin-right:40px;">Delete</a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventexampleModal">Add an Event</button>
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

    <?php
      if (isset($_GET['message'])) echo "<h6>" . $_GET['message'] . "</h6>";
      if (isset($_GET['insert_msg'])) echo "<h6>" . $_GET['insert_msg'] . "</h6>";
      if (isset($_GET['update_msg'])) echo "<h6>" . $_GET['update_msg'] . "</h6>";
      if (isset($_GET['delete_msg'])) echo "<h6>" . $_GET['delete_msg'] . "</h6>";
    ?>
  </div>
</div>

</main>
<?php include '../Layout/allUserFooter.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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

<script>
  function filterStatus(status) {
    const rows = document.querySelectorAll('.parking-row');
    rows.forEach(row => {
      const rowStatus = row.getAttribute('data-status');
      if (status === 'ALL' || rowStatus === status) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });

    // Toggle tab active class manually
    document.querySelectorAll('.nav-link').forEach(tab => tab.classList.remove('active'));
    if (status === 'AVAILABLE') document.getElementById('available-tab').classList.add('active');
    if (status === 'UNAVAILABLE') document.getElementById('unavailable-tab').classList.add('active');
    if (status === 'ALL') document.getElementById('all-tab').classList.add('active');
  }
</script>
</body>
</html>

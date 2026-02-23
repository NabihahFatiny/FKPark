<?php
include '../DB_FKPark/dbh.php';

if (isset($_POST['vehicleNumPlate'])) {
    $vehicleNumPlate = $_POST['vehicleNumPlate'];

    // Prepare a SQL statement to check if the vehicle number plate exists in the database
    $query = "SELECT * FROM vehicle WHERE vehicle_numPlate = '$vehicleNumPlate'";
    $result = mysqli_query($con, $query);

    // Check if the query was executed successfully
    if (!$result) {
        // If there's an error, echo the error message and exit
        echo "Error: " . mysqli_error($con);
        exit();
    }

    // Check if any rows were returned from the query
    if (mysqli_num_rows($result) > 0) {
        // Vehicle number plate exists in the database
        echo "exists";
    } else {
        // Vehicle number plate does not exist in the database
        echo "not exists";
    }
}


?>
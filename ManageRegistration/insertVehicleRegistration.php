<?php

if(isset($POST['submit'])){

    $numPlate = $_POST["vehicle_numPlate"];
    $vehicleType = $_POST["vehicle_type"];
    $brand = $_POST["vehicle_brand"];
    $trans = $_POST["vehicle_transmission"];
    $studentID = isset($_SESSION['student_ID']) ? $_SESSION['student_ID'] : null; // Retrieve student ID from session

    if($numPlate == "" || empty($numPlate)){
        header('location:RegistrationVehicle.php?message=You need to fill this form!');
    }



}

?>
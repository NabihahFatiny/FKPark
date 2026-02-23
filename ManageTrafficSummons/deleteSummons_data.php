<?php
    session_start();

    include '../DB_FKPark/dbh.php';


    if(isset($_GET['summon_ID'])){
        $summon_id = $_GET['summon_ID']; // Get the id from the URL.
        $veh_plate = $_GET['vehicle_numPlate'];

        error_log("summon_ID: " . $summon_id);
        error_log("vehicle_numPlate: " . $veh_plate);

        $querydem = "SELECT `summon_demerit` FROM `summon` WHERE summon_ID = '$summon_id'";
        $getdem = mysqli_query($con, $querydem);
        $current_dem = mysqli_fetch_row($getdem)[0]; // Directly fetch the value


        // Fetch student ID associated with the vehicle
        $querystudentid = "SELECT `student_ID` FROM `vehicle` WHERE vehicle_numPlate = '$veh_plate'";
        $getstid = mysqli_query($con, $querystudentid);
        $student_id = mysqli_fetch_row($getstid)[0]; // Directly fetch the value

        // Update student's demerit total
        $querydemtot = "UPDATE `student` SET `student_demtot` = `student_demtot` - $current_dem WHERE `student_ID` = $student_id";
        $upstdemtot = mysqli_query($con, $querydemtot);
    

        $query = "delete from `summon` where `summon_ID` = '$summon_id'";

        $result = mysqli_query($con, $query);

        if(!$result || !$upstdemtot){
            die("Query Failed".mysqli_error());
        }
        else{
            $_SESSION['del_message'] = "Your data has been deleted successfully!";
            header('location:ManageSummons.php');
            exit();
        }
    }
    else{
        echo "Mak Kau Hijau";
    }

?>
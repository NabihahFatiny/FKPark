<?php
    session_start();

    include '../DB_FKPark/dbh.php';


    if(isset($_POST['form_submitted'])){

        $veh_plate = $_POST['vehicleNumPlate'];
        $up_violation = $_POST['violation'];
        $up_location = $_POST['location'];
        $up_datetime = $_POST['datetime'];
        $summon_id = $_POST['summon_id'];

        $up_summon_demerit = 0;
        if($up_violation == "Speeding")
        {
            $up_summon_demerit = 10;
        } 
        else if ($up_violation === "Not Complying") {
            $up_summon_demerit = 15;
        } 
        else if ($up_violation === "Accident") {
            $up_summon_demerit = 20;
        } 

        $queryolddem = "SELECT `summon_demerit` FROM `summon` WHERE summon_id = '$summon_id'";
        $getolddem = mysqli_query($con, $queryolddem);
        $old_dempoint = mysqli_fetch_row($getolddem)[0];

        // Fetch student ID associated with the vehicle
        $querystudentid = "SELECT `student_ID` FROM `vehicle` WHERE vehicle_numPlate = '$veh_plate'";
        $getstid = mysqli_query($con, $querystudentid);
        $student_id = mysqli_fetch_row($getstid)[0]; // Directly fetch the value

        // Update student's demerit total
        $querydemtot = "UPDATE `student` SET `student_demtot` = `student_demtot` - $old_dempoint + $up_summon_demerit WHERE `student_ID` = $student_id";
        $upstdemtot = mysqli_query($con, $querydemtot);


        if(!$up_violation || !$up_location || !$up_datetime){
            header('location:ManageSummons.php?message=You need to fill in the required information! ');
        }
        else{

            // Perform the database update for parking slot
            $query1 = "UPDATE `summon` SET  `summon_violation` = '$up_violation',
                                            `summon_location` = '$up_location',
                                            `summon_datetime` = '$up_datetime',
                                            `summon_demerit` = '$up_summon_demerit'
                                            
            WHERE `summon_ID` = '$summon_id'"; 

            $result = mysqli_query($con, $query1);
            if(!$result || !$upstdemtot){
                die("Query failed: " . mysqli_error($con));
            }
            else{
                $_SESSION['up_message'] = "Your data has been updated successfully!";
                header('location:ManageSummons.php');
            }

        }


    } else{
        echo "Mak Kau Hijau";
    }

?>
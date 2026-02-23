<?php
    include 'dbcon.php';
    //include '../phpqrcode/qrlib.php';

    if(isset($_POST['add_parking'])){
        
        $p_area = $_POST['p_area'];
        $p_status = $_POST['p_status'];
        $event_name = $_POST['event_name'];

        if($p_area == "" || empty($p_area)){
            header('location:../ManageParkingArea/ManageParking.php?message=You need to fill in the parking area! ');
        }
        else{
            // Fetch event_ID based on event_name
            $eventQuery = "SELECT event_ID FROM event WHERE event_name = '$event_name'";
            $eventResult = mysqli_query($con, $eventQuery);
            if($eventResult && mysqli_num_rows($eventResult) > 0){
                $eventRow = mysqli_fetch_assoc($eventResult);
                $event_ID = $eventRow['event_ID'];

                // Insert the new parking area
                $query = "INSERT INTO `parkingArea` (`parkingArea_name`, `parkingArea_status`, `event_ID`) 
                VALUES ('$p_area', '$p_status', '$event_ID')";
                $result = mysqli_query($con, $query);

                if($result){
                    $parkingArea_ID = mysqli_insert_id($con);

                    // Determine the number of slots and the prefix based on the parking area name
                    $numSlots = ($p_area == 'M1' || $p_area == 'M2') ? 40 : 20;
                    $prefix = $p_area;

                    // Insert the parking slots
                    for ($i = 1; $i <= $numSlots; $i++) {
                        $slotName = $prefix . str_pad($i, 2, '0', STR_PAD_LEFT);
                        $insertSlotQuery = "INSERT INTO parkingSlot (parkingSlot_name, parkingSlot_status, parkingArea_ID) VALUES ('$slotName', '$p_status', $parkingArea_ID)";
                        mysqli_query($con, $insertSlotQuery);
                    }

                    // If the parking area status is 'Unavailable', update all related parking slots
                    if($p_status == 'UNAVAILABLE'){
                        $updateSlotsQuery = "UPDATE parkingSlot SET parkingSlot_status = 'UNAVAILABLE' WHERE parkingArea_ID = $parkingArea_ID";
                        mysqli_query($con, $updateSlotsQuery);
                    }

                    header('location:../ManageParkingArea/ManageParking.php?message=Your data has been added successfully!');
                } else {
                    die("Query Failed" . mysqli_error($con));
                }
            } else {
                die("Event not found: " . mysqli_error($con));
            }
        }
    }

    if(isset($_POST['add_event'])){
        
        $event_name = $_POST['event_name'];
        $event_date = $_POST['event_date'];
        $event_start = $_POST['event_start'];
        $event_end = $_POST['event_end'];
        $event_place = $_POST['event_place'];
        $event_description = $_POST['event_description'];

        $query1 = "INSERT INTO `event` (`event_name`, `event_date`, `event_startTime`, `event_endTime`, `event_place`, `event_description`) 
        VALUES ('$event_name', '$event_date', '$event_start', '$event_end','$event_place','$event_description')";

        $result = mysqli_query($con, $query1);

        if(!$result){
            die("Query Failed" . mysqli_error($con));
        }
        else{
            header('location:../ManageParkingArea/ManageParking.php?message=You event data has been added successfully!');
        }

        //if($event_name == "" || empty($event_name)){
        //  header('location:../ManageParkingArea/ManageParking.php?message=You need to fill in the event detail! ');
        //}

    }
?>

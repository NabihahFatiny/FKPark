<?php
// Connect to the database
$con = mysqli_connect("localhost", "root") or die(mysqli_connect_error());
mysqli_select_db($con, "fkpark") or die(mysqli_error($con));

// Insert data into the event table
$query3 = "INSERT INTO event (event_name, event_date, event_startTime, event_endTime, event_place, event_description) VALUES 
('NO EVENT', '0000-00-00', '00:00:00', '00:00:00', '--', '--'), 
('JAMUAN RAYA', '2005-12-04', '12:00:00', '13:00:00', 'FKOM', 'MAKAN'), 
('MENTOR MENTEE', '2005-07-18', '22:00:00', '23:00:00', 'ASTKAK', 'DISCUSSION')";

$result1 = mysqli_query($con, $query3);

if ($result1) {
    echo "Events inserted successfully<br>";
} else {
    echo "Error inserting events: " . mysqli_error($con) . "<br>";
}

// Retrieve the event_IDs for the newly inserted events
$query_get_event1_id = "SELECT event_ID FROM event WHERE event_name='NO EVENT'";
$query_get_event2_id = "SELECT event_ID FROM event WHERE event_name='JAMUAN RAYA'";
$query_get_event3_id = "SELECT event_ID FROM event WHERE event_name='MENTOR MENTEE'";

$result_event1_id = mysqli_query($con, $query_get_event1_id);
$result_event2_id = mysqli_query($con, $query_get_event2_id);
$result_event3_id = mysqli_query($con, $query_get_event3_id);

$event1_id = mysqli_fetch_assoc($result_event1_id)['event_ID'];
$event2_id = mysqli_fetch_assoc($result_event2_id)['event_ID'];
$event3_id = mysqli_fetch_assoc($result_event3_id)['event_ID'];

// Prepare the base query
$query4 = "
    INSERT INTO parkingArea (parkingArea_name, parkingArea_status, event_ID) VALUES 
    ('A1', 'UNAVAILABLE', $event1_id), 
    ('A2', 'AVAILABLE', $event2_id),
    ('A3', 'AVAILABLE', $event2_id),
    ('A4', 'AVAILABLE', $event2_id),
    ('A5', 'AVAILABLE', $event2_id),
    ('B1', 'AVAILABLE', $event3_id),
    ('B2', 'AVAILABLE', $event2_id),
    ('B3', 'AVAILABLE', $event2_id),
    ('M1', 'AVAILABLE', $event2_id),
    ('M2', 'AVAILABLE', $event2_id)
";

$result2 = mysqli_query($con, $query4);

// Check whether the inserts were successful
if ($result2) {
    echo "Parking data inserted successfully<br>";
} else {
    echo "Error inserting parking data: " . mysqli_error($con) . "<br>";
}

// Retrieve the parkingArea_IDs for the newly inserted parking areas
$parking_areas = ['A1', 'A2', 'A3', 'A4', 'A5', 'B1', 'B2', 'B3', 'M1', 'M2'];
$parking_area_ids = [];

foreach ($parking_areas as $area) {
    $query_get_parking_area_id = "SELECT parkingArea_ID FROM parkingArea WHERE parkingArea_name='$area'";
    $result_parking_area_id = mysqli_query($con, $query_get_parking_area_id);
    $parking_area_ids[$area] = mysqli_fetch_assoc($result_parking_area_id)['parkingArea_ID'];
}

// Function to generate and execute the insert queries for parking slots
function insert_parking_slots($con, $area, $start, $end, $area_id) {
    $values = [];
    for ($i = $start; $i <= $end; $i++) {
        $slot_name = $area . str_pad($i, 3, '0', STR_PAD_LEFT);
        $values[] = "('$slot_name', 'AVAILABLE', $area_id)";
    }
    $values_str = implode(", ", $values);
    $query = "INSERT INTO parkingSlot (parkingSlot_name, parkingSlot_status, parkingArea_ID) VALUES $values_str";
    return mysqli_query($con, $query);
}

// Insert parking slots for each area
$insert_results = [];
$insert_results[] = insert_parking_slots($con, 'A', 101, 120, $parking_area_ids['A1']);
$insert_results[] = insert_parking_slots($con, 'A', 201, 220, $parking_area_ids['A2']);
$insert_results[] = insert_parking_slots($con, 'A', 301, 320, $parking_area_ids['A3']);
$insert_results[] = insert_parking_slots($con, 'A', 401, 420, $parking_area_ids['A4']);
$insert_results[] = insert_parking_slots($con, 'A', 501, 520, $parking_area_ids['A5']);
$insert_results[] = insert_parking_slots($con, 'B', 101, 120, $parking_area_ids['B1']);
$insert_results[] = insert_parking_slots($con, 'B', 201, 220, $parking_area_ids['B2']);
$insert_results[] = insert_parking_slots($con, 'B', 301, 320, $parking_area_ids['B3']);
$insert_results[] = insert_parking_slots($con, 'M', 101, 140, $parking_area_ids['M1']);
$insert_results[] = insert_parking_slots($con, 'M', 201, 240, $parking_area_ids['M2']);

// Check whether the inserts were successful
foreach ($insert_results as $result) {
    if ($result) {
        echo "Parking slots inserted successfully<br>";
    } else {
        echo "Error inserting parking slots: " . mysqli_error($con) . "<br>";
    }
}

mysqli_close($con);
?>

<?php
// Connect to the database
$con = mysqli_connect("localhost", "root") or die(mysqli_connect_error());
mysqli_select_db($con, "fkpark") or die(mysqli_error($con));

// Insert data into the event table
$query1 = "INSERT INTO unitkeselamatanstaff (uk_username, uk_password, uk_email, uk_age) VALUES 
('rahim', '0000', 'rahim@gmail.com', '30'), 
('mutu', '1111', 'mutu@gmail.com', '59')";

$result1 = mysqli_query($con, $query1);

if ($result1) {
    echo "Unit Keselamatan Staff Data inserted successfully<br>";
} else {
    echo "Error inserting events: " . mysqli_error($con) . "<br>";
}

?>
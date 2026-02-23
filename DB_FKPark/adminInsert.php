<?php
// Connect to the database
$con = mysqli_connect("localhost", "root") or die(mysqli_connect_error());
mysqli_select_db($con, "fkpark") or die(mysqli_error($con));

// Insert data into the event table
$query1 = "INSERT INTO administrator (administrator_username, administrator_password, administrator_email, administrator_age) VALUES 
('ali', '0000', 'drali@gmail.com', '40'), 
('koh', '1111', 'drkoh@gmail.com', '32')";

$result1 = mysqli_query($con, $query1);

if ($result1) {
    echo "Admin Data inserted successfully<br>";
} else {
    echo "Error inserting events: " . mysqli_error($con) . "<br>";
}

?>
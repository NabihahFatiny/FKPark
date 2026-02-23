<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "fkpark");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Inserting 10 sets of data into the UnitKeselamatanStaff table
for ($i = 1; $i <= 10; $i++) {
    $username = "staff" . $i;
    $password = "staff123";
    $email = "staff" . $i . "@example.com";
    $age = rand(20, 60); // Random age between 20 and 60

    $queryInsert = "INSERT INTO UnitKeselamatanStaff (uk_username, uk_password, uk_email, uk_age) 
                    VALUES ('$username', '$password', '$email', $age)";

    if (mysqli_query($con, $queryInsert)) {
        echo "<p>Data for unitkeselamatanstaff $username has been inserted successfully!</p>";
    } else {
        echo "<p>Error inserting data for unitkeselamatanstaff $username: " . mysqli_error($con) . "</p>";
    }
}

mysqli_close($con);
?>

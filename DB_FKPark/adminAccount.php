<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "fkpark");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Inserting 10 sets of data into the Administrator table
for ($i = 1; $i <= 10; $i++) {
    $username = "admin" . $i;
    $password = "admin123";
    $email = "admin" . $i . "@example.com";
    $age = rand(20, 60); // Random age between 20 and 60

    $queryInsert = "INSERT INTO Administrator (administrator_username, administrator_password, administrator_email, administrator_age) 
                    VALUES ('$username', '$password', '$email', $age)";

    if (mysqli_query($con, $queryInsert)) {
        echo "<p>Data for administrator $username has been inserted successfully!</p>";
    } else {
        echo "<p>Error inserting data for administrator $username: " . mysqli_error($con) . "</p>";
    }
}

mysqli_close($con);
?>

// Code to verify student login credentials
// Assuming form data is posted and stored in variables like $username and $password

// Establish database connection
<?php

$con = mysqli_connect("localhost", "root", "", "fkpark");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare SQL statement
$sql = "SELECT * FROM Student WHERE student_username = '$username' AND student_password = '$password'";

// Execute SQL statement
$result = mysqli_query($con, $sql);

// Check if a row is returned
if (mysqli_num_rows($result) > 0) {
    // Login successful
    echo "Login successful!";
} else {
    // Login failed
    echo "Incorrect username or password. Please try again.";
}

// Close connection
mysqli_close($con);

?>

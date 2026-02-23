<?php
// config_all.php
// creation of database, table and insert of sample records.

$con = mysqli_connect("localhost", "root", "");
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}
if (mysqli_query($con, "CREATE DATABASE IF NOT EXISTS fkpark")) {
    echo "<br><br>";
    echo "<h3>Database 'fkpark' is ready.</h3>";
} else {
    echo "Error creating database: " . mysqli_error($con);
}

mysqli_close($con);
?>

<?php
// Connect to the database server.
$link = mysqli_connect("localhost", "root", "") or die(mysqli_connect_error());

// Select the database.
mysqli_select_db($link, "fkpark") or die(mysqli_error($link));

// Array containing table names in the order of deletion (child tables first)
$tables = array("summons", "booking", "parkingSlot", "approval", "vehicle", "student", "administrator", "unitKeselamatanStaff", "parkingArea", "event");

// Loop through each table and drop it
foreach ($tables as $table) {
    $strSQL = "DROP TABLE IF EXISTS $table";
    mysqli_query($link, $strSQL) or die(mysqli_error($link));
    echo "<h3>$table table has been deleted !!!</h3>";
}

// Close the database connection
mysqli_close($link);
?>

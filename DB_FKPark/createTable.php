<?php
// config_all.php
// creation of database, table and insert of sample records.

$con = mysqli_connect("localhost", "root", "");
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

mysqli_select_db($con, "fkpark") or die(mysqli_error($con));

// Now create the student table
$query6 = 'CREATE TABLE Student( ' .
          'student_ID INT NOT NULL AUTO_INCREMENT, ' .
          'student_username VARCHAR(100) NOT NULL, ' .
          'student_password VARCHAR(100) NOT NULL, ' .
          'student_email VARCHAR(100) NOT NULL, ' .
          'student_age INT NOT NULL, ' .
          'student_phoneNum VARCHAR(15) NOT NULL, ' .
          'student_gender VARCHAR(10) NOT NULL, ' .
          'student_birthdate DATE NOT NULL, ' .
          'student_profile VARCHAR(255) NOT NULL, ' .
          'student_demtot INT DEFAULT 0, ' .
          'PRIMARY KEY(student_ID)) ENGINE=InnoDB;';

if (mysqli_query($con, $query6)) {
    echo "<h3>Your student table has been created !!!</h3>";
} else {
    echo "<br>";
    echo "Error creating table: " . mysqli_error($con);
}



// Create the event table first
$query1 = 'CREATE TABLE event( ' .
          'event_ID INT NOT NULL AUTO_INCREMENT, ' .
          'event_name VARCHAR(100) NOT NULL, ' .
          'event_date DATE NOT NULL, ' .
          'event_startTime TIME NOT NULL, ' .
          'event_endTime TIME NOT NULL, ' .
          'event_place VARCHAR(100) NOT NULL, ' .
          'event_description VARCHAR(255) NOT NULL, ' .
          'PRIMARY KEY(event_ID))';

if (mysqli_query($con, $query1)) {
    echo "<h3>Your event table has been created !!!</h3>";
} else {
    echo "<br>";
    echo "Error creating table: " . mysqli_error($con);
}

// Now create the parkingArea table with the foreign key
$query2 = 'CREATE TABLE parkingArea( ' .
          'parkingArea_ID INT NOT NULL AUTO_INCREMENT, ' .
          'parkingArea_name VARCHAR(100) NOT NULL, ' .
          'parkingArea_status VARCHAR(100) NOT NULL, ' .
          'parkingArea_qr VARCHAR(100) NOT NULL, ' .
          'event_ID INT, ' .
          'PRIMARY KEY(parkingArea_ID), ' .
          'FOREIGN KEY (event_ID) REFERENCES event(event_ID))';

if (mysqli_query($con, $query2)) {
    echo "<h3>Your parking Area table has been created !!!</h3>";
} else {
    echo "<br>";
    echo "Error creating table: " . mysqli_error($con);
}

// Create the parkingSlot table 
$query10 = 'CREATE TABLE parkingSlot( ' .
          'parkingSlot_ID INT NOT NULL AUTO_INCREMENT, ' .
          'parkingSlot_name VARCHAR(100) NOT NULL, ' .
          'parkingSlot_status VARCHAR(100) NOT NULL, ' .
          'parkingArea_ID INT,'.
          'PRIMARY KEY(parkingSlot_ID), ' .
          'FOREIGN KEY (parkingArea_ID) REFERENCES parkingArea(parkingArea_ID) ON DELETE CASCADE)';

if (mysqli_query($con, $query10)) {
    echo "<h3>Your parking Slot table has been created !!!</h3>";
} else { 
    echo "<br>";
    echo "Error creating table: " . mysqli_error($con);
}


// Now create the booking table with the foreign key
$query3 = 'CREATE TABLE booking( ' .
          'booking_ID INT NOT NULL AUTO_INCREMENT, ' .
          'booking_startTime TIME NOT NULL, ' .
          'booking_endTime TIME NOT NULL, ' .
          'booking_date DATE NOT NULL, ' .
          'booking_QRCode VARCHAR(255) NOT NULL, ' .
          'parkingSlot_ID INT, ' .
          'student_ID INT, ' .
          'PRIMARY KEY(booking_ID), ' .
          'FOREIGN KEY (parkingSlot_ID) REFERENCES parkingSlot(parkingSlot_ID), ' . 
          'FOREIGN KEY (student_ID) REFERENCES student(student_ID) ON DELETE CASCADE ON UPDATE CASCADE)'; 

if (mysqli_query($con, $query3)) {
    echo "<h3>Your booking table has been created !!!</h3>";
} else {
    echo "<br>";
    echo "Error creating table: " . mysqli_error($con);
}


// Now create the administrator table
 $query4 = 'CREATE TABLE Administrator( ' .
          'administrator_ID INT NOT NULL AUTO_INCREMENT, ' .
          'administrator_username VARCHAR(100) NOT NULL, ' .
          'administrator_password VARCHAR(100) NOT NULL, ' .
          'administrator_email VARCHAR(100) NOT NULL, ' .
          'administrator_age INT NOT NULL, ' .
          'PRIMARY KEY(administrator_ID))';

if (mysqli_query($con, $query4)) {
    echo "<h3>Your administrator table has been created !!!</h3>";
} else {
    echo "<br>";
    echo "Error creating table: " . mysqli_error($con);
}

// Now create the unitkeselamatanstaff table
$query5 = 'CREATE TABLE UnitKeselamatanStaff( ' .
          'uk_ID INT NOT NULL AUTO_INCREMENT, ' .
          'uk_username VARCHAR(100) NOT NULL, ' .
          'uk_password VARCHAR(100) NOT NULL, ' .
          'uk_email VARCHAR(100) NOT NULL, ' .
          'uk_age INT NOT NULL, ' .
          'PRIMARY KEY(uk_ID))';

if (mysqli_query($con, $query5)) {
    echo "<h3>Your unitkeselamatanstaff table has been created !!!</h3>";
} else {
    echo "<br>";
    echo "Error creating table: " . mysqli_error($con);
}


// Now create the approval table
$query7 = 'CREATE TABLE approval( ' .
          'approval_ID INT NOT NULL AUTO_INCREMENT, ' .
          'vehicle_grant VARCHAR(100) NOT NULL, ' .
          'approval_status VARCHAR(10) NOT NULL, ' .
          'student_ID INT, ' .
          'PRIMARY KEY(approval_ID), ' .
          'FOREIGN KEY (student_ID) REFERENCES student(student_ID) ON DELETE CASCADE ON UPDATE CASCADE)';

if (mysqli_query($con, $query7)) {
    echo "<h3>Your registration table has been created !!!</h3>";
} else {
    echo "<br>";
    echo "Error creating table: " . mysqli_error($con);
}

// Now create the vehicle table
$query8 = 'CREATE TABLE Vehicle( ' .
          'vehicle_numPlate VARCHAR(10) NOT NULL, ' .
          'vehicle_type VARCHAR(20) NOT NULL, ' .
          'vehicle_brand VARCHAR(50) NOT NULL, ' .
          'vehicle_transmission VARCHAR(20) NOT NULL, ' .
          'vehicle_grant VARCHAR(255), ' .
          'student_ID INT, ' .
          'PRIMARY KEY(vehicle_numPlate), ' .
          'FOREIGN KEY (student_ID) REFERENCES student(student_ID) ON DELETE CASCADE ON UPDATE CASCADE)';

if (mysqli_query($con, $query8)) {
    echo "<h3>Your vehicle table has been created !!!</h3>";
} else {
    echo "<br>";
    echo "Error creating table: " . mysqli_error($con);
} 

// Create the summons table 
$query9 = 'CREATE TABLE summon( ' .
          'summon_ID INT NOT NULL AUTO_INCREMENT, ' .
          'summon_datetime DATETIME NOT NULL, ' .
          'summon_violation VARCHAR(30) NOT NULL, ' .
          'summon_demerit INT NOT NULL, ' .
          'summon_location VARCHAR(100) NOT NULL, ' .
          'summon_QR VARCHAR(255), ' .
          'uk_ID INT NOT NULL, ' .
          'vehicle_numPlate VARCHAR(10) NOT NULL, ' .
          'PRIMARY KEY(summon_ID), ' .
          'FOREIGN KEY (uk_ID) REFERENCES unitKeselamatanStaff(uk_ID), ' . 
          'FOREIGN KEY (vehicle_numPlate) REFERENCES Vehicle(vehicle_numPlate)' .
          ')';

if (mysqli_query($con, $query9)) {
    echo "<h3>Your summon table has been created !!!</h3>";
} else {
    echo "<br>";
    echo "Error creating table: " . mysqli_error($con);
}


mysqli_close($con);
?>

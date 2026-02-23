<?php
/**
 * Empties fkpark (drops all tables) and recreates them. Does NOT drop the database.
 * Open in browser: http://localhost/FKPark/DB_FKPark/migrate_fresh.php
 *
 * WARNING: This deletes ALL data in the fkpark database.
 */
$con = mysqli_connect("localhost", "root", "");
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

// Ensure fkpark exists
mysqli_query($con, "CREATE DATABASE IF NOT EXISTS fkpark");
mysqli_select_db($con, "fkpark") or die(mysqli_error($con));

// 1. Disable foreign key checks so we can drop tables in any order
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");

// 2. Drop every table in the database (get list from MySQL)
$result = mysqli_query($con, "SHOW TABLES");
$dropped = 0;
while ($row = mysqli_fetch_array($result)) {
    $table = $row[0];
    if (mysqli_query($con, "DROP TABLE IF EXISTS `" . mysqli_real_escape_string($con, $table) . "`")) {
        $dropped++;
        echo "<p>Dropped table <strong>{$table}</strong>.</p>";
    }
}

// 3. Turn foreign key checks back on
mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 1");

if ($dropped > 0) {
    echo "<h3>Dropped {$dropped} table(s). Database emptied.</h3>";
} else {
    echo "<h3>Database was already empty.</h3>";
}

// 4. Create all tables (correct order for foreign keys)
$tables = [
    'Student' => 'CREATE TABLE Student( student_ID INT NOT NULL AUTO_INCREMENT, student_username VARCHAR(100) NOT NULL, student_password VARCHAR(100) NOT NULL, student_email VARCHAR(100) NOT NULL, student_age INT NOT NULL, student_phoneNum VARCHAR(15) NOT NULL, student_gender VARCHAR(10) NOT NULL, student_birthdate DATE NOT NULL, student_profile VARCHAR(255) NOT NULL, student_demtot INT DEFAULT 0, PRIMARY KEY(student_ID)) ENGINE=InnoDB',
    'event' => 'CREATE TABLE event( event_ID INT NOT NULL AUTO_INCREMENT, event_name VARCHAR(100) NOT NULL, event_date DATE NOT NULL, event_startTime TIME NOT NULL, event_endTime TIME NOT NULL, event_place VARCHAR(100) NOT NULL, event_description VARCHAR(255) NOT NULL, PRIMARY KEY(event_ID))',
    'parkingArea' => 'CREATE TABLE parkingArea( parkingArea_ID INT NOT NULL AUTO_INCREMENT, parkingArea_name VARCHAR(100) NOT NULL, parkingArea_status VARCHAR(100) NOT NULL, parkingArea_qr VARCHAR(100) NOT NULL, event_ID INT, PRIMARY KEY(parkingArea_ID), FOREIGN KEY (event_ID) REFERENCES event(event_ID))',
    'parkingSlot' => 'CREATE TABLE parkingSlot( parkingSlot_ID INT NOT NULL AUTO_INCREMENT, parkingSlot_name VARCHAR(100) NOT NULL, parkingSlot_status VARCHAR(100) NOT NULL, parkingArea_ID INT, PRIMARY KEY(parkingSlot_ID), FOREIGN KEY (parkingArea_ID) REFERENCES parkingArea(parkingArea_ID) ON DELETE CASCADE)',
    'booking' => 'CREATE TABLE booking( booking_ID INT NOT NULL AUTO_INCREMENT, booking_startTime TIME NOT NULL, booking_endTime TIME NOT NULL, booking_date DATE NOT NULL, booking_QRCode VARCHAR(255) NOT NULL, parkingSlot_ID INT, student_ID INT, PRIMARY KEY(booking_ID), FOREIGN KEY (parkingSlot_ID) REFERENCES parkingSlot(parkingSlot_ID), FOREIGN KEY (student_ID) REFERENCES Student(student_ID) ON DELETE CASCADE ON UPDATE CASCADE)',
    'Administrator' => 'CREATE TABLE Administrator( administrator_ID INT NOT NULL AUTO_INCREMENT, administrator_username VARCHAR(100) NOT NULL, administrator_password VARCHAR(100) NOT NULL, administrator_email VARCHAR(100) NOT NULL, administrator_age INT NOT NULL, PRIMARY KEY(administrator_ID))',
    'UnitKeselamatanStaff' => 'CREATE TABLE UnitKeselamatanStaff( uk_ID INT NOT NULL AUTO_INCREMENT, uk_username VARCHAR(100) NOT NULL, uk_password VARCHAR(100) NOT NULL, uk_email VARCHAR(100) NOT NULL, uk_age INT NOT NULL, PRIMARY KEY(uk_ID))',
    'approval' => 'CREATE TABLE approval( approval_ID INT NOT NULL AUTO_INCREMENT, vehicle_grant VARCHAR(100) NOT NULL, approval_status VARCHAR(10) NOT NULL, student_ID INT, PRIMARY KEY(approval_ID), FOREIGN KEY (student_ID) REFERENCES Student(student_ID) ON DELETE CASCADE ON UPDATE CASCADE)',
    'Vehicle' => 'CREATE TABLE Vehicle( vehicle_numPlate VARCHAR(10) NOT NULL, vehicle_type VARCHAR(20) NOT NULL, vehicle_brand VARCHAR(50) NOT NULL, vehicle_transmission VARCHAR(20) NOT NULL, vehicle_grant VARCHAR(255), student_ID INT, PRIMARY KEY(vehicle_numPlate), FOREIGN KEY (student_ID) REFERENCES Student(student_ID) ON DELETE CASCADE ON UPDATE CASCADE)',
    'summon' => 'CREATE TABLE summon( summon_ID INT NOT NULL AUTO_INCREMENT, summon_datetime DATETIME NOT NULL, summon_violation VARCHAR(30) NOT NULL, summon_demerit INT NOT NULL, summon_location VARCHAR(100) NOT NULL, summon_QR VARCHAR(255), uk_ID INT NOT NULL, vehicle_numPlate VARCHAR(10) NOT NULL, PRIMARY KEY(summon_ID), FOREIGN KEY (uk_ID) REFERENCES UnitKeselamatanStaff(uk_ID), FOREIGN KEY (vehicle_numPlate) REFERENCES Vehicle(vehicle_numPlate))',
];

foreach ($tables as $name => $sql) {
    if (mysqli_query($con, $sql)) {
        echo "<p>Table <strong>{$name}</strong> created.</p>";
    } else {
        echo "<p>Table {$name}: " . mysqli_error($con) . "</p>";
    }
}

mysqli_close($con);
echo "<p><strong>Migration complete.</strong> Fresh tables ready. <a href='../Index/'>Go to FKPark</a></p>";
?>

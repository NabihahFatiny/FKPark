<?php
/**
 * Inserts default login accounts so you can test FKPark.
 * Run AFTER migrate_fresh.php. Open: http://localhost/FKPark/DB_FKPark/seed_default_accounts.php
 */
$con = mysqli_connect("localhost", "root", "", "fkpark");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$ok = 0;

// 1. Administrator (admin)
$q1 = "INSERT INTO Administrator (administrator_username, administrator_password, administrator_email, administrator_age) 
       VALUES ('admin1', 'admin123', 'admin1@example.com', 30)";
if (mysqli_query($con, $q1)) { $ok++; echo "<p>Admin: <b>admin1</b> / <b>admin123</b> (admin1@example.com)</p>"; }
else { echo "<p>Admin: " . mysqli_error($con) . "</p>"; }

// 2. Unit Keselamatan Staff (UK)
$q2 = "INSERT INTO UnitKeselamatanStaff (uk_username, uk_password, uk_email, uk_age) 
       VALUES ('staff1', 'staff123', 'staff1@example.com', 30)";
if (mysqli_query($con, $q2)) { $ok++; echo "<p>UK Staff: <b>staff1</b> / <b>staff123</b> (staff1@example.com)</p>"; }
else { echo "<p>UK Staff: " . mysqli_error($con) . "</p>"; }

// 3. Student (needs: username, password, email, age, phoneNum, gender, birthdate, profile)
$q3 = "INSERT INTO Student (student_username, student_password, student_email, student_age, student_phoneNum, student_gender, student_birthdate, student_profile) 
       VALUES ('student1', 'student123', 'student1@example.com', 20, '0123456789', 'Male', '2004-01-01', 'default.png')";
if (mysqli_query($con, $q3)) { $ok++; echo "<p>Student: <b>student1</b> / <b>student123</b> (student1@example.com)</p>"; }
else { echo "<p>Student: " . mysqli_error($con) . "</p>"; }

mysqli_close($con);
echo "<p><strong>Done.</strong> $ok default account(s) added. You can login at <a href='../Manage Login/Login.php'>Login</a>.</p>";
?>

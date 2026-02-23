<?php
/**
 * Creates empty databases: classconnect, nilamfyp, personal-portfolio
 * Open in browser: http://localhost/FKPark/DB_FKPark/create_my_databases.php
 */
$con = mysqli_connect("localhost", "root", "");
if (!$con) {
    die("<p>Cannot connect to MySQL. Start MySQL in XAMPP first.</p>");
}

$databases = [
    'classconnect',
    'nilamfyp',
    'personal-portfolio'  // MySQL allows hyphen when name is in backticks
];

echo "<h2>Creating databases</h2><ul>";
foreach ($databases as $db) {
    $sql = "CREATE DATABASE IF NOT EXISTS `" . mysqli_real_escape_string($con, $db) . "`";
    if (mysqli_query($con, $sql)) {
        echo "<li><strong>$db</strong> – created (or already exists).</li>";
    } else {
        echo "<li><strong>$db</strong> – error: " . mysqli_error($con) . "</li>";
    }
}
echo "</ul>";
mysqli_close($con);
echo "<p>Done. You can use these databases in phpMyAdmin or in your projects.</p>";
?>

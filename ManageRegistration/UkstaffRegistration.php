<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StudentRegistration.css">
    <title>Unit Keselamatan Staff Registration</title>
</head>
<body>
    <?php include '../Layout/adminHeader.php'; ?>
    <?php include '../DB_FKPark/dbcon.php'; ?>

    
    <main>
        <div class="container-registration">
            <h2 class="title-registration">Unit Keselamatan Staff Registration</h2>
            <form class="form-card" method="post" action="StudentRegistration.php" enctype="multipart/form-data">
                <table class="form-table">
                    <tr>
                        <td><label for="name">Username</label></td>
                        <td><input type="text" id="name" name="Name" class="form-control" placeholder="Enter username" required></td>
                    </tr>
                    <tr>
                        <td><label for="password">Password</label></td>
                        <td><input type="password" id="password" name="Password" class="form-control" placeholder="Enter password" required></td>
                    </tr>
                    <tr>
                        <td><label for="email">Email</label></td>
                        <td><input type="email" id="email" name="Email" class="form-control" placeholder="Enter email" required></td>
                    </tr>
                    <tr>
                        <td><label for="age">Age</label></td>
                        <td><input type="number" id="age" name="Age" class="form-control" placeholder="Enter age" required></td>
                    </tr>
                
                    <tr>
                        <td colspan="2"><button type="submit" class="btn btn-primary">Submit</button></td>
                    </tr>
                </table>
            </form>
        </div>
    </main>

    <?php include '../Layout/allUserFooter.php'; ?>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = mysqli_connect("localhost", "root", "");
    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    mysqli_select_db($con, "fkpark") or die(mysqli_error($con));

    $username = $_POST["Name"];
    $password = $_POST["Password"];
    $email = $_POST["Email"];
    $age = $_POST["Age"];

    // Insert form data into the database
    $strSQL = "INSERT INTO UnitKeselamatanStaff(uk_username, uk_password, uk_email, uk_age) VALUES('$username','$password','$email','$age')";

    if (mysqli_query($con, $strSQL)) {
        echo "<script>alert('Registration successful!');</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>


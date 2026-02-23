<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="StudentRegistration.css">
    <title>Student Registration</title>
</head>

<body>
    <?php include '../Layout/adminHeader.php'; ?>

    <main>
        <div class="container-registration">
            <h2 class="title-registration">Student Registration</h2>
            <form class="form-card" method="post" action="StudentRegistration.php" enctype="multipart/form-data">
                <table class="form-table">
                    <tr>
                        <td><label for="name">Username</label></td>
                        <td><input type="text" id="name" name="Name" class="form-control" placeholder="Enter student username" pattern="[A-Za-z]+" title="Only letters are allowed" required>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="password">Password</label></td>
                        <td><input type="password" id="password" name="Password" class="form-control" placeholder="Enter student password" minlength="7" required>

                        </td>
                    </tr>
                    <tr>
                        <td><label for="email">Email</label></td>
                        <td><input type="email" id="email" name="Email" class="form-control" placeholder="Enter student email" required></td>
                    </tr>
                    <tr>
                        <td><label for="age">Age</label></td>
                        <td><input type="number" id="age" name="Age" class="form-control" placeholder="Enter student age" required></td>
                    </tr>
                    <tr>
                        <td><label for="phoneNum">Phone Number</label></td>
                        <td><input type="text" id="phoneNum" name="PhoneNum" class="form-control" placeholder="Enter student phone number" required></td>
                    </tr>
                    <tr>
                        <td><label for="gender">Gender</label></td>
                        <td>
                            <input type="radio" id="male" name="Gender" value="Male" required>
                            <label for="male">Male</label>
                            <input type="radio" id="female" name="Gender" value="Female" required>
                            <label for="female">Female</label>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="birthdate">Birthdate</label></td>
                        <td><input type="date" id="birthdate" name="Birthdate" class="form-control" placeholder="Enter student birthdate" required></td>
                    </tr>
                    <tr>
                        <td><label for="profile">Profile picture</label></td>
                        <td><input type="file" id="profile" name="Profile" class="form-control" accept="image/*" required></td>
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
    if (!preg_match("/^[a-zA-Z]+$/", $username)) {
        echo "<script>alert('Username must contain only letters.');</script>";
        exit;
    }
    $password = $_POST["Password"];
    // Server-side password length check
    if (strlen($password) < 6) {
        echo "<script>alert('Password is too short. It must be at least 6 characters.');</script>";
        exit;
    }
    $email = $_POST["Email"];
    $age = $_POST["Age"];
    $phoneNum = $_POST["PhoneNum"];
    $gender = $_POST["Gender"];
    $birthdate = $_POST["Birthdate"];

    // Handle file upload
    $profile = $_FILES["Profile"];
    $profileName = basename($profile["name"]);
    $targetDir = "uploads/";
    $targetFilePath = $targetDir . $profileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array($fileType, $allowTypes)) {
        // Upload file to server
        if (move_uploaded_file($profile["tmp_name"], $targetFilePath)) {
            // Insert form data into the database
            $strSQL = "INSERT INTO student(student_username, student_password, student_email, student_age, student_phoneNum, student_gender, student_birthdate, student_profile) VALUES('$username','$password','$email','$age','$phoneNum','$gender','$birthdate','$targetFilePath')";

            if (mysqli_query($con, $strSQL)) {
                echo "<script>alert('Registration successful!');</script>";
            } else {
                echo "Error: " . mysqli_error($con);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed.";
    }

    mysqli_close($con);
}

?>
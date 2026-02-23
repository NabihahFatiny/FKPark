<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $con = mysqli_connect("localhost", "root", "", "fkpark");

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Determine user type based on which ID field was submitted
    if (isset($_POST['student_ID'])) {
        // STUDENT UPDATE
        $id = $_POST['student_ID'];
        $username = mysqli_real_escape_string($con, $_POST['student_username']);
        $password = mysqli_real_escape_string($con, $_POST['student_password']);
        $email = mysqli_real_escape_string($con, $_POST['student_email']);
        $age = intval($_POST['student_age']);
        $phoneNum = mysqli_real_escape_string($con, $_POST['student_phoneNum']);
        $gender = mysqli_real_escape_string($con, $_POST['student_gender']);
        $birthdate = mysqli_real_escape_string($con, $_POST['student_birthdate']);

        // Handle file upload
        $profile = $_POST['current_profile']; // Default to current
        if (isset($_FILES['student_profile']) && $_FILES['student_profile']['error'] === UPLOAD_ERR_OK) {
            $profile = $_FILES['student_profile']['name'];
            move_uploaded_file($_FILES['student_profile']['tmp_name'], "../ManageRegistration/uploads/$profile");
        }

        $query = "UPDATE `student` SET 
            `student_username`='$username', 
            `student_password`='$password', 
            `student_email`='$email', 
            `student_age`='$age', 
            `student_phoneNum`='$phoneNum', 
            `student_gender`='$gender', 
            `student_birthdate`='$birthdate', 
            `student_profile`='$profile' 
            WHERE `student_ID`='$id'";

        $redirect = 'StudProfile.php';
    } elseif (isset($_POST['administrator_ID'])) {
        // ADMIN UPDATE
        $id = $_POST['administrator_ID'];
        $username = mysqli_real_escape_string($con, $_POST['administrator_username']);
        $password = mysqli_real_escape_string($con, $_POST['administrator_password']);
        $email = mysqli_real_escape_string($con, $_POST['administrator_email']);
        $age = intval($_POST['administrator_age']);

        $query = "UPDATE `administrator` SET 
            `administrator_username`='$username', 
            `administrator_password`='$password', 
            `administrator_email`='$email', 
            `administrator_age`='$age'
            WHERE `administrator_ID`='$id'";

        $redirect = 'AdminProfile.php';
    } elseif (isset($_POST['uk_ID'])) {
        // UK STAFF UPDATE
        $id = $_POST['uk_ID'];
        $username = mysqli_real_escape_string($con, $_POST['uk_username']);
        $password = mysqli_real_escape_string($con, $_POST['uk_password']);
        $email = mysqli_real_escape_string($con, $_POST['uk_email']);
        $age = intval($_POST['uk_age']);

        $query = "UPDATE `unitkeselamatanstaff` SET 
            `uk_username`='$username', 
            `uk_password`='$password', 
            `uk_email`='$email', 
            `uk_age`='$age'
            WHERE `uk_ID`='$id'";

        $redirect = 'UKProfile.php';
    } else {
        $_SESSION['error'] = "Invalid user type";
        header("Location: index.php");
        exit();
    }

    if (mysqli_query($con, $query)) {
        $_SESSION['message'] = 'Profile updated successfully';
    } else {
        $_SESSION['error'] = "Error updating profile: " . mysqli_error($con);
    }

    mysqli_close($con);
    header("Location: $redirect");
    exit();
} else {
    header("Location: index.php");
    exit();
}

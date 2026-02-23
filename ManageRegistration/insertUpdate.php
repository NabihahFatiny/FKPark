<?php 
include '../DB_FKPark/dbcon.php';

if(isset($_POST['save_changes'])){ // Ensure this matches the name attribute of your form's submit button

    $student_username = $_POST['student_username'];
    $student_password = $_POST['student_password'];
    $student_email = $_POST['student_email'];
    $student_age = $_POST['student_age'];
    $student_phoneNum = $_POST['student_phoneNum'];
    $student_gender = $_POST['student_gender'];
    $student_birthdate = $_POST['student_birthdate'];
    $student_profile = $_POST['student_profile']; // Missing semicolon added here
    
    if($student_username == "" || empty($student_username)){
        header('location:viewRegistration.php?message=You need to fill username!');
        exit();
    } else {
        // Using a prepared statement
        $query = "INSERT INTO `student` (`student_username`, `student_password`, `student_email`, `student_age`, `student_phoneNum`, `student_gender`, `student_birthdate`, `student_profile`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $query);
        
        if ($stmt === false) {
            die("Prepare statement failed: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "sssiisss", $username, $password, $email, $age, $phoneNum, $gender, $birthdate, $targetFilePath);
        
        $result = mysqli_stmt_execute($stmt);

        if(!$result){
            die("Query Failed: " . mysqli_stmt_error($stmt)); // Changed to mysqli_stmt_error to get error from statement
        } else {
            header('location:viewRegistration.php?insert_msg=Your data has been updated successfully');
            exit();
        }

        mysqli_stmt_close($stmt); // Close the statement after execution
    }
}
?>

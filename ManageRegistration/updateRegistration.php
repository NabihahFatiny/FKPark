<?php include '../Layout/adminHeader.php'; ?>
<?php include '../DB_FKPark/dbcon.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<?php
if (isset($_GET['student_ID'])) {
    $student_ID = $_GET['student_ID'];

    $query = "SELECT * FROM student WHERE student_ID = '$student_ID'";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query failed:".mysqli_error($con));
    } else {
        $row = mysqli_fetch_assoc($result);
    }
}
?>

<?php
if (isset($_POST['saves_changes'])) {

    if(isset($_GET['student_ID_new'])){
        $student_ID_new = $_GET['student_ID_new'];
    }

    $username = $_POST['student_username'];
    $password = $_POST['student_password'];
    $email = $_POST['student_email'];
    $age = $_POST['student_age'];
    $phoneNum = $_POST['student_phoneNum'];
    $gender = $_POST['student_gender'];
    $birthdate = $_POST['student_birthdate'];
    $targetFilePath = $_POST['student_profile'];

    $updateQuery = "UPDATE student SET 
                    student_username = '$username', 
                    student_password = '$password', 
                    student_email = '$email', 
                    student_age = '$age', 
                    student_phoneNum = '$phoneNum', 
                    student_gender = '$gender', 
                    student_birthdate = '$birthdate', 
                    student_profile = '$targetFilePath' 
                    WHERE student_ID = '$student_ID_new'";

    $updateResult = mysqli_query($con, $updateQuery);

    if (!$updateResult) {
        die("Query failed:".mysqli_error($con));
    } else {
            header('location:viewRegistration.php?update_msg=Your data has updated successfully');
        exit;
    }
}
?>

        <!-- Modal -->
        <form action="viewRegistration.php?student_ID_new=<?php echo $student_ID; ?>" method="post">

        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Student Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateForm" method="post" action="viewRegistration.php">
                            <input type="hidden" id="updateStudentId" name="student_ID">
                            <div class="mb-3">
                                <label for="updateUsername" class="form-label">Username</label>
                                <input type="text" class="form-control" id="updateUsername" name="student_username" required>
                            </div>
                            <div class="mb-3">
                                <label for="updatePassword" class="form-label">Password</label>
                                <input type="text" class="form-control" id="updatePassword" name="student_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="updateEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="updateEmail" name="student_email" required>
                            </div>
                            <div class="mb-3">
                                <label for="updateAge" class="form-label">Age</label>
                                <input type="number" class="form-control" id="updateAge" name="student_age" required>
                            </div>
                            <div class="mb-3">
                                <label for="updatePhoneNumber" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="updatePhoneNumber" name="student_phoneNum" required>
                            </div>
                            <div class="mb-3">
                                <label for="updateGender" class="form-label">Gender</label>
                                <input type="text" class="form-control" id="updateGender" name="student_gender" required>
                            </div>
                            <div class="mb-3">
                                <label for="updateBirthday" class="form-label">Birthday</label>
                                <input type="date" class="form-control" id="updateBirthday" name="student_birthdate" required>
                            </div>
                            <div class="mb-3">
                                <label for="updateProfilePicture" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" accept="image/*" id="updateProfilePicture" name="student_profile" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="saves_changes" value="submit">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </form>

<?php include '../Layout/allUserFooter.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

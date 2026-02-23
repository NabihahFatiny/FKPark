<?php
include '../DB_FKPark/dbcon.php';

ob_start();

// Display messages if any
if (isset($_GET['message'])) {
    echo "<h6>" . htmlspecialchars($_GET['message']) . "</h6>";
}

if (isset($_GET['insert_msg'])) {
    echo "<h6>" . htmlspecialchars($_GET['insert_msg']) . "</h6>";
}

// Handle form submission for updating student info
if (isset($_POST['save_changes'])) {
    $id = $_POST['student_ID'];
    $username = $_POST['student_username'];
    $password = $_POST['student_password'];
    $email = $_POST['student_email'];
    $age = $_POST['student_age'];
    $phoneNum = $_POST['student_phoneNum'];
    $gender = $_POST['student_gender'];
    $birthdate = $_POST['student_birthdate'];
    $profile = $_POST['student_profile'];

    // Handle file upload if a new profile picture is provided
    if (isset($_FILES['student_profile']) && $_FILES['student_profile']['size'] > 0) {
        $profile = 'uploads/' . basename($_FILES['student_profile']['name']);
        if (!move_uploaded_file($_FILES['student_profile']['tmp_name'], $profile)) {
            echo "Error uploading file.";
            exit;
        }
    }

    $query = "UPDATE student SET student_username=?, student_password=?, student_email=?, student_age=?, student_phoneNum=?, student_gender=?, student_birthdate=?, student_profile=? WHERE student_ID=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'sssiisssi', $username, $password, $email, $age, $phoneNum, $gender, $birthdate, $profile, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: viewRegistration.php?message=Record updated successfully");
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
}

// Handle deletion of student
if (isset($_GET['delete_student_id'])) {
    $studentId = $_GET['delete_student_id'];

    // Prepare the delete query
    $query = "DELETE FROM student WHERE student_ID = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'i', $studentId);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: viewRegistration.php?message=Record deleted successfully");
        ob_end_flush();
        exit;
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
}

// Fetch students to display
$query = "SELECT * FROM student";
$result = mysqli_query($con, $query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>List of Registration</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
        }
        footer {
            background: #333;
            color: #fff;
            padding: 20px 0;
            margin-top: auto;
        }
        footer .container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        footer .container div {
            flex: 1;
            padding: 0 20px;
            text-align: center;
        }
        footer h5 {
            margin-top: 0;
        }
        footer ul {
            list-style: none;
            padding: 0;
        }
        footer ul li {
            margin: 5px 0;
        }
        footer ul li a {
            color: #fff;
            text-decoration: none;
        }
        footer ul li a:hover {
            text-decoration: underline;
        }
        .view-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include '../Layout/adminHeader.php'; ?>

    <main>
        <h1 id="main_title">List Of Registration</h1>

        <div class="view-container">
            <div class="d-flex justify-content-end mb-3">
                <a href="StudentRegistration.php" class="btn btn-primary">REGISTER</a>
            </div>

            <table class="table table-hover table-bordered table-striped">
                <thead>
                    <tr class="view-table-header">
                        <th>Student ID</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Phone Number</th>
                        <th>Gender</th>
                        <th>Birthdate</th>
                        <th>Profile Picture</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$result) {
                        die("Query failed: " . mysqli_error($con));
                    } else {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr id="student-<?php echo htmlspecialchars($row['student_ID']); ?>">
                        <td><?php echo htmlspecialchars($row['student_ID']); ?></td>
                        <td><?php echo htmlspecialchars($row['student_username']); ?></td>
                        <td><?php echo htmlspecialchars($row['student_password']); ?></td>
                        <td><?php echo htmlspecialchars($row['student_email']); ?></td>
                        <td><?php echo htmlspecialchars($row['student_age']); ?></td>
                        <td><?php echo htmlspecialchars($row['student_phoneNum']); ?></td>
                        <td><?php echo htmlspecialchars($row['student_gender']); ?></td>
                        <td><?php echo htmlspecialchars($row['student_birthdate']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($row['student_profile']); ?>" alt="Student Profile" width="100"></td>
                        <td><button type="button" class="btn btn-success update-button" data-id="<?php echo htmlspecialchars($row['student_ID']); ?>" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button></td>
                        <td><a href="viewRegistration.php?delete_student_id=<?php echo htmlspecialchars($row['student_ID']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Student Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateForm" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="updateStudentId" name="student_ID">
                            <div class="mb-3">
                                <label for="updateUsername" class="form-label">Username</label>
                                <input type="text" class="form-control" placeholder="Enter username" id="updateUsername" name="student_username" required>
                            </div>
                            <div class="mb-3">
                                <label for="updatePassword" class="form-label">Password</label>
                                <input type="text" class="form-control" placeholder="Enter password" id="updatePassword" name="student_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="updateEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="Enter email" id="updateEmail" name="student_email" required>
                            </div>
                            <div class="mb-3">
                                <label for="updateAge" class="form-label">Age</label>
                                <input type="number" class="form-control" placeholder="Enter age" id="updateAge" name="student_age" required>
                            </div>
                            <div class="mb-3">
                                <label for="updatePhoneNumber" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" placeholder="Enter phone number" id="updatePhoneNumber" name="student_phoneNum" required>
                            </div>
                            <div class="mb-3">
                                <label for="updateGender" class="form-label">Gender</label>
                                <input type="text" class="form-control" placeholder="Enter gender" id="updateGender" name="student_gender" required>
                            </div>
                            <div class="mb-3">
                                <label for="updateBirthdate" class="form-label">Birthdate</label>
                                <input type="date" class="form-control" id="updateBirthdate" name="student_birthdate" required>
                            </div>
                            <div class="mb-3">
                                <label for="updateProfilePicture" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" id="updateProfilePicture" name="student_profile">
                            </div>
                            <button type="submit" class="btn btn-primary" name="save_changes">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include '../Layout/allUserFooter.php'; ?>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.update-button').click(function() {
                var studentId = $(this).data('id');

                // Fetch student details from the table row
                var row = $('#student-' + studentId);
                var username = row.find('td:eq(1)').text();
                var password = row.find('td:eq(2)').text();
                var email = row.find('td:eq(3)').text();
                var age = row.find('td:eq(4)').text();
                var phoneNum = row.find('td:eq(5)').text();
                var gender = row.find('td:eq(6)').text();
                var birthdate = row.find('td:eq(7)').text();

                // Set values in the modal form
                $('#updateStudentId').val(studentId);
                $('#updateUsername').val(username);
                $('#updatePassword').val(password);
                $('#updateEmail').val(email);
                $('#updateAge').val(age);
                $('#updatePhoneNumber').val(phoneNum);
                $('#updateGender').val(gender);
                $('#updateBirthdate').val(birthdate);
            });
        });
    </script>
</body>
</html>

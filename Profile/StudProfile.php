<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "fkpark");

// Check messages
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            ' . $_SESSION['error'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    unset($_SESSION['error']);
}

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            ' . $_SESSION['message'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    unset($_SESSION['message']);
}

// Check if user is logged in
$studentID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
if ($studentID === null) {
    die('Student ID not found in session. Please login again.');
}

// Fetch student data
$query = "SELECT * FROM student WHERE student_ID = $studentID";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

$cacheBuster = time();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Student Profile</title>
    <style>
        /* Your existing CSS styles */
        body {
            background-color: #f8f9fa;
        }

        .profile-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
            margin: 0 auto 20px;
            display: block;
        }

        .profile-info p {
            margin-bottom: 10px;
            padding: 8px 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .profile-info b {
            color: #000;
            width: 150px;
            display: inline-block;
        }

        /* Keep all your existing styles */
    </style>
</head>

<body>
    <?php include '../Layout/studentHeader.php'; ?>

    <div class="container">
        <div class="profile-container">
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a href="#profile" class="nav-link active" data-bs-toggle="tab">Profile</a>
                </li>
                <li class="nav-item">
                    <a href="#editProfile" class="nav-link" data-bs-toggle="tab">Edit Profile</a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Profile Tab -->
                <div class="tab-pane container active" id="profile">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="text-center mb-4">
                            <h3 class="profile-header">Student Profile</h3>
                            <img src="../ManageRegistration/<?= htmlspecialchars($row['student_profile']); ?>?<?= $cacheBuster ?>" alt="Profile Picture" class="profile-picture">
                        </div>

                        <div class="profile-info">
                            <p><b>Student ID:</b> <?= htmlspecialchars($row['student_ID']); ?></p>
                            <p><b>Name:</b> <?= htmlspecialchars($row['student_username']); ?></p>
                            <p><b>Email:</b> <?= htmlspecialchars($row['student_email']); ?></p>
                            <p><b>Age:</b> <?= htmlspecialchars($row['student_age']); ?></p>
                            <p><b>Phone Number:</b> <?= htmlspecialchars($row['student_phoneNum']); ?></p>
                            <p><b>Gender:</b> <?= htmlspecialchars($row['student_gender']); ?></p>
                            <p><b>Birthdate:</b> <?= htmlspecialchars($row['student_birthdate']); ?></p>
                        </div>
                    <?php } ?>
                </div>

                <!-- Edit Profile Tab -->
                <div class="tab-pane container fade" id="editProfile">
                    <?php mysqli_data_seek($result, 0);
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="text-center mb-4">
                            <h3 class="profile-header">Edit Profile</h3>
                        </div>

                        <form method="POST" action="update_profile.php" enctype="multipart/form-data" id="profileForm">
                            <input type="hidden" name="student_ID" value="<?= htmlspecialchars($row['student_ID']); ?>">

                            <div class="text-center mb-4">
                                <img src="../ManageRegistration/<?= htmlspecialchars($row['student_profile']); ?>?<?= $cacheBuster ?>" alt="Profile Picture" class="profile-picture" id="profileImagePreview">
                                <div class="file-input-wrapper">
                                    <label for="student_profile" class="file-input-label">Change Profile Picture</label>
                                    <input type="file" class="form-control" id="student_profile" name="student_profile" accept="image/*">
                                    <input type="hidden" name="current_profile" value="<?= htmlspecialchars($row['student_profile']); ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="student_username" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="student_username" name="student_username" value="<?= htmlspecialchars($row['student_username']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="student_password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="student_password" name="student_password" value="<?= htmlspecialchars($row['student_password']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="student_email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="student_email" name="student_email" value="<?= htmlspecialchars($row['student_email']); ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="student_age" class="form-label">Age</label>
                                        <input type="number" class="form-control" id="student_age" name="student_age" value="<?= htmlspecialchars($row['student_age']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="student_phoneNum" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="student_phoneNum" name="student_phoneNum" value="<?= htmlspecialchars($row['student_phoneNum']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="student_gender" class="form-label">Gender</label>
                                        <select class="form-control" id="student_gender" name="student_gender">
                                            <option value="Male" <?= $row['student_gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                                            <option value="Female" <?= $row['student_gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="student_birthdate" class="form-label">Birthdate</label>
                                        <input type="date" class="form-control" id="student_birthdate" name="student_birthdate" value="<?= htmlspecialchars($row['student_birthdate']); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <button type="button" class="btn btn-secondary" onclick="window.location.reload();">Cancel</button>
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php include '../Layout/allUserFooter.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preview image before upload
        document.getElementById('student_profile').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('profileImagePreview').src = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>
<?php mysqli_close($con); ?>
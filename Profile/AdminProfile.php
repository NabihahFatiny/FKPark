<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "fkpark");

// Check if the user is logged in and the user ID is set in the session
$administratorID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

// If the administrator ID is not set, redirect to the login page
if ($administratorID === null) {
    die('Administrator ID not found in session. Please login again.');
}

// Fetching all administrator data
$query = "SELECT * FROM administrator WHERE administrator_ID = $administratorID";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

// Add cache buster to profile image URL
$cacheBuster = time();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Profile</title>
    <style>
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

        .profile-info {
            margin-bottom: 20px;
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

        .nav-tabs .nav-link {
            color: #495057;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active {
            color: #007bff;
            font-weight: bold;
            border-bottom: 3px solid #007bff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
        }

        .btn-group {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .file-input-wrapper {
            max-width: 300px;
            margin: 0 auto;
        }

        .file-input-label {
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <?php include '../Layout/adminHeader.php'; ?>
    <?php include '../DB_FKPark/dbcon.php'; ?>

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
                    <?php
                    // Reset pointer to first record
                    mysqli_data_seek($result, 0);
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="text-center mb-4">
                            <h3 class="profile-header">Administrator Profile</h3>
                        </div>

                        <div class="profile-info">
                            <p><b>Administrator ID:</b> <?= htmlspecialchars($row['administrator_ID']); ?></p>
                            <p><b>Name:</b> <?= htmlspecialchars($row['administrator_username']); ?></p>
                            <p><b>Password:</b> <?= htmlspecialchars($row['administrator_password']); ?></p>
                            <p><b>Email:</b> <?= htmlspecialchars($row['administrator_email']); ?></p>
                            <p><b>Age:</b> <?= htmlspecialchars($row['administrator_age']); ?></p>
                        </div>
                    <?php } ?>
                </div>

                <!-- Edit Profile Tab -->
                <div class="tab-pane container fade" id="editProfile">
                    <?php
                    // Reset result pointer and fetch data again
                    mysqli_data_seek($result, 0);
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="text-center mb-4">
                            <h3 class="profile-header">Edit Profile</h3>
                        </div>

                        <form method="POST" action="update_profile.php" enctype="multipart/form-data" id="profileForm">
                            <input type="hidden" name="administrator_ID" value="<?= htmlspecialchars($row['administrator_ID']); ?>">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="administrator_username" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="administrator_username" name="administrator_username" value="<?= htmlspecialchars($row['administrator_username']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="administrator_password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="administrator_password" name="administrator_password" value="<?= htmlspecialchars($row['administrator_password']); ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="administrator_email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="administrator_email" name="administrator_email" value="<?= htmlspecialchars($row['administrator_email']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="administrator_age" class="form-label">Age</label>
                                        <input type="number" class="form-control" id="administrator_age" name="administrator_age" value="<?= htmlspecialchars($row['administrator_age']); ?>">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // Force page reload after form submission
        document.getElementById('profileForm').addEventListener('submit', function() {
            setTimeout(function() {
                window.location.reload(true);
            }, 1000);
        });
    </script>
</body>

</html>

<?php mysqli_close($con); ?>
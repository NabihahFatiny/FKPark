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
$uk_ID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
if ($uk_ID === null) {
    die('UK Staff ID not found in session. Please login again.');
}

// Fetch UK staff data
$query = "SELECT * FROM unitkeselamatanstaff WHERE uk_ID = $uk_ID";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>UK Staff Profile</title>
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
    <?php include '../Layout/UKHeader.php'; ?>

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
                            <h3 class="profile-header">UK Staff Profile</h3>
                        </div>

                        <div class="profile-info">
                            <p><b>Staff ID:</b> <?= htmlspecialchars($row['uk_ID']); ?></p>
                            <p><b>Name:</b> <?= htmlspecialchars($row['uk_username']); ?></p>
                            <p><b>Email:</b> <?= htmlspecialchars($row['uk_email']); ?></p>
                            <p><b>Age:</b> <?= htmlspecialchars($row['uk_age']); ?></p>
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

                        <form method="POST" action="update_profile.php" id="profileForm">
                            <input type="hidden" name="uk_ID" value="<?= htmlspecialchars($row['uk_ID']); ?>">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="uk_username" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="uk_username" name="uk_username" value="<?= htmlspecialchars($row['uk_username']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="uk_password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="uk_password" name="uk_password" value="<?= htmlspecialchars($row['uk_password']); ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="uk_email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="uk_email" name="uk_email" value="<?= htmlspecialchars($row['uk_email']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="uk_age" class="form-label">Age</label>
                                        <input type="number" class="form-control" id="uk_age" name="uk_age" value="<?= htmlspecialchars($row['uk_age']); ?>">
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
</body>

</html>
<?php mysqli_close($con); ?>
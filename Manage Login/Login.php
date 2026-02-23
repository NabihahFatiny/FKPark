<?php
session_start();

$con = mysqli_connect("localhost", "root", "");
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

mysqli_select_db($con, "fkpark") or die(mysqli_error($con));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check the role and select the corresponding table
    switch ($role) {
        case 'Student':
            $table = 'Student';
            $userColumn = 'student_username';
            $passColumn = 'student_password';
            $idColumn = 'student_ID';
            $homePage = '../Home/studentHomePage.php';
            break;
        case 'Administrator':
            $table = 'Administrator';
            $userColumn = 'administrator_username';
            $passColumn = 'administrator_password';
            $idColumn = 'administrator_ID';
            $homePage = '../Home/adminHomePage.php';
            break;
        case 'UnitKeselamatanStaff':
            $table = 'UnitKeselamatanStaff';
            $userColumn = 'uk_username';
            $passColumn = 'uk_password';
            $idColumn = 'uk_ID';
            $homePage = '../Home/ukHomePage.php';
            break;
        default:
            $error = "Invalid role selected.";
            break;
    }

    if (!isset($error)) {
        $stmt = $con->prepare("SELECT $idColumn FROM $table WHERE $userColumn = ? AND $passColumn = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Fetch user ID
            $row = $result->fetch_assoc();
            $userID = $row[$idColumn];

            // Store role, username, and user ID in session
            $_SESSION['role'] = $role;
            $_SESSION['username'] = $username;
            $_SESSION['userID'] = $userID;

            // Set cookies to remember the user for 7 days
            setcookie('role', $role, time() + (86400 * 7), "/");
            setcookie('username', $username, time() + (86400 * 7), "/");
            setcookie('userID', $userID, time() + (86400 * 7), "/");

            header("Location: $homePage");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FK PARK Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="Login.css">
</head>

<body>
    <div class="login-container">
        <!-- Left Panel -->
        <div class="left-panel" style="background-image: url('../resource/login.jpg');">
            <div class="overlay">
                <h1>Welcome to FK PARK!</h1>
                <p>You can sign in to access your existing account.</p>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="right-panel">
            <div class="form-container">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">FK PARK</h2>

                        <form method="POST" action="Login.php">
                            <!-- Role -->
                            <div class="mb-3">
                                <label for="role" class="form-label">Role:</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                    <select class="form-select" name="role" id="role" required>
                                        <option value="Student">Student</option>
                                        <option value="Administrator">Administrator</option>
                                        <option value="UnitKeselamatanStaff">Unit Keselamatan Staff</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Forgot Password -->
                            <p class="text-center mt-3">
                                <a href="forgotPassword.php" class="text-decoration-none">Forgot Password?</a>
                            </p>

                            <!-- Submit -->
                            <button type="submit" class="btn btn-primary w-100 py-2">Sign In</button>
                        </form>

                        <!-- Error Message -->
                        <?php
                        if (isset($error)) {
                            echo "<div class='alert alert-danger mt-3 text-center' role='alert'>$error</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toggle Password Script -->
    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("toggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        });
    </script>
</body>

</html>
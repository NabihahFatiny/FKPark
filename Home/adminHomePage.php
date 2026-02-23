


<?php 
    ob_start();
    session_start();
    include '../Layout/adminHeader.php'; 
    include '../DB_FKPark/dbcon.php'; // Ensure the database connection is included

    if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
        header("Location: ../login.php");
        exit;
    }
    
    // Optional: Check cookies if session is not set
    if (!isset($_SESSION['username']) && isset($_COOKIE['username'])) {
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['role'] = $_COOKIE['role'];
    }
    
    // Verify role
    if ($_SESSION['role'] != 'Administrator') { // Change this to 'Administrator' or 'UnitKeselamatanStaff' as needed
        header("Location: ../login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creation to Market</title>
    <link rel="stylesheet" href="HomePage.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
</head>
<style>
    /* Modal styles */
.modal1 {
    display: none;
    position: fixed;
    z-index: 1000; /* Ensure it's above other content */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content1 {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fefefe;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 300px;
    text-align: center;
    z-index: 1001; /* Ensure it's above the modal backdrop */
}

</style>
<body>
<div class="profile-name">
  <span class="username">Welcome, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>!</span>
</div>

    <main class="container">
        <section class="text-section">
            <h1>FKPARK</h1>
            <p>Hello <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?> Ready for today task? .</p>
            <button onclick="window.location.href='../ManageRegistration/StudentRegistration.php'">Register</button>
            <button onclick="window.location.href='../ManageRegistration/viewRegistration.php'">View Your Registration</button>

        </section>
        <section class="image-section">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><img src="../resource/illustration.jpg" alt="Parking lot 1 at FKPARK"></div>
                    <div class="swiper-slide"><img src="../resource/FKPark_Map.png" alt="Parking lot 2 at FKPARK"></div>
                    <div class="swiper-slide"><img src="../resource/FK.jpg" alt="Parking lot 3 at FKPARK"></div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </section>
    </main>

    <?php include '../Layout/allUserFooter.php'; ?>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            spaceBetween: 10,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            loop: true,
        });
    </script>
</body>
</html>


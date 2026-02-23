<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>FKPark</title>

    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif; /* Ensures the same font throughout */
        }

        body {
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: #BE8A62;
            padding: 10px 0;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo {
            font-size: 24px;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        nav ul li {
            position: relative;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }

        nav ul li a:hover {
            background-color: #575757;
        }


        .dropdown {
            display: none;
            position: absolute;
            background-color: #BE8A62;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown a:hover {
            color: black; /* Change text color on hover */
            border-bottom: 2px solid #BE8A62; /* Add underline on hover */
            background-color:#E5CCA8;
        }

        .profile a {
            color: white;
            text-decoration: none;
            padding: 10px;
            font-size: 20px;
            position: relative;
        }

        .profile-dropdown {
            display: none;
            position: absolute;
            background-color: #BE8A62;
            right: 0;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .profile-dropdown a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .profile-dropdown a:hover {
            background-color: #E5CCA8;
            color:black;

        }

        main {
            flex: 1;
        }

        li a{
            font-size:16px;
        }

        .inbox a {
            color: white;
            text-decoration: none;
            padding: 10px;
            font-size: 20px;
            margin-right: 0px; /* spacing between inbox and profile */
        }


    </style>
</head>
<body>
    
    <header>
        <div class="container">
        <div class="logo"><img src="../resource/FKPark1.jpeg" alt="FKPark" width="170" height="70"></div>
            <nav>
                <ul>
                    <li>
                        <a href="../Home/studentHomePage.php">Home</a>
                    
                    </li>
                    <li>
                    <a class="dropdown-toggle">Vehicle</a>
                        <div class="dropdown">
                            <a href="../ManageRegistration/RegistrationVehicle.php">Register Vehicle</a>
                            <a href="../ManageRegistration/RegistrationStatus.php">Status Vehicle</a>
                        </div>                   
                     </li>
                    <li>
                        <a class="dropdown-toggle">Booking</a>
                        <div class="dropdown">
                            <a href="../ManageBooking/createBooking.php">Create Booking</a>
                            <a href="../ManageBooking/viewBooking.php">View Booking</a>
                        </div>
                    </li>
                    <li>
                        <a href="../Dashboard/studDashboard.php" class="dropdown-toggle-dashboard">Dashboard</a>
                    </li>
                    <li>
                        <a href="../Contact/ContactStud.php">Contact</a>
                    </li>
                </ul>
            </nav>
            <div class="inbox">
                <a href="../Home/inbox.php" class="inbox-toggle"><i class="fas fa-inbox"></i></a>
            </div>

            <div class="profile">
                <a href="#" class="profile-toggle"><i class="fas fa-user"></i></a>
                <div class="profile-dropdown">
                    <a href="../Profile/StudProfile.php">Profile</a>
                    <a href="#">Settings</a>
                    <a href="../Manage Login/Logout.php">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Booking dropdown toggle
            var dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            dropdownToggles.forEach(function (toggle) {
                toggle.addEventListener('click', function (event) {
                    event.preventDefault();
                    var dropdown = this.nextElementSibling;
                    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                });
            });

            // Profile dropdown toggle
            document.querySelector('.profile-toggle').addEventListener('click', function (event) {
                event.preventDefault();
                var dropdown = this.nextElementSibling;
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            });

            // Close dropdowns if clicked outside
            document.addEventListener('click', function (event) {
                var isClickInsideBooking = Array.from(dropdownToggles).some(function (toggle) {
                    return toggle.contains(event.target);
                });
                var isClickInsideProfile = document.querySelector('.profile-toggle').contains(event.target);
                var dropdowns = document.querySelectorAll('.dropdown, .profile-dropdown');

                if (!isClickInsideBooking && !isClickInsideProfile) {
                    dropdowns.forEach(function (dropdown) {
                        dropdown.style.display = 'none';
                    });
                }
            });
        });

   

    </script>

</body>
</html>

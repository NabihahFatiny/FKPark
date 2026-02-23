<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- <link rel="stylesheet" href="layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> -->
    <style>
        body, html {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif; /* Ensures the same font throughout */
        }

        main {
            flex-grow: 1;
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
            font-weight: bold;
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

        .profile a {
            color: white;
            text-decoration: none;
            padding: 10px;
            font-size: 20px;
        }

        .profile a:hover {
            color: #ccc;
        }


        footer {
            background-color: #333;
            color: white;
            padding: 20px 0;
            width: 100%;
            position: relative;
            bottom: 0;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            text-align: center;

        }

        .footer-section {
            flex: 1;
            padding: 0 20px;
        }

        .footer-section h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .footer-section p, .footer-section ul, .footer-section ul li {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .footer-section ul li a {
            color: white;
            text-decoration: none;
        }

        .footer-section ul li a:hover {
            text-decoration: underline;
        }

        .links {
            text-align: center;
        }

    </style>
</head>
<body>
    <main>

    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section about">
                    <h2>About FKPark</h2>
                    <p>FKPark is a premier parking management system providing seamless and efficient parking solutions.</p>
                </div>
                <div class="footer-section contact">
                    <h2>Contact Us</h2>
                    <p>Email: info@fkpark.com</p>
                    <p>Phone: +123 456 7890</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
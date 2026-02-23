<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FK Parking Management System</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="landing-container">
        <header class="landing-header">
            <img src="../resource/FKPark1.jpeg" alt="FK Parking Logo" class="logo">
            <nav class="landing-nav">
                <ul>
                    <li><a href="#about">About</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#contact" style="margin-right: 80px;">Contact</a></li>
                </ul>
            </nav>
        </header>
        <main class="landing-main">
            <section class="hero">
                <img src="../resource/homefk.png" alt="FK Parking home" class="banner">
                <h1>Efficient Parking for FK Community</h1>
                <p>Manage your parking experience at Universiti Malaysia Pahang Al-Sultan Abdullah with ease.</p>
                <a href="../Manage Login/Login.php" class="btn-get-started">Get Started</a>
            </section>
            <section id="about" class="about">
                <div class="about-bg">
                    <h2 style="">About FK Parking</h2>
                    <p>
                        Our web-based parking management system is a comprehensive solution tailored to streamline the parking process for faculty staff and students at FK. By leveraging modern technology, the system provides real-time information on available parking spaces, ensuring efficient use of the parking facilities. The system is equipped with a user-friendly interface that allows users to quickly check the status of parking spots, which are updated instantaneously as they are occupied or vacated.
                    </p>
                </div>
            </section>
            <section id="features" class="features">
                <h2>Features</h2>
                <div class="feature-list">
                    <div class="feature-item">
                        <h3>Real-Time Updates</h3>
                        <p>View current parking availability at a glance.</p>
                    </div>
                    <div class="feature-item">
                        <h3>Violation Reporting</h3>
                        <p>Report parking violations easily and efficiently.</p>
                    </div>
                    <div class="feature-item">
                        <h3>Staff Priority</h3>
                        <p>Designated parking areas for faculty staff ensure convenience.</p>
                    </div>
                </div>
            </section>
            <section id="contact" class="contact">
                <h2>Contact Us</h2>
                <div class="contact-content">
                    <div class="contact-info">
                        <p><b>Have questions or need support? Reach out to our team.</b></p>
                        <p><i class="fa fa-phone"></i> +60 114 0483940</p>
                        <p><i class="fa fa-envelope"></i> misterwhoopy@gmail.com</p>
                        <p><i class="fa fa-instagram"></i> @misterwhoopy_harith</p>
                    </div>
                    <form class="contact-form" action="send_email.php" method="post">
                        <input type="text" name="name" placeholder="Your Name" required>
                        <input type="email" name="email" placeholder="Your Email" required>
                        <textarea name="message" placeholder="Your Message" required></textarea>
                        <button type="submit" class="btn-submit">Send Message</button>
                    </form>
                </div>
            </section>
        </main>
        <footer class="landing-footer">
            <p>© <?= date("Y"); ?> FK Parking Management. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>

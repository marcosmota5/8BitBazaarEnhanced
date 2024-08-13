<?php

// Start the session if it wasn't started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home | 8 Bit Bazaar</title>
    <meta name="author" content="" />
    <meta name="description" content="Website of old products">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/style-contact.css" />
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <!-- Page-level header -->
    <header>
        <?php
        include("templates/header.php");
        ?>
    </header>
    <main>
        <div class="welcome">
            <span class="welcome-title">Contact</span>
            <span class="welcome-subtitle">We'd love to hear from you. Please fill out the form below or reach us using the contact information provided.</span>
        </div>

        <!-- Contact Form -->
        <div class="contact-form">
            <h2>Send us a message</h2>
            <form action="contact-received.php" method="post">
                <div class="form-field-group">
                    <div class="form-field">
                        <label for="name">Name</label>
                        <input class="input-box" type="text" id="name" name="name" required>
                    </div>
                    <div class="form-field">
                        <label for="phone">Phone</label>
                        <input class="input-box" type="tel" id="phone" name="phone" required>
                    </div>
                    <div class="form-field">
                        <label for="email">Email</label>
                        <input class="input-box" type="email" id="email" name="email" required>
                    </div>
                </div>
                <div class="form-field-group">
                    <div class="form-field">
                        <label for="message">Message</label>
                        <textarea class="input-box" id="message" name="message" rows="5" required></textarea>
                    </div>
                </div>
                <button type="submit" class="submit-button">Send</button>
            </form>
        </div>

        <!-- Contact Information -->
        <div class="contact-info">
            <h2>Contact information</h2>
            <p><strong>Address:</strong> </p>
            <p><strong>Phone:</strong> </p>
            <p><strong>Fax:</strong> </p>
            <p><strong>Email:</strong> </p>
            <p><strong>Office Hours:</strong> </p>
        </div>

        <!-- Page-level footer -->
        <footer>
            <?php
            include("templates/footer.php");
            ?>
        </footer>
    </main>

    <!-- Add the javascript file that has some scripts -->
    <script src="scripts/scripts.js"></script>
</body>

</html>
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
    <title>About | 8 Bit Bazaar</title>
    <meta name="author" content="" />
    <meta name="description" content="Website of old products">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/style-about.css" />
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
    <!-- Page-level main content -->
    <main>
        <div class="about-content">
            <p>This is a website for an assignment and only for learning purposes.</p>
            <br>
            <p>Assignment detail: COMP1006 Assignment 3</p>
            <p>GitHub repository: <a href="https://github.com/marcosmota5/8BitBazaarEnhanced" title="GitHub Repository">8 Bit Bazaar Enhanced Repository</a></p>
            <br>
            <h3>Students:</h3>
            <div class="students-section">
                <!-- Divs for students -->
                <div class="student-card">
                    <img src="images/students/marcos-mota.png" alt="Student Picture">
                    <div class="student-card-content">
                        <h3>Marcos Oliveira Mota</h3>
                        <p class="student-id">Id: 200564426</p>
                        <p>Portfolio: <a href="https://www.marcosmota.tech/portfolio">marcosmota.tech</a></p>
                        <p>Follow Me: <a href="https://www.linkedin.com/in/marcosmota5">LinkedIn</a></p>
                    </div>
                </div>
                <div class="student-card">
                    <img src="images/students/natalia-dias.jpeg" alt="Student Picture">
                    <div class="student-card-content">
                        <h3>Natália Dias</h3>
                        <p class="student-id">Id: 200587841</p>
                        <p>Portfolio:</p>
                        <p>Follow Me: <a href="https://www.linkedin.com/in/natalia-selestrini/">LinkedIn</a></p>
                    </div>
                </div>
                <div class="student-card">
                    <img src="images/students/lucas-navim.jpg" alt="Student Picture">
                    <div class="student-card-content">
                        <h3>Lucas Navim</h3>
                        <p class="student-id">Id: 200579342</p>
                        <p>Portfolio:</p>
                        <p>Follow Me: <a href="https://www.linkedin.com/in/lucasnavim/">LinkedIn</a></p>
                    </div>
                </div>
            </div>
            <br>
            <p>Thanks to the creators of the following images:</p>
            <ul>
                <li><a href="https://www.flaticon.com/free-icons/browser" title="browser icons">Browser icons created by Freepik - Flaticon</a></li>
                <li><a href="https://www.flaticon.com/free-icons/8-bit" title="8 bit icons">8 bit icons created by Freepik - Flaticon</a></li>
                <li><a href="https://wallpaperaccess.com/8-bit-gif" title="8 bit gif">8 bit gif by Wallpaper Access</a></li>
            </ul>

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
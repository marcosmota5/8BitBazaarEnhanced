<?php

// Start the session if it wasn't started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("db_operations/user_login.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | 8 Bit Bazaar</title>
    <meta name="author" content="" />
    <meta name="description" content="Website of old products">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/style-register.css" />
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
    <main class="main-content-register">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <!-- A div that has the header of the form, including the title of the current page and a reset button.  The actual reset input is hidden and a button is used instead that has the onclick element to click on the input reset, the reason
                             for that is to enable better formatting and controls -->
            <div class="form-header">
                <h2>Login</h2>
                <button class="reset-button" type="button" onclick="document.getElementById('reset-btn').click()"><span class="material-symbols-outlined">
                        delete
                    </span>&nbsp;Clear</button>
                <input style="display:none" type="reset" id="reset-btn" onclick="return confirmReset()">
            </div>
            <!-- All parts below are related to the contact information, such as the name, phone number, address type, street address, suite/apt, city, province, and postal code -->
            <div class="form-field-group">
                <div class="form-field">
                    <label for="email">Email<span class="required">*</span></label>
                    <input class="input-box" type="email" name="email" id="email" maxlength="50" required />
                </div>
            </div>
            <div class="form-field-group">
                <div class="form-field">
                    <label for="password">Password<span class="required">*</span></label>
                    <input class="input-box" type="password" name="password" id="password" maxlength="32" required>
                </div>
            </div>
            <div class="form-field-group">
                <span>Forgot my password</span>
            </div>
            <div class="form-field-group" <?php echo isset($errorMessages) ? '' : 'style="display:none"' ?>>
                <div class="error-message">
                    <span><strong>Error to login. Please check the details below:<br><br></strong></span>
                    <?php echo isset($errorMessages) ? $errorMessages : "" ?>
                </div>
            </div>
            <!-- A div that holds the button to submit the form. The actual submit input is hidden and a button is used instead that has the onclick element to click on the input submit, the reason
                             for that is to enable better formatting and controls -->
            <div class="form-container">
                <button class="submit-button" type="button" onclick="document.getElementById('submit-btn').click()"><span class="material-symbols-outlined">
                        login
                    </span>&nbsp;Login</button>
                <input style="display:none" type="submit" id="submit-btn">

                <a class="submit-button" href="register.php" class="register-popup-button"><span>Register</span></a>
            </div>
        </form>
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
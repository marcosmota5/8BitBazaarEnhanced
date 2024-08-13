<?php
    require_once("db_operations/user_password_change.php");

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
    <title>Change Password | 8 Bit Bazaar</title>
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
        
        // Set a variable to check if the user exists
        $user = null;

        // If the user_id is set in the session, get the user information
        if (isset($_SESSION['user_id'])) {

            // Include database config file => to get our PDO object 
            require_once 'config/db_config.php';

            // Set the sql statement
            $sql = 'SELECT id, first_name, last_name, sex, email, register_date, phone_number, picture_path, birth_date, address_line_1, address_line_2, postal_code, city, state_province, country, status FROM tb_users WHERE id = :id LIMIT 1';

            // Prepare the SQL statement
            $stmt = $pdo->prepare($sql);

            // Execute the statement by passing the parameters and saves
            $stmt->execute(
                [
                    'id' => $_SESSION['user_id']
                ]
            );

            // Get the user
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            echo $user->birth_date;
        } else {
            echo "User not found";
            exit();
        }
        ?>
    </header>
    <main class="main-content-register">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <!-- A div that has the header of the form, including the title of the current page and a reset button.  The actual reset input is hidden and a button is used instead that has the onclick element to click on the input reset, the reason
                             for that is to enable better formatting and controls -->
            <div class="form-header">
                <h2>Change Password</h2>
                <button class="reset-button" type="button" onclick="document.getElementById('reset-btn').click()"><span class="material-symbols-outlined">
                        delete
                    </span>&nbsp;Clear</button>
                <input style="display:none" type="reset" id="reset-btn" onclick="return confirmReset()">
            </div>
            <!-- All parts below are related to the contact information, such as the name, phone number, address type, street address, suite/apt, city, province, and postal code -->
            <div class="form-field-group">
                <div class="form-field">
                <label for="current-password">Current Password<span class="required">*</span></label>
                <input class="input-box" type="password" name="current-password" id="current-password" maxlength="32" required>
                </div>
            </div>
            <div class="form-field-group">
                <div class="form-field">
                <label for="new-password">New Password<span class="required">*</span></label>
                <input class="input-box" type="password" name="new-password" id="new-password" maxlength="32" required>
                </div>
            </div>
            <div class="form-field-group">
                <div class="form-field">
                    <label for="confirm-password">Confirm Password<span class="required">*</span></label>
                    <input class="input-box" type="password" name="confirm-password" id="confirm-password" maxlength="32" required>
                </div>
            </div>
            <div class="form-field-group" <?php echo isset($successMessage) ? '' : 'style="display:none"' ?>>
                <div class="success-message">
                    <span><strong><?php echo isset($successMessage) ? $successMessage : "" ?></strong></span>
                </div>
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
                        save
                    </span>&nbsp;Confirm Change</button>
                <!-- Hidden inputs to hold the user id -->
                <input style="display: none;" type="text" id="user_id" name="user_id" value="<?php echo isset($user) ? $user->id : "" ?>">
                <input style="display:none" type="submit" id="submit-btn">
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
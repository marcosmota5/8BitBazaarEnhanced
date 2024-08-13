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
    <title>Checkout | 8 Bit Bazaar</title>
    <meta name="author" content="" />
    <meta name="description" content="Website of old products">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/style-register.css" />
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />

    <!-- Google Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <!-- Page-level header -->
    <header>
        <?php
        include ("templates/header.php");

        // Set a variable to check if the user exists
        $user = null;

        // If the user_id is set in the session, get the user information
        if (isset($_SESSION['user_id'])) {

            // Include database config file => to get our PDO object 
            require_once 'config/db_config.php';

            // Set the sql statement
            $sql = 'SELECT first_name, last_name, phone_number, address_line_1, address_line_2, postal_code, country, state_province, city FROM tb_users WHERE id = :id LIMIT 1';

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
        }


        // If the request method received was a post, execute the codes
        // this is important so, when the page first load there's no error thrown
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Codes and quantities
            $product_ids = $_POST['product_ids'];
            $quantities = $_POST['quantities'];
            $total = $_POST['total'];
        }
        ?>
    </header>
    <main class="main-content-checkout">
        <h1 class="checkout-title">Checkout</h1>
        <form action="db_operations/order_insert.php" method="POST">
            <!-- A div that has the header of the form, including the title of the current page and a reset button.  The actual reset input is hidden and a button is used instead that has the onclick element to click on the input reset, the reason
                             for that is to enable better formatting and controls -->
            <div class="form-header">
                <h2>Contact Information</h2>
                <button class="reset-button" type="button" onclick="document.getElementById('reset-btn').click()"><span
                        class="material-symbols-outlined">
                        restart_alt
                    </span>&nbsp;Reset</button>
                <input style="display:none" type="reset" id="reset-btn" onclick="return confirmReset()">
            </div>
            <!-- All parts below are related to the contact information, such as the name, phone number, address type, street address, suite/apt, city, province, and postal code -->
            <div class="form-field-group">
                <div class="form-field">
                    <label for="name">Recipient name<span class="required">*</span></label>
                    <input class="input-box" type="text" id="name" name="name"
                        value="<?php echo isset($user) ? trim($user->first_name . ' ' . $user->last_name) : "" ?>"
                        required><br>
                </div>
                <div class="form-field">
                    <label for="phone-number">Phone Number<span class="required">*</span></label>
                    <input class="input-box" type="tel" id="phone-number" name="phone-number"
                        value="<?php echo isset($user) ? $user->phone_number : "" ?>" required><br>
                </div>
            </div>
            <div class="form-field-group">
                <div class="form-field">
                    <label for="address-line-1">Address line 1<span class="required">*</span></label>
                    <input class="input-box" type="text" id="address-line-1" name="address-line-1" maxlength="100"
                        value="<?php echo isset($user) ? $user->address_line_1 : "" ?>" required>
                </div>
            </div>
            <div class="form-field-group">
                <div class="form-field">
                    <label for="address-line-2">Address line 2</label>
                    <input class="input-box" type="text" id="address-line-2" name="address-line-2" maxlength="100"
                        value="<?php echo isset($user) ? $user->address_line_2 : "" ?>">
                </div>
                <div class="form-field">
                    <label for="postal-code">Postal Code<span class="required">*</span></label>
                    <input class="input-box" type="text" id="postal-code" name="postal-code" maxlength="20"
                        value="<?php echo isset($user) ? $user->postal_code : "" ?>" required>
                </div>
            </div>
            <div class="form-field-group">
                <div class="form-field">
                    <label for="country">Country<span class="required">*</span></label>
                    <select class="input-box" id="country" name="country" required>
                        <option <?php echo isset($user) && $user->country == 'Canada' ? 'selected="selected"' : ''; ?>
                            value="Canada">Canada</option>
                    </select>
                </div>
                <div class="form-field">
                    <label for="province">Province<span class="required">*</span></label>
                    <select class="input-box" id="province" name="province" required>
                        <option <?php echo isset($user) && $user->state_province == 'Alberta' ? 'selected="selected"' : ''; ?> value="Alberta">Alberta</option>
                        <option <?php echo isset($user) && $user->state_province == 'British Columbia' ? 'selected="selected"' : ''; ?> value="British Columbia">British Columbia</option>
                        <option <?php echo isset($user) && $user->state_province == 'Manitoba' ? 'selected="selected"' : ''; ?> value="Manitoba">Manitoba</option>
                        <option <?php echo isset($user) && $user->state_province == 'New Brunswick' ? 'selected="selected"' : ''; ?> value="New Brunswick">New Brunswick</option>
                        <option <?php echo isset($user) && $user->state_province == 'Newfoundland and Labrador' ? 'selected="selected"' : ''; ?> value="Newfoundland and Labrador">Newfoundland and Labrador
                        </option>
                        <option <?php echo isset($user) && $user->state_province == 'Nova Scotia' ? 'selected="selected"' : ''; ?> value="Nova Scotia">Nova Scotia</option>
                        <option <?php echo isset($user) && $user->state_province == 'Ontario' ? 'selected="selected"' : ''; ?> value="Ontario">Ontario</option>
                        <option <?php echo isset($user) && $user->state_province == 'Prince Edward Island' ? 'selected="selected"' : ''; ?> value="Prince Edward Island">Prince Edward Island</option>
                        <option <?php echo isset($user) && $user->state_province == 'Quebec' ? 'selected="selected"' : ''; ?> value="Quebec">Quebec</option>
                        <option <?php echo isset($user) && $user->state_province == 'Saskatchewan' ? 'selected="selected"' : ''; ?> value="Saskatchewan">Saskatchewan</option>
                    </select>
                </div>
                <div class="form-field">
                    <label for="city">City<span class="required">*</span></label>
                    <input class="input-box" type="text" id="city" name="city"
                        value="<?php echo isset($user) ? $user->city : "" ?>" required>
                </div>
            </div>
            <div class="form-field-group">
                <input style="display: none;" type="text" id="product_ids" name="product_ids"
                    value="<?php echo isset($product_ids) ? $product_ids : "" ?>">
                <input style="display: none;" type="text" id="quantities" name="quantities"
                    value="<?php echo isset($quantities) ? $quantities : "" ?>">
                <input style="display: none;" type="text" id="total" name="total"
                    value="<?php echo isset($total) ? $total : "" ?>">
                <div class="form-field">
                    <h2 class="cart-total">Total: <span id="total-value">$
                            <?php echo isset($total) ? $total : "0" ?></span></h2>
                </div>
            </div>
            <!-- A div that holds the button to submit the form. The actual submit input is hidden and a button is used instead that has the onclick element to click on the input submit, the reason
                             for that is to enable better formatting and controls -->
            <div class="form-container">
                <button class="submit-button" type="button"
                    onclick="document.getElementById('submit-btn').click()"><span class="material-symbols-outlined">
                        done
                    </span>&nbsp;Confirm</button>
                <input style="display:none" type="submit" id="submit-btn">
            </div>
        </form>
        <!-- Page-level footer -->
        <footer>
            <?php
            include ("templates/footer.php");
            ?>
        </footer>
    </main>

    <!-- Add the javascript file that has some scripts -->
    <script src="scripts/scripts.js"></script>
</body>

</html>
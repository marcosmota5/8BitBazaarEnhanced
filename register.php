<?php
require_once("db_operations/user_register.php");

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
    <title>Register | 8 Bit Bazaar</title>
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
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
            <!-- A div that has the header of the form, including the title of the current page and a reset button.  The actual reset input is hidden and a button is used instead that has the onclick element to click on the input reset, the reason
                             for that is to enable better formatting and controls -->
            <div class="form-header">
                <h2>Register</h2>
                <button class="reset-button" type="button" onclick="document.getElementById('reset-btn').click()"><span class="material-symbols-outlined">
                        delete
                    </span>&nbsp;Clear</button>
                <input style="display:none" type="reset" id="reset-btn" onclick="return confirmReset()">
            </div>
            <!-- All parts below are related to the contact information, such as the name, phone number, address type, street address, suite/apt, city, province, and postal code -->
            <div class="form-field-group">
                <div class="form-field">
                    <label for="first-name">First name<span class="required">*</span></label>
                    <input class="input-box" type="text" id="first-name" name="first-name" maxlength="30" value="<?php echo isset($firstName) ? $firstName : "" ?>" required>
                </div>
                <div class="form-field">
                    <label for="last-name">Last name<span class="required">*</span></label>
                    <input class="input-box" type="text" id="last-name" name="last-name" maxlength="30" value="<?php echo isset($lastName) ? $lastName : "" ?>" required>
                </div>
            </div>
            <div class="form-field-group">
                <div class="form-field">
                    <label for="birth-date">Birth date<span class="required">*</span></label>
                    <input class="input-box" type="date" id="birth-date" name="birth-date" min="1900-01-01" value="<?php echo isset($birthDate) ? $birthDate : "" ?>" required>
                </div>
                <div class="form-field">
                    <label for="sex">Sex<span class="required">*</span></label>
                    <select class="input-box" id="sex" name="sex" required>
                        <option <?php echo isset($sex) && $sex == 'M' ? 'selected="selected"' : ''; ?> value="M">Male</option>
                        <option <?php echo isset($sex) && $sex == 'F' ? 'selected="selected"' : ''; ?> value="F">Female</option>
                        <option <?php echo isset($sex) && $sex == 'N' ? 'selected="selected"' : ''; ?> value="N">Not declared</option>
                    </select>
                </div>
                <div class="form-field">
                    <label for="profile-picture">Profile picture</label>
                    <div class="user-image-selector">
                        <img id="image-preview" src="images/users/no-picture.png" alt="Image Preview">
                        <input type="file" id="profile-picture" name="profile-picture" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="form-field-group">
                <div class="form-field">
                    <label for="phone-number">Phone Number<span class="required">*</span></label>
                    <input class="input-box" type="tel" id="phone-number" name="phone-number" maxlength="20" value="<?php echo isset($phoneNumber) ? $phoneNumber : "" ?>" required>
                </div>
                <div class="form-field">
                    <label for="email">Email<span class="required">*</span></label>
                    <input class="input-box" type="email" id="email" name="email" maxlength="50" value="<?php echo isset($email) ? $email : "" ?>" required />
                </div>
            </div>
            <div class="form-field-group">
                <div class="form-field">
                    <label for="address-line-1">Address line 1<span class="required">*</span></label>
                    <input class="input-box" type="text" id="address-line-1" name="address-line-1" maxlength="100" value="<?php echo isset($addressLine1) ? $addressLine1 : "" ?>" required>
                </div>
            </div>
            <div class="form-field-group">
                <div class="form-field">
                    <label for="address-line-2">Address line 2</label>
                    <input class="input-box" type="text" id="address-line-2" name="address-line-2" maxlength="100" value="<?php echo isset($addressLine2) ? $addressLine2 : "" ?>">
                </div>
                <div class="form-field">
                    <label for="postal-code">Postal Code<span class="required">*</span></label>
                    <input class="input-box" type="text" id="postal-code" name="postal-code" maxlength="20" value="<?php echo isset($postalCode) ? $postalCode : "" ?>" required>
                </div>
            </div>
            <div class="form-field-group">
                <div class="form-field">
                    <label for="country">Country<span class="required">*</span></label>
                    <select class="input-box" id="country" name="country" required>
                        <option <?php echo isset($country) && $country == 'Canada' ? 'selected="selected"' : ''; ?> value="Canada">Canada</option>
                    </select>
                </div>
                <div class="form-field">
                    <label for="province">Province<span class="required">*</span></label>
                    <select class="input-box" id="province" name="province" required>
                        <option <?php echo isset($province) && $province == 'Alberta' ? 'selected="selected"' : ''; ?> value="Alberta">Alberta</option>
                        <option <?php echo isset($province) && $province == 'British Columbia' ? 'selected="selected"' : ''; ?> value="British Columbia">British Columbia</option>
                        <option <?php echo isset($province) && $province == 'Manitoba' ? 'selected="selected"' : ''; ?> value="Manitoba">Manitoba</option>
                        <option <?php echo isset($province) && $province == 'New Brunswick' ? 'selected="selected"' : ''; ?> value="New Brunswick">New Brunswick</option>
                        <option <?php echo isset($province) && $province == 'Newfoundland and Labrador' ? 'selected="selected"' : ''; ?> value="Newfoundland and Labrador">Newfoundland and Labrador</option>
                        <option <?php echo isset($province) && $province == 'Nova Scotia' ? 'selected="selected"' : ''; ?> value="Nova Scotia">Nova Scotia</option>
                        <option <?php echo isset($province) && $province == 'Ontario' ? 'selected="selected"' : ''; ?> value="Ontario">Ontario</option>
                        <option <?php echo isset($province) && $province == 'Prince Edward Island' ? 'selected="selected"' : ''; ?> value="Prince Edward Island">Prince Edward Island</option>
                        <option <?php echo isset($province) && $province == 'Quebec' ? 'selected="selected"' : ''; ?> value="Quebec">Quebec</option>
                        <option <?php echo isset($province) && $province == 'Saskatchewan' ? 'selected="selected"' : ''; ?> value="Saskatchewan">Saskatchewan</option>
                    </select>
                </div>
                <div class="form-field">
                    <label for="city">City<span class="required">*</span></label>
                    <input class="input-box" type="text" id="city" name="city" value="<?php echo isset($city) ? $city : "" ?>" required>
                </div>
            </div>
            <div class="form-field-group">
                <div class="form-field">
                    <label for="password">Password<span class="required">*</span></label>
                    <input class="input-box" type="password" id="password" name="password" maxlength="32" required>
                </div>
                <div class="form-field">
                    <label for="confirm-password">Confirm Password<span class="required">*</span></label>
                    <input class="input-box" type="password" id="confirm-password" name="confirm-password" maxlength="32" required>
                </div>
            </div>
            <div class="form-field-group" <?php echo isset($errorMessages) ? '' : 'style="display:none"' ?>>
                <div class="error-message">
                    <span><strong>Error to register user. Please check the details below:<br><br></strong></span>
                    <?php echo isset($errorMessages) ? $errorMessages : "" ?>
                </div>
            </div>
            <!-- A div that holds the button to submit the form. The actual submit input is hidden and a button is used instead that has the onclick element to click on the input submit, the reason
                             for that is to enable better formatting and controls -->
            <div class="form-container">
                <button class="submit-button" type="button" onclick="document.getElementById('submit-btn').click()"><span class="material-symbols-outlined">
                        how_to_reg
                    </span>&nbsp;Register</button>
                <input style="display:none" type="submit" id="submit-btn">
            </div>
        </form>
        <!-- Page-level footer -->
        <footer>
            <?php
            include("templates/footer.php");
            ?>
        </footer>
    </main>
    <!-- Add the javascript file that has some scripts -->
    <script src="scripts/scripts.js"></script>
    <!-- Scripts to handle some important operations -->
    <script>
        // Set the max property for the birth date to 10 years ago
        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date();
            const yyyy = today.getFullYear() - 10; // Don't allow users that are younger than 10 years to register
            const mm = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based, so we add 1
            const dd = String(today.getDate()).padStart(2, '0');

            const maxDate = `${yyyy}-${mm}-${dd}`;

            document.getElementById('birth-date').setAttribute('max', maxDate);
        });

        // Handle the file selection and show it on the img field
        document.getElementById('profile-picture').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.getElementById('image-preview');
                    imgElement.src = e.target.result;
                    imgElement.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>
<?php

// Include database config file => to get our PDO object 
require_once 'config/db_config.php';

// If the request method received was a post, execute the codes
// this is important so, when the page first load there's no error thrown
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Set the variables for the values
    $firstName = trim($_POST['first-name']);
    $lastName = trim($_POST['last-name']);
    $birthDate = $_POST['birth-date'];
    $sex = $_POST['sex'];
    $profilePicture = $_POST['profile-picture'];
    $phoneNumber = trim($_POST['phone-number']);
    $email = trim($_POST['email']);
    $addressLine1 = trim($_POST['address-line-1']);
    $addressLine2 = trim($_POST['address-line-2']);
    $postalCode = trim($_POST['postal-code']);
    $country = $_POST['country'];
    $province = $_POST['province'];
    $city = trim($_POST['city']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm-password']);
    $status = 'A'; // Set the status as active

    // Create the errors array
    $errors = [];
    $errorMessages = '';

    // Validate first name
    if (empty($firstName)) {
        $errors[] = 'First name is required';
    } elseif (strlen($firstName) > 30) {
        $errors[] = 'First name cannot have more than 30 characters';
    }

    // Validate last name
    if (empty($lastName)) {
        $errors[] = 'Last name is required';
    } elseif (strlen($lastName) > 30) {
        $errors[] = 'Last name cannot have more than 30 characters';
    }

    // Validate birth date
    if (empty($birthDate)) {
        $errors[] = 'Birth date is required';
    }

    // Validate sex
    if (empty($sex)) {
        $errors[] = 'Sex is required';
    }

    // Validate profile picture
    if (!(str_ends_with($profilePicture, 'jpg') || !str_ends_with($profilePicture, 'jpeg') || !str_ends_with($profilePicture, 'png') || !str_ends_with($profilePicture, 'gif'))) {
        $errors[] = 'The file provided for the picture must be a .jpg, .jpeg, .png or .gif file';
    }

    // Validate phone number
    if (strlen($phoneNumber) > 20) {
        $errors[] = 'Phone number cannot have more than 20 characters';
    }

    // Validate email
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (strlen($email) > 50) {
        $errors[] = 'Email cannot have more than 50 characters';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Use the bultin function to verify if it's a valid email
        $errors[] = 'Email invalid';
    }

    // Validate address line 1
    if (empty($addressLine1)) {
        $errors[] = 'Address line 1 is required';
    } elseif (strlen($addressLine1) > 100) {
        $errors[] = 'Address line 1 cannot have more than 30 characters';
    }

    // Validate address line 2
    if (strlen($addressLine2) > 100) {
        $errors[] = 'Address line 2 cannot have more than 30 characters';
    }

    // Validate postal code
    if (empty($postalCode)) {
        $errors[] = 'Postal code is required';
    } elseif (strlen($postalCode) > 20) {
        $errors[] = 'Postal code cannot have more than 20 characters';
    }

    // Validate country
    if (empty($country)) {
        $errors[] = 'Country is required';
    } elseif (strlen($country) > 30) {
        $errors[] = 'Country cannot have more than 20 characters';
    }

    // Validate province
    if (empty($province)) {
        $errors[] = 'Province is required';
    } elseif (strlen($province) > 20) {
        $errors[] = 'Province cannot have more than 20 characters';
    }

    // Validate city
    if (empty($city)) {
        $errors[] = 'City is required';
    } elseif (strlen($city) > 20) {
        $errors[] = 'City cannot have more than 20 characters';
    }

    // Validate passwords
    if (empty($password)) {
        $errors[] = 'Password is required';
    } elseif (strlen($password) > 32) {
        $errors[] = 'Password cannot have more than 32 characters';
    } elseif ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match';
    }

    // If there are no errors, execute the db transactions
    if (empty($errors)) {
        // Try-catch block to execute the needed operations in the db and catch any error
        try {

            
            // Set the sql statement
            $sql = 'SELECT id FROM tb_users WHERE email = :email LIMIT 1';

            // Prepare the SQL statement
            $stmt = $pdo->prepare($sql);

            // Execute the statement by passing the parameters and saves
            $stmt->execute(
                [
                    'email' => $email
                ]
            );

            // Get the user
            $user = $stmt->fetch(PDO::FETCH_OBJ);

            // If the user is empty, throw an exception
            if (!empty($user)) {
                throw new Exception('User/email already exists');
            }


            // Set the variables to encrypt the password
            $currentDatetime = date('Y-m-d H:i:s'); // Equivalent to NOW() in MySQL
            $saltValue = bin2hex(random_bytes(16)); // Equivalent to UUID() in MySQL, used to generates a 32-character random string
            $hashedPassword = hash('sha256', $password . $saltValue); // Equivalent to the SHA2 in MySQL, used to hash the password

            // Set the statement that will be executed
            $sql = '
                INSERT INTO tb_users 
                (
                    first_name,
                    last_name,
                    sex,
                    email,
                    password_hash,
                    salt,
                    register_date,
                    phone_number,
                    picture_path,
                    birth_date,
                    address_line_1,
                    address_line_2,
                    postal_code,
                    city,
                    state_province,
                    country,
                    status
                ) VALUES 
                (
                    :first_name,
                    :last_name,
                    :sex,
                    :email,
                    :password_hash,
                    :salt,
                    :register_date,
                    :phone_number,
                    :picture_path,
                    :birth_date,
                    :address_line_1,
                    :address_line_2,
                    :postal_code,
                    :city,
                    :state_province,
                    :country,
                    :status
                );
            ';

            // Prepare the SQL statement
            $stmt = $pdo->prepare($sql);

            // Execute the statement by passing the parameters and saves
            $stmt->execute(
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'sex' => $sex,
                    'email' => $email,
                    'password_hash' => $hashedPassword,
                    'salt' => $saltValue,
                    'register_date' => $currentDatetime,
                    'phone_number' => $phoneNumber,
                    'picture_path' => '', // Will be updated after the insert is done
                    'birth_date' => $birthDate,
                    'address_line_1' => $addressLine1,
                    'address_line_2' => $addressLine2,
                    'postal_code' => $postalCode,
                    'city' => $city,
                    'state_province' => $province,
                    'country' => $country,
                    'status' => $status
                ]
            );

            // Get the ID of the inserted user
            $userId = $pdo->lastInsertId();

            // Handle the profile picture upload
            if (isset($_FILES['profile-picture']) && $_FILES['profile-picture']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['profile-picture']['tmp_name'];
                $fileName = $_FILES['profile-picture']['name'];
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

                // Set the destination path for the uploaded file
                $newFileName = 'user_picture_' . $userId . '.' . $fileExtension;
                $destinationPath = 'images/users/' . $newFileName;

                // Move the uploaded file to the destination directory
                if (move_uploaded_file($fileTmpPath, $destinationPath)) {
                    // Update the picture_path in the database
                    $stmt = $pdo->prepare('UPDATE tb_users SET picture_path = :picture_path WHERE id = :user_id');
                    $stmt->execute([
                        'picture_path' => $destinationPath,
                        'user_id' => $userId,
                    ]);
                }
            }
        } catch (Exception $e) {
            // Add the error to the error list
            $errors[] = $e->getMessage();
        }
    }

    // If there are no errors, redirects to the login page so the user can login
    if (empty($errors)) {

        // Save the logged user in the session
        $_SESSION['user_id'] = $userId;

        // Redirect to the login page
        header("Location: index.php");

        // Ensure that no further code is executed after the redirection
        exit();
    } else { // As there are errors, display them
        // Set the errors message
        foreach ($errors as $error) {
            $errorMessages = $errorMessages . '<span>' . $error . '</span><br>';
        }
    }
}

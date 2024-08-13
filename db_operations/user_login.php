<?php

// Include database config file => to get our PDO object 
require_once 'config/db_config.php';

// If the request method received was a post, execute the codes
// this is important so, when the page first load there's no error thrown
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Set the variables
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Create the errors array
    $errors = [];
    $errorMessages = '';

    // Validate email
    if (empty($email)) {
        $errors[] = 'Email is required';
    }

    // Validate passwords
    if (empty($password)) {
        $errors[] = 'Password is required';
    }

    // If there are no errors, execute the db transactions
    if (empty($errors)) {
        // Try-catch block to execute the needed operations in the db and catch any error
        try {

            // Set the sql statement
            $sql = 'SELECT id, password_hash, salt, status FROM tb_users WHERE email = :email LIMIT 1';

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
            if (empty($user)) {
                throw new Exception('User not found');
            }

            // Set the variables to encrypt the password
            $hashedPassword = hash('sha256', $password . $user->salt); // Equivalent to the SHA2 in MySQL, used to hash the password

            // Check if the password hash is the same
            if ($user->password_hash != $hashedPassword) {
                throw new Exception('Incorrect password');
            }

            // If the user is not active, throw an exception
            if ($user->status != 'A') {
                throw new Exception('Inactive user');
            }

        } catch (Exception $e) {
            // Add the error to the error list
            $errors[] = $e->getMessage();
        }
    }

    // If there are no errors, redirects to the login page so the user can login
    if (empty($errors)) {
        // Start the session
        session_start();

        // Save the logged user in the session
        $_SESSION['user_id'] = $user->id;

        // Redirect to another page
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

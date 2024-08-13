<?php

// Include database config file => to get our PDO object 
require_once 'config/db_config.php';

// If the request method received was a post, execute the codes
// this is important so, when the page first load there's no error thrown
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Set the variables for the values
    $userId = trim($_POST['user_id']);
    $currentPassword = trim($_POST['current-password']);
    $newPassword = trim($_POST['new-password']);
    $confirmPassword = trim($_POST['confirm-password']);

    // Create the errors array
    $errors = [];
    $errorMessages = '';
    $successMessage = '';

    // Validate current password
    if (empty($currentPassword)) {
        $errors[] = 'Current password is required';
    }
    
    // Validate new password
    if (empty($newPassword)) {
        $errors[] = 'New password is required';
    } elseif (strlen($newPassword) > 32) {
        $errors[] = 'New password cannot have more than 32 characters';
    } elseif ($newPassword !== $confirmPassword) {
        $errors[] = 'New password and the confirmation does not match';
    }

    // If there are no errors, execute the db transactions
    if (empty($errors)) {
        // Try-catch block to execute the needed operations in the db and catch any error
        try {

            // Set the sql statement
            $sql = 'SELECT id, password_hash, salt, status FROM tb_users WHERE id = :id LIMIT 1';

            // Prepare the SQL statement
            $stmt = $pdo->prepare($sql);

            // Execute the statement by passing the parameters and saves
            $stmt->execute(
                [
                    'id' => $userId
                ]
            );

            // Get the user
            $user = $stmt->fetch(PDO::FETCH_OBJ);

            // If the user is empty, throw an exception
            if (empty($user)) {
                throw new Exception('User not found');
            }

            // Set the variables to encrypt the password
            $hashedPassword = hash('sha256', $currentPassword . $user->salt); // Equivalent to the SHA2 in MySQL, used to hash the password

            // Check if the password hash is the same
            if ($user->password_hash != $hashedPassword) {
                throw new Exception('Incorrect current password');
            }

            // Set the variables to encrypt the new password
            $hashedPassword = hash('sha256', $newPassword . $user->salt); // Equivalent to the SHA2 in MySQL, used to hash the password

            // Set the statement that will be executed
            $sql = '
                UPDATE tb_users SET
                    password_hash = :password_hash
                WHERE id = :user_id;
            ';

            // Prepare the SQL statement
            $stmt = $pdo->prepare($sql);

            // Execute the statement by passing the parameters and saves
            $stmt->execute(
                [
                    'user_id' => $userId,
                    'password_hash' => $newPassword,
                ]
            );
        } catch (Exception $e) {
            // Add the error to the error list
            $errors[] = $e->getMessage();
        }
    }

    // If there are no errors, redirects to the login page so the user can login
    if (empty($errors)) {
        //header("Location: profile.php");
        $errorMessages = null;
        $successMessage = 'Password changed successfully!';
        // Redirect to the login page
        //
    } else { // As there are errors, display them
        $successMessage = null;
        // Set the errors message
        foreach ($errors as $error) {
            $errorMessages = $errorMessages . '<span>' . $error . '</span><br>';
        }
    }
}

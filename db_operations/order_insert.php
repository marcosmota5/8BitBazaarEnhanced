<?php

// Include database config file => to get our PDO object 
require_once '../config/db_config.php';

// If the request method received was a post, execute the codes
// this is important so, when the page first load there's no error thrown
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Start the session
    session_start();

    // Set the sql statement
    $sql = 'SELECT id, first_name, last_name, email, phone_number, picture_path, status FROM tb_users WHERE id = :id LIMIT 1';

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

    // Codes and quantities
    $productIds = explode(";", $_POST['product_ids']);
    $quantities = explode(";", $_POST['quantities']);
    $total = $_POST['total'];
    $name = trim($_POST['name']);
    $phoneNumber = $_POST['phone-number'];
    $addressLine1 = trim($_POST['address-line-1']);
    $addressLine2 = trim($_POST['address-line-2']);
    $postalCode = trim($_POST['postal-code']);
    $country = trim($_POST['country']);
    $province = trim($_POST['province']);
    $city = trim($_POST['city']);

    // Set the default timezone to EST
    date_default_timezone_set('America/Toronto');

    // Get the current date and time in EST
    $orderDateTime = date('Y-m-d H:i:s');
    $orderCode = "";

    // Create the errors array
    $errors = [];
    $errorMessages = '';

    // If there are no errors, execute the db transactions
    if (empty($errors)) {
        // Try-catch block to execute the needed operations in the db and catch any error
        try {
            // Set the statement that will be executed
            $sql = '
                INSERT INTO tb_orders 
                (
                    order_date,
                    total_amount,
                    user_id,
                    recipient_name,
                    phone_number,
                    address_line_1,
                    address_line_2,
                    postal_code,
                    city,
                    state_province,
                    country
                ) VALUES 
                (
                    :order_date,
                    :total_amount,
                    :user_id,
                    :recipient_name,
                    :phone_number,
                    :address_line_1,
                    :address_line_2,
                    :postal_code,
                    :city,
                    :state_province,
                    :country
                );
            ';

            // Prepare the SQL statement
            $stmt = $pdo->prepare($sql);

            // Execute the statement by passing the parameters and saves
            $stmt->execute(
                [
                    'order_date' => $orderDateTime,
                    'total_amount' => $total,
                    'user_id' => $user->id,
                    'recipient_name' => $name,
                    'phone_number' => $phoneNumber,
                    'address_line_1' => $addressLine1,
                    'address_line_2' => $addressLine2,
                    'postal_code' => $postalCode,
                    'city' => $city,
                    'state_province' => $province,
                    'country' => $country,
                ]
            );

            // Get the ID of the inserted user
            $orderId = $pdo->lastInsertId();
            $orderCode = str_pad($orderId, 10, '0', STR_PAD_LEFT);

            // Set the statement that will be executed
            $sql = 'UPDATE tb_orders SET code = LPAD(:id, 10, \'0\') WHERE id = :id;';

            // Prepare the SQL statement
            $stmt = $pdo->prepare($sql);

            // Execute the statement by passing the parameters and saves
            $stmt->execute(
            [
                'id' => $orderId
            ]
            );

            // Loop through the array using a normal for loop
            for ($i = 0; $i < count($productIds); $i++) {

                // Set the statement that will be executed
                $sql = '
                    INSERT INTO tb_order_items 
                    (
                        order_id,
                        product_id,
                        quantity,
                        price,
                        discount,
                        total_price
                    ) VALUES 
                    (
                        :order_id,
                        :product_id,
                        :quantity,
                        (SELECT price FROM tb_products WHERE id = :product_id LIMIT 1),
                        (SELECT discount FROM tb_products WHERE id = :product_id LIMIT 1),
                        (SELECT (price * (1 - discount)) * :quantity FROM tb_products WHERE id = :product_id LIMIT 1)
                    );
                ';

                // Prepare the SQL statement
                $stmt = $pdo->prepare($sql);

                // Execute the statement by passing the parameters and saves
                $stmt->execute(
                    [
                        'order_id' => $orderId,
                        'product_id' => $productIds[$i],
                        'quantity' => $quantities[$i]
                    ]
                );
                
                // Set the statement that will be executed
                $sql = '
                    UPDATE tb_products SET quantity_in_stock = quantity_in_stock - :quantity WHERE id = :product_id;
                ';

                // Prepare the SQL statement
                $stmt = $pdo->prepare($sql);

                // Execute the statement by passing the parameters and saves
                $stmt->execute(
                    [
                        'product_id' => $productIds[$i],
                        'quantity' => $quantities[$i]
                    ]
                );
            }
        } catch (Exception $e) {
            // Add the error to the error list
            $errors[] = $e->getMessage();
        }
    }

    // If there are no errors, redirects to the login page so the user can login
    if (empty($errors)) { 
        // Set the order id
        $_SESSION['order_id'] = $orderId;

        // Redirect to another page
        header("Location: ../receipt.php");

        // Ensure that no further code is executed after the redirection
        exit();
    } else {
        // Set the errors message
        foreach ($errors as $error) {
            $errorMessages = $errorMessages . '<span>' . $error . '</span><br>';
        }
    }
}

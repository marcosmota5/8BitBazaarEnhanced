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
    <link rel="stylesheet" href="css/style-receipt.css" />
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />

    <!-- Google Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <!-- Page-level header -->
    <header>
        <?php

        include("templates/header.php");

        // Set a variable to set the order
        $order = null;

        // If the order is set in the session, get the user information
        if (isset($_SESSION['order_id'])) {

            // Include database config file => to get our PDO object 
            require_once 'config/db_config.php';

            // Set the sql statement
            $sql = 'SELECT * FROM tb_orders WHERE id = :id LIMIT 1';

            // Prepare the SQL statement
            $stmt = $pdo->prepare($sql);

            // Execute the statement by passing the parameters and saves
            $stmt->execute(
                [
                    'id' => $_SESSION['order_id']
                ]
            );

            // Get the order
            $order = $stmt->fetch(PDO::FETCH_OBJ);
        }

        if (!isset($order) || $order === false) {
            echo 'No order found';
            exit();
        }

        ?>
    </header>
    <main class="main-content-receipt">
        <!-- Receipt section that displays the order details -->
        <div class="receipt">
            <h2>8 Bit Bazaar</h2>
            <br>
            <h3>Your order has been received!</h3>
            <p>Please, check the details below.</p>
            <br>
            <br>
            <!-- Receipt details section -->
            <div class="receipt-details">
                <h4>Order Details:</h4>
                <ul>
                    <li>Date time of the order: <?php echo $order->order_date; ?></li>
                    <li>Order number: <?php echo $order->code; ?></li>
                </ul>
                <h4>Items:</h4>
                <ul>
                    <?php
                    // Code to include the products in deal

                    // Include database config file => to get our PDO object 
                    require_once 'config/db_config.php';

                    // Set the sql statement
                    $sql = 'SELECT o.product_id, p.name AS product_name, o.quantity, (o.price * (1 - o.discount)) AS price, o.total_price FROM tb_order_items AS o 
                    INNER JOIN tb_products AS p ON p.id = o.product_id
                    WHERE o.order_id = :order_id;';

                    // Prepare the SQL statement
                    $stmt = $pdo->prepare($sql);

                    // Execute the statement by passing the parameters and saves
                    $stmt->execute(
                        [
                            'order_id' => $order->id
                        ]
                    );

                    // Get the products
                    $orderItems = $stmt->fetchAll(PDO::FETCH_OBJ);

                    // If any product was found, add it
                    if ($stmt->rowCount() > 0) {
                        // Print the products
                        foreach ($orderItems as $orderItem) {
                            echo '<li id="' . $orderItem->product_id . '">' . $orderItem->product_name . '. Quantity: ' . $orderItem->quantity . '. Value: <span class="price-new">$ ' . round($orderItem->price, 2) . '</span>. Total: <span class="price-new">$ ' . round($orderItem->total_price, 2) . '</span></li>';
                        }
                    }
                    ?>
                </ul>
                <h4>Total: <span id="total-value">$ <?php echo $order->total_amount; ?></span></h4>
                <h4>Contact Information:</h4>
                <ul>
                    <li>Recipient name: <?php echo $order->recipient_name; ?></li>
                    <li>Phone number: <?php echo $order->phone_number; ?></li>
                    <li>Address line 1: <?php echo $order->address_line_1; ?></li>
                    <li>Address line 2: <?php echo $order->address_line_2; ?></li>
                    <li>Postal code: <?php echo $order->postal_code; ?></li>
                    <li>Country: <?php echo $order->country; ?></li>
                    <li>State/province: <?php echo $order->state_province; ?></li>
                    <li>City: <?php echo $order->city; ?></li>
                </ul>
                <br>
            </div>
            <p>Thank you for your order!</p>
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
    <script>
        updateReceiptItems();
    </script>
</body>

</html>
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
    <title>My Orders | 8 Bit Bazaar</title>
    <meta name="author" content="" />
    <meta name="description" content="Website of old products">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css" />

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
        ?>
    </header>
    <main class="main-content-register">
        <h2>Orders</h2>
        <div class="table-content">
            <?php
            // Code to include the products in deal

            // Include database config file => to get our PDO object 
            require_once 'config/db_config.php';

            // Get the user's orders
            $sql = 'SELECT * FROM tb_orders WHERE user_id = :user_id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $_SESSION['user_id']]);
            $orders = $stmt->fetchAll(PDO::FETCH_OBJ);

            // Get the items for all orders
            $sql = 'SELECT oi.*, p.code AS product_code, p.picture_path AS product_picture_path, p.name AS product_name FROM tb_order_items AS oi INNER JOIN tb_products AS p ON p.id = oi.product_id WHERE oi.order_id IN (SELECT id FROM tb_orders WHERE user_id = :user_id)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $_SESSION['user_id']]);
            $order_items = $stmt->fetchAll(PDO::FETCH_OBJ);

            // Create an array to hold items grouped by order_id
            $order_items_by_order = [];
            foreach ($order_items as $item) {
                $order_items_by_order[$item->order_id][] = $item;
            }

            // If there are any orders, print the order table
            if ($orders) {
                echo '<table class="table-fill">';
                echo '<tr><th>Order Code</th><th>Order Date</th><th>Total Amount</th><th>Recipient</th><th>Action</th></tr>';

                foreach ($orders as $order) {
                    echo '<tr>';
                    echo '<td>' . $order->code . '</td>';
                    echo '<td>' . $order->order_date . '</td>';
                    echo '<td>$' . $order->total_amount . '</td>';
                    echo '<td>' . $order->recipient_name . '</td>';
                    echo '<td><button onclick="toggleOrderItems(' . $order->id . ')">View items</button>  <button onclick="showReceipt(' . $order->id . ')">View receipt</button></td>';
                    echo '</tr>';

                    // Now add a row for the order items, which will be hidden initially
                    if (isset($order_items_by_order[$order->id])) {
                        echo '<tr id="order-items-' . $order->id . '" style="display:none;">';
                        echo '<td colspan="5">';
                        echo '<table border="1" cellpadding="5">';
                        echo '<tr><th>Code</th><th>Image</th><th>Name</th><th>Quantity</th><th>Price</th><th>Discount</th><th>Total Price</th></tr>';
                        foreach ($order_items_by_order[$order->id] as $item) {
                            echo '<tr>';
                            echo '<td>' . $item->product_code . '</td>';
                            echo '<td><img src="' . $item->product_picture_path . '" alt="Product Image" class="product-image"></td>';
                            echo '<td>' . $item->product_name . '</td>';
                            echo '<td>' . $item->quantity . '</td>';
                            echo '<td>$ ' . $item->price . '</td>';
                            echo '<td>' . $item->discount * 100 . '%</td>';
                            echo '<td>$ ' . $item->total_price . '</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                        echo '</td>';
                        echo '</tr>';
                    }
                }

                echo '</table>';
            } else {
                echo '<p>No orders found.</p>';
            }
            ?>
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
        function toggleOrderItems(orderId) {
            var orderItemsRow = document.getElementById('order-items-' + orderId);
            if (orderItemsRow.style.display === 'none' || orderItemsRow.style.display === '') {
                orderItemsRow.style.display = 'table-row';
            } else {
                orderItemsRow.style.display = 'none';
            }
        }

        function showReceipt(orderId) {
            // Create a form element
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'receipt.php';

            // Create an input element for the order_id
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'order_id';
            input.value = orderId;

            // Append the input to the form and the form to the body
            form.appendChild(input);
            document.body.appendChild(form);

            // Submit the form
            form.submit();
        }
    </script>
</body>

</html>
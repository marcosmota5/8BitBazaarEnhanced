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
    <title>Cart | 8 Bit Bazaar</title>
    <meta name="author" content="" />
    <meta name="description" content="Website of old products">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/style-shopping-cart.css" />
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
        ?>
    </header>
    <main>
        <h1 class="cart-title">Shopping Cart</h1>
        <div class="cart-items">
            <?php
            // Code to include the products in deal
            
            // Include database config file => to get our PDO object 
            require_once 'config/db_config.php';

            // Set the sql statement
            $sql = 'SELECT * FROM tb_products WHERE status = :status AND quantity_in_stock > 0';

            // Prepare the SQL statement
            $stmt = $pdo->prepare($sql);

            // Execute the statement by passing the parameters and saves
            $stmt->execute(
                [
                    'status' => 'A'
                ]
            );

            // Get the products
            $products = $stmt->fetchAll(PDO::FETCH_OBJ);

            // If any product was found, add it
            if ($stmt->rowCount() > 0) {
                // Print the products
                foreach ($products as $product) {

                    // Creates the variable to hold the quantity options
                    $quantityOptions = '';

                    // For to add the options based on the quantity in stock
                    for ($i = 1; $i <= $product->quantity_in_stock; $i++) {
                        $quantityOptions = $quantityOptions . '<option value="' . $i . '">' . $i . '</option>';
                    }

                    echo '
                    <div class="cart-item" id="' . $product->code . '" style="display: none">
                        <div class="delete-button" onclick="deleteCartItem(\'' . $product->code . '\')">
                            <span class="material-symbols-outlined">
                                close
                            </span>
                        </div>
                        <div class="cart-item-image-wrapper">
                            <img src="' . $product->picture_path . '" alt="Cart Item Image" class="cart-item-image">
                        </div>
                        <div class="cart-item-details">
                            <h2 class="cart-item-name">' . $product->name . '</h2>
                        </div>
                        <div class="form-field">
                            <select class="input-box" id="quantity" name="quantity" onChange="updateCartItems()">
                                ' . $quantityOptions . '
                            </select>
                        </div>
                        <div class="cart-item-price">
                            <span class="cart-item-price-new">$ ' . round(($product->price * (1 - $product->discount)), 2) . '</span>
                        </div>
                    </div>
                ';
                }
            }
            ?>
        </div>
        <h2 class="cart-total">Total: <span id="total-value">$ 0</span></h2>
        <form action="<?php echo isset($_SESSION['user_id']) ? "checkout.php" : "login.php" ?>" id="form-checkout"
            method="<?php echo isset($_SESSION['user_id']) ? "POST" : "GET" ?>">
            <input style="display: none;" type="text" id="product_ids" name="product_ids">
            <input style="display: none;" type="text" id="quantities" name="quantities">
            <input style="display: none;" type="text" id="total" name="total">
            <input class="proceed-to-checkout-btn" type="submit" value="Proceed to Checkout" />
        </form>

    </main>
    <!-- Page-level footer -->
    <footer>
        <?php
        include ("templates/footer.php");
        ?>
    </footer>
    <script src="scripts/scripts.js"></script>
    <script>
        updateCartItems();
    </script>
</body>

</html>
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
    <title>Products | 8 Bit Bazaar</title>
    <meta name="author" content="" />
    <meta name="description" content="Website of old products">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/style-products.css" />
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
    <main>
        <div class="welcome">
            <span class="welcome-title">Products</span>
        </div>
        <div class="">
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
                    echo '
                    <div class="product" id="' . $product->code . '">
                        <div class="product-image-wrapper">
                            <img src="' . $product->picture_path . '" alt="Product Image" class="product-image">
                            ' . ((bool)$product->is_deal ? '<img src="images/hot-deal.png" alt="Hot Deal" class="hot-deal">' : '') . '
                        </div>
                        <div class="product-details">
                            <h2 class="product-name">' . $product->name . '</h2>
                            <p class="type">' . $product->type . '</p>
                            <div class="price">
                                <span class="price-old">$ ' . round($product->price, 2) . '</span>
                                <span class="price-new">$ ' . round(($product->price * (1 - $product->discount)), 2) . '</span>
                            </div>
                            <span class="product-quantity">Quantity: ' . $product->quantity_in_stock . '</span>
                            <p class="description">' . $product->description . '</p>
                            <button class="add-to-cart-btn" onclick="addToCart(\'' . $product->code . '\')">Add to cart</button>
                        </div>
                    </div>
                ';
                }
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
</body>

</html>
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
    <title>Home | 8 Bit Bazaar</title>
    <meta name="author" content="" />
    <meta name="description" content="Website of old products">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css" />
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
            <span class="welcome-title">Welcome to 8 Bit Bazaar!</span>
            <span class="welcome-subtitle">Here you can find everything you love from old times.</span>
        </div>
        <div class="cards">
            <div class="card">
                <img src="images/Cul-ars-vidgames-954038980.webp" alt="img" class="card-image">
                <div class="card-content">
                    <h2 class="card-title">RETRO RAID</h2>
                    <p class="card-subtitle">Level up your collection!</p>
                </div>
            </div>
            <div class="card">
                <img src="images/y2ZOW9.png" alt="img" class="card-image">
                <div class="card-content">
                    <h2 class="card-title">VINTAGE QUEST</h2>
                    <p class="card-subtitle">Discover classic adventures!</p>
                </div>
            </div>
            <div class="card">
                <img src="images/metroid.webp" alt="img" class="card-image">
                <div class="card-content">
                    <h2 class="card-title">GAME LEGACY</h2>
                    <p class="card-subtitle">Get the icons of history!</p>
                </div>
            </div>
        </div>
        <div class="description2">
            <div class="description2-element-1">
                <span class="material-symbols-outlined">
                    local_shipping
                </span>
                <span>
                    <h3>Free Shipping</h3>
                    <p>Free shipping on all orders</p>
                </span>
            </div>
            <div class="description2-element-2">
                <span class="material-symbols-outlined">
                    support_agent
                </span>
                <span>
                    <h3>Support 24/7</h3>
                    <p>Support 24 hours a day</p>
                </span>
            </div>
            <div class="description2-element-3">
                <span class="material-symbols-outlined">
                    replay
                </span>
                <span>
                    <h3>30 Days Returns</h3>
                    <p>30 days free returns</p>
                </span>
            </div>
            <div class="description2-element-3">
                <span class="material-symbols-outlined">
                    star
                </span>
                <span>
                    <h3>High Quality</h3>
                    <p>Best quality products</p>
                </span>
            </div>
        </div>

        <?php
        // Code to include the products in featured deals

        // Include database config file => to get our PDO object 
        require_once 'config/db_config.php';

        // Set the sql statement
        $sql = 'SELECT * FROM tb_products WHERE status = :status AND quantity_in_stock > 0 AND is_featured_deal = 1';

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

        // If any product in deal was found, add it
        if ($stmt->rowCount() > 0) {
            
            // Print the title
            echo '<h2 class="featured-deals-title">Featured Deals</h2>';

            // Print the feature deals div
            echo '<div class="featured-deals">';

            // Print the products
            foreach ($products as $product) {
                echo '
                    <div class="product" id="' . $product->code . '">
                        <div class="product-image-container">
                            <img class="product-image" src="' . $product->picture_path . '" alt="Product Image" class="product-image">
                            <img src="images/hot-deal.png" alt="Hot Deal" class="hot-deal">
                        </div>
                        <div class="product-detail">
                            <span class="product-title">' . $product->name . '</span>
                            <div class="product-price">
                                <span class="product-price-old">$' . round($product->price, 2) . '</span>
                                <span class="product-price-new">$' . round(($product->price * (1- $product->discount)), 2) . '</span>
                            </div>
                            <span class="product-quantity">Quantity: ' . $product->quantity_in_stock . '</span>
                            <button class="add-to-cart-btn" onclick="addToCart(\'' . $product->code . '\')">Add to cart</button>
                        </div>
                    </div>
                ';
            }

            // Print the closing div
            echo '</div>';
        }
        ?>

        <div class="newsletter">
            <h2>Newsletter</h2>
            <p>Subscribe to our newsletter to receive the last deals</p>
            <form action="subscribe.php" method="get">
                <label class="input-label" for="emailAddress">Email</label>
                <input class="input-box" type="email" name="emailAddress" id="emailAddress" required />
                <button class="input-button" type="submit">Subscribe</button>
            </form>
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
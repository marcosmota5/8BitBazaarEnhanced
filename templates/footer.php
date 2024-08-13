<div class="footer-menu">
    <a href="index.php">Home</a>
    <a href="deals.php">Deals</a>
    <a href="products.php">Products</a>
    <?php
    // If the user is not empty, show the orders option
    if (!empty($user)) {
        echo '
                <a href="orders.php">My orders</a>
                ';
    }
    ?>
    <a href="contact.php">Contact</a>
    <a href="about.php">About</a>
</div>
<div class="footer-info">
    <span>
        <p>8 Bit Bazaar © All Rights Reserved</p>
    </span>
    <span>
        <p>Toronto, Ontario</p>
    </span>
    <span>
        <p>Phone +1 333 333 3333</p>
        <p>Email: contact@8bitbazaar.net</p>
    </span>
</div>
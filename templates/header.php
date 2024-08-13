<?php

// Set a variable to check if the user exists
$user = null;

// If the user_id is set in the session, get the user information
if (isset($_SESSION['user_id'])) {

    // Include database config file => to get our PDO object 
    require_once 'config/db_config.php';

    // Set the sql statement
    $sql = 'SELECT first_name, last_name, email, phone_number, picture_path, status FROM tb_users WHERE id = :id LIMIT 1';

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
}
?>
<nav>
    <!-- Div that holds the logo and the company name. When clicked, it redirects to the home page -->
    <div class="logo" onclick="window.location.href='index.php'">
        <img src="images/favicon.png" alt="Company Logo">
        <span class="company-name">8 Bit Bazaar</span>
    </div>
    <!-- Div that holds the options for the user to navigate through the website -->
    <div class="options">
        <a href="index.php"><span class="material-symbols-outlined">
                home
            </span>&nbsp;Home</a>
        <a href="deals.php"><span class="material-symbols-outlined">
                sell
            </span>&nbsp;Deals</a>
        <a href="products.php"><span class="material-symbols-outlined">
                storefront
            </span>&nbsp;Products</a>
        <?php
        // If the user is not empty, show the orders option
        if (!empty($user)) {
            echo '
                    <a href="orders.php"><span class="material-symbols-outlined">
                            list_alt
                    </span>&nbsp;My orders</a>
                ';
        }
        ?>
        <a href="contact.php"><span class="material-symbols-outlined">
                phone
            </span>&nbsp;Contact</a>
        <a href="about.php"><span class="material-symbols-outlined">
                info
            </span>&nbsp;About</a>
    </div>
    <!-- Div to the right part -->
    <div class="user-and-shopping-cart">
        <?php
        // If the user is not empty, show user information, otherwise show the sign in/up info
        if (!empty($user)) {
            echo '
                <div class="user-mini-info">
                    <a href="#" id="user-mini-info" data-count=""><img src="' . $user->picture_path . '" alt="User Picture">&nbsp;<span class="user-mini-info-text">' . $user->first_name . '</span><span class="material-symbols-outlined">
                            arrow_drop_down
                        </span></a>
                    <div id="user-popup" class="user-popup-content">
                        <div class="profile-and-logout">
                            <a href="profile.php"><span class="material-symbols-outlined">
                                    user_attributes
                                </span>&nbsp;My profile</a>
                            <a href="logout.php" class="logout-popup-button"><span class="material-symbols-outlined">
                                    logout
                                </span><span>&nbsp;Logout</span></a>
                        </div>
                        <div class="picture-and-details">
                            <div class="picture">
                                <img src="' . $user->picture_path . '" alt="User Picture">
                            </div>
                            <div class="details">
                                <div>
                                    <span class="material-symbols-outlined">
                                        person
                                    </span>&nbsp;' . $user->first_name . ' ' . $user->last_name . '
                                </div>
                                <div>
                                    <span class="material-symbols-outlined">
                                        phone
                                    </span>&nbsp;' . $user->phone_number . '
                                </div>
                                <div>
                                    <span class="material-symbols-outlined">
                                        email
                                    </span>&nbsp;' . $user->email . '
                                </div>
                            </div>
                        </div>
                        <div class="change-password">
                            <a href="change-password.php"><span class="material-symbols-outlined">
                            lock_reset
                                </span>&nbsp;Change password</a>
                        </div>
                    </div>
                </div>
                ';
        } else {
            echo '
                <div class="user-sign-in-up">
                    <a href="#" id="sign-in-up" data-count=""><span class="material-symbols-outlined">
                            person
                        </span>&nbsp;Sign in/up<span class="material-symbols-outlined">
                            arrow_drop_down
                        </span></a>
                    <!-- Popup content -->
                    <div id="sign-in-up-popup" class="sign-in-up-popup-content">
                        <span>Already an user?</span>
                        <a href="login.php" class="login-popup-button"><span>Login</span></a>
                        <br>
                        <div class="section-divider"></div>
                        <br>
                        <span>Not an user yet?</span>
                        <a href="register.php" class="register-popup-button"><span>Register</span></a>
                    </div>
                </div>
            ';
        }
        ?>


        <!-- <div class="user-logout">
            <a href="logout.php" id="logout" data-count=""><span class="material-symbols-outlined">
                    logout
                </span>&nbsp;Logout</a>
        </div> -->
        <div class="shopping-cart">
            <a href="cart.php" id="cart" data-count=""><span class="material-symbols-outlined">
                    shopping_cart
                </span>&nbsp;<span class="cart-text">Cart</span></a>
        </div>
    </div>

    <div class="menu-toggle">
        <span id="menu-icon" class="material-symbols-outlined">menu</span>
    </div>
    <div class="overlay-menu">
        <!-- Menu options -->
        <a class="first" href="index.php"><span class="material-symbols-outlined">
                home
            </span>&nbsp;Home</a>
        <a href="deals.php"><span class="material-symbols-outlined">
                sell
            </span>&nbsp;Deals</a>
        <a href="products.php"><span class="material-symbols-outlined">
                storefront
            </span>&nbsp;Products</a>
        <?php
        // If the user is not empty, show the orders option
        if (!empty($user)) {
            echo '
                    <a href="orders.php"><span class="material-symbols-outlined">
                            list_alt
                    </span>&nbsp;My orders</a>
                ';
        }
        ?>
        <a href="contact.php"><span class="material-symbols-outlined">
                phone
            </span>&nbsp;Contact</a>
        <a href="about.php"><span class="material-symbols-outlined">
                info
            </span>&nbsp;About</a>
    </div>
</nav>
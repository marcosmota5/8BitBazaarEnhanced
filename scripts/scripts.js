// Add an event to the click button in order to open the menu on small screens
document.querySelector('.menu-toggle').addEventListener('click', function () {
    this.classList.toggle('open');
    document.querySelector('.overlay-menu').classList.toggle('open');
});

// Set the session cart items
var sessionCartItems = sessionStorage.getItem("productids");

// Set the cart items array that will be used to store the cart items
var cartItems = [];

// If there's no session cart items, set the session to an empty string, otherwise get the cart items
if (sessionCartItems == null || sessionCartItems == "") {
    sessionStorage.setItem("productids", "");
}
else {
    cartItems = JSON.parse(sessionStorage.getItem("productids"));
}

// Sets the attribute of the cart count to the array length
document.getElementById("cart").setAttribute("data-count", cartItems.length);

/**
 * Adds an item to the cart, if it's not there yet.
 * 
 * @param {number} productId - The id of the product to be added.
 */
function addToCart(productId) {

    // If there's no session cart items, set the session to an empty string, otherwise get the cart items
    if (sessionCartItems == null || sessionCartItems == "") {
        sessionStorage.setItem("productids", "");
    }
    else {
        cartItems = JSON.parse(sessionStorage.getItem("productids"));
    }

    // Declares the variable to check if the item already exists in the cart
    let itemExist = false;

    // Iterates through the cart items and set if the item already exists
    for (var i = 0; i < cartItems.length; i++) {
        if (cartItems[i] == productId) {
            itemExist = true;
            break;
        }
    }

    // If the item does not exist yet, add it to the cart
    if (!itemExist) {
        cartItems.push(productId);

        sessionStorage.setItem("productids", JSON.stringify(cartItems));

        document.getElementById("cart").setAttribute("data-count", cartItems.length);

        // Show a notification
        toastr.success('Item added to cart!', 'Success');
    }
}

/**
 * Updates the cart items, including the total value.
 */
function updateCartItems() {

    // If there's no session cart items, set the session to an empty string, otherwise get the cart items
    if (sessionCartItems == null || sessionCartItems == "") {
        sessionStorage.setItem("productids", "");
    } else {
        cartItems = JSON.parse(sessionStorage.getItem("productids"));
    }

    // Set the total variable
    var total = 0;

    // Products codes and quantities
    var codes = "";
    var quantities = "";

    // Iterates through the art items and add the value to the total
    for (var i = 0; i < cartItems.length; i++) {
        var cartItem = document.getElementById(cartItems[i]);
        cartItem.style.display = 'flex';

        var prices = cartItem.querySelectorAll('.cart-item-price-new');
        var priceValue = parseFloat(prices[0].textContent.replace('$', '').trim());
        
        // Get the selected quantity
        var quantitySelect = cartItem.querySelector('select[name="quantity"]');
        var selectedQuantity = parseInt(quantitySelect.value);

        // Add the value to total
        total += priceValue * selectedQuantity;

        // Add the code
        if (codes == "") {
            codes += cartItems[i];
        } else {
            codes += ";" + cartItems[i];
        }
        
        // Add the code
        if (quantities == "") {
            quantities += selectedQuantity;
        } else {
            quantities += ";" + selectedQuantity;
        }
        
    }

    // Set the total value by passing the total variable and rounding to 2 decimal places
    document.getElementById('total-value').innerHTML = "$ " + total.toFixed(2);

    // Get the input that holds the product codes and quantities
    document.getElementById('product_ids').setAttribute("value", codes);
    document.getElementById('quantities').setAttribute("value", quantities);
    document.getElementById('total').setAttribute("value", total);

    // If the total is equal to 0, hides it
    if (total == 0) {
        document.getElementById('form-checkout').style.display = 'none';
    }
}

/**
 * Deletes an item in the cart.
 * 
 * @param {number} productId - The id of the product to be deleted.
 */
function deleteCartItem(productId) {

    // Finds the index of the productId in the cartItems array
    let index = cartItems.indexOf(productId);

    // Checks if the productId is found in the cartItems array (index > -1 indicates it's found)
    if (index > -1) {
        // If found, remove the item from the array at the specified index
        cartItems.splice(index, 1);
    }

    // Updates the session storage to reflect the new cartItems array after deletion
    sessionStorage.setItem("productids", JSON.stringify(cartItems));

    // Gets the element with the id equal to productId and sets its display style to 'none', hiding it
    document.getElementById(productId).style.display = 'none';

    // Updates the "cart" element's "data-count" attribute to reflect the new length of the cartItems array
    document.getElementById("cart").setAttribute("data-count", cartItems.length);

    // Calls updateCartItems function to handle any additional updates required after item deletion
    updateCartItems();
}

/**
 * Updates the receipt element with the items found.
 */
function updateReceiptItems() {

    // Set the product ids in the session to empty, clearing it
    sessionStorage.setItem("productids", "");

    // Set the data-count attribute to 0, meaning there's no item
    document.getElementById("cart").setAttribute("data-count", 0);
}

document.addEventListener('DOMContentLoaded', function() {
    var signInUpBtn = document.getElementById('sign-in-up');
    var signInUpPopup = document.getElementById('sign-in-up-popup');

    // Toggle the popup when the button is clicked if it's not null
    if (signInUpBtn != null) {
        signInUpBtn.addEventListener('click', function(event) {
            event.preventDefault();
            signInUpPopup.classList.toggle('show');
        });
    }

    var userProfileBtn = document.getElementById('user-mini-info');
    var userProfilePopup = document.getElementById('user-popup');

    // Toggle the popup when the button is clicked if it's not null
    if (userProfileBtn != null) {
        userProfileBtn.addEventListener('click', function(event) {
            event.preventDefault();
            userProfilePopup.classList.toggle('show');
        });
    }

    // Close the popup if the user clicks outside of it
    //window.addEventListener('click', function(event) {
    //    if (!signInUpBtn.contains(event.target) && !popup.contains(event.target)) {
    //        signInUpPopup.classList.remove('show');
    //        userProfilePopup.classList.remove('show');
    //    }
    // });
});
<?php
/* **************** MUST EXISTS IN ALL PAGES BEGGINING (before starting the cart editions) **************** */

// Running the session
session_start();
//session_destroy();

// Including the required class files
require_once 'Item.class.php';
require_once 'Cart.class.php';

// Creation of an empty cart
if(!isset($_SESSION['cart'])) $panier = new Cart();
else $panier = unserialize($_SESSION['cart']);

/* ******************************************************************************************************** */

// Creation of three initial items
$item1 = new Item(1, 'BMW', 2);
$item2 = new Item(2, 'Mercedes');
$item3 = new Item(1, 'BMW Serie 5'); // This will increase the item "1" and edit its reference's name

// Add the last items to the cart
$panier->addItem($item1);
$panier->addItem($item2);
$panier->addItem($item3);

// Add one more item
$panier->addItem(new Item(3, 'Renault', 4, 'img/renault.png'));

// Trying to add a wrong item
$panier->addItem(new Item(4, null)); // No reference => wrong

// Remove two copies from item one and rename it
//$panier->setItem(1, -2, 'New BMW');

// Remove three copies from item 3
$panier->setItem(3, -3);

/* **************** MUST EXISTS IN ALL PAGES ENDING (after finishing the cart editions) ******************* */

// Save the new cart
//$_SESSION['cart'] = serialize($panier);

/* ******************************************************************************************************** */

// Show the cart's content
var_dump($panier);
?>
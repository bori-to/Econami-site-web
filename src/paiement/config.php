<?php

if(!isset($_SESSION['email'])){
    header('location:forum.php');
    exit;
}


if (isset($_COOKIE['panier']) && !empty($_COOKIE['panier'])) {
    $panier = unserialize($_COOKIE['panier']);
}
if (isset($_COOKIE['panier']) && !empty($_COOKIE['panier'])) {  
    $prix = 0;
    $id = ' ';
    $marque = ' ';
    $reduction = 0;
    $type = ' ';
    $quantity = 0;
    foreach($panier as $contenue){
        $prix = $prix + $contenue['prix'];
        $id = $id . $contenue['id'];
        $marque = $marque . ' ' . $contenue['marque'];
        $reduction = $reduction + $contenue['reduction'];
        $type = $type . ' ' . $contenue['type'];
        $quantity = $quantity + 1;
    }
}
$productName = $marque;
$productType = $type;  
$productReduc = $reduction;
$productID = $id;  
$productPrice = $prix; 
$currency = "eur"; 

/* 
 * Stripe API configuration 
 * Remember to switch to your live publishable and secret key in production! 
 * See your keys here: https://dashboard.stripe.com/account/apikeys 
 */ 
define('STRIPE_API_KEY', 'apiKey'); 
define('STRIPE_PUBLISHABLE_KEY', 'key_public'); 
define('STRIPE_SUCCESS_URL', 'https://econami.ddns.net/paiement/succes-de-paiement.php'); //Payment success URL
// http://localhost/econami%20Online/paiement/succes-de-paiement.php

define('STRIPE_CANCEL_URL', 'https://econami.ddns.net/paiement/annulation-paiement.php'); //Payment cancel URL 
// http://localhost/econami%20Online/paiement/annulation-paiement.php
// Database configuration    
define('DB_HOST', 'IP_replace');   
define('DB_USERNAME', 'user'); 
define('DB_PASSWORD', 'password');   
define('DB_NAME', 'econami'); 
 
?>
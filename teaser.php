<?php if(!isset($_SESSION)) session_start(); ?>
<?php 
// Redirection si mauvais url rewriting
// $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// if(strpos($actual_link, 'php') == true){
//     header("location: /login"); 
// }
// // Redirection si utilisateur connecté
// if(isset($_SESSION['pseudo'])){
//     header("location: /");    
// }
?>
<!DOCTYPE html>
<html lang="fr">
<!-- IMPORTANT NOTE: This file is licensed only for use in providing the Square Cloud service,
or any part thereof, and is subject to the Square Cloud Terms and Conditions. You may not
port this file to another platform without the owner's written consent. --> 
<head>
    <meta charset="UTF-8">
    <title>Square Cloud</title>
    <!--  META  -->
    <meta name="Author" content="Loris"/>
    <meta name="keywords" content="efrei, efrei doc, documents, moodle, extranet efrei, DE, devoirs écrit, examens, ingénieur" />
    <meta name="copyright" content="Square Cloud Inc." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/layout/favicon.ico" />
    <link rel="apple-touch-icon" href="images/layout/touch-icon.png">
    <!--  CSS  -->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--  TWITTER  -->
    <!-- OPEN GRAPH -->
</head>
<?php include_once('functions.php'); ?>
<?php 
$args = array (
    "1"  => "ff691f",
    "2" => "FAB81E",
    "3"   => "169c87",
    "4"   => "e81c4f",
    "5"   => "55acee",
    "6"   => "1b95e0"
);
$rand = rand(1,6);
?>
<body id="template-login">

    <div class="center-card-login">
        <div class="logo" style="color: #<?= $args[$rand]; ?> "><span class="icon-noun-logo-sc"></span></div>
        <p class="teaser-title">A brand new Square Cloud, with a brand new logo and look is almost ready for you.</p>
    </div>

<!-- Se souvenir de moi -->
<div id="modal-souvenir" class="modal-container">
    <div class="modal">
        <div class="text-container">
            <p class="title">Se souvenir de moi</p>
            <p class="explications">Si vous cochez la case Se souvenir de moi, vous serez automatiquement connecté à Square Cloud lors de votre prochaine visite. Décochez cette option si vous ne voulez pas que d'autres personnes puissent accéder à votre compte (si, par exemple, vous utilisez un ordinateur public). Assurez-vous de bien quitter votre navigateur après vous être déconnecté de votre compte.</p>
        </div>
        <div class="modal-buttons">
            <a class="" id="close" title="">OK</a>
        </div>
    </div>
</div>

<footer class="footer-login">©<?= date('Y'); ?> Square Cloud.<br> <?= get_signature(); ?></footer>
<?php get_footer(); ?>
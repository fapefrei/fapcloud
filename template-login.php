<?php if(!isset($_SESSION)) session_start(); ?>
<?php 
// Redirection si mauvais url rewriting
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(strpos($actual_link, 'php') == true){
    header("location: /login"); 
}
// Redirection si utilisateur connecté
if(isset($_SESSION['pseudo'])){
    header("location: /");    
}
?>
<!DOCTYPE html>
<html lang="fr">
<!-- IMPORTANT NOTE: This file is licensed only for use in providing the Square Cloud service,
or any part thereof, and is subject to the Square Cloud Terms and Conditions. You may not
port this file to another platform without the owner's written consent. --> 
<head>
    <meta charset="UTF-8">
    <title>Square Cloud / Login</title>
    <!--  META  -->
    <meta name="Author" content="Loris"/>
    <meta name="description" content="Validez toutes vos matières." />
    <meta name="keywords" content="efrei, efrei doc, documents, moodle, extranet efrei, DE, devoirs écrit, examens, ingénieur" />
    <meta name="copyright" content="Square Cloud Inc." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/layout/favicon.ico" />
    <link rel="apple-touch-icon" href="images/layout/touch-icon.png">
    <!--  CSS  -->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <?php include('parts/open-graph.php'); ?>
</head>
<?php include_once('functions.php'); ?>
<?php 
// Remember me
test_cookie(); 
?>
<body id="template-login">

    <div class="center-card-login">
        <div class="logo"><span class="icon-noun-logo-sc"></span></div>
        <?php if (isset($_COOKIE['AUTH'])) { ?>
            <img style="margin: auto !important; text-align: center !important;" src="images/layout/loader.gif">
            <p id="logout">Réinitialiser</p>
        <?php }else{ ?>
        <form autocomplete="on" id="login-form" action="/functions.php" method="post">
            <input required id="user_login" class="input" type="email" name="email" placeholder="Email Efrei/Esigetel">
            <input required id="user_password" class="input" type="password" name="password" placeholder="Mot de passe">
            <div class="checkbox-container">
                <input type="checkbox" id="stay" name="stay">
                <label for="stay">Se souvenir de moi sur cet appareil.</label>
                <p id="souvenir"><i class="material-icons">help_outline</i></p>
            </div>
            <input class="submit" type="submit" value="Se connecter">
            <!-- <p id="erreur"></p> -->
            <p id="password-reset" class="password-reset-link">Mot de passe oublié ?</p>
        </form>
        <?php } ?>
    </div>

<!-- MOT DE PASSE OUBLIE -->
<div id="action-view-password-reset" class="action-view-container">
    <div class="action-view">
        <div class="navbar">
            <p class="title">Mot de passe oublié</p>
            <a id="close" class="button">Annuler</a>
            <!-- <a id="valide" class="button">Valider</a> -->
        </div>
        <div class="action-view-content">
            <form id="password-reset-form" class="form" method="POST" action="">
                <p class="explications">Nous vous enverrons les instructions de réinitialisation de votre mot de passe par e-mail.</p>
                <p>(Essayez de ne pas l'oublier cette fois-ci ! 😅)</p>
                <br>
                <input required id="email" class="input" type="email" placeholder="Email Efrei">
                <input class="submit" type="submit" value="Réinitialiser">
            </form>
        </div>
    </div>
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

<!-- Message -->
<div class="mesage">
    <p></p>
</div>

<footer class="footer-login">©<?= date('Y'); ?> Square Cloud.<br> <?= get_signature(); ?></footer>

<?php get_footer(); ?>


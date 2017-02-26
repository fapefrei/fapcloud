<?php if(!isset($_SESSION)) session_start(); ?>
<?php 
if(isset($_SESSION['accountcreated']) && $_SESSION['accountcreated'] == true){
    header('Location: /account/created');
}
//Redirection si url rewriting mauvais
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(strpos($actual_link, 'php') == true){
    header("location: /account".$_GET['document']); 
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>S'inscrire sur Square Cloud</title>
    <meta name="Author" content=""/>
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<?php include_once('functions.php'); ?>
<body id="template-compte">
    <!-- Navigation Bar -->
    <div id="navigation-bar">
        <div class="navigation-content">
            <div id="logo" style="top: 0;"><a href="/about"><span class="big-logo icon-noun-logo-sc"></span><span class="small-logo icon-noun-fin-de-liste"></span></a></div>
        </div>
    </div>
    <!-- /Navigation bar -->
    <div id="content-wrap">
        <h1>Rejoignez Square Cloud aujourd'hui.</h1>
        <form id="form-account" method="post" action="/functions.php">
            <hr>
            <div class="input-card" data-error="">
                <div class="left">
                    <p class="title">Email</p>
                    <p class="caption">Utilisez votre adresse email Efrei ou Esigetel pour créer votre compte.<br/>Vous devez avoir une adresse @efrei.net ou @esigetel.net.</p>
                </div>
                <div class="right">
                    <input required id="email-efrei" class="input" maxlength="70" type="email" name="email" placeholder="Email Efrei ou Esigetel">
                    <input required id="email-confirm" class="input" maxlength="70" type="text" name="email-confirm" placeholder="Confirmer votre email">
                </div>
            </div>
            <hr>
            <div class="input-card" data-error="">
                <div class="left">
                    <p class="title">Mot de passe</p>
                    <p class="caption">Please create a password that is 8 to 40 characters in length. Don’t use your name or your nickname from 8th grade.</p>
                </div>
                <div class="right">
                    <input required id="password" class="input" maxlength="40" type="password" name="password" placeholder="Mot de passe">
                    <input required id="password-confirm" class="input" maxlength="40" type="password" name="password-confirm" placeholder="Confirmez le mot de passe">
                </div>
            </div>
            <hr>
            <div class="input-card" data-error="">
                <div class="left">
                    <p class="title">Nom & Pseudo</p>
                    <p class="caption">Votre @pseudo ne pourra pas être modifié ultérieurement.</p>
                </div>
                <div class="right">
                    <input required class="input" maxlength="20" type="text" name="nom" placeholder="Nom">
                    <input required class="input" maxlength="20" type="text" name="prenom" placeholder="Prénom">
                    <input required id="pseudo" class="input" maxlength="15" type="text" name="pseudo" placeholder="Pseudo">
                </div>
            </div>
            <hr>
            <div class="input-card" data-error="">
                <div class="left">
                    <p class="title">Promotion</p>
                    <p class="caption">Sélectionnez votre promotion actuelle.<br>Vous aurez accès à tous les documents des promotions précédentes.</p>
                </div>
                <div class="right">
                    <!-- Promotion js -->
                    <div id="radios">
                             <input id="option1" name="options" type="radio" value="L1" <?php if (isset($_POST['options']) && $_POST['options'] == 'L1'){ echo 'checked'; } ?> >
                             <label for="option1">Année L1/PL1</label>

                             <input id="option2" name="options" type="radio" value="L2" <?php if (isset($_POST['options']) && $_POST['options'] == 'L2'){ echo 'checked'; } ?>>
                             <label for="option2">Année L2/PL2</label>

                             <input id="option3" name="options" type="radio" value="L3" <?php if (isset($_POST['options']) && $_POST['options'] == 'L3'){ echo 'checked'; } ?>>
                             <label for="option3">Année L3/L'3</label>

                             <input id="option4" name="options" type="radio" value="M1" <?php if (isset($_POST['options']) && $_POST['options'] == 'M1'){ echo 'checked'; } ?>>
                             <label for="option4">Année M1</label>

                             <input id="option5" name="options" type="radio" value="M2" <?php if (isset($_POST['options']) && $_POST['options'] == 'M2'){ echo 'checked'; } ?>>
                             <label for="option5">Année M2</label>
                         </div>
                </div>
            </div>
            <hr>
            <div class="input-card" data-error="">
                <div class="left">
                    <p class="title">Couleur du thème</p>
                    <p class="caption">Sélectionnez la couleur de contraste du site.<br>Vous pourrez changer ce réglage dans vos paramètres.</p>
                </div>
                <div class="right">
                    <?php include('parts/color-picker.php'); ?>
                    <input id="color-input" type="hidden" name="color">
                </div>
            </div>
            <hr>
            <div class="input-card" data-error="">
                <div class="left">
                    <p class="title">Avatar</p>
                    <p class="caption">Choisissez un avatar de profil. Si le choix ne vous convient pas, vous n'avez qu'a qu'a prendre le moins moche.<br>Vous pourrez changer ce réglage dans vos paramètres.</p>
                </div>
                <div class="right">
                    <div class="avatar-container">
                        <div data-avatar="A1" class="avatar avatar-A1-sm"></div>
                        <div data-avatar="A2" class="avatar avatar-A2-sm"></div>
                        <div data-avatar="A3" class="avatar avatar-A3-sm"></div>
                        <div data-avatar="A4" class="avatar avatar-A4-sm"></div>
                        <div data-avatar="B1" class="avatar avatar-B1-sm"></div>
                        <div data-avatar="B2" class="avatar avatar-B2-sm"></div>
                        <br/>
                        <div data-avatar="B3" class="avatar avatar-B3-sm"></div>
                        <div data-avatar="B4" class="avatar avatar-B4-sm"></div>
                        <div data-avatar="B5" class="avatar avatar-B5-sm"></div>
                        <div data-avatar="B6" class="avatar avatar-B6-sm"></div>
                        <div data-avatar="B7" class="avatar avatar-B7-sm"></div>
                        <div data-avatar="B8" class="avatar avatar-B8-sm"></div>
                    </div>
                    <input id="avatar-input" type="hidden" name="avatar">
                </div>
            </div>
            <hr>
            <p class="caption">En créant votre compte, vous acceptez les <span id="cgu">Conditions générales d'utilisation</span> du service.</p>
            <input class="submit" type="submit" value="Créer mon compte">

        </form>
    </div>

    <!-- MESSAGE -->
    <div class="message">
        <p></p>
    </div>

    <!-- CGU -->
    <div id="action-view-cgu" class="action-view-container">
        <div class="action-view">
            <div class="navbar">
                <p class="title">Conditions Générales d'utilisation</p>
                <a id="close" class="button">OK</a>
            </div>
            <div class="action-view-content">
       
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="home-footer">
        <div class="home-footer-container">
            <i class="icon-noun-fin-de-liste"></i>
            <div class="texte">
                <p>Square Cloud 2014-<?= date("Y"); ?>.</p>
                <p>A website by Square Inc.</p>
                <p>Square Cloud™ is a registered trademark of Square Inc.<br/>Mentioned companies names and logos are property of their respective owners.<br/>Your use of any information or materials on this website is entirely at your own risk.</p>
            </div>
        </div>
    </footer>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<!-- Radio Slider -->
<script src="js/vendor/radio-slider/radios-to-slider.js"></script>
<script src="js/global.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready( function(){
        jQuery("#radios").radiosToSlider();
    });
</script>
</body>
</html>
<?php if(!isset($_SESSION)) session_start(); ?>
<?php 
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(strpos($actual_link, 'php') == true){
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
    <title>Square Cloud</title>
    <!--  META  -->
    <meta name="Author" content="Loris"/>
    <!-- <meta name="description" content="Consultez le temps d'attente avant vos prochains Devoirs Écrit." /> -->
    <!-- <meta name="keywords" content="efrei, DE, devoirs écrit, examens, ingénieur" /> -->
    <meta name="copyright" content="© Square Cloud Inc." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/layout/favicon.ico" />
    <!--  iOS  -->
    <!--    <meta name="apple-mobile-web-app-capable" content="yes">-->
    <!--    <meta name="apple-mobile-web-app-status-bar-style" content="default">-->

    <!--  CSS  -->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/theme.php">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- FILER JS -->
    <link href="../css/vendor/filer/jquery.filer.css" type="text/css" rel="stylesheet" />
    <link href="../css/vendor/filer/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
    <?php include('parts/open-graph.php'); ?>
</head>
<?php include_once('functions.php'); ?>
<?php redirect(); ?>
<body id="template-homepage">

    <?php get_navbar(); ?>
    
    <div id="content-wrap">
        <!-- TOP CONTENT -->
        <div class="top-content">
            <div class="card-header">
                <p class="title">Matières populaires en <?= $_SESSION['promo']; ?></p>
                <span class="dot">•</span>
                <p class="link theme-fcolor" id="all-matieres">Toutes les matières</p>
                <?php if(is_vip()): ?>
                    <span class="dot">•</span>
                    <p class="link theme-fcolor" id="changePromo">Changer de promotion [<?= $_SESSION['promo']; ?>]</p>
                <?php endif; ?>
            </div>
            <div class="matieres-list animated">
                <?php getPopularMatieres($_SESSION['promo'], 6); ?>
            </div>
            <div class="all-matieres matieres-list">
            <p class="title">Toutes les matières</p><br/>
                <?php getAllMatieres($_SESSION['promo']); ?>
            </div>

            <div class="tableted">
                <?php include('parts/tendances.php'); ?>
            </div>
        </div>
        <!-- SIDE CONTENT -->
        <div class="side-content">

            <?php include('parts/tendances.php'); ?>

            <?php include('parts/feedback.php'); ?>

            <?php include('parts/favoris.php'); ?>

            <div class="desktoped">
                <?php include('parts/side-footer.php'); ?>
            </div>

            <div class="mobiled">
                <?php include('parts/contributeurs.php'); ?>

                <?php include('parts/connected.php'); ?>

                <?php include('parts/side-footer.php'); ?>
            </div>

        </div>
        <!-- MIDDLE CONTENT -->
        <div class="middle-content">
            
            <div class="posts-list" data-promo="<?= $_SESSION['promo']; ?>" data-lastlogin="<?= $_SESSION['lastlogin']; ?>" data-offset="0" data-ajax="0">
                <div class="post-panel">
                    <div id="post" class="btn-upload"><i class="icon-noun-new-post"></i>Nouveau Post</div>
                </div>
                <!-- POST ADDED VIA AJAX HERE -->
                <div class="post-loader" style="height: 90px; text-align: center; padding-top: 10px; padding-bottom: 10px;">
                    <img src="images/layout/loader.gif">
                </div>
            </div>

            <?php include('parts/fin-de-liste.php'); ?>
            
        </div>
        <!-- RIGHT CONTENT -->
        <div class="right-content">
            <?php include('parts/contributeurs.php'); ?>

            <?php include('parts/connected.php'); ?>
        </div>
    </div>

    <!-- POPUP FIRST LOGIN -->
    <?php 
    if (isset($_SESSION['new']) && $_SESSION['new'] == true){ ?>
        <div class="erreur-modal"></div>
    <?php $_SESSION['new'] = false; } ?>
    <div id="modal-new" class="modal-container">
        <div class="modal">
            <div class="text-container">
               <p class="title">Bienvenue sur votre Timeline</p>
               <p class="explications">Votre fil d'actualités est constitué d'un flux de posts publiés par les comptes de votre promotion.<br>Les contenus sont suggérés dans le fil sur la base de différents signaux. Vous pouvez aimer un post depuis le fil, ou accéder aux informations qu'il contient.</p>
            </div>
            <div class="modal-buttons">
                <a class="" id="close" title="">Génial !</a>
            </div>
        </div>
    </div>
    <!-- /POPUP FIRST LOGIN -->
    
    <div class="select-popup" style="top: 30px; left: 40px;">

    </div>

    <?php get_footer(); ?>
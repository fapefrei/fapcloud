<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<!-- IMPORTANT NOTE: This file is licensed only for use in providing the Square Cloud service,
or any part thereof, and is subject to the Square Cloud Terms and Conditions. You may not
port this file to another platform without the owner's written consent. --> 
<head>
    <meta charset="UTF-8">
    <title>Notifications | Square Cloud</title>
    <!--  META  -->
    <meta name="Author" content="Loris"/>
    <meta name="description" content="Consultez le temps d'attente avant vos prochains Devoirs Écrit." />
    <meta name="keywords" content="efrei, DE, devoirs écrit, examens, ingénieur" />
    <meta name="copyright" content="© Square Cloud Inc." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/layout/favicon.ico" />
    <link rel="apple-touch-icon" href="images/layout/touch-icon.png">
    <!--  iOS  -->
    <!--    <meta name="apple-mobile-web-app-capable" content="yes">-->
    <!--    <meta name="apple-mobile-web-app-status-bar-style" content="default">-->

    <!--  CSS  -->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/theme.php">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!--  TWITTER  -->
</head>
<?php include_once('functions.php'); ?>
<?php redirect(); ?>
<body id="template-notifications">
    
    <?php get_navbar(); ?>

    <div id="content-wrap">
        <!-- SIDE CONTENT -->
        <div class="side-content">
            <?php include('parts/tendances.php'); ?>
            <?php include('parts/suggestions.php'); ?>
            <?php include('parts/side-footer.php'); ?>
        </div>
        <!-- CENTER CONTENT -->
        <div class="center-content">
            <div class="card empty-notification theme-bcolor">
                <h1>Retrouvez vos notifications ici.</h1>
            </div>
            <p class="empty">Aucune notification pour le moment.</p>
            <div class="posts-list">
                <?= notifications_posts($_SESSION['pseudo']); ?>
                <?php include('parts/fin-de-liste.php'); ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
<!DOCTYPE html>
<html lang="fr">
<!-- IMPORTANT NOTE: This file is licensed only for use in providing the Fap Cloud service,
or any part thereof, and is subject to the Fap Cloud Terms and Conditions. You may not
port this file to another platform without the owner's written consent. --> 
<head>
    <meta charset="UTF-8">
    <title>ADMIN PANEL / Fap Cloud</title>
    <!--  META  -->
    <meta name="Author" content="Loris"/>
    <!-- <meta name="description" content="Consultez le temps d'attente avant vos prochains Devoirs Écrit." /> -->
    <!-- <meta name="keywords" content="efrei, DE, devoirs écrit, examens, ingénieur" /> -->
    <meta name="copyright" content="© Fap Cloud Inc." />
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
    <!--  TWITTER  -->
<!--     <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@lorismrtnl" />
    <meta name="twitter:title" content="Système d'Information en Ligne | Fap Cloud" />
    <meta name="twitter:description" content="Consultez le temps d'attente avant vos prochains Devoirs Écrit." />
    <meta name="twitter:image" content="https://fapcloud.fr/" /> -->
</head>
<?php include_once('functions.php'); ?>
<?php redirect(); ?>
<body id="template-admin">

    <?php get_navbar(); ?>

    <div id="content-wrap">
        <div class="card">

        <h1>Utilisateurs</h1>
        <table id="table-user-list">
            <tr>
                <td>Pseudo</td>
                <td>Prénom</td>
                <td>Nom</td>
                <td>Email</td>
                <td>Promotion</td>
                <td>Dernier Login</td>
            </tr>
            <?= get_all_users(); ?>

        </table>
          
        <?php include('parts/fin-de-liste.php'); ?>
    </div>
<?php get_footer(); ?>
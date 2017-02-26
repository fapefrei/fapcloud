<?php if(!isset($_SESSION)) session_start();?>
<?php 
//Redirection si url rewriting mauvais
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(strpos($actual_link, 'php') == true){
    header("location: /account/created".$_GET['document']); 
}
?>
<!DOCTYPE html>
<html lang="fr">
<!-- IMPORTANT NOTE: This file is licensed only for use in providing the Fap Cloud service,
or any part thereof, and is subject to the Fap Cloud Terms and Conditions. You may not
port this file to another platform without the owner's written consent. --> 
<head>
    <meta charset="UTF-8">
    <title>Votre compte / Fap Cloud</title>
    <!--  CSS  -->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/theme.php">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<?php include_once('functions.php'); ?>
<body class="default-page">

    <div class="center-card" style="width: 100px;">
        <br>
        <h1 class="title">Votre compte est en cours de création.</h1>
        <p class="caption">Un mail d'activation vous a été envoyé.</p>
    </div>

 <?php get_footer(); ?>
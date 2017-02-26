<?php if(!isset($_SESSION)) session_start();?>
<!DOCTYPE html>
<html lang="fr">
<!-- IMPORTANT NOTE: This file is licensed only for use in providing the Square Cloud service,
or any part thereof, and is subject to the Square Cloud Terms and Conditions. You may not
port this file to another platform without the owner's written consent. --> 
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation du mot de passe</title>
    <!--  CSS  -->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/theme.php">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<?php include_once('functions.php'); ?>
<body id="template-reset" class="template-default">
    <?php 
        if( (!isset($_GET['key']))||($_GET['key'] == null) ) {
            ?>
            <div class="center-card">
                <h1>Erreur de clé</h1>
            </div>
            <?php
            die();
        }
        require('connect_db.php');
        $key_to_be_tested = $_GET['key'];
        $query = "SELECT cle, uname FROM usr WHERE cle ='$key_to_be_tested'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {         
            while($row = $result->fetch_assoc()) {
        ?>

        <div class="center-card">
            <h1><?= ucfirst($row['uname']); ?>, choisissez un nouveau mot de passe</h1>
            <form id="new-password-choice" class="form" action="" method="post">
                <input max-length="40" id="pass1" class="input" type="password" name="" placeholder="Nouveau mot de passe">
                <input max-length="40" id="pass2" class="input" type="password" name="" placeholder="Retapez">
                <input type="hidden" id="user" value="<?= $row['uname']; ?>">
                <input class="submit" type="submit" value="Valider">
            </form>
        </div>

        <?php }
        }else{
           ?>
           <div class="center-card">
               <h1>Clé inexistante</h1>
           </div>
           <?php 
        }
        ?>
        <!-- Message -->
        <div class="message">
            <p></p>
        </div>
        
<?php get_footer(); ?>
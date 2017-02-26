<?php if(!isset($_SESSION)) session_start();?>
<!DOCTYPE html>
<html lang="fr">
<!-- IMPORTANT NOTE: This file is licensed only for use in providing the Fap Cloud service,
or any part thereof, and is subject to the Fap Cloud Terms and Conditions. You may not
port this file to another platform without the owner's written consent. --> 
<head>
    <meta charset="UTF-8">
    <title>Mise à niveau du compte</title>
    <!--  CSS  -->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/theme.php">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<?php include_once('functions.php'); ?>
<body id="template-maj">

    <div class="center-card-maj">
        <div class="center-card-header">
            <h1 data-user="<?= $_SESSION['pseudo']; ?>">Bonjour <?= ucfirst(get_user_fullname($_SESSION['pseudo'])); ?>,</h1>
        </div>
        <div class="center-card-inner">
            <div class="part part-one">
                <p class="title">Êtes-vous maintenant en <?= get_following_promo($_SESSION['promo']); ?> ?</p>
                    <div class="btn-container">
                        <?php
                            $promo = $_SESSION['promo'];
                            // $promo = "L1";
                            if(!isset($_SESSION)) session_start();
                            $_SESSION['color'] = '1b95e0';
                            if($promo == 'L1'){ $current = 1;}
                            if($promo == 'L2'){ $current = 2;}
                            if($promo == 'L3'){ $current = 3;}
                            if($promo == 'M1'){ $current = 4;}
                            if($promo == 'M2'){ $current = 5;}
                            $current++;
                        ?>
                        <div class="situation-container">
                            <div class="<?php if($current >= 1){ echo 'done theme-bcolor';} ?> year">L1</div>
                            <div class="<?php if($current >= 2){ echo 'done theme-bcolor';} ?> year-link"></div>
                            <div class="<?php if($current >= 2){ echo 'done theme-bcolor';} ?> year">L2</div>
                            <div class="<?php if($current > 2){ echo 'done theme-bcolor';} ?> year-link"></div>
                            <div class="<?php if($current >= 3){ echo 'done theme-bcolor';} ?> year">L3</div>
                            <div class="<?php if($current > 3){ echo 'done theme-bcolor';} ?> year-link"></div>
                            <div class="<?php if($current > 3){ echo 'done theme-bcolor';} ?> year">M1</div>
                            <div class="<?php if($current > 4){ echo 'done theme-bcolor';} ?> year-link"></div>
                            <div class="<?php if($current >= 5){ echo 'done theme-bcolor';} ?> year">M2</div>
                        </div>
                        <br>
                        <br>
                        <div data-promo="<?= get_following_promo($_SESSION['promo']); ?>" id="yes" class="btn">Oui</div>
                        <div data-promo="<?= $_SESSION['promo']; ?>" id="no" class="btn">Non</div>
                    </div>
            </div>
            <div class="part part-two">
                <p class="title">Choisissez une couleur de contraste.</p>
                <p class="caption">Vous pourrez modifier ce réglage dans vos paramètres de profil.</p>
                <?php include('parts/color-picker.php'); ?>
            </div>
            <div class="part part-three">
                <p class="title">Choisissez un avatar.</p>
                <p class="caption">Vous pourrez modifier ce réglage dans vos paramètres de profil.</p>
                <!-- Avatar picker -->
                <?php include('parts/avatar-picker.php'); ?>
            </div>
            <div class="part part-four">
                <p class="title">Mise à niveau de vos réglages.</p>
                <p class="caption">Cela peut prendre quelques nano-secondes...</p>
                <img src="images/layout/loader.gif">
            </div>
        </div>
    </div>

 <?php get_footer(); ?>
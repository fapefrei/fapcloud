<?php if(!isset($_SESSION)) session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<!-- IMPORTANT NOTE: This file is licensed only for use in providing the Square Cloud service,
or any part thereof, and is subject to the Square Cloud Terms and Conditions. You may not
port this file to another platform without the owner's written consent. --> 
<head>
    <meta charset="UTF-8">
    <title><?= $args['name']; ?> | Square Cloud</title>
    <!--  META  -->
    <meta name="Author" content="Loris"/>
    <meta name="description" content="Consultez le temps d'attente avant vos prochains Devoirs Écrit." />
    <meta name="keywords" content="efrei, DE, devoirs écrit, examens, ingénieur" />
    <meta name="copyright" content="© Square Cloud Inc." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--  CSS  -->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/theme.php">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- JS -->
    <!-- PDF.JS -->
    <script src="/js/vendor/pdfjs/pdf.js" type="text/javascript"></script>
    <script src="/js/vendor/pdfjs/pdf.worker.js" type="text/javascript"></script>
    <!-- FILER JS -->
    <link href="../css/vendor/filer/jquery.filer.css" type="text/css" rel="stylesheet" />
    <link href="../css/vendor/filer/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
</head>
<?php include_once('functions.php'); ?>
<?php redirect(); ?>
<body id="template-upload">
    
    <?php get_navbar(); ?>

    <div id="content-wrap">
<!--         <form action="./php/upload.php" method="post" enctype="multipart/form-data">
              <input type="file" name="files[]" id="filer_input" multiple="multiple">
              <input type="submit" value="Submit">
        </form> -->
    </div>


<?php get_footer(); ?>  
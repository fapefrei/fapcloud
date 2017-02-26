<?php session_start(); ?>
<?php
require("connect_db.php");
$codename = $_GET['subject'];
$getSubjectInfo = "SELECT * FROM subjects WHERE codename = '$codename'"; 
$result = $conn->query($getSubjectInfo);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $profM = $row["prof"];
        $popularity = $row["popularity"];
        $icon = $row["icon"];
        $majeurematiere = $row["majeure"];
        $url = $row["url"];
        $code = $row['codename'];

        $args = [
            'name'=> $row["name"],
            'codename'=> $row["codename"],
            'promo'=> $row["annee"],
            'semestre'=> $row["SEM"]
        ];
    }
}else{
    // header('HTTP/1.0 404 Not Found');
    exit();
}
//Redirection si url rewriting mauvais
if($_GET['url'] != $url){
    header("location: /cours/".$url."-".$code);
}
if(!isset($_GET["subject"]) || ($_GET["subject"] == "")  ){
    // header('HTTP/1.0 404 Not Found');
    exit();
}
?>
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
    <link rel="icon" href="../images/layout/favicon.ico" />
    <link rel="apple-touch-icon" href="../images/layout/touch-icon.png">
    <!--  iOS  -->
    <!--    <meta name="apple-mobile-web-app-capable" content="yes">-->
    <!--    <meta name="apple-mobile-web-app-status-bar-style" content="default">-->
    <!--  CSS  -->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/theme.php">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <?php include('parts/open-graph.php'); ?>
    <!-- JS -->
    <!-- PDF.JS -->
    <script src="../js/vendor/pdfjs/pdf.js" type="text/javascript"></script>
    <script src="../js/vendor/pdfjs/pdf.worker.js" type="text/javascript"></script>
</head>
<?php include_once('functions.php'); ?>
<?php redirect(); ?>
<body id="template-matiere">
    
    <?php get_navbar(); ?>
    
    <div id="content-wrap">
        <!-- TOP CONTENT -->
        <div class="card top-content theme-bcolor">
            <h1><?= $args['name']; ?></h1>
            <?= popularity($args['codename']); ?>

            <div class="favoris favoris-icon" data-matiere="<?= $args['codename']; ?>">
                <i data-balloon="Ajouter aux favoris" data-balloon-pos="right" class="material-icons"><?= json_decode(favoris_check($_SESSION['pseudo'], $args['codename'])); ?></i>
            </div>
            <div class="infos">
                <div data-balloon="Code Matière" data-balloon-pos="up" class="promo theme-fcolor"><?= $args['codename']; ?></div>
                <div data-balloon="Année" data-balloon-pos="up" class="promo theme-fcolor"><?= $args['promo'].' - '.$args['semestre']; ?></div>
            </div>
        </div>
        <!-- SIDE CONTENT -->
        <div class="side-content">
            <?php include('parts/tendances.php'); ?>
            
            <?php include('parts/feedback.php'); ?>

            <?php include('parts/side-footer.php'); ?>
        </div>
        <!-- CENTER CONTENT -->
        <div class="center-content">
            <div class="card toolbar-card">
                <ul class="file-type-selection">
                    <li class="selected" id="all">Tout</li>
                    <li id="Cours">Cours</li>
                    <li id="DE">DE</li>
                    <li id="CE">CE</li>
                    <li id="TD">TD</li>
                    <li id="TP">TP</li>
                </ul>
            </div>

            <div class="file-list">
                <?php get_documents($args['codename']); ?>
            </div>
            <?php include('parts/fin-de-liste.php'); ?>
        </div>
    </div>

<?php get_footer(); ?>
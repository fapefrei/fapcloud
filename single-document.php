<?php if(!isset($_SESSION)) session_start(); ?>
<?php
require("connect_db.php");
$document_id = $_GET['document'];
$getDocumentInfo = "SELECT * FROM documents WHERE id = '$document_id' AND available ='1'"; 
$result = $conn->query($getDocumentInfo);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $date = $row["dldate"];
        $yearnext = $row["year"] + 1;
        $year = $row["year"];
        $subject = $row["subject"];
        $format = $row["format"];
        $type = $row["type"];
        $titre = $row["titre"];
        $address = $row["address"];
        $prof = $row["prof"];
        $nomoriginal = $row["nomoriginal"];
        $taille = $row["taille"];
        $source = $row["source"];
        $downloads = $row["downloads"];
        $uploaderdisplay = $row["uploaderdisplay"];
    }
}else{
    // Display error notification
    echo '<div class="erreur-modal"></div>';
    $error = 1;
}
//Redirection si url rewriting mauvais
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(strpos($actual_link, 'php') == true){
    header("location: /document/".$_GET['document']); 
}

if(!isset($_GET["document"]) || ($_GET["document"] == "")  ){
    header('HTTP/1.0 404 Not Found');
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
    <title><?= $titre; ?> | Square Cloud</title>
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
<body id="template-single-document">

    <?php get_navbar(); ?>

    <div id="content-wrap">
        <!-- TOP CONTENT -->
        <div class="top-content card ariane theme-bcolor">
            <a href="/">M1</a><span class="arrow">▶︎</span><a href="/single-matiere.php?subject=<?= $subject; ?>" class=""> <?= get_subject_name($subject); ?></a><span class="arrow">▶︎</span><?= $titre; ?>
        </div>
        <!-- SIDE CONTENT -->
        <div class="side-content">
            <?php include('parts/tendances.php'); ?>
            <?php include('parts/side-footer.php'); ?>
        </div>
        <!-- CENTER CONTENT -->
        <div class="center-content">
        <?php if($error != 1): ?>
            <div class="card single-document">
                <div class="file"><i class="filefont-<?= $format; ?>"></i></div>
                <div class="texts">
                    <p class="eyebrow"><?= get_subject_name($subject); ?></p>
                    <p class="titre"><?= $titre; ?></p>
                </div>
                <a target="parent" href="<?= the_link($address); ?>" data-document-id="<?= $document_id; ?>" class="download-button"><?= download_history($document_id, $_SESSION['pseudo']); ?></a>
                <!-- <div class="format">PDF</div> -->

                <div class="file-infos">
                    <canvas class="file-preview" id="canvas-<?= $document_id; ?>" ></canvas>
                    <script id="script">

                        // If absolute URL from the remote server is provided, configure the CORS
                        // header on that server.
                        //
                        var url = "<?= the_link($address); ?>";

                        PDFJS.workerSrc = '../js/vendor/pdfjs/pdf.worker.js';

                        PDFJS.getDocument(url).then(function getPdfHelloWorld(pdf) {

                            pdf.getPage(1).then(function getPageHelloWorld(page) {
                                var scale = 1;
                                var viewport = page.getViewport(scale);

                                var canvas = document.getElementById('canvas-<?= $document_id; ?>');
                                var context = canvas.getContext('2d');
                                canvas.height = viewport.height;
                                canvas.width = viewport.width;

                                var renderContext = {
                                    canvasContext: context,
                                    viewport: viewport
                                };
                                page.render(renderContext);
                            });
                        });
                    </script>
                    <div class="file-details">
                        <div class="label">.<?= strtoupper($format); ?></div>
                        <div class="label"><?= strtoupper($type); ?></div>
                        <p>Année : <?= $year.'-'.$yearnext; ?></p>
                        <p>Source : <?= $source; ?></p>
                        <p>Taille : <?= human_filesize(filesize($address)); ?></p>
                        <p>Nom du fichier : <?= $nomoriginal; ?></p>
                    </div>
                    <table class="file-status">
                        <tr>
                            <td><p>Téléchargements</p><p class="theme-fcolor"><?= get_dowloads_number($document_id); ?></p></td>
                            <td>
                                <?php get_who_dowloaded($document_id); ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="post-actions">
                  <ul class="actions-list">
                    <li data-balloon="J'aime" data-balloon-pos="up">
                      <span class="heart like <?php if(is_liked($document_id, $_SESSION['pseudo']) == true){ echo 'liked';} ?>" data-document="<?= $document_id; ?>"></span>
                      <p class="like-number"><?= get_likes($document_id); ?></p>
                    </li>
                    <li data-balloon="Plus" data-balloon-pos="up" class="more"><i class="icon-noun-dots"></i></li>
                  </ul>
                  <div class="more-menu">
                    <ul class="actions-drowpdown-list">
                      <li class="subject-link" id="open-link" data-link="http://www.squarecloud.fr/single-matiere.php?subject=<?= $subject; ?>">Copier le lien de la matière</li>
                      <li class="document-link" id="open-link" data-link="http://www.squarecloud.fr/single-document.php?document=<?= $document_id; ?>">Copier le lien du document</li>
                      <li>Signaler</li>
                    </ul>
                  </div>
                </div>

                <div class="file-footer">
                    <p class="file-user">Ajouté par <a href="/template-profil.php?user=<?= $uploaderdisplay; ?>"><strong class="theme-fcolor"><?= $uploaderdisplay; ?></strong></a></p>
                    <p class="file-timestamp"><?= strftime("%H:%M - %A %d %B %Y",strtotime($date));?></p>
                </div>
            </div>
        <?php endif; ?>
            <?php include('parts/fin-de-liste.php'); ?>
        </div>
    </div>

    <!-- Modal document unavailable -->
    <div id="modal-document-unavailable" class="modal-container">
        <div class="modal">
            <div class="text-container">
                <p class="title">Oups !</p>
                <p class="explications">Une erreur est survenue.<br>Ce document n'est pas disponible.</p>
            </div>
            <div class="modal-buttons">
                <a class="" id="close" href="/" title="">OK</a>
            </div>
        </div>
    </div>
<?php get_footer(); ?>

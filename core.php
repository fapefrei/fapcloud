<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Fap Cloud | Core</title>
        <meta name="Author" content=""/>
        <link rel="stylesheet" type="text/css" href="../css/main.css">
    </head>
    <?php include_once('functions.php'); ?>
    <body id="template-core">
    
        <div id="container9" class="container">
            
        </div>
        <audio src="processeur.m4a" autoplay></audio>

    <!-- Siri Waves JS -->
    <script src="http://rawgit.com/CaffeinaLab/SiriWavEJS/master/siriwave9.js"></script>
    <script type="text/javascript">
        var w = window.innerWidth / 2,
            h = w / 10;

        new SiriWave9({
            width: w,
            height: h,
            speed: 1,
            amplitude: 1,
            container: document.getElementById('container9'),
            autostart: true
        });
    </script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="../js/global.js" type="text/javascript"></script>
    </body>
</html>
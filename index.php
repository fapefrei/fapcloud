<!DOCTYPE html>
<html lang="fr">
<!-- J'avais 5 minutes dispo pendant ma pause déjeuner donc j'ai codé cette page. -->

<!-- IMPORTANT NOTE: This file is licensed only for use in providing the Fap Cloud service,
or any part thereof, and is subject to the Fap Cloud Terms and Conditions. You may not
port this file to another platform without the owner's written consent. --> 
<head>
    <meta charset="UTF-8">
    <title>SIEL — Système d'Information En Ligne | Fap Cloud</title>
    <!--  META  -->
    <meta name="Author" content="Loris"/>
    <meta name="description" content="Consultez le temps d'attente avant vos prochains Devoirs Écrit." />
    <meta name="keywords" content="efrei, DE, devoirs écrit, examens, ingénieur" />
    <meta name="copyright" content="© Fap Cloud Inc." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favicon.ico" />
    <!--  iOS  -->
<!--    <meta name="apple-mobile-web-app-capable" content="yes">-->
<!--    <meta name="apple-mobile-web-app-status-bar-style" content="default">-->

    <!--  CSS  -->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <!--  TWITTER  -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@lorismrtnl" />
    <meta name="twitter:title" content="Système d'Information en Ligne | Fap Cloud" />
    <meta name="twitter:description" content="Consultez le temps d'attente avant vos prochains Devoirs Écrit." />
    <meta name="twitter:image" content="https://fapcloud.fr/" />
</head>
<?php //include_once('functions.php'); ?>
<?php if( isset($_GET['year']) ){ $year = $_GET['year'];}else{ $year = "l1"; } ?>
<body id="template-siel">
    <img id="reglage" src="images/reglage-en-cours.png">
    <div class="siel-panel">
        <div class="upper-panel">
            <table>
                <tr>
                    <th rowspan="2">
                        <img class="logo-metro" src="images/Metro-<?= substr($year, -2, 1); ?>.png">
                        <div class="logo-ligne <?= $year; ?>" data-ligne="<?= substr($year, 1); ?>"></div>
                    </th>
                    <th colspan="2">
                        <div class="heure"><p id="heure">..</p><p id="separator">:</p><p id="minute">..</p></div>
                    </th>
                </tr>
            </table>
        </div>
        <table class="lower-panel">
            <tr>
                <td></td>
                <td><p class="order">Devoir Écrit</p></td>
                <td><p class="order">Rattrapage</p></td>
            </tr>
            
            <?php get_the_date($year); ?>    

            <tr class="<?= $year; ?>">
                <td colspan=3>
                    <img height="82" src="images/sponsors.png">
                </td>
            </tr>
        </table>
    </div>
    
    <ul id="year-list">
        <li data-year="l1">
            <img class="logo-metro" src="images/Metro-l.png">
            <div class="logo-ligne l1" data-ligne="1"></div>
        </li>
        <li data-year="l2">
            <img class="logo-metro" src="images/Metro-l.png">
            <div class="logo-ligne l2" data-ligne="2"></div>
        </li>
        <li data-year="l3">
            <img class="logo-metro" src="images/Metro-l.png">
            <div class="logo-ligne l3" data-ligne="3"></div>
        </li>
        <li data-year="m1">
            <img class="logo-metro" src="images/Metro-m.png">
            <div class="logo-ligne m1" data-ligne="1"></div>
        </li> 
        <li data-year="m2">
            <img class="logo-metro" src="images/Metro-m.png">
            <div class="logo-ligne m2" data-ligne="2"></div>
        </li>
    </ul>
    
    <form id="form" action="/" method="get">
        <input id="input" type="hidden" name="year" value="l2">
    </form>
    
    <p id="credits">  <span id="help">Aide</span> | © <?= date("Y"); ?> SIEL 1.1 (Système d'Infomation en Ligne) — <a target="blank" href="https://www.fapcloud.fr">Coded by Loris M.</a></p>
    
    <?php
    function get_the_date($year){
        /*------------------*/
        
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $database = "SQA";
            
        /*------------------*/
        $conn = new mysqli($servername, $username, $password, $database);

        $getsubjects = "SET NAMES 'utf8'";
        $result = $conn->query($getsubjects);

        setlocale(LC_TIME, 'fr_FR');
        
        $getDE = "SELECT * FROM dates_de WHERE year = '$year' ORDER BY date ASC";
        $result = $conn->query($getDE);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                
                // RATTRAPAGE
                if($row['ratt'] == null){
                    $diffr = "--";
                }else{
                    $today = new DateTime();
                    $de = new DateTime($row['ratt']);
                    $diffr = $today->diff($de)->format("%R%a");

                    if($diffr > 0){
                        
                        // Delete sign +
                        $diffr = substr($diffr, 1);

                        // Add zero if number < 10
                        if($diffr < 10){
                            $diffr = '0'.$diffr;
                        }
                        if($diffr > 99){
                            $diffr = '++';
                        }
                    }else{
                        $diffr = '--';
                    }
                }
                
                // DE
                // null
                if($row['date'] == null){
                    $diff = "--";
                }else{
                    $today = new DateTime();
                    $de = new DateTime($row['date']);
                    $diff = $today->diff($de)->format("%R%a");
                    
                    if($diff < 0){
                        $diff = 'xx';
                        
                    }else{
                        if($diff > 0){ // Pas aujourd'hui

                            // Delete sign +
                            $diff = substr($diff, 1);

                            // Add zero if number < 10
                            if($diff < 10){
                                $diff = '0'.$diff;
                            }
                            if($diff > 99){
                                $diff = '++';
                            }
                        }elseif($diff == 0){ // Aujourd'hui
                            $diff = '00';
                        }
                            
                        ?>
                        <tr>
                            <td><p class="terminus"><?= $row['matiere']; ?></p> <!--<div class="triangle <?php if($diff <= 7){echo'active';} ?>"></div>--> </td>
                            <td>
                                <div class="lcd">
                                    <p class="temps <?php if(($diff <= 7)&&($diff != 'xx')&&($diff != '++')&&($diff != '--')){ echo 'approach';} ?>"><?= $diff; ?></p><p>jours</p>
                                </div>
                            </td>
                            <td>
                                <div class="lcd">
                                    <p class="temps <?php if(($diffr <= 7)&&($diffr != 'xx')&&($diffr != '++')&&($diffr != '--')&&($diffr != '')){ echo 'approach';} ?>"><?= $diffr; ?></p><p>jours</p>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                }
            } // End While
        }else{
        ?>
        <tr>
            <td><p class="terminus">...</p></td>
            <td>
                <div class="lcd">
                    <p class="temps bogue">--</p><p>jours</p>
                </div>
            </td>
            <td>
                <div class="lcd">
                    <p class="temps bogue2">--</p><p>jours</p>
                </div>
            </td>
        </tr>
        <?php
        }
        
    }
    ?>

    <div id="modal-help" class="modal-container">
        <div class="modal">
            <div class="text-container">
                <p class="title">À Propos du SIEL</p>
                <p class="explications">Le Système d'Information en Ligne vous permet de connaître le temps d'attente avant vos prochains DE.</p>
                <p class="list">
                    -- : Aucune donnée/Erreur<br/>
                    xx : Date passée<br/>
                    ++ : Plus de 99 jours<br/>
                    Chiffre clignotant : - de 7 jours
                </p>
            </div>
            <div class="modal-buttons">
                <a class="" id="close" href="#" title="">OK</a>
            </div>
        </div>
    </div>
    
    <div id="modal-error" class="modal-container">
        <div class="modal">
            <div class="text-container">
                <p class="title">Database unreachable</p>
                <p class="explications">Il est impossible d'accéder à la base de données sur choam.efrei.fr.<br/> Les dates factices ont étés affichées.</p>
            </div>
            <div class="modal-buttons">
                <a class="" id="close" href="#" title="">OK</a>
            </div>
        </div>
    </div>
    
    <!-- <div class="btn" id="test">Open</div> -->
    
    <div id="action-view-test" class="action-view-container">
        <div class="action-view">
            <div class="navbar">
                <p class="title">Ajouter une entrée</p>
                <a id="close" class="button">Annuler</a>
                <a id="valide" class="button">Valider</a>
            </div>
            <div class="action-view-content">
                <form action="" method="post">
                    <input type="text" name="">
                    <input type="text" name="">
                    

                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="../js/global.js" type="text/javascript"></script>
    <script type="text/javascript">
        // Get current time on page load
        var now = new Date();
        // Adds zeros to hours and minutes
        $('#heure').html( (now.getHours()<10 ? '0' : '') + now.getHours() );
        $('#minute').html( (now.getMinutes()<10 ? '0' : '') + now.getMinutes() );

        // Update time every 30s
        window.setInterval(function(){
            var now = new Date();
            $('#heure').html( (now.getHours()<10 ? '0' : '') + now.getHours() );
            $('#minute').html( (now.getMinutes()<10 ? '0' : '') + now.getMinutes() );
            
            //Reload at midnight (for 24/7 display)
            if( ($('#heure').html() == '00')&&($('#minute').html() == '00') ){
                locaction.reload();
            }
        }, 30000);
        
        // Change year
        jQuery('#year-list li').on('click', function(){
            var year = jQuery(this).attr('data-year');
            jQuery('#input').attr('value', year);
            jQuery('#form').submit();
        });
    </script>
    <!-- G Analytics -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-49703588-1', 'auto');
      ga('send', 'pageview');

    </script>
</body>
</html>
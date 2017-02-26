<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fap Cloud | Dashboard</title>
    <meta name="Author" content=""/>
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<?php include_once('functions.php'); ?>
<body id="template-dashboard">
    
    <div class="loader">
        <div class="l"></div>
        <p>Fap Cloud Dashboard 10.3-A</p>
    </div>
    <div class="top-panel">
        <p class="title-panel" data-title="Fap Cloud">website status</p><p class="subtitle-panel">DASHBOARD 10.3-A</p>
    </div>
    
    <div class="panel">
        <table>
            <tr>
                <th colspan=4 ><p class="title-panel" data-title="data">database status</p><p class="subtitle-panel">sql 10.4-A</p></th>
            </tr>
            <tr class="title-01">
                <td>
                    <p></p>
                    <p>up and running</p>
                </td>
                <td class="backgrounded">
                    <p>11</p>
                    <p>tables</p>
                    <div class="checking-1"></div>
                </td>
                <td class="backgrounded">
                    <p>13,6 Gio</p>
                    <p>received</p>
                    <div class="checking"></div>
                </td>
                <td class="backgrounded">
                    <p>340,6 Gio</p>
                    <p>sent</p>
                    <div class="checking-1"></div>
                </td>
            </tr>
            <tr class="title-02">
                <td class="backgrounded">
                    <p>301</p>
                    <p>max conn.</p>
                </td>
                <td class="backgrounded">
                    <p>688</p>
                    <p>Kio</p>
                </td>
                <td class="backgrounded">
                    <p>23%</p>
                    <p>vrsls</p>
                </td>
                <td class="backgrounded">
                    <p>128</p>
                    <p>sol</p>
                </td>
            </tr>
        </table>
    </div>    
        
    <div class="panel">
        <table class="big">
            <tr>
                <th colspan=3 ><p class="title-panel" data-title="input">files data</p><p class="subtitle-panel">watney</p></th>
            </tr>
            <tr>
                <td class="backgrounded title-1" rowspan=2>
                    <p>340</p>
                    <p>files</p>
                </td>
                <td colspan=2 class="title-2">
                    <p>/documents dwld</p>
                    <p class="anim-pulse">stable</p>
                </td>
            </tr>
            <tr>
                <td class="title-3">
                    <p>12</p>
                    <p>this month</p>
                </td>
                <td class="title-3">
                    <p>2</p>
                    <p>this week</p>
                </td>
            </tr>
        </table>
    </div>
        
    <div class="panel">
        <table class="big-2">
            <tr>
                <th colspan=3 ><p class="title-panel" data-title="data">users data</p><p class="subtitle-panel">usr A-113</p></th>
            </tr>
            <tr>

                <td class="title-2">
                    <p></p>
                    <p>stable</p>
                </td>
                <td rowspan=2 class="title-1">
                    <p>127</p>
                    <p>users</p>
                </td>
                <td class="title-04 backgrounded">
                    <p>licence</p>
                    <p data-annee="L1">23.0</p>
                    <p data-annee="L2">12.0</p>
                    <p data-annee="L3">45.0</p>
                </td>
            </tr>
            <tr>
                <td class="title-3">
                    <p>0</p>
                    <p>this month</p>
                </td>
                <td class="title-04 backgrounded">
                    <p>master</p>
                    <p data-annee="M1">123.0</p>
                    <p data-annee="M2">00.0</p>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="panel unavailable">
        <table class="">
            <tr>
                <th colspan=4 ><p class="title-panel" data-title="measures">raw data</p><p class="subtitle-panel">hatch 10.2-B</p></th>
            </tr>
            <tr>
                <td rowspan=2 class="title-1">
                    <p>--</p>
                    <p>per minute</p>
                </td>
                <td class="title-02">
                    <p>47,3</p>
                    <p>psi</p>
                </td>
                <td class="title-04 backgrounded">
                    <p>licence</p>
                    <p data-annee="watney">23.7</p>
                    <p data-annee="watney">12.6</p>
                    <p data-annee="L3">45.1</p>
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="title-3">
                    <p>--</p>
                    <p>this month</p>
                </td>
                <td class="title-04 backgrounded">
                    <p>master</p>
                    <p data-annee="hatch">30.6</p>
                    <p data-annee="hatch">00.9</p>
                </td>
                <td></td>
            </tr>
        </table>
    </div>

    <p class="credits">Interface from The Martian movie — © Territory studio All rights reserved</p>
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="../js/global.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery( document ).ready(function() {
            myAudio = new Audio('demarrage.mp3'); 
            myAudio.play();
            setTimeout(
            function(){
                jQuery('.l').css('visibility', 'visible');
            }, 200);


            setTimeout(
                function(){
                    jQuery('.loader').fadeOut(500);

                    myAudio = new Audio('warning.mp3'); 
                    myAudio.addEventListener('ended', function() {
                        this.currentTime = 0;
                        this.play();
                    }, false);
    //                myAudio.play();

                }, 3500);
        });
    </script>
</body>
</html>
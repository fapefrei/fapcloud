<?php
if(!isset($_SESSION)) session_start();
// Redirection si mauvais url rewriting
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(strpos($actual_link, 'php') == true){
    header("location: /about"); 
}
?>
<?php include_once('functions.php'); ?>
<?php 
    // if( isset($_SESSION['pseudo'])){
    //     header("location: /template-homepage.php"); 
    // }
?>
<!DOCTYPE html>
<html lang="fr">
<!-- IMPORTANT NOTE: This file is licensed only for use in providing the Square Cloud service,
or any part thereof, and is subject to the Square Cloud Terms and Conditions. You may not
port this file to another platform without the owner's written consent. --> 
<!-- TIGER, tiger, burning bright
In the forests of the night,     
What immortal hand or eye    
Could frame thy fearful symmetry? -->
    <head>
        <meta charset="UTF-8">
        <title>Square Cloud | A plateform designed for Efrei's students</title>
        <meta name="Author" content="Loris"/>
        <meta name="keywords" content="efrei, efrei doc, documents, moodle, extranet efrei, DE, devoirs écrit, examens, ingénieur" />
        <meta name="copyright" content="Square Cloud Inc." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="images/layout/favicon.ico" />
        <link rel="apple-touch-icon" href="images/layout/touch-icon.png">
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <?php include('parts/open-graph.php'); ?>
    </head>
    <body id="template-home">
        <nav>
            <div class="nav-container"> 
                <div id="logo"><span class="big-logo icon-noun-logo-sc"></span><span class="small-logo icon-noun-fin-de-liste"></span></div> 
                <div class="btn-container">
                    <a href="/compte.php" title="Créer un compte">Créer un compte</a>
                    <a href="/login" class="connexion" title="Se connecter"><?=  ( isset($_SESSION['pseudo']) ? 'Accueil' : 'Connexion'); ?></a>
                </div>
            </div>
        </nav>
    <header>
        <h2>A plateform designed for Group Efrei's students</h2>
        <h3><em id="number">1</em> documents are on square cloud.</h3>
        <a href="#arrow" id="arrow"><img src="https://www.snapchat.com/static/style-guide/home/images/caret.svg" ></a>

<!--         <div class="parallax">
            <div id="cloud-1" class="cloud"></div>
            <div id="cloud-2" class="cloud"></div>
        </div> -->
    </header>
    <div class="page-content">
<!--         <section id="matieres">
            <div class="left">
                <div class="matieres-container">
                    <div class="matiere"><div class="matiere-icon theme-bcolor"></div><p>Thermodynamique</p></div>
                    <div class="matiere"><div class="matiere-icon theme-bcolor"></div><p>Fonctions & variations</p></div>
                    <div class="matiere"><div class="matiere-icon theme-bcolor"></div><p>Optique</p></div>
                    <div class="matiere"><div class="matiere-icon theme-bcolor"></div><p>Physique Quantique</p></div>
                    <div class="matiere"><div class="matiere-icon theme-bcolor"></div><p>Aide à la décision</p></div>
                    <div class="matiere"><div class="matiere-icon theme-bcolor"></div><p>Atome puce</p></div>
                    <div class="matiere"><div class="matiere-icon theme-bcolor"></div><p>Programmation Java</p></div>
                    <div class="matiere"><div class="matiere-icon theme-bcolor"></div><p>C++</p></div>
                    <br>
                    <div class="matiere"><div class="matiere-icon theme-bcolor"></div><p>Web services</p></div>
                </div>
            </div>
           <div class="right">
                <div class="textes">
                    <p class="eyebrow">5 years</p>
                    <p class="title">Every single subjects</p>
                    <p class="description">Keep track of every year. From L1 to M2, every subject is here. Course, TD, TP, CE, DE, you will find the document you are looking for.</p>
                </div>
           </div>
        </section>
        <section>
            <div class="left">
                <div class="textes">
                    <p class="eyebrow">courses files</p>
                    <p class="title">Add <b>your</b> documents</p>
                    <p class="description">You have the document that everyone is looking for ? The only copy of the Quantum physics DE ? <br>You can add it to the Square Cloud database in just a click ! Keep an eye on the downloads and the number of people you reached, thanks to new statistics.<br>The best part is that your document will still be avalaible for next year's students.</p>
                </div>
            </div>
            <div class="right centered">
                <img src="images/layout/books.png" alt="Documents">
            </div>
        </section>
        <section id="years">
            <div class="left centered">
                <img src="images/layout/trends.png" width="350" alt="Trends">
            </div>
            <div class="right">
                <div class="textes">
                    <p class="eyebrow">Timeline</p>
                    <p class="title">Popular trends</p>
                    <p class="description">Thanks to your new Timeline, you can see the popular trends and files the whole school is talking about. The powerful trending algorithm will suggest you the file or subject you are looking for. Even before you know it.</p>
                </div>
            </div>
        </section>
        <section>
            <div class="left">
                <div class="textes">
                    <p class="eyebrow">efficiency</p>
                    <p class="title">Custom coded</p>
                    <p class="description">Everything is said in the title. On a more serious note, we do not use any CMS or pre-made CSS to build Square Cloud. Everything is made by hand with love (and coffee).</p>
                </div>
            </div>
            <div class="right centered">
                <img src="images/layout/dev.png" alt="Custom coded">
            </div>
        </section>
         -->

        <section>
        <h3>Features</h3>
            <ul class="feature-list">
                <li id="speed"><h4>5 years</h4> We support every promotion, from L1 to M2.</li>
                <li id="touch"><h4>All subjects</h4> You have access to every subject.</li>
                <li id="publish"><h4>Publish</h4> Add your own documents to the database.</li>
                <li id="fav"><h4>Favorites</h4> Add subjects to your favorites.</li>
                <li id="search"><h4>Search</h4> Powerfull search let you find everything.</li>

            </ul>
        </section>
        <section>
        <h3>New in version 3!</h3>
            <ul class="feature-list">
                <li id="ui"><h4>New UI</h4> Designed impeccably to look great on your browser.</li>
                <li id="responsive"><h4>Mobile</h4> Square Cloud now works even better on your iPad and your iPhone.</li>
                <li id="hashtag"><h4>New Timeline</h4> Discover popular trends and files.</li>
                <li id="sync"><h4>Ajax</h4> Every feature has been rewritten using Ajax for a better user experience.</li>
                <li id="fix"><h4>Lots More</h4> Incredible fixes around every corner.</li>

            </ul>
        </section>
        <section>
            <h3>What is Square Cloud?</h3>
            <p class="text">It’s the best <em>document exchange platform</em> for Efrei, ever. Probably because it's not made by them. It’s elegant, powerful, and always ready.</p>
        </section>
    </div>

    <br/>
    <br/>
    <br/>
    <br/>

    <footer class="home-footer">
        <div class="home-footer-container">
            <i class="icon-noun-fin-de-liste"></i>
            <div class="texte">
                <p>Square Cloud 2014-<?= date("Y"); ?>.</p>
                <p>A website by Square Inc.</p>
                <p>Square Cloud™ is a registered trademark of Square Inc.<br/>Mentioned companies names and logos are property of their respective owners.<br/>Your use of any information or materials on this website is entirely at your own risk.</p>
            </div>
        </div>
    </footer>

    <!-- Modal CLOSED -->
<!--     <div id="modal-connexion" class="modal-container">
        <div class="modal">
            <div class="text-container">
                <p class="title">Connexion impossible</p>
                <p class="explications">Square cloud est actuellement fermé.<br/>Allez trainer sur Facebook en attendant.</p>
            </div>
            <div class="modal-buttons">
                <a id="close" href="http://facebook.com" title="">OK</a>
            </div>
        </div>
    </div> -->
    
    <!-- Modal account closed -->
<!--     <div id="modal-account" class="modal-container">
        <div class="modal">
            <div class="text-container">
                <p class="title">Registration is now closed</p>
                <p class="explications">It will re-open shortly.</p>
            </div>
            <div class="modal-buttons">
                <a id="close" class="" title="">OK</a>
            </div>
        </div>
    </div> -->

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="../js/global.js" type="text/javascript"></script>

    <script src="js/vendor/effect/jquery.animateNumber.min.js" type="text/javascript"></script>
    <script type="text/javascript">

        $('#number')
            .animateNumber(
            {
              number: 200
            },
            6000,
            'easeOutCirc'
        );
    </script>
    </body>
</html>

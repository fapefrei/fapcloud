<?php if(!isset($_SESSION)) session_start(); ?>
<?php
//Redirection si url rewriting mauvais
$user = $_GET['user'];
if(!isset($_GET["user"]) || ($_GET["user"] == "")  ){
    header("location: /profil/".$user);
}
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(strpos($actual_link, 'php') == true){
    header("location: /profil/".$user);
}
?>

<?php include_once('functions.php'); ?>

<?php 
include("connect_db.php"); 
/* Check user to display */
if(isset($_GET["user"])){
    if($_GET["user"] == $_SESSION["pseudo"]){
        $usr = $_SESSION["pseudo"];
        $own = 1;
    }else{
        $usr = $_GET["user"];
    }
}else{
    $usr = $_SESSION["pseudo"];
    $own = 1;
}

$getUserInfo = "SELECT * FROM usr WHERE uname = '$usr'";
$result = $conn->query($getUserInfo);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $name = $row["name"];
        $lastname = $row["lastname"];
        $pseudo = $row["uname"];
        $initiale = $row["initiale"];
        $promo = $row["promo"];
        $groupe = $row["groupe"];
        $avatar = $row["avatar"];
        $pass = $row['upass'];
        if($own != 1){
            $_SESSION['stranger-color'] = $row['color'];
        }else{
            $color = $row['color'];
        }
        $email = $row['email'];
        $downloads = $row["downloads"];
        // $description = $row["description"];
        $vip = $row["vip"];
        $lastlogin = $row['lastLogin'];
        $creation = $row['dateinscription'];
    }
} else {
    echo "User not found.";
    // echo '<meta http-equiv="refresh" content="0;URL=../404.php">';
    exit();
}
?>
<?php redirect(); ?>
<!DOCTYPE html>
<html lang="fr">
<!-- IMPORTANT NOTE: This file is licensed only for use in providing the Square Cloud service,
or any part thereof, and is subject to the Square Cloud Terms and Conditions. You may not
port this file to another platform without the owner's written consent. --> 
<head>
    <meta charset="UTF-8">
    <title><?= ucfirst($name).' (@'.$pseudo.')';?> | Square Cloud</title>
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
</head>
<body id="template-profil">
    
    <?php get_navbar(); ?>

    <div id="content-wrap">
    
        <!-- SIDE CONTENT -->
        <div class="side-content">
            <?php include('parts/user-card.php'); ?>
            <?php ($own == 1 ? include('parts/favoris.php') : '' ); ?>
            <?php include('parts/localisation.php'); ?>
            <hr>
            <?php include('parts/tendances.php'); ?>
            <?php include('parts/suggestions.php'); ?>
        </div>

        <!-- CENTER CONTENT -->
        <div class="center-content">

            <div class="tableted">
                <?php include('parts/user-card.php'); ?>

            </div>

            <div class="card toolbar-card" style="margin-top: 0;">
                <ul class="tab-selection">
                    <li class="<?php if($_GET["tab"] != '3'){ echo 'selected';} ?>" data-section="sec-add"><span class="icon-noun-reply"></span>Ajouts</li>
                    <li data-section="sec-aime"><span class="icon-noun-like"></span>J'aime</li>
                    <?php if($own){ ?>
                    <a href="/settings/<?= $_SESSION["pseudo"]; ?>">
                        <li class="<?php if($_GET["tab"] == '3'){ echo 'selected';} ?>" data-section="sec-"><span class="icon-noun-settings"></span>Paramètres</li>
                    </a>
                    <?php } ?>
                </ul>
            </div>

            <section id="sec-aime">
                <div class="post-list-title">
                    <h3>Aimé par @<?= $name; ?></h3>
                </div>
                <div class="posts-list">
                    <?= like_history($pseudo); ?>
                    <?php include('parts/fin-de-liste.php'); ?>
                </div>
            </section>

            <!-- if user is connected -->
            <?php if($own){ ?>
            <section id="sec-param" class="<?php if($_GET["tab"] == '3'){ echo 'selected';} ?>">
                <ul class="list-slide">
                    <li>
                        <div class="top-list">
                            <i class="material-icons">account_circle</i><p>Votre compte</p>
                            <p class="data"><?= $name.' '. $lastname ?></p>
                        </div>
                        <div class="bottom-list">
                            <p class="caption">Un aperçu des informations de votre compte Square Cloud.</p>
                            <p style="text-transform: capitalize;">Prénom : <b><?= $name .'</b> Nom : <b>'. $lastname; ?></b></p>
                            <p>Nom d'utilisateur : <b>@<?= $usr; ?></b></p>
                            <?php if($promo == 'M1'){ $majeure = 'Majeure :';} ?>
                            <p>Année actuelle : <b><?php if($promo == 'M2'){ echo 'Master 2ème année';}elseif($promo == 'M1'){ echo 'Master 1ère année';}elseif($promo == 'L1'){ echo 'Licence 1ère année';}elseif($promo == 'L2'){ echo 'Licence 2ème année';}elseif($promo == 'L3'){ echo 'Licence 3ème année';};  echo '</b> '. $majeure .'<b> '. $groupe; ?></b></p>
                            <p >Adresse email <?php if(strpos($email, 'efrei') !== false) { echo 'Efrei'; }else{ echo 'Esigetel'; } ?> : <b><?= $email; ?></b></p>
                            <p>Création du compte : <b><?= strftime("%A %d %B %Y",strtotime($creation));  ?></b></p>
                            <p>Dernière connexion : <b><?= strftime("%A %d %B %Y à %H:%M",strtotime($lastlogin));?></b></p>
                            <p>Avant dernière connexion : <b><?= strftime("%A %d %B %Y à %H:%M",strtotime($_SESSION['lastlogin']));?></b></p>
                        </div>
                    </li>

                    <li>
                        <div class="top-list">
                            <i class="material-icons">lock</i><p>Mot de passe</p>
                            <p class="data">******</p>
                        </div>
                        <div class="bottom-list">
                            <p class="caption">Modifiez votre mot de passe.</p>
                            <form class="form" autocomplete="off" id="passchange" action="/functions.php" method="">
                                <input class="input" required max-length="40" id="pass" type="password" placeholder="Mot de passe actuel">
                                <br/>
                                <input class="input" required max-length="40" id="pass1" type="password" placeholder="Nouveau mot de passe">
                                <input class="input" required max-length="40" id="pass2" type="password" placeholder="Retapez">
                                <input class="input" id="passT" type="hidden" value="<?= $pass; ?>">
                                <input class="submit" type="submit">
                            </form>
                            <p id="error"></p>
                        </div>
                    </li>

                    <li>
                        <div class="top-list">
                            <i class="material-icons">colorize</i><p>Couleur du thème</p>
                            <p class="data">#<?= $color; ?></p>
                        </div>
                        <div class="bottom-list">
                            <p class="caption">Choisissez la couleur de contraste qui sera utilisée sur tout le site.</p>
                            <?php include('parts/color-picker.php'); ?>
                        </div>
                    </li>

                    <li>
                        <div class="top-list">
                            <i class="material-icons">portrait</i><p>Avatar de profil</p>
                            <p class="data"><?= $_SESSION['avatar']; ?></p>
                        </div>
                        <div class="bottom-list">
                            <p class="caption">Choisissez un avatar de profil. Si le choix ne vous convient pas, vous n'avez qu'a qu'a prendre le moins moche.</p>
                            <?php include('parts/avatar-picker.php'); ?>
                        </div>
                    </li>

                    <li>
                        <div class="top-list">
                            <i class="material-icons">cached</i><p>Connexion automatique</p>
                            <p class="data"><?=  (isset($_COOKIE['AUTH']) ? 'Oui' : 'Non'); ?></p>
                        </div>
                        <div class="bottom-list">
                            <p class="caption">La fonction connexion automatique vous permet de rester connecté sur Square Cloud sans avoir à entrer de nouveau votre mot de passe.</p>
                            <p><?php if(isset($_COOKIE['AUTH']) ){ echo'Connexion automatique activée sur ce navigateur. Pour désactiver cette fonction, déconnectez-vous.';}else{ echo 'Vous n\'avez pas activé la connexion automatique sur ce navigateur.';} ?></p>
                        </div>
                    </li>

                    <li>
                        <div class="top-list">
                            <i class="material-icons">fingerprint</i><p>Confidentialité</p>
                            <p class="data"></p>
                        </div>
                        <div class="bottom-list">
                            <p>Votre profil utilisateur n'est pas référencé par les moteurs de recherche.</p>
                            <p>Les documents et fichiers ne sont pas référencés par les moteurs de recherches et ne sont accessibles qu'aux personnes ayant un compte Square Cloud.</p>
                        </div>
                    </li>

                    <li>
                        <div class="top-list">
                            <i class="material-icons">delete_forever</i><p>Suppimer mon compte</p>
                            <p class="data"></p>
                        </div>
                        <div class="bottom-list">
                            <p class="caption">Veuillez noter que la suppression de votre compte est définitive. Toutes vos données utilisateurs seront supprimées définitivement.</p>
                            <div id="delete" class="btn">Supprimer définitivement mon compte</div>
                        </div>
                    </li>
                </ul>
            </section>

            <?php } ?>

            <!-- if visitor -->
            <section id="sec-add" class="<?php if($_GET["tab"] != '3'){ echo 'selected';} ?>">
                <div class="post-list-title">
                    <h3>Ajouté par @<?= $name; ?></h3>
                </div>
                <div class="posts-list">
                    <?= upload_history($pseudo); ?>
                    <?php include('parts/fin-de-liste.php'); ?>
                </div>
            </section>
        </div>
    </div>

    <!-- Modal delete account -->
    <div id="modal-delete" class="modal-container">
        <div class="modal">
            <div class="text-container">
                <p class="title">Suppression de votre compte</p>
                <p class="explications">Une fois votre compte Square Cloud supprimé, vous ne serez pas en mesure d'en créer un nouveau.</p>
            </div>
            <div class="modal-buttons">
                <a class="two" id="close" title="">Annuler</a>
                <a class="two" id="valide" title="" style="color: red;">Supprimer</a>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
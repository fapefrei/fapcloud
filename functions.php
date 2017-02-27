<?php

/* ==========================================================================
    FUNCTIONS PHP
/* ========================================================================== */

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ){
    if(isset($_GET['action'])){
        $function = $_GET['action'];
        if(function_exists($function)) {        
            call_user_func($function);
            logs_history('Function executed', $function);
        } else {
            echo 'Function Not Exists!!';
            logs_history('Function not found', $function);
        }
    }
}

// include_once("parts/analytics.php");

setlocale(LC_TIME, 'fr_FR');

function get_signature(){
    echo 'Designed & Coded with ❤ by Loris M.';
}

/* ==========================================================================
    LOGIN / LOGOUT
/* ========================================================================== */

/* Checks if the user is logged in (true/false) */
function is_logged_in(){
    
    if(!isset($_SESSION)) session_start();
    if ( isset( $_SESSION['pseudo'])){
        return true;
    }else{
        return false;
    }
}

/* MAIN LOGIN FUNCTION */
function login($mail = '', $password = '', $alt = 0)
{
    $try = '['.$_POST['username'].'] ['.$_POST["password"].']';
    logs_history('Login try', $try);

    if( $alt == 1 ){
        $password_crypte = $password;
        $email = $mail;
    }else{
        $salt = "Sguar€ë&•&çl0ud)";
        $password = $_POST["password"];
        $password_crypte = sha1(sha1($password).$salt);
        $email = $_POST['username'];
    }

    $check = "SELECT * FROM usr WHERE email = '$email'";
    require("connect_db.php");

    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Password is good
            if($password_crypte == $row['upass']) {
                // User acount is active
                if($row['actif'] == 1){
                    // SESSION variables set
                    if(!isset($_SESSION)) session_start();
                    $_SESSION["pseudo"] = $row["uname"];
                    $_SESSION["nom"] = $row['lastname'];
                    $_SESSION["prenom"] = $row['name'];
                    $_SESSION["promo"] = $row["promo"];
                    $_SESSION["avatar"] = $row['avatar'];
                    $_SESSION["color"] = $row['color'];
                    $_SESSION["lastlogin"] = $row["lastLogin"];
                    if( $row["vip"] == '1'){
                        $_SESSION["vip"] = 1;
                    }
                    // Update user values
                    $username = $row["uname"];
                    lastlogin($username);
                    // last($username);

                    // If redirection in url
                    if(isset($_POST['redirect']) && ($_POST['redirect'] != '')) {
                        $retour['redirect'] = $_POST['redirect'];

                    // If login by cookies
                    }elseif($alt == 1){
                        echo '<meta http-equiv="refresh" content="0;/">';

                    // If classic login
                    }else{
                        $retour['redirect'] = "/template-homepage.php";
                    }

                    // Cookies set
                    if($_POST['remember'] == 1){
                        $_SESSION['password'] = $row['upass'];
                        $retour['redirect'] = "/template-cookie.php";
                    }

                    // Mise à jour du compte
                    if( ($row["lastLogin"] < '2016-08-01') && ($row["dateinscription"] < '2016-08-01') ){
                        $retour['redirect'] = "/template-mise-a-niveau.php";
                    }

                }else{
                    // Compte non activé
                    header('HTTP/1.1 500 Internal Server Error');
                    $retour['erreur'] = $row["errormess"];
                }
            }else{
                // Mot de passe non valide
                header('HTTP/1.1 500 Internal Server Error');
                $retour['erreur'] = "Mot de passe incorrect";
            }
        }
    }else{
        // Adresse email non reconnue
        header('HTTP/1.1 500 Internal Server Error');
        $retour['erreur'] = "Adresse email incorrecte";
    }
    $conn->close();
    echo json_encode($retour);
}

function logout()
{
    logs_history('Logout user', null);

    /* ERASE SESSION */
    if(!isset($_SESSION)) session_start();
    $_SESSION["promo"] = null;
    $_SESSION["pseudo"] = null;
    session_unset(); 
    session_destroy();

    /* ERASE COOKIES */
    setcookie ("AUTH", "", time() - 3600);
    setcookie ("auth", "", time() - 3600);

    // Redirection to login
    $retour['redirect'] = "/template-login.php";
    echo json_encode($retour);
}

function delete_cookie()
{
    if(!isset($_SESSION)) session_start();
    /* ERASE COOKIES */
    setcookie ("AUTH", "", time() - 3600);
    setcookie ("auth", "", time() - 3600);
}

function test_cookie()
{
    if (isset($_COOKIE['AUTH'])) {
        $savedName = substr($_COOKIE['AUTH'], 0, strrpos($_COOKIE['AUTH'], '-'));
        $savedKey = strstr($_COOKIE['AUTH'], '-');
        $savedKey = substr($savedKey, 1);
        // echo 'SK: '.$savedKey.' <br> SN: '.$savedName;

        require("connect_db.php");
        $check = "SELECT * FROM usr WHERE uname = '$savedName'";
        $result = $conn->query($check);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
            
                $password = sha1($row['upass']);

                if($password == $savedKey){
                    // Login by cookies
                    login($row['email'], $row['upass'], 1);
                }else{
                    echo '⛔️ Erreur de cookie';
                    logs_history('Cookie Error', $savedName);
                }
            }
        }
    }
}

function is_vip(){
    if(!isset($_SESSION)) session_start();
    if ( isset( $_SESSION['vip'])){
        return true;
    }else{
        return false;
    }
}

function redirect(){
    if(!isset($_SESSION)) session_start();
    if(!isset($_SESSION["pseudo"])){
        $current_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        echo'<form action="/home.php" id="red">
        <input type="hidden" name="red" value="'.  $current_link .'">
        </form>';
        ?>
        <script type="text/javascript">
            document.getElementById('red').submit();
        </script>
    <?php
    } 
}

/* ==========================================================================
    ---
/* ========================================================================== */

function changePassword()
{
    require('connect_db.php');
    if(isset($_POST["pass"]) && isset($_POST["pass1"]) && isset($_POST["pass2"])){
        $salt = "Sguar€ë&•&çl0ud)";
        $password = $_POST["pass"];
        $pass = $_POST['truepass'];
        $usr = $_POST['pseudo'];

        $password_entered = sha1(sha1($password).$salt);

        if($password_entered == $pass ){
            if($_POST["pass1"] != $_POST["pass2"]){
                //header('500 Internal Server Error', true, 500);
                echo json_encode('Passwords don&apos;t match.');

            }elseif($_POST["pass1"] != ""){
                $newpass = $_POST["pass1"];
                $salt = "Sguar€ë&•&çl0ud)";
                $password_crypte = sha1(sha1($newpass).$salt);
                $changepass = "UPDATE usr SET upass = '$password_crypte' WHERE uname = '$usr'";

                if ($conn->query($changepass) === TRUE) {
                    include("../scripts/newpassmail.php");
                    echo json_encode('Mot de passe modifié.');
                    $mail = get_user_email($usr);
                    mail_passwordChanged($usr, $usr, $mail);
                    logs_history('Password Changed', $usr);

                } else {
                    //header('500 Internal Server Error', true, 500);
                }

            }else{
                //header('500 Internal Server Error', true, 500);
                echo json_encode('Entrez un nouveau mot de passe.');
            }
        }else{
            //header('500 Internal Server Error', true, 500);
            echo json_encode('Mot de passe actuel invalide.');
        }
    }
}

function get_user_email($pseudo){
    require('connect_db.php');

    $SELECT = "SELECT email FROM usr WHERE uname = '$pseudo'";
    $result = $conn->query($SELECT);

    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            return $row['email'];
        }
    }else{
        //header('500 Internal Server Error', true, 500);
        return null;
    }
    $conn->close();
}

/* Returns the current semester number (1->10) */
function get_the_semester($annee){
    $today = date('Y-m-d');
    $today= date('Y-m-d', strtotime($today));
    require('connect_db.php');

    $SemesterCheck = "SELECT * FROM semesters WHERE year = '$annee'";
    $result = $conn->query($SemesterCheck);

    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $SemesterDateBegin = $row['beginning'];
            $SemesterDateEnd = $row['end'];
            //echo $SemesterDateBegin . ' '.$SemesterDateEnd;
            if (($today >= $SemesterDateBegin) && ($today <= $SemesterDateEnd)){
                return $row['number'];
            }
        }
    }elseif($result->num_rows == 0){
        echo 'Pas de dates de semestres.';
    }
    $conn->close();
}

/* Retourne l'année de sortie de la promo */
function get_the_promo($annee){
    $currentYear = date('Y');
    return $currentYear;
}


/* ==========================================================================
    INCLUDE PARTS
/* ========================================================================== */

/* Get footer and JS scripts */
function get_footer(){
    include_once('parts/popups.php');
    include_once('parts/footer.php');
}

/* Get Navigation bar */
function get_navbar(){
    include_once('parts/menubar.php');
}


/* ==========================================================================
    EMAILS
/* ========================================================================== */

/* Template loader */
function emailLoadTemplate($args, $template){
    ob_start();
    include($template);
    return ob_get_clean();
}

/* Création de compte */
function welcomeMail($prenom, $mail){

    $args = [
        'prenom'=> $prenom,
        'email'=> $mail
    ];

    $emailContent = emailLoadTemplate($args, 'mails/welcome.php');
    $headers = 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'From: Fap Cloud <contact@fapcloud.fr>' . "\r\n";
    $subject = "Bienvenue sur Fap Cloud";
    mail($mail, $subject, $emailContent, $headers);
    logs_history('Mail sent: Welcome', $mail);
}

/* Confirmation du compte */
function confirmMail($prenom, $pseudo, $mail, $key){
    $link = 'http://www.fapcloud.fr/activation.php?log='.urlencode($pseudo).'&cle='.urlencode($key);
    $args = [
        'prenom'=> $prenom,
        'link'=> $link,
        'email'=> $mail
    ];

    $emailContent = emailLoadTemplate($args, 'mails/confirm.php');
    $headers = 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'From: Fap Cloud <contact@fapcloud.fr>' . "\r\n";
    $subject = "Confirmez la création de votre compte";
    mail($mail, $subject, $emailContent, $headers);
    logs_history('Mail sent: Confirm', $mail);
}

function mail_passwordReset($prenom, $mail, $key){

    $args = [
        'prenom'=> $prenom,
        'email'=> $mail,
        'lien'=> 'http://www.fapcloud.fr/template-reset.php?key='.$key
    ];

    $emailContent = emailLoadTemplate($args, 'mails/password-reset.php');
    $headers = 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'From: Fap Cloud <contact@fapcloud.fr>' . "\r\n";
    $subject = "Réinitialisation du mot de passe Fap Cloud";
    mail($mail, $subject, $emailContent, $headers);
    logs_history('Mail sent: Pass reset', $mail);
}

/* Confirmation de mise à jour du mot de passe */
function mail_passwordChanged($prenom, $pseudo, $mail){

    $args = [
        'prenom'=> $prenom,
        'pseudo'=> $pseudo,
        'email'=> $mail
    ];

    $emailContent = emailLoadTemplate($args, 'mails/password.php');
    $headers = 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'From: Fap Cloud <contact@fapcloud.fr>' . "\r\n";
    $subject = "Votre compte a été mis à jour";
    mail($mail, $subject, $emailContent, $headers);
    logs_history('Mail sent: Pass changed', $mail);
}

function mail_signalerprobleme($pseudo, $text, $browser, $date, $page, $type){

    $args = [
        'pseudo'=> $pseudo,
        'text'=> $text,
        'browser'=> $browser,
        'date'=> $date,
        'type'=> $type,
        'page'=> $page
    ];
    $mail = "contact@fapcloud.fr";
    $emailContent = emailLoadTemplate($args, 'mails/signaler-probleme.php');
    $headers = 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'From: Fap Cloud Admin <contact@fapcloud.fr>' . "\r\n";
    $subject = "Signalement de problème [@".$pseudo."]";
    mail($mail, $subject, $emailContent, $headers);
}


/* SIGNALER UN PROBLEME */
function SignalerProbleme(){
    mail_signalerprobleme($_POST['user'], $_POST['text'], $_POST['browser'], $_POST['date'], $_POST['page'], $_POST['type']);
    logs_history('Problem Signaled', $_POST['user']);
}

function mail_cron($task, $mail){

    $args = [
        'task'=> $task,
        'email'=> $mail
    ];

    $emailContent = emailLoadTemplate($args, 'mails/cron-confirm.php');
    $headers = 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'From: Fap Cloud <contact@fapcloud.fr>' . "\r\n";
    $subject = "Tâche Cron effectuée";
    mail($mail, $subject, $emailContent, $headers);
}

/* ==========================================================================
    USER ACCOUNT SETTINGS
/* ========================================================================== */

function valideEmail(){
    /* IS VALID ?*/
    if (empty($_POST["email"])) {
        header('HTTP/1.1 500 Internal Server Error');
        echo "Vous devez avoir une adresse email valide.";

    }else{
        $email = $_POST["email"];
        //    if (!preg_match("/^[a-zA-Z0-9_.+-]+@[efrei]+.[net]",$email)) {
        if( (!preg_match("/@.*efrei\.net$/", $email)) && (!preg_match("/@.*esigetel\.net$/", $email)) ){
            header('HTTP/1.1 500 Internal Server Error');
            $Message = 'Votre adresse email doit être du format nom.prenom@efrei.net ou nom.prenom@esigetel.net.';
            echo $Message;

        }else{
            echo json_encode('Format correct'); 
        }
    }
}

/* AVATAR UPDATE */
function selectAvatar(){
    require('connect_db.php');
    $avatar = $_POST['avatar'];
    $pseudo = $_POST['pseudo'];
    $changeColor = "UPDATE usr SET avatar = '$avatar' WHERE uname = '$pseudo' ";

    if ($conn->query($changeColor) === TRUE) {
        if(!isset($_SESSION)) session_start();
        $_SESSION['avatar'] = $avatar;
        logs_history('Avatar changed', $pseudo);
        echo json_encode('Done');
    } else {
        //header('500 Internal Server Error', true, 500);
        echo 'Error';
    }
}

/* COLOR UPDATE */
function selectColor(){
    require('connect_db.php');
    $color = $_POST['color'];
    $pseudo = $_POST['pseudo'];
    $changeColor = "UPDATE usr SET color = '$color' WHERE uname = '$pseudo' ";

    if ($conn->query($changeColor) === TRUE) {
        if(!isset($_SESSION)) session_start();
        $_SESSION['color'] = $color;
        logs_history('Color changed', $pseudo);
        echo json_encode('Done');
    } else {
        //header('500 Internal Server Error', true, 500);
        echo 'Error';
    }
}

/* FAVORIS (SUBJECTS) */
function getFavoris($uname){
    require('connect_db.php');
    $getsubjects = "SELECT * FROM favoris LEFT JOIN subjects ON favoris.subject = subjects.codename WHERE uname = '$uname' ORDER BY name";
    $result = $conn->query($getsubjects);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) { ?>
            <a href="/single-matiere.php?subject=<?= $row['subject']; ?>">
                <div class="matiere">
                    <div class="icon theme-bcolor"><i class="material-icons"><?= $row["icon"]; ?></i></div>
                    <p><?= $row["name"]; ?></p>
                    <div class="favoris favoris-list" data-matiere="<?= $row['subject']; ?>"><i class="material-icons">close</i></div>
                </div>
            </a>
            <?php }
    } else {
        ?>
        <p class="aucun">Vous n'avez aucun favoris</p>
        <?php   
    }
}

/* NUMBER OF ADDED FILES */
function ajouts($user){
    require('connect_db.php');
    $getMax = "SELECT * FROM documents WHERE uploaderdisplay = '$user' ";
    $result = $conn->query($getMax);
    return ($result->num_rows);
}


/* ==========================================================================
    SUBJECTS + POPULARITY
/* ========================================================================== */

function getMaxPopularity($promo){
    require('connect_db.php');
    $getMax = "SELECT MAX(popularity) FROM subjects WHERE annee = '$promo' ";
    $result = $conn->query($getMax);
    print_r( $result->fetch_assoc());
}

function getPopularMatieres($promo, $limit){
    require('connect_db.php');
    $getsubjects = "SELECT * FROM subjects WHERE annee = '$promo' ORDER BY popularity DESC LIMIT $limit";
    $result = $conn->query($getsubjects);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) : ?>
            <a href="/single-matiere.php?subject=<?= $row["codename"]; ?>" class="matiere">
                <div class="icon theme-bcolor"><i class="material-icons"><?= $row["icon"]; ?></i></div>
                <p><?= $row["name"]; ?></p>
            </a>
        <?php endwhile;
    }else{
     ?>
     <p class="aucun">Aucune matière populaire</p>
     <?php   
    }
}

function getAllMatieres($promo){
    require('connect_db.php');
    $getsubjects = "SELECT * FROM subjects WHERE annee = '$promo' AND majeure IS NULL ORDER BY name ASC";
    $result = $conn->query($getsubjects);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) : ?>
            <a href="/single-matiere.php?subject=<?= $row["codename"]; ?>" class="matiere">
                <div class="icon theme-bcolor"><i class="material-icons"><?= $row["icon"]; ?></i></div>
                <p><?= $row["name"]; ?></p>
            </a>
        <?php endwhile;
    }else{
     ?>
     <p class="aucun">Aucune matière trouvée en <?= $promo;?></p>
     <?php   
    }
}

function get_the_most_popular_subject($promo){
    require('connect_db.php');
    $getsubjects = "SELECT * FROM subjects WHERE annee = '$promo' ORDER BY popularity DESC LIMIT 3";
    $result = $conn->query($getsubjects);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) : ?>
            <li>
                <a href="/single-matiere.php?subject=<?= $row['codename']; ?>" >
                    <p class="trend theme-fcolor"><?= $row['name']; ?></p>
                    <p class="description"><?= get_subject_total_download($row['codename']); ?></p>
                </a>
            </li>
        <?php endwhile;
    }
}

function get_subject_total_download($subject){
    require("connect_db.php");
    $DD = "SELECT DISTINCT(id) FROM documents WHERE subject = '$subject'"; 
    $result = $conn->query($DD);
    if ($result->num_rows > 1) {
        return ($result->num_rows).' documents';
    } elseif ($result->num_rows == 1) {
        return ($result->num_rows).' document';
    } else {
        return null;
    }
}

function get_the_most_popular_document($promo){
    require('connect_db.php');
    $getsubjects = "SELECT * FROM documents LEFT JOIN subjects ON documents.subject = subjects.codename WHERE annee = '$promo' ORDER BY downloads DESC LIMIT 3";
    $result = $conn->query($getsubjects);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) : ?>
            <li>
                <a href="/single-document.php?document=<?= $row['id']; ?>" >
                    <p class="trend theme-fcolor"><?= $row['titre']; ?></p>
                    <?php if($row['downloads'] >= 2 ){ ?>
                    <p class="description"><?= $row['downloads']; ?> Téléchargements</p>
                    <?php } ?>
                </a>
            </li>
        <?php endwhile;
    }
}

function get_the_most_popular_hashtags(){

}

function changePromotion(){
    if(!isset($_SESSION)) session_start();
    $_SESSION['promo'] = $_POST['promo'];
    logs_history('Promotion changed', $_POST['promo']);
}

/* ==========================================================================
    PROMOTED TRENDS
/* ========================================================================== */

function get_promoted_trends($promo){
    require('connect_db.php');
    $getsubjects = "SELECT * FROM trends WHERE (promo = '$promo') OR (promo = 'all') ORDER BY date DESC";
    $result = $conn->query($getsubjects);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) : ?>
            <li>
                <a href="<?= $row['link']; ?>">
                    <p class="trend theme-fcolor"><?= $row['title']; ?></p>
                    <p class="description promoted">Sponsorisé par <?= $row['by']; ?></p>
                </a>
            </li>
        <?php endwhile;
    }
}

function meilleursContributeurs(){
    require('connect_db.php');
    $connectedusr = "SELECT * FROM documents LEFT JOIN usr ON usr.uname = documents.uploaderdisplay WHERE available = 1 GROUP BY name ORDER BY count(name) DESC LIMIT 4";
    $result = $conn->query($connectedusr);
    if ($result->num_rows > 0){

        while($row = $result->fetch_assoc()) { ?>
            <li>
                <a href="/template-profil.php?user=<?= $row['uname']; ?>">
                    <div class="avatar-medium avatar-<?= $row['avatar']; ?>-sm">
                        <?php if($row['vip']){ ?>
                            <svg width="26" height="26" viewBox="0 0 26 26" data-reactid=".erdow2pz40.4.0.0.0.0.1.0.0.0">
                            <path d="M13,24.9c-0.5,0-1-0.2-1.3-0.6l-1.9-1.9c-0.4-0.4-0.7-0.5-1.2-0.5H5.8c-1,0-1.8-0.8-1.8-1.8v-2.7c0-0.5-0.2-0.8-0.5-1.2l-1.9-1.9C1.2,13.9,1,13.4,1,13s0.2-0.9,0.6-1.3l1.9-1.9C3.9,9.4,4,9.1,4,8.6V5.9c0-1,0.8-1.8,1.8-1.8h2.7c0.5,0,0.8-0.2,1.2-0.5l1.9-1.9C12,1.3,12.5,1.1,13,1.1s1,0.2,1.3,0.6l1.9,1.9c0.3,0.3,0.7,0.5,1.2,0.5h2.7c1,0,1.8,0.8,1.8,1.8v2.5c0,0.5,0.3,1.1,0.6,1.5l1.8,1.8c0.4,0.4,0.6,0.8,0.6,1.3c0,0.5-0.2,0.9-0.6,1.3l-1.9,1.9C22.3,16.5,22,17,22,17.5v2.7c0,1-0.8,1.8-1.8,1.8h-2.7c-0.5,0-0.8,0.2-1.2,0.5l-1.9,1.9c-0.1,0.1-0.2,0.1-0.3,0.2C13.9,24.7,13.5,24.9,13,24.9z" fill="#55acee" data-reactid=".erdow2pz40.4.0.0.0.0.1.0.0.0.0"></path>
                            <path d="M13,2.1c0.2,0,0.5,0.1,0.6,0.3l1.9,1.9c0.5,0.5,1.2,0.8,1.9,0.8h2.7c0.5,0,0.8,0.4,0.8,0.8v2.5c0,0.7,0.4,1.6,0.9,2.2l1.8,1.8c0.4,0.4,0.4,0.8,0,1.2l-1.9,1.9C21.4,16,21,16.7,21,17.4v2.7c0,0.5-0.4,0.8-0.8,0.8h-2.7c-0.7,0-1.4,0.3-1.9,0.8l-1.9,1.9c-0.2,0.1-0.5,0.2-0.6,0.2s-0.5-0.1-0.6-0.3l-1.9-1.9c-0.5-0.5-1.2-0.8-1.9-0.8H5.8c-0.5,0-0.8-0.4-0.8-0.8v-2.7c0-0.7-0.3-1.4-0.8-1.9l-1.9-1.9c-0.4-0.4-0.4-0.8,0-1.2l1.9-1.9C4.7,10,5,9.4,5,8.6V5.9c0-0.5,0.4-0.8,0.8-0.8h2.7c0.7,0,1.4-0.3,1.9-0.8l1.9-1.9C12.5,2.2,12.8,2.1,13,2.1 M13,0.1c-0.7,0-1.5,0.3-2,0.9L9,2.9C8.8,3.1,8.7,3.1,8.6,3.1H5.8C4.3,3.1,3,4.4,3,5.9v2.7c0,0.2-0.1,0.2-0.1,0.3C2.9,9,2.8,9,2.8,9L0.9,11C0.3,11.5,0,12.2,0,13c0,0.7,0.3,1.5,0.9,2l1.9,1.9C3,17.1,3,17.2,3,17.4v2.7c0,1.6,1.3,2.8,2.8,2.8h2.7c0.1,0,0.3,0,0.5,0.2L11,25c0.5,0.5,1.3,0.9,2,0.9c0.7,0,1.3-0.3,1.5-0.4c0.2-0.1,0.4-0.2,0.5-0.4l1.9-1.9c0.2-0.2,0.4-0.2,0.5-0.2h2.7c1.6,0,2.8-1.3,2.8-2.8v-2.7c0-0.1,0.1-0.4,0.2-0.5l1.9-1.9c0.6-0.6,0.9-1.3,0.9-2c0-0.7-0.3-1.5-0.9-2l-1.8-1.8C23.1,9.1,23,8.7,23,8.5V5.9c0-1.6-1.3-2.8-2.8-2.8h-2.7c-0.1,0-0.4-0.1-0.5-0.2L15,1C14.5,0.4,13.7,0.1,13,0.1L13,0.1z" fill="#fff" data-reactid=".erdow2pz40.4.0.0.0.0.1.0.0.0.1"></path> 
                            <path d="M15.3,16.5C14.7,16.9,14,17,13.2,17H10V9h3.2c0.6,0,1.3,0.1,1.8,0.4c0.6,0.4,0.9,1,0.9,1.7c0,0.7-0.3,1.4-1,1.7c0.8,0.3,1.1,1.1,1.1,1.8C16.1,15.4,15.9,16,15.3,16.5z M13.3,10.3h-1.8v2h1.8c0.7,0,1.2-0.2,1.2-1C14.5,10.5,13.9,10.3,13.3,10.3z M13.3,13.5h-1.8v2.2h1.8c0.7,0,1.4-0.2,1.4-1.1C14.7,13.8,14.1,13.5,13.3,13.5z" fill="#fff" data-reactid=".erdow2pz40.4.0.0.0.0.1.0.0.0.2"></path>
                            </svg>
                        <?php } ?>
                    </div>
                    <div class="textes">
                        <p><?= $row['name']; ?> <strong>• <?= $row['promo']; ?></strong></p>
                        <p>@<?= $row['uname']; ?></p>
                    </div>
                </a>
            </li>
        <?php }
    } else {
        ?>
        <p class="aucun">Recherche...</p>
    <?php       }
}

function connected_users(){
    require('connect_db.php');
    $today = new DateTime('now');
    $now = $today->format('Y-m-d H:i:s');
    $currentDate = strtotime($now);
    $futureDate = $currentDate-(60*60*24);
    $formatDate = date("Y-m-d H:i:s", $futureDate);

    $connectedusr = "SELECT * FROM usr WHERE lastlogin BETWEEN ('$formatDate') AND ('$now') ORDER BY lastlogin DESC";
    $result = $conn->query($connectedusr);
    if ($result->num_rows > 0){

        while($row = $result->fetch_assoc()) { ?>
            <li>
                <a href="/template-profil.php?user=<?= $row['uname']; ?>">
                    <div class="avatar-medium avatar-<?= $row['avatar']; ?>-sm">
                        <?php if($row['vip']){ ?>
                            <svg width="26" height="26" viewBox="0 0 26 26" data-reactid=".erdow2pz40.4.0.0.0.0.1.0.0.0">
                            <path d="M13,24.9c-0.5,0-1-0.2-1.3-0.6l-1.9-1.9c-0.4-0.4-0.7-0.5-1.2-0.5H5.8c-1,0-1.8-0.8-1.8-1.8v-2.7c0-0.5-0.2-0.8-0.5-1.2l-1.9-1.9C1.2,13.9,1,13.4,1,13s0.2-0.9,0.6-1.3l1.9-1.9C3.9,9.4,4,9.1,4,8.6V5.9c0-1,0.8-1.8,1.8-1.8h2.7c0.5,0,0.8-0.2,1.2-0.5l1.9-1.9C12,1.3,12.5,1.1,13,1.1s1,0.2,1.3,0.6l1.9,1.9c0.3,0.3,0.7,0.5,1.2,0.5h2.7c1,0,1.8,0.8,1.8,1.8v2.5c0,0.5,0.3,1.1,0.6,1.5l1.8,1.8c0.4,0.4,0.6,0.8,0.6,1.3c0,0.5-0.2,0.9-0.6,1.3l-1.9,1.9C22.3,16.5,22,17,22,17.5v2.7c0,1-0.8,1.8-1.8,1.8h-2.7c-0.5,0-0.8,0.2-1.2,0.5l-1.9,1.9c-0.1,0.1-0.2,0.1-0.3,0.2C13.9,24.7,13.5,24.9,13,24.9z" fill="#55acee" data-reactid=".erdow2pz40.4.0.0.0.0.1.0.0.0.0"></path>
                            <path d="M13,2.1c0.2,0,0.5,0.1,0.6,0.3l1.9,1.9c0.5,0.5,1.2,0.8,1.9,0.8h2.7c0.5,0,0.8,0.4,0.8,0.8v2.5c0,0.7,0.4,1.6,0.9,2.2l1.8,1.8c0.4,0.4,0.4,0.8,0,1.2l-1.9,1.9C21.4,16,21,16.7,21,17.4v2.7c0,0.5-0.4,0.8-0.8,0.8h-2.7c-0.7,0-1.4,0.3-1.9,0.8l-1.9,1.9c-0.2,0.1-0.5,0.2-0.6,0.2s-0.5-0.1-0.6-0.3l-1.9-1.9c-0.5-0.5-1.2-0.8-1.9-0.8H5.8c-0.5,0-0.8-0.4-0.8-0.8v-2.7c0-0.7-0.3-1.4-0.8-1.9l-1.9-1.9c-0.4-0.4-0.4-0.8,0-1.2l1.9-1.9C4.7,10,5,9.4,5,8.6V5.9c0-0.5,0.4-0.8,0.8-0.8h2.7c0.7,0,1.4-0.3,1.9-0.8l1.9-1.9C12.5,2.2,12.8,2.1,13,2.1 M13,0.1c-0.7,0-1.5,0.3-2,0.9L9,2.9C8.8,3.1,8.7,3.1,8.6,3.1H5.8C4.3,3.1,3,4.4,3,5.9v2.7c0,0.2-0.1,0.2-0.1,0.3C2.9,9,2.8,9,2.8,9L0.9,11C0.3,11.5,0,12.2,0,13c0,0.7,0.3,1.5,0.9,2l1.9,1.9C3,17.1,3,17.2,3,17.4v2.7c0,1.6,1.3,2.8,2.8,2.8h2.7c0.1,0,0.3,0,0.5,0.2L11,25c0.5,0.5,1.3,0.9,2,0.9c0.7,0,1.3-0.3,1.5-0.4c0.2-0.1,0.4-0.2,0.5-0.4l1.9-1.9c0.2-0.2,0.4-0.2,0.5-0.2h2.7c1.6,0,2.8-1.3,2.8-2.8v-2.7c0-0.1,0.1-0.4,0.2-0.5l1.9-1.9c0.6-0.6,0.9-1.3,0.9-2c0-0.7-0.3-1.5-0.9-2l-1.8-1.8C23.1,9.1,23,8.7,23,8.5V5.9c0-1.6-1.3-2.8-2.8-2.8h-2.7c-0.1,0-0.4-0.1-0.5-0.2L15,1C14.5,0.4,13.7,0.1,13,0.1L13,0.1z" fill="#fff" data-reactid=".erdow2pz40.4.0.0.0.0.1.0.0.0.1"></path> 
                            <path d="M15.3,16.5C14.7,16.9,14,17,13.2,17H10V9h3.2c0.6,0,1.3,0.1,1.8,0.4c0.6,0.4,0.9,1,0.9,1.7c0,0.7-0.3,1.4-1,1.7c0.8,0.3,1.1,1.1,1.1,1.8C16.1,15.4,15.9,16,15.3,16.5z M13.3,10.3h-1.8v2h1.8c0.7,0,1.2-0.2,1.2-1C14.5,10.5,13.9,10.3,13.3,10.3z M13.3,13.5h-1.8v2.2h1.8c0.7,0,1.4-0.2,1.4-1.1C14.7,13.8,14.1,13.5,13.3,13.5z" fill="#fff" data-reactid=".erdow2pz40.4.0.0.0.0.1.0.0.0.2"></path>
                            </svg>
                        <?php } ?>
                        <div class="connected-dot"></div>
                    </div>
                    <div class="textes">
                        <p><?= $row['name']; ?> <strong>• <?= $row['promo']; ?></strong></p>
                        <p>@<?= $row['uname']; ?></p>
                        <p><?= time_ago(strtotime($row['lastLogin'])); ?></p>
                        <p class="numlog">[<?= $row['numlog']; ?>]</p>
                    </div>
                </a>
            </li>
        <?php }
    } else {
        ?>
        <p class="aucun">Recherche...</p>
    <?php       }
}

function lastlogin($user){
    require('connect_db.php');
    $today = new DateTime('now');
    $now = $today->format('Y-m-d H:i:s');

    $lastlog = "UPDATE usr SET lastLogin = '$now' WHERE uname = '$user'";
    $result = $conn->query($lastlog);

    if ($conn->query($lastlog) === TRUE) {
        if(!isset($_SESSION)) session_start();
        $_SESSION['newlastlogin'] = $now;
    } else {
        die("Erreur sur logindate");
    }

    $getLogNumber = "SELECT numlog FROM usr WHERE uname = '$user'" ;
    $result = $conn->query($getLogNumber); 
    if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) {
            $lognum = $row["numlog"]; 
        }
    }
    $lognum = $lognum + 1; 
    $Log = "UPDATE usr SET numlog = '$lognum' WHERE uname = '$user'";
    if ($conn->query($Log) === TRUE) {
    } else {
        die("Erreur sur numlog");
    }
}

// /!\ FONCTION QUI DECONNE
// function last($user){
//     //Updates last login values
//     require('connect_db.php');

//     $pageContent = file_get_contents('http://freegeoip.net/json/');
//     $parsedJson  = json_decode($pageContent);
//     $ip = htmlspecialchars($parsedJson->ip);
//     $city = htmlspecialchars($parsedJson->city);
//     $country = htmlspecialchars($parsedJson->country_name);
//     $Log = "UPDATE usr SET lastLoginIp = '$ip', lastLoginCity = '$city', lastLoginCountry = '$country' WHERE uname = '$user'";
//     if ($conn->query($Log) === TRUE) {
//     } else {
//         die("Erreur sur last values");
//     }
// }

/* ==========================================================================
    LINK
/* ========================================================================== */

function the_link($address){
    echo 'https://fapcloud.fr/'.substr($address, 3);
}

/* ==========================================================================
    DOCUMENT
/* ========================================================================== */

/* Display Documents from a subject */
function get_documents($subject){
        require("connect_db.php");
        $DD = "SELECT * FROM documents WHERE subject = '$subject' AND available ='1' ORDER BY dldate DESC"; 
        $result = $conn->query($DD);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) { 
            ?>
                <div class="file-card" data-file-type="<?= $row['type']; ?>" data-file-id="<?= $row['id']; ?>" >
                    <div class="file"><i class="filefont-<?= $row['format']; ?>"></i></div>
                    <div class="texts">
                        <p class="eyebrow"><?= get_subject_name($row['subject']); ?></p>
                        <p class="titre"><?= $row['titre']; ?></p>
                    </div>
                    <a target="parent" href="<?= $row['address']; ?>" data-document-id="<?= $row['id']; ?>" class="download-button"><?= download_history($row['id'], $_SESSION['pseudo']); ?></a>
                    <!-- <div class="format"><?= $row['format']; ?></div> -->
                    <div class="file-infos">
                        <canvas class="file-preview" id="canvas-<?= $row['id']; ?>" ></canvas>
                        <script id="script">

                            // If absolute URL from the remote server is provided, configure the CORS
                            // header on that server.
                            //
                            var url = "<?= the_link($row['address']); ?>";

                            PDFJS.workerSrc = '../js/vendor/pdfjs/pdf.worker.js';

                            PDFJS.getDocument(url).then(function getPdfHelloWorld(pdf) {

                                pdf.getPage(1).then(function getPageHelloWorld(page) {
                                    var scale = 1;
                                    var viewport = page.getViewport(scale);

                                    var canvas = document.getElementById('canvas-<?= $row["id"]; ?>');
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
                            <div class="label">.<?= strtoupper($row['format']); ?></div>
                            <div class="label"><?= strtoupper($row['type']); ?></div>
                            <p>Année : <?= $row['year'].'-'.($row['year'] + 1); ?></p>
                            <p>Source : <?= $row['source']; ?></p>
                            <p>Taille : <?= human_filesize(filesize($row['address'])); ?></p>
                            <p>Nom du fichier : <?= $row['nomoriginal']; ?></p>
                            <p><?= strftime("%H:%M - %A %d %B %Y",strtotime($row['dldate']));?></p>
                        </div>
                        <table class="file-status">
                            <tr>
                                <td><p>Téléchargements</p><p class="theme-fcolor"><?= get_dowloads_number($row['id']); ?></p></td>
                                <td>
                                    <?php get_who_dowloaded($row['id']); ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="file-footer">
                        <p class="file-user">Ajouté par <a href="/template-profil.php?user=<?= $row['uploaderdisplay']; ?>"><strong class="theme-fcolor"><?= $row['uploaderdisplay']; ?></strong></a></p>
                        <a href="/single-document.php?document=<?= $row['id']; ?>" class="file-timestamp"><?= time_ago(strtotime($row['dldate'])); ?></a>
                    </div>
                </div>


            <?php 
            }
        }else{ 
            ?>
            <p class="empty">Aucun document.</p>
            <?php
        }
}

function human_filesize($bytes, $decimals = 2) {
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

/* Return document info for embeded post */
function get_document_infos($document_id){
    require("connect_db.php");
    $DD = "SELECT * FROM documents WHERE id = '$document_id'"; 
    $result = $conn->query($DD);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $args = [
                'titre'=> $row["titre"],
                'format'=> $row["format"],
                'type'=> $row["type"],
                'year'=> $row["year"],
                'date'=> $row["dldate"]
            ];
        }
        return $args;
    }
}

function get_who_dowloaded($doc){
    require("connect_db.php");
    $DD = "SELECT DISTINCT(uname) FROM downloads LEFT JOIN documents on downloads.document_id = documents.id WHERE downloads.document_id = '$doc' ORDER BY date_dld DESC"; 
    $result = $conn->query($DD);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) { 
            ?>
            <div data-balloon="@<?= $row['uname']; ?>" data-balloon-pos="up" class="avatar-small avatar-<?= get_user_avatar($row['uname']); ?>-sm"></div>
            <?php
        }
    }
}

function get_dowloads_number($doc){
    require("connect_db.php");
    $DD = "SELECT DISTINCT(uname) FROM downloads WHERE document_id = '$doc' ORDER BY date_dld DESC"; 
    $result = $conn->query($DD);
    if ($result->num_rows > 0) {
        return ($result->num_rows);
    }else{
        return '0';
    }
}

/* Gets user avatar */
function get_user_avatar($uname){
    require("connect_db.php");
    $DD = "SELECT avatar FROM usr WHERE uname = '$uname'"; 
    $result = $conn->query($DD);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) { 
            return $row['avatar'];
        }
    }
}

function get_user_fullname($uname){
    require("connect_db.php");
    $DD = "SELECT name FROM usr WHERE uname = '$uname'"; 
    $result = $conn->query($DD);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) { 
            return $row['name'];
        }
    } else {
        return 'User Fullname';
    }
}

/* Gets subject name from codename */
function get_subject_name($codename){
    require("connect_db.php");
    $FindName = "SELECT name FROM subjects WHERE codename = '$codename'";
    $result = $conn->query($FindName);

    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $SubName = $row["name"];
        }
    } else {
        return 'Code matière inconnu.';
    }

    return $SubName;
}


/* ==========================================================================
    FAVORIS
/* ========================================================================== */

/* Add or remove favorite for user */
function add_favoris(){
    require("connect_db.php");
    $matiere = $_POST['matiere'];
    $user = $_POST['user'];

    $GET_favoris = "SELECT * FROM favoris WHERE subject = '$matiere' AND uname = '$user'"; 
    $result = $conn->query($GET_favoris);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
    //        echo 'Favoris';
        }
        $DELETE_favoris = "DELETE FROM favoris WHERE subject = '$matiere' AND uname = '$user'";
        $result = $conn->query($DELETE_favoris);
        if ($conn->query($DELETE_favoris) === TRUE) {
            ////header('500 Internal Server Error', true, 500);
            logs_history('Favoris Deleted', $matiere);
            echo 'Favoris deleted';
        }


    }else{
        $POST_favoris = "INSERT INTO favoris (uname, subject) VALUES ('$user','$matiere')";
        if ($conn->query($POST_favoris) === TRUE) {
            logs_history('Favoris Added', $matiere);
            echo json_encode('Favoris added');
        }
    } 
}

/* Checks if matiere is favorite by user and return the correspondant icon */
function favoris_check($user, $subject){
    require("connect_db.php");
        
    $GET_favoris = "SELECT * FROM favoris WHERE subject = '$subject' AND uname = '$user'"; 
    $result = $conn->query($GET_favoris);

    if ($result->num_rows > 0) {
        return json_encode('star');
    }else{
        ////header('500 Internal Server Error', true, 500);
        return json_encode('star_border');
    }
}

function have_favoris($user){
    require("connect_db.php");
        
    $GET_favoris = "SELECT * FROM favoris WHERE uname = '$user'"; 
    $result = $conn->query($GET_favoris);

    if ($result->num_rows > 0) {
        return true;
    }else{
        return false;
    }
}


/* ==========================================================================
    POPULARITY ALGORYTHM
/* ========================================================================== */

function popularity($codename){
    require("connect_db.php");

    $getPopularity = "SELECT * FROM subjects WHERE codename = '$codename'"; 
    $result = $conn->query($getPopularity);
    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            $popularity = $row['popularity'];
        }
    }

    $popularity = $popularity + 1;
    $popularitySet = "UPDATE subjects SET popularity = '$popularity' WHERE codename = '$codename'";
    if ($conn->query($popularitySet) === TRUE) {
    }
}


/* Checks if user already dwnoaded the given document */
function download_history($document_id, $user){
    require("connect_db.php");
    $FindName = "SELECT * FROM downloads WHERE uname = '$user' AND document_id = '$document_id'";
    $result = $conn->query($FindName);

    if ($result->num_rows > 0) { 
        return "Obtenir"; 
    } else { 
        return "Télécharger"; 
    }
}

/* ==========================================================================
    DOWNLOAD
/* ========================================================================== */

function download(){
    if(!isset($_SESSION)) session_start();
    $document_id = $_POST['document'];
    $user = $_SESSION['pseudo'];
    logs_history('Download', $document_id);

    include("connect_db.php");

    // DOCUMENT DOWNLOAD + 1 
    //--------------------------------------------------------------------------------------------------------//
    $GetDocumentDownloads = "SELECT downloads FROM documents WHERE id = '$document_id'";
    $result = $conn->query($GetDocumentDownloads);

    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $downloads_doc_cnt = $row["downloads"]; 
        }
    } else {
        echo 'Document not found.';
    }

    $downloads_doc_cnt = $downloads_doc_cnt + 1;

    $UpdateDocumentDownloads = "UPDATE documents SET downloads = '$downloads_doc_cnt' WHERE id = '$document_id'";

    if ($conn->query($UpdateDocumentDownloads) === TRUE) {
    }else {
        echo $sql . $conn->error;
    }

    // USER DOWNLOADS + 1
    //--------------------------------------------------------------------------------------------------------//
    $GetUserDownloads = "SELECT downloads FROM usr WHERE uname = '$user'";
    $result = $conn->query($GetUserDownloads);

    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $downloads_usr_cnt = $row["downloads"];
        }
        $downloads_usr_cnt = $downloads_usr_cnt + 1;
    } else {
        echo 'Username not found';
    }

    $UpdateDocumentDownloads = "UPDATE usr SET downloads = '$downloads_usr_cnt' WHERE uname = '$user'";

    if ($conn->query($UpdateDocumentDownloads) === TRUE) {
    } else {
        echo $sql . $conn->error;
    }

    // USER DOWNLOAD HISTORY UPDATE
    //--------------------------------------------------------------------------------------------------------//
    $today = new DateTime('now');
    $now = $today->format('Y-m-d H:i:s');

    $Insert_downloads_table = "INSERT INTO downloads (uname, document_id, date_dld)
        VALUES ('$user','$document_id','$now')";

    if ($conn->query($Insert_downloads_table) === TRUE) {
    }else{
        echo "History error";
    }
}

/* FORGOTTEN PASSWORD (reset from login) */
function password_reset(){
    include("connect_db.php");
    $email = $_POST['email'];

    $getkey = "SELECT cle, email, name FROM usr WHERE email = '$email'" ;
    $result = $conn->query($getkey); 
    if ( ($result->num_rows > 0) && ($email != null)) { 
        while($row = $result->fetch_assoc()) {
            $thekey = $row["cle"];
            $name = $row["name"];
        }
        /* Send email */
        mail_passwordReset($name, $email, $thekey);
        logs_history('Forget pass: Sent', $email);
        echo json_encode($email);
    }else{
        //header('500 Internal Server Error', true, 500);
        logs_history('Forget pass: Not found', $email);
        echo 'Adresse email inconnue.';
    }
}

/* Reset password from reset page */
function password_reset_new(){
    include("connect_db.php");
    $user = $_POST['user'];
    $salt = "Sguar€ë&•&çl0ud)";
    $password = $_POST['password'];
    $password_crypte = sha1(sha1($password).$salt);

    $UpdateDocumentDownloads = "UPDATE usr SET upass = '$password_crypte' WHERE uname = '$user'";

    if ($conn->query($UpdateDocumentDownloads) === TRUE) {
        logs_history('Password Reseted', $user);
    } else {
        //header('500 Internal Server Error', true, 500);
        echo $sql . $conn->error;
    }
}


/* ==========================================================================
    SEARCH
/* ========================================================================== */

function search(){
    include('connect_db.php');

    if(isset($_POST['keyword'])){
        $motcle = $_POST['keyword'];

        $SearchQuery = "SELECT * FROM subjects WHERE name like '%$motcle%' OR keyword = '$motcle' OR codename like '%$motcle%'";
        $result = $conn->query($SearchQuery);

        if ($result->num_rows > 0){ 
            while($row = $result->fetch_assoc()){
                $search[] = array(
                    "name" => $row['name'], 
                    "codename" => $row['codename'], 
                    "annee" => $row['annee']
                );
            }
            echo json_encode($search);

        }else{
            echo 'Aucun résultat pour "'.$motcle.'"';
        }

    }else{
        echo 'Erreur recherche.';
    }
}


/* ==========================================================================
    TIME AGO
/* ========================================================================== */

define('TIMEBEFORE_NOW',         'À l\'instant');
define('TIMEBEFORE_MINUTE',      'Il y a {num} minute' );
define('TIMEBEFORE_MINUTES',     'Il y a {num} minutes' );
define('TIMEBEFORE_HOUR',        'Il y a {num} heure' );
define('TIMEBEFORE_HOURS',       'Il y a {num} heures' );
define('TIMEBEFORE_YESTERDAY',   'Hier' );
define('TIMEBEFORE_DAY',         'Il y a {num} jour' );
define('TIMEBEFORE_DAYS',        'Il y a {num} jours' );
define('TIMEBEFORE_WEEK',        'Il y a {num} semaine' );
define('TIMEBEFORE_WEEKS',       'Il y a {num} semaines' );
define('TIMEBEFORE_MONTH',       'Il y a {num} mois' );
define('TIMEBEFORE_MONTHS',      'Il y a {num} mois' );
define('TIMEBEFORE_FORMAT',      '%e %b' );
define('TIMEBEFORE_FORMAT_YEAR', '%e %b, %Y' );

function time_ago( $time ) {

    $out    = ''; // what we will print out
    $now    = time(); // current time
    $diff   = $now - $time; // difference between the current and the provided dates

    if( $diff < 60 ) // it happened now
        return TIMEBEFORE_NOW;

    elseif( $diff < 3600 ) // it happened X minutes ago
        return str_replace( '{num}', ( $out = round( $diff / 60 ) ), $out == 1 ? TIMEBEFORE_MINUTE : TIMEBEFORE_MINUTES );

    elseif( $diff < 3600 * 24 ) // it happened X hours ago
        return str_replace( '{num}', ( $out = round( $diff / 3600 ) ), $out == 1 ? TIMEBEFORE_HOUR : TIMEBEFORE_HOURS );

    elseif( $diff < 3600 * 24 * 2 ) // it happened yesterday
        return TIMEBEFORE_YESTERDAY;

    elseif( $diff < 3600 * 24 * 7 )
        return str_replace( '{num}', round( $diff / ( 3600 * 24 ) ), TIMEBEFORE_DAYS );

    elseif( $diff < 3600 * 24 * 7 * 4 )
        return str_replace( '{num}', ( $out = round( $diff / ( 3600 * 24 * 7 ) ) ), $out == 1 ? TIMEBEFORE_WEEK : TIMEBEFORE_WEEKS );

    elseif( $diff < 3600 * 24 * 7 * 4 * 12 )
        return str_replace( '{num}', ( $out = round( $diff / ( 3600 * 24 * 7 * 4 ) ) ), $out == 1 ? TIMEBEFORE_MONTH : TIMEBEFORE_MONTHS );

    else // falling back on a usual date format as it happened later than yesterday
        return strftime( date( 'Y', $time ) == date( 'Y' ) ? TIMEBEFORE_FORMAT : TIMEBEFORE_FORMAT_YEAR, $time );
}

/* Loading message joke */
function loadingMessage(){
    $args = array (
        "1"  => "Blurring Reality Lines",
        "2" => "Caffeinating Student Body",
        "3"   => "Reticulating Splines",
        "4"   => "Securing Online Grades Database"
    );
    $rand = rand(1,4);
    echo $args[$rand].'...';
}


/* COMMENTS */
/*
// function displayComments(){
//     ?>
//     <div class="transcript">

//         <div class="comment-reply">
//             <form>
//                 <div class="avatar-comment avatar-A1-sm"></div>
//                 <input type="text" name="" placeholder="Commenter">
//             </form>
//         </div>
//         <div class="single-comment">
            
//         </div>

//     </div>
//     <?php}

// function post_comment(){}
// function delete_comment(){}
// function modify_comment(){}
// function is_my_comment(){}


/* ==========================================================================
    LIKES
/* ========================================================================== */

function get_likes($document_id){
    include("connect_db.php");
    $query = "SELECT * FROM likes WHERE document = '$document_id'" ;
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return ($result->num_rows);
    }else{
        return null;
    }
}

function is_liked($document_id, $user_id){
    require("connect_db.php");
        
    $query = "SELECT * FROM likes WHERE document = '$document_id' AND user = '$user_id'"; 
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return true;
    }else{
        ////header('500 Internal Server Error', true, 500);
        return false;
    }
}

function like(){
    require("connect_db.php");
    $document_id = $_POST['document'];
    $user_id = $_POST['user'];

    $QUERY = "SELECT * FROM likes WHERE document = '$document_id' AND user = '$user_id'"; 
    $result = $conn->query($QUERY);

    if ($result->num_rows > 0) {

        $DELETE = "DELETE FROM likes WHERE document = '$document_id' AND user = '$user_id'";
        $result = $conn->query($DELETE);

        if ($conn->query($DELETE) === TRUE) {
            ////header('500 Internal Server Error', true, 500);
        }

    }else{
        $ADD = "INSERT INTO likes (document, user) VALUES ('$document_id','$user_id')";
        if ($conn->query($ADD) === TRUE) {
            return true;
        }
    } 
}


function user_reached($date){
    require("connect_db.php");

    $today = new DateTime('now');
    $now = $today->format('Y-m-d H:i:s');
        
    $query = "SELECT * FROM usr WHERE lastLogin BETWEEN '$date' AND '$now'"; 
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return ($result->num_rows);
    }else{
        return '0';
    }
}

/* ==========================================================================
    ACCOUNT SEPTEMBER'S UPDATE
/* ========================================================================== */

function get_following_promo($current_promo){
    if( $current_promo == "L1"){ return "L2"; }
    if( $current_promo == "L2"){ return "L3"; }
    if( $current_promo == "L3"){ return "M1"; }
    if( $current_promo == "M1"){ return "M2"; }
    if( $current_promo == "M2"){ return "M2"; }
}

function maj(){
    $promo = $_POST['promo'];
    $color = $_POST['color'];
    $avatar = $_POST['avatar'];
    $user = $_POST['user'];

    require("connect_db.php");
    $query = "UPDATE usr SET promo = '$promo', color = '$color', avatar = '$avatar', groupe = NULL, EFREIusr = NULL, EFREIpass = NULL, EFREIcopie = NULL, alertDe = 0 WHERE uname = '$user'";

    if ($conn->query($query) === TRUE) {
        if(!isset($_SESSION)) session_start();
        $_SESSION['color'] = $color;
        $_SESSION['avatar'] = $avatar;
        $_SESSION['promo'] = $promo;
        $_SESSION['new'] = true;

        $retour['redirect'] = "/";
        echo json_encode($retour);
    } else {
        //header('500 Internal Server Error', true, 500);
    }
}

/* ==========================================================================
    TIMELINE
/* ========================================================================== */

include('parts/function-timeline.php');
include('parts/notifications-functions.php');


/* ==========================================================================
    GET SUBJECTS FROM YEAR
/* ========================================================================== */

function subject($year){
    require("connect_db.php");

    if(($year == "L1") || ($year == "L2") || ($year == "L3") || ($year == "M1") || ($year == "M2")){
    ?>
    <optgroup label="L1"> 
    <?php
       $getsubjects = "SELECT * FROM subjects WHERE annee = 'L1' ORDER BY name";
       $result = $conn->query($getsubjects);

       if ($result->num_rows > 0){
           while($row = $result->fetch_assoc()) {
               if($_GET["sub"] == $row["codename"]){ $sub = 'selected';}else{ $sub = '';}
               echo '<option ' . $sub . ' value="' . $row["codename"] . '">' . $row["name"] . '</option>';
           }
       } else {
           echo 'No results';
       }
    }
    ?>
    </optgroup>
    
    <?php
    if(($year == "L2") || ($year == "L3") || ($year == "M1") || ($year == "M2")){
    ?>
    <optgroup label="L2"> 
    <?php
        $getsubjects = "SELECT * FROM subjects WHERE annee = 'L2' ORDER BY name";
        $result = $conn->query($getsubjects);

        if ($result->num_rows > 0){
           while($row = $result->fetch_assoc()) {
               if($_GET["sub"] == $row["codename"]){ $sub = 'selected';}else{ $sub = '';}
               echo '<option ' . $sub . ' value="' . $row["codename"] . '">' . $row["name"] . '</option>';
           }
        } else {
           echo 'No results';
        }
    }
    ?>
    </optgroup>

    <?php
    if(($year == "L3") || ($year == "M1") || ($year == "M2")){
    ?>
    <optgroup label="L3"> 
    <?php              
        $getsubjects = "SELECT * FROM subjects WHERE annee = 'L3' ORDER BY name";
        $result = $conn->query($getsubjects);

        if ($result->num_rows > 0){
           while($row = $result->fetch_assoc()) {
               if($_GET["sub"] == $row["codename"]){ $sub = 'selected';}else{ $sub = '';}
               echo '<option ' . $sub . ' value="' . $row["codename"] . '">' . $row["name"] . '</option>';
           }
        } else {
           echo 'No results';
        }
    }
    ?> 
    </optgroup>
    
    <?php
    if(($year == "M1") || ($year == "M2")){
    ?>
    <optgroup label="M1"> 
    <?php              
        $getsubjects = "SELECT * FROM subjects WHERE annee = 'M1' ORDER BY name";
        $result = $conn->query($getsubjects);

        if ($result->num_rows > 0){
           while($row = $result->fetch_assoc()) {
               if($_GET["sub"] == $row["codename"]){ $sub = 'selected';}else{ $sub = '';}
               echo '<option ' . $sub . ' value="' . $row["codename"] . '">' . $row["name"] . '</option>';
           }
        } else {
           echo 'No results';
        }
    }
    ?> 
    </optgroup>
    <?php

    if(($year == "M2")){
    ?>
    <optgroup label="M2"> 
    <?php              
        $getsubjects = "SELECT * FROM subjects WHERE annee = 'M2' ORDER BY name";
        $result = $conn->query($getsubjects);

        if ($result->num_rows > 0){
           while($row = $result->fetch_assoc()) {
               if($_GET["sub"] == $row["codename"]){ $sub = 'selected';}else{ $sub = '';}
               echo '<option ' . $sub . ' value="' . $row["codename"] . '">' . $row["name"] . '</option>';
           }
        } else {
           echo 'No results';
        }
    }
    ?> 
    </optgroup>
    <?php
}


function deletePost(){
    require("connect_db.php");
    $post_id = $_POST['post-id'];

    // $DELETE = "DELETE FROM posts WHERE id = '$postid'";
    // $result = $conn->query($DELETE);

    // if ($conn->query($DELETE) === TRUE) {
    //     //header('500 Internal Server Error', true, 500);
    // }

    $update = "UPDATE posts SET display = '0' WHERE id = '$post_id'";

    if ($conn->query($update) === TRUE) {
    }else{
        //header('500 Internal Server Error', true, 500); 
    }
}

function deleteAccount(){
    require("connect_db.php");
    $account_ID = $_POST['accountID'];

    // $DELETE = "DELETE FROM posts WHERE id = '$postid'";
    // $result = $conn->query($DELETE);

    // if ($conn->query($DELETE) === TRUE) {
    //     //header('500 Internal Server Error', true, 500);
    // }

    $update = "UPDATE usr SET actif = '0', errormess = 'Votre compte est en cours de suppression' WHERE usr = '$account_ID'";

    if ($conn->query($update) === TRUE) {
    }else{
        //header('500 Internal Server Error', true, 500); 
    }
}

function checkPseudo(){
    require("connect_db.php");
    $pseudo = $_POST['pseudo'];

    $SELECT = "SELECT * FROM usr WHERE uname = '$pseudo'";
    $result = $conn->query($SELECT);

    if ($result->num_rows > 0){
        //header('500 Internal Server Error', true, 500); 
    }else{

    }
}

function checkEmail(){
    require("connect_db.php");
    $email = $_POST['email'];

    $SELECT = "SELECT * FROM usr WHERE email = '$email'";
    $result = $conn->query($SELECT);

    if ($result->num_rows > 0){
        //header('500 Internal Server Error', true, 500); 
    }else{

    }
}

function create_new_account(){
    $email = strtolower($_POST['email']);
    $password = $_POST['password'];
    $salt = "Sguar€ë&•&çl0ud)";
    $password_crypte = sha1(sha1($password).$salt);
    $nom = ucfirst($_POST['nom']);
    $prenom = ucfirst($_POST['prenom']);
    $initiale = substr("$prenom", 0, 1);
    $pseudo = strtolower($_POST['pseudo']);
    $promo = $_POST['options'];
    $color = $_POST['color'];
    $avatar = $_POST['avatar'];
    $now = new DateTime('now');
    $today = $now->format('Y-m-d H:i:s');
    $cle = md5(microtime(TRUE)*100000);

    require("connect_db.php");
    $CREATE_USER_ACCOUNT = "INSERT INTO usr (uname, upass, name, lastname, initiale, email, promo, dateinscription, cle, avatar, color) 
    VALUES ('$pseudo','$password_crypte', '$prenom', '$nom', '$initiale', '$email', '$promo', '$today', '$cle', '$avatar', '$color')";

    if ($conn->query($CREATE_USER_ACCOUNT) === TRUE) {
        confirmMail($prenom, $pseudo, $email, $cle);
        if(!isset($_SESSION)) session_start();
        $_SESSION['accountcreated'] = true;
        return true;
    }else{
        //header('500 Internal Server Error', true, 500);
        return false;
    }

}


// function get_mention_number(){
    // require('connect_db.php');
    // if(!isset($_SESSION)) session_start();
    // $pseudo = $_SESSION['pseudo'];
    // $lastlogin = $_SESSION['lastlogin'];
    // $today = new DateTime('now');
    // $now = $today->format('Y-m-d H:i:s');

    // $SELECT = "SELECT * FROM posts WHERE status LIKE '%@$pseudo%' AND display = '1' AND date < '$lastlogin'";
    // $result = $conn->query($SELECT);
    // if ($result->num_rows > 0){
    //     echo ($result->num_rows);
    // }else{
    //     header('204 Aucune information', true, 204);
    // }
// }

/* Get current browser used */
function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'Linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'Macintosh';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'Windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    }
    elseif(preg_match('/OPR/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}


function logs_history($action, $value)
{
    //User
    if(!isset($_SESSION)) session_start();
    $user_name = isset($_SESSION["pseudo"]) ? $_SESSION["pseudo"] : '';
    $user_year = isset($_SESSION["promo"]) ? $_SESSION["pseudo"] : '';

    //Admin
    if( is_vip() == 'true'){
        $admin_enabled = 'true';
    }else{
        $admin_enabled = 'false';
    }

    //Source
    $source = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    //
    //
    // GET LAST SQL STATEMENT ? or function value
    // 

    $today = new DateTime('now');
    $date = $today->format('Y-m-d H:i:s');
    
    include('connect_db.php');

    $sql_request = isset($sql_request) ? $sql_request : '';

    $CREATE_LOG = "INSERT INTO logs (date, action, value, user_name, user_year, admin_enabled, sql_request, source) 
    VALUES ('$date','$action', '$value', '$user_name', '$user_year', '$admin_enabled', '$sql_request', '$source' )";

    if ($conn->query($CREATE_LOG) === TRUE) {
        return true;
    }else{
        //header('500 Internal Server Error', true, 500);
        return false;
    }


}


// ADMIN
// 

function get_all_users(){

    require("connect_db.php");

    $SELECT = "SELECT * FROM usr";
    $result = $conn->query($SELECT);

    if ($result->num_rows > 0){
       while($row = $result->fetch_assoc()) {
           ?>
               <tr>
               <td>@<?= $row["uname"]; ?></td>
               <td><?= $row["name"]; ?></td>
               <td><?= $row["lastname"]; ?></td>
               <td><?= $row["email"]; ?></td>
               <td id="promo"><?= $row["promo"]; ?></td>
               <td><?= $row["lastLogin"]; ?></td>
               </tr>
           <?php
       }
    } else {
       echo 'No results';
    }
}


?>
<?php
session_start(); 
$uname = $_SESSION["pseudo"]; 
$year = $_SESSION["promo"];

include("connect_db.php");

$now = new DateTime('now');
$today = $now->format('Y-m-d H:i:s');

//$_FILES['icone']['name']     //Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
//$_FILES['icone']['type']     //Le type du fichier. Par exemple, cela peut être « image/png ».
//$_FILES['icone']['size']     //La taille du fichier en octets.
//$_FILES['icone']['tmp_name'] //L'adresse vers le fichier uploadé dans le répertoire temporaire.
//$_FILES['icone']['error']    //Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.

$maxsize = 200000000; //200Mo

if( !empty($_FILES['mon_fichier']['name']) ){

    if ($_FILES['mon_fichier']['error'] > 0) { 
        header('HTTP/1.1 500 Internal Server Error');
        $retour['erreur'] = "Erreur lors du transfert";

    } else {

        if ($_FILES['mon_fichier']['size'] > $maxsize) {
            header('HTTP/1.1 500 Internal Server Error');
            $retour['erreur'] = "Le fichier est trop volumineux (max. 200Mo)";
        
        } else {
            $nom_original = $_FILES['mon_fichier']['name'];
            $taille = $_FILES['mon_fichier']['size'];
            $extensions_valides = array( 'pdf', 'zip', 'doc', 'docx', 'xls', 'xlsx','ppt', 'pptx', 'sql', 'key', 'java', 'png', 'jpg', 'jpeg', 'rar' );

            //1. strrchr renvoie l'extension avec le point (« . »).
            //2. substr(chaine,1) ignore le premier caractère de chaine.
            //3. strtolower met l'extension en minuscules.
            $extension_upload = strtolower(  substr(  strrchr($_FILES['mon_fichier']['name'], '.')  ,1)  );
            $format = "{$extension_upload}";

            if ( in_array($extension_upload, $extensions_valides) ) {

                $retour['done'] = "Extension correcte";

                // Crée un identifiant unique
                $prefix = "SQC_";
                $nom = $prefix . md5(uniqid(rand(), true));
                $subject = $_POST["subject"];

                // SCRIPT GET ANNEE LX FROM SUBJECT CODENAME
                $getAnnee = "SELECT annee FROM subjects WHERE codename = '$subject'";
                $result = $conn->query($getAnnee);

                if ($result->num_rows > 0){
                    while($row = $result->fetch_assoc()) {
                        $yeard = $row["annee"];
                    }
                } else {
                    header('HTTP/1.1 500 Internal Server Error');
                    $retour['erreur'] = "Année non trouvée";
                }

                /////////////////////////////////////////////

                // Créer un dossier
                mkdir("Core/Library/{$yeard}/{$subject}/", 0777, true);

                $type = $_POST["type"];

                $directory = "Core/Library/{$yeard}/{$subject}/{$type}/{$nom}.{$extension_upload}";
                $resultat = move_uploaded_file($_FILES['mon_fichier']['tmp_name'], $directory);
                $nom1 = "../Core/Library/{$yeard}/{$subject}/{$type}/{$nom}.{$extension_upload}";

                if ($resultat) {
                    $retour['done'] = "Transfert effectué";

                    $id = $nom;
                    $titre = $_POST["titre"];
                    $dldate = $today;
                    $uploader = $_SESSION["pseudo"];
                    $uploaderdisplay = $_SESSION["pseudo"];
                    $address = $nom1;
                    
                    $annee = $_POST["annee"];
                    $long = strtotime($annee);
                    $year = date('Y', $long);

                    if(isset($_POST["corrige"])){
                        $corrige = 1;
                    }            
                    if(isset($_POST["prof"])){
                        $prof = $_POST["prof"];
                    }else{
                        $prof = "Unknown";
                    }
                    
                    $source = $_POST["source"];

                    $addfile = "INSERT INTO documents (id, titre, type, subject, dldate, uploader, uploaderdisplay, year, prof, address, format, corrige, copie, source, nomoriginal, taille) 
                    VALUES ('$id','$titre','$type','$subject','$dldate','$uploader','$uploaderdisplay','$year','$prof', '$address', '$format', '$corrige','$copie','$source', '$nom_original', '$taille')";

                    if ($conn->query($addfile) === TRUE) {
                        $promo = $_SESSION['promo'];
                        $status = addslashes($_POST['status']);
                        // Hashtag check
                        $status = detect_link($status);
                        $status = hashtag($status);
                        $status = mention($status);

                        create_post($today, $uploader, $promo, 'doc', $status, $nom, $subject);
                        
                        $retour['done'] = "Nouveau fichier ajouté";

                    } else {
                        header('HTTP/1.1 500 Internal Server Error');
                        $retour['erreur'] = "Error :" . $sql  . $conn->error;
                        unlink($nom1);
                    }        

                } else {
                    header('HTTP/1.1 500 Internal Server Error');
                    $retour['erreur'] = "Le dossier n\'existe pas";
                    unlink($nom1);
                }
            }else { 
                header('HTTP/1.1 500 Internal Server Error');
                $retour['erreur'] = 'Format [.' . $format . '] non supporté';
            }
        }
    }
}else{
    header('HTTP/1.1 500 Internal Server Error');
    $retour['erreur'] = "Aucun fichier sélectionné.";
    // $promo = $_SESSION['promo'];
    // $uploader = $_SESSION["pseudo"];
    // $status = $_POST['status'];
    // // Hashtag check
    // $status = detect_link($status);
    // $status = hashtag($status);
    // $status = mention($status);

    // create_post($today, $uploader, $promo, 'text', $status, 'null', 'null');
}
echo json_encode($retour);

function create_post($today, $uploader, $promo, $type, $status, $nom, $subject){
    include("connect_db.php");

    // Create post
    $FILE_POST = "INSERT INTO posts (date, user, promo, type, status, document_id, subject, display) VALUES ('$today', '$uploader', '$promo', '$type', '$status', '$nom', '$subject', '1')";
    if ($conn->query($FILE_POST) === TRUE) {
    }else{
        header('HTTP/1.1 500 Internal Server Error');
        $retour['erreur'] = 'Erreur sur le post.';
    }
}

/* Return formatted link */
function hashtag($text){
    // The Regular Expression filter
    $reg_exUrl = "/#([a-zA-Z0-9]+)?/";

    // The Text you want to filter for urls
    // $text = "The text you want to filter goes here. http://google.com";

    // Check if there is a url in the text
    if(preg_match($reg_exUrl, $text, $url)) {

           // make the urls hyper links
           return preg_replace($reg_exUrl, '<a class="hashtag" href="/hashtag/'.substr($url[0], 1).'">'.$url[0].'</a>', $text); //39

    } else {
           // if no urls in the text just return the text
           return $text;
    }
}

function detect_link($text){
    // The Regular Expression filter
    $reg_exUrl = "/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

    // The Text you want to filter for urls
    // $text = "The text you want to filter goes here. http://google.com";

    // Check if there is a url in the text
    if(preg_match($reg_exUrl, $text, $url)) {

           // make the urls hyper links
           return preg_replace($reg_exUrl, '<a target="parent" class="external-link" href="'.$url[0].'">'.$url[0].'</a>', $text); //52

    } else {
           // if no urls in the text just return the text
           return $text;
    }
}

function mention($text){
    // The Regular Expression filter
    $reg_exUrl = "/@([a-zA-Z0-9]+)?/";

    // The Text you want to filter for urls
    // $text = "The text you want to filter goes here. http://google.com";

    // Check if there is a url in the text
    if(preg_match($reg_exUrl, $text, $url)) {

           // make the urls hyper links
           return preg_replace($reg_exUrl, '<a class="mention" href="/profil/'.substr($url[0], 1).'">'.$url[0].'</a>', $text); //

    } else {
           // if no urls in the text just return the text
           return $text;
    }
}

?>
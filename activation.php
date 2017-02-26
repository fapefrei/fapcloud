<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Activation de votre compte</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body class="default-page">
    <div class="center-card">
    <?php
    include("connect_db.php");

    $login = $_GET['log'];
    $cle = $_GET['cle'];
    //echo $login, $cle;

    $sql = "SELECT cle, actif FROM usr WHERE uname = '$login'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $clebdd = $row['cle'];	// Récupération de la clé
            $actif = $row['actif']; // $actif contiendra alors 0 ou 1
        }
    } else {
        echo '<p class="error"><i class="material-icons">warning</i>Erreur ! Votre compte ne peut pas être activé.</p>';
        exit();
    }
    //$conn->close(); 

    if($actif == '1') // Si le compte est déjà actif on prévient
    {
        echo '<p class="done"><i class="material-icons">done_all</i>Votre compte est déjà activé !</p>';
        echo '<meta http-equiv="refresh" content="2;URL=/login">'; 
    }
    else // Si ce n'est pas le cas on passe aux comparaisons
    {
        if($cle == $clebdd) // On compare nos deux clés	
        {
            // Si elles correspondent on active le compte !	

            // La requête qui va passer notre champ actif de 0 à 1
            $ActivateAccount = "UPDATE usr SET actif = 1 WHERE uname ='$login'";
            $result2 = $conn->query($ActivateAccount);

            if ($conn->query($ActivateAccount) === TRUE) {
                echo '<p class="act done"><i class="material-icons">done</i>Votre compte a été activé !</p>';
                echo '<meta http-equiv="refresh" content="2;URL=/login">';
            } else {
                echo '<p class="error animated shake"><i class="material-icons">warning</i>Erreur SQL ! Votre compte ne peut être activé...</p>';
            }
        }else // Si les deux clés sont différentes on provoque une erreur...
        {
            echo '<p class="error animated shake"><i class="material-icons">warning</i>Erreur ! Votre compte ne peut pas être activé.</p>';
            echo '<meta http-equiv="refresh" content="2;URL=/">';
        }
    }
    $conn->close();

        ?>
        </div>
    </body>
</html>

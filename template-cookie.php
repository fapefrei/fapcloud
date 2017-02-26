<?php if(!isset($_SESSION)) session_start();
$password = $_SESSION['password'];
$_SESSION['password'] = null;
setcookie('AUTH', $_SESSION['pseudo'] . '-' . sha1($password) , time() + 3600 * 24 * 3);

?>
<!DOCTYPE html>
<html lang="fr">
<!-- IMPORTANT NOTE: This file is licensed only for use in providing the Square Cloud service,
or any part thereof, and is subject to the Square Cloud Terms and Conditions. You may not
port this file to another platform without the owner's written consent. --> 
<head>
    <meta charset="UTF-8">
    <title>Square Cloud | Cookies</title>
    <!--  CSS  -->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/theme.php">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<?php include_once('functions.php'); ?>
<?php redirect(); ?>
<body id="template-cookies">

<div class="center-texte">
    <h1><?php loadingMessage(); ?></h1>
</div>
<meta http-equiv="refresh" content="1;/">

</body>
</html>
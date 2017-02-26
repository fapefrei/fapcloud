<?php if(!isset($_SESSION)) session_start(); ?>
<?php
//Redirection si url rewriting mauvais
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(strpos($actual_link, 'php') == true){
    header("location: /hashtag/".$_GET['hashtag']); 
}
$hashtag = $_GET['hashtag'];
?>
<!DOCTYPE html>
<html lang="fr">
<!-- IMPORTANT NOTE: This file is licensed only for use in providing the Square Cloud service,
or any part thereof, and is subject to the Square Cloud Terms and Conditions. You may not
port this file to another platform without the owner's written consent. --> 

<head>
    <meta charset="UTF-8">
    <title>#<?= $hashtag; ?> | Square Cloud</title>
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
<?php include_once('functions.php'); ?>
<?php redirect(); ?>
<body id="template-hashtag">

    <?php get_navbar(); ?>

    <div id="content-wrap">
        <!-- TOP CONTENT -->
        <div class="top-content card hashtag-title theme-bcolor">
           <p>#<?= $hashtag; ?></p>
        </div>
        <!-- SIDE CONTENT -->
        <div class="side-content">
            <?php include('parts/tendances.php'); ?>
            <?php include('parts/side-footer.php'); ?>
        </div>
        <!-- CENTER CONTENT -->
        <div class="center-content">
            <div class="posts-list first-post">
                <?= hashtag($hashtag); ?>
            </div>
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
<?php
/* Fonction principale de la Timeline */
function hashtag($hashtag){
    require("connect_db.php");
    if(!isset($_SESSION)) session_start();

    $timeline = "SELECT * FROM posts WHERE ( status LIKE '%#$hashtag%') AND ( display = '1') ORDER BY date DESC"; 
    $result = $conn->query($timeline);

    $key = 0;
    $offset = 0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            // STATUS
            if ( $row['type'] == 'text' ){ ?>

            <div class="post post-upload">
                <div class="post-top">
                    <div class="avatar-post avatar-<?= get_user_avatar($row['user']); ?>-sm"></div>
                        <div class="texte">
                            <p class="title capitalize"><?= get_user_fullname($row['user']); ?> <?php if( $row['subject'] ){ ?> <span class="arrow">▶︎</span></p><a class="theme-fcolor" href="/single-matiere.php?subject=<?= $row['subject']; ?>"><?= get_subject_name($row['subject']); ?></a> <?php } ?><p data-time="<?= strtotime($row['date']); ?>" class="datetime"><?= time_ago(strtotime($row['date'])); ?></p>
                            <br/>
                            <p class="legende">@<?= $row['user']; ?> à publié un status</p>
                    </div>
                </div>
                <div class="post-content">
                    <p class="status"><?= $row['status']; ?></p>
                 </div>
                <div class="post-actions">
                    <ul class="actions-list">
                        <li data-balloon="J'aime" data-balloon-pos="up">
                            <span class="heart like <?php if(is_liked($row['id'], $_SESSION['pseudo']) == true){ echo 'liked';} ?>" data-document="<?= $row['id']; ?>"></span>
                            <p class="like-number"><?= get_likes($row['id']); ?></p>
                        </li>
                        <li data-balloon="Plus" data-balloon-pos="up" class="more"><i class="icon-noun-dots"></i></li>
                    </ul>
                    <div class="more-menu">
                        <ul class="actions-drowpdown-list">
                            <a href="/template-profil.php?user=<?= $row['user']; ?>"><li>Profil de @<?= $row['user']; ?></li></a>
                            <li>Signaler</li>
                            <?php if( $row['user'] == $_SESSION['pseudo']){ ?>
                            <hr>
                            <a data-post-id="<?= $row['id']; ?>" class="delete-post"><li>Supprimer le post</li></a>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

            <?php 
            // DOC
            } elseif ( $row['type'] == 'doc' ){ ?>

            <div class="post post-upload">
                <div class="post-top">
                    <div class="avatar-post avatar-<?= get_user_avatar($row['user']); ?>-sm"></div>
                        <div class="texte">
                            <p class="title capitalize"><?= get_user_fullname($row['user']); ?><span class="arrow">▶︎</span></p><a class="theme-fcolor" href="/single-matiere.php?subject=<?= $row['subject']; ?>"><?= get_subject_name($row['subject']); ?></a><p data-time="<?= strtotime($row['date']); ?>" class="datetime"><?= time_ago(strtotime($row['date'])); ?></p>
                            <br/>
                            <p class="legende">@<?= $row['user']; ?> à ajouté un document</p>
                        </div>
                    </div>
                    <div class="post-content">
                        <p class="status"><?= $row['status']; ?></p>
                        <a href="/single-document.php?document=<?= $row['document_id']; ?>">
                            <div class="embedded-doc"> 
                                <div class="icon"><i class="filefont-<?= get_document_infos($row['document_id'])['format']; ?>"></i></div>
                                <div class="texte">
                                    <p class="title"><?= get_document_infos($row['document_id'])['titre']; ?></p>
                                    <p class="description"><?= get_document_infos($row['document_id'])['type'].' de '.get_subject_name($row['subject']).'<br>'.get_document_infos($row['document_id'])['year'].' - '.( (get_document_infos($row['document_id'])['year']) + 1); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="post-actions">
                        <ul class="actions-list">
                            <li data-balloon="J'aime" data-balloon-pos="up">
                                <span class="heart like <?php if(is_liked($row['document_id'], $_SESSION['pseudo']) == true){ echo 'liked';} ?>" data-document="<?= $row['document_id']; ?>"></span>
                                <p class="like-number"><?= get_likes($row['document_id']); ?></p>
                            </li>
                            <li data-balloon="Plus" data-balloon-pos="up" class="more"><i class="icon-noun-dots"></i></li>
                        </ul>
                        <div class="more-menu">
                            <ul class="actions-drowpdown-list">
                                <li class="subject-link" id="open-link" data-link="http://www.squarecloud.fr/single-matiere.php?subject=<?= $row['subject']; ?>">Copier le lien de la matière</li>
                                <li class="document-link" id="open-link" data-link="http://www.squarecloud.fr/single-document.php?document=<?= $row['document_id']; ?>">Copier le lien du document</li>
                                <a href="/template-profil.php?user=<?= $row['user']; ?>"><li>Profil de @<?= $row['user']; ?></li></a>
                                <li>Signaler</li>
                                <?php if( $row['user'] == $_SESSION['pseudo']){ ?>
                                <hr>
                                <a data-post-id="<?= $row['id']; ?>" class="delete-post"><li>Supprimer le post</li></a>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
            </div>

            <?php
            // LINK
            } elseif ( $row['type'] == 'link' ){ ?>

            <div class="post post-upload">
                <div class="post-top">
                    <div class="avatar-post avatar-<?= get_user_avatar($row['user']); ?>-sm"></div>
                        <div class="texte">
                            <p class="title capitalize"><?= get_user_fullname($row['user']); ?><span class="arrow">▶︎</span></p><a class="theme-fcolor" href="/single-matiere.php?subject=<?= $row['subject']; ?>"><?= get_subject_name($row['subject']); ?></a><p data-time="<?= strtotime($row['date']); ?>" class="datetime"><?= time_ago(strtotime($row['date'])); ?></p>
                            <br/>
                            <p class="legende">@<?= $row['user']; ?> à publié un lien</p>
                        </div>
                    </div>
                    <div class="post-content">
                        <p class="status"><?= $row['status']; ?></p>
                        <a target="parent" href="<?= $row['link']; ?>">
                            <div class="embedded-doc"> 
                                <div class="icon"><i class="material-icons">link</i></div>
                                <div class="texte">
                                    <p class="title">...</p>
                                    <p class="description">...</p>
                                    <p class="address"><?= $row['link']; ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="post-actions">
                        <ul class="actions-list">
                            <li data-balloon="J'aime" data-balloon-pos="up">
                                <span class="heart like <?php if(is_liked($row['id'], $_SESSION['pseudo']) == true){ echo 'liked';} ?>" data-document="<?= $row['id']; ?>"></span>
                                <p class="like-number"><?= get_likes($row['id']); ?></p>
                            </li>
                            <li data-balloon="Plus" data-balloon-pos="up" class="more"><i class="icon-noun-dots"></i></li>
                        </ul>
                        <div class="more-menu">
                            <ul class="actions-drowpdown-list">
                                <li class="subject-link" id="open-link" data-link="http://www.squarecloud.fr/single-matiere.php?subject=<?= $row['subject']; ?>">Copier le lien de la matière</li>
                                <a href="/template-profil.php?user=<?= $row['user']; ?>"><li>Profil de @<?= $row['user']; ?></li></a>
                                <li>Signaler</li>
                                <?php if( $row['user'] == $_SESSION['pseudo']){ ?>
                                <hr>
                                <a data-post-id="<?= $row['id']; ?>" class="delete-post"><li>Supprimer le post</li></a>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
            </div>

            <?php
            }

            // // MISCELANEOUS POSTS
            // if( (($key % 4) == 1) ){
            //     // echo timeline_dl($_SESSION['promo'], $_SESSION['lastlogin'], $offset);
            //     $offset++;
            // }
            // $key++;
            // if( $key == 2 ){
            //     // echo est_tendance($_SESSION['promo']);
            // }
        }

    } else { 
    // EMPTY POST
    ?>
        <div class="post post-empty">
            <p class="title">Aucun post ne contient ce hashtag.</p>
        </div>
    <?php
    }
}
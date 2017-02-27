<?php
if(!isset($_SESSION)) session_start();

/* ==========================================================================
    FUNCTION PRINCIPALE TIMELINE | © Fap Cloud
/* ========================================================================== */

// if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ){

    include("../connect_db.php");

    include_once('../functions.php');

    // $promotion = "M1";
    // $offset = "0";
    $offset_alt = "0";
    // $lastlogin = "2016-12-01";
    
    // Get post values
    $promotion = $_POST['promotion'];
    $offset = $_POST['offset'];
    $lastlogin = $_POST['lastlogin']; 
    // echo $_POST['promotion'];
    
    // The Query
    $timeline = "SELECT * FROM posts WHERE (( promo = '$promotion') OR ( promo = '' )) AND ( display = '1' ) ORDER BY date DESC LIMIT 3 OFFSET $offset "; 
    $result = $conn->query($timeline);
    // echo $timeline;
    
    // Loops values
    $key = 0;
    $offset_alt = 0;

    // Posts found
    if ($result->num_rows > 0) {
        
        // Display loop
        while($row = $result->fetch_assoc()) {

         // STATUS
         if ( $row['type'] == 'text' ){ 
             ?>

                <div class="post post-upload" data-post-id="<?= $row['id']; ?>">
                 <div class="post-top">
                     <div class="avatar-post avatar-<?= get_user_avatar($row['user']); ?>-sm"></div>
                         <div class="texte">
                             <p class="title capitalize"><a href="/profil/<?= $row['user']; ?>"><?= get_user_fullname($row['user']); ?></a> <?php if( $row['subject'] ){ ?> <span class="arrow">▶︎</span></p><a class="theme-fcolor" href="/single-matiere.php?subject=<?= $row['subject']; ?>"><?= get_subject_name($row['subject']); ?></a> <?php } ?><p data-time="<?= strtotime($row['date']); ?>" class="datetime"><?= time_ago(strtotime($row['date'])); ?></p>
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
                             <li class="signaler">Signaler</li>
                             <?php if( $row['user'] == $_SESSION['pseudo']){ ?>
                             <hr>
                             <!-- <a href=""><li>Modifier le post</li></a> -->
                             <a data-post-id="<?= $row['id']; ?>" class="delete-post"><li>Supprimer le post</li></a>
                             <?php } ?>
                         </ul>
                     </div>
                 </div>
                </div>

                <?php 
                // DOC
                } elseif ( $row['type'] == 'doc' ){ ?>

                <div class="post post-upload" data-post-id="<?= $row['id']; ?>">
                 <div class="post-top">
                     <div class="avatar-post avatar-<?= get_user_avatar($row['user']); ?>-sm"></div>
                         <div class="texte">
                             <p class="title capitalize"><a href="/profil/<?= $row['user']; ?>"><?= get_user_fullname($row['user']); ?></a><span class="arrow">▶︎</span></p><a class="theme-fcolor" href="/single-matiere.php?subject=<?= $row['subject']; ?>"><?= get_subject_name($row['subject']); ?></a><p data-time="<?= strtotime($row['date']); ?>" class="datetime"><?= time_ago(strtotime($row['date'])); ?></p>
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
                         <?php if ($row['user'] == $_SESSION['pseudo']): ?>
                         <table class="success">
                             <tr>
                                 <td><p class="theme-fcolor"><?= user_reached(get_document_infos($row['document_id'])['date']); ?> people reached</p></td>
                             </tr>
                         </table>
                         <?php endif; ?>
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
                                 <li class="subject-link" id="open-link" data-link="http://www.fapcloud.fr/single-matiere.php?subject=<?= $row['subject']; ?>">Copier le lien de la matière</li>
                                 <li class="document-link" id="open-link" data-link="http://www.fapcloud.fr/single-document.php?document=<?= $row['document_id']; ?>">Copier le lien du document</li>
                                 <a href="/template-profil.php?user=<?= $row['user']; ?>"><li>Profil de @<?= $row['user']; ?></li></a>
                                 <li class="signaler">Signaler</li>
                                 <?php if( $row['user'] == $_SESSION['pseudo']){ ?>
                                 <hr>
                                 <!-- <a href=""><li>Modifier le post</li></a> -->
                                 <a data-post-id="<?= $row['id']; ?>" class="delete-post"><li>Supprimer le post</li></a>
                                 <?php } ?>
                             </ul>
                         </div>
                     </div>
                </div>

                <?php
                // LINK
                } elseif ( $row['type'] == 'link' ){ ?>

                <div class="post post-upload" data-post-id="<?= $row['id']; ?>">
                 <div class="post-top">
                     <div class="avatar-post avatar-<?= get_user_avatar($row['user']); ?>-sm"></div>
                         <div class="texte">
                             <p class="title capitalize"><a href="/profil/<?= $row['user']; ?>"><?= get_user_fullname($row['user']); ?></a><span class="arrow">▶︎</span></p><a class="theme-fcolor" href="/single-matiere.php?subject=<?= $row['subject']; ?>"><?= get_subject_name($row['subject']); ?></a><p data-time="<?= strtotime($row['date']); ?>" class="datetime"><?= time_ago(strtotime($row['date'])); ?></p>
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
                                 <li class="subject-link" id="open-link" data-link="http://www.fapcloud.fr/single-matiere.php?subject=<?= $row['subject']; ?>">Copier le lien de la matière</li>
                                 <a href="/template-profil.php?user=<?= $row['user']; ?>"><li>Profil de @<?= $row['user']; ?></li></a>
                                 <li class="signaler">Signaler</li>
                                 <?php if( $row['user'] == $_SESSION['pseudo']){ ?>
                                 <hr>
                                 <!-- <a href=""><li>Modifier le post</li></a> -->
                                 <a data-post-id="<?= $row['id']; ?>" class="delete-post"><li>Supprimer le post</li></a>
                                 <?php } ?>
                             </ul>
                         </div>
                     </div>
                </div>

                <?php
                }

                    // Miscelaneous Posts
                    if( (($key % 4) == 1) ){
                        echo timeline_dl($promotion, $lastlogin, $offset_alt);
                        $offset_alt++;
                    }
                    if( $key == 2 ){
                        echo est_tendance($promotion);
                    }
                    // Increment key
                    $key++;
        }

        
    // No posts found
    } else { 

        header('HTTP/1.1 500 Internal Server Error');
    ?>
<!--         <div class="post post-empty">
            <p class="title">Il ne se passe pas grand chose en ce moment.</p>
            <p>Essayez de télécharger ou d'ajouter un document.</p>
            <img id="sad" src="../images/layout/facebook-sad.png">
        </div> -->

        <div class="post post-empty">
            <p class="title" style="font-size: 18px;">Retrouvez tous les autres documents classés par matière.</p>
            <p>Commencez par rechercher une matière depuis la barre de recherche.</p>
            <img id="sad" src="../images/layout/facebook-happy.png">
        </div>
    <?php
    }

// }else{
//      die('Get Ajaxed !');
// } // END ONLY AJAX


/* ==========================================================================
    FUNCTIONS SECONDAIRES TIMELINE | © Fap Cloud
/* ========================================================================== */


function timeline_dl($promo, $lastlogin, $offset){
    include("../connect_db.php");
    $timeline = "SELECT * FROM downloads LEFT JOIN documents on downloads.document_id = documents.id LEFT JOIN subjects on documents.subject = subjects.codename WHERE annee = '$promo' GROUP BY document_id ORDER BY date_dld DESC LIMIT 3 OFFSET $offset"; 
    $result = $conn->query($timeline);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) { 
            if(get_dowloads_number($row['id']) >= 2){
            ?>
                <div class="post post-count">
                    <p class="caption"><span class="theme-fcolor"><?= get_dowloads_number($row['id']); ?> personnes</span> ont récement téléchargé ce document.</p>
                    <a href="/single-document.php?document=<?= $row['id']; ?>">
                        <div class="embedded-doc"> 
                            <div class="icon"><i class="filefont-<?= $row['format']; ?>"></i> </div>
                                <div class="texte">
                                    <p class="title"><?= $row['titre']; ?></p>
                                    <p class="description"><?= $row['type'].' de '.get_subject_name($row['subject']).'<br>'.$row['year'].' - '.($row['year'] + 1); ?></p>
                            </div>
                        </div>
                    </a>
                    <table>
                            <tr>
                                    <td><p>Téléchargements</p><p class="theme-fcolor"><?= get_dowloads_number($row['id']); ?></p></td>
                                    <td>
                                    <?php get_who_dowloaded($row['id']); ?>
                                    </td>
                            </tr>
                    </table>
                </div>
        <?php }
            }
    }else{
        // echo 'Aucun résultat download';
    }
}

function est_tendance($promo){
    include("../connect_db.php");
    $timeline = "SELECT * FROM subjects WHERE annee = '$promo' ORDER BY popularity DESC LIMIT 1"; 
    $result = $conn->query($timeline);

    if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) { ?>
                <div class="post post-trend">
                        <p class="caption"><i class="material-icons">whatshot</i>#<?= $row['name']; ?> est à la une.</p>
                        <div class="matieres-list">
                            <a href="/single-matiere.php?subject=<?= $row["codename"]; ?>" class="matiere">
                                    <div class="icon theme-bcolor"><i class="material-icons"><?= $row["icon"]; ?></i></div>
                                    <p><?= $row["name"]; ?></p>
                            </a>
                        </div>
                    </div>
            <?php }
    }else{
        // echo 'Aucune tendance';
    }
}

?>
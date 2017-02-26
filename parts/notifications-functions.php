<?php 

// function get_mentions($pseudo){
//     require('connect_db.php');
//     $SELECT = "SELECT * FROM posts WHERE status LIKE '%@$pseudo%' ORDER BY date DESC";
//     $result = $conn->query($SELECT);



/* Fonction principale de la Timeline */
function notifications_posts($pseudo){
    require("connect_db.php");
    session_start();

    $timeline = "SELECT * FROM posts WHERE status LIKE '%@$pseudo%' AND display = '1' ORDER BY date DESC"; 
    $result = $conn->query($timeline);

    $key = 0;
    $offset = 0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            ?><p>Mentionné par @<?= $row['user']; ?></p>
            <?php
            // STATUS
            if ( $row['type'] == 'text' ){ ?>

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
                            <li>Signaler</li>
                            <?php if( $row['user'] == $_SESSION['pseudo']){ ?>
                            <hr>
                            <!-- <a href=""><li>Modifier le post</li></a> -->
                            <a data-post-id="<?= $row['id']; ?>" id="delete-post"><li>Supprimer le post</li></a>
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
                                <li class="subject-link" id="open-link" data-link="http://www.squarecloud.fr/single-matiere.php?subject=<?= $row['subject']; ?>">Copier le lien de la matière</li>
                                <li class="document-link" id="open-link" data-link="http://www.squarecloud.fr/single-document.php?document=<?= $row['document_id']; ?>">Copier le lien du document</li>
                                <a href="/template-profil.php?user=<?= $row['user']; ?>"><li>Profil de @<?= $row['user']; ?></li></a>
                                <li>Signaler</li>
                                <?php if( $row['user'] == $_SESSION['pseudo']){ ?>
                                <hr>
                                <!-- <a href=""><li>Modifier le post</li></a> -->
                                <a data-post-id="<?= $row['id']; ?>" id="delete-post"><li>Supprimer le post</li></a>
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
                                <li class="subject-link" id="open-link" data-link="http://www.squarecloud.fr/single-matiere.php?subject=<?= $row['subject']; ?>">Copier le lien de la matière</li>
                                <a href="/template-profil.php?user=<?= $row['user']; ?>"><li>Profil de @<?= $row['user']; ?></li></a>
                                <li>Signaler</li>
                                <?php if( $row['user'] == $_SESSION['pseudo']){ ?>
                                <hr>
                                <!-- <a href=""><li>Modifier le post</li></a> -->
                                <a data-post-id="<?= $row['id']; ?>" id="delete-post"><li>Supprimer le post</li></a>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
            </div>

            <?php
            }
        }

    } 
    // EMPTY POST
}
?>
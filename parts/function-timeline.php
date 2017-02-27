<?php

/* User's download history */
function upload_history($user){
        require("connect_db.php");

        $timeline = "SELECT * FROM documents LEFT JOIN subjects on documents.subject = subjects.codename WHERE uploaderdisplay = '$user' ORDER BY dldate DESC"; 
        $result = $conn->query($timeline);

        $key = 0;
        $offset = 0;
        if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) { 
                        $key ++;
                        ?>
                     <div class="post post-upload">
                             <div class="post-top">
                                     <div class="avatar-post avatar-<?= get_user_avatar($row['uploaderdisplay']); ?>-sm"></div>
                                     <div class="texte">
                                             <p class="title capitalize"><?= get_user_fullname($row['uploaderdisplay']); ?><span class="arrow">▶︎</span></p><a class="theme-fcolor" href="/single-matiere.php?subject=<?= $row['subject']; ?>"><?= get_subject_name($row['subject']); ?></a><p data-time="<?= strtotime($row['dldate']); ?>" class="datetime"><?= time_ago(strtotime($row['dldate'])); ?></p>
                                             <br/>
                                             <p class="legende">@<?= $row['uploaderdisplay']; ?> à ajouté un document</p>
                                     </div>
                             </div>
                             <div class="post-content">
                                     <p class="status"></p>
                                     <a href="/single-document.php?document=<?= $row['id']; ?>">
                                             <div class="embedded-doc"> 
                                                     <div class="icon"><i class="filefont-<?= $row['format']; ?>"></i> </div>
                                                     <div class="texte">
                                                            <p class="title"><?= $row['titre']; ?></p>
                                                            <p class="description"><?= $row['type'].' de '.get_subject_name($row['subject']).'<br>'.$row['year'].' - '.($row['year'] + 1); ?></p>
                                                     </div>
                                             </div>
                                     </a>
                                    <?php if ($row['uploaderdisplay'] == $_SESSION['pseudo']): ?>
                                    <table class="success">
                                            <tr>
                                                <td><p class="theme-fcolor"><?= user_reached($row['dldate']); ?> people reached</p></td>
                                            </tr>
                                    </table>
                                    <?php endif; ?>
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
                                                 <li class="document-link" id="open-link" data-link="http://www.fapcloud.fr/single-document.php?document=<?= $row['id']; ?>">Copier le lien du document</li>
                                                 <a href="/template-profil.php?user=<?= $row['uploaderdisplay']; ?>"><li>Profil de l'utilisateur</li></a>
                                                 <li>Signaler</li>
                                             </ul>
                                         </div>
                                     </div>
                     </div>

                <?php }
        }else{ ?>
        <div class="post post-empty">
                <p class="title">Aucun document ajouté.</p>
        </div>
        <?php }
}

/* User's LIKE history */ 
function like_history($user){
        require("connect_db.php");

        $timeline = "SELECT * FROM posts JOIN documents WHERE user IN ( SELECT user FROM likes WHERE user = '$user') GROUP BY posts.id ORDER BY date DESC "; 
        $result = $conn->query($timeline);

        if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) { 
                        ?>
                     <div class="post post-upload">
                             <div class="post-top">
                                     <div class="avatar-post avatar-<?= get_user_avatar($row['uploaderdisplay']); ?>-sm"></div>
                                     <div class="texte">
                                             <p class="title capitalize"><?= get_user_fullname($row['uploaderdisplay']); ?><span class="arrow">▶︎</span></p><a class="theme-fcolor" href="/single-matiere.php?subject=<?= $row['subject']; ?>"><?= get_subject_name($row['subject']); ?></a><p data-time="<?= strtotime($row['dldate']); ?>" class="datetime"><?= time_ago(strtotime($row['dldate'])); ?></p>
                                             <br/>
                                             <p class="legende">@<?= $row['uploaderdisplay']; ?> à ajouté un document</p>
                                     </div>
                             </div>
                             <div class="post-content">
                                     <p class="status"></p>
                                     <a href="/single-document.php?document=<?= $row['document_id']; ?>">
                                             <div class="embedded-doc"> 
                                                     <div class="icon"><i class="filefont-<?= $row['format']; ?>"></i> </div>
                                                     <div class="texte">
                                                            <p class="title"><?= $row['titre']; ?></p>
                                                            <p class="description"><?= $row['type'].' de '.get_subject_name($row['subject']).'<br>'.$row['year'].' - '.($row['year'] + 1); ?></p>
                                                     </div>
                                             </div>
                                     </a>
                                <table class="success">
                                        <tr>
                                                <td><p class="theme-fcolor"><?= user_reached($row['dldate']); ?> people reached</p></td>
                                        </tr>
                                </table>
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
                                                 <li class="document-link" id="open-link" data-link="http://www.fapcloud.fr/single-document.php?document=<?= $row['id']; ?>">Copier le lien du document</li>
                                                 <a href="/template-profil.php?user=<?= $row['uploaderdisplay']; ?>"><li>Profil de l'utilisateur</li></a>
                                                 <li>Signaler</li>
                                             </ul>
                                         </div>
                                     </div>
                     </div>

                <?php }
        }else{ ?>
        <div class="post post-empty">
                <p class="title">Aucun j'aime.</p>
        </div>
        <?php }
}


    


?>
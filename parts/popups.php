 <!-- POPUPS TEMPLATE -->
 
 <!-- Aide Favoris -->
<div id="action-view-test" class="action-view-container">
    <div class="action-view">
        <div class="navbar">
            <p class="title">Ajouter des Favoris</p>
            <!-- <a id="close" class="button">Annuler</a> -->
            <a id="close" class="button">OK</a>
        </div>
        <div class="action-view-content"></div>
    </div>
</div>

<!-- Ajout tendance -->
<div id="action-view-trend" class="action-view-container">
    <div class="action-view">
        <div class="navbar">
            <p class="title">Ajouter une tendance sponsorisée</p>
            <a id="close" class="button">Annuler</a>
            <!-- <a id="valide" class="button">Ajouter</a> -->
        </div>
        <div class="action-view-content">
        <p class="caption">Ajoutez une tendance sponsorisée,<br/> elle sera affichée dans la section "tendances" pour toutes les promotions pendant 1 semaine.</p>
        <form action="" method="post">
            <input class="input" type="text" name="title" placeholder="Titre de la tendance">
            <input class="input" type="text" name="link" placeholder="Lien web">
            <div class="checkbox-container">
                <input type="checkbox" id="L1" name="L1">
                <label for="L1">L1</label>
            </div>
            <input class="submit" type="submit" value="Ajouter la tendance">
        </form>

            <div class="tendances-card" style="text-align: left; margin-left: 35%;">
                <ul>
                    <li>
                        <a href="" >
                            <p class="trend">SEPEFREI recrute !</p>
                            <p class="description promoted">Sponsorisé par <?= ucfirst($_SESSION['prenom']); ?></p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Change promotion -->
<div id="modal-changePromo" class="modal-container">
    <div class="modal">
        <div class="text-container">
            <p class="title">Sélectionnez une promotion</p>
            <form action="/functions.php" method="post">
                <ul>
                    <li class="theme-fcolor" data-promo="L1">L1</li>
                    <li class="theme-fcolor" data-promo="L2">L2</li>
                    <li class="theme-fcolor" data-promo="L3">L3</li>
                    <li class="theme-fcolor" data-promo="M1">M1</li>
                    <li class="theme-fcolor" data-promo="M2">M2</li>
                </ul>
            </form>
        </div>
        <div class="modal-buttons">
            <a class="" id="close" href="#" title="">Annuler</a>
        </div>
    </div>
</div>

<!-- SYSTEM STATUS -->
<div id="modal-system-status" class="modal-container">
    <div class="modal">
        <div class="text-container">
            <p class="title">System status</p>
            <p class="explications">All Systems Operational. </p>
            <p class="explications" style="font-family: monospace;">Refreshed at <?= date('Y-m-d H:i:s'); ?>.</p>
            <p class="explications" style="font-family: monospace;">Last incident : Never.</p>
            <!-- <p class="explications" style="font-family: monospace;">Warning : SCOS => Check adaptative link function.</p> -->
            <!-- <p class="explications" style="font-family: monospace;">Warning : MONGODB: Not on main site.</p> -->
        </div>
        <div class="modal-buttons">
            <a class="" id="close" title="">Okay</a>
        </div>
    </div>
</div>

<!-- [DEV] -->
 <div id="action-view-vardump" class="action-view-container">
     <div class="action-view">
         <div class="navbar">
             <p class="title">Console de développement</p>
             <a id="close" class="button">OK</a>
         </div>
        <div class="action-view-content">
            <p>SESSION</p>
            <?= var_dump($_SESSION); ?>
            <br>
            <br>
            <p>COOKIES</p>
            <?= var_dump($_COOKIE); ?>
         </div>
     </div>
 </div>

<!-- FEEDBACK -->
<div id="action-view-feedback" class="action-view-container">
    <div class="action-view">
        <div class="navbar">
            <p class="title">Feedback</p>
            <a id="close" class="button">Annuler</a>
            <a id="valide" class="button">OK</a>
        </div>
        <div class="action-view-content">
            <p class="explications">Donnez votre avis sur Fap Cloud 3.0.</p>
            <form method="post" action="/">
                <textarea class="input" name="text" placeholder=""></textarea>
            </form>
        </div>
    </div>
</div>

<!-- SIGNALER UN PROBLEME -->
<div id="action-view-signaler-probleme" class="action-view-container">
    <div class="action-view">
        <div class="navbar">
            <p class="title">Signaler un problème</p>
            <a id="close" class="button">Annuler</a>
        </div>
        <div class="action-view-content">
        <p class="explications">Si quelque chose ne fonctionne pas sur Fap Cloud, utilisez le formulaire ci-dessous pour nous en informer.</p>
            <form id="form-signaler" class="form" method="post" action="/">
                <div class="select">
                    <select required class="input" name="type">
                        <option value="problème">Signaler un problème</option>
                        <option value="matiere_manquante">Signaler une matière manquante</option>
                        <option value="abus">Signaler un abus</option>
                        <option value="affichage">Signaler un problème d'affichage</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
                <?php 
                    $ua = getBrowser();
                    $yourbrowser = $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'] . " reports: <br/>" . $ua['userAgent'];
                ?>
                <textarea required class="input" name="text" placeholder="Describe your problem"></textarea>
                <input type="hidden" name="page" value="<?= basename($_SERVER['PHP_SELF']); ?>">
                <input type="hidden" name="browser" value="<?= print_r($yourbrowser); ; ?>">
                <input type="hidden" name="date" value="<?= date('Y-m-d H:i:s'); ?>">
                <input type="hidden" name="user" value="<?= $_SESSION["pseudo"]; ?>">
                <input class="submit" type="submit" value="Signaler">
            </form>
        </div>
    </div>
</div>

 <!-- Lien document -->
 <div id="modal-link-document" class="modal-container">
     <div class="modal">
         <div class="text-container">
            <p class="title">Lien du document</p>
            <p class="explications">L'URL de ce document se trouve ci-dessous. Copiez-la pour la partager facilement avec vos amis.</p>
            <input autofocus class="input" type="text" value="">
         </div>
         <div class="modal-buttons">
             <a class="" id="close" title="">Fermer</a>
         </div>
     </div>
 </div>

 <!-- Lien matière -->
 <div id="modal-link-subject" class="modal-container">
     <div class="modal">
         <div class="text-container">
            <p class="title">Lien de la matière</p>
            <p class="explications">L'URL de la matière se trouve ci-dessous. Copiez-la pour la partager facilement avec vos amis.</p>
            <input autofocus class="input" type="text" value="">
         </div>
         <div class="modal-buttons">
             <a class="" id="close" title="">Fermer</a>
         </div>
     </div>
 </div>

 <!-- MODAL DELETE POST -->
 <div id="modal-delete-post" class="modal-container" data-post-id="">
     <div class="modal">
         <div class="text-container">
            <p class="title">Supprimer le post</p>
            <p class="explications">Êtes-vous sûr de vouloir supprimer ce post ?<br>Cela ne supprimera pas le document inclus dans celui-ci.</p>
         </div>
         <div class="modal-buttons">
             <a class="two" id="close" title="">Annuler</a>
             <a class="two" id="valide-delete-post" title="" style="color: red;">Supprimer</a>
         </div>
     </div>
 </div>



<!-- Upload -->
<div id="upload-view" class="upload-container">
    <div class="upload-view">
        <div class="navbar">
            <p class="title">Écrire un post</p>
            <a id="close" class="button"><i class="material-icons">close</i></a>
        </div>
        <div class="upload-content">
            <div class="upload-center-content">
                <form id="form-file-upload" action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="upload-content-header">
                        <textarea autofocus id="post-text" name="status" maxlength="160" placeholder="Dites quelque chose à propos de ceci..."></textarea>
                        <!-- DOC -->
                        <div class="upload-type-file">
                            <p class="subtitle">Ajoutez un document</p>
                            <!-- FILE -->
                            <input required id="filer_input" name="mon_fichier" type="file">
                            <hr>
                            <!-- TITRE -->
                            <input required class="input" type="text" name="titre" placeholder="Titre du document">
                            <!-- SUBJECT -->
                            <div class="select">
                            <select required class="input" name="subject">
                                <option selected disabled>Matière</option>
                                <?php subject($_SESSION['promo']); ?>
                            </select>
                            </div>
                            <!-- TYPE -->
                            <div class="select">
                            <select required class="input" name="type">
                                <option selected disabled>Type de document</option>
                                <option value="Cours">Cours</option>
                                <option value="TD">TD</option>
                                <option value="TP">TP</option>
                                <option value="CE">CE</option>
                                <option value="DE">DE</option>
                            </select>
                            </div>
                            <!-- ANNEE -->
                            <div required class="select">
                            <select class="input" name="annee">
                                <option selected value="2016">2016-2017 (Cette année)</option>
                                <option value="2015">2015-2016</option>
                                <option value="2014">2014-2015</option>
                                <option value="2013">2013-2014</option>
                                <option value="2012">2012-2013</option>
                                <option value="2011">2011-2012</option>
                            </select>
                            </div>
                            <!-- SOURCE -->
                            <input class="input" type="text" name="source" placeholder="Source du document">
                        </div>
                        <!-- LINK -->
                        <div class="upload-type-link">
                            <p class="subtitle">Ajouter un lien</p>
                            <input type="text" name="">
                        </div>
                        <!-- TEXT -->
                        <div class="upload-type-text">
                            <p class="subtitle">Choisissez la matière dans laquelle publier votre post.</p>
                            <div class="select">
                            <select class="select-input">
                                <option selected disabled>Matière</option>
                                <?php subject($_SESSION['promo']); ?>
                            </select>
                            </div>
                        </div>
                        <!-- Barre de chargement -->
                        <div class="bar"></div>
                    </div>
                    <div class="upload-content-inner">
                        <div class="btn-upload-container">
                            <!-- <div id="upload-choose-file" data-balloon="Ajouter un document" data-balloon-pos="up" class="btn">Document</div> -->
                            <!-- <div id="upload-choose-link" data-balloon="Ajouter un lien" data-balloon-pos="up" class="btn">Lien</div> -->
                        </div>
                        <div class="loader" style="display: none; padding-top: 5px; float: left;"><img src="images/layout/loader-alt.gif"></div>
                        <p class="total-text-count">160</p>
                        <input type="submit" value="Publier" class="add-button">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MESSAGE -->
<div class="message">
    <p></p>
</div>


<!-- /Template popups -->
<!-- Navigation Bar -->
<div id="navigation-bar">
    <div class="navigation-content">
        <nav>
            <ul>
                <li id="nav-home">
                    <a href="/"><i class="icon-noun-home"></i><p>Accueil</p></a>
                </li>
                <li id="nav-notifications" data-notification="">
                    <a href="/notifications"><i class="icon-noun-notification"></i><p>Notifications</p></a>
                </li>
            </ul>
        </nav>

        <div id="logo"><a href="/template-homepage.php"><span class="big-logo icon-noun-logo-sc"></span><span class="small-logo icon-noun-fin-de-liste"></span></a></div>

        <div class="bar-right">
            <?php include('parts/search.php'); ?>

            <div class="menus">
                <div class="user-menu" data-user="<?= $_SESSION['pseudo']; ?>">
                    <p><?= $_SESSION['prenom']; ?></p>
                    <div class="avatar-small avatar-<?= $_SESSION['avatar']; ?>-sm"></div>
                    <i class="material-icons">keyboard_arrow_down</i>
                </div>
                <div class="user-dropdown">
                    <a href="/profil/<?= $_SESSION["pseudo"]; ?>">
                        <p class="theme-fcolor">@<?= $_SESSION['pseudo']; ?></p>
                        <p>Voir le profil</p>
                    </a>
                    <a href="/settings/<?= $_SESSION["pseudo"]; ?>"><i class="material-icons">settings</i>Paramètres</a>
                    <!-- <a href=""><i class="material-icons">create</i>Éditeur</a> -->
                    <a target="parent" href="https://digicampus.groupe-efrei.fr/"><i class="material-icons">aspect_ratio</i>Copies scannées</a>
                    <a id="logout" href=""><i class="material-icons">directions_run</i>Se déconnecter</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Navigation bar -->
<!-- Template favoris -->
<?php if(have_favoris($_SESSION['pseudo'])){ ?>
<div class="card favoris-card">
    <div class="card-header">
        <p class="title">Favoris</p>
        <!-- <span class="dot">•</span> -->
        <!-- <p class="link theme-fcolor" id="test">Aide</p> -->
    </div>
    <div class="matieres-list">

    <?php getFavoris($_SESSION['pseudo']); ?>

    </div>
</div>
<?php } ?>
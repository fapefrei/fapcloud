<!-- Template tendances -->
<div class="card tendances-card">
    <div class="card-header">
        <p class="title">Tendances</p>
        <?php if(is_vip()): ?>
            <span class="dot">•</span>
            <p class="link theme-fcolor" id="trend">Ajouter une tendance</p>
        <?php endif; ?>
    </div>
    <ul>
        <?php get_promoted_trends($_SESSION['promo']); ?>

        <?php get_the_most_popular_subject($_SESSION['promo']); ?>
        
        <?php get_the_most_popular_document($_SESSION['promo']); ?>
        
        <?php get_the_most_popular_hashtags($_SESSION['promo']); ?>
<!--         <li>
            <a target="_blank" href="http://siel.fapcloud.fr?year=<?= strtolower($_SESSION['promo']); ?>" >
                <p class="trend theme-fcolor">Prochains DE</p>
                <p class="description linked">Afficher sur le SIEL</p>
            </a>
        </li> -->
    </ul>
</div>

<div class="card">
    <div class="card-header">
        <p class="title">Current situation</p>
    </div>
    <?php
        if($promo == 'L1'){ $current = 1;}
        if($promo == 'L2'){ $current = 2;}
        if($promo == 'L3'){ $current = 3;}
        if($promo == 'M1'){ $current = 4;}
        if($promo == 'M2'){ $current = 5;}
    ?>
    <div class="situation-container">
        <div class="<?php if($current >= 1){ echo 'done theme-bcolor';} ?> year">L1</div>
        <div class="<?php if($current >= 2){ echo 'done theme-bcolor';} ?> year-link"></div>
        <div class="<?php if($current >= 2){ echo 'done theme-bcolor';} ?> year">L2</div>
        <div class="<?php if($current > 2){ echo 'done theme-bcolor';} ?> year-link"></div>
        <div class="<?php if($current >= 3){ echo 'done theme-bcolor';} ?> year">L3</div>
        <div class="<?php if($current > 3){ echo 'done theme-bcolor';} ?> year-link"></div>
        <div class="<?php if($current > 3){ echo 'done theme-bcolor';} ?> year">M1</div>
        <div class="<?php if($current > 4){ echo 'done theme-bcolor';} ?> year-link"></div>
        <div class="<?php if($current >= 5){ echo 'done theme-bcolor';} ?> year">M2</div>
    </div>
</div>
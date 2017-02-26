<?php header("Content-type: text/css; charset: UTF-8");
session_start();
$color = $_SESSION["color"];

?>



/* Color for font and background */
.theme-fcolor{
    color: #<?= $color; ?>!important;
}

.theme-bcolor{
    background-color: #<?= $color; ?>!important;
}

/* Hashtag */
.hashtag{
    color: #<?= $color; ?>!important;
    font-weight: 500;
}

.hashtag:hover{
    text-decoration: underline;
}

/* External link*/
.external-link{
    color: #<?= $color; ?>!important; 
    font-weight: 500;
}

.external-link:hover{
    text-decoration: underline;
}

/* Mention */
/* External link*/
.mention{
    color: #<?= $color; ?>!important;
    font-weight: 500; 
}

.mention:hover{
    text-decoration: underline;
}


/* Navigation bar */
nav ul li a:hover{
    color:  #<?= $color; ?>!important;
    border-bottom-color:  #<?= $color; ?>!important;
}
nav ul li .current{
    border-bottom-color:  #<?= $color; ?>!important;
}

/* User dropdown */
.user-dropdown a:hover{
    background-color: #<?= $color; ?>!important;
}

/* Inputs */

.input:focus{
    border: 2px solid #<?= $color; ?>!important;
}

/* Button */
.download-button{
    border: 1px solid #<?= $color; ?>!important;
    color: #<?= $color; ?>!important;
}
.download-button:hover{
    background-color: #<?= $color; ?>!important;
}

/* File type selection */
.file-type-selection li.selected{
    border-bottom: 5px solid #<?= $color; ?>!important;
    color: #<?= $color; ?>!important;
}
.file-type-selection li:hover{
    border-bottom: 5px solid #<?= $color; ?>!important;
    color: #<?= $color; ?>!important;
}
.tab-selection li.selected{
    border-bottom: 5px solid #<?= $color; ?>!important;
    color: #<?= $color; ?>!important;
}
.tab-selection li:hover{
    border-bottom: 5px solid #<?= $color; ?>!important;
    color: #<?= $color; ?>!important;
}

/* Post More Menu */
.posts-list .post-upload .post-actions .more-menu .actions-drowpdown-list li:hover{
    background-color:  #<?= $color; ?>!important;
}

/* Notification */
#nav-notifications:before{
    background-color:  #<?= $color; ?>!important;
}

/* Upload View */

/* Post panel + post modal */
.post-panel, .upload-container .upload-view .upload-content, .upload-container .upload-view .upload-content .upload-center-content .upload-content-inner{
    background: <?= hex2rgba($color, 0.2); ?> !important;
}

.upload-container .upload-view .upload-content .upload-center-content .upload-content-header{
    border: 1px solid #<?= $color; ?>!important;
}

.btn-upload{
    background-color:  #<?= $color; ?>!important;
}

.btn-upload:hover{
    background-color: <?= adjustBrightness( $color, -30); ?> !important;
}

.btn-upload:active{
    background-color: <?= adjustBrightness( $color, -60); ?> !important;
}


.add-button{
    background-color: #<?= $color; ?> !important;
    border: 1px solid #<?= $color; ?> !important;
}

.add-button:hover{
    background-color: <?= adjustBrightness( $color, 30); ?> !important;
}

.add-button:active{
    background-color: <?= adjustBrightness( $color, -30); ?> !important;
}


.btn-feedback:hover{
    background-color: <?= adjustBrightness( $color, 30); ?> !important;
}
.btn-feedback:active{
    background-color: <?= adjustBrightness( $color, -30); ?> !important;
}


<?php

function hex2rgba($color, $opacity = false) {
 
    $default = 'rgb(0,0,0)';
 
    //Return default if no color provided
    if(empty($color))
          return $default; 
 
    //Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
            if(abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}
 


function adjustBrightness($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Normalize into a six character long hex string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Split into three parts: R, G and B
    $color_parts = str_split($hex, 2);
    $return = '#';

    foreach ($color_parts as $color) {
        $color   = hexdec($color); // Convert to decimal
        $color   = max(0,min(255,$color + $steps)); // Adjust color
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
    }

    return $return;
}

?>
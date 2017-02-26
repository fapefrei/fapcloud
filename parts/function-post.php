<?php

/* Return formatted link */
function detect_link($text){
    // The Regular Expression filter
    $reg_exUrl = "/(http|https|www)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

    // The Text you want to filter for urls
    // $text = "The text you want to filter goes here. http://google.com";

    // Check if there is a url in the text
    if(preg_match($reg_exUrl, $text, $url)) {

           // make the urls hyper links
           echo preg_replace($reg_exUrl, '<a href="'.$url[0].'">'.$url[0].'</a>', $text);

    } else {
           // if no urls in the text just return the text
           echo $text;
    }
}

detect_link("Your post can contain an url. http://www.twitter.com");


/* Return formatted link */
function hashtag($text){
    // The Regular Expression filter
    $reg_exUrl = "/#([a-zA-Z0-9]+)?/";

    // The Text you want to filter for urls
    // $text = "The text you want to filter goes here. http://google.com";

    // Check if there is a url in the text
    if(preg_match($reg_exUrl, $text, $url)) {

           // make the urls hyper links
           echo preg_replace($reg_exUrl, '<a class="hashtag" href="'.$url[0].'">'.$url[0].'</a>', $text);

    } else {
           // if no urls in the text just return the text
           echo $text;
    }
}

hashtag("Your post can contain an url. www.twitter.com #twitterdown apres");




?>
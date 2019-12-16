<?php

function debug($variable){
    echo '<pre>' . var_dump($variable, true) . '</pre>';
}

function str_random($length){
    $alphabet ="0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}
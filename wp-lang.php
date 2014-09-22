<?php 
session_start();
 if ( isset( $_GET['lang'] ) ) {
    $_SESSION['WPLANG'] = $_GET['lang'];
    define ('WPLANG', $_SESSION['WPLANG']);
 } else {
    if(isset($_SESSION['WPLANG'])) {
        define ('WPLANG', $_SESSION['WPLANG']);
        $_GET['lang'] = $_SESSION['WPLANG'];
    } else {
        if ( isset( $_SERVER["HTTP_ACCEPT_LANGUAGE"] ) ) {
            $languages = strtolower( $_SERVER["HTTP_ACCEPT_LANGUAGE"] );
             $languages = explode( ",", $languages );
            $_SESSION['WPLANG'] = $languages[0];
            $_SESSION['WPLANG'] = str_replace("-", "_", $_SESSION['WPLANG']);
            $_GET['lang'] = substr($_SESSION['WPLANG'],0,2);
            define ('WPLANG', $_SESSION['WPLANG']);
        } else {
            define ('WPLANG', '');
        }
    }
 }
?>
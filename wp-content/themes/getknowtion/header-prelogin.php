<?php
/*
 * header-prelogin.php
 * This is header for prelogin page
 * 
 */
/* Disable BP CHAT ON ALL PRELOGIN PAGE to hide error message*/
add_filter("bpchat_is_disabled","my_custom_chat_disable");

?>
<!DOCTYPE html>
<html style="margin: 0px !important;" xmlns="http://www.w3.org/1999/xhtml">
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<!--=== META TAGS ===-->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="description" content="Keywords"/>
<meta name="author" content="Name"/>

<!--=== Script TAGS ===-->
<!--=== LINK TAGS ===-->
<!--=== TITLE ===-->
<title><?php the_title(); ?> &raquo; <?php bloginfo('name');?></title>
<?php wp_head();?>
</head>
<body <?php body_class(); ?>>
    <div align="center" style="width:100%;">
        <table class="maincontainer" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td align="left" valign="middle" class="loginheader">
                    <header>
                          <a href="<?php echo home_url();?>"><img src="<?php echo THEME_DIR; ?>/images/logo.png" border="0" alt="Knowtion" /></a>
                    </header>
                </td>
            </tr>


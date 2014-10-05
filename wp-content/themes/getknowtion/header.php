<?php
    session_start();
    if (!is_user_logged_in()) {
        wp_redirect(home_url());
        exit(0);
    }
    global $bp;
    $totalfriendsrequest=0;
    $current_loggedin_userid=$bp->loggedin_user->id;
    $homepagepath=$bp->loggedin_user->domain;
    $friendsrequest_userids=bp_get_friendship_requests($current_loggedin_userid);
    if($friendsrequest_userids!=0){
        $totalfriendsrequest=count(explode(",",$friendsrequest_userids));
    }
    $totalunreadmessages=messages_get_unread_count();
    $totalnotifications=$totalunreadmessages+$totalfriendsrequest;

    // video call code start
    require "vendor/autoload.php";

    use OpenTok\OpenTok;
    use OpenTok\Session;
    use OpenTok\Role;

    //$apikey = "44942912";
    //$apisecret = "9ea1ba41c7232eac5ebc68323876ec9d2a8b90f2";
    $openTok = new OpenTok(API_KEY, API_SECRET);
    //$sessionId = "2_MX40NDk0MjkxMn5-RnJpIEF1ZyAxNSAxMDowODoyMSBQRFQgMjAxNH4wLjI3NzYzOTk5fn4";

    //$iam = "id=user" . $current_loggedin_userid;
    $iam = "id=" . $current_loggedin_userid;
    $myidentity = $iam . "|||name=" . xprofile_get_field_data('First Name', $current_loggedin_userid) . " " . xprofile_get_field_data('Last Name', $current_loggedin_userid) . "|||path=" . bp_core_fetch_avatar(array('item_id' => $current_loggedin_userid, 'no_grav' => true, 'html' => false));
    
    $token = trim($_SESSION['token']);
    if(!$token){
        $token = $openTok->generateToken(SESSIONID, array( 'role' => "publisher", null, 'expireTime' => time()+(7 * 24 * 60 * 60), 'data' => $myidentity)); 
    }
    // add the details to the session
    $_SESSION['sessionid'] = SESSIONID;
    $_SESSION['iam'] = $iam;
    $_SESSION['myidentity'] = $myidentity;
    //$_SESSION['profileid'] = $profileid;
    $_SESSION['token'] = $token;
    // video call code ends
    $current_locale=get_locale();
?>
<!DOCTYPE html>
<html style="margin: 0px !important;" xmlns="http://www.w3.org/1999/xhtml">
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<!--=== META TAGS ===-->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="description" content="Keywords"/>
<meta name="author" content="Name"/>
<title>Knowtion &raquo; <?php wp_title(''); ?></title>
<!--=== LINK TAGS ===-->

<!--=== Script TAGS ===-->

<!--=== WP_HEAD() ===-->
<?php wp_head(); ?>
<script src="<?php echo THEME_DIR."/js/pages/opentok/TB.min.js"; ?>" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    var autoconnect = true;
    var home_url="<?php echo HOME_URL;?>";
    var iam = "<?php echo $_SESSION['iam'];?>";
    var myidentity = "<?php echo $_SESSION['myidentity'];?>";
    var usertocall = "cGFydG5lcl9pZD00NDk0MjkxMiZzaWc9N2FmM2Q2ZDM3OWJlYmQ3NTllOWZjMTE3MTA1ZmRlZTVlOTk4ZWFkNzpzZXNzaW9uX2lkPTJfTVg0ME5EazBNamt4TW41LVJuSnBJRUYxWnlBeE5TQXhNRG93T0RveU1TQlFSRlFnTWpBeE5INHdMakkzTnpZek9UazVmbjQmY3JlYXRlX3RpbWU9MTQwOTkzNzI2NyZyb2xlPXB1Ymxpc2hlciZub25jZT0xNDA5OTM3MjY3Ljk0MTEyOTQyMzIwMjQmZXhwaXJlX3RpbWU9MTQxMDU0MjA2NyZjb25uZWN0aW9uX2RhdGE9aWQlM0R1c2VyMiU3QyU3QyU3Q25hbWUlM0RKaXRlc2grVGFuZGVsJTdDJTdDJTdDcGF0aCUzRGh0dHAlM0ElMkYlMkZsb2NhbGhvc3QlMkZrbm93dGlvbiUyRndwLWNvbnRlbnQlMkZwbHVnaW5zJTJGYnVkZHlwcmVzcyUyRmJwLWNvcmUlMkZpbWFnZXMlMkZteXN0ZXJ5LW1hbi5qcGc";
    var useroncallname = "";

    var apiKey = "<?php echo API_KEY;?>";
    var sessionId = "<?php echo SESSIONID;?>";
    var token = "<?php echo $_SESSION['token'];?>";
</script>
<script src="<?php echo THEME_DIR."/js/pages/opentok/common.js"; ?>" type="text/javascript" charset="utf-8"></script>
</head>
    <body <?php body_class(); ?>>
    	<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
        	<tr>
            	<td valign="top" align="center" style="width:960px;height: 100%;">
            		<div id="workingarea">
                            <table cellpadding="0" cellspacing="0" border="0" style="width:100%;height: 100%;">
                            <tr>
                                <td valign="top" align="left" id="header">
                                    <div class="top">
                                        <div class="logo">
                                            <a href="<?php echo $homepagepath;?>"><img alt="knowtion" title="knowtion" src="<?php echo THEME_DIR; ?>/images/logo.png" width="140" height="40"></a>
                                        </div>
                                        <div class="search">
                                            <form method="post" id="searchform" method="get" action="<?php echo site_url(); ?>/members/">
                                                <input type="hidden" name="actionname" value="searchmembers">
                                                <input type="hidden" id="searchsubmit" value="Search" />
                                                <table cellpadding="0" cellspacing="0" align="right">
                                                <tr>
                                                    <td><input type="text" class="searchtextbox" name="searchterm" placeholder="<?php _e( 'Search', 'knowtion' ); ?>"/></td>
                                                    <td style="vertical-align:middle;"><input type="image" id="searchsubmit" src="<?php echo THEME_DIR; ?>/images/search-green.png" class="searchbutton" /></td>
                                                  </tr>
                                              </table>
                                              </form>
                                        </div>
                                        <div class="menu">
                                            <div class="dropdown">
                                                <div class="user">
                                                    <div class="header-account-text">
                                                        <?php _e( 'My Account', 'knowtion' ); ?>
                                                        <?php if($totalnotifications>0){?>
                                                            <div class="notification-count-main"><?php echo $totalnotifications;?></div>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                                <div class="headersubmneu">
                                                    <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
                                                        <tr>
                                                            <td class="popover-border-bottom"><!-- --></td>
                                                            <td class="popover-top-arrow"><!-- --></td>
                                                            <td class="popover-border-bottom" style="width: 12px;"><!-- --></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" class="popover-border-bottom popover-border-right popover-border-left popover-bg">
                                                                <ul class="root">
                                                                    <li><a href="<?php echo $homepagepath . 'profile';?>"><?php _e( 'My Account', 'knowtion' ); ?></a></li>
                                                                    <li>
                                                                        <a href="<?php echo $homepagepath . 'messages';?>">
                                                                            <?php _e( 'Messages', 'knowtion' ); ?>
                                                                            <?php if($totalunreadmessages>0){?>
                                                                                <div class="notification-count-main"><?php echo $totalunreadmessages; ?></div>
                                                                            <?php }?>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="<?php echo $homepagepath . 'friends';?>">
                                                                            <?php _e( 'Friends', 'knowtion' ); ?>
                                                                            <?php if($totalfriendsrequest>0){?>
                                                                                <div class="notification-count-main"><?php echo $totalfriendsrequest; ?></div>
                                                                            <?php }?>

                                                                        </a>
                                                                    </li>
                                                                    <li><a href="<?php echo $homepagepath . 'settings';?>"><?php _e( 'Settings', 'knowtion' ); ?></a></li>
                                                                    <li><a href="javascript:void(0);" onclick="MemberLogout('<?php echo wp_logout_url(HOME_URL); ?>');"><?php _e( 'Sign Out', 'knowtion' ); ?></a></li>
                                                                </ul>                                                    
                                                            </td>
                                                        </tr>
                                                    </table> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="header-lang-main pull-right">
                                            <?php
                                                if($current_locale=="en_us" || $current_locale=="en"){
                                            ?>
                                            <span class="header-lang-selected" title="English">EN</span>    

                                            <?php 
                                                }
                                                else { 
                                            ?>
                                                <span class="header-lang-text" title="English" onclick="changecurrentlocale('en');">EN</span>
                                            <?php 
                                                }
                                            ?>
                                                <span>|</span>
                                            <?php
                                                if($current_locale=="zh"){
                                            ?>
                                                <span class="header-lang-selected" title="Chinese">ZH</span>

                                            <?php 
                                                }
                                                else { 
                                            ?>
                                                <span class="header-lang-text" title="Chinese" onclick="changecurrentlocale('zh');">ZH</span>
                                            <?php 
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            
                                     
        
 


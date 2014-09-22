<?php
define('WP_USE_THEMES', false);
require_once('../../../../wp-load.php');

global $bp;
//echo $displayed_userid=$bp->displayed_user->id;
echo $bp->displayed_user->id;


global $wpdb;


//$wpdb->insert('wp_email_subscription',array('name'=>$name,'email'=>$email),array('%s','%s'));
//$result = $wpdb->get_results('select * from wp_users WHERE ID = 1');

echo '<pre>';
print_r($_REQUEST);
echo '</pre>';

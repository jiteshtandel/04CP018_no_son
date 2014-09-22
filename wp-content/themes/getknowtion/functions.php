<?php
/**
 * functions.php
 *
 * Contains almost all of the Theme's setup functions and custom functions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 *
 * 
 */

/**
 * Register & Enqueue Style & Scripts For Themes
 */
define("THEME_DIR", get_template_directory_uri());
define("HOME_URL", home_url());
define("PER_PAGE_RECORDS", 2);
define("MEMBERS_PER_PAGE", 20);
/*--- REMOVE GENERATOR META TAG ---*/
remove_action('wp_head', 'wp_generator');
$TIMEZONEARR=array();
    $TIMEZONEARR['(GMT -12:00) Eniwetok, Kwajalein']=array("seconds"=>-43200);
    $TIMEZONEARR['(GMT -11:00) Midway Island, Samoa']=array("seconds"=>-39600);
    $TIMEZONEARR['(GMT -10:00) Hawaii']=array("seconds"=>-36000);
    $TIMEZONEARR['(GMT -9:00) Alaska']=array("seconds"=>-32400);
    $TIMEZONEARR['(GMT -8:00) Pacific Time (US & Canada)']=array("seconds"=>-28800);
    $TIMEZONEARR['(GMT -7:00) Mountain Time (US & Canada)']=array("seconds"=>-25200);
    $TIMEZONEARR['(GMT -6:00) Central Time (US & Canada), Mexico City']=array("seconds"=>-21600);
    $TIMEZONEARR['(GMT -5:00) Eastern Time (US & Canada), Bogota, Lima']=array("seconds"=>-18000);
    $TIMEZONEARR['(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz']=array("seconds"=>-14400);
    $TIMEZONEARR['(GMT -4:30) Caracas']=array("seconds"=>-16200);
    $TIMEZONEARR['(GMT -3:30) Newfoundland']=array("seconds"=>-12600);
    $TIMEZONEARR['(GMT -3:00) Brazil, Buenos Aires, Georgetown']=array("seconds"=>-10800);
    $TIMEZONEARR['(GMT -2:00) Mid-Atlantic']=array("seconds"=>-7200);
    $TIMEZONEARR['(GMT -1:00) Azores, Cape Verde Islands']=array("seconds"=>-3600);
    $TIMEZONEARR['(GMT 0:00) Western Europe Time, London, Lisbon, Casablanca, Greenwich']=array("seconds"=>0);
    $TIMEZONEARR['(GMT +1:00) Brussels, Copenhagen, Madrid, Paris']=array("seconds"=>+3600);
    $TIMEZONEARR['(GMT +2:00) Kaliningrad, South Africa']=array("seconds"=>+7200);
    $TIMEZONEARR['(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg']=array("seconds"=>+10800);
    $TIMEZONEARR['(GMT +3:30) Tehran']=array("seconds"=>+12600);
    $TIMEZONEARR['(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi']=array("seconds"=>+14400);
    $TIMEZONEARR['(GMT +4:30) Kabul']=array("seconds"=>+16200);
    $TIMEZONEARR['(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent']=array("seconds"=>+18000);
    $TIMEZONEARR['(GMT +5:30) Mumbai, Kolkata, Chennai, New Delhi']=array("seconds"=>+19800);
    $TIMEZONEARR['(GMT +5:45) Kathmandu']=array("seconds"=>+20700);
    $TIMEZONEARR['(GMT +6:00) Almaty, Dhaka, Colombo']=array("seconds"=>+21600);
    $TIMEZONEARR['(GMT +7:00) Bangkok, Hanoi, Jakarta']=array("seconds"=>+25200);
    $TIMEZONEARR['(GMT +8:00) Beijing, Perth, Singapore, Hong Kong']=array("seconds"=>+28800);
    $TIMEZONEARR['(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk']=array("seconds"=>+32400);
    $TIMEZONEARR['(GMT +9:30) Adelaide, Darwin']=array("seconds"=>+34200);
    $TIMEZONEARR['(GMT +10:00) Eastern Australia, Guam, Vladivostok']=array("seconds"=>+36000);
    $TIMEZONEARR['(GMT +11:00) Magadan, Solomon Islands, New Caledonia']=array("seconds"=>+39600);
    $TIMEZONEARR['(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka']=array("seconds"=>+43200);
    $TIMEZONEARR["(GMT +13:00) Nuku'alofa"]=array("seconds"=>+46800);
    //print_r($TIMEZONEARR);

function getusertimezonename($userid=0){
    global $TIMEZONEARR;
    $usertimezone=xprofile_get_field_data('Local Timezone', $userid);
    $getgmoffset=$TIMEZONEARR[$usertimezone]['seconds'];
    $timezoneName=timezone_name_from_abbr("", $getgmoffset, 0);
    return $timezoneName;
}
function settimezone($timezoneName="UTC"){
    $UTC = new DateTimeZone("UTC");
    $newTZ = new DateTimeZone($timezoneName);
    $date = new DateTime("now", $UTC );
    $date->setTimezone( $newTZ );
    return $date;
}
// ENQUEUE STYLES
function my_enqueue_styles() {
    //wp_register_style('my-main-style', THEME_DIR . '/css/main-style.css', array(), '1', 'all' );
    wp_register_style('my-main-style', THEME_DIR . '/css/main.css', array(), '1', 'all' );
    wp_register_style('my-notification-style', THEME_DIR . '/css/notification.css', array(), '1', 'all' );
    wp_register_style('my-secondary-style', THEME_DIR . '/css/secondary.css', array(), '1', 'all' );
    wp_register_style('my-video-style', THEME_DIR . '/css/video.css', array(), '1', 'all' );
    
    wp_enqueue_style('my-main-style' );
    wp_enqueue_style('my-notification-style' );
    wp_enqueue_style('my-secondary-style' );
    wp_enqueue_style('my-video-style' );
}

     
// ENQUEUE SCRIPTS
     
function my_enqueue_scripts() {
    /** REGISTER Notification OtherScript.js **/
    wp_register_script('jquery-notification-script', THEME_DIR .'/js/jquery/jquery.notification.js', array(), '1', false);
    wp_register_script('jquery-validate-script', THEME_DIR .'/js/jquery/jquery.validate.1.9.js', array(), '1', false);
    wp_register_script('my-editor-script', THEME_DIR .'/js/bbpress/editor.js', array(), '1', false);
    wp_register_script('my-common-script', THEME_DIR .'/js/pages/common.js', array(), '1', false);
    wp_register_script('jquery-raty-script', THEME_DIR .'/js/jquery/jquery.raty.js', array('jquery'), '1.0', true);
    wp_register_script('member-profile', THEME_DIR.'/js/pages/member.js', array(), '1', false );
    wp_register_script('my-popup', THEME_DIR.'/js/pages/popup.js', array('jquery'), '1.0', true );
    
    wp_enqueue_script( 'jquery-notification-script');
    wp_enqueue_script( 'jquery-validate-script');
    wp_enqueue_script( 'my-editor-script');
    wp_enqueue_script( 'my-common-script');
    wp_enqueue_script( 'jquery-raty-script');
    wp_enqueue_script( 'member-profile');
    wp_enqueue_script( 'my-popup');
    wp_localize_script('my-popup', 'ajax_var', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-nonce'),
        'themepath' => THEME_DIR
        
    ));
 }

/* Custom actions - WP hooks */
function restrict_admin(){
    /*if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
        wp_redirect( site_url() );
    }*/
}

function my_login_failed( $user ) {
  	// check what page the login attempt is coming from
  	$referrer = $_SERVER['HTTP_REFERER'];

  	// check that were not on the default login page
	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $user!=null ) {
		// make sure we don't already have a failed login attempt
		if ( !strstr($referrer, '?login=failed' )) {
			// Redirect to the login page and append a querystring of login failed
	    	wp_redirect( $referrer . '?login=failed');
	    } else {
	      	wp_redirect( $referrer );
	    }

	    exit;
	}
}

function my_blank_login( $user ){
  	// check what page the login attempt is coming from
  	$referrer = $_SERVER['HTTP_REFERER'];

  	$error = false;

  	if($_POST['log'] == '' || $_POST['pwd'] == '')
  	{
  		$error = true;
  	}

  	// check that were not on the default login page
  	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $error ) {

  		// make sure we don't already have a failed login attempt
    	if ( !strstr($referrer, '?login=failed') ) {
    		// Redirect to the login page and append a querystring of login failed
        	wp_redirect( $referrer . '?login=failed' );
      	} else {
        	wp_redirect( $referrer );
    }

    exit;

  	}
}
/*
 * Register Navigation Menu
 * 
 */
function my_register_theme_menu() {
    register_nav_menu('user-main-nav', 'User Main Navigation Menu' );
}

/*
 * Register Widget Menu
 */
function my_widgets_init() {
 
    // Sidebar widget area, located in the sidebar. Empty by default.
    register_sidebar( array(
        'name' => 'Sidebar FAQ Widget',
        'id' => 'sidebar-faq-widget',
        'description' => 'The FAQ sidebar widget area',
        'before_widget' => '<div class="widget-container %2$s" id="%1$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
	
	register_sidebar( array(
        'name' => 'Sidebar Recent Activity Widget',
        'id' => 'sidebar-recent-activity-widget',
        'description' => 'The Recent Activity sidebar widget area',
        'before_widget' => '<div class="widget-container %2$s" id="%1$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="lang-categories recent-activity">',
        'after_title' => '</div>',
    ) );
	
	register_sidebar( array(
        'name' => 'Who are Currently Online ',
        'id' => 'who-are-currently-online',
        'description' => 'who are currently online widget area',
        'before_widget' => '<div class="widget-container %2$s" id="%1$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="who-online" style="text-transform:uppercase">',
        'after_title' => '</div>',
    ) );
	
	register_sidebar( array(
        'name' => 'Search Forum',
        'id' => 'search-forum',
        'description' => 'search forum widget area',
        'before_widget' => '<div class="widget-container %2$s" id="%1$s">',
        'after_widget' => '</div>',
        'before_title' => '<div style="text-transform:uppercase">',
        'after_title' => '</div>',
    ) );
}

function my_redirect_to_profile($redirect_to_calculated,$redirect_url_specified,$user){
    /*if the user is not site admin,redirect to his/her profile*/
    if(!is_site_admin($user->ID)){
        return bp_core_get_user_domain($user->ID );}
    else{
        $redirect_to_calculated=admin_url();
        return $redirect_to_calculated; 
    } 
        /*if site admin or not logged in,do not do anything much*/
}

/* Forum BreadCrumb Filter*/
function mycustom_breadcrumb_options() {
    $args['before'] = '<div class="bbp-breadcrumb"><p><a href="' . bp_core_get_user_domain(bp_loggedin_user_id()) . '" class="bbp-breadcrumb-home">Home</a><span class="bbp-breadcrumb-sep"> &rsaquo; </span>';
    $args['after'] = '</p></div>';
    // Home - default = true
    $args['include_home']    = false;
    // Forum root - default = true
    $args['include_root']    = (str_replace(".php","",basename($_SERVER['REQUEST_URI']))!="forums") ? true : false;
    // Current - default = true
    $args['include_current'] = true;
    return $args;
}

function concat($row, $fields, $concatby) {
        $return='';

        $row=get_object_vars($row);

        for($index=0;$index<count($fields);$index++) {
                if(strlen(trim($return))==0 and strlen(trim($row[$fields[$index]]))>0) {
                        $return=$row[$fields[$index]];
                }
                else if(strlen(trim($row[$fields[$index]]))>0) {
                        $return.=$concatby . $row[$fields[$index]];	
                }
        }

        return $return;
}

function strconcat($fields, $concatby) {
        $return='';

        for($index=0;$index<count($fields);$index++) 
        {
                if(strlen(trim($return))==0 and strlen(trim($fields[$index]))>0) {
                        $return=$fields[$index];	
                }
                else if(strlen(trim($fields[$index]))>0) {
                        $return.=$concatby . $fields[$index];	
                }
        }
        return $return;
}
function ellipses($value, $length) {
        if(strlen(trim($value))>$length)
                return substr($value, 0, $length) . "...";
        else
                return trim($value);
}

function my_custom_chat_disable($disable){
    return true;
}
function post_review(){
    global $wpdb;
    // Check for nonce security
    $nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Busted!');
     
    if(isset($_POST['action'])){
        $to_userid = intval($_POST['to_userid']);
        $from_userid = intval($_POST['from_userid']);
        $rating = intval($_POST['rating']);
        $review = trim($_POST['review']);
        $sessionid = trim($_POST['sessionid']);
        $sessiontime = trim($_POST['sessiontime']);
        
        // Into the posts table, insert a published post with a title and content with the arbitrary post ID of 9999
        $wpdb->insert(
            'usersreview',
            array(
                'sessionid'=>$sessionid,
                'sessiontime'=>$sessiontime,
                'to_userid'=>$to_userid,
                'from_userid'=>$from_userid,
                'rating'=>$rating,
                'review'=>$review,
                'creationdate'=>current_time('mysql', 1),
            ),
            array('%d', '%s', '%d', '%d', '%d', '%s', '%s')
        );        
        echo "success";
    }
    else{
        echo "error";
    }
    exit(0);
}

function getratingoverall($userid=0){
    global $wpdb;
    $row = $wpdb->get_results("SELECT avg(rating) as avgrating,count(*) as totalrating FROM usersreview where to_userid=$userid");
    $wpdb->flush();
    if(isset($row)){
        $totalrating=$row[0]->totalrating;
        $avgrating=$row[0]->avgrating;
        
        $avgrating=round(($avgrating*2), 0)/2;
        return array("totalrating"=>$totalrating,"avgrating"=>$avgrating);
    }
    else{
        return array();
    }     
}   
function getuserreviews(){
    $nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Busted!');
    
    bp_get_template_part('members/single/member-reviews');
    exit();
}

function my_theme_setup(){
    load_theme_textdomain('knowtion', get_template_directory() . '/languages');
    //load_theme_textdomain('knowtion', THEME_DIR . '/languages');
}


// Numbered Pagination
if ( !function_exists( 'wpex_pagination' ) ) {
	
	function wpex_pagination($max_num_pages) {
		
		$prev_arrow = is_rtl() ? '&rarr;' : '&larr;';
		$next_arrow = is_rtl() ? '&larr;' : '&rarr;';
		
		global $wp_query;
		$total = $max_num_pages;//$wp_query->max_num_pages;
		$big = 999999999; // need an unlikely integer
		if( $total > 1 )  {
			 if( !$current_page = get_query_var('paged') )
				 $current_page = 1;
			 if( get_option('permalink_structure') ) {
				 $format = 'page/%#%/';
			 } else {
				 $format = '&paged=%#%';
			 }
			echo paginate_links(array(
				'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'		=> $format,
				'current'		=> max( 1, get_query_var('paged') ),
				'total' 		=> $total,
				'end_size' 		=> 1,
				'mid_size' 		=> 1,
				'show_all' 		=> false,
				'type' 			=> 'list',
				'prev_text'		=> $prev_arrow,
				'next_text'		=> $next_arrow,
			 ) );
		}
	}
	
}


add_action('after_setup_theme', 'my_theme_setup');
add_action('wp_ajax_nopriv_post-review', 'post_review');
add_action('wp_ajax_post-review', 'post_review');

add_action('wp_ajax_nopriv_get-user-reviews', 'getuserreviews');
add_action('wp_ajax_get-user-reviews', 'getuserreviews');
add_filter('login_redirect', 'my_redirect_to_profile',10, 3);
add_action( 'admin_init', 'restrict_admin', 1 );
add_action( 'wp_login_failed', 'my_login_failed' ); // hook failed login
add_action( 'authenticate', 'my_blank_login');
add_action( 'wp_enqueue_scripts', 'my_enqueue_styles' );
add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts' );
add_action( 'init', 'my_register_theme_menu' );
add_action( 'widgets_init', 'my_widgets_init' );
add_filter('show_admin_bar', '__return_false');
add_filter('bbp_before_get_breadcrumb_parse_args', 'mycustom_breadcrumb_options');

// video call constants
/*OLD*/
//define("API_KEY", "44942912");
//define("API_SECRET", "9ea1ba41c7232eac5ebc68323876ec9d2a8b90f2");
/*NEW*/ 
define("API_KEY","44983012");
define("API_SECRET","c10f770b5b0a0d4398b824c4430609e8bf55f8a7");
//Please change Sessionid on main.css page also 
define("SESSIONID","1_MX40NDk4MzAxMn5-U2F0IFNlcCAxMyAwMTo0ODoxNiBQRFQgMjAxNH4wLjk0MjA5NH5-");

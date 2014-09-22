<?php 
    get_header();
    $displayed_userid=$bp->displayed_user->id;
    $current_loggedin_userid=$bp->loggedin_user->id;
    if($displayed_userid==$current_loggedin_userid){
        bp_get_template_part( 'members/single/user-home' );
    }
    else{
        bp_get_template_part( 'members/single/member-details' );
    }

    /* Time scheduler plugin */
    require_once get_template_directory() . '/np_calender/calender.php';
    get_footer();
?>



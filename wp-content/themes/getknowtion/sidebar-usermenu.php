<?php
    global $bp;
    $homepagepath=$bp->loggedin_user->domain;
    $current_loggedin_userid=$bp->loggedin_user->id;
    $userimage=bp_core_fetch_avatar(array('item_id' => $current_loggedin_userid,'html' => false, 'type'=>'thumb','width'=>BP_AVATAR_THUMB_WIDTH,'height' => BP_AVATAR_THUMB_HEIGHT));
?>
<div class="userinfo">
    <a href="<?php echo  $homepagepath . 'profile/';?>"><img src="<?php echo $userimage;?>" border="0"/></a>
    <a href="<?php echo $homepagepath . 'profile/';?>" class="username"><?php echo $bp->loggedin_user->fullname;?></a></br>
    <a href="<?php echo $homepagepath . 'profile/edit';?>" class="edit-profile"><?php _e( 'Edit Profile', 'knowtion' ); ?></a>
    <div class="clearboth"></div>
</div>
<div class="left-site-menu">
    <ul class="menu-items">
        <li class="page-item">
            <a id="homelink" href="<?php echo $homepagepath;?>"><?php _e( 'Home', 'knowtion' ); ?></a>
        </li>
        <li class="page-item">
            <a href="#calender-container" class="manage_calender fancybox"><?php _e( 'Manage my calendar', 'knowtion' ); ?></a>
        </li>
         <li class="page-item">
            <a href="<?php echo HOME_URL; ?>/schedule-request"><?php _e( 'Schedule a lesson', 'knowtion' ); ?></a>
        </li>
         <li class="page-item">
             <a href="<?php echo HOME_URL; ?>/forums"><?php _e( 'Forums', 'knowtion' );?></a>
        </li>
    </ul>
</div>
<div class="gray-border-bottom">&nbsp;</div>

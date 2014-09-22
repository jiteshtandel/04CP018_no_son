<?php
    global $bp;
    $currentaction=$bp->current_action;
    $homepagepath=$bp->loggedin_user->domain;
?>
<tr>
    <td valign="top" align="left" id="container">
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
            <tr>
                <td valign="top" align="left" id="leftbar">
                    <div class="userinfo">
                        <a href="<?php echo  $homepagepath . 'profile/';?>"><?php bp_displayed_user_avatar( 'type=thumb' );?></a>
                        <a href="<?php echo $homepagepath . 'profile/';?>" class="username"><?php echo $bp->loggedin_user->fullname;;?></a></br>
                        <a href="<?php echo $homepagepath . 'profile/edit';?>" class="edit-profile">Edit Profile</a>
                        <div class="clearboth"></div>
                    </div>    
                    <div class="left-site-menu">
                        <ul class="menu-items">
                            <li class="page-item">
                                <a href="<?php echo $homepagepath;?>">Home</a>
                            </li>
                            <li class="page-item">
                                <a href="#calender-container" class="manage_calender fancybox">Manage my calender</a>
                            </li>
                             <li class="page-item">
                                <a href="<?php echo HOME_URL; ?>/schedule-request">Schedule a lesson</a>
                            </li>
                             <li class="page-item">
                                 <a href="<?php echo HOME_URL; ?>/forums">Forums</a>
                            </li>
                        </ul>
                    </div>
                    <div class="gray-border-bottom">&nbsp;</div>
                    <?php get_sidebar('faq');?>
                </td>
                <td valign="top" align="left" id="content">
                    	<div class="learning-option">
                            <div><h4>Get to Know</h4></div>
                            <div style="padding:10px 0px 0px 45px;">
                                <a class="greentext15" href="<?php echo HOME_URL; ?>/members/">Browse Language Partners</a>
                                <div class="blacktext12">Search for language partners in your target languages.</div>
                                <div class="height15"><!-- --></div>
                                <a class="greentext15" href="<?php echo HOME_URL; ?>/schedule-request/">Schedule a Lesson</a>
                                <div class="blacktext12">Set a time for your first online language lesson.</div>
                                <div class="height15"><!-- --></div>
                                <a class="greentext15" href="<?php echo site_url(); ?>/forums">Visit a Forum</a>
                                <div class="blacktext12">Now that you've had a lesson, give feedback on your teacher.</div>
                            </div>
                        </div>                    
                        <div style="padding-top:20px;" id="buddypress">
                        <div class="greentext15">Update Your Status</div>
                        <div class="update-status">
                            <div class="up-arrow"></div>
                            <div>
                            <?php 
                                do_action( 'bp_before_member_activity_post_form' );
                                bp_get_template_part( 'activity/post-form' );
                                do_action('bp_after_member_activity_post_form' );
                            ?>
                            </div>
                        </div>
                        <div style="padding-top: 25px;">
                                <!--<div class="greentext15">Updates</div>-->
                                <div class="height10"><!-- --></div>
                                <div class="member-posts-title-main">
                                    <div class="pull-left"><a href="<?php echo $homepagepath . 'activity/';?>" id="just-me"><div class="member-posts-title <?php echo ($currentaction!="friends") ? 'meber-posts-selected' : '';?>">Personal</div></a></div>
                                    <div class="pull-left"><a href="<?php echo $homepagepath . 'activity/friends/';?>" id="activity-friends"><div class="member-posts-title <?php echo ($currentaction=="friends") ? 'meber-posts-selected' : '';?>">Friends</div></a></div>
                                </div>
                                <div class="activity" role="main">
                                    <?php do_action( 'bp_before_member_activity_content' ); ?>
                                    <?php bp_get_template_part( 'activity/activity-loop' ) ?>
                                    <?php do_action( 'bp_after_member_activity_content' ); ?>
                                </div><!-- .activity -->
                        </div>
                    </div>
                </td>
                <td valign="top" align="left" id="rightbar">
                    <h6 class="suggested-knowtions">Suggested</h6>
                    <div class="height15"><!-- --></div>
                    <?php get_sidebar('suggestedknowtion');?>
                    <div class="height20"><!-- --></div>
                    <?php get_sidebar('whotoknow');?>
                </td>
            </tr>
        </table>
    </td>
</tr>

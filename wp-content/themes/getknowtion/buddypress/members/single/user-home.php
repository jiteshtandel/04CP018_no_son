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
                    <?php get_sidebar('usermenu');?>
                    <?php get_sidebar('faq');?>
                </td>
                <td valign="top" align="left" id="content">
                    	<div class="learning-option">
                            <div><h4><?php _e( 'Get to Know', 'knowtion' ); ?></h4></div>
                            <div style="padding:10px 0px 0px 45px;">
                                <a class="greentext15" href="<?php echo HOME_URL; ?>/members/"><?php _e( 'Browse Language Partners', 'knowtion' ); ?></a>
                                <div class="blacktext12"><?php _e( 'Search for language partners in your target languages.', 'knowtion' ); ?></div>
                                <div class="height15"><!-- --></div>
                                <a class="greentext15" href="<?php echo HOME_URL; ?>/schedule-request/"><?php _e( 'Schedule a Lesson', 'knowtion' ); ?></a>
                                <div class="blacktext12"><?php _e( 'Set a time for your first online language lesson.', 'knowtion' ); ?></div>
                                <div class="height15"><!-- --></div>
                                <a class="greentext15" href="<?php echo HOME_URL; ?>/forums"><?php _e( 'Visit a Forum', 'knowtion' ); ?></a>
                                <div class="blacktext12"><?php _e( "Now that you've had a lesson, give feedback on your teacher.", 'knowtion' ); ?></div>
                            </div>
                        </div>                    
                        <div style="padding-top:20px;" id="buddypress">
                        <div class="greentext15"><?php _e( 'Update Your Status', 'knowtion' ); ?></div>
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
                                    <div class="pull-left"><a href="<?php echo $homepagepath . 'activity/';?>" id="just-me"><div class="member-posts-title <?php echo ($currentaction!="friends") ? 'meber-posts-selected' : '';?>"><?php _e( 'Personal', 'knowtion' ); ?></div></a></div>
                                    <div class="pull-left"><a href="<?php echo $homepagepath . 'activity/friends/';?>" id="activity-friends"><div class="member-posts-title <?php echo ($currentaction=="friends") ? 'meber-posts-selected' : '';?>"><?php _e( 'Friends', 'knowtion' ); ?></div></a></div>
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
                    <h6 class="suggested-knowtions"><?php _e( 'Suggested', 'knowtion' ); ?></h6>
                    <div class="height15"><!-- --></div>
                    <?php get_sidebar('suggestedknowtion');?>
                    <div class="height20"><!-- --></div>
                    <?php get_sidebar('whotoknow');?>
                </td>
            </tr>
        </table>
    </td>
</tr>

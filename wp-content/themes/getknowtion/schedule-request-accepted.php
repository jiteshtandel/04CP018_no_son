<?php
    get_header();
    global $bp;
    $current_loggedin_userid=get_current_user_id();
    require_once get_template_directory() . '/np_calender/calender.php';

    //check if search filter has any year request
    $search_year = !empty( $_REQUEST['sy'] ) ? stripslashes( $_REQUEST['sy'] ) : 0;
    $approved_schedules = get_approved_schedules($current_loggedin_userid, $search_year);

    //echo '<pre>';print_r($approved_schedules);exit;

    $homepagepath=$bp->loggedin_user->domain;
    $userimage=bp_core_fetch_avatar(array('item_id' => $current_loggedin_userid,'html' => false, 'type'=>'thumb','width'=>BP_AVATAR_THUMB_WIDTH,'height' => BP_AVATAR_THUMB_HEIGHT));
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
                    <div>
                        <article class="post-0 bp_members type-bp_members status-publish hentry" id="post-0">
                            <div class="entry-content">
                                <div id="buddypress">
                                    <div id="item-header">
                                        <h4><?php _e( 'Schedule a lesson', 'knowtion' );?></h4>
                                    </div><!-- #item-header -->
                                    <div class="height5"><!-- --></div>
                                    <div role="main" id="item-body">
                                        <div role="navigation" id="subnav" class="item-list-tabs no-ajax">
                                            <ul>
                                                <li id="friends-my-friends-personal-li"><a href="<?php echo  home_url(); ?>/schedule-request/" id="friends-my-friends"><?php _e( 'Requests', 'knowtion' );?></a></li>
                                                <li class="current selected" id="requests-personal-li"><a href="<?php echo  home_url(); ?>/schedule-request-accepted/" id="requests"><?php _e( 'Accepted', 'knowtion' );?></a></li>
                                                <li id="requests-personal-li"><a href="<?php echo  home_url(); ?>/sent-requests/" id="sent_requests"><?php _e( 'Request Sent', 'knowtion' );?></a></li>
                                                <li id="requests-personal-li">
                                                    <div style="width: 265px;text-align: right">
                                                        <?php //np_year_search_form(); ?>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <?php if(!empty($approved_schedules)): ?>
                                        <?php
                                            foreach($approved_schedules as $schedule) :

                                                $viewer_user_id = $schedule->requester_id;
                                                if($current_loggedin_userid == $schedule->requester_id)
                                                    $viewer_user_id = $schedule->host_user_id;
                                                $requester = get_user_info($viewer_user_id);
                                                $time_batch  = get_schedule($schedule->user_id, $schedule->schedule_date)
                                        ?>
                                        <ul role="main" class="item-list" id="schedule_requests">
                                            <li id="" class="schedule_time_<?php echo $batch->schedule_time_id;?>">
                                                <div class="clearboth" style="width: 100%;border-top:1px solid #939598;"><!-- --></div>
                                                <div class="height15"><!-- --></div>
                                                <div class="item-avatar">
                                                    <a href="<?php echo  home_url(); ?>/members/<?php echo $requester->user_nicename; ?>"><img width="50" height="50" alt="Profile picture of <?php echo $requester->display_name; ?>" class="avatar user-9-avatar avatar- photo" src="http://gravatar.com/avatar/<?php echo md5(strtolower(trim($requester->user_email))); ?>?d=mm&amp;s=50&amp;r=G"></a>
                                                </div>

                                                <div class="item">
                                                    <div class="item-title"><a href="<?php echo  home_url(); ?>/members/<?php echo $requester->user_nicename; ?>/"><?php echo $requester->display_name; ?></a></div>
                                                    <div class="item-meta"><span class="activity"><?php echo $schedule->schedule_date; ?></span></div>
                                                    <div class="item-meta"><span class="activity"><?php echo $schedule->start_time; ?> - <?php echo $schedule->end_time; ?> <?php echo $schedule->host_timezone; ?></span></div>

                                                    <?php if($schedule->host_timezone != $schedule->requester_timezone):?>
                                                        <div class="item-meta" style="margin-left: 65px"><span class="activity"><?php echo $schedule->requester_start_time; ?> - <?php echo $schedule->requester_end_time; ?> <?php echo $schedule->requester_timezone; ?></span></div>
                                                    <?php endif; ?>
                                                </div>
                                            </li>
                                        </ul>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div id="errornotify"></div>
                                            <script type="text/javascript" language="javascript">
                                                jQuery("#errornotify").notification({caption: "<?php _e( 'Sorry, no records found.', 'knowtion' );?>",type:"error",sticky:true});
                                            </script>
                                        <?php endif; ?>
                                    </div><!-- #item-body -->
                                </div><!-- #buddypress -->
                            </div><!-- .entry-content -->
                        </article><!-- #post -->
                    </div>
                </td>
                <td valign="top" align="left" id="rightbar">
                    <h6 class="suggested-knowtions"><?php _e( 'Suggested', 'knowtion' );?></h6>
                    <div class="height15"><!-- --></div>
                    <?php get_sidebar('suggestedknowtion');?>
                    <div class="height20"><!-- --></div>
                    <?php get_sidebar('whotoknow');?>
                </td>
            </tr>
        </table>
    </td>
</tr>
<?php
    get_footer();
?>



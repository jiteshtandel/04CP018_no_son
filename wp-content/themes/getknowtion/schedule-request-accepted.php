<?php
    get_header();
    global $bp;
    $current_loggedin_userid=get_current_user_id();
    require_once get_template_directory() . '/np_calender/calender.php';
    $approved_schedules = get_approved_schedules($current_loggedin_userid);
    $homepagepath=$bp->loggedin_user->domain;
    $userimage=bp_core_fetch_avatar(array('item_id' => $current_loggedin_userid,'html' => false, 'type'=>'thumb','width'=>BP_AVATAR_THUMB_WIDTH,'height' => BP_AVATAR_THUMB_HEIGHT));
?>
<tr>
    <td valign="top" align="left" id="container">
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
            <tr>
                <td valign="top" align="left" id="leftbar">
                    <div class="userinfo">
                        <a href="<?php echo  $homepagepath . 'profile/';?>"><img src="<?php echo $userimage;?>" border="0"/></a>
                        <a href="<?php echo $homepagepath . 'profile/';?>" class="username"><?php echo $bp->loggedin_user->fullname;?></a></br>
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

                    <div>
                        <article class="post-0 bp_members type-bp_members status-publish hentry" id="post-0">
                            <div class="entry-content">
                                <div id="buddypress">
                                    <div id="item-header">
                                        <h4> Schedule a lesson</h4>
                                    </div><!-- #item-header -->
                                    <div class="height5"><!-- --></div>
                                    <div role="main" id="item-body">

                                        <div role="navigation" id="subnav" class="item-list-tabs no-ajax">
                                            <ul>
                                                <li id="friends-my-friends-personal-li"><a href="<?php echo  home_url(); ?>/schedule-request/" id="friends-my-friends">Requests</a></li>
                                                <li class="current selected" id="requests-personal-li"><a href="<?php echo  home_url(); ?>/schedule-request-accepted/" id="requests">Accepted</a></li>
                                                <li id="requests-personal-li"><a href="<?php echo  home_url(); ?>/sent-requests/" id="sent_requests">Request Sent</a></li>
                                            </ul>
                                        </div>

                                        <div id="np_message"></div>
                                        <?php if(!empty($approved_schedules)): ?>

                                        <?php
                                            foreach($approved_schedules as $schedule) :
                                                $requester = get_user_info($schedule->booked_user_id);
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
                                                    <div class="item-meta"><span class="activity"><?php echo $schedule->start_time; ?> - <?php echo $schedule->end_time; ?> <?php echo $time_batch->user_timezone; ?></span></div>
                                                </div>
                                            </li>

                                        </ul>

                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div id="errornotify"></div>
                                            <script type="text/javascript" language="javascript">
                                                jQuery("#errornotify").notification({caption: "Sorry, no records found.",type:"error",sticky:true});
                                            </script>
                                        <?php endif; ?>


                                    </div><!-- #item-body -->


                                </div><!-- #buddypress -->
                            </div><!-- .entry-content -->
                        </article><!-- #post -->
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
<?php
    get_footer();
?>



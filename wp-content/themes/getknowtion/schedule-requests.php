<?php
    /**
     * Template Name:  Schedule-requests
     */
    get_header();
    global $bp;
    $totalrequest=0;
    $current_loggedin_userid=get_current_user_id();
    require_once get_template_directory() . '/np_calender/calender.php';

    //check if search filter has any year request
    $search_year = !empty( $_REQUEST['sy'] ) ? stripslashes( $_REQUEST['sy'] ) : 0;
    $busy_dates = get_future_schedule_requests($current_loggedin_userid, $search_year);
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
                                                <li class="current selected" id="friends-my-friends-personal-li"><a href="<?php echo  home_url(); ?>/schedule-request/" id="friends-my-friends">Requests</a></li>
                                                <li id="requests-personal-li"><a href="<?php echo  home_url(); ?>/schedule-request-accepted/" id="requests">Accepted</a></li>
                                                <li id="requests-personal-li"><a href="<?php echo  home_url(); ?>/sent-requests/" id="sent_requests">Request Sent</a></li>
                                                <li id="requests-personal-li">
                                                    <div style="width: 265px;text-align: right">
                                                        <?php //np_year_search_form(); ?>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                    <?php if($busy_dates): ?>

                                        <?php
                                            foreach($busy_dates as $busy_date) :
                                                //echo '<pre>';print_r($busy_date);echo '</pre>';
                                            $batches = get_requested_schedules($current_loggedin_userid, $busy_date->schedule_date, $busy_date->batch_id);
                                                foreach($batches as $batch) :
                                                    $totalrequest++;
                                                    //echo '<pre>';print_r($batch);echo '</pre>';
                                                    $requester = get_user_info($batch->requester_id);
                                                    //echo '<pre>';print_r($batch->requester_id);echo '</pre>';

                                        ?>

                                        <ul role="main" class="item-list" id="schedule_requests">
                                            <li id="schedule_<?php echo $batch->requester_id.'_'.$batch->schedule_time_id;?>" class="schedule_time_<?php echo $batch->schedule_time_id;?>">
                                                <div class="clearboth" style="width: 100%;border-top:1px solid #939598;"><!-- --></div>
                                                <div class="height15"><!-- --></div>

                                                <div class="item-avatar">
                                                    <a href="<?php echo  home_url(); ?>/members/<?php echo $requester->user_nicename; ?>"><img width="50" height="50" alt="Profile picture of <?php echo $requester->display_name; ?>" class="avatar user-9-avatar avatar- photo" src="http://gravatar.com/avatar/<?php echo md5(strtolower(trim($requester->user_email))); ?>?d=mm&amp;s=50&amp;r=G"></a>
                                                </div>

                                                <div class="item">
                                                    <div class="item-title"><a href="<?php echo  home_url(); ?>/members/<?php echo $requester->user_nicename; ?>/"><?php echo $requester->display_name; ?></a></div>
                                                    <div class="item-meta"><span class="activity"><?php echo $busy_date->schedule_date; ?></span></div>
                                                    <div class="item-meta"><span class="activity"><?php echo $batch->start_time; ?> - <?php echo $batch->end_time; ?> <?php echo $batch->host_timezone; ?></span></div>

                                                    <?php if($batch->host_timezone != $batch->requester_timezone):?>
                                                    <div class="item-meta" style="margin-left: 65px"><span class="activity"><?php echo $batch->requester_start_time; ?> - <?php echo $batch->requester_end_time; ?> <?php echo $batch->requester_timezone; ?></span></div>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="action">
                                                    <a href="<?php echo  home_url(); ?>" class="button accept" data-batch_id="<?php echo $batch->batch_id;?>" data-requester_id="<?php echo $batch->requester_id; ?>" data-schedule_time_id="<?php echo $batch->schedule_time_id; ?>" >Accept</a> &nbsp;
                                                    <a href="<?php echo  home_url(); ?>" class="button reject" data-batch_id="<?php echo $batch->batch_id;?>" data-requester_id="<?php echo $batch->requester_id; ?>" data-schedule_time_id="<?php echo $batch->schedule_time_id; ?>" >Reject</a>

                                                </div>
                                            </li>

                                        </ul>

                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        <?php if($totalrequest<=0): ?>
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



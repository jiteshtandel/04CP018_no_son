<?php
    //global $bp;
    $viewtype='';
    if(isset($_GET['view']) && strlen($_GET['view'])>0){
        $viewtype=trim($_GET['view']);
    }
    $viewtype=($viewtype=="reviews") ? "reviews" : "posts";
    
    $userid=bp_displayed_user_id();
    $member_user_domain=bp_core_get_user_domain($userid);
    $loggedin_userid=bp_loggedin_user_id();
    $introductiontext=xprofile_get_field_data('About Me', $userid);
    $firstname=xprofile_get_field_data('First Name', $userid);
    $lastname=xprofile_get_field_data('Last Name', $userid);
    $fullname=strconcat(array($firstname,$lastname),' ');
    $languagespoken1=xprofile_get_field_data( 'Language Spoken 1', $userid);
    $languagespoken2=xprofile_get_field_data( 'Language Spoken 2', $userid);
    $languagespoken3=xprofile_get_field_data( 'Language Spoken 3', $userid);
    //Language Level 1
    $languagelearning1 = xprofile_get_field_data( 'Language Learning 1', $userid);
    $languagelearninglevel1 = xprofile_get_field_data( 'Language Level 1', $userid);

    if(strlen($languagelearning1)>0){    
        $languagelearning1=$languagelearning1 .' (' . $languagelearninglevel1 . ')';
    }
    else{
        $languagelearning1='';
    }

    $languagelearning2 = xprofile_get_field_data( 'Language Learning 2', $userid);
    $languagelearninglevel2 = xprofile_get_field_data( 'Language Level 2', $userid);

    if(strlen($languagelearning2)>0){    
        $languagelearning2=$languagelearning2 .' (' . $languagelearninglevel2 . ')';
    }
    else{
        $languagelearning1='';
    }

    $languagelearning3 = xprofile_get_field_data( 'Language Learning 3', $userid);
    $languagelearninglevel3 = xprofile_get_field_data( 'Language Level 3', $userid);

    if(strlen($languagelearning3)>0){    
        $languagelearning3=$languagelearning3 .' (' . $languagelearninglevel3 . ')';
    }
    else{
        $languagelearning3='';
    }
    $timezoneName=getusertimezonename($userid);
    $dateobj=settimezone($timezoneName);
    
    $from=new DateTime(xprofile_get_field_data( 'Birthday', $userid));
    $to=new DateTime('today');
    $age=$from->diff($to)->y;
    $gender=xprofile_get_field_data( 'Gender', $userid);
    $isonline=is_user_online($userid,10);
    $is_friend = bp_is_friend($userid);
    $friendshiptext="";
    $friendshiplink="";
    if ( empty( $is_friend ) )
        return false;

    switch ( $is_friend ) {
        case 'pending' :
            $friendshiptext="Cancel Request";
            $friendshiplink = wp_nonce_url( bp_loggedin_user_domain() . bp_get_friends_slug() . '/requests/cancel/' . $userid . '/', 'friends_withdraw_friendship' );
        break;

        case 'awaiting_response' :
            $friendshiptext="See Request";
            $friendshiplink = bp_loggedin_user_domain() . bp_get_friends_slug() . '/requests/';
        break;

        case 'is_friend' :
            $friendshiptext="Remove Friend";
            $link = wp_nonce_url( bp_loggedin_user_domain() . bp_get_friends_slug() . '/remove-friend/' . $userid . '/', 'friends_remove_friend' );
        break;

        default:
            $friendshiptext="Add Friend";
            $friendshiplink = wp_nonce_url( bp_loggedin_user_domain() . bp_get_friends_slug() . '/add-friend/' . $userid . '/', 'friends_add_friend' );
        break;
    }
    $ratingarr=getratingoverall($userid);
    
    // below line for video call
    $_SESSION['profileid'] = "id=" . $userid;
?>
<tr>
    <td valign="top" align="left" id="container">
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
            <tr>
                <td valign="top" align="left" id="content">
                    <div id="buddypress">
                        <script type="text/javascript" charset="utf-8">
                            usertocall = "<?php echo $_SESSION['profileid'];?>";
                        </script>
                        <?php do_action( 'template_notices' ); ?>
                        <div class="box-round-border">
                            <div class="profile-round-padding">
                                <div class="<?php echo ($isonline) ? "userpresence-online" : "userpresence-offline";?> pull-left"><!----></div>
                                <div class="member-profile-name pull-left"><?php echo $fullname;?></div>
                                <div class="member-overall-rating pull-left" style="margin: -3px 0px 0px 30px;width: auto;" overallrating="<?php echo $ratingarr['avgrating'];?>"></div>
                                <div class="pull-left" style="margin: -2px 0px 0px 5px;"><a href="<?php echo $member_user_domain ."?view=reviews";?>">(<?php echo $ratingarr['totalrating']; ?>)</a></div>
                                <div class="clearboth"></div>
                                <div class="full-width">
                                    <table class="full-width" cellspacing="0" cellpadding="0" border="0">
                                        <tr>
                                            <td valign="top" align="left" style="width: 182px;">
                                                <div style="padding-left: 20px;">
                                                    <div class="member-profile-pic"><?php bp_displayed_user_avatar( 'type=full' );?></div>
                                                    <div align="center">Time: <?php echo $dateobj->format('M d H:i (T)');?></div>
                                                </div>       
                                            </td>
                                            <td valign="top" align="left">
                                                <div class="member-profile-details">
                                            <?php if(strlen($introductiontext)>0){?>                                                    
                                                    <div class="member-profile-aboutme"><?php echo $introductiontext;?></div>
                                            <?php }?>                                                    
                                                    <div>Native Languages: <?php echo strconcat(array($languagespoken1,$languagespoken2,$languagespoken3),', ');?></div>
                                                    <div class="height2"><!-- --></div>
                                                    <div>Learning: <?php echo strconcat(array($languagelearning1,$languagelearning2,$languagelearning3),', ');?></div>
                                                    <div class="height2"><!-- --></div>
                                                    <div>Age: <?php echo $age;?></div>
                                                    <div class="height2"><!-- --></div>
                                                    <div>Sex: <?php echo $gender;?></div>
                                                    <div class="height2"><!-- --></div>
                                                    <div>From: <?php echo strconcat(array(xprofile_get_field_data('Native State',$userid),xprofile_get_field_data('Native Country',$userid)),', ');?></div>
                                                    <div class="height2"><!-- --></div>
                                                    <div>Current Location: <?php echo strconcat(array(xprofile_get_field_data('Current State',$userid),xprofile_get_field_data('Current Country',$userid)),', ');?></div>
                                                    <div class="height10"></div>
                                                    <div class="pull-right" style="margin-left: 18px;"><input type="button" name="message" onclick="myredirect('<?php echo bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . bp_core_get_username( $userid ); ?>');" value="Message"></div>
                                            <?php if($is_friend=='is_friend'){?>                                                    
                                                    <div class="pull-right"><input id="callbutton" type="button" name="videochat" value="Video Chat" style="background-color: #808080;"></div>
                                            <?php }?>                                                                                                       
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div style="height:12px"><!-- --></div>
                <?php if($is_friend!='is_friend'){?>                                    
                        <div class="member-add-connection-box">
                            <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;height: 100%;">
                                <tr>
                                <?php if($is_friend=='not_friends'){?>                                    
                                    <td valign="middle" align="center">Connect with <?php echo $firstname;?> to schedule a video chat & see what they shares</td>
                                    <td valign="top" align="right" style="width: 170px;"><a href="<?php echo $friendshiplink;?>"><img style="position: relative;right:-1px;top:13px;" src="<?php echo THEME_DIR.'/images/add-connection.jpg'?>" border="0"></a></td>   
                                <?php 
                                    } 
                                    if($is_friend=='pending'){ 
                                ?>
                                    <td valign="middle" align="center">You have already sent request to <?php echo $firstname;?></td>
                                    <td valign="top" align="right" style="width: 170px;"><img style="position: relative;right:-1px;top:13px;" src="<?php echo THEME_DIR.'/images/request-sent.jpg'?>" border="0"></td>   
                                <?php 
                                    } 
                                    if($is_friend=='awaiting_response'){ 
                                ?>
                                    <td valign="middle" align="center">User has already sent you a request</td>
                                    <td valign="top" align="right" style="width: 170px;"><img style="position: relative;right:-1px;top:13px;" src="<?php echo THEME_DIR.'/images/request-received.jpg'?>" border="0"></td>   
                                <?php 
                                    } 
                                ?>
                                </tr>
                            </table>
                        </div>
                <?php }?>                                                         
                        <div style="height:12px"><!-- --></div>
                        <div class="full-width">
                            <table class="full-width" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td valign="top" align="left" id="leftbar">
                                        <div class="member-myschedule-box">My Schedule</div>
                                        <div>
                                            <div id="datepicker_member"></div>
                                        </div>
                                <?php if ( bp_has_members('per_page=12&user_id=' . $userid) ) { ?>                                        
                                        <div class="height15"<!-- --></div>
                                        <div class="box-round-border">
                                            <div class="member-myconnection-box">
                                                <div class="pull-left">Connections</div>
                                                <div class="pull-right"><a class="footer-white-link small-font-11" href="<?php echo $member_user_domain . bp_get_friends_slug(); ?>">View all</a></div>
                                            </div>
                                
                                            <div class="member-connnection-list" align="left">
                                        <?php while ( bp_members() ) : bp_the_member(); ?>
                                                <a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar('type=thumb'); ?></a>
                                        <?php endwhile; ?>
                                            </div>
                                        </div>
                                <?php } ?>                                        
                                    </td>
                                    <td valign="top" align="left" id="memberprofile">
                                        <div class="member-posts-title-main">
                                            <div class="pull-left"><a href="<?php echo $member_user_domain;?>"><div class="member-posts-title <?php echo ($viewtype=="posts") ? 'meber-posts-selected' : "";?>">Posts</div></a></div>
                                            <div class="pull-left"><a href="<?php echo $member_user_domain .'?view=reviews';?>"><div class="member-posts-title <?php echo ($viewtype=="reviews") ? 'meber-posts-selected' : "";?>">Reviews</div></a></div>
                                        </div>
                                        <div class="clearboth"><!-- --></div>
                                        <div  class="activity" role="main">
                                    <?php 
                                        if($viewtype=="reviews") { 
                                            bp_get_template_part('members/single/member-reviews');
                                        }
                                        else { 
                                    ?>
                                            <?php do_action( 'bp_before_member_activity_content' ); ?>
                                            <?php bp_get_template_part('activity/member-activity-loop' ) ?>
                                            <?php do_action( 'bp_after_member_activity_content' ); ?>
                                    <?php }?>                                            
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    <div>
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

<?php

/**
 * BuddyPress - Members Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */
    $searcharr=array();
    $has_arg='';
    $current_loggedin_userid=bp_loggedin_user_id();
    if(isset($_POST['actionname']) && $_POST['actionname']=='searchmembers'){
        $recurrencecount=0;
        $nativespeaker=0;
        $languagespoken=trim($_POST['languagespoken']);
        $languagelearn=trim($_POST['languagelearning']);
        $searchterm=trim($_POST['searchterm']);
        $searchterm=(strtolower($searchterm)=='search') ? "" : $searchterm;
        if(isset($_POST['native'])){
            $nativespeaker=1;
        }

        if(strlen($_POST['age'])>0){
            $age=intval($_POST['age']);
            $searcharr['Birthday']=$age;
            $recurrencecount=$recurrencecount+1;
        }

        if(strlen($_POST['gender'])>0){
            $gender=trim($_POST['gender']);
            $searcharr['Gender']=$gender;
            $recurrencecount=$recurrencecount+1;
        }
        
        if($nativespeaker>0){
            //value ='%" . $field_value . "%';
            $searcharr['Native Country']=xprofile_get_field_data( 'Native Country', $current_loggedin_userid);
            $searcharr['Native State']=xprofile_get_field_data( 'Native State', $current_loggedin_userid);
            //$searcharr['Current Country']=xprofile_get_field_data('Current Country', $current_loggedin_userid);
            //$searcharr['Current State']=xprofile_get_field_data( 'Current State', $current_loggedin_userid);;
            if(strlen($searchterm)>0){
                $searcharr['First Name']=$searchterm;
                $searcharr['Last Name']=$searchterm;
                $searcharr['About Me']=$searchterm;
                $recurrencecount=$recurrencecount+1;
            }
            $recurrencecount=$recurrencecount+2;
        }
        else{
            if(strlen($searchterm)>0){
                $searcharr['Native Country']=$searchterm;
                $searcharr['Native State']=$searchterm;
                $searcharr['Current Country']=$searchterm;
                $searcharr['Current State']=$searchterm;
                $searcharr['First Name']=$searchterm;
                $searcharr['Last Name']=$searchterm;
                $searcharr['About Me']=$searchterm;
                $recurrencecount=$recurrencecount+1;
            }
        }
        
        if(strlen($languagespoken)>0){
            $searcharr['Language Spoken 1']=$languagespoken;
            $searcharr['Language Spoken 2']=$languagespoken;
            $searcharr['Language Spoken 3']=$languagespoken;
            
            $recurrencecount=$recurrencecount+1;
        }    
        if(strlen($languagelearn)>0){
            $searcharr['Language Learning 1']=$languagelearn;
            $searcharr['Language Learning 2']=$languagelearn;
            $searcharr['Language Learning 3']=$languagelearn;
            
            $recurrencecount=$recurrencecount+1;
        }
        if(!empty($searcharr)){
            $where_clause=build_members_where($searcharr,'');
            $has_arg=search_memmbers_query($where_clause,$recurrencecount);
            if(strlen($has_arg)>0){
                $has_arg='&include='.$has_arg;
            }
            else{
                $has_arg='&include=false';
            } 
        }
    } 
?>
<!--=== Script TAGS ===-->
<script src="<?php echo THEME_DIR;?>/js/pages/city-state.js" type="text/javascript"></script>
<script src="<?php echo THEME_DIR;?>/js/pages/members.js" type="text/javascript"></script>
<script src="<?php echo THEME_DIR; ?>/js/jquery/jquery.autocomplete.js" type="text/javascript" ></script>
<?php do_action( 'bp_before_members_loop' ); ?>
<?php if ( bp_has_members(bp_ajax_querystring('members').'&per_page=' . MEMBERS_PER_PAGE . '&exclude=1' . $has_arg)) : ?>
	<div id="pag-top" class="pagination">
            <div class="pag-count" id="member-dir-count-top">
                <?php bp_members_pagination_count(); ?>
            </div>
            <div class="pagination-links" id="member-dir-pag-top">
                <?php bp_members_pagination_links(); ?>
            </div>
	</div>
	<?php do_action( 'bp_before_directory_members_list' ); ?>
        <ul id="members-list" class="item-list" role="main">
	<?php while ( bp_members() ) : bp_the_member(); ?>
        <?php
            $userid=bp_get_member_user_id();
            $member_user_domain=bp_core_get_user_domain($userid);
            $is_friend=bp_is_friend($userid);
            $languagespoken1 = xprofile_get_field_data( 'Language Spoken 1', $userid);
            $languagespoken2 = xprofile_get_field_data( 'Language Spoken 2', $userid);
            $languagespoken3 = xprofile_get_field_data( 'Language Spoken 3', $userid);
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
                $languagelearning2='';
            }

            $languagelearning3 = xprofile_get_field_data( 'Language Learning 3', $userid);
            $languagelearninglevel3 = xprofile_get_field_data( 'Language Level 3', $userid);
            
            if(strlen($languagelearning3)>0){    
                $languagelearning3=$languagelearning3 .' (' . $languagelearninglevel3 . ')';
            }
            else{
                $languagelearning3='';
            }

            
            $from=new DateTime(xprofile_get_field_data( 'Birthday', $userid));
            $to=new DateTime('today');
            $isonline=is_user_online($userid,10);
            $ratingarr=getratingoverall($userid);
        ?>
            <li style="width: 100%;border-top:1px solid #939598;">
                <table cellpadding="0" cellspacing="0" border="0" style="width:100%;padding: 15px 0px 15px 0px;" id="search_reasult_content" align="left">
                        <tr>
                            <td valign="top" align="left" style="width:65px;" >
                                <a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar('type=thumb'); ?></a>
                            </td>
                            <td valign="top" align="left" style="width:150px;">
                                <div><a href="<?php echo $member_user_domain; ?>"><?php echo strconcat(array(xprofile_get_field_data('First Name', $userid),xprofile_get_field_data('Last Name', $userid)),' '); ?></a></div>
                                <div class="height2"><!-- ---></div>
                                <div class="star_rating_small" overallrating="<?php echo $ratingarr['avgrating'];?>"><!-- --></div>
                                <div><?php bp_member_profile_data('field=Gender');?>,&nbsp;<?php echo $from->diff($to)->y;?></div>
                                <div></div>
                                <div class="<?php echo ($isonline) ? 'greentext13' : 'greytext';?>"><?php echo ($isonline)? 'Online' : 'Offline';?></div>
                            </td>
                            <td valign="top" align="left" style="padding-right: 10px;">
                                <div><?php _e( 'Native Languages', 'knowtion' ); ?>: <?php echo strconcat(array($languagespoken1,$languagespoken2,$languagespoken3),', ');?></div>
                                <div><?php _e( 'Learning', 'knowtion' ); ?>: <?php echo strconcat(array($languagelearning1,$languagelearning2,$languagelearning3),', ');?></div>
                                <div><?php _e( 'From', 'knowtion' ); ?> <?php echo strconcat(array(xprofile_get_field_data('Native State',$userid),xprofile_get_field_data('Native Country',$userid)),', ');?></div>
                                <div><?php _e( 'Lives in', 'knowtion' ); ?> <?php echo strconcat(array(xprofile_get_field_data('Current State',$userid),xprofile_get_field_data('Current Country',$userid)),', ');?></div>    
                            </td>
                            <td valign="top" align="left" style="width: 120px;">
                                <div class="dropdown">
                                    <input  id="connect" name="connect" class="connect-arrow-btn" value="<?php _e( 'Connect', 'knowtion' ); ?>" type="button"  />
                                    <div class="submenu">
                                        <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
                                            <tr>
                                                <td class="popover-border-bottom"><!-- --></td>
                                                <td class="popover-top-arrow"><!-- --></td>
                                                <td class="popover-border-bottom" style="width: 12px;"><!-- --></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="popover-border-bottom popover-border-right popover-border-left popover-bg">
                                                    <ul class="root">
                                                <?php if($userid!=$current_loggedin_userid){?>                                                         
                                                        <li><a href="<?php echo bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . bp_core_get_username( $userid ); ?>"><?php _e( 'Message', 'knowtion' ); ?></a></li>
                                                <?php } else { ?>
                                                        <li class="optiondisabled"><?php _e( 'Message', 'knowtion' ); ?></li>
                                                <?php } ?>                                                         
                                                
                                                <?php if($is_friend=='is_friend'){?>                                                         
                                                        <li><a href="<?php echo $member_user_domain; ?>"><?php _e( 'Video Chat', 'knowtion' ); ?></a></li>
                                                <?php } else { ?>
                                                        <li class="optiondisabled"><?php _e( 'Video Chat', 'knowtion' ); ?></li>
                                                <?php } ?>                                                         
                                                        
                                                        <li><a href="<?php echo $member_user_domain; ?>"><?php _e( 'View Profile', 'knowtion' ); ?></a></li>
                                                        <li><a href="<?php echo $member_user_domain . bp_get_friends_slug(); ?>"><?php _e( 'View Connections', 'knowtion' ); ?></a></li>
                                                    </ul>                                                    
                                                </td>
                                            </tr>
                                        </table> 
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
            </li>
	<?php endwhile; ?>
        </ul>    
        <div style="border-top:1px solid #939598;" class="clearboth"><!-- --></div>

	<?php do_action( 'bp_after_directory_members_list' ); ?>

	<?php bp_member_hidden_fields(); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="member-dir-count-bottom">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-bottom">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( "Sorry, no members were found.", 'knowtion' ); ?></p>
	</div>

<?php endif; ?>

<?php do_action( 'bp_after_members_loop' ); ?>

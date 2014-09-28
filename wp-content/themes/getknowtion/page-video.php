<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 */
    get_header();    
    $profileid = trim($_SESSION['profileid']);
    $useroncall = intval($_GET['id']);
    if($useroncall){
        $profileid = "id=" . $useroncall;
    }
    
    if(!$profileid){
        die("Invalid Request");
    }
    
    $firstname=xprofile_get_field_data('First Name', $useroncall);
    $current_loggedin_userid=bp_loggedin_user_id();
    $isonline=is_user_online($useroncall,5);
    $useroncall_domain=bp_core_get_user_domain($useroncall);
?>   
   <tr>
   		<td>
        	<div class="vedio-top-bg">
                    <link type="text/css" rel="stylesheet" href="<?php echo get_stylesheet_directory_uri()."/css/popup.css";?>"/>
                    <script src="<?php echo THEME_DIR."/js/jquery/jquery.runner.js"; ?>" type="text/javascript" charset="utf-8"></script>
                    <script type="text/javascript" charset="utf-8">
                        useroncallname = "<?php echo $firstname;?>";
                        usertocall = "<?php echo $profileid;?>";
                        var useroncall_domain="<?php echo $useroncall_domain;?>";
                        jQuery(document).ready(function(){
                                callstatus = 2;
                                setTimeout(function(){
                                    publish();
                                }, 10000)
                        });
                    </script>
            	<table border="0" cellpadding="0" cellspacing="0" style="width:100%;table-layout:fixed;">
                    <tr>
                        
                        <td align="left" valign="middle" style="width:100%;height:39px;">
                            <div class="fonttime">&nbsp&nbsp;<span id="waitingmessage"><?php _e( 'Waiting for your conversation partner to join..', 'knowtion' ); ?></span></div>
                        </td>
                        <td align="right" valign="middle" style="width:154px;padding:0px 12px 0px 10px;">
                            <div id="endcall" class="btnbg" style="display:none;width:100px;">
                            	<input type="button" class="btn-on-off" value="<?php _e( 'End Call', 'knowtion' ); ?>" style="padding-left:40px;"/>
                            </div>                           
                        </td>
                    </tr>                                   
                </table>
            </div>
            <div class="chat-container">
            	<table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                    	<td>
                        	<table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="left" valign="top">
                                        <div id="callerCamera" class="box-vedio" align="center" style="background-image: url('<?php echo THEME_DIR."/images/user-image.png"; ?>');background-position:center center; background-repeat:no-repeat;background-color:#222222;">
                                        	
                                        </div>
                                        <div class="videousername">
                                            <div class="displaytable">
                                                <div class="tablerow">
                                                    <div class="tablecell" style="vertical-align: middle;"><div class="<?php echo ($isonline) ? "userpresence-online" : "userpresence-offline";?>"></div></div>
                                                    <div class="tablecell"><div class="font-username">&nbsp;<?php echo $firstname;?></div></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="width:20px;"><div style="width:20px;">&nbsp;</div></td>
                                    <td align="left" valign="top">
                                    	<div id="myCamera" style="width:340px;height:260px;background-image: url('<?php echo THEME_DIR."/images/box-audio.png"; ?>')">
                                        	
                                        </div>
                                        <div style="height:15px;">&nbsp;</div> 
                                        <div align="left" class="font-chat"><?php _e( 'YOUR CHAT', 'knowtion' ); ?></div>
                                        <div style="height:12px;">&nbsp;</div> 
                                        <div class="chat-massage-container">
                                        	<div id="messagecollector" class="massagebox"></div>
                                            <div style="padding:5px;float:left;">
                                            	<div class="input_chat_left">
                                                	<div class="input_chat_right">
                                                            <div class="input_chat_mid" style="padding-top:2px;">
                                                                <input id="messagebox" placeholder="<?php _e( 'Type your message here', 'knowtion' ); ?>" type="text" name="chatmassage" class="input_chat" style="background:none;border:none;color:#858585;line-height:21px;width:95%;"/>                                                        	
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="padding:5px;float:left;">
                                                <div class="btn-send"><input id="chatsendbutton" type="button" value="<?php _e( 'Send', 'knowtion' ); ?>" style="width:70px;height:35px;background-color: #808080;"/></div>
                                           </div>
                                           <div style="clear:both;"></div>
                                        </div>                                         
                                    </td>
                                </tr>
                            </table>
                        </td>                    
                    </tr>
                </table>          	
            </div>
        </td>
   </tr>
<?php
    get_footer();
?>
<div id="reviewbox">
    <div class="displaytable full-width">
        <div class="tablerow">
            <div align="left" id="popup_dragheader" class="tablecell" style="vertical-align: middle;"><div class="fonttime"><?php _e( 'Submit a Review', 'knowtion' ); ?></div></div>
            <div align="right" class="tablecell"><img src="<?php echo THEME_DIR.'/images/icons/popup-close.png';?>" onClick="hideReviewPopup();" style="cursor: pointer;"/></div>
        </div>
    </div>
    <div id="popupworkingarea">
        <div class="height15"><!-- --></div>
        <div id="popupnotify"></div>
        <form id="reviewform" name="reviewform" method="post">
            <input type="hidden" name="to_userid" id="to_userid" value="<?php echo $useroncall;?>"/>
            <input type="hidden" name="from_userid" id="from_userid" value="<?php echo $current_loggedin_userid;?>"/>
            <input type="hidden" name="sessionid" id="sessionid" value="12545454"/>
            <div>
                <textarea name="review" id="reviewtext" rows="5" cols="50"></textarea>
            </div>
            <div class="height15"><!-- --></div>
            <div class="displaytable full-width">
                <div  class="tablerow">
                    <div align="left" class="tablecell">
                        <div class="star_rating"></div>
                    </div>
                    <div align="right" class="tablecell"><input type="submit" name="reviewsubmit" id="submitreview" value="<?php _e( 'Submit', 'knowtion' ); ?>"></div>
                </div>
            </div>
        </form>
    </div>
</div>
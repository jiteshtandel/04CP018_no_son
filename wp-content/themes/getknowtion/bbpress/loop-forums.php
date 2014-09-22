<?php

/**
 * Forums Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_forums_loop' ); ?>
	<?php if (!bbp_is_forum_category()) : ?>
    	<?php bbp_breadcrumb(); ?>	
    	<?php do_action( 'bbp_template_before_forums_index' ); ?>
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr class="subforum-titlebar">
                    <td valign="middle" align="left" class="forums"><?php _e( 'FORUMS', 'knowtion' ); ?></td>
                    <td valign="middle" align="center" class="forums-topics"><?php _e( 'TOPICS', 'knowtion' ); ?></td>
                    <td valign="middle" align="center" class="forums-posts"><?php bbp_show_lead_topic() ? _e( 'REPLIES', 'knowtion' ) : _e( 'POSTS', 'knowtion' ); ?></td>
                    <td valign="middle" align="left" class="forums-lastposts"><?php _e( 'LAST POSTS', 'knowtion' ); ?></td>
                </tr>
            </table>
            <table border="0" cellspacing="0" cellpadding="0" width="100%" class="forum-border-lr">
            	<?php if ( bbp_has_forums() ) : ?>
					<?php do_action( 'bbp_template_before_forums_loop' ); ?>
                    <?php while ( bbp_forums() ) : bbp_the_forum(); ?>
                        <?php bbp_get_template_part( 'loop', 'single-forum' ); ?>
                    <?php endwhile; ?>
                    <?php do_action( 'bbp_template_after_forums_loop' ); ?>
                <?php else : ?>
					<?php bbp_get_template_part( 'feedback', 'no-forums' ); ?>
				<?php endif; ?>    
            </table>
		<?php do_action( 'bbp_template_after_forums_index' ); ?>
	<?php else: ?>
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr class="subforum-titlebar">
                    <td valign="middle" align="left" class="forums" style="text-transform:uppercase"><?php _e('SUB-FORUMS', 'knowtion' )?> : <?php bbp_forum_title(); ?></td>
                    <td valign="middle" align="center" class="forums-topics"><?php _e( 'TOPICS', 'knowtion' ); ?></td>
                    <td valign="middle" align="center" class="forums-posts"><?php bbp_show_lead_topic() ? _e( 'REPLIES', 'knowtion' ) : _e( 'POSTS', 'knowtion' ); ?></td>
                    <td valign="middle" align="left" class="forums-lastposts"><?php _e( 'LAST POSTS', 'knowtion' ); ?></td>
                </tr>
            </table>
            <table border="0" cellspacing="0" cellpadding="0" width="100%" class="forum-border-lr">
            <?php if ( bbp_has_forums() ) : ?>
                <?php while ( bbp_forums() ) : bbp_the_forum(); ?>
                    <?php bbp_get_template_part( 'loop', 'single-forum' ); ?>
                <?php endwhile; ?>
			<?php else : ?>
                <?php  bbp_get_template_part( 'feedback', 'no-forums' ); ?>
            <?php endif; ?>     
            </table>
            <table border="0" cellspacing="0" cellpadding="0" width="100%" class="forum-border-lr">
            	<tr>
                	<td valign="top" align="right" style="padding: 10px 15px 10px 25px">
					<?php if ( is_active_sidebar( 'search-forum' ) ) : ?>
                        <div id="secondary" class="widget-area" role="complementary">
                    <?php dynamic_sidebar( 'search-forum' ); ?>
                        </div>
                    <?php endif; ?>  
                    </td>
                </tr>
            </table>
		<?php
            if ( bbp_has_topics( array( 'author' => 0, 'order' => 'DESC', 'post_parent' => 'any'))):
                bbp_get_template_part( 'loop', 'subforum-recent-topics' );
            endif;
        ?>
	<?php endif; ?>
<?php do_action( 'bbp_template_after_forums_loop' ); ?>
<table border="0" cellspacing="0" cellpadding="0" width="100%" class="forum-border-lr">
    <tr><td colspan="2" class="gray-border-top4"></td></tr>
    <tr>
        <td valign="top" align="left" style="width:50%">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td valign="middle" align="left" class="best-conversation"><?php _e( 'BEST CONVERSATION STARTERS', 'knowtion' ); ?></td>
                </tr>
                <?php 
					$best_conversation_starter =  $wpdb->get_results(("SELECT COUNT(*) topic, post_author FROM {$wpdb->posts} INNER JOIN {$wpdb->users} ON {$wpdb->posts}.post_author={$wpdb->users}.ID WHERE {$wpdb->posts}.post_type LIKE '%topic%' AND {$wpdb->posts}.post_author NOT IN (1) GROUP BY post_author ORDER BY topic DESC LIMIT 5"));
					if ( !empty( $best_conversation_starter ) && !is_wp_error( $best_conversation_starter ) ) {
						foreach ( $best_conversation_starter as $key=>$best_starter ) { 
						$userid= intval($best_starter->post_author);
				?>
                <tr>
                	<td style="padding:5px 0px 5px 25px;">
                        <div class="rankno"><?php echo $key+1;?></div>
                        <div class="best-user-pic"><a href="<?php echo bp_core_get_user_domain($userid); ?>"><?php echo get_avatar( $userid, 25);?></a></div>
                        <div class="best-username"><?php echo bp_core_get_userlink( $userid );?></div>
                        <div class="blacktext12 padding-top10"><?php echo intval($best_starter->topic); ?>  <?php _e( 'Topics', 'knowtion' ); ?></div>
                    </td>
                </tr>	
                <?php	} 
					}else{?>
                <tr>
                    <td style="padding:10px 0 10px 25px;">
                        <div  style="width:275px;">
                            <p><?php _e('No Best Conversation Starter were found here!', 'knowtion' ); ?></p>
                        </div>
                    </td>
                </tr>        			
				<?php		
					}
				?>
            </table>
        </td>
        <td valign="top" align="left" style="width:50%">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td valign="middle" align="left" class="most-active"><?php _e('MOST ACTIVE EXPERTS', 'knowtion' ); ?></td>
                </tr>
                <?php 
					$most_active_expert =  $wpdb->get_results(("SELECT COUNT(*) reply, post_author FROM {$wpdb->posts} INNER JOIN {$wpdb->users} ON {$wpdb->posts}.post_author={$wpdb->users}.ID WHERE {$wpdb->posts}.post_type LIKE '%reply%' AND {$wpdb->posts}.post_author NOT IN (1) GROUP BY post_author ORDER BY reply DESC LIMIT 5"));
					if ( !empty( $most_active_expert ) && !is_wp_error( $most_active_expert ) ) {
						foreach ( $most_active_expert as $key=>$most_active ) { 
						$userid= intval($most_active->post_author);?>
                <tr>
                	<td style="padding:5px 0px 5px 25px;">
                        <div class="rankno"><?php echo $key+1;?></div>
                        <div class="best-user-pic"><a href="<?php echo bp_core_get_user_domain( $userid); ?>"><?php echo get_avatar( $userid, 25);?></a></div>
                        <div class="best-username"><?php echo bp_core_get_userlink( $userid );?></div>
                        <div class="blacktext12 padding-top10"><?php echo intval($most_active->reply); ?> <?php _e('Reply', 'knowtion' ); ?></div>
                    </td>
                </tr>	
                <?php	} 
					}else{?>
                <tr>
                    <td style="padding:10px 0 10px 25px;">
                        <div style="width:275px;">
                            <p><?php _e('No Most Active Experts were found here!', 'knowtion' ); ?></p>
                        </div>
                    </td>
                </tr>        			
				<?php		
					}
				?>
            </table>
        </td>
    </tr>
    <tr>
    	<td align="left" class="gray-border-top-1" style="padding:3px 3px 3px 25px;">
         <?php if(!empty( $best_conversation_starter )){ ?><a href="<?php echo HOME_URL.'/best-conversation-starters'?>" class="see-more-top-knowtions"><?php _e('See More Knowtions', 'knowtion' ); ?>.. &NestedGreaterGreater;</a><?php } ?>
        </td>    
        <td align="left" class="gray-border-top-1" style="padding:3px 3px 3px 25px;">
         <?php if(!empty( $most_active_expert )){ ?> <a href="<?php echo HOME_URL.'/most-active-experts'?>" class="see-more-top-knowtions"><?php _e('See More Knowtions', 'knowtion' ); ?>.. &NestedGreaterGreater;</a><?php } ?>
        </td> 
    </tr>
    <tr><td colspan="2" class="gray-border-bottom-1"></td></tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%" class="forum-border-lr">
    <tr><td valign="middle" align="left" class="who-online gray-border-top4" colspan="2"><?php _e('WHO IS ONLINE', 'knowtion' ); ?></td></tr>
    <tr>
        <td valign="middle" align="left" class="user-online">
        	
            <?php if ( bp_has_members('type=online')) : ?>
                <?php $count=0; 
					while ( bp_members() ) : bp_the_member();
						$exclude_ids = array(1); 
						if (!in_array(bp_get_member_user_id(), $exclude_ids)) :
							$count++;
						endif; 
					endwhile; 
				?>              
                <div class="padding-bottom5"><?php echo $count; ?> <?php _e( 'users online!', 'knowtion' ); ?></div>
                <div class="avatar-block">
                    <?php while ( bp_members() ) : bp_the_member(); ?>
                        <?php $exclude_ids = array(1); 
                            if (!in_array(bp_get_member_user_id(), $exclude_ids)) :
						   // if( !in_array( bp_get_member_user_login(), get_super_admins() ) ) :
                        ?>
                            <div class="best-user-pic">
                                <a href="<?php bp_member_permalink() ?>" title="<?php bp_member_name() ?>"><?php bp_member_avatar(); ?></a>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="widget-error">
                    <?php _e( 'There are no users currently online', 'knowtion' ) ?>
                </div>
            <?php endif; ?>
        </td>
    </tr>
    <tr><td colspan="2" class="forum-border-bottom"></td></tr>
</table> 


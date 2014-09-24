<?php

/**
 * Template Name: bbPress - Best Conversation Starters
 *
 * @package bbPress
 * @subpackage Theme
 */


get_header(); ?>
<tr> 
    <td valign="top" align="left" id="container">
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
            <tr>
                <td valign="top" align="left" id="content">
                    <div>
                    	<div style="float:left;">
                        	<h1 class="entry-title"><?php the_title(); ?></h1>
                        </div>
                        <div align="left" style="padding-top:3px;">
                            <div class="view-your-posts" style="float: right;"><a class="greentext12" href="<?php echo bp_core_get_user_domain(bp_loggedin_user_id()) . "forums"; ?>"><?php _e( 'View Your Posts', 'knowtion' ); ?></a></div>
                            <div style="float: right;"><a class="greentext12" href="<?php echo site_url(); ?>/unanswered-post"><?php _e( 'Unanswered Post', 'knowtion' ); ?></a></div>
                            <!--<div class="view-post-since" style="float:left;"><a href="#" class="greentext12">View Posts Since Last Visit</a></div>-->
                        </div>
						<div class="clearboth"></div>
                        <?php bbp_breadcrumb(); ?>	
						<div class="entry-content clearboth">
                            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                <tr class="subforum-titlebar">
                                    <td valign="middle" align="left" class="forums"><?php _e( 'BEST CONVERSATION STARTERS', 'knowtion' ); ?></td>
                                    <td valign="middle" align="center"><?php _e( 'TOPICS', 'knowtion' ); ?></td>
                                </tr>
                            </table>    
                        <?php 
							global $wpdb, $paged;
							//$user_id = (is_super_admin() && get_current_user_id()>0) ? get_current_user_id() : 0;
							$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
							$post_per_page =  (intval(get_query_var('posts_per_page'))>0) ? intval(get_query_var('posts_per_page')) : PER_PAGE_RECORDS;
							$offset =  ($paged - 1)*$post_per_page;
							// query normal post
							$best_conversation_starter_query =  "SELECT COUNT(*) topic, post_author FROM {$wpdb->posts} INNER JOIN {$wpdb->users} ON {$wpdb->posts}.post_author={$wpdb->users}.ID WHERE {$wpdb->posts}.post_type LIKE '%topic%' AND {$wpdb->posts}.post_author NOT IN (1) GROUP BY post_author ORDER BY topic DESC ";
							//query the posts with pagination
							$best_conversation_starter = $best_conversation_starter_query . " LIMIT ".$offset.", ".$post_per_page."; ";
							$best_conversation_starter_results = $wpdb->get_results( $best_conversation_starter, OBJECT);
						
							//RUN QUERY TO COUNT THE RESULT LATER
							$total_result = $wpdb->get_results($best_conversation_starter_query, OBJECT );
							$total_count = count($total_result);
							$max_num_pages = ceil( $total_count / $post_per_page );
						?>
                        	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="forum-border-lr">	
                        <?php
							if ( !empty( $best_conversation_starter_results ) && !is_wp_error( $best_conversation_starter_results ) ) {	
								foreach ( $best_conversation_starter_results as $best_starter ) { 
									$userid= intval($best_starter->post_author);
						?>
                        		<tr>
                        			<td valign="middle" align="center" class="forums gray-border-bottom-1" style="padding:5px 0px 5px 20px;">
										<div class="rankno"><?php echo $offset+=1;?></div>
                                        <div class="best-user-pic"><a href="<?php echo bp_core_get_user_domain($userid); ?>"><?php echo get_avatar( $userid, 25);?></a></div>
                                        <div class="best-username" style="width:0px;"><?php echo bp_core_get_userlink( $userid );?></div>
                                    </td>
        							<td valign="middle" align="center" class="gray-border-bottom-1"	>
                                        <div class="blacktext12"><?php echo intval($best_starter->topic); ?> <?php _e( 'Topics', 'knowtion' ); ?></div>
                                    </td>
                        		</tr>		
                        <?php				
								}
							}
						    else{
						?>
                        		 <tr>
                                    <td style="padding:10px 0 10px 25px;">
                                        <p><?php _e( 'No Best Conversation Starter were found here!', 'knowtion' ); ?></p>
                                    </td>
                                </tr>		
						<?php		
							}
						?> 
                        		 <tr><td colspan="2" class="forum-border-bottom"></td></tr>      
                            </table>
                        </div>
                        <div class="padding-top10" style="float:right;" id="bbpress">
                            <?php if($max_num_pages>0){wpex_pagination($max_num_pages);} ?>
                        </div>
                    </div>
               </td>
               <td valign="top" align="left" id="rightbar">
                    <?php get_sidebar('forums');?> 
               </td>
            </tr>
        </table>
    </td>
</tr>
<?php get_footer(); ?>
<?php

/**
 * Template Name: bbPress - Top Contributors
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
                                    <td valign="middle" align="left" class="forums"><?php _e( 'TOP CONTRIBUTORS', 'knowtion' ); ?></td>
                                    <td valign="middle" align="center" class="posts"><?php _e( 'TOPICS', 'knowtion' ); ?></td>
                                    <td valign="middle" align="center" class="posts"><?php _e( 'REPLIES', 'knowtion' ); ?></td>
                                </tr>
                            </table>    
                        <?php 
							global $wpdb, $paged;
							
							$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
							$post_per_page =  2 ;//(intval(get_query_var('posts_per_page'))>0) ? intval(get_query_var('posts_per_page')) : 10;
							$offset =  ($paged - 1)*$post_per_page;
							// query normal post
							$top_contributors_query =  "SELECT SUM(CASE WHEN {$wpdb->posts}.`post_type` LIKE '%topic%' THEN 1 ELSE 0 END) AS topic, SUM(CASE WHEN {$wpdb->posts}.`post_type` LIKE '%reply%' THEN 1 ELSE 0 END) AS reply,{$wpdb->posts}.post_author FROM {$wpdb->posts} INNER JOIN {$wpdb->users} ON {$wpdb->posts}.post_author={$wpdb->users}.ID WHERE {$wpdb->posts}.post_author NOT IN (1) GROUP BY {$wpdb->posts}.post_author ORDER BY topic DESC, reply DESC, post_author ASC ";
							//query the posts with pagination
							$top_contributors = $top_contributors_query . " LIMIT ".$offset.", ".$post_per_page."; ";
							$top_contributors_results = $wpdb->get_results( $top_contributors, OBJECT);
						
							//RUN QUERY TO COUNT THE RESULT LATER
							$total_result = $wpdb->get_results($top_contributors_query, OBJECT );
							$total_count = count($total_result);
							$max_num_pages = ceil( $total_count / $post_per_page );
						?>
                        	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="forum-border-lr">	
                        <?php
							if ( !empty( $top_contributors_results ) && !is_wp_error( $top_contributors_results ) ) {	
								foreach ( $top_contributors_results as $top_contributer_user) { 
									$userid= intval($top_contributer_user->post_author);
						?>
                        		<tr>
                        			<td valign="middle" align="center" class="forums gray-border-bottom-1" style="padding:5px 0px 5px 20px;">
										<div class="rankno"><?php echo $offset+=1;?></div>
                                        <div class="best-user-pic"><a href="<?php echo bp_core_get_user_domain($userid); ?>"><?php echo get_avatar($userid, 25);?></a></div>
                                        <div class="best-username" style="width:0px;"><?php echo bp_core_get_userlink( $userid );?></div>
                                    </td>
        							<td valign="middle" align="center" class="gray-border-bottom-1 posts">
                                        <div class="blacktext12"><?php echo intval($top_contributer_user->topic); ?> <?php _e( 'Topics', 'knowtion' ); ?></div>
                                    </td>
                                    <td valign="middle" align="center" class="gray-border-bottom-1 posts">
                                        <div class="blacktext12"><?php echo intval($top_contributer_user->reply); ?> <?php _e( 'Reply', 'knowtion' ); ?></div>
                                    </td>
                        		</tr>		
                        <?php				
								}
							}
						    else{
						?>
                        		 <tr>
                                    <td style="padding:10px 0 10px 25px;">
                                        <p><?php _e( 'No Top Contributer were found here!', 'knowtion' ); ?></p>
                                    </td>
                                </tr>		
						<?php		
							}
						?> 
                        		 <tr><td colspan="3" class="forum-border-bottom"></td></tr>      
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
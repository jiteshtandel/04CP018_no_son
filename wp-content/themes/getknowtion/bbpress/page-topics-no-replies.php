<?php

/**
 * Template Name: bbPress - Topics (No Replies)
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
						<?php do_action( 'bbp_before_main_content' ); ?>
                        <?php do_action( 'bbp_template_notices' ); ?>
						<?php while ( have_posts() ) : the_post(); ?>
                            <div id="topics-front" class="bbp-topics-front">
                                <div style="float:left;"><h1 class="entry-title"><?php the_title(); ?></h1></div>
                                <div align="left" style="padding-top:3px;">
                                    <div class="view-your-posts" style="float: right;"><a class="greentext12" href="<?php echo bp_core_get_user_domain(bp_loggedin_user_id()) . "forums"; ?>"><?php _e( 'View Your Posts', 'knowtion' ); ?></a></div>
                                    <div style="float: right;"><a class="greentext12" href="<?php echo site_url(); ?>/unanswered-post"><?php _e( 'Unanswered Post', 'knowtion' ); ?></a></div>
                                    <!--<div class="view-post-since" style="float:left;"><a href="#" class="greentext12">View Posts Since Last Visit</a></div>-->
                                </div>
                                <div class="clearboth"></div>
                                <?php bbp_breadcrumb(); ?>
                                <div class="entry-content">
                                    <?php the_content(); ?>
                                    <div id="bbpress-forums">
                                        <?php bbp_set_query_name( 'bbp_no_replies' ); ?>
                                        <?php if ( bbp_has_topics( array( 'meta_key' => '_bbp_reply_count', 'meta_value' => '1', 'meta_compare' => '<', 'orderby' => 'date', 'show_stickies' => false ) ) ) : ?>
                                            <?php bbp_get_template_part( 'pagination', 'topics'    ); ?>
                                            <?php bbp_get_template_part( 'loop',       'topics'    ); ?>
                                            <?php bbp_get_template_part( 'pagination', 'topics'    ); ?>
                                        <?php else : ?>
                                            <div class="clearboth">
                                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                   <tr class="subforum-titlebar">
                                                        <td valign="middle" align="left" style="width: 45%;" class="topics padding-left25"><?php _e( 'TOPICS', 'knowtion' ); ?></td>
                                                        <td valign="middle" align="center" class="posts"><?php _e( 'VOICES', 'knowtion' ); ?></td>
                                                        <td valign="middle" align="center" class="posts"><?php bbp_show_lead_topic() ? _e( 'REPLIES', 'knowtion' ) : _e( 'POSTS', 'knowtion' ); ?></td>
                                                        <td valign="middle" align="left" class="lastposts"><?php _e( 'LAST POSTS', 'knowtion' ); ?></td>
                                                    </tr>
                                                </table>
                                                <table border="0" cellspacing="0" cellpadding="0" width="100%" class="forum-border-lr">	
                                                    <tr>
                                                        <td style="padding:10px 0 10px 25px;">
                                                            <p><?php _e( ' No Unanswered topics were found here!.', 'bbpress' ); ?></p>
                                                        </td>
                                                    </tr>
                                                     <tr><td colspan="2" class="forum-border-bottom"></td></tr>  
                                                </table>
                                            </div>
                                        <?php endif; ?>
                                        <?php bbp_reset_query_name(); ?>
                                    </div>
                                </div>
                            </div><!-- #topics-front -->
						<?php endwhile; ?>
						<?php do_action( 'bbp_after_main_content' ); ?>
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

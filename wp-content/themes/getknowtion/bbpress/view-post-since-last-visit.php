<?php

/**
 * Template Name: bbPress - View Post Since Last Visit.
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
                    <div align="left">
                        <div style="float: left;"><a class="greentext12" href="<?php echo site_url(); ?>/unanswered-post">Unanswered Post</a></div>
                        <div class="view-your-posts" style="float: left;"><a class="greentext12" href="<?php echo bp_core_get_user_domain(bp_loggedin_user_id()) . "forums"; ?>">View Your Posts</a></div>
                        <!--<div class="view-post-since" style="float:left;"><a href="#" class="greentext12">View Posts Since Last Visit</a></div>-->
                    </div>
                    <div class="clearboth"></div>
                    <div>
						<?php do_action( 'bbp_before_main_content' ); ?>
                        <?php do_action( 'bbp_template_notices' ); ?>
						<?php while ( have_posts() ) : the_post(); ?>
                            <div id="topics-front" class="bbp-topics-front">
                                <h1 class="entry-title"><?php the_title(); ?></h1>
                                <div class="entry-content">
                                    <?php the_content(); ?>
                                    <div id="bbpress-forums">
                                        <?php bbp_breadcrumb(); ?>
                                        
                                        <?php bbp_set_query_name( 'bbp_no_replies' ); ?>
										<?php 
											$year = date( 'Y' );
											$year = date( 'Y' );
										?>
                                        <?php if ( bbp_has_topics( array('meta_query'=> array( 'year' => $year, '&w' => $week )  , 'orderby' => 'date', 'show_stickies' => false ) ) ) : ?>
                                            <?php bbp_get_template_part( 'pagination', 'topics'    ); ?>
                                            <?php bbp_get_template_part( 'loop',       'topics'    ); ?>
                                            <?php bbp_get_template_part( 'pagination', 'topics'    ); ?>
                                        <?php else : ?>
                                            <?php bbp_get_template_part( 'feedback',   'no-topics' ); ?>
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

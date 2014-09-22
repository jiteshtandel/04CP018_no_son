<?php

/**
 * Template Name: bbPress - Forums (Index)
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
                        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?><?php the_content(); ?><?php endwhile; ?><?php endif; ?>
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
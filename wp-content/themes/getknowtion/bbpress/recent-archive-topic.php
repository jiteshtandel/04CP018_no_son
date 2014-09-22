<?php

/**
 * Template Name: bbPress - Recent-Archive-Topic
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
                    <div style="float:left;">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </div>
                    <div align="left" style="padding-top:3px;">
                        <div class="view-your-posts" style="float: right;"><a class="greentext12" href="<?php echo bp_core_get_user_domain(bp_loggedin_user_id()) . "forums"; ?>"><?php _e( 'View Your Posts', 'knowtion' ); ?></a></div>
                        <div style="float: right;"><a class="greentext12" href="<?php echo site_url(); ?>/unanswered-post"><?php _e( 'Unanswered Post', 'knowtion' ); ?></a></div>
                        <!--<div class="view-post-since" style="float:left;"><a href="#" class="greentext12">View Posts Since Last Visit</a></div>-->
                    </div>
                    <div class="clearboth"></div>
                    <div>
                        <div id="bbpress-forums">
                            <?php bbp_breadcrumb(); ?>
                        
                            <?php if ( bbp_is_topic_tag() ) bbp_topic_tag_description(); ?>
                        
                            <?php do_action( 'bbp_template_before_topics_index' ); ?>
                        
                            <?php if ( bbp_has_topics() ) : ?>
                        
                                <?php bbp_get_template_part( 'pagination', 'topics'    ); ?>
                        
                                <?php bbp_get_template_part( 'loop',       'topics'    ); ?>
                        
                                <?php bbp_get_template_part( 'pagination', 'topics'    ); ?>
                        
                            <?php else : ?>
                        
                                <?php bbp_get_template_part( 'feedback',   'no-topics' ); ?>
                        
                            <?php endif; ?>
                        
                            <?php do_action( 'bbp_template_after_topics_index' ); ?>
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

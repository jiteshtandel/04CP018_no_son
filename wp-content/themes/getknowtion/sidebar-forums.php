<?php
/*
 * This is forums Sidebar
 */
?>
    <script src="<?php echo THEME_DIR; ?>/js/bbpress/forum.js" type="text/javascript" language="javascript"></script>
    <div class="knowtion-community"><?php _e( 'The Knowtion Community', 'knowtion' ); ?></div>
    <div class="height15"><!-- --></div>
    <?php get_sidebar('suggestedknowtion');?>
    <div class="clearboth"></div>
    <div class="lang-categories"><?php _e( 'CATEGORIES', 'knowtion' ); ?></div>
    <div id="languages">
		<?php if ( bbp_has_forums( array('show_stickies' => false, 'post_parent' => 0,  'post_type' => bbp_get_forum_types() , 'posts_per_page' => 5 ) ) ):   ?>
            <?php while ( bbp_forums() ) : bbp_the_forum(); ?>
                    <div class="lm_link_container lm_has_sub">
                        <div class="lm_link">
                            <div style="float: left" class="icon lm_arrow"></div>
                            <?php do_action( 'bbp_theme_before_forum_title' ); ?>
                            <div class="language-title"><?php bbp_forum_title(); ?></div>
                            <?php do_action( 'bbp_theme_after_forum_title' ); ?>
                            <div class="clearboth"></div>
                        </div>    
                        <div class="language-subcategory">
                            <?php do_action( 'bbp_theme_before_forum_description' ); ?>
                            <div class="language-subcategory"><a class="bbp-forum-title" href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_content(); ?></a></div>
                             <?php do_action( 'bbp_theme_after_forum_description' ); ?>
                        </div>
                    </div>
            <?php endwhile; ?>
        <?php else : ?>
                <?php bbp_get_template_part( 'feedback', 'no-forums' ); ?>
        <?php endif; ?>
       
    </div>
    <div class="lang-categories"><?php _e( 'TOP CONTRIBUTORS', 'knowtion' ); ?></div>
    <div>
	<?php 
		$user_id = (is_super_admin() && get_current_user_id()>0) ? get_current_user_id() : 0;
		$top_contributers =  $wpdb->get_results(("SELECT SUM(CASE WHEN {$wpdb->posts}.`post_type` LIKE '%topic%' THEN 1 ELSE 0 END) AS topic, SUM(CASE WHEN {$wpdb->posts}.`post_type` LIKE '%reply%' THEN 1 ELSE 0 END) AS reply,{$wpdb->posts}.post_author FROM {$wpdb->posts} INNER JOIN {$wpdb->users} ON {$wpdb->posts}.post_author={$wpdb->users}.ID WHERE {$wpdb->posts}.post_author NOT IN (1) GROUP BY {$wpdb->posts}.post_author ORDER BY topic DESC, reply DESC, post_author ASC LIMIT 15"));
		if ( !empty( $top_contributers ) && !is_wp_error( $top_contributers ) ) {
			foreach ( $top_contributers as $key=>$top_contributer_user) {
				$userid= intval($top_contributer_user->post_author);
	?>
    	<div class="best-user-pic"><a href="<?php echo bp_core_get_user_domain($userid); ?>"><?php echo get_avatar($userid, 25);?></a></div>		 
	<?php		
			}
	?>
    	<div align="left" class="clearboth"><a class="see-more-top-knowtions" href="<?php echo HOME_URL.'/top-contributors/';?>"><?php _e( 'More', 'knowtion' ); ?> ≫</a></div>		
	<?php }else{
	?>
        <div>
            <?php _e( 'No Top Contributer were found here!', 'knowtion' ); ?>
        </div>	
    <?php } ?>
        <div class="clearboth"></div>
    </div>
    <div>
    	<?php if ( is_active_sidebar('sidebar-recent-activity-widget' ) ) : ?>
            <div id="secondary" class="widget-area" role="complementary">
                <?php dynamic_sidebar('sidebar-recent-activity-widget' ); ?>
            </div><!-- #secondary -->
        <?php endif; ?>
    </div>
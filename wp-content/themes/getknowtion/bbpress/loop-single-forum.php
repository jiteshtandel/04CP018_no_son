<?php

/**
 * Forums Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
    <tr class="subforum-row blacktext12" id="bbp-forum-<?php bbp_forum_id(); ?>">
        <td valign="middle" align="left" class="forums forums-padding">
			<div style="float:left;"><img src="<?php bloginfo('template_directory'); ?>/images/forum-add-icon2.png" width="22" height="29"></div>
            <div class="margin-left35">
				<?php do_action( 'bbp_theme_before_forum_title' ); ?>
                <div><a class="bbp-forum-title" href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a></div>
                <?php do_action( 'bbp_theme_after_forum_title' ); ?>
                <?php do_action( 'bbp_theme_before_forum_description' ); ?>
                <div><?php bbp_forum_content(); ?></div>
                <?php do_action( 'bbp_theme_after_forum_description' ); ?>
            </div>
            <div class="clearboth"></div>
        </td>
        <td valign="middle" align="center" class="forums-topics forums-padding"><?php bbp_forum_topic_count(); ?></td>
        <td valign="middle" align="center" class="forums-posts forums-padding"><?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?></td>
        <td valign="middle" align="left" class="forums-lastposts forums-padding">
			<?php do_action( 'bbp_theme_before_forum_freshness_link' ); ?>
            <?php bbp_forum_freshness_link(); ?>
            <?php do_action( 'bbp_theme_after_forum_freshness_link' ); ?>
        </td>
    </tr>
    <tr>
        <td valign='top' align='left' colspan="4" class="forums-topic-arrow">
        	<?php do_action( 'bbp_theme_before_forum_sub_forums' ); ?>
                <div class="forums-topic">
					<?php
                        bbp_list_forums(array(
                            'before' => '<ul id="bbp-forum-'.bbp_get_forum_id().'" '.bbp_get_forum_class().'>',
                            'after' => '</ul>',
                            'link_before' => '<li class="subforums-topics blacktext12"><div class="circledarrow"><img src="'.THEME_DIR.'/images/circledarrow.png" width="20" height="20"></div>',
                            'link_after' => '</li>',
                            'separator' => '',
                            'forum_id' => '',
                            'show_topic_count' => false,
                            'show_reply_count' => false,
                        ), 'list_forums' );
                    ?>
            	</div>
			<?php do_action( 'bbp_theme_after_forum_sub_forums' ); ?>	
            <?php bbp_forum_row_actions(); ?>
        </td>
    </tr>
    <tr><td colspan="4" class="gray-border-bottom-1"></td></tr>



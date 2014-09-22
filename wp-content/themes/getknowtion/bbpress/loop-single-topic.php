<?php

/**
 * Topics Loop - Single
 *
 * @package bbPress
 * @subpackage Theme
 */

?>


<tr class="subforum-row blacktext12" id="bbp-topic-<?php bbp_topic_id(); ?>">
    <td valign="middle" align="left" style="width: 300px;" class="subforum padding-top5">
        <div style="float: left;margin: 5px 10px 0px 0px;"><img width="17" height="22" src="<?php bloginfo('template_directory'); ?>/images/topic-icon.png"></div>
        <div style="margin-left: 26px;">
            <div>
				<?php do_action( 'bbp_theme_before_topic_title' ); ?>
                <a class="bbp-topic-permalink" href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a>
                <?php do_action( 'bbp_theme_after_topic_title' ); ?>
            </div>
            <div>
				<?php do_action( 'bbp_theme_before_topic_started_by' ); ?>
                <span class="bbp-topic-started-by"><?php printf( __( 'Started by: %1$s', 'knowtion' ), bbp_get_topic_author_link( array( 'size' => '14' ) ) ); ?></span>
                <?php do_action( 'bbp_theme_after_topic_started_by' ); ?>	
            </div>
        </div>
        <div class="clearboth"></div>
    </td>
    <td valign="middle" align="center" class="posts padding-top5"><?php bbp_topic_voice_count(); ?></td>
    <td valign="middle" align="center" class="posts padding-top5"><?php bbp_show_lead_topic() ? bbp_topic_reply_count() : bbp_topic_post_count(); ?></td>
    <td valign="middle" align="left" class="lastposts padding-top5">
        <div>
			<?php do_action( 'bbp_theme_before_topic_freshness_link' ); ?>
			<?php bbp_topic_freshness_link(); ?>
			<?php do_action( 'bbp_theme_after_topic_freshness_link' ); ?>
        </div>
        <div>
        	<?php do_action( 'bbp_theme_before_topic_freshness_author' ); ?>
			<!--<span class="bbp-topic-freshness-author"><?php bbp_author_link( array( 'post_id' => bbp_get_topic_last_active_id(), 'size' => 14 ) ); ?></span>-->
            <span class="bbp-topic-freshness-author"><?php printf( __( 'by: %1$s', 'knowtion' ), bbp_get_topic_author_link( array( 'size' => '14' ) ) ); ?></span>
			<?php do_action( 'bbp_theme_after_topic_freshness_author' ); ?>	
        </div>
    </td>
</tr>
<tr><td class="gray-border-bottom-1 padding-top5" colspan="4"></td></tr>

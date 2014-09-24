<?php

/**
 * Replies Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>



<?php do_action( 'bbp_template_before_replies_loop' ); ?>


<table width="100%" cellspacing="0" cellpadding="0" border="0" id="topic-<?php bbp_topic_id(); ?>-replies">
    <tr>
        <td valign="middle" align="left" class="topic-title"><?php _e( 'Topic: ', 'knowtion' ); ?><?php bbp_topic_title(); ?></td>
    </tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="forum-border-lr">
	<?php if ( bbp_thread_replies() ) : ?>
        <?php bbp_list_replies(); ?>
    <?php else : ?>
        <?php while ( bbp_replies() ) : bbp_the_reply(); ?>
            <?php bbp_get_template_part( 'loop', 'single-reply' ); ?>
        <?php endwhile; ?>
    <?php endif; ?>
</table>




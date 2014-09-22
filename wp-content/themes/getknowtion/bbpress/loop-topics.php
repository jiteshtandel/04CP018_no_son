<?php

/**
 * Topics Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_topics_loop' ); ?>
<div class="clearboth"></div>
<div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
       <tr class="subforum-titlebar">
            <td valign="middle" align="left" style="width: 45%;" class="topics padding-left25"><?php _e( 'TOPICS', 'knowtion' ); ?></td>
            <td valign="middle" align="center" class="posts"><?php _e( 'VOICES', 'knowtion' ); ?></td>
            <td valign="middle" align="center" class="posts"><?php bbp_show_lead_topic() ? _e( 'REPLIES', 'knowtion' ) : _e( 'POSTS', 'knowtion' ); ?></td>
            <td valign="middle" align="left" class="lastposts"><?php _e( 'LAST POSTS', 'knowtion' ); ?></td>
        </tr>
    </table>
</div>
<div class="forum-border-lr">    
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<?php while ( bbp_topics() ) : bbp_the_topic(); ?>
            <?php bbp_get_template_part( 'loop', 'single-topic' ); ?>
        <?php endwhile; ?>
        <tr><td class="forum-border-bottom" colspan="4"></td></tr>       
    </table>
</div>
<div class="padding-bottom10"><!-- --></div>
<?php do_action( 'bbp_template_after_topics_loop' ); ?>
<?php

/**
 * Topics Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php
	
	$forum_ids = bbp_forum_query_subforum_ids (bbp_get_forum_id());
	$forum_id_cnt = count($forum_ids);
	$counter=0;
?>

<?php do_action( 'bbp_template_before_topics_loop' ); ?>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
   <tr class="subforum-titlebar">
        <td valign="middle" align="left" style="width: 45%;" class="topics padding-left25"><?php _e( 'TOPICS', 'knowtion' ); ?></td>
        <td valign="middle" align="center" class="posts"><?php _e( 'VOICES', 'knowtion' ); ?></td>
        <td valign="middle" align="center" class="posts"><?php bbp_show_lead_topic() ? _e( 'REPLIES', 'knowtion' ) : _e( 'POSTS', 'knowtion' ); ?></td>
        <td valign="middle" align="left" class="lastposts"><?php _e( 'LAST POSTS', 'knowtion' ); ?></td>
    </tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="forum-border-lr">
    <?php
	
		if($forum_id_cnt>0){
			for ($n=0;$n < $forum_id_cnt; $n++) {
				if ( bbp_has_topics( array( 'author' => 0, 'show_stickies' => false, 'order' => 'DESC','post_parent' => $forum_ids[$n]))) {
					while ( bbp_topics() ) : bbp_the_topic();
						$counter++;
						if($counter<=5) {
							bbp_get_template_part( 'loop', 'single-topic' );
						}
						else {
							break;
						}
					endwhile;
				}
			}
			if($counter>0){
	?>
		<tr><td colspan="4" align="right" valign="middle" class="topics-show-more"><a href="<?php echo HOME_URL.'/forums-topics'?>" class="see-more-top-knowtions"><?php _e( 'Show More', 'knowtion' ); ?> &NestedGreaterGreater;</a></td></tr>
	<?php } else{ ?>
		<tr><td colspan="4" style="padding:10px 0 10px 25px;"><?php _e( 'No Topics were found here!', 'knowtion' ); ?></td></tr>
	<?php	}
		}	?> 
</table>
<?php do_action( 'bbp_template_after_topics_loop' ); ?>
	



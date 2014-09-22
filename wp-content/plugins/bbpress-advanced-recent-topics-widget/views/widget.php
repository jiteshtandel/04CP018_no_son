<?php
/*  The output of the Widget   */
?>



	<?php	$i=0;
                while ($widget_query->have_posts()) :
                $i++;
		$widget_query->the_post();
		$topic_id = bbp_get_topic_id($widget_query->post->ID);
		$author_link = bbp_get_topic_author_link(array('post_id'=>$topic_id, 'type'=>'avatar', 'size'=>25));
		$author_name = bbp_get_topic_author_link(array('post_id'=>$topic_id, 'type'=>'name'));
		$forum_id = bbp_get_topic_forum_id($topic_id); ?>
        
        <div>
                        <?php 
				if ($show_user) :
					echo '<div class="bbp_show_user">' . $author_link . '</div>';
				endif;
			?>
                <div>
			<?php
                if ($show_user) {
            ?>                                            
                <div class="recent-post-username">
                        <div><?php echo $author_name;?></div>
					<?php if ($show_date) { ?>
						<div class="recent-post-date clearboth" align="left">
                        	<?php 
									$last_active = get_post_meta( $topic_id, '_bbp_last_active_time', true );
									if ( empty( $last_active ) ) {
										$reply_id = bbp_get_topic_last_reply_id( $topic_id );
										if ( !empty( $reply_id ) ) {
											$last_active = get_post_field('post_date', $reply_id);
										} else {
											$last_active = get_post_field('post_date', $topic_id );
										}
									}
								
							?>
                            <?php echo date ('j F', strtotime($last_active)) //bbp_topic_post_date($topic_id,10,2);?>
						</div>
					<?php } ?>					
				</div>
			<?php } ?>					
                    <div class="recent-post clearboth">
                        <div class="padding-bottom5"><a class="bbp-forum-title" href="<?php bbp_topic_permalink($topic_id); ?>" title="<?php bbp_topic_title($topic_id); ?>"><?php bbp_topic_title($topic_id); ?></a></div>
                        <div><a class="greentext12" href="<?php bbp_topic_permalink($topic_id); ?>" ><?php _e( 'Show Comments', 'knowtion' ); ?> (<?php echo bbp_update_topic_reply_count($topic_id); ?>)</a></div>
                    </div>
                </div>
        </div>
   <?php	endwhile; ?>
    <?php if($i>0){?>
<div align="left"><a href="<?php echo HOME_URL.'/recent-activity/';?>" class="see-more-top-knowtions"><?php _e( 'More', 'knowtion' ); ?> ≫</a></div>
    <?php }
        else{
    ?>
    		<?php _e( 'Sorry, there was no Activity found. ', 'knowtion' ); ?>
            
    <?php        
        }
    ?>


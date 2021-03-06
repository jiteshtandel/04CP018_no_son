<?php 
    $currentactionscope=(bp_current_action()=="friends") ? "friends" : "just-me";
    $activitycount=0;
?>

<?php do_action( 'bp_before_activity_loop' ); ?>
    
    <?php if ( bp_has_activities( bp_ajax_querystring( 'activity' ).'&scope=' . $currentactionscope . '&action=activity_update&per_page=' . PER_PAGE_RECORDS) ) { ?>

	<?php /* Show pagination if JS is not enabled, since the "Load More" link will do nothing */ ?>
	<noscript>
		<div class="pagination">
			<div class="pag-count"><?php bp_activity_pagination_count(); ?></div>
			<div class="pagination-links"><?php bp_activity_pagination_links(); ?></div>
		</div>
	</noscript>

	<?php if ( empty( $_POST['page'] ) ) : ?>

		<ul id="activity-stream" class="activity-list item-list">

	<?php endif; ?>

	<?php while ( bp_activities() ) : bp_the_activity(); ?>
		<?php 
                    $activitycount++;
                    bp_get_template_part( 'activity/entry' ); 
                ?>

	<?php endwhile; ?>

	<?php if ( bp_activity_has_more_items() ) : ?>

		<li class="load-more">
			<a href="#more"><?php _e( 'Load More', 'knowtion' ); ?></a>
		</li>

	<?php endif; ?>

	<?php if ( empty( $_POST['page'] ) ) : ?>

		</ul>

	<?php endif; ?>

    <?php     
        }
        if($activitycount==0){
    ?>

	<div id="message" class="box-round-border info clearboth ">
            <div class="member-post">
		<?php _e( 'Sorry, there was no activity found.', 'knowtion' ); ?>
            </div>
	</div>

    <?php } ?>

<?php do_action( 'bp_after_activity_loop' ); ?>

<?php if ( empty( $_POST['page'] ) ) : ?>

	<form action="" name="activity-loop-form" id="activity-loop-form" method="post">

		<?php wp_nonce_field( 'activity_filter', '_wpnonce_activity_filter' ); ?>

	</form>

<?php endif; ?>
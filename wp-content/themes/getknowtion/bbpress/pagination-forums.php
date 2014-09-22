<?php

/**
 * Pagination for pages of forums (when viewing a forum)
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_pagination_loop' ); ?>

<div class="bbp-pagination">
	<div class="bbp-pagination-count">
		<?php bbp_subforum_pagination_count(); ?>
	</div>
	<div class="bbp-pagination-links">
		<?php //bbp_subforum_pagination_links(); ?>
        <?php bbp_forum_pagination_links();?>
	</div>
</div>

<?php do_action( 'bbp_template_after_pagination_loop' ); ?>

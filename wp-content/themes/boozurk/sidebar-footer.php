<?php
/**
 * sidebar-footer.php
 *
 * Template part file that contains the footer widget area
 *
 * @package Boozurk
 * @since 1.00
 */
?>

<!-- here should be the footer widget area -->
<?php
	/* The footer widget area is triggered if any of the areas have widgets. */
	if ( ! is_active_sidebar( 'first-footer-widget-area' ) && ! is_active_sidebar( 'second-footer-widget-area' ) && ! is_active_sidebar( 'third-footer-widget-area'  ) && ! is_active_sidebar( 'fourth-footer-widget-area' ) )
		return;
?>

<?php boozurk_hook_sidebars_before( 'footer' ); ?>

<div id="footer-widget-area">

	<?php boozurk_hook_sidebar_top( 'footer' ); ?>

	<div id="first_fwa" class="widget-area">
			<?php if ( is_active_sidebar( 'first-footer-widget-area' ) ) { dynamic_sidebar( 'first-footer-widget-area' ); } ?>
	</div><!-- #first .widget-area -->

	<div id="second_fwa" class="widget-area">
			<?php if ( is_active_sidebar( 'second-footer-widget-area' ) ) { dynamic_sidebar( 'second-footer-widget-area' ); } ?>
	</div><!-- #second .widget-area -->

	<div id="third_fwa" class="widget-area">
			<?php if ( is_active_sidebar( 'third-footer-widget-area' ) ) { dynamic_sidebar( 'third-footer-widget-area' ); } ?>
	</div><!-- #third .widget-area -->

	<?php boozurk_hook_sidebar_bottom( 'footer' ); ?>

</div><!-- #footer-widget-area -->

<?php boozurk_hook_sidebars_after( 'footer' ); ?>

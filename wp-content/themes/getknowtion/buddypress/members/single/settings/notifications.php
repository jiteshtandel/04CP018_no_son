<h4><?php _e( 'Notification Settings', 'buddypress' ); ?></h4>
<?php do_action( 'bp_before_member_settings_template' ); ?>
<?php do_action( 'template_notices' ); ?>
<form action="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/notifications'; ?>" method="post" class="standard-form" id="settings-form">
        <div class="height10"><!-- --></div>
	<p><?php _e( 'Send an email notice when:', 'buddypress' ); ?></p>

	<?php do_action( 'bp_notification_settings' ); ?>

	<?php do_action( 'bp_members_notification_settings_before_submit' ); ?>

	<div class="submit">
		<input type="submit" name="submit" value="<?php esc_attr_e( 'Save Changes', 'buddypress' ); ?>" id="submit" class="auto" />
	</div>

	<?php do_action( 'bp_members_notification_settings_after_submit' ); ?>

	<?php wp_nonce_field('bp_settings_notifications' ); ?>

</form>

<?php do_action( 'bp_after_member_settings_template' ); ?>

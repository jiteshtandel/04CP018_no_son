<?php 
    do_action( 'bp_before_activity_entry' ); 
?>

<li class="<?php bp_activity_css_class(); ?>" id="activity-<?php bp_activity_id(); ?>">
    <div class="activity-content">
            <?php if ( bp_activity_has_content() ) : ?>
                    <div class="activity-inner member-post">
                        <?php bp_activity_content_body(); ?>
                    </div>
            <?php endif; ?>

            <?php do_action( 'bp_activity_entry_content' ); ?>

            <div class="activity-meta member-post-comment">

                    <?php if ( bp_get_activity_type() == 'activity_comment' ) : ?>

                            <a href="<?php bp_activity_thread_permalink(); ?>" class="button view bp-secondary-action" title="<?php esc_attr_e( 'View Conversation', 'knowtion' ); ?>"><?php _e( 'View Conversation', 'knowtion' ); ?></a>

                    <?php endif; ?>

                    <?php if ( is_user_logged_in() ) : ?>

                            <?php if ( bp_activity_can_comment() ) : ?>

                                    <a href="<?php bp_activity_comment_link(); ?>" class="button acomment-reply bp-primary-action" id="acomment-comment-<?php bp_activity_id(); ?>"><?php printf( __( 'Comment ( <span>%s</span>)', 'knowtion' ), bp_activity_get_comment_count() ); ?></a>

                            <?php endif; ?>

                            <?php if ( bp_activity_user_can_delete() ) bp_activity_delete_link(); ?>

                            <?php do_action( 'bp_activity_entry_meta' ); ?>

                    <?php endif; ?>
            </div>
            <div class="activity-time member-post-comment">
                    <?php echo bp_core_time_since( bp_get_activity_date_recorded() ); ?>
                    <?php //bp_activity_action(); ?>
            </div>
    </div>

    <?php do_action( 'bp_before_activity_entry_comments' ); ?>

    <?php if ( ( is_user_logged_in() && bp_activity_can_comment() ) || bp_is_single_activity() ) : ?>

            <div class="activity-comments">

                    <?php bp_activity_comments(); ?>

                    <?php if ( is_user_logged_in() ) : ?>

                            <form action="<?php bp_activity_comment_form_action(); ?>" method="post" id="ac-form-<?php bp_activity_id(); ?>" class="ac-form"<?php bp_activity_comment_form_nojs_display(); ?>>
                                    <div class="ac-reply-avatar"><?php bp_loggedin_user_avatar( 'width=' . BP_AVATAR_THUMB_WIDTH . '&height=' . BP_AVATAR_THUMB_HEIGHT ); ?></div>
                                    <div class="ac-reply-content">
                                            <div class="ac-textarea">
                                                    <textarea id="ac-input-<?php bp_activity_id(); ?>" class="ac-input" name="ac_input_<?php bp_activity_id(); ?>"></textarea>
                                            </div>
                                            <input type="submit" name="ac_form_submit" value="<?php esc_attr_e( 'Post', 'knowtion' ); ?>" /> &nbsp; <a href="#" class="ac-reply-cancel"><?php _e( 'Cancel', 'knowtion' ); ?></a>
                                            <input type="hidden" name="comment_form_id" value="<?php bp_activity_id(); ?>" />
                                    </div>

                                    <?php do_action( 'bp_activity_entry_comments' ); ?>

                                    <?php wp_nonce_field( 'new_activity_comment', '_wpnonce_new_activity_comment' ); ?>

                            </form>

                    <?php endif; ?>

            </div>

    <?php endif; ?>

    <?php do_action( 'bp_after_activity_entry_comments' ); ?>

</li>

<?php do_action( 'bp_after_activity_entry' ); ?>

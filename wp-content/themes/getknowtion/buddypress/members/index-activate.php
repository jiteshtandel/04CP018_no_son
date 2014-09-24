<?php get_header('prelogin');?>
            <tr>
                <td align="left" valign="top" style="background-color:#fff;">
                    <div style="padding:25px 0px 38px 40px;">
                        <div id="buddypress">
                            <?php do_action( 'bp_before_activation_page' ); ?>
                            <div class="page" id="activate-page">
                                <?php do_action( 'bp_before_activate_content' ); ?>
                                
                                <?php if ( bp_account_was_activated() ) : ?>
                        
                                    <?php if ( isset( $_GET['e'] ) ) : ?>
                                        <p><?php _e( 'Your account was activated successfully. Your account details have been sent to you in a separate email.', 'knowtion' ); ?></p>
                                    <?php else : ?>
                                        <p><?php printf( __( 'Your account was activated successfully. You can now <a href="%s">log in</a> with the username and password you provided when you signed up.', 'knowtion' ), HOME_URL); ?></p>
                                    <?php endif; ?>
                        
                                <?php else : ?>
                                    <p><?php _e( 'Please provide a valid activation key.', 'knowtion' ); ?></p>
                                                <?php do_action( 'template_notices' ); ?>                            
                                    <form action="" method="get" class="standard-form" id="activation-form">
                                        <label for="key"><?php _e( 'Activation Key:', 'knowtion' ); ?></label>
                                        <input type="text" name="key" id="key" value="" />
                                        <p class="submit">
                                                            <input type="submit" name="submit" value="<?php _e( 'Activate', 'knowtion' ); ?>" />
                                        </p>
                        
                                    </form>
                        
                                <?php endif; ?>
                        
                                <?php do_action( 'bp_after_activate_content' ); ?>
                        
                            </div><!-- .page -->
                        
                            <?php do_action( 'bp_after_activation_page' ); ?>
                        
                        </div><!-- #buddypress -->                    
					</div>
                </td>
            </tr>
<?php get_footer('prelogin' ); ?>
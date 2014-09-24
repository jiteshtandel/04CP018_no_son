<?php
/*
* Template Name: Login Page
* This template is to customize login page
* 
*/
?>
<?php 
    get_header('prelogin');
    while ( have_posts() ) : the_post();
        $video_shortcode=get_field('video_shortcode');
        $maindescription=get_the_content();
    endwhile;
?>
            <tr>
                <td align="left" valign="top" class="blackboardbg">
                	<table cellpadding="0" cellspacing="0" border="0">
                    	<tr>
                        	<td valign="top">
                            	<div class="unlocktextblock">
                                    <h6><?php _e('//unlock how you learn','knowtion');?></h6>
                                    <div class="videoblock">
                                        <?php echo do_shortcode($video_shortcode);?>
                                    </div>
                                </div>
                            </td>
                        	<td valign="top">
                            	<div class="logindetailsblock" align="right">
                                    <?php
                                            $args = array(
                                            'echo' => true,
                                            'redirect' => '', 
                                            'form_id' => 'loginform',
                                            'label_username' => __( 'Username','knowtion' ),
                                            'label_password' => __( 'Password','knowtion' ),
                                            'label_remember' => __( 'REMEMBER ME','knowtion'),
                                            'label_log_in' => __( 'Log In' ),
                                            'id_username' => 'user_login',
                                            'id_password' => 'user_pass',
                                            'id_remember' => 'rememberme',
                                            'id_submit' => 'wp-submit',
                                            'remember' => true,
                                            'value_username' => 'Username',
                                            'value_remember' => false );
                                    ?>
                                    <?php                                            
                                        if(isset($_GET['login']) && $_GET['login'] == 'failed'){
                                    ?>
                                        <div id="notification" style="margin:0px 0px 10px 60px;"></div>
                                        <script type="text/javascript" language="javascript">
                                            jQuery("#notification").notification({caption: "Invalid credentials. Please try again.",type:"warning",sticky:true});
                                        </script>
                                    <?php
                                        }										
                                        else if(isset($_GET['action']) && $_GET['action'] == 'reset_pwd'){
                                    ?>
                                        <div id="notification" style="margin:0px 0px 10px 60px;"></div>
                                        <script type="text/javascript" language="javascript">
                                            jQuery("#notification").notification({caption: "Password reset successfully.",type:"information",sticky:false,hidedelay:1500});
                                        </script>
                                    <?php
                                        }										
                                        wp_login_form( $args );
                                    ?>
                                    <div align="right" style="padding:10px 0px 0px 0px;">
                                        <span><?php _e('Need an account','knowtion');?>?</span> <a href="<?php echo get_permalink( get_page_by_title( 'register' ) );?>" class="signuplink"><?php _e('SIGN UP','knowtion');?></a> | 
                                        <a class="nodecorationlink" href="forgot-password" title="Lost Password"><?php _e('Forgot Password?','knowtion');?></a>
                                    </div>								
                                </div>
                            </td>
                        </tr>	
                    </table>
                </td>
            </tr>
            <tr>
                <td align="left" class="plaingreebg" style="height:26px;"><!-- --></td>
            </tr>
            <tr>
                <td align="left" valign="top" style="background-color:#fff;">
                    <div style="padding:48px 0px 38px 40px;">
                        <div class="logincontentmain">
                            <div style="display:table-row">
                                <div class="loginbodydesc">
                                    <?php _e('Break the confines of traditional learning.','knowtion');?><Br />
                                    <?php _e('Utilize and connect with knowledge','knowtion');?><Br />
                                    <?php _e('around the globe.','knowtion');?>
                                </div>
                                <div align="right" class="traditionalcontainer">
                                    <div class="traditionaltext">
                                        <div><img src="<?php bloginfo('template_directory'); ?>/images/traditional-learning.jpg" alt="traditional-learning" border="0" /></div>
                                        <div  align="center"><?php _e('traditional learning','knowtion');?></div>
                                    </div>
                                    <div class="learningversus">
                                        <img src="<?php bloginfo('template_directory'); ?>/images/learning-versus.jpg" alt="learning-versus" border="0" />
                                    </div>
                                    <div class="independenttext">
                                        <div><img src="<?php bloginfo('template_directory'); ?>/images/independent-learning.jpg" alt="independent-learning" border="0" /></div>
                                        <div class="independenttext" align="center"><?php _e('independent learning','knowtion');?></div>
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>
                    <!--<div class="slashseparator"></div>-->
                    <div class="logincontentdesc" align="left"><?php echo $maindescription;?></div>
                </td>
            </tr>
<?php get_footer('prelogin' ); ?>
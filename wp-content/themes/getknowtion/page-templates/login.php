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
                                    <h6>//unlock how you learn</h6>
                                    <div class="videoblock">
                                        <?php echo do_shortcode($video_shortcode);?>
                                        
                                        <!--<video id="MY_VIDEO_1" class="video-js vjs-default-skin" controls
                                            preload="auto" width="530" height="219" poster="<?php bloginfo('template_directory'); ?>/images/poster.jpg"
                                            data-setup="{}">
                                            <source src="http://video-js.zencoder.com/oceans-clip.mp4" type='video/mp4'>
                                            <source src="http://video-js.zencoder.com/oceans-clip.webm" type='video/webm'>
                                       </video>-->
                                    </div>
                                </div>
                            </td>
                        	<td valign="top">
                            	<div class="logindetailsblock" align="right">
                                    <?php
                                            $args = array(
                                            'echo' => true,
                                            'redirect' => 'http://localhost/wordpress/members/', 
                                            'form_id' => 'loginform',
                                            'label_username' => __( 'Username' ),
                                            'label_password' => __( 'Password' ),
                                            'label_remember' => __( 'REMEBER ME' ),
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
                                        <span>Need an account?</span> <a href="<?php echo get_permalink( get_page_by_title( 'register' ) );?>" class="signuplink">SIGN UP</a> | 
                                        <a class="nodecorationlink" href="forgot-password" title="Lost Password">Forgot Password?</a>
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
                                    Break the confines of traditional learning.<Br />Utilize and connect with knowledge<br /> around the globe.
                                </div>
                                <div align="right" class="traditionalcontainer">
                                    <div class="traditionaltext">
                                        <div><img src="<?php bloginfo('template_directory'); ?>/images/traditional-learning.jpg" alt="traditional-learning" border="0" /></div>
                                        <div  align="center">traditional learning</div>
                                    </div>
                                    <div class="learningversus">
                                        <img src="<?php bloginfo('template_directory'); ?>/images/learning-versus.jpg" alt="learning-versus" border="0" />
                                    </div>
                                    <div class="independenttext">
                                        <div><img src="<?php bloginfo('template_directory'); ?>/images/independent-learning.jpg" alt="independent-learning" border="0" /></div>
                                        <div class="independenttext" align="center">independent learning</div>
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
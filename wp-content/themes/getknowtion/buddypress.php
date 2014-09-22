<?php
    global $bp;
    if (!is_user_logged_in()) {
        get_header('prelogin');
    }
    else{
        get_header();
    }
    require_once get_template_directory() . '/np_calender/calender.php';
    $homepagepath=$bp->loggedin_user->domain;
?>
<tr>
    <td valign="top" align="left" id="container">
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
            <tr>
                <td valign="top" align="left" id="leftbar">
                    <div class="userinfo">
                        <a href="<?php echo $bp->displayed_user->domain . 'profile/';?>"><?php bp_displayed_user_avatar( 'type=thumb' );?></a>
                        <a href="<?php echo $bp->displayed_user->domain . 'profile/';?>" class="username"><?php echo $bp->loggedin_user->fullname;?></a></br>
                        <a href="<?php echo $bp->displayed_user->domain . 'profile/edit';?>" class="edit-profile">Edit Profile</a>
                        <div class="clearboth"></div>
                    </div>    
                    <div class="left-site-menu">
                        <ul class="menu-items">
                            <li class="page-item">
                                <a href="<?php echo $homepagepath;?>">Home</a>
                            </li>
                            <li class="page-item">
                                <a href="#calender-container" class="manage_calender fancybox">Manage my calender</a>
                            </li>
                             <li class="page-item">
                                <a href="<?php echo HOME_URL; ?>/schedule-request">Schedule a lesson</a>
                            </li>
                             <li class="page-item">
                                 <a href="<?php echo HOME_URL; ?>/forums">Forums</a>
                            </li>
                        </ul>
                    </div>
                    <div class="gray-border-bottom">&nbsp;</div>
                    <?php get_sidebar('faq');?>
                </td>
                <td valign="top" align="left" id="content">
                    <div>
                        <?php /* The loop */ ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                        <div class="entry-content">
                                            <?php the_content(); ?>
                                            <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
                                        </div><!-- .entry-content -->
                                    </article><!-- #post -->
                            <?php endwhile; ?>
                    </div><!-- #content -->
                </td>
            </tr>
        </table>
    </td>
</tr>
<?php
    if (!is_user_logged_in()) {
        get_footer('prelogin');
    }
	else{
        get_footer();
	}
?>

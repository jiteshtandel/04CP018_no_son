<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 */
    get_header('prelogin');    
?>
    <tr>
        <td align="left" valign="top" style="background-color:#fff;">
            <div style="padding:25px 40px 38px 40px;">
                <div id="page" role="main">
                    <?php /* The loop */ ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                                        <header class="entry-header">
                                            <?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
                                            <div class="entry-thumbnail">
                                                    <?php the_post_thumbnail(); ?>
                                            </div>
                                            <?php endif; ?>

                                        <h3 class="entry-title"><?php the_title(); ?></h3>
                                        </header><!-- .entry-header -->
                                        <div class="height10"><!-- --></div>        
                                        <div class="entry-content">
                                            <?php the_content(); ?>
                                            <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
                                        </div><!-- .entry-content -->

                                <?php //comments_template(); ?>
                        <?php endwhile; ?>
                </div><!-- #content -->
            </div>
        </td>
    </tr>
<?php
    get_footer('prelogin');
?>
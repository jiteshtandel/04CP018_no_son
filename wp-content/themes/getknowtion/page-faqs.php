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
                    <?php while ( have_posts() ) : the_post(); ?>
                        <header class="entry-header">
                            <h3 class="entry-title"><?php the_title(); ?></h3>
                        </header><!-- .entry-header -->
                    <?php endwhile; ?>
                </div><!-- #content -->
<?php
        $args = array( 'posts_per_page' => 0, 'order'=> 'asc', 'orderby' => 'date', 'post_status' => 'publish','cat'=>4 );
        $postslist = get_posts( $args );
        if( have_posts()){
            echo '<ol class="faqslist">';
            foreach ( $postslist as $post ){
                setup_postdata( $post ); 
?> 
                    <li id="<?php echo $post->ID;?>">
                        <div class="faq-title"><?php the_title(); ?></div>
                        <div><?php the_content(); ?></div>
                        <div class="height10"><!-- --></div>
                    </li>
<?php                    
            }                    
            wp_reset_postdata();
            echo '</ol>';
        }
?>                
                
            </div>
        </td>
    </tr>
<?php
    get_footer('prelogin');
?>
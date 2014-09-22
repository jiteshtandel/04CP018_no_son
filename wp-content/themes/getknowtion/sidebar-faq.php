<?php
/*
 * This is FAQ Sidebar
 */
?>
<div style="padding:15px 0 25px 5px;">
    <div class="sub-title-15">FAQ</div>
<?php
        $args = array( 'posts_per_page' => 3, 'orderby' => 'rand','cat'=>4,'post_status' => 'publish' );
        $rand_posts = get_posts( $args );        
        if( have_posts()){
            echo '<ul class="faq-questions">';
            foreach ( $rand_posts as $post ){
                setup_postdata( $post ); 
?> 
                    <li><a target="_blank" href="<?php echo site_url() . "/faqs#" . $post->ID;?>" style="color:#000;"><?php the_title(); ?></a></li>
<?php                    
            }                    
            wp_reset_postdata();
            echo '</ul>';
        }
?>          
</div>
<div class="widget">
        <div id="datepicker_secondary"></div>
</div>     



<?php
    $item_per_page=PER_PAGE_RECORDS;
    //sanitize post value
    $page_number=intval($_POST["page"]);
    $nextpage=$page_number+1;
    
    //get current starting point of records
    $position = ($page_number * $item_per_page);
    $userid=bp_displayed_user_id();
    
    $totalreviews=$wpdb->get_var( $wpdb->prepare("SELECT count(*) FROM usersreview WHERE to_userid = %d", $userid));    
    
    $querystr="SELECT rating,review,from_userid,creationdate FROM usersreview WHERE to_userid=$userid ORDER BY creationdate DESC limit $position, $item_per_page";
    $reviewsresult=$wpdb->get_results($querystr, OBJECT);
    
    $lastpage = ceil($totalreviews/$item_per_page); //lastpage.
?>
<?php if ($reviewsresult): ?>
    <?php if ( $page_number==0 ) { ?>
            <ul id="activity-stream" class="activity-list item-list">
    <?php } ?>
    
        <?php 
            foreach ($reviewsresult as $reviewobj){
              $from_userid=$reviewobj->from_userid;  
              $from_displayname=bp_core_get_user_displayname( $from_userid );
              $from_userdomain=bp_core_get_user_domain( $from_userid ); 
        ?>
                <li>
                    <div>
                        <div class="activity-inner member-post activity-comments">
                            <div class="acomment-avatar">
                                <a href="<?php echo $from_userdomain; ?>" 
                                title="<?php echo $from_displayname; ?>">
                                <?php echo bp_core_fetch_avatar ( array( 'item_id' => $from_userid, 'type' => 'thumb' ) ) ?>
                                </a>
                            </div>
                            <div class="acomment-meta" style="font-size: 100%;">
                                <a href="<?php echo $from_userdomain;?>"><?php echo $from_displayname;?></a>&nbsp;<span class="time-since"><?php echo bp_core_time_since($reviewobj->creationdate); ?></span>
                            </div>                            
                            <div class="acomment-content" style="font-size: 100%;">
                                <div class="star_rating_small" overallrating="<?php echo $reviewobj->rating;?>"><!-- --></div>
                                <p><?php echo $reviewobj->review;?></p>
                            </div>                
                        </div>
                    </div>
                </li>
        <?php } ?>
        <?php if ( $lastpage > $nextpage) { ?>

                <li id="load-more">
                    <a href="javascript:void(0);" onclick="loadmorereviews(<?php echo $nextpage;?>);"><?php _e( 'Load More', 'buddypress' ); ?></a>
                </li>

        <?php } ?>
                    
    <?php if ( $page_number==0 ) { ?>
        </ul>
    <?php } ?>

<?php else : ?>
        <div id="message" class="box-round-border info clearboth ">
            <div class="member-post">
                <?php _e( 'Sorry, there was no review found.', 'buddypress' ); ?>
            </div>
        </div>
 <?php endif; ?>

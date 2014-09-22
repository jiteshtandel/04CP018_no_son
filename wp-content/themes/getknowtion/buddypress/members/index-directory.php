<?php 
    get_header();
    if(isset($_POST['actionname']) && $_POST['actionname']=='searchmembers'){
        $nativespeaker=0;
        $languagespoken=trim($_POST['languagespoken']);
        $languagelearn=trim($_POST['languagelearning']);
        $age=intval($_POST['age']);
        $gender=trim($_POST['gender']);
        $searchterm=trim($_POST['searchterm']);
        $searchterm=(strtolower($searchterm)=='search') ? "" : $searchterm;
        if(isset($_POST['native'])){
            $nativespeaker=1;
        }
    }
?>
    <tr> 
        <td valign="top" align="left" id="container" style="padding-right:15px;padding-left: 30px;">
            <div class="page_tital_text">Search Results</div>
            <div class="height10"><!-- --></div>
            <div>
            	<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
                    <tr>
                        <td valign="top" align="left" id="content" style="padding-left:0px;">
                            <div id="searchbox">
                                <div style="padding:8px;">
                                    <div style="font-size:17px;">Filter Results</div>                        
                                    <div style="height:10px;"><!-- --></div>
                                    <div style="padding-left:5px;padding-bottom:5px;">
                                        <form method="post" id="search-members" method="get" action="">
                                            <input type="hidden" name="actionname" value="searchmembers">
                                            <table cellpadding="0" cellspacing="0" border="0" style="width:100%;" id="searchoptions">
                                                <tr>
                                                    <td valign="top" colspan="2">
                                                        <div>Languages Spoken</div>
                                                        <div style="height:5px;"><!-- --></div>	
                                                        <div>
                                                            <input type="text" id="languagespoken" name="languagespoken" value="<?php echo $languagespoken;?>" style="width:85%;"/>
                                                        </div>
                                                    </td>
                                                    <td valign="top" colspan="2">
                                                        <div>Languages Learning</div>
                                                        <div style="height:5px;"><!-- --></div>	
                                                        <div>
                                                            <input type="text" id="languagelearning" name="languagelearning" value="<?php echo $languagelearn;?>" style="width:85%;" />
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr><td colspan="5" class="height5"><!-- --></td></tr>
                                                <tr>
                                                    <td valign="top" style="width: 20%">
                                                        <div>Age</div>
                                                        <div style="height:5px;"><!-- --></div>	
                                                        <div>
                                                            <select id="age" name="age" style="width: 85%;">
                                                                <option value="">Select Age</option>
                                                                <option value="18" <?php echo ($age==18)? 'selected="selected"' : '';?>>18+</option>
                                                                <option value="25" <?php echo ($age==25)? 'selected="selected"' : '';?>>25+</option>
                                                                <option value="30" <?php echo ($age==30)? 'selected="selected"' : '';?>>30+</option>
                                                                <option value="35" <?php echo ($age==35)? 'selected="selected"' : '';?>>35+</option>
                                                                <option value="40" <?php echo ($age==40)? 'selected="selected"' : '';?>>40+</option>
                                                                <option value="50" <?php echo ($age==50)? 'selected="selected"' : '';?>>50+</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td valign="top" style="width: 22%">
                                                        <div>Gender</div>
                                                        <div style="height:5px;"><!-- --></div>	
                                                        <div>
                                                            <select id="gender" name="gender" style="width: 85%">
                                                                <option value="">Select Gender</option>
                                                                <option value="Male" <?php echo ($gender=='Male')? 'selected="selected"' : '';?>>Male</option>
                                                                <option value="Female" <?php echo ($gender=='Female')? 'selected="selected"' : '';?>>Female</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td valign="top" style="width: 24%">
                                                        <div>
                                                            <div>Search</div>
                                                            <div style="height:5px;"><!-- --></div>	
                                                            <div>
                                                                <input type="text" id="searchterm" name="searchterm" value="<?php echo $searchterm;?>"  style="width:85%;" />
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td valign="middle" style="width: 17%">
                                                        <div style="padding-top:18px;">
                                                            <input type="checkbox" id="native" name="native" <?php echo ($nativespeaker>0) ? 'checked="checked"' : "";?>  />
                                                            <label for="native">Native Speaker</label>
                                                        </div>
                                                    </td>
                                                    <td valign="top" align="right">
                                                        <div style="padding-top:25px;"><input id="search" name="search" class="green-button" value="Search" type="submit"/></div>
                                                    </td>
                                                </tr>
                                            </table>	
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div style="height: 25px;"><!-- --></div>
                            <div style="width:100%;" id="searchresult">
                                <?php do_action( 'bp_before_directory_members_page' ); ?>
                                <div id="buddypress">
                                <?php do_action( 'bp_before_directory_members' ); ?>
                                        <?php do_action( 'bp_before_directory_members_content' ); ?>
                                        <form action="" method="post" id="members-directory-form" class="dir-form">
                                                <div class="item-list-tabs" id="subnav" role="navigation">
                                                        <ul>
                                                                <?php do_action( 'bp_members_directory_member_sub_types' ); ?>
                                                                <li id="members-order-select" class="last filter">
                                                                        <label for="members-order-by"><?php _e( 'Order By:', 'buddypress' ); ?></label>
                                                                        <select id="members-order-by">
                                                                                <option value="active"><?php _e( 'Last Active', 'buddypress' ); ?></option>
                                                                                <option value="newest"><?php _e( 'Newest Registered', 'buddypress' ); ?></option>

                                                                                <?php if ( bp_is_active( 'xprofile' ) ) : ?>
                                                                                        <option value="alphabetical"><?php _e( 'Alphabetical', 'buddypress' ); ?></option>
                                                                                <?php endif; ?>

                                                                                <?php do_action( 'bp_members_directory_order_options' ); ?>
                                                                        </select>
                                                                </li>
                                                        </ul>
                                                </div>
                                                <div id="members-dir-list" class="members dir-list">
                                                    <?php bp_get_template_part( 'members/members-loop' ); ?>
                                                </div><!-- #members-dir-list -->

                                                <?php do_action( 'bp_directory_members_content' ); ?>

                                                <?php wp_nonce_field( 'directory_members', '_wpnonce-member-filter' ); ?>

                                                <?php do_action( 'bp_after_directory_members_content' ); ?>
                                        </form><!-- #members-directory-form -->
                                        <?php do_action( 'bp_after_directory_members' ); ?>
                                </div><!-- #buddypress -->
                                <?php do_action( 'bp_after_directory_members_page' ); ?>
                            </div>
                        </td>
                        <td valign="top" align="left" id="rightbar">
                            <div style="padding:0px 5px 25px 5px">
                                <div style="background-color:#E6E7E8;height:500px" align="center">
                                    Advertisement
                                </div> 
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>

<?php get_footer();?>


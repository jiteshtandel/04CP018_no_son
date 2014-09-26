<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php 
    get_header();
    $currentaction=$bp->current_action;
?>
<script src="<?php echo THEME_DIR;?>/js/pages/city-state.js" type="text/javascript"></script>
<script src="<?php echo THEME_DIR; ?>/js/pages/edit-profile.js" type="text/javascript" ></script>
<script src="<?php echo THEME_DIR; ?>/js/jquery/jquery.autocomplete.js" type="text/javascript" ></script>
<tr> 
    <td valign="top" align="left" id="container">
        <div id="buddypress">
            <h4 class="greenbigheading"><?php _e( 'My Profile', 'buddypress' ) ?></h4>  
            <div class="height5"><!-- --></div>
            <div class="myprofileedittable">
                <div class="myprofileeditrow">
                    <div class="myprofileeditcell">
                        <div class="height10"><!-- --></div>
                        <div class="userinfo">
                            <?php bp_displayed_user_avatar( 'type=full' );?>
                            <div class="clearboth"></div>
                        </div>
                        <ul id="settings-edit">
                            <li class="view-profile-icon<?php echo (!bp_is_profile_edit() && !bp_is_change_avatar()) ? " selected" : "";?>"><a href="<?php echo $bp->displayed_user->domain . 'profile/';?>"><?php _e( 'View Profile', 'buddypress' ) ?></a></li>
                            <li class="edit-profile-icon<?php echo (bp_is_profile_edit()) ? " selected" : "";?>"><a href="<?php echo $bp->displayed_user->domain . 'profile/edit/';?>"><?php _e( 'Edit Profile', 'buddypress' ) ?></a></li>
                            <li class="change-avatar-icon<?php echo (bp_is_change_avatar()) ? " selected" : "";?>"><a href="<?php echo $bp->displayed_user->domain . 'profile/change-avatar';?>"><?php _e( 'Change Picture', 'buddypress' ) ?></a></li>
                        </ul>
                    </div>
                    <div style="display: table-cell;padding: 0px 0px 35px 25px;vertical-align: top;">

                            <?php do_action( 'bp_before_profile_content' ); ?>

                            <div class="settings" role="main">

                            <?php switch ( $currentaction ) :

                                    // Edit
                                    case 'edit'   :
                                            bp_get_template_part( 'members/single/profile/edit' );
                                            break;

                                    // Change Avatar
                                    case 'change-avatar' :
                                            bp_get_template_part( 'members/single/profile/change-avatar' );
                                            break;

                                    // Compose
                                    case 'public' :

                                            // Display XProfile
                                            if ( bp_is_active( 'xprofile' ) )
                                                    bp_get_template_part( 'members/single/profile/profile-loop' );

                                            // Display WordPress profile (fallback)
                                            else
                                                    bp_get_template_part( 'members/single/profile/profile-wp' );

                                            break;

                                    // Any other
                                    default :
                                            bp_get_template_part( 'members/single/plugins' );
                                            break;
                            endswitch; ?>
                            </div><!-- .profile -->

                            <?php do_action( 'bp_after_profile_content' ); ?>                        
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>
<?php get_footer();?>



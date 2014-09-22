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
            <h4 class="greenbigheading">Settings</h4>  
            <div class="height5"><!-- --></div>
            <div class="myprofileedittable">
                <div class="myprofileeditrow">
                    <div class="myprofileeditcell">
                        <ul id="settings-edit">
                            <li class="settings-icon<?php echo ($currentaction=="general") ? " selected" : "";?>"><a href="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/general'; ?>">General</a></li>
                            <li class="alert-icon<?php echo ($currentaction=="notifications") ? " selected" : "";?>"><a href="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/notifications' ?>">Notification</a></li>
                            <li class="trash-icon<?php echo ($currentaction=="delete-account") ? " selected" : "";?>"><a href="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/delete-account/' ?>">Delet Account</a></li>
                        </ul>
                    </div>
                    <div style="display: table-cell;padding: 0px 0px 35px 25px;vertical-align: top;">
                        <div class="settings">
                        <?php
                            switch ( $currentaction ) :
                                    case 'notifications'  :
                                            bp_get_template_part( 'members/single/settings/notifications'  );
                                            break;
                                    case 'capabilities'   :
                                            bp_get_template_part( 'members/single/settings/capabilities'   );
                                            break;
                                    case 'delete-account' :
                                            bp_get_template_part( 'members/single/settings/delete-account' );
                                            break;
                                    case 'general'        :
                                            bp_get_template_part( 'members/single/settings/general'        );
                                            break;
                                    case 'profile'        :
                                            bp_get_template_part( 'members/single/settings/profile'        );
                                            break;
                                    default:
                                            bp_get_template_part( 'members/single/plugins'                 );
                                            break;
                            endswitch;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>
<?php get_footer();?>



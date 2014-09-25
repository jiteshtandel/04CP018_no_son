<?php
    $current_loggedin_userid=bp_loggedin_user_id();
    $languagespoken1=trim(xprofile_get_field_data('Language Spoken 1',$current_loggedin_userid));
    $languagespoken2=trim(xprofile_get_field_data('Language Spoken 2',$current_loggedin_userid));
    $languagespoken3=trim(xprofile_get_field_data('Language Spoken 3',$current_loggedin_userid));
    
    $languagelearn1=trim(xprofile_get_field_data('Language Learning 1',$current_loggedin_userid));
    $languagelearn2=trim(xprofile_get_field_data('Language Learning 2',$current_loggedin_userid));
    $languagelearn3=trim(xprofile_get_field_data('Language Learning 3',$current_loggedin_userid));
    
    //create an array based on value
    $languagespokenarr=array($languagespoken1,$languagespoken2,$languagespoken3);
    $languagelearnarr=array($languagelearn1,$languagelearn2,$languagelearn3);
    $where_clause='';
    foreach($languagespokenarr as $value){
        
        if(strlen($value)>0){
            $searcharr['Language Learning 1']=$value;
            $searcharr['Language Learning 2']=$value;
            $searcharr['Language Learning 3']=$value;
            
            $where_clause=build_members_where($searcharr,$where_clause);
            unset($searcharr);
        }
        
    }
    foreach($languagelearnarr as $value){
        if(strlen($value)>0){
            $searcharr['Language Spoken 1']=$value;
            $searcharr['Language Spoken 2']=$value;
            $searcharr['Language Spoken 3']=$value;
            
            $where_clause=build_members_where($searcharr,$where_clause);
            unset($searcharr);
        }
    }
    $has_arg=search_memmbers_query($where_clause,2);
    $suggested_userid=0;
    if(strlen($has_arg)>0){
        $suggested_userid=getsuggestedmember($has_arg);
    }
?>
<div style="padding:0px 5px 0px 5px">
<?php 
    if($suggested_userid>0){
        $firstname=xprofile_get_field_data('First Name', $suggested_userid);
        $languagespoken1 = xprofile_get_field_data( 'Language Spoken 1', $suggested_userid);
        $languagespoken2 = xprofile_get_field_data( 'Language Spoken 2', $suggested_userid);
        $languagespoken3 = xprofile_get_field_data( 'Language Spoken 3', $suggested_userid);
        $nativecountry=xprofile_get_field_data('Native Country',$suggested_userid);
        $about_user=xprofile_get_field_data('About Me',$suggested_userid);
        $suggested_userdomain=bp_core_get_user_domain( $suggested_userid ); 
?>
    <div class="userinfo">
        <a href="<?php echo $suggested_userdomain; ?>" title="<?php echo $firstname; ?>">
        <?php echo bp_core_fetch_avatar ( array( 'item_id' => $suggested_userid, 'type' => 'thumb' ) ) ?>
        </a>
    </div>
    <div><a href="<?php echo $suggested_userdomain; ?>" class="greentext12"><?php echo $firstname;?></div>
    <div><a class="blacktext11">From <?php echo $nativecountry;?></div>
    <div><a class="blacktext11">Speaks <?php echo strconcat(array($languagespoken1,$languagespoken2,$languagespoken3),', ');?></div>
    <div class="about-user"><?php echo ellipses($about_user,200); ?></div>
    <div align="right"><input class="green-button" type="button" name="viewprofile" value="View Profile" onclick="location.href='<?php echo $suggested_userdomain;?>';" /></div>	
<?php }else{?>
    <div><p><?php _e( 'Sorry, no any suggested matching profile found related to your profile.', 'knowtion' ); ?></p></div>
<?php }?> 
    <div class="clearboth"></div>
</div>

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
    if(strlen($has_arg)>0){
        $has_arg='&include='.$has_arg;
    }
    else{
        $has_arg='&include=false';
    }
?>
<div>
    <h6 class="suggested-knowtions"><?php _e( 'who to know', 'knowtion' ); ?></h6>
    <div style="margin:15px 0px 0px 5px">
<?php if ( bp_has_members(bp_ajax_querystring('members').'&per_page=8&type=random&exclude=1,' . $current_loggedin_userid . $has_arg)) : ?>        
        <table border="0" cellpadding="0" cellspacing="0">
        <?php 
            while ( bp_members() ) : bp_the_member();
                $userid=bp_get_member_user_id();
                $languagespoken1 = xprofile_get_field_data( 'Language Spoken 1', $userid);
                $languagespoken2 = xprofile_get_field_data( 'Language Spoken 2', $userid);
                $languagespoken3 = xprofile_get_field_data( 'Language Spoken 3', $userid);
                $nativecountry=xprofile_get_field_data('Native Country',$userid)
        ?>
            
            <tr>
                <td class="userinfo" valign="top" align="left"><a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar('type=thumb'); ?></a></td>
                <td valign="top" align="left">
                    <div><a class="greentext12" href="<?php bp_member_permalink(); ?>"><?php echo xprofile_get_field_data('First Name', $userid);?></a></div>
                    <div class="blacktext11">From: <?php echo $nativecountry;?></div>
                    <div class="blacktext11">Speaks: <?php echo strconcat(array($languagespoken1,$languagespoken2,$languagespoken3),', ');?></div>
                </td>
            </tr>
            <tr><td colspan="2" class="height10"></td></tr>
        <?php endwhile; ?>            
        </table>
<?php else: ?>
	<div>
		<p><?php _e( 'Sorry, no any matching profile found related to your profile.', 'knowtion' ); ?></p>
	</div>
<?php endif; ?>        
    </div>
</div>
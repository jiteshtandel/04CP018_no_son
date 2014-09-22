<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    define ( 'BP_AVATAR_FULL_WIDTH',180);
    define ( 'BP_AVATAR_FULL_HEIGHT',180);
    define ( 'BP_AVATAR_THUMB_WIDTH',50);
    define ( 'BP_AVATAR_THUMB_HEIGHT',50);

    function remove_xprofile_links() {
        remove_filter( 'bp_get_the_profile_field_value', 'xprofile_filter_link_profile_data', 9, 2);
    }
    function is_user_online($user_id, $time=5){
            global $wp, $wpdb;

            $user_login = $wpdb->get_var( $wpdb->prepare("
                    SELECT u.user_login FROM $wpdb->users u JOIN $wpdb->usermeta um ON um.user_id = u.ID 
                    WHERE 	u.ID = %d 
                    AND um.meta_key = 'last_activity'
                    AND DATE_ADD( um.meta_value, INTERVAL $time MINUTE ) >= UTC_TIMESTAMP()",$user_id));
            if(isset($user_login) && $user_login !=""){
                    return true;
            }
            else {return false;}
    }
    function search_memmbers_query($where_clause='',$recurrencecount=0) {
        global $wpdb;

        if ( !empty( $where_clause ) ){
            $query = "select user_id from (SELECT user_id,count(*) as usercount FROM " . $wpdb->prefix . "bp_xprofile_data where (" . $where_clause .")  group by user_id) as temp where usercount>=" . $recurrencecount;
        }
        else
            return '';
        /*
        LIKE is slow. If you're sure the value has not been serialized, you can do this:
        $query .= " AND value = '" . $field_value . "'";
        */
        $custom_ids = $wpdb->get_col( $query );

        if (!empty( $custom_ids ) ) {
          //convert the array to a csv string
          $user_ids=implode(",", $custom_ids);
          return $user_ids;
        }
        else
            return '';

    }
    
    function build_members_where($fieldarr=array(),$where_clause=''){
        if ( empty( $fieldarr ) )
            return '';
        
        foreach($fieldarr as $field_name=>$field_value){
                $field_id = xprofile_get_field_id_from_name( $field_name );

                if(in_array($field_name, array('Gender','Language Spoken 1','Language Spoken 2','Language Spoken 3','Language Learning 1','Language Learning 2','Language Learning 3'))){
                    if(strlen($where_clause)>0){
                        $where_clause .=' or ';
                    }
                    $where_clause .=" (field_id=" . $field_id . " AND value='" . $field_value. "')";
                }
                else if(in_array($field_name, array('Birthday'))){
                    if(strlen($where_clause)>0){                    
                        $where_clause .=' or ';
                    }   
                    $where_clause .=" (field_id=" . $field_id . " AND (DATEDIFF(now(),value)/ 365.25) >" . $field_value . ")";
                }
                else{
                    if(strlen($where_clause)>0){
                        $where_clause .=' or ';
                    }

                    $where_clause .=" (field_id=" . $field_id . " AND value like '%" . $field_value. "%')";
                } 
        }
        return $where_clause;
    }
    function getsuggestedmember($user_ids=''){
        global $wpdb;
        $querystr="SELECT AVG(rating) as avgrating,count(*) as totalrating,to_userid 
                FROM usersreview
                WHERE to_userid IN (" . $user_ids . ") 
                GROUP BY to_userid ORDER BY avgrating DESC,totalrating DESC LIMIT 0,1";
        $reviewsresult=$wpdb->get_results($querystr, OBJECT);
        if ($reviewsresult){
            return $reviewsresult[0]->to_userid;
        }
        else{
            return '';
        }
    }
    add_action( 'bp_init', 'remove_xprofile_links' );
?>

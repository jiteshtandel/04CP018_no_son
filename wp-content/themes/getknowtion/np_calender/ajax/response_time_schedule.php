<?php
define('WP_USE_THEMES', false);
require_once('../../../../../wp-load.php');
require_once('../lib/custom_functions.php');
require_once('../lib/schedule_functions.php');

global $bp;
//echo $displayed_userid=$bp->displayed_user->id;
//echo $bp->displayed_user->id;

$user_id = get_current_user_id();
$user_timezone = getusertimezonename($user_id);

$requester_id = $_REQUEST['requester_id'];
$batch_id = $_REQUEST['batch_id'];
$schedule_time_id = $_REQUEST['schedule_time_id'];
$status = $_REQUEST['status'];

if($status == 1) {
    //check if request exists in database
    $request = get_logged_user_requested_schedule($requester_id, $user_id, $batch_id, $schedule_time_id);

    if(!empty($request)){

        //check if for selected schedule_time_id not approved for any other users
        $approved_already = check_schedule_approved_already($user_id, $batch_id, $schedule_time_id);

        if(!$approved_already){

            //invalidate all requests first
            reject_schedule_requests($user_id, $batch_id, $schedule_time_id);

            //approve the selected request
            $approved_id = approve_schedule_request($requester_id, $user_id, $batch_id, $schedule_time_id);

            $requester_info = get_user_info($requester_id);
            $host_info = get_user_info($user_id);

            $request = get_specific_request($requester_id, $user_id, $batch_id, $schedule_time_id, $approved = 1);

            @send_approval_email($requester_info, $host_info, $request);

            echo json_encode(array('status' => 'success', 'message' => 'Request approved', 'approved_id' => $approved_id));
            exit;

        } else {

            //already approved
            echo json_encode(array('status' => 'fail', 'message' => 'Request already approved'));
            exit;

        }

    } else {

        //no request found for selected record
        echo json_encode(array('status' => 'fail', 'message' => 'No request found for this record'));
        exit;
    }
} elseif($status == 2){
    $result = reject_individual_schedule_requests($requester_id, $user_id, $batch_id, $schedule_time_id);
    if($result){
        echo json_encode(array('status' => 'success', 'message' => 'Request rejected'));
        exit;
    } else {
        echo json_encode(array('status' => 'fail', 'message' => 'Error occoured, please try again.'));
        exit;
    }
}
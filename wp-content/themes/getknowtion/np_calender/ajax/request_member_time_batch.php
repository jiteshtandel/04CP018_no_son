<?php
define('WP_USE_THEMES', false);
require_once('../../../../../wp-load.php');
require_once('../lib/custom_functions.php');
require_once('../lib/schedule_functions.php');

$requester_id = get_current_user_id();
$member_id = $_REQUEST['user_id'];
$request_date = $_REQUEST['request_date'];
$batch_id = $_REQUEST['batch_id'];
$time_batches = $_REQUEST['time_batches'];

$inserted_ids = request_time_schedule($requester_id, $member_id, $request_date, $batch_id, $time_batches);

if(! empty($inserted_ids)){
    $requester_info = get_user_info($requester_id);
    $host_info = get_user_info($member_id);

    $schedules = array();
    foreach($inserted_ids as $schedule_id){
        $schedules[] = get_time_batch($schedule_id);
    }
    $mail_status = send_request_notification($requester_info, $host_info, $schedules);

    echo json_encode(array('status'=>true, 'records' => count($inserted_ids) ,'message' => count($inserted_ids) . ' new request(s) initiated.', 'mail_status' => $mail_status, 'email_sent_to' => $host_info->user_email));
} else {
    echo json_encode(array('status' => false, 'message' => 'No new schedule request initiated.'));
}
exit;

?>
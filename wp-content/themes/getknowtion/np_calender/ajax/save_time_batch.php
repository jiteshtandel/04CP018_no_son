<?php
define('WP_USE_THEMES', false);
require_once('../../../../../wp-load.php');
require_once('../lib/custom_functions.php');
require_once('../lib/schedule_functions.php');

global $bp;
//echo $displayed_userid=$bp->displayed_user->id;
//echo $bp->displayed_user->id;

$user_id = get_current_user_id();
//$user_timezone = 'GMT';
$user_timezone = getusertimezonename($user_id);
$schedule_date = $_REQUEST['date'];
$batch_id = generateRandomString();
$first_half_action = $_REQUEST['first_half'];

$time_batches = $_REQUEST['time_batches'];
$schedule = get_schedule($user_id, $schedule_date);
//echo '<pre>';print_r($schedule);echo '</pre>';exit;

if($schedule && isset($schedule->batch_id)){
    //update the time-schedule batches
    $batch_id = $schedule->batch_id;

    //first delete all the previous batch schedule informations
    delete_time_batch($user_id, $batch_id, $booked = 0);

    if(is_array($time_batches)){
        insert_time_batch($user_id, $batch_id, $schedule_date, $time_batches);
    }

    //update first_half option if its not same
    if($first_half_action != $schedule->first_half_action){
        update_first_half_action($user_id, $batch_id, $first_half_action);
    }
    echo json_encode(array('status' => true, 'message' => 'updated'));exit;
} else{
    insert_time_schedule($user_id, $user_timezone, $schedule_date, $batch_id, $first_half_action);
    //insert the time-schedule batches
    if(is_array($time_batches)){
        insert_time_batch($user_id, $batch_id, $schedule_date, $time_batches);
    }
    echo json_encode(array('status' => true, 'message' => 'inserted'));exit;
}



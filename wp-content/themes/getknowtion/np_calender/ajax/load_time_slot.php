<?php
define('WP_USE_THEMES', false);
require_once('../../../../../wp-load.php');
require_once('../lib/custom_functions.php');
require_once('../lib/schedule_functions.php');

$user_id = get_current_user_id();
$schedule_date = $_REQUEST['date'];
$schedule = get_schedule($user_id, $schedule_date);

if(isset($schedule) && isset($schedule->batch_id)){
    $batch_id = $schedule->batch_id;

    $batch_times = get_schedule_times($user_id, $batch_id, $schedule_date);

    //check if any request sent on following time or request accepted
    //if yes, disable user's input
    foreach($batch_times as $key => $time_batch){
        if(check_time_requested_from_anyone($time_batch->user_id, $time_batch->batch_id, $time_batch->time_id))
            $batch_times[$key]->disable = 1;
        else
            $batch_times[$key]->disable = 0;
    }

    //echo "<pre>";print_r($batch_times);exit;

    $schedule->times = $batch_times;



    echo json_encode($schedule);
    exit;
}

echo '';exit;
<?php
define('WP_USE_THEMES', false);
require_once( dirname(__FILE__) . '/../../../../../wp-load.php' );
//require_once( dirname(__FILE__) . '/custom_functions.php');

$schedule_table = 'wp_schedule';
$schedule_time_batch_table = 'wp_schedule_time';
$schedule_request_table = 'wp_schedule_request';


/*
 * Get all the records for busy dates
 */
function get_schedule_requests($user_id){
    global $wpdb, $schedule_table, $schedule_time_batch_table, $schedule_request_table;
    $requests = $wpdb->get_results('select * from wp_schedule WHERE user_id = '.$user_id);

    return $requests;

}

/*
 * Get all the records above or equal today
 */
function get_future_schedule_requests($user_id){
    global $wpdb;
    $requests = $wpdb->get_results('select * from wp_schedule WHERE user_id = '.$user_id .' AND schedule_date >="'. date('Y-m-d') .'" ORDER BY schedule_date ASC');
    //echo $wpdb->last_query ."\n";

    return $requests;

}
/*
 * Get all the busy dates only of the user
 */
function get_busy_dates($user_id){
    global $wpdb, $schedule_table;
    $result = $wpdb->get_results('select schedule_date from wp_schedule WHERE user_id = '.$user_id);
    //echo $wpdb->last_query ."\n";echo '<pre>';print_r($result);echo '</pre>';

    if(!empty($result))
        return $result;

    return false;
}

/*
 * Get the schedule date records for a specific date
 */
function get_schedule($user_id, $schedule_date){
    global $wpdb, $schedule_table;
    $result = $wpdb->get_results('select * from '.$schedule_table.' WHERE user_id = '.$user_id.' AND schedule_date="'.$schedule_date.'"');

    if(!empty($result))
        return $result[0];

    return false;
}

/*
 * Get the schedule date records for a specific date
 */
function get_schedule_times($user_id, $batch_id, $schedule_date){
    global $wpdb, $schedule_table,$schedule_time_batch_table;
    $result = $wpdb->get_results('select * from '.$schedule_time_batch_table.' WHERE user_id = '.$user_id.' AND batch_id="'.$batch_id.'" AND schedule_date="'.$schedule_date.'"');
    //echo $wpdb->last_query."\n";

    if(!empty($result))
        return $result;

    return false;
}

function get_approved_schedules($user_id){
    global $wpdb, $schedule_time_batch_table;
    $result = $wpdb->get_results('select * from '.$schedule_time_batch_table.' WHERE (user_id = '.$user_id.' OR booked_user_id='. $user_id .') AND booked=1 ORDER BY schedule_date ASC');
    //echo $wpdb->last_query."\n";

    if(!empty($result))
        return $result;

    return false;
}

/*
 * Insert master entry in scheduler table and
 * generate batch_id which will work as foreign key in
 * time-scheduler batch table
 */
function insert_time_schedule($user_id, $user_timezone, $schedule_date, $batch_id, $first_half_action){
    global $wpdb, $schedule_table,$schedule_time_batch_table;
    $wpdb->insert($schedule_table,
        array(
            'user_id'=>$user_id,
            'user_timezone'=>$user_timezone,
            'schedule_date'=>$schedule_date,
            'batch_id'=>$batch_id,
            'first_half_action'=>$first_half_action,
            'created'=>date('Y-m-d H:i:s')
        ), array('%d','%s','%s','%s','%s','%s'));
    //echo $wpdb->last_query."\n";;
}

/*
 * Available time will be stored in a batch
 * for a specific date
 */
function insert_time_batch($user_id, $batch_id, $schedule_date, $time_batches){
    global $wpdb, $schedule_table,$schedule_time_batch_table;
    foreach($time_batches as $batch){
        $times = explode(',', $batch);
        $wpdb->insert($schedule_time_batch_table,
            array(
                'user_id'=>$user_id,
                'batch_id'=>$batch_id,
                'time_id'=>$times[0],
                'schedule_date'=>$schedule_date,
                'start_time'=>$times[1],
                'end_time' => $times[2]
            ),array('%d','%s','%d','%s','%s','%s'));
        //echo $wpdb->last_query ."\n";
    }
}

/*
 * Before inserting new time-batch slot,
 * delete all existing batch for a specific date,
 * and replace with the new batch
 */
function delete_time_batch($user_id, $batch_id, $booked = 0){
    global $wpdb, $schedule_table,$schedule_time_batch_table;
    $wpdb->delete( $schedule_time_batch_table,
        array(
            'user_id' => $user_id,
            'batch_id' => $batch_id,
            'booked' => $booked),
        array('%d','%s','%d'));

    //echo $wpdb->last_query."\n";exit;
}

function update_first_half_action($user_id, $batch_id, $first_half_action){
    global $wpdb, $schedule_table,$schedule_time_batch_table;
    $wpdb->update(
        $schedule_table,
        array('first_half_action' => $first_half_action),
        array('user_id' => $user_id, 'batch_id' => $batch_id),
        array('%d')
    );
}


function request_time_schedule($requester_id, $user_id, $schedule_date, $batch_id, $time_batches){
    global $wpdb, $schedule_table, $schedule_request_table, $schedule_time_batch_table;

    //check if host has any open free dates for request
    $result = $wpdb->get_results('select * from '.$schedule_table.' WHERE user_id = '.$user_id.' AND schedule_date="'.$schedule_date.'" AND batch_id="'. $batch_id .'"');
    //echo $wpdb->last_query."\n";exit;

    if(empty($result))
        return array();

    $inserted_ids = array();
    //check if requester already made the request for the same time-batch
    foreach($time_batches as $time_batch){
        $result_time_batch = $wpdb->get_results('select * from '.$schedule_request_table.' WHERE requester_id="'. $requester_id .'" AND batch_id="'. $batch_id .'" AND schedule_time_id=' . $time_batch);
        //echo '<pre>';print_r($result_time_batch);echo '</pre>';echo $wpdb->last_query."\n";exit;

        //if not requested before for this time schedule then only insert into database
        if(empty($result_time_batch)){
            //get the start-time and end-time for the batch
            $schedule_time_batch = $wpdb->get_results('select * from '.$schedule_time_batch_table.' WHERE batch_id="'. $batch_id .'" AND time_id=' . $time_batch);

            $wpdb->insert($schedule_request_table,
                array(
                    'requester_id'=>$requester_id,
                    'host_user_id'=>$user_id,
                    'schedule_date'=>$schedule_date,
                    'batch_id'=>$batch_id,
                    'schedule_time_id'=>$time_batch,
                    'start_time'=>$schedule_time_batch[0]->start_time,
                    'end_time' => $schedule_time_batch[0]->end_time,
                    'approved' => 0,
                    'requested_on' => date('Y-m-d H:i:s'),
                ),array('%d','%d','%s','%s','%d','%s','%s','%d','%s'));
                //echo $wpdb->last_query."\n";

            $inserted_ids[] = $wpdb->insert_id;
        }
    }
    return $inserted_ids;
}


/**
 * Get the requested times for logged user
 * @param $host_id
 * @param $schedule_date
 * @param $batch_id
 * @return mixed
 */

function get_requested_schedules($host_id, $schedule_date, $batch_id, $approved = 0){
    global $wpdb, $schedule_request_table;

    $result = $wpdb->get_results('select * from '.$schedule_request_table.' WHERE host_user_id = '.$host_id.' AND schedule_date="'.$schedule_date.'" AND batch_id="'. $batch_id .'" AND approved="'. $approved .'"');
    //echo $wpdb->last_query."\n";

    return $result;
}

function get_logged_user_requested_schedule($requester_id, $user_id, $batch_id, $schedule_time_id){
    global $wpdb, $schedule_request_table;
    $result = $wpdb->get_results('select * from '.$schedule_request_table.' WHERE requester_id="'. $requester_id .'" AND host_user_id = "'.$user_id.'" AND batch_id="'. $batch_id .'" AND schedule_time_id="'. $schedule_time_id .'"');
    //echo $wpdb->last_query."\n";

    if(!empty($result) && isset($result[0]))
        return $result[0];

    return $result;
}

function check_schedule_approved_already($user_id, $batch_id, $schedule_time_id){
    global $wpdb, $schedule_request_table;
    $result = $wpdb->get_results('select * from '.$schedule_request_table.' WHERE host_user_id = '.$user_id.' AND batch_id="'. $batch_id .'" AND schedule_time_id="'. $schedule_time_id .'" AND approved = 1');

    if(!empty($result) && isset($result[0]))
        return true;

    return false;
}

/**
 * Accept / Reject any schedule request
 * @param $user_id
 * @param $request_id
 * @param $batch_id
 * @param $status
 */

function approve_schedule_request($requester_id, $user_id, $batch_id, $schedule_time_id){
    global $wpdb, $schedule_request_table, $schedule_time_batch_table;

    $result = $wpdb->get_results('select * from '.$schedule_request_table.' WHERE requester_id="'. $requester_id .'" AND host_user_id = '.$user_id.' AND batch_id="'. $batch_id .'" AND schedule_time_id='. $schedule_time_id);
    //echo $wpdb->last_query."\n";print_r($result);

    if(!empty($result) && isset($result[0]->id)){
        $request_id = $result[0]->id;

        $wpdb->update(
            $schedule_request_table,
            array('approved' => 1, 'approved_on' => date('Y-m-d H:i:s')),
            array('id' => $request_id),
            array('%d','%s')
        );

        //update the schedule_time table
        $wpdb->update(
            $schedule_time_batch_table,
            array('booked' => 1, 'booked_user_id' => $requester_id, 'booked_on' => date('Y-m-d H:i:s')),
            array('user_id' => $user_id, 'batch_id' => $batch_id, 'time_id' => $schedule_time_id),
            array('%d','%s','%s')
        );

        return $request_id;

    } else {
        return false;
    }
}

/**
 * If any request is selected, invalidate all other requests for that time batch
 * @param $user_id
 * @param $batch_id
 * @param $schedule_time_id
 */
function reject_schedule_requests($user_id, $batch_id, $schedule_time_id){
    global $wpdb, $schedule_request_table;

    $wpdb->update(
        $schedule_request_table,
        array('approved' => 2),
        array('host_user_id' => $user_id, 'batch_id' => $batch_id, 'schedule_time_id' => $schedule_time_id),
        array('%d')
    );

    //echo $wpdb->last_query."\n";
}

/**
 * When user click on reject button for a specific request
 * @param $requeter_id
 * @param $user_id
 * @param $batch_id
 * @param $schedule_time_id
 */
function reject_individual_schedule_requests($requeter_id, $user_id, $batch_id, $schedule_time_id){
    global $wpdb, $schedule_request_table;

    return $wpdb->update(
        $schedule_request_table,
        array('approved' => 2),
        array('requester_id' => $requeter_id,'host_user_id' => $user_id, 'batch_id' => $batch_id, 'schedule_time_id' => $schedule_time_id),
        array('%d')
    );

    //echo $wpdb->last_query."\n";
}

function get_user_info($user_id){
    global $wpdb;
    $result = $wpdb->get_results('select * from wp_users WHERE ID = '.$user_id);
    //echo $wpdb->last_query."\n";

    if(!empty($result) && isset($result[0]))
        return $result[0];

    return $result;
}

function get_time_batch($schedule_id){
    global $wpdb, $schedule_request_table;
    $result = $wpdb->get_results('select * from '.$schedule_request_table.' WHERE id = '.$schedule_id);

    //echo $wpdb->last_query."\n";

    if(!empty($result) && isset($result[0]))
        return $result[0];

    return false;
}

function get_sent_request($requester_id){
    global $wpdb, $schedule_request_table;
    $result = $wpdb->get_results('select * from '.$schedule_request_table.' WHERE requester_id = '.$requester_id .' AND approved = 0 AND schedule_date >= "' . date('Y-m-d') .'"');

    //echo $wpdb->last_query."\n";
    if(!empty($result) && isset($result[0]))
        return $result;

    return false;
}
?>
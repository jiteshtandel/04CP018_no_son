<?php
define('WP_USE_THEMES', false);
require_once('../../../../../wp-load.php');
require_once('../lib/custom_functions.php');
require_once('../lib/schedule_functions.php');

$host_id = $_REQUEST['member_id'];
$host_timezone = getusertimezonename($host_id);

$requester_id = get_current_user_id();
$requester_timezone = getusertimezonename($requester_id);
//$requester_timezone = 'Europe/Berlin';
//echo '<pre>';print_r($requester_id);print_r($requester_timezone);


$schedule_date = $_REQUEST['request_date'];
$schedule = get_schedule($host_id, $schedule_date);

if(isset($schedule) && isset($schedule->batch_id)):
    $batch_id = $schedule->batch_id;

    $batch_times = get_schedule_free_times($host_id, $batch_id, $schedule_date);

    if($host_timezone != $requester_timezone){
        foreach($batch_times as $key => $batch_time){
            $batch_times[$key]->host_timezone = $host_timezone;
            $batch_times[$key]->requester_timezone = $requester_timezone;

            $start_time = converToTz($batch_time->schedule_date.' '.$batch_time->start_time, $requester_timezone, $host_timezone);
            $end_time = converToTz($batch_time->schedule_date.' '.$batch_time->end_time, $requester_timezone, $host_timezone);
            $batch_times[$key]->requester_schedule_date = date("Y-m-d", strtotime($start_time) );
            $batch_times[$key]->requester_start_time = date("g:i A", strtotime($start_time) );
            $batch_times[$key]->requester_end_time = date("g:i A", strtotime($end_time) );
        }
    }
    //echo '<pre>';print_r($batch_times);exit;


    $schedule->times = $batch_times;

    if(!empty($schedule->times)):
?>
        <ul data-batch_id="<?php echo $schedule->batch_id;?>">
        <?php foreach($schedule->times as $time_batch): ?>
            <li style="<?php echo ($host_timezone == $requester_timezone)?'height:40px':'' ?>">
                <div class="chkbox">
                    <label>
                        <input type="checkbox" name="time_batch_member" value="<?php echo $time_batch->time_id ?>">
                        <?php if($host_timezone != $requester_timezone): ?>
                        <?php echo ($time_batch->requester_schedule_date == $schedule_date)?'&nbsp;':$time_batch->requester_schedule_date .' : '; ?><?php echo $time_batch->requester_start_time ?> - <?php echo $time_batch->requester_end_time ?>
                        <span class="timezone"><?php echo $requester_timezone; ?></span>
                        <hr />
                        <?php endif; ?>
                        <?php echo $time_batch->start_time ?> - <?php echo $time_batch->end_time ?>
                        <span class="timezone"><?php echo $host_timezone; ?></span>
                    </label>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
           <p style="text-align: center">Sorry, no free time batch found for this user.</p>
    <?php endif; ?>

<?php else: ?>
    <p style="text-align: center">Error, Please try again.</p>
<?php endif; ?>
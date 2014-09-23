<?php
define('WP_USE_THEMES', false);
require_once('../../../../../wp-load.php');
require_once('../lib/custom_functions.php');
require_once('../lib/schedule_functions.php');

$user_id = $_REQUEST['member_id'];
$schedule_date = $_REQUEST['request_date'];
$schedule = get_schedule($user_id, $schedule_date);

if(isset($schedule) && isset($schedule->batch_id)):
    $batch_id = $schedule->batch_id;

    $batch_times = get_schedule_free_times($user_id, $batch_id, $schedule_date);
    $schedule->times = $batch_times;

    if(!empty($schedule->times)):
?>
        <ul data-batch_id="<?php echo $schedule->batch_id;?>">
        <?php foreach($schedule->times as $time_batch): ?>
            <li>
                <div class="chkbox">
                    <label><input type="checkbox" name="time_batch_member" value="<?php echo $time_batch->time_id ?>"><?php echo $time_batch->start_time ?> - <?php echo $time_batch->end_time ?> <span class="timezone"><?php echo $schedule->user_timezone; ?></span></label>
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
<?php

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function send_request_notification($requester, $host, $requests){

    //send email to host
    $headers = 'Content-type: text/html;charset=utf-8' . "\r\n";
    $headers .= 'From: Knowtion <admin@knowtion.com>' . "\r\n";

    $title = $requester->display_name .'('. $requester->user_email .') has requested for following times.';
    $footer = 'Pleaes approve/reject from your admin panel.';
    $message = get_email_body($requester->display_name, $requester->user_email, $requests, $title, $footer);
    //print_r($message);exit;
    @$send1 = wp_mail( $host->user_email, 'You got new request(s)', $message, $headers);


    //send email to requester
    $title = 'You had sent following request(s) to user :'. $host->display_name .'('. $host->user_email .')';
    $footer = 'Please wait until your host accept your request.';
    $message = get_email_body($host->display_name, $host->user_email, $requests, $title, $footer);
    //print_r($message);exit;
    @$send2 = wp_mail( $requester->user_email, 'You had sent new request(s)', $message, $headers);

    if($send1 && $send2)
        return true;

    return false;
}

function get_email_body($user_name, $email, $requests, $title = '',$footer = '') {
 ob_start();
?>

    <html>
    <head><title>New Requests notifications</title></head>
    <body>
        <p><?php echo $title; ?></p>
        <table>
            <tr>
                <td>Host Timezone</td>
                <td>Date</td>
                <td>Start Time</td>
                <td>End Time</td>
                <td>Requester Timezone</td>
                <td>Requester Date</td>
                <td>Requester Start Time</td>
                <td>Requester End Time</td>
            </tr>
        <?php foreach($requests as $request) : ?>
            <tr>
                <td><?php echo $request->host_timezone; ?></td>
                <td><?php echo $request->schedule_date; ?></td>
                <td><?php echo $request->start_time; ?></td>
                <td><?php echo $request->end_time; ?></td>
                <td><?php echo $request->requester_timezone; ?></td>
                <td><?php echo $request->requester_schedule_date; ?></td>
                <td><?php echo $request->requester_start_time; ?></td>
                <td><?php echo $request->requester_end_time; ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
        <p><?php echo $footer; ?></p>
    </body>
    </html>

<?php
    $body = ob_get_clean();
    return $body;
}


function send_approval_email($requester, $host, $request){

    //send email to host
    $headers = 'Content-type: text/html;charset=utf-8' . "\r\n";
    $headers .= 'From: Knowtion <admin@knowtion.com>' . "\r\n";

    $title = $requester->display_name .'('. $requester->user_email .')\'s request accepted by you.';
    $footer = 'Please have a good chat on approved time.';
    $message = get_approve_body($requester->display_name, $requester->user_email, $request, $title, $footer);
    //print_r($message);exit;
    @$send1 = wp_mail( $host->user_email, 'You approved a request', $message, $headers);


    //send email to requester
    $title = 'Congratulation, '. $host->display_name .'('. $host->user_email .') had accepted one of your request.';
    $footer = 'Please have a good chat on approved time.';
    $message = get_approve_body($host->display_name, $host->user_email, $request, $title, $footer);
    //print_r($message);exit;
    @$send2 = wp_mail( $requester->user_email, 'One of your request approved', $message, $headers);

    if($send1 && $send2)
        return true;

    return false;
}

function send_reject_email($requester_id, $host_id, $request){

}

function get_approve_body($host_name, $host_email, $request, $title, $footer){
ob_start();
?>

    <html>
    <head><title>Response for your requests</title></head>
    <body>
    <p><?php echo $title; ?></p>
    <table>
        <tr>
            <td>Member Name</td>
            <td>Member Email</td>
            <td>Member Timezone</td>
            <td>Date</td>
            <td>Start Time</td>
            <td>End Time</td>
            <td>Requester Timezone</td>
            <td>Requester Date</td>
            <td>Requester Start Time</td>
            <td>Requester End Time</td>
        </tr>
        <tr>
            <td><?php echo $host_name; ?></td>
            <td><?php echo $host_email; ?></td>
            <td><?php echo $request->host_timezone; ?></td>
            <td><?php echo $request->schedule_date; ?></td>
            <td><?php echo $request->start_time; ?></td>
            <td><?php echo $request->end_time; ?></td>
            <td><?php echo $request->requester_timezone; ?></td>
            <td><?php echo $request->requester_schedule_date; ?></td>
            <td><?php echo $request->requester_start_time; ?></td>
            <td><?php echo $request->requester_end_time; ?></td>
        </tr>
    </table>
    <p><?php echo $footer; ?></p>
    </body>
    </html>

<?php
    $body = ob_get_clean();
    return $body;
}

function np_year_search_form() {

    $search_year = (!empty($_REQUEST['sy']))?stripslashes($_REQUEST['sy']):0;
?>


    <form id="search-requst-form" method="post" action="">
        <select name="sy">
            <option value="0">Select year</option>
            <?php for($i = 0; $i <=3; $i++ ): ?>
            <?php
                $year = date("Y", strtotime('+'.$i.' year'));
                $selected = ($search_year == $year)?'selected="selected"':'';
            ?>
            <option value="<?php echo $year ?>" <?php echo $selected; ?>><?php echo $year; ?></option>
            <?php endfor; ?>
        </select>
        <input type="submit" value="Search" name="schedule_search_submit" id="messages_search_submit">
    </form>

<?php
}


function converToTz($time="",$toTz='',$fromTz='')
{
    // timezone by php friendly values
    $date = new DateTime($time, new DateTimeZone($fromTz));
    $date->setTimezone(new DateTimeZone($toTz));
    $time= $date->format('Y-m-d H:i:s');
    return $time;
}
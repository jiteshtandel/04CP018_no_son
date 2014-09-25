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
    $headers = 'Content-type: text/html;charset=utf-8' . "\r\n";
    $headers .= 'From: Knowtion <admin@knowtion.com>' . "\r\n";
    $message = get_email_body($requester->display_name, $requester->user_email, $requests);
    //print_r($message);exit;
    @$send = wp_mail( $host->user_email, 'You got new request(s)', $message, $headers);

    if($send)
        return true;

    return false;
}

function get_email_body($user_name, $email, $requests) {
 ob_start();
?>

    <html>
    <head><title>New Requests notifications</title></head>
    <body>
        <p><?php echo $user_name ?> (<?php echo $email; ?>)has requested for following times.</p>
        <table>
            <tr>
                <td>Date</td>
                <td>Start Time</td>
                <td>End Time</td>
            </tr>
        <?php foreach($requests as $request) : ?>
            <tr>
                <td><?php echo $request->schedule_date; ?></td>
                <td><?php echo $request->start_time; ?></td>
                <td><?php echo $request->end_time; ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
        <p>Pleaes approve/reject from your admin panel.</p>
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
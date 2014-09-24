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

    $default_search_value = bp_get_search_default_text( 'messages' );
    $search_value         = !empty( $_REQUEST['s'] ) ? stripslashes( $_REQUEST['s'] ) : $default_search_value; ?>

    <?php /*
    <form action="" method="get" id="search-message-form">
        <label><input type="text" name="s" id="messages_search" <?php if ( $search_value === $default_search_value ) : ?>placeholder="<?php echo esc_html( $search_value ); ?>"<?php endif; ?> <?php if ( $search_value !== $default_search_value ) : ?>value="<?php echo esc_html( $search_value ); ?>"<?php endif; ?> /></label>
        <input type="submit" id="messages_search_submit" name="messages_search_submit" value="<?php esc_attr_e( 'Search', 'buddypress' ) ?>" />
    </form>
    */ ?>

    <form id="search-requst-form" method="post" action="">
        <select name="start_year">
            <option value="0" selected="selected">Start Year</option>
            <option value="2012">2012</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
        </select>
        <select name="end_year">
            <option value="0" selected="selected">End Year</option>
            <option value="2012">2012</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
        </select>
        <input type="submit" value="Search" name="messages_search_submit" id="messages_search_submit">
    </form>

<?php
}
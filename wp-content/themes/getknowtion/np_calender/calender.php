<?php

    wp_enqueue_style( 'jquery-ui', THEME_DIR.'/np_calender/css/jquery-ui.css', array());
    wp_enqueue_style( 'fancybox-style', THEME_DIR.'/np_calender/js/fancybox/jquery.fancybox.css', array());
    wp_enqueue_style( 'np_calender', THEME_DIR.'/np_calender/css/np_calender.css', array());

    wp_enqueue_script( 'jquery-ui', THEME_DIR.'/np_calender/js/jquery-ui.js', array('jquery'),'', true);
    wp_enqueue_script( 'custom', THEME_DIR.'/np_calender/js/custom.js', array('jquery-ui'),'', true);
    wp_enqueue_script( 'fancybox', THEME_DIR.'/np_calender/js/fancybox/jquery.fancybox.pack.js', array('jquery'),'', true);

    require_once('lib/schedule_functions.php');

    $dates = get_busy_dates(get_current_user_id());
    $mdates = get_busy_dates(bp_displayed_user_id());

?>

<div id="hidden_divs" style="display: none">
    <div id="calender-container">

        <div class="popup_notify" style="display: block;min-height:25px"></div>
        <div class="clear"></div>
        <div id="calender">
            <p style="float: left;margin-bottom: 24px">Select date and time for your video chat</p>
            <div class="clear"></div>
            <div class="calender-placeholder">
                <div id="datepicker"></div>
            </div>
            <div class="time-placeholder">
                <p class="current_date">Wednesday January 16</p>
                <div class="times">
                    <div class="times-container">
                        <?php
                        $h = 0;
                        $i=1;
                        $suffix = ' AM';
                        for($hours=0; $hours<24; $hours++){
                            $timestamp1 = strtotime($h.':00');
                            $start_time = date('H:i', $timestamp1) . $suffix;
                            $timestamp2 = $timestamp1 + 60*60;
                            $end_time = date('H:i', $timestamp2) . $suffix;

                            echo '<div class="chkbox"><label><input id="timer_'.$i.'" class="timer_schedule" type="checkbox" name="time_batch" value="'. $i .','. $start_time.','. $end_time .'">'. $start_time.' - '. $end_time .'</label></div>';
                            $h++;
                            $i++;
                            if($h == 12){
                                $suffix = ' PM';
                            } else if($h > 12){
                                $h = 0;
                                $suffix = ' PM';
                            }
                        }
                        ?>
                    </div>
                </div>

                <p style="display: block">Times are in your local time zone.</p>
                <div class="title">
                    1st half in:
                </div>
                <div class="options">
                    <ul>
                        <li>
                            <label><input id="first_half_1" type="radio" name="first_half" value="1" checked="checked"> Language I am learning</label>
                        </li>
                        <li>
                            <label><input id="first_half_2" type="radio" name="first_half" value="2"> My native language</label>
                        </li>
                    </ul>
                </div>
                <div class="clear"></div>
                <div style="margin-top: 10px;">
                    <a id="schedule_button" href="#" class="round_button active">Schedule</a>
                    <a id="close_btn" href="#" class="round_button close_btn">Cancel</a>
                </div>
            </div>
            <div class="clear"></div>
            <?php /* <p class="note">Don't see a time that works? <a href="#">Send a message</a> to request a time</p> */ ?>
        </div>
    </div>

    <div id="time_picker">
        <div class="popup_notify" style="display: block;min-height:25px"></div>
        <p class="selected_date">Wednesday January 16</p>
        <p>Select time for your video chat :</p>

        <div class="times-placeholder">
            <div class="time_listing"></div>
            <div class="clear"></div>
            <div id="action_btns">
                <a id="make_request" href="#" class="round_button active">Make Request</a>
                <a href="#" class="round_button close_btn">Cancel</a>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <!-- Timepicker div ends -->
</div>
<script type="text/javascript">
    var templateDir = "<?php bloginfo('template_directory'); ?>";
    var member_id = "<?php echo bp_displayed_user_id(); ?>";
    <?php
            $str = 'var dates = [';
            if(is_array($dates)){
                foreach($dates as $dt){
                    $str .= 'new Date('. date('Y, m, d', strtotime($dt->schedule_date .' -1 month')) .'),';
                }
                $str = rtrim($str, ',');
            }
            $str .= '];';
            echo $str;
    ?>

    <?php
            $str = 'var m_dates = [';
            if(is_array($mdates)){
                foreach($mdates as $dt){
                    $str .= 'new Date('. date('Y, m, d', strtotime($dt->schedule_date .' -1 month')) .'),';
                }
                $str = rtrim($str, ',');
            }
            $str .= '];';
            echo $str;
    ?>
</script>
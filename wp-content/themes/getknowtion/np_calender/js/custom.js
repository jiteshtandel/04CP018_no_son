/*var dates = [new Date(2014, 9 - 1, 19),
    new Date(2014, 9 - 1, 20),
    new Date(2014, 9 - 1, 21),
    new Date(2014, 10 - 1, 31)];*/

var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

var date_input;
var member_date_input;
var selected_date;
var first_half = 1;

(function($){

    $(".manage_calender").bind('click',function(){
        open_fancybox();
    });

    $(".close_btn").bind('click',function(){
        $.fancybox.close();
    });

    $("#schedule_requests .accept").bind('click',function(){
        var $this = $(this);
        var schedule_time_id = $this.data('schedule_time_id');
        var batch_id = $this.data('batch_id');
        var requester_id = $this.data('requester_id');

        response_time_schedule(requester_id, batch_id, schedule_time_id, 1);

        return false;
    });

    $("#schedule_requests .reject").bind('click',function(){
        var $this = $(this);
        var schedule_time_id = $this.data('schedule_time_id');
        var batch_id = $this.data('batch_id');
        var requester_id = $this.data('requester_id');

        response_time_schedule(requester_id, batch_id, schedule_time_id, 2);
        return false;
    });

    date_input = $( "#datepicker" ).datepicker({
        inline: true,
        beforeShowDay: highlightDays,
        dateFormat : "yy-mm-dd",
        minDate: 0,
        onSelect : function(){
            update_selected_date("#datepicker",".current_date");
            load_time_slot($(date_input).val());
        }
    });

    secondary_date_input = $( "#datepicker_secondary" ).datepicker({
        inline: true,
        beforeShowDay: highlightDays,
        dateFormat : "yy-mm-dd",
        minDate: 0,
        onSelect : function(){
            open_fancybox();
        }
    });

    /*on members details page calender */
    member_date_input = $( "#datepicker_member" ).datepicker({
        inline: true,
        dateFormat : "yy-mm-dd",
        beforeShowDay: highlightDaysMember,
        minDate: 0,
        onSelect : function(selected, event){
            console.log(member_date_input);
            load_member_times();
        }
    });

    selected_date = $(date_input).val();
    update_selected_date("#datepicker",".current_date");

    function highlightDays(date) {

        if(typeof dates == "undefined"){
            return false;
        }

        for (var i = 0; i < dates.length; i++) {
            if (dates[i].getTime() == date.getTime()) {
                return [true, 'highlight'];
            }
        }
        return [true, ''];
    }

    function highlightDaysMember(date) {

        if(typeof m_dates == "undefined"){
            return false;
        }

        for (var i = 0; i < m_dates.length; i++) {
            if (m_dates[i].getTime() == date.getTime()) {
                return [true, 'highlight'];
            }
        }
        return [true, ''];
    }

    $("input:radio[name=first_half]").click(function(){
        first_half = $(this).val();
    });

    var open_fancybox = function(){
        clearMessage();
        $('.fancybox').fancybox({
            fitToView	: false,
            width		: 710,
            height		: 520,
            autoSize	: false,
            closeClick	: false,
            openEffect	: 'none',
            closeEffect	: 'none',
            showCloseButton : false,
            padding: 0,
            helpers: {
                overlay: {
                    locked: false
                }
            }
        });
    }

    var load_time_slot = function($date){
        showLoader();
        clearMessage();
        $(".timer_schedule").prop('checked',false).prop('disabled','');

        $.ajax({
            type       : "GET",
            data       : {date : $date},
            dataType   : "json",
            url        : templateDir + "/np_calender/ajax/load_time_slot.php",
            success    : function(data){
                if(typeof data != "undefined" && data != null){
                    var times = data.times;
                    $.each(times, function(key, value){
                        $("#timer_"+value.time_id).prop('checked',true);
                        if(value.disable == 1){
                            $("#timer_"+value.time_id).prop('disabled','disabled');
                        }
                    });
                    $("#first_half_" + data.first_half_action).prop('checked', true);

                } else {
                    console.log('no time records found');
                }
            },
            error : function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            },
            complete : function(){
                hideLoader();
            }
        });
    }

    var save_dates = function(date, time_batches){

        clearMessage();
        if(time_batches.length <= 0){
            showMessage('error',"No time schedule selected.");
            return false;
        }
        showLoader();
        $.ajax({
            type       : "POST",
            data       : {date : date, time_batches : time_batches, first_half : first_half},
            url        : templateDir + "/np_calender/ajax/save_time_batch.php",
            dataType   : "json",
            success    : function(data){
                console.log(data);
                if(typeof data != "undefined" && data != ''){
                    console.log(data.status);
                    if(data.status == true){
                        $("#calender .ui-state-active").parent('td').addClass('highlight');
                        showMessage('success',"Record saved !");
                        dates.push(selected_date);
                    }
                }
            },
            error : function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                showMessage('error',"Error occurred, please try again!");
            },
            complete : function(){
                hideLoader();
            }
        });
    }

    var load_member_times = function(){
        var selected_date = $("#datepicker_member").datepicker("getDate");
        var date = member_date_input.val();
        showLoader();
        clearMessage();
        $.ajax({
            type       : "POST",
            data       : {request_date : date, member_id : member_id},
            url        : templateDir + "/np_calender/ajax/load_member_time_batch.php",
            dataType   : "html",
            success    : function(data){
                if(typeof data != "undefined" && data != ''){
                    update_selected_date("#datepicker_member",".selected_date");
                    $("#time_picker .time_listing").html(data);

                    $.fancybox.open({
                        href : "#time_picker",
                        padding: 0,
                        helpers: {
                            overlay: {
                                locked: false
                            }
                        }
                    });
                }
            },
            error : function(jqXHR, textStatus, errorThrown) {
                //alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                showMessage('error',"Error occurred, please try again!");
            },
            complete : function(){
                hideLoader();
            }
        });
    }

    var make_request_for_time = function(user_id, schedule_date, batch_id, time_batch){
        clearMessage();
        if(time_batch.length <= 0){
            showMessage('error',"No time schedule selected.");
            return false;
        }
        showLoader();
        $.ajax({
            type       : "POST",
            data       : {user_id : user_id, request_date : schedule_date, batch_id : batch_id, time_batches:time_batch},
            url        : templateDir + "/np_calender/ajax/request_member_time_batch.php",
            dataType   : "json",
            success    : function(data){
                if(typeof data != "undefined" && data != null){
                    if(data.status){
                        showMessage('success',data.message);
                    } else {
                        showMessage('error',data.message);
                    }
                }
            },
            error : function(jqXHR, textStatus, errorThrown) {
                showMessage('error',"Error occurred, please try again!");
            },
            complete : function(){
                hideLoader();
            }
        });
    }

    var response_time_schedule = function(requester_id, batch_id, schedule_time_id, status){
        showLoader();
        clearMessage();
        $.ajax({
            type       : "POST",
            data       : {requester_id : requester_id, batch_id : batch_id, schedule_time_id:schedule_time_id, status : status},
            url        : templateDir + "/np_calender/ajax/response_time_schedule.php",
            dataType   : "json",
            success    : function(data){
                if(typeof data != "undefined" && data != null){
                    if(data.status == "success"){
                        if(status == 1){
                            $(".schedule_time_" + schedule_time_id).hide();
                        } else {
                            $("#schedule_" + requester_id +"_"+schedule_time_id).hide();
                        }
                        /*if($("#schedule_requests li").length<=0){
                            $("#schedule_requests").insertAfter('<div id="errornotify"></div>');
                            $("#errornotify").notification({caption: "Sorry, no records found.",type:"warning",sticky:true});
                        }*/
                        showMessage('success',data.message);
                    } else {
                        showMessage('error',data.message);
                    }
                }
            },
            error : function(jqXHR, textStatus, errorThrown) {
                //alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                showMessage('error',data.message);
            },
            complete : function(){
                hideLoader();
            }
        });
    }


    $("#schedule_button").bind('click',function(){
        // insert/update selected date's times
        var time_batches = [];
        $.each($('input[type="checkbox"][name="time_batch"]:checked'), function(key, element){
            time_batches.push($(element).val());
        });
        save_dates(date_input.val(), time_batches);
    });

    $("#make_request").bind('click',function(){
        var time_batches = [];
        var batch_id = $("#time_picker .time_listing ul").data('batch_id');
        $.each($('input[type="checkbox"][name="time_batch_member"]:checked'), function(key, element){
            time_batches.push($(element).val());
        });
        make_request_for_time(member_id,member_date_input.val(), batch_id, time_batches);
    });

    function update_selected_date(dom, dt_placeholder){
        selected_date = $(dom).datepicker( "getDate" );
        console.log(selected_date);
        if(typeof selected_date == "undefined"){
            return false;
        }
        var txt_date = days[selected_date.getDay()] + " " + months[selected_date.getMonth()] +" "+ selected_date.getDate() +", "+ selected_date.getFullYear();
        //$(".current_date").html(txt_date);
        $(dt_placeholder).html(txt_date);
    }

    showMessage = function(type, message){
        var status = "information";
        if( type=="error"){ status = "warning" }
        jQuery(".popup_notify").notification({caption: message, type:status, sticky:true});
    }

    clearMessage = function(){
        jQuery(".popup_notify").html('').attr('class','popup_notify');
    }

})(jQuery);
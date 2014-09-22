jQuery(document).ready(function(){
    jQuery.fn.raty.defaults.path = ajax_var.themepath+'/images/icons';
    jQuery('.star_rating').raty({
            half  : false,
            readOnly: false,
            starOff  : 'star-off.png',
            starOn   : 'star-on.png',
            number: 5		
    });
    jQuery("#reviewform").validate({
        debug:false, onsubmit: true, onfocusout: false, onkeyup: false,onfocus:false,
        ignore: "",
        rules: {
            review: {
                required:true
            },
            score: {
                required:true
            }
        },
        messages: {
            review: {
                required: "Please enter review."
            },
            score: {
                required: "Please give a rating."
            }
        },
        showErrors: validationErrorspopup,
        submitHandler: validationSuccessspopup
    });
        
});
function validationErrorspopup(errorMap, errorList) {
    if(errorList.length==0) return;
    var msgs=[];
    for(var err=0;err<errorList.length;err++) {
        msgs.push({ message: errorList[err].message });
    }
    jQuery("#popupnotify").notification({caption: "One or more invalid inputs found:", messages: msgs, sticky:true});
}

function validationSuccessspopup(form) {
    showLoader();
    submitReview();
}

function submitReview(sessionid, to_userid, from_userid){
    jQuery('#submitreview').attr('disabled','disabled');
    var review=jQuery("#reviewtext").val();
    var rating=jQuery(".scorerating").val();
    var sessiontime=jQuery("#calltimer").html();
    
    var to_userid=jQuery("#to_userid").val();
    var from_userid=jQuery("#from_userid").val();
    var sessionid=jQuery("#sessionid").val();
    
    // Ajax call
    jQuery.ajax({
        type: "post",
        url: ajax_var.url,
        data: "action=post-review&nonce="+ajax_var.nonce+"&from_userid=" + from_userid + "&to_userid=" + to_userid + "&review=" + review + "&rating=" + rating + "&sessionid=" + sessionid + "&sessiontime=" + sessiontime,
        success: function(data){
            hideLoader();
            jQuery('#submitreview').removeAttr('disabled');
            if(data=="success"){
                jQuery("#popupnotify").notification({caption:"Your review submitted successfully. Thank You.",type:"information", sticky:false,hidedelay:1500, onhide:function(){
                        hideReviewPopup();
                        window.location.href=useroncall_domain;
                }});
            }
            else{
                jQuery("#popupnotify").notification({caption:"Error while processing review data. Please try again.",type:"warning", sticky:true});
            }
            
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            hideLoader();
            jQuery('#submitreview').removeAttr('disabled');
            jQuery("#popupnotify").notification({caption:"Error while processing review data. Please try again.",type:"warning", sticky:true});
        }                
    });
}
function showReviewPopup(sessionid, userid, loggedinuserid) {
	var windowWidth=jQuery(window).width();
	var windowHeight=jQuery(window).height();

	var popupWidth=parseInt(jQuery("#reviewbox").width());
	var popupHeight=parseInt(jQuery("#reviewbox").height());

	var popupLeft=((windowWidth/2) - (popupWidth/2));
	var popupTop = jQuery(document).scrollTop() + (windowHeight - popupHeight)/2;

	jQuery("#reviewbox").css("left", popupLeft + "px");
	jQuery("#reviewbox").css("top", popupTop + "px");
	showPopupLoader();
        jQuery('#reviewbox #reviewtext').val('');
        jQuery('#reviewbox .star_rating').raty({ score: 0 });
        jQuery('#reviewbox #popupnotify').hide();
    
	jQuery("#reviewbox").fadeIn(1000);
}
function hideReviewPopup() {
	hideLoader();
	jQuery("#reviewbox").stop().hide();
	jQuery("#popupmodel").hide();
        window.location.href=useroncall_domain;
}

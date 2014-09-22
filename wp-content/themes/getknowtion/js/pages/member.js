jQuery(document).ready(function(){
    jQuery.fn.raty.defaults.path = ajax_var.themepath+'/images/icons';
    jQuery('.member-overall-rating').raty({
            half  : true,
            readOnly: true,
            starOff  : 'star-off.png',
            starOn   : 'star-on.png',
            number: 5,
            width:'auto',
            score: function() {
                return jQuery(this).attr('overallrating');
            }
    });
    configreviewrating();    
});
function configreviewrating(){
    jQuery('.star_rating_small').raty({
            half  : false,
            readOnly: true,
            starOff  : 'star-off-small.png',
            starOn   : 'star-on-small.png',
            number: 5,
            score: function() {
                return jQuery(this).attr('overallrating');
            }
    });
}

function loadmorereviews(nextpage){
    //showLoader();
    // Ajax call
    jQuery.ajax({
        type: "post",
        url: ajax_var.url,
        data:"action=get-user-reviews&page=" + nextpage + "&nonce="+ajax_var.nonce,
        success: function(data){
            //hideLoader();
            jQuery("#activity-stream #load-more").remove();  
            jQuery("#activity-stream").append(data);
            configreviewrating();                
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            //hideLoader();
        }                
    });
}
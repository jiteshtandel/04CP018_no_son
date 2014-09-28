var session;
var logouturl;
function showPopupLoader() {
    relocateModelAreas();
    jQuery("#popupmodel").css("opacity", 0.7);
    jQuery("#popupmodel").show();
}

function showLoader(type) {
	relocateLoader();
	jQuery("#loader").stop().fadeIn(500);
}

function hideLoader() {
	jQuery("#loader").stop().hide();
}

function relocateObjects() {
	relocateModelAreas();
	relocateLoader();
}

function relocateLoader() {
	var windowWidth=jQuery(window).width();
	var windowHeight=jQuery(window).height();

	var loaderWidth=parseInt(jQuery("#loader").css("width"));
	var loaderHeight=parseInt(jQuery("#loader").css("height"));

	var loaderLeft=((windowWidth/2) - (loaderWidth/2));
	var loaderTop= jQuery(document).scrollTop() + ((windowHeight/2) - (loaderHeight/2));

	jQuery("#loader").css("left", loaderLeft + "px");
	jQuery("#loader").css("top", loaderTop + "px");
	jQuery("#loader").css("opacity", "0.7");
}

function relocateModelAreas() {
	jQuery("#popupmodel").css("left", "0px");
	jQuery("#popupmodel").css("top", "0px");
	jQuery("#popupmodel").width(jQuery(document).width());
	jQuery("#popupmodel").height(jQuery(document).height());		
}
 
//jQuery(window).scroll(relocateObjects);
jQuery(window).resize(relocateObjects);


function relocateLoader() {
        var windowWidth=jQuery(window).width();
        var windowHeight=jQuery(window).height();

        var loaderWidth=parseInt(jQuery("#loader").css("width"));
        var loaderHeight=parseInt(jQuery("#loader").css("height"));

        var loaderLeft=((windowWidth/2) - (loaderWidth/2));
        var loaderTop= jQuery(document).scrollTop() + ((windowHeight/2) - (loaderHeight/2));

        jQuery("#loader").css("left", loaderLeft + "px");
        jQuery("#loader").css("top", loaderTop + "px");
        jQuery("#loader").css("opacity", "0.5");	
}

function showLoader() {
    relocateLoader();
    jQuery("#loader").stop().fadeIn(500);
}

function hideLoader() {
    jQuery("#loader").stop().hide();
}

jQuery(document).ready(function(){
    jQuery(".menu .user").click(function(){
        jQuery(".headersubmneu").hide();
        var X=jQuery(this).attr('id');
        if(X==1){
            jQuery(this).siblings(".headersubmneu").hide();
            jQuery(this).attr('id', '0');
        }
        else {
            jQuery(this).siblings(".headersubmneu").show();
            jQuery(this).attr('id', '1');
        }
    });
    
    //Mouse click on sub menu
    jQuery(".headersubmneu").mouseup(function(){
        return false
    });

    //Mouse click on my account link
    jQuery(".menu .user").mouseup(function(){
        return false
    });

    //Document Click
    jQuery(document).mouseup(function(){
        jQuery(".headersubmneu").hide();
        jQuery(".menu .user").attr('id', '');
    });
});

function myredirect(location){
    window.location.href=location;
}

function MemberLogout(redirecturl){
    logouturl=redirecturl;
    session = TB.initSession(sessionId);
    session.addEventListener("sessionDisconnected", connectionDisconnectedHandler);
    session.disconnect();
    //myredirect(redirecturl);
}
function connectionDisconnectedHandler(event){
    myredirect(logouturl);
}
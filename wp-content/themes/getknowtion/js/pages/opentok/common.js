//var PUBLISHER_WIDTH = 220;
//var PUBLISHER_HEIGHT = 165;
var stateManager;  
var session; var publisher;
var userconnectionid;
var callstatus = 0; var oncallwith;
var suppressStatemanagerEvent = true;

TB.addEventListener("exception", exceptionHandler);
session = TB.initSession(sessionId);
session.addEventListener("sessionConnected", sessionConnectedHandler);
session.addEventListener("streamCreated", streamCreatedHandler);
//session.addEventListener("signalReceived", signalEventHandler);
session.addEventListener("connectionCreated", connectionCreatedHandler);

function exceptionHandler(event) {
    alert("Exception: " + event.code + "::" + event.message);
}

function connectionCreatedHandler(event){
    console.log(event);

    for (var i = 0; i < event.connections.length; i++) {
        var condata = event.connections[i].data;
        if(condata.indexOf(usertocall) != -1){
			/*
            if(document.getElementById("callbutton")){
                document.getElementById("callbutton").value = "Call Now";
            }
			*/
			//if(jQuery("#callbutton")){
				jQuery("#callbutton").css("backgroundColor", "#006738");
				jQuery("#callbutton").click(sendSignalUserCalling);
			//}
            userconnectionid = event.connections[0];
        }
    }
}

function sessionConnectedHandler(event){
    console.log("in sessionConnectedHandler:: " + usertocall);   
	console.log("callstatus: " + callstatus);
    console.log(event);
    //tempstream = event;

    for (var i = 0; i < event.connections.length; i++) {
        console.log(event.connections[i].data);
        //if(event.connections[i].data == usertocall){
        var condata = event.connections[i].data;
        if(condata.indexOf(usertocall) != -1){
			if(callstatus == 2){
				if(event.streams){
					//addStreamToDom(event.streams[i]);
					//startTimer();
					subscribeToStreams(event.streams);
				}
			}
			else{
				jQuery("#callbutton").css("backgroundColor", "#006738");
				jQuery("#callbutton").click(sendSignalUserCalling);
			}
			userconnectionid = event.connections[i];
            console.log(userconnectionid);
        }
    }
    
    if(!stateManager){
        stateManager = session.getStateManager();
        console.log(stateManager);
        stateManager.addEventListener("changed:" + iam, stateChangedHandler);
        suppressStateManagerHandler();
        //
		
		if(callstatus == 2){
			jQuery("#chatsendbutton").click(sendChat);
			jQuery("#chatsendbutton").css("backgroundColor", "#006738");
		
			jQuery("#messagebox").keyup(function(event){
				if((event.keyCode == 13) || (event.which == 13)){
					sendChat();
				}
			});
			
			callStarted();
		}
    }
}

function suppressStateManagerHandler(){
   setTimeout(function(){
            suppressStatemanagerEvent = false;
   }, 1000); 
}

function streamCreatedHandler(event){
    console.log("in streamCreatedHandler:: " + callstatus);
    console.log(event);
    if(callstatus == 2){
        subscribeToStreams(event.streams);
        //closeOutgoingCallPopUp();   
    }
    //if((callstatus == 1) || (callstatus == 2)){
    /*
    if(callstatus == 1){
        callstatus = 2;
        subscribeToStreams(event.streams);
        publish();
        //closeOutgoingCallPopUp();
    }
    else if(callstatus == 2){
        subscribeToStreams(event.streams);
        //closeOutgoingCallPopUp();   
    }
    */
}

function addStreamToDom(obj){
	// Create a div for the publisher to replace
	var parentDiv = document.getElementById("callerCamera");
	var stubDiv = document.createElement("div");
	stubDiv.id = "new_stream";
	parentDiv.appendChild(stubDiv);
	
	var subscriberProps = {width: 600,
									height: 556,
									subscribeToAudio: true};
	session.subscribe(obj, stubDiv.id, subscriberProps);
}

function subscribeToStreams(streams) {
console.log(usertocall);
    for (var i = 0; i < streams.length; i++) {
            var stream = streams[i];
			console.log(stream.connection.connectionId);
			console.log(session.connection.connectionId);
			console.log(stream.connection.data);
            if (stream.connection.connectionId != session.connection.connectionId) {
                var condata = stream.connection.data;
                //if(condata.indexOf(usertocall) != -1){
                //if(stream.connection.data == usertocall){
					addStreamToDom(stream);
					/*
                    // Create a div for the publisher to replace
                    var parentDiv = document.getElementById("callerCamera");
                    var stubDiv = document.createElement("div");
                    stubDiv.id = "new_stream";
                    parentDiv.appendChild(stubDiv);
					
					var subscriberProps = {width: 600,
													height: 556,
													subscribeToAudio: true};
                    session.subscribe(stream, stubDiv.id, subscriberProps);
					*/
					//callerStreamReceived();
                //}
            }
    }
}

function connect(){
	console.log("in connect here");
    session.connect(apiKey, token); 
}

function publish(){
	console.log("in publish");
    if(!publisher){
    // Create a div for the publisher to replace
    var parentDiv = document.getElementById("myCamera");
    var stubDiv = document.createElement("div");
    stubDiv.id = "opentok_publisher";
    parentDiv.appendChild(stubDiv);

    var publisherProps = {width: 340, height: 260, publishAudio: true};
    publisher = TB.initPublisher(apiKey, stubDiv.id, publisherProps);
    session.publish(publisher);

    //stateManager = session.getStateManager();
    //console.log(stateManager);
    //stateManager.addEventListener("changed:" + iam, stateChangedHandler);
    }
}

function stateChangedHandler(event){
    console.log(event);
    console.log("supressStatemanagerEvent:: " + suppressStatemanagerEvent);
    if(suppressStatemanagerEvent){
        return false;
    }
    var currentmessage = event.changedValues[iam];
    if(currentmessage){
        console.log("Message for User 1: " + event.changedValues[iam]);
        //usertocall = currentmessage.split("|||")[1];
        if(currentmessage.indexOf("^#!@calling@!#^") != -1){
			if(callstatus != 2){
				callstatus = 1;
				usertocall = currentmessage.split("|||")[1];
				openIncomingCallPopup(currentmessage);
			}
        }
        else if(currentmessage.indexOf("^#!@callrejected@!#^") != -1){
            callstatus = 0;
            unPublish();
            closeOutgoingCallPopUp();
        }
        else if(currentmessage.indexOf("^#!@noanswer@!#^") != -1){
            callstatus = 0;
            unPublish();
            closeOutgoingCallPopUp();
        }
        else if(currentmessage.indexOf("^#!@callaccepted@!#^") != -1){
            /*
            callstatus = 2;
            closeOutgoingCallPopUp();
            publish();
            */
			//usertocall = currentmessage.split("|||")[1];
			//alert("../../video?" + usertocall);
			//console.log(window.location);
			window.location=home_url + "/video/?" + usertocall;
        }
        else if(currentmessage.indexOf("^#!@callended@!#^") != -1){
            callstatus = 0; // idle
            unPublish();
            showReviewPopup();
			
			//stop the timer
			jQuery('#calltimer').runner('stop');
			jQuery('#callmessage').html("Call ended with " + useroncallname);
        }
        else if(currentmessage.indexOf("^#!@callcancelled@!#^") != -1){
            callstatus = 0; // idle
            unPublish();
            closeIncomingCallPopUp();
        }
        else{
            if(callstatus != 0){
                var collector = document.getElementById("messagecollector");
                //var sendername = currentmessage.split("|||");
                collector.innerHTML = collector.innerHTML + "<br/><b>" + useroncallname + "</b>: " + event.changedValues[iam]; 
				collector.scrollTop = collector.scrollHeight;
            }
        }
        
        
    }
}

function sendSignalUserCalling(){
    /*
    callstatus = 1; // user called
    session.signal({
        type: "begincall",
        to: userconnectionid,
        data: "hello"
        //data: { streamId: _selfstream.streamId + "|" + _selfstream.name }
    },
    function (error) {
        if (error) {
            console.log("signal error: " + error.reason);
        } else {
            console.log("signal sent: begincall:");
        }
    });
    */
   
    callstatus = 1;
    stateManager.set(usertocall, "^#!@calling@!#^|||" + myidentity);
    // open calling popup
    openOutgoingCallPopup(userconnectionid);
}

function sendSignalCallAccepted(){
    stateManager.set(usertocall, "^#!@callaccepted@!#^|||" + myidentity);
    /*
    callstatus = 2; // on call
    session.signal({
        type: "acceptcall",
        to: oncallwith,
        data: "hello"
        //data: { streamId: _selfstream.streamId + "|" + _selfstream.name }
    },
            function (error) {
                if (error) {
                    console.log("signal error: " + error.reason);
                } else {
                    console.log("signal sent: begincall:");
                }
            }
        );
        */
}

function sendSignalCallCancelled(){
    stateManager.set(usertocall, "^#!@callcancelled@!#^|||" + myidentity);
}

function sendSignalCallRejected(){
    stateManager.set(usertocall, "^#!@callrejected@!#^|||" + myidentity);
}

function sendSignalCallDisconnected(){
    callstatus = 0; // idle
    stateManager.set(usertocall, "^#!@callended@!#^|||" + myidentity);
    /*
    session.signal({
        type: "disconnectcall",
        to: oncallwith,
        data: "hello"
        //data: { streamId: _selfstream.streamId + "|" + _selfstream.name }
    },
    function (error) {
        if (error) {
            console.log("signal error: " + error.reason);
        } else {
            console.log("signal sent: begincall:");
        }
    });
    */

    // clear all streams
    unPublish();
	
	//stop the timer
	jQuery('#calltimer').runner('stop');
	jQuery('#callmessage').html("Call ended with " + useroncallname);
}

function unPublish(){
    if(publisher){
    // my code to clear screen
        session.unpublish(publisher);
        publisher = false;
    }
}
/*
function signalEventHandler(event) {
    console.log(event);
}
*/
function sendChat(){
	if(stateManager){
		var message = document.getElementById("messagebox").value;
		var collector = document.getElementById("messagecollector");
		collector.innerHTML = collector.innerHTML + "<br/>Me: " + message;
		document.getElementById("messagebox").value = "";
		stateManager.set(usertocall, message);
		
		collector.scrollTop = collector.scrollHeight;
	}
}

function openOutgoingCallPopup(obj){
    //console.log(obj);
    //temp = obj;
    //var callerdata = obj.data;
    var callerdata = obj.data.split("|||");
    jQuery("#outgoingcallpopup").css("left", (jQuery(document).width()/2) - (jQuery("#outgoingcallpopup").width() / 2));
    //jQuery("#outgoingcallpopup").css("top", (jQuery(document).height()/2) - (jQuery("#outgoingcallpopup").height() / 2));
    jQuery("#outgoingcallpopup").css("top", jQuery("#outgoingcallpopup").height() / 2);
	
    //var html = "<img src='" + callerdata[2].replace("path=", "") + "' width='32' height='32' /> " + " Calling.. " + callerdata[1].replace("name=", "");
    //jQuery("#outgoingcallpopup").html(html);
    jQuery("#outgoingcallpopup").find("img").attr("src", callerdata[2].replace("path=", ""));
    jQuery("#outgoingcallpopup").find("span").html(" Calling.. " + callerdata[1].replace("name=", ""));
    jQuery("#outgoingcallpopup").show();

    jQuery("#callcancel").click(function(){
        cancelCall();
    });

    setTimeout(function(){
        if(callstatus == 1){
            callstatus = 0; // idle
            //jQuery("#outgoingcallpopup").html("No Answer");
            closeOutgoingCallPopUp();
        }
    }, 40000);
    
	showPopupLoader();
}

function closeOutgoingCallPopUp(){
    jQuery("#outgoingcallpopup").hide();
	jQuery("#popupmodel").hide();
}

function openIncomingCallPopup(obj){
    //console.log(obj);
    //temp = obj;
    //var callerdata = obj.data;
    //var callerdata = obj.data.split("|||");
    var callerdata = obj.split("|||");
    jQuery("#incomingcallpopup").css("left", (jQuery(document).width()/2) - (jQuery("#incomingcallpopup").width() / 2));
    //jQuery("#incomingcallpopup").css("top", (jQuery(document).height()/2) - (jQuery("#incomingcallpopup").height() / 2));
	jQuery("#incomingcallpopup").css("top", jQuery("#incomingcallpopup").height() / 2);
    
    //var html = "<img src='" + callerdata[2].replace("path=", "") + "' width='32' height='32' /> " + " Calling.. " + callerdata[1].replace("name=", "");
    //jQuery("#outgoingcallpopup").html(html);
    jQuery("#incomingcallpopup").find("img").attr("src", callerdata[3].replace("path=", ""));
    jQuery("#incomingcallpopup").find("span").html(callerdata[2].replace("name=", "") + " Calling..");
    jQuery("#incomingcallpopup").show();

    //var currevent = event;
    jQuery("#callacceptbutton").click(function(){
        acceptCall(callerdata[1]);
    });
    jQuery("#rejectcallbutton").click(function(){
        rejectCall();
    });

    setTimeout(function(){
        incomingcallNoAnswer();
    }, 40000);
    
    showPopupLoader();
}

function incomingcallNoAnswer(){
    console.log("here:: " + callstatus);
    //if((callstatus != 2) || (callstatus != 0)){
    if(callstatus == 1){
        callstatus = 0; // idle
        //console.log("in here");
        //jQuery("#outgoingcallpopup").html("No Answer");
        
        stateManager.set(usertocall, "^#!@noanswer@!#^|||" + myidentity);
        closeIncomingCallPopUp();
    }
}

function closeIncomingCallPopUp(){
    jQuery("#incomingcallpopup").hide();
	jQuery("#popupmodel").hide();
}

function acceptCall(callfrom){
	//console.log(window.location);
	sendSignalCallAccepted();
	setTimeout(function(){
		//alert("../../video/?" + callfrom);
                window.location=home_url + "/video/?" + callfrom;
	}, 1000);
   //window.location="../videocall.php";
   
}

function rejectCall(){
    callstatus = 0;
    //stateManager.set(usertocall, "^#!@callrejected@!#^|||" + myidentity);
    sendSignalCallRejected();
    closeIncomingCallPopUp();
}

function cancelCall(){
    callstatus = 0;
    sendSignalCallCancelled();
    closeOutgoingCallPopUp();
}

function callStarted(){
	jQuery("#waitingmessage").html("<span id=\"callmessage\">On call with " + useroncallname + "</span>&nbsp;-&nbsp;<span id=\"calltimer\">00:00</span>&nbsp;(MM:SS)");
	
	jQuery("#endcall").css("display", "block");
	jQuery("#endcall").click(function(){
		jQuery("#endcall").css("display", "none");
		jQuery("#chatsendbutton").css("backgroundColor", "#858585");
		jQuery("#chatsendbutton").unbind("click");
		sendSignalCallDisconnected();
		showReviewPopup();
	});
	
	/*
	jQuery("#chatsendbutton").click(sendChat);
	jQuery("#chatsendbutton").css("backgroundColor", "#006738");
	
	jQuery("#messagebox").keyup(function(event){
		if((event.keyCode == 13) || (event.which == 13)){
			sendChat();
		}
	});
	*/
	
	startTimer();
}

function startTimer(){
	// start the timer
	if(jQuery('#calltimer')){
		jQuery('#calltimer').runner({milliseconds : false});
		jQuery('#calltimer').runner('start');
	}
}

//console.log(autoconnect);
if(typeof(autoconnect) != "undefined"){
	connect();
}

/*
if(startCall){
    console.log("in start call");
    connect();
    publish();
}
*/
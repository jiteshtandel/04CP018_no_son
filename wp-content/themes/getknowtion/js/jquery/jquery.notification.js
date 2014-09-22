(function($) {
	$.fn.notification = function(options) {
		//debug(this);

		var opts = $.extend({}, $.fn.notification.defaults, options);

		return this.each(function() {
   			$this = $(this);
   			// build element specific options
   			var o = $.meta ? $.extend({}, opts, $this.data()) : opts;

			//$(document).scrollTop($this.position().top);

			$this.hide();
			if($this.hasClass("notify_warning")) $this.removeClass("notify_warning");
			if($this.hasClass("notify_information")) $this.removeClass("notify_information");
			if($this.hasClass("notify_help")) $this.removeClass("notify_help");
                        if($this.hasClass("notify_error")) $this.removeClass("notify_error");
			
			if(o.type=="warning") {
				$this.addClass("notify_warning");
			}
			else if(o.type=="information"){
				$this.addClass("notify_information");
			}
			else if(o.type=="error"){
				$this.addClass("notify_error");
			}
			else {
				$this.addClass("notify_help");
			}

			$this.html("<label>" + o.caption + "</label>");
			if(o.messages.length>0) {
				$this.append("<ul></ul>");
				for(var msg=0;msg<o.messages.length;msg++) {
					$this.find("ul").append("<li>" + o.messages[msg].message + "</li>");
				}
			}
			
			// For help type notification
			if(o.type=="help"){
				$this.append("<div></div>");
				$this.find("div").append('<input type="checkbox" name="showhelp" id="showhelp" /> <label for="showhelp" id="helplabel"> ' + o.helpmessage + '</label>');
			}
			
			if(o.sticky) {
				$this.fadeIn(1000, o.onshow);
			}
			else {
				$this.fadeIn(1000, function() {
					var $obj=$(this);
					o.onshow();
					setTimeout(function() {
						$obj.fadeOut(500, o.onhide);
					}, o.hidedelay);
				});
			}
			
			// For only help type notification
			$this.find("#showhelp").bind("click",{"showhelp": o.showhelp, "notify": $this},function(event) {
				if($(this).attr('checked')) {
					var notify=event.data.notify;
					$(notify).fadeOut(500, o.onhide);
				}
				event.data.showhelp(event);
			});
		});
	};

	function debug($obj) {
		if(window.console && window.console.log)
		window.console.log('hilight selection count: ' + $obj.size());
	};

	function onnotify_show() {
		
	};

	function onnotify_hide() {
		
	};


	$.fn.notification.defaults = {
		caption: "Warning!",
		sticky: false,
		hidedelay:1000,
		type: "warning", // type can either be "warning" or "information".
		messages: [],
		helpmessage: "Do not show this help again.",
		onshow:onnotify_show,
		onhide:onnotify_hide,
		showhelp:function() { }
	};
})(jQuery);

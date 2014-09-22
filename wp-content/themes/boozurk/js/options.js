var themeOptions;

(function($) {

themeOptions = {

	//initialize
	init : function() {

		var frame;

		themeOptions.switchTab('style');

		$('#to-defaults').click (function () {
			var answer = confirm(theme_options_l10n.confirm_to_defaults)
			if (!answer){
				return false;
			}
		});

		$('#choose-logo-from-library-link').click( function( event ) {
			var $el = $(this);

			event.preventDefault();

			// If the media frame already exists, reopen it.
			if ( frame ) {
				frame.open();
				return;
			}

			// Create the media frame.
			frame = wp.media.frames.customLogo = wp.media({
				// Set the title of the modal.
				title: $el.data('choose'),

				// Tell the modal to show only images.
				library: {
					type: 'image'
				},

				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: $el.data('update'),
					// Tell the button not to close the modal, since we're
					// going to refresh the page when the image is selected.
					close: true
				}
			});

			// When an image is selected, run a callback.
			frame.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = frame.state().get('selection').first().toJSON();
				$('#option_field_boozurk_logo').val(attachment.url);
			});

			// Finally, open the modal.
			frame.open();
		});

		$('#theme-options .theme_option_cp').each(function() {
			$this = $(this);
			$this.wpColorPicker({
				change: function( event, ui ) {
					$this.val( $this.wpColorPicker('color') );
				},
				clear: function() {
					$this.val( '' );
				},
				palettes: ['#21759b','#404040','#87ceeb','#000','#fff','#aaa','#ff7b0a','#f7009c']
			});
		});

	},

	//show only a set of rows
	switchTab : function (thisset) {
		if ( thisset != 'info' ) {
			$('#theme-infos').css({ 'display' : 'none' });
			$('#theme-options').css({ 'display' : '' });
			thisclass = '.tabgroup-' + thisset;
			thissel = '#selgroup-' + thisset;
			$('.tabgroup').css({ 'display' : 'none' });
			$(thisclass).css({ 'display' : '' });
			$('#tabselector a').removeClass("nav-tab-active");
			$(thissel).addClass("nav-tab-active");
		} else {
			$('#theme-infos').css({ 'display' : '' });
			$('#theme-options').css({ 'display' : 'none' });
			$('#tabselector a').removeClass("nav-tab-active");
			$('#selgroup-info').addClass("nav-tab-active");
		}
	}

};

$(document).ready(function($){ themeOptions.init(); });

})(jQuery);
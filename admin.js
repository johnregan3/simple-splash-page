(function ($) {
	$(document).ready( function() {
		$("#ssp-preview").click( function(event) {
			event.preventDefault;
			if ( $("#default-css").is( ":checked" ) ) {
				previewUrl = previewUrl + '&default-css';
			}
			window.open( previewUrl );
		});
	});
}(jQuery));
(function ($) {
	$(document).ready( function() {
		jQuery.fn.center = function () {
			this.css({
				"left": ((($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px")
			});
			return this;
		}
		$("#ssp-box").center();
	});
}(jQuery));
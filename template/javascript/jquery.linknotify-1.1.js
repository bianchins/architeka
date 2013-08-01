/**
* linkNotify v1.1 // 2009.06.10
* <http://briancray.com/2009/06/09/jquery-plugin-linknotify-inline-link-click-notification/>
* 
* @author    Brian Cray <webmail@briancray.com>
*/

(function($) {
	$.fn.linkNotify = function (notification) {
		notification = notification || 'Loading&hellip;';
		this.not('[href^="#"]').each(function () {
			$(this).click(function () {
				$(this).html(notification);
			});
		});
		return this;
	};
})(jQuery);
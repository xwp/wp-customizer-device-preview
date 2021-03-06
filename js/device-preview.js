/*global _wpCustomizerDevicePreview */
window.wp = window.wp || {};
(function($) {
	var customizer;
	customizer = wp.customizer = wp.customizer || {};
	customizer.screen = {
		data: _wpCustomizerDevicePreview,
		model: {},
		view: {},
		template: wp.template
	};
	customizer.screen.model = Backbone.Model.extend({});
	customizer.screen.view.Devices = wp.Backbone.View.extend({
		className: 'device',
		activeClass: 'current',
		events: {
			'click .device': 'preview'
		},
		el: 'body',
		previewFrame: $('#customize-preview'),
		html: customizer.screen.template('device'),
		render: function() {
			this.$el.append(this.html);
			this.$el.find('[data-device="desktop"]').addClass(this.activeClass);
			this.previewFrame.addClass('desktop');
			if (customizer.screen.data.settings.mobileTheme) {
				this.previewFrame.append('<p id="mobile-message">' + customizer.screen.data.settings.mobileMessage + '</p>');
			}
		},
		preview: function(event) {
			var $el = $(event.target),
				device = $el.data('device');
			if ($el.hasClass(this.activeClass)) {
				return;
			}
			$('.device').removeClass(this.activeClass);
			$el.addClass(this.activeClass);
			this.previewFrame.removeClass('desktop tablet mobile');
			this.previewFrame.addClass(device);
			new Image().src = document.location.protocol + '//pixel.wp.com/g.gif?v=wpcom-no-pv&x_customizer-device-preview=' + device + '&baba=' + Math.random();
		}
	});
	customizer.screen.Run = {
		init: function() {
			this.view = new customizer.screen.view.Devices({});
			this.view.render();
		}
	};
	jQuery(document).ready(_.bind(customizer.screen.Run.init, customizer.screen.Run));
})(jQuery);
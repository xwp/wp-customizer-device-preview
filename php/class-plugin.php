<?php

namespace CustomizerDevicePreview;

/**
 * Main plugin bootstrap file.
 */
class Plugin extends Plugin_Base {

	/**
	 * @param array $config
	 */
	public function __construct( $config = array() ) {

		$default_config = array(
			// ...
		);

		$this->config = array_merge( $default_config, $config );

		add_action( 'after_setup_theme', array( $this, 'init' ) );

		parent::__construct(); // autoload classes and set $slug, $dir_path, and $dir_url vars
	}

	/**
	 * @action after_setup_theme
	 */
	function init() {
		$this->config = \apply_filters( 'customizer_device_preview_plugin_config', $this->config, $this );

		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'print_templates' ) );
	}

	/**
	 * @acton customize_controls_enqueue_scripts
	 */
	function enqueue_scripts() {
		$handle = 'customizer-device-preview';
		$src = "{$this->dir_url}/css/device-preview.css";
		wp_enqueue_style( $handle, $src );

		$handle = 'customizer-device-preview';
		$src = "{$this->dir_url}/js/device-preview.js";
		$deps = array( 'customize-controls' );
		$ver = false;
		$in_footer = true;
		wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );

		$exports = array(
			'screen' => array(
				'desktop',
				'tablet',
				'mobile',
			),
			'settings' => array(
				'mobileTheme' => false,
				'mobileMessage' => 'You have the Mobile Theme enabled. This view may not represent how your viewers see your blog. You can deactivate the mobile theme on <a href="https://example.wordpress.com/wp-admin/themes.php?page=mobile-options">Appearance &rarr; Mobile</a>.',
			),
		);
		wp_localize_script( $handle, '_wpCustomizerDevicePreview', $exports );
	}

	/**
	 * @action customize_controls_print_footer_scripts
	 */
	function print_templates() {
		?>
		<script id="tmpl-device" type="text/template">
			<div id="devices">
				<div class="devices-container">
					<span data-device="desktop" class="device screen-desktop" title="Desktop"></span>
					<span data-device="tablet" class="device screen-tablet" title="Tablet"></span>
					<span data-device="mobile" class="device screen-mobile" title="Mobile"></span>
				</div>
			</div>
		</script>
		<?php
	}
}

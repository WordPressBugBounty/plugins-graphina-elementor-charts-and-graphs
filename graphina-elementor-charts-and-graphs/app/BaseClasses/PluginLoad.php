<?php
/**
 * PluginLoad class file for loading plugin require class and localization files
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina_Charts_For_Elementor
 */

namespace GraphinaElementor\App\BaseClasses;

// If this file is called directly, abort.

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Something went wrong' );
}

/**
 * Class PluginLoad
 *
 * Initializes and manages the loading of the Graphina Charts plugin.
 */
class PluginLoad {


	/**
	 * PluginLoad constructor.
	 *
	 * Initializes the plugin, registers hooks, and loads necessary components.
	 */
	public function __construct() {
		add_filter( 'plugin_action_links_' . GRAPHINA_BASE_PATH, 'graphina_plugin_settings_link' );
		add_action( 'init', 'graphina_update_configuration_options' );

		// Define the path to the plugin's language files.
		$language_path = dirname( GRAPHINA_BASE_PATH ) . '/languages/';
		// Load the plugin's text domain for localization.
		load_plugin_textdomain( 'graphina-charts-for-elementor', false, $language_path );
		// Initialize Elementor integration.
		( new Frontend() )->init();
		// Initialize the admin settings panel.
		( new AdminSettingPanel() )->init();
	}
}

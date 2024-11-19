<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin line. This file also includes all the dependencies used by the plugin,
 * registers the activation and deactivation functions, and call core class to load plugin
 *
 * @link    https://iqonic.design
 * @since   1.0.0
 * @package Graphina_Charts_For_Elementor
 *
 * @wordpress-plugin
 * Plugin Name:       Graphina - Elementor Charts and Graphs
 * Plugin URI:        https://graphina.iqonic.design
 * Description:       Your ultimate charts and graphs solution to enhance visual effects. Create versatile, advanced and interactive charts on your website.
 * Version:           2.0.4
 * Elementor tested up to: 3.25.7
 * Elementor Pro tested up to: 3.20.2
 * Requires PHP:      8.0
 * Author:            Iqonic Design
 * Author URI:        https://iqonic.design/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       graphina-charts-for-elementor
 * Domain Path:       /languages
 * Requires Plugins   elementor
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Something went wrong' );
}

if ( ! file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	die( 'Something went wrong' );
}

// Load composer autoload file.
require_once __DIR__ . '/vendor/autoload.php';

use GraphinaElementor\App\BaseClasses\PluginLoad;

if ( ! defined( 'GRAPHINA_ROOT' ) ) {
	define( 'GRAPHINA_ROOT', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'GRAPHINA_URL' ) ) {
	define( 'GRAPHINA_URL', plugins_url( '', __FILE__ ) );
}

if ( ! defined( 'GRAPHINA_BASE_PATH' ) ) {
	define( 'GRAPHINA_BASE_PATH', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION' ) ) {
	define( 'GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION', '2.0.4' );
}

if ( ! defined( 'GRAPHINA_CHARTS_DEPENDENT_PRO_VERSION' ) ) {
	define( 'GRAPHINA_CHARTS_DEPENDENT_PRO_VERSION', '2.1.3' );
}
if ( ! defined( 'GRAPHINA_WP_CACHE_GROUP' ) ) {
	define( 'GRAPHINA_WP_CACHE_GROUP', 'graphina' );
}
register_activation_hook( __FILE__, 'graphina_plugin_activation' );
register_deactivation_hook(
	__FILE__,
	function () {
		graphina_plugin_activation( true );
	}
);

( new PluginLoad() );

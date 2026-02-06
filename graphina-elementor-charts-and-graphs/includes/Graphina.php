<?php

namespace Graphina;

use Error;
use Graphina\Admin\GraphinaAdmin;
use Graphina\Public\GraphinaPublic;
use Graphina\Charts\Elementor\GraphinaElementor;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Graphina' ) ) :

	/**
	 * Main Graphina Class
	 * Handles the initialization, admin and frontend functionality of the Graphina plugin.
	 */
	final class Graphina {

		/**
		 * Singleton instance of the class.
		 *
		 * @var Graphina|null
		 */
		protected static $instance = null;

		/**
		 * Instance of the admin class.
		 *
		 * @var GraphinaAdmin|null
		 */
		public $admin;

		/**
		 * Instance of the frontend class.
		 *
		 * @var GraphinaFrontend|null
		 */
		public $public;

		/**
		 * Instance of the Elementor integration class.
		 *
		 * @var GraphinaElementor|null
		 */
		public $graphina_elementor;

		/**
		 * Class constructor.
		 * Includes necessary files and initializes hooks.
		 */
		public function __construct() {
			$this->include();
			$this->init_hooks();
		}

		/**
		 * Singleton instance creator.
		 *
		 * Ensures only one instance of the class is created.
		 *
		 * @return Graphina
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance                     = new self();
				self::$instance->graphina_elementor = new GraphinaElementor();

				// Initialize admin functionality if in the admin dashboard.
				if ( is_admin() ) {
					self::$instance->admin = new GraphinaAdmin();
				}
			}

			// Initialize frontend functionality.
			new GraphinaPublic();

			return self::$instance;
		}

		/**
		 * Include required files.
		 */
		public static function include() {
			require_once GRAPHINA_PATH . 'includes/GraphinaFunction.php';
		}

		/**
		 * Initialize WordPress hooks for the plugin.
		 */
		public static function init_hooks() {
			add_action( 'init', array( __CLASS__, 'load_textdomain' ) );
			add_filter( 'graphina_is_pro_active', array( __CLASS__, 'is_graphina_pro_active' ) );
			register_activation_hook( __FILE__, array( 'Graphina\Graphina_Install', 'install' ) );
		}
		/**
         * Check if the Graphina Pro plugin is active.
         *
         * @return bool
         */

		public static function is_graphina_pro_active() {
			return graphina_pro_active();
		}

		/**
		 * Load the plugin's text domain for translations.
		 */
		public static function load_textdomain() {
			load_plugin_textdomain( 'graphina-charts-for-elementor', false, dirname( plugin_basename( GRAPHINA_PLUGIN_FILE ) ) . '/languages/' );
		}
	}

endif;

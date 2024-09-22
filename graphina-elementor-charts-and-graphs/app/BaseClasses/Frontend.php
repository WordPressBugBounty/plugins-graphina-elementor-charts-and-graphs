<?php
/**
 * ElementorInit class file for elementor plugins hooks and functions
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

use Elementor\Plugin;
use Elementor\Elements_Manager;
use GraphinaElementor\App\Controllers\FrontendController;

/**
 * The public-facing functionality of the plugin.
 *
 * Enqueue the public-facing stylesheet and JavaScript and load elementor hooks.
 */
class Frontend {

	/**
	 * Initialize Graphina Elementor integration.
	 *
	 * This method initializes various actions and filters related to Graphina Elementor integration,
	 * including enqueueing styles and scripts, registering widgets, checking required plugins,
	 * and other Elementor specific actions.
	 *
	 * @return void
	 */
	public function init(): void {
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'admin_enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'elementor/elements/categories_registered', array( $this, 'elementor_init' ) );
		add_action( 'elementor/widgets/register', array( $this, 'include_widgets' ) );
		add_action( 'admin_notices', array( $this, 'check_required_plugins_for_graphina' ) );
		add_filter( 'elementor/editor/localize_settings', array( $this, 'promote_pro_elements' ) );
		add_filter(
			'elementor/frontend/builder_content_data',
			function ( $content ) {
				$this->enqueue_scripts();
				return $content;
			}
		);

		( new FrontendController() );
	}


	/**
	 * Register the stylesheets for the admin-facing side of the site.
	 *
	 * @since 1.5.7
	 */
	public function admin_enqueue_styles(): void {
		wp_register_style( 'graphina_font_awesome', GRAPHINA_URL . '/elementor/css/fontawesome-all.min.css', array(), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, 'all' );
		wp_enqueue_style( 'graphina_font_awesome' );
		wp_enqueue_style( 'graphina-charts-for-elementor-public', GRAPHINA_URL . '/elementor/css/graphina-charts-for-elementor-public.css', array(), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, 'all' );
		if ( ! graphina_pro_active() ) {
			wp_enqueue_style( 'graphina-charts-pro-requirement', GRAPHINA_URL . '/elementor/css/graphina-charts-for-elementor-pro.css', array(), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, 'all' );
		} else {
			wp_enqueue_style( 'graphina-charts-pro-css', GRAPHINA_URL . '/elementor/css/graphina-charts-for-elementor-pro-public.css', array(), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, 'all' );
		}
	}


	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since 1.5.7
	 */
	public function enqueue_styles(): void {
		wp_enqueue_style( 'graphina-charts-for-elementor-public', GRAPHINA_URL . '/elementor/css/graphina-charts-for-elementor-public.css', array(), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, 'all' );
		if ( ! graphina_pro_active() ) {
			wp_enqueue_style( 'graphina-charts-pro-requirement', GRAPHINA_URL . '/elementor/css/graphina-charts-for-elementor-pro.css', array(), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, 'all' );
		} else {
			wp_enqueue_style( 'graphina-charts-pro-css', GRAPHINA_URL . '/elementor/css/graphina-charts-for-elementor-pro-public.css', array(), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, 'all' );
		}
	}


	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @return void
	 */
	public function enqueue_scripts(): void {
		// check if graphina is not in preview mode.
		if ( ! graphina_is_preview_mode() ) {
			wp_enqueue_script( 'googlecharts-min', GRAPHINA_URL . '/elementor/js/gstatic/loader.js', array(), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, false );
		}

		wp_enqueue_script( 'apexcharts-min', GRAPHINA_URL . '/elementor/js/apexcharts.min.js', array( 'jquery' ), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, false );
		wp_enqueue_script( 'graphina-charts-for-elementor-public', GRAPHINA_URL . '/elementor/js/graphina-charts-for-elementor-public.js', array( 'jquery' ), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, false );
		wp_localize_script(
			'graphina-charts-for-elementor-public',
			'graphina_localize',
			array(
				'ajaxurl'                  => admin_url( 'admin-ajax.php' ),
				'nonce'                    => wp_create_nonce( 'get_graphina_chart_settings' ),
				'graphinaAllGraphs'        => array(),
				'graphinaAllGraphsOptions' => array(),
				'graphinaBlockCharts'      => array(),
				'is_view_port_disable'     => graphina_common_setting_get( 'view_port' ),
				'thousand_seperator'       => graphina_common_setting_get( 'thousand_seperator' ),
			)
		);
	}


	/**
	 * Initializes Elementor integration and adds custom categories based on plugin settings.
	 *
	 * @param Elements_Manager $elements_manager The Elementor elements manager instance.
	 */
	public function elementor_init( Elements_Manager $elements_manager ): void {
		$data              = get_option( 'graphina_common_setting', true );
		$selected_js_array = ! empty( $data['graphina_select_chart_js'] ) ? $data['graphina_select_chart_js'] : array();

		// Add category for Apex Charts if selected in plugin settings.
		if ( in_array( 'apex_chart_js', $selected_js_array, true ) ) {
			$elements_manager->add_category(
				'iq-graphina-charts',
				array(
					'title' => esc_html__( 'Graphina Apex Chart', 'graphina-charts-for-elementor' ),
					'icon'  => 'fa fa-plug',
				)
			);
		}

		// Add category for Google Charts if selected in plugin settings.
		if ( in_array( 'google_chart_js', $selected_js_array, true ) ) {
			Plugin::$instance->elements_manager->add_category(
				'iq-graphina-google-charts',
				array(
					'title' => esc_html__( 'Graphina Google Chart', 'graphina-charts-for-elementor' ),
					'icon'  => 'fa fa-plug',
				)
			);
		}

		// Reorder categories with a custom sorting function.
		$category_prefix = 'iq-g';
		$categories      = Plugin::$instance->elements_manager->get_categories();
		$reorder_cats    = function () use ( $category_prefix, $categories ) {
			uksort(
				$categories,
				function ( $key_one, $key_two ) use ( $category_prefix ) {
					if ( substr( $key_one, 0, 4 ) === $category_prefix ) {
						return 1;
					}

					if ( substr( $key_two, 0, 4 ) === $category_prefix ) {
						return -1;
					}

					return 0;
				}
			);
		};
		$reorder_cats->call( $elements_manager );
	}


	/**
	 * Include Elementor widgets if Elementor plugin is active.
	 *
	 * This method checks if Elementor plugin is active and includes PHP files for Elementor widgets
	 * related to charts and Google Charts.
	 *
	 * @return void
	 */
	public function include_widgets(): void {
		if ( defined( 'ELEMENTOR_PATH' ) && class_exists( 'Elementor\Widget_Base' ) ) {
			// Load files for apexcharts and table.
			graphina_load_widget( GRAPHINA_ROOT . '/elementor/charts/*.php' );
			// Load files for google charts.
			graphina_load_widget( GRAPHINA_ROOT . '/elementor/google_charts/*.php' );
		}
	}

	/**
	 * Check if required plugins for Graphina are active.
	 *
	 * This method checks whether essential plugins required for Graphina - Elementor Charts
	 * and Graphs are currently active in the WordPress installation.
	 *
	 * @return void
	 */
	public function check_required_plugins_for_graphina(): void {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		// Path to the Elementor plugin file relative to the plugins' directory.
		$file_path         = 'elementor/elementor.php';
		$installed_plugins = get_plugins();

		if ( ! isset( $installed_plugins[ $file_path ] ) ) {
			$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
			$button_text = esc_html__( 'Install Elementor ', 'graphina-charts-for-elementor' );
			$message     =
				'<strong>' . esc_html__( 'Graphina - Elementor Charts and Graphs', 'graphina-charts-for-elementor' ) . ' </strong> '
				. esc_html__( 'Not working because you need to install the', 'graphina-charts-for-elementor' )
				. ' <strong> ' . esc_html__( 'Elementor', 'graphina-charts-for-elementor' ) . ' </strong> '
				. esc_html__( 'plugin', 'graphina-charts-for-elementor' );

			graphina_admin_notice( $message, $install_url, $button_text );
			graphina_unset_activate_key();
			return;
		}

		if ( ! is_plugin_active( $file_path ) ) {

			$activation_url = admin_url( 'plugins.php?action=activate&plugin=' . rawurlencode( $file_path ) . '&plugin_status=all&paged=1&s' );
			$activation_url = wp_nonce_url( $activation_url, 'activate-plugin_' . $file_path );
			$button_text    = esc_html__( 'Activate Elementor', 'graphina-charts-for-elementor' );
			$message        = '<strong>' . esc_html__( 'Graphina - Elementor Charts and Graphs', 'graphina-charts-for-elementor' ) . '</strong> '
				. esc_html__( 'requires', 'graphina-charts-for-elementor' ) .
				' <strong>' . esc_html__( 'Elementor', 'graphina-charts-for-elementor' ) . '</strong> '
				. esc_html__( 'plugin to be active. Please activate Elementor for Graphina - Elementor Charts and Graphs to continue.', 'graphina-charts-for-elementor' );

			graphina_admin_notice( $message, $activation_url, $button_text );
			graphina_unset_activate_key();
			return;
		}

		if ( graphina_pro_install() && graphina_pro_active() && version_compare( graphina_pro_plugin_version(), GRAPHINA_CHARTS_DEPENDENT_PRO_VERSION, '<' ) ) {
			$message = esc_html__( 'Version', 'graphina-charts-for-elementor' ) . GRAPHINA_CHARTS_DEPENDENT_PRO_VERSION
				. '<strong>' . esc_html__( 'Required', 'graphina-charts-for-elementor' ) . '</strong> '
				. esc_html__( 'of', 'graphina-charts-for-elementor' ) .
				' <strong>' . esc_html__( 'Graphina – Elementor Dynamic Charts & Datatable', 'graphina-charts-for-elementor' ) . '</strong> '
				. esc_html__( 'Please update to continue for Graphina - Elementor Charts and Graphs to continue.', 'graphina-charts-for-elementor' );

			$url         = 'https://themeforest.net/downloads';
			$button_text = esc_html__( 'Download Version ', 'graphina-charts-for-elementor' ) . GRAPHINA_CHARTS_DEPENDENT_PRO_VERSION;
			graphina_admin_notice( $message, $url, $button_text );
			graphina_unset_activate_key( false );
		}
	}


	/**
	 * Promotes additional Pro elements in Elementor if Graphina Pro is active.
	 *
	 * @param array $config The original Elementor settings configuration.
	 * @return array Modified Elementor settings configuration with promoted widgets.
	 */
	public function promote_pro_elements( array $config ): array {
		if ( graphina_pro_active() ) {
			return $config;
		}

		$promotion_widgets = array();

		if ( isset( $config['promotionWidgets'] ) ) {
			$promotion_widgets = $config['promotionWidgets'];
		}

		$combine_array = array_merge(
			$promotion_widgets,
			array(
				array(
					'name'       => 'dynamic_column_chart',
					'title'      => esc_html__( 'Nested Column', 'graphina-charts-for-elementor' ),
					'icon'       => 'fas fa-wave-square',
					'categories' => '["iq-graphina-charts"]',
				),
				array(
					'name'       => 'mixed_chart',
					'title'      => esc_html__( 'Mixed', 'graphina-charts-for-elementor' ),
					'icon'       => 'fas fa-water',
					'categories' => '["iq-graphina-charts"]',
				),
				array(
					'name'       => 'graphina_counter',
					'title'      => esc_html__( 'Counter', 'graphina-charts-for-elementor' ),
					'icon'       => 'fas fa-sort-numeric-up-alt',
					'categories' => '["iq-graphina-charts"]',
				),
				array(
					'name'       => 'advance_datatable',
					'title'      => esc_html__( 'Advance DataTable', 'graphina-charts-for-elementor' ),
					'icon'       => 'fas fa-table',
					'categories' => '["iq-graphina-charts"]',
				),
				array(
					'name'       => 'brush_chart',
					'title'      => esc_html__( 'Brush Charts', 'graphina-charts-for-elementor' ),
					'icon'       => 'fa fa-bars',
					'categories' => '["iq-graphina-charts"]',
				),
				array(
					'name'       => 'gauge_google',
					'title'      => esc_html__( 'Gauge', 'graphina-charts-for-elementor' ),
					'icon'       => 'fas fa-tachometer-alt',
					'categories' => '["iq-graphina-google-charts"]',
				),
				array(
					'name'       => 'geo_google',
					'title'      => esc_html__( 'Geo', 'graphina-charts-for-elementor' ),
					'icon'       => 'fas fa-globe-asia',
					'categories' => '["iq-graphina-google-charts"]',
				),
				array(
					'name'       => 'org_google',
					'title'      => esc_html__( 'Org', 'graphina-charts-for-elementor' ),
					'icon'       => 'fas fa-chess-board',
					'categories' => '["iq-graphina-google-charts"]',
				),

				array(
					'name'       => 'gantt_google',
					'title'      => esc_html__( 'Gantt', 'graphina-charts-for-elementor' ),
					'icon'       => 'fas fa-project-diagram',
					'categories' => '["iq-graphina-google-charts"]',
				),
			)
		);
		$config['promotionWidgets'] = $combine_array;

		return $config;
	}

	/**
	 * Retrieve a list of Google Charts available in the plugin.
	 *
	 * @return array List of Google Charts names.
	 */
	public function google_charts_list(): array {
		return array(
			'area_google',
			'bar_google',
			'column_google',
			'line_google',
			'pie_google',
			'donut_google',
			'gauge_google',
			'geo_google',
			'org_google',
		);
	}
}

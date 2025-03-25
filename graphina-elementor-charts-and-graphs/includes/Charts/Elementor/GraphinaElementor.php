<?php

namespace Graphina\Charts\Elementor;

use Elementor\Plugin;
use Graphina\Elementor\Widget\AreaChart;
use Graphina\Elementor\Widget\LineChart;
use Graphina\Elementor\Widget\ColumnChart;
use Graphina\Elementor\Widget\DonutChart;
use Graphina\Elementor\Widget\RadarChart;
use Graphina\Elementor\Widget\PolarChart;
use Graphina\Elementor\Widget\PieChart;
use Graphina\Elementor\Widget\ScatterChart;
use Graphina\Elementor\Widget\RadialChart;
use Graphina\Elementor\Widget\DataTable;
use Graphina\Elementor\Widget\DistributeColumnChart;
use Graphina\Elementor\Widget\BubbleChart;
use Graphina\Elementor\Widget\TimelineChart;
use Graphina\Elementor\Widget\Google\AreaGoogleChart;
use Graphina\Elementor\Widget\Google\BarGoogleChart;
use Graphina\Elementor\Widget\Google\DonutGoogleChart;
use Graphina\Elementor\Widget\Google\LineGoogleChart;
use Graphina\Elementor\Widget\Google\ColumnGoogleChart;
use Graphina\Elementor\Widget\Google\PieGoogleChart;
use Graphina\Elementor\Widget\CandleChart;
use Graphina\Elementor\Widget\HeatmapChart;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * GraphinaElementor Class
 *
 * This class handles the integration of Graphina chart widgets with Elementor.
 * It registers widgets, organizes them into categories, and ensures the
 * required scripts and styles are loaded for optimal functionality.
 *
 * Product: Graphina - Advanced Chart Plugin for Elementor
 * Purpose: Streamline the addition of various chart widgets into the Elementor interface.
 */
class GraphinaElementor {

	/**
	 * Summary of is_pro_active
	 * @var
	 */
	private $is_pro_active = false;
	/**
	 * Constructor
	 *
	 * Initializes the class and hooks into Elementor's initialization process.
	 */
	public function __construct() {
		add_action( 'elementor/init', array( $this, 'init_elementor' ) );
		$this->is_pro_active = apply_filters( 'graphina_is_pro_active', false );
	}

	/**
	 * Initialize Elementor Integration
	 *
	 * Registers custom widget categories and includes widgets for Graphina charts.
	 * Also enqueues scripts and styles required for the charts.
	 */
	public function init_elementor() {
		add_action( 'elementor/widgets/register', array( $this, 'include_widgets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'graphina_widgets_dependencies' ) );
		add_filter( 'elementor/editor/localize_settings', array( $this, 'promote_pro_elements' ) );
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'graphina_chart_icons' ) );
		Plugin::$instance->elements_manager->add_category(
			'graphina-apex',
			array(
				'title' => esc_html__( 'Graphina ApexCharts', 'graphina-charts-for-elementor' ),
				'icon'  => 'fa fa-plug',
			)
		);
		Plugin::$instance->elements_manager->add_category(
			'graphina-google',
			array(
				'title' => esc_html__( 'Graphina GoogleCharts', 'graphina-charts-for-elementor' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}

	/**
	 * Include Graphina Widgets
	 *
	 * Registers widgets for both ApexCharts and Google Charts.
	 */
	public function include_widgets() {
		// Apex Chart Widgets
		require_once __DIR__ . '/Elements/ApexCharts/AreaChart.php';
		Plugin::instance()->widgets_manager->register( new AreaChart() );

		require_once __DIR__ . '/Elements/ApexCharts/LineChart.php';
		Plugin::instance()->widgets_manager->register( new LineChart() );

		require_once __DIR__ . '/Elements/ApexCharts/ColumnChart.php';
		Plugin::instance()->widgets_manager->register( new ColumnChart() );

		require_once __DIR__ . '/Elements/ApexCharts/DonutChart.php';
		Plugin::instance()->widgets_manager->register( new DonutChart() );

		require_once __DIR__ . '/Elements/ApexCharts/HeatmapChart.php';
		Plugin::instance()->widgets_manager->register( new HeatmapChart() );

		require_once __DIR__ . '/Elements/ApexCharts/RadarChart.php';
		Plugin::instance()->widgets_manager->register( new RadarChart() );

		require_once __DIR__ . '/Elements/ApexCharts/PolarChart.php';
		Plugin::instance()->widgets_manager->register( new PolarChart() );

		require_once __DIR__ . '/Elements/ApexCharts/PieChart.php';
		Plugin::instance()->widgets_manager->register( new PieChart() );

		require_once __DIR__ . '/Elements/ApexCharts/RadialChart.php';
		Plugin::instance()->widgets_manager->register( new RadialChart() );

		require_once __DIR__ . '/Elements/ApexCharts/BubbleChart.php';
		Plugin::instance()->widgets_manager->register( new BubbleChart() );

		require_once __DIR__ . '/Elements/ApexCharts/TimelineChart.php';
		Plugin::instance()->widgets_manager->register( new TimelineChart() );

		require_once __DIR__ . '/Elements/ApexCharts/ScatterChart.php';
		Plugin::instance()->widgets_manager->register( new ScatterChart() );

		require_once __DIR__ . '/Elements/ApexCharts/DataTable.php';
		Plugin::instance()->widgets_manager->register( new DataTable() );

		require_once __DIR__ . '/Elements/ApexCharts/CandleChart.php';
		Plugin::instance()->widgets_manager->register( new CandleChart() );

		require_once __DIR__ . '/Elements/ApexCharts/DistributeColumnChart.php';
		Plugin::instance()->widgets_manager->register( new DistributeColumnChart() );

		// Google Chart Widgets
		require_once __DIR__ . '/Elements/GoogleCharts/AreaGoogleChart.php';
		Plugin::instance()->widgets_manager->register( new AreaGoogleChart() );

		require_once __DIR__ . '/Elements/GoogleCharts/BarGoogleChart.php';
		Plugin::instance()->widgets_manager->register( new BarGoogleChart() );

		require_once __DIR__ . '/Elements/GoogleCharts/LineGoogleChart.php';
		Plugin::instance()->widgets_manager->register( new LineGoogleChart() );

		require_once __DIR__ . '/Elements/GoogleCharts/ColumnGoogleChart.php';
		Plugin::instance()->widgets_manager->register( new ColumnGoogleChart() );

		require_once __DIR__ . '/Elements/GoogleCharts/DonutGoogleChart.php';
		Plugin::instance()->widgets_manager->register( new DonutGoogleChart() );

		require_once __DIR__ . '/Elements/GoogleCharts/PieGoogleChart.php';
		Plugin::instance()->widgets_manager->register( new PieGoogleChart() ); // pie google chart
	}

	/**
	 * Enqueue Dependencies for Graphina Widgets
	 *
	 * Registers and enqueues scripts and styles required for the widgets.
	 */
	public function graphina_widgets_dependencies() {
		self::enqueue_kucrut();
	}
	/**
	 * Registers and enqueues
	 */

	public function graphina_chart_icons() {
		wp_enqueue_style( 'graphina-chart-icons', GRAPHINA_URL . 'assets/elementor/css/graphina-chart-icon.css' );
		wp_enqueue_style( 'graphina_font_awesome', GRAPHINA_URL . 'assets/elementor/css/fontawesome-all.min.css' );
	}

	/**
	 * Register Assets with Kucrut Vite
	 *
	 * Utilizes the Kucrut Vite package to register and manage JavaScript
	 * and CSS assets for the widgets.
	 */
	public function enqueue_kucrut() {
		// Core Scripts and Styles
		wp_register_script( 'apexchart-js', GRAPHINA_URL . 'assets/js/apexchart.min.js', array(), GRAPHINA_VERSION );
		wp_register_script( 'googlechart-js', GRAPHINA_URL . 'assets/js/googlechart-loader.js', array(), GRAPHINA_VERSION );
		wp_register_style( 'apexchart-css', GRAPHINA_URL . 'assets/css/apexchart.min.css', array(), GRAPHINA_VERSION );
		wp_enqueue_style( 'graphina_chart-css', GRAPHINA_URL . 'assets/css/graphina-chart.css', array(), GRAPHINA_VERSION );
		wp_register_script( 'data-table-js', GRAPHINA_URL . 'assets/js/dataTables.min.js', array( 'jquery' ), GRAPHINA_VERSION );
		wp_register_style( 'data-table-css', GRAPHINA_URL . 'assets/css/dataTables.min.css' );
		wp_register_script( 'data-table-button-js', GRAPHINA_URL . 'assets/js/dataTables.buttons.min.js', array( 'jquery' ), GRAPHINA_VERSION  );
		wp_register_script( 'data-table-button-html5-js', GRAPHINA_URL . 'assets/js/buttons.html5.min.js', array( 'jquery' ), GRAPHINA_VERSION  );
		wp_register_script( 'data-table-button-print-js', GRAPHINA_URL . 'assets/js/buttons.print.min.js', array( 'jquery' ), GRAPHINA_VERSION  );
		wp_register_style( 'data-table-button-css', GRAPHINA_URL . 'assets/css/buttons.dataTables.min.css', array(), GRAPHINA_VERSION  );
		wp_register_script( 'data-table-colvis-print-js', GRAPHINA_URL . 'assets/js/buttons.colVis.min.js', array( 'jquery' ), GRAPHINA_VERSION  );
		wp_register_script( 'data-table-jszip-js', GRAPHINA_URL . 'assets/js/jszip.min.js', array(), GRAPHINA_VERSION  );
		wp_register_script( 'data-table-pdfmake-js', GRAPHINA_URL . 'assets/js/pdfmake.min.js', array(), GRAPHINA_VERSION  );

		// Apex Charts Assets
		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/AreaChart.js',
			array(
				'handle'           => 'area-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/LineChart.js',
			array(
				'handle'           => 'line-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/HeatmapChart.js',
			array(
				'handle'           => 'heatmap-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/ColumnChart.js',
			array(
				'handle'           => 'column-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/BubbleChart.js',
			array(
				'handle'           => 'bubble-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/TimelineChart.js',
			array(
				'handle'           => 'timeline-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/NestedcolumnChart.js',
			array(
				'handle'           => 'nestedcolumn-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/DonutChart.js',
			array(
				'handle'           => 'donut-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/RadarChart.js',
			array(
				'handle'           => 'radar-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/RadialChart.js',
			array(
				'handle'           => 'radial-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/PolarChart.js',
			array(
				'handle'           => 'polar-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/PieChart.js',
			array(
				'handle'           => 'pie-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/ScatterChart.js',
			array(
				'handle'           => 'scatter-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/DistributeColumnChart.js',
			array(
				'handle'           => 'distributed_column-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/CandleChart.js',
			array(
				'handle'           => 'candle-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/DataTable.js',
			array(
				'handle'           => 'data-table-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/MixedChart.js',
			array(
				'handle'           => 'mixed-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/BrushChart.js',
			array(
				'handle'           => 'brush-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);
		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/apex-chart/CounterChart.js',
			array(
				'handle'           => 'counter-chart',
				'dependencies'     => array( 'apexchart-js' ),
				'css-dependencies' => array( 'apexchart-css' ),
				'in-footer'        => true,
			)
		);

		// Google Charts Assets
		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/google-chart/AreaGoogleChart.js',
			array(
				'handle'           => 'area-google-chart',
				'dependencies'     => array( 'googlechart-js' ),
				'css-dependencies' => array( 'graphina_chart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/google-chart/BarGoogleChart.js',
			array(
				'handle'           => 'bar-google-chart',
				'dependencies'     => array( 'googlechart-js' ),
				'css-dependencies' => array( 'graphina_chart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/google-chart/GeoGoogleChart.js',
			array(
				'handle'           => 'geo-google-chart',
				'dependencies'     => array( 'googlechart-js' ),
				'css-dependencies' => array( 'graphina_chart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/google-chart/GaugeGoogleChart.js',
			array(
				'handle'           => 'gauge-google-chart',
				'dependencies'     => array( 'googlechart-js' ),
				'css-dependencies' => array( 'graphina_chart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/google-chart/LineGoogleChart.js',
			array(
				'handle'           => 'line-google-chart',
				'dependencies'     => array( 'googlechart-js' ),
				'css-dependencies' => array( 'graphina_chart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/google-chart/ColumnGoogleChart.js',
			array(
				'handle'           => 'column-google-chart',
				'dependencies'     => array( 'googlechart-js' ),
				'css-dependencies' => array( 'graphina_chart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/google-chart/GanttGoogleChart.js',
			array(
				'handle'           => 'gantt-google-chart',
				'dependencies'     => array( 'googlechart-js' ),
				'css-dependencies' => array( 'graphina_chart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/google-chart/OrgGoogleChart.js',
			array(
				'handle'           => 'org-google-chart',
				'dependencies'     => array( 'googlechart-js' ),
				'css-dependencies' => array( 'graphina_chart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/google-chart/DonutGoogleChart.js',
			array(
				'handle'           => 'donut-google-chart',
				'dependencies'     => array( 'googlechart-js' ),
				'css-dependencies' => array( 'graphina_chart-css' ),
				'in-footer'        => true,
			)
		);

		\Kucrut\Vite\register_asset(
			GRAPHINA_PATH . 'dist',
			'assets/elementor/js/google-chart/PieGoogleChart.js',
			array(
				'handle'           => 'pie-google-chart',
				'dependencies'     => array( 'googlechart-js' ),
				'css-dependencies' => array( 'graphina_chart-css' ),
				'in-footer'        => true,
			)
		);
	}
	/**
	 * Summary of promote_pro_elements
	 * @param array $config
	 * @return array
	 */
	public function promote_pro_elements( array $config ): array {
		if ( $this->is_pro_active ) {
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
					'name'       => 'nested_column_chart',
					'title'      => esc_html__( 'Nested Column', 'graphina-charts-for-elementor' ),
					'icon'       => 'fas fa-wave-square',
					'categories' => '["graphina-apex"]',
				),
				array(
					'name'       => 'mixed_chart',
					'title'      => esc_html__( 'Mixed', 'graphina-charts-for-elementor' ),
					'icon'       => 'fas fa-water',
					'categories' => '["graphina-apex"]',
				),
				array(
					'name'       => 'counter_chart',
					'title'      => esc_html__( 'Counter', 'graphina-charts-for-elementor' ),
					'icon'       => 'fas fa-sort-numeric-up-alt',
					'categories' => '["graphina-apex"]',
				),
				array(
					'name'       => 'advance-datatable',
					'title'      => esc_html__( 'Advance DataTable', 'graphina-charts-for-elementor' ),
					'icon'       => 'fas fa-table',
					'categories' => '["graphina-apex"]',
				),
				array(
					'name'       => 'brush_chart',
					'title'      => esc_html__( 'Brush Charts', 'graphina-charts-for-elementor' ),
					'icon'       => 'fa fa-bars',
					'categories' => '["graphina-apex"]',
				),
				array(
					'name'       => 'gauge_google_chart',
					'title'      => esc_html__( 'Gauge', 'graphina-charts-for-elementor' ),
					'icon'       => 'fas fa-tachometer-alt',
					'categories' => '["graphina-google"]',
				),
				array(
					'name'       => 'geo_google_chart',
					'title'      => esc_html__( 'Geo', 'graphina-charts-for-elementor' ),
					'icon'       => 'fas fa-globe-asia',
					'categories' => '["graphina-google"]',
				),
				array(
					'name'       => 'org_google_chart',
					'title'      => esc_html__( 'Org', 'graphina-charts-for-elementor' ),
					'icon'       => 'fas fa-chess-board',
					'categories' => '["graphina-google"]',
				),

				array(
					'name'       => 'gantt_google_chart',
					'title'      => esc_html__( 'Gantt', 'graphina-charts-for-elementor' ),
					'icon'       => 'fas fa-project-diagram',
					'categories' => '["graphina-google"]',
				),
			)
		);
		$config['promotionWidgets'] = $combine_array;

		return $config;
	}
}

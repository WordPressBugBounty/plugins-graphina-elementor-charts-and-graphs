<?php

namespace Graphina\Elementor\Widget;

use Graphina\Charts\Elementor\GraphinaDataTableBase;
use Graphina\Charts\Elementor\GraphinaElementorControls;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly to ensure security.
}

/**
 * Data_Table_Chart Class
 *
 * This class defines the DataTable Chart widget for the Graphina plugin, integrating
 * with Elementor to provide a customizable DataTable Chart based on ApexCharts.
 *
 * Product: Graphina - Elementor Charts and Graphs
 * Purpose: To allow users to create dynamic and interactive DataTable Charts.
 */
class DataTable extends GraphinaDataTableBase {

	/**
	 * Get Widget Name
	 *
	 * Returns the unique identifier for the widget.
	 *
	 * @return string Widget name used internally.
	 */
	public function get_name() {
		return 'data_table_lite';
	}

	/**
	 * Get Widget Title
	 *
	 * Returns the display name of the widget shown in Elementor.
	 *
	 * @return string Translatable widget title.
	 */
	public function get_title() {
		return __( 'Jquery Data Table', 'graphina-charts-for-elementor' );
	}

	/**
	 * Get Widget Icon
	 *
	 * Returns the icon class for the widget shown in Elementor's widget panel.
	 *
	 * @return string Icon CSS class.
	 */
	public function get_icon() {
		return 'eicon-table';
	}

	/**
	 * Get Chart Type
	 *
	 * Defines the type of chart this widget represents. In this case, 'data-table'.
	 *
	 * @return string Chart type identifier.
	 */
	public function get_chart_type(): string {
		return 'data_table_lite';
	}

	/**
	 * Get Script Dependencies
	 *
	 * Specifies the JavaScript dependencies required for this widget.
	 * Ensures necessary scripts are loaded for proper functionality.
	 *
	 * @return array List of script handles.
	 */
	public function get_script_depends() {
		return array( 'data-table-chart', 'data-table-jszip-js', 'data-table-pdfmake-js', 'data-table-js', 'data-table-button-js', 'data-table-colvis-print-js', 'data-table-button-html5-js', 'data-table-button-print-js' );
	}

	/**
	 * Get Widget Categories
	 *
	 * Categorizes this widget under 'graphina-apex' in Elementor's widget panel.
	 *
	 * @return array List of categories.
	 */
	public function get_categories() {
		return array( 'graphina-apex' );
	}

	/**
	 * Get Style Dependencies
	 *
	 * Specifies the CSS dependencies required for this widget.
	 * Ensures necessary styles are loaded for proper visualization.
	 *
	 * @return array List of style handles.
	 */
	public function get_style_depends() {
		return array( 'data-table-chart', 'data-table-css', 'graphina_chart-css', 'data-table-button-css' );
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {
		$controls   = new GraphinaElementorControls();
		$chart_type = $this->get_chart_type();

		$controls->register_card_controls( $this, $chart_type );
		$controls->register_card_style_controls( $this, $chart_type );
		$controls->register_chart_controls( $this, $chart_type );
		$controls->graphina_dyanmic_chart_style_section( $this, $chart_type );
		$controls->graphina_chart_data_series( $this, $chart_type, 0 );
		$controls->graphina_common_chart_setting( $this, $chart_type, false, true, false );
		$controls->register_chart_restriction_controls( $this, $chart_type );
		$controls->register_table_style_controls( $this, $chart_type );
		apply_filters( 'graphina_password_form_style_section', $this, $chart_type );
	}

	/**
	* Render widget output on the frontend.
	*
	* @param array $args Widget parameters from the 'widget' function call.
	* @param array $instance Widget instance settings.
	 */
	protected function graphina_prepare_table_data_common( $settings, $chart_type, $element_id )
	{
		return graphina_prepare_jqeury_table_data( $settings, $chart_type, $element_id );
	}

	
	
	protected function render_chart( $chart_data ) {
		// Determine the CSS class for the chart card based on the settings.
		$chart_data['chart_card_class'] = ! empty( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_card_show' ] )
			&& $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_card_show' ] === 'yes'
			? 'chart-card'
			: '';

		$chart_data['show_card'] = $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_card_show' ];

		// Check if the heading should be displayed.
		$chart_data['show_heading'] = ! empty( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_is_card_heading_show' ] )
			&& $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_is_card_heading_show' ] === 'yes';

		// Check if the description should be displayed.
		$chart_data['show_description'] = ! empty( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_is_card_desc_show' ] )
			&& $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_is_card_desc_show' ] === 'yes';

		// Get the sanitized chart title if provided in the settings.
		$chart_data['chart_title'] = ! empty( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_heading' ] )
			? sanitize_text_field( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_heading' ] )
			: '';

		$chart_data['table_heading'] = ! empty( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_heading' ] )
			? sanitize_text_field( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_heading' ] )
			: '';

		$chart_data['table_content'] = ! empty( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_content' ] )
			? sanitize_text_field( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_content' ] )
			: '';

		// Get the sanitized chart description if provided in the settings.
		$chart_data['chart_description'] = ! empty( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_content' ] )
			? sanitize_text_field( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_content' ] )
			: '';

		graphina_get_template( 'graphina-apex-charts/' . $chart_data['chart_type'] . '-table.php', $chart_data );
	}
}

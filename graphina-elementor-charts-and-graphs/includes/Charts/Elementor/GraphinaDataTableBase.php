<?php

namespace Graphina\Charts\Elementor;
use Graphina\Charts\Elementor\GraphinaElementorWidgetBase;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Base class for Graphina Elementor Widget
 */
class GraphinaDataTableBase extends GraphinaElementorWidgetBase {
	/**
	 * Retrieve the widget name
	 *
	 * @return string
	 */
	public function get_name()
	{
		return __('Data Tables','graphina-charts-for-elementor');
	}

	/**
	 * Retrieve the chart type
	 *
	 * @return string
	 */
	public function get_chart_type()
	{
		return 'data_tables';
	}

	/**
	 * Get the icon for the widget
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'graphina-chart-data_table';
	}

	/**
	 * Get the title for the widget
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Graphina Data Table', 'graphina-charts-for-elementor' );
	}

	/**
	 * Get keywords for the widget
	 *
	 * @return array
	 */
	public function get_keywords() {
		return array( 'graph', 'graphina', 'table', 'data table' );
	}

	/**
	 * Get script dependencies
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'graphina-table-js' );
	}

	/**
	 * Get style dependencies
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array( 'graphina_table-css' );
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {
		// To be implemented in child classes
	}
	/**
	 * Summary of render
	 * @return void
	 */
	protected function render() {
		$settings   = $this->get_settings_for_display();
		$chart_type = $this->get_chart_type();
		$element_id = $this->get_id();

		// Handle chart restrictions
		if ( $this->handle_restrictions( $settings, $chart_type, $element_id ) ) {
			return;
		}
		// Prepare data for rendering
		$chart_data = $this->prepare_chart_data( $settings, $chart_type, $element_id );

		// Render the chart
		$this->render_chart( $chart_data );
	}

	/**
	 * Get common data
	 *
	 * @return array
	 */
	protected function graphina_prepare_table_data_common($settings, $chart_type, $element_id ){
		return array();
	}

	/**
	 * Prepare data for rendering the chart
	 *
	 * @return array
	 */
	protected function prepare_chart_data( $settings, $chart_type, $element_id ) {
		$chart_data = array(
			'settings'      => $settings,
			'chart_type'    => $chart_type,
			'element_id'    => $element_id,
			'extra_data'    => array(),
			'chart_options' => array(),
			'loader'        => graphina_common_setting_get('graphina_loader'),
		);

		$chart_data['extra_data'] = graphina_prepare_table_extra_data( $settings, $chart_type );
		$chart_data['table_data'] = $this->graphina_prepare_table_data_common( $settings, $chart_type, $element_id );
		if ( Plugin::$instance->editor->is_edit_mode() ) {
			$chart_data['element_settings'] = array_merge( $settings, array( GRAPHINA_PREFIX . $chart_type . '_is_edit_mode' => true ) );
		} else {
			$chart_data['element_settings'] = array();
		}

		return $chart_data;
	}

	/**
	 * Render the chart
	 *
	 * @param array $chart_data
	 */
	protected function render_chart( $chart_data ) {
		$chart_data['show_card']  = $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_element_card_show' ];
		$chart_data['filter']     = $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_can_show_filter' ];
		$chart_data['responsive'] = $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_table_responsive' ];
		graphina_get_template( 'graphina-apex-charts/' . $chart_data['chart_type'] . '-table.php', $chart_data );
	}

}
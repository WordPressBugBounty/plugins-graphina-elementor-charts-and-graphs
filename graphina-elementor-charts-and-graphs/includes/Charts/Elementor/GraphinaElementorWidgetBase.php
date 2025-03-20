<?php

namespace Graphina\Charts\Elementor;

use Elementor\Plugin;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Base class for Graphina Elementor Widget
 */
abstract class GraphinaElementorWidgetBase extends Widget_Base {

	/**
	 * Retrieve the widget name
	 *
	 * @return string
	 */
	abstract public function get_name();

	/**
	 * Retrieve the chart type
	 *
	 * @return string
	 */
	abstract public function get_chart_type();

	/**
	 * Get the icon for the widget
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'graphina-chart';
	}

	/**
	 * Get the title for the widget
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Graphina Chart', 'graphina-charts-for-elementor' );
	}

	/**
	 * Get keywords for the widget
	 *
	 * @return array
	 */
	public function get_keywords() {
		return array( 'graph', 'graphina', 'charts', 'chart', 'apex chart' );
	}

	/**
	 * Get script dependencies
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return array( 'graphina-chart-js' );
	}

	/**
	 * Get style dependencies
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array( 'graphina_chart-css' );
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {
		// To be implemented in child classes
	}

	/**
	 * Handle restrictions for the chart
	 *
	 * @return bool
	 */
	protected function handle_restrictions( $settings, $chart_type, $element_id ) {
		if ( graphina_restricted_access( $chart_type, $element_id, $settings, true ) ) {
			if ( $settings[ GRAPHINA_PREFIX . $chart_type . '_restriction_content_type' ] === 'password' ) {
				return true;
			}
			echo wp_kses_post( html_entity_decode( $settings[ GRAPHINA_PREFIX . $chart_type . '_restriction_content_template' ] ) );
			return true;
		}
		return false;
	}
}

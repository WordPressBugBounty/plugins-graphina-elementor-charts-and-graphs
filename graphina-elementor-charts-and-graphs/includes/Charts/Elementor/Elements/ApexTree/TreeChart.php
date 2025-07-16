<?php

namespace Graphina\Elementor\Widget\Tree;

use Graphina\Charts\Elementor\GraphinaApexTreeBase;
use Graphina\Charts\Elementor\GraphinaElementorControls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly to ensure security.
}

/**
 * TreeChart Class
 *
 * This class defines the Tree Chart widget for the Graphina plugin, integrating
 * with Elementor to provide a customizable Tree Chart based on ApexTree.
 *
 * Product: Graphina - Elementor Charts and Graphs
 * Purpose: To allow users to create dynamic and interactive Tree Charts.
 */
class TreeChart extends GraphinaApexTreeBase {

	/**
	 * Get Widget Name
	 *
	 * Returns the unique identifier for the widget.
	 *
	 * @return string Widget name used internally.
	 */
	public function get_name() {
		return 'tree_chart';
	}

	/**
	 * Get Widget Title
	 *
	 * Returns the display name of the widget shown in Elementor.
	 *
	 * @return string Translatable widget title.
	 */
	public function get_title() {
		return __( 'Tree Chart', 'graphina-charts-for-elementor' );
	}

	/**
	 * Get Widget Icon
	 *
	 * Returns the icon class for the widget shown in Elementor's widget panel.
	 *
	 * @return string Icon CSS class.
	 */
	public function get_icon() {
		return 'eicon-sitemap';
	}

	/**
	 * Get Chart Type
	 *
	 * Defines the type of chart this widget represents. In this case, 'tree'.
	 *
	 * @return string Chart type identifier.
	 */
	public function get_chart_type(): string {
		return 'tree';
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
		return array( 'tree-chart' );
	}

	/**
	 * Get Widget Categories
	 *
	 * Categorizes this widget under 'graphina-apex-tree' in Elementor's widget panel.
	 *
	 * @return array List of categories.
	 */
	public function get_categories() {
		return array( 'graphina-apex-tree' );
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
		return array( 'tree-chart' );
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
		$controls->graphina_animation( $this, $chart_type );
		$controls->graphina_chart_data_series( $this, $chart_type, 0 );
		$controls->graphina_tree_chart_setting($this, $chart_type );
		$controls->register_chart_restriction_controls( $this, $chart_type );
	}

    /**
	 * Get common options
	 *
	 * @return array
	 */
	protected function graphina_prepare_chart_common_options($settings, $chart_type, $element_id)
	{		
		$chart_options = array(
			'contentKey' 			=> 'data',
			'width'      			=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_div_width']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_div_width'] : 400,
			'height'     			=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_div_height']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_div_height'] : 350,
			'siblingSpacing'  		=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_sibling_spacing']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_sibling_spacing'] : 50,
			'direction'  			=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_flow_direction']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_flow_direction'] : 'top',
			'edgeColor'       		=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_edge_color']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_edge_color'] : '#FF0000',
			'edgeColorHover'  		=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_hover_edge_color']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_hover_edge_color'] : '#BCBCBC',
			'borderStyle'          	=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_style']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_style'] : 'solid',
			'enableExpandCollapse' 	=> ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_node_collapse' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_node_collapse' ] === 'yes' ? true : false,
			'highlightOnHover'		=> true, 
			'enableToolbar'  		=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_show_toolbar']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_show_toolbar'] === 'yes' ? true : false,
			'enableTooltip'       	=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip'] === 'yes' ? true : false,
			'nodeWidth'  			=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_width']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_width'] : 40,
			'nodeHeight'  			=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_height']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_height'] : 40,
			'borderRadius' 			=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_border_radius'].'px') ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_border_radius'].'px' : '5px',
			'borderWidth' 			=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_border_width']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_border_width'] : 2,	
			'fontFamily' 			=> ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_node_font_family' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_node_font_family' ] : '',
		);
		return $chart_options;
	}
}

<?php

namespace Graphina\Charts\Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Group_Control_Border;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * GraphinaElementorControls Class
 *
 * This class provides reusable control structures for Elementor widgets
 * within the Graphina plugin. It centralizes the management of Elementor
 * controls to ensure consistency and reduce redundancy when adding settings
 * and styles to widgets.
 *
 * Product: Graphina - Advanced Chart Plugin for Elementor
 * Purpose: To enhance the developer experience by offering predefined,
 *          easy-to-integrate control configurations for Elementor widgets.
 */
class GraphinaElementorControls {


	public $defaultLabel = array( 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan1', 'Feb1', 'Mar1', 'Apr1', 'May1', 'Jun1', 'July1', 'Aug1', 'Sep1', 'Oct1', 'Nov1', 'Dec1', 'Jan2', 'Feb2', 'Mar2', 'Apr2', 'May2', 'Jun2', 'July2', 'Aug2' );

	/**
	 * Constructor
	 *
	 * Initializes the Graphina Elementor Controls class.
	 */
	public function __construct() {
		// Initialization code, if needed.
	}

	/**
	 * Register Card Controls
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 * the appearance and behavior of chart cards, including background,
	 * borders, shadows, and typography.
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function register_card_controls( $widget, $chart_type ) {

		// if (in_array($chart_type, ['area', 'timeline','line', 'bubble','column', 'area_google','column_google','line_google'])) :
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_1',
			array(
				'label' => esc_html__( 'Basic Setting', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_card_show',
			array(
				'label'     => esc_html__( 'Card', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_is_card_heading_show',
			array(
				'label'     => esc_html__( 'Heading', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_card_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_heading',
			array(
				'label'     => esc_html__( 'Card Heading', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'My Example Heading',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_is_card_heading_show' => 'yes',
					GRAPHINA_PREFIX . $chart_type . '_chart_card_show'      => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_is_card_desc_show',
			array(
				'label'     => esc_html__( 'Description', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_card_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_content',
			array(
				'label'     => 'Card Description',
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => 'My Other Example Heading',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_is_card_desc_show' => 'yes',
					GRAPHINA_PREFIX . $chart_type . '_chart_card_show'   => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);
		$widget->end_controls_section();
	}

	/**
	 * Register Card Style Controls
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 * the appearance and behavior of chart cards, including background,
	 * borders, shadows, and typography.
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function register_card_style_controls( $widget, $chart_type ) {
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_card_style_section',
			array(
				'label'     => esc_html__( 'Card Style', 'graphina-charts-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_card_show' => 'yes',
				),
			)
		);

		$widget->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => GRAPHINA_PREFIX . $chart_type . '_card_background',
				'label'     => esc_html__( 'Background', 'graphina-charts-for-elementor' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .chart-card',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_card_show' => 'yes',
				),
			)
		);

		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => GRAPHINA_PREFIX . $chart_type . '_card_box_shadow',
				'label'     => esc_html__( 'Box Shadow', 'graphina-charts-for-elementor' ),
				'selector'  => '{{WRAPPER}} .chart-card',
				'condition' => array( GRAPHINA_PREFIX . $chart_type . '_chart_card_show' => 'yes' ),
			)
		);

		$widget->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => GRAPHINA_PREFIX . $chart_type . '_card_border',
				'label'     => esc_html__( 'Border', 'graphina-charts-for-elementor' ),
				'selector'  => '{{WRAPPER}} .chart-card',
				'condition' => array( GRAPHINA_PREFIX . $chart_type . '_chart_card_show' => 'yes' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_card_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'graphina-charts-for-elementor' ),
				'size_units' => array( 'px', '%', 'em' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'condition'  => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_card_show' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .chart-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_heading_style_divider',
			array(
				'type'      => Controls_Manager::DIVIDER,
				'condition' => array( GRAPHINA_PREFIX . $chart_type . '_is_card_heading_show' => 'yes' ),
			),
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_heading_style_title',
			array(
				'label'     => esc_html__( 'Heading', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_is_card_heading_show' => 'yes',
				),
			)
		);

		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => GRAPHINA_PREFIX . $chart_type . '_card_title_typography',
				'label'     => esc_html__( 'Typography', 'graphina-charts-for-elementor' ),
				'global'    => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector'  => '{{WRAPPER}} .graphina-chart-heading',
				'condition' => array( GRAPHINA_PREFIX . $chart_type . '_is_card_heading_show' => 'yes' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_card_title_align',
			array(
				'label'     => esc_html__( 'Heading Alignment', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .graphina-chart-heading' => 'text-align: {{VALUE}};',
				),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_is_card_heading_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_card_title_font_color',
			array(
				'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .graphina-chart-heading' => 'color: {{VALUE}};',
				),
			)
		);

		$widget->add_responsive_control(
			GRAPHINA_PREFIX . $chart_type . '_card_title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'graphina-charts-for-elementor' ),
				'size_units' => array( 'px', '%', 'em' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'condition'  => array(
					GRAPHINA_PREFIX . $chart_type . '_is_card_heading_show' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .graphina-chart-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$widget->add_responsive_control(
			GRAPHINA_PREFIX . $chart_type . '_card_title_padding',
			array(
				'label'      => esc_html__( 'Padding', 'graphina-charts-for-elementor' ),
				'size_units' => array( 'px', '%', 'em' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'condition'  => array(
					GRAPHINA_PREFIX . $chart_type . '_is_card_heading_show' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .graphina-chart-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_style_divider',
			array(
				'type'      => Controls_Manager::DIVIDER,
				'condition' => array( GRAPHINA_PREFIX . $chart_type . '_is_card_desc_show' => 'yes' ),
			),
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_subtitle_options',
			array(
				'label'     => esc_html__( 'Description', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array( GRAPHINA_PREFIX . $chart_type . '_is_card_desc_show' => 'yes' ),
			)
		);

		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => GRAPHINA_PREFIX . $chart_type . '_subtitle_typography',
				'label'     => esc_html__( 'Typography', 'graphina-charts-for-elementor' ),
				'global'    => array(
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				),
				'selector'  => '{{WRAPPER}} .graphina-chart-sub-heading',
				'condition' => array( GRAPHINA_PREFIX . $chart_type . '_is_card_desc_show' => 'yes' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_card_subtitle_align',
			array(
				'label'     => esc_html__( 'Alignment', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_is_card_desc_show' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .graphina-chart-sub-heading' => 'text-align: {{VALUE}};',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_card_subtitle_font_color',
			array(
				'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .graphina-chart-sub-heading' => 'color: {{VALUE}};',
				),
			)
		);

		$widget->add_responsive_control(
			GRAPHINA_PREFIX . $chart_type . '_card_subtitle_margin',
			array(
				'label'      => esc_html__( 'Margin', 'graphina-charts-for-elementor' ),
				'size_units' => array( 'px', '%', 'em' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'condition'  => array(
					GRAPHINA_PREFIX . $chart_type . '_is_card_heading_show' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .graphina-chart-sub-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$widget->add_responsive_control(
			GRAPHINA_PREFIX . $chart_type . '_card_subtitle_padding',
			array(
				'label'      => esc_html__( 'Padding', 'graphina-charts-for-elementor' ),
				'size_units' => array( 'px', '%', 'em' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'condition'  => array(
					GRAPHINA_PREFIX . $chart_type . '_is_card_heading_show' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .graphina-chart-sub-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$widget->end_controls_section();
	}


	/*
	 * Register Table style,search style,button style for jquery data table
	*/

	public function register_table_style_controls( $widget, $chart_type){

		
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_table_style',
			array(
				'label' => esc_html__( 'Table Style', 'graphina-charts-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_table_header_align',
			array(
				'label'     => esc_html__( 'Table Header Alignment', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_table_body_align',
			array(
				'label'     => esc_html__( 'Table Body Alignment', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_header_row_color',
			array(
				'label'     => esc_html__( 'Header Row Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} table thead' => 'background-color: {{VALUE}};',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_header_text_row_color',
			array(
				'label'     => esc_html__( 'Header Row Text Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} table thead' => 'color: {{VALUE}};',
				),
			)
		);
		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => GRAPHINA_PREFIX . $chart_type . '_header_typography',
				'label'    => esc_html__( 'Header Typography', 'graphina-charts-for-elementor' ),
				'selector' => '{{WRAPPER}} table thead',
			)
		);

		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => GRAPHINA_PREFIX . $chart_type . '_footer_typography',
				'label'    => esc_html__( 'Footer Typography', 'graphina-charts-for-elementor' ),
				'selector' => '{{WRAPPER}} table tfoot',
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_table_even_row_color',
			array(
				'label'     => esc_html__( 'Even Row Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} table .even,{{WRAPPER}} table .even .sorting_1' => 'background-color: {{VALUE}}!important;',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_table_even_row_text_color',
			array(
				'label'     => esc_html__( 'Even Row Text Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} table .even' => 'color: {{VALUE}};',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_table_old_row_color',
			array(
				'label'     => esc_html__( 'Odd Row Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} table .odd,{{WRAPPER}} table .odd .sorting_1' => 'background-color: {{VALUE}}!important;',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_table_old_row_text_color',
			array(
				'label'     => esc_html__( 'Odd Row Text Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} table .odd' => 'color: {{VALUE}};',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_footer_row_color',
			array(
				'label'     => esc_html__( 'Footer Row Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} table tfoot' => 'background-color: {{VALUE}};',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_footer_row_text_color',
			array(
				'label'     => esc_html__( 'Footer Row Text Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} table tfoot' => 'color: {{VALUE}};',
				),
			)
		);

		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => GRAPHINA_PREFIX . $chart_type . '_cell_typography',
				'label'    => esc_html__( 'Typography', 'graphina-charts-for-elementor' ),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .dt-container',
			)
		);

		$widget->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => GRAPHINA_PREFIX . $chart_type . '_table_search_border',
				'label'    => esc_html__( 'Border', 'graphina-charts-for-elementor' ),
				'selector' => '{{WRAPPER}} table',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_table_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'graphina-charts-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_table_margin',
			array(
				'label'      => esc_html__( 'Margin', 'graphina-charts-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} table' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_table_padding',
			array(
				'label'      => esc_html__( 'Padding', 'graphina-charts-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$widget->end_controls_section();

		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_table_button_style',
			array(
				'label' => esc_html__( 'Button Style', 'graphina-charts-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$widget->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => GRAPHINA_PREFIX . $chart_type . '_table_button_search_border',
				'label'    => esc_html__( 'Border', 'graphina-charts-for-elementor' ),
				'selector' => '{{WRAPPER}} .buttons-page-length,
                             {{WRAPPER}} .buttons-colvis,
                             {{WRAPPER}} .buttons-copy,
                             {{WRAPPER}} .buttons-excel,
                             {{WRAPPER}} .buttons-pdf,
                             {{WRAPPER}} .buttons-print,
                             {{WRAPPER}} .dt-paging-button,
                             {{WRAPPER}} .dt-paging-button.disabled',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_table_button_search_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .buttons-page-length,
                             {{WRAPPER}} .buttons-colvis,
                             {{WRAPPER}} .buttons-copy,
                             {{WRAPPER}} .buttons-excel,
                             {{WRAPPER}} .buttons-pdf,
                             {{WRAPPER}} .buttons-print,
                             {{WRAPPER}} .dt-paging-button,
                             {{WRAPPER}} .dt-paging-button.disabled' => 'background: {{VALUE}} !important;',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_table_button_search_text_font_size',
			array(
				'label'     => esc_html__( 'Font Size', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'default'   => 16,
				'selectors' => array(
					'{{WRAPPER}} .buttons-page-length,
                             {{WRAPPER}} .buttons-colvis,
                             {{WRAPPER}} .buttons-copy,
                             {{WRAPPER}} .buttons-excel,
                             {{WRAPPER}} .buttons-pdf,
                             {{WRAPPER}} .buttons-print,
                             {{WRAPPER}} .dt-paging-button,
                             {{WRAPPER}} .dt-paging-button.disabled' => 'font-size: {{VALUE}}px !important;',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_table_button_search_text_font_color',
			array(
				'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .buttons-page-length,
                             {{WRAPPER}} .buttons-colvis,
                             {{WRAPPER}} .buttons-copy,
                             {{WRAPPER}} .buttons-excel,
                             {{WRAPPER}} .buttons-pdf,
                             {{WRAPPER}} .buttons-print,
                             {{WRAPPER}} .dt-paging-button,
                             {{WRAPPER}} .dt-paging-button.disabled' => 'color: {{VALUE}}!important;',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_table_button_search_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'graphina-charts-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .buttons-page-length,
                             {{WRAPPER}} .buttons-colvis,
                             {{WRAPPER}} .buttons-copy,
                             {{WRAPPER}} .buttons-excel,
                             {{WRAPPER}} .buttons-pdf,
                             {{WRAPPER}} .buttons-print,
                             {{WRAPPER}} .dt-paging-button,
                             {{WRAPPER}} .dt-paging-button.disabled' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_table_button_search_margin',
			array(
				'label'      => esc_html__( 'Margin', 'graphina-charts-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .buttons-page-length,
                             {{WRAPPER}} .buttons-colvis,
                             {{WRAPPER}} .buttons-copy,
                             {{WRAPPER}} .buttons-excel,
                             {{WRAPPER}} .buttons-pdf,
                             {{WRAPPER}} .buttons-print,
                             {{WRAPPER}} .dt-paging-button,
                             {{WRAPPER}} .dt-paging-button.disabled' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_table_button_search_padding',
			array(
				'label'      => esc_html__( 'Padding', 'graphina-charts-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .buttons-page-length,
                             {{WRAPPER}} .buttons-colvis,
                             {{WRAPPER}} .buttons-copy,
                             {{WRAPPER}} .buttons-excel,
                             {{WRAPPER}} .buttons-pdf,
                             {{WRAPPER}} .buttons-print,
                             {{WRAPPER}} .dt-paging-button,
                             {{WRAPPER}} .dt-paging-button.disabled' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$widget->end_controls_section();

		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_search_style',
			array(
				'label'     => esc_html__( 'Search Style', 'graphina-charts-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . 'table_search' => 'yes',
				),
			)
		);

		$widget->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => GRAPHINA_PREFIX . $chart_type . '_search_border',
				'label'    => esc_html__( 'Border', 'graphina-charts-for-elementor' ),
				'selector' => '{{WRAPPER}} input[type=search]',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_search_width',
			array(
				'label'     => esc_html__( 'Width', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'default'   => 200,
				'selectors' => array(
					'{{WRAPPER}} input[type=search]' => 'width: {{VALUE}}px;',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_search_height',
			array(
				'label'     => esc_html__( 'height', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'default'   => 40,
				'selectors' => array(
					'{{WRAPPER}} input[type=search]' => 'height: {{VALUE}}px;',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_search_background_color',
			array(
				'label'     => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} input[type=search]' => 'background: {{VALUE}}',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_search_text_font_size',
			array(
				'label'     => esc_html__( 'Font Size', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'default'   => 16,
				'selectors' => array(
					'{{WRAPPER}} input[type=search]' => 'font-size: {{VALUE}}px;',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_search_text_font_color',
			array(
				'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} input[type=search]' => 'color: {{VALUE}}',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_search_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'graphina-charts-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} input[type=search]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_search_margin',
			array(
				'label'      => esc_html__( 'Margin', 'graphina-charts-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} input[type=search]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_search_padding',
			array(
				'label'      => esc_html__( 'Padding', 'graphina-charts-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} input[type=search]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$widget->end_controls_section();

	}
	/**
	 * Register Chart Controls
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function register_chart_controls( $widget, $chart_type ) {

		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_5_2',
			array(
				'label' => esc_html__( 'Data Options', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_data_json',
			array(
				'label'       => esc_html__( 'Data Json', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::HIDDEN,
				'label_block' => true,
				'default'     => json_encode(
					array(
						'header' => array_fill( 0, 5, '' ),
						'body'   => array_fill( 0, 5, array_fill( 0, 5, '' ) ),
					)
				),
			)
		);

		if ( ! in_array( $chart_type, array( 'advance-datatable', 'counter' ) ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_data_option',
				array(
					'label'   => esc_html__( 'Type', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'manual',
					'options' => graphina_chart_dynamic_options( $chart_type ),
				)
			);
		}

		if ( ! in_array( $chart_type, array( 'nested_column', 'brush', 'gantt_google', 'advance-datatable', 'counter', 'tree' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_can_chart_reload_ajax',
				array(
					'label'     => esc_html__( 'Reload Ajax', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'True', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'False', 'graphina-charts-for-elementor' ),
					'default'   => false,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option!' => array( 'manual' ),
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_interval_data_refresh',
				array(
					'label'     => __( 'Set Interval(sec)', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 5,
					'step'      => 5,
					'default'   => 15,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_can_chart_reload_ajax' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option!'    => array( 'manual' ),
					),
				)
			);
		}elseif( 'counter' === $chart_type ){
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_can_chart_reload_ajax',
				array(
					'label'     => esc_html__( 'Reload Ajax', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'True', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'False', 'graphina-charts-for-elementor' ),
					'default'   => false,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_element_data_option!' => array( 'manual' ),
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_interval_data_refresh',
				array(
					'label'     => __( 'Set Interval(sec)', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 5,
					'step'      => 5,
					'default'   => 15,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_can_chart_reload_ajax' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_element_data_option!'    => array( 'manual' ),
					),
				)
			);
		}

		

		if ( 'advance-datatable' === $chart_type ) {
			$this->graphina_dynamic_table_data_settings( $widget, $chart_type );
			$this->graphina_get_table_settings( $widget, $chart_type );
			$this->graphina_advance_data_table_settings( $widget, $chart_type );
		}

		if ( 'counter' === $chart_type ) {
			$this->graphina_dynamic_table_data_settings( $widget, $chart_type );
			$this->graphina_counter_chart_data_options( $widget, $chart_type );
		}
		$widget->end_controls_section();
	}
	/**
	 * Adds counter chart data options controls to the Elementor widget.
	 *
	 * This function defines various control options for configuring counter charts,
	 * including layout selection, chart visibility, data source selection,
	 * mathematical operations, titles, descriptions, and icons.
	 *
	 * @param object $widget     The Elementor widget instance.
	 * @param string $chart_type The type of the chart being configured.
	 */
	protected function graphina_counter_chart_data_options( $widget, $chart_type ) {

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_import_from_table_dynamic_key',
			array(
				'label'       => esc_html__( 'Dynamic Keys', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Use dynamic key in  Query,it will replace key will dynamic value (example : column_name={{CURRENT_USER_ID}} <strong><a href="https://documentation.iqonic.design/graphina/graphina-pro/unlocking-the-power-of-dynamic-keys-in-wordpress" target="_blank">List of Dynamic key</a></strong> and If you using dynamic key then please use default value like <b>where id={{QUERY_PARAM_key=1}}</b>', 'graphina-charts-for-elementor' ),
				'condition'   => array(
					GRAPHINA_PREFIX . $chart_type . '_element_data_option' => 'dynamic',
					GRAPHINA_PREFIX . $chart_type . '_element_dynamic_data_option' => array( 'sql-builder','database', 'external_database'),
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_element_builder_refresh',
			array(
				'label'       => esc_html__( 'Refresh', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'refresh',
				'options'     => array(
					'refresh' => array(
						'title' => esc_html__( 'Classic', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-redo',
					),
				),
				'description' => esc_html__( 'Click if column list is showing empty', 'graphina-charts-for-elementor' ),
				'condition'   => array(
					GRAPHINA_PREFIX . $chart_type . '_element_data_option' => array( 'dynamic' ),
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_column_no',
			array(
				'label'       => esc_html__( 'Column', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select column which data should be referenced', 'graphina-charts-for-elementor' ),
				'min'         => 1,
				'options'     => array(),
				'condition'   => array(
					GRAPHINA_PREFIX . $chart_type . '_element_data_option' => 'dynamic',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_layout_option',
			array(
				'label'   => esc_html__( 'Layout', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => $this->graphina_element_data_enter_options( 'counter_layout', true ),
				'options' => $this->graphina_element_data_enter_options( 'counter_layout' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_show_chart',
			array(
				'label'     => esc_html__( 'Has chart?', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => false,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_use_chart_data',
			array(
				'label'     => esc_html__( 'Use chart data?', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => false,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_element_show_chart' => 'yes',
					GRAPHINA_PREFIX . $chart_type . '_element_data_option' => 'manual',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_title',
			array(
				'label'       => esc_html__( 'Title', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Title', 'graphina-charts-for-elementor' ),
				'label_block' => true,
				'default'     => 'Title',
				'condition' => [
                    GRAPHINA_PREFIX . $chart_type . '_element_data_option' => 'manual'
                ],
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_description',
			array(
				'label'       => esc_html__( 'Description', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Description', 'graphina-charts-for-elementor' ),
				'label_block' => true,
				'default'     => 'Description',
				'condition' => [
                    GRAPHINA_PREFIX . $chart_type . '_element_data_option' => 'manual'
                ],
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_counter_icon',
			array(
				'label'     => esc_html__( 'Icon', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_element_layout_option!' => array( 'layout_2', 'layout_3', 'layout_4' ),
				),
			)
		);
	}

	/**
	 * Registers Tree Chart settings for Graphina widget.
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_tree_chart_setting($widget, $chart_type)
	{
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_2',
			array(
				'label' => esc_html__('Chart Setting', 'graphina-charts-for-elementor'),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_tree_setting',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_coman_setting',
			array(
				'label' => esc_html__(' Settings', 'graphina-charts-for-elementor'),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_tooltip',
			array(
				'label'       => esc_html__('Tooltip', 'graphina-charts-for-elementor'),
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__('Yes', 'graphina-charts-for-elementor'),
				'label_off'   => esc_html__('No', 'graphina-charts-for-elementor'),
				'default'     => 'yes',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_show_toolbar',
			array(
				'label'     => esc_html__('Toolbar', 'graphina-charts-for-elementor'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Hide', 'graphina-charts-for-elementor'),
				'label_off' => esc_html__('Show', 'graphina-charts-for-elementor'),
				'default'   => true,
			)
		);

		$widget->add_responsive_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_div_width',
			array(
				'label'   => esc_html__('Width', 'graphina-charts-for-elementor'),
				'type'    => Controls_Manager::NUMBER,
				'default'   => 1000,

			)
		);

		$widget->add_responsive_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_div_height',
			array(
				'label'     => esc_html__('Height', 'graphina-charts-for-elementor'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 350,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_node_collapse',
			array(
				'label'     => esc_html__('Collapse Node', 'graphina-charts-for-elementor'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Yes', 'graphina-charts-for-elementor'),
				'label_off' => esc_html__('No', 'graphina-charts-for-elementor'),
				'default'   => 'yes',
			)
		);

		$widget->add_responsive_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_flow_direction',
			array(
				'label'     => esc_html__('Chart Flow Direction', 'graphina-charts-for-elementor'),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'top',
				'options'   => array(
					'top'    => array(
						'title' => esc_html__('Top', 'graphina-charts-for-elementor'),
						'icon'  => 'eicon-arrow-up',
					),
					'right'  => array(
						'title' => esc_html__('Right', 'graphina-charts-for-elementor'),
						'icon'  => 'eicon-arrow-right',
					),
					'bottom' => array(
						'title' => esc_html__('Bottom', 'graphina-charts-for-elementor'),
						'icon'  => 'eicon-arrow-down',
					),
					'left'   => array(
						'title' => esc_html__('Left', 'graphina-charts-for-elementor'),
						'icon'  => 'eicon-arrow-left',
					),
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_sibling_spacing',
			array(
				'label'     => esc_html__('Sibling Spacing', 'graphina-charts-for-elementor'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 50,

			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_title_setting',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_node_setting',
			array(
				'label' => esc_html__('Node Settings', 'graphina-charts-for-elementor'),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$widget->add_responsive_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_node_width',
			array(
				'label'     => esc_html__('Node Width', 'graphina-charts-for-elementor'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 150,

			)
		);

		$widget->add_responsive_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_node_height',
			array(
				'label'     => esc_html__('Node Height', 'graphina-charts-for-elementor'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 130,

			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_node_style',
			array(
				'label'     => esc_html__('Style', 'graphina-charts-for-elementor'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'solid'  => esc_html__('solid', 'graphina-charts-for-elementor'),
					'dotted' => esc_html__('dotted', 'graphina-charts-for-elementor'),
					'dashed' => esc_html__('dashed', 'graphina-charts-for-elementor'),
					'groove' => esc_html__('groove', 'graphina-charts-for-elementor'),
					'none'   => esc_html__('none', 'graphina-charts-for-elementor'),
				),

			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_node_font_family',
			array(
				'label'       => esc_html__('Font Family', 'graphina-charts-for-elementor'),
				'type'        => Controls_Manager::FONT,
				'default'     => 'Poppins',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_node_border_radius',
			array(
				'label'      => esc_html__('Border radius', 'graphina-charts-for-elementor'),
				'type'       => Controls_Manager::NUMBER,
				'default'    => 5,

			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_node_border_width',
			array(
				'label'      => esc_html__('Border Width', 'graphina-charts-for-elementor'),
				'type'       => Controls_Manager::NUMBER,
				'default'    => 2,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_sel_node_setting_divider',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_node_edge_Setting',
			array(
				'label' => esc_html__('Edge Connection', 'graphina-charts-for-elementor'),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_node_edge_color',
			array(
				'label'     => esc_html__('Color', 'graphina-charts-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FF0000',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_node_hover_edge_color',
			array(
				'label'     => esc_html__('Hover Color', 'graphina-charts-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#5C6BC0',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_node_edge_Setting_divider',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_tree_refresh_btn',
			array(
				'label'       => esc_html__('Refresh', 'graphina-charts-for-elementor'),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'refresh',
				'options'     => array(
					'refresh' => array(
						'title' => esc_html__('Classic', 'graphina-charts-for-elementor'),
						'icon'  => 'fas fa-sync',
					),
				),
				'description' => esc_html__('Click if list is showing empty', 'graphina-charts-for-elementor'),
				'condition'  => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_option'	=>	'dynamic'
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_available_tree_columns',
			array(
				'label'       => esc_html__('Available Content', 'graphina-charts-for-elementor'),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__('', 'graphina-charts-for-elementor'),
				'condition'  => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_option'	=>	'dynamic'
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_tree_chart_template',
			array(
				'label'     => __('Tree Chart Template', 'graphina-charts-for-elementor'),
				'type'      => Controls_Manager::CODE,
				'default'   => graphina_tree_chart_template(),
			)
		);


		$widget->end_controls_section();

		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_2_node',
			array(
				'label' => esc_html__('Elements Setting', 'graphina-charts-for-elementor'),
			)
		);

		$series_name = esc_html__('Element', 'graphina-charts-for-elementor');
		$max_series = graphina_default_setting('max_series_value');

		for ($i = 0; $i < $max_series; $i++) {

			if ($i !== 0) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_hr_series_count_' . $i,
					array(
						'type'      => Controls_Manager::DIVIDER,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value')),
						),
					)
				);
			}

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_series_title_' . $i,
				array(
					'label'     => $series_name . ' ' . ($i + 1),
					'type'      => Controls_Manager::HEADING,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value')),
					),
				)
			);


			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_node_element_color' . $i,
				array(
					'label'     => esc_html__('Node Border Color', 'graphina-charts-for-elementor'),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#000000',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value')),
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_node_element_color_hover' . $i,
				array(
					'label'     => esc_html__('Hover Color', 'graphina-charts-for-elementor'),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#8396FF',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value')),
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_node_element_bgcolor' . $i,
				array(
					'label'     => esc_html__('Background Color', 'graphina-charts-for-elementor'),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#FFFFFF',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value')),
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_node_element_bgcolor_hover' . $i,
				array(
					'label'     => esc_html__('Background Color Hover', 'graphina-charts-for-elementor'),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#FFCDCD',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value')),
					),
				)
			);

			$widget->add_responsive_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_sel_node_font_size' . $i,
				array(
					'label'     => esc_html__('Font Size', 'graphina-charts-for-elementor'),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 15,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value')),
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_sel_node_font_color' . $i,
				array(
					'label'     => esc_html__('Font Color', 'graphina-charts-for-elementor'),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#000000',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value')),
					),
				)
			);
		}
		$widget->end_controls_section();
	}

	public function tree_data_settings($widget, $chart_type)
	{
		$max_series    = graphina_default_setting('max_series_value');

		for ($i = 0; $i < $max_series; $i++) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . 'section_series' . $i,
				array(
					'label'     => esc_html__('Element ', 'graphina-charts-for-elementor') . ($i + 1),
					'type'      => Controls_Manager::HEADING,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range(1 + $i, graphina_default_setting('max_series_value')),
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_add_image' . $i,
				[
					'label' => __('Image Settings', 'text-domain'),
					'type'        => Controls_Manager::SWITCHER,
					'label_on'    => esc_html__('Show', 'graphina-charts-for-elementor'),
					'label_off'   => esc_html__('Hide', 'graphina-charts-for-elementor'),
					'default'     => false,
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option'        => 'manual',
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count'  => range(1 + $i, graphina_default_setting('max_series_value')),
					),
				]
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_image' . $i,
				array(

					'label' => __('Choose Image', 'text-domain'),
					'type' => Controls_Manager::MEDIA,
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
					'dynamic'     => array(
						'active'  => true,
					),
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option'        => 'manual',
						GRAPHINA_PREFIX . $chart_type . '_add_image' . $i => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count'  => range(1 + $i, graphina_default_setting('max_series_value')),
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_child' . $i,
				array(
					'label'       => 'Child',
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__('Add Child', 'graphina-charts-for-elementor'),
					'default'     => 'Node ' . ($i + 1),
					'dynamic'     => array(
						'active'  => true,
					),
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option'        => 'manual',
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count'  => range(1 + $i, graphina_default_setting('max_series_value')),
					),

				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_parent' . $i,
				array(
					'label'       => 'Parent Node',
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__('Add Parent', 'graphina-charts-for-elementor'),
					'dynamic'     => array(
						'active'  => true,
					),
					'default'     => 'Node 1',
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option'        => 'manual',
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count'  => range(1 + $i, graphina_default_setting('max_series_value')),
					),

				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_node_category' . $i,
				array(
					'label'       => 'Node Category',
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__('Add Node Category', 'graphina-charts-for-elementor'),
					'dynamic'     => array(
						'active'  => true,
					),
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option'        => 'manual',
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count'  => range(1 + $i, graphina_default_setting('max_series_value')),
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_data_divider_tree' . $i,
				array(
					'type'      => Controls_Manager::DIVIDER,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option'        => 'manual',
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count'  => range(1 + $i, graphina_default_setting('max_series_value')),
					),
				)
			);
		}
	}
	/**
	 * Adds configuration controls for the Counter Chart in the Elementor widget.
	 *
	 * This function defines various customization options for the Counter Chart,
	 * including stroke settings, plot settings, fill styles, and gradient settings.
	 *
	 * @param object $widget     The Elementor widget instance.
	 * @param string $chart_type The type of chart being configured.
	 */
	public function counter_chart_options( $widget, $chart_type ) {
		$colors        = $this->graphina_colors( 'color' );
		$gradientColor = $this->graphina_colors( 'gradientColor' );
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_5_3',
			array(
				'label' => esc_html__( 'Counter Chart Options', 'graphina-charts-for-elementor' ),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_element_show_chart' => 'yes'
				)
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_type',
			array(
				'label'   => esc_html__( 'Type', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => graphina_mixed_chart_typeList( true, true ),
				'options' => graphina_mixed_chart_typeList( false, true ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_height',
			array(
				'label'           => esc_html__( 'Height (px)', 'graphina-charts-for-elementor' ),
				'type'            => Controls_Manager::NUMBER,
				'default'         => $chart_type === 'brush' ? 175 : 350,
				'step'            => 5,
				'min'             => 10,
				'desktop_default' => $chart_type === 'brush' ? 175 : 350,
				'tablet_default'  => $chart_type === 'brush' ? 175 : 350,
				'mobile_default'  => $chart_type === 'brush' ? 175 : 350,
			)
		);

		$widget->add_control(
			'hr_1_01',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_stroke_title',
			array(
				'label' => esc_html__( 'Stroke Setting', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_stroke_width',
			array(
				'label'   => esc_html__( 'Width', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 0,
				'max'     => 100,

			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_stroke_dash',
			array(
				'label'   => esc_html__( 'Dash Space', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 100,
				'default' => 0,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_stroke_color',
			array(
				'label'     => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#009FF5',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_type!' => 'line',

				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_stroke_curve',
			array(
				'label'     => esc_html__( 'Curve', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => graphina_stroke_curve_type( true ),
				'options'   => graphina_stroke_curve_type(),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_type!' => 'bar',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_stroke_line_cap',
			array(
				'label'     => esc_html__( 'Line Cap', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => graphina_line_cap_type( true ),
				'options'   => graphina_line_cap_type(),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_type!' => 'bar',
				),
			)
		);

		$widget->add_control(
			'hr_1_02',
			array(
				'type'      => Controls_Manager::DIVIDER,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_type' => 'bar',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_plot_title',
			array(
				'label'     => esc_html__( 'Plot Setting', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_type' => 'bar',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_plot_end_shape',
			array(
				'label'     => esc_html__( 'Ending Shape', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'flat',
				'options'   => array(
					'flat'    => esc_html__( 'Flat', 'graphina-charts-for-elementor' ),
					'rounded' => esc_html__( 'Rounded', 'graphina-charts-for-elementor' ),
				),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_type' => 'bar',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_plot_width',
			array(
				'label'       => esc_html__( 'Width', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Note: Set 0 for auto setting.', 'graphina-charts-for-elementor' ),
				'size_units'  => array( '%' ),
				'range'       => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'     => array(
					'unit' => '%',
					'size' => 70,
				),
				'condition'   => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_type' => 'bar',
				),
			)
		);

		$widget->add_control(
			'hr_1_03',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_fill_title',
			array(
				'label' => esc_html__( 'Fill Setting', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type',
			array(
				'label'   => esc_html__( 'Style', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => graphina_fill_style_type( array( 'classic', 'gradient', 'pattern' ), true ),
				'options' => graphina_fill_style_type( array( 'classic', 'gradient', 'pattern' ) ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_fill_opacity',
			array(
				'label'     => esc_html__( 'Opacity', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0.6,
				'min'       => 0.00,
				'max'       => 1,
				'step'      => 0.05,
				'condition' => array( GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type!' => 'gradient' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_gradient_1',
			array(
				'label'   => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => $colors[0],
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_gradient_2',
			array(
				'label'     => esc_html__( 'Second Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => $gradientColor[0],
				'condition' => array( GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type' => 'gradient' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_pattern',
			array(
				'label'     => esc_html__( 'Fill Pattern', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => graphina_get_fill_patterns( true ),
				'options'   => graphina_get_fill_patterns(),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type' => 'pattern',
				),
			)
		);

		$this->graphina_gradient_setting( $widget, $chart_type, true, true );

		$widget->end_controls_section();
	}
	/**
	 * Registers dynamic table data settings for Graphina widget.
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	protected function graphina_dynamic_table_data_settings( $widget, $chart_type ) {

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_data_option',
			array(
				'label'   => esc_html__( 'Type', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'manual',
				'options' => graphina_chart_dynamic_options( $chart_type ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_dynamic_data_option',
			array(
				'label'     => esc_html__( 'Type', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => graphina_chart_data_enter_options( $chart_type ),
				'default'   => 'csv',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_element_data_option' => 'dynamic',
				),
			)
		);

		if ( graphina_pro_active() ) {
			apply_filters( 'graphina_dynamic_table_data_settings_controllers', $widget, $chart_type );
		}

		if ( ! graphina_pro_active() ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . 'get_pro',
				array(
					'type' => Controls_Manager::RAW_HTML,
					'raw'  => graphina_get_teaser_template(
						array(
							'title'    => esc_html__( 'Get New Exciting Features', 'graphina-charts-for-elementor' ),
							'messages' => array( 'Get Graphina Pro for above exciting features and more.' ),
							'link'     => 'https://codecanyon.net/item/graphinapro-elementor-dynamic-charts-datatable/28654061',
						)
					),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_element_data_option' => 'dynamic',
					),
				)
			);
		}
	}

	/**
	 * Registers table settings for Graphina widget.
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	protected function graphina_get_table_settings( $widget, $chart_type ) {

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_table_data_series',
			array_merge(
				array(
					'label' => esc_html__( 'Set Number Of Columns and Rows', 'graphina-charts-for-elementor' ),
					'type'  => Controls_Manager::HEADING,
				)
			)
		);

		$max_row = graphina_default_setting( 'max_row_value' );
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_rows',
			array_merge(
				array(
					'label'       => esc_html__( 'No of Rows', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => 3,
					'min'         => 1,
					'max'         => $max_row,
					'description' => esc_html__( 'Note: If the data type is dynamic and pagination is enabled, then this option will not work.', 'graphina-charts-for-elementor' ),
				)
			)
		);

		$max_column = graphina_default_setting( 'max_column_value' );
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_columns',
			array_merge(
				array(
					'label'   => esc_html__( 'No of Columns', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 3,
					'min'     => 1,
					'max'     => $max_column,
				)
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_table_data_divider',
			array_merge(
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_table_data_header_show',
			array(
				'label' => esc_html__( 'Header', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_can_show_header',
			array(
				'label'     => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_can_include_in_body',
			array(
				'label'     => esc_html__( 'Includes In Body', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_can_show_header!' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_table_data_divider_index',
			array(
				'type'      => Controls_Manager::DIVIDER,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_can_show_index',
			array(
				'label'     => esc_html__( 'Show Index', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_index_title',
			array(
				'label'       => esc_html__( 'Index Header', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Index Title', 'graphina-charts-for-elementor' ),
				'default'     => '#',
				'condition'   => array(
					GRAPHINA_PREFIX . $chart_type . '_can_show_index' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_index_value_type',
			array(
				'label'     => esc_html__( 'Index Value Type', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'number',
				'options'   => array(
					'number' => esc_html__( 'Number', 'graphina-charts-for-elementor' ),
					'roman'  => esc_html__( 'Roman Number', 'graphina-charts-for-elementor' ),
				),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_can_show_index' => 'yes',
				),
			)
		);
	}

	/**
	 * Register Dynamic Data Settings Controls
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_dynamic_chart_data_settings( $widget, $chart_type ) {

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_dynamic_data_option',
			array(
				'label'     => esc_html__( 'Type', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => graphina_chart_data_enter_options( $chart_type ),
				'default'   => 'csv',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'dynamic',
				),
			)
		);

		if ( graphina_pro_active() ) {
			apply_filters( 'graphina_dynamic_data_settings_controllers', $widget, $chart_type );
		}

		if ( ! graphina_pro_active() ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . 'get_pro',
				array(
					'type' => Controls_Manager::RAW_HTML,
					'raw'  => graphina_get_teaser_template(
						array(
							'title'    => esc_html__( 'Get New Exciting Features', 'graphina-charts-for-elementor' ),
							'messages' => array( 'Get Graphina Pro for above exciting features and more.' ),
							'link'     => 'https://codecanyon.net/item/graphinapro-elementor-dynamic-charts-datatable/28654061',
						)
					),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'dynamic',
					),
				)
			);
		}
	}

	/**
	 * Function to handle google chart series section settings for Elementor widgets.
	 *
	 * @param Element_Base $widget The Elementor element instance.
	 * @param string       $type     Type of chart being configured.
	 * @param array        $ele_array Array of which section to show.
	 *
	 * @return void
	 */
	public function graphina_google_series_setting( $widget, string $chart_type = 'chart_id', array $ele_array = array( 'color' ) ): void {
		$colors      = $this->graphina_colors();
		$series_name = esc_html__( 'Element', 'graphina-charts-for-elementor' );

		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_12',
			array(
				'label' => esc_html__( 'Elements Setting', 'graphina-charts-for-elementor' ),
			)
		);
		$max_series = graphina_default_setting( 'max_series_value' );
		for ( $i = 0; $i < $max_series; $i++ ) {

			if ( $i !== 0 ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_hr_series_count_' . $i,
					array(
						'type'      => Controls_Manager::DIVIDER,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
			}

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_series_title_' . $i,
				array(
					'label'     => $series_name . ' ' . ( $i + 1 ),
					'type'      => Controls_Manager::HEADING,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);

			if ( in_array( 'color', $ele_array, true ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_element_color_' . $i,
					array(
						'label'     => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => ! empty($colors[ $i ]) ? $colors[ $i ] : '',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
			}

			if ( in_array( $chart_type, array( 'line_google', 'area_google' ), true ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_element_linewidth' . $i,
					array(
						'label'     => esc_html__( ' LineWidth', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::NUMBER,
						'default'   => 2,
						'min'       => 1,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_element_lineDash' . $i,
					array(
						'label'     => esc_html__( ' Line Dash Style', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SELECT,
						'default'   => 'default',
						'options'   => array(
							'default' => esc_html__( 'Default', 'graphina-charts-for-elementor' ),
							'style_1' => esc_html__( 'Style 1', 'graphina-charts-for-elementor' ),
							'style_2' => esc_html__( 'Style 2', 'graphina-charts-for-elementor' ),
							'style_3' => esc_html__( 'Style 3', 'graphina-charts-for-elementor' ),
							'style_4' => esc_html__( 'Style 4', 'graphina-charts-for-elementor' ),
							'style_5' => esc_html__( 'Style 5', 'graphina-charts-for-elementor' ),
							'style_6' => esc_html__( 'Style 6', 'graphina-charts-for-elementor' ),
							'style_7' => esc_html__( 'Style 7', 'graphina-charts-for-elementor' ),
							'style_8' => esc_html__( 'Style 8', 'graphina-charts-for-elementor' ),
							'style_9' => esc_html__( 'Style 9', 'graphina-charts-for-elementor' ),
						),
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
			}

			if ( in_array( 'width', $ele_array, true ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_width_3_' . $i,
					array(
						'label'     => 'Stroke Width',
						'type'      => Controls_Manager::NUMBER,
						'default'   => 5,
						'min'       => 1,
						'max'       => 20,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
			}

			$type = array( 'line_google', 'area_google' );

			if ( in_array( $chart_type, $type, true ) ) {

				$this->graphina_marker_setting_google( $widget, $chart_type, $i );

			}
		}
		$widget->end_controls_section();
	}

	/**
	 * Function to handle google chart marker section settings for Elementor widgets.
	 *
	 * @param Element_Base $widget The Elementor element instance.
	 * @param string       $type     Type of chart being configured.
	 * @param int          $i        Element index.
	 *
	 * @return void
	 */
	public function graphina_marker_setting_google( $widget, string $chart_type = 'chart_id', int $i = 0 ): void {

		$condition = array(
			GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_marker_setting_title_' . $i,
			array(
				'label'     => esc_html__( 'Marker Settings', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => $condition,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_point_show' . $i,
			array(
				'label'     => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'true'      => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'false'     => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => false,
				'condition' => $condition,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_line_point' . $i,
			array(
				'label'     => esc_html__( 'Point', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'circle',
				'options'   => array(
					'circle'   => esc_html__( 'Circle', 'graphina-charts-for-elementor' ),
					'triangle' => esc_html__( 'Triangle', 'graphina-charts-for-elementor' ),
					'square'   => esc_html__( 'Square', 'graphina-charts-for-elementor' ),
					'diamond'  => esc_html__( 'Diamond', 'graphina-charts-for-elementor' ),
					'star'     => esc_html__( 'Star', 'graphina-charts-for-elementor' ),
					'polygon'  => esc_html__( 'Polygon', 'graphina-charts-for-elementor' ),
				),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					GRAPHINA_PREFIX . $chart_type . '_chart_point_show' . $i   => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_line_point_size' . $i,
			array(
				'label'     => esc_html__( ' Size', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5,
				'max'       => 100,
				'min'       => 1,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					GRAPHINA_PREFIX . $chart_type . '_chart_point_show' . $i   => 'yes',
				),
			)
		);
	}

	/**
	 * Function to handle chart dynamic section settings for Elementor widgets.
	 *
	 * @param Element_Base $widget The Elementor element instance.
	 * @param string       $type     Type of chart being configured.
	 *
	 * @return void
	 */
	public function graphina_dyanmic_chart_style_section( $widget, $chart_type ) {
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . 'dynamic_change_type_style_section',
			array(
				'label'     => esc_html__( 'Change Chart Type Style', 'graphina-charts-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_dynamic_change_chart_type' => 'yes',
				),
			)
		);

		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => GRAPHINA_PREFIX . $chart_type . '_dynamic_change_type_select_text_typography',
				'label'    => esc_html__( 'Select Text Typography', 'graphina-charts-for-elementor' ),
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} .graphina-select-chart-type',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_dynamic_change_type_align',
			array(
				'label'     => esc_html__( 'Alignment', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .graphina_dynamic_change_type' => 'text-align: {{VALUE}}',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_dynamic_change_type_font_color',
			array(
				'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .graphina-select-chart-type' => 'color: {{VALUE}}',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_dynamic_change_type_background_color',
			array(
				'label'     => esc_html__( 'Select Background Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .graphina-select-chart-type' => 'background: {{VALUE}}',
				),
			)
		);
		$widget->add_responsive_control(
			GRAPHINA_PREFIX . $chart_type . '_dynamic_change_type_height',
			array(
				'label'          => __( 'Height', 'graphina-charts-for-elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => array(
					'unit' => 'px',
				),
				'tablet_default' => array(
					'unit' => 'px',
				),
				'mobile_default' => array(
					'unit' => 'px',
				),
				'size_units'     => array( 'px', 'vw' ),
				'range'          => array(
					'px' => array(
						'min' => 1,
						'max' => 1000,
					),
					'vw' => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'selectors'      => array(
					'{{WRAPPER}} .graphina-select-chart-type' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$widget->add_responsive_control(
			GRAPHINA_PREFIX . $chart_type . '__dynamic_change_type_width',
			array(
				'label'          => __( 'Width', 'graphina-charts-for-elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => array(
					'unit' => '%',
				),
				'tablet_default' => array(
					'unit' => '%',
				),
				'mobile_default' => array(
					'unit' => '%',
				),
				'size_units'     => array( '%', 'px', 'vw' ),
				'range'          => array(
					'%'  => array(
						'min' => 1,
						'max' => 100,
					),
					'px' => array(
						'min' => 1,
						'max' => 1000,
					),
					'vw' => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'selectors'      => array(
					'{{WRAPPER}} .graphina-select-chart-type' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '__dynamic_change_type_select_radius',
			array(
				'label'      => esc_html__( 'Select Border Radius', 'graphina-charts-for-elementor' ),
				'size_units' => array( 'px', '%', 'em' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => array(
					'{{WRAPPER}} .graphina-select-chart-type ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_dynamic_change_type_margin',
			array(
				'label'      => esc_html__( 'Margin', 'graphina-charts-for-elementor' ),
				'size_units' => array( 'px', '%', 'em' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => array(
					'{{WRAPPER}} .graphina_dynamic_change_type' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_dynamic_change_type_padding',
			array(
				'label'      => esc_html__( 'Padding', 'graphina-charts-for-elementor' ),
				'size_units' => array( 'px', '%', 'em' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'condition'  => array(
					GRAPHINA_PREFIX . $chart_type . '_is_card_heading_show' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .graphina_dynamic_change_type' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$widget->end_controls_section();
	}

	/**
	 * Register Chart Filter Controls
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_charts_filter_settings( $widget, $chart_type ) {
		$condition = array(
			GRAPHINA_PREFIX . $chart_type . '_chart_data_option'         => 'dynamic',
			GRAPHINA_PREFIX . $chart_type . '_chart_dynamic_data_option' => array( 'sql-builder', 'api' ),
		);
		if ( in_array( $chart_type, array( 'counter', 'tree', 'advance-datatable' ), true ) ) {
			$condition = array(
				GRAPHINA_PREFIX . $chart_type . '_element_data_option'         => 'dynamic',
				GRAPHINA_PREFIX . $chart_type . '_element_dynamic_data_option' => array( 'database', 'api' ),
			);
		}
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_chart_filter',
			array(
				'label'     => esc_html__( 'Chart Filter', 'graphina-charts-for-elementor' ),
				'condition' => $condition,
			)
		);

		if ( graphina_pro_active() ) {
			apply_filters( 'graphina_chart_filter_settings', $widget, $chart_type );
		}

		if ( ! graphina_pro_active() ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . 'get_pro_filter',
				array(
					'type' => Controls_Manager::RAW_HTML,
					'raw'  => graphina_get_teaser_template(
						array(
							'title'    => esc_html__( 'Get New Exciting Features', 'graphina-charts-for-elementor' ),
							'messages' => array( 'Get Graphina Pro for above exciting features and more.' ),
							'link'     => 'https://codecanyon.net/item/graphinapro-elementor-dynamic-charts-datatable/28654061',
						)
					)
				)
			);
		}

		$widget->end_controls_section();
	}

	/**
	 * Register Chart Filter Style
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_chart_filter_style( $widget, $chart_type ) {
		apply_filters('graphina_chart_filter_style',$widget,$chart_type);
	}

	/**
	 * Register Chart Restriction Controls
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function register_chart_restriction_controls( $widget, $chart_type ) {
		if ( graphina_pro_active() ) {
			apply_filters( 'graphina_chart_restriction_controllers', $widget, $chart_type );
		}
	}

	/**
	 * Register Chart Dataset Controls
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_chart_dataset( $widget, $chart_type ) {
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_2_1',
			array(
				'label'     => esc_html__( 'Categories', 'graphina-charts-for-elementor' ),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
				),
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_hr_category_listing',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_category',
			array(
				'label'       => esc_html__( 'Category Value', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
				'dynamic'     => array(
					'active' => true,
				),
				'description' => esc_html__( 'Note: For multiline text seperate Text by comma(,) and Only work if Labels Prefix/Postfix in X-axis is disable ', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_category_list',
			array(
				'label'       => esc_html__( 'Categories', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => $this->graphina_get_default_category( $chart_type ),
				'condition'   => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
				),
				'title_field' => '{{{ ' . GRAPHINA_PREFIX . $chart_type . '_chart_category }}}',
			)
		);

		$widget->end_controls_section();
	}

	/**
	 * Retrieves the default category structure for different chart types in Graphina.
	 *
	 * This function provides default category values based on the chart type.
	 * If the chart type is 'brush', it returns a numeric sequence from 1 to 25.
	 * For other chart types, it returns an array of predefined month names.
	 *
	 * A filter hook `graphina_default_chart_category` is applied to allow modification
	 * of the default category list dynamically.
	 *
	 * @since 4.0.0 (Graphina Revamp)
	 *
	 * @param string $chart_type The type of chart (e.g., 'brush', 'line', 'bar').
	 *
	 * @return array The default category data structure for the given chart type.
	 */
	protected function graphina_get_default_category( $chart_type ) {
		if ( 'brush' === $chart_type ) {
			$result = array();

			// Generate category values from 1 to 25 for 'brush' charts
			for ( $j = 0; $j < 25; $j++ ) {
				$result[] = array(
					GRAPHINA_PREFIX . $chart_type . '_chart_category' => $j + 1,
				);
			}
		} elseif ( 'geo_google' === $chart_type ) {
			$result = array(
				array( GRAPHINA_PREFIX . $chart_type . '_chart_category' => 'Germany' ),
				array( GRAPHINA_PREFIX . $chart_type . '_chart_category' => 'Japan' ),
				array( GRAPHINA_PREFIX . $chart_type . '_chart_category' => 'Mexico' ),
				array( GRAPHINA_PREFIX . $chart_type . '_chart_category' => 'India' ),
				array( GRAPHINA_PREFIX . $chart_type . '_chart_category' => 'South Africa' ),
				array( GRAPHINA_PREFIX . $chart_type . '_chart_category' => 'Russia' ),
			);
		} else {
			// Default category values for non-'brush' chart types
			$result = array(
				array( GRAPHINA_PREFIX . $chart_type . '_chart_category' => 'Jan' ),
				array( GRAPHINA_PREFIX . $chart_type . '_chart_category' => 'Feb' ),
				array( GRAPHINA_PREFIX . $chart_type . '_chart_category' => 'Mar' ),
				array( GRAPHINA_PREFIX . $chart_type . '_chart_category' => 'Apr' ),
				array( GRAPHINA_PREFIX . $chart_type . '_chart_category' => 'May' ),
				array( GRAPHINA_PREFIX . $chart_type . '_chart_category' => 'Jun' ),
			);
		}

		/**
		 * Filters the default category list for Graphina charts.
		 *
		 * Developers can modify the default category list by hooking into this filter.
		 *
		 * @since 4.0.0 (Graphina Revamp)
		 *
		 * @param array  $result     The default category array.
		 * @param string $chart_type The type of chart being processed.
		 */
		return apply_filters( 'graphina_default_chart_category', $result, $chart_type );
	}

	/**
	 * Registers Axis Color for Graphina widget.
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_geo_chart_axis_color( $widget, $chart_type ) {
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_color_axis',
			array(
				'label' => esc_html__( 'Color Axis', 'graphina-charts-for-elementor' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_color_axis_index',
			array(
				'label' => esc_html__( 'Color Axis', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::COLOR,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_color_axis',
			array(
				'label'   => esc_html__( 'Color Axis', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => array(
					array( GRAPHINA_PREFIX . $chart_type . '_chart_color_axis_index' => '#f8bbd0' ),
					array( GRAPHINA_PREFIX . $chart_type . '_chart_color_axis_index' => '#00853f' ),
					array( GRAPHINA_PREFIX . $chart_type . '_chart_color_axis_index' => '#e31b23' ),
				),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_color_axis_number',
			array(
				'label'   => esc_html__( 'Color Axis Value', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_color_axis_value',
			array(
				'label'   => esc_html__( 'Color Axis Value', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => array(
					array( GRAPHINA_PREFIX . $chart_type . '_chart_color_axis_number' => 0 ),
					array( GRAPHINA_PREFIX . $chart_type . '_chart_color_axis_number' => 10 ),
					array( GRAPHINA_PREFIX . $chart_type . '_chart_color_axis_number' => 20 ),
				),
			)
		);

		$widget->end_controls_section();
	}

	/**
	 * Registers Counter Chart Data Series for Graphina widget.
     *
     * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
     * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function counter_counter_chart_data_series( $widget, $chart_type ) {
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_3_chart_data_',
			array(
				'label'     => ! in_array( $chart_type, graphina_get_chart_type( 'table' ) ) ? esc_html__( 'Chart Data', 'graphina-charts-for-elementor' ) : esc_html__( 'Table Data', 'graphina-charts-for-elementor' ),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_element_data_option' => 'manual',
				),
			),
		);

		// Add the series title control (dependent on 'manual' data option)
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_series_title',
			array(
				'label'       => esc_html__( 'Title', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add Title', 'graphina-charts-for-elementor' ),
				'default'     => 'Element',
				'condition'   => array(
					GRAPHINA_PREFIX . $chart_type . '_element_data_option' => 'manual',
				),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		// Define the repeater for chart values (dependent on 'manual' data option)
		$repeaters = new Repeater();

		$repeaters->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_value',
			array(
				'label'       => esc_html__( 'Series Value', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		// Add the repeater control for the values list (dependent on 'manual' data option)
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_value_list',
			array(
				'label'     => esc_html__( 'Values List', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::REPEATER,
				'fields'    => $repeaters->get_controls(),
				'default'   => array(
					array( GRAPHINA_PREFIX . $chart_type . '_chart_value' => wp_rand( 10, 200 ) ),
					array( GRAPHINA_PREFIX . $chart_type . '_chart_value' => wp_rand( 10, 200 ) ),
					array( GRAPHINA_PREFIX . $chart_type . '_chart_value' => wp_rand( 10, 200 ) ),
					array( GRAPHINA_PREFIX . $chart_type . '_chart_value' => wp_rand( 10, 200 ) ),
					array( GRAPHINA_PREFIX . $chart_type . '_chart_value' => wp_rand( 10, 200 ) ),
					array( GRAPHINA_PREFIX . $chart_type . '_chart_value' => wp_rand( 100, 200 ) ),
				),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_element_data_option' => 'manual',
				),
			)
		);

		$widget->end_controls_section();
	}

	/**
	 * Register Chart Data Series Controls
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_chart_data_series( $widget, $chart_type, $default_count = 0 ) {

		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_3_chart_data_',
			array(
				'label' => ! in_array( $chart_type, graphina_get_chart_type( 'table' ) ) ? esc_html__( 'Chart Data', 'graphina-charts-for-elementor' ) : esc_html__( 'Table Data', 'graphina-charts-for-elementor' ),
			),
		);

		if ( ! in_array( $chart_type, array_merge( graphina_get_chart_type( 'table' ), array( 'gantt_google', 'geo_google' ) ) ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count_title',
				array(
					'label' => esc_html__( 'Set Data Elements', 'graphina-charts-for-elementor' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count',
				array(
					'label'   => esc_html__( 'Data Elements', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'description' => __( '<strong>Notice:</strong> The minimum required value for data elements is <strong>1</strong>. To increase the maximum data element value, please refer to the <a href="https://documentation.iqonic.design/graphina/php-hooks/optimizing-element-sets-in-graphina-with-php-hooks" target="_blank">PHP Hooks Documentation</a>.', 'graphina-charts-for-elementor' ),
					'default' => $default_count !== 0 ? $default_count : ( in_array( $chart_type, array( 'pie', 'polar', 'donut', 'radial', 'bubble', 'pie_google', 'donut_google', 'tree','org_google', 'gauge_google', 'distributed_column', 'nested_column' ), true ) ? 6 : 1 ),
					'min'     => 1,
					'max'     => $chart_type === 'gantt_google' ? 1 : graphina_default_setting( 'max_series_value' ),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_series_divider',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);

			$this->graphina_dynamic_chart_data_settings( $widget, $chart_type );

			if ( in_array( $chart_type, array( 'nested_column', 'candle' ) ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_color_divider',
					array(
						'type' => Controls_Manager::DIVIDER,
					)
				);
			}
			if ( $chart_type === 'distributed_column' ) {
				$this->graphina_distributed_column_chart_data( $widget, $chart_type );
			} elseif ( 'tree' === $chart_type ) {
				$this->tree_data_settings($widget, $chart_type);
			}else{
				$this->graphina_manual_chart_data_series( $widget, $chart_type );
			}
		} elseif ( 'data_table_lite' === $chart_type ) {
			$this->graphina_dynamic_chart_data_settings( $widget, $chart_type );
			$this->graphina_manual_table_data_series( $widget, $chart_type );
		} elseif ( 'gantt_google' === $chart_type ) {
			$this->graphina_dynamic_chart_data_settings( $widget, $chart_type );
			$this->graphina_gantt_google_chart_data_settings( $widget, $chart_type );
		} elseif ( 'geo_google' === $chart_type ) {
			$this->graphina_dynamic_chart_data_settings( $widget, $chart_type );
			$this->graphina_geo_google_chart_data_settings( $widget, $chart_type );
		}

		$widget->end_controls_section();
		do_action( 'graphina_forminator_addon_control_section', $widget, $chart_type );
		do_action( 'graphina_addons_control_section', $widget, $chart_type );
		$this->graphina_charts_filter_settings( $widget, $chart_type );
		$this->graphina_chart_filter_style( $widget, $chart_type );
	}

	/**
     * Register Dynamic Chart Data Settings Controls
     *
     * Adds a set of controls to a given widget, based on the specified chart type, for dynamic chart data.
     * These controls allow users to configure the chart data dynamically.
	 */
	protected function graphina_distributed_column_chart_data( $widget, $chart_type ) {
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_title_3_',
			array(
				'label'       => 'Title',
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add Tile', 'graphina-charts-for-elementor' ),
				'default'     => 'Element ',
				'dynamic'     => array(
					'active' => true,
				),
				'condition'   => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
				),
			)
		);
		$repeater = new Repeater();

		$repeater->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_value_4_',
			array(
				'label'       => esc_html__( 'Chart Value', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		/** Chart value list. */
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_value_list_4_1_',
			array(
				'label'       => esc_html__( 'Chart value list', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' => wp_rand( 100, 200 ) ),
					array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' => wp_rand( 100, 200 ) ),
					array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' => wp_rand( 100, 200 ) ),
					array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' => wp_rand( 100, 200 ) ),
					array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' => wp_rand( 100, 200 ) ),
					array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' => wp_rand( 100, 200 ) ),
				),
				'condition'  => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
				),
				'title_field' => '{{{ ' . GRAPHINA_PREFIX . $chart_type . '_chart_value_4_}}}',
			)
		);
	}


	/**
	 * Registers Geo Chart Data for Graphina widget.
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	protected function graphina_geo_google_chart_data_settings( $widget, $chart_type ) {
        $max_row = graphina_default_setting( 'max_series_value' );
        $widget->add_control(
            GRAPHINA_PREFIX . $chart_type . '_can_geo_have_more_element',
            array(
                'label'     => esc_html__( 'Multiple Element', 'graphina-charts-for-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
                'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
                'default'   => false,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_option'	=> 'manual',
                ),
            )
        );


        $widget->add_control(
            GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count',
            array(
                'label'   => esc_html__( 'Data Elements', 'graphina-charts-for-elementor' ),
                'type'    => Controls_Manager::NUMBER,
                'description' => __( '<strong>Notice:</strong> The minimum required value for data elements is <strong>1</strong>. To increase the maximum data element value, please refer to the <a href="https://documentation.iqonic.design/graphina/php-hooks/optimizing-element-sets-in-graphina-with-php-hooks" target="_blank">PHP Hooks Documentation</a>.', 'graphina-charts-for-elementor' ),
                'default' => 1,
                'min'     => 1,
                'max'     => graphina_default_setting( 'max_series_value' ),
                'condition' => array(
                    GRAPHINA_PREFIX . $chart_type . '_can_geo_have_more_element' 		=> 'yes',
					GRAPHINA_PREFIX . $chart_type . '_chart_data_option' 				=> 'manual',
                ),
            )
        );

        for ( $i = 0; $i <= $max_row; $i++ ) {
            $widget->add_control(
                GRAPHINA_PREFIX . $chart_type . '_chart_title_3_element_setting_' . $i,
                array(
                    'label'       => esc_html__( 'Title', 'graphina-charts-for-elementor' ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => esc_html__( 'Add Title', 'graphina-charts-for-elementor' ),
                    'default'     => esc_html__( 'Element ', 'graphina-charts-for-elementor' ) . ( $i + 1 ),
                    'condition'   => array(
                        GRAPHINA_PREFIX . $chart_type . '_can_geo_have_more_element'    	=> 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option' 				=> 'manual',
                        GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count'         	=> range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
                    ),
                )
            );

            $repeater = new Repeater();

            $repeater->add_control(
                GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting_' . $i,
                array(
                    'label'       => esc_html__( 'Element Value', 'graphina-charts-for-elementor' ),
                    'type'        => Controls_Manager::NUMBER,
                    'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
                    'dynamic'     => array(
                        'active' => true,
                    ),
                )
            );

            /** Chart value list. */
            $widget->add_control(
                GRAPHINA_PREFIX . $chart_type . '_value_list_3_1_element_setting_' . $i,
                array(
                    'label'       => esc_html__( 'Values', 'graphina-charts-for-elementor' ),
                    'type'        => Controls_Manager::REPEATER,
                    'fields'      => $repeater->get_controls(),
                    'default'     => array(
                        array( GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting_' . $i => rand( 10, 200 ) ),
                        array( GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting_' . $i => rand( 10, 200 ) ),
                        array( GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting_' . $i => rand( 10, 200 ) ),
                        array( GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting_' . $i => rand( 10, 200 ) ),
                        array( GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting_' . $i => rand( 10, 200 ) ),
                        array( GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting_' . $i => rand( 10, 200 ) ),
                    ),
                    'title_field' => '{{{ ' . GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting_' . $i . ' }}}',
                    'condition'   => array(
                        GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count'         	=> range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
                        GRAPHINA_PREFIX . $chart_type . '_can_geo_have_more_element'    	=> 'yes',
                        GRAPHINA_PREFIX . $chart_type . '_chart_data_option' 				=> 'manual',
                    ),
                )
            );
        }
        
        $widget->add_control(
            GRAPHINA_PREFIX . $chart_type . '_chart_title_3_element_setting',
            array(
                'label'       => esc_html__( 'Title', 'graphina-charts-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Add Tile', 'graphina-charts-for-elementor' ),
                'default'     => 'Element',
                'dynamic'     => array(
                    'active' => true,
                ),
                'condition'   => array(
                    GRAPHINA_PREFIX . $chart_type . '_can_geo_have_more_element!'    => 'yes',
                    GRAPHINA_PREFIX . $chart_type . '_chart_data_option'             => 'manual',
                ),
            )
        );

        $repeater = new Repeater();

        $repeater->add_control(
            GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting',
            array(
                'label'       => esc_html__( 'Element Value', 'graphina-charts-for-elementor' ),
                'type'        => Controls_Manager::NUMBER,
                'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
                'dynamic'     => array(
                    'active' => true,
                ),
            )
        );

        /** Chart value list. */
        $widget->add_control(
            GRAPHINA_PREFIX . $chart_type . '_value_list_3_1_element_setting',
            array(
                'label'       => esc_html__( 'Values', 'graphina-charts-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => array(
                    array( GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting' => rand( 10, 200 ) ),
                    array( GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting' => rand( 10, 200 ) ),
                    array( GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting' => rand( 10, 200 ) ),
                    array( GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting' => rand( 10, 200 ) ),
                    array( GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting' => rand( 10, 200 ) ),
                    array( GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting' => rand( 10, 200 ) ),
                ),
                'title_field' => '{{{ ' . GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting }}}',
                'condition'   => array(
                    GRAPHINA_PREFIX . $chart_type . '_can_geo_have_more_element!'    => 'yes',
                    GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
                ),
            )
        );
    }

	/**
	 * Registers Gantt Chart Data for Graphina widget.
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	protected function graphina_gantt_google_chart_data_settings( $widget, $chart_type ) {
		$repeater = new Repeater();

		$repeater->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_name',
			array(
				'label'       => 'Element Name',
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add Element Name', 'graphina-charts-for-elementor' ),
				'default'     => 'Task',
			)
		);

		$repeater->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_resource',
			array(
				'label'       => 'Element Resource',
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add Element Resource', 'graphina-charts-for-elementor' ),
				'default'     => '',
			)
		);

		$repeater->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_start_date',
			array(
				'label'          => 'Start Date',
				'type'           => Controls_Manager::DATE_TIME,
				'picker_options' => array(
					'enableTime' => false,
				),
				'placeholder'    => esc_html__( 'Start Date', 'graphina-charts-for-elementor' ),
			)
		);

		$repeater->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_end_date',
			array(
				'label'          => 'End Date',
				'type'           => Controls_Manager::DATE_TIME,
				'picker_options' => array(
					'enableTime' => false,
				),
				'placeholder'    => esc_html__( 'End Date', 'graphina-charts-for-elementor' ),
			)
		);

		$repeater->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_percent_complete',
			array(
				'label'       => 'Percent Complete',
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => esc_html__( 'Percent Complete', 'graphina-charts-for-elementor' ),
				'max'         => 100,
				'min'         => 0,
				'default'     => rand( 10, 100 ),
			)
		);

		$repeater->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_sql_builder_refresh',
			array(
				'label'       => esc_html__( 'Refresh', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'refresh',
				'options'     => array(
					'refresh' => array(
						'title' => esc_html__( 'Classic', 'graphina-charts-for-elementor' ),
						'icon'  => 'fas fa-sync',
					),
				),
				'description' => esc_html__( 'Click if Dependencies column list is showing empty', 'graphina-charts-for-elementor' ),

			)
		);

		$repeater->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_dependencies',
			array(
				'label'       => 'Dependencies',
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'placeholder' => esc_html__( 'Dependencies', 'graphina-charts-for-elementor' ),
				'options'     => '',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_value_list_3_1_repeaters',
			array(
				'label'       => esc_html__( 'Values', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => $this->ganttDataGenerator( $chart_type, 5 ),
				'title_field' => '{{{ ' . GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_name }}}',
				'condition'   => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
				),
			)
		);
	}

	/**
	 * Generates sample Gantt chart data.
	 *
	 * This function dynamically generates Gantt chart data with randomized
	 * start and end dates, along with task completion percentages.
	 * The generated data structure is compatible with the Graphina plugin's
	 * charting system, ensuring seamless integration.
	 *
	 * Key Features:
	 * - Generates a specified number of tasks (default: 3).
	 * - Assigns a random start and end date to each task.
	 * - Randomly assigns a percentage of completion.
	 * - Uses dynamic prefixes for flexible chart integration.
	 *
	 * @param string $chart_type  The type of the chart, used for dynamic key generation.
	 * @param int    $count       The number of tasks to generate (default: 3).
	 *
	 * @return array Returns an array of associative arrays, each representing a Gantt chart task.
	 */
	protected function ganttDataGenerator( $chart_type = '', $count = 3 ) {
		$result = array();
		for ( $j = 1; $j <= $count; $j++ ) {
			$start    = graphina_get_random_date( date( 'Y-m-d' ), 'Y-m-d', array( 'day' => rand( 0, 5 ) ) );
			$end      = graphina_get_random_date( date( 'Y-m-d', strtotime( $start ) ), 'Y-m-d', array( 'day' => rand( 0, 5 ) ) );
			$result[] = array(
				GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_name' => 'Task ' . $j,
				GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_percent_complete' => rand( 10, 100 ),
				GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_end_date' => $end,
				GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_start_date' => $start,
			);
		}
		return $result;
	}

	/**
	 * Registers Table Data Series for Graphina widget.
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	protected function graphina_manual_table_data_series( $widget, $chart_type ) {

		if ( in_array( $chart_type, array( 'donut_google', 'pie_google' ) ) ) {

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_datalabel_sections',
				array(
					'label'     => esc_html__( 'Data Table Options', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_columnone_title',
				array(
					'label'       => esc_html__( 'Label Title', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'Month', 'graphina-charts-for-elementor' ),
					'description' => esc_html__( 'Data Values Title in DataTable', 'graphina-charts-for-elementor' ),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_columntwo_title',
				array(
					'label'       => esc_html__( 'Value Title', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'Sales', 'graphina-charts-for-elementor' ),
					'description' => esc_html__( 'Data Values Title in DataTable', 'graphina-charts-for-elementor' ),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_datalabel_sections_divider',
				array(
					'type'      => Controls_Manager::DIVIDER,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
					),
				)
			);
		}

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_table_data_series',
			array(
				'label'     => esc_html__( 'Set Number Of Columns and Rows', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
				),
			)
		);

		$max_row = graphina_default_setting( 'max_row_value' );
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_rows',
			array(
				'label'     => esc_html__( 'No of Rows', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3,
				'min'       => 1,
				'max'       => $max_row,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
				),
			)
		);

		$max_column = graphina_default_setting( 'max_column_value' );
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_columns',
			array(
				'label'     => esc_html__( 'No of Columns', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3,
				'min'       => 1,
				'max'       => $max_column,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_table_data_divider',
			array(
				'type'      => Controls_Manager::DIVIDER,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_table_data_column',
			array(
				'label'     => esc_html__( 'Set Column Data', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
				),
			)
		);
		for ( $i = 0; $i < $max_column; $i++ ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_header_title_' . $i,
				array(
					'label'       => esc_html__( 'Column Header', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Add Title', 'graphina-charts-for-elementor' ),
					'default'     => 'Column ' . ( $i + 1 ),
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_element_columns' => range( 1 + $i, $max_column ),
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
					),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . 'has_column_width' . $i,
				array(
					'label'       => esc_html__( 'Add Column Width', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'   => false,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_element_columns' => range( 1 + $i, $max_column ),
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option'	=> 'manual',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_table_column_width_' . $i,
				array(
					'label'   => esc_html__( 'Column Width (px)', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'min'     => 20,
					'default' => '150',
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_element_columns' => range( 1 + $i, $max_column ),
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
						GRAPHINA_PREFIX . $chart_type . 'has_column_width'.$i => 'yes',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_jquery_manual_column_wise_alignment' . $i,
				array(
					'label'     => esc_html__( 'Column wise alighment', 'graphina-charts-for-elementor' ) . ' ' . $i+1,
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'   => false,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
						GRAPHINA_PREFIX . $chart_type . '_element_columns' => range( 1 + $i, $max_column ),
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_table_manual_body_align' . $i,
				array(
					'label'     => esc_html__( 'Table Alignment', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
					'options'   => array(
						'left'   => array(
							'title' => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'graphina-charts-for-elementor' ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'  => array(
							'title' => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
						GRAPHINA_PREFIX . $chart_type . '_element_columns' => range( 1 + $i, $max_column ),
						GRAPHINA_PREFIX . $chart_type . '_jquery_manual_column_wise_alignment'.$i => 'yes',
					),
				)
			);
		}

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_table_data_divider1' . $i,
			array(
				'type'      => Controls_Manager::DIVIDER,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_table_data_row',
			array(
				'label'     => esc_html__( 'Set Row Data', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
				),
			)
		);
		for ( $i = 0; $i < $max_row; $i++ ) {
			$repeater = new Repeater();

			$repeater->add_control(
				GRAPHINA_PREFIX . $chart_type . '_row_value',
				array(
					'label'       => esc_html__( 'Row Value', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);

			$repeater->add_control(
				GRAPHINA_PREFIX . $chart_type . '_row_url',
				array(
					'label'        => esc_html__( 'Row URL', 'graphina-charts-for-elementor' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'label_off'    => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'return_value' => 'yes',
					'default'      => 'no',
					'separator'    => 'before', // Add the checkbox before the row value control.
				)
			);

			$repeater->add_control(
				GRAPHINA_PREFIX . $chart_type . '_row_link_text',
				array(
					'label'       => esc_html__( 'Link Text', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Add Link Text', 'graphina-charts-for-elementor' ),
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_row_url' => 'yes', // Show this control only if the URL option is enabled.
					),
				)
			);

			/** Chart value list. */
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_row_list' . $i,
				array(
					/* translators: %d: 1 */
					'label'     => esc_html( sprintf( __( 'Row Data %d', 'graphina-charts-for-elementor' ), $i + 1 ) ),
					'type'      => Controls_Manager::REPEATER,
					'fields'    => $repeater->get_controls(),
					'default'   => array(
						array( GRAPHINA_PREFIX . $chart_type . '_row_value' => 'Data 1' ),
						array( GRAPHINA_PREFIX . $chart_type . '_row_value' => 'Data 2' ),
						array( GRAPHINA_PREFIX . $chart_type . '_row_value' => 'Data 3' ),
					),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_element_rows' => range( 1 + $i, $max_row ),
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
					),
				)
			);
		}
	}


	/**
	 * Registers Data Series for Graphina widget.
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	protected function graphina_manual_chart_data_series( $widget, $chart_type ) {
		$max_series    = graphina_default_setting( 'max_series_value' );
		$default_label = graphina_default_setting( 'categories', 'string' );
		$colors        = $this->graphina_colors();
		if('column' === $chart_type) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_can_chart_negative_values',
				array(
					'label'     => esc_html__( 'Default Negative', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'   => false,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
					),
				)
			);
		}
		for ( $i = 0; $i < $max_series; $i++ ) {
			if ( in_array( $chart_type, array( 'donut', 'pie', 'polar', 'radial', 'pie_google', 'donut_google' ) ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_section_series' . $i,
					array(
						'label'     => esc_html__( 'Element ', 'graphina-charts-for-elementor' ) . ( $i + 1 ),
						'type'      => Controls_Manager::HEADING,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_label' . $i,
					array(
						'label'       => 'Label',
						'type'        => Controls_Manager::TEXT,
						'placeholder' => esc_html__( 'Add Label', 'graphina-charts-for-elementor' ),
						'default'     => isset($default_label[ $i ]) ? $default_label[ $i ] : '',
						'dynamic'     => array(
							'active' => true,
						),
						'condition'   => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_value' . $i,
					array(
						'label'       => 'Value',
						'type'        => Controls_Manager::NUMBER,
						'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
						'default'     => $i*30,
						'dynamic'     => array(
							'active' => true,
						),
						'condition'   => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);

				if ( 'donut_google' === $chart_type || 'pie_google' === $chart_type ) {
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_element_color_' . $i,
						array(
							'label'     => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => ! empty($colors[ $i ]) ? $colors[ $i ] : '',
							'condition' => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
							),

						)
					);
				}
			} elseif ( 'mixed' === $chart_type ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_title_4_' . $i,
					array(
						'label'       => esc_html__( 'Title', 'graphina-charts-for-elementor' ),
						'type'        => Controls_Manager::TEXT,
						'placeholder' => esc_html__( 'Add Tile', 'graphina-charts-for-elementor' ),
						'default'     => 'Element ' . ( $i + 1 ),
						'dynamic'     => array(
							'active' => true,
						),
						'condition'   => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),

					)
				);

				$widget->add_control(
					'hr_4_05_' . $i,
					array(
						'type'      => Controls_Manager::DIVIDER,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_element_values_4_' . $i,
					array(
						'label'     => esc_html__( 'Value Setting', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::HEADING,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_can_chart_negative_values_4_' . $i,
					array(
						'label'     => esc_html__( 'Default Negative', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
						'default'   => false,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);

				$repeater = new Repeater();

				$repeater->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i,
					array(
						'label'       => esc_html__( 'Series Value', 'graphina-charts-for-elementor' ),
						'type'        => Controls_Manager::NUMBER,
						'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
						'dynamic'     => array(
							'active' => true,
						),
					)
				);

				/** Chart value list. */
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_value_list_4_1_' . $i,
					array(
						'label'       => esc_html__( 'Values List', 'graphina-charts-for-elementor' ),
						'type'        => Controls_Manager::REPEATER,
						'fields'      => $repeater->get_controls(),
						'default'     => array(
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => rand( 10, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => rand( 10, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => rand( 10, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => rand( 10, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => rand( 10, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => rand( 10, 200 ) ),
						),
						'condition'   => array(
							GRAPHINA_PREFIX . $chart_type . '_can_chart_negative_values_4_' . $i . '!' => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
						'title_field' => '{{{ ' . GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i . ' }}}',
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_value_list_4_2_' . $i,
					array(
						'label'       => esc_html__( 'Values', 'graphina-charts-for-elementor' ),
						'type'        => Controls_Manager::REPEATER,
						'fields'      => $repeater->get_controls(),
						'default'     => array(
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => rand( -200, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => rand( -200, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => rand( -200, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => rand( -200, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => rand( -200, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => rand( -200, 200 ) ),
						),
						'condition'   => array(
							GRAPHINA_PREFIX . $chart_type . '_can_chart_negative_values_4_' . $i => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
						'title_field' => '{{{ ' . GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i . ' }}}',
					)
				);

			}  elseif('column' === $chart_type){
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_title_4_' . $i,
					array(
						'label'       => esc_html__( 'Element Title', 'graphina-charts-for-elementor' ),
						'type'        => Controls_Manager::TEXT,
						'placeholder' => esc_html__( 'Add Tile', 'graphina-charts-for-elementor' ),
						'default'     => 'Element ' . ( $i + 1 ),
						'condition'	  => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
						'dynamic'     => array(
							'active' => true,
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_depends_3_' . $i,
					array(
						'label'       => 'Depends on Right Y-axis',
						'type'        => Controls_Manager::SWITCHER,
						'label_on'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
						'label_off'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
						'default'     => false,
						'condition'   => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count'              => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
							GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title_enable'    => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count!' => 1,
						),
						'description' => esc_html__( 'Warning: Each Y-axis must be associated with at least one series. Please ensure that all elements are not set with only the left or right axis.', 'graphina-charts-for-elementor' ),
					)
				);

				$repeater = new Repeater();

				$repeater->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i,
					array(
						'label'       => esc_html__( 'Chart Value', 'graphina-charts-for-elementor' ),
						'type'        => Controls_Manager::NUMBER,
						'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
						'dynamic'     => array(
							'active' => true,
						),
					)
				);

				/** Chart value list. */
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_value_list_4_1_' . $i,
					array(
						'label'       => esc_html__( 'Chart value list', 'graphina-charts-for-elementor' ),
						'type'        => Controls_Manager::REPEATER,
						'fields'      => $repeater->get_controls(),
						'default'     => array(
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => wp_rand( 100, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => wp_rand( 100, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => wp_rand( 100, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => wp_rand( 100, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => wp_rand( 100, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => wp_rand( 100, 200 ) ),
						),
						'condition'   => array(
							GRAPHINA_PREFIX . $chart_type . '_can_chart_negative_values!' => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
						'title_field' => '{{{ ' . GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i . ' }}}',
					)
				);
				/** Chart value list. */

				/** Chart value negative list. */
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_value_list_4_2_' . $i,
					array(
						'label'       => esc_html__( 'Chart value list', 'graphina-charts-for-elementor' ),
						'type'        => Controls_Manager::REPEATER,
						'fields'      => $repeater->get_controls(),
						'default'     => array(
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => wp_rand( -200, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => wp_rand( -200, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => wp_rand( -200, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => wp_rand( -200, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => wp_rand( -200, 200 ) ),
							array( GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i => wp_rand( -200, 200 ) ),
						),
						'condition'   => array(
							GRAPHINA_PREFIX . $chart_type . '_can_chart_negative_values' => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
						'title_field' => '{{{' . GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' . $i . ' }}}',
					)
				);
			}
			elseif ( 'org_google' === $chart_type ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_section_series' . $i,
					array(
						'label'     => esc_html__( 'Element ', 'graphina-charts-for-elementor' ) . ( $i + 1 ),
						'type'      => Controls_Manager::HEADING,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_google_chart_child' . $i,
					array(
						'label'       => 'Child',
						'type'        => Controls_Manager::TEXT,
						'placeholder' => esc_html__( 'Add Child', 'graphina-charts-for-elementor' ),
						'default'     => 'Node ' . ( $i + 1 ),
						'dynamic'     => array(
							'active' => true,
						),
						'condition'   => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option'        => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count'  => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),

					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_google_chart_parent' . $i,
					array(
						'label'       => 'Parent Node',
						'type'        => Controls_Manager::TEXT,
						'placeholder' => esc_html__( 'Add Parent', 'graphina-charts-for-elementor' ),
						'dynamic'     => array(
							'active' => true,
						),
						'default'     => 'Node 1',
						'condition'   => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option'        => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count'  => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),

					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_google_chart_tooltip' . $i,
					array(
						'label'       => 'Tooltip',
						'type'        => Controls_Manager::TEXT,
						'placeholder' => esc_html__( 'Add Tooltip', 'graphina-charts-for-elementor' ),
						'dynamic'     => array(
							'active' => true,
						),
						'default'     => 'Node',
						'condition'   => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option'        => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count'  => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),

					)
				);
			} 
			elseif ( 'gauge_google' === $chart_type ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_section_series_1' . $i,
					array(
						'label'     => esc_html__( 'Element ', 'graphina-charts-for-elementor' ) . ( $i + 1 ),
						'type'      => Controls_Manager::HEADING,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_element_setting_title_' . $i,
					array(
						'label'     => esc_html__( 'Label', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::TEXT,
						'default'   => ! empty ( $this->defaultLabel[ $i ] ) ? $this->defaultLabel[ $i ] : '',
						'dynamic'   => array(
							'active' => true,
						),
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_element_setting_value_' . $i,
					array(
						'label'     => esc_html__( 'Value', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::NUMBER,
						'default'   => $i*10,
						'dynamic'   => array(
							'active' => true,
						),
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
			} else {
				// for two axis
				if ( in_array( $chart_type, array( 'area', 'line','bar', 'bubble' , 'candle', 'scatter', 'brush' ) ) ) {
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_depends_3_' . $i,
						array(
							'label'       => 'Depends on Right Y-axis',
							'type'        => Controls_Manager::SWITCHER,
							'label_on'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
							'label_off'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
							'default'     => false,
							'condition'   => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
								GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count'              => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
								GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title_enable'    => 'yes',
								GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count!' => 1,
							),
							'description' => esc_html__( 'Warning: Each Y-axis must be associated with at least one series. Please ensure that all elements are not set with only the left or right axis.', 'graphina-charts-for-elementor' ),
						)
					);
				}

				$repeater = new Repeater();

				if ( $chart_type === 'bubble' ) {

					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_title_3_' . $i,
						array(
							'label'       => 'Value',
							'type'        => Controls_Manager::TEXT,
							'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
							'default'     => 'Element ' . ( $i + 1 ),
							'dynamic'     => array(
								'active' => true,
							),
							'condition'   => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
								GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
							),
						)
					);

					$repeater->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_x_value_3_' . $i,
						array(
							'label'       => 'Chart X Value',
							'type'        => Controls_Manager::NUMBER,
							'placeholder' => esc_html__( 'Add X Value', 'graphina-charts-for-elementor' ),
							'dynamic'     => array(
								'active' => true,
							),
						)
					);

					$repeater->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_y_value_3_' . $i,
						array(
							'label'       => 'Chart Y Value',
							'type'        => Controls_Manager::NUMBER,
							'placeholder' => esc_html__( 'Add Y Value', 'graphina-charts-for-elementor' ),
							'dynamic'     => array(
								'active' => true,
							),
						)
					);

					$repeater->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_z_value_3_' . $i,
						array(
							'label'       => 'Chart Z Value',
							'type'        => Controls_Manager::NUMBER,
							'placeholder' => esc_html__( 'Add Z Value', 'graphina-charts-for-elementor' ),
							'dynamic'     => array(
								'active' => true,
							),
						)
					);

					$x = array(
						'min' => 10,
						'max' => 1000,
					);
					$y = array(
						'min' => 10,
						'max' => 200,
					);
					$z = array(
						'min' => 10,
						'max' => 200,
					);
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_value_list_3_' . $i,
						array(
							'label'     => esc_html__( 'Chart value list', 'graphina-charts-for-elementor' ),
							'type'      => Controls_Manager::REPEATER,
							'fields'    => $repeater->get_controls(),
							'default'   => $this->bubble_data_generator( 'bubble', $i, 6, $x, $y, $z ),
							'condition' => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
								GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
							),
						)
					);
				} elseif ( $chart_type === 'timeline' ) {
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_title_3_' . $i,
						array(
							'label'       => 'Title',
							'type'        => Controls_Manager::TEXT,
							'placeholder' => esc_html__( 'Add Tile', 'graphina-charts-for-elementor' ),
							'default'     => 'Element ' . ( $i + 1 ),
							'dynamic'     => array(
								'active' => true,
							),
							'condition'   => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
								GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
							),
						)
					);
					$repeater->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_from_date_' . $i,
						array(
							'label'       => esc_html__( 'From Date ( Y )', 'graphina-charts-for-elementor' ),
							'type'        => Controls_Manager::DATE_TIME,
							'placeholder' => esc_html__( 'Select Date', 'graphina-charts-for-elementor' ),
						)
					);

					$repeater->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_to_date_' . $i,
						array(
							'label'       => esc_html__( 'To Date ( Y )', 'graphina-charts-for-elementor' ),
							'type'        => Controls_Manager::DATE_TIME,
							'placeholder' => esc_html__( 'Select Date', 'graphina-charts-for-elementor' ),
						)
					);

					/** Chart value list. */
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_value_list_' . $i,
						array(
							'label'     => esc_html__( 'Chart Value list', 'graphina-charts-for-elementor' ),
							'type'      => Controls_Manager::REPEATER,
							'fields'    => $repeater->get_controls(),
							'default'   => $this->timeline_data_generator( 'timeline', $i, 6 ),
							'condition' => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
								GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
							),
						)
					);
				} elseif ( 'nested_column' === $chart_type ) {

					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_title_3_' . $i,
						array(
							'label'       => 'Value',
							'type'        => Controls_Manager::TEXT,
							'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
							'default'     => 'Element ' . ( $i + 1 ),
							'dynamic'     => array(
								'active' => true,
							),
							'condition'   => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
								GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
							),
						)
					);

					$repeater->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_title_3_' . $i,
						array(
							'label'       => 'Title',
							'type'        => Controls_Manager::TEXT,
							'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
							'dynamic'     => array(
								'active' => true,
							),
						)
					);

					$repeater->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_value_3_' . $i,
						array(
							'label'       => 'Value',
							'type'        => Controls_Manager::NUMBER,
							'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
							'dynamic'     => array(
								'active' => true,
							),
						)
					);

					/** Chart value list. */
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_value_list_3_1_' . $i,
						array(
							'label'       => esc_html__( 'Sub Data', 'graphina-charts-for-elementor' ),
							'type'        => Controls_Manager::REPEATER,
							'fields'      => $repeater->get_controls(),
							'default'     => array(
								array(
									GRAPHINA_PREFIX . $chart_type . '_chart_data_title_3_' . $i => 'Data 1',
									GRAPHINA_PREFIX . $chart_type . '_chart_data_value_3_' . $i => rand( 10, 200 ),
								),
								array(
									GRAPHINA_PREFIX . $chart_type . '_chart_data_title_3_' . $i => 'Data 2',
									GRAPHINA_PREFIX . $chart_type . '_chart_data_value_3_' . $i => rand( 10, 200 ),
								),
								array(
									GRAPHINA_PREFIX . $chart_type . '_chart_data_title_3_' . $i => 'Data 3',
									GRAPHINA_PREFIX . $chart_type . '_chart_data_value_3_' . $i => rand( 10, 200 ),
								),
								array(
									GRAPHINA_PREFIX . $chart_type . '_chart_data_title_3_' . $i => 'Data 4',
									GRAPHINA_PREFIX . $chart_type . '_chart_data_value_3_' . $i => rand( 10, 200 ),
								),
								array(
									GRAPHINA_PREFIX . $chart_type . '_chart_data_title_3_' . $i => 'Data 5',
									GRAPHINA_PREFIX . $chart_type . '_chart_data_value_3_' . $i => rand( 10, 200 ),
								),
								array(
									GRAPHINA_PREFIX . $chart_type . '_chart_data_title_3_' . $i => 'Data 6',
									GRAPHINA_PREFIX . $chart_type . '_chart_data_value_3_' . $i => rand( 10, 200 ),
								),
							),
							'condition'   => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
								GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
							),
							'title_field' => '{{{ ' . GRAPHINA_PREFIX . $chart_type . '_chart_data_title_3_' . $i . ' }}}',
						)
					);
				} elseif ( 'candle' === $chart_type ) {

					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_title_3_' . $i,
						array(
							'label'       => 'Value',
							'type'        => Controls_Manager::TEXT,
							'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
							'default'     => 'Element ' . ( $i + 1 ),
							'dynamic'     => array(
								'active' => true,
							),
							'condition'   => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
								GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
							),
						)
					);

					$repeater->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_value_date_3_' . $i,
						array(
							'label'       => esc_html__( 'Chart Date ( X ) Value', 'graphina-charts-for-elementor' ),
							'type'        => Controls_Manager::DATE_TIME,
							'placeholder' => esc_html__( 'Select Date', 'graphina-charts-for-elementor' ),
						)
					);

					$repeater->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_value_open_3_' . $i,
						array(
							'label'       => esc_html__( 'Open Value', 'graphina-charts-for-elementor' ),
							'type'        => Controls_Manager::NUMBER,
							'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
							'dynamic'     => array(
								'active' => true,
							),
						)
					);

					$repeater->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_value_high_3_' . $i,
						array(
							'label'       => esc_html__( 'High Value', 'graphina-charts-for-elementor' ),
							'type'        => Controls_Manager::NUMBER,
							'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
							'dynamic'     => array(
								'active' => true,
							),
						)
					);

					$repeater->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_value_low_3_' . $i,
						array(
							'label'       => esc_html__( 'Low Value', 'graphina-charts-for-elementor' ),
							'type'        => Controls_Manager::NUMBER,
							'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
							'dynamic'     => array(
								'active' => true,
							),
						)
					);

					$repeater->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_value_close_3_' . $i,
						array(
							'label'       => esc_html__( 'Close Value', 'graphina-charts-for-elementor' ),
							'type'        => Controls_Manager::NUMBER,
							'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
							'dynamic'     => array(
								'active' => true,
							),
						)
					);

					/** Chart value list. */
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_value_list_3_1_' . $i,
						array(
							'label'       => esc_html__( 'Chart value list', 'graphina-charts-for-elementor' ),
							'type'        => Controls_Manager::REPEATER,
							'fields'      => $repeater->get_controls(),
							'default'     => $this->candle_data_generator( 'candle', $i, 6000, 8000, 500, 50 ),
							'title_field' => '{{{ ' . GRAPHINA_PREFIX . $chart_type . '_chart_value_date_3_' . $i . ' }}}',
							'condition'   => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
								GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
							),
						)
					);
				} elseif ( 'brush' === $chart_type ) {
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_title_3_' . $i,
						array(
							'label'       => 'Title',
							'type'        => Controls_Manager::TEXT,
							'placeholder' => esc_html__( 'Add Tile', 'graphina-charts-for-elementor' ),
							'default'     => 'Element ' . ( $i + 1 ),
							'dynamic'     => array(
								'active' => true,
							),
							'condition'   => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
								GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
							),
						)
					);

					/** Chart value list. */

					$repeater->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_value_3_' . $i,
						array(
							'label'       => 'Element Value',
							'type'        => Controls_Manager::NUMBER,
							'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
							'dynamic'     => array(
								'active' => true,
							),
						)
					);

					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_value_list_3_1_' . $i,
						array(
							'label'       => esc_html__( 'Values', 'graphina-charts-for-elementor' ),
							'type'        => Controls_Manager::REPEATER,
							'fields'      => $repeater->get_controls(),
							'default'     => $this->brushDataGenerator( $chart_type, $i, 25 ),
							'title_field' => '{{{ ' . GRAPHINA_PREFIX . $chart_type . '_chart_value_3_' . $i . ' }}}',
							'condition'   => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
								GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
							),
						)
					);
				} else {

					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_title_3_' . $i,
						array(
							'label'       => 'Title',
							'type'        => Controls_Manager::TEXT,
							'placeholder' => esc_html__( 'Add Tile', 'graphina-charts-for-elementor' ),
							'default'     => 'Element ' . ( $i + 1 ),
							'dynamic'     => array(
								'active' => true,
							),
							'condition'   => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
								GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
							),
						)
					);

					$repeater->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_value_3_' . $i,
						array(
							'label'       => esc_html__( 'Element Value', 'graphina-charts-for-elementor' ),
							'type'        => Controls_Manager::NUMBER,
							'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
							'dynamic'     => array(
								'active' => true,
							),
						)
					);
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_value_list_3_1_' . $i,
						array(
							'label'       => esc_html__( 'Values', 'graphina-charts-for-elementor' ),
							'type'        => Controls_Manager::REPEATER,
							'fields'      => $repeater->get_controls(),
							'default'     => array(
								array( GRAPHINA_PREFIX . $chart_type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
								array( GRAPHINA_PREFIX . $chart_type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
								array( GRAPHINA_PREFIX . $chart_type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
								array( GRAPHINA_PREFIX . $chart_type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
								array( GRAPHINA_PREFIX . $chart_type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
								array( GRAPHINA_PREFIX . $chart_type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
							),
							'title_field' => '{{{ ' . GRAPHINA_PREFIX . $chart_type . '_chart_value_3_' . $i . ' }}}',
							'condition'   => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_data_option' => 'manual',
								GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
							),
						)
					);
				}
			}
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_data_divider' . $i,
				array(
					'type'      => Controls_Manager::DIVIDER,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_option'        => 'manual',
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count'  => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
		}
	}

	/**
	 * Generates sample data for Brush Charts.
	 *
	 * This function dynamically generates an array of random numerical values
	 * for use in brush-style charts within the Graphina plugin. The generated
	 * data ensures flexibility by incorporating dynamic prefixes, making it
	 * adaptable for various chart types.
	 *
	 * Key Features:
	 * - Generates a specified number of random data points (default: 20).
	 * - Uses a dynamic chart type and index for flexible key structuring.
	 * - Ensures compatibility with the Graphina plugin's data structure.
	 *
	 * @param string $chart_type The type of the chart, used for dynamic key generation.
	 * @param int    $i          The index value used to differentiate multiple datasets.
	 * @param int    $count      The number of data points to generate (default: 20).
	 *
	 * @return array Returns an array of associative arrays, each containing a random value.
	 */
	protected function brushDataGenerator( $chart_type = '', $i = 0, $count = 20 ) {
		$result = array();
		for ( $j = 0; $j < $count; $j++ ) {
			$result[] = array(
				GRAPHINA_PREFIX . $chart_type . '_chart_value_3_' . $i => rand( 10, 200 ),
			);
		}
		return $result;
	}

	/**
	 * Function to retrieve color arrays based on type.
	 *
	 * @param string $chart_type The type of colors to retrieve ('color' or 'gradientColor').
	 *
	 * @return array An array of colors based on the type.
	 */
	protected function graphina_colors( string $chart_type = 'color' ): array {
		if ( $chart_type === 'gradientColor' ) {
			return array( '#6C25FB', '#ff7179', '#654ae8', '#f8576f', '#31317a', '#fe6f7e', '#7D02EB', '#E02828', '#D56767', '#26A2D6', '#6C25FB', '#ff7179', '#654ae8', '#f8576f', '#31317a', '#fe6f7e', '#7D02EB', '#E02828', '#D56767', '#26A2D6', '#6C25FB', '#ff7179', '#654ae8', '#f8576f', '#31317a', '#fe6f7e', '#7D02EB', '#E02828', '#D56767', '#26A2D6', '#6C25FB', '#ff7179', '#654ae8', '#f8576f', '#31317a', '#fe6f7e', '#7D02EB', '#E02828', '#D56767', '#26A2D6' );
		}
		return array( '#3499FF', '#e53efc', '#f9a243', '#46adfe', '#2c80ff', '#e23cfd', '#7D02EB', '#8D5B4C', '#F86624', '#2E294E', '#3499FF', '#e53efc', '#f9a243', '#46adfe', '#2c80ff', '#e23cfd', '#7D02EB', '#8D5B4C', '#F86624', '#2E294E', '#3499FF', '#e53efc', '#f9a243', '#46adfe', '#2c80ff', '#e23cfd', '#7D02EB', '#8D5B4C', '#F86624', '#2E294E', '#e23cfd', '#3499FF', '#e53efc', '#f9a243', '#46adfe', '#2c80ff', '#e23cfd', '#7D02EB', '#8D5B4C', '#F86624', '#2E294E' );
	}

	/***********************
	 * @param object   $widget
	 * @param string   $chart_type
	 * @param string[] $ele_array like ['color','stroke','drop shadow']
	 * @param array    $fillOptions lke ['classic', 'gradient', 'pattern']
	 */
	public function graphina_mixed_series_setting( $widget, $chart_type = 'chart_id', $ele_array = array(), $fillOptions = array() ) {
		$colors        = $this->graphina_colors( 'color' );
		$gradientColor = $this->graphina_colors( 'gradientColor' );
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_11',
			array(
				'label' => esc_html__( 'Elements Setting', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_marker_setting_pro_divider',
			array(
				'type' => Controls_Manager::DIVIDER,

			)
		);

		for ( $i = 0; $i < graphina_default_setting( 'max_series_value' ); $i++ ) {
			$condition = array(
				GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
			);

			if ( $i !== 0 ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_hr_series_element_setting_1_' . $i,
					array(
						'type'      => Controls_Manager::DIVIDER,
						'condition' => $condition,
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_hr_series_element_setting_2_' . $i,
					array(
						'type'      => Controls_Manager::DIVIDER,
						'condition' => $condition,
					)
				);
			}

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_series_element_setting_title_' . $i,
				array(
					'label'     => esc_html__( 'Element ' . ( $i + 1 ), 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => $condition,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_type_3_' . $i,
				array(
					'label'     => esc_html__( 'Type', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => $this->graphina_pro_get_random_chart_type( $this->graphina_pro_mixed_chart_typeList(), $i ),
					'options'   => $this->graphina_pro_mixed_chart_typeList(),
					'condition' => $condition,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show_3_' . $i,
				array(
					'label'     => esc_html__( 'Show Data Labels', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => 'yes',
					'condition' => array_merge( array( GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show' => 'yes' ), $condition ),
				)
			);

			$widget->add_control(
				'hr_4_01_' . $i,
				array(
					'type'      => Controls_Manager::DIVIDER,
					'condition' => array_merge( array( GRAPHINA_PREFIX . $chart_type . '_chart_show_multiple_yaxis' => 'yes' ), $condition ),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_setting_title_3_' . $i,
				array(
					'label'     => esc_html__( 'Y-Axis Setting', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => array_merge( array( GRAPHINA_PREFIX . $chart_type . '_chart_show_multiple_yaxis' => 'yes' ), $condition ),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_show_3_' . $i,
				array(
					'label'     => esc_html__( 'Show Axis With Title', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => '',
					'condition' => array_merge( array( GRAPHINA_PREFIX . $chart_type . '_chart_show_multiple_yaxis' => 'yes' ), $condition ),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title_3_' . $i,
				array(
					'label'     => esc_html__( 'Yaxis Title', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_show_3_' . $i => 'yes',
					),
					'dynamic'   => array(
						'active' => true,
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_opposite_3_' . $i,
				array(
					'label'     => esc_html__( 'Position', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => graphina_position_type( 'horizontal_boolean', true ),
					'options'   => graphina_position_type( 'horizontal_boolean' ),
					'condition' => array_merge( array( GRAPHINA_PREFIX . $chart_type . '_chart_show_multiple_yaxis' => 'yes' ), $condition ),
				)
			);

			if ( in_array( 'color', $ele_array ) ) {

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_hr_fill_setting_3_' . $i,
					array(
						'type'      => Controls_Manager::DIVIDER,
						'condition' => $condition,
					)
				);

				$this->graphina_fill_style_setting( $widget, $chart_type, $fillOptions, true, $i, $condition, true );

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_gradient_3_1_' . $i,
					array(
						'label'     => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => ! empty( $colors[ $i ] ) ? $colors[ $i ] : '',
						'condition' => $condition,
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_gradient_3_2_' . $i,
					array(
						'label'     => esc_html__( 'Second Color', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => ! empty( $gradientColor[ $i ] ) ? $gradientColor[ $i ] : '',
						'condition' => array_merge( array( GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type_' . $i => 'gradient' ), $condition ),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_pattern_3_' . $i,
					array(
						'label'     => esc_html__( 'Fill Pattern', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SELECT,
						'default'   => $this->graphina_get_fill_patterns( true ),
						'options'   => $this->graphina_get_fill_patterns(),
						'condition' => array_merge(
							array(
								GRAPHINA_PREFIX . $chart_type . '_chart_type_3_' . $i . '!' => 'line',
								GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type_' . $i => 'pattern',
								GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
							),
							$condition
						),
					)
				);

				$this->graphina_marker_setting( $widget, $chart_type, $i );

				$this->graphina_gradient_setting( $widget, $chart_type, false, true, $i, $condition );
			}

			if ( in_array( 'stroke', $ele_array ) ) {

				$widget->add_control(
					'hr_4_03_' . $i,
					array(
						'type'      => Controls_Manager::DIVIDER,
						'condition' => $condition,
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_stroke_setting_title_3_' . $i,
					array(
						'label'     => esc_html__( 'Stroke Setting', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::HEADING,
						'condition' => $condition,
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_stroke_curve_3_' . $i,
					array(
						'label'     => esc_html__( 'Curve', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SELECT,
						'default'   => graphina_stroke_curve_type( true ),
						'options'   => graphina_stroke_curve_type(),
						'condition' => array_merge( array( GRAPHINA_PREFIX . $chart_type . '_chart_type_3_' . $i => array( 'line', 'area' ) ), $condition ),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_stroke_dash_3_' . $i,
					array(
						'label'     => 'Dash',
						'type'      => Controls_Manager::NUMBER,
						'default'   => 0,
						'min'       => 0,
						'max'       => 100,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_stroke_width_3_' . $i,
					array(
						'label'     => 'Stroke Width',
						'type'      => Controls_Manager::NUMBER,
						'default'   => 5,
						'min'       => 1,
						'max'       => 20,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
			}

			if ( in_array( 'drop-shadow', $ele_array ) ) {
				$widget->add_control(
					'hr_4_04_' . $i,
					array(
						'type'      => Controls_Manager::DIVIDER,
						'condition' => $condition,
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_drop_shadow_setting_title_3_' . $i,
					array(
						'label'     => esc_html__( 'Drop Shadow Setting', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::HEADING,
						'condition' => $condition,
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_drop_shadow_enabled_3_' . $i,
					array(
						'label'     => esc_html__( 'Enabled', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'True', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'False', 'graphina-charts-for-elementor' ),
						'default'   => '',
						'condition' => $condition,
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_drop_shadow_color_3_' . $i,
					array(
						'label'     => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#FFFFFF00',
						'condition' => array_merge( array( GRAPHINA_PREFIX . $chart_type . '_chart_drop_shadow_enabled_3_' . $i => 'yes' ), $condition ),
					)
				);
			}
			if ( in_array( 'tooltip', $ele_array ) ) {
				$condition = array_merge(
					$condition,
					array(
						GRAPHINA_PREFIX . $chart_type . '_chart_tooltip' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared' => 'yes',
					)
				);

				$widget->add_control(
					'hr_4_06_' . $i,
					array(
						'type'      => Controls_Manager::DIVIDER,
						'condition' => $condition,
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_tooltip_setting_title_3_' . $i,
					array(
						'label'     => esc_html__( 'Tooltip Setting', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::HEADING,
						'condition' => $condition,
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_enabled_on_1_' . $i,
					array(
						'label'     => esc_html__( 'Enabled', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
						'default'   => 'yes',
						'condition' => $condition,
					)
				);
			}
		}
		$widget->end_controls_section();
	}


	/**
	 * Setup series settings for a chart element.
	 *
	 * @param Element_Base $widget The Elementor element instance.
	 * @param string       $type Type of chart element (e.g., 'chart_id').
	 * @param array        $ele_array Array of element types to configure (e.g., ['color', 'dash']).
	 * @param bool         $show_fill_style Whether to show fill style settings.
	 * @param array        $fill_options Additional fill style options.
	 * @param bool         $show_fill_opacity Whether to show fill opacity setting.
	 * @param bool         $show_gradient_type Whether to show gradient type setting.
	 * @return void
	 */
	public function graphina_series_setting( $widget, string $chart_type = 'chart_id', array $ele_array = array( 'color' ), bool $show_fill_style = true, array $fill_options = array(), bool $show_fill_opacity = false, bool $show_gradient_type = false ): void {
		$colors         = $this->graphina_colors();
		$gradient_color = $this->graphina_colors( 'gradientColor' );
		$series_name    = esc_html__( 'Element', 'graphina-charts-for-elementor' );

		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_11',
			array(
				'label' => esc_html__( 'Elements Setting', 'graphina-charts-for-elementor' ),
			)
		);

		if ( $show_fill_style ) {
			$this->graphina_fill_style_setting( $widget, $chart_type, $fill_options, $show_fill_opacity );
		}

		if ( $show_fill_style && in_array( 'gradient', $fill_options, true ) ) {
			$this->graphina_gradient_setting( $widget, $chart_type, $show_gradient_type, true );
		}

		if ( $chart_type === 'scatter' ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_scatter_width',
				array(
					'label'   => esc_html__( 'Width', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 10,
					'step'    => 1,
					'min'     => 1,
				)
			);
		}

		$max_series = graphina_default_setting( 'max_series_value' );
		for ( $i = 0; $i < $max_series; $i++ ) {

			if ( $i !== 0 || $show_fill_style ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_hr_series_count_' . $i,
					array(
						'type'      => Controls_Manager::DIVIDER,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
			}

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_series_title_' . $i,
				array(
					'label'     => $series_name . ' ' . ( $i + 1 ),
					'type'      => Controls_Manager::HEADING,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);

			if ( in_array( 'tooltip', $ele_array, true ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_enabled_on_1_' . $i,
					array(
						'label'     => esc_html__( 'Tooltip Enabled', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
						'default'   => 'yes',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_tooltip' => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared' => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
			}

			if ( in_array( 'color', $ele_array, true ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_gradient_1_' . $i,
					array(
						'label'     => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => ! empty( $colors[ $i ] ) ? $colors[ $i ] : '',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_gradient_2_' . $i,
					array(
						'label'     => esc_html__( 'Second Color', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => ! empty( $gradient_color[ $i ] ) ? $gradient_color[ $i ] : '',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type' => 'gradient',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_bg_pattern_' . $i,
					array(
						'label'     => esc_html__( 'Fill Pattern', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SELECT,
						'default'   => graphina_get_fill_patterns( true ),
						'options'   => graphina_get_fill_patterns(),
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type' => 'pattern',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
			}

			if ( in_array( 'dash', $ele_array, true ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_dash_3_' . $i,
					array(
						'label'     => 'Dash',
						'type'      => Controls_Manager::NUMBER,
						'default'   => 0,
						'min'       => 0,
						'max'       => 100,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
			}

			if ( in_array( 'width', $ele_array, true ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_width_3_' . $i,
					array(
						'label'     => 'Stroke Width',
						'type'      => Controls_Manager::NUMBER,
						'default'   => 5,
						'min'       => 1,
						'max'       => 20,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
			}

			$type = array( 'radar', 'line', 'area' );

			if ( in_array( $chart_type, $type, true ) ) {

				$this->graphina_marker_setting( $widget, $chart_type, $i );

			}
		}
		$widget->end_controls_section();
	}

	/**
	 * Function to handle gradient settings for Elementor widgets.
	 *
	 * @param  $widget         The Elementor element instance.
	 * @param string $chart_type             Type of chart being configured.
	 * @param bool  $show_type        Whether to show gradient type control.
	 * @param bool  $used_as_sub_part Whether this function is used as a sub-part.
	 * @param int   $i                Index for multi-instance controls.
	 * @param array $condition        Additional conditions for control visibility.
	 *
	 * @return void
	 */
	public function graphina_gradient_setting( $widget, string $chart_type = 'chart_id', bool $show_type = true, bool $used_as_sub_part = false, int $i = -1, array $condition = array() ): void {
		if ( ! $used_as_sub_part ) {
			$widget->start_controls_section(
				GRAPHINA_PREFIX . $chart_type . '_chart_section_3' . ( $i > -1 ? '_' . $i : '' ),
				array(
					'label'     => esc_html__( 'Gradient Setting', 'graphina-charts-for-elementor' ),
					'condition' => array_merge( array( GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type' . ( $i > -1 ? '_' . $i : '' ) => 'gradient' ), ( $i > -1 ? $condition : array() ) ),
				)
			);
		} else {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_hr_gradient_setting' . ( $i > -1 ? '_' . $i : '' ),
				array(
					'type'      => Controls_Manager::DIVIDER,
					'condition' => array_merge( array( GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type' . ( $i > -1 ? '_' . $i : '' ) => 'gradient' ), ( $i > -1 ? $condition : array() ) ),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_gradient_setting_title' . ( $i > -1 ? '_' . $i : '' ),
				array(
					'label'     => esc_html__( 'Gradient Settings', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => array_merge( array( GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type' . ( $i > -1 ? '_' . $i : '' ) => 'gradient' ), ( $i > -1 ? $condition : array() ) ),
				)
			);
		}

		if ( $show_type ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_gradient_type' . ( $i > -1 ? '_' . $i : '' ),
				array(
					'label'     => esc_html__( 'Type', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'vertical',
					'options'   => array(
						'vertical'   => esc_html__( 'Vertical', 'graphina-charts-for-elementor' ),
						'horizontal' => esc_html__( 'Horizontal', 'graphina-charts-for-elementor' ),
					),
					'condition' => array_merge( array( GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type' . ( $i > -1 ? '_' . $i : '' ) => 'gradient' ), ( $i > -1 ? $condition : array() ) ),
				)
			);
		}

		$from_opacity = ( in_array( $chart_type, array( 'radar', 'area', 'brush' ), true ) ) ? 0.6 : 1.0;
		$to_opacity   = ( in_array( $chart_type, array( 'radar', 'area', 'brush' ), true ) ) ? 0.6 : 1.0;

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_gradient_opacityFrom' . ( $i > -1 ? '_' . $i : '' ),
			array(
				'label'     => esc_html__( 'From Opacity', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'step'      => 0.1,
				'default'   => $from_opacity,
				'min'       => 0,
				'max'       => 1,
				'condition' => array_merge( array( GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type' . ( $i > -1 ? '_' . $i : '' ) => 'gradient' ), ( $i > -1 ? $condition : array() ) ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_gradient_opacityTo' . ( $i > -1 ? '_' . $i : '' ),
			array(
				'label'     => esc_html__( 'To Opacity', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'step'      => 0.1,
				'default'   => $to_opacity,
				'min'       => 0,
				'max'       => 1,
				'condition' => array_merge( array( GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type' . ( $i > -1 ? '_' . $i : '' ) => 'gradient' ), ( $i > -1 ? $condition : array() ) ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_gradient_inversecolor' . ( $i > -1 ? '_' . $i : '' ),
			array(
				'label'     => esc_html__( 'Inverse Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => false,
				'condition' => array_merge( array( GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type' . ( $i > -1 ? '_' . $i : '' ) => 'gradient' ), ( $i > -1 ? $condition : array() ) ),
			)
		);

		if ( ! $used_as_sub_part ) {
			$widget->end_controls_section();
		}
	}

	/**
	 * Function to handle chart marker section settings for Elementor widgets.
	 *
	 * @param  $widget The Elementor element instance.
	 * @param string                                $chart_type     Type of chart being configured.
	 * @param int                                   $i        Element index.
	 *
	 * @return void
	 */
	protected function graphina_marker_setting( $widget, string $chart_type = 'chart_id', int $i = 0 ): void {

		if ( $chart_type === 'mixed' ) {
			$condition = array(
				GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count'  => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
				GRAPHINA_PREFIX . $chart_type . '_chart_type_3_' . $i . '!' => 'bar',
			);
		} else {
			$condition = array(
				GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
			);
		}

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_marker_setting_title_' . $i,
			array(
				'label'     => esc_html__( 'Marker Settings', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => $condition,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_marker_size_' . $i,
			array(
				'label'       => esc_html__( 'Size', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => in_array( $chart_type, array( 'radar', 'mixed', 'brush' ), true ) ? 3 : 0,
				'min'         => 0,
				'condition'   => $condition,
				'description' => $chart_type === 'brush' ? esc_html__( 'Note : Marker are only show in Chart 1 ', 'graphina-charts-for-elementor' ) : '',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_marker_stroke_color_' . $i,
			array(
				'label'     => esc_html__( 'Stroke Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'condition' => $condition,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_marker_stroke_width_' . $i,
			array(
				'label'     => esc_html__( 'Stroke Width', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => in_array( $chart_type, array( 'mixed', 'brush' ), true ) ? 1 : 5,
				'min'       => 0,
				'condition' => $condition,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_chart_marker_stroke_shape_' . $i,
			array(
				'label'       => esc_html__( 'Shape', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'circle',
				'options'     => array(
					'circle' => esc_html__( 'Circle', 'graphina-charts-for-elementor' ),
					'square' => esc_html__( 'Square', 'graphina-charts-for-elementor' ),
				),
				'condition'   => $condition,
				'description' => esc_html__( 'Note: Hover will Not work in Square', 'graphina-charts-for-elementor' ),

			)
		);
	}

	/**
	 * Get fill pattern options for Graphina.
	 *
	 * This function returns an array of fill pattern options.
	 * If $first is true, it returns only the first key of the patterns array.
	 *
	 * @param bool $first Whether to return only the first key of the patterns array. Defaults to false.
	 *
	 * @return array|string The array of fill pattern options or the first key of the patterns array.
	 */
	protected function graphina_get_fill_patterns( bool $first = false ): mixed {
		$patterns = array(
			'verticalLines'   => esc_html__( 'VerticalLines', 'graphina-charts-for-elementor' ),
			'squares'         => esc_html__( 'Squares', 'graphina-charts-for-elementor' ),
			'horizontalLines' => esc_html__( 'HorizontalLines', 'graphina-charts-for-elementor' ),
			'circles'         => esc_html__( 'Circles', 'graphina-charts-for-elementor' ),
			'slantedLines'    => esc_html__( 'SlantedLines', 'graphina-charts-for-elementor' ),
		);
		// Return the first key if $first is true, otherwise return the patterns array.
		return $first ? 'verticalLines' : $patterns;
	}


	/**
	 * Retrieves a random chart type from the provided dataset.
	 *
	 * This function selects a chart type key from the given data array based on
	 * the provided index. It ensures cyclic access to the available keys, making
	 * it useful for generating diverse chart types in a predictable yet randomized
	 * manner.
	 *
	 * Key Features:
	 * - Uses modulo operation to avoid out-of-bounds errors.
	 * - Ensures uniform distribution of chart types when iterating over datasets.
	 * - Designed to support Graphina Pro’s dynamic chart rendering.
	 *
	 * @param array $data The dataset containing available chart types as keys.
	 * @param int   $i    The index used to select a chart type.
	 *
	 * @return string Returns a chart type key from the dataset.
	 */
	protected function graphina_pro_get_random_chart_type( $data, $i ) {
		$index = $i % count( $data );
		$keys  = array_keys( $data );
		return $keys[ $index ];
	}


	/**
	 * Retrieves a predefined list of supported mixed chart types.
	 *
	 * This function returns an associative array of available chart types used in
	 * Graphina Pro’s mixed charts. It provides an option to reverse the order of
	 * chart types and fetch only the first chart type if required.
	 *
	 * Key Features:
	 * - Supports "Column", "Line", and "Area" chart types.
	 * - Provides an option to reverse the chart order.
	 * - Allows retrieving either the full list or just the first chart type.
	 * - Ensures compatibility with Graphina’s chart rendering logic.
	 *
	 * @param bool $first  Whether to return only the first chart type key.
	 * @param bool $revese Whether to reverse the chart type order.
	 *
	 * @return array|string Returns an array of chart types or a single chart type key.
	 */
	protected function graphina_pro_mixed_chart_typeList( $first = false, $revese = false ) {
		$charts = array(
			'bar'  => esc_html__( 'Column', 'graphina-charts-for-elementor' ),
			'line' => esc_html__( 'Line', 'graphina-charts-for-elementor' ),
			'area' => esc_html__( 'Area', 'graphina-charts-for-elementor' ),
		);
		if ( $revese ) {
			$charts = array_reverse( $charts );
		}
		$keys = array_keys( $charts );
		return $first ? ( count( $keys ) > 0 ? $keys[0] : '' ) : $charts;
	}


	/**
	 * Function to add fill style settings for Elementor widgets.
	 *
	 * @param Element_Base $widget The Elementor element instance.
	 * @param string       $chart_type                Type of chart being configured.
	 * @param array        $fill_styles         Array of fill styles available.
	 * @param bool         $show_opacity        Whether to show opacity control.
	 * @param int          $i                   Index for multi-instance controls.
	 * @param array        $condition           Additional conditions for control visibility.
	 * @param bool         $show_note_fill_style Whether to show a note about pattern style.
	 *
	 * @return void
	 */
	protected function graphina_fill_style_setting( $widget, string $chart_type = 'chart_id', array $fill_styles = array( 'classic', 'gradient', 'pattern' ), bool $show_opacity = false, int $i = -1, array $condition = array(), bool $show_note_fill_style = false ): void {
		if ( $chart_type === 'heatmap' ) {
    		return;
		}
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_fill_setting_title' . ( $i > -1 ? '_' . $i : '' ),
			array(
				'label'     => esc_html__( 'Fill Settings', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array_merge( array(), ( $i > -1 ? $condition : array() ) ),
			)
		);

		$description = esc_html__( 'Pattern will not eligible for the line chart. So if you select it, it will consider as Classic', 'graphina-charts-for-elementor' );

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type' . ( $i > -1 ? '_' . $i : '' ),
			array(
				'label'       => esc_html__( 'Style', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => $this->graphina_fill_style_type( $fill_styles, true ),
				'options'     => $this->graphina_fill_style_type( $fill_styles ),
				'description' => $show_note_fill_style ? $description : '',
				'condition'   => array_merge( array(), ( $i > -1 ? $condition : array() ) ),
			)
		);

		if ( $show_opacity ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_fill_opacity' . ( $i > -1 ? '_' . $i : '' ),
				array(
					'label'     => esc_html__( 'Opacity', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => in_array( $chart_type, array( 'column', 'timeline', 'scatter' ), true ) ? 1 : 0.4,
					'min'       => 0.00,
					'max'       => 1,
					'step'      => 0.05,
					'condition' => array_merge( array( GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type' . ( $i > -1 ? '_' . $i : '' ) => 'classic' ), ( $i > -1 ? $condition : array() ) ),
				)
			);
		}
	}


	/**
	 * Get fill style type options for Graphina.
	 *
	 * This function returns an array of fill style type options based on the provided types.
	 * If $first is true, it returns only the first key of the options array.
	 *
	 * @param array $chart_types The types of fill styles to include in the options.
	 * @param bool  $first Whether to return only the first key of the options array. Defaults to false.
	 *
	 * @return array|int|string|null The array of fill style type options or the first key of the options array.
	 */
	protected function graphina_fill_style_type( array $chart_types, bool $first = false ): mixed {

		$options = array();

		if ( in_array( 'classic', $chart_types, true ) ) {
			$options['classic'] = array(
				'title' => esc_html__( 'Classic', 'graphina-charts-for-elementor' ),
				'icon'  => 'eicon-paint-brush',
			);
		}
		if ( in_array( 'gradient', $chart_types, true ) ) {
			$options['gradient'] = array(
				'title' => esc_html__( 'Gradient', 'graphina-charts-for-elementor' ),
				'icon'  => 'eicon-barcode',
			);
		}

		if ( in_array( 'pattern', $chart_types, true ) ) {
				$options['pattern'] = array(
					'title' => esc_html__( 'Pattern', 'graphina-charts-for-elementor' ),
					'icon'  => 'eicon-menu-bar',
				);
		}

		// Return the first key if $first is true, otherwise return the options array.
		return $first ? array_key_first( $options ) : $options;
	}


	/**
	 * Function to generate timeline chart data.
	 *
	 * @param string $chart_type Controller type.
	 * @param int    $i index number.
	 * @param int    $count max generate limit.
	 * @return array
	 */
	protected function timeline_data_generator( string $chart_type = '', int $i = 0, int $count = 20 ): array {
		$result = array();
		for ( $j = 0; $j < $count; $j++ ) {
			$start    = graphina_get_random_date(
                date('Y-m-d H:i'), //@phpcs:ignore
				'Y-m-d h:i',
				array(
					'day'    => wp_rand( 0, 5 ),
					'hour'   => wp_rand( 0, 6 ),
					'minute' => wp_rand( 0, 50 ),
				),
				array(
					'day'    => wp_rand( 0, 5 ),
					'hour'   => wp_rand( 0, 6 ),
					'minute' => wp_rand( 0, 50 ),
				)
			);
			$end      = graphina_get_random_date(
                date('Y-m-d H:i', strtotime($start)), //@phpcs:ignore
				'Y-m-d h:i',
				array(
					'day'    => wp_rand( 0, 5 ),
					'hour'   => wp_rand( 0, 6 ),
					'minute' => wp_rand( 0, 50 ),
				)
			);
			$result[] = array(
				GRAPHINA_PREFIX . $chart_type . '_chart_from_date_' . $i => $start,
				GRAPHINA_PREFIX . $chart_type . '_chart_to_date_' . $i   => $end,
			);
		}
		return $result;
	}

	/**
	 * Generates random candlestick chart data.
	 *
	 * This function creates an array of simulated candlestick chart data points,
	 * including Open, High, Low, Close (OHLC) values, and associated timestamps.
	 * It ensures realistic variation within a defined range to mimic financial
	 * market data trends.
	 *
	 * Key Features:
	 * - Generates `len` number of data points with random values.
	 * - Uses `wp_rand()` for realistic randomization of price movements.
	 * - Supports dynamic configuration with `min`, `max`, and `range` parameters.
	 * - Assigns each data point a random timestamp within a given timeframe.
	 * - Compatible with Graphina Pro’s candlestick chart rendering.
	 *
	 * @param string $chart_type Chart type identifier for unique data keys.
	 * @param int    $i          Unique index for differentiating datasets.
	 * @param int    $min        Minimum value for the candlestick range.
	 * @param int    $max        Maximum value for the candlestick range.
	 * @param int    $range      Allowed price fluctuation range.
	 * @param int    $len        Number of data points to generate.
	 *
	 * @return array An array of candlestick data formatted for Graphina Pro charts.
	 */
	protected function candle_data_generator( string $chart_type = '', int $i = 0, int $min = 0, int $max = 100, int $range = 5, int $len = 25 ): array {
		$result = array();
		for ( $j = 0; $j < $len; $j++ ) {
			$default  = wp_rand( $min, $max );
			$result[] =
				array(
					GRAPHINA_PREFIX . $chart_type . '_chart_value_open_3_' . $i => round( ( wp_rand( $default + $range, $default - $range ) * 1.00002 ), 2 ),
					GRAPHINA_PREFIX . $chart_type . '_chart_value_high_3_' . $i => round( ( wp_rand( $default + $range, $default - $range ) * 1.00002 ), 2 ),
					GRAPHINA_PREFIX . $chart_type . '_chart_value_low_3_' . $i => round( ( wp_rand( $default + $range, $default - $range ) * 1.00002 ), 2 ),
					GRAPHINA_PREFIX . $chart_type . '_chart_value_close_3_' . $i => round( ( wp_rand( $default + $range, $default - $range ) * 1.00002 ), 2 ),
					GRAPHINA_PREFIX . $chart_type . '_chart_value_date_3_' . $i => graphina_get_random_date(
						date( 'Y-m-d H:i' ),
                        @ //phpcs:ignore
						'Y-m-d H:i',
						array(
							'hour'   => wp_rand( 0, 6 ),
							'minute' => wp_rand( 0, 50 ),
						)
					),
				);
		}
		return $result;
	}

	/**
	 * Generates random data for a bubble chart.
	 *
	 * This function creates an array of data points for a bubble chart, where
	 * each point consists of X, Y, and Z values representing position and size.
	 * The values are randomly generated within specified ranges, making the
	 * function flexible for various data visualization needs.
	 *
	 * Key Features:
	 * - Supports dynamic data generation with customizable count and value ranges.
	 * - Generates X (horizontal position), Y (vertical position), and Z (bubble size) values.
	 * - Uses `wp_rand()` for realistic randomization within user-defined limits.
	 * - Ensures compatibility with Graphina Pro’s bubble chart rendering.
	 *
	 * @param string $chart_type Chart type identifier for unique data keys.
	 * @param int    $i          Unique index for differentiating datasets.
	 * @param int    $count      Number of data points to generate.
	 * @param array  $x          Associative array with 'min' and 'max' for X-axis values.
	 * @param array  $y          Associative array with 'min' and 'max' for Y-axis values.
	 * @param array  $z          Associative array with 'min' and 'max' for Z-axis (bubble size).
	 *
	 * @return array An array of bubble chart data formatted for Graphina Pro charts.
	 */
	protected function bubble_data_generator(string $chart_type = '', int $i = 0, int $count = 20, array $x = array(
		'min' => 10,
		'max' => 1000,
	), array $y = array(
		'min' => 10,
		'max' => 200,
	), array $z = array(
		'min' => 10,
		'max' => 200,
	)): array {
		$result = array();
		for ( $j = 0; $j < $count; $j++ ) {
			$result[] = array(
				GRAPHINA_PREFIX . $chart_type . '_chart_x_value_3_' . $i => wp_rand( $x['min'], $x['max'] ),
				GRAPHINA_PREFIX . $chart_type . '_chart_y_value_3_' . $i => wp_rand( $y['min'], $y['max'] ),
				GRAPHINA_PREFIX . $chart_type . '_chart_z_value_3_' . $i => wp_rand( $z['min'], $z['max'] ),
			);
		}
		return $result;
	}

	/**
	 * Register Chart Markers Controls
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_markers_settings( $widget, $chart_type, $i ) {
	}


	/**
	 * Registers Gantt Chart settings for Graphina widget.
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_gantt_chart_setting( $widget, $chart_type ) {
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_2_chart_setting_element',
			array(
				'label' => esc_html__( 'Chart Setting', 'graphina-charts-for-elementor' ),
			)
		);

		// Chart Background
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_chart_heading',
			array(
				'label'     => esc_html__( 'Chart Settings', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_2_chart_background',
			array(
				'label' => esc_html__( 'Background Color', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::COLOR,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_label_heading',
			array(
				'label'     => esc_html__( 'Lebel Settings', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_2_chart_label_size',
			array(
				'label'   => esc_html__( 'Label Font Size (PX)', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'default' => '12',
			)
		);

		// Arrow Settings
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_arrow_setting_info',
			array(
				'label'     => esc_html__( 'Arrow Settings', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_2_chart_arrow_style',
			array(
				'label'   => esc_html__( 'Arrow Style', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'40'  => esc_html__( 'Arrow', 'graphina-charts-for-elementor' ),
					'100' => esc_html__( 'Line', 'graphina-charts-for-elementor' ),
				),
				'default' => '40',
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_2_chart_arrow_width',
			array(
				'label'   => esc_html__( 'Arrow Width (PX)', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'default' => '1',
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_2_chart_arrow_color',
			array(
				'label'   => esc_html__( 'Arrow Color', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#000000',
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_2_chart_arrow_radius',
			array(
				'label'   => esc_html__( 'Arrow Radius', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '0',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_additional_info',
			array(
				'label'     => esc_html__( 'Additional Settings', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_grid_line_heading',
			array(
				'label' => esc_html__( 'Grid Lines', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_3_chart_grid_line',
			array(
				'label'     => esc_html__( 'Grid Lines Show', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_on'  => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => '',
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_3_chart_grid_line_stoke',
			array(
				'label'     => esc_html__( 'Grid Stoke Size (PX)', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'default'   => '0',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_section_3_chart_grid_line' => 'yes',
				),
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_section_3_chart_grid_line_color',
			array(
				'label'     => esc_html__( 'Grid Stoke Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_section_3_chart_grid_line' => 'yes',
				),
			)
		);

		$widget->end_controls_section();
	}

	/**
	 * Registers Org Chart Settings for Graphina widget.
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_org_chart_setting( $widget, $chart_type ) {
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_2',
			array(
				'label' => esc_html__( 'Chart Setting', 'graphina-charts-for-elementor' ),
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_node_collapse',
			array(
				'label'     => esc_html__( 'Collapse Node', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_googlr_chart_title_setting',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_googlr_chart_node_setting',
			array(
				'label' => esc_html__( 'Node Settings', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_node_size',
			array(
				'label'   => esc_html__( 'Node Size', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'large',
				'options' => array(
					'small'  => esc_html__( 'small', 'graphina-charts-for-elementor' ),
					'medium' => esc_html__( 'medium', 'graphina-charts-for-elementor' ),
					'large'  => esc_html__( 'large', 'graphina-charts-for-elementor' ),

				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_node_font_size',
			array(
				'label'     => esc_html__( 'Font Size', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 12,
				'selectors' => array( '{{WRAPPER}} .myNodeClass' => 'font-size:{{VALUE}}px' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_node_font_color',
			array(
				'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'black',
				'selectors' => array(
					'{{WRAPPER}} .myNodeClass' => 'color: {{VALUE}}',
				),
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_node_text_align',
			array(
				'label'     => esc_html__( 'Alignment', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-text-align-justify',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .myNodeClass' => 'text-align: {{VALUE}}',
				),

			)
		);

		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => GRAPHINA_PREFIX . $chart_type . '_google_chart_node_shadow',
				'label'    => esc_html__( 'Node Shadow', 'graphina-charts-for-elementor' ),
				'selector' => '{{WRAPPER}} .myNodeClass',
			)
		);
		$widget->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => GRAPHINA_PREFIX . $chart_type . '_google_chart_node_background_color',
				'label'    => esc_html__( 'Background', 'graphina-charts-for-elementor' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .myNodeClass',
			)
		);

		$widget->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => GRAPHINA_PREFIX . $chart_type . '_google_chart_node_border',
				'label'          => esc_html__( 'Border', 'graphina-charts-for-elementor' ),
				'fields_options' => array(
					'border' => array(
						'default' => 'solid',
					),
					'width'  => array(
						'default' => array(
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						),
					),
					'color'  => array(
						'default' => '#000000',
					),
				),
				'selector'       => '{{WRAPPER}} .myNodeClass',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_node_setting',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_sel_node_setting',
			array(
				'label' => esc_html__( 'Selected Node Settings', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_node_font_size_sel',
			array(
				'label'     => esc_html__( 'Font Size', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 12,
				'selectors' => array( '{{WRAPPER}} .myNodeClassSel' => 'font-size:{{VALUE}}px' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_sel_node_font_color',
			array(
				'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'blue',
				'selectors' => array(
					'{{WRAPPER}} .myNodeClassSel' => 'color: {{VALUE}}',
				),
			)
		);

		$widget->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => GRAPHINA_PREFIX . $chart_type . '_google_chart_sel_node_background_color',
				'label'    => esc_html__( 'Background', 'graphina-charts-for-elementor' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .myNodeClassSel ',
			)
		);
		$widget->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => GRAPHINA_PREFIX . $chart_type . '_google_chart_sel_node_border',
				'label'    => esc_html__( 'Border', 'graphina-charts-for-elementor' ),
				'selector' => '{{WRAPPER}} .myNodeClassSel',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_sel_node_setting_divider',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_node_conn_Setting',
			array(
				'label' => esc_html__( 'Connection', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_node_conn_height',
			array(
				'label'     => esc_html__( 'Height', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'selectors' => array(
					'{{WRAPPER}} .google-visualization-orgchart-connrow-large' => 'height: {{VALUE}}px',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_node_conn_width',
			array(
				'label'     => esc_html__( 'Width', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'selectors' => array(
					'{{WRAPPER}} .google-visualization-orgchart-linebottom,{{WRAPPER}} .google-visualization-orgchart-lineright,{{WRAPPER}} .google-visualization-orgchart-lineleft' => ' border-bottom-width: {{VALUE}}px;border-right-width:{{VALUE}}px;border-left-width:{{VALUE}}px',
				),
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_node_conn_style',
			array(
				'label'     => esc_html__( 'Style', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'solid'  => esc_html__( 'solid', 'graphina-charts-for-elementor' ),
					'dotted' => esc_html__( 'dotted', 'graphina-charts-for-elementor' ),
					'dashed' => esc_html__( 'dashed', 'graphina-charts-for-elementor' ),
					'groove' => esc_html__( 'groove', 'graphina-charts-for-elementor' ),
					'none'   => esc_html__( 'none', 'graphina-charts-for-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .google-visualization-orgchart-linebottom' => ' border-bottom-style: {{VALUE}}',
					'{{WRAPPER}} .google-visualization-orgchart-lineleft' => ' border-left-style: {{VALUE}}',
					'{{WRAPPER}} .google-visualization-orgchart-lineright' => ' border-right-style: {{VALUE}}',
				),
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_node_conn_color',
			array(
				'label'     => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'black',
				'selectors' => array(
					'{{WRAPPER}} .google-visualization-orgchart-linebottom' => ' border-bottom-color: {{VALUE}}',
					'{{WRAPPER}} .google-visualization-orgchart-lineleft' => ' border-left-color: {{VALUE}}',
					'{{WRAPPER}} .google-visualization-orgchart-lineright' => ' border-right-color: {{VALUE}}',
				),

			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_node_conn_Setting_divider',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);
		$widget->end_controls_section();
	}

	/**
	 * Registers Element Lebel Settings for Graphina widget.
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	protected function graphina_element_label( $widget, string $chart_type = 'chart_id' ): void {

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_hr_label_setting',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_label_setting_title',
			array(
				'label' => esc_html__( 'Label Settings', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		if ( in_array( $chart_type, array( 'pie_google', 'donut_google' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_pieSliceText_show',
				array(
					'label'   => esc_html__( 'Label Show', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::SWITCHER,
					'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'false'   => esc_html__( 'no', 'graphina-charts-for-elementor' ),
					'default' => 'no',
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_pieSliceText',
				array(
					'label'     => esc_html__( 'Label Text', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'label',
					'options'   => array(

						'label'                => esc_html__( 'Label', 'graphina-charts-for-elementor' ),
						'value'                => esc_html__( 'Value', 'graphina-charts-for-elementor' ),
						'percentage'           => esc_html__( 'Percentage', 'graphina-charts-for-elementor' ),
						'value-and-percentage' => esc_html__( 'Value And Percentage', 'graphina-charts-for-elementor' ),
					),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_pieSliceText_show' => 'yes',

					),

				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_label_prefix_postfix',
				array(
					'label'     => esc_html__( 'Label Prefix/Postfix', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'true'      => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'false'     => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'   => '',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_pieSliceText_show' => 'yes',

					),
					'description' => esc_html__( 'Prefix/Postfix will not be applied when label type is set to Percentage.', 'graphina-charts-for-elementor' ),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_label_prefix',
				array(
					'label'     => esc_html__( 'Prefix', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_pieSliceText_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_label_prefix_postfix' => 'yes',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_label_postfix',
				array(
					'label'     => esc_html__( 'Postfix', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_pieSliceText_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_label_prefix_postfix' => 'yes',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_pieSliceText_color',
				array(
					'label'     => esc_html__( 'Label Text Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => 'black',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_pieSliceText_show' => 'yes',
					),

				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_pieSliceText_fontsize',
				array(
					'label'     => esc_html__( 'Label Text Fontsize', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 5,
					'max'       => 20,
					'default'   => '12',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_pieSliceText_show' => 'yes',
					),

				)
			);
		}
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_label_reversecategory',
			array(
				'label'   => esc_html__( 'Reverse Categories', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'false'   => esc_html__( 'no', 'graphina-charts-for-elementor' ),
				'default' => 'false',
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_setting',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);
		if ( $chart_type === 'pie_google' ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_isthreed',
				array(
					'label'   => esc_html__( '3D ', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::SWITCHER,
					'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'false'   => esc_html__( 'no', 'graphina-charts-for-elementor' ),
					'default' => 'false',
				)
			);
		}
		if ( $chart_type === 'donut_google' || $chart_type === 'pie_google' ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_pieslice_bordercolor',
				array(
					'label'   => esc_html__( 'Pieslice Border', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::COLOR,
					'default' => '#ffffff',
				)
			);
		}
		if ( $chart_type === 'donut_google' ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_piehole',
				array(
					'label'   => esc_html__( 'pieHole', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'min'     => 0,
					'max'     => 1,
					'step'    => 0.01,
					'default' => 0.65,
				)
			);
		}
	}

	/**
	 * Registers Geo Chart Settings for Graphina widget.
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_geo_chart_setting( $widget, $chart_type ) {
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_2',
			array(
				'label' => esc_html__( 'Chart Setting', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_settings_heading',
			array(
				'label' => esc_html__( 'Chart Configuration', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_height',
			array(
				'label'   => esc_html__( 'Height', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'default' => 360,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_region_show',
			array(
				'label'       => esc_html__( 'Show Region', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'description' => __( 'Note: Enable it to highlight the region of the particular country, Click <strong><a href="https://developers.google.com/chart/interactive/docs/gallery/geochart#regions-mode-format" target="_blank">here</a></strong> for more information', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_label_text',
			array(
				'label'   => esc_html__( 'label', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Latitude', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_region',
			array(
				'label'     => esc_html__( 'Region', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_google_chart_region_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_geo_background',
			array(
				'label'   => esc_html__( 'Background', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#81d4fa',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_background_stroke_color',
			array(
				'label' => esc_html__( 'Stroke Color', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::COLOR,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_background_stroke_width',
			array(
				'label'   => esc_html__( 'Stroke Width', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'default' => 0,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_geo_default_color',
			array(
				'label' => esc_html__( 'Geo Default Color', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::COLOR,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_geo_data_less_color',
			array(
				'label'   => esc_html__( 'Geo No Data Region', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#fbffee',
			)
		);

		if ( in_array( $chart_type, array( 'polar', 'radar', 'pie', 'bubble', 'donut', 'radial' ) ) ) {
			$this->graphina_tooltip( $widget, $chart_type, true, false );
		} else {
			$this->graphina_tooltip( $widget, $chart_type );
		}

		$widget->end_controls_section();
	}

	/**
     * Registers Line Chart Settings for Graphina widget.
     *
     * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
     * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_counter_common_settings( $widget, $chart_type ) {

		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_2',
			array(
				'label' => ! in_array( $chart_type, graphina_get_chart_type( 'table' ) ) ? esc_html__( 'Chart Setting', 'graphina-charts-for-elementor' ) : esc_html__( 'Table Setting', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_from_count',
			array(
				'label'       => esc_html__( 'Start From', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => esc_html__( '0', 'graphina-charts-for-elementor' ),
				'default'     => 0,
				'min'         => 0,
				'conditions'  => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'terms' => array(
								array(
									'name'     => GRAPHINA_PREFIX . $chart_type . '_element_show_chart',
									'operator' => '===',
									'value'    => 'yes',
								),
								array(
									'name'     => GRAPHINA_PREFIX . $chart_type . '_element_use_chart_data',
									'operator' => '===',
									'value'    => 'yes',
								),
							),
						),
						array(
							'terms' => array(
								array(
									'name'     => GRAPHINA_PREFIX . $chart_type . '_element_data_option',
									'operator' => '===',
									'value'    => 'manual',
								),
							),
						),
					),
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_to_count',
			array(
				'label'       => esc_html__( 'End At', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => esc_html__( '1000', 'graphina-charts-for-elementor' ),
				'default'     => 100,
				'min'         => 0,
				'conditions'  => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'terms' => array(
								array(
									'name'     => GRAPHINA_PREFIX . $chart_type . '_element_show_chart',
									'operator' => '===',
									'value'    => 'yes',
								),
								array(
									'name'     => GRAPHINA_PREFIX . $chart_type . '_element_use_chart_data',
									'operator' => '===',
									'value'    => 'yes',
								),
							),
						),
						array(
							'terms' => array(
								array(
									'name'     => GRAPHINA_PREFIX . $chart_type . '_element_data_option',
									'operator' => '===',
									'value'    => 'manual',
								),
							),
						),
					),
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_counter_operation',
			array(
				'label'       => esc_html__( 'Operation', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'PLease select which operation needs to be performed on the selected column. If selected none, last value from selected column will be considered', 'graphina-charts-for-elementor' ),
				'default'     => $this->graphina_element_data_enter_options( 'graphina_counter_operations', true ),
				'options'     => $this->graphina_element_data_enter_options( 'graphina_counter_operations' ),
				'conditions'  => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'terms' => array(
								array(
									'name'     => GRAPHINA_PREFIX . $chart_type . '_element_show_chart',
									'operator' => '===',
									'value'    => 'yes',
								),
								array(
									'name'     => GRAPHINA_PREFIX . $chart_type . '_element_use_chart_data',
									'operator' => '===',
									'value'    => 'yes',
								),
							),
						),
						array(
							'terms' => array(
								array(
									'name'     => GRAPHINA_PREFIX . $chart_type . '_element_data_option',
									'operator' => '!==',
									'value'    => 'manual',
								),
							),
						),
					),
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_api_object_no',
			array(
				'label'       => esc_html__( 'Object Number', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => esc_html__( '1', 'graphina-charts-for-elementor' ),
				'default'     => 1,
				'min'         => 1,
				'conditions'  => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'terms' => array(
								array(
									'name'     => GRAPHINA_PREFIX . $chart_type . '_element_data_option',
									'operator' => '===',
									'value'    => 'dynamic',
								),
								array(
									'name'     => GRAPHINA_PREFIX . $chart_type . '_element_dynamic_data_option',
									'operator' => '===',
									'value'    => 'api',
								),
							),
						),
						array(
							'terms' => array(
								array(
									'name'     => GRAPHINA_PREFIX . $chart_type . '_element_data_option',
									'operator' => '===',
									'value'    => 'firebase',
								),
							),
						),
					),
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_counter_speed',
			array(
				'label'       => esc_html__( 'Speed', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'placeholder' => esc_html__( '1000', 'graphina-charts-for-elementor' ),
				'default'     => 1000,
				'min'         => 100,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_counter_floating_decimal_point',
			array(
				'label'   => esc_html__( 'Decimal point', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'min'     => 0,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_counter_prefix',
			array(
				'label'       => esc_html__( 'Prefix', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'prefix', 'graphina-charts-for-elementor' ),
				'default'     => '',
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_counter_postfix',
			array(
				'label'       => esc_html__( 'Postfix', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'postfix', 'graphina-charts-for-elementor' ),
				'default'     => '',
				'condition'   => array( GRAPHINA_PREFIX . $chart_type . '_element_counter_operation!' => 'percentage' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_counter_postfix_percentage',
			array(
				'label'       => esc_html__( 'Counter Postfix', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'postfix', 'graphina-charts-for-elementor' ),
				'default'     => '%',
				'condition'   => array( GRAPHINA_PREFIX . $chart_type . '_element_counter_operation' => 'percentage' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_counter_separator',
			array(
				'label'       => esc_html__( 'Number Separator', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'separator', 'graphina-charts-for-elementor' ),
				'default'     => '',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_counter_color_condition_based',
			array(
				'label' => esc_html__( 'Condition Based Color', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::SWITCHER,

			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_counter_heading_color_condition_based',
			array(
				'label'     => esc_html__( 'Heading Condition Based Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_counter_color_condition_based' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_counter_subheading_color_condition_based',
			array(
				'label'     => esc_html__( 'Subheading Condition Based Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_counter_color_condition_based' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_counter_min_value',
			array(
				'label'     => esc_html__( 'Min Value', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_counter_color_condition_based' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_counter_min_value_color',
			array(
				'label'     => esc_html__( 'Min Value Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_counter_color_condition_based' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_counter_max_value',
			array(
				'label'     => esc_html__( 'Max Value', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1000,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_counter_color_condition_based' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_counter_max_value_color',
			array(
				'label'     => esc_html__( 'Max Value Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_counter_color_condition_based' => 'yes',
				),
			)
		);
		$widget->end_controls_section();
	}


	/**
	 * Summary of heatmap_common_options
	 * @param mixed $widget
	 * @param mixed $chart_type
	 * @return void
	 */
	protected function heatmap_common_options($widget,$chart_type)
	{
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_number_formatter',
			array(
				'label'     => esc_html__( 'Number Formatter', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);
		
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_prefix_postfix',
			array(
				'label'     => esc_html__( 'Tooltip Prefix/Postfix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'true'      => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'false'     => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => '',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_number_formatter' => 'yes',
				),
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_prefix_val',
			array(
				'label'     => esc_html__( 'Prefix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_number_formatter' => 'yes',
					GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_prefix_postfix' => 'yes',
				),
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_postfix_val',
			array(
				'label'     => esc_html__( 'Postfix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_number_formatter' => 'yes',
					GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_prefix_postfix' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_hr_plot_setting',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_plot_setting_title',
			array(
				'label' => esc_html__( 'Plot Settings', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_radius',
			array(
				'label'   => esc_html__( 'Matrix Radius', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 0,
				'max'     => 100,
				'step'    => 5,
			)
		);
	}

	/**
	 * Register Chart Common Controls
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_common_chart_setting( $widget, string $chart_type = 'chart_id', bool $show_data_label = false, bool $label_add_fixed = true, bool $label_position = false, bool $show_label_background = true, bool $show_label_color = true ): void {

		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_2',
			array(
				'label' => ! in_array( $chart_type, graphina_get_chart_type( 'table' ) ) ? esc_html__( 'Chart Setting', 'graphina-charts-for-elementor' ) : esc_html__( 'Table Setting', 'graphina-charts-for-elementor' ),
			)
		);

		if ( 'brush' === $chart_type ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_type_1',
				array(
					'label'   => esc_html__( 'Chart-1 Type', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'area',
					'options' => array(
						'area' => 'area',
						'line' => 'line',
						'bar'  => 'Column',
					),
				)
			);

			if ( 'line' === $chart_type ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_line_curve',
					array(
						'label'   => esc_html__( 'Line Shape', 'graphina-charts-for-elementor' ),
						'type'    => Controls_Manager::SELECT,
						'default' => graphina_stroke_curve_type( true ),
						'options' => graphina_stroke_curve_type(),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_line_x_label_color',
					array(
						'label'   => esc_html__( 'X-axis Labels Color', 'graphina-charts-for-elementor' ),
						'type'    => Controls_Manager::COLOR,
						'default' => '#000000',
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_line_y_label_color',
					array(
						'label'   => esc_html__( 'Y-axis Labels Color', 'graphina-charts-for-elementor' ),
						'type'    => Controls_Manager::COLOR,
						'default' => '#000000',
					)
				);
			} else {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_area_curve_1',
					array(
						'label'     => esc_html__( 'Area Shape', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SELECT,
						'default'   => graphina_stroke_curve_type( true ),
						'options'   => graphina_stroke_curve_type(),
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_type_1' => 'area',
						),
					)
				);
			}

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_line_curve_1',
				array(
					'label'     => esc_html__( 'Line Shape', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => graphina_stroke_curve_type( true ),
					'options'   => graphina_stroke_curve_type(),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_type_1' => 'line',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_is_chart_stroke_width_chart_1',
				array(
					'label'     => esc_html__( 'Column Width', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 50,
					'min'       => 1,
					'max'       => 100,
					'step'      => 10,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_type_1' => 'bar',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_type_2',
				array(
					'label'   => esc_html__( 'Chart-2 Type', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'bar',
					'options' => array(
						'area' => 'area',
						'line' => 'line',
						'bar'  => 'Column',
					),

				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_area_curve_2',
				array(
					'label'     => esc_html__( 'Area Shape', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => graphina_stroke_curve_type( true ),
					'options'   => graphina_stroke_curve_type(),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_type_2' => 'area',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_line_curve_2',
				array(
					'label'     => esc_html__( 'Line Shape', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => graphina_stroke_curve_type( true ),
					'options'   => graphina_stroke_curve_type(),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_type_2' => 'line',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_is_chart_stroke_width_chart_2',
				array(
					'label'     => esc_html__( 'Column Width', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 50,
					'min'       => 1,
					'max'       => 100,
					'step'      => 10,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_type_2' => 'bar',
					),
				)
			);
		}
		
		if( in_array($chart_type, ['column','distributed_column'])  ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_is_chart_stroke_width',
				array(
					'label'   => esc_html__( 'Column Width', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 50,
					'min'     => 1,
					'max'     => 100,
					'step'    => 10,
				)
			);
		}

		if ( in_array( $chart_type, array( 'donut' ) ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_inner_radius',
				array(
					'label'   => 'Inner Radius',
					'type'    => Controls_Manager::NUMBER,
					'default' => 65,
					'min'     => 1,
					'max'     => 98,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . 'is_semi_circular_donut_chart',
				array(
					'label'     => __( 'Enable Semi-Circular Donut Chart?', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => false,
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . 'semi_circular_donut_chart_start_angle',
				array(
					'label'     => __( 'Start Angle', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 0,
					'min'       => -360,
					'max'       => 360,
					'condition' => array( GRAPHINA_PREFIX . $chart_type . 'is_semi_circular_donut_chart' => 'yes' ),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . 'semi_circular_donut_chart_end_angle',
				array(
					'label'     => __( 'End Angle', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 360,
					'min'       => -360,
					'max'       => 360,
					'condition' => array( GRAPHINA_PREFIX . $chart_type . 'is_semi_circular_donut_chart' => 'yes' ),
				)
			);
		}

		if ( in_array( $chart_type, array( 'area_google', 'column_google', 'line_google', 'donut_google', 'pie_google' ) ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_title_heading',
				array(
					'label' => esc_html__( 'Chart Title Settings', 'graphina-charts-for-elementor' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_title_show',
				array(
					'label'     => esc_html__( 'Chart Title Show', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => 'no',
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_title',
				array(
					'label'       => esc_html__( 'Chart Title', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
					'default'     => esc_html__( 'Chart Title', 'graphina-charts-for-elementor' ),
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_title_show' => 'yes',
					),
				)
			);

			if(! in_array($chart_type,array('donut_google','pie_google'))) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_title_position',
					array(
						'label'     => esc_html__( 'Position', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SELECT,
						'options'   => array(
							'in'  => esc_html__( 'In', 'graphina-charts-for-elementor' ),
							'out' => esc_html__( 'Out', 'graphina-charts-for-elementor' ),
						),
						'default'   => 'out',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_title_show' => 'yes',
						),
					)
				);
			}
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_title_color',
				array(
					'label'     => esc_html__( 'Title Font Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#000000',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_title_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_title_font_size',
				array(
					'label'     => esc_html__( 'Title Font Size', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 20,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_title_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_title_setting',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);
		}

		if ( in_array( $chart_type, array( 'area' ) ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_area_curve',
				array(
					'label'   => esc_html__( 'Area Shape', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::SELECT,
					'default' => graphina_stroke_curve_type( true ),
					'options' => graphina_stroke_curve_type(),

				)
			);
		}
		if ( in_array( $chart_type, array( 'line' ) ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_area_curve',
				array(
					'label'   => esc_html__( 'Line Shape', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::SELECT,
					'default' => graphina_stroke_curve_type( true ),
					'options' => graphina_stroke_curve_type(),

				)
			);
		}

		if ( in_array( $chart_type, array( 'column' ) ) ) {
			$widget->add_control(
				// $widget->add_responsive_control(
				GRAPHINA_PREFIX . $chart_type . '_is_chart_horizontal',
				array(
					'label'     => esc_html__( 'Horizontal', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					// 'desktop_default' => false,
					// 'tablet_default'  => false,
					// 'mobile_default'  => false,
				)
			);
		}

		if ( in_array( $chart_type, array( 'line', 'area', 'column', 'pie', 'polar', 'donut', 'scatter', 'line_google', 'area_google', 'bar_google', 'column_google' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_dynamic_change_chart_type',
				array(
					'label'     => esc_html__( 'Change Chart Type ', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => false,
				)
			);
		}

		if ( ! in_array( $chart_type, array( 'brush', 'data_table_lite', 'advance-datatable' ) ) ) {
			if ( ! in_array( $chart_type, array( 'line_google', 'area_google', 'bar_google', 'column_google', 'pie_google', 'donut_google', 'geo_google', 'gauge_google', 'org_google' ), true ) ) {

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_can_chart_show_toolbar',
					array(
						'label'     => esc_html__( 'Toolbar', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'default'   => true,
					)
				);
			
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_download',
					array(

						'label'     => esc_html__( 'Download Option', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_can_chart_show_toolbar' => 'yes',
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_offsety',
					array(
						'label'     => esc_html__( 'Offset-Y', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::NUMBER,
						'default'   => 0,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_can_chart_show_toolbar' => 'yes',
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_offsetx',
					array(

						'label'     => esc_html__( 'Offset-X', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::NUMBER,
						'default'   => 0,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_can_chart_show_toolbar' => 'yes',
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_export_filename',
					array(
						'label'     => esc_html__( 'Export Filename', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::TEXT,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_can_chart_show_toolbar' => 'yes',
						),
						'dynamic'   => array(
							'active' => true,
						),
					)
				);
			}
		}

		if ( ! in_array( $chart_type, array( 'data_table_lite', 'advance-datatable', 'line_google', 'area_google', 'bar_google', 'column_google', 'pie_google', 'donut_google', 'gauge_google', 'org_google' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_no_data_text',
				array(
					'label'       => esc_html__( 'No Data Text', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Loading...', 'graphina-charts-for-elementor' ),
					'default'     => 'No Data Available',
					'description' => esc_html__( 'When chart is empty, this text appears', 'graphina-charts-for-elementor' ),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);
		}

		if ( in_array( $chart_type, array( 'area', 'line', 'column' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_stacked',
				array(
					'label'     => esc_html__( 'Stacked ', 'graphina-charts-for-elementor' ) . ucfirst( $chart_type ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'   => false,
				)
			);
		}
		if ( in_array( $chart_type, array( 'area_google'), true ) ) { 
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_stacked_show',
				array(
					'label'     => esc_html__( 'Stacked Show ', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'   => false,
				)
			);
		}

		if ( ! in_array( $chart_type, array( 'data_table_lite', 'advance-datatable', 'line_google', 'area_google', 'column_google', 'bar_google', 'pie_google', 'donut_google', 'org_google', 'gauge_google' ), true ) ) {

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_hr_datalabel_setting',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_setting_title',
				array(
					'label' => esc_html__( 'Label Settings', 'graphina-charts-for-elementor' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$widget->add_responsive_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show',
				array(
					'label'     => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => $show_data_label === true ? 'yes' : false,
				)
			);


			if ( $chart_type === 'timeline' ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_hide_show_text',
					array(
						'label'     => esc_html__( 'Show Text', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'default'   => 'yes',
					)
				);
			}

			if ( in_array( $chart_type, array( 'radial', 'pie', 'donut' ), true ) ) {

				if ( in_array( $chart_type, array( 'pie', 'donut' ), true ) ) {
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_center_datalabel_show',
						array(
							'label'     => esc_html__( 'Show Center Label', 'graphina-charts-for-elementor' ),
							'type'      => Controls_Manager::SWITCHER,
							'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
							'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
							'default'   => $show_data_label === true ? 'yes' : false,
							'condition' => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show' => 'yes',
							),
						)
					);
				}
				if ( $chart_type === 'radial' ) {
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_total_title_show',
						array(
							'label'     => esc_html__( 'Show Total Label', 'graphina-charts-for-elementor' ),
							'type'      => Controls_Manager::SWITCHER,
							'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
							'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
							'condition' => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show' => 'yes',
							),
						)
					);
				} else {
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_total_title_show',
						array(
							'label'     => esc_html__( 'Show Total Value', 'graphina-charts-for-elementor' ),
							'type'      => Controls_Manager::SWITCHER,
							'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
							'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
							'condition' => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show' => 'yes',
								GRAPHINA_PREFIX . $chart_type . '_chart_center_datalabel_show' => 'yes',
							),
						)
					);
				}

				if ( $chart_type !== 'radial' ) {

					$condition_title = array(
						GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_center_datalabel_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_total_title_show' => 'yes',
					);
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_total_title_always',
						array(
							'label'       => esc_html__( 'Show Always Total', 'graphina-charts-for-elementor' ),
							'type'        => Controls_Manager::SWITCHER,
							'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
							'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
							'condition'   => $condition_title,
							'description' => esc_html__( 'Note: Always show the total label and do not remove it even when  clicks/hovers over the slices.', 'graphina-charts-for-elementor' ),
						)
					);

					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_total_title',
						array(
							'label'     => esc_html__( 'Total Text', 'graphina-charts-for-elementor' ),
							'type'      => Controls_Manager::TEXT,
							'default'   => esc_html__( 'Total', 'graphina-charts-for-elementor' ),
							'condition' => $condition_title,
						)
					);
				}
			}

			if ( in_array( $chart_type, array( 'radar', 'heatmap', 'radial', 'brush', 'distributed_column' ), true ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_label_pointer_for_label',
					array(
						'label'       => esc_html__( 'Format Number to String', 'graphina-charts-for-elementor' ),
						'type'        => Controls_Manager::SWITCHER,
						'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'condition'   => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show' => 'yes',
						),
						'default'     => false,
						'description' => esc_html__( 'Note: Convert 1,000  => 1k and 1,000,000 => 1m and if Format Number(Commas) is enable this will not work', 'graphina-charts-for-elementor' ),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_label_pointer_number_for_label',
					array(
						'label'     => esc_html__( 'Number of Decimal Want', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::NUMBER,
						'default'   => 0,
						'min'       => 0,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show' => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_label_pointer_for_label' => 'yes',
						),
					)
				);
			}

			if ( ! in_array( $chart_type, array( 'pie', 'donut', 'polar', 'nested_column', 'radial', 'column' ), true ) ) {

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_offsety',
					array(

						'label'     => esc_html__( 'Offset-Y', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::NUMBER,
						'default'   => 0,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show' => 'yes',
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_offsetx',
					array(

						'label'     => esc_html__( 'Offset-X', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::NUMBER,
						'default'   => 0,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show' => 'yes',
						),
					)
				);
			}

			if ( in_array( $chart_type, array( 'pie', 'donut', 'polar' ), true ) ) {

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format',
					array(
						'label'     => esc_html__( 'Format(tooltip/label)', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'default'   => 'no',
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format_showlabel',
					array(
						'label'     => esc_html__( 'Show label', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'default'   => 'no',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format' => 'yes',
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format_showValue',
					array(
						'label'     => esc_html__( 'Show Value', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'default'   => 'yes',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format' => 'yes',
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_label_pointer',
					array(
						'label'       => esc_html__( 'Format Number to String', 'graphina-charts-for-elementor' ),
						'type'        => Controls_Manager::SWITCHER,
						'condition'   => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format' => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format_showValue' => 'yes',
						),
						'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'default'     => false,
						'description' => esc_html__( 'Note: Convert 1,000  => 1k and 1,000,000 => 1m and if Format Number(Commas) is enable this will not work', 'graphina-charts-for-elementor' ),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_label_pointer_number',
					array(
						'label'     => esc_html__( 'Number of Decimal Want', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::NUMBER,
						'default'   => 0,
						'min'       => 0,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format' => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format_showValue' => 'yes',
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_format_prefix',
					array(
						'label'     => esc_html__( 'Label Prefix', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::TEXT,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format' => 'yes',
						),
						'dynamic'   => array(
							'active' => true,
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_format_postfix',
					array(
						'label'     => esc_html__( 'Label Postfix', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::TEXT,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format' => 'yes',
						),
						'dynamic'   => array(
							'active' => true,
						),
					)
				);
			}

			// Need to create condition for responsive controller.
			$data_label_font_color_condition = array(
				'relation' => 'and',
				'terms'    => array(
					array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show',
								'operator' => '==',
								'value'    => 'yes',
							),
						),
					),
				),
			);
				
			if ($chart_type !== 'mixed' && $label_position ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_position_show',
					array(
						'label'      => esc_html__( 'Position', 'graphina-charts-for-elementor' ),
						'type'       => Controls_Manager::SELECT,
						'default'    => graphina_position_type( 'vertical', true ),
						'options'    => graphina_position_type(),
						'conditions' => $data_label_font_color_condition,
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_orientation',
					array(
						'label'      => esc_html__( 'Orientation Position', 'graphina-charts-for-elementor' ),
						'type'       => Controls_Manager::SELECT,
						'default'    => graphina_position_type( 'orientation', true ),
						'options'    => graphina_position_type( 'orientation' ),
						'conditions' => $data_label_font_color_condition,
					)
				);
			}

			if ( $show_label_color ) {
				$data_label_font_setting = $data_label_font_color_condition;
				$data_label_background   = $data_label_font_color_condition;
				if ( $show_label_background ) {
					$data_label_font_setting['terms'][] = array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show',
								'operator' => '!=',
								'value'    => 'yes',
							),
						),
					);
				}

				$widget->add_responsive_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color',
					array(
						'label'      => esc_html__( 'Label Font Color', 'graphina-charts-for-elementor' ),
						'type'       => Controls_Manager::COLOR,
						'default'    => '#000000',
						'conditions' => $data_label_font_setting,
					)
				);
			}

			if ( $show_label_background && $chart_type !== 'heatmap' ) {

				$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show',
				array(
					'label'      => esc_html__( 'Show Background', 'graphina-charts-for-elementor' ),
					'type'       => Controls_Manager::SWITCHER,
					'label_on'   => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off'  => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'    => false,
					'conditions' => $data_label_font_color_condition,
					)
				);

				$data_label_background['terms'][] = array(
					'relation' => 'and',
					'terms'    => array(
						array(
							'name'     => GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show',
							'operator' => '==',
							'value'    => 'yes',
						),
					),
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_color',
					array(
						'label'      => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
						'type'       => Controls_Manager::COLOR,
						'default'    => '#FFFFFF',
						'conditions' => $data_label_background,
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color_1',
					array(
						'label'      => esc_html__( 'Background Color', 'graphina-charts-for-elementor' ),
						'type'       => Controls_Manager::COLOR,
						'default'    => '#000000',
						'conditions' => $data_label_background,
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_width',
					array(
						'label'      => esc_html__( 'Border Width', 'graphina-charts-for-elementor' ),
						'type'       => Controls_Manager::NUMBER,
						'default'    => 1,
						'min'        => 0,
						'max'        => 20,
						'conditions' => $data_label_background,
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_radius',
					array(
						'label'      => esc_html__( 'Border radius', 'graphina-charts-for-elementor' ),
						'type'       => Controls_Manager::NUMBER,
						'default'    => 0,
						'conditions' => $data_label_background,
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_color',
					array(
						'label'      => esc_html__( 'Border Color', 'graphina-charts-for-elementor' ),
						'type'       => Controls_Manager::COLOR,
						'default'    => '#FFFFFF',
						'conditions' => $data_label_background,
					)
				);

			}

			if ( $chart_type === 'heatmap' ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_color',
					array(
						'label'   => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
						'type'    => Controls_Manager::COLOR,
						'default' => '#FFFFFF',
					)
				);
			}



			if ( in_array( $chart_type, array( 'area', 'line', 'column', 'mixed','radial' ), true ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_number_format_commas',
					array(
						'label'     => esc_html__( 'Format Number(Commas)', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'default'   => 'no',
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_decimals_in_float',
					array(
						'label'     => esc_html__( 'Decimals In Float', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::NUMBER,
						'default'   => 0,
						'max'       => 6,
						'min'       => 0,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_number_format_commas' => 'yes',
						),
					)
				);
			}

			if ( $label_add_fixed && ! in_array( $chart_type, array( 'donut', 'pie', 'polar' ) ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_prefix',
					array(
						'label'      => esc_html__( 'Label Prefix', 'graphina-charts-for-elementor' ),
						'type'       => Controls_Manager::TEXT,
						'conditions' => $data_label_font_color_condition,
						'dynamic'    => array(
							'active' => true,
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_postfix',
					array(
						'label'      => esc_html__( 'Label Postfix', 'graphina-charts-for-elementor' ),
						'type'       => Controls_Manager::TEXT,
						'conditions' => $data_label_font_color_condition,
						'dynamic'    => array(
							'active' => true,
						),
					)
				);
			}
		}

		if ( ! in_array( $chart_type, array( 'data_table_lite', 'advance-datatable', 'gauge_google', 'nested_column' ) ) ) {
			$this->graphina_tooltip( $widget, $chart_type );
		}

		if ( 'heatmap' === $chart_type )
		{
			$this->heatmap_common_options($widget,$chart_type);
		}

		if ( in_array( $chart_type, array( 'donut', 'pie', 'timeline', 'heatmap' ) ) ) {
			$this->graphina_stroke( $widget, $chart_type );
		}

		if ( in_array( $chart_type, graphina_get_chart_type( 'apex' ) ) && ( ! in_array( $chart_type, array( 'candle', 'donut', 'polar', 'pie', 'radial' ,'heatmap') ) ) ) {
			$this->graphina_dropshadow( $widget, $chart_type );
		}

		if ( 'radar' === $chart_type ) {
			$this->graphina_plot_setting( $widget, $chart_type );
		} elseif ( 'bubble' === $chart_type ) {
			$this->graghina_bubble_plot_settings( $widget, $chart_type );
		} elseif ( 'distributed_column' === $chart_type ) {
			$this->graphina_distributed_column_plot_setting( $widget, $chart_type );
		}

		if ( 'radial' === $chart_type ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_hr_plot_setting',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_plot_setting_title',
				array(
					'label' => esc_html__( 'Plot Settings', 'graphina-charts-for-elementor' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_is_stroke_rounded',
				array(
					'label'     => esc_html__( 'Linecap Stroke Rounded', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'   => false,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_line_width',
				array(
					'label'   => esc_html__( 'Line width (%)', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'min'     => 20,
					'max'     => 70,
					'step'    => 5,
					'default' => 30,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_track_width',
				array(
					'label'   => 'Track Width',
					'type'    => Controls_Manager::NUMBER,
					'default' => 97,
					'min'     => 0,
					'max'     => 100,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_track_color_enable',
				array(
					'label'     => esc_html__( 'Chart Track Background Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'   => false,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_track_color',
				array(
					'label'     => 'Track Color',
					'type'      => Controls_Manager::COLOR,
					'default'   => '#808080',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_track_color_enable' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_track_opacity',
				array(
					'label'   => 'Track Opacity',
					'type'    => Controls_Manager::NUMBER,
					'default' => 0.2,
					'min'     => 0,
					'max'     => 0.5,
					'step'    => 0.01,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_angle',
				array(
					'label'   => esc_html__( 'Radial Shape', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'circle',
					'options' => array(
						'circle'      => esc_html__( 'Circle', 'graphina-charts-for-elementor' ),
						'semi_circle' => esc_html__( 'Semi Circle', 'graphina-charts-for-elementor' ),
						'custom'      => esc_html__( 'Custom', 'graphina-charts-for-elementor' ),
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_start_angle',
				array(
					'label'     => esc_html__( 'Start Angle', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 0,
					'max'       => 315,
					'step'      => 5,
					'default'   => 0,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_angle' => 'custom',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_end_angle',
				array(
					'label'     => esc_html__( 'End Angle', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 45,
					'max'       => 360,
					'step'      => 5,
					'default'   => 270,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_angle' => 'custom',
					),
				)
			);
		}
		if ( in_array( $chart_type, array( 'gauge_google' ), true ) ) {

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_meter_width',
				array(
					'label' => esc_html__( 'Width', 'graphina-charts-for-elementor' ),
					'type'  => Controls_Manager::NUMBER,
					'step'  => 10,
					'min'   => 0,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_meter_height',
				array(
					'label'   => esc_html__( 'Height', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 350,
					'min'     => 0,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_hr_ticks_prefix_1',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_value_prefix',
				array(
					'label'   => esc_html__( 'Value Prefix', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::TEXT,
					'default' => '',
					'dynamic' => array(
						'active' => true,
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_value_postfix',
				array(
					'label'   => esc_html__( 'Value Postfix', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::TEXT,
					'default' => '',
					'dynamic' => array(
						'active' => true,
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_value_decimal',
				array(
					'label'   => esc_html__( 'Decimal in float', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 0,
					'step'    => 1,
					'min'     => 0,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_hr_ticks_prefix_2',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_meter_min_value',
				array(
					'label'   => esc_html__( 'Min Value', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 0,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_meter_max_value',
				array(
					'label'   => esc_html__( 'Max Value', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 200,
					'min'     => 0,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_hr_ticks_color',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_ticks_color',
				array(
					'label' => esc_html__( 'Ticks Color From To', 'graphina-charts-for-elementor' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_meter_green_from',
				array(
					'label'   => esc_html__( 'Green From', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 0,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_meter_green_to',
				array(
					'label'   => esc_html__( 'Green To', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 50,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_meter_yellow_from',
				array(
					'label'   => esc_html__( 'Yellow From', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 50,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_meter_yellow_to',
				array(
					'label'   => esc_html__( 'Yellow To', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 150,
					'min'     => 0,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_meter_red_from',
				array(
					'label'   => esc_html__( 'Red From', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 150,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_meter_red_to',
				array(
					'label'   => esc_html__( 'Red To', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 200,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_ticks_color_divider',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_ticks_color_hr',
				array(
					'label' => esc_html__( 'Ticks Color', 'graphina-charts-for-elementor' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_ticks_green_color',
				array(
					'label'   => esc_html__( 'Green Color', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::COLOR,
					'default' => '#109618',
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_ticks_yellow_color',
				array(
					'label'   => esc_html__( 'Yellow Color', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::COLOR,
					'default' => '#FF9900',
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_ticks_red_color',
				array(
					'label'   => esc_html__( 'Red Color', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::COLOR,
					'default' => '#DC3912',
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_hr_ticks_setting',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_ticks_settings',
				array(
					'label' => esc_html__( 'Ticks Settings', 'graphina-charts-for-elementor' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_minor_ticks',
				array(
					'label'   => esc_html__( 'Minor Ticks', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 5,
					'min'     => 0,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_major_ticks_show',
				array(
					'label'     => esc_html__( 'Major Ticks Show', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => 'yes',
				)
			);

			$repeater = new Repeater();

			$repeater->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_major_ticks_value',
				array(
					'label'   => esc_html__( 'Major Ticks', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'dynamic' => array(
						'active' => true,
					),

				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_major_ticks',
				array(
					'label'     => esc_html__( 'Ticks', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::REPEATER,
					'fields'    => $repeater->get_controls(),
					'default'   => array(
						array( GRAPHINA_PREFIX . $chart_type . '_google_chart_major_ticks_value' => 0 ),
						array( GRAPHINA_PREFIX . $chart_type . '_google_chart_major_ticks_value' => 50 ),
						array( GRAPHINA_PREFIX . $chart_type . '_google_chart_major_ticks_value' => 100 ),
						array( GRAPHINA_PREFIX . $chart_type . '_google_chart_major_ticks_value' => 150 ),
						array( GRAPHINA_PREFIX . $chart_type . '_google_chart_major_ticks_value' => 200 ),
					),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_major_ticks_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_hr_needle_setting',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_needle_color',
				array(
					'label'   => esc_html__( 'Needle Color', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::COLOR,
					'default' => '#c63310',
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_round_ball_color',
				array(
					'label'   => esc_html__( 'Round Ball Color', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::COLOR,
					'default' => '#4684ee',
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_inner_circle_color',
				array(
					'label'   => esc_html__( 'Inner Circle Color', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::COLOR,
					'default' => '#f7f7f7',
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_outer_circle_color',
				array(
					'label'   => esc_html__( 'Outer Circle Color', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::COLOR,
					'default' => '#cccccc',
				)
			);
		}

		if ( $chart_type === 'data_table_lite' ) {
			$this->graphina_table_settings( $widget, $chart_type );
		}

		if ( 'mixed' === $chart_type ) {
			$plotOptionTypeCondition = array();
			for ( $loop = 0; $loop < graphina_default_setting( 'max_series_value' ); $loop++ ) {
				$plotOptionTypeCondition[] = array(
					'name'     => GRAPHINA_PREFIX . $chart_type . '_chart_type_3_' . $loop,
					'operator' => '===',
					'value'    => 'bar',
				);
			}

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_hr_plot_option_setting',
				array(
					'type'       => Controls_Manager::DIVIDER,
					'conditions' => array(
						'relation' => 'or',
						'terms'    => $plotOptionTypeCondition,
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_plot_options_setting_title',
				array(
					'label'      => esc_html__( 'Plot Option Settings ( Column )', 'graphina-charts-for-elementor' ),
					'type'       => Controls_Manager::HEADING,
					'conditions' => array(
						'relation' => 'or',
						'terms'    => $plotOptionTypeCondition,
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_plot_border_radius',
				array(
					'label'   => esc_html__( 'Border Radius', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'min'     => 0,
					'default' => 0,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_plot_datalabel_position_show',
				array(
					'label'      => esc_html__( 'Position', 'graphina-charts-for-elementor' ),
					'type'       => Controls_Manager::SELECT,
					'default'    => graphina_position_type( 'vertical', true ),
					'options'    => graphina_position_type( 'vertical' ),
					'conditions' => array(
						'relation' => 'or',
						'terms'    => $plotOptionTypeCondition,
					),
				)
			);

			$fillStyleTypeCondition = array();
			for ( $loop = 0; $loop < graphina_default_setting( 'max_series_value' ); $loop++ ) {
				$fillStyleTypeCondition[] = array(
					'name'     => GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type_' . $loop,
					'operator' => '===',
					'value'    => 'gradient',
				);
			}

			$widget->add_control(
				'hr_2_02',
				array(
					'type'       => Controls_Manager::DIVIDER,
					'conditions' => array(
						'relation' => 'or',
						'terms'    => $fillStyleTypeCondition,
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_fill_setting_title',
				array(
					'label'      => esc_html__( 'Fill Setting', 'graphina-charts-for-elementor' ),
					'type'       => Controls_Manager::HEADING,
					'conditions' => array(
						'relation' => 'or',
						'terms'    => $fillStyleTypeCondition,
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_can_chart_fill_inverse_color',
				array(
					'label'      => esc_html__( 'Inverse Color', 'graphina-charts-for-elementor' ),
					'type'       => Controls_Manager::SWITCHER,
					'label_on'   => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'label_off'  => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'    => false,
					'conditions' => array(
						'relation' => 'or',
						'terms'    => $fillStyleTypeCondition,
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_fill_gradient_type',
				array(
					'label'      => esc_html__( 'Gradient Type', 'graphina-charts-for-elementor' ),
					'type'       => Controls_Manager::SELECT,
					'default'    => 'horizontal',
					'options'    => array(
						'horizontal' => esc_html__( 'Horizontal', 'graphina-charts-for-elementor' ),
						'vertical'   => esc_html__( 'Vertical', 'graphina-charts-for-elementor' ),
						'diagonal1'  => esc_html__( 'Diagonal1', 'graphina-charts-for-elementor' ),
						'diagonal2'  => esc_html__( 'Diagonal2', 'graphina-charts-for-elementor' ),
					),
					'conditions' => array(
						'relation' => 'or',
						'terms'    => $fillStyleTypeCondition,
					),
				)
			);

			$widget->add_control(
				'hr_2_03',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_stroke_setting_title',
				array(
					'label' => esc_html__( 'Stroke Setting', 'graphina-charts-for-elementor' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_stroke_line_cap',
				array(
					'label'   => esc_html__( 'Line Cap', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::SELECT,
					'default' => $this->graphina_line_cap_type( true ),
					'options' => $this->graphina_line_cap_type(),
				)
			);
		}

		if ( in_array( $chart_type, array( 'donut_google', 'pie_google' ) ) ) {
			$this->graphina_element_label( $widget, $chart_type );
		}
		if ( 'candle' === $chart_type ) {
			$widget->add_control(
				'hr_2_03_fill',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_fill_setting_title',
				array(
					'label' => esc_html__( 'Fill Settings', 'graphina-charts-for-elementor' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_is_fill_color_show',
				array(
					'label'     => esc_html__( 'Color Show', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'   => 'yes',
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_is_fill_opacity',
				array(
					'label'   => esc_html__( 'Opacity', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 1,
					'min'     => 0.00,
					'max'     => 1,
					'step'    => 0.05,
				)
			);

			$widget->add_control(
				'iq_chart_upward_color',
				array(
					'label'   => esc_html__( 'Upward Color', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::COLOR,
					'default' => '#008B36',
				)
			);

			$widget->add_control(
				'iq_chart_downward_color',
				array(
					'label'   => esc_html__( 'Downward Color', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::COLOR,
					'default' => '#C70000',
				)
			);

		}

		if( 'nested_column' === $chart_type ) {
			apply_filters( 'graphina_nested_chart_common_options', $widget, $chart_type );
		}

		$widget->end_controls_section();
	}

	/**
	 * Function to handle chart selection section settings for Elementor widgets.
	 *
	 * @param \Elementor\Widget_Base $widget The Elementor element instance.
	 * @param string                 $chart_type     Type of chart being configured.
	 *
	 * @return void
	 */
	public function graphina_selection_setting( $widget, string $chart_type ): void {

		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_selection',
			array(
				'label' => esc_html__( 'Selection Setting', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_selection_xaxis',
			array(
				'label'     => esc_html__( 'Xaxis', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Enable', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Disable', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_selection_xaxis_min',
			array(
				'label'     => __( 'Min', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'step'      => 1,
				'default'   => 1,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_selection_xaxis' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_selection_xaxis_max',
			array(
				'label'     => __( 'Max', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 2,
				'step'      => 1,
				'default'   => 6,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_selection_xaxis' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_selection_fill',
			array(
				'label' => __( 'Fill', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_selection_fill_color',
			array(
				'label'   => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#fff',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_selection_fill_opacity',
			array(
				'label'   => esc_html__( 'Opacity', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0.4,
				'min'     => 0.00,
				'max'     => 1,
				'step'    => 0.05,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_selection_stroke',
			array(
				'label' => __( 'Stroke', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_selection_stroke_width',
			array(
				'label'   => esc_html__( 'Width', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
				'step'    => 1,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_selection_stroke_dasharray',
			array(
				'label'   => esc_html__( 'Dash', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'step'    => 1,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_selection_stroke_color',
			array(
				'label'   => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#24292e',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_selection_stroke_opacity',
			array(
				'label'   => esc_html__( 'Opacity', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0.4,
				'min'     => 0.00,
				'max'     => 1,
				'step'    => 0.05,
			)
		);

		$widget->end_controls_section();
	}

	/**
	 * Registers Geo Chart Settings for Graphina widget.
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_series_2_setting( \Elementor\Widget_Base $widget, string $chart_type = 'chart_id', array $ele_array = array( 'color' ), bool $show_fill_style = true, array $fill_options = array(), bool $show_fill_opacity = false, bool $show_gradient_type = false ): void {
		$colors         = $this->graphina_colors();
		$gradient_color = $this->graphina_colors( 'gradientColor' );
		$series_name    = esc_html__( 'Element', 'graphina-charts-for-elementor' );

		$title = in_array( 'brush-1', $ele_array, true ) ? esc_html__( 'Chart-1 ', 'graphina-charts-for-elementor' ) : esc_html__( 'Chart-2', 'graphina-charts-for-elementor' );

		$chart_type1 = 'brush';

		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_11',
			array(
				'label' => $title . esc_html__( ' Settings', 'graphina-charts-for-elementor' ),
			)
		);

		if ( $show_fill_style ) {
			$this->graphina_fill_style_setting( $widget, $chart_type, $fill_options, $show_fill_opacity );
		}

		if ( $show_fill_style && in_array( 'gradient', $fill_options, true ) ) {
			$this->graphina_gradient_setting( $widget, $chart_type, $show_gradient_type, true );
		}

		$max_series = graphina_default_setting( 'max_series_value' );
		for ( $i = 0; $i < $max_series; $i++ ) {

			if ( $i !== 0 || $show_fill_style ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_hr_series_count_' . $i,
					array(
						'type'      => Controls_Manager::DIVIDER,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type1 . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
			}

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_series_title_' . $i,
				array(
					'label'     => $series_name . ' ' . ( $i + 1 ),
					'type'      => Controls_Manager::HEADING,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type1 . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);

			if ( in_array( 'color', $ele_array, true ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_gradient_1_' . $i,
					array(
						'label'     => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => ! empty( $colors[ $i ] ) ? $colors[ $i ] : '',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type1 . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_gradient_2_' . $i,
					array(
						'label'     => esc_html__( 'Second Color', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => ! empty( $gradient_color[ $i ] ) ? $gradient_color[ $i ] : '',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type' => 'gradient',
							GRAPHINA_PREFIX . $chart_type1 . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_bg_pattern_' . $i,
					array(
						'label'     => esc_html__( 'Fill Pattern', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SELECT,
						'default'   => $this->graphina_get_fill_patterns( true ),
						'options'   => $this->graphina_get_fill_patterns(),
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type' => 'pattern',
							GRAPHINA_PREFIX . $chart_type1 . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
					)
				);
			}

			if ( in_array( 'dash', $ele_array, true ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_dash_3_' . $i,
					array(
						'label'       => 'Dash',
						'type'        => Controls_Manager::NUMBER,
						'default'     => 0,
						'min'         => 0,
						'max'         => 100,
						'condition'   => array(
							GRAPHINA_PREFIX . $chart_type1 . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
						'description' => esc_html__( 'Notice:This will not work in column chart', 'graphina-charts-for-elementor' ),
					)
				);
			}

			if ( in_array( 'width', $ele_array, true ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_width_3_' . $i,
					array(
						'label'       => 'Stroke Width',
						'type'        => Controls_Manager::NUMBER,
						'default'     => 3,
						'min'         => 1,
						'max'         => 20,
						'condition'   => array(
							GRAPHINA_PREFIX . $chart_type1 . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						),
						'description' => esc_html__( 'Notice:This will not work in column chart', 'graphina-charts-for-elementor' ),
					)
				);
			}

			if ( in_array( $chart_type, array( 'radar', 'line', 'area', 'brush' ), true ) ) {

				$this->graphina_marker_setting( $widget, $chart_type, $i );

			}
		}
		$widget->end_controls_section();
	}

	/**
	 * Retrieves available line cap types for line charts.
	 *
	 * This function provides a list of line cap styles used in Graphina Pro's
	 * line charts. The line cap defines the shape of the ends of lines,
	 * affecting the chart’s visual aesthetics. It supports fetching the full
	 * list of options or only the first available type.
	 *
	 * Key Features:
	 * - Provides three cap styles: Square, Butt, and Round.
	 * - Returns localized labels for better internationalization.
	 * - Supports optional retrieval of the first cap type for convenience.
	 *
	 * @param bool $first If true, returns only the first available line cap type.
	 *
	 * @return array|string An array of line cap types with labels, or a single cap type if `$first` is true.
	 */
	protected function graphina_line_cap_type( $first = false ) {
		$options = array(
			'square' => esc_html__( 'Square', 'graphina-charts-for-elementor' ),
			'butt'   => esc_html__( 'Butt', 'graphina-charts-for-elementor' ),
			'round'  => esc_html__( 'Round', 'graphina-charts-for-elementor' ),
		);
		$keys    = array_keys( $options );
		return $first ? ( count( $keys ) > 0 ? $keys[0] : '' ) : $options;
	}

	/**
	 * Configures advanced data table settings for Graphina Pro charts.
	 *
	 * This function adds various controls to the Elementor widget, allowing users
	 * to customize the behavior and appearance of data tables used within charts.
	 * It includes settings for table visibility, responsiveness, search filtering,
	 * pagination, and caching.
	 *
	 * Key Features:
	 * - **Show Card Toggle:** Enables or disables card-style display for data.
	 * - **Responsive Mode:** Controls whether the table adapts to different screen sizes.
	 * - **Search Filter:** Allows users to enable or disable search functionality.
	 * - **Pagination:** Offers multiple pagination styles and customizable rows per page.
	 * - **Cache for Development:** Creates a temporary cache to speed up rendering in editor mode.
	 *
	 * @param object $widget Elementor widget instance to which controls are added.
	 * @param string $chart_type The type of chart for which settings are applied.
	 *
	 * @return void
	 */
	protected function graphina_advance_data_table_settings( $widget, $chart_type ) {

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_element_card_show',
			array(
				'label'     => esc_html__( 'Show Card', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_table_responsive',
			array(
				'label'     => esc_html__( 'Responsive', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_can_show_filter',
			array(
				'label'     => esc_html__( 'Search', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => '',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_table_pagination',
			array(
				'label'     => esc_html__( 'Pagination Enabled', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'no',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_pagination_type',
			array(
				'label'     => esc_html__( 'Pagination Type', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'simple_numbers',
				'options'   => array(
					'numbers'            => esc_html__( 'Numbers', 'graphina-charts-for-elementor' ),
					'simple'             => esc_html__( 'Simple', 'graphina-charts-for-elementor' ),
					'simple_numbers'     => esc_html__( 'Simple Numbers', 'graphina-charts-for-elementor' ),
					'first_last_numbers' => esc_html__( 'First Last Numbers', 'graphina-charts-for-elementor' ),
				),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_table_pagination' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_pagination_row',
			array(
				'label'     => esc_html__( 'Rows Per Page', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 10,
				'min'       => 1,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_table_pagination' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_page_range',
			array(
				'label'     => esc_html__( 'Page Range', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 1,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_table_pagination' => 'yes',
					GRAPHINA_PREFIX . $chart_type . '_pagination_type' => array( 'numbers', 'simple_numbers' ),
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_pagination_info',
			array(
				'label'     => esc_html__( 'Pagination Info', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_table_pagination' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_can_use_cache_development',
			array(
				'label'       => esc_html__( 'Use Cache For Development', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'label_off'   => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'description' => esc_html__( "It's create temporary cache of your file data and load from their for one hour in editor mode. It doesn't effect preview or live website", 'graphina-charts-for-elementor' ),
				'default'     => false,
				'condition'   => array(
					GRAPHINA_PREFIX . $chart_type . '_element_data_option' => 'dynamic',
					GRAPHINA_PREFIX . $chart_type . '_element_dynamic_data_option' => array( 'remote-csv', 'google-sheet' ),
				),
			)
		);
	}

	/**
	 * Registers Table Settings for Graphina widget.
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	protected function graphina_table_settings( $widget, $chart_type ) {
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . 'table_footer',
			array(
				'label'     => esc_html__( 'Footer Enable', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_hide_table_header',
			array(
				'label'     => esc_html__( 'Header Enable', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . 'table_data_direct',
			array(
				'label'     => esc_html__( 'Direct Data Input Enabled', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Enable', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Disable', 'graphina-charts-for-elementor' ),
				'default'   => 'no',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . 'table_search',
			array(
				'label'     => esc_html__( 'Search Enabled', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . 'table_pagination',
			array(
				'label'     => esc_html__( 'Pagination Enabled', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . 'table_pagination_info',
			array(
				'label'     => esc_html__( 'Pagination Info', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . 'table_pagination' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . 'pagination_type',
			array(
				'label'     => esc_html__( 'Pagination Type', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'numbers',
				'options'   => array(
					'numbers'            => esc_html__( 'Numbers', 'graphina-charts-for-elementor' ),
					'simple'             => esc_html__( 'Simple', 'graphina-charts-for-elementor' ),
					'simple_numbers'     => esc_html__( 'Simple Numbers', 'graphina-charts-for-elementor' ),
					'full'               => esc_html__( 'Full', 'graphina-charts-for-elementor' ),
					'full_numbers'       => esc_html__( 'Full Numbers', 'graphina-charts-for-elementor' ),
					'first_last_numbers' => esc_html__( 'First Last Numbers', 'graphina-charts-for-elementor' ),
				),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . 'table_pagination' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . 'table_sort',
			array(
				'label'     => esc_html__( 'Sorting Enabled', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . 'table_scroll',
			array(
				'label'     => esc_html__( 'Scrolling Enabled', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_table_scroll_y',
			array(
				'label'     => esc_html__( 'Scroll Y', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 200,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . 'table_scroll' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_pagelength',
			array(
				'label'   => esc_html__( 'Page Length', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 10,
				'options' => array(
					10  => 10,
					50  => 50,
					100 => 100,
					-1  => esc_html__( 'All', 'graphina-charts-for-elementor' ),
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_button_menu',
			array(
				'label'    => esc_html__( 'Button Menu', 'graphina-charts-for-elementor' ),
				'type'     => Controls_Manager::SELECT2,
				'default'  => 'pageLength',
				'multiple' => true,
				'options'  => array(
					'pageLength' => esc_html__( 'pageLength', 'graphina-charts-for-elementor' ),
					'colvis'     => esc_html__( 'Column Visibilty', 'graphina-charts-for-elementor' ),
					'copy'       => esc_html__( 'Copy', 'graphina-charts-for-elementor' ),
					'excel'      => esc_html__( 'Excel', 'graphina-charts-for-elementor' ),
					'pdf'        => esc_html__( 'PDF', 'graphina-charts-for-elementor' ),
					'print'      => esc_html__( 'Print', 'graphina-charts-for-elementor' ),
					'excelFlash' => esc_html__( 'excelFlash', 'graphina-charts-for-elementor' ),
				),
			)
		);

		
	}

	/**
	 * Registers Plot for Graphina widget.
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_plot_setting( $widget, $chart_type ) {

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_hr_plot_setting',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_plot_setting_title',
			array(
				'label' => esc_html__( 'Plot Settings', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_plot_stroke_color',
			array(
				'label'   => 'Stroke Color',
				'type'    => Controls_Manager::COLOR,
				'default' => '#e9e9e9',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_plot_color',
			array(
				'label'   => 'Color',
				'type'    => Controls_Manager::COLOR,
				'default' => '#ffffff',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_stroke_size',
			array(
				'label'   => esc_html__( 'Stroke Size', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 0,
			)
		);

	}
	/**
	 * Summary of graphina_distributed_column_plot_setting
	 * @param mixed $widget
	 * @param mixed $chart_type
	 * @return void
	 */
	protected function graphina_distributed_column_plot_setting( $widget, $chart_type ) {
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_hr_plot_setting',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_plot_setting_title',
			array(
				'label' => esc_html__( 'Plot Settings', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_plot_border_radius',
			array(
				'label'   => esc_html__( 'Border Radius', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'default' => 0,
			)
		);
	}
	/**
	 * Summary of graghina_bubble_plot_settings
	 * @param mixed $widget
	 * @param mixed $chart_type
	 * @return void
	 */

	protected function graghina_bubble_plot_settings( $widget, $chart_type ) {

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_hr_plot_setting',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_plot_setting_title',
			array(
				'label' => esc_html__( 'Plot Settings', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_fill_opacity',
			array(
				'label'   => esc_html__( 'Fill Opacity', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 0,
				'max'     => 1,
				'step'    => 0.05,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_stroke_width',
			array(
				'label'   => 'Stroke Width',
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 0,
				'max'     => 15,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_stroke_color',
			array(
				'label'     => 'Stroke Color',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_stroke_width!' => 0,
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_3d_show',
			array(
				'label'     => esc_html__( '3D Chart', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => false,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_is_custom_radius',
			array(
				'label'     => esc_html__( 'Custom Bubble Radius', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => false,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_min_bubble_radius',
			array(
				'label'     => esc_html__( 'Minimum Bubble Radius', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 25,
				'max'       => 100,
				'min'       => 10,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_is_custom_radius' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_max_bubble_radius',
			array(
				'label'     => esc_html__( 'Maximum Bubble Radius', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 70,
				'max'       => 200,
				'min'       => 10,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_is_custom_radius' => 'yes',
				),
			)
		);
	}

	/**
	 * Register Chart Tooltip Controls
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_tooltip( $widget, string $chart_type = 'chart_id', bool $show_theme = true, bool $shared = true ): void {
		// Tooltip Setting.
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_hr_tooltip_setting',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_setting_title',
			array(
				'label' => esc_html__( 'Tooltip Settings', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		if ( in_array( $chart_type, array( 'area_google', 'line_google', 'bar_google', 'column_google', 'pie_google', 'donut_google', 'geo_google' ), true ) ) {

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_show',
				array(
					'label'     => esc_html__( 'Show Tooltip', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => 'yes',
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_trigger',
				array(
					'label'     => esc_html__( ' Trigger', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						'focus'     => esc_html__( 'On Hover', 'graphina-charts-for-elementor' ),
						'selection' => esc_html__( 'On Selection', 'graphina-charts-for-elementor' ),
					),
					'default'   => 'focus',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_color',
				array(
					'label'     => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => 'black',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_show' => 'yes',
					),
				)
			);

			if ( $chart_type === 'geo_google' ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_font_size',
					array(
						'label'     => esc_html__( 'Font Size', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::NUMBER,
						'min'       => 0,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_show' => 'yes',
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_bold',
					array(
						'label'     => esc_html__( 'Bold', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_show' => 'yes',
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_italic',
					array(
						'label'     => esc_html__( 'Italic', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_show' => 'yes',
						),
					)
				);
			}

			if ( in_array( $chart_type, array( 'pie_google', 'donut_google' ), true ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_text',
					array(
						'label'     => esc_html__( 'Text', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SELECT,
						'default'   => 'value',
						'options'   => array(
							'both'       => esc_html__( 'Value And Percentage', 'graphina-charts-for-elementor' ),
							'value'      => esc_html__( 'Value', 'graphina-charts-for-elementor' ),
							'percentage' => esc_html__( 'Percentage', 'graphina-charts-for-elementor' ),
						),
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_show' => 'yes',
						),

					)
				);
			}

			if ( in_array( $chart_type, array( 'column_google', 'bar_google' ), true ) ) {

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_element_column_setting',
					array(
						'type' => Controls_Manager::DIVIDER,
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_element_column_setting_title',
					array(
						'label' => esc_html__( 'Column Settings', 'graphina-charts-for-elementor' ),
						'type'  => Controls_Manager::HEADING,
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_element_width',
					array(
						'label'   => esc_html__( 'Column Width', 'graphina-charts-for-elementor' ),
						'type'    => Controls_Manager::NUMBER,
						'default' => 20,
					)
				);

				if ( in_array( $chart_type, array( 'column_google'), true ) ){
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_stacked',
						array(
							'label'     => esc_html__( 'Stacked Show', 'graphina-charts-for-elementor' ),
							'type'      => Controls_Manager::SWITCHER,
							'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
							'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
							'default'   => false,
						)
					);
				}
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_stack_type',
					array(
						'label'     => esc_html__( 'Stack Type', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SELECT,
						'default'   => 'absolute',
						'options'   => array(
							'absolute' => esc_html__( 'Absolute', 'graphina-charts-for-elementor' ),
							'relative' => esc_html__( 'Relative', 'graphina-charts-for-elementor' ),
							'percent'  => esc_html__( 'percent', 'graphina-charts-for-elementor' ),
						),
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_stacked' => 'yes',

						),
					)
				);
			}
			if ( in_array( $chart_type, array( 'column_google', 'bar_google', 'line_google', 'area_google' ), true ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_annotation_setting_start',
					array(
						'type' => Controls_Manager::DIVIDER,
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_annotation_setting_title',
					array(
						'label' => esc_html__( 'Annotation Settings', 'graphina-charts-for-elementor' ),
						'type'  => Controls_Manager::HEADING,
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_annotation_show',
					array(
						'label'     => esc_html__( 'Show Annotation', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
						'default'   => false,
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_annotation_color',
					array(
						'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000000',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_annotation_show' => 'yes',
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_annotation_color2',
					array(
						'label'     => esc_html__( 'Second Color', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_annotation_show' => 'yes',
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_annotation_stemcolor',
					array(
						'label'     => esc_html__( 'Stem Color', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000000',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_annotation_show' => 'yes',
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_annotation_fontsize',
					array(
						'label'     => esc_html__( ' Fontsize', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::NUMBER,
						'default'   => 12,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_annotation_show' => 'yes',
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_annotation_opacity',
					array(
						'label'     => esc_html__( 'Opacity', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::NUMBER,
						'default'   => 0.5,
						'step'      => 0.01,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_annotation_show' => 'yes',
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_annotation_prefix_postfix',
					array(
						'label'     => esc_html__( 'Annotation Prefix/Postfix', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'true'      => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
						'false'     => esc_html__( 'No', 'graphina-charts-for-elementor' ),
						'default'   => '',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_annotation_show' => 'yes',
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_annotation_prefix',
					array(
						'label'     => esc_html__( 'Prefix', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::TEXT,
						'default'   => '',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_annotation_show' => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_annotation_prefix_postfix' => 'yes',
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_annotation_postfix',
					array(
						'label'     => esc_html__( 'Postfix', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::TEXT,
						'default'   => '',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_annotation_show' => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_annotation_prefix_postfix' => 'yes',
						),
					)
				);
			}
		} else {
			$notice = '';
			if ( $chart_type === 'radar' ) {
				$notice = esc_html__( 'Warning: This will may not work if markers are not shown.', 'graphina-charts-for-elementor' );
			}
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_tooltip',
				array(
					'label'       => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::SWITCHER,
					'label_on'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'label_off'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'     => 'yes',
					'description' => $notice,
				)
			);

			if ( $shared && $chart_type !== 'candle' ) {
				$notice = '';
				if ( $chart_type === 'column' ) {
					$notice = esc_html__( 'Warning: This will may not work for horizontal column chart.', 'graphina-charts-for-elementor' );
				}
				if ( in_array( $chart_type, array( 'area', 'line' ), true ) ) {
					$notice = esc_html__( 'If tooltip shared off ,Elements setting -> Marker settings -> size value should be greater then 0 to work properly', 'graphina-charts-for-elementor' );
				}

				if ( ! in_array( $chart_type, array( 'donut', 'polar', 'pie', 'timeline', 'bubble', 'radar' ,' heatmap', 'radial','distributed_column') ) ) {
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared',
						array(
							'label'       => esc_html__( 'Shared', 'graphina-charts-for-elementor' ),
							'type'        => Controls_Manager::SWITCHER,
							'label_on'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
							'label_off'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
							'description' => $notice,
							'default'     => 'yes',
							'condition'   => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_tooltip' => 'yes',
							),
						)
					);
				}
			}

			if ( $show_theme ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_theme',
					array(
						'label'     => esc_html__( 'Theme', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::CHOOSE,
						'default'   => 'light',
						'options'   => array(
							'light' => array(
								'title' => esc_html__( 'Light', 'graphina-charts-for-elementor' ),
								'icon'  => 'eicon-light-mode',
							),
							'dark'  => array(
								'title' => esc_html__( 'Dark', 'graphina-charts-for-elementor' ),
								'icon'  => 'eicon-dark-mode',
							),
						),
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_tooltip' => 'yes',
						),
					)
				);
			}
		}
	}
	/**
	 * Summary of graphina_stroke
	 * @param mixed $widget
	 * @param string $chart_type
	 * @return void
	 */
	protected function graphina_stroke( $widget, string $chart_type = 'chart_id' ): void {
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_hr_stroke_setting',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_stroke_setting_title',
			array(
				'label' => esc_html__( 'Stroke Settings', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_stroke_show',
			array(
				'label'     => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => false,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_stroke_width',
			array(
				'label'     => 'Stroke Width',
				'type'      => Controls_Manager::NUMBER,
				'default'   => 2,
				'min'       => 0,
				'max'       => 10,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_stroke_show' => 'yes',
				),
			)
		);
		if ( in_array( $chart_type, array( 'timeline' ) ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_stroke_color',
				array(
					'label'     => 'Stroke Color',
					'type'      => Controls_Manager::COLOR,
					'default'   => '#e9e9e9',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_stroke_show' => 'yes',
					),
				)
			);
		}
	}
	/**
	 * Register Chart Animation Controls
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_animation( $widget, string $chart_type = 'chart_id' ): void {

		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_chart_style',
			array(
				'label' => esc_html__( 'Chart Style', 'graphina-charts-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		
		if ( $chart_type !== 'tree' ) {

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_style_title',
				array(
					'label' => esc_html__( 'Chart', 'graphina-charts-for-elementor' ),
					'type'  => Controls_Manager::HEADING,
				)
			);
	
			if(! in_array( $chart_type, ['geo_google', 'gauge_google', 'org_google', 'gantt_google'] )){
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_background_color1',
					array(
						'label' => esc_html__( 'Chart Background Color', 'graphina-charts-for-elementor' ),
						'type'  => Controls_Manager::COLOR,
					)
				);
			}
	
			$responsive = 'add_responsive_control';
	
			if ( 'gantt_google' !== $chart_type ){
				$widget->$responsive(
					GRAPHINA_PREFIX . $chart_type . '_chart_height',
					array(
						'label'           => esc_html__( 'Height (px)', 'graphina-charts-for-elementor' ),
						'type'            => Controls_Manager::NUMBER,
						'default'         => $chart_type === 'brush' ? 175 : 350,
						'step'            => 5,
						'min'             => 10,
						'desktop_default' => $chart_type === 'brush' ? 175 : 350,
						'tablet_default'  => $chart_type === 'brush' ? 175 : 350,
						'mobile_default'  => $chart_type === 'brush' ? 175 : 350,
					)
				);
			}
	
			if(! in_array( $chart_type, graphina_google_chart_lists() )){
				$widget->$responsive(
					GRAPHINA_PREFIX . $chart_type . '_chart_font_size',
					array(
						'label'      => esc_html__( 'Font Size', 'graphina-charts-for-elementor' ),
						'type'       => Controls_Manager::SLIDER,
						'size_units' => array( 'px', 'em', 'rem', 'vw' ),
						'range'      => array(
							'px'  => array(
								'min' => 1,
								'max' => 200,
							),
							'em'  => array(
								'min' => 1,
								'max' => 200,
							),
							'rem' => array(
								'min' => 1,
								'max' => 200,
							),
							'vw'  => array(
								'min'  => 0.1,
								'max'  => 10,
								'step' => 0.1,
							),
						),
						'default'    => array(
							'unit' => 'px',
							'size' => 12,
						),
						'tablet_default' => array(
							'unit' => 'px',
							'size' => 12,
						),
						'mobile_default' => array(
							'unit' => 'px',
							'size' => 12,
						),
					)
				);
			}
	
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_font_family',
				array(
					'label'       => esc_html__( 'Font Family', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::FONT,
					'description' => esc_html__( 'Notice:If possible use same font as Chart Title & Description, Otherwise it may not show the actual font you selected.', 'graphina-charts-for-elementor' ),
					'default'     => 'Poppins',
				)
			);
	
			foreach ( array_merge( array( 'normal', 'bold' ), range( 100, 900, 100 ) ) as $weight ) {
				$typo_weight_options[ $weight ] = ucfirst( $weight );
			}
	
			if(! in_array( $chart_type, graphina_google_chart_lists() )){
				$widget->$responsive(
					GRAPHINA_PREFIX . $chart_type . '_chart_font_weight',
					array(
						'label'     => esc_html__( 'Font Weight', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SELECT,
						'default'   => '',
						'options'   => $typo_weight_options,
					)
				);
		
				$widget->$responsive(
					GRAPHINA_PREFIX . $chart_type . '_chart_font_color',
					array(
						'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000000',
					)
				);
			}
	
			if(  ! in_array( $chart_type, array( 'geo_google', 'gauge_google' ), true )  ){
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_hr_animation_setting',
					array(
						'type' => Controls_Manager::DIVIDER,
					)
				);
	
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_animation_setting_title',
					array(
						'label' => esc_html__( 'Animation Settings', 'graphina-charts-for-elementor' ),
						'type'  => Controls_Manager::HEADING,
					)
				);
			}
	
			if ( in_array( $chart_type, array( 'area_google', 'line_google', 'bar_google', 'column_google' ), true ) ) {
	
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_animation_show',
					array(
						'label'   => esc_html__( 'Show Animation', 'graphina-charts-for-elementor' ),
						'type'    => Controls_Manager::SWITCHER,
						'yes'     => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
						'no'      => esc_html__( 'No', 'graphina-charts-for-elementor' ),
						'default' => 'yes',
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_animation_speed',
					array(
						'label'     => esc_html__( 'Speed', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::NUMBER,
						'default'   => 800,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_animation_show' => 'yes',
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_animation_easing',
					array(
						'label'     => esc_html__( 'Easing', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SELECT,
						'default'   => 'linear',
						'options'   => array(
							'linear'   => esc_html__( 'Linear', 'graphina-charts-for-elementor' ),
							'in'       => esc_html__( 'In', 'graphina-charts-for-elementor' ),
							'out'      => esc_html__( 'Out', 'graphina-charts-for-elementor' ),
							'inAndout' => esc_html__( 'In And Out', 'graphina-charts-for-elementor' ),
						),
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_animation_show' => 'yes',
						),
					)
				);
			} else {
				if( ! in_array( $chart_type, array( 'geo_google', 'gauge_google' ), true )  ){
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_animation',
						array(
							'label'     => esc_html__( 'Custom', 'graphina-charts-for-elementor' ),
							'type'      => Controls_Manager::SWITCHER,
							'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
							'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
							'default'   => 'yes',
						)
					);
	
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_animation_speed',
						array(
							'label'     => esc_html__( 'Speed', 'graphina-charts-for-elementor' ),
							'type'      => Controls_Manager::NUMBER,
							'default'   => 800,
							'condition' => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_animation' => 'yes',
							),
						)
					);
	
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_animation_delay',
						array(
							'label'     => esc_html__( 'Delay', 'graphina-charts-for-elementor' ),
							'type'      => Controls_Manager::NUMBER,
							'default'   => 150,
							'condition' => array(
								GRAPHINA_PREFIX . $chart_type . '_chart_animation' => 'yes',
							),
						)
					);
				}
			}
	
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_style_box_divider',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);
		}

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_box_settings_heading',
			array(
				'label' => esc_html__( 'Box Style', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_border_show',
			array(
				'label'     => esc_html__( 'Chart Box', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$widget->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => GRAPHINA_PREFIX . $chart_type . '_chart_background',
				'label'     => esc_html__( 'Background', 'graphina-charts-for-elementor' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .chart-box',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_border_show' => 'yes',
				),
			)
		);

		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => GRAPHINA_PREFIX . $chart_type . '_chart_box_shadow',
				'label'     => esc_html__( 'Box Shadow', 'graphina-charts-for-elementor' ),
				'selector'  => '{{WRAPPER}} .chart-box',
				'condition' => array( GRAPHINA_PREFIX . $chart_type . '_chart_border_show' => 'yes' ),
			)
		);

		$widget->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => GRAPHINA_PREFIX . $chart_type . '_chart_border',
				'label'     => esc_html__( 'Border', 'graphina-charts-for-elementor' ),
				'selector'  => '{{WRAPPER}} .chart-box',
				'condition' => array( GRAPHINA_PREFIX . $chart_type . '_chart_border_show' => 'yes' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'graphina-charts-for-elementor' ),
				'size_units' => array( 'px', '%', 'em' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'condition'  => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_border_show' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .chart-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
				),
			)
		);

		$widget->end_controls_section();
	}
	/**
	 * Summary of graphina_counter_card_style_section
	 * @param mixed $widget
	 * @param mixed $chart_type
	 * @param mixed $alignItems
	 * @return void
	 */
	public function graphina_counter_card_style_section( $widget, $chart_type, $alignItems = false ) {
			$widget->start_controls_section(
				GRAPHINA_PREFIX . $chart_type . '_icon_style_section',
				array(
					'label'     => esc_html__( 'Icon Style', 'graphina-charts-for-elementor' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_element_layout_option' => graphina_get_array_diff( $this->graphina_element_data_enter_options( 'counter_layout', false, true ), array( 'layout_2', 'layout_3', 'layout_4' ) ),
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_count_icon_font_color',
				array(
					'label'     => esc_html__( 'Icon Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#000000',
					'selectors' => array(
						'{{WRAPPER}} .graphina-card.counter .counter-icon svg' => 'fill: {{VALUE}}',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_element_counter_icon_size',
				array(
					'label'      => esc_html__( 'Size', 'graphina-charts-for-elementor' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'range'      => array(
						'px' => array(
							'min'  => 0,
							'max'  => 1000,
							'step' => 5,
						),
					),
					'default'    => array(
						'unit' => 'px',
						'size' => 20,
					),
					'selectors'  => array(
						'{{WRAPPER}} .graphina-card.counter .counter-icon svg' => 'width: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_count_icon_horizontal_alignment',
				array(
					'label'     => esc_html__( 'Alignment', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'left'   => array(
							'title' => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
							'icon'  => 'fa fa-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'graphina-charts-for-elementor' ),
							'icon'  => 'fa fa-align-center',
						),
						'right'  => array(
							'title' => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
							'icon'  => 'fa fa-align-right',
						),
					),
					'default'   => 'center',
					'selectors' => array(
						'{{WRAPPER}} .graphina-card.counter .counter-icon' => 'text-align: {{VALUE}};',
					),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_element_layout_option' => graphina_get_array_diff( $this->graphina_element_data_enter_options( 'counter_layout', false, true ), array( 'layout_5', 'layout_6' ) ),
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_count_icon_horizontal_position',
				array(
					'label'     => esc_html__( 'Alignment', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'row'         => array(
							'title' => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
							'icon'  => 'fa fa-align-left',
						),
						'row-reverse' => array(
							'title' => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
							'icon'  => 'fa fa-align-right',
						),
					),
					'default'   => 'row',
					'selectors' => array(
						'{{WRAPPER}} .graphina-card.counter' => 'flex-direction: {{VALUE}};',
					),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_element_layout_option' => array( 'layout_5', 'layout_6' ),
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_count_icon_margin',
				array(
					'label'      => esc_html__( 'Margin', 'graphina-charts-for-elementor' ),
					'size_units' => array( 'px', '%', 'em' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'selectors'  => array(
						'{{WRAPPER}} .graphina-card.counter .counter-icon ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_count_icon_padding',
				array(
					'label'      => esc_html__( 'Padding', 'graphina-charts-for-elementor' ),
					'size_units' => array( 'px', '%', 'em' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'selectors'  => array(
						'{{WRAPPER}} .graphina-card.counter .counter-icon ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
					),
				)
			);

			$widget->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'     => GRAPHINA_PREFIX . $chart_type . '_counter_icon_border',
					'label'    => esc_html__( 'Border', 'graphina-charts-for-elementor' ),
					'selector' => '{{WRAPPER}} .graphina-card.counter .counter-icon ',
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_counter_icon_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'graphina-charts-for-elementor' ),
					'size_units' => array( 'px', '%', 'em' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'selectors'  => array(
						'{{WRAPPER}} .graphina-card.counter .counter-icon ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
					),
				)
			);

			$widget->end_controls_section();

		/***************************
		* Counter Style
		*/
		$this->graphina_counter_style_section( $widget, $chart_type, 'counter', '.graphina-card.counter .myGraphinaCounter' );

		/***************************
		* Title Style
		*/
		$this->graphina_counter_style_section( $widget, $chart_type, 'title', '.graphina-card.counter .title' );

		/***************************
		* Title Style
		*/
		$this->graphina_counter_style_section( $widget, $chart_type, 'description', '.graphina-card.counter .description' );
	}

	/**
	 * Summary of graphina_counter_style_section
	 * @param mixed $widget
	 * @param mixed $chart_type
	 * @param mixed $for
	 * @param mixed $class
	 * @return void
	 */
	protected function graphina_counter_style_section( $widget, $chart_type = 'element_id', $for = 'counter-title', $class = '' ) {
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_count_style_section_' . $for,
			array(
				'label' => esc_html__( ucfirst( $for ) . ' Style', 'graphina-charts-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$typography = Global_Typography::TYPOGRAPHY_ACCENT;
		switch ( $for ) {
			case 'counter':
				$typography = Global_Typography::TYPOGRAPHY_PRIMARY;
				break;
			case 'title':
				$typography = Global_Typography::TYPOGRAPHY_SECONDARY;
				break;
			case 'description':
				$typography = Global_Typography::TYPOGRAPHY_TEXT;
				break;
		}
		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => GRAPHINA_PREFIX . $chart_type . '_count_' . $for . '_typography',
				'label'    => esc_html__( 'Typography', 'graphina-charts-for-elementor' ),
				'global'   => array(
					'default' => $typography,
				),
				'selector' => '{{WRAPPER}} ' . $class,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_count_' . $for . '_font_color',
			array(
				'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} ' . $class => 'color: {{VALUE}}',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_count_' . $for . '_horizontal_alignment',
			array(
				'label'     => esc_html__( 'Text Alignment', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'graphina-charts-for-elementor' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} ' . $class => 'text-align: {{VALUE}};',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_count_' . $for . '_margin',
			array(
				'label'      => esc_html__( 'Margin', 'graphina-charts-for-elementor' ),
				'size_units' => array( 'px', '%', 'em' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => array(
					'{{WRAPPER}} ' . $class => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_count_' . $for . '_padding',
			array(
				'label'      => esc_html__( 'Padding', 'graphina-charts-for-elementor' ),
				'size_units' => array( 'px', '%', 'em' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => array(
					'{{WRAPPER}} ' . $class => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
				),
			)
		);

		$widget->end_controls_section();
	}
	/**
	 * Register Chart dropshadow Controls
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_dropshadow( $widget, string $chart_type = 'chart_id', bool $condition = true ): void {

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_hr_plot_drop_shadow_setting',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_plot_drop_shadow_setting_title',
			array(
				'label' => esc_html__( 'Drop Shadow Settings', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow',
			array(
				'label'     => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => false,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_top',
			array(
				'label'     => esc_html__( 'Drop Shadow Top Position', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_left',
			array(
				'label'     => esc_html__( 'Drop Shadow Left Position', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_blur',
			array(
				'label'     => esc_html__( 'Drop Shadow Blur', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'min'       => 0,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow' => 'yes',
				),
			)
		);

		if ( $condition ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_color',
				array(
					'label'     => esc_html__( 'Drop Shadow Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#000',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow' => 'yes',
					),
				)
			);
		}

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_opacity',
			array(
				'label'     => esc_html__( 'Drop Shadow Opacity', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0.35,
				'max'       => 1,
				'min'       => 0,
				'step'      => 0.05,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow' => 'yes',
				),
			)
		);
	}

	/**
	 * Function to handle chart advance legend section settings for Elementor widgets.
	 *
	 * @param Element_Base $widget The Elementor element instance.
	 * @param string       $type     Type of chart being configured.
	 *
	 * @return void
	 */
	public function graphina_advance_legend_setting( $widget, string $chart_type = 'chart_id' ): void {
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_10',
			array(
				'label' => esc_html__( 'Legend Setting', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show',
			array(
				'label'     => esc_html__( 'Show Legend', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		if ( in_array( $chart_type, array( 'column_google', 'line_google', 'area_google', 'bar_google' ), true ) ) {

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_position',
				array(
					'label'     => esc_html__( 'Legend Position', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'bottom',
					'options'   => graphina_position_type( 'google_chart_legend_position' ),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_color',
				array(
					'label'     => esc_html__( 'Legend Text Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => 'black',
					'options'   => graphina_position_type( 'google_chart_legend_position' ),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_fontsize',
				array(
					'label'     => esc_html__( 'Legend Text Fontsize', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 10,
					'min'       => 1,
					'max'       => 15,
					'options'   => graphina_position_type( 'google_chart_legend_position' ),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);
		}
		if ( in_array( $chart_type, array( 'column_google', 'line_google', 'area_google', 'bar_google', 'pie_google', 'donut_google' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_horizontal_align',
				array(
					'label'     => esc_html__( 'Horizontal Align', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
					'options'   => array(
						'start'  => array(
							'title' => esc_html__( 'Start', 'graphina-charts-for-elementor' ),
							'icon'  => 'fa fa-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'graphina-charts-for-elementor' ),
							'icon'  => 'fa fa-align-center',
						),
						'end'    => array(
							'title' => esc_html__( 'End', 'graphina-charts-for-elementor' ),
							'icon'  => 'fa fa-align-right',
						),
					),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);
		}
		if ( in_array( $chart_type, array( 'pie_google', 'donut_google' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_piechart_legend_position',
				array(
					'label'     => esc_html__( 'Legend Position', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'bottom',
					'options'   => graphina_position_type( 'google_piechart_legend_position' ),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_labeld_value',
				array(
					'label'       => esc_html__( 'Labeled Value Text', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'Value',
					'options'     => array(
						'both' => esc_html__( 'Value And Percentage', 'graphina-charts-for-elementor' ),
					),
					'value'       => esc_html__( 'Value', 'graphina-charts-for-elementor' ),
					'percentages' => esc_html__( 'Percentages', 'graphina-charts-for-elementor' ),
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_google_piechart_legend_position' => 'labeled',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_color',
				array(
					'label'     => esc_html__( 'Legend Text Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => 'black',
					'options'   => graphina_position_type( 'google_piechart_legend_position' ),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_fontsize',
				array(
					'label'     => esc_html__( 'Legend Text Fontsize', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 1,
					'max'       => 15,
					'default'   => 10,
					'options'   => graphina_position_type( 'google_piechart_legend_position' ),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);
		}

		if ( $chart_type === 'geo_google' ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_legend_color',
				array(
					'label'     => esc_html__( 'Legend Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_legend_size',
				array(
					'label'     => esc_html__( 'Legend Size', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 0,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_legend_format',
				array(
					'label'     => esc_html__( 'Number Format', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_legend_bold',
				array(
					'label'     => esc_html__( 'Bold', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_legend_italic',
				array(
					'label'     => esc_html__( 'Italic', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);
		}

		$widget->end_controls_section();
	}

	/**
	 * Register Chart Legend Controls
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_chart_legend_setting( $widget, string $chart_type = 'chart_id' ): void {

		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_7',
			array(
				'label' => esc_html__( 'Legend Setting', 'graphina-charts-for-elementor' ),

			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_legend_show',
			array(
				'label'     => esc_html__( 'Legend', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		if ( in_array( $chart_type, array( 'area', 'column', 'line', 'bar', 'candle', 'bubble', 'polar', 'radar', 'donut', 'pie', 'radial', 'timeline', 'scatter', 'mixed', 'brush', 'distributed_column', 'nested_column' ) ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_legend_position',
				array(
					'label'     => esc_html__( 'Position', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'bottom',
					'options'   => array(
						'top'    => array(
							'title' => esc_html__( 'Top', 'graphina-charts-for-elementor' ),
							'icon'  => 'eicon-arrow-up',
						),
						'right'  => array(
							'title' => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
							'icon'  => 'eicon-arrow-right',
						),
						'bottom' => array(
							'title' => esc_html__( 'Bottom', 'graphina-charts-for-elementor' ),
							'icon'  => 'eicon-arrow-down',
						),
						'left'   => array(
							'title' => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
							'icon'  => 'eicon-arrow-left',
						),
					),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_legend_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_legend_horizontal_align',
				array(
					'label'     => esc_html__( 'Horizontal Align', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
					'options'   => array(
						'left'   => array(
							'title' => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'graphina-charts-for-elementor' ),
							'icon'  => 'eicon-text-align-justify',
						),
						'right'  => array(
							'title' => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_legend_position' => array( 'top', 'bottom' ),
						GRAPHINA_PREFIX . $chart_type . '_chart_legend_show'     => 'yes',
					),
				)
			);
		}

		if ( in_array( $chart_type, array( 'area_google', 'line_google', 'column_google', 'pie_google', 'donut_google','bar_google' ) ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_google_legend_position',
				array(
					'label'     => esc_html__( 'Legend Position', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'bottom',
					'options'   => graphina_position_type( 'google_chart_legend_position' ),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_legend_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_legend_color',
				array(
					'label'     => esc_html__( 'Legend Text Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => 'black',
					'options'   => graphina_position_type( 'google_chart_legend_position' ),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_legend_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_horizontal_align',
				array(
					'label'     => esc_html__( 'Horizontal Align', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
					'options'   => array(
						'start'  => array(
							'title' => esc_html__( 'Start', 'graphina-charts-for-elementor' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'graphina-charts-for-elementor' ),
							'icon'  => 'eicon-text-align-center',
						),
						'end'    => array(
							'title' => esc_html__( 'End', 'graphina-charts-for-elementor' ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_legend_show' => 'yes',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_legend_fontsize',
				array(
					'label'     => esc_html__( 'Legend Text Fontsize', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 10,
					'min'       => 1,
					'max'       => 15,
					'options'   => graphina_position_type( 'google_chart_legend_position' ),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_legend_show' => 'yes',
					),
				)
			);
		}

		$des = '';
		if ( ! in_array( $chart_type, array( 'pie', 'donut', 'polar', 'donut' ), true ) ) {
			$des = esc_html__( 'Note: Only work if tooltip enable', 'graphina-charts-for-elementor' );
		}

		if ( ! in_array( $chart_type, array( 'bubble', 'candle', 'distributed_column', 'radar', 'timeline', 'nested_column', 'scatter', 'area_google', 'column_google', 'bar_google', 'line_google', 'donut_google', 'pie_google'), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_legend_show_series_value',
				array(
					'label'       => esc_html__( 'Show Series Value', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::SWITCHER,
					'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'description' => $des,
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_legend_show' => 'yes',
					),
				)
			);
		}
		if ( $chart_type === 'pie' ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_legend_show_series_postfix',
				array(
					'label'       => esc_html__( 'Show Series PostFix', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::SWITCHER,
					'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'description' => $des,
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_legend_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format' => 'yes',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_legend_show_series_prefix',
				array(
					'label'       => esc_html__( 'Show Series PreFix', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::SWITCHER,
					'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'description' => $des,
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_legend_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format' => 'yes',
					),
				)
			);
		}

		$widget->end_controls_section();
	}
	/**
	 * Summary of graphina_google_chart_legend_setting
	 * @param mixed $widget
	 * @param mixed $chart_type
	 * @return void
	 */
	public function graphina_google_chart_legend_setting( $widget, $chart_type ) {
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_10',
			array(
				'label' => esc_html__( 'Legend Setting', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show',
			array(
				'label'     => esc_html__( 'Show Legend', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		if ( in_array( $chart_type, array( 'column_google', 'line_google', 'area_google', 'bar_google' ), true ) ) {

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_position',
				array(
					'label'     => esc_html__( 'Legend Position', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'bottom',
					'options'   => graphina_position_type( 'google_chart_legend_position' ),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_color',
				array(
					'label'     => esc_html__( 'Legend Text Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => 'black',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_fontsize',
				array(
					'label'     => esc_html__( 'Legend Text Fontsize', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 10,
					'min'       => 1,
					'max'       => 15,
					'options'   => graphina_position_type( 'google_chart_legend_position' ),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);
		}
		if ( in_array( $chart_type, array( 'column_google', 'line_google', 'area_google', 'bar_google', 'pie_google', 'donut_google' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_horizontal_align',
				array(
					'label'     => esc_html__( 'Horizontal Align', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
					'options'   => array(
						'start'  => array(
							'title' => esc_html__( 'Start', 'graphina-charts-for-elementor' ),
							'icon'  => 'fa fa-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'graphina-charts-for-elementor' ),
							'icon'  => 'fa fa-align-center',
						),
						'end'    => array(
							'title' => esc_html__( 'End', 'graphina-charts-for-elementor' ),
							'icon'  => 'fa fa-align-right',
						),
					),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);
		}
		if ( in_array( $chart_type, array( 'pie_google', 'donut_google' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_piechart_legend_position',
				array(
					'label'     => esc_html__( 'Legend Position', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'bottom',
					'options'   => graphina_position_type( 'google_piechart_legend_position' ),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_labeld_value',
				array(
					'label'       => esc_html__( 'Labeled Value Text', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'Value',
					'options'     => array(
						'both' => esc_html__( 'Value And Percentage', 'graphina-charts-for-elementor' ),
					),
					'value'       => esc_html__( 'Value', 'graphina-charts-for-elementor' ),
					'percentages' => esc_html__( 'Percentages', 'graphina-charts-for-elementor' ),
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_google_piechart_legend_position' => 'labeled',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_color',
				array(
					'label'     => esc_html__( 'Legend Text Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => 'black',
					'options'   => graphina_position_type( 'google_piechart_legend_position' ),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_fontsize',
				array(
					'label'     => esc_html__( 'Legend Text Fontsize', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 1,
					'max'       => 15,
					'default'   => 10,
					'options'   => graphina_position_type( 'google_piechart_legend_position' ),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);
		}

		if ( $chart_type === 'geo_google' ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_legend_color',
				array(
					'label'     => esc_html__( 'Legend Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_legend_size',
				array(
					'label'     => esc_html__( 'Legend Size', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 0,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_legend_format',
				array(
					'label'     => esc_html__( 'Number Format', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_legend_bold',
				array(
					'label'     => esc_html__( 'Bold', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_google_legend_italic',
				array(
					'label'     => esc_html__( 'Italic', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' => 'yes',
					),
				)
			);
		}

		$widget->end_controls_section();
	}

	/**
	 * Register Chart X-Axis Controls
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_chart_x_axis_setting( $widget, string $chart_type = 'chart_id', bool $show_fixed = true, bool $show_tooltip = true ): void {
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_axis_settings',
			array(
				'label' => esc_html__( 'Axis Setting', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_x_axis_settings_heading',
			array(
				'label' => esc_html__( 'X-Axis Setting', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		if ( in_array( $chart_type, array( 'column', 'distributed_column' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_enable_min_max',
				array(
					'label'       => esc_html__( 'Enable Min/Max', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::SWITCHER,
					'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'     => false,
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_is_chart_horizontal' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_stack_type'    => 'normal',
					),
					'description' => esc_html__( 'Note: If chart having multi series, Enable Min/Max value will be applicable to all series and xaxis Tickamount must be according to min - max value', 'graphina-charts-for-elementor' ),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_min_value',
				array(
					'label'       => esc_html__( 'Min Value', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => 0,
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_enable_min_max' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_is_chart_horizontal' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_stack_type'    => 'normal',
					),
					'description' => esc_html__( 'Note: Lowest number to be set for the x-axis. The graph drawing beyond this number will be clipped off', 'graphina-charts-for-elementor' ),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_max_value',
				array(
					'label'       => esc_html__( 'Max Value', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => 250,
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_enable_min_max' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_is_chart_horizontal' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_stack_type'    => 'normal',
					),
					'description' => esc_html__( 'Note: Highest number to be set for the x-axis. The graph drawing beyond this number will be clipped off.', 'graphina-charts-for-elementor' ),
				)
			);
		}
		if( ! in_array( $chart_type,[ 'timeline', 'bubble' ] ) ){
			if ( $show_tooltip ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_tooltip_show',
					array(
						'label'     => esc_html__( 'Tooltip', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'default'   => '',
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_crosshairs_show',
					array(
						'label'     => esc_html__( 'Pointer Line', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'default'   => '',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_tooltip_show' => 'yes',
						),
					)
				);
			}
		}

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show',
			array(
				'label'     => esc_html__( 'Labels', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_position',
			array(
				'label'     => esc_html__( 'Position', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'bottom',
				'options'   => array(
					'top'    => array(
						'title' => esc_html__( 'Top', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-arrow-up',
					),
					'bottom' => array(
						'title' => esc_html__( 'Bottom', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-arrow-down',
					),
				),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_auto_rotate',
			array(
				'label'     => esc_html__( 'Labels Auto Rotate', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'False', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'True', 'graphina-charts-for-elementor' ),
				'default'   => false,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_rotate',
			array(
				'label'     => esc_html__( 'Rotate', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => -45,
				'max'       => 360,
				'min'       => -360,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_auto_rotate' => 'yes',
					GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_offset_x',
			array(
				'label'     => esc_html__( 'Offset-X', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_offset_y',
			array(
				'label'     => esc_html__( 'Offset-Y', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' => 'yes',
				),
			)
		);

		if ( $chart_type === 'brush' ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_tick_amount_dataPoints',
				array(
					'label'     => esc_html__( 'Tick Amount(dataPoints)', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'False', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'True', 'graphina-charts-for-elementor' ),
					'default'   => 'yes',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' => 'yes',
					),
				)
			);
		}

		if ( ! in_array( $chart_type, array( 'brush', 'candle', 'timeline' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_tick_amount',
				array(
					'label'     => esc_html__( 'Tick Amount', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 6,
					'max'       => 30,
					'min'       => 0,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' => 'yes',
					),
				)
			);
		}
		if ( ! in_array( $chart_type, array( 'brush', 'candle', 'timeline', 'heatmap' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_tick_placement',
				array(
					'label'     => esc_html__( 'Tick Placement', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => graphina_position_type( 'placement', true ),
					'options'   => graphina_position_type( 'placement' ),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' => 'yes',
					),
				)
			);
		}

		if ( in_array( $chart_type, array( 'timeline', 'candle' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_show_time',
				array(
					'label'     => esc_html__( 'Show Time In xaxis', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => 'yes',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_show_date',
				array(
					'label'     => esc_html__( 'Show Date In xaxis', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => false,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' => 'yes',
					),
				)
			);
		}
		if ( $show_fixed && ! in_array( $chart_type, array( 'timeline' ) ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_show',
				array(
					'label'       => esc_html__( 'Labels Prefix/Postfix', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::SWITCHER,
					'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'     => false,
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' => 'yes',
					),
					'description' => esc_html__( 'Note: If categories data are in array form it won\'t work', 'graphina-charts-for-elementor' ),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_prefix',
				array(
					'label'     => esc_html__( 'Labels Prefix', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' => 'yes',
					),
					'dynamic'   => array(
						'active' => true,
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_postfix',
				array(
					'label'     => esc_html__( 'Labels Postfix', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' => 'yes',
					),
					'dynamic'   => array(
						'active' => true,
					),
				)
			);
		}

		if ( in_array( $chart_type, array( 'column', 'distributed_column' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_prefix_postfix_decimal_point',
				array(
					'label'     => esc_html__( 'Decimals In Float', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 0,
					'max'       => 6,
					'min'       => 0,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_is_chart_horizontal' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_pointer!' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_number_format!' => 'yes',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_pointer',
				array(
					'label'       => esc_html__( 'Format Number to String', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::SWITCHER,
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_is_chart_horizontal' => 'yes',
					),
					'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'     => false,
					'description' => esc_html__( 'Note: Convert 1,000  => 1k and 1,000,000 => 1m and if Format Number(Commas) is enable this will not work', 'graphina-charts-for-elementor' ),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_pointer_number',
				array(
					'label'     => esc_html__( 'Number of Decimal Want', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 0,
					'min'       => 0,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_pointer' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_is_chart_horizontal' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_show' => 'yes',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_format_number',
				array(
					'label'       => esc_html__( 'Format Number', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::SWITCHER,
					'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'     => 'no',
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_is_chart_horizontal' => 'yes',
					),
					'description' => esc_html__( 'Enabled Labels Prefix/Postfix ', 'graphina-charts-for-elementor' ),
				)
			);
		}
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title_enable',
			array(
				'label'     => esc_html__( 'Enable Title', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'no',
			)
		);
		if ( ! in_array( $chart_type, array( 'distributed_column', 'mixed' ) ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title_offset_x',
				array(
					'label'     => esc_html__( 'Title offset X', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 0,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title_enable' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title_offset_y',
				array(
					'label'     => esc_html__( 'Title offset Y', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 0,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title_enable' => 'yes',
					),
				)
			);
		}

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title',
			array(
				'label'     => esc_html__( 'Xaxis Title', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title_enable' => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);
	}

	/**
	 * Register Google Chart X-Axis Controls
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_advance_h_axis_setting( $widget, string $chart_type = 'chart_id' ): void {
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_google_axis_settings',
			array(
				'label' => esc_html__( 'Axis Setting', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_h_axis_heading',
			array(
				'label' => esc_html__( 'X-Axis Settings', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		if ( in_array( $chart_type, array( 'column_google', 'line_google', 'area_google', 'bar_google' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_label_settings',
				array(
					'label' => esc_html__( 'Label Setting', 'graphina-charts-for-elementor' ),
					'type'  => Controls_Manager::HEADING,
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_position_show',
				array(
					'label'   => esc_html__( 'Label Show', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::SWITCHER,
					'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'false'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default' => 'yes',
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_position',
				array(
					'label'     => esc_html__( 'Label Position', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'out',
					'options'   => graphina_position_type( 'in_out' ),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_position_show' => 'yes',
					),
				)
			);
			if ( in_array( $chart_type, array( 'column_google', 'line_google', 'area_google' ), true ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_prefix_postfix',
					array(
						'label'     => esc_html__( 'Label Prefix/Postfix', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'true'      => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
						'false'     => esc_html__( 'No', 'graphina-charts-for-elementor' ),
						'default'   => '',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_position_show' => 'yes',
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_prefix',
					array(
						'label'     => esc_html__( 'Prefix', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::TEXT,
						'default'   => '',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_position_show' => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_prefix_postfix' => 'yes',
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_postfix',
					array(
						'label'     => esc_html__( 'Postfix', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::TEXT,
						'default'   => '',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_position_show' => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_prefix_postfix' => 'yes',
						),
					)
				);
			}
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_font_color',
				array(
					'label'     => esc_html__( 'Label Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#000000',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_position_show' => 'yes',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_font_size',
				array(
					'label'     => esc_html__( ' Label Fontsize', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 5,
					'max'       => 25,
					'default'   => 11,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_position_show' => 'yes',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_rotate',
				array(
					'label'     => esc_html__( 'Label Rotate', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'true'      => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'false'     => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'   => false,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_position_show' => 'yes',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_rotate_value',
				array(
					'label'     => esc_html__( 'Label Rotate Angle', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 50,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_rotate' => 'yes',
					),
					'description' => esc_html__( 'Label rotation works only when position is set to "out".', 'graphina-charts-for-elementor' ),
				)
			);
		}
		if ( in_array( $chart_type, array( 'column_google', 'line_google', 'area_google', 'geo_google' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_haxis_direction',
				array(
					'label'     => esc_html__( 'Reverse Category', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'true'      => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'false'     => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'   => 'false',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_position_show' => 'yes',
					),
				)
			);
		}

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_axis_Title_heading',
			array(
				'label' => esc_html__( 'Title Setting', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_haxis_title_show',
			array(
				'label'   => esc_html__( 'Title Show', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'false'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default' => 'false',
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_haxis_title',
			array(
				'label'     => esc_html__( 'Title', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Title',
				'dynamic'   => array(
					'active' => true,
				),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_haxis_title_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_haxis_title_font_color',
			array(
				'label'     => esc_html__( 'Title Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_haxis_title_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_haxis_title_font_size',
			array(
				'label'     => esc_html__( ' Title Fontsize', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 25,
				'default'   => 12,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_haxis_title_show' => 'yes',
				),
			)
		);
	}

	/**
	 * Register Google Chart Y-Axis Controls
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_advance_v_axis_setting( $widget, string $chart_type = 'chart_id' ): void {
		// Divider
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_setting_divider',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_v_axis_settings_heading',
			array(
				'label' => esc_html__( 'Y-Axis Setting', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		if ( in_array( $chart_type, array( 'column_google', 'bar_google', 'line_google', 'area_google' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_enable_minmax',
				array(
					'label'   => esc_html__( 'Enable Min/Max', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::SWITCHER,
					'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'false'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default' => 'false',
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_minvalue',
				array(
					'label'     => esc_html__( 'Y-axis Min Value', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 0,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_enable_minmax' => 'yes',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_maxvalue',
				array(
					'label'     => esc_html__( 'Y-axis Max Value', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 250,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_enable_minmax' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_Label_Settings',
				array(
					'label' => esc_html__( 'Label Setting', 'graphina-charts-for-elementor' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_label_position_show',
				array(
					'label'   => esc_html__( 'Label Show', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::SWITCHER,
					'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'false'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default' => 'yes',
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_label_position',
				array(
					'label'     => esc_html__( 'Label Position', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'out',
					'options'   => graphina_position_type( 'in_out' ),
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_label_position_show' => 'yes',
					),
				)
			);
			if ( $chart_type === 'bar_google' ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_prefix_postfix',
					array(
						'label'     => esc_html__( 'Label Prefix/Postfix', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'true'      => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
						'false'     => esc_html__( 'No', 'graphina-charts-for-elementor' ),
						'default'   => '',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_position_show' => 'yes',
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_prefix',
					array(
						'label'     => esc_html__( 'Prefix', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::TEXT,
						'default'   => '',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_position_show' => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_prefix_postfix' => 'yes',
						),
					)
				);
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_postfix',
					array(
						'label'     => esc_html__( 'Postfix', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::TEXT,
						'default'   => '',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_position_show' => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_prefix_postfix' => 'yes',
						),
					)
				);
			}

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_font_color',
				array(
					'label'     => esc_html__( 'Label Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#000000',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_label_position_show' => 'yes',
					),
				)
			);
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_font_size',
				array(
					'label'     => esc_html__( ' Label Fontsize', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 3,
					'max'       => 18,
					'default'   => 11,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_label_position_show' => 'yes',
					),
				)
			);
		}
		if ( in_array( $chart_type, array( 'column_google', 'line_google', 'area_google' ), true ) ) {

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_direction',
				array(
					'label'   => esc_html__( 'Reverse Direction', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::SWITCHER,
					'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'false'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default' => 'false',
				)
			);
		}
		if ( $chart_type === 'bar_google' ) {

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_haxis_direction',
				array(
					'label'   => esc_html__( 'Reverse Direction', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::SWITCHER,
					'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'false'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default' => 'false',
				)
			);
		}
		if ( $chart_type === 'bar_google' ) {

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_direction',
				array(
					'label'   => esc_html__( 'Reverse Category', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::SWITCHER,
					'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'false'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default' => 'false',
				)
			);
		}
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_format',
			array(
				'label'   => esc_html__( 'Number Format', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'decimal',
				'options' => array(
					'decimal'    => esc_html__( 'Decimal', 'graphina-charts-for-elementor' ),
					'scientific' => esc_html__( 'Scientific', 'graphina-charts-for-elementor' ),
					'\#'         => esc_html__( 'Currency', 'graphina-charts-for-elementor' ),
					"percent"    => esc_html__( 'Percent', 'graphina-charts-for-elementor' ),
					'short'      => esc_html__( 'Short', 'graphina-charts-for-elementor' ),
					'long'       => esc_html__( 'Long', 'graphina-charts-for-elementor' ),

				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_format_currency_prefix',
			array(
				'label'     => esc_html__( 'Currency Prefix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '$',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_format' => '\#',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_Title_heading',
			array(
				'label' => esc_html__( 'Title Setting', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_title_show',
			array(
				'label'   => esc_html__( 'Title Show', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'false'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default' => 'false',
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_title',
			array(
				'label'     => esc_html__( 'Title', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Title',
				'dynamic'   => array(
					'active' => true,
				),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_title_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_title_font_color',
			array(
				'label'     => esc_html__( 'Title Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_title_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_title_font_size',
			array(
				'label'     => esc_html__( ' Title Fontsize', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 25,
				'default'   => 12,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_title_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_gridline_setting',
			array(
				'label' => esc_html__( 'Gridline Setting', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_gridline_count_show',
			array(
				'label'   => esc_html__( 'Line Show', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'false'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default' => 'yes',
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_gridline_count',
			array(
				'label'       => esc_html__( 'Gridline Count', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 5,
				'description' => esc_html__( 'Note: This setting only works when Logarithmic Axis is disabled.', 'graphina-charts-for-elementor' ),
				'condition'   => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_gridline_count_show' => 'yes',
				),

			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_gridline_color',
			array(
				'label'     => esc_html__( 'Gridline color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cccccc',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_gridline_count_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_baseline_Color',
			array(
				'label'   => esc_html__( 'Zero Indicator', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#cccccc',

			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_logscale_setting_title',
			array(
				'label'     => esc_html__( 'Log Scale Settings', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_gridline_count_show' => 'yes',
				),
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_logscale_show',
			array(
				'label'     => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'true'      => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'false'     => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => 'fasle',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_gridline_count_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_scaletype',
			array(
				'label'     => esc_html__( 'Scale Type', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'log',
				'options'   => array(
					'log'       => esc_html__( 'Log', 'graphina-charts-for-elementor' ),
					'mirrorLog' => esc_html__( 'MirrorLog', 'graphina-charts-for-elementor' ),

				),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_logscale_show' => 'yes',
					GRAPHINA_PREFIX . $chart_type . '_chart_gridline_count_show' => 'yes',
				),
			)
		);

		$widget->end_controls_section();
	}
	/**
	 * Summary of graphina_advance_x_axis_setting
	 * @param mixed $widget
	 * @param mixed $chart_type
	 * @return void
	 */
	public function graphina_advance_x_axis_setting( $widget, $chart_type ) {
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_5',
			array(
				'label' => esc_html__( 'Advance X-Axis Setting', 'graphina-charts-for-elementor' ),

			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show',
			array(
				'label'     => esc_html__( 'Labels', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$widget->end_controls_section();
	}
	/**
	 * Summary of graphina_advcance_y_axis_setting
     * @param mixed $widget
     * @param mixed $chart_type
     * @return void
	 */
	public function graphina_advcance_y_axis_setting( $widget, $chart_type ) {
		$widget->start_controls_section(
			GRAPHINA_PREFIX . $chart_type . '_section_6',
			array(
				'label' => esc_html__( 'Advance Y-Axis Setting', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_enable_min_max',
			array(
				'label'       => esc_html__( 'Enable Min/Max', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'     => false,
				'description' => esc_html__( 'Note: If chart having multi series, Enable Min/Max value will be applicable to all series and Yaxis Tickamount must be according to min - max value', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_min_value',
			array(
				'label'       => esc_html__( 'Min Value', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 0,
				'condition'   => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_enable_min_max' => 'yes',
				),
				'description' => esc_html__( 'Note: Lowest number to be set for the y-axis. The graph drawing beyond this number will be clipped off', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_max_value',
			array(
				'label'       => esc_html__( 'Max Value', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 250,
				'condition'   => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_enable_min_max' => 'yes',
				),
				'description' => esc_html__( 'Note: Highest number to be set for the y-axis. The graph drawing beyond this number will be clipped off.', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_responsive_control (
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show',
			array(
				'label'     => esc_html__( 'Labels', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_tick_amount',
			array(
				'label'     => esc_html__( 'Tick Amount', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 6,
				'max'       => 30,
				'min'       => 0,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_format',
			array(
				'label'     => esc_html__( 'Format', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_yaxis_chart_number_format_commas',
			array(
				'label'     => esc_html__( 'Format Number(Commas)', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_format' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_format_prefix',
			array(
				'label'     => esc_html__( 'Label Prefix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_format' => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_format_postfix',
			array(
				'label'     => esc_html__( 'Label Postfix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_format' => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_prefix_postfix_decimal_point',
			array(
				'label'     => esc_html__( 'Decimals In Float', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'max'       => 6,
				'min'       => 0,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_format' => 'yes',
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_pointer!' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_pointer',
			array(
				'label'       => esc_html__( 'Format Number to String', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition'   => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_format' => 'yes',
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
				),
				'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'     => false,
				'description' => esc_html__( 'Note: Convert 1,000  => 1k and 1,000,000 => 1m', 'graphina-charts-for-elementor' ),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_pointer_number',
			array(
				'label'     => esc_html__( 'Number of Decimal Want', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'max'       => 6,
				'min'       => 0,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_pointer' => 'yes',
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_format' => 'yes',
				),
			)
		);

		$widget->end_controls_section();
	}

	/**
	 * Register Chart Y-Axis Controls
	 *
	 * Adds a standardized set of controls to a given widget, based on
	 * the specified chart type. These controls allow users to configure
	 *
	 * @param \Elementor\Widget_Base $widget The widget instance to which controls are added.
	 * @param string                 $chart_type The type of chart for which controls are being registered.
	 */
	public function graphina_chart_y_axis_setting( $widget, string $chart_type = 'chart_id', bool $show_fixed = true, bool $show_tooltip = true ): void {

		// Divider
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_axis_setting_divider',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_y_axis_settings_heading',
			array(
				'label' => esc_html__( 'Y-Axis Setting', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		if ( in_array( $chart_type, array( 'line', 'area', 'column', 'mixed', 'distributed_column','candle' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_enable_min_max',
				array(
					'label'       => esc_html__( 'Enable Min/Max', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::SWITCHER,
					'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'     => false,
					'description' => esc_html__( 'Note: If chart having multi series, Enable Min/Max value will be applicable to all series and Yaxis Tickamount must be according to min - max value', 'graphina-charts-for-elementor' ),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_min_value',
				array(
					'label'       => esc_html__( 'Min Value', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => 0,
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_enable_min_max' => 'yes',
					),
					'description' => esc_html__( 'Note: Lowest number to be set for the y-axis. The graph drawing beyond this number will be clipped off', 'graphina-charts-for-elementor' ),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_max_value',
				array(
					'label'       => esc_html__( 'Max Value', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => 250,
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_enable_min_max' => 'yes',
					),
					'description' => esc_html__( 'Note: Highest number to be set for the y-axis. The graph drawing beyond this number will be clipped off.', 'graphina-charts-for-elementor' ),
				)
			);
		}

		if ( ! in_array( $chart_type, array( 'heatmap', 'polar' ) ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_line_show',
				array(
					'label'     => esc_html__( 'Line', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => 'yes',
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_line_grid_color',
				array(
					'label'     => esc_html__( 'Grid Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#90A4AE',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_line_show' => 'yes',
					),
				)
			);
		}

		if ( in_array( $chart_type, array( 'line', 'area', 'column', 'bubble', 'candle', 'distributed_column', 'scatter' ), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_show',
				array(
					'label'     => esc_html__( 'Zero Indicator', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => false,
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_stroke_dash',
				array(
					'label'     => esc_html__( 'Stroke Dash', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 6,
					'min'       => 0,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_show' => 'yes',
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_stroke_color',
				array(
					'label'     => esc_html__( 'Stroke Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#000000',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_show' => 'yes',
					),
				)
			);
		}
		if($chart_type !== 'timeline'){

			if ( $show_tooltip ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_tooltip_show',
					array(
						'label'     => esc_html__( 'Tooltip', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'default'   => '',
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_crosshairs_show',
					array(
						'label'     => esc_html__( 'Pointer Line', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'default'   => '',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_tooltip_show' => 'yes',
						),
					)
				);
			}
		}

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show',
			array(
				'label'     => esc_html__( 'Labels', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_position',
			array(
				'label'     => esc_html__( 'Position', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => graphina_position_type( 'horizontal_boolean', true ),
				'options'   => graphina_position_type( 'horizontal_boolean' ),
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_offset_x',
			array(
				'label'     => esc_html__( 'Offset-X', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_offset_y',
			array(
				'label'     => esc_html__( 'Offset-Y', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
				),
			)
		);
		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_rotate',
			array(
				'label'     => esc_html__( 'Rotate', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'max'       => 360,
				'min'       => -360,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
				),
			)
		);
		if ( in_array( $chart_type,[ 'mixed', 'heatmap' ] ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_rotate',
				array(
					'label'     => esc_html__( 'Rotate', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 0,
					'max'       => 360,
					'min'       => -360,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_show_multiple_yaxis!' => 'yes',
					),
				)
			);
		}

		$title_brush_chart = $chart_type === 'brush' ? esc_html__( 'Chart-1', 'graphina-charts-for-elementor' ) : '';

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_tick_amount',
			array(
				'label'       => $title_brush_chart . esc_html__( ' Tick Amount', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 6,
				'max'         => 30,
				'min'         => 0,
				'condition'   => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
				),
				'description' => esc_html__( 'If this would not have any effect, enable "min max", ', 'graphina-charts-for-elementor' ),

			)
		);

		if ( $chart_type === 'brush' ) {

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_tick_amount_2',
				array(
					'label'     => esc_html__( 'Chart-2 Tick Amount', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 0,
					'max'       => 30,
					'min'       => 0,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
					),
				)
			);
		}
		
		if ( ! in_array( $chart_type, array( 'timeline' ) ) ) {
			if ( $show_fixed ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_show',
					array(
						'label'     => esc_html__( 'Labels Prefix/Postfix', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'default'   => false,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_prefix',
					array(
						'label'     => esc_html__( 'Labels Prefix', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::TEXT,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_show' => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
						),
						'dynamic'   => array(
							'active' => true,
						),
					)
				);

				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_postfix',
					array(
						'label'     => esc_html__( 'Labels Postfix', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::TEXT,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_show' => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
						),
						'dynamic'   => array(
							'active' => true,
						),
					)
				);
			}

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_pointer_number',
				array(
					'label'     => esc_html__( 'Number of Decimal Want', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 0,
					'min'       => 0,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_pointer' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_show' => 'yes',

					),
				)
			);
			if ( in_array( $chart_type, array( 'column', 'line', 'area', 'bubble', 'distributed_column', 'scatter', 'brush' ), true ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_number_format',
					array(
						'label'     => esc_html__( 'Enable Number Formatting', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',

						),
						'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
						'default'   => 'yes',
					)
				);
			}
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_pointer',
				array(
					'label'       => esc_html__( 'Format Number to Strings', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::SWITCHER,
					'condition'   => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_number_format' => 'yes',
					),
					'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'     => false,
					'description' => esc_html__( 'Note: Convert 1,000 to 1k and 1,000,000 to 1m. You can also set the number of decimal places for the number-to-string conversion, and enable label prefix or postfix if needed.', 'graphina-charts-for-elementor' ),
				)
			);
		}

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_decimals_in_float',
			array(
				'label'     => esc_html__( 'Decimals In Float', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => apply_filters('graphina_default_decimals_float_value', 2),
				'max'       => 6,
				'min'       => 0,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' => 'yes',
				),
				'description' => ( isset( $chart_type ) && $chart_type !== 'mixed' ) ? esc_html__( 'Note: Not work when Format Number to Strings enable', 'graphina-charts-for-elementor' ): '',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title_enable',
			array(
				'label'     => esc_html__( 'Enable Title', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'no',
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title',
			array(
				'label'     => esc_html__( 'Y-axis Title', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title_enable' => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$widget->add_control(
			GRAPHINA_PREFIX . $chart_type . '_card_yaxis_title_font_color',
			array(
				'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'condition' => array(
					GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title_enable' => 'yes',
				),
			)
		);

		if ( in_array( $chart_type, array( 'line', 'area', 'column', 'candle', 'heatmap', 'bubble', 'brush', 'scatter', 'mixed'), true ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_hr_opposite_yaxis',
				array(
					'type'      => Controls_Manager::DIVIDER,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count!' => 1,
					),
				)
			);

			if ( 'column' === $chart_type ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title_enable',
					array(
						'label'     => esc_html__( 'Enable Opposite Title', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'default'   => 'no',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count!' => 1,
							GRAPHINA_PREFIX . $chart_type . '_is_chart_horizontal!' => 'yes',
						),
					)
				);
			}else{
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title_enable',
					array(
						'label'     => esc_html__( 'Enable Opposite Title', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'default'   => 'no',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count!' => 1,
						),
					)
				);
			}

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_tick_amount',
				array(
					'label'     => esc_html__( 'Tick Amount', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 0,
					'max'       => 30,
					'min'       => 0,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title_enable' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count!' => 1,
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_label_show',
				array(
					'label'     => esc_html__( 'Show Label', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => false,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title_enable' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count!' => 1,
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_label_prefix',
				array(
					'label'     => esc_html__( 'Labels Prefix', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_label_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count!' => 1,
					),
					'dynamic'   => array(
						'active' => true,
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_label_postfix',
				array(
					'label'     => esc_html__( 'Labels Postfix', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_label_show' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count!' => 1,
					),
					'dynamic'   => array(
						'active' => true,
					),
				)
			);

			if ( in_array( $chart_type, array( 'area', 'column', 'bubble', 'line', 'scatter' ), true ) ) {
				$widget->add_control(
					GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_format_number',
					array(
						'label'     => esc_html__( 'Format Number', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'default'   => 'no',
						'condition' => array(
							GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title_enable' => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_label_show' => 'yes',
							GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count!' => 1,
						),
					)
				);
				if ( $chart_type === 'column' ) {
					$widget->add_control(
						GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_max_width',
						array(
							'label'   => esc_html__( 'Max Width', 'graphina-charts-for-elementor' ),
							'type'    => Controls_Manager::NUMBER,
							'default' => 'auto',
						)
					);
				}
			}

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title',
				array(
					'label'     => esc_html__( 'Opposite Y-axis Title', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title_enable' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count!' => 1,
					),
					'dynamic'   => array(
						'active' => true,
					),
				)
			);

			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_card_opposite_yaxis_title_font_color',
				array(
					'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#000000',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title_enable' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count!' => 1,
					),
				)
			);
		}

		if ( in_array( $chart_type, array( 'mixed' ) ) ) {
			$widget->add_control(
				GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_format_number',
				array(
					'label'     => esc_html__( 'Format Number', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => 'no',
					'condition' => array(
						GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title_enable' => 'yes',
						GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count!' => 1,
					),
				)
			);
		}

		$widget->end_controls_section();
	}

	/**
	 * Summary of graphina_element_data_enter_options
	 * @param mixed $chart_type
	 * @param mixed $first
	 * @param mixed $keys
	 * @param mixed $widgetType
	 */
	protected function graphina_element_data_enter_options( $chart_type = '', $first = false, $keys = false, $widgetType = 'advance-datatable' ) {

		switch ( $chart_type ) {
			case 'counter':
				$options = array(
					'csv'          => esc_html__( 'CSV', 'graphina-charts-for-elementor' ),
					'remote-csv'   => esc_html__( 'Remote CSV', 'graphina-charts-for-elementor' ),
					'google-sheet' => esc_html__( 'Google Sheet', 'graphina-charts-for-elementor' ),
					'api'          => esc_html__( 'API', 'graphina-charts-for-elementor' ),
					'database'     => esc_html__( 'Database', 'graphina-charts-for-elementor' ),
				);
				if ( graphina_pro_active() ) {
					$options['filter'] = esc_html__( 'Data From Filter', 'graphina-charts-for-elementor' );
				}
				break;
			case 'graphina_counter_operations':
				$options = array(
					''           => esc_html__( 'None', 'graphina-charts-for-elementor' ),
					'sum'        => esc_html__( 'Sum', 'graphina-charts-for-elementor' ),
					'avg'        => esc_html__( 'Average', 'graphina-charts-for-elementor' ),
					'percentage' => esc_html__( 'Percentage', 'graphina-charts-for-elementor' ),
				);
				break;
			case 'index_type':
				$options = array(
					'number' => esc_html__( 'Number', 'graphina-charts-for-elementor' ),
					'roman'  => esc_html__( 'Roman Number', 'graphina-charts-for-elementor' ),
				);
				break;
			case 'counter_layout':
				$options = array(
					'layout_1' => esc_html__( 'Layout 1', 'graphina-charts-for-elementor' ),
					'layout_2' => esc_html__( 'Layout 2', 'graphina-charts-for-elementor' ),
					'layout_3' => esc_html__( 'Layout 3', 'graphina-charts-for-elementor' ),
					'layout_4' => esc_html__( 'Layout 4', 'graphina-charts-for-elementor' ),
					'layout_5' => esc_html__( 'Layout 5', 'graphina-charts-for-elementor' ),
					'layout_6' => esc_html__( 'Layout 6', 'graphina-charts-for-elementor' ),
				);
				break;
			default:
				$options = array(
					'csv'          => esc_html__( 'CSV', 'graphina-charts-for-elementor' ),
					'remote-csv'   => esc_html__( 'Remote CSV', 'graphina-charts-for-elementor' ),
					'google-sheet' => esc_html__( 'Google Sheet', 'graphina-charts-for-elementor' ),
					'database'     => esc_html__( 'Database', 'graphina-charts-for-elementor' ),
					'api'          => esc_html__( 'API', 'graphina-charts-for-elementor' ),
				);
				if ( graphina_pro_active() ) {
					$options['filter'] = esc_html__( 'Data From Filter', 'graphina-charts-for-elementor' );
				}
				break;

		}
		if ( $first ) {
			return array_keys( $options )[0];
		}
		if ( $keys ) {
			return array_keys( $options );
		}
		return $options;
	}
}
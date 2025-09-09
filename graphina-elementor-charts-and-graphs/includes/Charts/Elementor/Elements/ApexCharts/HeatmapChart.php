<?php

namespace Graphina\Elementor\Widget;

use Elementor\Plugin;
use Graphina\Charts\Elementor\GraphinaApexChartBase;
use Graphina\Charts\Elementor\GraphinaElementorControls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly to ensure security.
}

/**
 * HeatmapChart Class
 *
 * This class defines the Area Chart widget for the Graphina plugin, integrating
 * with Elementor to provide a customizable Area Chart based on ApexCharts.
 *
 * Product: Graphina - Elementor Charts and Graphs
 * Purpose: To allow users to create dynamic and interactive Area Charts.
 */
class HeatmapChart extends GraphinaApexChartBase {

	/**
	 * Get Widget Name
	 *
	 * Returns the unique identifier for the widget.
	 *
	 * @return string Widget name used internally.
	 */
	public function get_name() {
		return 'heatmap_chart';
	}

	/**
	 * Get Widget Title
	 *
	 * Returns the display name of the widget shown in Elementor.
	 *
	 * @return string Translatable widget title.
	 */
	public function get_title() {
		return __( 'Heatmap', 'graphina-charts-for-elementor' );
	}

	/**
	 * Get Widget Icon
	 *
	 * Returns the icon class for the widget shown in Elementor's widget panel.
	 *
	 * @return string Icon CSS class.
	 */
	public function get_icon() {
		return 'graphina-apex-heatmap-chart';
	}

	/**
	 * Get Chart Type
	 *
	 * Defines the type of chart this widget represents. In this case, 'area'.
	 *
	 * @return string Chart type identifier.
	 */
	public function get_chart_type(): string {
		return 'heatmap';
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
		return array( 'heatmap-chart' );
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
		return array( 'area-chart' );
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
		$controls->graphina_chart_dataset( $this, $chart_type );
		$controls->graphina_chart_data_series( $this, $chart_type, 0 );
		$controls->graphina_common_chart_setting( $this, $chart_type, false, true, false );
		$controls->graphina_series_setting( $this, $chart_type, array( 'color' ), true, array( 'classic' ), false, false );
		$controls->graphina_chart_x_axis_setting( $this, $chart_type );
		$controls->graphina_chart_y_axis_setting( $this, $chart_type );
		$controls->register_chart_restriction_controls( $this, $chart_type );
		$controls->graphina_chart_legend_setting( $this, $chart_type );
		apply_filters( 'graphina_password_form_style_section', $this, $chart_type );
	}

	/**
	 * Get common options
	 *
	 * @return array
	 */
	protected function graphina_prepare_chart_common_options($settings, $chart_type, $element_id)
	{
		$series_temp      = array();
		$series_count     = $settings[GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count'] ?? 0;
		$gradient         = '';

		$marker_size = $marker_stroke_color = $stroke_widths = $strock_dash_array = $categories = $marker_size = $gradient_new = $tooltip_series = $marker_stoke_width = $marker_shape = $second_gradient = $fill_pattern = $gradient = array();
		// Prepare series data
		for ($i = 0; $i < $series_count; $i++) {
			$colors[]      = ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_gradient_1_' . $i]) ? strval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_gradient_1_' . $i]) : '';
			if('manual' === $settings[GRAPHINA_PREFIX . $chart_type . '_chart_data_option']){
				$value_list    = $settings[GRAPHINA_PREFIX . $chart_type . '_value_list_3_1_' . $i] ?? array();
				$values        = array_map(
					fn($v) => (float) graphina_get_dynamic_tag_data($v, GRAPHINA_PREFIX . $chart_type . '_chart_value_3_' . $i),
					$value_list
				);
				$series_temp[] = array(
					'name'  => wp_kses(htmlspecialchars_decode(graphina_get_dynamic_tag_data($settings, GRAPHINA_PREFIX . $chart_type . '_chart_title_3_' . $i)),graphina_allowed_html_tags()),
					'data'  => $values,
					'yaxis' => graphina_get_dynamic_tag_data($settings, GRAPHINA_PREFIX . $chart_type . '_chart_depends_3_' . $i) === 'yes' ? 1 : 0,
				);
			}
			if (! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_enabled_on_1_' . $i]) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_enabled_on_1_' . $i] === 'yes') {
				$tooltip_series[] = $i;
			}
			$gradient[] = esc_html($settings[GRAPHINA_PREFIX . $chart_type . '_chart_gradient_1_' . $i]);
			if (strval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_gradient_2_' . $i]) === '') {
				$second_gradient[] = esc_html($settings[GRAPHINA_PREFIX . $chart_type . '_chart_gradient_1_' . $i]);
			} else {
				$second_gradient[] = esc_html($settings[GRAPHINA_PREFIX . $chart_type . '_chart_gradient_2_' . $i]);
			}
			if ($settings[GRAPHINA_PREFIX . $chart_type . '_chart_bg_pattern_' . $i] !== '') {
				$fill_pattern[] = esc_html($settings[GRAPHINA_PREFIX . $chart_type . '_chart_bg_pattern_' . $i]);
			} else {
				$fill_pattern[] = 'verticalLines';
			}


			$category_list = $settings[GRAPHINA_PREFIX . $chart_type . '_category_list'] ?? array();

			$categories = array_map(
				function ($v) use ($chart_type) {
					$value = htmlspecialchars_decode(esc_html(graphina_get_dynamic_tag_data($v, GRAPHINA_PREFIX . $chart_type . '_chart_category')));
					$allowed_tags  = graphina_allowed_html_tags();
					$value 		   = wp_kses($value, $allowed_tags);
					// Check for comma and split into array if present
					if (strpos($value, ',') !== false) {
						// Split by comma and trim spaces
						return array_map('trim', explode(',', $value));
					}

					return $value;
				},
				$category_list
			);

			$marker_size[]         	= ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_marker_size_' . $i]) ? (float) $settings[GRAPHINA_PREFIX . $chart_type . '_chart_marker_size_' . $i] : 0;
			$marker_stroke_color[] 	= ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_marker_stroke_color_' . $i]) ? esc_html($settings[GRAPHINA_PREFIX . $chart_type . '_chart_marker_stroke_color_' . $i]) : '#fff';
			$marker_stoke_width[]  	= isset($settings[GRAPHINA_PREFIX . $chart_type . '_chart_marker_stroke_width_' . $i]) ? (float) esc_html($settings[GRAPHINA_PREFIX . $chart_type . '_chart_marker_stroke_width_' . $i]) : 5;
			$marker_shape[]        	= ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_chart_marker_stroke_shape_' . $i]) ? esc_html($settings[GRAPHINA_PREFIX . $chart_type . '_chart_chart_marker_stroke_shape_' . $i]) : 'circle';
			$stroke_widths[]        = (float) esc_html(! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_width_3_' . $i]) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_width_3_' . $i] : 0);
			$strock_dash_array[]    = (float) esc_html(! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_dash_3_' . $i]) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_dash_3_' . $i] : 0);
		}


		$gradient_new  = array();
		$desiredLength = count($series_temp);

		while (count($gradient_new) < $desiredLength) {
			$gradient_new = array_merge($gradient_new, $gradient);
		}
		$gradient = array_slice($gradient_new, 0, $desiredLength);

		$export_file_name = $settings[GRAPHINA_PREFIX . $chart_type . '_export_filename'] ?? '';
		$legend_show      = ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_legend_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_legend_show'] === 'yes' ? true : false;

		$locales = array(
			generate_chart_locales(get_locale()),
		);

		$loading_text 	= esc_html( ( isset( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_no_data_text' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_no_data_text' ] : '' ) );

		if(graphina_pro_active() && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_data_option'] !== 'manual'){
			$loading_text    = esc_html__( 'Loading...', 'graphina-charts-for-elementor' );
		}

		$font_color = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ] ) ? strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ] ) : '#000000';

		$chart_options = [
			'series' => $series_temp,
			'chart' => [
				'id' => esc_js($element_id),
				'background' => esc_js($settings[GRAPHINA_PREFIX . $chart_type .'_chart_background_color1']),
				'height' => intval($settings[GRAPHINA_PREFIX . $chart_type .'_chart_height']),
				'type' => 'heatmap',
				'fontFamily' => esc_js(esc_js($settings[GRAPHINA_PREFIX . $chart_type .'_chart_font_family'])),
				'locales'       => $locales,
				'defaultLocale' => get_locale(),
				'toolbar' => [
					'offsetX' => intval(isset($settings[GRAPHINA_PREFIX . $chart_type .'_chart_toolbar_offsetx']) ? $settings[GRAPHINA_PREFIX . $chart_type .'_chart_toolbar_offsetx'] : 0),
					'offsetY' => intval(isset($settings[GRAPHINA_PREFIX . $chart_type .'_chart_toolbar_offsety']) ? $settings[GRAPHINA_PREFIX . $chart_type .'_chart_toolbar_offsety'] : 0),
					'show' => $settings[GRAPHINA_PREFIX . $chart_type .'_can_chart_show_toolbar'],
					'export' => [
						'csv' => [
							'filename' => $export_file_name
						],
						'svg' => [
							'filename' => $export_file_name
						],
						'png' => [
							'filename' => $export_file_name
						]
					]
				],
				'animations' => [
					'enabled' => ($settings[GRAPHINA_PREFIX . $chart_type .'_chart_animation'] === 'yes'),
					'speed' => intval($settings[GRAPHINA_PREFIX . $chart_type .'_chart_animation_speed']) ?: 800,
					'delay' => intval($settings[GRAPHINA_PREFIX . $chart_type .'_chart_animation_delay']) ?: 150
				]
			],
			'plotOptions' => [
				'heatmap' => [
					'radius' => floatval($settings[GRAPHINA_PREFIX . $chart_type .'_chart_radius'])
				]
			],
			'noData' => [
				'text' => $loading_text,
				'align' => 'center',
				'verticalAlign' => 'middle',
				'style' => [
					'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['unit'] : '12px',
					'fontFamily' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
					'color' => $font_color
				]
			],
			'legend' => [
				'showForSingleSeries' => true,
				'show' => $legend_show,
				'fontSize' => !empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['unit'] : '12px',
				'fontFamily' => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'],
				'fontWeight' => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'],
				'labels' => [
					'colors' => $font_color,
				],
				'horizontalAlign' => !empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_legend_horizontal_align']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_legend_horizontal_align'] : 'center',
			],
			'dataLabels' => [
				'enabled' => $settings[GRAPHINA_PREFIX . $chart_type .'_chart_datalabel_show'],
				'style' => [
					'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['unit'] : '12px',
					'fontFamily' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
					'fontWeight' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'] : '',
					'colors' => [$settings[GRAPHINA_PREFIX . $chart_type .'_chart_datalabel_color']],
				],
				'offsetY' => intval(isset($settings[GRAPHINA_PREFIX . $chart_type .'_chart_datalabel_offsety']) ? $settings[GRAPHINA_PREFIX . $chart_type .'_chart_datalabel_offsety'] : 0),
				'offsetX' => intval(isset($settings[GRAPHINA_PREFIX . $chart_type .'_chart_datalabel_offsetx']) ? $settings[GRAPHINA_PREFIX . $chart_type .'_chart_datalabel_offsetx'] : 0),
			],
			'stroke' => [
				'show' => ($settings[GRAPHINA_PREFIX . $chart_type .'_chart_stroke_show'] === 'yes'),
				'width' => intval($settings[GRAPHINA_PREFIX . $chart_type .'_chart_stroke_show'] === 'yes' ? $settings[GRAPHINA_PREFIX . $chart_type .'_chart_stroke_width'] : 0)
			],
			'colors' => $gradient,
			'xaxis' => [
				'categories' => $categories,
				'position' => $settings[GRAPHINA_PREFIX . $chart_type .'_chart_xaxis_datalabel_position'],
				'tickAmount' => intval($settings[GRAPHINA_PREFIX . $chart_type .'_chart_xaxis_datalabel_tick_amount']),
				'labels' => [
					'show' => $settings[GRAPHINA_PREFIX . $chart_type .'_chart_xaxis_datalabel_show'],
					'rotateAlways' => $settings[GRAPHINA_PREFIX . $chart_type .'_chart_xaxis_datalabel_auto_rotate'],
					'rotate' => intval($settings[GRAPHINA_PREFIX . $chart_type .'_chart_xaxis_datalabel_rotate']) ?: 0,
					'offsetX' => intval($settings[GRAPHINA_PREFIX . $chart_type .'_chart_xaxis_datalabel_offset_x']) ?: 0,
					'offsetY' => intval($settings[GRAPHINA_PREFIX . $chart_type .'_chart_xaxis_datalabel_offset_y']) ?: 0,
					'trim' => true,
					'style' => [
					'colors' => $font_color,
					'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['unit'] : '12px',
					'fontFamily' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
					'fontWeight' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'] : '',
					],
				],
				'tooltip' => [
					'enabled' => (isset($settings[GRAPHINA_PREFIX . $chart_type .'_chart_xaxis_tooltip_show']) && $settings[GRAPHINA_PREFIX . $chart_type .'_chart_xaxis_tooltip_show'] === 'yes')
				],
				'crosshairs' => [
					'show' => (isset($settings[GRAPHINA_PREFIX . $chart_type .'_chart_xaxis_crosshairs_show']) && 
							$settings[GRAPHINA_PREFIX . $chart_type .'_chart_xaxis_crosshairs_show'] === 'yes' && 
							isset($settings[GRAPHINA_PREFIX . $chart_type .'_chart_xaxis_tooltip_show']) && 
							$settings[GRAPHINA_PREFIX . $chart_type .'_chart_xaxis_tooltip_show'] === 'yes'),
					'position' => 'front',
				]
			],
			'yaxis' => [
				'tickAmount' => intval($settings[GRAPHINA_PREFIX . $chart_type .'_chart_yaxis_datalabel_tick_amount']),
				'decimalsInFloat' => intval($settings[GRAPHINA_PREFIX . $chart_type .'_chart_yaxis_datalabel_decimals_in_float']),
				'labels' => [
					'show' => $settings[GRAPHINA_PREFIX . $chart_type .'_chart_yaxis_datalabel_show'],
					'rotate' => intval($settings[GRAPHINA_PREFIX . $chart_type .'_chart_yaxis_datalabel_rotate']) ?: 0,
					'offsetX' => intval($settings[GRAPHINA_PREFIX . $chart_type .'_chart_yaxis_datalabel_offset_x']) ?: 0,
					'offsetY' => intval($settings[GRAPHINA_PREFIX . $chart_type .'_chart_yaxis_datalabel_offset_y']) ?: 0,
					'rotate'  => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_rotate']) ? intval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_rotate']) : 0,
					'style' => [
						'colors' => $font_color,
						'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['unit'] : '12px',
						'fontFamily' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
						'fontWeight' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'] : '',
					]
				],
				'tooltip' => [
					'enabled' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_tooltip_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_tooltip_show'] === 'yes' ? true : false,
				],
				'crosshairs'      => array(
					'show' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_crosshairs_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_crosshairs_show'] ? true : false,
				),
			],
			'fill' => [
				'opacity' => 1
			],
			'tooltip' => [
				'enabled' =>! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip'] === 'yes' ? true : false,
				'theme' => $settings[GRAPHINA_PREFIX . $chart_type .'_chart_tooltip_theme'],
				'style' => [
						'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['unit'] : '12px',
						'fontFamily' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
				],
			],
			'responsive' => array(
				[
					'breakpoint' => 1024,
					'options'    => array(
						'chart'  => array(
							'height' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_height_tablet']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_height_tablet'] : 350,
						),
						'dataLabels' => array(
							'enabled'    => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show_tablet']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show_tablet'] === 'yes' ? true : false,
							'style'      => array(
								'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['unit'] : '12px',
								'fontWeight' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight_tablet']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight_tablet'] : ( ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'] : '' ),
								//desktop color is used if the tablet color is not set or empty.
								'colors' => [
									!empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show_tablet'])
										&& $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show_tablet'] === 'yes'
										? (
											!empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color_1_tablet'])
											? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color_1_tablet']
											: (
												!empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show'])
												&& $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show'] === 'yes'
												? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color_1']
												: $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color']
											)
										)
										: (
											!empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color_tablet'])
											? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color_tablet']
											: (
												!empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show'])
												&& $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show'] === 'yes'
												? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color_1']
												: $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color']
											)
										)
								]
							),
							'background' => array(
								'enabled'      => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show_tablet' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show_tablet' ] === 'yes' ? true : false,
								'borderRadius' => intval( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_radius_tablet' ] ) ? esc_js( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_radius_tablet' ] ) : 0 ),
								'foreColor'    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_color_tablet' ] ) ? array( esc_js( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_color_tablet' ] ) ) : '#ffffff',
								'borderWidth'  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_width_tablet' ] ) ? intval( esc_js( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_width_tablet' ] ) ) : 1,
								'borderColor'  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_color_tablet' ] ) ? esc_js( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_color_tablet' ] ) : '#ffffff',
							),
						),
						'yaxis'      => array(
							'labels'      => array(
								'style'        => array(
									'colors'     => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_color_tablet']) ? strval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_color_tablet']) : $font_color,
									'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['unit'] : ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px'),
									'fontWeight' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight_tablet']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight_tablet'] : ( ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'] : '' ),
								),
							)
						),
						'xaxis'  => array(
							'labels'        => array(
								'style'        => array(
									'colors'     => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_color_tablet']) ? strval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_color_tablet']) : $font_color,
									'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['unit'] : ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px'),
									'fontWeight' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight_tablet']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight_tablet'] : ( ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'] : '' ),
								),
							)
						),
						'legend'     => array(
							'showForSingleSeries' => true,
							'fontSize'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet' ]['unit'] : ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px'),
							'fontWeight' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight_tablet' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight_tablet' ] : ( ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'] : '' ),
							'labels'	 => [
								'colors'	=> ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color_tablet' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color_tablet' ] : $font_color,
							],
						),
					)
				],
				[

					'breakpoint' => 767,
					'options'    => array(
						'chart'  => array(
							'height' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_height_mobile']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_height_mobile'] : 350,
						),
						'dataLabels' => array(
							'enabled'    => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show_mobile']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show_mobile'] === 'yes' ? true : false,
							'style'      => array(
								'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['unit'] : ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px'),
								'fontWeight' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight_mobile']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight_mobile'] : ( ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'] : '' ),
								//desktop color is used if the mobile color is not set or empty.
								'colors' => [
									!empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show_mobile'])
										&& $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show_mobile'] === 'yes'
										? (
											!empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color_1_mobile'])
											? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color_1_mobile']
											: (
												!empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show'])
												&& $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show'] === 'yes'
												? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color_1']
												: $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color']
											)
										)
										: (
											!empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color_mobile'])
											? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color_mobile']
											: (
												!empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show'])
												&& $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show'] === 'yes'
												? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color_1']
												: $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color']
											)
										)
								]
							),
							'background' => array(
								'enabled'      => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show_mobile' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show_mobile' ] === 'yes' ? true : false,
								'borderRadius' => intval( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_radius_mobile' ] ) ? esc_js( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_radius_mobile' ] ) : 0 ),
								'foreColor'    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_color_mobile' ] ) ? array( esc_js( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_color_mobile' ] ) ) : '#ffffff',
								'borderWidth'  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_width_mobile' ] ) ? intval( esc_js( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_width_mobile' ] ) ) : 1,
								'borderColor'  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_color_mobile' ] ) ? esc_js( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_color_mobile' ] ) : '#ffffff',
							),
						),
						'yaxis'      => array(
							'labels'      => array(
								'style'        => array(
									'colors'     => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_color_mobile']) ? strval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_color_mobile']) : $font_color,
									'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['unit'] : ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px'),
									'fontWeight' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight_mobile']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight_mobile'] : ( ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'] : '' ),
								),
							)
						),
						'xaxis'  => array(
							'labels'        => array(
								'style'        => array(
									'colors'     => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_color_mobile']) ? strval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_color_mobile']) : $font_color,
									'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['unit'] : ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px'),
									'fontWeight' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight_mobile']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight_mobile'] : ( ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'] : '' ),
								),
							)
						),
						'legend'     => array(
							'showForSingleSeries' => true,
							'fontSize'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile' ]['unit'] : ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px'),
							'fontWeight' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight_mobile' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight_mobile' ] : ( ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'] : '' ),
							'labels'	 => [
								'colors'	=> ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color_mobile' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color_mobile' ] : $font_color,
							],
						),
					),
				]
			),
		];
		
		$yaxis_position_is_opposite = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_position' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_position' ] === 'yes';
		$chart_options['yaxis']['opposite'] = $yaxis_position_is_opposite ? true : false;
		$xaxis_title_show = ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title_enable']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title_enable'] === 'yes' ? true : false;

		if ($xaxis_title_show && ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title'])) {

			$chart_options['xaxis']['title'] = array(
				'text'    => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title'],
				'offsetX' => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title_offset_x'],
				'offsetY' => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title_offset_y'],
				'style'   => array(
					'color'      => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_color'],
					'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['unit'] : '12px',
					'fontFamily' => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'],
					'fontWeight' => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'],
				),
			);
		}

		$yaxis_title_show = ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title_enable']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title_enable'] === 'yes' ? true : false;
		if ($yaxis_title_show && ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title'])) {

			$chart_options['yaxis']['title'] = array(
				'text'  => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title'],
				'style' => array(
					'color'      => $settings[GRAPHINA_PREFIX . $chart_type . '_card_yaxis_title_font_color'],
					'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['unit'] : '12px',
					'fontFamily' => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'],
					'fontWeight' => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'],
				),
			);
		}

		$is_opposite_yaxis = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title_enable' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title_enable' ] === 'yes' ? true : false;
		if ( $is_opposite_yaxis ) {

			$rightYAxis = array();
			$leftYAxis  = array();

			// Loop through the data and filter based on yaxis value
			foreach ( $series_temp as $item ) {
				if ( isset( $item['yaxis'] ) ) {
					if ( $item['yaxis'] === 1 ) {
						$rightYAxis[] = $item['name'];
					} elseif ( $item['yaxis'] === 0 ) {
						$leftYAxis[] = $item['name'];
					}
				}
			}

			if ( is_array( $leftYAxis ) && ! empty( $leftYAxis ) && is_array( $rightYAxis ) && ! empty( $rightYAxis ) ) {
				$chart_options['yaxis']['seriesName'] = $leftYAxis;
			}
			$chart_options['yaxis'] = array( $chart_options['yaxis'] );
			$yaxis_opposite_options = array(
				'opposite'        => $yaxis_position_is_opposite ? false : true,
				'title'           => array(
					'text'  => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title' ],
					'style' => array(
						'color' => $settings[ GRAPHINA_PREFIX . $chart_type . '_card_opposite_yaxis_title_font_color' ],
						'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['unit'] : '12px',
						'fontFamily' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
						'fontWeight' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'] : '',
					),
				),
				'labels'          => array(
					'show'  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_label_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_label_show' ] === 'yes',
					'style' => array(
						'colors' => array( $settings[ GRAPHINA_PREFIX . $chart_type . '_card_opposite_yaxis_title_font_color' ] ),
						'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['unit'] : '12px',
						'fontFamily' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
						'fontWeight' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'] : '',
					),
				),
				'tickAmount'      => intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_tick_amount' ] ) ?? 6,
				'decimalsInFloat' => intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_decimals_in_float' ] ) ?? 1,
			);

			if ( is_array( $rightYAxis ) && ! empty( $rightYAxis ) && is_array( $leftYAxis ) && ! empty( $leftYAxis ) ) {
				$yaxis_opposite_options['seriesName'] = $rightYAxis;
			}

			if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_enable_min_max' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_enable_min_max' ] === 'yes' ) {
				$yaxis_opposite_options['min'] = floatval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_min_value' ] ) ?? 0;
				$yaxis_opposite_options['max'] = floatval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_max_value' ] ) ?? 0;
			}
			$chart_options['yaxis'][] = $yaxis_opposite_options;
		}
		return $chart_options;
	}
}

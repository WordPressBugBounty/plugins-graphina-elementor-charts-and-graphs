<?php

namespace Graphina\Elementor\Widget\Google;

use Graphina\Charts\Elementor\GraphinaGoogleChartBase;
use Graphina\Charts\Elementor\GraphinaElementorControls;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly to ensure security.
}

/**
 * AreaGoogleChart Class
 *
 * This class defines the Area Google Chart widget for the Graphina plugin,
 * enabling the creation of dynamic and visually appealing Area Charts
 * using Google Charts within Elementor.
 *
 * Product: Graphina - Elementor Charts and Graphs
 * Purpose: To allow users to integrate Google Area Charts seamlessly
 *          with Elementor's drag-and-drop editor, leveraging Google Charts' capabilities.
 */
class AreaGoogleChart extends GraphinaGoogleChartBase {

	/**
	 * Get Widget Name
	 *
	 * Provides the unique identifier for the Area Google Chart widget,
	 * used internally by Elementor and Graphina.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'area_google_chart';
	}

	/**
	 * Get Widget Title
	 *
	 * Returns the title of the Area Google Chart widget,
	 * displayed in Elementor's widget panel for easy identification.
	 *
	 * @return string Translatable widget title.
	 */
	public function get_title() {
		return __( 'Area Google Chart', 'graphina-charts-for-elementor' );
	}

	/**
	 * Get Widget Icon
	 *
	 * Specifies the icon class for the widget,
	 * shown in Elementor's widget panel to visually represent this chart type.
	 *
	 * @return string Icon CSS class.
	 */
	public function get_icon() {
		return 'graphina-google-area-chart';
	}

	/**
	 * Get Chart Type
	 *
	 * Indicates the chart type associated with this widget.
	 * Here, it defines an 'area_google' chart type, aligning with Google Charts.
	 *
	 * @return string Chart type identifier.
	 */
	public function get_chart_type(): string {
		return 'area_google';
	}

	/**
	 * Get Script Dependencies
	 *
	 * Returns a list of JavaScript dependencies required by the Area Google Chart widget,
	 * ensuring that all necessary scripts are loaded for proper functionality.
	 *
	 * @return array List of script handles.
	 */
	public function get_script_depends() {
		 return ['googlechart-js', 'area-google-chart'];
	}

	/**
	 * Get Widget Categories
	 *
	 * Categorizes the Area Google Chart widget under 'graphina-google',
	 * ensuring it appears in the correct section of Elementor's widget panel.
	 *
	 * @return array List of categories.
	 */
	public function get_categories() {
		return array( 'graphina-google' );
	}

	/**
	 * Get Style Dependencies
	 *
	 * Returns a list of CSS dependencies required by the Area Google Chart widget,
	 * ensuring the correct styles are applied to the chart.
	 *
	 * @return array List of style handles.
	 */
	public function get_style_depends() {
		return array( 'graphina_chart-css' );
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
		$controls->graphina_common_chart_setting( $this, $chart_type, false );
		$controls->graphina_advance_legend_setting( $this, $chart_type );
		$controls->graphina_advance_h_axis_setting( $this, $chart_type );
		$controls->graphina_advance_v_axis_setting( $this, $chart_type );
		$controls->graphina_google_series_setting( $this, $chart_type, array( 'tooltip', 'color' ) );
		$controls->register_chart_restriction_controls( $this, $chart_type );
		apply_filters( 'graphina_password_form_style_section', $this, $chart_type );
	}


	/**

	 * Render widget output on the frontend
	 *
	 * Retrieves and processes the necessary settings for the Area Google Chart widget,
	 * then renders the Google Charts JavaScript code to create and display the chart.
	 * The chart will then be rendered on the frontend
	 */
	protected function graphina_prepare_google_chart_options($settings, $chart_type, $element_id)
	{
		$series_count   = $settings[GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count'] ?? 0;
		$legend_position = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' ] === 'yes' ? $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_position' ] : 'none';
		$chartArea       = array(
			'left'  => '10%',
			'right' => '5%',
		);
		if ($legend_position === 'left') {
			$chartArea = array(
				'left'  => '25%',
				'right' => '10%',
			);
		} elseif ($legend_position === 'right') {
			$chartArea = array(
				'left'  => '10%',
				'right' => '25%',
			);
		}

		$element_colors = $element_title_array = $series_style_array = array();

		for ($j = 0; $j < $series_count; $j++) {
			$element_colors[]      = isset($settings[GRAPHINA_PREFIX . $chart_type . '_chart_element_color_' . $j]) ? esc_html($settings[GRAPHINA_PREFIX . $chart_type . '_chart_element_color_' . $j]) : '';
			$element_title_array[] = isset($settings[GRAPHINA_PREFIX . $chart_type . '_chart_title_3_' . $j]) ? esc_html($settings[GRAPHINA_PREFIX . $chart_type . '_chart_title_3_' . $j]) : '';
			$point_show = ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_point_show' . $j]) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_point_show' . $j] : false;

			if ($point_show) {
				$point_size  = isset($settings[GRAPHINA_PREFIX . $chart_type . '_chart_line_point_size' . $j]) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_line_point_size' . $j] : null;
				$point_shape = isset($settings[GRAPHINA_PREFIX . $chart_type . '_chart_line_point' . $j]) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_line_point' . $j] : null;
			} else {
				$point_size  = null;
				$point_shape = null;
			}

			$line_dash = match (! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_element_lineDash' . $j]) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_element_lineDash' . $j] : '') {
				'style_1' => array(1, 1),
				'style_2' => array(2, 2),
				'style_3' => array(4, 4),
				'style_4' => array(5, 1, 3),
				'style_5' => array(4, 1),
				'style_6' => array(10, 2),
				'style_7' => array(14, 2, 7, 2),
				'style_8' => array(14, 2, 2, 7),
				'style_9' => array(2, 2, 20, 2, 20, 2),
				default => null,
			};
			$series_style_array[] = array(
				'lineWidth'       => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_element_linewidth' . $j]) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_element_linewidth' . $j] : 2,
				'lineDashStyle'   => $line_dash,
				'pointShow'       => $point_show,
				'pointSize'       => $point_size,
				'pointShape'      => $point_shape,
				'targetAxisIndex' => $legend_position === 'left' ? 1 : 0,
			);
		}
		$type_of_chart = isset($settings[GRAPHINA_PREFIX . $chart_type . '_chart_title']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_title'] : '';

		$response = array(
			'title'           => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_title']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_title'] : '',
			'titlePosition'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_title_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_title_show'] === 'yes' ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_title_position'] : 'none', // in, out, none
			'titleTextStyle'  => array(
				'color'    => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_title_color']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_title_color'] : '',
				'fontSize' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_title_font_size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_title_font_size'] : '',
				'fontName' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
			),
			'chartArea'       => $chartArea,
			'height'          => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_height'],
			'chartType'	   => $type_of_chart,
			'series'          => $series_style_array,
			'tooltip'         => array(
				'showColorCode' => true,
				'textStyle'     => array('color' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_color']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_color'] : ''),
				'trigger'       => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_show'] === 'yes' ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_trigger'] : 'none',
			),

			'backgroundColor' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_background_color1']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_background_color1'] : '',
			'colors'          => $element_colors,
			'legend' => [
				'position' => $legend_position,
				'textStyle' => [
					'fontName' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
					'fontSize' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_fontsize' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_fontsize' ] ) : '10',
					'color' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_color' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_color' ] : '',
				],
				'alignment' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_horizontal_align' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_horizontal_align' ] : '',
			]
		);

		$response['annotations'] = array(
			'stemColor' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_annotation_stemcolor']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_annotation_stemcolor'] : '',
			'textStyle' => array(
				'fontName' 	=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
				'fontSize'  => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_annotation_fontsize']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_annotation_fontsize'] : '',
				'color'     => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_annotation_color']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_annotation_color'] : '',
				'auraColor' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_annotation_color2']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_annotation_color2'] : '',
				'opacity'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_annotation_opacity']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_annotation_opacity'] : '',
			),
		);
		$response['isStacked']   = ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_stacked_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_stacked_show'] === 'yes' ? true : false;
		$response['animation']   = array(
			'startup'  => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_animation_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_animation_show'] === 'yes' ? true : false,
			'duration' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_animation_speed']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_animation_speed'] : '',
			'easing'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_animation_easing']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_animation_easing'] : '',
		);
		$response['hAxis']       = array(
			'slantedText'      => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_rotate']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_rotate'] === 'yes' ? true : false,
			'slantedTextAngle' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_rotate_value']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_rotate_value'] : '',
			'direction'        => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_haxis_direction']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_haxis_direction'] === 'yes' ? -1 : 1,
			'title'            => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_haxis_title']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_haxis_title'] : '',
			'titleTextStyle'   => array(
				'fontName' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
				'color'    => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_haxis_title_font_color']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_haxis_title_font_color'] : '',
				'fontSize' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_haxis_title_font_size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_haxis_title_font_size'] : '',
			),
			'textStyle'        => array(
				'fontName' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
				'color'    => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_font_color']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_font_color'] : '',
				'fontSize' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_font_size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_font_size'] : '',
			),
			'textPosition'     => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_position_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_position_show'] === 'yes' ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_haxis_label_position'] : 'none', // in, out, none
		);

		$response['vAxis']  = array(
			'viewWindowMode' => 'explicit',
			'viewWindow'     => array(
				'max' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_maxvalue']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_maxvalue'] : '',
				'min' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_minvalue']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_minvalue'] : '',
			),
			'direction'      => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_direction']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_direction'] === 'yes' ? -1 : 1,
			'title'          => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_title']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_title'] : '',
			'logScale'       => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_logscale_show']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_logscale_show'] : '',
			'scaleType'      => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_scaletype']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_scaletype'] : '',
			'titleTextStyle' => array(
				'fontName' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
				'color'    => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_title_font_color']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_title_font_color'] : '',
				'fontSize' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_title_font_size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_title_font_size'] : '',
			),
			'textStyle'      => array(
				'fontName' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
				'color'    => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_font_color']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_font_color'] : '',
				'fontSize' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_font_size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_font_size'] : '',
			),
			'textPosition'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_label_position_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_label_position_show'] === 'yes' ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_label_position'] : 'none', // in, out, none
			'format'         => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_format']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_format'] === '\#' ? ($settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_format_currency_prefix']) : (! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_format']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_vaxis_format'] : ''),
			'baselineColor'  => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_baseline_Color']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_baseline_Color'] : '',
			'gridlines'      => array(
				'color' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_gridline_color']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_gridline_color'] : '',
				'count' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_gridline_count']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_gridline_count'] : '',
			),
			'minorGridlines' => array(
				'count'	=> 0,
			)
		);

		if (! empty($settings[GRAPHINA_PREFIX . $chart_type . '_google_chart_major_ticks_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_google_chart_major_ticks_show'] == 'yes') {
			if (! empty($settings[GRAPHINA_PREFIX . $chart_type . '_google_chart_major_ticks'])) {
				$majorticksvalue = array();
				foreach ($settings[GRAPHINA_PREFIX . $chart_type . '_google_chart_major_ticks'] as $key1 => $value1) {
					$majorticksvalue[] = strval($value1[GRAPHINA_PREFIX . $chart_type . '_google_chart_major_ticks_value']);
				}
				$majorticksvalue = json_encode($majorticksvalue);
			}
			$response['majorTicks'] = isset($majorticksvalue) && ! empty($majorticksvalue) ? $majorticksvalue : array();
		}
		return $response;
	}	
}

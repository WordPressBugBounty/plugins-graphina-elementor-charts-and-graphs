<?php

namespace Graphina\Elementor\Widget\Google;

use Graphina\Charts\Elementor\GraphinaGoogleChartBase;
use Graphina\Charts\Elementor\GraphinaElementorControls;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly to ensure security.
}

/**
 * PieGoogleChart Class
 *
 * This class defines the Pie Google Chart widget for the Graphina plugin,
 * enabling the creation of dynamic and visually appealing Pie Charts
 * using Google Charts within Elementor.
 *
 * Product: Graphina - Elementor Charts and Graphs
 * Purpose: To allow users to integrate Google Pie Charts seamlessly
 *          with Elementor's drag-and-drop editor, leveraging Google Charts' capabilities.
 */
class PieGoogleChart extends GraphinaGoogleChartBase {

	/**
	 * Get Widget Name
	 *
	 * Provides the unique identifier for the Pie Google Chart widget,
	 * used internally by Elementor and Graphina.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'pie_google_chart';
	}

	/**
	 * Get Widget Title
	 *
	 * Returns the title of the Pie Google Chart widget,
	 * displayed in Elementor's widget panel for easy identification.
	 *
	 * @return string Translatable widget title.
	 */
	public function get_title() {
		return __( 'Pie Google Chart', 'graphina-charts-for-elementor' );
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
		return 'graphina-google-pie-chart';
	}

	/**
	 * Get Chart Type
	 *
	 * Indicates the chart type associated with this widget.
	 * Here, it defines an 'pie_google' chart type, aligning with Google Charts.
	 *
	 * @return string Chart type identifier.
	 */
	public function get_chart_type(): string {
		return 'pie_google';
	}

	/**
	 * Get Script Dependencies
	 *
	 * Returns a list of JavaScript dependencies required by the Pie Google Chart widget,
	 * ensuring that all necessary scripts are loaded for proper functionality.
	 *
	 * @return array List of script handles.
	 */
	public function get_script_depends() {
		return array( 'pie-google-chart' );
	}

	/**
	 * Get Widget Categories
	 *
	 * Categorizes the Pie Google Chart widget under 'graphina-google',
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
	 * Returns a list of CSS dependencies required by the Pie Google Chart widget,
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
		$controls->graphina_chart_data_series( $this, $chart_type, 0 );
		$controls->graphina_common_chart_setting( $this, $chart_type, false );
		$controls->graphina_advance_legend_setting( $this, $chart_type );
		$controls->register_chart_restriction_controls( $this, $chart_type );
		apply_filters( 'graphina_password_form_style_section', $this, $chart_type );
	}

	/**
	 * Prepare Google Chart Options
	 *
	 * This method prepares the options for the Pie Google Chart widget,
	 * ensuring that all necessary settings are properly formatted for Google Charts.
	 * This method also prepares the options for the Google Chart Options widget for display
	 * in the Google Chart Options widget container element
	 */
	protected function graphina_prepare_google_chart_options($settings, $chart_type, $element_id)
	{
		$legend_position = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_show' ] === 'yes' ? $settings[ GRAPHINA_PREFIX . $chart_type . '_google_piechart_legend_position' ] : 'none';
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
		$response = array(
			'title' => isset($settings[GRAPHINA_PREFIX . $chart_type . '_chart_title']) && !empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_title']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_title'] : '',
			'titleTextStyle'  => array(
				'fontName' 	=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
				'color'    => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_title_color']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_title_color'] : '',
				'fontSize' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_title_font_size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_title_font_size'] : '',
			),
			'chartArea'       => $chartArea,
			'height'          => isset($settings[GRAPHINA_PREFIX . $chart_type . '_chart_height']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_height'] : '',
			'tooltip'         => array(
				'showColorCode' => true,
				'textStyle'     => array(
					'fontName'  => isset($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) && ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
					'color'     => isset($settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_color']) && ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_color']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_color'] : '',
					'fontName'  => isset($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) && ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
				),
				'trigger'       => (isset($settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_show']) && ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_show'] === 'yes' && isset($settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_trigger'])) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_trigger'] : 'none',
			),

			'backgroundColor' => isset($settings[GRAPHINA_PREFIX . $chart_type . '_chart_background_color1']) && ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_background_color1']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_background_color1'] : '',
			'legend' => [
				'position' => $legend_position,
				'textStyle' => [
					'fontName'  => isset($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) && ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
					'fontSize'  => isset($settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_fontsize' ]) && ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_fontsize' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_fontsize' ] ) : '10',
					'color'     => isset($settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_color' ]) && ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_color' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_color' ] : '',
				],
				'alignment' => isset($settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_horizontal_align' ]) && ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_horizontal_align' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_legend_horizontal_align' ] : '',
			]
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

		$colors = array();
		for ($i = 0; $i < $settings[GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count']; $i++) {
			$colors[] = esc_html($settings[GRAPHINA_PREFIX . $chart_type . '_chart_element_color_' . $i]);
		}

		$response['reverseCategories']        = $settings[GRAPHINA_PREFIX . $chart_type . '_chart_label_reversecategory'] === 'yes';
		$response['pieSliceText']             = $settings[GRAPHINA_PREFIX . $chart_type . '_chart_pieSliceText_show'] === 'yes' ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_pieSliceText'] : 'none';
		$response['sliceVisibilityThreshold'] = 0;
		$response['pieSliceBorderColor']      = $settings[GRAPHINA_PREFIX . $chart_type . '_chart_pieslice_bordercolor'] ? strval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_pieslice_bordercolor']) : '#000000';
		$response['pieSliceTextStyle']        = array(
			'fontName' 	=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
			'color' 	=> ! empty ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_pieSliceText_color' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_pieSliceText_color' ] : '',
			'fontSize' 	=> ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_pieSliceText_fontsize' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_pieSliceText_fontsize' ] : '',
		);
		$response['is3D']                     = $settings[GRAPHINA_PREFIX . $chart_type . '_chart_isthreed'] === 'yes';
		$response['tooltip']['text']          = $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_text'];
		$response['colors']                   = $colors;


		return $response;
	}
}

<?php

namespace Graphina\Elementor\Widget;

use Graphina\Charts\Elementor\GraphinaApexChartBase;
use Graphina\Charts\Elementor\GraphinaElementorControls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly to ensure security.
}

/**
 * LineChart Class
 *
 * This class defines the Line Chart widget for the Graphina plugin,
 * enabling the creation of highly customizable Line Charts within Elementor.
 *
 * Product: Graphina - Elementor Charts and Graphs
 * Purpose: To allow users to create dynamic and interactive Line Charts
 *          using Elementor's drag-and-drop interface with ApexCharts integration.
 */
class LineChart extends GraphinaApexChartBase {

	/**
	 * Get Widget Name
	 *
	 * Provides the unique identifier for the Line Chart widget,
	 * used internally by Elementor and Graphina.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'line_chart';
	}

	/**
	 * Get Widget Title
	 *
	 * Returns the title of the Line Chart widget,
	 * displayed in Elementor's widget panel for easy identification.
	 *
	 * @return string Translatable widget title.
	 */
	public function get_title() {
		return __( 'Line Chart', 'graphina-charts-for-elementor' );
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
		return 'graphina-apex-line-chart';
	}

	/**
	 * Get Chart Type
	 *
	 * Indicates the chart type associated with this widget.
	 * Here, it defines a 'line' chart type, aligning with the ApexCharts library.
	 *
	 * @return string Chart type identifier.
	 */
	public function get_chart_type(): string {
		return 'line';
	}

	/**
	 * Get Widget Categories
	 *
	 * Categorizes the Line Chart widget under 'graphina-apex',
	 * ensuring it appears in the correct section of Elementor's widget panel.
	 *
	 * @return array List of categories.
	 */
	public function get_categories() {
		return array( 'graphina-apex' );
	}

	/**
	 * Get Script Dependencies
	 *
	 * Returns a list of JavaScript dependencies required by the Line Chart widget,
	 * ensuring that all necessary scripts are loaded for proper functionality.
	 *
	 * @return array List of script handles.
	 */
	public function get_script_depends() {
		return array( 'line-chart' );
	}

	/**
	 * Get Style Dependencies
	 *
	 * Returns a list of CSS dependencies required by the Line Chart widget,
	 * ensuring the correct styles are applied to the chart.
	 *
	 * @return array List of style handles.
	 */
	public function get_style_depends() {
		return array( 'line-chart' );
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
		$controls->graphina_chart_legend_setting( $this, $chart_type );
		$controls->graphina_series_setting( $this, $chart_type, array( 'tooltip', 'color', 'dash', 'width' ), true, array( 'classic', 'gradient' ), false, true );
		$controls->graphina_chart_x_axis_setting( $this, $chart_type );
		$controls->graphina_chart_y_axis_setting( $this, $chart_type );
		$controls->register_chart_restriction_controls( $this, $chart_type );
		apply_filters( 'graphina_password_form_style_section', $this, $chart_type );
	}

	/**
     * Render widget output in the editor.
     *
     * @param array $args Widget arguments.
     * @param array $instance Saved widget instance.
	 */
	protected function graphina_prepare_chart_common_options($settings, $chart_type, $element_id)
	{
		$series_temp      = array();
		$series_count     = $settings[GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count'] ?? 0;
		$gradient         = '';

		$marker_size = $marker_stroke_color = $stroke_widths = $strock_dash_array = $categories = $marker_size = $tooltip_series = $marker_stoke_width = $marker_shape = $second_gradient = $fill_pattern = $gradient = array();

		// Prepare series data
		for ($i = 0; $i < $series_count; $i++) {
			$colors[]      = ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_gradient_1_' . $i]) ? strval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_gradient_1_' . $i]) : '';
			$value_list    = $settings[GRAPHINA_PREFIX . $chart_type . '_value_list_3_1_' . $i] ?? array();
			$values        = array_map(
				fn($v) => (float) graphina_get_dynamic_tag_data($v, GRAPHINA_PREFIX . $chart_type . '_chart_value_3_' . $i),
				$value_list
			);
			$series_temp[] = array(
				'name'  => esc_html(graphina_get_dynamic_tag_data($settings, GRAPHINA_PREFIX . $chart_type . '_chart_title_3_' . $i)),
				'data'  => $values,
				'yaxis' => graphina_get_dynamic_tag_data($settings, GRAPHINA_PREFIX . $chart_type . '_chart_depends_3_' . $i) === 'yes' ? 1 : 0,
			);

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
			$marker_size[]         	= ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_marker_size_' . $i]) ? (float) $settings[GRAPHINA_PREFIX . $chart_type . '_chart_marker_size_' . $i] : 0;
			$marker_stroke_color[] 	= ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_marker_stroke_color_' . $i]) ? esc_html($settings[GRAPHINA_PREFIX . $chart_type . '_chart_marker_stroke_color_' . $i]) : '#fff';
			$marker_stoke_width[]  	= ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_marker_stroke_width_' . $i]) ? (float) esc_html($settings[GRAPHINA_PREFIX . $chart_type . '_chart_marker_stroke_width_' . $i]) : 5;
			$marker_shape[]        	= ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_chart_marker_stroke_shape_' . $i]) ? esc_html($settings[GRAPHINA_PREFIX . $chart_type . '_chart_chart_marker_stroke_shape_' . $i]) : 'circle';
			$stroke_widths[]        = (float) esc_html(! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_width_3_' . $i]) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_width_3_' . $i] : 0);
			$strock_dash_array[]    = (float) esc_html(! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_dash_3_' . $i]) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_dash_3_' . $i] : 0);
		}

		$category_list = $settings[GRAPHINA_PREFIX . $chart_type . '_category_list'] ?? array();
		$categories    = array_map(
			fn($v) => htmlspecialchars_decode(esc_html(graphina_get_dynamic_tag_data($v, GRAPHINA_PREFIX . $chart_type . '_chart_category'))),
			$category_list
		);

		$export_file_name = $settings[GRAPHINA_PREFIX . $chart_type . '_export_filename'] ?? '';
		$legend_show      = ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_legend_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_legend_show'] === 'yes' ? true : false;

		$locales = array(
			generate_chart_locales(get_locale()),
		);



		$type_of_chart = '';

		$type_of_chart = $chart_type;

		$color_setting_key = GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show';
		$font_color_key    = GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color_1';
		$default_color 	   = ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_color']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_color'] : '#000000';

		$datalabel_font_color = ! empty($settings[$color_setting_key]) && 'yes' === $settings[$color_setting_key]
			? $settings[$font_color_key]
			: $default_color;

		$color_array = array(esc_js($datalabel_font_color));


		$chart_options = array(
			'series'     => $series_temp,
			'chart'      => array(
				'id'            => $element_id,
				'background'    => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_background_color1']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_background_color1'] : '',
				'height'        => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_height']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_height'] : '350',
				'type'          => $type_of_chart,
				'stacked'       => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_stacked']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_stacked'] : '',
				'toolbar'       => array(
					'offsetX' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_offsetx']) ? intval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_offsetx']) : 0,
					'offsetY' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_offsety']) ? intval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_offsety']) : 0,
					'show'    => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_can_chart_show_toolbar']) && $settings[GRAPHINA_PREFIX . $chart_type . '_can_chart_show_toolbar'] === 'yes' ? true : false,
					'export'  => array(
						'csv' => array(
							'filename' => esc_js($export_file_name),
						),
						'svg' => array(
							'filename' => esc_js($export_file_name),
						),
						'png' => array(
							'filename' => esc_js($export_file_name),
						),
					),
					'tools'   => array(
						'download' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_download']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_download'] === 'yes' ? true : false,
					),
				),
				'dropShadow'    => array(
					'enabled' => $settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow'] ?? false,
					'top'     => $settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_top'] ?? 0,
					'left'    => $settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_left'] ?? 0,
					'blur'    => $settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_blur'] ?? 0,
					'color'   => $settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_color'] ?? '',
					'opacity' => $settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_opacity'] ?? 0,
				),
				'animations'    => array(
					'enabled' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_animation']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_animation'] === 'yes' ? true : false,
					'speed'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_animation_speed']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_animation_speed'] : 800,
					'delay'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_animation_delay']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_animation_delay'] : 150,
				),

				'locales'       => $locales,
				'defaultLocale' => get_locale(),
			),
			'xaxis'      => array(
				'tickAmount'    => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_tick_amount']) ? intval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_tick_amount']) : 6,
				'tickPlacement' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_tick_placement']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_tick_placement'] : '',
				'position'      => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_position']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_position'] : 'buttom',
				'labels'        => array(
					'show'         => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show'] === 'yes' ? true : false,
					'rotateAlways' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_auto_rotate']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_auto_rotate'] === 'yes' ? true : false,
					'rotate'       => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_rotate']) ? intval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_rotate']) : 0,
					'offsetX'      => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_offset_x']) ? intval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_offset_x']) : 0,
					'offsetY'      => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_offset_y']) ? intval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_offset_y']) : 0,
					'trim'         => true,
					'style'        => array(
						'colors'     => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_color']) ? strval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_color']) : '#000000',
						'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['unit'] : '12px',
						'fontFamily' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
						'fontWeight' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'] : '',
					),
				),
				'tooltip'       => array(
					'enabled' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_tooltip_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_tooltip_show'] === 'yes' ? true : false,
				),
				'crosshairs'    => array(
					'show' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_crosshairs_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_crosshairs_show'] === 'yes' ? true : false,
				),
			),
			'colors'	 => $gradient,
			'yaxis'      => array(
				'tickAmount'      => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_tick_amount']) ? intval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_tick_amount']) : 6,
				'decimalsInFloat' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_decimals_in_float']) ? intval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_decimals_in_float']) : 1,
				'labels'          => array(
					'show'    => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show'] === 'yes' ? true : false,
					'offsetX' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_offset_x']) ? intval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_offset_x']) : 0,
					'offsetY' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_offset_y']) ? intval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_offset_y']) : 0,
					'style'        => array(
						'colors'     => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_color']) ? strval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_color']) : '#000000',
						'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['unit'] : '12px',
						'fontFamily' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
						'fontWeight' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'] : '',
					),
				),
				'tooltip'         => array(
					'enabled' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_tooltip_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_tooltip_show'] === 'yes' ? true : false,
				),
				'crosshairs'      => array(
					'show' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_crosshairs_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_crosshairs_show'] ? true : false,
				),
			),
			'legend'     => array(
				'showForSingleSeries' => true,
				'show'                => $legend_show,
				'horizontalAlign'     => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_legend_horizontal_align']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_legend_horizontal_align'] : 'center',
			),
			'dataLabels' => array(
				'enabled'    => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show'] === 'yes' ? true : false,
				'style'      => array(
					'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['unit'] : '12px',
					'fontFamily' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
					'fontWeight' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'] : '',
					'colors'     => [ ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show' ]) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show' ] === 'yes' ? $settings[ GRAPHINA_PREFIX . $chart_type .  '_chart_datalabel_font_color_1' ] : $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color' ]]
				),
				'background' => array(
					'enabled'      => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show'] === 'yes' ? true : false,
					'borderRadius' => intval(! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_radius']) ? esc_js($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_radius']) : 0),
					'foreColor'    => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_color']) ? array(esc_js($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_color'])) : '#ffffff',
					'borderWidth'  => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_width']) ? intval(esc_js($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_width'])) : 1,
					'borderColor'  => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_color']) ? esc_js($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_color']) : '#ffffff',
				),
			),
			'noData'     => array(
				'text' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_no_data_text']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_no_data_text'] : esc_html__('No Data Available', 'graphina-charts-for-elementor'),
			),
			'tooltip'    => array(
				'enabled' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip'] === 'yes' ? true : false,
				'theme'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_theme']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_theme'] : 'light',
			),
		);


		$chart_options['tooltip']['shared'] = ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared'] ? true : false;
		$chart_options['tooltip']['intersect'] = ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared'] ? false : true;


		$chart_options['dataLabels']['offsetY'] = ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_offsety']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_offsety'] : 0;
		$chart_options['dataLabels']['offsetX'] = ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_offsetx']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_offsetx'] : 0;
		$chart_options['tooltip']['shared'] 	= ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared'] === 'yes' ? true : false;
		$chart_options['tooltip']['intersect'] 	= ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared'] === 'yes' ? false : true;

		if (in_array($chart_type, array('area', 'column'))) {
			$chart_options['fill']                       = array(
				'type'     => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type'],
				'opacity'  => floatval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_fill_opacity']),
				'colors'   => $gradient,
				'gradient' => array(
					'gradientToColors' => $second_gradient,
					'type'             => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_gradient_type'],
					'inverseColors'    => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_gradient_inversecolor'] === 'yes',
					'opacityFrom'      => floatval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_gradient_opacityFrom']),
					'opacityTo'        => floatval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_gradient_opacityTo']),
				),
				'pattern'  => array(
					'style'       => $fill_pattern,
					'width'       => 6,
					'height'      => 6,
					'strokeWidth' => 2,
				),
			);
			$chart_options['yaxis']['opposite'] = ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_position']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_position'] === 'yes' ? true : false;

			if (! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared'] === 'yes' ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared'] : '') {
				$chart_options['tooltip']['enabledOnSeries'] = $tooltip_series;
			}
			$chart_options['markers']                    = array(
				'size'               => $marker_size,
				'strokeColors'       => $marker_stroke_color,
				'strokeWidth'        => $marker_stoke_width,
				'shape'              => $marker_shape,
				'showNullDataPoints' => true,
				'hover'              => array(
					'size'       => 3,
					'sizeOffset' => 1,
				),
			);
		}

		if ('column' === $chart_type) {
			$chart_options['plotOptions'] = [
				'bar' => [
					'horizontal' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_horizontal']) && $settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_horizontal'] === 'yes' ? true : false,
					'columnWidth' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_stroke_width']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_stroke_width'] . '%' : '12%',
					'borderRadius' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_plot_border_radius']) ? intval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_plot_border_radius']) : 0,
					'dataLabels' => [
						'position' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_position_show']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_position_show'] : '',
						'orientation' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_orientation']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_orientation'] : '',
						'total' => [
							'enabled' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_datalable_total']) && $settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_datalable_total'] === 'yes' ? true : false,
							'style' => [
								'fontSize' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_datalable_total_fontsize']) ? intval($settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_datalable_total_fontsize']) : '',
							]
						]
					]
				],
			];
		}

		if ('line' === $chart_type) {

			if (! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared'] === 'yes' ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared'] : '') {
				$chart_options['tooltip']['enabledOnSeries'] = $tooltip_series;
			}
			$chart_options['stroke'] = array(
				'curve'     => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_line_curve']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_line_curve'] : 'smooth',
				'width' => $stroke_widths,
				'dashArray' => $strock_dash_array,

			);
			$chart_options['xaxis']['label'] = array(
				'style' => array(
					'colors' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_line_x_label_color']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_line_x_label_color'] : '#000000',
				),
			);
			$chart_options['yaxis']['label'] = array(
				'style' => array(
					'colors' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_line_y_label_color']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_line_y_label_color'] : '#000000',
				),
			);
			$chart_options['fill']            = array(
				'type'     => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type'],
				'opacity'  => 1,
				'colors'   => $gradient,
				'gradient' => array(
					'gradientToColors' => $second_gradient,
					'type'             => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_gradient_type'],
					'inverseColors'    => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_gradient_inversecolor'] === 'yes',
					'opacityFrom'      => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_gradient_opacityFrom'],
					'opacityTo'        => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_gradient_opacityTo'],
				),
			);
			$chart_options['markers']         = array(
				'size'               => $marker_size,
				'strokeColors'       => $marker_stroke_color,
				'strokeWidth'        => $marker_stoke_width,
				'shape'              => $marker_shape,
				'showNullDataPoints' => true,
				'hover'              => array(
					'size'       => 3,
					'sizeOffset' => 1,
				),
			);
		}
		$chart_options['legend'] = array(
			'showForSingleSeries' => true,
			'show'                => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_legend_show'] === 'yes' ? true : false,
			'position'            => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_legend_position']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_legend_position'] : 'bottom',
			'horizontalAlign'     => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_legend_horizontal_align']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_legend_horizontal_align'] : 'center',
			'fontSize'            => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['unit'] : '12px',
			'fontFamily'          => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'],
			'fontWeight'          => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'],
			'labels'              => array(
				'colors' => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_color'],
			),
		);

		$chart_options['grid'] = array(
			'borderColor' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_line_grid_color']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_line_grid_color'] : '#90A4AE',
			'yaxis'       => array(
				'lines' => array(
					'show' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_line_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_line_show'] === 'yes' ? true : false,
				),
			),
		);

		$chart_options['legend']['position'] = ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_legend_position']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_legend_position'] : 'buttom';
		$chart_options['xaxis']['categories'] = $categories;

		if (! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_area_curve'])) {
			$chart_options['stroke']['curve'] = $settings[GRAPHINA_PREFIX . $chart_type . '_chart_area_curve'];
		}

		$chart_options['tooltip']['shared'] = $settings[GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared'];

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

		$yaxis_enable_min_man = ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_enable_min_max']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_enable_min_max'] === 'yes' ? true : false;

		if ($yaxis_enable_min_man) {
			$chart_options['yaxis']['min'] = intval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_min_value']) ?? 0;
			$chart_options['yaxis']['max'] = intval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_max_value']) ?? 250;
		}

		if (! $legend_show) {
			$chart_options['legend'] = array(
				'showForSingleSeries' => true,
				'show'                => false,
			);
		}

		$is_zero_indicator = ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_show'] === 'yes' ? true : false;

		if ($is_zero_indicator) {
			$chart_options['annotations']['yaxis'] = array(
				array(
					'y'               => 0,
					'strokeDashArray' => intval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_stroke_dash']) ?? 6,
					'borderColor'     => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_stroke_color']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_stroke_color'] : '#000000',
				),
			);
		}

		$is_opposite_yaxis = ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title_enable']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title_enable'] === 'yes' ? true : false;

		if ($is_opposite_yaxis) {

			$rightYAxis = array();
			$leftYAxis  = array();

			// Loop through the data and filter based on yaxis value
			foreach ($series_temp as $item) {
				if ($item['yaxis'] === 1) {
					$rightYAxis[] = $item['name'];
				} elseif ($item['yaxis'] === 0) {
					$leftYAxis[] = $item['name'];
				}
			}

			if (is_array($leftYAxis) && ! empty($leftYAxis) && is_array($rightYAxis) && ! empty($rightYAxis)) {
				$chart_options['yaxis']['seriesName'] = $leftYAxis;
			}
			$chart_options['yaxis'] = array($chart_options['yaxis']);
			$yaxis_opposite_options = array(
				'opposite'        => true,
				'title'           => array(
					'text'  => $settings[GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title'],
					'style' => array(
						'color' => $settings[GRAPHINA_PREFIX . $chart_type . '_card_opposite_yaxis_title_font_color'],
						'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['unit'] : '12px',
						'fontFamily' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
						'fontWeight' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'] : '',
					),
				),
				'labels'          => array(
					'show'  => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_label_show']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_label_show'] === 'yes',
					'style' => array(
						'colors' => array($settings[GRAPHINA_PREFIX . $chart_type . '_card_opposite_yaxis_title_font_color']),
						'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size']['unit'] : '12px',
						'fontFamily' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_family'] : 'poppins',
						'fontWeight' => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_weight'] : '',
					),
				),
				'tickAmount'      => intval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_tick_amount']) ?? 6,
				'decimalsInFloat' => intval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_decimals_in_float']) ?? 1,
			);

			if (is_array($rightYAxis) && ! empty($rightYAxis) && is_array($leftYAxis) && ! empty($leftYAxis)) {
				$yaxis_opposite_options['seriesName'] = $rightYAxis;
			}

			if (! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_enable_min_max']) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_enable_min_max'] === 'yes') {
				$yaxis_opposite_options['min'] = floatval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_min_value']) ?? 0;
				$yaxis_opposite_options['max'] = floatval($settings[GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_max_value']) ?? 0;
			}
			$chart_options['yaxis'][] = $yaxis_opposite_options;
		}

		return $chart_options;
	}
}

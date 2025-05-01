<?php

namespace Graphina\Elementor\Widget;

use Graphina\Charts\Elementor\GraphinaApexChartBase;
use Graphina\Charts\Elementor\GraphinaElementorControls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly to ensure security.
}

/**
 * DistributeColumnChart Class
 *
 * This class defines the DistributeColumn Chart widget for the Graphina plugin,
 * integrating with Elementor to provide a customizable DistributeColumn Chart
 * powered by ApexCharts.
 *
 * Product: Graphina - Elementor Charts and Graphs
 * Purpose: To allow users to create visually appealing and dynamic DistributeColumn Charts
 *          with customizable options, leveraging Elementor's drag-and-drop interface.
 */
class DistributeColumnChart extends GraphinaApexChartBase {

	/**
	 * Get Widget Name
	 *
	 * Returns the unique identifier for the widget.
	 *
	 * @return string Widget name used internally.
	 */
	public function get_name() {
		return 'distributed_column_chart';
	}

	/**
	 * Get Widget Title
	 *
	 * Returns the display name of the widget shown in Elementor.
	 *
	 * @return string Translatable widget title.
	 */
	public function get_title() {
		return __( 'DistributeColumn Chart', 'graphina-charts-for-elementor' );
	}

	/**
	 * Get Widget Icon
	 *
	 * Returns the icon class for the widget shown in Elementor's widget panel.
	 *
	 * @return string Icon CSS class.
	 */
	public function get_icon() {
		return 'graphina-apex-column-chart';
	}

	/**
	 * Get Chart Type
	 *
	 * Specifies the type of chart this widget represents. In this case, 'column'.
	 *
	 * @return string Chart type identifier.
	 */
	public function get_chart_type(): string {
		return 'distributed_column';
	}

	/**
	 * Get Script Dependencies
	 *
	 * Lists the JavaScript dependencies required for this widget.
	 * Ensures necessary scripts are loaded for functionality.
	 *
	 * @return array List of script handles.
	 */
	public function get_script_depends() {
		return array( 'distributed_column-chart' );
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
	 * Lists the CSS dependencies required for this widget.
	 * Ensures necessary styles are loaded for proper visualization.
	 *
	 * @return array List of style handles.
	 */
	public function get_style_depends() {
		return array( 'column-chart' );
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
		$controls->graphina_common_chart_setting( $this, $chart_type, false, true, true );
		$controls->graphina_chart_legend_setting( $this, $chart_type );
		$controls->graphina_series_setting( $this, $chart_type, array( 'tooltip', 'color' ), true, array( 'classic', 'gradient', 'pattern' ), true, true );
		$controls->graphina_chart_x_axis_setting( $this, $chart_type );
		$controls->graphina_chart_y_axis_setting( $this, $chart_type );
		$controls->register_chart_restriction_controls( $this, $chart_type );
		apply_filters( 'graphina_password_form_style_section', $this, $chart_type );
	}

	/**

     * Render the widget output in the frontend.
     *
     * @param array $args Widget parameters from the widget's editor.
     * @param array $instance Widget instance settings.
	 */
	protected function graphina_prepare_chart_common_options( $settings, $chart_type, $element_id ) {
		$series_temp      = array();
		$series_count     = $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' ] ?? 0;
		$gradient         = '';

		$categories = $tooltip_series = $second_gradient = $fill_pattern = $gradient = array();
		
		$value_lists = isset( $settings[ GRAPHINA_PREFIX . $chart_type . '_value_list_4_1_' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_value_list_4_1_' ] : array();
		$chart_data  = array();
		foreach ( $value_lists as $index => $item ) {
			$chart_value = isset( $item[ GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' ] ) ? $item[ GRAPHINA_PREFIX . $chart_type . '_chart_value_4_' ] : null;
			if ( $chart_value !== null ) {
				$chart_data[] = $chart_value; // Add value to the chart data array
			}
		}
		$series_temp[] = array(
			'name' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_title_3_' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_title_3_' ] : '',
			'data' => $chart_data,
		);

		$series_count = isset( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' ] : 0;
		for ( $i = 0; $i < $series_count; $i++ ) {
			$dropshadow_series[] = $i;
			if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_enabled_on_1_' . $i ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_enabled_on_1_' . $i ] === 'yes' ) {
				$tooltip_series[] = $i;
			}
			$gradient[] = esc_html( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_1_' . $i ] );
			if ( strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_2_' . $i ] ) === '' ) {
				$second_gradient[] = esc_html( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_1_' . $i ] );
			} else {
				$second_gradient[] = esc_html( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_2_' . $i ] );
			}
			if ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_bg_pattern_' . $i ] !== '' ) {
				$fill_pattern[] = esc_html( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_bg_pattern_' . $i ] );
			} else {
				$fill_pattern[] = 'verticalLines';
			}
		}

		// Prepare categories
		if ( ! in_array( $chart_type, array( 'candle', 'donut', 'pie', 'polar', 'radial' ) ) ) {
			$category_list = $settings[ GRAPHINA_PREFIX . $chart_type . '_category_list' ] ?? array();
			$categories    = array_map(
				fn( $v ) => $chart_type === 'brush' ? intval( htmlspecialchars_decode( esc_html( graphina_get_dynamic_tag_data( $v, GRAPHINA_PREFIX . $chart_type . '_chart_category' ) ) ) ) : htmlspecialchars_decode( esc_html( graphina_get_dynamic_tag_data( $v, GRAPHINA_PREFIX . $chart_type . '_chart_category' ) ) ),
				$category_list
			);
		}

	
		$export_file_name = $settings[ GRAPHINA_PREFIX . $chart_type . '_export_filename' ] ?? '';
		$legend_show      = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_show' ] === 'yes' ? true : false;

		$locales = array(
			generate_chart_locales( get_locale() ),
		);

		$type_of_chart = '';
		$type_of_chart = $chart_type;

		$color_setting_key = GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show';
		$font_color_key    = GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color_1';
		$default_color 	   = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ] : '#000000';

		$datalabel_font_color = ! empty( $settings[ $color_setting_key ] ) && 'yes' === $settings[ $color_setting_key ]
			? $settings[ $font_color_key ]
			: $default_color;

		$color_array = array( esc_js( $datalabel_font_color ) );


		$chart_options = array(
			'series'     => $series_temp,
			'chart'      => array(
				'id'            => $element_id,
				'background'    => ! empty($settings[ GRAPHINA_PREFIX . $chart_type . '_chart_background_color1' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_background_color1' ] : '',
				'height'        => ! empty($settings[ GRAPHINA_PREFIX . $chart_type . '_chart_height' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_height' ] : '350',
				'type'          => $type_of_chart,
				'stacked'       => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_area_stacked' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_area_stacked' ] : '',
				'toolbar'       => array(
					'offsetX' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_offsetx' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_offsetx' ] ) : 0,
					'offsetY' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_offsety' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_offsety' ] ) : 0,
					'show'    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_can_chart_show_toolbar' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_can_chart_show_toolbar' ] === 'yes' ? true : false,
					'export'  => array(
						'csv' => array(
							'filename' => esc_js( $export_file_name ),
						),
						'svg' => array(
							'filename' => esc_js( $export_file_name ),
						),
						'png' => array(
							'filename' => esc_js( $export_file_name ),
						),
					),
					'tools'   => array(
						'download' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_download' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_download' ] === 'yes' ? true : false,
					),
				),
				'zoom' => [
					'enabled' => false
				],
				'dropShadow'    => array(
					'enabled' => $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow' ] ?? false,
					'top'     => $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_top' ] ?? 0,
					'left'    => $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_left' ] ?? 0,
					'blur'    => $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_blur' ] ?? 0,
					'color'   => $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_color' ] ?? '',
					'opacity' => $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_opacity' ] ?? 0,
				),
				'animations'    => array(
					'enabled' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_animation' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_animation' ] === 'yes' ? true : false,
					'speed'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_animation_speed' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_animation_speed' ] : 800,
					'delay'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_animation_delay' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_animation_delay' ] : 150,
			),

				'locales'       => $locales,
				'defaultLocale' => get_locale(),
			),
			'xaxis'      => array(
				'tickAmount'    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_tick_amount' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_tick_amount' ] ) : 6,
				'position'      => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_position' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_position' ] : 'buttom',
				'labels'        => array(
					'show'         => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' ] === 'yes' ? true : false,
					'rotateAlways' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_auto_rotate' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_auto_rotate' ] === 'yes' ? true : false,
					'rotate'       => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_rotate' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_rotate' ] ) : 0,
					'offsetX'      => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_offset_x' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_offset_x' ] ) : 0,
					'offsetY'      => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_offset_y' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_offset_y' ] ) : 0,
					'trim'         => true,
					'style'        => array(
						'colors'     => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ] ) ? strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ] ) : '#000000',
						'fontSize'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px',
						'fontFamily' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ] : 'poppins',
						'fontWeight' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight' ] : '',
					),
				),
				'tooltip'       => array(
					'enabled' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_tooltip_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_tooltip_show' ] === 'yes' ? true : false,
				),
				'crosshairs'    => array(
					'show' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_crosshairs_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_crosshairs_show' ] === 'yes' ? true : false,
				),
			),
			'yaxis'      => array(
				'tickAmount'      => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_tick_amount' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_tick_amount' ] ) : 6,
				'decimalsInFloat' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_decimals_in_float' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_decimals_in_float' ] ) : 1,
				'labels'          => array(
					'show'    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' ] === 'yes' ? true : false,
					'offsetX' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_offset_x' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_offset_x' ] ) : 0,
					'offsetY' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_offset_y' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_offset_y' ] ) : 0,
					'style'        => array(
						'colors'     => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ] ) ? strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ] ) : '#000000',
						'fontSize'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px',
						'fontFamily' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ] : 'poppins',
						'fontWeight' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight' ] : '',
					),
				),
				'tooltip'         => array(
					'enabled' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_tooltip_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_tooltip_show' ] === 'yes' ? true : false,
				),
				'crosshairs'      => array(
					'show' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_crosshairs_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_crosshairs_show' ] ? true : false,
				),
			),
			'legend'     => array(
				'showForSingleSeries' => true,
				'show'                => $legend_show,
				'horizontalAlign'     => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_horizontal_align' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_horizontal_align' ] : 'center',
				'fontSize'   		  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px',
				'fontFamily' 		  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ] : 'poppins',
				'fontWeight' 		  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight' ] : '',
				'labels'	 		  => [
					'colors'	=> ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ] : '',
				],
			),
			'dataLabels' => array(
				'enabled'    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show' ] === 'yes' ? true : false,
				'style'      => array(
					'fontSize'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px',
					'fontFamily' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ] : 'poppins',
					'fontWeight' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight' ] : '',
					'colors'     => [ ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show' ]) && $settings[GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show' ] === 'yes' ? $settings[ GRAPHINA_PREFIX . $chart_type .  '_chart_datalabel_font_color_1' ] : $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color' ]]
				),
				'background' => array(
					'enabled'      => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show' ] === 'yes' ? true : false,
					'borderRadius' => intval( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_radius' ] ) ? esc_js( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_radius' ] ) : 0 ),
					'foreColor'    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_color' ] ) ? array( esc_js( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_color' ] ) ) : '#ffffff',
					'borderWidth'  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_width' ] ) ? intval( esc_js( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_width' ] ) ) : 1,
					'borderColor'  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_color' ] ) ? esc_js( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_color' ] ) : '#ffffff',
				),
			),
			'noData'     => array(
				'text' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_no_data_text' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_no_data_text' ] : esc_html__('No Data Available','graphina-charts-for-elementor'),
			),
			'tooltip'    => array(
				'enabled' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip' ] === 'yes' ? true : false,
				'theme'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_theme' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_theme' ] : 'light',
			),
		);
	
		$chart_options['dataLabels']  = array(
			'enabled' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show' ] === 'yes',
			'offsetX' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_offsetx' ],
			'offsetY' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_offsety' ],
			'background' => array(
				'enabled'      => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show' ] === 'yes' ? true : false,
				'borderRadius' => intval( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_radius' ] ) ? esc_js( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_radius' ] ) : 0 ),
				'foreColor'    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_color' ] ) ? array( esc_js( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_color' ] ) ) : '#ffffff',
				'borderWidth'  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_width' ] ) ? intval( esc_js( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_width' ] ) ) : 1,
				'borderColor'  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_color' ] ) ? esc_js( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_color' ] ) : '#ffffff',
			),
		);
		$chart_options['dataLabels']['style']['colors'] = $color_array;
		$chart_options['colors']      = $gradient;
		$chart_options['plotOptions'] = array(
			'bar' => array(
				'distributed'  => true,
				'columnWidth'  => ! empty($settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_stroke_width' ]) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_stroke_width' ].'%' : '12%',
				'borderRadius' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_plot_border_radius' ] ?? 0, // Added fallback
				'dataLabels'   => array( // Fixed assignment operator
					'position'    => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_position_show' ] ?? 'top', // Added fallback
					'orientation' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_orientation' ] ?? 'horizontal', // Added fallback
				),
			),
		);

		$chart_options['fill']               = array(
			'type'     => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type' ],
			'opacity'  => floatval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_fill_opacity' ] ),
			'colors'   => $gradient,
			'gradient' => array(
				'gradientToColors' => $second_gradient,
				'type'             => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_type' ],
				'inverseColors'    => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_inversecolor' ] === 'yes',
				'opacityFrom'      => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_opacityFrom' ],
				'opacityTo'        => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_opacityTo' ],
			),
			'pattern'  => array(
				'style'       => $fill_pattern,
				'width'       => 6,
				'height'      => 6,
				'strokeWidth' => 2,
			),
		);
		$chart_options['grid']               = array(
			'borderColor' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_line_grid_color' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_line_grid_color' ] : '#90A4AE',
			'yaxis'       => array(
				'lines' => array(
					'show' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_line_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_line_show' ] === 'yes' ? true : false,
				),
			),
		);
		$chart_options['yaxis']['opposite']  = $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_position' ];
		$chart_options['legend']['position'] = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_position' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_position' ] : 'bottom';

		$chart_options['position'] = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_position' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_position' ] : 'buttom';
		$chart_options['xaxis']['categories'] = $categories;

		if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_area_curve' ] ) ) {
			$chart_options['stroke']['curve'] = $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_area_curve' ];
		}
		$chart_options['tooltip']['intersect'] 	= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared' ] === 'yes' ? false : true;
		$chart_options['tooltip']['shared']		= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared' ] === 'yes' ? true : false;
		
		$xaxis_title_show = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title_enable' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title_enable' ] === 'yes' ? true : false;

		if ( $xaxis_title_show && ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title' ] ) ) {

			$chart_options['xaxis']['title'] = array(
				'text'    => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title' ],
				'offsetX' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title_offset_x' ],
				'offsetY' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title_offset_y' ],
				'style'   => array(
					'color'      => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ],
					'fontSize'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px',
					'fontFamily' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ],
					'fontWeight' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight' ],
				),
			);
		}

		$yaxis_title_show = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title_enable' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title_enable' ] === 'yes' ? true : false;
		if ( $yaxis_title_show && ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title' ] ) ) {

			$chart_options['yaxis']['title'] = array(
				'text'  => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title' ],
				'style' => array(
					'color'      => $settings[ GRAPHINA_PREFIX . $chart_type . '_card_yaxis_title_font_color' ],
					'fontSize'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px',
					'fontFamily' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ],
					'fontWeight' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight' ],
				),
			);
		}

		$yaxis_enable_min_man = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_enable_min_max' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_enable_min_max' ] === 'yes' ? true : false;

		if ( $yaxis_enable_min_man ) {
			$chart_options['yaxis']['min'] = floatval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_min_value' ] ) ?? 0;
			$chart_options['yaxis']['max'] = floatval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_max_value' ] ) ?? 250;
		}

		if ( ! $legend_show ) {
			$chart_options['legend'] = array(
				'showForSingleSeries' => true,
				'show'                => false,
			);
		}

		$is_zero_indicator = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_show' ] === 'yes' ? true : false;

		if ( $is_zero_indicator ) {
			$chart_options['annotations']['yaxis'] = array(
				array(
					'y'               => 0,
					'strokeDashArray' => intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_stroke_dash' ] ) ?? 6,
					'borderColor'     => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_stroke_color' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_stroke_color' ] : '#000000',
				),
			);
		}

		return $chart_options;
	}
}

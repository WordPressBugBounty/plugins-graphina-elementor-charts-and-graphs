<?php
/**
 * Graphina chart/table utility function (file autoload by composer)
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina_Charts_For_Elementor
 */

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Element_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Retrieve default settings.
 *
 * This function returns default settings based on the provided key.
 * It supports returning integer and string data types.
 *
 * @param string $key       The setting key to retrieve.
 * @param string $data_type The expected data type of the setting value. Defaults to 'int'.
 *
 * @return array|int|string The value of the setting. Returns 0 for integer/float data types if the key is not found.
 *               Returns an empty string for other data types if the key is not found.
 */
function graphina_default_setting( string $key, string $data_type = 'int' ): array|int|string {
	$list = array(
		'max_series_value' => apply_filters( 'graphina_max_series_value', 31 ),
		'categories'       => array(
			'Jan',
			'Feb',
			'Mar',
			'Apr',
			'May',
			'Jun',
			'July',
			'Aug',
			'Sep',
			'Oct',
			'Nov',
			'Dec',
			'Jan1',
			'Feb1',
			'Mar1',
			'Apr1',
			'May1',
			'Jun1',
			'July1',
			'Aug1',
			'Sep1',
			'Oct1',
			'Nov1',
			'Dec1',
			'Jan2',
			'Feb2',
			'Mar2',
			'Apr2',
			'May2',
			'Jun2',
			'July2',
			'Aug2',
		),
	);
	if ( isset( $list[ $key ] ) ) {
		return $list[ $key ];
	}
	if ( in_array( $data_type, array( 'int', 'float' ), true ) ) {
		return 0;
	}
	return '';
}

/**
 * Get stroke curve type options for Graphina.
 *
 * This function returns an array of stroke curve type options, or the first key if specified.
 *
 * @param bool $first Whether to return only the first key of the options array. Defaults to false.
 *
 * @return array|string The array of stroke curve type options or the first key of the options array.
 */
function graphina_stroke_curve_type( bool $first = false ): array|string {
	// Define the stroke curve type options.
	$options = array(
		'smooth'   => esc_html__( 'Smooth', 'graphina-charts-for-elementor' ),
		'straight' => esc_html__( 'Straight', 'graphina-charts-for-elementor' ),
		'stepline' => esc_html__( 'Stepline', 'graphina-charts-for-elementor' ),
	);

	// Return the first key if $first is true, otherwise return the options array.
	return $first ? 'smooth' : $options;
}


/**
 * Get position type options for Graphina.
 *
 * This function returns an array of position type options based on the provided type.
 * If $first is true, it returns only the first key of the options array.
 *
 * @param string $type  The type of position options to retrieve. Defaults to 'vertical'.
 * @param bool   $first Whether to return only the first key of the options array. Defaults to false.
 *
 * @return array|int|string|null The array of position type options or the first key of the options array.
 */
function graphina_position_type( string $type = 'vertical', bool $first = false ): array|int|string|null {
	$result = array();
	switch ( $type ) {
		case 'vertical':
			$result = array(
				'top'    => esc_html__( 'Top', 'graphina-charts-for-elementor' ),
				'center' => esc_html__( 'Center', 'graphina-charts-for-elementor' ),
				'bottom' => esc_html__( 'Bottom', 'graphina-charts-for-elementor' ),
			);
			break;
		case 'horizontal_boolean':
			$result = array(
				''    => array(
					'title' => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
					'icon'  => 'fa fa-arrow-left',
				),
				'yes' => array(
					'title' => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
					'icon'  => 'fa fa-arrow-right',
				),
			);
			break;

		case 'placement':
			$result = array(
				'on'      => esc_html__( 'On', 'graphina-charts-for-elementor' ),
				'between' => esc_html__( 'Between', 'graphina-charts-for-elementor' ),
			);
			break;
		case 'in_out':
				$result = array(
					'in'  => esc_html__( 'In', 'graphina-charts-for-elementor' ),
					'out' => esc_html__( 'Out', 'graphina-charts-for-elementor' ),
				);
			break;
		case 'google_chart_legend_position':
			$result = array(
				'top'    => esc_html__( 'Top', 'graphina-charts-for-elementor' ),
				'bottom' => esc_html__( 'Bottom', 'graphina-charts-for-elementor' ),
				'left'   => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
				'right'  => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
				'in'     => esc_html__( 'Inside', 'graphina-charts-for-elementor' ),
			);
			break;
		case 'google_piechart_legend_position':
				$result = array(
					'top'     => esc_html__( 'Top', 'graphina-charts-for-elementor' ),
					'bottom'  => esc_html__( 'Bottom', 'graphina-charts-for-elementor' ),
					'left'    => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
					'right'   => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
					'labeled' => esc_html__( 'Labeled', 'graphina-charts-for-elementor' ),
				);
			break;
		case 'orientation':
			$result = array(
				'horizontal'	=> esc_html__('Horizontal','graphina-charts-for-elementor' ),
				'vertical'		=> esc_html__('Vertical', 'graphina-charts-for-elementor' ),
			);
			break;
	}
	// Return the first key if $first is true, otherwise return the options array.
	return $first ? array_key_first( $result ) : $result;
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
function graphina_get_fill_patterns( bool $first = false ): array|string {
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
 * Get chart data enter options for Graphina.
 *
 * This function returns an array of chart data enter options based on the provided type and chart type.
 * If $first is true, it returns only the first key of the options array.
 *
 * @param string $type       The type of data enter options to retrieve. Defaults to 'base'.
 * @param string $chart_type The chart type to consider for specific options.
 * @param bool   $first      Whether to return only the first key of the options array. Defaults to false.
 *
 * @return array|int|string|null The array of chart data enter options or the first key of the options array.
 */
function graphina_chart_data_enter_options( string $type = '', string $chart_type = '', bool $first = false ): array|int|string|null {
	$options = array();
	$type    = ! empty( $type ) ? $type : 'base';
	switch ( $type ) {
		case 'base':
			$options = array(
				'manual'  => esc_html__( 'Manual', 'graphina-charts-for-elementor' ),
				'dynamic' => esc_html__( 'Dynamic', 'graphina-charts-for-elementor' ),
			);

			if ( get_option( 'graphina_firebase_addons' ) === '1' ) {
				$options['firebase'] = esc_html__( 'Firebase', 'graphina-charts-for-elementor' );
			}
			if ( graphina_forminator_addon_active() ) {
				if ( in_array(
					$chart_type,
					array(
						'line',
						'column',
						'area',
						'pie',
						'donut',
						'radial',
						'radar',
						'polar',
						'data_table_lite',
						'distributed_column',
						'scatter',
						'mixed',
						'brush',
						'pie_google',
						'donut_google',
						'line_google',
						'area_google',
						'column_google',
						'bar_google',
						'gauge_google',
						'geo_google',
						'org_google',
					),
					true
				) ) {
					$options['forminator'] = esc_html__( 'Forminator Addon', 'graphina-charts-for-elementor' );
				}
			}
			break;
		case 'dynamic':
			$options         = array(
				'csv'          => esc_html__( 'CSV', 'graphina-charts-for-elementor' ),
				'remote-csv'   => esc_html__( 'Remote CSV', 'graphina-charts-for-elementor' ),
				'google-sheet' => esc_html__( 'Google Sheet', 'graphina-charts-for-elementor' ),
				'api'          => esc_html__( 'API', 'graphina-charts-for-elementor' ),
			);
			$sql_builder_for = array( 'line', 'column', 'area', 'pie', 'donut', 'radial', 'radar', 'polar', 'data_table_lite', 'distributed_column', 'scatter', 'mixed', 'brush', 'pie_google', 'donut_google', 'line_google', 'area_google', 'column_google', 'bar_google', 'gauge_google', 'geo_google', 'org_google' );
			if ( in_array( $chart_type, $sql_builder_for, true ) ) {
				$options['sql-builder'] = esc_html__( 'SQL Builder', 'graphina-charts-for-elementor' );
			}
			if ( graphina_pro_active() ) {
				$options['filter'] = esc_html__( 'Data From Filter', 'graphina-charts-for-elementor' );
			}
			break;
	}

	// Return the first key if $first is true, otherwise return the options array.
	return $first ? array_key_first( $options ) : $options;
}

/**
 * Get fill style type options for Graphina.
 *
 * This function returns an array of fill style type options based on the provided types.
 * If $first is true, it returns only the first key of the options array.
 *
 * @param array $types The types of fill styles to include in the options.
 * @param bool  $first Whether to return only the first key of the options array. Defaults to false.
 *
 * @return array|int|string|null The array of fill style type options or the first key of the options array.
 */
function graphina_fill_style_type( array $types, bool $first = false ): array|int|string|null {
	$options = array();

	if ( in_array( 'classic', $types, true ) ) {
		$options['classic'] = array(
			'title' => esc_html__( 'Classic', 'graphina-charts-for-elementor' ),
			'icon'  => 'fa fa-paint-brush',
		);
	}
	if ( in_array( 'gradient', $types, true ) ) {
		$options['gradient'] = array(
			'title' => esc_html__( 'Gradient', 'graphina-charts-for-elementor' ),
			'icon'  => 'fa fa-barcode',
		);
	}
	if ( in_array( 'pattern', $types, true ) ) {
		$options['pattern'] = array(
			'title' => esc_html__( 'Pattern', 'graphina-charts-for-elementor' ),
			'icon'  => 'fa fa-bars',
		);
	}
	// Return the first key if $first is true, otherwise return the options array.
	return $first ? array_key_first( $options ) : $options;
}

/**
 * Add basic setting controls for Graphina charts.
 *
 * This function adds a section of controls to the specified Elementor element
 * for configuring basic settings of a Graphina chart.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     The type of chart (default is 'chart_id').
 *
 * @return void
 */
function graphina_basic_setting( Element_Base $this_ele, string $type = 'chart_id' ): void {

	$this_ele->start_controls_section(
		'iq_' . $type . '_section_1',
		array(
			'label' => esc_html__( 'Basic Setting', 'graphina-charts-for-elementor' ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_card_show',
		array(
			'label'     => esc_html__( 'Card', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			'default'   => 'yes',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_is_card_heading_show',
		array(
			'label'     => esc_html__( 'Heading', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
			'default'   => 'yes',
			'condition' => array(
				'iq_' . $type . '_chart_card_show' => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_heading',
		array(
			'label'     => esc_html__( 'Card Heading', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => 'My Example Heading',
			'condition' => array(
				'iq_' . $type . '_is_card_heading_show' => 'yes',
				'iq_' . $type . '_chart_card_show'      => 'yes',
			),
			'dynamic'   => array(
				'active' => true,
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_is_card_desc_show',
		array(
			'label'     => esc_html__( 'Description', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
			'default'   => 'yes',
			'condition' => array(
				'iq_' . $type . '_chart_card_show' => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_content',
		array(
			'label'     => 'Card Description',
			'type'      => Controls_Manager::TEXTAREA,
			'default'   => 'My Other Example Heading',
			'condition' => array(
				'iq_' . $type . '_is_card_desc_show' => 'yes',
				'iq_' . $type . '_chart_card_show'   => 'yes',
			),
			'dynamic'   => array(
				'active' => true,
			),
		)
	);

	$this_ele->end_controls_section();
}

/**
 * Add chart data option settings controls for Graphina charts.
 *
 * This function adds a section of controls to the specified Elementor element
 * for configuring chart data options of a Graphina chart.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type The type of chart (default is 'chart_id').
 * @param int          $default_count The default number of data series (default is 0).
 * @param bool         $show_negative Whether to show options for negative values (default is false).
 *
 * @return void
 */
function graphina_chart_data_option_setting( Element_Base $this_ele, string $type = 'chart_id', int $default_count = 0, bool $show_negative = false ): void {
	$this_ele->start_controls_section(
		'iq_' . $type . '_section_5_2',
		array(
			'label' => esc_html__( 'Chart Data Options', 'graphina-charts-for-elementor' ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_is_pro',
		array(
			'label'   => esc_html__( 'Is Pro', 'graphina-charts-for-elementor' ),
			'type'    => Controls_Manager::HIDDEN,
			'default' => graphina_pro_active() === true ? 'true' : 'false',
		)
	);

	if ( $type === 'demo' ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_data_option',
			array(
				'label'   => esc_html__( 'Type', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::HIDDEN,
				'default' => 'manual',
			)
		);
	} else {
		$this_ele->add_control(
			'iq_' . $type . '_chart_data_option',
			array(
				'label'   => esc_html__( 'Type', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => graphina_chart_data_enter_options( 'base', $type, true ),
				'options' => graphina_chart_data_enter_options( 'base', $type ),
			)
		);
	}
	$series_test = 'Elements';
	if ( $type !== 'geo_google' ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_data_series_count',
			array(
				'label'   => esc_html__( 'Data ', 'graphina-charts-for-elementor' ) . $series_test,
				'type'    => Controls_Manager::NUMBER,
				'default' => $default_count !== 0 ? $default_count : ( in_array( $type, array( 'pie', 'polar', 'donut', 'radial', 'bubble', 'pie_google', 'donut_google', 'org_google' ), true ) ? 5 : 1 ),
				'min'     => 1,
				'max'     => $type === 'gantt_google' ? 1 : graphina_default_setting( 'max_series_value' ),
			)
		);
	}

	if ( $show_negative && ( ! in_array( $type, array( 'pie_google', 'donut_google', 'gauge_google', 'geo_google', 'org_google', 'gantt_google' ), true ) ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_can_chart_negative_values',
			array(
				'label'       => esc_html__( 'Default Negative Value', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'label_off'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'description' => esc_html__( 'Show default chart with some negative values', 'graphina-charts-for-elementor' ),
				'default'     => false,
				'condition'   => array(
					'iq_' . $type . '_chart_data_option' => 'manual',
				),
			)
		);
	}

	if ( ! in_array( $type, array( 'nested_column', 'brush', 'gantt_google' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_can_chart_reload_ajax',
			array(
				'label'     => esc_html__( 'Reload Ajax', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'True', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'False', 'graphina-charts-for-elementor' ),
				'default'   => false,
				'condition' => array(
					'iq_' . $type . '_chart_data_option!' => array( 'manual' ),
				),
			)
		);
	}

	$this_ele->add_control(
		'iq_' . $type . '_interval_data_refresh',
		array(
			'label'     => __( 'Set Interval(sec)', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'min'       => 5,
			'step'      => 5,
			'default'   => 15,
			'condition' => array(
				'iq_' . $type . '_can_chart_reload_ajax' => 'yes',
				'iq_' . $type . '_chart_data_option!'    => array( 'manual' ),
			),
		)
	);

	$this_ele->end_controls_section();

	if ( in_array(
		$type,
		array(
			'line',
			'column',
			'area',
			'pie',
			'donut',
			'radial',
			'radar',
			'polar',
			'data_table_lite',
			'distributed_column',
			'scatter',
			'mixed',
			'brush',
			'pie_google',
			'donut_google',
			'line_google',
			'area_google',
			'column_google',
			'bar_google',
			'gauge_google',
			'geo_google',
			'org_google',
		),
		true
	) ) {
		do_action( 'graphina_forminator_addon_control_section', $this_ele, $type );
	}

	do_action( 'graphina_addons_control_section', $this_ele, $type );

	$this_ele->start_controls_section(
		'iq_' . $type . '_section_5_2_1',
		array(
			'label'     => esc_html__( 'Dynamic Data Options', 'graphina-charts-for-elementor' ),
			'condition' => array(
				'iq_' . $type . '_chart_data_option' => array( 'dynamic' ),
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_dynamic_data_option',
		array(
			'label'   => esc_html__( 'Type', 'graphina-charts-for-elementor' ),
			'type'    => Controls_Manager::SELECT,
			'default' => graphina_chart_data_enter_options( 'dynamic', $type, true ),
			'options' => graphina_chart_data_enter_options( 'dynamic', $type ),
		)
	);

	if ( graphina_pro_active() ) {
		graphina_pro_get_dynamic_options( $this_ele, $type );
	}

	if ( ! graphina_pro_active() ) {

		$this_ele->add_control(
			'iq_' . $type . 'get_pro',
			array(
				'type' => Controls_Manager::RAW_HTML,
				'raw'  => graphina_get_teaser_template(
					array(
						'title'    => esc_html__( 'Get New Exciting Features', 'graphina-charts-for-elementor' ),
						'messages' => array( 'Get Graphina Pro for above exciting features and more.' ),
						'link'     => 'https://codecanyon.net/item/graphinapro-elementor-dynamic-charts-datatable/28654061',
					)
				),
			)
		);
	}

	$this_ele->end_controls_section();

	if ( ! in_array( $type, array( 'mixed', 'brush', 'nested_column', 'area_google', 'pie_google', 'bar_google', 'column_google', 'donut_google', 'gauge_google', 'geo_google', 'org_google' ), true ) ) {
		graphina_charts_filter_settings( $this_ele, $type );
	}
	if ( graphina_pro_active() ) {
		graphina_restriction_content_options( $this_ele, $type );
	}
}

/**
 * Function to add common chart settings controls for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type                Type of chart being configured.
 * @param bool         $show_data_label     Whether to show data labels.
 * @param bool         $label_add_fixed     Whether to add fixed labels.
 * @param bool         $label_position      Whether to show label positions.
 * @param bool         $show_label_background Whether to show label background.
 * @param bool         $show_label_color    Whether to show label font color.
 *
 * @return void
 */
function graphina_common_chart_setting( Element_Base $this_ele, string $type = 'chart_id', bool $show_data_label = false, bool $label_add_fixed = true, bool $label_position = false, bool $show_label_background = true, bool $show_label_color = true ): void {

	$this_ele->add_control(
		'iq_' . $type . '_chart_background_color1',
		array(
			'label' => esc_html__( 'Chart Background Color', 'graphina-charts-for-elementor' ),
			'type'  => Controls_Manager::COLOR,
		)
	);

	$responsive = 'add_responsive_control';

	$this_ele->$responsive(
		'iq_' . $type . '_chart_height',
		array(
			'label'           => esc_html__( 'Height (px)', 'graphina-charts-for-elementor' ),
			'type'            => Controls_Manager::NUMBER,
			'default'         => $type === 'brush' ? 175 : 350,
			'step'            => 5,
			'min'             => 10,
			'desktop_default' => $type === 'brush' ? 175 : 350,
			'tablet_default'  => $type === 'brush' ? 175 : 350,
			'mobile_default'  => $type === 'brush' ? 175 : 350,
		)
	);

	if ( in_array( $type, array( 'line', 'area', 'column', 'pie', 'polar', 'donut', 'scatter', 'line_google', 'area_google', 'bar_google', 'column_google' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_dynamic_change_chart_type',
			array(
				'label'     => esc_html__( 'Change Chart Type ', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => false,
			)
		);
	}

	if ( $type !== 'brush' ) {

		if ( ! in_array( $type, array( 'line_google', 'area_google', 'bar_google', 'column_google', 'pie_google', 'donut_google', 'geo_google', 'gauge_google', 'org_google' ), true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_can_chart_show_toolbar',
				array(
					'label'     => esc_html__( 'Toolbar', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => false,
				)
			);

			if ( in_array( $type, array( 'line') ) ){
				$this_ele->add_control(
					'iq_' . $type . '_chart_toolbar_download',
					array(
	
						'label'     => esc_html__( 'Download Option', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'condition' => array(
							'iq_' . $type . '_can_chart_show_toolbar' => 'yes',
						),
					)
				);
			}

			$this_ele->add_control(
				'iq_' . $type . '_chart_toolbar_offsety',
				array(

					'label'     => esc_html__( 'Offset-Y', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 0,
					'condition' => array(
						'iq_' . $type . '_can_chart_show_toolbar' => 'yes',
					),
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_toolbar_offsetx',
				array(

					'label'     => esc_html__( 'Offset-X', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 0,
					'condition' => array(
						'iq_' . $type . '_can_chart_show_toolbar' => 'yes',
					),
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_export_filename',
				array(
					'label'     => esc_html__( 'Export Filename', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'condition' => array(
						'iq_' . $type . '_can_chart_show_toolbar' => 'yes',
					),
					'dynamic'   => array(
						'active' => true,
					),
				)
			);
		}
	}

	if ( ! in_array( $type, array( 'line_google', 'area_google', 'bar_google', 'column_google', 'pie_google', 'donut_google', 'gauge_google', 'org_google' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_no_data_text',
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

	// ------ Datalabel Setting Start ------
	if ( in_array( $type, array( 'area', 'line' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_stacked',
			array(
				'label'     => esc_html__( 'Stacked ', 'graphina-charts-for-elementor' ) . ucfirst( $type ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => false,
			)
		);
	}

	if ( ! in_array( $type, array( 'line_google', 'area_google', 'column_google', 'bar_google', 'pie_google', 'donut_google', 'org_google' ), true ) ) {

		$this_ele->add_control(
			'iq_' . $type . '_chart_hr_datalabel_setting',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_datalabel_setting_title',
			array(
				'label' => esc_html__( 'Label Settings', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_datalabel_show',
			array(
				'label'     => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => $show_data_label === true ? 'yes' : false,
			)
		);

		if ( $type === 'timeline' ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabel_hide_show_text',
				array(
					'label'     => esc_html__( 'Show Text', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => 'yes',
				)
			);
		}

		if ( in_array( $type, array( 'radial', 'pie', 'donut' ), true ) ) {

			if ( in_array( $type, array( 'pie', 'donut' ), true ) ) {
				$this_ele->add_control(
					'iq_' . $type . '_chart_center_datalabel_show',
					array(
						'label'     => esc_html__( 'Show Center Label', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'default'   => $show_data_label === true ? 'yes' : false,
						'condition' => array(
							'iq_' . $type . '_chart_datalabel_show' => 'yes',
						),
					)
				);
			}
			if ( $type === 'radial' ) {
				$this_ele->add_control(
					'iq_' . $type . '_chart_datalabel_total_title_show',
					array(
						'label'     => esc_html__( 'Show Total Label', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'condition' => array(
							'iq_' . $type . '_chart_datalabel_show' => 'yes',
						),
					)
				);
			}

			if ( $type !== 'radial' ) {

				$this_ele->add_control(
					'iq_' . $type . '_chart_datalabel_total_title_show',
					array(
						'label'     => esc_html__( 'Show Total Value', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'condition' => array(
							'iq_' . $type . '_chart_datalabel_show' => 'yes',
							'iq_' . $type . '_chart_center_datalabel_show' => 'yes',
						),
					)
				);

				$condition_title = array(
					'iq_' . $type . '_chart_datalabel_show' => 'yes',
					'iq_' . $type . '_chart_center_datalabel_show' => 'yes',
					'iq_' . $type . '_chart_datalabel_total_title_show' => 'yes',
				);
				$this_ele->add_control(
					'iq_' . $type . '_chart_datalabel_total_title_always',
					array(
						'label'       => esc_html__( 'Show Always Total', 'graphina-charts-for-elementor' ),
						'type'        => Controls_Manager::SWITCHER,
						'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
						'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
						'condition'   => $condition_title,
						'description' => esc_html__( 'Note: Always show the total label and do not remove it even when  clicks/hovers over the slices.', 'graphina-charts-for-elementor' ),
					)
				);

				$this_ele->add_control(
					'iq_' . $type . '_chart_datalabel_total_title',
					array(
						'label'     => esc_html__( 'Total Text', 'graphina-charts-for-elementor' ),
						'type'      => Controls_Manager::TEXT,
						'default'   => esc_html__( 'Total', 'graphina-charts-for-elementor' ),
						'condition' => $condition_title,
					)
				);
			}
		}

		if ( in_array( $type, array( 'radar', 'heatmap', 'radial', 'brush', 'distributed_column' ), true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_label_pointer_for_label',
				array(
					'label'       => esc_html__( 'Format Number to String', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::SWITCHER,
					'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'condition'   => array(
						'iq_' . $type . '_chart_datalabel_show' => 'yes',
					),
					'default'     => false,
					'description' => esc_html__( 'Note: Convert 1,000  => 1k and 1,000,000 => 1m and if Format Number(Commas) is enable this will not work', 'graphina-charts-for-elementor' ),
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_label_pointer_number_for_label',
				array(
					'label'     => esc_html__( 'Number of Decimal Want', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 1,
					'min'       => 0,
					'condition' => array(
						'iq_' . $type . '_chart_datalabel_show' => 'yes',
						'iq_' . $type . '_chart_label_pointer_for_label' => 'yes',
					),
				)
			);
		}

		if ( ! in_array( $type, array( 'pie', 'donut', 'polar', 'nested_column', 'radial', 'column' ), true ) ) {

			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabel_offsety',
				array(

					'label'     => esc_html__( 'Offset-Y', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => -20,
					'condition' => array(
						'iq_' . $type . '_chart_datalabel_show' => 'yes',
					),
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabel_offsetx',
				array(

					'label'     => esc_html__( 'Offset-X', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 0,
					'condition' => array(
						'iq_' . $type . '_chart_datalabel_show' => 'yes',
					),
				)
			);
		}

		if ( in_array( $type, array( 'pie', 'donut', 'polar' ), true ) ) {

			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabels_format',
				array(
					'label'     => esc_html__( 'Format(tooltip/label)', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => 'no',
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabels_format_showlabel',
				array(
					'label'     => esc_html__( 'Show label', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => 'no',
					'condition' => array(
						'iq_' . $type . '_chart_datalabels_format' => 'yes',
					),
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabels_format_showValue',
				array(
					'label'     => esc_html__( 'Show Value', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => 'yes',
					'condition' => array(
						'iq_' . $type . '_chart_datalabels_format' => 'yes',
					),
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_label_pointer',
				array(
					'label'       => esc_html__( 'Format Number to String', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::SWITCHER,
					'condition'   => array(
						'iq_' . $type . '_chart_datalabels_format' => 'yes',
						'iq_' . $type . '_chart_datalabels_format_showValue' => 'yes',
					),
					'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'     => false,
					'description' => esc_html__( 'Note: Convert 1,000  => 1k and 1,000,000 => 1m and if Format Number(Commas) is enable this will not work', 'graphina-charts-for-elementor' ),
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_label_pointer_number',
				array(
					'label'     => esc_html__( 'Number of Decimal Want', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 1,
					'min'       => 0,
					'condition' => array(
						'iq_' . $type . '_chart_datalabels_format' => 'yes',
						'iq_' . $type . '_chart_datalabels_format_showValue' => 'yes',
						'iq_' . $type . '_chart_label_pointer' => 'yes',
					),
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabel_format_prefix',
				array(
					'label'     => esc_html__( 'Label Prefix', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'condition' => array(
						'iq_' . $type . '_chart_datalabels_format' => 'yes',
					),
					'dynamic'   => array(
						'active' => true,
					),
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabel_format_postfix',
				array(
					'label'     => esc_html__( 'Label Postfix', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'condition' => array(
						'iq_' . $type . '_chart_datalabels_format' => 'yes',
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
							'name'     => 'iq_' . $type . '_chart_datalabel_show',
							'operator' => '==',
							'value'    => 'yes',
						),
					),
				),
			),
		);

		if ( $label_position ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabel_position_show',
				array(
					'label'      => esc_html__( 'Position', 'graphina-charts-for-elementor' ),
					'type'       => Controls_Manager::SELECT,
					'default'    => graphina_position_type( 'vertical', true ),
					'options'    => graphina_position_type(),
					'conditions' => $data_label_font_color_condition,
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabel_orientation',
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
							'name'     => 'iq_' . $type . '_chart_datalabel_background_show',
							'operator' => '!=',
							'value'    => 'yes',
						),
					),
				);
			}

			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabel_font_color',
				array(
					'label'      => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
					'type'       => Controls_Manager::COLOR,
					'default'    => '#000000',
					'conditions' => $data_label_font_setting,
				)
			);

		}

		if ( $show_label_background ) {

			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabel_background_show',
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
						'name'     => 'iq_' . $type . '_chart_datalabel_background_show',
						'operator' => '==',
						'value'    => 'yes',
					),
				),
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabel_background_color',
				array(
					'label'      => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
					'type'       => Controls_Manager::COLOR,
					'default'    => '#FFFFFF',
					'conditions' => $data_label_background,
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabel_font_color_1',
				array(
					'label'      => esc_html__( 'Background Color', 'graphina-charts-for-elementor' ),
					'type'       => Controls_Manager::COLOR,
					'default'    => '#000000',
					'conditions' => $data_label_background,
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabel_border_width',
				array(
					'label'      => esc_html__( 'Border Width', 'graphina-charts-for-elementor' ),
					'type'       => Controls_Manager::NUMBER,
					'default'    => 1,
					'min'        => 0,
					'max'        => 20,
					'conditions' => $data_label_background,
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabel_border_radius',
				array(
					'label'      => esc_html__( 'Border radius', 'graphina-charts-for-elementor' ),
					'type'       => Controls_Manager::NUMBER,
					'default'    => 0,
					'conditions' => $data_label_background,
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabel_border_color',
				array(
					'label'      => esc_html__( 'Border Color', 'graphina-charts-for-elementor' ),
					'type'       => Controls_Manager::COLOR,
					'default'    => '#FFFFFF',
					'conditions' => $data_label_background,
				)
			);
		}

		if ( $label_add_fixed ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabel_prefix',
				array(
					'label'      => esc_html__( 'Label Prefix', 'graphina-charts-for-elementor' ),
					'type'       => Controls_Manager::TEXT,
					'conditions' => $data_label_font_color_condition,
					'dynamic'    => array(
						'active' => true,
					),
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_datalabel_postfix',
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

	// ------ Datalabel Setting End ------
}

/**
 * Function to add fill style settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type                Type of chart being configured.
 * @param array        $fill_styles         Array of fill styles available.
 * @param bool         $show_opacity        Whether to show opacity control.
 * @param int          $i                   Index for multi-instance controls.
 * @param array        $condition           Additional conditions for control visibility.
 * @param bool         $show_note_fill_style Whether to show a note about pattern style.
 *
 * @return void
 */
function graphina_fill_style_setting( Element_Base $this_ele, string $type = 'chart_id', array $fill_styles = array( 'classic', 'gradient', 'pattern' ), bool $show_opacity = false, int $i = -1, array $condition = array(), bool $show_note_fill_style = false ): void {
	$this_ele->add_control(
		'iq_' . $type . '_chart_fill_setting_title' . ( $i > -1 ? '_' . $i : '' ),
		array(
			'label'     => esc_html__( 'Fill Settings', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::HEADING,
			'condition' => array_merge( array(), ( $i > -1 ? $condition : array() ) ),
		)
	);

	$description = esc_html__( 'Pattern will not eligible for the line chart. So if you select it, it will consider as Classic', 'graphina-charts-for-elementor' );

	$this_ele->add_control(
		'iq_' . $type . '_chart_fill_style_type' . ( $i > -1 ? '_' . $i : '' ),
		array(
			'label'       => esc_html__( 'Style', 'graphina-charts-for-elementor' ),
			'type'        => Controls_Manager::CHOOSE,
			'default'     => graphina_fill_style_type( $fill_styles, true ),
			'options'     => graphina_fill_style_type( $fill_styles ),
			'description' => $show_note_fill_style ? $description : '',
			'condition'   => array_merge( array(), ( $i > -1 ? $condition : array() ) ),
		)
	);

	if ( $show_opacity ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_fill_opacity' . ( $i > -1 ? '_' . $i : '' ),
			array(
				'label'     => esc_html__( 'Opacity', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => in_array( $type, array( 'column', 'timeline', 'scatter' ), true ) ? 1 : 0.4,
				'min'       => 0.00,
				'max'       => 1,
				'step'      => 0.05,
				'condition' => array_merge( array( 'iq_' . $type . '_chart_fill_style_type' . ( $i > -1 ? '_' . $i : '' ) => 'classic' ), ( $i > -1 ? $condition : array() ) ),
			)
		);
	}
}

/**
 * Function to handle gradient settings for Elementor widgets.
 *
 * @param Element_Base $this_ele         The Elementor element instance.
 * @param string       $type             Type of chart being configured.
 * @param bool         $show_type        Whether to show gradient type control.
 * @param bool         $used_as_sub_part Whether this function is used as a sub-part.
 * @param int          $i                Index for multi-instance controls.
 * @param array        $condition        Additional conditions for control visibility.
 *
 * @return void
 */
function graphina_gradient_setting( Element_Base $this_ele, string $type = 'chart_id', bool $show_type = true, bool $used_as_sub_part = false, int $i = -1, array $condition = array() ): void {
	if ( ! $used_as_sub_part ) {
		$this_ele->start_controls_section(
			'iq_' . $type . '_chart_section_3' . ( $i > -1 ? '_' . $i : '' ),
			array(
				'label'     => esc_html__( 'Gradient Setting', 'graphina-charts-for-elementor' ),
				'condition' => array_merge( array( 'iq_' . $type . '_chart_fill_style_type' . ( $i > -1 ? '_' . $i : '' ) => 'gradient' ), ( $i > -1 ? $condition : array() ) ),
			)
		);
	} else {
		$this_ele->add_control(
			'iq_' . $type . '_chart_hr_gradient_setting' . ( $i > -1 ? '_' . $i : '' ),
			array(
				'type'      => Controls_Manager::DIVIDER,
				'condition' => array_merge( array( 'iq_' . $type . '_chart_fill_style_type' . ( $i > -1 ? '_' . $i : '' ) => 'gradient' ), ( $i > -1 ? $condition : array() ) ),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_gradient_setting_title' . ( $i > -1 ? '_' . $i : '' ),
			array(
				'label'     => esc_html__( 'Gradient Settings', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array_merge( array( 'iq_' . $type . '_chart_fill_style_type' . ( $i > -1 ? '_' . $i : '' ) => 'gradient' ), ( $i > -1 ? $condition : array() ) ),
			)
		);
	}

	if ( $show_type ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_gradient_type' . ( $i > -1 ? '_' . $i : '' ),
			array(
				'label'     => esc_html__( 'Type', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'vertical',
				'options'   => array(
					'vertical'   => esc_html__( 'Vertical', 'graphina-charts-for-elementor' ),
					'horizontal' => esc_html__( 'Horizontal', 'graphina-charts-for-elementor' ),
				),
				'condition' => array_merge( array( 'iq_' . $type . '_chart_fill_style_type' . ( $i > -1 ? '_' . $i : '' ) => 'gradient' ), ( $i > -1 ? $condition : array() ) ),
			)
		);
	}

	$from_opacity = ( in_array( $type, array( 'radar', 'area', 'brush' ), true ) ) ? 0.6 : 1.0;
	$to_opacity   = ( in_array( $type, array( 'radar', 'area', 'brush' ), true ) ) ? 0.6 : 1.0;

	$this_ele->add_control(
		'iq_' . $type . '_chart_gradient_opacityFrom' . ( $i > -1 ? '_' . $i : '' ),
		array(
			'label'     => esc_html__( 'From Opacity', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'step'      => 0.1,
			'default'   => $from_opacity,
			'min'       => 0,
			'max'       => 1,
			'condition' => array_merge( array( 'iq_' . $type . '_chart_fill_style_type' . ( $i > -1 ? '_' . $i : '' ) => 'gradient' ), ( $i > -1 ? $condition : array() ) ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_gradient_opacityTo' . ( $i > -1 ? '_' . $i : '' ),
		array(
			'label'     => esc_html__( 'To Opacity', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'step'      => 0.1,
			'default'   => $to_opacity,
			'min'       => 0,
			'max'       => 1,
			'condition' => array_merge( array( 'iq_' . $type . '_chart_fill_style_type' . ( $i > -1 ? '_' . $i : '' ) => 'gradient' ), ( $i > -1 ? $condition : array() ) ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_gradient_inversecolor' . ( $i > -1 ? '_' . $i : '' ),
		array(
			'label'     => esc_html__( 'Inverse Color', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
			'default'   => false,
			'condition' => array_merge( array( 'iq_' . $type . '_chart_fill_style_type' . ( $i > -1 ? '_' . $i : '' ) => 'gradient' ), ( $i > -1 ? $condition : array() ) ),
		)
	);

	if ( ! $used_as_sub_part ) {
		$this_ele->end_controls_section();
	}
}

/**
 * Function to handle legend settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_chart_label_setting( Element_Base $this_ele, string $type = 'chart_id' ): void {

	$this_ele->start_controls_section(
		'iq_' . $type . '_section_7',
		array(
			'label' => esc_html__( 'Legend Setting', 'graphina-charts-for-elementor' ),

		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_legend_show',
		array(
			'label'     => esc_html__( 'Legend', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			'default'   => 'yes',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_legend_position',
		array(
			'label'     => esc_html__( 'Position', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::CHOOSE,
			'default'   => 'bottom',
			'options'   => array(
				'top'    => array(
					'title' => esc_html__( 'Top', 'graphina-charts-for-elementor' ),
					'icon'  => 'fa fa-arrow-up',
				),
				'right'  => array(
					'title' => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
					'icon'  => 'fa fa-arrow-right',
				),
				'bottom' => array(
					'title' => esc_html__( 'Bottom', 'graphina-charts-for-elementor' ),
					'icon'  => 'fa fa-arrow-down',
				),
				'left'   => array(
					'title' => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
					'icon'  => 'fa fa-arrow-left',
				),
			),
			'condition' => array(
				'iq_' . $type . '_chart_legend_show' => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_legend_horizontal_align',
		array(
			'label'     => esc_html__( 'Horizontal Align', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::CHOOSE,
			'default'   => 'center',
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
			'condition' => array(
				'iq_' . $type . '_chart_legend_position' => array( 'top', 'bottom' ),
				'iq_' . $type . '_chart_legend_show'     => 'yes',
			),
		)
	);

	$des = '';
	if ( ! in_array( $type, array( 'pie', 'donut', 'polar', 'donut' ), true ) ) {
		$des = esc_html__( 'Note: Only work if tooltip enable', 'graphina-charts-for-elementor' );
	}

	if ( ! in_array( $type, array( 'bubble', 'candle', 'distributed_column', 'radar', 'timeline', 'nested_column', 'scatter' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_legend_show_series_value',
			array(
				'label'       => esc_html__( 'Show Series Value', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'description' => $des,
				'condition'   => array(
					'iq_' . $type . '_chart_legend_show' => 'yes',
				),
			)
		);
	}
	if ( $type === 'pie' ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_legend_show_series_postfix',
			array(
				'label'       => esc_html__( 'Show Series PostFix', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'description' => $des,
				'condition'   => array(
					'iq_' . $type . '_chart_legend_show' => 'yes',
					'iq_' . $type . '_chart_datalabels_format' => 'yes',
				),
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_legend_show_series_prefix',
			array(
				'label'       => esc_html__( 'Show Series PreFix', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'description' => $des,
				'condition'   => array(
					'iq_' . $type . '_chart_legend_show' => 'yes',
					'iq_' . $type . '_chart_datalabels_format' => 'yes',
				),
			)
		);
	}

	$this_ele->end_controls_section();
}

/**
 * Function to handle advance x-axis settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 * @param bool         $show_fixed show prefix/postfix.
 * @param bool         $show_tooltip show tooltip widget.
 *
 * @return void
 */
function graphina_advance_x_axis_setting( Element_Base $this_ele, string $type = 'chart_id', bool $show_fixed = true, bool $show_tooltip = true ): void {
	$this_ele->start_controls_section(
		'iq_' . $type . '_section_5',
		array(
			'label' => esc_html__( 'X-Axis Setting', 'graphina-charts-for-elementor' ),
		)
	);

	if ( in_array( $type, array( 'column', 'distributed_column' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_enable_min_max',
			array(
				'label'       => esc_html__( 'Enable Min/Max', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'     => false,
				'condition'   => array(
					'iq_' . $type . '_is_chart_horizontal' => 'yes',
					'iq_' . $type . '_chart_stack_type'    => 'normal',
				),
				'description' => esc_html__( 'Note: If chart having multi series, Enable Min/Max value will be applicable to all series and xaxis Tickamount must be according to min - max value', 'graphina-charts-for-elementor' ),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_min_value',
			array(
				'label'       => esc_html__( 'Min Value', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 0,
				'condition'   => array(
					'iq_' . $type . '_chart_xaxis_enable_min_max' => 'yes',
					'iq_' . $type . '_is_chart_horizontal' => 'yes',
					'iq_' . $type . '_chart_stack_type'    => 'normal',
				),
				'description' => esc_html__( 'Note: Lowest number to be set for the x-axis. The graph drawing beyond this number will be clipped off', 'graphina-charts-for-elementor' ),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_max_value',
			array(
				'label'       => esc_html__( 'Max Value', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 250,
				'condition'   => array(
					'iq_' . $type . '_chart_xaxis_enable_min_max' => 'yes',
					'iq_' . $type . '_is_chart_horizontal' => 'yes',
					'iq_' . $type . '_chart_stack_type'    => 'normal',
				),
				'description' => esc_html__( 'Note: Highest number to be set for the x-axis. The graph drawing beyond this number will be clipped off.', 'graphina-charts-for-elementor' ),
			)
		);
	}

	if ( $show_tooltip ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_tooltip_show',
			array(
				'label'     => esc_html__( 'Tooltip', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => '',
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_crosshairs_show',
			array(
				'label'     => esc_html__( 'Pointer Line', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => '',
				'condition' => array(
					'iq_' . $type . '_chart_xaxis_tooltip_show' => 'yes',
				),
			)
		);
	}

	$this_ele->add_control(
		'iq_' . $type . '_chart_xaxis_datalabel_show',
		array(
			'label'     => esc_html__( 'Labels', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			'default'   => 'yes',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_xaxis_datalabel_position',
		array(
			'label'     => esc_html__( 'Position', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::CHOOSE,
			'default'   => 'bottom',
			'options'   => array(
				'top'    => array(
					'title' => esc_html__( 'Top', 'graphina-charts-for-elementor' ),
					'icon'  => 'fa fa-arrow-up',
				),
				'bottom' => array(
					'title' => esc_html__( 'Bottom', 'graphina-charts-for-elementor' ),
					'icon'  => 'fa fa-arrow-down',
				),
			),
			'condition' => array(
				'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_xaxis_datalabel_auto_rotate',
		array(
			'label'     => esc_html__( 'Labels Auto Rotate', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'False', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'True', 'graphina-charts-for-elementor' ),
			'default'   => false,
			'condition' => array(
				'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_xaxis_datalabel_rotate',
		array(
			'label'     => esc_html__( 'Rotate', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => -45,
			'max'       => 360,
			'min'       => -360,
			'condition' => array(
				'iq_' . $type . '_chart_xaxis_datalabel_auto_rotate' => 'yes',
				'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_xaxis_datalabel_offset_x',
		array(
			'label'     => esc_html__( 'Offset-X', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 0,
			'condition' => array(
				'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_xaxis_datalabel_offset_y',
		array(
			'label'     => esc_html__( 'Offset-Y', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 0,
			'condition' => array(
				'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes',
			),
		)
	);

	if ( $type === 'brush' ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_datalabel_tick_amount_dataPoints',
			array(
				'label'     => esc_html__( 'Tick Amount(dataPoints)', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'False', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'True', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
				'condition' => array(
					'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes',
				),
			)
		);
	}

	if ( ! in_array( $type, array( 'brush', 'candle', 'timeline' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_datalabel_tick_amount',
			array(
				'label'     => esc_html__( 'Tick Amount', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 6,
				'max'       => 30,
				'min'       => 0,
				'condition' => array(
					'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes',
				),
			)
		);
	}
	if ( ! in_array( $type, array( 'brush', 'candle', 'timeline' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_datalabel_tick_placement',
			array(
				'label'     => esc_html__( 'Tick Placement', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => graphina_position_type( 'placement', true ),
				'options'   => graphina_position_type( 'placement' ),
				'condition' => array(
					'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes',
				),
			)
		);

	}

	if ( in_array( $type, array( 'timeline', 'candle' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_show_time',
			array(
				'label'     => esc_html__( 'Show Time In xaxis', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
				'condition' => array(
					'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes',
				),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_show_date',
			array(
				'label'     => esc_html__( 'Show Date In xaxis', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => false,
				'condition' => array(
					'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes',
				),
			)
		);
	}

	if ( $show_fixed ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_label_show',
			array(
				'label'       => esc_html__( 'Labels Prefix/Postfix', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'     => false,
				'condition'   => array(
					'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes',
				),
				'description' => esc_html__( 'Note: If categories data are in array form it won\'t work', 'graphina-charts-for-elementor' ),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_label_prefix',
			array(
				'label'     => esc_html__( 'Labels Prefix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'iq_' . $type . '_chart_xaxis_label_show' => 'yes',
					'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_label_postfix',
			array(
				'label'     => esc_html__( 'Labels Postfix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'iq_' . $type . '_chart_xaxis_label_show' => 'yes',
					'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);
	}

	if ( in_array( $type, array( 'column', 'distributed_column' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_prefix_postfix_decimal_point',
			array(
				'label'     => esc_html__( 'Decimals In Float', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'max'       => 6,
				'min'       => 0,
				'condition' => array(
					'iq_' . $type . '_chart_xaxis_label_show' => 'yes',
					'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
					'iq_' . $type . '_is_chart_horizontal' => 'yes',
					'iq_' . $type . '_chart_yaxis_label_pointer!' => 'yes',
				),
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_label_pointer',
			array(
				'label'       => esc_html__( 'Format Number to String', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition'   => array(
					'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes',
					'iq_' . $type . '_chart_xaxis_label_show' => 'yes',
					'iq_' . $type . '_is_chart_horizontal' => 'yes',
				),
				'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'     => false,
				'description' => esc_html__( 'Note: Convert 1,000  => 1k and 1,000,000 => 1m and if Format Number(Commas) is enable this will not work', 'graphina-charts-for-elementor' ),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_label_pointer_number',
			array(
				'label'     => esc_html__( 'Number of Decimal Want', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 0,
				'condition' => array(
					'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes',
					'iq_' . $type . '_chart_xaxis_label_pointer' => 'yes',
					'iq_' . $type . '_is_chart_horizontal' => 'yes',
					'iq_' . $type . '_chart_xaxis_label_show' => 'yes',
				),
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_format_number',
			array(
				'label'       => esc_html__( 'Format Number', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'     => 'no',
				'condition'   => array(
					'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes',
					'iq_' . $type . '_is_chart_horizontal' => 'yes',
				),
				'description' => esc_html__( 'Enabled Labels Prefix/Postfix ', 'graphina-charts-for-elementor' ),
			)
		);
	}
	$this_ele->add_control(
		'iq_' . $type . '_chart_xaxis_title_enable',
		array(
			'label'     => esc_html__( 'Enable Title', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			'default'   => 'no',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_xaxis_title',
		array(
			'label'     => esc_html__( 'Xaxis Title', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::TEXT,
			'condition' => array(
				'iq_' . $type . '_chart_xaxis_title_enable' => 'yes',
			),
			'dynamic'   => array(
				'active' => true,
			),
		)
	);
	$this_ele->end_controls_section();
}

/**
 * Function to handle advance y-axis settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 * @param bool         $show_fixed show prefix/postfix.
 * @param bool         $show_tooltip show tooltip widget.
 *
 * @return void
 */
function graphina_advance_y_axis_setting( Element_Base $this_ele, string $type = 'chart_id', bool $show_fixed = true, bool $show_tooltip = true ): void {
	$this_ele->start_controls_section(
		'iq_' . $type . '_section_6',
		array(
			'label' => esc_html__( 'Y-Axis Setting', 'graphina-charts-for-elementor' ),
		)
	);

	if ( in_array( $type, array( 'line', 'area', 'column', 'mixed', 'distributed_column' ), true ) ) {
		graphina_yaxis_min_max_setting( $this_ele, $type );
	}

	if ( $type !== 'heatmap' ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_yaxis_line_show',
			array(
				'label'     => esc_html__( 'Line', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_yaxis_line_grid_color',
			array(
				'label'     => esc_html__( 'Grid Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#90A4AE',
				'condition' => array(
					'iq_' . $type . '_chart_yaxis_line_show' => 'yes',
				),
			)
		);
	}

	if ( in_array( $type, array( 'line', 'area', 'column', 'bubble', 'candle', 'distributed_column', 'scatter' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_yaxis_0_indicator_show',
			array(
				'label'     => esc_html__( 'Zero Indicator', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => false,
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_yaxis_0_indicator_stroke_dash',
			array(
				'label'     => esc_html__( 'Stroke Dash', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'min'       => 0,
				'condition' => array(
					'iq_' . $type . '_chart_yaxis_0_indicator_show' => 'yes',
				),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_yaxis_0_indicator_stroke_color',
			array(
				'label'     => esc_html__( 'Stroke Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'condition' => array(
					'iq_' . $type . '_chart_yaxis_0_indicator_show' => 'yes',
				),
			)
		);
	}

	if ( $show_tooltip ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_yaxis_tooltip_show',
			array(
				'label'     => esc_html__( 'Tooltip', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => '',
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_yaxis_crosshairs_show',
			array(
				'label'     => esc_html__( 'Pointer Line', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => '',
				'condition' => array(
					'iq_' . $type . '_chart_yaxis_tooltip_show' => 'yes',
				),
			)
		);
	}

	$this_ele->add_control(
		'iq_' . $type . '_chart_yaxis_datalabel_show',
		array(
			'label'     => esc_html__( 'Labels', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			'default'   => 'yes',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_yaxis_datalabel_position',
		array(
			'label'     => esc_html__( 'Position', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::CHOOSE,
			'default'   => graphina_position_type( 'horizontal_boolean', true ),
			'options'   => graphina_position_type( 'horizontal_boolean' ),
			'condition' => array(
				'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_yaxis_datalabel_offset_x',
		array(
			'label'     => esc_html__( 'Offset-X', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 0,
			'condition' => array(
				'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_yaxis_datalabel_offset_y',
		array(
			'label'     => esc_html__( 'Offset-Y', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 0,
			'condition' => array(
				'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_yaxis_datalabel_rotate',
		array(
			'label'     => esc_html__( 'Rotate', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 0,
			'max'       => 360,
			'min'       => -360,
			'condition' => array(
				'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
			),
		)
	);

	$title_brush_chart = $type === 'brush' ? esc_html__( 'Chart-1', 'graphina-charts-for-elementor' ) : '';

	$this_ele->add_control(
		'iq_' . $type . '_chart_yaxis_datalabel_tick_amount',
		array(
			'label'     => $title_brush_chart . esc_html__( ' Tick Amount', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 6,
			'max'       => 30,
			'min'       => 0,
			'condition' => array(
				'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
			),
		)
	);

	if ( $type === 'brush' ) {

		$this_ele->add_control(
			'iq_' . $type . '_chart_yaxis_datalabel_tick_amount_2',
			array(
				'label'     => esc_html__( 'Chart-2 Tick Amount', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'max'       => 30,
				'min'       => 0,
				'condition' => array(
					'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
				),
			)
		);
	}

	$condition = array( 'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes' );
	$note      = '';
	if ( $show_fixed ) {
		$condition = array(
			'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
			'iq_' . $type . '_chart_yaxis_label_show!'    => 'yes',
		);
		$note      = esc_html__( 'If you enabled "Labels Prefix/Postfix", this won’t have any effect.', 'graphina-charts-for-elementor' );
	}

	$this_ele->add_control(
		'iq_' . $type . '_chart_yaxis_datalabel_decimals_in_float',
		array(
			'label'       => esc_html__( 'Decimals In Float', 'graphina-charts-for-elementor' ),
			'type'        => Controls_Manager::NUMBER,
			'default'     => 2,
			'max'         => 6,
			'min'         => 0,
			'condition'   => $condition,
			'description' => $note,
		)
	);

	if ( $show_fixed ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_yaxis_label_show',
			array(
				'label'     => esc_html__( 'Labels Prefix/Postfix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => false,
				'condition' => array(
					'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
				),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_yaxis_label_prefix',
			array(
				'label'     => esc_html__( 'Labels Prefix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'iq_' . $type . '_chart_yaxis_label_show' => 'yes',
					'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_yaxis_label_postfix',
			array(
				'label'     => esc_html__( 'Labels Postfix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'iq_' . $type . '_chart_yaxis_label_show' => 'yes',
					'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		if ( in_array( $type, array( 'line', 'area', 'column', 'distributed_column', 'scatter' ), true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_yaxis_prefix_postfix_decimal_point',
				array(
					'label'     => esc_html__( 'Decimals In Float', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 0,
					'max'       => 6,
					'min'       => 0,
					'condition' => array(
						'iq_' . $type . '_chart_yaxis_label_show' => 'yes',
						'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
						'iq_' . $type . '_chart_yaxis_label_pointer!' => 'yes',
					),
				)
			);
		}

		$this_ele->add_control(
			'iq_' . $type . '_chart_yaxis_label_pointer',
			array(
				'label'       => esc_html__( 'Format Number to Strings', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition'   => array(
					'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
					'iq_' . $type . '_chart_yaxis_label_show' => 'yes',
					'iq_' . $type . '_chart_yaxis_format_number!' => 'yes',
				),
				'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'     => false,
				'description' => esc_html__( 'Note: Convert 1,000  => 1k and 1,000,000 => 1m and if Format Number(Commas) is enable this will not work', 'graphina-charts-for-elementor' ),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_yaxis_label_pointer_number',
			array(
				'label'     => esc_html__( 'Number of Decimal Want', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 0,
				'condition' => array(
					'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
					'iq_' . $type . '_chart_yaxis_label_pointer' => 'yes',
					'iq_' . $type . '_chart_yaxis_label_show' => 'yes',

				),
			)
		);
		if ( in_array( $type, array( 'column', 'line', 'area', 'bubble', 'heatmap', 'distributed_column', 'scatter', 'brush' ), true ) ) {
			// $this_ele->add_control(
			// 	'iq_' . $type . '_chart_yaxis_number_format',
			// 	array(
			// 		'label'     => esc_html__( 'Enable Number Formatting', 'graphina-charts-for-elementor' ),
			// 		'type'      => Controls_Manager::SWITCHER,
			// 		'condition' => array(
			// 			'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',

			// 		),
			// 		'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
			// 		'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
			// 		'default'   => false,
			// 	)
			// );

			// $this_ele->add_control(
			// 	'iq_' . $type . '_chart_yaxis_locale',
			// 	array(
			// 		'label'       => esc_html__( 'Locale for Number Formatting', 'graphina-charts-for-elementor' ),
			// 		'type'        => Controls_Manager::TEXT,
			// 		'default'     => 'ja-JP',
			// 		'condition'   => array(
			// 			'iq_' . $type . '_chart_yaxis_number_format' => 'yes',

			// 		),
			// 		'description' => esc_html__( 'Specify the locale (e.g., en-US, ja-JP) for number formatting.', 'graphina-charts-for-elementor' ),
			// 	)
			// );
		}
	}

	if ( in_array( $type, array( 'area', 'column', 'bubble', 'line', 'brush', 'distributed_column', 'scatter' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_yaxis_format_number',
			array(
				'label'       => esc_html__( 'Format Number', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'     => 'no',
				'condition'   => array(
					'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
				),
			)
		);
	}

	$this_ele->add_control(
		'iq_' . $type . '_chart_yaxis_title_enable',
		array(
			'label'     => esc_html__( 'Enable Title', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			'default'   => 'no',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_yaxis_title',
		array(
			'label'     => esc_html__( 'Y-axis Title', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::TEXT,
			'condition' => array(
				'iq_' . $type . '_chart_yaxis_title_enable' => 'yes',
			),
			'dynamic'   => array(
				'active' => true,
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_card_yaxis_title_font_color',
		array(
			'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#000000',
			'condition' => array(
				'iq_' . $type . '_chart_yaxis_title_enable' => 'yes',
			),
		)
	);

	if ( in_array( $type, array( 'line', 'area', 'column', 'candle', 'heatmap', 'bubble', 'brush', 'scatter' ), true ) ) {

		graphina_yaxis_opposite( $this_ele, $type );

	}

	$this_ele->end_controls_section();
}

/**
 * Function to handle style section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_style_section( Element_Base $this_ele, string $type = 'chart_id' ): void {
	$this_ele->start_controls_section(
		'iq_' . $type . '_style_section',
		array(
			'label'     => esc_html__( 'Style Section', 'graphina-charts-for-elementor' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => array(
				'iq_' . $type . '_chart_card_show' => 'yes',
			),
		)
	);
	/** Header settings. */
	$this_ele->add_control(
		'iq_' . $type . '_title_options',
		array(
			'label'     => esc_html__( 'Title', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::HEADING,
			'condition' => array( 'iq_' . $type . '_is_card_heading_show' => 'yes' ),
		)
	);
	/** Header typography. */
	$this_ele->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'      => 'iq_' . $type . '_card_title_typography',
			'label'     => esc_html__( 'Typography', 'graphina-charts-for-elementor' ),
			'global'    => array(
				'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
			),
			'selector'  => '{{WRAPPER}} .graphina-chart-heading',
			'condition' => array( 'iq_' . $type . '_is_card_heading_show' => 'yes' ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_card_title_align',
		array(
			'label'     => esc_html__( 'Alignment', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::CHOOSE,
			'default'   => 'center',
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
			'selectors' => array(
				'{{WRAPPER}} .graphina-chart-heading' => 'text-align: {{VALUE}};',
			),
			'condition' => array(
				'iq_' . $type . '_is_card_heading_show' => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_card_title_font_color',
		array(
			'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#000000',
			'selectors' => array(
				'{{WRAPPER}} .graphina-chart-heading' => 'color: {{VALUE}};',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_card_title_margin',
		array(
			'label'      => esc_html__( 'Margin', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'condition'  => array(
				'iq_' . $type . '_is_card_heading_show' => 'yes',
			),
			'selectors'  => array(
				'{{WRAPPER}} .graphina-chart-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_card_title_padding',
		array(
			'label'      => esc_html__( 'Padding', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'condition'  => array(
				'iq_' . $type . '_is_card_heading_show' => 'yes',
			),
			'selectors'  => array(
				'{{WRAPPER}} .graphina-chart-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_subtitle_options',
		array(
			'label'     => esc_html__( 'Description', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::HEADING,
			'condition' => array( 'iq_' . $type . '_is_card_desc_show' => 'yes' ),
		)
	);

	$this_ele->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'      => 'iq_' . $type . '_subtitle_typography',
			'label'     => esc_html__( 'Typography', 'graphina-charts-for-elementor' ),
			'global'    => array(
				'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
			),
			'selector'  => '{{WRAPPER}} .graphina-chart-sub-heading',
			'condition' => array( 'iq_' . $type . '_is_card_desc_show' => 'yes' ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_card_subtitle_align',
		array(
			'label'     => esc_html__( 'Alignment', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::CHOOSE,
			'default'   => 'center',
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
			'condition' => array(
				'iq_' . $type . '_is_card_heading_show' => 'yes',
			),
			'selectors' => array(
				'{{WRAPPER}} .graphina-chart-sub-heading' => 'text-align: {{VALUE}};',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_card_subtitle_font_color',
		array(
			'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#000000',
			'selectors' => array(
				'{{WRAPPER}} .graphina-chart-sub-heading' => 'color: {{VALUE}};',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_card_subtitle_margin',
		array(
			'label'      => esc_html__( 'Margin', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'condition'  => array(
				'iq_' . $type . '_is_card_heading_show' => 'yes',
			),
			'selectors'  => array(
				'{{WRAPPER}} .graphina-chart-sub-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_card_subtitle_padding',
		array(
			'label'      => esc_html__( 'Padding', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'condition'  => array(
				'iq_' . $type . '_is_card_heading_show' => 'yes',
			),
			'selectors'  => array(
				'{{WRAPPER}} .graphina-chart-sub-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);
	$this_ele->end_controls_section();
}

/**
 * Function to handle card style section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_card_style( Element_Base $this_ele, string $type = 'chart_id' ): void {
	$this_ele->start_controls_section(
		'iq_' . $type . '_card_style_section',
		array(
			'label'     => esc_html__( 'Card Style', 'graphina-charts-for-elementor' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => array(
				'iq_' . $type . '_chart_card_show' => 'yes',
			),
		)
	);

	$this_ele->add_group_control(
		Group_Control_Background::get_type(),
		array(
			'name'      => 'iq_' . $type . '_card_background',
			'label'     => esc_html__( 'Background', 'graphina-charts-for-elementor' ),
			'types'     => array( 'classic', 'gradient' ),
			'selector'  => '{{WRAPPER}} .chart-card',
			'condition' => array(
				'iq_' . $type . '_chart_card_show' => 'yes',
			),
		)
	);

	$this_ele->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		array(
			'name'      => 'iq_' . $type . '_card_box_shadow',
			'label'     => esc_html__( 'Box Shadow', 'graphina-charts-for-elementor' ),
			'selector'  => '{{WRAPPER}} .chart-card',
			'condition' => array( 'iq_' . $type . '_chart_card_show' => 'yes' ),
		)
	);

	$this_ele->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'      => 'iq_' . $type . '_card_border',
			'label'     => esc_html__( 'Border', 'graphina-charts-for-elementor' ),
			'selector'  => '{{WRAPPER}} .chart-card',
			'condition' => array( 'iq_' . $type . '_chart_card_show' => 'yes' ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_card_border_radius',
		array(
			'label'      => esc_html__( 'Border Radius', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'condition'  => array(
				'iq_' . $type . '_chart_card_show' => 'yes',
			),
			'selectors'  => array(
				'{{WRAPPER}} .chart-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
			),
		)
	);

	$this_ele->end_controls_section();
}

/**
 * Function to handle chart style section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_chart_style( Element_Base $this_ele, string $type = 'chart_id' ): void {
	$this_ele->start_controls_section(
		'iq_' . $type . '_chart_style_section',
		array(
			'label' => esc_html__( 'Chart Style', 'graphina-charts-for-elementor' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		)
	);

	if ( ! in_array( $type, array( 'line_google', 'area_google', 'bar_google', 'column_google', 'pie_google', 'donut_google', 'org_google', 'geo_google', 'gantt_google', 'gauge_google' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_font_family',
			array(
				'label'       => esc_html__( 'Font Family', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::FONT,
				'description' => esc_html__( 'Notice:If possible use same font as Chart Title & Description, Otherwise it may not show the actual font you selected.', 'graphina-charts-for-elementor' ),
				'default'     => 'Poppins',
			)
		);

		$this_ele->add_responsive_control(
			'iq_' . $type . '_chart_font_size',
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
				'mobile_default' => array(
					'unit' => 'px',
					'size' => 12,
				),
				'tablet_default' => array(
					'unit' => 'px',
					'size' => 12,
				)
			)
		);

		$typo_weight_options = array(
			'' => esc_html__( 'Default', 'graphina-charts-for-elementor' ),
		);

		foreach ( array_merge( array( 'normal', 'bold' ), range( 100, 900, 100 ) ) as $weight ) {
			$typo_weight_options[ $weight ] = ucfirst( $weight );
		}

		$this_ele->add_control(
			'iq_' . $type . '_chart_font_weight',
			array(
				'label'   => esc_html__( 'Font Weight', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => $typo_weight_options,
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_font_color',
			array(
				'label'   => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#000000',
			)
		);
	}

	$this_ele->add_control(
		'iq_' . $type . '_chart_border_show',
		array(
			'label'     => esc_html__( 'Chart Box', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			'default'   => 'yes',
		)
	);

	$this_ele->add_group_control(
		Group_Control_Background::get_type(),
		array(
			'name'      => 'iq_' . $type . '_chart_background',
			'label'     => esc_html__( 'Background', 'graphina-charts-for-elementor' ),
			'types'     => array( 'classic', 'gradient' ),
			'selector'  => '{{WRAPPER}} .chart-box',
			'condition' => array(
				'iq_' . $type . '_chart_border_show' => 'yes',
			),
		)
	);

	$this_ele->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		array(
			'name'      => 'iq_' . $type . '_chart_box_shadow',
			'label'     => esc_html__( 'Box Shadow', 'graphina-charts-for-elementor' ),
			'selector'  => '{{WRAPPER}} .chart-box',
			'condition' => array( 'iq_' . $type . '_chart_border_show' => 'yes' ),
		)
	);

	$this_ele->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'      => 'iq_' . $type . '_chart_border',
			'label'     => esc_html__( 'Border', 'graphina-charts-for-elementor' ),
			'selector'  => '{{WRAPPER}} .chart-box',
			'condition' => array( 'iq_' . $type . '_chart_border_show' => 'yes' ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_border_radius',
		array(
			'label'      => esc_html__( 'Border Radius', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'condition'  => array(
				'iq_' . $type . '_chart_border_show' => 'yes',
			),
			'selectors'  => array(
				'{{WRAPPER}} .chart-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
			),
		)
	);
	$this_ele->end_controls_section();
}

/**
 * Function to handle chart filter section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_chart_filter_style( Element_Base $this_ele, string $type = 'chart_id' ): void {

	$this_ele->start_controls_section(
		'iq_' . $type . '_chart_filter_style',
		array(
			'label'     => esc_html__( 'Chart Filter Style', 'graphina-charts-for-elementor' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => array(
				'iq_' . $type . '_chart_filter_enable' => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_align_heading',
		array(
			'label' => esc_html__( 'Chart Filter', 'graphina-charts-for-elementor' ),
			'type'  => Controls_Manager::HEADING,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_align',
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
			'selectors' => array(
				'{{WRAPPER}} .graphina_chart_filter' => 'justify-content: {{VALUE}}',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_hr_label',
		array(
			'type' => Controls_Manager::DIVIDER,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_label_heading',
		array(
			'label' => esc_html__( 'Label', 'graphina-charts-for-elementor' ),
			'type'  => Controls_Manager::HEADING,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_label_font_color',
		array(
			'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .graphina-filter-div label' => 'color:{{VALUE}}' ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_label_font_size',
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
			'selectors'  => array(
				'{{WRAPPER}} .graphina-filter-div label' => 'font-size: {{SIZE}}{{UNIT}}',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_label_margin',
		array(
			'label'      => esc_html__( 'Margin', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'selectors'  => array(
				'{{WRAPPER}} .graphina-filter-div label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_label_padding',
		array(
			'label'      => esc_html__( 'Padding', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'selectors'  => array(
				'{{WRAPPER}} .graphina-filter-div label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_hr_select',
		array(
			'type' => Controls_Manager::DIVIDER,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_select_heading',
		array(
			'label' => esc_html__( 'DropDown', 'graphina-charts-for-elementor' ),
			'type'  => Controls_Manager::HEADING,
		)
	);

	$this_ele->add_group_control(
		Group_Control_Background::get_type(),
		array(
			'name'     => 'iq_' . $type . '_chart_filter_select_background',
			'label'    => esc_html__( 'Background Type', 'graphina-charts-for-elementor' ),
			'types'    => array( 'classic', 'gradient' ),
			'selector' => '{{WRAPPER}} .graphina-filter-div select',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_select_font_color',
		array(
			'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .graphina-filter-div select' => 'color:{{VALUE}}' ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_select_font_size',
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
			'selectors'  => array(
				'{{WRAPPER}} .graphina-filter-div select' => 'font-size: {{SIZE}}{{UNIT}}',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_select_margin',
		array(
			'label'      => esc_html__( 'Margin', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'selectors'  => array(
				'{{WRAPPER}} .graphina-filter-div select' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_select_padding',
		array(
			'label'      => esc_html__( 'Padding', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'selectors'  => array(
				'{{WRAPPER}} .graphina-filter-div select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
			),
		)
	);

	$this_ele->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'iq_' . $type . '_chart_filter_select_border',
			'label'    => esc_html__( 'Border', 'graphina-charts-for-elementor' ),
			'selector' => '{{WRAPPER}} .graphina-filter-div select',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_select_border_radius',
		array(
			'label'      => esc_html__( 'Border Radius', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'selectors'  => array(
				'{{WRAPPER}} .graphina-filter-div select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_hr_button',
		array(
			'type' => Controls_Manager::DIVIDER,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_button_heading',
		array(
			'label' => esc_html__( 'Apply Filter Button', 'graphina-charts-for-elementor' ),
			'type'  => Controls_Manager::HEADING,
		)
	);

	$this_ele->add_group_control(
		Group_Control_Background::get_type(),
		array(
			'name'     => 'iq_' . $type . '_chart_filter_button_background',
			'label'    => esc_html__( 'Background Type', 'graphina-charts-for-elementor' ),
			'types'    => array( 'classic', 'gradient' ),
			'selector' => '{{WRAPPER}} .graphina-filter-div input[type=button]',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_button_font_color',
		array(
			'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .graphina-filter-div input[type=button]' => 'color:{{VALUE}}' ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_button_font_size',
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
			'selectors'  => array(
				'{{WRAPPER}} .graphina-filter-div .graphina-filter-div-button' => 'font-size: {{SIZE}}{{UNIT}}',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_button_margin',
		array(
			'label'      => esc_html__( 'Margin', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'selectors'  => array(
				'{{WRAPPER}} .graphina-filter-div input[type=button]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_button_padding',
		array(
			'label'      => esc_html__( 'Padding', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'selectors'  => array(
				'{{WRAPPER}} .graphina-filter-div input[type=button]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
			),
		)
	);

	$this_ele->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'iq_' . $type . '_chart_filter_button_border',
			'label'    => esc_html__( 'Border', 'graphina-charts-for-elementor' ),
			'selector' => '{{WRAPPER}} .graphina-filter-div input[type=button]',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_button_border_radius',
		array(
			'label'      => esc_html__( 'Border Radius', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'selectors'  => array(
				'{{WRAPPER}} .graphina-filter-div input[type=button]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_hr_date_picker',
		array(
			'type' => Controls_Manager::DIVIDER,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_hr_date_picker_header',
		array(
			'label' => esc_html__( 'Date Picker', 'graphina-charts-for-elementor' ),
			'type'  => Controls_Manager::HEADING,
		)
	);

	$this_ele->add_group_control(
		Group_Control_Background::get_type(),
		array(
			'name'     => 'iq_' . $type . '_chart_filter_date_background',
			'label'    => esc_html__( 'Background Type', 'graphina-charts-for-elementor' ),
			'types'    => array( 'classic', 'gradient' ),
			'selector' => '{{WRAPPER}} .graphina-filter-div .graphina-chart-filter-date-time',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_date_font_color',
		array(
			'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .graphina-filter-div .graphina-chart-filter-date-time' => 'color:{{VALUE}}' ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_date_font_size',
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
			'selectors'  => array(
				'{{WRAPPER}} .graphina-filter-div .graphina-chart-filter-date-time' => 'font-size: {{SIZE}}{{UNIT}}',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_date_margin',
		array(
			'label'      => esc_html__( 'Margin', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'selectors'  => array(
				'{{WRAPPER}} .graphina-filter-div .graphina-chart-filter-date-time' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_date_padding',
		array(
			'label'      => esc_html__( 'Padding', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'selectors'  => array(
				'{{WRAPPER}} .graphina-filter-div .graphina-chart-filter-date-time' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
			),
		)
	);

	$this_ele->add_group_control(
		Group_Control_Border::get_type(),
		array(
			'name'     => 'iq_' . $type . '_chart_filter_date_border',
			'label'    => esc_html__( 'Border', 'graphina-charts-for-elementor' ),
			'selector' => '{{WRAPPER}} .graphina-filter-div .graphina-chart-filter-date-time',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_date_border_radius',
		array(
			'label'      => esc_html__( 'Border Radius', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'selectors'  => array(
				'{{WRAPPER}} .graphina-filter-div .graphina-chart-filter-date-time' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
			),
		)
	);

	$this_ele->end_controls_section();
}

/**
 * Function to handle chart stroke section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_stroke( Element_Base $this_ele, string $type = 'chart_id' ): void {
	$this_ele->add_control(
		'iq_' . $type . '_chart_hr_stroke_setting',
		array(
			'type' => Controls_Manager::DIVIDER,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_stroke_setting_title',
		array(
			'label' => esc_html__( 'Stroke Settings', 'graphina-charts-for-elementor' ),
			'type'  => Controls_Manager::HEADING,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_stroke_show',
		array(
			'label'     => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
			'default'   => false,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_stroke_width',
		array(
			'label'     => 'Stroke Width',
			'type'      => Controls_Manager::NUMBER,
			'default'   => 2,
			'min'       => 0,
			'max'       => 10,
			'condition' => array(
				'iq_' . $type . '_chart_stroke_show' => 'yes',
			),
		)
	);
}

/**
 * Function to handle chart animation section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_animation( Element_Base $this_ele, string $type = 'chart_id' ): void {
	$this_ele->add_control(
		'iq_' . $type . '_chart_hr_animation_setting',
		array(
			'type' => Controls_Manager::DIVIDER,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_animation_setting_title',
		array(
			'label' => esc_html__( 'Animation Settings', 'graphina-charts-for-elementor' ),
			'type'  => Controls_Manager::HEADING,
		)
	);

	// ------ Animation Setting For Google Chart ------
	if ( in_array( $type, array( 'area_google', 'line_google', 'bar_google', 'column_google', 'gauge_google' ), true ) ) {

		$this_ele->add_control(
			'iq_' . $type . '_chart_animation_show',
			array(
				'label'   => esc_html__( 'Show Animation', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'yes'     => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'no'      => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default' => 'yes',
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_animation_speed',
			array(
				'label'     => esc_html__( 'Speed', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 800,
				'condition' => array(
					'iq_' . $type . '_chart_animation_show' => 'yes',
				),
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_animation_easing',
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
					'iq_' . $type . '_chart_animation_show' => 'yes',
				),
			)
		);
	} else {
		// ------ Animation Setting For Apex Chart ------
		$this_ele->add_control(
			'iq_' . $type . '_chart_animation',
			array(
				'label'     => esc_html__( 'Custom', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_animation_speed',
			array(
				'label'     => esc_html__( 'Speed', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 800,
				'condition' => array(
					'iq_' . $type . '_chart_animation' => 'yes',
				),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_animation_delay',
			array(
				'label'     => esc_html__( 'Delay', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 150,
				'condition' => array(
					'iq_' . $type . '_chart_animation' => 'yes',
				),
			)
		);
	}
}

/**
 * Function to handle chart plot section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_plot_setting( Element_Base $this_ele, string $type = 'chart_id' ): void {
	$this_ele->add_control(
		'iq_' . $type . '_chart_hr_plot_setting',
		array(
			'type' => Controls_Manager::DIVIDER,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_plot_setting_title',
		array(
			'label' => esc_html__( 'Plot Settings', 'graphina-charts-for-elementor' ),
			'type'  => Controls_Manager::HEADING,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_plot_options',
		array(
			'label'     => esc_html__( 'Show Options', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			'default'   => 'yes',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_plot_stroke_color',
		array(
			'label'   => 'Stroke Color',
			'type'    => Controls_Manager::COLOR,
			'default' => '#e9e9e9',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_plot_color',
		array(
			'label'   => 'Color',
			'type'    => Controls_Manager::COLOR,
			'default' => '#ffffff',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_stroke_size',
		array(
			'label'   => esc_html__( 'Stroke Size', 'graphina-charts-for-elementor' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 1,
			'min'     => 0,
		)
	);
}

/**
 * Function to handle chart marker section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 * @param int          $i        Element index.
 *
 * @return void
 */
function graphina_marker_setting( Element_Base $this_ele, string $type = 'chart_id', int $i = 0 ): void {

	if ( $type === 'mixed' ) {
		$condition = array(
			'iq_' . $type . '_chart_data_series_count'  => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
			'iq_' . $type . '_chart_type_3_' . $i . '!' => 'bar',
		);
	} else {
		$condition = array(
			'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
		);
	}

	$this_ele->add_control(
		'iq_' . $type . '_chart_marker_setting_title_' . $i,
		array(
			'label'     => esc_html__( 'Marker Settings', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::HEADING,
			'condition' => $condition,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_marker_size_' . $i,
		array(
			'label'       => esc_html__( 'Size', 'graphina-charts-for-elementor' ),
			'type'        => Controls_Manager::NUMBER,
			'default'     => in_array( $type, array( 'radar', 'mixed', 'brush' ), true ) ? 3 : 1,
			'min'         => 0,
			'condition'   => $condition,
			'description' => $type === 'brush' ? esc_html__( 'Note : Marker are only show in Chart 1 ', 'graphina-charts-for-elementor' ) : '',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_marker_stroke_color_' . $i,
		array(
			'label'     => esc_html__( 'Stroke Color', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#fff',
			'condition' => $condition,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_marker_stroke_width_' . $i,
		array(
			'label'     => esc_html__( 'Stroke Width', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => in_array( $type, array( 'mixed', 'brush' ), true ) ? 1 : 5,
			'min'       => 0,
			'condition' => $condition,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_chart_marker_stroke_shape_' . $i,
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
 * Function to handle google chart marker section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 * @param int          $i        Element index.
 *
 * @return void
 */
function graphina_marker_setting_google( Element_Base $this_ele, string $type = 'chart_id', int $i = 0 ): void {
	$condition = array(
		'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_marker_setting_title_' . $i,
		array(
			'label'     => esc_html__( 'Marker Settings', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::HEADING,
			'condition' => $condition,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_point_show' . $i,
		array(
			'label'     => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'true'      => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
			'false'     => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			'default'   => false,
			'condition' => $condition,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_line_point' . $i,
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
				'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
				'iq_' . $type . '_chart_point_show' . $i   => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_line_point_size' . $i,
		array(
			'label'     => esc_html__( ' Size', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 5,
			'max'       => 100,
			'min'       => 1,
			'condition' => array(
				'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
				'iq_' . $type . '_chart_point_show' . $i   => 'yes',
			),
		)
	);
}

/**
 * Function to handle label section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_element_label( Element_Base $this_ele, string $type = 'chart_id' ): void {

	$this_ele->add_control(
		'iq_' . $type . '_chart_hr_label_setting',
		array(
			'type' => Controls_Manager::DIVIDER,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_label_setting_title',
		array(
			'label' => esc_html__( 'Label Settings', 'graphina-charts-for-elementor' ),
			'type'  => Controls_Manager::HEADING,
		)
	);

	if ( in_array( $type, array( 'pie_google', 'donut_google' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_pieSliceText_show',
			array(
				'label'   => esc_html__( 'Label Show', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'false'   => esc_html__( 'no', 'graphina-charts-for-elementor' ),
				'default' => 'no',
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_pieSliceText',
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
					'iq_' . $type . '_chart_pieSliceText_show' => 'yes',

				),

			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_label_prefix_postfix',
			array(
				'label'     => esc_html__( 'Label Prefix/Postfix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'true'      => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'false'     => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => '',
				'condition' => array(
					'iq_' . $type . '_chart_pieSliceText_show' => 'yes',

				),
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_label_prefix',
			array(
				'label'     => esc_html__( 'Prefix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => array(
					'iq_' . $type . '_chart_pieSliceText_show' => 'yes',
					'iq_' . $type . '_chart_label_prefix_postfix' => 'yes',
				),
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_label_postfix',
			array(
				'label'     => esc_html__( 'Postfix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => array(
					'iq_' . $type . '_chart_pieSliceText_show' => 'yes',
					'iq_' . $type . '_chart_label_prefix_postfix' => 'yes',
				),
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_pieSliceText_color',
			array(
				'label'     => esc_html__( 'Label Text Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'black',
				'condition' => array(
					'iq_' . $type . '_chart_pieSliceText_show' => 'yes',
				),

			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_pieSliceText_fontsize',
			array(
				'label'     => esc_html__( 'Label Text Fontsize', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 5,
				'max'       => 20,
				'default'   => '12',
				'condition' => array(
					'iq_' . $type . '_chart_pieSliceText_show' => 'yes',
				),

			)
		);
	}
	$this_ele->add_control(
		'iq_' . $type . '_chart_label_reversecategory',
		array(
			'label'   => esc_html__( 'Reverse Categories', 'graphina-charts-for-elementor' ),
			'type'    => Controls_Manager::SWITCHER,
			'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
			'false'   => esc_html__( 'no', 'graphina-charts-for-elementor' ),
			'default' => 'false',
		)
	);
	$this_ele->add_control(
		'iq_' . $type . '_chart_setting',
		array(
			'type' => Controls_Manager::DIVIDER,
		)
	);
	if ( $type === 'pie_google' ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_isthreed',
			array(
				'label'   => esc_html__( '3D ', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'false'   => esc_html__( 'no', 'graphina-charts-for-elementor' ),
				'default' => 'false',
			)
		);
	}
	if ( $type === 'pie_google' ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_pieslice_bordercolor',
				array(
					'label'     => esc_html__( 'Pieslice Border', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					'condition' => array(
						'iq_' . $type . '_chart_isthreed' => '',
					),
				)
			);
	}
	if ( $type === 'donut_google' ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_pieslice_bordercolor',
			array(
				'label'   => esc_html__( 'Pieslice Border', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#ffffff',
			)
		);
	}
	if ( $type === 'donut_google' ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_piehole',
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
 * Function to handle common area stacked section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_common_area_stacked_option( Element_Base $this_ele, string $type = 'chart_id' ): void {
	$this_ele->add_control(
		'iq_' . $type . '_chart_stacked_show',
		array(
			'label'     => esc_html__( 'Stacked Show ', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
			'default'   => false,
		)
	);
}

/**
 * Function to handle chart tooltip section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 * @param bool         $show_theme Show theme setting based on value.
 * @param bool         $shared    show shared setting based on value.
 *
 * @return void
 */
function graphina_tooltip( Element_Base $this_ele, string $type = 'chart_id', bool $show_theme = true, bool $shared = true ): void {
	// Tooltip Setting.
	$this_ele->add_control(
		'iq_' . $type . '_chart_hr_tooltip_setting',
		array(
			'type' => Controls_Manager::DIVIDER,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_tooltip_setting_title',
		array(
			'label' => esc_html__( 'Tooltip Settings', 'graphina-charts-for-elementor' ),
			'type'  => Controls_Manager::HEADING,
		)
	);

	// ------ Tooltip Setting For Google Chart ------
	if ( in_array( $type, array( 'area_google', 'line_google', 'bar_google', 'column_google', 'pie_google', 'donut_google', 'geo_google' ), true ) ) {

		$this_ele->add_control(
			'iq_' . $type . '_chart_tooltip_show',
			array(
				'label'     => esc_html__( 'Show Tooltip', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_tooltip_trigger',
			array(
				'label'     => esc_html__( ' Trigger', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'focus'     => esc_html__( 'On Hover', 'graphina-charts-for-elementor' ),
					'selection' => esc_html__( 'On Selection', 'graphina-charts-for-elementor' ),
				),
				'default'   => 'focus',
				'condition' => array(
					'iq_' . $type . '_chart_tooltip_show' => 'yes',
				),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_tooltip_color',
			array(
				'label'     => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'black',
				'condition' => array(
					'iq_' . $type . '_chart_tooltip_show' => 'yes',
				),
			)
		);

		if ( $type === 'geo_google' ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_tooltip_font_size',
				array(
					'label'     => esc_html__( 'Font Size', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 0,
					'condition' => array(
						'iq_' . $type . '_chart_tooltip_show' => 'yes',
					),
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_tooltip_bold',
				array(
					'label'     => esc_html__( 'Bold', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'iq_' . $type . '_chart_tooltip_show' => 'yes',
					),
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_tooltip_italic',
				array(
					'label'     => esc_html__( 'Italic', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => array(
						'iq_' . $type . '_chart_tooltip_show' => 'yes',
					),
				)
			);

		}

		if ( in_array( $type, array( 'pie_google', 'donut_google' ), true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_tooltip_text',
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
						'iq_' . $type . '_chart_tooltip_show' => 'yes',
					),

				)
			);
		}

		if ( in_array( $type, array( 'column_google', 'bar_google' ), true ) ) {

			$this_ele->add_control(
				'iq_' . $type . '_chart_element_column_setting',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_element_column_setting_title',
				array(
					'label' => esc_html__( 'Column Settings', 'graphina-charts-for-elementor' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_element_width',
				array(
					'label'   => esc_html__( 'Column Width', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 20,
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_stacked',
				array(
					'label'     => esc_html__( 'Stacked Show', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'   => false,
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_stack_type',
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
						'iq_' . $type . '_chart_stacked' => 'yes',

					),
				)
			);

		}
		if ( in_array( $type, array( 'column_google', 'bar_google', 'line_google', 'area_google' ), true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_annotation_setting_start',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_annotation_setting_title',
				array(
					'label' => esc_html__( 'Annotation Settings', 'graphina-charts-for-elementor' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_annotation_show',
				array(
					'label'     => esc_html__( 'Show Annotation', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'   => false,
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_annotation_color',
				array(
					'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#000000',
					'condition' => array(
						'iq_' . $type . '_chart_annotation_show' => 'yes',
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_annotation_color2',
				array(
					'label'     => esc_html__( 'Second Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					'condition' => array(
						'iq_' . $type . '_chart_annotation_show' => 'yes',
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_annotation_stemcolor',
				array(
					'label'     => esc_html__( 'Stem Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#000000',
					'condition' => array(
						'iq_' . $type . '_chart_annotation_show' => 'yes',
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_annotation_fontsize',
				array(
					'label'     => esc_html__( ' Fontsize', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 12,
					'condition' => array(
						'iq_' . $type . '_chart_annotation_show' => 'yes',
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_annotation_opacity',
				array(
					'label'     => esc_html__( 'Opacity', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 0.5,
					'step'      => 0.01,
					'condition' => array(
						'iq_' . $type . '_chart_annotation_show' => 'yes',
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_annotation_prefix_postfix',
				array(
					'label'     => esc_html__( 'Annotation Prefix/Postfix', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'true'      => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'false'     => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'   => '',
					'condition' => array(
						'iq_' . $type . '_chart_annotation_show' => 'yes',
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_annotation_prefix',
				array(
					'label'     => esc_html__( 'Prefix', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '',
					'condition' => array(
						'iq_' . $type . '_chart_annotation_show' => 'yes',
						'iq_' . $type . '_chart_annotation_prefix_postfix' => 'yes',
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_annotation_postfix',
				array(
					'label'     => esc_html__( 'Postfix', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '',
					'condition' => array(
						'iq_' . $type . '_chart_annotation_show' => 'yes',
						'iq_' . $type . '_chart_annotation_prefix_postfix' => 'yes',
					),
				)
			);
		}
	} else {
		// ------ Tooltip Setting For Apex Chart ------
		$notice = '';
		if ( $type === 'radar' ) {
			$notice = esc_html__( 'Warning: This will may not work if markers are not shown.', 'graphina-charts-for-elementor' );
		}
		$this_ele->add_control(
			'iq_' . $type . '_chart_tooltip',
			array(
				'label'       => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'label_on'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'label_off'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'     => 'yes',
				'description' => $notice,
			)
		);
		if ( in_array( $type, array( 'pie','area', 'donut', 'radial', 'polar' ), true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_number_format_commas',
				array(
					'label'     => esc_html__( 'Format Number(Commas)', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => 'no',
					'condition' => array(
						'iq_' . $type . '_chart_tooltip' => 'yes',
					),
				)
			);

		// 	$this_ele->add_control(
		// 		'iq_' . $type . '_chart_number_format_locale',
		// 		array(
		// 			'label'     => esc_html__( 'Format Number(Locale)', 'graphina-charts-for-elementor' ),
		// 			'type'      => Controls_Manager::SWITCHER,
		// 			'condition' => array(
		// 				'iq_' . $type . '_chart_tooltip' => 'yes',

		// 			),
		// 			'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
		// 			'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
		// 			'default'   => false,
		// 		)
		// 	);

		// 	$this_ele->add_control(
		// 		'iq_' . $type . '_chart_tooltip_locale',
		// 		array(
		// 			'label'       => esc_html__( 'Locale for Number Formatting', 'graphina-charts-for-elementor' ),
		// 			'type'        => Controls_Manager::TEXT,
		// 			'default'     => 'ja-JP',
		// 			'condition'   => array(
		// 				'iq_' . $type . '_chart_tooltip' => 'yes',
		// 				'iq_' . $type . '_chart_number_format_locale' => 'yes',

		// 			),
		// 			'description' => esc_html__( 'Specify the locale (e.g., en-US, ja-JP) for number formatting.', 'graphina-charts-for-elementor' ),
		// 		)
		// 	);
		}

		if ( $shared && $type !== 'candle' ) {
			$notice = '';
			if ( $type === 'column' ) {
				$notice = esc_html__( 'Warning: This will may not work for horizontal column chart.', 'graphina-charts-for-elementor' );
			}
			if ( in_array( $type, array( 'area', 'line' ), true ) ) {
				$notice = esc_html__( 'If tooltip shared off ,Elements setting -> Marker settings -> size value should be greater then 0 to work properly', 'graphina-charts-for-elementor' );
			}
			$this_ele->add_control(
				'iq_' . $type . '_chart_tooltip_shared',
				array(
					'label'       => esc_html__( 'Shared', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::SWITCHER,
					'label_on'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'label_off'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'description' => $notice,
					'default'     => 'yes',
					'condition'   => array(
						'iq_' . $type . '_chart_tooltip' => 'yes',
					),
				)
			);
		}
		if ( $show_theme ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_tooltip_theme',
				array(
					'label'     => esc_html__( 'Theme', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'light',
					'options'   => array(
						'light' => array(
							'title' => esc_html__( 'Light', 'graphina-charts-for-elementor' ),
							'icon'  => 'fas fa-sun',
						),
						'dark'  => array(
							'title' => esc_html__( 'Dark', 'graphina-charts-for-elementor' ),
							'icon'  => 'fas fa-moon',
						),
					),
					'condition' => array(
						'iq_' . $type . '_chart_tooltip' => 'yes',
					),
				)
			);
		}
	}
}

/**
 * Function to handle chart dropshadow section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 * @param bool         $condition Show some section based condition value.
 *
 * @return void
 */
function graphina_dropshadow( Element_Base $this_ele, string $type = 'chart_id', bool $condition = true ): void {

	$this_ele->add_control(
		'iq_' . $type . '_chart_hr_plot_drop_shadow_setting',
		array(
			'type' => Controls_Manager::DIVIDER,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_plot_drop_shadow_setting_title',
		array(
			'label' => esc_html__( 'Drop Shadow Settings', 'graphina-charts-for-elementor' ),
			'type'  => Controls_Manager::HEADING,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_is_chart_dropshadow',
		array(
			'label'     => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
			'default'   => false,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_is_chart_dropshadow_top',
		array(
			'label'     => esc_html__( 'Drop Shadow Top Position', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 0,
			'condition' => array(
				'iq_' . $type . '_is_chart_dropshadow' => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_is_chart_dropshadow_left',
		array(
			'label'     => esc_html__( 'Drop Shadow Left Position', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 0,
			'condition' => array(
				'iq_' . $type . '_is_chart_dropshadow' => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_is_chart_dropshadow_blur',
		array(
			'label'     => esc_html__( 'Drop Shadow Blur', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 0,
			'min'       => 0,
			'condition' => array(
				'iq_' . $type . '_is_chart_dropshadow' => 'yes',
			),
		)
	);

	if ( $condition ) {
		$this_ele->add_control(
			'iq_' . $type . '_is_chart_dropshadow_color',
			array(
				'label'     => esc_html__( 'Drop Shadow Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'condition' => array(
					'iq_' . $type . '_is_chart_dropshadow' => 'yes',
				),
			)
		);
	}

	$this_ele->add_control(
		'iq_' . $type . '_is_chart_dropshadow_opacity',
		array(
			'label'     => esc_html__( 'Drop Shadow Opacity', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 0.35,
			'max'       => 1,
			'min'       => 0,
			'step'      => 0.05,
			'condition' => array(
				'iq_' . $type . '_is_chart_dropshadow' => 'yes',
			),
		)
	);
}

/**
 * Function to retrieve color arrays based on type.
 *
 * @param string $type The type of colors to retrieve ('color' or 'gradientColor').
 *
 * @return array An array of colors based on the type.
 */
function graphina_colors( string $type = 'color' ): array {
	if ( $type === 'gradientColor' ) {
		return array( '#6C25FB', '#ff7179', '#654ae8', '#f8576f', '#31317a', '#fe6f7e', '#7D02EB', '#E02828', '#D56767', '#26A2D6', '#6C25FB', '#ff7179', '#654ae8', '#f8576f', '#31317a', '#fe6f7e', '#7D02EB', '#E02828', '#D56767', '#26A2D6', '#6C25FB', '#ff7179', '#654ae8', '#f8576f', '#31317a', '#fe6f7e', '#7D02EB', '#E02828', '#D56767', '#26A2D6', '#6C25FB', '#ff7179', '#654ae8', '#f8576f', '#31317a', '#fe6f7e', '#7D02EB', '#E02828', '#D56767', '#26A2D6' );
	}
	return array( '#3499FF', '#e53efc', '#f9a243', '#46adfe', '#2c80ff', '#e23cfd', '#7D02EB', '#8D5B4C', '#F86624', '#2E294E', '#3499FF', '#e53efc', '#f9a243', '#46adfe', '#2c80ff', '#e23cfd', '#7D02EB', '#8D5B4C', '#F86624', '#2E294E', '#3499FF', '#e53efc', '#f9a243', '#46adfe', '#2c80ff', '#e23cfd', '#7D02EB', '#8D5B4C', '#F86624', '#2E294E', '#e23cfd', '#3499FF', '#e53efc', '#f9a243', '#46adfe', '#2c80ff', '#e23cfd', '#7D02EB', '#8D5B4C', '#F86624', '#2E294E' );
}

/**
 * Generate a random date based on the given start date and adjustments.
 *
 * @param string $start The starting date in strtotime() compatible format.
 * @param string $format The format in which the date should be returned.
 * @param array  $add Associative array of units to add to the start date (e.g., ['day' => 2, 'month' => 1]).
 * @param array  $minus Associative array of units to subtract from the start date (e.g., ['year' => 1]).
 *
 * @return string Formatted random date based on adjustments.
 */
function graphina_get_random_date( string $start, string $format, array $add = array(), array $minus = array() ): string {
	$date = '';
	foreach ( $add as $i => $a ) {
		$date .= ' + ' . $a . ' ' . $i;
	}
	foreach ( $minus as $j => $b ) {
		$date .= ' - ' . $b . ' ' . $j;
	}
	$timestamp = strtotime( $date, strtotime( $start ) );
	return date( $format, $timestamp ); //@phpcs:ignore
}

/**
 * Setup series settings for a chart element.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type Type of chart element (e.g., 'chart_id').
 * @param array        $ele_array Array of element types to configure (e.g., ['color', 'dash']).
 * @param bool         $show_fill_style Whether to show fill style settings.
 * @param array        $fill_options Additional fill style options.
 * @param bool         $show_fill_opacity Whether to show fill opacity setting.
 * @param bool         $show_gradient_type Whether to show gradient type setting.
 * @return void
 */
function graphina_series_setting( Element_Base $this_ele, string $type = 'chart_id', array $ele_array = array( 'color' ), bool $show_fill_style = true, array $fill_options = array(), bool $show_fill_opacity = false, bool $show_gradient_type = false ): void {
	$colors         = graphina_colors();
	$gradient_color = graphina_colors( 'gradientColor' );
	$series_name    = esc_html__( 'Element', 'graphina-charts-for-elementor' );

	$this_ele->start_controls_section(
		'iq_' . $type . '_section_11',
		array(
			'label' => esc_html__( 'Elements Setting', 'graphina-charts-for-elementor' ),
		)
	);

	if ( $show_fill_style ) {
		graphina_fill_style_setting( $this_ele, $type, $fill_options, $show_fill_opacity );
	}

	if ( $show_fill_style && in_array( 'gradient', $fill_options, true ) ) {
		graphina_gradient_setting( $this_ele, $type, $show_gradient_type, true );
	}

	if ( $type === 'scatter' ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_scatter_width',
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
			$this_ele->add_control(
				'iq_' . $type . '_chart_hr_series_count_' . $i,
				array(
					'type'      => Controls_Manager::DIVIDER,
					'condition' => array(
						'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
		}

		$this_ele->add_control(
			'iq_' . $type . '_chart_series_title_' . $i,
			array(
				'label'     => $series_name . ' ' . ( $i + 1 ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
				),
			)
		);

		if ( in_array( 'tooltip', $ele_array, true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_tooltip_enabled_on_1_' . $i,
				array(
					'label'     => esc_html__( 'Tooltip Enabled', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'   => 'yes',
					'condition' => array(
						'iq_' . $type . '_chart_tooltip' => 'yes',
						'iq_' . $type . '_chart_tooltip_shared' => 'yes',
						'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
		}

		if ( in_array( 'color', $ele_array, true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_gradient_1_' . $i,
				array(
					'label'     => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => $colors[ $i ],
					'condition' => array(
						'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_gradient_2_' . $i,
				array(
					'label'     => esc_html__( 'Second Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => $gradient_color[ $i ],
					'condition' => array(
						'iq_' . $type . '_chart_fill_style_type' => 'gradient',
						'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_bg_pattern_' . $i,
				array(
					'label'     => esc_html__( 'Fill Pattern', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => graphina_get_fill_patterns( true ),
					'options'   => graphina_get_fill_patterns(),
					'condition' => array(
						'iq_' . $type . '_chart_fill_style_type' => 'pattern',
						'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
		}

		if ( in_array( 'dash', $ele_array, true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_dash_3_' . $i,
				array(
					'label'     => 'Dash',
					'type'      => Controls_Manager::NUMBER,
					'default'   => 0,
					'min'       => 0,
					'max'       => 100,
					'condition' => array(
						'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
		}

		if ( in_array( 'width', $ele_array, true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_width_3_' . $i,
				array(
					'label'     => 'Stroke Width',
					'type'      => Controls_Manager::NUMBER,
					'default'   => 5,
					'min'       => 1,
					'max'       => 20,
					'condition' => array(
						'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
		}

		$chart_type = array( 'radar', 'line', 'area' );

		if ( in_array( $type, $chart_type, true ) ) {

			graphina_marker_setting( $this_ele, $type, $i );

		}
	}
	$this_ele->end_controls_section();
}


/**
 * Get dynamic tag data from element settings.
 *
 * @param array  $ele_setting_vals Array of element setting values.
 * @param string $main_key The main key to retrieve from the settings array.
 * @return string The sanitized dynamic tag data.
 */
function graphina_get_dynamic_tag_data( array $ele_setting_vals, string $main_key ): string {
	return str_replace( "'", "\'", $ele_setting_vals[ $main_key ] );
}


/**
 * Include user.php if not already defined.
 *
 * This conditionally includes the user.php file from WordPress admin includes directory
 * if the WordPress ABSPATH constant is defined and the function get_editable_roles() does not exist.
 *
 * This is typically used to ensure essential WordPress functions are available in custom code.
 */
if ( defined( 'ABSPATH' ) && ! function_exists( 'get_editable_roles' ) ) {
    // phpcs:ignore WordPress.Security.IncludeFileName
	require_once ABSPATH . '/wp-admin/includes/user.php';
}

/**
 * Fetches editable roles and prepares options array.
 *
 * Retrieves editable roles using WordPress function get_editable_roles().
 * Constructs an array where role IDs are keys and role names are values.
 *
 * @return array Array of roles where keys are role IDs and values are role names.
 */
function graphina_fetch_roles_options(): array {
	$roles         = get_editable_roles();
	$roles_options = array();

	foreach ( $roles as $role_id => $role_data ) {
		$roles_options[ $role_id ] = $role_data['name'];
	}

	return $roles_options;
}

/**
 * Fetches all WordPress users and prepares options array.
 *
 * Retrieves all users using WordPress function get_users().
 * Constructs an array where user login names are keys and values are formatted as "First Name Last Name(Display Name)".
 *
 * @return array Array of user options where keys are user login names and values are formatted names.
 */
function graphina_fetch_user_name_options(): array {
	$all_users     = get_users();
	$users_options = array();

	foreach ( $all_users as $user ) {
		$first_name   = get_user_meta( $user->ID, 'first_name', true );
		$last_name    = get_user_meta( $user->ID, 'last_name', true );
		$display_name = $user->display_name;

		// Construct formatted name.
		$formatted_name = $first_name . ' ' . $last_name . ' (' . $display_name . ')';

		// Assign to array with user login as key.
		$users_options[ $user->user_login ] = $formatted_name;
	}

	return $users_options;
}


/**
 * Retrieves the login name of the current WordPress user.
 *
 * Uses WordPress function wp_get_current_user() to get the current user object.
 * Returns the login name of the current user.
 *
 * @return string The login name of the current user.
 */
function graphina_fetch_user_name(): string {
	$user = wp_get_current_user();
	return ! empty( $user->user_login ) ? $user->user_login : '';
}


/**
 * Retrieves the roles assigned to the current WordPress user.
 *
 * Retrieves the roles of the current user by fetching the user ID and querying
 * the roles associated with that user ID. Returns either a single role (if $singleRole
 * is true) or an array of roles.
 *
 * @param bool $single_role Optional. Whether to return a single role or array of roles.
 *                        Default is true (return single role).
 * @return string|array The role(s) of the current user. Returns a single role if $single_role
 *                             is true and the user has roles assigned. Returns an array of roles if
 *                             $single_role is false or the user has multiple roles. Returns an empty
 *                             string or empty array if no roles are found or the user ID is empty.
 */
function graphina_fetch_user_roles( bool $single_role = true ): array|string {
	$user_id = get_current_user_id();

	// If user ID is empty, return empty string or empty array based on $single_role.
	if ( empty( $user_id ) ) {
		return $single_role ? '' : array();
	}

	// Fetch the user object based on user ID.
	$user_obj  = new WP_User( $user_id );
	$user_role = ! empty( $user_obj->roles ) ? $user_obj->roles : array();

	// If roles are found, and it's an array with roles, proceed.
	if ( ! empty( $user_role ) && is_array( $user_role ) && count( $user_role ) > 0 ) {
		$user_role = array_values( $user_role );
		// Return either a single role or array of roles based on $single_role.
		return $single_role ? $user_role[0] : $user_role;
	}

	// If no roles found, return empty string or empty array based on $single_role.
	return $single_role ? '' : array();
}


/**
 * Function to handle restriction content section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_restriction_content_options( Element_Base $this_ele, string $type = 'chart_id' ): void {

	$this_ele->start_controls_section(
		'iq_' . $type . '_restriction_content_control',
		array(
			'label' => esc_html__( 'Restriction Content Access', 'graphina-charts-for-elementor' ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_restriction_content_type',
		array(
			'label'   => esc_html__( 'Restriction Based On', 'graphina-charts-for-elementor' ),
			'type'    => Controls_Manager::SELECT,
			'options' => array(
				''         => __( 'No Restriction Access', 'graphina-charts-for-elementor' ),
				'login'    => __( 'Logged In User', 'graphina-charts-for-elementor' ),
				'password' => __( 'Password Protected', 'graphina-charts-for-elementor' ),
				'role'     => __( 'Role Based Access', 'graphina-charts-for-elementor' ),
				'userName' => __( 'UserName Based Access', 'graphina-charts-for-elementor' ),
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_restriction_content_password',
		array(
			'label'     => __( 'Set Password', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::TEXT,
			'condition' => array(
				'iq_' . $type . '_restriction_content_type' => 'password',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_password_content_headline',
		array(
			'label'     => __( 'Headline', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => __( 'Protected Area', 'graphina-charts-for-elementor' ),
			'condition' => array(
				'iq_' . $type . '_restriction_content_type' => 'password',
			),
			'dynamic'   => array(
				'active' => true,
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_password_button_label',
		array(
			'label'     => __( 'Button Label', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => __( 'Submit', 'graphina-charts-for-elementor' ),
			'condition' => array(
				'iq_' . $type . '_restriction_content_type' => 'password',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_password_error_message_show',
		array(
			'label'       => esc_html__( 'Error', 'graphina-charts-for-elementor' ),
			'type'        => Controls_Manager::SWITCHER,
			'label_on'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
			'label_off'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
			'description' => esc_html__( 'Notice:Error message when incorrect password enter', 'graphina-charts-for-elementor' ),
			'default'     => 'yes',
			'condition'   => array(
				'iq_' . $type . '_restriction_content_type' => 'password',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_password_error_message',
		array(
			'label'     => __( 'Error message', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => __( 'Password is invalid', 'graphina-charts-for-elementor' ),
			'condition' => array(
				'iq_' . $type . '_restriction_content_type' => 'password',
				'iq_' . $type . '_password_error_message_show' => 'yes',
			),
			'dynamic'   => array(
				'active' => true,
			),
		)
	);
	$this_ele->add_control(
		'iq_' . $type . '_password_instructions_text',
		array(
			'label'     => __( 'Instructions Text', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::TEXTAREA,
			'rows'      => 10,
			'default'   => __( 'This content is password-protected. Please verify with a password to unlock the content.', 'graphina-charts-for-elementor' ),
			'condition' => array(
				'iq_' . $type . '_restriction_content_type' => 'password',
			),
			'dynamic'   => array(
				'active' => true,
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_restriction_content_role_type',
		array(
			'label'       => __( 'Select Roles', 'graphina-charts-for-elementor' ),
			'type'        => Controls_Manager::SELECT2,
			'multiple'    => true,
			'condition'   => array(
				'iq_' . $type . '_restriction_content_type' => 'role',
			),
			'options'     => graphina_fetch_roles_options(),
			'label_block' => true,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_restriction_content_user_name_based',
		array(
			'label'       => __( 'Select User', 'graphina-charts-for-elementor' ),
			'type'        => Controls_Manager::SELECT2,
			'multiple'    => true,
			'condition'   => array(
				'iq_' . $type . '_restriction_content_type' => 'userName',
			),
			'options'     => graphina_fetch_user_name_options(),
			'label_block' => true,
		)
	);
	$this_ele->add_control(
		'iq_' . $type . '_restriction_content_template',
		array(
			'label'     => __( 'Restricted Template View (shortcode)', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::WYSIWYG,
			'default'   => wp_kses_post( graphina_default_restrict_content_template() ),
			'condition' => array(
				'iq_' . $type . '_restriction_content_type!' => array( '', 'password' ),
			),
			'dynamic'   => array(
				'active' => true,
			),
		)
	);

	$this_ele->end_controls_section();
}


/**
 * Function to handle opposite y-axis section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_yaxis_opposite( Element_Base $this_ele, string $type ): void {

	$this_ele->add_control(
		'iq_' . $type . '_chart_hr_opposite_yaxis',
		array(
			'type'      => Controls_Manager::DIVIDER,
			'condition' => array(
				'iq_' . $type . '_chart_data_series_count!' => 1,
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_opposite_yaxis_title_enable',
		array(
			'label'     => esc_html__( 'Enable Opposite Title', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			'default'   => 'no',
			'condition' => array(
				'iq_' . $type . '_chart_data_series_count!' => 1,
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_opposite_yaxis_tick_amount',
		array(
			'label'     => esc_html__( 'Tick Amount', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 0,
			'max'       => 30,
			'min'       => 0,
			'condition' => array(
				'iq_' . $type . '_chart_opposite_yaxis_title_enable' => 'yes',
				'iq_' . $type . '_chart_data_series_count!' => 1,
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_opposite_yaxis_label_show',
		array(
			'label'     => esc_html__( 'Show Label', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			'default'   => false,
			'condition' => array(
				'iq_' . $type . '_chart_opposite_yaxis_title_enable' => 'yes',
				'iq_' . $type . '_chart_data_series_count!' => 1,
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_opposite_yaxis_label_prefix',
		array(
			'label'     => esc_html__( 'Labels Prefix', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::TEXT,
			'condition' => array(
				'iq_' . $type . '_chart_opposite_yaxis_label_show' => 'yes',
				'iq_' . $type . '_chart_data_series_count!' => 1,
			),
			'dynamic'   => array(
				'active' => true,
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_opposite_yaxis_label_postfix',
		array(
			'label'     => esc_html__( 'Labels Postfix', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::TEXT,
			'condition' => array(
				'iq_' . $type . '_chart_opposite_yaxis_label_show' => 'yes',
				'iq_' . $type . '_chart_data_series_count!' => 1,
			),
			'dynamic'   => array(
				'active' => true,
			),
		)
	);

	if ( in_array( $type, array( 'area', 'column', 'bubble', 'line', 'mixed', 'scatter' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_opposite_yaxis_format_number',
			array(
				'label'     => esc_html__( 'Format Number', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'no',
				'condition' => array(
					'iq_' . $type . '_chart_opposite_yaxis_title_enable' => 'yes',
					'iq_' . $type . '_chart_opposite_yaxis_label_show' => 'yes',
					'iq_' . $type . '_chart_data_series_count!' => 1,
				),
			)
		);
		if ( $type === 'column' ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_yaxis_max_width',
				array(
					'label'   => esc_html__( 'Max Width', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 'auto',
				)
			);
		}
	}

	$this_ele->add_control(
		'iq_' . $type . '_chart_opposite_yaxis_title',
		array(
			'label'     => esc_html__( 'Opposite Y-axis Title', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::TEXT,
			'condition' => array(
				'iq_' . $type . '_chart_opposite_yaxis_title_enable' => 'yes',
				'iq_' . $type . '_chart_data_series_count!' => 1,
			),
			'dynamic'   => array(
				'active' => true,
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_card_opposite_yaxis_title_font_color',
		array(
			'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#000000',
			'condition' => array(
				'iq_' . $type . '_chart_opposite_yaxis_title_enable' => 'yes',
				'iq_' . $type . '_chart_data_series_count!' => 1,
			),
		)
	);
}

/**
 * Function to handle chart selection section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_selection_setting( Element_Base $this_ele, string $type ): void {

	$this_ele->start_controls_section(
		'iq_' . $type . '_section_selection',
		array(
			'label' => esc_html__( 'Selection Setting', 'graphina-charts-for-elementor' ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_selection_xaxis',
		array(
			'label'     => esc_html__( 'Xaxis', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Enable', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'Disable', 'graphina-charts-for-elementor' ),
			'default'   => 'yes',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_selection_xaxis_min',
		array(
			'label'     => __( 'Min', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'min'       => 0,
			'step'      => 1,
			'default'   => 1,
			'condition' => array(
				'iq_' . $type . '_chart_selection_xaxis' => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_selection_xaxis_max',
		array(
			'label'     => __( 'Max', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'min'       => 2,
			'step'      => 1,
			'default'   => 6,
			'condition' => array(
				'iq_' . $type . '_chart_selection_xaxis' => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_selection_fill',
		array(
			'label' => __( 'Fill', 'graphina-charts-for-elementor' ),
			'type'  => Controls_Manager::HEADING,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_selection_fill_color',
		array(
			'label'   => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
			'type'    => Controls_Manager::COLOR,
			'default' => '#fff',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_selection_fill_opacity',
		array(
			'label'   => esc_html__( 'Opacity', 'graphina-charts-for-elementor' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 0.4,
			'min'     => 0.00,
			'max'     => 1,
			'step'    => 0.05,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_selection_stroke',
		array(
			'label' => __( 'Stroke', 'graphina-charts-for-elementor' ),
			'type'  => Controls_Manager::HEADING,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_selection_stroke_width',
		array(
			'label'   => esc_html__( 'Width', 'graphina-charts-for-elementor' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 1,
			'min'     => 1,
			'step'    => 1,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_selection_stroke_dasharray',
		array(
			'label'   => esc_html__( 'Dash', 'graphina-charts-for-elementor' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 3,
			'min'     => 1,
			'step'    => 1,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_selection_stroke_color',
		array(
			'label'   => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
			'type'    => Controls_Manager::COLOR,
			'default' => '#24292e',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_selection_stroke_opacity',
		array(
			'label'   => esc_html__( 'Opacity', 'graphina-charts-for-elementor' ),
			'type'    => Controls_Manager::NUMBER,
			'default' => 0.4,
			'min'     => 0.00,
			'max'     => 1,
			'step'    => 0.05,
		)
	);

	$this_ele->end_controls_section();
}

/**
 * Setup series 2 settings for a chart element.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type Type of chart element (e.g., 'chart_id').
 * @param array        $ele_array Array of element types to configure (e.g., ['color', 'dash']).
 * @param bool         $show_fill_style Whether to show fill style settings.
 * @param array        $fill_options Additional fill style options.
 * @param bool         $show_fill_opacity Whether to show fill opacity setting.
 * @param bool         $show_gradient_type Whether to show gradient type setting.
 * @return void
 */
function graphina_series_2_setting( Element_Base $this_ele, string $type = 'chart_id', array $ele_array = array( 'color' ), bool $show_fill_style = true, array $fill_options = array(), bool $show_fill_opacity = false, bool $show_gradient_type = false ): void {
	$colors         = graphina_colors();
	$gradient_color = graphina_colors( 'gradientColor' );
	$series_name    = esc_html__( 'Element', 'graphina-charts-for-elementor' );

	$title = in_array( 'brush-1', $ele_array, true ) ? esc_html__( 'Chart-1', 'graphina-charts-for-elementor' ) : esc_html__( 'Chart-2', 'graphina-charts-for-elementor' );

	$type1 = 'brush';

	$this_ele->start_controls_section(
		'iq_' . $type . '_section_11',
		array(
			'label' => $title . esc_html__( 'Elements Setting', 'graphina-charts-for-elementor' ),
		)
	);

	if ( $show_fill_style ) {
		graphina_fill_style_setting( $this_ele, $type, $fill_options, $show_fill_opacity );
	}

	if ( $show_fill_style && in_array( 'gradient', $fill_options, true ) ) {
		graphina_gradient_setting( $this_ele, $type, $show_gradient_type, true );
	}

	$max_series = graphina_default_setting( 'max_series_value' );
	for ( $i = 0; $i < $max_series; $i++ ) {

		if ( $i !== 0 || $show_fill_style ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_hr_series_count_' . $i,
				array(
					'type'      => Controls_Manager::DIVIDER,
					'condition' => array(
						'iq_' . $type1 . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
		}

		$this_ele->add_control(
			'iq_' . $type . '_chart_series_title_' . $i,
			array(
				'label'     => $series_name . ' ' . ( $i + 1 ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'iq_' . $type1 . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
				),
			)
		);

		if ( in_array( 'color', $ele_array, true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_gradient_1_' . $i,
				array(
					'label'     => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => $colors[ $i ],
					'condition' => array(
						'iq_' . $type1 . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_gradient_2_' . $i,
				array(
					'label'     => esc_html__( 'Second Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => $gradient_color[ $i ],
					'condition' => array(
						'iq_' . $type . '_chart_fill_style_type' => 'gradient',
						'iq_' . $type1 . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_bg_pattern_' . $i,
				array(
					'label'     => esc_html__( 'Fill Pattern', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => graphina_get_fill_patterns( true ),
					'options'   => graphina_get_fill_patterns(),
					'condition' => array(
						'iq_' . $type . '_chart_fill_style_type' => 'pattern',
						'iq_' . $type1 . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
		}

		if ( in_array( 'dash', $ele_array, true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_dash_3_' . $i,
				array(
					'label'       => 'Dash',
					'type'        => Controls_Manager::NUMBER,
					'default'     => 0,
					'min'         => 0,
					'max'         => 100,
					'condition'   => array(
						'iq_' . $type1 . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
					'description' => esc_html__( 'Notice:This will not work in column chart', 'graphina-charts-for-elementor' ),
				)
			);
		}

		if ( in_array( 'width', $ele_array, true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_width_3_' . $i,
				array(
					'label'       => 'Stroke Width',
					'type'        => Controls_Manager::NUMBER,
					'default'     => 3,
					'min'         => 1,
					'max'         => 20,
					'condition'   => array(
						'iq_' . $type1 . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
					'description' => esc_html__( 'Notice:This will not work in column chart', 'graphina-charts-for-elementor' ),
				)
			);
		}

		$chart_type = array( 'radar', 'line', 'area', 'brush' );

		if ( in_array( $type, $chart_type, true ) ) {

			graphina_marker_setting( $this_ele, $type, $i );

		}
	}
	$this_ele->end_controls_section();
}

/**
 * Function to handle chart y-axis min/max section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_yaxis_min_max_setting( Element_Base $this_ele, string $type ): void {
	$this_ele->add_control(
		'iq_' . $type . '_chart_yaxis_enable_min_max',
		array(
			'label'       => esc_html__( 'Enable Min/Max', 'graphina-charts-for-elementor' ),
			'type'        => Controls_Manager::SWITCHER,
			'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
			'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			'default'     => false,
			'description' => esc_html__( 'Note: If chart having multi series, Enable Min/Max value will be applicable to all series and Yaxis Tickamount must be according to min - max value', 'graphina-charts-for-elementor' ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_yaxis_min_value',
		array(
			'label'       => esc_html__( 'Min Value', 'graphina-charts-for-elementor' ),
			'type'        => Controls_Manager::NUMBER,
			'default'     => 0,
			'condition'   => array(
				'iq_' . $type . '_chart_yaxis_enable_min_max' => 'yes',
			),
			'description' => esc_html__( 'Note: Lowest number to be set for the y-axis. The graph drawing beyond this number will be clipped off', 'graphina-charts-for-elementor' ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_yaxis_max_value',
		array(
			'label'       => esc_html__( 'Max Value', 'graphina-charts-for-elementor' ),
			'type'        => Controls_Manager::NUMBER,
			'default'     => 250,
			'condition'   => array(
				'iq_' . $type . '_chart_yaxis_enable_min_max' => 'yes',
			),
			'description' => esc_html__( 'Note: Highest number to be set for the y-axis. The graph drawing beyond this number will be clipped off.', 'graphina-charts-for-elementor' ),
		)
	);
}

/**
 * Function to handle datatable element section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_datatable_lite_element_data_option_setting( Element_Base $this_ele, string $type = 'element_id' ): void {
	$this_ele->start_controls_section(
		'iq_' . $type . '_section_data_options',
		array(
			'label' => esc_html__( 'Data Options', 'graphina-charts-for-elementor' ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_is_pro',
		array(
			'label'   => esc_html__( 'Is Pro', 'graphina-charts-for-elementor' ),
			'type'    => Controls_Manager::HIDDEN,
			'default' => graphina_pro_active() === true ? 'true' : 'false',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_data_option',
		array(
			'label'   => esc_html__( 'Type', 'graphina-charts-for-elementor' ),
			'type'    => Controls_Manager::SELECT,
			'default' => graphina_chart_data_enter_options( 'base', $type, true ),
			'options' => graphina_chart_data_enter_options( 'base', $type ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_element_rows',
		array(
			'label'     => esc_html__( 'No of Rows', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 3,
			'min'       => 1,
			'condition' => array(
				'iq_' . $type . '_chart_data_option' => 'manual',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_element_columns',
		array(
			'label'     => esc_html__( 'No of Columns', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 3,
			'min'       => 1,
			'condition' => array(
				'iq_' . $type . '_chart_data_option' => 'manual',
			),
		)
	);

	$this_ele->end_controls_section();

	do_action( 'graphina_addons_control_section', $this_ele, $type );

	$this_ele->start_controls_section(
		'iq_' . $type . '_section_5_2_1',
		array(
			'label'     => esc_html__( 'Dynamic Data Options', 'graphina-charts-for-elementor' ),
			'condition' => array(
				'iq_' . $type . '_chart_data_option' => array( 'dynamic' ),
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_dynamic_data_option',
		array(
			'label'   => esc_html__( 'Type', 'graphina-charts-for-elementor' ),
			'type'    => Controls_Manager::SELECT,
			'default' => graphina_chart_data_enter_options( 'dynamic', $type, true ),
			'options' => graphina_chart_data_enter_options( 'dynamic', $type ),
		)
	);

	if ( graphina_pro_active() ) {
		graphina_pro_get_dynamic_options( $this_ele, $type );
	} else {
		$this_ele->add_control(
			'iq_' . $type . 'get_pro',
			array(
				'type' => Controls_Manager::RAW_HTML,
				'raw'  => graphina_get_teaser_template(
					array(
						'title'    => esc_html__( 'Get New Exciting Features', 'graphina-charts-for-elementor' ),
						'messages' => array( 'Get Graphina Pro for above exciting features and more.' ),
						'link'     => 'https://codecanyon.net/item/graphinapro-elementor-dynamic-charts-datatable/28654061',
					)
				),
			)
		);
	}

	$this_ele->end_controls_section();

	if ( graphina_pro_active() && ( $type !== 'line_google' ) ) {
		graphina_restriction_content_options( $this_ele, $type );
	}
}

/**
 * Function to handle chart dynamic section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_dyanmic_chart_style_section( Element_Base $this_ele, string $type = 'chart_id' ): void {
	$this_ele->start_controls_section(
		'iq_' . $type . 'dynamic_change_type_style_section',
		array(
			'label'     => esc_html__( 'Change Chart Type Style', 'graphina-charts-for-elementor' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => array(
				'iq_' . $type . '_dynamic_change_chart_type' => 'yes',
			),
		)
	);

	$this_ele->add_group_control(
		Group_Control_Typography::get_type(),
		array(
			'name'     => 'iq_' . $type . '_dynamic_change_type_select_text_typography',
			'label'    => esc_html__( 'Select Text Typography', 'graphina-charts-for-elementor' ),
			'global'   => array(
				'default' => Global_Typography::TYPOGRAPHY_TEXT,
			),
			'selector' => '{{WRAPPER}} #graphina-select-chart-type',
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_dynamic_change_type_align',
		array(
			'label'     => esc_html__( 'Alignment', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::CHOOSE,
			'default'   => 'left',
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
			'selectors' => array(
				'{{WRAPPER}} .graphina_dynamic_change_type' => 'text-align: {{VALUE}}',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_dynamic_change_type_font_color',
		array(
			'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#000000',
			'selectors' => array(
				'{{WRAPPER}} #graphina-select-chart-type' => 'color: {{VALUE}}',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_dynamic_change_type_background_color',
		array(
			'label'     => esc_html__( 'Select Background Color', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => array(
				'{{WRAPPER}} #graphina-select-chart-type' => 'background: {{VALUE}}',
			),
		)
	);
	$this_ele->add_responsive_control(
		'iq_' . $type . '_dynamic_change_type_height',
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
				'{{WRAPPER}} #graphina-select-chart-type' => 'height: {{SIZE}}{{UNIT}};',
			),
		)
	);

	$this_ele->add_responsive_control(
		'iq_' . $type . '__dynamic_change_type_width',
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
				'{{WRAPPER}} #graphina-select-chart-type' => 'width: {{SIZE}}{{UNIT}};',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '__dynamic_change_type_select_radius',
		array(
			'label'      => esc_html__( 'Select Border Radius', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'selectors'  => array(
				'{{WRAPPER}} #graphina-select-chart-type ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_dynamic_change_type_margin',
		array(
			'label'      => esc_html__( 'Margin', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'selectors'  => array(
				'{{WRAPPER}} .graphina_dynamic_change_type' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_dynamic_change_type_padding',
		array(
			'label'      => esc_html__( 'Padding', 'graphina-charts-for-elementor' ),
			'size_units' => array( 'px', '%', 'em' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'condition'  => array(
				'iq_' . $type . '_is_card_heading_show' => 'yes',
			),
			'selectors'  => array(
				'{{WRAPPER}} .graphina_dynamic_change_type' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			),
		)
	);

	$this_ele->end_controls_section();
}

/**
 * Function to handle chart filters section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_charts_filter_settings( Element_Base $this_ele, string $type ): void {
	$condition = array(
		'iq_' . $type . '_chart_data_option'         => 'dynamic',
		'iq_' . $type . '_chart_dynamic_data_option' => array( 'sql-builder', 'api' ),
	);
	if ( in_array( $type, array( 'counter', 'advance-datatable' ), true ) ) {
		$condition = array(
			'iq_' . $type . '_element_data_option'         => 'dynamic',
			'iq_' . $type . '_element_dynamic_data_option' => array( 'database', 'api' ),
		);
	}
	$this_ele->start_controls_section(
		'iq_' . $type . '_section_chart_filter',
		array(
			'label'     => esc_html__( 'Chart Filter', 'graphina-charts-for-elementor' ),
			'condition' => $condition,
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_enable',
		array(
			'label'     => esc_html__( 'Enable Filter', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			'default'   => false,
		)
	);

	$repeater = new Repeater();

	$repeater->add_control(
		'iq_' . $type . '_chart_filter_value_label',
		array(
			'label'       => esc_html__( 'Label', 'graphina-charts-for-elementor' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => esc_html__( 'Choose Option', 'graphina-charts-for-elementor' ),
			'description' => esc_html__( 'Note: This key is use where you want to use selected option value', 'graphina-charts-for-elementor' ),
			'dynamic'     => array(
				'active' => true,
			),
		)
	);

	$repeater->add_control(
		'iq_' . $type . '_chart_filter_value_key',
		array(
			'label'       => esc_html__( 'Add Filter Keys', 'graphina-charts-for-elementor' ),
			'type'        => Controls_Manager::TEXT,
			'placeholder' => esc_html__( '{{key_1}}', 'graphina-charts-for-elementor' ),
			'description' => esc_html__( 'Note: This key is use where you want to use selected option value', 'graphina-charts-for-elementor' ),
			'dynamic'     => array(
				'active' => true,
			),
		)
	);

	$repeater->add_control(
		'iq_' . $type . '_chart_filter_type',
		array(
			'label'   => esc_html__( 'Filter Type', 'graphina-charts-for-elementor' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'select',
			'block'   => true,
			'options' => array(
				'select' => esc_html__( 'Select Dropdown', 'graphina-charts-for-elementor' ),
				'date'   => esc_html__( 'Datepicker', 'graphina-charts-for-elementor' ),
			),
			'dynamic' => array(
				'active' => true,
			),
		)
	);

	$repeater->add_control(
		'iq_' . $type . '_chart_filter_date_type',
		array(
			'label'      => esc_html__( 'Date Type', 'graphina-charts-for-elementor' ),
			'type'       => Controls_Manager::SELECT,
			'default'    => 'date',
			'block'      => true,
			'options'    => array(
				'datetime' => esc_html__( 'DateTime', 'graphina-charts-for-elementor' ),
				'date'     => esc_html__( 'Date', 'graphina-charts-for-elementor' ),
			),
			'conditions' => array(
				'terms' => array(
					array(
						'name'  => 'iq_' . $type . '_chart_filter_type',
						'value' => 'date',
					),
				),
			),
		)
	);

	$repeater->add_control(
		'iq_' . $type . '_chart_filter_datetime_default',
		array(
			'label'       => esc_html__( 'Default Date', 'graphina-charts-for-elementor' ),
			'type'        => Controls_Manager::DATE_TIME,
			'default'     => current_time( 'Y-m-d h:i:s' ),
			'label_block' => true,
			'dynamic'     => array(
				'active' => true,
			),
			'conditions'  => array(
				'relation' => 'and',
				'terms'    => array(
					array(
						'name'  => 'iq_' . $type . '_chart_filter_type',
						'value' => 'date',
					),
					array(
						'name'  => 'iq_' . $type . '_chart_filter_date_type',
						'value' => 'datetime',
					),
				),
			),
		)
	);

	$repeater->add_control(
		'iq_' . $type . '_chart_filter_date_default',
		array(
			'label'          => esc_html__( 'Default Date', 'graphina-charts-for-elementor' ),
			'type'           => Controls_Manager::DATE_TIME,
			'default'        => current_time( 'Y-m-d' ),
			'label_block'    => true,
			'dynamic'        => array(
				'active' => true,
			),
			'picker_options' => array(
				'enableTime' => false,
			),
			'conditions'     => array(
				'relation' => 'and',
				'terms'    => array(
					array(
						'name'  => 'iq_' . $type . '_chart_filter_type',
						'value' => 'date',
					),
					array(
						'name'  => 'iq_' . $type . '_chart_filter_date_type',
						'value' => 'date',
					),
				),
			),
		)
	);

	$repeater->add_control(
		'iq_' . $type . '_chart_filter_value',
		array(
			'label'       => esc_html__( 'Add Select Dropdown Filter Value', 'graphina-charts-for-elementor' ),
			'type'        => Controls_Manager::TEXTAREA,
			'placeholder' => esc_html__( 'Value,Value1', 'graphina-charts-for-elementor' ),
			'description' => wp_kses_post( graphina_chart_filter_controller_description() ),
			'label_block' => true,
			'dynamic'     => array(
				'active' => true,
			),
			'conditions'  => array(
				'terms' => array(
					array(
						'name'  => 'iq_' . $type . '_chart_filter_type',
						'value' => 'select',
					),
				),
			),
		)
	);

	$repeater->add_control(
		'iq_' . $type . '_chart_filter_option',
		array(
			'label'       => esc_html__( 'Add Select Dropdown Filter Name', 'graphina-charts-for-elementor' ),
			'type'        => Controls_Manager::TEXTAREA,
			'placeholder' => esc_html__( 'Name1,Name2', 'graphina-charts-for-elementor' ),
			'description' => wp_kses_post( graphina_chart_filter_controller_description() ),
			'label_block' => true,
			'dynamic'     => array(
				'active' => true,
			),
			'conditions'  => array(
				'terms' => array(
					array(
						'name'  => 'iq_' . $type . '_chart_filter_type',
						'value' => 'select',
					),
				),
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_filter_list',
		array(
			'label'     => esc_html__( 'Filter Tab', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::REPEATER,
			'fields'    => $repeater->get_controls(),
			'condition' => array(
				'iq_' . $type . '_chart_filter_enable' => 'yes',
			),
		)
	);

	$this_ele->end_controls_section();
}

/**
 * Function to handle chart h-axis section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_advance_h_axis_setting( Element_Base $this_ele, string $type = 'chart_id' ): void {
	$this_ele->start_controls_section(
		'iq_' . $type . '_section_8',
		array(
			'label' => esc_html__( 'X-Axis Setting', 'graphina-charts-for-elementor' ),
		)
	);
	if ( in_array( $type, array( 'column_google', 'line_google', 'area_google', 'bar_google' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_label_settings',
			array(
				'label' => esc_html__( 'Label Setting', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_haxis_label_position_show',
			array(
				'label'   => esc_html__( 'Label Show', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'false'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default' => 'yes',
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_haxis_label_position',
			array(
				'label'     => esc_html__( 'Label Position', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'out',
				'options'   => graphina_position_type( 'in_out' ),
				'condition' => array(
					'iq_' . $type . '_chart_haxis_label_position_show' => 'yes',
				),
			)
		);
		if ( in_array( $type, array( 'column_google', 'line_google', 'area_google' ), true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_haxis_label_prefix_postfix',
				array(
					'label'     => esc_html__( 'Label Prefix/Postfix', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'true'      => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'false'     => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'   => '',
					'condition' => array(
						'iq_' . $type . '_chart_haxis_label_position_show' => 'yes',
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_haxis_label_prefix',
				array(
					'label'     => esc_html__( 'Prefix', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '',
					'condition' => array(
						'iq_' . $type . '_chart_haxis_label_position_show' => 'yes',
						'iq_' . $type . '_chart_haxis_label_prefix_postfix' => 'yes',
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_haxis_label_postfix',
				array(
					'label'     => esc_html__( 'Postfix', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '',
					'condition' => array(
						'iq_' . $type . '_chart_haxis_label_position_show' => 'yes',
						'iq_' . $type . '_chart_haxis_label_prefix_postfix' => 'yes',
					),
				)
			);
		}
		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_label_font_color',
			array(
				'label'     => esc_html__( 'Label Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'condition' => array(
					'iq_' . $type . '_chart_haxis_label_position_show' => 'yes',
				),
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_label_font_size',
			array(
				'label'     => esc_html__( ' Label Fontsize', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 5,
				'max'       => 25,
				'default'   => 11,
				'condition' => array(
					'iq_' . $type . '_chart_haxis_label_position_show' => 'yes',
				),
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_rotate',
			array(
				'label'     => esc_html__( 'Label Rotate', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'true'      => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'false'     => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => false,
				'condition' => array(
					'iq_' . $type . '_chart_haxis_label_position_show' => 'yes',
				),
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_xaxis_rotate_value',
			array(
				'label'     => esc_html__( 'Label Rotate Angle', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 11,
				'max'       => 349,
				'default'   => 50,
				'condition' => array(
					'iq_' . $type . '_chart_xaxis_rotate' => 'yes',
				),
			)
		);
	}
	if ( in_array( $type, array( 'column_google', 'line_google', 'area_google', 'geo_google' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_chart_haxis_direction',
			array(
				'label'     => esc_html__( 'Reverse Category', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'true'      => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'false'     => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => 'false',
				'condition' => array(
					'iq_' . $type . '_chart_haxis_label_position_show' => 'yes',
				),
			)
		);
	}

	$this_ele->add_control(
		'iq_' . $type . '_chart_xaxis_title_devider',
		array(
			'type' => Controls_Manager::DIVIDER,
		)
	);
	$this_ele->add_control(
		'iq_' . $type . '_chart_axis_Title_heading',
		array(
			'label' => esc_html__( 'Title Setting', 'graphina-charts-for-elementor' ),
			'type'  => Controls_Manager::HEADING,
		)
	);
	$this_ele->add_control(
		'iq_' . $type . '_chart_haxis_title_show',
		array(
			'label'   => esc_html__( 'Title Show', 'graphina-charts-for-elementor' ),
			'type'    => Controls_Manager::SWITCHER,
			'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
			'false'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
			'default' => 'false',
		)
	);
	$this_ele->add_control(
		'iq_' . $type . '_chart_haxis_title',
		array(
			'label'     => esc_html__( 'Title', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => 'Title',
			'dynamic'   => array(
				'active' => true,
			),
			'condition' => array(
				'iq_' . $type . '_chart_haxis_title_show' => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_haxis_title_font_color',
		array(
			'label'     => esc_html__( 'Title Color', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#000000',
			'condition' => array(
				'iq_' . $type . '_chart_haxis_title_show' => 'yes',
			),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_chart_haxis_title_font_size',
		array(
			'label'     => esc_html__( ' Title Fontsize', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::NUMBER,
			'min'       => 1,
			'max'       => 25,
			'default'   => 12,
			'condition' => array(
				'iq_' . $type . '_chart_haxis_title_show' => 'yes',
			),
		)
	);

	$this_ele->end_controls_section();
}

/**
 * Function to handle chart v-axis section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_advance_v_axis_setting( Element_Base $this_ele, string $type = 'chart_id' ): void {
	$this_ele->start_controls_section(
		'iq_' . $type . '_section_9',
		array(
			'label' => esc_html__( 'Y-Axis Setting', 'graphina-charts-for-elementor' ),
		)
	);
	if ( in_array( $type, array( 'column_google', 'bar_google', 'line_google', 'area_google' ), true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_vaxis_enable_minmax',
				array(
					'label'   => esc_html__( 'Enable Min/Max', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::SWITCHER,
					'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'false'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default' => 'false',
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_vaxis_minvalue',
				array(
					'label'     => esc_html__( 'Y-axis Min Value', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 0,
					'condition' => array(
						'iq_' . $type . '_chart_vaxis_enable_minmax' => 'yes',
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_vaxis_maxvalue',
				array(
					'label'     => esc_html__( 'Y-axis Max Value', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 250,
					'condition' => array(
						'iq_' . $type . '_chart_vaxis_enable_minmax' => 'yes',
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '__chart_vaxis_enable_minmax_divider',
				array(
					'type' => Controls_Manager::DIVIDER,
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_Label_Settings',
				array(
					'label' => esc_html__( 'Label Setting', 'graphina-charts-for-elementor' ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_vaxis_label_position_show',
				array(
					'label'   => esc_html__( 'Label Show', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::SWITCHER,
					'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'false'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default' => 'yes',
				)
			);

			$this_ele->add_control(
				'iq_' . $type . '_chart_vaxis_label_position',
				array(
					'label'     => esc_html__( 'Label Position', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'out',
					'options'   => graphina_position_type( 'in_out' ),
					'condition' => array(
						'iq_' . $type . '_chart_vaxis_label_position_show' => 'yes',
					),
				)
			);
		if ( $type === 'bar_google' ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_haxis_label_prefix_postfix',
				array(
					'label'     => esc_html__( 'Label Prefix/Postfix', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'true'      => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'false'     => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default'   => '',
					'condition' => array(
						'iq_' . $type . '_chart_haxis_label_position_show' => 'yes',
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_haxis_label_prefix',
				array(
					'label'     => esc_html__( 'Prefix', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '',
					'condition' => array(
						'iq_' . $type . '_chart_haxis_label_position_show' => 'yes',
						'iq_' . $type . '_chart_haxis_label_prefix_postfix' => 'yes',
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_haxis_label_postfix',
				array(
					'label'     => esc_html__( 'Postfix', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '',
					'condition' => array(
						'iq_' . $type . '_chart_haxis_label_position_show' => 'yes',
						'iq_' . $type . '_chart_haxis_label_prefix_postfix' => 'yes',
					),
				)
			);
		}

			$this_ele->add_control(
				'iq_' . $type . '_chart_yaxis_label_font_color',
				array(
					'label'     => esc_html__( 'Label Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#000000',
					'condition' => array(
						'iq_' . $type . '_chart_vaxis_label_position_show' => 'yes',
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_yaxis_label_font_size',
				array(
					'label'     => esc_html__( ' Label Fontsize', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 3,
					'max'       => 18,
					'default'   => 11,
					'condition' => array(
						'iq_' . $type . '_chart_vaxis_label_position_show' => 'yes',
					),
				)
			);

	}
	if ( in_array( $type, array( 'column_google', 'line_google', 'area_google' ), true ) ) {

			$this_ele->add_control(
				'iq_' . $type . '_chart_vaxis_direction',
				array(
					'label'   => esc_html__( 'Reverse Direction', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::SWITCHER,
					'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'false'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'default' => 'false',
				)
			);
	}
	if ( $type === 'bar_google' ) {

		$this_ele->add_control(
			'iq_' . $type . '_chart_haxis_direction',
			array(
				'label'   => esc_html__( 'Reverse Direction', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'false'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default' => 'false',
			)
		);

	}
	if ( $type === 'bar_google' ) {

		$this_ele->add_control(
			'iq_' . $type . '_chart_vaxis_direction',
			array(
				'label'   => esc_html__( 'Reverse Category', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'false'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default' => 'false',
			)
		);
	}
		$this_ele->add_control(
			'iq_' . $type . '_chart_vaxis_format',
			array(
				'label'   => esc_html__( 'Number Format', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'decimal',
				'options' => array(
					'decimal'    => esc_html__( 'Decimal', 'graphina-charts-for-elementor' ),
					'scientific' => esc_html__( 'Scientific', 'graphina-charts-for-elementor' ),
					'\#'         => esc_html__( 'Currency', 'graphina-charts-for-elementor' ),
					"#\'%\'"     => esc_html__( 'Percent', 'graphina-charts-for-elementor' ),
					'short'      => esc_html__( 'Short', 'graphina-charts-for-elementor' ),
					'long'       => esc_html__( 'Long', 'graphina-charts-for-elementor' ),

				),
			)
		);

	$this_ele->add_control(
		'iq_' . $type . '_chart_vaxis_format_currency_prefix',
		array(
			'label'     => esc_html__( 'Currency Prefix', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => '$',
			'condition' => array(
				'iq_' . $type . '_chart_vaxis_format' => '\#',
			),
		)
	);

		$this_ele->add_control(
			'iq_' . $type . '__chart_vaxis_label_divider',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_yaxis_Title_heading',
			array(
				'label' => esc_html__( 'Title Setting', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_vaxis_title_show',
			array(
				'label'   => esc_html__( 'Title Show', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'false'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default' => 'false',
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_vaxis_title',
			array(
				'label'     => esc_html__( 'Title', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Title',
				'dynamic'   => array(
					'active' => true,
				),
				'condition' => array(
					'iq_' . $type . '_chart_vaxis_title_show' => 'yes',
				),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_vaxis_title_font_color',
			array(
				'label'     => esc_html__( 'Title Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'condition' => array(
					'iq_' . $type . '_chart_vaxis_title_show' => 'yes',
				),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_vaxis_title_font_size',
			array(
				'label'     => esc_html__( ' Title Fontsize', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 25,
				'default'   => 12,
				'condition' => array(
					'iq_' . $type . '_chart_vaxis_title_show' => 'yes',
				),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_gridline',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_gridline_setting',
			array(
				'label' => esc_html__( 'Gridline Setting', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_gridline_count_show',
			array(
				'label'   => esc_html__( 'Line Show', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'true'    => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'false'   => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default' => 'yes',
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_gridline_count',
			array(
				'label'     => esc_html__( 'Gridline Count', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5,
				'condition' => array(
					'iq_' . $type . '_chart_gridline_count_show' => 'yes',
				),

			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_gridline_color',
			array(
				'label'     => esc_html__( 'Gridline color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cccccc',
				'condition' => array(
					'iq_' . $type . '_chart_gridline_count_show' => 'yes',
				),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_baseline_Color',
			array(
				'label'   => esc_html__( 'Zero Indicator', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#cccccc',

			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_logscale_setting_title',
			array(
				'label'     => esc_html__( 'Log Scale Settings', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'iq_' . $type . '_chart_gridline_count_show' => 'yes',
				),
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_chart_logscale_show',
			array(
				'label'     => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'true'      => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'false'     => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => 'fasle',
				'condition' => array(
					'iq_' . $type . '_chart_gridline_count_show' => 'yes',
				),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_chart_vaxis_scaletype',
			array(
				'label'     => esc_html__( 'Scale Type', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'log',
				'options'   => array(
					'log'       => esc_html__( 'Log', 'graphina-charts-for-elementor' ),
					'mirrorLog' => esc_html__( 'MirrorLog', 'graphina-charts-for-elementor' ),

				),
				'condition' => array(
					'iq_' . $type . '_chart_logscale_show' => 'yes',
					'iq_' . $type . '_chart_gridline_count_show' => 'yes',
				),
			)
		);

		$this_ele->end_controls_section();
}

/**
 * Function to handle chart advance legend section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 *
 * @return void
 */
function graphina_advance_legend_setting( Element_Base $this_ele, string $type = 'chart_id' ): void {
	$this_ele->start_controls_section(
		'iq_' . $type . '_section_10',
		array(
			'label' => esc_html__( 'Legend Setting', 'graphina-charts-for-elementor' ),
		)
	);

	$this_ele->add_control(
		'iq_' . $type . '_google_chart_legend_show',
		array(
			'label'     => esc_html__( 'Show Legend', 'graphina-charts-for-elementor' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
			'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			'default'   => 'yes',
		)
	);

	if ( in_array( $type, array( 'column_google', 'line_google', 'area_google', 'bar_google' ), true ) ) {

		$this_ele->add_control(
			'iq_' . $type . '_google_chart_legend_position',
			array(
				'label'     => esc_html__( 'Legend Position', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'bottom',
				'options'   => graphina_position_type( 'google_chart_legend_position' ),
				'condition' => array(
					'iq_' . $type . '_google_chart_legend_show' => 'yes',
				),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_google_chart_legend_color',
			array(
				'label'     => esc_html__( 'Legend Text Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'black',
				'options'   => graphina_position_type( 'google_chart_legend_position' ),
				'condition' => array(
					'iq_' . $type . '_google_chart_legend_show' => 'yes',
				),
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_google_chart_legend_fontsize',
			array(
				'label'     => esc_html__( 'Legend Text Fontsize', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 10,
				'min'       => 1,
				'max'       => 15,
				'options'   => graphina_position_type( 'google_chart_legend_position' ),
				'condition' => array(
					'iq_' . $type . '_google_chart_legend_show' => 'yes',
				),
			)
		);
	}
	if ( in_array( $type, array( 'column_google', 'line_google', 'area_google', 'bar_google', 'pie_google', 'donut_google' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_google_chart_legend_horizontal_align',
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
					'iq_' . $type . '_google_chart_legend_show' => 'yes',
				),
			)
		);
	}
	if ( in_array( $type, array( 'pie_google', 'donut_google' ), true ) ) {
		$this_ele->add_control(
			'iq_' . $type . '_google_piechart_legend_position',
			array(
				'label'     => esc_html__( 'Legend Position', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'bottom',
				'options'   => graphina_position_type( 'google_piechart_legend_position' ),
				'condition' => array(
					'iq_' . $type . '_google_chart_legend_show' => 'yes',
				),
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_google_chart_legend_labeld_value',
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
					'iq_' . $type . '_google_chart_legend_show' => 'yes',
					'iq_' . $type . '_google_piechart_legend_position' => 'labeled',
				),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_google_chart_legend_color',
			array(
				'label'     => esc_html__( 'Legend Text Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'black',
				'options'   => graphina_position_type( 'google_piechart_legend_position' ),
				'condition' => array(
					'iq_' . $type . '_google_chart_legend_show' => 'yes',
				),
			)
		);
		$this_ele->add_control(
			'iq_' . $type . '_google_chart_legend_fontsize',
			array(
				'label'     => esc_html__( 'Legend Text Fontsize', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 15,
				'default'   => 10,
				'options'   => graphina_position_type( 'google_piechart_legend_position' ),
				'condition' => array(
					'iq_' . $type . '_google_chart_legend_show' => 'yes',
				),
			)
		);
	}

	if ( $type === 'geo_google' ) {
		$this_ele->add_control(
			'iq_' . $type . '_google_legend_color',
			array(
				'label'     => esc_html__( 'Legend Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'iq_' . $type . '_google_chart_legend_show' => 'yes',
				),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_google_legend_size',
			array(
				'label'     => esc_html__( 'Legend Size', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'condition' => array(
					'iq_' . $type . '_google_chart_legend_show' => 'yes',
				),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_google_legend_format',
			array(
				'label'     => esc_html__( 'Number Format', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'iq_' . $type . '_google_chart_legend_show' => 'yes',
				),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_google_legend_bold',
			array(
				'label'     => esc_html__( 'Bold', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'iq_' . $type . '_google_chart_legend_show' => 'yes',
				),
			)
		);

		$this_ele->add_control(
			'iq_' . $type . '_google_legend_italic',
			array(
				'label'     => esc_html__( 'Italic', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'iq_' . $type . '_google_chart_legend_show' => 'yes',
				),
			)
		);
	}

	$this_ele->end_controls_section();
}

/**
 * Function to handle google chart series section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 * @param array        $ele_array Array of which section to show.
 *
 * @return void
 */
function graphina_google_series_setting( Element_Base $this_ele, string $type = 'chart_id', array $ele_array = array( 'color' ) ): void {
	$colors      = graphina_colors();
	$series_name = esc_html__( 'Element', 'graphina-charts-for-elementor' );

	$this_ele->start_controls_section(
		'iq_' . $type . '_section_12',
		array(
			'label' => esc_html__( 'Elements Setting', 'graphina-charts-for-elementor' ),
		)
	);
	$max_series = graphina_default_setting( 'max_series_value' );
	for ( $i = 0; $i < $max_series; $i++ ) {

		if ( $i !== 0 ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_hr_series_count_' . $i,
				array(
					'type'      => Controls_Manager::DIVIDER,
					'condition' => array(
						'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
		}

		$this_ele->add_control(
			'iq_' . $type . '_chart_series_title_' . $i,
			array(
				'label'     => $series_name . ' ' . ( $i + 1 ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
				),
			)
		);

		if ( in_array( 'color', $ele_array, true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_element_color_' . $i,
				array(
					'label'     => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => $colors[ $i ],
					'condition' => array(
						'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
		}

		if ( in_array( $type, array( 'line_google', 'area_google' ), true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_element_linewidth' . $i,
				array(
					'label'     => esc_html__( ' LineWidth', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 2,
					'min'       => 1,
					'condition' => array(
						'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
			$this_ele->add_control(
				'iq_' . $type . '_chart_element_lineDash' . $i,
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
						'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
		}

		if ( in_array( 'width', $ele_array, true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_width_3_' . $i,
				array(
					'label'     => 'Stroke Width',
					'type'      => Controls_Manager::NUMBER,
					'default'   => 5,
					'min'       => 1,
					'max'       => 20,
					'condition' => array(
						'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
		}

		$chart_type = array( 'line_google', 'area_google', 'column_google' );

		if ( in_array( $type, $chart_type, true ) ) {

			graphina_marker_setting_google( $this_ele, $type, $i );

		}
	}
	$this_ele->end_controls_section();
}

/**
 * Function to handle google column type chart series section settings for Elementor widgets.
 *
 * @param Element_Base $this_ele The Elementor element instance.
 * @param string       $type     Type of chart being configured.
 * @param array        $ele_array Array of which section to show.
 *
 * @return void
 */
function graphina_column_chart_google_series_setting( Element_Base $this_ele, string $type = 'chart_id', array $ele_array = array( 'color' ) ): void {
	$colors      = graphina_colors();
	$series_name = esc_html__( 'Element Setting', 'graphina-charts-for-elementor' );

	$this_ele->start_controls_section(
		'iq_' . $type . '_section_13',
		array(
			'label'      => esc_html__( 'Elements Setting', 'graphina-charts-for-elementor' ),
			'conditions' => array(
				'relation' => 'or',
				'terms'    => array(
					array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => 'iq_' . $type . '_chart_is_pro',
								'operator' => '==',
								'value'    => 'false',
							),
							array(
								'name'     => 'iq_' . $type . '_chart_data_option',
								'operator' => '==',
								'value'    => 'manual',
							),
						),
					),
					array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => 'iq_' . $type . '_chart_is_pro',
								'operator' => '==',
								'value'    => 'true',
							),
						),
					),
				),
			),
		)
	);
	$max_series = graphina_default_setting( 'max_series_value' );
	for ( $i = 0; $i < $max_series; $i++ ) {

		if ( $i !== 0 ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_hr_series_count_' . $i,
				array(
					'type'      => Controls_Manager::DIVIDER,
					'condition' => array(
						'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
		}

		$this_ele->add_control(
			'iq_' . $type . '_chart_series_title_' . $i,
			array(
				'label'     => $series_name . ' ' . ( $i + 1 ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
				),
			)
		);

		if ( in_array( 'color', $ele_array, true ) ) {
			$this_ele->add_control(
				'iq_' . $type . '_chart_element_color_' . $i,
				array(
					'label'     => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => $colors[ $i ],
					'condition' => array(
						'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
					),
				)
			);
		}
	}
	$this_ele->end_controls_section();
}


/**
 * Function to handle google column type chart series section settings for Elementor widgets.
 *
 * @param array  $settings The widget settings data.
 * @param string $type     Type of widget being configured.
 *
 * @return array
 */
function graphina_ajax_settings( array $settings, string $type ): array {
	return array(
		'iq_' . $type . '_can_chart_reload_ajax' => ! empty( $settings[ 'iq_' . $type . '_can_chart_reload_ajax' ] ) ? $settings[ 'iq_' . $type . '_can_chart_reload_ajax' ] : '',
		'iq_' . $type . '_interval_data_refresh' => ! empty( $settings[ 'iq_' . $type . '_interval_data_refresh' ] ) && $settings[ 'iq_' . $type . '_interval_data_refresh' ] !== 0 ? $settings[ 'iq_' . $type . '_interval_data_refresh' ] : 10,
		'iq_' . $type . '_chart_filter_enable'   => ! empty( $settings[ 'iq_' . $type . '_chart_filter_enable' ] ) ? $settings[ 'iq_' . $type . '_chart_filter_enable' ] : '',
	);
}

<?php
/**
 * Apex candle chart elementor widget class.
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina_Charts_For_Elementor
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Elementor candle widget.
 *
 * Elementor widget that displays an eye-catching candle chart widget.
 *
 * @since 1.5.7
 */
class Candle_Chart extends Widget_Base {


	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @return string Widget name.
	 * @since 1.5.7
	 * @access public
	 */
	public function get_name(): string {
		return 'candle_chart';
	}

	/**
	 * Get widget Title.
	 *
	 * Retrieve heading widget Title.
	 *
	 * @return string Widget Title.
	 * @since 1.5.7
	 * @access public
	 */
	public function get_title(): string {
		return 'Candle';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @return array Widget categories.
	 * @since 1.5.7
	 * @access public
	 */
	public function get_categories(): array {
		return array( 'iq-graphina-charts' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.5.7
	 * @access public
	 */
	public function get_icon(): string {
		return 'graphina-apex-candle-chart';
	}

	/**
	 * Function to generate candle chart data.
	 *
	 * @param string $type controller type.
	 * @param int    $i index.
	 * @param int    $min min value.
	 * @param int    $max max value.
	 * @param int    $range range value.
	 * @param int    $len length.
	 * @return array
	 */
	protected function candle_data_generator( string $type = '', int $i = 0, int $min = 0, int $max = 100, int $range = 5, int $len = 25 ): array {
		$result = array();
		for ( $j = 0; $j < $len; $j++ ) {
			$default  = wp_rand( $min, $max );
			$result[] =
				array(
					'iq_' . $type . '_chart_value_open_3_' . $i => round( ( wp_rand( $default + $range, $default - $range ) * 1.00002 ), 2 ),
					'iq_' . $type . '_chart_value_high_3_' . $i => round( ( wp_rand( $default + $range, $default - $range ) * 1.00002 ), 2 ),
					'iq_' . $type . '_chart_value_low_3_' . $i => round( ( wp_rand( $default + $range, $default - $range ) * 1.00002 ), 2 ),
					'iq_' . $type . '_chart_value_close_3_' . $i => round( ( wp_rand( $default + $range, $default - $range ) * 1.00002 ), 2 ),
					'iq_' . $type . '_chart_value_date_3_' . $i => graphina_get_random_date(
						date( 'Y-m-d H:i' ), @//phpcs:ignore
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
	 * Get widget type.
	 *
	 * @return string Widget ty[e.
	 *
	 * @access public
	 */
	public function get_chart_type(): string {
		return 'candle';
	}

	/**
	 * Register controller to elementor
	 *
	 * @return void
	 */
	protected function register_controls(): void {
		$type = $this->get_chart_type();

		graphina_basic_setting( $this, $type );

		graphina_chart_data_option_setting( $this, $type );

		$this->start_controls_section(
			'iq_' . $type . '_section_2',
			array(
				'label'      => esc_html__( 'Chart Setting', 'graphina-charts-for-elementor' ),
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

		$this->add_control(
			'iq_' . $type . '_chart_background_color1',
			array(
				'label' => esc_html__( 'Chart Background Color', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::COLOR,
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_height',
			array(
				'label'   => esc_html__( 'Height (px)', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 350,
				'step'    => 5,
				'min'     => 100,
			)
		);

		$this->add_control(
			'iq_' . $type . '_can_chart_show_toolbar',
			array(
				'label'     => esc_html__( 'Toolbar', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => false,
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_no_data_text',
			array(
				'label'       => esc_html__( 'No Data Text', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Loading...', 'graphina-charts-for-elementor' ),
				'default'     => 'No Data Available',
			)
		);

		graphina_tooltip( $this, $type );

		$this->add_control(
			'iq_' . $type . '_chart_hr_fill_setting',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_fill_setting_title',
			array(
				'label' => esc_html__( 'Fill Settings', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_is_fill_color_show',
			array(
				'label'     => esc_html__( 'Color Show', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_is_fill_opacity',
			array(
				'label'   => esc_html__( 'Opacity', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 0.00,
				'max'     => 1,
				'step'    => 0.05,
			)
		);

		$this->add_control(
			'iq_chart_upward_color',
			array(
				'label'   => esc_html__( 'Upward Color', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#008B36',
			)
		);

		$this->add_control(
			'iq_chart_downward_color',
			array(
				'label'   => esc_html__( 'Downward Color', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#C70000',
			)
		);

		graphina_animation( $this, $type );

		$this->end_controls_section();

		graphina_chart_label_setting( $this, $type );

		graphina_advance_x_axis_setting( $this, $type );

		graphina_advance_y_axis_setting( $this, $type );

		graphina_series_setting( $this, $type, array( 'color' ), false );

		$max_series = graphina_default_setting( 'max_series_value' );
		for ( $i = 0; $i < $max_series; $i++ ) {
			$this->start_controls_section(
				'iq_' . $type . '_section_3_' . $i,
				array(
					'label'      => esc_html__( 'Element ', 'graphina-charts-for-elementor' ) . ( $i + 1 ),
					'condition'  => array(
						'iq_' . $type . '_chart_data_series_count' => range( 1 + $i, graphina_default_setting( 'max_series_value' ) ),
						'iq_' . $type . '_chart_data_option' => 'manual',
					),
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

			$this->add_control(
				'iq_' . $type . '_chart_title_3_' . $i,
				array(
					'label'       => esc_html__( 'Title', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Add Tile', 'graphina-charts-for-elementor' ),
					'default'     => 'Element ' . ( $i + 1 ),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);

			$repeater = new Repeater();

			$repeater->add_control(
				'iq_' . $type . '_chart_value_date_3_' . $i,
				array(
					'label'       => esc_html__( 'Chart Date ( X ) Value', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::DATE_TIME,
					'placeholder' => esc_html__( 'Select Date', 'graphina-charts-for-elementor' ),
				)
			);

			$repeater->add_control(
				'iq_' . $type . '_chart_value_open_3_' . $i,
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
				'iq_' . $type . '_chart_value_high_3_' . $i,
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
				'iq_' . $type . '_chart_value_low_3_' . $i,
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
				'iq_' . $type . '_chart_value_close_3_' . $i,
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
			$this->add_control(
				'iq_' . $type . '_chart_value_list_3_1_' . $i,
				array(
					'label'       => esc_html__( 'Chart value list', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => $this->candle_data_generator( 'candle', $i, 6000, 8000, 500, 50 ),
					'title_field' => '{{{ iq_' . $type . '_chart_value_date_3_' . $i . ' }}}',
				)
			);

			$this->end_controls_section();
		}

		graphina_style_section( $this, $type );

		graphina_card_style( $this, $type );

		graphina_chart_style( $this, $type );

		graphina_chart_filter_style( $this, $type );

		if ( function_exists( 'graphina_pro_password_style_section' ) ) {
			graphina_pro_password_style_section( $this, $type );
		}
	}

	/**
	 * Render element.
	 *
	 * Generates the final HTML on the frontend.
	 *
	 * @return void
	 */
	protected function render(): void {
		$settings      = $this->get_settings_for_display();
		$type          = $this->get_chart_type();
		$ajax_settings = graphina_ajax_settings( $settings, $type );
		$main_id       = graphina_widget_id( $this );
		$gradient      = array();
		$data          = array(
			'series'   => array(),
			'category' => array(),
		);
		$series_count  = isset( $settings[ 'iq_' . $type . '_chart_data_series_count' ] ) ? $settings[ 'iq_' . $type . '_chart_data_series_count' ] : 0;
		$call_ajax     = false;
		$loading_text  = esc_html( isset( $settings[ 'iq_' . $type . '_chart_no_data_text' ] ) ? $settings[ 'iq_' . $type . '_chart_no_data_text' ] : '' );

		$export_file_name = (
			! empty( $settings[ 'iq_' . $type . '_can_chart_show_toolbar' ] ) && $settings[ 'iq_' . $type . '_can_chart_show_toolbar' ] === 'yes'
			&& ! empty( $settings[ 'iq_' . $type . '_export_filename' ] )
		) ? $settings[ 'iq_' . $type . '_export_filename' ] : $main_id;

		$y_label_prefix  = '';
		$y_label_postfix = '';
		$x_label_prefix  = '';
		$x_label_postfix = '';

		if ( $settings[ 'iq_' . $type . '_chart_xaxis_label_show' ] === 'yes' ) {
			$x_label_prefix  = $settings[ 'iq_' . $type . '_chart_xaxis_label_prefix' ];
			$x_label_postfix = $settings[ 'iq_' . $type . '_chart_xaxis_label_postfix' ];
		}

		if ( $settings[ 'iq_' . $type . '_chart_yaxis_label_show' ] === 'yes' ) {
			$y_label_prefix  = $settings[ 'iq_' . $type . '_chart_yaxis_label_prefix' ];
			$y_label_postfix = $settings[ 'iq_' . $type . '_chart_yaxis_label_postfix' ];
		}

		if ( graphina_pro_active() && $settings[ 'iq_' . $type . '_chart_data_option' ] !== 'manual' ) {
			$call_ajax    = true;
			$gradient     = array( '#ffffff' );
			$loading_text = esc_html__( 'Loading...', 'graphina-charts-for-elementor' );
		} else {
			for ( $i = 0; $i < $series_count; $i++ ) {
				$gradient[] = esc_html( $settings[ 'iq_' . $type . '_chart_gradient_1_' . $i ] );
				$chart_data = array();
				$value_list = $settings[ 'iq_' . $type . '_chart_value_list_3_1_' . $i ];
				if ( gettype( $value_list ) === 'NULL' ) {
					$value_list = array();
				}
				foreach ( $value_list as $val ) {
					$chart_data[] = array(
						'x' => strtotime( graphina_get_dynamic_tag_data( $val, 'iq_' . $type . '_chart_value_date_3_' . $i ) ) * 1000,
						'y' => array(
							(float) graphina_get_dynamic_tag_data( $val, 'iq_' . $type . '_chart_value_open_3_' . $i ),
							(float) graphina_get_dynamic_tag_data( $val, 'iq_' . $type . '_chart_value_high_3_' . $i ),
							(float) graphina_get_dynamic_tag_data( $val, 'iq_' . $type . '_chart_value_low_3_' . $i ),
							(float) graphina_get_dynamic_tag_data( $val, 'iq_' . $type . '_chart_value_close_3_' . $i ),
						),
					);
				}
				$data['series'][] = array(
					'name' => esc_html( graphina_get_dynamic_tag_data( $settings, 'iq_' . $type . '_chart_title_3_' . $i ) ),
					'data' => $chart_data,
				);
			}
			if ( $settings[ 'iq_' . $type . '_chart_data_option' ] === 'dynamic' ) {
				$data = array(
					'series'   => array(),
					'category' => array(),
				);
			}
			$gradient_new   = array();
			$desired_length = count( $data['series'] );
			$current_length = 0;
			while ( $current_length < $desired_length ) {
				$gradient_new   = array_merge( $gradient_new, $gradient );
				$current_length = count( $gradient_new );
			}
			$gradient = array_slice( $gradient_new, 0, $desired_length );
		}

		$gradient = implode( '_,_', $gradient );
		graphina_chart_widget_content( $this, $main_id, $settings );
		if ( graphina_restricted_access( 'candle', $main_id, $settings, false ) === false ) {
			?>
			<script>
				(function (){
					if (typeof isInit === 'undefined') {
						var isInit = {};
					}
					isInit['<?php echo esc_js( $main_id ); ?>'] = false;

					const myElement = document.querySelector(".candle-chart-<?php echo esc_js( $main_id ); ?>");

					const candleOptions = {
						series: <?php echo wp_json_encode( $data['series'] ); ?>,
						chart: {
							background: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_background_color1' ] ); ?>',
							height: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_height' ] ); ?>'),
							type: 'candlestick',
							fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
                            locales: [JSON.parse('<?php echo graphina_apexchart_localization(); //@phpcs:ignore ?>')],
							defaultLocale: "en",
							toolbar: {
								offsetX: parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_toolbar_offsetx' ] ) ? $settings[ 'iq_' . $type . '_chart_toolbar_offsetx' ] : 0 ); ?>') || 0,
								offsetY: parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_toolbar_offsety' ] ) ? $settings[ 'iq_' . $type . '_chart_toolbar_offsety' ] : 0 ); ?>')|| 0,
								show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_can_chart_show_toolbar' ] === 'yes' ); ?>',
								export: {
									csv: {
										filename: "<?php echo esc_js( $export_file_name ); ?>"
									},
									svg: {
										filename: "<?php echo esc_js( $export_file_name ); ?>"
									},
									png: {
										filename: "<?php echo esc_js( $export_file_name ); ?>"
									}
								}
							},
							animations: {
								enabled: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_animation' ] === 'yes' ); ?>',
								speed: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_animation_speed' ] ); ?>') || 800,
								delay: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_animation_delay' ] ); ?>') || 150
							}
						},
						plotOptions: {
							candlestick: {
								colors: {
									upward: '<?php echo esc_js( $settings['iq_chart_upward_color'] ); ?>',
									downward: '<?php echo esc_js( $settings['iq_chart_downward_color'] ); ?>'
								},
								wick: {
									useFillColor: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_is_fill_color_show' ] === 'yes' ); ?>',
								}
							}
						},
						noData: {
							text: '<?php echo esc_js( $loading_text ); ?>',
							align: 'center',
							verticalAlign: 'middle',
							style: {
								fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
								fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
								color: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_color' ] ); ?>'
							}
						},
						grid: {
							borderColor: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_line_grid_color' ] ) ? $settings[ 'iq_' . $type . '_chart_yaxis_line_grid_color' ] : '#90A4AE' ); ?>',
							yaxis: {
								lines: {
									show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_line_show' ] === 'yes' ); ?>'
								}
							}
						},
						xaxis: {
							type: 'datetime',
							position: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_position' ] ); ?>',
							labels: {
								show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_show' ] === 'yes' ); ?>',
								rotateAlways: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_auto_rotate' ] === 'yes' ); ?>',
								rotate: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_rotate' ] ); ?>')|| 0,
								offsetX: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_offset_x' ] ); ?>')|| 0,
								offsetY: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_offset_y' ] ); ?>')|| 0,
								trim: true,
								style: {
									colors: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_color' ] ); ?>',
									fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
									fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
									fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>'
								},
								formatter: function (val) {
									const showTime = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_xaxis_show_time' ] ) && $settings[ 'iq_' . $type . '_chart_xaxis_show_time' ] === 'yes' ? 'true' : 'false' ); ?>' === 'true'
									const showDate = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_xaxis_show_date' ] ) && $settings[ 'iq_' . $type . '_chart_xaxis_show_date' ] === 'yes' ? 'true' : 'false' ); ?>' === 'true'
									val =  dateFormat(
										val,
										showTime,
										showDate
									)
									return '<?php echo esc_js( $x_label_prefix ); ?>' + val + '<?php echo esc_js( $x_label_postfix ); ?>';
								}
							},
							tooltip: {
								enabled: "<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_xaxis_tooltip_show' ] ) && $settings[ 'iq_' . $type . '_chart_xaxis_tooltip_show' ] === 'yes' ); ?>"
							},
							crosshairs: {
								show: "<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_xaxis_crosshairs_show' ] ) && $settings[ 'iq_' . $type . '_chart_xaxis_crosshairs_show' ] === 'yes' ); ?>"
							}
						},
						yaxis: {
							opposite: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_position' ] ); ?>',
							tickAmount: parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_tick_amount' ] ); ?>"),
							decimalsInFloat: parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_decimals_in_float' ] ); ?>"),
							labels: {
								show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_show' ] === 'yes' ); ?>',
								rotate: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_rotate' ] ); ?>') || 0 ,
								offsetX: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_offset_x' ] ); ?>') || 0,
								offsetY: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_offset_y' ] ); ?>') || 0,
								style: {
									colors: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_color' ] ); ?>',
									fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
									fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
									fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>'
								}
							},
							tooltip: {
								enabled: "<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_tooltip_show' ] ) && $settings[ 'iq_' . $type . '_chart_yaxis_tooltip_show' ] === 'yes' ); ?>"
							},
							crosshairs: {
								show: "<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_crosshairs_show' ] ) && $settings[ 'iq_' . $type . '_chart_yaxis_crosshairs_show' ] === 'yes' ); ?>"
							}
						},
						colors: '<?php echo esc_js( $gradient ); ?>'.split('_,_'),
						stroke: {
							show: true,
							width: 0.7,
							colors: '<?php echo esc_js( $gradient ); ?>'.split('_,_')
						},
						fill: {
							opacity: parseFloat('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_is_fill_opacity' ] ); ?>')
						},
						legend: {
							onItemClick: {
								toggleDataSeries: false
							},
							showForSingleSeries:true,
							show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_legend_show' ] === 'yes' ); ?>',
							position: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_legend_position' ] ) ? esc_html( $settings[ 'iq_' . $type . '_chart_legend_position' ] ) : 'bottom' ); ?>',
							horizontalAlign: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_legend_horizontal_align' ] ) ? esc_html( $settings[ 'iq_' . $type . '_chart_legend_horizontal_align' ] ) : 'center' ); ?>',
							fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
							fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
							fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
							labels: {
								colors: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_color' ] ); ?>'
							}
						},
						tooltip: {
							theme: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip_theme' ] ); ?>',
							enabled: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip' ] === 'yes' ); ?>',
							style: {
								fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
								fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>'
							}
						}
					};

					if ("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_label_show' ] ) === 'yes'; ?>" ) {
						candleOptions.yaxis.labels.formatter = function (val) {
							if("<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_label_pointer' ] ) && $settings[ 'iq_' . $type . '_chart_yaxis_label_pointer' ] === 'yes' ); ?>"
								&&  typeof graphinaAbbrNum  !== "undefined"){
								val = graphinaAbbrNum(val ,  parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_label_pointer_number' ] ); ?>") || 0 );
							}
							return '<?php echo esc_js( $y_label_prefix ); ?>' + val + '<?php echo esc_js( $y_label_postfix ); ?>';
						}
					}

					if ("<?php echo esc_html( $settings[ 'iq_' . $type . '_chart_yaxis_0_indicator_show' ] ) === 'yes'; ?>" ) {
						candleOptions['annotations'] = {
							yaxis: [
								{
									y: 0,
									strokeDashArray: parseInt("<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_0_indicator_stroke_dash' ] ) ? $settings[ 'iq_' . $type . '_chart_yaxis_0_indicator_stroke_dash' ] : 0 ); ?>"),
									borderColor: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_0_indicator_stroke_color' ] ) ? $settings[ 'iq_' . $type . '_chart_yaxis_0_indicator_stroke_color' ] : '#000000' ); ?>'
								}
							]
						};
					}

					if("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_title_enable' ] === 'yes' ); ?>"){
						let style ={
							color:'<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_color' ] ); ?>',
							fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
							fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
							fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
						}
						let title = '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_title' ] ); ?>';
						let xaxisYoffset ='<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_position' ] ) === 'top'; ?>' ? -95 : 0;
						if(typeof axisTitle !== "undefined"){
							axisTitle(candleOptions, 'xaxis' ,title, style ,xaxisYoffset);
						}
					}

					if("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_title_enable' ] === 'yes' ); ?>"){
						let style ={
							color:'<?php echo esc_js( $settings[ 'iq_' . $type . '_card_yaxis_title_font_color' ] ); ?>',
							colors:'<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_color' ] ); ?>',
							fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
							fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
							fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
						}
						let title = '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_title' ] ); ?>';
						if(typeof axisTitle !== "undefined"){
							axisTitle(candleOptions, 'yaxis' ,title, style );
						}
					}

					if("<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_opposite_yaxis_title_enable' ] ) && $settings[ 'iq_' . $type . '_chart_opposite_yaxis_title_enable' ] === 'yes' ); ?>"){
						let style = {
							color:'<?php echo esc_js( $settings[ 'iq_' . $type . '_card_opposite_yaxis_title_font_color' ] ); ?>',
							colors:'<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_color' ] ); ?>',
							fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
							fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
							fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
						}
						candleOptions['yaxis'] = [candleOptions.yaxis]
						candleOptions.yaxis.push({
							opposite: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_position' ] === 'yes' ) ? false : true; ?>',
							labels: {
								show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_opposite_yaxis_label_show' ] === 'yes' ); ?>',
								formatter: function (val) {
									return '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_opposite_yaxis_label_prefix' ] ); ?>'  + val + '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_opposite_yaxis_label_postfix' ] ); ?>'
								},
								style
							},
							tickAmount: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_opposite_yaxis_tick_amount' ] ); ?>'),
							title: {
								text: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_opposite_yaxis_title' ] ); ?>',
								style
							}
						})
					}

					if (typeof initNowGraphina !== "undefined") {
						initNowGraphina(
							myElement,
							{
								ele: myElement,
								options: candleOptions,
								series: [{name: '', data: []}],
								animation: true,
								setting_date:<?php echo Plugin::$instance->editor->is_edit_mode() ? wp_json_encode( $settings ) : wp_json_encode( $ajax_settings ); ?>
							},
							'<?php echo esc_js( $main_id ); ?>'
						);
					}

					if (window.ajaxIntervalGraphina_<?php echo esc_js( $main_id ); ?> !== undefined) {
						clearInterval(window.ajaxIntervalGraphina_<?php echo esc_js( $main_id ); ?>)
					}
				})()

			</script>
			<?php
		}
		if ( graphina_pro_active() && $settings[ 'iq_' . $type . '_chart_data_option' ] !== 'manual' ) {
			graphina_ajax_reload( $call_ajax, array(), $type, $main_id );
		}
	}
}

Plugin::instance()->widgets_manager->register( new Candle_Chart() );

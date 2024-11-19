<?php
/**
 * Apex radial chart elementor widget class.
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
 * Elementor radial chart widget.
 *
 * Elementor widget that displays an eye-catching radial chart.
 */
class Radial_Chart extends Widget_Base {

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
		return 'radial_chart';
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
		return 'Radial';
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
	public function get_categories() {
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
		return 'graphina-apex-radial-chart';
	}

	/**
	 * Get widget type.
	 *
	 * @return string Widget ty[e.
	 *
	 * @access public
	 */
	public function get_chart_type(): string {
		return 'radial';
	}

	/**
	 * Register controller to elementor
	 *
	 * @return void
	 */
	protected function register_controls(): void {
		$type          = $this->get_chart_type();
		$default_label = graphina_default_setting( 'categories' );

		graphina_basic_setting( $this, $type );

		graphina_chart_data_option_setting( $this, $type );

		$this->start_controls_section(
			'iq_' . $type . '_chart_section_2',
			array(
				'label' => esc_html__( 'Chart Setting', 'graphina-charts-for-elementor' ),
			)
		);

		graphina_common_chart_setting( $this, $type, true, true, false, false );

		graphina_tooltip( $this, $type, true, false );

		$this->add_control(
			'iq_' . $type . '_chart_hr_plot_setting',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_plot_setting_title',
			array(
				'label' => esc_html__( 'Plot Settings', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_is_stroke_rounded',
			array(
				'label'     => esc_html__( 'Linecap Stroke Rounded', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => false,
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_line_width',
			array(
				'label'   => esc_html__( 'Line width (%)', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 20,
				'max'     => 70,
				'step'    => 5,
				'default' => 30,
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_track_width',
			array(
				'label'   => 'Track Width',
				'type'    => Controls_Manager::NUMBER,
				'default' => 97,
				'min'     => 0,
				'max'     => 100,
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_track_color_enable',
			array(
				'label'     => esc_html__( 'Chart Track Background Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => false,
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_track_color',
			array(
				'label'     => 'Track Color',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#808080',
				'condition' => array(
					'iq_' . $type . '_chart_track_color_enable' => 'yes',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_track_opacity',
			array(
				'label'   => 'Track Opacity',
				'type'    => Controls_Manager::NUMBER,
				'default' => 0.2,
				'min'     => 0,
				'max'     => 0.5,
				'step'    => 0.01,
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_angle',
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

		$this->add_control(
			'iq_' . $type . '_chart_start_angle',
			array(
				'label'     => esc_html__( 'Start Angle', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 315,
				'step'      => 5,
				'default'   => 0,
				'condition' => array(
					'iq_' . $type . '_chart_angle' => 'custom',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_end_angle',
			array(
				'label'     => esc_html__( 'End Angle', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 45,
				'max'       => 360,
				'step'      => 5,
				'default'   => 270,
				'condition' => array(
					'iq_' . $type . '_chart_angle' => 'custom',
				),
			)
		);

		graphina_animation( $this, $type );

		$this->end_controls_section();

		graphina_chart_label_setting( $this, $type );

		graphina_series_setting( $this, $type, array( 'color' ), true, array( 'classic', 'gradient', 'pattern' ), false, true );

		$max_series = graphina_default_setting( 'max_series_value' );
		for ( $i = 0; $i <= $max_series; $i++ ) {

			$this->start_controls_section(
				'iq_' . $type . '_section_series' . $i,
				array(
					'label'      => esc_html__( 'Element ', 'graphina-charts-for-elementor' ) . ( $i + 1 ),
					'condition'  => array(
						'iq_' . $type . '_chart_data_series_count' => range( $i + 1, graphina_default_setting( 'max_series_value' ) ),
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
				'iq_' . $type . '_chart_label' . $i,
				array(
					'label'       => 'Label',
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Add Label', 'graphina-charts-for-elementor' ),
					'default'     => $default_label[ $i ],
					'dynamic'     => array(
						'active' => true,
					),
				)
			);

			$this->add_control(
				'iq_' . $type . '_chart_value' . $i,
				array(
					'label'       => 'Value',
					'type'        => Controls_Manager::NUMBER,
					'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
					'default'     => $i*50,
					'dynamic'     => array(
						'active' => true,
					),
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
		$type          = $this->get_chart_type();
		$settings      = $this->get_settings_for_display();
		$ajax_settings = graphina_ajax_settings( $settings, $type );

		$main_id                  = graphina_widget_id( $this );
		$value_list               = $settings[ 'iq_' . $type . '_chart_data_series_count' ];
		$gradient                 = array();
		$second_gradient          = array();
		$fill_pattern             = array();
		$data_label_prefix        = '';
		$data_label_postfix       = '';
		$data                     = array(
			'category' => array(),
			'series'   => array(),
			'total'    => 0,
		);
		$call_ajax                = false;
		$loading_text             = esc_html( isset( $settings[ 'iq_' . $type . '_chart_no_data_text' ] ) ? $settings[ 'iq_' . $type . '_chart_no_data_text' ] : '' );

		$export_file_name = (
			! empty( $settings[ 'iq_' . $type . '_can_chart_show_toolbar' ] ) && $settings[ 'iq_' . $type . '_can_chart_show_toolbar' ] === 'yes'
			&& ! empty( $settings[ 'iq_' . $type . '_export_filename' ] )
		) ? $settings[ 'iq_' . $type . '_export_filename' ] : $main_id;

		if ( gettype( $value_list ) === 'NULL' ) {
			$value_list = 0;
		}
		if ( $settings[ 'iq_' . $type . '_chart_datalabel_show' ] === 'yes' ) {
			$data_label_prefix  = $settings[ 'iq_' . $type . '_chart_datalabel_prefix' ];
			$data_label_postfix = $settings[ 'iq_' . $type . '_chart_datalabel_postfix' ];
		}

		if ( $settings[ 'iq_' . $type . '_chart_angle' ] === 'circle' ) {
			$start_angle = 0;
			$end_angle   = 360;
		} elseif ( $settings[ 'iq_' . $type . '_chart_angle' ] === 'semi_circle' ) {
			$start_angle = -90;
			$end_angle   = 90;
		} else {
			$start_angle = $settings[ 'iq_' . $type . '_chart_start_angle' ];
			$end_angle   = $settings[ 'iq_' . $type . '_chart_end_angle' ];
		}

		for ( $i = 0; $i < $value_list; $i++ ) {
			$gradient[]        = esc_html( $settings[ 'iq_' . $type . '_chart_gradient_1_' . $i ] );
			$second_gradient[] = esc_html( ! isset( $settings[ 'iq_' . $type . '_chart_gradient_2_' . $i ] ) ? $settings[ 'iq_' . $type . '_chart_gradient_1_' . $i ] : $settings[ 'iq_' . $type . '_chart_gradient_2_' . $i ] );
			$fill_pattern[]    = esc_html( isset( $settings[ 'iq_' . $type . '_chart_bg_pattern_' . $i ] ) ? $settings[ 'iq_' . $type . '_chart_bg_pattern_' . $i ] : 'verticalLines' );
		}

		if ( graphina_pro_active() && $settings[ 'iq_' . $type . '_chart_data_option' ] !== 'manual' ) {
			$call_ajax       = true;
			$gradient        = array( '#ffffff' );
			$second_gradient = array( '#ffffff' );
			$loading_text    = esc_html__( 'Loading...', 'graphina-charts-for-elementor' );
		} else {
			$temp = '';
			for ( $i = 0; $i < $value_list; $i++ ) {
				$temp = esc_html( graphina_get_dynamic_tag_data( $settings, 'iq_' . $type . '_chart_label' . $i ) );
				$data['category'][] = htmlspecialchars_decode($temp);
				$val                = (float) graphina_get_dynamic_tag_data( $settings, 'iq_' . $type . '_chart_value' . $i );
				$data['series'][]   = $val;
				$data['total']     += $val;
			}
			$gradient_new        = array();
			$second_gradient_new = array();
			$fill_pattern_new    = array();
			$desired_length      = count( $data['series'] );
			$length              = 0;
			while ( $length < $desired_length ) {
				$gradient_new        = array_merge( $gradient_new, $gradient );
				$second_gradient_new = array_merge( $second_gradient_new, $second_gradient );
				$fill_pattern_new    = array_merge( $fill_pattern_new, $fill_pattern );
				$length              = count( $gradient_new );
			}

			$gradient        = array_slice( $gradient_new, 0, $desired_length );
			$second_gradient = array_slice( $second_gradient_new, 0, $desired_length );
			$fill_pattern    = array_slice( $fill_pattern_new, 0, $desired_length );
		}

		$gradient          = implode( '_,_', $gradient );
		$second_gradient   = implode( '_,_', $second_gradient );
		$fill_pattern      = implode( '_,_', $fill_pattern );
		$label             = implode( '_,_', $data['category'] );
		$value             = implode( ',', $data['series'] );
		$local_string_type = graphina_common_setting_get( 'thousand_seperator' );
		graphina_chart_widget_content( $this, $main_id, $settings );
		if ( graphina_restricted_access( 'radial', $main_id, $settings, false ) === false ) {
			?>
			<script>
				(function (){
					if (typeof isInit === 'undefined') {
						var isInit = {};
					}
					isInit['<?php echo esc_js( $main_id ); ?>'] = false;

					const myElement = document.querySelector(".radial-chart-<?php echo esc_js( $main_id ); ?>");
					const radialOptions = {
						series: [<?php echo esc_js( $value ); ?>],
						chart: {
							background: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_background_color1' ] ); ?>',
							height: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_height' ] ); ?>'),
							type: 'radialBar',
							fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
							locales: [JSON.parse('<?php echo graphina_apexchart_localization(); //@phpcs:ignore ?>')],
							defaultLocale: "en",
							toolbar: {
								offsetX: parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_toolbar_offsetx' ] ) ? $settings[ 'iq_' . $type . '_chart_toolbar_offsetx' ] : 0 ); ?>') || 0,
								offsetY: parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_toolbar_offsety' ] ) ? $settings[ 'iq_' . $type . '_chart_toolbar_offsety' ] : 0 ); ?>')|| 0,
								show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_can_chart_show_toolbar' ] ); ?>',
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
						labels: '<?php echo ( $label ); ?>'.split('_,_'),
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
						colors: '<?php echo esc_js( $gradient ); ?>'.split('_,_'),
						plotOptions: {
							radialBar: {
								startAngle: parseInt('<?php echo esc_js( $start_angle ); ?>'),
								endAngle: parseInt('<?php echo esc_js( $end_angle ); ?>'),
								hollow: {
									size: parseInt('<?php echo esc_js( ( 70 - $settings[ 'iq_' . $type . '_chart_line_width' ] ) ); ?>')
								},
								dataLabels: {
									show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_datalabel_show' ] === 'yes' ); ?>',
									name: {
										show: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_total_title_show' ] ) && $settings[ 'iq_' . $type . '_chart_datalabel_total_title_show' ] === 'yes' ); ?>',
										fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
										fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
										fontSize: '<?php echo esc_js( ( (int) $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] + 2 ) . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
									},
									value: {
										formatter: function (val) {
											if("<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_number_format_commas' ] ) && $settings[ 'iq_' . $type . '_chart_number_format_commas' ] === 'yes' ); ?>" ){
												val = graphinNumberWithCommas(val,'<?php echo esc_js( $local_string_type ); ?>')
											}
											else if("<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_label_pointer_for_label' ] ) && $settings[ 'iq_' . $type . '_chart_label_pointer_for_label' ] === 'yes' ); ?>"
												&&  typeof graphinaAbbrNum  !== "undefined"){
												val = graphinaAbbrNum(val ,  parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_label_pointer_number_for_label' ] ); ?>") || 0 );
											}
											return '<?php echo esc_js( $data_label_prefix ); ?>' + val + '<?php echo esc_js( $data_label_postfix ); ?>';
										},
										fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
										fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
										color: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_color' ] ); ?>',
										fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
									},
									total: {
										fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
										fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
										color: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] ); ?>',
										fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
										show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_datalabel_show' ] === 'yes' ); ?>',
										label: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_total_title' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_total_title' ] : 'Total' ); ?>',
										formatter: function (w) {
											let total =   w.globals.seriesTotals.reduce((a, b) => {
												return a + b
											}, 0) ;
											if("<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_number_format_commas' ] ) && $settings[ 'iq_' . $type . '_chart_number_format_commas' ] === 'yes' ); ?>" ){
												total = graphinNumberWithCommas(total,'<?php echo esc_js( $local_string_type ); ?>')
											}else if("<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_label_pointer_for_label' ] ) && $settings[ 'iq_' . $type . '_chart_label_pointer_for_label' ] === 'yes' ); ?>"
												&&  typeof graphinaAbbrNum  !== "undefined"){
												total = graphinaAbbrNum(total ,  parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_label_pointer_number_for_label' ] ); ?>") || 0 );
											}

											return '<?php echo esc_js( $data_label_prefix ); ?>' + total + '<?php echo esc_js( $data_label_postfix ); ?>';
										}
									},
									offsetY: parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_offsety' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_offsety' ] : 0 ); ?>'),
									offsetX: parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_offsetx' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_offsetx' ] : 0 ); ?>'),
								},
								track: {
									show: true,
									background: '<?php echo esc_js( $gradient ); ?>'.split('_,_'),
									strokeWidth: parseFloat('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_track_width' ] ); ?>') + '%',
									opacity: parseFloat('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_track_opacity' ] ); ?>')
								}
							}
						},
						stroke: {
							lineCap: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_is_stroke_rounded' ] === 'yes' ? 'round' : '' ); ?>'
						},
						fill: {
							type: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_fill_style_type' ] ); ?>',
							opacity: 1,
							colors: '<?php echo esc_js( $gradient ); ?>'.split('_,_'),
							gradient: {
								gradientToColors: '<?php echo esc_js( $second_gradient ); ?>'.split('_,_'),
								type: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_gradient_type' ] ); ?>',
								inverseColors: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_gradient_inversecolor' ] ); ?>',
								opacityFrom: parseFloat('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_gradient_opacityFrom' ] ); ?>'),
								opacityTo: parseFloat('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_gradient_opacityTo' ] ); ?>')
							},
							pattern: {
								style: '<?php echo esc_js( $fill_pattern ); ?>'.split('_,_'),
								width: 6,
								height: 6,
								strokeWidth: 2
							}
						},
						legend: {
							showForSingleSeries:true,
							show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_legend_show' ] === 'yes' && $label !== '' && $value !== '' ); ?>',
							position: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_legend_position' ] ) ? $settings[ 'iq_' . $type . '_chart_legend_position' ] : 'bottom' ); ?>',
							horizontalAlign: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_legend_horizontal_align' ] ) ? $settings[ 'iq_' . $type . '_chart_legend_horizontal_align' ] : 'center' ); ?>',
							fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
							fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
							fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
							labels: {
								colors: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_color' ] ); ?>'
							},
							formatter: function(seriesName, opts) {

								if('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_legend_show_series_value' ] ) && $settings[ 'iq_' . $type . '_chart_legend_show_series_value' ] === 'yes' ); ?>'){
									let divEl= document.createElement("div");
									divEl.classList.add("legend-info");
									divEl.append(document.createElement("span").innerText=seriesName,":",document.createElement("strong").innerText=opts.w.globals.series[opts.seriesIndex])
									return divEl.outerHTML;
								}
								return seriesName
							}
						},
						tooltip: {
							theme: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip_theme' ] ); ?>',
							enabled: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip' ] ); ?>',
							style: {
								fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
								fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>'
							},
							y: {
								formatter: function(val) {
									if('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_number_format_commas' ] ) && $settings[ 'iq_' . $type . '_chart_number_format_commas' ] === 'yes' ); ?>'){
										val= graphinNumberWithCommas(val,'<?php echo esc_js( $local_string_type ); ?>')
									}else if("<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_label_pointer_for_label' ] ) && $settings[ 'iq_' . $type . '_chart_label_pointer_for_label' ] === 'yes' ); ?>"
										&&  typeof graphinaAbbrNum  !== "undefined"){
										val = graphinaAbbrNum(val ,  parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_label_pointer_number_for_label' ] ); ?>") || 0 );
									}
									return '<?php echo esc_js( $data_label_prefix ); ?>' + val + '<?php echo esc_js( $data_label_postfix ); ?>'
								}
							}
						},
						responsive: [{
							breakpoint: 1024,
							options: {
								chart: {
									height: parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_height_tablet' ] ) ? $settings[ 'iq_' . $type . '_chart_height_tablet' ] : $settings[ 'iq_' . $type . '_chart_height' ] ); ?>')
								}
							}
						},
							{
								breakpoint: 674,
								options: {
									chart: {
										height: parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_height_mobile' ] ) ? $settings[ 'iq_' . $type . '_chart_height_mobile' ] : $settings[ 'iq_' . $type . '_chart_height' ] ); ?>')
									}
								}
							}
						]
					};
					
					if('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_track_color_enable' ] ) && $settings[ 'iq_' . $type . '_chart_track_color_enable' ] ); ?>'){
						radialOptions.plotOptions.radialBar.track.background = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_track_color' ] ) ? $settings[ 'iq_' . $type . '_chart_track_color' ] : '#808080' ); ?>'
					}

					if (typeof initNowGraphina !== "undefined") {
						initNowGraphina(
							myElement,
							{
								ele: document.querySelector(".radial-chart-<?php echo esc_js( $main_id ); ?>"),
								options: radialOptions,
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
		if ( $settings[ 'iq_' . $type . '_chart_data_option' ] !== 'manual' ) {
			if ( $settings[ 'iq_' . $type . '_chart_data_option' ] === 'forminator' ) {
				graphina_ajax_reload( true, array(), $type, $main_id );
			} elseif ( graphina_pro_active() ) {
				graphina_ajax_reload( $call_ajax, array(), $type, $main_id );
			}
		}
	}
}

Plugin::instance()->widgets_manager->register( new \Elementor\Radial_Chart() );
<?php
/**
 * Apex donut chart elementor widget class.
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
 * Elementor donut chart widget.
 *
 * Elementor widget that displays an eye-catching donut chart.
 */
class Donut_Chart extends Widget_Base {


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
		return 'donut_chart';
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
		return 'Donut';
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
		return 'graphina-apex-donat-chart';
	}

	/**
	 * Get widget type.
	 *
	 * @return string Widget ty[e.
	 *
	 * @access public
	 */
	public function get_chart_type(): string {
		return 'donut';
	}

	/**
	 * Register controller to elementor
	 *
	 * @return void
	 */
	protected function register_controls(): void {
		$type          = $this->get_chart_type();
		$default_label = graphina_default_setting( 'categories', 'string' );

		graphina_basic_setting( $this, $type );

		graphina_chart_data_option_setting( $this, $type );

		$this->start_controls_section(
			'iq_' . $type . '_section2',
			array(
				'label' => esc_html__( 'Chart Setting', 'graphina-charts-for-elementor' ),
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_inner_radius',
			array(
				'label'   => 'Inner Radius',
				'type'    => Controls_Manager::NUMBER,
				'default' => 65,
				'min'     => 1,
				'max'     => 98,
			)
		);

		$this->add_control(
			'iq_' . $type . 'is_semi_circular_donut_chart',
			array(
				'label'     => __( 'Enable Semi-Circular Donut Chart?', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => false,
			)
		);
		$this->add_control(
			'iq_' . $type . 'semi_circular_donut_chart_start_angle',
			array(
				'label'     => __( 'Start Angle', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'min'       => -360,
				'max'       => 360,
				'condition' => array( 'iq_' . $type . 'is_semi_circular_donut_chart' => 'yes' ),
			)
		);
		$this->add_control(
			'iq_' . $type . 'semi_circular_donut_chart_end_angle',
			array(
				'label'     => __( 'End Angle', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 360,
				'min'       => -360,
				'max'       => 360,
				'condition' => array( 'iq_' . $type . 'is_semi_circular_donut_chart' => 'yes' ),
			)
		);

		graphina_common_chart_setting( $this, $type, false, false, false, false );

		graphina_tooltip( $this, $type, true, false );

		graphina_stroke( $this, $type );

		graphina_animation( $this, $type );

		$this->end_controls_section();

		graphina_chart_label_setting( $this, $type );

		graphina_series_setting( $this, $type, array( 'color' ), true, array( 'classic', 'gradient', 'pattern' ), false, false );

		$max_series = graphina_default_setting( 'max_series_value' );
		for ( $i = 0; $i < $max_series; $i++ ) {

			$this->start_controls_section(
				'iq_' . $type . '_section_series' . $i,
				array(
					'label'      => esc_html__( 'Element ', 'graphina-charts-for-elementor' ) . ( $i + 1 ),
					'default'    => wp_rand( 50, 200 ),
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
					'default'     => ($i*99),
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

		graphina_dyanmic_chart_style_section( $this, $type );
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

		$enable_number_formatting = $settings[ 'iq_' . $type . '_chart_number_format_locale' ] === 'yes';
		$locale                   = $settings[ 'iq_' . $type . '_chart_tooltip_locale' ];

		$main_id         = graphina_widget_id( $this );
		$value_list      = $settings[ 'iq_' . $type . '_chart_data_series_count' ];
		$gradient        = array();
		$second_gradient = array();
		$fill_pattern    = array();
		$data            = array(
			'category' => array(),
			'series'   => array(),
		);
		$call_ajax       = false;
		$loading_text    = esc_html( isset( $settings[ 'iq_' . $type . '_chart_no_data_text' ] ) ? $settings[ 'iq_' . $type . '_chart_no_data_text' ] : '' );

		$export_file_name = ( ! empty( $settings[ 'iq_' . $type . '_can_chart_show_toolbar' ] ) && $settings[ 'iq_' . $type . '_can_chart_show_toolbar' ] === 'yes'
			&& ! empty( $settings[ 'iq_' . $type . '_export_filename' ] )
		) ? $settings[ 'iq_' . $type . '_export_filename' ] : $main_id;

		if ( gettype( $value_list ) === 'NULL' ) {
			$value_list = 0;
		}

		if ( graphina_pro_active() && $settings[ 'iq_' . $type . '_chart_data_option' ] !== 'manual' ) {
			$call_ajax       = true;
			$gradient        = array( '#ffffff' );
			$second_gradient = array( '#ffffff' );
			$loading_text    = esc_html__( 'Loading...', 'graphina-charts-for-elementor' );
		} else {
			for ( $i = 0; $i < $value_list; $i++ ) {
				$gradient[]        = esc_html( $settings[ 'iq_' . $type . '_chart_gradient_1_' . $i ] );
				$second_gradient[] = esc_html( ! isset( $settings[ 'iq_' . $type . '_chart_gradient_2_' . $i ] ) ? $settings[ 'iq_' . $type . '_chart_gradient_1_' . $i ] : $settings[ 'iq_' . $type . '_chart_gradient_2_' . $i ] );
				$fill_pattern[]    = esc_html( isset( $settings[ 'iq_' . $type . '_chart_bg_pattern_' . $i ] ) ? $settings[ 'iq_' . $type . '_chart_bg_pattern_' . $i ] : 'verticalLines' );
			}
			$temp = '';
			for ( $i = 0; $i < $value_list; $i++ ) {
				$temp = esc_html( graphina_get_dynamic_tag_data( $settings, 'iq_' . $type . '_chart_label' . $i ) );
				$data['category'][] = htmlspecialchars_decode($temp);
				$data['series'][]   = (float) graphina_get_dynamic_tag_data( $settings, 'iq_' . $type . '_chart_value' . $i );
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

		$gradient                      = implode( '_,_', $gradient );
		$second_gradient               = implode( '_,_', $second_gradient );
		$fill_pattern                  = implode( '_,_', $fill_pattern );
		$label                         = implode( '_,_', $data['category'] );
		$value                         = implode( ',', $data['series'] );
		$local_string_type             = graphina_common_setting_get( 'thousand_seperator' );
		$forminator_percentage_enable  = $settings[ 'iq_' . $type . '_chart_data_option' ] === 'forminator' && ! empty( $settings[ 'iq_' . $type . '_section_chart_forminator_aggregate_percentage' ] )
			&& $settings[ 'iq_' . $type . '_section_chart_forminator_aggregate_percentage' ] === 'yes';
		$forminator_percentage_decimal = ! empty( $settings[ 'iq_' . $type . '_section_chart_forminator_aggregate_percentage_decimal' ] ) ? $settings[ 'iq_' . $type . '_section_chart_forminator_aggregate_percentage_decimal' ] : 0;
		graphina_chart_widget_content( $this, $main_id, $settings );
		if ( graphina_restricted_access( 'donut', $main_id, $settings, false ) === false ) {

			?>
			<script>
				(function (){
					if (typeof isInit === 'undefined') {
						var isInit = {};
					}
					isInit['<?php echo esc_js( $main_id ); ?>'] = false;

					const myElement = document.querySelector(".donut-chart-<?php echo esc_js( $main_id ); ?>");
					const donutOptions = {
						series: [<?php echo esc_js( $value ); ?>],
						chart: {
							background: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_background_color1' ] ); ?>',
							height: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_height' ] ); ?>'),
							type: 'donut',
							fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
							locales: [JSON.parse('<?php echo graphina_apexchart_localization(); //@phpcs:ignore ?>')],
							defaultLocale: "en",
							toolbar: {
								offsetX: parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_toolbar_offsetx' ] ) ? $settings[ 'iq_' . $type . '_chart_toolbar_offsetx' ] : 0 ); ?>') || 0,
								offsetY: parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_toolbar_offsety' ] ) ? $settings[ 'iq_' . $type . '_chart_toolbar_offsety' ] : 0 ); ?>') || 0,
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
								dynamicAnimation: {
									enabled: true
								}
							},
						},
						plotOptions: {
							pie: {
								<?php
								if ( $settings[ 'iq_' . $type . 'is_semi_circular_donut_chart' ] === 'yes' ) {
									?>
									startAngle: <?php echo esc_js( $settings[ 'iq_' . $type . 'semi_circular_donut_chart_start_angle' ] ); ?>,
									endAngle: <?php echo esc_js( $settings[ 'iq_' . $type . 'semi_circular_donut_chart_end_angle' ] ); ?>,
									<?php
								}
								?>
								donut: {
									size: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_inner_radius' ] ); ?>%',
									labels: {
										show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_center_datalabel_show' ] ); ?>',
										value: {
											fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
											fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
											color: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] : '#000000' ); ?>',
											fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
										},
										total: {
											show: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_total_title_show' ] ) && $settings[ 'iq_' . $type . '_chart_datalabel_total_title_show' ] === 'yes' ); ?>',
											showAlways: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_total_title_always' ] ) && $settings[ 'iq_' . $type . '_chart_datalabel_total_title_always' ] === 'yes' ); ?>',
											label: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_total_title' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_total_title' ] : esc_html__( 'Total', 'graphina-charts-for-elementor' ) ); ?>',
											fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
											fontight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
											color: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] ) ? strval( $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] ) : '#000000' ); ?>',
											formatter: function(w) {

												let totals = w.globals.seriesTotals.reduce((a, b) => {
													return a + b;
												}, 0)

												let prefix = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_format_prefix' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_format_prefix' ] : '' ); ?>'
												let postfix = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_format_postfix' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_format_postfix' ] : '' ); ?>'
												let valueInStringShow = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_label_pointer' ] ) ? $settings[ 'iq_' . $type . '_chart_label_pointer' ] : 'no' ); ?>'
												let valueInString = parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_label_pointer_number' ] ) ? $settings[ 'iq_' . $type . '_chart_label_pointer_number' ] : 0 ); ?>')
												if ('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_number_format_commas' ] ) && $settings[ 'iq_' . $type . '_chart_number_format_commas' ] === 'yes' ); ?>') {
													totals = graphinNumberWithCommas(totals, '<?php echo esc_js( $local_string_type ); ?>');
												}else if('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_number_format_locale' ] ) && $settings[ 'iq_' . $type . '_chart_number_format_locale' ] === 'yes' ); ?>'){

													const locale = '<?php echo esc_js( $locale ); ?>';
													const numberFormatter = new Intl.NumberFormat(locale, {
														style: 'decimal',
														minimumFractionDigits: 0,
														maximumFractionDigits: 2,
														useGrouping: true,
													});
													totals = numberFormatter.format(totals);


												}else if (valueInStringShow === 'yes') {

													totals = graphinaAbbrNum(totals, valueInString);
												}

												return prefix + totals + postfix
											}
										}
									}
								}
							}
						},
						labels: '<?php echo esc_js( $label ); ?>'.split('_,_'),
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
						dataLabels: {
							enabled: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_datalabel_show' ] === 'yes' ); ?>',
							style: {
								fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
								fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
								fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
								colors: ['<?php echo esc_js( isset( $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] ) ? strval( $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] ) : '#ffffff' ); ?>'],
							},
							background: {
								enabled: false
							},
							dropShadow: {
								enabled: false,
							}
						},
						colors: '<?php echo esc_js( $gradient ); ?>'.split('_,_'),
						fill: {
							type: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_fill_style_type' ] ); ?>',
							opacity: 1,
							colors: '<?php echo esc_js( $gradient ); ?>'.split('_,_'),
							gradient: {
								gradientToColors: '<?php echo esc_js( $second_gradient ); ?>'.split('_,_'),
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
							showForSingleSeries: true,
							show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_legend_show' ] === 'yes' && $label !== '' && $value !== '' ); ?>',
							position: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_legend_position' ] ) ? $settings[ 'iq_' . $type . '_chart_legend_position' ] : 'bottom' ); ?>',
							horizontalAlign: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_legend_horizontal_align' ] ) ? esc_html( $settings[ 'iq_' . $type . '_chart_legend_horizontal_align' ] ) : 'center' ); ?>',
							fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
							fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
							fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
							labels: {
								colors: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_color' ] ); ?>'
							},
							formatter: function(seriesName, opts) {

								if ('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_legend_show_series_value' ] ) && $settings[ 'iq_' . $type . '_chart_legend_show_series_value' ] === 'yes' ); ?>') {
									let divEl= document.createElement("div");
									divEl.classList.add("legend-info");
									divEl.append(document.createElement("span").innerText=seriesName,":",document.createElement("strong").innerText=opts.w.globals.series[opts.seriesIndex])
									return divEl.outerHTML;
								}
								return seriesName
							}
						},
						tooltip: {
							enabled: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip' ] === 'yes' ); ?>',
							theme: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip_theme' ] ); ?>',
							style: {
								fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
								fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>'
							},
							y: {
								formatter: function(val, w) {

									let valueInStringShow = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_label_pointer' ] ) ? $settings[ 'iq_' . $type . '_chart_label_pointer' ] : 'no' ); ?>'
									let valueInString = parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_label_pointer_number' ] ) ? $settings[ 'iq_' . $type . '_chart_label_pointer_number' ] : 0 ); ?>')
									let prefix = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_format_prefix' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_format_prefix' ] : '' ); ?>'
									let postfix = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_format_postfix' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_format_postfix' ] : '' ); ?>'
									if ('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_number_format_commas' ] ) && $settings[ 'iq_' . $type . '_chart_number_format_commas' ] === 'yes' ); ?>') {
										val = graphinNumberWithCommas(val, '<?php echo esc_js( $local_string_type ); ?>')
									} else {
										val = valueInStringShow === 'no' ? val : graphinaAbbrNum(val, valueInString);
									}
									if ("<?php echo esc_js( $forminator_percentage_enable ); ?>") {
										let totals = w.globals.seriesTotals.reduce((a, b) => {
											return a + b;
										}, 0)
										if (postfix.trim() === '') {
											postfix = '%';
										}
										return prefix + val + " (" + parseFloat(val / totals * 100).toFixed('<?php echo esc_js( $forminator_percentage_decimal ); ?>') + postfix + ")"
									}
									return prefix + val + postfix
								}
							}
						},
						stroke: {
							show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_stroke_show' ] === 'yes' ); ?>',
							width: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_stroke_show' ] === 'yes' ? $settings[ 'iq_' . $type . '_chart_stroke_width' ] : 0 ); ?>')
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
					if ("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_number_format_locale' ] ) === 'yes'; ?>") {
						donutOptions.tooltip.y.formatter = function (val) {
							const enableNumberFormatting = '<?php echo esc_js( $enable_number_formatting ); ?>';
							const locale = '<?php echo esc_js( $locale ); ?>';

							const dataLabelShow = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabels_format' ] ) && $settings[ 'iq_' . $type . '_chart_datalabels_format' ] === 'yes' ); ?>';
							const prefix = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_format_prefix' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_format_prefix' ] : '' ); ?>'
							const postfix = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_format_postfix' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_format_postfix' ] : '' ); ?>'

							if (enableNumberFormatting) {
								const numberFormatter = new Intl.NumberFormat(locale, {
									style: 'decimal',
									minimumFractionDigits: 0,
									maximumFractionDigits: 2,
									useGrouping: true,
								});
								val = numberFormatter.format(val);
							}
							if (dataLabelShow) {
								val = prefix + val + postfix;
							}
							return val;
						};
					}

					if ("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_datalabels_format' ] === 'yes' ); ?>") {
						const valueInStringShow = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_label_pointer' ] ) ? $settings[ 'iq_' . $type . '_chart_label_pointer' ] : 'no' ); ?>'
						const valueInStringValue = parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_label_pointer_number' ] ) ? $settings[ 'iq_' . $type . '_chart_label_pointer_number' ] : 0 ); ?>')
						const showlabel = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabels_format_showlabel' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabels_format_showlabel' ] : 'no' ); ?>'
						const showValue = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabels_format_showValue' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabels_format_showValue' ] : 'no' ); ?>'
						const prefix = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_format_prefix' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_format_prefix' ] : '' ); ?>'
						const postfix = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_format_postfix' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_format_postfix' ] : '' ); ?>'
						const numberformat = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_number_format_commas' ] ) ? $settings[ 'iq_' . $type . '_chart_number_format_commas' ] : 'no' ); ?>'
						if (typeof chartDatalabelsFormat !== "undefined") {
							chartDatalabelsFormat(donutOptions, showlabel, showValue, numberformat, prefix, postfix, valueInStringShow, valueInStringValue, '<?php echo esc_js( $forminator_percentage_enable ); ?>', '<?php echo esc_js( $forminator_percentage_decimal ); ?>');
						}
					}

					if (typeof initNowGraphina !== "undefined") {
						initNowGraphina(
							myElement, {
								ele: document.querySelector(".donut-chart-<?php echo esc_js( $main_id ); ?>"),
								options: donutOptions,
								series: [{
									name: '',
									data: []
								}],
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

Plugin::instance()->widgets_manager->register( new Donut_Chart() );

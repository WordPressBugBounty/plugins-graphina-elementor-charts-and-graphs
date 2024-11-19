<?php
/**
 * Apex pie chart elementor widget class.
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
 * Elementor pie chart widget.
 *
 * Elementor widget that displays an eye-catching pie chart.
 */
class Pie_Chart extends Widget_Base {

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
		return 'pie_chart';
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
		return 'Pie';
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
		return 'graphina-apex-pie-chart';
	}

	/**
	 * Get widget type.
	 *
	 * @return string Widget ty[e.
	 *
	 * @access public
	 */
	public function get_chart_type(): string {
		return 'pie';
	}

	/**
	 * Register controller to elementor
	 *
	 * @return void
	 */
	protected function register_controls(): void {
		$type          = $this->get_chart_type();
		$default_label = array(
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
			'May2',
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
		);
		graphina_basic_setting( $this, $type );

		graphina_chart_data_option_setting( $this, $type );

		$this->start_controls_section(
			'iq_' . $type . '_section_2',
			array(
				'label' => esc_html__( 'Chart Setting', 'graphina-charts-for-elementor' ),
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
					'default'     => wp_rand( 25, 200 ),
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

		$main_id                  = graphina_widget_id( $this );
		$value_list               = $settings[ 'iq_' . $type . '_chart_data_series_count' ];
		$gradient                 = array();
		$second_gradient          = array();
		$fill_pattern             = array();
		$data                     = array(
			'category' => array(),
			'series'   => array(),
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
		if ( graphina_restricted_access( 'pie', $main_id, $settings, false ) === false ) {
			?>
			<script>

				(function (){
					if (typeof isInit === 'undefined') {
						var isInit = {};
					}
					isInit['<?php echo esc_js( $main_id ); ?>'] = false;

					const myElement = document.querySelector(".pie-chart-<?php echo esc_js( $main_id ); ?>");
					const pieOptions = {
						series: [<?php echo esc_html( $value ); ?>],
						chart: {
							background: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_background_color1' ] ); ?>',
							height: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_height' ] ); ?>'),
							type: 'pie',
							fontFamily: '<?php echo esc_js( esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ) ); ?>',
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
								speed: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_animation_speed' ] ); ?>',
								delay: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_animation_delay' ] ); ?>',
								dynamicAnimation: {
									enabled: true
								}
							},
						},
						plotOptions: {
							pie: {
								donut: {
									labels: {
										show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_center_datalabel_show' ] ); ?>',
										value: {
											fontFamily: '<?php echo esc_js( esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ) ); ?>',
											fontWeight: '<?php echo esc_js( esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ) ); ?>',
											color: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] : '#000000' ); ?>',
											fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
										},
										total: {
											show: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_total_title_show' ] ) && $settings[ 'iq_' . $type . '_chart_datalabel_total_title_show' ] === 'yes' ); ?>',
											showAlways:'<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_total_title_always' ] ) && $settings[ 'iq_' . $type . '_chart_datalabel_total_title_always' ] === 'yes' ); ?>',
											label: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_total_title' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_total_title' ] : 'Total' ); ?>',
											fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
											fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
											color: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] : '#000000' ); ?>',
											formatter: function (w) {
												let totals = w.globals.seriesTotals.reduce((a, b) => {
													return  a + b;
												}, 0)
												let prefix = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_format_prefix' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_format_prefix' ] : '' ); ?>'
												let postfix = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_format_postfix' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_format_postfix' ] : '' ); ?>'
												let valueInStringShow =  '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_label_pointer' ] ) ? $settings[ 'iq_' . $type . '_chart_label_pointer' ] : 'no' ); ?>'
												let valueInString =  parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_label_pointer_number' ] ) ? $settings[ 'iq_' . $type . '_chart_label_pointer_number' ] : 0 ); ?>')
												if('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_number_format_commas' ] ) && $settings[ 'iq_' . $type . '_chart_number_format_commas' ] === 'yes' ); ?>'){
													totals= graphinNumberWithCommas(totals,'<?php echo esc_js( $local_string_type ); ?>')
												}else if(valueInStringShow === 'yes'){
													totals = graphinaAbbrNum(totals , valueInString);
												}
												return prefix + totals + postfix
											}
										}
									}
								}
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
						dataLabels: {
							enabled: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_datalabel_show' ] === 'yes' ); ?>',
							style: {
								fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
								fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
								fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
								colors: ['<?php echo esc_js( isset( $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] : '#ffffff' ); ?>'],
							},
							background:{
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
							showForSingleSeries:true,
							show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_legend_show' ] === 'yes' && $label !== '' && $value !== '' ); ?>',
							position: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_legend_position' ] ) ? esc_html( $settings[ 'iq_' . $type . '_chart_legend_position' ] ) : 'bottom' ); ?>',
							horizontalAlign: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_legend_horizontal_align' ] ) ? $settings[ 'iq_' . $type . '_chart_legend_horizontal_align' ] : 'center' ); ?>',
							fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
							fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
							fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
							labels: {
								colors: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_color' ] ); ?>'
							},
							formatter: function(seriesName, opts) {
								if('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_legend_show_series_value' ] ) && $settings[ 'iq_' . $type . '_chart_legend_show_series_value' ] === 'yes' ); ?>'){
									let prefix = '<?php echo esc_js( isset( $settings[ 'iq_' . $type . '_chart_legend_show_series_prefix' ] ) && $settings[ 'iq_' . $type . '_chart_legend_show_series_prefix' ] === 'yes' && ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_format_prefix' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_format_prefix' ] : '' ); ?>'
									let postfix = '<?php echo esc_js( isset( $settings[ 'iq_' . $type . '_chart_legend_show_series_postfix' ] ) && $settings[ 'iq_' . $type . '_chart_legend_show_series_postfix' ] === 'yes' && ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_format_postfix' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_format_postfix' ] : '' ); ?>'
									let divEl= document.createElement("div");
									divEl.classList.add("legend-info");
									divEl.append(document.createElement("span").innerText=seriesName,":",document.createElement("strong").innerText=prefix+opts.w.globals.series[opts.seriesIndex]+postfix)
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
								formatter: function(val,w) {
									let valueInStringShow =  '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_label_pointer' ] ) ? $settings[ 'iq_' . $type . '_chart_label_pointer' ] : 'no' ); ?>'
									let valueInString =  parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_label_pointer_number' ] ) ? $settings[ 'iq_' . $type . '_chart_label_pointer_number' ] : 0 ); ?>')
									let prefix = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_format_prefix' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_format_prefix' ] : '' ); ?>'
									let postfix = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_format_postfix' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_format_postfix' ] : '' ); ?>'
									if('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_number_format_commas' ] ) && $settings[ 'iq_' . $type . '_chart_number_format_commas' ] === 'yes' ); ?>'){
										val= graphinNumberWithCommas(val,'<?php echo esc_js( $local_string_type ); ?>')
									}else{
										val = valueInStringShow === 'no' ? val : graphinaAbbrNum(val , valueInString);
									}
									if("<?php echo esc_js( $forminator_percentage_enable ); ?>"){
										let totals = w.globals.seriesTotals.reduce((a, b) => {
											return  a + b;
										}, 0)
										if(postfix.trim() === ''){
											postfix = '%';
										}
										return prefix + val+" (" + parseFloat(val/totals * 100).toFixed('<?php echo esc_js( $forminator_percentage_decimal ); ?>') +postfix+")"
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

					


					if("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_datalabels_format' ] === 'yes' ); ?>"){
						let valueInStringShow =  '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_label_pointer' ] ) ? $settings[ 'iq_' . $type . '_chart_label_pointer' ] : 'no' ); ?>'
						let valueInStringValue =  parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_label_pointer_number' ] ) ? $settings[ 'iq_' . $type . '_chart_label_pointer_number' ] : 0 ); ?>')
						let showlabel = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabels_format_showlabel' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabels_format_showlabel' ] : 'no' ); ?>'
						let showValue = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabels_format_showValue' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabels_format_showValue' ] : 'no' ); ?>'
						let prefix = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_format_prefix' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_format_prefix' ] : '' ); ?>'
						let postfix = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_format_postfix' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_format_postfix' ] : '' ); ?>'
						let numberformat = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_number_format_commas' ] ) ? $settings[ 'iq_' . $type . '_chart_number_format_commas' ] : 'no' ); ?>'
						if(typeof chartDatalabelsFormat !== "undefined"){
							chartDatalabelsFormat(pieOptions, showlabel, showValue, numberformat, prefix, postfix ,valueInStringShow, valueInStringValue,'<?php echo esc_js( $forminator_percentage_enable ); ?>','<?php echo esc_js( $forminator_percentage_decimal ); ?>');
						}
					}
					if (typeof initNowGraphina !== "undefined") {
						initNowGraphina(
							myElement,
							{
								ele: document.querySelector(".pie-chart-<?php echo esc_js( $main_id ); ?>"),
								options: pieOptions,
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

Plugin::instance()->widgets_manager->register( new \Elementor\Pie_Chart() );
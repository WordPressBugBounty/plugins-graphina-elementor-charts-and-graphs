<?php
/**
 * Apex scatter chart elementor widget class.
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
 * Elementor scatter chart widget.
 *
 * Elementor widget that displays an eye-catching scatter chart.
 */
class Scatter_Chart extends Widget_Base {
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
		return 'scatter_chart';
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
		return 'Scatter';
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
		return 'graphina-apex-scatter-chart';
	}

	/**
	 * Get widget type.
	 *
	 * @return string Widget ty[e.
	 *
	 * @access public
	 */
	public function get_chart_type(): string {
		return 'scatter';
	}

	/**
	 * Register controller to elementor
	 *
	 * @return void
	 */
	protected function register_controls(): void {
		$type = $this->get_chart_type();
		graphina_basic_setting( $this, $type );

		graphina_chart_data_option_setting( $this, $type, 0, true );

		$this->start_controls_section(
			'iq_' . $type . '_section_2',
			array(
				'label' => esc_html__( 'Chart Setting', 'graphina-charts-for-elementor' ),
			)
		);

		graphina_common_chart_setting( $this, $type, false, true, false, false, true );

		graphina_tooltip( $this, $type );

		graphina_animation( $this, $type );

		graphina_dropshadow( $this, $type );

		$this->add_control(
			'iq_' . $type . '_chart_hr_category_listing',
			array(
				'type'      => Controls_Manager::DIVIDER,
				'condition' => array(
					'iq_' . $type . '_chart_data_option' => 'manual',
				),
			)
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'iq_' . $type . '_chart_category',
			array(
				'label'       => esc_html__( 'Category Value', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
				'dynamic'     => array(
					'active' => true,
				),
				'description' => esc_html__( 'Note: For multiline text seperate Text by comma(,) and Only work if Labels Prefix/Postfix in X-axis is disable ', 'graphina-charts-for-elementor' ),
			)
		);

		/** Chart value list. */
		$this->add_control(
			'iq_' . $type . '_category_list',
			array(
				'label'       => esc_html__( 'Categories', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array( 'iq_' . $type . '_chart_category' => 'Jan' ),
					array( 'iq_' . $type . '_chart_category' => 'Feb' ),
					array( 'iq_' . $type . '_chart_category' => 'Mar' ),
					array( 'iq_' . $type . '_chart_category' => 'Apr' ),
					array( 'iq_' . $type . '_chart_category' => 'May' ),
					array( 'iq_' . $type . '_chart_category' => 'Jun' ),
				),
				'condition'   => array(
					'iq_' . $type . '_chart_data_option' => 'manual',
				),
				'title_field' => '{{{ iq_' . $type . '_chart_category }}}',
			)
		);

		$this->end_controls_section();

		graphina_chart_label_setting( $this, $type );

		graphina_advance_x_axis_setting( $this, $type );

		graphina_advance_y_axis_setting( $this, $type );

		graphina_series_setting( $this, $type, array( 'tooltip', 'color' ), true, array( 'classic', 'gradient', 'pattern' ), true, true );

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
					'label'       => 'Title',
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
				'iq_' . $type . '_chart_value_3_' . $i,
				array(
					'label'       => 'Element Value',
					'type'        => Controls_Manager::NUMBER,
					'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);

			/** Chart value list. */
			$this->add_control(
				'iq_' . $type . '_value_list_3_1_' . $i,
				array(
					'label'       => esc_html__( 'Values', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => array(
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
					),
					'condition'   => array(
						'iq_' . $type . '_can_chart_negative_values!' => 'yes',
					),
					'title_field' => '{{{ iq_' . $type . '_chart_value_3_' . $i . ' }}}',
				)
			);

			$this->add_control(
				'iq_' . $type . '_value_list_3_2_' . $i,
				array(
					'label'       => esc_html__( 'Values', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => array(
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( -200, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( -200, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( -200, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( -200, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( -200, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( -200, 200 ) ),
					),
					'condition'   => array(
						'iq_' . $type . '_can_chart_negative_values' => 'yes',
					),
					'title_field' => '{{{ iq_' . $type . '_chart_value_3_' . $i . ' }}}',
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
		$type                     = $this->get_chart_type();
		$settings                 = $this->get_settings_for_display();
		$ajax_settings            = graphina_ajax_settings( $settings, $type );
		$main_id                  = graphina_widget_id( $this );
		$second_gradient          = array();
		$fill_pattern             = array();
		$drop_shadow_series       = array();
		$tooltip_series           = array();
		$gradient                 = array();
		$data                     = array(
			'series'   => array(),
			'category' => array(),
		);
		$data_label_prefix        = '';
		$data_label_postfix       = '';
		$y_label_prefix           = '';
		$y_label_postfix          = '';
		$x_label_prefix           = '';
		$x_label_postfix          = '';
		$call_ajax                = false;
		$loading_text             = esc_html( isset( $settings[ 'iq_' . $type . '_chart_no_data_text' ] ) ? $settings[ 'iq_' . $type . '_chart_no_data_text' ] : '' );

		$export_file_name = (
			! empty( $settings[ 'iq_' . $type . '_can_chart_show_toolbar' ] ) && $settings[ 'iq_' . $type . '_can_chart_show_toolbar' ] === 'yes'
			&& ! empty( $settings[ 'iq_' . $type . '_export_filename' ] )
		) ? $settings[ 'iq_' . $type . '_export_filename' ] : $main_id;

		if ( $settings[ 'iq_' . $type . '_chart_datalabel_show' ] === 'yes' ) {
			$data_label_prefix  = $settings[ 'iq_' . $type . '_chart_datalabel_prefix' ];
			$data_label_postfix = $settings[ 'iq_' . $type . '_chart_datalabel_postfix' ];
		}

		if ( $settings[ 'iq_' . $type . '_chart_xaxis_label_show' ] === 'yes' ) {
			$x_label_prefix  = $settings[ 'iq_' . $type . '_chart_xaxis_label_prefix' ];
			$x_label_postfix = $settings[ 'iq_' . $type . '_chart_xaxis_label_postfix' ];
		}

		if ( $settings[ 'iq_' . $type . '_chart_yaxis_label_show' ] === 'yes' ) {
			$y_label_prefix  = $settings[ 'iq_' . $type . '_chart_yaxis_label_prefix' ];
			$y_label_postfix = $settings[ 'iq_' . $type . '_chart_yaxis_label_postfix' ];
		}
		$series_count = isset( $settings[ 'iq_' . $type . '_chart_data_series_count' ] ) ? $settings[ 'iq_' . $type . '_chart_data_series_count' ] : 0;
		for ( $i = 0; $i < $series_count; $i++ ) {
			$drop_shadow_series[] = $i;
			if ( ! empty( $settings[ 'iq_' . $type . '_chart_tooltip_enabled_on_1_' . $i ] ) && $settings[ 'iq_' . $type . '_chart_tooltip_enabled_on_1_' . $i ] === 'yes' ) {
				$tooltip_series[] = $i;
			}
			$gradient[] = esc_html( $settings[ 'iq_' . $type . '_chart_gradient_1_' . $i ] );
			if ( strval( $settings[ 'iq_' . $type . '_chart_gradient_2_' . $i ] ) === '' ) {
				$second_gradient[] = esc_html( $settings[ 'iq_' . $type . '_chart_gradient_1_' . $i ] );
			} else {
				$second_gradient[] = esc_html( $settings[ 'iq_' . $type . '_chart_gradient_2_' . $i ] );
			}
			if ( $settings[ 'iq_' . $type . '_chart_bg_pattern_' . $i ] !== '' ) {
				$fill_pattern[] = esc_html( $settings[ 'iq_' . $type . '_chart_bg_pattern_' . $i ] );
			} else {
				$fill_pattern[] = 'verticalLines';
			}
		}
		$category_list = $settings[ 'iq_' . $type . '_category_list' ];
		if ( graphina_pro_active() && $settings[ 'iq_' . $type . '_chart_data_option' ] !== 'manual' ) {
			$call_ajax       = true;
			$gradient        = array( '#ffffff' );
			$second_gradient = array( '#ffffff' );
			$loading_text    = esc_html__( 'Loading...', 'graphina-charts-for-elementor' );
		} else {
			if ( gettype( $category_list ) === 'NULL' ) {
				$category_list = array();
			}
			$temp = '';
			foreach ( $category_list as $v ) {
				$temp = esc_html( graphina_get_dynamic_tag_data( $v, 'iq_' . $type . '_chart_category' ) );
				$data['category'][] = htmlspecialchars_decode($temp);
			}
			for ( $i = 0; $i < $settings[ 'iq_' . $type . '_chart_data_series_count' ]; $i++ ) {
				$value_list = $settings[ 'iq_' . $type . '_value_list_3_' . ( $settings[ 'iq_' . $type . '_can_chart_negative_values' ] === 'yes' ? 2 : 1 ) . '_' . $i ];
				$value      = array();
				if ( gettype( $value_list ) === 'NULL' ) {
					$value_list = array();
				}
				foreach ( $value_list as $v ) {
					$value[] = (float) graphina_get_dynamic_tag_data( $v, 'iq_' . $type . '_chart_value_3_' . $i );
				}
				$data['series'][] = array(
					'name' => esc_html( graphina_get_dynamic_tag_data( $settings, 'iq_' . $type . '_chart_title_3_' . $i ) ),
					'data' => $value,
				);
			}
			if ( $settings[ 'iq_' . $type . '_chart_data_option' ] === 'dynamic' ) {
				$data = array(
					'series'   => array(),
					'category' => array(),
				);
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

		$gradient           = implode( '_,_', $gradient );
		$second_gradient    = implode( '_,_', $second_gradient );
		$fill_pattern       = implode( '_,_', $fill_pattern );
		$category           = implode( '_,_', $data['category'] );
		$drop_shadow_series = implode( ',', $drop_shadow_series );
		$tooltip_series     = implode( ',', $tooltip_series );
		$local_string_type  = graphina_common_setting_get( 'thousand_seperator' );
		graphina_chart_widget_content( $this, $main_id, $settings );
		if ( graphina_restricted_access( 'scatter', $main_id, $settings, false ) === false ) {
			?>
			<script>
				( function (){
					if (typeof isInit === 'undefined') {
						var isInit = {};
					}
					isInit['<?php echo esc_js( $main_id ); ?>'] = false;

					const myElement = document.querySelector(".scatter-chart-<?php echo esc_js( $main_id ); ?>");
					const scatterOptions = {
						series: <?php echo wp_json_encode( $data['series'] ); ?>,
						chart: {
							background: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_background_color1' ] ); ?>',
							height: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_height' ] ); ?>'),
							type: 'scatter',
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
							dropShadow: {
								enabled: '<?php echo esc_js( $settings[ 'iq_' . $type . '_is_chart_dropshadow' ] === 'yes' ); ?>',
								enabledOnSeries: [<?php echo esc_js( $drop_shadow_series ); ?>],
								top: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_is_chart_dropshadow_top' ] ); ?>'),
								left: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_is_chart_dropshadow_left' ] ); ?>'),
								blur: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_is_chart_dropshadow_blur' ] ); ?>'),
								color: '<?php echo esc_js( isset( $settings[ 'iq_' . $type . '_is_chart_dropshadow_color' ] ) ? $settings[ 'iq_' . $type . '_is_chart_dropshadow_color' ] : '' ); ?>',
								opacity: parseFloat('<?php echo esc_js( $settings[ 'iq_' . $type . '_is_chart_dropshadow_opacity' ] ); ?>')
							},
							animations: {
								enabled: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_animation' ] === 'yes' ); ?>',
								speed: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_animation_speed' ] ); ?>'),
								delay: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_animation_delay' ] ); ?>')
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
						dataLabels: {
							enabled: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_datalabel_show' ] === 'yes' ); ?>',
							style: {
								fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
								fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
								fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
								colors: ['<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] : '#000000' ); ?>']
							},
							background: {
								enabled: false,
							},
							formatter: function (val) {
								if(isNaN(val)){
									return '';
								}
								if("<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_number_format_commas' ] ) && $settings[ 'iq_' . $type . '_chart_number_format_commas' ] === 'yes' ); ?>" ){
									val = graphinNumberWithCommas(val,'<?php echo esc_js( $local_string_type ); ?>')
								}
								else if("<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_label_pointer' ] ) && $settings[ 'iq_' . $type . '_chart_yaxis_label_pointer' ] === 'yes' ); ?>"
									&&  typeof graphinaAbbrNum  !== "undefined"){
									val = graphinaAbbrNum(val ,  parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_label_pointer_number' ] ); ?>") || 0 );
								}
								return '<?php echo esc_js( $data_label_prefix ); ?>' + val + '<?php echo esc_js( $data_label_postfix ); ?>';
							},
							offsetY: parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_offsety' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_offsety' ] : 0 ); ?>'),
							offsetX: parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_offsetx' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_offsetx' ] : 0 ); ?>'),
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
							categories: '<?php echo ( $category ); ?>'.split('_,_'),
							position: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_position' ] ); ?>',
							tickAmount: parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_tick_amount' ] ); ?>"),
							tickPlacement: "<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_tick_placement' ] ); ?>",
							labels: {
								show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_show' ] === 'yes' ); ?>',
								rotateAlways: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_auto_rotate' ] === 'yes' ); ?>',
								rotate: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_rotate' ] ); ?>') || 0,
								offsetX: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_offset_x' ] ); ?>') || 0,
								offsetY: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_offset_y' ] ); ?>') || 0,
								trim: true,
								style: {
									colors: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_color' ] ); ?>',
									fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
									fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
									fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>'
								},
								formatter: function (val) {
									if('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_xaxis_label_show' ] ) && $settings[ 'iq_' . $type . '_chart_xaxis_label_show' ] === 'yes' ); ?>'){
										val = '<?php echo esc_js( $x_label_prefix ); ?>' + val + '<?php echo esc_js( $x_label_postfix ); ?>';
									}
									if(val){
										val = val.split(',')
									}
									return val
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
							opposite: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_position' ] === 'yes' ); ?>',
							tickAmount: parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_tick_amount' ] ); ?>"),
							decimalsInFloat: parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_decimals_in_float' ] ); ?>"),
							labels: {
								show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_show' ] === 'yes' ); ?>',
								rotate: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_rotate' ] ); ?>') || 0,
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
						stroke:{
							show:true,
							width:2,
							colors: ['transparent']
						},
						colors: '<?php echo esc_js( $gradient ); ?>'.split('_,_'),
						fill: {
							type: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_fill_style_type' ] ); ?>',
							opacity: parseFloat('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_fill_opacity' ] ); ?>'),
							colors: '<?php echo esc_js( $gradient ); ?>'.split('_,_'),
							gradient: {
								gradientToColors: '<?php echo esc_js( $second_gradient ); ?>'.split('_,_'),
								type: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_gradient_type' ] ); ?>',
								inverseColors: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_gradient_inversecolor' ] === 'yes' ); ?>',
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
							show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_legend_show' ] === 'yes' ); ?>',
							position: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_legend_position' ] ) ? $settings[ 'iq_' . $type . '_chart_legend_position' ] : 'bottom' ); ?>',
							horizontalAlign: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_legend_horizontal_align' ] ) ? $settings[ 'iq_' . $type . '_chart_legend_horizontal_align' ] : 'center' ); ?>',
							fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
							fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
							fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
							labels: {
								colors: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_color' ] ); ?>'
							},
							tooltipHoverFormatter: function(seriesName, opts) {
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
							enabled: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip' ] === 'yes' ); ?>',
							intersect: !('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_tooltip_shared' ] ) ? $settings[ 'iq_' . $type . '_chart_tooltip_shared' ] : '' ); ?>' === "yes"),
							shared: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_tooltip_shared' ] ) ? $settings[ 'iq_' . $type . '_chart_tooltip_shared' ] : '' ); ?>' === "yes",
							theme: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip_theme' ] ); ?>',
							style: {
								fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
								fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>'
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
						],
						markers : {
							size: parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_scatter_width' ] ) ? $settings[ 'iq_' . $type . '_chart_scatter_width' ] : 10 ); ?>') || 10,
						}
					};


					if ("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_label_show' ] ) === 'yes'; ?>" || "<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_format_number' ] ) === 'yes'; ?>" ) {
						scatterOptions.yaxis.labels.formatter = function (val) {
							let decimal = parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_prefix_postfix_decimal_point' ] ) ? $settings[ 'iq_' . $type . '_chart_yaxis_prefix_postfix_decimal_point' ] : 0 ); ?>') || 0;
							if("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_format_number' ] ) === 'yes'; ?>" ){
								val = graphinNumberWithCommas(val,'<?php echo esc_js( $local_string_type ); ?>',decimal)
							}
							else if("<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_label_pointer' ] ) && $settings[ 'iq_' . $type . '_chart_yaxis_label_pointer' ] === 'yes' ); ?>"
								&&  typeof graphinaAbbrNum  !== "undefined"){
								val = graphinaAbbrNum(val ,  parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_label_pointer_number' ] ); ?>") || 0 );
							}else{
								val = parseFloat(val).toFixed(decimal)
							}
							return '<?php echo esc_js( $y_label_prefix ); ?>' + val + '<?php echo esc_js( $y_label_postfix ); ?>';
						}
					}
					if ("<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_tooltip_shared' ] ) && $settings[ 'iq_' . $type . '_chart_tooltip_shared' ] === 'yes' ? $settings[ 'iq_' . $type . '_chart_tooltip_shared' ] : '' ); ?>" ) {
						scatterOptions.tooltip['enabledOnSeries'] = [<?php echo esc_js( $tooltip_series ); ?>];
					}
					if ("<?php echo esc_html( $settings[ 'iq_' . $type . '_chart_yaxis_0_indicator_show' ] ) === 'yes'; ?>" ) {
						scatterOptions['annotations'] = {
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
							axisTitle(scatterOptions, 'xaxis' ,title, style ,xaxisYoffset);
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
							axisTitle(scatterOptions, 'yaxis' ,title, style );
						}
					}
					if('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_enable_min_max' ] ) && $settings[ 'iq_' . $type . '_chart_yaxis_enable_min_max' ] === 'yes' ); ?>'){
						scatterOptions.yaxis.tickAmount = parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_tick_amount' ] ); ?>") || 6;
						scatterOptions.yaxis.min = parseFloat('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_min_value' ] ) ? $settings[ 'iq_' . $type . '_chart_yaxis_min_value' ] : 0 ); ?>') || 0;
						scatterOptions.yaxis.max = parseFloat('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_max_value' ] ) ? $settings[ 'iq_' . $type . '_chart_yaxis_max_value' ] : 0 ); ?>') || 200;
					}

					if("<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_opposite_yaxis_title_enable' ] ) && $settings[ 'iq_' . $type . '_chart_opposite_yaxis_title_enable' ] === 'yes' ); ?>"){
						let style = {
							color:'<?php echo esc_js( $settings[ 'iq_' . $type . '_card_opposite_yaxis_title_font_color' ] ); ?>',
							colors:'<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_color' ] ); ?>',
							fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
							fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
							fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
						}
						scatterOptions['yaxis'] = [scatterOptions.yaxis]
						let areaYaxisTemp = {
							opposite: '<?php echo ! ( esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_position' ] ) === 'yes' ); ?>',
							labels: {
								show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_opposite_yaxis_label_show' ] === 'yes' ); ?>',
								formatter: function (val) {
									if("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_opposite_yaxis_format_number' ] ); ?>" === "yes"){
										val = graphinNumberWithCommas(val,'<?php echo esc_js( $local_string_type ); ?>')
									}
									return '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_opposite_yaxis_label_prefix' ] ); ?>'  + val + '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_opposite_yaxis_label_postfix' ] ); ?>'
								},
								style
							},
							tickAmount: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_opposite_yaxis_tick_amount' ] ); ?>'),
							title: {
								text: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_opposite_yaxis_title' ] ); ?>',
								style
							}
						}
						if('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_enable_min_max' ] ) && $settings[ 'iq_' . $type . '_chart_yaxis_enable_min_max' ] === 'yes' ); ?>'){
							areaYaxisTemp.tickAmount = parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_opposite_yaxis_tick_amount' ] ); ?>') || 6;
							areaYaxisTemp.min = parseFloat('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_min_value' ] ) ? $settings[ 'iq_' . $type . '_chart_yaxis_min_value' ] : 0 ); ?>') || 0;
							areaYaxisTemp.max = parseFloat('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_max_value' ] ) ? $settings[ 'iq_' . $type . '_chart_yaxis_max_value' ] : 0 ); ?>') || 200;
						}
						scatterOptions.yaxis.push(areaYaxisTemp)
					}


					if (typeof initNowGraphina !== "undefined") {
						initNowGraphina(
							myElement,
							{
								ele: myElement,
								options: scatterOptions,
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

Plugin::instance()->widgets_manager->register( new Scatter_Chart() );
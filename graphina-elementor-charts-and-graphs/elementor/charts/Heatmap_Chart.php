<?php
/**
 * Apex heatmap chart elementor widget class.
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
 * Elementor heatmap chart widget.
 *
 * Elementor widget that displays an eye-catching heatmap chart.
 */
class Heatmap_Chart extends Widget_Base {


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
		return 'heatmap_chart';
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
		return 'Heatmap';
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
		return 'graphina-apex-heatmap-chart';
	}

	/**
	 * Get widget type.
	 *
	 * @return string Widget ty[e.
	 *
	 * @access public
	 */
	public function get_chart_type(): string {
		return 'heatmap';
	}

	/**
	 * Register controller to elementor
	 *
	 * @return void
	 */
	protected function register_controls(): void {
		$type = $this->get_chart_type();
		graphina_basic_setting( $this, $type );

		graphina_chart_data_option_setting( $this, $type, 10 );

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

		graphina_common_chart_setting( $this, $type, false, true, false, false );

		graphina_tooltip( $this, $type, true, false );

		$this->add_control(
			'iq_' . $type . '_chart_tooltip_number_formatter',
			array(
				'label'     => esc_html__( 'Number Formatter', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);
		
		$this->add_control(
			'iq_' . $type . '_chart_tooltip_prefix_postfix',
			array(
				'label'     => esc_html__( 'Tooltip Prefix/Postfix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'true'      => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'false'     => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => '',
				'condition' => array(
					'iq_' . $type . '_chart_tooltip_number_formatter' => 'yes',
				),
			)
		);
		$this->add_control(
			'iq_' . $type . '_chart_tooltip_prefix_val',
			array(
				'label'     => esc_html__( 'Prefix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => array(
					'iq_' . $type . '_chart_tooltip_number_formatter' => 'yes',
					'iq_' . $type . '_chart_tooltip_prefix_postfix' => 'yes',
				),
			)
		);
		$this->add_control(
			'iq_' . $type . '_chart_tooltip_postfix_val',
			array(
				'label'     => esc_html__( 'Postfix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => array(
					'iq_' . $type . '_chart_tooltip_number_formatter' => 'yes',
					'iq_' . $type . '_chart_tooltip_prefix_postfix' => 'yes',
				),
			)
		);

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
			'iq_' . $type . '_chart_radius',
			array(
				'label'   => esc_html__( 'Matrix Radius', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 0,
				'max'     => 100,
				'step'    => 5,
			)
		);

		graphina_stroke( $this, $type );

		graphina_animation( $this, $type );

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
				'label'       => 'Category Value',
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
				'label'     => esc_html__( 'Categories', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::REPEATER,
				'fields'    => $repeater->get_controls(),
				'default'   => array(
					array( 'iq_' . $type . '_chart_category' => 'w1' ),
					array( 'iq_' . $type . '_chart_category' => 'w2' ),
					array( 'iq_' . $type . '_chart_category' => 'w3' ),
					array( 'iq_' . $type . '_chart_category' => 'w4' ),
					array( 'iq_' . $type . '_chart_category' => 'w5' ),
					array( 'iq_' . $type . '_chart_category' => 'w6' ),
					array( 'iq_' . $type . '_chart_category' => 'w7' ),
					array( 'iq_' . $type . '_chart_category' => 'w8' ),
					array( 'iq_' . $type . '_chart_category' => 'w9' ),
					array( 'iq_' . $type . '_chart_category' => 'w10' ),
					array( 'iq_' . $type . '_chart_category' => 'w11' ),
					array( 'iq_' . $type . '_chart_category' => 'w12' ),
					array( 'iq_' . $type . '_chart_category' => 'w13' ),
					array( 'iq_' . $type . '_chart_category' => 'w14' ),
					array( 'iq_' . $type . '_chart_category' => 'w15' ),
				),
				'condition' => array(
					'iq_' . $type . '_chart_data_option' => 'manual',
				),
			)
		);

		$this->end_controls_section();

		graphina_advance_x_axis_setting( $this, $type, true, true );

		graphina_advance_y_axis_setting( $this, $type, true, true );

		graphina_series_setting( $this, $type, array( 'color' ), false, array( 'classic' ), false, false );

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
					'label'       => 'Element Title',
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
					'label'       => 'Chart Value',
					'type'        => Controls_Manager::NUMBER,
					'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);

			/** Chart value list. */
			$this->add_control(
				'iq_' . $type . '_value_list_3_' . $i,
				array(
					'label'       => esc_html__( 'Chart value list', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => array(
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
						array( 'iq_' . $type . '_chart_value_3_' . $i => wp_rand( 10, 200 ) ),
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
	}

	/**
	 * Render element.
	 *
	 * Generates the final HTML on the frontend.
	 *
	 * @return void
	 */
	protected function render(): void {
		$settings           = $this->get_settings_for_display();
		$type               = $this->get_chart_type();
		$ajax_settings      = graphina_ajax_settings( $settings, $type );
		$main_id            = graphina_widget_id( $this );
		$color              = array();
		$data               = array(
			'series'   => array(),
			'category' => array(),
		);
		$data_label_prefix  = '';
		$data_label_postfix = '';
		$y_label_prefix     = '';
		$y_label_postfix    = '';
		$x_label_prefix     = '';
		$x_label_postfix    = '';
		$call_ajax          = false;
		$loading_text       = esc_html( isset( $settings[ 'iq_' . $type . '_chart_no_data_text' ] ) ? $settings[ 'iq_' . $type . '_chart_no_data_text' ] : '' );

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

		if ( $settings[ 'iq_' . $type . '_chart_tooltip_prefix_postfix' ] === 'yes' ) {
			$yt_label_prefix  = $settings[ 'iq_' . $type . '_chart_tooltip_prefix_val' ];
			$yt_label_postfix = $settings[ 'iq_' . $type . '_chart_tooltip_postfix_val' ];
		}

		$series_count = isset( $settings[ 'iq_' . $type . '_chart_data_series_count' ] ) ? $settings[ 'iq_' . $type . '_chart_data_series_count' ] : 0;
		for ( $i = 0; $i < $series_count; $i++ ) {
			$color[] = esc_html( $settings[ 'iq_' . $type . '_chart_gradient_1_' . $i ] );
		}
		if ( graphina_pro_active() && $settings[ 'iq_' . $type . '_chart_data_option' ] !== 'manual' ) {
			$call_ajax    = true;
			$gradient     = array( '#ffffff' );
			$loading_text = esc_html__( 'Loading...', 'graphina-charts-for-elementor' );
		} else {
			$category_list = $settings[ 'iq_' . $type . '_category_list' ];
			if ( gettype( $category_list ) === 'NULL' ) {
				$category_list = array();
			}
			if ( empty( $series_count ) ) {
				$category_list = array();
			}
			$temp = '';
			foreach ( $category_list as $v ) {
				$temp = esc_html( graphina_get_dynamic_tag_data( $v, 'iq_' . $type . '_chart_category' ) );
				$data['category'][] = htmlspecialchars_decode($temp);
			}
			for ( $i = 0; $i < $series_count; $i++ ) {
				$value_list = $settings[ 'iq_' . $type . '_value_list_3_' . $i ];
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
			if ( $settings[ 'iq_' . $type . '_chart_data_option' ] !== 'manual' ) {
				$data = array(
					'series'   => array(),
					'category' => array(),
				);
			}
			$gradient_new   = array();
			$desired_length = count( $data['series'] );
			$length         = 0;
			while ( $length < $desired_length ) {
				$gradient_new = array_merge( $gradient_new, $color );
				$length       = count( $gradient_new );
			}
			$gradient = array_slice( $gradient_new, 0, $desired_length );
		}
		$color                    = implode( '_,_', $gradient );
		$category                 = implode( '_,_', $data['category'] );
		$local_string_type        = graphina_common_setting_get( 'thousand_seperator' );
		graphina_chart_widget_content( $this, $main_id, $settings );
		if ( graphina_restricted_access( 'heatmap', $main_id, $settings, false ) === false ) {
			?>
			<script>

				(function (){
					if (typeof isInit === 'undefined') {
						var isInit = {};
					}
					isInit['<?php echo esc_js( $main_id ); ?>'] = false;

					const myElement = document.querySelector(".heatmap-chart-<?php echo esc_js( $main_id ); ?>");

					const heatmapOptions = {
						series: <?php echo wp_json_encode( $data['series'] ); ?>,
						chart: {
							background: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_background_color1' ] ); ?>',
							height: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_height' ] ); ?>'),
							type: 'heatmap',
							fontFamily: '<?php echo esc_js( esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ) ); ?>',
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
						plotOptions: {
							heatmap: {
								radius: parseFloat('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_radius' ] ); ?>')
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
							enabled: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_datalabel_show' ] ); ?>',
							style: {
								fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
								fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
								fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
								colors: ['<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] ); ?>'],
							},
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
							offsetY: parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_offsety' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_offsety' ] : 0 ); ?>'),
							offsetX: parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_offsetx' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_offsetx' ] : 0 ); ?>'),
						},
						stroke: {
							show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_stroke_show' ] === 'yes' ); ?>',
							width: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_stroke_show' ] === 'yes' ? $settings[ 'iq_' . $type . '_chart_stroke_width' ] : 0 ); ?>')
						},
						colors: '<?php echo esc_js( $color ); ?>'.split('_,_'),
						xaxis: {
							categories: '<?php echo ( $category ); ?>'.split('_,_'),
							position: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_position' ] ); ?>',
							tickAmount: parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_tick_amount' ] ); ?>"),
							tickPlacement: "<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_tick_placement' ] ); ?>",
							labels: {
								show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_show' ] ); ?>',
								rotateAlways: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_auto_rotate' ] ); ?>',
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
								show: "<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_xaxis_crosshairs_show' ] ) && $settings[ 'iq_' . $type . '_chart_xaxis_crosshairs_show' ] === 'yes' && $settings[ 'iq_' . $type . '_chart_xaxis_tooltip_show' ] === 'yes' ); ?>",
								position: 'front',
							}

						},
						yaxis: {
							opposite: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_position' ] ); ?>',
							tickAmount: parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_tick_amount' ] ); ?>"),
							decimalsInFloat: parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_decimals_in_float' ] ); ?>"),
							labels: {
								show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_show' ] ); ?>',
								rotate:parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_rotate' ] ); ?>') || 0,
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
								show: "<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_crosshairs_show' ] ) && $settings[ 'iq_' . $type . '_chart_yaxis_crosshairs_show' ] === 'yes' && $settings[ 'iq_' . $type . '_chart_yaxis_tooltip_show' ] === 'yes' ); ?>",
								position: 'front',
							}
						},
						fill: {
							opacity: 1
						},
						tooltip: {
							enabled: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip' ] ); ?>',
							theme: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip_theme' ] ); ?>',
							style: {
								fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
								fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>'
							},
							y: {
								formatter: function(value) {
									value = ("<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_label_pointer' ] ) && $settings[ 'iq_' . $type . '_chart_yaxis_label_pointer' ] === 'yes' ); ?>"  &&  typeof graphinaAbbrNum  !== "undefined") ? graphinaAbbrNum(value ,  parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_label_pointer_number' ] ); ?>") || 0 ) : value
									return value;
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


					if ("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip_number_formatter' ] ) === 'yes'; ?>") {
						heatmapOptions.tooltip.y.formatter = function (val) {
							let decimal = 0;
							if("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip_number_formatter' ] ) === 'yes'; ?>" ){
								val = graphinNumberWithCommas(val,'<?php echo esc_js( $local_string_type ); ?>',decimal)
							}
							return '<?php echo esc_js( $yt_label_prefix ); ?>' + val + '<?php echo esc_js( $yt_label_postfix ); ?>';
						};
					}

					if ("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_label_show' ] ) === 'yes'; ?>" ) {
						heatmapOptions.yaxis.labels.formatter = function (val) {
							if (val !== '') {
								return '<?php echo esc_js( $y_label_prefix ); ?>' + val + '<?php echo esc_js( $y_label_postfix ); ?>';
							}
							return val;
						}
					}

					if("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_title_enable' ] === 'yes' ); ?>"){
						const style ={
							color:'<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_color' ] ); ?>',
							fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
							fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
							fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
						}
						const title = '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_title' ] ); ?>';
						const xaxisYoffset = '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_position' ] ); ?>' === 'top' ? -95 : 0;
						if(typeof axisTitle !== "undefined"){
							axisTitle(heatmapOptions, 'xaxis' ,title, style,xaxissYoffset );
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
						const title = '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_title' ] ); ?>';
						if(typeof axisTitle !== "undefined"){
							axisTitle(heatmapOptions, 'yaxis' ,title, style );
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
						heatmapOptions['yaxis'] = [heatmapOptions.yaxis]
						heatmapOptions.yaxis.push({
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
								ele: document.querySelector(".heatmap-chart-<?php echo esc_js( $main_id ); ?>"),
								options: heatmapOptions,
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

Plugin::instance()->widgets_manager->register( new Heatmap_Chart() );
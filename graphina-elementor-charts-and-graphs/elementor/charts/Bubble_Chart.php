<?php
/**
 * Apex bubble chart elementor widget class.
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
 * Elementor bubble chart widget.
 *
 * Elementor widget that displays an eye-catching bubble chart.
 *
 * @since 1.5.7
 */
class Bubble_Chart extends Widget_Base {


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
		return 'bubble_chart';
	}

	/**
	 * Get widget Title.
	 *
	 * Retrieve heading widget Title.
	 *
	 * @return string Widget Title.
	 * @access public
	 */
	public function get_title(): string {
		return 'Bubble';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @return array Widget categories.
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
		return 'graphina-apex-bubble-chart';
	}

	/**
	 * Function to generate random bubble chart value.
	 *
	 * @param string $type controller type.
	 * @param int    $i index number.
	 * @param int    $count max count.
	 * @param int[]  $x x value.
	 * @param int[]  $y y value.
	 * @param int[]  $z z value.
	 * @return array
	 */
	protected function bubble_data_generator(string $type = '', int $i = 0, int $count = 20, array $x = array(
		'min' => 10,
		'max' => 1000,
	), array $y = array(
		'min' => 10,
		'max' => 200,
	), array $z = array(
		'min' => 10,
		'max' => 200,
	) ): array {
		$result = array();
		for ( $j = 0; $j < $count; $j++ ) {
			$result[] = array(
				'iq_' . $type . '_chart_x_value_3_' . $i => wp_rand( $x['min'], $x['max'] ),
				'iq_' . $type . '_chart_y_value_3_' . $i => wp_rand( $y['min'], $y['max'] ),
				'iq_' . $type . '_chart_z_value_3_' . $i => wp_rand( $z['min'], $z['max'] ),
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
		return 'bubble';
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

		graphina_common_chart_setting( $this, $type, false, true, false, false );

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
			'iq_' . $type . '_chart_fill_opacity',
			array(
				'label'   => esc_html__( 'Fill Opacity', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 0,
				'max'     => 1,
				'step'    => 0.05,
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_stroke_width',
			array(
				'label'   => 'Stroke Width',
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 0,
				'max'     => 15,
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_stroke_color',
			array(
				'label'     => 'Stroke Color',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'condition' => array(
					'iq_' . $type . '_chart_stroke_width!' => 0,
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_3d_show',
			array(
				'label'     => esc_html__( '3D Chart', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => false,
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_is_custom_radius',
			array(
				'label'     => esc_html__( 'Custom Bubble Radius', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'No', 'graphina-charts-for-elementor' ),
				'default'   => false,
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_min_bubble_radius',
			array(
				'label'     => esc_html__( 'Minimum Bubble Radius', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 25,
				'max'       => 100,
				'min'       => 10,
				'condition' => array(
					'iq_' . $type . '_chart_is_custom_radius' => 'yes',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_max_bubble_radius',
			array(
				'label'     => esc_html__( 'Maximum Bubble Radius', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 70,
				'max'       => 200,
				'min'       => 10,
				'condition' => array(
					'iq_' . $type . '_chart_is_custom_radius' => 'yes',
				),
			)
		);

		graphina_animation( $this, $type );

		$this->end_controls_section();

		graphina_chart_label_setting( $this, $type );

		$this->start_controls_section(
			'iq_' . $type . '_section_5',
			array(
				'label'      => esc_html__( 'X-Axis Setting', 'graphina-charts-for-elementor' ),
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
			'iq_' . $type . '_chart_xaxis_datalabel_show',
			array(
				'label'     => esc_html__( 'Labels', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
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

		$this->add_control(
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

		$this->add_control(
			'iq_' . $type . '_chart_xaxis_datalabel_rotate',
			array(
				'label'     => esc_html__( 'Rotate', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => -45,
				'max'       => 360,
				'min'       => -360,
				'condition' => array(
					'iq_' . $type . '_chart_xaxis_datalabel_auto_rotate' => 'yes',
				),
			)
		);

		$this->add_control(
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

		$this->add_control(
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

		$this->add_control(
			'iq_' . $type . '_chart_xaxis_datalabel_tick_amount',
			array(
				'label'     => esc_html__( 'Tick Amount', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 30,
				'max'       => 30,
				'min'       => 0,
				'condition' => array(
					'iq_' . $type . '_chart_xaxis_datalabel_show' => 'yes',
				),
			)
		);

		$this->add_control(
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

		$this->add_control(
			'iq_' . $type . '_chart_xaxis_title_enable',
			array(
				'label'     => esc_html__( 'Enable Title', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'no',
			)
		);

		$this->add_control(
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

		$this->end_controls_section();

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
					'label'       => esc_html__( 'Element Title', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Add Tile', 'graphina-charts-for-elementor' ),
					'default'     => 'Series ' . ( $i + 1 ),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);

			$repeater = new Repeater();

			$repeater->add_control(
				'iq_' . $type . '_chart_x_value_3_' . $i,
				array(
					'label'       => 'Chart  X Value',
					'type'        => Controls_Manager::NUMBER,
					'placeholder' => esc_html__( 'Add X Value', 'graphina-charts-for-elementor' ),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);

			$repeater->add_control(
				'iq_' . $type . '_chart_y_value_3_' . $i,
				array(
					'label'       => 'Chart Y Value',
					'type'        => Controls_Manager::NUMBER,
					'placeholder' => esc_html__( 'Add Y Value', 'graphina-charts-for-elementor' ),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);

			$repeater->add_control(
				'iq_' . $type . '_chart_z_value_3_' . $i,
				array(
					'label'       => 'Chart Z Value',
					'type'        => Controls_Manager::NUMBER,
					'placeholder' => esc_html__( 'Add Z Value', 'graphina-charts-for-elementor' ),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);

			$x = array(
				'min' => 10,
				'max' => 1000,
			);
			$y = array(
				'min' => 10,
				'max' => 200,
			);
			$z = array(
				'min' => 10,
				'max' => 200,
			);

			/** Chart value list. */
			$this->add_control(
				'iq_' . $type . '_value_list_3_' . $i,
				array(
					'label'   => esc_html__( 'Chart value list', 'graphina-charts-for-elementor' ),
					'type'    => Controls_Manager::REPEATER,
					'fields'  => $repeater->get_controls(),
					'default' => $this->bubble_data_generator( 'bubble', $i, 20, $x, $y, $z ),
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
		$settings                 = $this->get_settings_for_display();
		$type                     = $this->get_chart_type();
		$ajax_settings            = graphina_ajax_settings( $settings, $type );
		$main_id                  = graphina_widget_id( $this );
		$color                    = array();
		$data_label_prefix        = '';
		$data_label_postfix       = '';
		$y_label_prefix           = '';
		$y_label_postfix          = '';
		$data                     = array(
			'series'   => array(),
			'category' => array(),
		);
		$call_ajax                = false;
		$loading_text             = isset( $settings[ 'iq_' . $type . '_chart_no_data_text' ] ) ? esc_html( $settings[ 'iq_' . $type . '_chart_no_data_text' ] ) : '';
		$enable_number_formatting = $settings[ 'iq_' . $type . '_chart_yaxis_number_format' ] === 'yes';
		$locale                   = $settings[ 'iq_' . $type . '_chart_yaxis_locale' ];

		$export_file_name = (
			! empty( $settings[ 'iq_' . $type . '_can_chart_show_toolbar' ] ) && $settings[ 'iq_' . $type . '_can_chart_show_toolbar' ] === 'yes'
			&& ! empty( $settings[ 'iq_' . $type . '_export_filename' ] )
		) ? $settings[ 'iq_' . $type . '_export_filename' ] : $main_id;

		if ( $settings[ 'iq_' . $type . '_chart_datalabel_show' ] === 'yes' ) {
			$data_label_prefix  = $settings[ 'iq_' . $type . '_chart_datalabel_prefix' ];
			$data_label_postfix = $settings[ 'iq_' . $type . '_chart_datalabel_postfix' ];
		}

		if ( $settings[ 'iq_' . $type . '_chart_yaxis_label_show' ] === 'yes' ) {
			$y_label_prefix  = $settings[ 'iq_' . $type . '_chart_yaxis_label_prefix' ];
			$y_label_postfix = $settings[ 'iq_' . $type . '_chart_yaxis_label_postfix' ];
		}

		$series_count = isset( $settings[ 'iq_' . $type . '_chart_data_series_count' ] ) ? $settings[ 'iq_' . $type . '_chart_data_series_count' ] : 0;

		if ( graphina_pro_active() && $settings[ 'iq_' . $type . '_chart_data_option' ] !== 'manual' ) {
			$call_ajax    = true;
			$loading_text = esc_html__( 'Loading...', 'graphina-charts-for-elementor' );
			$color        = array( '#ffffff' );
		} else {
			for ( $i = 0; $i < $series_count; $i++ ) {
				$color[]        = esc_html( $settings[ 'iq_' . $type . '_chart_gradient_1_' . $i ] );
				$formated_value = array();
				$value_list     = $settings[ 'iq_' . $type . '_value_list_3_' . $i ];
				if ( gettype( $value_list ) === 'NULL' ) {
					$value_list = array();
				}
				foreach ( $value_list as $key => $val ) {
					if ( $val[ 'iq_' . $type . '_chart_x_value_3_' . $i ] !== '' && $val[ 'iq_' . $type . '_chart_y_value_3_' . $i ] !== '' && $val[ 'iq_' . $type . '_chart_z_value_3_' . $i ] !== '' ) {
						$formated_value[] = array(
							'x' => (float) graphina_get_dynamic_tag_data( $val, 'iq_' . $type . '_chart_x_value_3_' . $i ),
							'y' => (float) graphina_get_dynamic_tag_data( $val, 'iq_' . $type . '_chart_y_value_3_' . $i ),
							'z' => (float) graphina_get_dynamic_tag_data( $val, 'iq_' . $type . '_chart_z_value_3_' . $i ),
						);
					}
				}
				$data['series'][] = array(
					'name' => esc_html( graphina_get_dynamic_tag_data( $settings, 'iq_' . $type . '_chart_title_3_' . $i ) ),
					'data' => $formated_value,
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
			$current_length = 0;
			while ( $current_length < $desired_length ) {
				$gradient_new   = array_merge( $gradient_new, $color );
				$current_length = count( $gradient_new );
			}
		}

		$color             = implode( '_,_', $color );
		$local_string_type = graphina_common_setting_get( 'thousand_seperator' );
		graphina_chart_widget_content( $this, $main_id, $settings );
		if ( graphina_restricted_access( 'bubble', $main_id, $settings, false ) === false ) {

			?>
			<script>
				(function() {
					if (typeof isInit === 'undefined') {
						var isInit = {};
					}
					isInit['<?php echo esc_js( $main_id ); ?>'] = false;

					const myElement = document.querySelector(".bubble-chart-<?php echo esc_js( $main_id ); ?>");
					const bubbleOptions = {
						series: <?php echo wp_json_encode( $data['series'] ); ?>,
						chart: {
							background: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_background_color1' ] ); ?>',
							height: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_height' ] ); ?>'),
							type: 'bubble',
							fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
                            locales: [JSON.parse('<?php echo graphina_apexchart_localization();//@phpcs:ignore; ?>')],
							defaultLocale: "en",
							toolbar: {
								offsetX: parseInt('<?php echo ! empty( $settings[ 'iq_' . $type . '_chart_toolbar_offsetx' ] ) ? esc_js( $settings[ 'iq_' . $type . '_chart_toolbar_offsetx' ] ) : 0; ?>') || 0,
								offsetY: parseInt('<?php echo ! empty( $settings[ 'iq_' . $type . '_chart_toolbar_offsety' ] ) ? esc_js( $settings[ 'iq_' . $type . '_chart_toolbar_offsety' ] ) : 0; ?>')|| 0,
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
							bubble: {
								minBubbleRadius: parseInt('<?php echo( $settings[ 'iq_' . $type . '_chart_is_custom_radius' ] === 'yes' ? esc_js( $settings[ 'iq_' . $type . '_chart_min_bubble_radius' ] ) : 10 ); ?>'),
								maxBubbleRadius: parseInt('<?php echo( $settings[ 'iq_' . $type . '_chart_is_custom_radius' ] === 'yes' ? esc_js( $settings[ 'iq_' . $type . '_chart_max_bubble_radius' ] ) : 50 ); ?>')
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
								colors: ['<?php echo esc_js( isset( $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] : '#ffffff' ); ?>']
							},
							formatter: function (val) {
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
						colors: '<?php echo esc_js( $color ); ?>'.split('_,_'),
						fill: {
							opacity: parseFloat(<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_fill_opacity' ] ); ?>),
							type: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_3d_show' ] === 'yes' ? 'gradient' : '' ); ?>'
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
							type: 'category',
							categories: [],
							position: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_position' ] ); ?>',
							tickAmount: parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_tick_amount' ] ); ?>"),
							tickPlacement: "<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_tick_placement' ] ); ?>",
							labels: {
								show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_show' ] === 'yes' ); ?>',
								rotateAlways: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_auto_rotate' ] ); ?>',
								rotate: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_rotate' ] ); ?>') || 0,
								offsetX: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_offset_x' ] ); ?>')  || 0,
								offsetY: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_offset_y' ] ); ?>')  || 0,
								trim: true,
								style: {
									colors: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_color' ] ); ?>',
									fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
									fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
									fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>'
								}
							},
							tooltip: {
								enabled: "<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_xaxis_tooltip_show' ] ) && $settings[ 'iq_' . $type . '_chart_xaxis_tooltip_show' ] === 'yes' ); ?>"
							}
						},
						yaxis: {
							opposite: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_position' ] ); ?>',
							tickAmount: parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_tick_amount' ] ); ?>"),
							decimalsInFloat: parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_decimals_in_float' ] ); ?>"),
							labels: {
								show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_show' ] === 'yes' ); ?>',
								rotate: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_rotate' ] ); ?>')  || 0,
								offsetX: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_offset_x' ] ); ?>')  || 0,
								offsetY: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_offset_y' ] ); ?>')  || 0,
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
							}
						},
						tooltip: {
							theme: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip_theme' ] ); ?>',
							enabled: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip' ] === 'yes' ); ?>',
							x: {
								format: "dd/MM/yy"
							},
							style: {
								fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
								fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>'
							}
						},
						markers: {
							strokeWidth: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_stroke_width' ] ); ?>'),
							strokeColors: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_stroke_color' ] ); ?>'
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

					if ("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_number_format' ] ) === 'yes'; ?>") {
						bubbleOptions.yaxis.labels.formatter = function (val) {
							const enableNumberFormatting = '<?php echo esc_js( $enable_number_formatting ); ?>';
							const locale = '<?php echo esc_js( $locale ); ?>';

							const yLabelShow = '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_label_show' ] ) && $settings[ 'iq_' . $type . '_chart_yaxis_label_show' ] === 'yes' ); ?>';
							const yLabelPrefix = '<?php echo esc_js( $y_label_prefix ); ?>';
							const yLabelPostfix = '<?php echo esc_js( $y_label_postfix ); ?>';
							if (enableNumberFormatting) {
								const numberFormatter = new Intl.NumberFormat(locale, {
									style: 'decimal',
									minimumFractionDigits: 0,
									maximumFractionDigits: 2,
									useGrouping: true,
								});
								val = numberFormatter.format(val);
							}

							if (yLabelShow) {
								val = yLabelPrefix + val + yLabelPostfix;
							}

							return val;
						};
					}
					if ("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_label_show' ] ) === 'yes'; ?>" ) {
						bubbleOptions.yaxis.labels.formatter = function (val) {
							if("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_format_number' ] ) === 'yes'; ?>" ){
								val = graphinNumberWithCommas(val,'<?php echo esc_js( $local_string_type ); ?>')
							}
							else if("<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_label_pointer' ] ) && $settings[ 'iq_' . $type . '_chart_yaxis_label_pointer' ] === 'yes' ); ?>"
								&&  typeof graphinaAbbrNum  !== "undefined"){
								val = graphinaAbbrNum(val ,  parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_label_pointer_number' ] ); ?>") || 0 );
							}
							return '<?php echo esc_js( $y_label_prefix ); ?>' + val + '<?php echo esc_js( $y_label_postfix ); ?>';
						}
					}
					if ("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_0_indicator_show' ] ) === 'yes'; ?>" ) {
						bubbleOptions['annotations'] = {
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
						let xaxisYoffset ='<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_position' ] ); ?>' === 'top' ? -95 : 0;
						if(typeof axisTitle !== "undefined"){
							axisTitle(bubbleOptions, 'xaxis' ,title, style,xaxisYoffset );
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
							axisTitle(bubbleOptions, 'yaxis' ,title, style );
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
						bubbleOptions['yaxis'] = [bubbleOptions.yaxis]
						bubbleOptions.yaxis.push({
							opposite: '<?php echo ! esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_position' ] === 'yes' ); ?>',
							labels: {
								show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_opposite_yaxis_label_show' ] === 'yes' ); ?>',
								formatter: function (val) {
									if("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_opposite_yaxis_format_number' ] === 'yes' ); ?>" ){
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
						})
					}

					if (typeof initNowGraphina !== "undefined") {
						initNowGraphina(
							myElement,
							{
								ele: document.querySelector(".bubble-chart-<?php echo esc_js( $main_id ); ?>"),
								options: bubbleOptions,
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

Plugin::instance()->widgets_manager->register( new Bubble_Chart() );
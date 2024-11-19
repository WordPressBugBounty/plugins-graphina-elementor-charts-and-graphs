<?php
/**
 * Apex radar chart elementor widget class.
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
 * Elementor radar chart widget.
 *
 * Elementor widget that displays an eye-catching radar chart.
 */
class Radar_Chart extends Widget_Base {


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
		return 'radar_chart';
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
		return 'Radar';
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
		return 'graphina-apex-radar-chart';
	}

	/**
	 * Get widget type.
	 *
	 * @return string Widget ty[e.
	 *
	 * @access public
	 */
	public function get_chart_type(): string {
		return 'radar';
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
				'label' => esc_html__( 'Chart Setting', 'graphina-charts-for-elementor' ),
			)
		);

		graphina_common_chart_setting( $this, $type, false );

		graphina_tooltip( $this, $type, true, false );

		graphina_animation( $this, $type );

		graphina_plot_setting( $this, $type );

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
				'description' => esc_html__( 'Note: For multiline text seperate Text by comma(,) ', 'graphina-charts-for-elementor' ),
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

		$this->start_controls_section(
			'iq_' . $type . '_section_5',
			array(
				'label' => esc_html__( 'Advance X-Axis Setting', 'graphina-charts-for-elementor' ),

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

		$this->end_controls_section();

		$this->start_controls_section(
			'iq_' . $type . '_section_6',
			array(
				'label' => esc_html__( 'Advance Y-Axis Setting', 'graphina-charts-for-elementor' ),
			)
		);

		graphina_yaxis_min_max_setting( $this, $type );

		$this->add_control(
			'iq_' . $type . '_chart_yaxis_datalabel_show',
			array(
				'label'     => esc_html__( 'Labels', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_yaxis_datalabel_tick_amount',
			array(
				'label'     => esc_html__( ' Tick Amount', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 6,
				'max'       => 30,
				'min'       => 0,
				'condition' => array(
					'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
					'iq_' . $type . '_chart_yaxis_enable_min_max' => 'yes',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_yaxis_datalabel_format',
			array(
				'label'     => esc_html__( 'Format', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'no',
			)
		);

		$this->add_control(
			'iq_' . $type . '_yaxis_chart_number_format_commas',
			array(
				'label'     => esc_html__( 'Format Number(Commas)', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'no',
				'condition' => array(
					'iq_' . $type . '_chart_yaxis_datalabel_format' => 'yes',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_yaxis_format_prefix',
			array(
				'label'     => esc_html__( 'Label Prefix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'iq_' . $type . '_chart_yaxis_datalabel_format' => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_yaxis_format_postfix',
			array(
				'label'     => esc_html__( 'Label Postfix', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'iq_' . $type . '_chart_yaxis_datalabel_format' => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_yaxis_prefix_postfix_decimal_point',
			array(
				'label'     => esc_html__( 'Decimals In Float', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'max'       => 6,
				'min'       => 0,
				'condition' => array(
					'iq_' . $type . '_chart_yaxis_datalabel_format' => 'yes',
					'iq_' . $type . '_chart_yaxis_datalabel_show' => 'yes',
					'iq_' . $type . '_chart_yaxis_label_pointer!' => 'yes',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_yaxis_label_pointer',
			array(
				'label'       => esc_html__( 'Format Number to String s', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition'   => array(
					'iq_' . $type . '_chart_yaxis_datalabel_format' => 'yes',
				),
				'label_on'    => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off'   => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'     => false,
				'description' => esc_html__( 'Note: Convert 1,000  => 1k and 1,000,000 => 1m', 'graphina-charts-for-elementor' ),
			)
		);
	
		$this->add_control(
			'iq_' . $type . '_chart_yaxis_label_pointer_number',
			array(
				'label'     => esc_html__( 'Number of Decimal Want', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 0,
				'condition' => array(
					'iq_' . $type . '_chart_yaxis_label_pointer' => 'yes',
					'iq_' . $type . '_chart_yaxis_datalabel_format' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		graphina_series_setting( $this, $type, array( 'color' ), true, array( 'classic', 'gradient', 'pattern' ), true, true );

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
					),
					'title_field' => '{{{ iq_' . $type . '_chart_value_3_' . $i . ' }}}',
				)
			);

			$this->end_controls_section();
		}

		graphina_style_section( $this, $type );

		graphina_card_style( $this, $type );

		graphina_chart_style( $this, $type );

		$this->start_controls_section(
            'iq_' . $type . '_chart_font_style_section',
            [
                'label'=>esc_html__('Chart Font Size','graphina-charts-for-elementor'),
                'tab'=>Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'iq_' . $type . '_chart_font_size_responsive',
            [
                'label' => esc_html__('Font Size', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => 0.1,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 12,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 14,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 12,
                ],
            ]
        );
        $this->add_responsive_control(
            'iq_' . $type . '_chart_legend_font_size_responsive',
            [
                'label' => esc_html__('Legend font size', 'graphina-charts-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => 0.1,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 12,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 14,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 12,
                ],
            ]
        );
        $this->end_controls_section();

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

		$main_id             = graphina_widget_id( $this );
		$marker_size         = array();
		$marker_stroke_color = array();
		$marker_stoke_width  = array();
		$marker_shape        = array();
		$gradient            = array();
		$second_gradient     = array();
		$fill_pattern        = array();
		$xaxis_font_color    = array();
		$data                = array(
			'series'   => array(),
			'category' => array(),
		);
		$call_ajax           = false;
		$loading_text        = esc_html( isset( $settings[ 'iq_' . $type . '_chart_no_data_text' ] ) ? $settings[ 'iq_' . $type . '_chart_no_data_text' ] : '' );
		$data_label_prefix   = '';
		$data_label_postfix  = '';
		$export_file_name = (
			! empty( $settings[ 'iq_' . $type . '_can_chart_show_toolbar' ] ) && $settings[ 'iq_' . $type . '_can_chart_show_toolbar' ] === 'yes'
			&& ! empty( $settings[ 'iq_' . $type . '_export_filename' ] )
		) ? $settings[ 'iq_' . $type . '_export_filename' ] : $main_id;

		if ( $settings[ 'iq_' . $type . '_chart_datalabel_show' ] === 'yes' ) {
			$data_label_prefix  = $settings[ 'iq_' . $type . '_chart_datalabel_prefix' ];
			$data_label_postfix = $settings[ 'iq_' . $type . '_chart_datalabel_postfix' ];
		}
		$series_count = isset( $settings[ 'iq_' . $type . '_chart_data_series_count' ] ) ? $settings[ 'iq_' . $type . '_chart_data_series_count' ] : 0;
		for ( $i = 0; $i < $series_count; $i++ ) {
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
			$marker_size[]         = (float) esc_html( $settings[ 'iq_' . $type . '_chart_marker_size_' . $i ] );
			$marker_stroke_color[] = esc_html( $settings[ 'iq_' . $type . '_chart_marker_stroke_color_' . $i ] );
			$marker_stoke_width[]  = (float) esc_html( $settings[ 'iq_' . $type . '_chart_marker_stroke_width_' . $i ] );
			$marker_shape[]        = esc_html( $settings[ 'iq_' . $type . '_chart_chart_marker_stroke_shape_' . $i ] );
		}
		if ( graphina_pro_active() && $settings[ 'iq_' . $type . '_chart_data_option' ] !== 'manual' ) {
			$call_ajax       = true;
			$gradient        = array( '#ffffff' );
			$second_gradient = array( '#ffffff' );
			$loading_text    = esc_html__( 'Loading...', 'graphina-charts-for-elementor' );
		} else {
			$category_list = $settings[ 'iq_' . $type . '_category_list' ];
			if ( gettype( $category_list ) === 'NULL' ) {
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
			$gradient_new         = array();
			$second_gradient_new  = array();
			$fill_pattern_new     = array();
			$xaxis_font_color_new = array();
			$desired_length       = count( $data['series'] );
			$length               = 0;
			while ( $length < $desired_length ) {
				$gradient_new        = array_merge( $gradient_new, $gradient );
				$second_gradient_new = array_merge( $second_gradient_new, $second_gradient );
				$fill_pattern_new    = array_merge( $fill_pattern_new, $fill_pattern );
				$length              = count( $gradient_new );
			}
			$xaxis_font_color_new_length = 0;
			$category_length             = count( $data['category'] );
			while ( $xaxis_font_color_new_length <= $category_length ) {
				$xaxis_font_color_new        = array_merge( $xaxis_font_color_new, array( strval( $settings[ 'iq_' . $type . '_chart_font_color' ] ) ) );
				$xaxis_font_color_new_length = count( $xaxis_font_color_new );
			}

			$gradient         = array_slice( $gradient_new, 0, $desired_length );
			$second_gradient  = array_slice( $second_gradient_new, 0, $desired_length );
			$fill_pattern     = array_slice( $fill_pattern_new, 0, $desired_length );
			$xaxis_font_color = array_slice( $xaxis_font_color_new, 0, count( $data['category'] ) );
		}

		$marker_size         = implode( '_,_', $marker_size );
		$marker_stroke_color = implode( '_,_', $marker_stroke_color );
		$marker_stoke_width  = implode( '_,_', $marker_stoke_width );
		$marker_shape        = implode( '_,_', $marker_shape );
		$gradient            = implode( '_,_', $gradient );
		$second_gradient     = implode( '_,_', $second_gradient );
		$fill_pattern        = implode( '_,_', $fill_pattern );
		$xaxis_font_color    = implode( '_,_', $xaxis_font_color );
		$category            = implode( '_,_', $data['category'] );

		$local_string_type        = graphina_common_setting_get( 'thousand_seperator' );
		graphina_chart_widget_content( $this, $main_id, $settings );
		if ( graphina_restricted_access( 'radar', $main_id, $settings, false ) === false ) {
			?>
			<script>
				( function (){
					if (typeof isInit === 'undefined') {
						var isInit = {};
					}
					isInit['<?php echo esc_js( $main_id ); ?>'] = false;


					const myElement = document.querySelector(".radar-chart-<?php echo esc_js( $main_id ); ?>");
					const radarOptions = {
						series: <?php echo wp_json_encode( $data['series'] ); ?>,
						chart: {
							background: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_background_color1' ] ); ?>',
							height: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_height' ] ); ?>'),
							type: 'radar',
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
								speed: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_animation_speed' ] ); ?>'),
								delay: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_animation_delay' ] ); ?>'
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
								colors: ['<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_datalabel_background_show' ] === 'yes' ? $settings[ 'iq_' . $type . '_chart_datalabel_font_color_1' ] : $settings[ 'iq_' . $type . '_chart_datalabel_font_color' ] ); ?>']
							},
							background: {
								enabled: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_datalabel_background_show' ] === 'yes' ); ?>',
								borderRadius:parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_border_radius' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_border_radius' ] : 0 ); ?>'),
								foreColor: ['<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_datalabel_background_color' ] ); ?>'],
								borderWidth: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_datalabel_border_width' ] ); ?>'),
								borderColor: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_datalabel_border_color' ] ); ?>'
							},
							formatter: function (val) {
								if(isNaN(val)){
									return '';
								}
								if("<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_number_format_commas' ] ) && esc_html( $settings[ 'iq_' . $type . '_chart_number_format_commas' ] ) === 'yes' ); ?>" ){
									val = graphinNumberWithCommas(val,'<?php echo esc_js( $local_string_type ); ?>')
								}
								else if("<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_label_pointer_for_label' ] ) && esc_html( $settings[ 'iq_' . $type . '_chart_label_pointer_for_label' ] ) === 'yes' ); ?>"
									&&  typeof graphinaAbbrNum  !== "undefined"){
									val = graphinaAbbrNum(val ,  parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_label_pointer_number_for_label' ] ); ?>") || 0 );
								}
								return '<?php echo esc_js( $data_label_prefix ); ?>' + val + '<?php echo esc_js( $data_label_postfix ); ?>';
							},
							offsetY: parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_offsety' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_offsety' ] : 0 ); ?>'),
							offsetX: parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_datalabel_offsetx' ] ) ? $settings[ 'iq_' . $type . '_chart_datalabel_offsetx' ] : 0 ); ?>'),
						},
						plotOptions: {
							radar: {
								polygons: {
									strokeColors: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_plot_stroke_color' ] ); ?>',
									connectorColors: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_plot_stroke_color' ] ); ?>',
									fill: {
										colors: ['<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_plot_color' ] ); ?>']
									}
								}
							}
						},
						stroke: {
							width: parseFloat('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_stroke_size' ] ); ?>')
						},
						colors: '<?php echo esc_js( $gradient ); ?>'.split('_,_'),
						xaxis: {
							categories: '<?php echo ( $category ); ?>'.split('_,_'),
							labels: {
								show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_datalabel_show' ] === 'yes' ); ?>',
								trim: true,
								style: {
									colors: '<?php echo esc_js( $xaxis_font_color ); ?>'.split('_,_'),
									fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
									fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
									fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>'
								},
								formatter: function (val) {
									if(val){
										val = val.split(',')
									}
									return val
								}
							}
						},
						yaxis: {
							show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_show' ] === 'yes' ); ?>',
							labels: {
								style: {
									colors: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_color' ] ); ?>',
									fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
									fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
									fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>'
								}
							}
						},
						fill: {
							type: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_fill_style_type' ] ); ?>',
							opacity: parseFloat('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_fill_opacity' ] ); ?>'),
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
						tooltip: {
							enabled: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip' ] ); ?>',
							theme: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip_theme' ] ); ?>',
							style: {
								fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
								fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>'
							}
						},
						legend: {
							showForSingleSeries:true,
							show: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_legend_show' ] ); ?>',
							position: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_legend_position' ] ) ? $settings[ 'iq_' . $type . '_chart_legend_position' ] : 'bottom' ); ?>',
							horizontalAlign: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_legend_horizontal_align' ] ) ? $settings[ 'iq_' . $type . '_chart_legend_horizontal_align' ] : 'center' ); ?>',
							fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_size' ]['size'] . $settings[ 'iq_' . $type . '_chart_font_size' ]['unit'] ); ?>',
							fontFamily: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_family' ] ); ?>',
							fontWeight: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_weight' ] ); ?>',
							labels: {
								colors: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_font_color' ] ); ?>'
							}
						},
						responsive: [
							{
								breakpoint: 1024,
								options: {
									chart: {
										height: parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_height_tablet']) ? $settings['iq_' . $type . '_chart_height_tablet'] : $settings['iq_' . $type . '_chart_height'] ; ?>')
									},
									xaxis: {
											labels: {
												style: {
													colors: '<?php echo $xaxisFontColor; ?>'.split('_,_'),
													fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size_responsive_tablet']['size'] . $settings['iq_' . $type . '_chart_font_size_responsive_tablet']['unit']; ?>',
												}
											}
										},
										yaxis: {
											labels: {
												style: {
													colors: '<?php echo strval($settings['iq_' . $type . '_chart_font_color']); ?>',
													fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size_responsive_tablet']['size'] . $settings['iq_' . $type . '_chart_font_size_responsive_tablet']['unit']; ?>',
												}
											}
										},
										tooltip: {
											style: {
												fontSize: '<?php echo $settings['iq_' . $type . '_chart_tooltip_font_size_responsive_tablet']['size'] . $settings['iq_' . $type . '_chart_tooltip_font_size_responsive_tablet']['unit']; ?>',
											}
										},
										legend: {
											fontSize: '<?php echo $settings['iq_' . $type . '_chart_legend_font_size_responsive_tablet']['size'] . $settings['iq_' . $type . '_chart_legend_font_size_responsive_tablet']['unit']; ?>',
											labels: {
												colors: '<?php echo strval($settings['iq_' . $type . '_chart_font_color']); ?>'
											}
										}
								}
							},
							{
								breakpoint: 674,
								options: {
									chart: {
										height: parseInt('<?php echo !empty($settings['iq_' . $type . '_chart_height_mobile']) ? $settings['iq_' . $type . '_chart_height_mobile'] : $settings['iq_' . $type . '_chart_height'] ;  ?>')
									},
									xaxis: {
										labels: {
											style: {
												colors: '<?php echo $xaxisFontColor; ?>'.split('_,_'),
												fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size_responsive_mobile']['size'] . $settings['iq_' . $type . '_chart_font_size_responsive_mobile']['unit']; ?>',
											}
										}
									},
									yaxis: {
										labels: {
											style: {
												colors: '<?php echo strval($settings['iq_' . $type . '_chart_font_color']); ?>',
												fontSize: '<?php echo $settings['iq_' . $type . '_chart_font_size_responsive_mobile']['size'] . $settings['iq_' . $type . '_chart_font_size_responsive_mobile']['unit']; ?>',
											}
										}
									},
									tooltip: {
										style: {
											fontSize: '<?php echo $settings['iq_' . $type . '_chart_tooltip_font_size_responsive_mobile']['size'] . $settings['iq_' . $type . '_chart_tooltip_font_size_responsive_mobile']['unit']; ?>',
										}
									},
									legend: {
										fontSize: '<?php echo $settings['iq_' . $type . '_chart_legend_font_size_responsive_mobile']['size'] . $settings['iq_' . $type . '_chart_legend_font_size_responsive_mobile']['unit']; ?>',
										labels: {
											colors: '<?php echo strval($settings['iq_' . $type . '_chart_font_color']); ?>'
										}
									}
								}
							}
						]
					};

					radarOptions['markers'] ={
						size: '<?php echo esc_js( $marker_size ); ?>'.split('_,_'),
						strokeColors: '<?php echo esc_js( $marker_stroke_color ); ?>'.split('_,_'),
						strokeWidth: '<?php echo esc_js( $marker_stoke_width ); ?>'.split('_,_'),
						shape: '<?php echo esc_js( $marker_shape ); ?>'.split('_,_'),
						showNullDataPoints: true,
						hover: {
							size: 3,
							sizeOffset: 1
						}
					};

					if("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_format' ] === 'yes' ); ?>"){
						radarOptions.yaxis.labels.formatter = function (val){
							let decimal = parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_prefix_postfix_decimal_point' ] ) ? $settings[ 'iq_' . $type . '_chart_yaxis_prefix_postfix_decimal_point' ] : 0 ); ?>') || 0;
							if("<?php echo esc_js( $settings[ 'iq_' . $type . '_yaxis_chart_number_format_commas' ] ) === 'yes'; ?>" ){
								val = graphinNumberWithCommas(val,'<?php echo esc_js( $local_string_type ); ?>',decimal)
							}
							else if("<?php esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_label_pointer' ] ) && $settings[ 'iq_' . $type . '_chart_yaxis_label_pointer' ] === 'yes' ); ?>"
								&&  typeof graphinaAbbrNum  !== "undefined"){
								val = graphinaAbbrNum(val ,  parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_label_pointer_number' ] ); ?>") || 0 );
							}else{
								val = parseFloat(val).toFixed(decimal)
							}
							return '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_format_prefix' ] ) ? $settings[ 'iq_' . $type . '_chart_yaxis_format_prefix' ] : '' ); ?>' + val + '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_format_postfix' ] ) ? $settings[ 'iq_' . $type . '_chart_yaxis_format_postfix' ] : '' ); ?>';
						}
					}

					if('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_enable_min_max' ] ) && $settings[ 'iq_' . $type . '_chart_yaxis_enable_min_max' ] === 'yes' ); ?>'){
						radarOptions.yaxis.tickAmount = parseInt("<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_datalabel_tick_amount' ] ); ?>") || 6;
						radarOptions.yaxis.min = parseFloat('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_min_value' ] ) ? $settings[ 'iq_' . $type . '_chart_yaxis_min_value' ] : 0 ); ?>') || 0;
						radarOptions.yaxis.max = parseFloat('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_yaxis_max_value' ] ) ? $settings[ 'iq_' . $type . '_chart_yaxis_max_value' ] : 0 ); ?>') || 200;
					}

					if (typeof initNowGraphina !== "undefined") {
						initNowGraphina(
							myElement,
							{
								ele: document.querySelector(".radar-chart-<?php echo esc_js( $main_id ); ?>"),
								options: radarOptions,
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

Plugin::instance()->widgets_manager->register( new Radar_Chart() );

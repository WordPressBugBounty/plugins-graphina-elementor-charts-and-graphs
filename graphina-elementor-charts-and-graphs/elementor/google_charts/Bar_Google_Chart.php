<?php
/**
 * Google bars chart elementor widget class.
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina_Charts_For_Elementor
 */

namespace google_charts;

use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Elementor google area chart widget.
 *
 * Elementor widget that displays an eye-catching google bar chart.
 */
class Bar_Google_Chart extends Widget_Base {



	/**
	 * Class constructor.
	 *
	 * @param array      $data Widget data. Default is an empty array.
	 * @param array|null $args Optional. Widget default arguments. Default is null.
	 * @throws Exception If arguments are missing when initializing a full widget
	 *                    instance.
	 */
	public function __construct( $data = array(), $args = null ) {
		wp_register_script( 'googlecharts-min', GRAPHINA_URL . '/elementor/js/gstatic/loader.js', array(), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, true );
		parent::__construct( $data, $args );
	}

	/**
	 * Enqueue scripts.
	 *
	 * Registers all the scripts defined as element dependencies and enqueues
	 *
	 * @return array
	 */
	public function get_script_depends(): array {
		return array(
			'googlecharts-min',
		);
	}

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name(): string {
		return 'bar_google_chart';
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
		return 'Bar';
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
		return array( 'iq-graphina-google-charts' );
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
		return 'graphina-google-bar-chart';
	}

	/**
	 * Get widget type.
	 *
	 * @return string Widget ty[e.
	 *
	 * @access public
	 */
	public function get_chart_type(): string {
		return 'bar_google';
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

		$this->add_control(
			'iq_' . $type . '_google_chart_title_heading',
			array(
				'label' => esc_html__( 'Chart Title Settings', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'iq_' . $type . '_google_chart_title_show',
			array(
				'label'     => esc_html__( 'Chart Title Show', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'no',
			)
		);

		$this->add_control(
			'iq_' . $type . '_google_chart_title',
			array(
				'label'       => esc_html__( 'Chart Title', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
				'default'     => esc_html__( 'Chart Title', 'graphina-charts-for-elementor' ),
				'condition'   => array(
					'iq_' . $type . '_google_chart_title_show' => 'yes',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_google_chart_title_position',
			array(
				'label'     => esc_html__( 'Position', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'in'  => esc_html__( 'In', 'graphina-charts-for-elementor' ),
					'out' => esc_html__( 'Out', 'graphina-charts-for-elementor' ),
				),
				'default'   => 'out',
				'condition' => array(
					'iq_' . $type . '_google_chart_title_show' => 'yes',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_google_chart_title_color',
			array(
				'label'     => esc_html__( 'Title Font Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'condition' => array(
					'iq_' . $type . '_google_chart_title_show' => 'yes',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_google_chart_title_font_size',
			array(
				'label'     => esc_html__( 'Title Font Size', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 20,
				'condition' => array(
					'iq_' . $type . '_google_chart_title_show' => 'yes',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_title_setting',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		graphina_common_chart_setting( $this, $type, false );

		graphina_tooltip( $this, $type );

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
				'label'       => esc_html__( 'Category Value', 'graphina-charts-for-elementor' ),
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

		graphina_advance_legend_setting( $this, $type );

		graphina_advance_h_axis_setting( $this, $type );

		graphina_advance_v_axis_setting( $this, $type );

		graphina_google_series_setting( $this, $type, array( 'tooltip', 'color' ) );

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
	}

	/**
	 * Render element.
	 *
	 * Generates the final HTML on the frontend.
	 *
	 * @return void
	 */
	protected function render(): void {
		$main_id             = graphina_widget_id( $this );
		$type                = $this->get_chart_type();
		$settings            = $this->get_settings_for_display();
		$ajax_settings       = graphina_ajax_settings( $settings, $type );
		$bar_data            = array();
		$element_colors      = array();
		$element_title_array = array();
		$category_count      = 0;
		$legend_position     = $settings[ 'iq_' . $type . '_google_chart_legend_show' ] === 'yes' ? $settings[ 'iq_' . $type . '_google_chart_legend_position' ] : 'none';

		if ( $settings[ 'iq_' . $type . '_chart_data_option' ] === 'manual' ) {
			$category_count = count( $settings[ 'iq_' . $type . '_category_list' ] );
			$xaxis_prefix   = '';
			$xaxis_postfix  = '';
			if ( ! empty( $settings[ 'iq_' . $type . '_chart_haxis_label_prefix_postfix' ] ) ) {
				$xaxis_prefix  = $settings[ 'iq_' . $type . '_chart_haxis_label_prefix' ];
				$xaxis_postfix = $settings[ 'iq_' . $type . '_chart_haxis_label_postfix' ];
			}
			foreach ( $settings[ 'iq_' . $type . '_category_list' ] as $key => $value ) {
				$bar_data[ $key ][] = esc_html( $xaxis_prefix . $value[ 'iq_' . $type . '_chart_category' ] . $xaxis_postfix );
			}
		}

		$annotation_prefix  = '';
		$annotation_postfix = '';
		if ( $settings[ 'iq_' . $type . '_chart_annotation_show' ] === 'yes' && ! empty( $settings[ 'iq_' . $type . '_chart_annotation_prefix_postfix' ] ) ) {
			$annotation_prefix  = $settings[ 'iq_' . $type . '_chart_annotation_prefix' ];
			$annotation_postfix = $settings[ 'iq_' . $type . '_chart_annotation_postfix' ];
		}

		for ( $j = 0; $j < $settings[ 'iq_' . $type . '_chart_data_series_count' ]; $j++ ) {
			$value_list            = $settings[ 'iq_' . $type . '_value_list_3_' . ( $settings[ 'iq_' . $type . '_can_chart_negative_values' ] === 'yes' ? 2 : 1 ) . '_' . $j ];
			$element_colors[]      = esc_html( $settings[ 'iq_' . $type . '_chart_element_color_' . $j ] );
			$element_title_array[] = esc_html( $settings[ 'iq_' . $type . '_chart_title_3_' . $j ] );
			if ( $settings[ 'iq_' . $type . '_chart_data_option' ] === 'manual' ) {
				if ( ! empty( $value_list ) && count( $value_list ) > 0 ) {
					foreach ( $value_list as $key => $value ) {
						if ( $key >= $category_count ) {
							break;
						}
						if ( ! empty( $value[ 'iq_' . $type . '_chart_value_3_' . $j ] ) && is_numeric( $value[ 'iq_' . $type . '_chart_value_3_' . $j ] ) && floor( $value[ 'iq_' . $type . '_chart_value_3_' . $j ] ) === $value[ 'iq_' . $type . '_chart_value_3_' . $j ] ) {
							$numeric_val = (int) $value[ 'iq_' . $type . '_chart_value_3_' . $j ];
						} elseif ( ! empty( $value[ 'iq_' . $type . '_chart_value_3_' . $j ] ) && filter_var( $value[ 'iq_' . $type . '_chart_value_3_' . $j ], FILTER_VALIDATE_FLOAT ) !== false ) {
							$numeric_val = (float) $value[ 'iq_' . $type . '_chart_value_3_' . $j ];
						} else {
							$numeric_val = (int) $value[ 'iq_' . $type . '_chart_value_3_' . $j ];
						}

						$value_data         = ! empty( $value[ 'iq_' . $type . '_chart_value_3_' . $j ] ) ? $numeric_val : graphina_generate_random_number( 0, 200 );
						$bar_data[ $key ][] = $value_data;
						if ( $settings[ 'iq_' . $type . '_chart_annotation_show' ] === 'yes' ) {
							$bar_data[ $key ][] = esc_html( $annotation_prefix . $value_data . $annotation_postfix );
						}
					}
				}
			}
		}
		foreach ( $bar_data as &$data ) {
			$data_count = count( $data );
			for ( $i = 1; $i < $data_count; $i += 2 ) {
				if ( $data[ $i ] === '' ) {
					$data[ $i ] = 0;
				}
			}
		}

		$element_title_array = implode( '_,_', $element_title_array );
		$element_colors      = implode( '_,_', $element_colors );

		graphina_chart_widget_content( $this, $main_id, $settings );
		if ( graphina_restricted_access( $type, $main_id, $settings, false ) === false ) {
			?>
		<script type="text/javascript">

			(function() {
				'use strict';
				function renderGoogleBarChart(){
					if (typeof isInit === 'undefined') {
						var isInit = {};
					}
					isInit['<?php echo esc_js( $main_id ); ?>'] = false;
					google.charts.load('current', {packages: ['corechart', 'bar']});
					google.charts.setOnLoadCallback(drawBarColors);
				}
				if(parent.document.querySelector('.elementor-editor-active') !== null){
					renderGoogleBarChart();
				}
				document.addEventListener('readystatechange', event => {
					// When window loaded ( external resources are loaded too- `css`,`src`, etc...)
					if (event.target.readyState === "complete") {
						renderGoogleBarChart();
					}
				})

				function drawBarColors() {


					let chartArea = { left: '10%', right: '5%' }
					if( '<?php echo esc_js( $legend_position ); ?>' === 'left' ){
						chartArea = { left: '25%', right: '10%' }
					}else if( '<?php echo esc_js( $legend_position ); ?>' === 'right' ){
						chartArea = { left: '10%', right: '25%' }
					}


					const data = new google.visualization.DataTable();
					data.addColumn('string', '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_haxis_title' ] ); ?>');

					'<?php echo esc_js( $element_title_array ); ?>'.split('_,_').map((value)=>{
						data.addColumn('number', value);
						if('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_annotation_show' ] === 'yes' ); ?>'){
							data.addColumn( { role: 'annotation' });
						}
					})

					data.addRows(<?php echo wp_json_encode( $bar_data ); ?>);

					var options = {
						title: '<?php echo esc_js( $settings[ 'iq_' . $type . '_google_chart_title' ] ); ?>',
						titlePosition: '<?php echo esc_js( $settings[ 'iq_' . $type . '_google_chart_title_show' ] === 'yes' ? $settings[ 'iq_' . $type . '_google_chart_title_position' ] : 'none' ); ?>', // in, out, none
						titleTextStyle: {
							color: '<?php echo esc_js( $settings[ 'iq_' . $type . '_google_chart_title_color' ] ); ?>',
							fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_google_chart_title_font_size' ] ); ?>',
						},
						chartArea: chartArea,
						bar: {
							groupWidth: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_element_width' ] ); ?>'),
						},
						isStacked:'<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_stack_type' ] ); ?>',
						height: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_height' ] ); ?>'),
						series: { targetAxisIndex: 1 },
						annotations: {
							stemColor: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_annotation_stemcolor' ] ); ?>',
							textStyle: {
								fontSize: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_annotation_fontsize' ] ); ?>'),
								color: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_annotation_color' ] ); ?>',
								auraColor: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_annotation_color2' ] ); ?>',
								opacity: parseFloat('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_annotation_opacity' ] ); ?>'),
							}
						},
						tooltip: {
							showColorCode: true,
							textStyle: {color:'<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip_color' ] ); ?>',},
							trigger: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip_show' ] === 'yes' ? $settings[ 'iq_' . $type . '_chart_tooltip_trigger' ] : 'none' ); ?>',
						},
						animation:{
							startup: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_animation_show' ] === 'yes' ); ?>',
							duration: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_animation_speed' ] ); ?>'),
							easing: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_animation_easing' ] ); ?>',
						},
						backgroundColor: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_background_color1' ] ); ?>',
						hAxis: {
							viewWindowMode:'explicit',
							viewWindow:{
								max:parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_vaxis_maxvalue' ] ); ?>'),
								min: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_vaxis_minvalue' ] ); ?>'),
							},
							slantedText:'<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_rotate' ] === 'yes' ); ?>',
							slantedTextAngle:parseFloat('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_rotate_value' ] ); ?>'),
							direction: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_haxis_direction' ] === 'yes' ? -1 : 1 ); ?>'),
							title: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_haxis_title' ] ); ?>',
							titleTextStyle: {
								color: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_haxis_title_font_color' ] ); ?>',
								fontSize: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_haxis_title_font_size' ] ); ?>'),
							},
							textStyle: {
								color: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_label_font_color' ] ); ?>',
								fontSize: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_xaxis_label_font_size' ] ); ?>'),
							},
							textPosition: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_haxis_label_position_show' ] === 'yes' ? $settings[ 'iq_' . $type . '_chart_haxis_label_position' ] : 'none' ); ?>', // in, out, none
							format:'<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_vaxis_format' ] ); ?>',
							baselineColor: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_baseline_Color' ] ); ?>',
							gridlines:{
								color: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_gridline_color' ] ); ?>',
								count: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_gridline_count' ] ); ?>'),
							},
							scaleType:'<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_vaxis_scaletype' ] ); ?>',

						},
						vAxis: {
							direction:parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_vaxis_direction' ] === 'yes' ? -1 : 1 ); ?>'),
							title: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_vaxis_title' ] ); ?>',
							minValue: 0,
							format:'<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_vaxis_format' ] === '\#' ? ( $settings[ 'iq_' . $type . '_chart_vaxis_format_currency_prefix' ] . $settings[ 'iq_' . $type . '_chart_vaxis_format' ] ) : $settings[ 'iq_' . $type . '_chart_vaxis_format' ] ); ?>',
							titleTextStyle: {
								color: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_vaxis_title_font_color' ] ); ?>',
								fontSize: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_vaxis_title_font_size' ] ); ?>'),
							},
							textStyle: {
								color: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_label_font_color' ] ); ?>',
								fontSize: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_yaxis_label_font_size' ] ); ?>'),
							},
							textPosition: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_vaxis_label_position_show' ] === 'yes' ? $settings[ 'iq_' . $type . '_chart_vaxis_label_position' ] : 'none' ); ?>', // in, out, none
						},
						colors:  '<?php echo esc_js( $element_colors ); ?>'.split('_,_'),
						legend:{
							position: '<?php echo esc_js( $legend_position ); ?>', // Position others options:-  bottom,labeled,left,right,top,none
							textStyle: {
								fontSize: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_google_chart_legend_fontsize' ] ); ?>'),
								color: '<?php echo esc_js( $settings[ 'iq_' . $type . '_google_chart_legend_color' ] ); ?>',
							},
							alignment: '<?php echo esc_js( $settings[ 'iq_' . $type . '_google_chart_legend_horizontal_align' ] ); ?>', // start,center,end
						},
					};
					if (typeof graphinaGoogleChartInit !== "undefined") {
						graphinaGoogleChartInit(
							document.getElementById('bar_google_chart<?php echo esc_js( $main_id ); ?>'),
							{
								ele:document.getElementById('bar_google_chart<?php echo esc_js( $main_id ); ?>'),
								options: options,
								series: data,
								animation: true,
								renderType:'BarChart',
								setting_date:<?php echo Plugin::$instance->editor->is_edit_mode() ? wp_json_encode( $settings ) : wp_json_encode( $ajax_settings ); ?>
							},
							'<?php echo esc_js( $main_id ); ?>',
							'<?php echo esc_js( $this->get_chart_type() ); ?>',
						);
					}
					if (window['ajaxIntervalGraphina_' + '<?php echo esc_js( $main_id ); ?>'] !== undefined) {
						clearInterval(window['ajaxIntervalGraphina_' + '<?php echo esc_js( $main_id ); ?>']);
					}
					if('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_data_option' ] !== 'manual' ); ?>'){
						if('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_data_option' ] === 'forminator' || graphina_pro_active() ); ?>'){
							graphina_google_chart_ajax_reload(
								'<?php echo true; ?>',
								'<?php echo esc_js( $this->get_chart_type() ); ?>',
								'<?php echo esc_js( $main_id ); ?>',
								'<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_can_chart_reload_ajax' ] ) && $settings[ 'iq_' . $type . '_can_chart_reload_ajax' ] === 'yes' ? 'true' : 'false' ); ?>',
								parseInt('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_interval_data_refresh' ] ) ? $settings[ 'iq_' . $type . '_interval_data_refresh' ] : 5 ); ?>') || 5
							)
						}
					}
				}

			}).apply(this, [jQuery]);

		</script>
			<?php
		}
	}
}

Plugin::instance()->widgets_manager->register( new Bar_Google_Chart() );

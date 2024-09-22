<?php
/**
 * Google pie chart elementor widget class.
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina_Charts_For_Elementor
 */

namespace google_charts;

use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Widget_Base;
use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Elementor google area chart widget.
 *
 * Elementor widget that displays an eye-catching google pie chart.
 */
class Pie_Google_Chart extends Widget_Base {



	/**
	 * Class constructor.
	 *
	 * @param array      $data Widget data. Default is an empty array.
	 * @param array|null $args Optional. Widget default arguments. Default is null.
	 * @throws Exception If arguments are missing when initializing a full widget
	 *                    instance.
	 */
	public function __construct( $data = array(), $args = null ) {
		wp_register_script( 'googlecharts-min', plugin_dir_url( __FILE__ ) . 'js/gstatic/loader.js', array(), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, true );
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
		return 'pie_google_chart';
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
		return 'graphina-google-pie-chart';
	}

	/**
	 * Get widget type.
	 *
	 * @return string Widget ty[e.
	 *
	 * @access public
	 */
	public function get_chart_type(): string {
		return 'pie_google';
	}

	/**
	 * Register controller to elementor
	 *
	 * @return void
	 */
	protected function register_controls(): void {
		$type          = $this->get_chart_type();
		$colors        = graphina_colors();
		$default_label = array(
			'Jan',
			'Feb',
			'Mar',
			'Apr',
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
			'Sep2',
			'Oct2',
			'Nov2',
			'Dec2',
		);

		graphina_basic_setting( $this, $type );

		graphina_chart_data_option_setting( $this, $type, 0, true );

		/* Data Option: 'Manual' Start */
		$this->start_controls_section(
			'iq_' . $type . '_datalabel_sections',
			array(
				'label'     => esc_html__( 'Data Table Options', 'graphina-charts-for-elementor' ),
				'condition' => array(
					'iq_' . $type . '_chart_data_option' => 'manual',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_columnone_title',
			array(
				'label'       => esc_html__( 'Label Title', 'graphina-charts-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Month', 'graphina-charts-for-elementor' ),
				'description' => esc_html__( 'Data Values Title in DataTable', 'graphina-charts-for-elementor' ),
			)
		);

		$this->add_control(
			'iq_' . $type . '_columntwo_title',
			array(
				'label'       => esc_html__( 'Value Title', 'graphina-charts-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Sales', 'graphina-charts-for-elementor' ),
				'description' => esc_html__( 'Data Values Title in DataTable', 'graphina-charts-for-elementor' ),
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'iq_' . $type . '_section_2',
			array(
				'label' => esc_html__( 'Chart Setting', 'graphina-charts-for-elementor' ),
			)
		);
		$this->add_control(
			'iq_' . $type . '_chart_title_heading',
			array(
				'label' => esc_html__( 'Chart Title Settings', 'graphina-charts-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_title_show',
			array(
				'label'     => esc_html__( 'Chart Title Show', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'no',
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_title',
			array(
				'label'       => esc_html__( 'Chart Title', 'graphina-charts-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
				'default'     => esc_html__( 'Chart Title', 'graphina-charts-for-elementor' ),
				'condition'   => array(
					'iq_' . $type . '_chart_title_show' => 'yes',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_title_color',
			array(
				'label'     => esc_html__( 'Title Font Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'condition' => array(
					'iq_' . $type . '_chart_title_show' => 'yes',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_chart_title_font_size',
			array(
				'label'     => esc_html__( 'Title Font Size', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 20,
				'condition' => array(
					'iq_' . $type . '_chart_title_show' => 'yes',
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
		graphina_element_label( $this, $type );
		graphina_tooltip( $this, $type );

		$this->end_controls_section();

		graphina_advance_legend_setting( $this, $type );

		/* Manual Data options start */
		$max_series = graphina_default_setting( 'max_series_value' );
		for ( $i = 0; $i <= $max_series; $i++ ) {

			$this->start_controls_section(
				'iq_' . $type . '_section_series' . $i,
				array(
					'label'     => esc_html__( 'Element ', 'graphina-charts-for-elementor' ) . ( $i + 1 ),
					'default'   => wp_rand( 50, 200 ),
					'condition' => array(
						'iq_' . $type . '_chart_data_series_count' => range( $i + 1, graphina_default_setting( 'max_series_value' ) ),
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
					'condition'   => array(
						'iq_' . $type . '_chart_data_option' => 'manual',
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
					'condition'   => array(
						'iq_' . $type . '_chart_data_option' => 'manual',
					),
				)
			);

				$this->add_control(
					'iq_' . $type . '_chart_element_color_' . $i,
					array(
						'label'   => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
						'type'    => Controls_Manager::COLOR,
						'default' => $colors[ $i ],

					)
				);

			$this->end_controls_section();
		}
		/* Manual Data options End */

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

		$main_id         = graphina_widget_id( $this );
		$colors          = array();
		$pie_data        = array();
		$type            = $this->get_chart_type();
		$settings        = $this->get_settings_for_display();
		$ajax_settings   = graphina_ajax_settings( $settings, $type );
		$legend_position = $settings[ 'iq_' . $type . '_google_chart_legend_show' ] === 'yes' ? $settings[ 'iq_' . $type . '_google_piechart_legend_position' ] : 'none';
		for ( $i = 0; $i < $settings[ 'iq_' . $type . '_chart_data_series_count' ]; $i++ ) {
			$colors[] = esc_html( graphina_get_dynamic_tag_data( $settings, 'iq_' . $type . '_chart_element_color_' . $i ) );
			if ( $settings[ 'iq_' . $type . '_chart_data_option' ] === 'manual' ) {
				$pie_data[] = array(
					esc_html( $settings[ 'iq_' . $type . '_chart_label' . $i ] ),
					(float) $settings[ 'iq_' . $type . '_chart_value' . $i ],
				);
			}
		}

		$ele_colors = implode( '_,_', $colors );
		graphina_chart_widget_content( $this, $main_id, $settings );
		if ( graphina_restricted_access( $type, $main_id, $settings, false ) === false ) {
			?>
			<script type="text/javascript">

				(function () {
					function renderGooglePieChart(){
						if (typeof isInit === 'undefined') {
							var isInit = {};
						}
						isInit['<?php echo esc_js( $main_id ); ?>'] = false;
						google.charts.load('current', {'packages': ['corechart']});
						google.charts.setOnLoadCallback(drawChart);
					}
					'use strict';
					if (parent.document.querySelector('.elementor-editor-active') !== null) {
						renderGooglePieChart();
					}
					document.addEventListener('readystatechange', event => {
						// When window loaded ( external resources are loaded too- `css`,`src`, etc...)
						if (event.target.readyState === "complete") {
							renderGooglePieChart();
						}
					})

					function drawChart() {

						const data = new google.visualization.DataTable();
						data.addColumn('string', '<?php echo esc_js( $settings[ 'iq_' . $type . '_columnone_title' ] ); ?>');
						data.addColumn('number', '<?php echo esc_js( $settings[ 'iq_' . $type . '_columntwo_title' ] ); ?>');
						data.addRows(<?php echo wp_json_encode( $pie_data ); ?>);

						if ('<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_label_prefix_postfix' ] ) && $settings[ 'iq_' . $type . '_chart_label_prefix_postfix' ] === 'yes' ); ?>') {
							const formatter = new google.visualization.NumberFormat({
								prefix: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_label_prefix' ] ); ?>',
								suffix: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_label_postfix' ] ); ?>',
								fractionDigits: 0
							});
							formatter.format(data, 1);
						}
						/* Graph Options */
						var options = {
							title: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_title' ] ); ?>',
							titleTextStyle: {
								color: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_title_color' ] ); ?>',
								fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_title_font_size' ] ); ?>',
							},
							chartArea: '<?php echo esc_js( $legend_position ); ?>' === 'top' ? {
								top: '15%',
								width: '100%',
								height: '80%'
							} : {width: '100%', height: '80%'},
							height: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_height' ] ); ?>'),
							backgroundColor: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_background_color1' ] ); ?>',
							colors: '<?php echo esc_js( $ele_colors ); ?>'.split('_,_'),
							tooltip: {
								showColorCode: true,
								textStyle: {color: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip_color' ] ); ?>',},
								trigger: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip_show' ] === 'yes' ? $settings[ 'iq_' . $type . '_chart_tooltip_trigger' ] : 'none' ); ?>',
								text: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_tooltip_text' ] ); ?>',
							},
							legend: {
								position: '<?php echo esc_js( $legend_position ); ?>',
								labeledValueText: '<?php echo esc_js( $settings[ 'iq_' . $type . '_google_chart_legend_labeld_value' ] ); ?>',
								textStyle: {
									fontSize: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_google_chart_legend_fontsize' ] ); ?>'),
									color: '<?php echo esc_js( $settings[ 'iq_' . $type . '_google_chart_legend_color' ] ); ?>',
								},
								alignment: '<?php echo esc_js( $settings[ 'iq_' . $type . '_google_chart_legend_horizontal_align' ] ); ?>', // start,center,end
							},
							reverseCategories: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_label_reversecategory' ] === 'yes' ); ?>',
							pieSliceText: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_pieSliceText_show' ] === 'yes' ? $settings[ 'iq_' . $type . '_chart_pieSliceText' ] : 'none' ); ?>',
							sliceVisibilityThreshold: 0,
							pieSliceBorderColor: '<?php echo esc_js( ! empty( $settings[ 'iq_' . $type . '_chart_pieslice_bordercolor' ] ) ? strval( $settings[ 'iq_' . $type . '_chart_pieslice_bordercolor' ] ) : '#000000' ); ?>',
							pieSliceTextStyle: {
								color: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_pieSliceText_color' ] ); ?>',
								fontSize: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_pieSliceText_fontsize' ] ); ?>',
							},
							is3D: '<?php echo esc_js( $settings[ 'iq_' . $type . '_chart_isthreed' ] === 'yes' ); ?>',
						};

						if (typeof graphinaGoogleChartInit !== "undefined") {
							graphinaGoogleChartInit(
								document.getElementById('pie_google_chart<?php echo esc_js( $main_id ); ?>'),
								{
									ele: document.getElementById('pie_google_chart<?php echo esc_js( $main_id ); ?>'),
									options: options,
									series: data,
									animation: true,
									renderType: 'PieChart',
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

Plugin::instance()->widgets_manager->register( new Pie_Google_Chart() );
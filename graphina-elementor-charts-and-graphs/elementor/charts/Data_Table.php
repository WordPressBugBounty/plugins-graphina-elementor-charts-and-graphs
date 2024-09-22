<?php
/**
 * Jquery datatable chart elementor widget class.
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina_Charts_For_Elementor
 */

namespace Elementor;

use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Elementor Jquery datatable widget.
 *
 * Elementor widget that displays an eye-catching datatable.
 *
 * @since 1.5.7
 */
class Data_Table extends Widget_Base {


	/**
	 * Datatable class constructor.
	 *
	 * @param array      $data Widget data. Default is an empty array.
	 * @param array|null $args Optional. Widget default arguments. Default is null.
	 * @throws Exception If arguments are missing when initializing a full widget
	 *                    instance.
	 */
	public function __construct( $data = array(), $args = null ) {
		wp_register_script( 'graphina_datatables', GRAPHINA_URL . '/elementor/js/jquery-datatable/graphina_datatables.min.js', array( 'jquery' ), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, true );
		wp_register_script( 'graphina_datatables_rowreorder', GRAPHINA_URL . '/elementor/js/jquery-datatable/graphina_datatables_rowreorder.js', array( 'jquery' ), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, true );
		wp_register_script( 'graphina_datatables_row_responsive', GRAPHINA_URL . '/elementor/js/jquery-datatable/graphina_datatables_row_responsive.js', array( 'jquery' ), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, true );
		wp_register_script( 'graphina_datatables_button_print', GRAPHINA_URL . '/elementor/js/jquery-datatable/graphina_datatables_button_print.js', array( 'jquery' ), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, true );
		wp_register_script( 'graphina_datatable_button', GRAPHINA_URL . '/elementor/js/jquery-datatable/graphina_datatable_button.js', array( 'jquery' ), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, true );
		wp_register_script( 'graphina_datatable_button_flash', GRAPHINA_URL . '/elementor/js/jquery-datatable/graphina_datatable_button_flash.js', array( 'jquery' ), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, true );
		wp_register_script( 'graphina_datatable_html', GRAPHINA_URL . '/elementor/js/jquery-datatable/graphina_datatable_html.js', array( 'jquery' ), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, true );
		wp_register_script( 'graphina_datatable_zip', GRAPHINA_URL . '/elementor/js/jquery-datatable/graphina_datatable_zip.js', array( 'jquery' ), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, true );
		wp_register_script( 'graphina_datatable_pdf', GRAPHINA_URL . '/elementor/js/jquery-datatable/graphina_datatable_pdf.js', array( 'jquery' ), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, true );
		wp_register_script( 'graphina_datatable_font', GRAPHINA_URL . '/elementor/js/jquery-datatable/graphina_datatable_font.js', array( 'jquery' ), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, true );
		wp_register_script( 'graphina_datatable_colvis', GRAPHINA_URL . '/elementor/js/jquery-datatable/graphina_datatable_colvis.js', array( 'jquery' ), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, true );
		wp_register_style( 'graphina_datatables_style', GRAPHINA_URL . '/elementor/css/jquery-datatable/graphina_datatables_style.css', array(), true );
		wp_register_style( 'graphina_datatable_button_style', GRAPHINA_URL . '/elementor/css/jquery-datatable/graphina_datatable_button_style.css', array(), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION );
		wp_register_style( 'graphina_datatable_reponsive_css', GRAPHINA_URL . '/elementor/css/jquery-datatable/graphina_datatable_reponsive_css.css', array(), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION );

		parent::__construct( $data, $args );
	}

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name(): string {
		return 'data_table_lite';
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
		return 'Jquery Data Table';
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
		return 'eicon-table';
	}

	/**
	 * Get widget type.
	 *
	 * @return string Widget ty[e.
	 *
	 * @access public
	 */
	public function get_chart_type(): string {
		return 'data_table_lite';
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
			'graphina_datatables',
			'graphina_datatable_button',
			'graphina_datatables_button_print',
			'graphina_datatables_row_responsive',
			'graphina_datatables_rowreorder',
			'graphina_datatable_button_flash',
			'graphina_datatable_html',
			'graphina_datatable_zip',
			'graphina_datatable_pdf',
			'graphina_datatable_font',
			'graphina_datatable_colvis',
		);
	}

	/**
	 * Enqueue styles.
	 *
	 * Registers all the styles defined as element dependencies and enqueues
	 *
	 * @return array
	 */
	public function get_style_depends(): array {
		return array(
			'graphina_datatables_style',
			'graphina_datatable_button_style',
			'graphina_datatable_reponsive-css',
		);
	}

	/**
	 * Register controller to elementor
	 *
	 * @return void
	 */
	protected function register_controls(): void {

		$type = $this->get_chart_type();

		graphina_basic_setting( $this, $type );

		$type = $this->get_name();
		graphina_datatable_lite_element_data_option_setting( $this, $type );

		do_action( 'graphina_forminator_addon_control_section', $this, $type );

		$this->start_controls_section(
			'iq_' . $type . 'table_setting',
			array(
				'label' => esc_html__( 'Table Settings', 'graphina-charts-for-elementor' ),
			)
		);

		$this->add_control(
			'iq_' . $type . 'table_footer',
			array(
				'label'     => esc_html__( 'Footer Enable', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);
			$this->add_control(
				'iq_' . $type . 'table_data_direct',
				array(
					'label'     => esc_html__( 'Direct Data Input Enabled', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Enable', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Disable', 'graphina-charts-for-elementor' ),
					'default'   => 'no',
				)
			);

		$this->add_control(
			'iq_' . $type . 'table_search',
			array(
				'label'     => esc_html__( 'Search Enabled', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'iq_' . $type . 'table_pagination',
			array(
				'label'     => esc_html__( 'Pagination Enabled', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

			$this->add_control(
				'iq_' . $type . 'table_pagination_info',
				array(
					'label'     => esc_html__( 'Pagination Info', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
					'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
					'default'   => 'yes',
					'condition' => array(
						'iq_' . $type . 'table_pagination' => 'yes',
					),
				)
			);

			$this->add_control(
				'iq_' . $type . 'pagination_type',
				array(
					'label'     => esc_html__( 'Pagination Type', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'numbers',
					'options'   => array(
						'numbers'            => esc_html__( 'Numbers', 'graphina-charts-for-elementor' ),
						'simple'             => esc_html__( 'Simple', 'graphina-charts-for-elementor' ),
						'simple_numbers'     => esc_html__( 'Simple Numbers', 'graphina-charts-for-elementor' ),
						'full'               => esc_html__( 'Full', 'graphina-charts-for-elementor' ),
						'full_numbers'       => esc_html__( 'Full Numbers', 'graphina-charts-for-elementor' ),
						'first_last_numbers' => esc_html__( 'First Last Numbers', 'graphina-charts-for-elementor' ),
					),
					'condition' => array(
						'iq_' . $type . 'table_pagination' => 'yes',
					),
				)
			);

		$this->add_control(
			'iq_' . $type . 'table_sort',
			array(
				'label'     => esc_html__( 'Sorting Enabled', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
				'default'   => 'yes',
			)
		);

		$this->add_control(
			'iq_' . $type . 'table_scroll',
			array(
				'label'     => esc_html__( 'Scrolling Enabled', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Hide', 'graphina-charts-for-elementor' ),
				'label_off' => esc_html__( 'Show', 'graphina-charts-for-elementor' ),
			)
		);

		$this->add_control(
			'iq_' . $type . '_pagelength',
			array(
				'label'   => esc_html__( 'Page Length', 'graphina-charts-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 10,
				'options' => array(
					10  => 10,
					50  => 50,
					100 => 100,
					-1  => esc_html__( 'All', 'graphina-charts-for-elementor' ),
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_button_menu',
			array(
				'label'    => esc_html__( 'Button Menu', 'graphina-charts-for-elementor' ),
				'type'     => Controls_Manager::SELECT2,
				'default'  => 'pageLength',
				'multiple' => true,
				'options'  => array(
					'pageLength' => esc_html__( 'pageLength', 'graphina-charts-for-elementor' ),
					'colvis'     => esc_html__( 'Column Visibilty', 'graphina-charts-for-elementor' ),
					'copy'       => esc_html__( 'Copy', 'graphina-charts-for-elementor' ),
					'excel'      => esc_html__( 'Excel', 'graphina-charts-for-elementor' ),
					'pdf'        => esc_html__( 'PDF', 'graphina-charts-for-elementor' ),
					'print'      => esc_html__( 'Print', 'graphina-charts-for-elementor' ),
					'excelFlash' => esc_html__( 'excelFlash', 'graphina-charts-for-elementor' ),
				),
			)
		);

		$this->end_controls_section();

		/*Table Column section */
		$this->start_controls_section(
			'iq_' . $type . '_section_column',
			array(
				'label'     => esc_html__( 'Table Columns', 'graphina-charts-for-elementor' ),
				'condition' => array(
					'iq_' . $type . '_chart_data_option' => 'manual',
				),
			)
		);

		for ( $i = 0; $i < 25; $i++ ) {
			$this->add_control(
				'iq_' . $type . '_chart_header_title_' . $i,
				array(
					'label'       => 'Column Header',
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Add Title', 'graphina-charts-for-elementor' ),
					'default'     => 'Column ' . ( $i + 1 ),
					'condition'   => array(
						'iq_' . $type . '_element_columns' => range( 1 + $i, 25 ),
						'iq_' . $type . '_chart_data_option' => 'manual',
					),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);
		}

		$this->end_controls_section();

		for ( $i = 0; $i < 100; $i++ ) {
			$this->start_controls_section(
				'iq_' . $type . '_section_4_' . $i,
				array(
					'label'     => esc_html__( 'Row  ', 'graphina-charts-for-elementor' ) . ( $i + 1 ),
					'condition' => array(
						'iq_' . $type . '_element_rows' => range( 1 + $i, 100 ),
						'iq_' . $type . '_chart_data_option' => 'manual',
					),
				)
			);

			$repeater = new Repeater();

			$repeater->add_control(
				'iq_' . $type . '_row_value',
				array(
					'label'       => esc_html__( 'Row Value', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Add Value', 'graphina-charts-for-elementor' ),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);

			$repeater->add_control(
				'iq_' . $type . '_row_url',
				array(
					'label'        => esc_html__( 'Row URL', 'graphina-charts-for-elementor' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'graphina-charts-for-elementor' ),
					'label_off'    => esc_html__( 'No', 'graphina-charts-for-elementor' ),
					'return_value' => 'yes',
					'default'      => 'no',
					'separator'    => 'before', // Add the checkbox before the row value control.
				)
			);

			$repeater->add_control(
				'iq_' . $type . '_row_link_text',
				array(
					'label'       => esc_html__( 'Link Text', 'graphina-charts-for-elementor' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Add Link Text', 'graphina-charts-for-elementor' ),
					'condition'   => array(
						'iq_' . $type . '_row_url' => 'yes', // Show this control only if the URL option is enabled.
					),
				)
			);

			/** Chart value list. */
			$this->add_control(
				'iq_' . $type . '_row_list' . $i,
				array(
					'label'     => esc_html__( 'Row Data', 'graphina-charts-for-elementor' ),
					'type'      => Controls_Manager::REPEATER,
					'fields'    => $repeater->get_controls(),
					'default'   => array(
						array( 'iq_' . $type . '_row_value' => 'Data 1' ),
						array( 'iq_' . $type . '_row_value' => 'Data 2' ),
						array( 'iq_' . $type . '_row_value' => 'Data 3' ),
					),
					'condition' => array(
						'iq_' . $type . '_chart_data_option' => 'manual',
					),
				)
			);

			$this->end_controls_section();

		}

		graphina_style_section( $this, $type );

		graphina_card_style( $this, $type );

		$this->start_controls_section(
			'iq_' . $type . '_table_style',
			array(
				'label' => esc_html__( 'Table Style', 'graphina-charts-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'iq_' . $type . '_header_row_color',
			array(
				'label'     => esc_html__( 'Header Row Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} table thead' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_header_text_row_color',
			array(
				'label'     => esc_html__( 'Header Row Text Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} table thead' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'iq_' . $type . '_header_typography',
				'label'    => esc_html__( 'Header Typography', 'graphina-charts-for-elementor' ),
				'selector' => '{{WRAPPER}} table thead',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'iq_' . $type . '_footer_typography',
				'label'    => esc_html__( 'Footer Typography', 'graphina-charts-for-elementor' ),
				'selector' => '{{WRAPPER}} table tfoot',
			)
		);
		$this->add_control(
			'iq_' . $type . '_table_even_row_color',
			array(
				'label'     => esc_html__( 'Even Row Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} table .even,{{WRAPPER}} table .even .sorting_1' => 'background-color: {{VALUE}}!important;',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_table_even_row_text_color',
			array(
				'label'     => esc_html__( 'Even Row Text Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} table .even' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_table_old_row_color',
			array(
				'label'     => esc_html__( 'Odd Row Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} table .odd,{{WRAPPER}} table .odd .sorting_1' => 'background-color: {{VALUE}}!important;',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_table_old_row_text_color',
			array(
				'label'     => esc_html__( 'Odd Row Text Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} table .odd' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_footer_row_color',
			array(
				'label'     => esc_html__( 'Footer Row Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} table tfoot' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_footer_row_text_color',
			array(
				'label'     => esc_html__( 'Footer Row Text Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} table tfoot' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'iq_' . $type . '_cell_typography',
				'label'    => esc_html__( 'Typography', 'graphina-charts-for-elementor' ),
				'scheme'   => Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .dataTables_wrapper',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'iq_' . $type . '_table_search_border',
				'label'    => esc_html__( 'Border', 'graphina-charts-for-elementor' ),
				'selector' => '{{WRAPPER}} table',
			)
		);

		$this->add_control(
			'iq_' . $type . '_table_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'graphina-charts-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_table_margin',
			array(
				'label'      => esc_html__( 'Margin', 'graphina-charts-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} table' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_table_padding',
			array(
				'label'      => esc_html__( 'Padding', 'graphina-charts-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'iq_' . $type . '_search_style',
			array(
				'label'     => esc_html__( 'Search Style', 'graphina-charts-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'iq_' . $type . 'table_search' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'iq_' . $type . '_search_border',
				'label'    => esc_html__( 'Border', 'graphina-charts-for-elementor' ),
				'selector' => '{{WRAPPER}} input[type=search]',
			)
		);

		$this->add_control(
			'iq_' . $type . '_search_width',
			array(
				'label'     => esc_html__( 'Width', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'default'   => 200,
				'selectors' => array(
					'{{WRAPPER}} input[type=search]' => 'width: {{VALUE}}px;',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_search_height',
			array(
				'label'     => esc_html__( 'height', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'default'   => 40,
				'selectors' => array(
					'{{WRAPPER}} input[type=search]' => 'height: {{VALUE}}px;',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_search_background_color',
			array(
				'label'     => esc_html__( 'Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} input[type=search]' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_search_text_font_size',
			array(
				'label'     => esc_html__( 'Font Size', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'default'   => 16,
				'selectors' => array(
					'{{WRAPPER}} input[type=search]' => 'font-size: {{VALUE}}px;',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_search_text_font_color',
			array(
				'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} input[type=search]' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_search_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'graphina-charts-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} input[type=search]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_search_margin',
			array(
				'label'      => esc_html__( 'Margin', 'graphina-charts-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} input[type=search]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_search_padding',
			array(
				'label'      => esc_html__( 'Padding', 'graphina-charts-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} input[type=search]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'iq_' . $type . '_table_button_style',
			array(
				'label' => esc_html__( 'Button Style', 'graphina-charts-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'iq_' . $type . '_table_button_search_border',
				'label'    => esc_html__( 'Border', 'graphina-charts-for-elementor' ),
				'selector' => '{{WRAPPER}} .buttons-page-length,
                             {{WRAPPER}} .buttons-colvis,
                             {{WRAPPER}} .buttons-copy,
                             {{WRAPPER}} .buttons-excel,
                             {{WRAPPER}} .buttons-pdf,
                             {{WRAPPER}} .buttons-print,
                             {{WRAPPER}} .paginate_button,
                             {{WRAPPER}} .paginate_button.disabled',
			)
		);

		$this->add_control(
			'iq_' . $type . '_table_button_search_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .buttons-page-length,
                             {{WRAPPER}} .buttons-colvis,
                             {{WRAPPER}} .buttons-copy,
                             {{WRAPPER}} .buttons-excel,
                             {{WRAPPER}} .buttons-pdf,
                             {{WRAPPER}} .buttons-print,
                             {{WRAPPER}} .paginate_button,
                             {{WRAPPER}} .paginate_button.disabled' => 'background: {{VALUE}} !important;',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_table_button_search_text_font_size',
			array(
				'label'     => esc_html__( 'Font Size', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'default'   => 16,
				'selectors' => array(
					'{{WRAPPER}} .buttons-page-length,
                             {{WRAPPER}} .buttons-colvis,
                             {{WRAPPER}} .buttons-copy,
                             {{WRAPPER}} .buttons-excel,
                             {{WRAPPER}} .buttons-pdf,
                             {{WRAPPER}} .buttons-print,
                             {{WRAPPER}} .paginate_button,
                             {{WRAPPER}} .paginate_button.disabled' => 'font-size: {{VALUE}}px !important;',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_table_button_search_text_font_color',
			array(
				'label'     => esc_html__( 'Font Color', 'graphina-charts-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .buttons-page-length,
                             {{WRAPPER}} .buttons-colvis,
                             {{WRAPPER}} .buttons-copy,
                             {{WRAPPER}} .buttons-excel,
                             {{WRAPPER}} .buttons-pdf,
                             {{WRAPPER}} .buttons-print,
                             {{WRAPPER}} .paginate_button,
                             {{WRAPPER}} .paginate_button.disabled' => 'color: {{VALUE}}!important;',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_table_button_search_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'graphina-charts-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .buttons-page-length,
                             {{WRAPPER}} .buttons-colvis,
                             {{WRAPPER}} .buttons-copy,
                             {{WRAPPER}} .buttons-excel,
                             {{WRAPPER}} .buttons-pdf,
                             {{WRAPPER}} .buttons-print,
                             {{WRAPPER}} .paginate_button,
                             {{WRAPPER}} .paginate_button.disabled' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_table_button_search_margin',
			array(
				'label'      => esc_html__( 'Margin', 'graphina-charts-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .buttons-page-length,
                             {{WRAPPER}} .buttons-colvis,
                             {{WRAPPER}} .buttons-copy,
                             {{WRAPPER}} .buttons-excel,
                             {{WRAPPER}} .buttons-pdf,
                             {{WRAPPER}} .buttons-print,
                             {{WRAPPER}} .paginate_button,
                             {{WRAPPER}} .paginate_button.disabled' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_control(
			'iq_' . $type . '_table_button_search_padding',
			array(
				'label'      => esc_html__( 'Padding', 'graphina-charts-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .buttons-page-length,
                             {{WRAPPER}} .buttons-colvis,
                             {{WRAPPER}} .buttons-copy,
                             {{WRAPPER}} .buttons-excel,
                             {{WRAPPER}} .buttons-pdf,
                             {{WRAPPER}} .buttons-print,
                             {{WRAPPER}} .paginate_button,
                             {{WRAPPER}} .paginate_button.disabled' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				),
			)
		);

		$this->end_controls_section();

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

		$type     = $this->get_name();
		$main_id  = graphina_widget_id( $this );
		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings[ 'iq_' . $type . '_button_menu' ] ) && ! is_array( $settings[ 'iq_' . $type . '_button_menu' ] ) ) {
			$button = array( $settings[ 'iq_' . $type . '_button_menu' ] );
		} else {
			$button = $settings[ 'iq_' . $type . '_button_menu' ];
		}

		if ( graphina_restricted_access( 'data_table_lite', $main_id, $settings, true ) ) {
			if ( $settings['iq_data_table_lite_restriction_content_type'] === 'password' ) {
				return;
			}
			echo wp_kses_post( html_entity_decode( $settings['iq_data_table_lite_restriction_content_template'] ) );
			return;
		}

		$header_data = array();
		for ( $i = 0; $i < $settings[ 'iq_' . $type . '_element_columns' ]; $i++ ) {
			$title         = $settings[ 'iq_' . $type . '_chart_header_title_' . $i ];
			$header_data[] = esc_html( $title );
		}

		// Prepare body data.
		$body_data = array();
		$class     = esc_attr( apply_filters( 'graphina_widget_table_url_class', '', $settings, $main_id ) );
		for ( $i = 0; $i < $settings[ 'iq_' . $type . '_element_rows' ]; $i++ ) {
			$row_list = $settings[ 'iq_' . $type . '_row_list' . $i ];
			foreach ( $row_list as $row ) {
				$row_value = esc_html( $row[ 'iq_' . $type . '_row_value' ] );
				if ( $row[ 'iq_' . $type . '_row_url' ] === 'yes' && ! empty( $row[ 'iq_' . $type . '_row_link_text' ] ) ) {
					$url       = esc_url( $row[ 'iq_' . $type . '_row_link_text' ] );
					$row_value = "<a href='{$url}' target='_blank' class='{$class}'>{$row_value}</a>";
				}
				$body_data[ $i ][] = $row_value;
			}
		}

		?>
		<div class="<?php echo esc_attr( $settings['iq_data_table_lite_chart_card_show'] === 'yes' ? 'chart-card' : '' ); ?>">
			<div class="">
				<?php if ( $settings['iq_data_table_lite_is_card_heading_show'] && $settings['iq_data_table_lite_chart_card_show'] ) { ?>
					<h4 class="heading graphina-chart-heading">
						<?php echo wp_kses_post( html_entity_decode( (string) $settings['iq_data_table_lite_chart_heading'] ) ); ?>
					</h4>
					<?php
				}
				if ( $settings['iq_data_table_lite_is_card_desc_show'] && $settings['iq_data_table_lite_chart_card_show'] ) {
					?>
					<p class="sub-heading graphina-chart-sub-heading">
						<?php echo wp_kses_post( html_entity_decode( (string) $settings['iq_data_table_lite_chart_content'] ) ); ?>
					</p>
				<?php } ?>
			</div>
			
			<table id="data_table_lite_<?php echo esc_attr( $main_id ); ?>"
					class="chart-texture display wrap data_table_lite_<?php echo esc_attr( $main_id ); ?>" style="width:100%">
			</table>
			<p id="data_table_lite_loading_<?php echo esc_attr( $main_id ); ?>" class="graphina-chart-heading"
				style="text-align: center;">
				<?php echo wp_kses_post( apply_filters( 'graphina_datatable_loader', esc_html__( 'Loading..........', 'graphina-charts-for-elementor' ) ) ); ?>
			</p>
			<p id="data_table_lite_no_data_<?php echo esc_attr( $main_id ); ?>" class="graphina-chart-heading d-none">
				<?php echo esc_html__( 'The Data is Not Available', 'graphina-charts-for-elementor' ); ?>
			</p>
		</div>

		<script defer>
			(function () {
				'use strict';
				// Function to render the DataTable.
				function graphinaDatatableRender(columns, tableData) {

					jQuery("#data_table_lite_<?php echo esc_attr( $main_id ); ?>").DataTable({
						columns: columns,
						data: tableData,
						searching: '<?php echo esc_js( $settings[ 'iq_' . $type . 'table_search' ] === 'yes' ); ?>',
						paging: '<?php echo esc_js( $settings[ 'iq_' . $type . 'table_pagination' ] === 'yes' ); ?>',
						info: '<?php echo esc_js( $settings[ 'iq_' . $type . 'table_pagination_info' ] === 'yes' ); ?>',
						lengthChange: false,
						sort: '<?php echo esc_js( $settings[ 'iq_' . $type . 'table_sort' ] === 'yes' ); ?>',
						pagingType: '<?php echo esc_js( $settings[ 'iq_' . $type . 'pagination_type' ] ); ?>',
						scrollX: '<?php echo esc_js( $settings[ 'iq_' . $type . 'table_scroll' ] ); ?>',
						pageLength: parseInt('<?php echo esc_js( $settings[ 'iq_' . $type . '_pagelength' ] ); ?>') || 10,
						responsive: true,
						<?php if ( wp_is_mobile() ) { ?>
						rowReorder: {
							selector: 'td:nth-child(2)'
						},
						<?php } ?>
						dom: 'Bfrtip',
						lengthMenu: [[10, 50, 100, -1], [10, 50, 100, 'All']],
						buttons: JSON.parse('<?php echo wp_json_encode( $button ); ?>'),
						deferRender: true,
						language: {
							search: '',
							info: "<?php echo esc_html__( 'Showing ', 'graphina-charts-for-elementor' ); ?>" + '_START_'
								+ "<?php echo esc_html__( ' to ', 'graphina-charts-for-elementor' ); ?>"
								+ '_END_' + "<?php echo esc_html__( ' of ', 'graphina-charts-for-elementor' ); ?>" + '_TOTAL_' +
								"<?php echo esc_html__( ' entries', 'graphina-charts-for-elementor' ); ?>",
							searchPlaceholder: "<?php echo esc_html__( 'Search....', 'graphina-charts-for-elementor' ); ?>",
							emptyTable: "<?php echo esc_html__( 'No data available in table', 'graphina-charts-for-elementor' ); ?>",
							zeroRecords: "<?php echo esc_html__( 'No matching records found', 'graphina-charts-for-elementor' ); ?>",
							paginate: {
								first: "<?php echo esc_html__( 'First', 'graphina-charts-for-elementor' ); ?>",
								last: "<?php echo esc_html__( 'Last', 'graphina-charts-for-elementor' ); ?>",
								next: "<?php echo esc_html__( 'Next', 'graphina-charts-for-elementor' ); ?>",
								previous: "<?php echo esc_html__( 'Previous', 'graphina-charts-for-elementor' ); ?>",
							},
							buttons: {
								copy: "<?php echo esc_html__( 'Copy', 'graphina-charts-for-elementor' ); ?>",
								colvis: "<?php echo esc_html__( 'Column Visibility', 'graphina-charts-for-elementor' ); ?>",
								pdf: "<?php echo esc_html__( 'PDF', 'graphina-charts-for-elementor' ); ?>",
								print: "<?php echo esc_html__( 'Print', 'graphina-charts-for-elementor' ); ?>",
								excel: "<?php echo esc_html__( 'Excel', 'graphina-charts-for-elementor' ); ?>",
								pageLength: {
									"-1": "<?php echo esc_html__( 'Show all rows', 'graphina-charts-for-elementor' ); ?>",
									"_": "<?php echo esc_html__( 'Show ', 'graphina-charts-for-elementor' ); ?>" +
										"%d" + "<?php echo esc_html__( ' rows', 'graphina-charts-for-elementor' ); ?>"
								},
							}
						},
						fnInitComplete: function () {
							<?php if ( $settings[ 'iq_' . $type . 'table_footer' ] === true ) { ?>
							// Disable TBODY scroll bars
							jQuery('.dataTables_scrollBody').css({
								'overflow': 'hidden',
								'border': '0'
							});
							jQuery("#data_table_lite_<?php echo esc_attr( $main_id ); ?> thead th").addClass('all graphina-datatable-columns')

							jQuery("#data_table_lite_<?php echo esc_attr( $main_id ); ?> tbody td").addClass('graphina-datatable-tbody-td')

							const tableScrollFoot = jQuery('.dataTables_scrollFoot');
							// Enable TFOOT scroll bars
							tableScrollFoot.css('overflow', 'auto');

							// Sync TFOOT scrolling with TBODY
							tableScrollFoot.on('scroll', function () {
								jQuery('.dataTables_scrollBody').scrollLeft(jQuery(this).scrollLeft());
							});
							<?php } ?>
						}
					});
				}

				// Function to handle AJAX data fetching and table rendering.
				function graphinaDataTableAjax() {
					jQuery.ajax({
						url: '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>',
						type: 'POST',
						data: {
							action: "get_jquery_datatable_data",
							nonce: '<?php echo esc_js( wp_create_nonce( 'get_jquery_datatable_data' ) ); ?>',
							chart_type: '<?php echo esc_js( $this->get_chart_type() ); ?>',
							chart_id: '<?php echo esc_js( $main_id ); ?>',
							fields: <?php echo wp_json_encode( $settings ); ?>
						},
						success: function (response) {
							jQuery("#data_table_lite_loading_<?php echo esc_attr( $main_id ); ?>").addClass('d-none')
							if (response.status && response.status === true) {
								jQuery("#data_table_lite_<?php echo esc_attr( $main_id ); ?>").removeClass('d-none')
								jQuery("#data_table_lite_no_data_<?php echo esc_attr( $main_id ); ?>").addClass('d-none')
								const columnHeaders = response.data.header;
								const tableData = response.data.body;
								const columns = [];
								for (let i = 0; i < columnHeaders.length; i++) {
									columns.push({title: columnHeaders[i], width: (100 / columnHeaders.length) + "px"});
								}
								if('<?php echo esc_js( $settings[ 'iq_' . $type . 'table_footer' ] ); ?>'){
									jQuery("#data_table_lite_<?php echo esc_attr( $main_id ); ?>").append('<tfoot><tr>' + columns.map(column => `<th>${column.title}</th>`).join('') + '</tr></tfoot>');
								}
								graphinaDatatableRender(columns, tableData);
							} else {
								jQuery("#data_table_lite_<?php echo esc_attr( $main_id ); ?>").addClass('d-none')
								jQuery("#data_table_lite_no_data_<?php echo esc_attr( $main_id ); ?>").removeClass('d-none')
							}
						},
						error: function (error) {
							jQuery("#data_table_lite_loading_<?php echo esc_attr( $main_id ); ?>").addClass('d-none')
							jQuery("#data_table_lite_<?php echo esc_attr( $main_id ); ?>").addClass('d-none')
							jQuery("#data_table_lite_no_data_<?php echo esc_attr( $main_id ); ?>").removeClass('d-none')
							console.log(error)
						}
					});
				}

				// Function to handle direct data rendering
				function renderDirectData() {
					const columnHeaders = <?php echo wp_json_encode( $header_data ); ?>;
					const bodyData = <?php echo wp_json_encode( $body_data ); ?>;
					const columns = [];

					for (let i = 0; i < columnHeaders.length; i++) {
						columns.push({title: columnHeaders[i], width: (100 / columnHeaders.length) + "px"});
					}
					if('<?php echo esc_js( $settings[ 'iq_' . $type . 'table_footer' ] ); ?>'){
						jQuery("#data_table_lite_<?php echo esc_attr( $main_id ); ?>").append('<tfoot><tr>' + columns.map(column => `<th>${column.title}</th>`).join('') + '</tr></tfoot>');
					}
					jQuery("#data_table_lite_loading_<?php echo esc_attr( $main_id ); ?>").addClass('d-none')

					graphinaDatatableRender(columns, bodyData);
				}

				function renderDataTable(){
					const directDataEnabled = <?php echo esc_js( $settings[ 'iq_' . $type . '_chart_data_option' ] === 'manual' && $settings[ 'iq_' . $type . 'table_data_direct' ] === 'yes' ) ? 'true' : 'false'; ?>;
					if (directDataEnabled) {
						renderDirectData();
					} else {
						graphinaDataTableAjax();
					}
				}

				// Event listeners for loading and changes
				if (parent.document.querySelector('.elementor-editor-active') !== null) {
					renderDataTable();
				}

				document.addEventListener('readystatechange', event => {
					if (event.target.readyState === "complete") {
						renderDataTable();
					}
				});
			}).apply(this, [jQuery]);
			</script>


		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Data_Table() );

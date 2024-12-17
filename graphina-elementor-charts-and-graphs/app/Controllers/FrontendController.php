<?php
/**
 * AdminController class load all admin ajax routes
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina_Charts_For_Elementor
 */

namespace GraphinaElementor\App\Controllers;

use GraphinaElementor\App\BaseClasses\ElementorWidgetSettings;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Something went wrong' );
}

use Elementor\Plugin;
use Exception;
use GraphinaElementor\App\BaseClasses\Frontend;

/**
 * FrontendController class.
 *
 * Handles AJAX requests for chart settings and password restrictions in the frontend.
 *
 * Extends ElementorInit.
 */
class FrontendController extends Frontend {

	/**
	 * The ID of the widget.
	 *
	 * @var string
	 */
	public string $widget_id;

	/**
	 * The settings array for the widget.
	 *
	 * @var array
	 */
	public array $settings = array();


	/**
	 * Class constructor.
	 *
	 * Initializes the class by adding actions to handle various AJAX requests.
	 */
	public function __construct() {
		// Add AJAX actions for logged-in users and non-logged-in users.
		add_action( 'wp_ajax_get_graphina_chart_settings', array( $this, 'action_get_graphina_chart_settings' ) );
		add_action( 'wp_ajax_nopriv_get_graphina_chart_settings', array( $this, 'action_get_graphina_chart_settings' ) );
		add_action( 'wp_ajax_graphina_restrict_password_ajax', array( $this, 'action_graphina_restrict_password_ajax' ) );
		add_action( 'wp_ajax_nopriv_graphina_restrict_password_ajax', array( $this, 'action_graphina_restrict_password_ajax' ) );
		add_action( 'wp_ajax_get_jquery_datatable_data', array( $this, 'action_get_jquery_datatable_data' ) );
		add_action( 'wp_ajax_nopriv_get_jquery_datatable_data', array( $this, 'action_get_jquery_datatable_data' ) );
	}


	/**
	 * Handle AJAX request to get Graphina chart settings.
	 *
	 * This function processes an AJAX request to retrieve the settings for a Graphina chart. It validates the request,
	 * fetches the settings, processes the data, and returns the response in JSON format.
	 *
	 * @return void
	 */
	public function action_get_graphina_chart_settings(): void {

		// Initialize the response array with default values.
		$response = array(
			'status'          => false,
			'instant_init'    => false,
			'fail'            => false,
			'fail_message'    => '',
			'chart_id'        => -1,
			'chart_option'    => array(
				'chart' => array(
					'dropShadow' =>
						array(
							'enabledOnSeries' => array(),
						),
				),
			),
			'filter_enable'   => false,
			'googlechartData' => array(
				'count'       => 0,
				'title_array' => array(),
				'data'        => array(),
				'title'       => '',
			),
			'category_count'  => 0,
			'data'            => array(
				'series'       => array(),
				'category'     => array(),
				'fail_message' => '',
				'fail'         => false,
			),
		);

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'get_graphina_chart_settings' ) ) {
			wp_send_json( $response );
		}

		try {
			$request_data    = graphina_recursive_sanitize_textfield( $_POST );
			$settings        = $this->get_widget_setting( $request_data );
			$type            = $request_data['chart_type'];
			$id              = $request_data['chart_id'];
			$this->widget_id = $id;
			$this->settings  = $settings;
			if ( empty( $request_data['selected_field'] ) && ! empty( $settings[ "iq_{$type}_chart_filter_list" ] ) ) {
				$selected_item = array();
				foreach ( $settings[ "iq_{$type}_chart_filter_list" ] as $item ) {
					if ( isset( $item[ "iq_{$type}_chart_filter_type" ] ) && $item[ "iq_{$type}_chart_filter_type" ] === 'date' ) {
						list($first_value) = explode( ' ', $item[ "iq_{$type}_chart_filter_datetime_default" ] );
					} else {
						$first_value = explode( ',', $item[ "iq_{$type}_chart_filter_value" ] )[0];
					}

					$selected_item[] = $first_value;
				}
			} else {
				$selected_item = $request_data['selected_field'];
			}

			$gradient           = array();
			$second_gradient    = array();
			$drop_shadow_series = array();
			$stock_width        = array();
			$stock_dash_array   = array();
			$fill_pattern       = array();

			$data_type = match ( $type ) {
				'distributed_column', 'line', 'area', 'column', 'heatmap', 'radar', 'line_google', 'column_google', 'bar_google', 'scatter', 'mixed', 'area_google' => 'area',
				'donut', 'polar', 'pie', 'data-tables', 'radial', 'pie_google', 'donut_google', 'gauge_google', 'geo_google' => 'circle',
				'timeline' => 'timeline',
				'org_google' => 'org_google',
				default => $type,
			};//end switch

			if ( $settings[ 'iq_' . $type . '_chart_data_option' ] !== 'manual' ) {
				if ( graphina_pro_active() && $settings[ 'iq_' . $type . '_chart_data_option' ] !== 'forminator' ) {
					$response['data'] = graphina_pro_chart_content( $settings, $id, $type, $data_type, $selected_item );
			
				} elseif ( graphina_forminator_addon_active() ) {
					$response['data'] = apply_filters( 'graphina_forminator_addon_data', $response['data'], $type, $settings );
				}

				if ( ! empty( $response['data']['fail'] ) && $response['data']['fail'] === 'permission' ) {
					$response['fail']         = true;
					$response['status']       = true;
					$response['fail_message'] = ! empty( $response['data']['fail_message'] ) ? $response['data']['fail_message'] : '';
					$response['chart_id']     = $id;
					$response['chart_option'] = array();
					wp_send_json( $response );
				}
			}


			$response['category_count'] = ! empty( $response['data']['category'] ) && is_array( $response['data']['category'] ) ? count( $response['data']['category'] ) : 0;

			if ( in_array( $type, $this->google_charts_list(), true ) ) {
				$response['googlechartData'] = $this->get_google_chart_format_data( $response['data'], $settings, $type );
			} else {
				$series_count = ! empty( $settings[ 'iq_' . $type . '_chart_data_series_count' ] ) ? $settings[ 'iq_' . $type . '_chart_data_series_count' ] : 0;
				for ( $i = 0; $i < $series_count; $i++ ) {
					$drop_shadow_series[] = $i;
					$gradient[]           = strval( $settings[ 'iq_' . $type . '_chart_gradient_1_' . $i ] );
					$second_gradient[]    = ! empty( $settings[ 'iq_' . $type . '_chart_gradient_2_' . $i ] ) ? strval( $settings[ 'iq_' . $type . '_chart_gradient_2_' . $i ] ) : strval( $settings[ 'iq_' . $type . '_chart_gradient_1_' . $i ] );
					$stock_width[]        = ! empty( $settings[ 'iq_' . $type . '_chart_width_3_' . $i ] ) ? $settings[ 'iq_' . $type . '_chart_width_3_' . $i ] : 0;
					$stock_dash_array[]   = ! empty( $settings[ 'iq_' . $type . '_chart_dash_3_' . $i ] ) ? $settings[ 'iq_' . $type . '_chart_dash_3_' . $i ] : 0;
					$fill_pattern[]       = ! empty( $settings[ 'iq_' . $type . '_chart_bg_pattern_' . $i ] ) ? $settings[ 'iq_' . $type . '_chart_bg_pattern_' . $i ] : 'verticalLines';
				}

				if ( $type === 'distributed_column' && isset( $response['data']['series'][0]['data'] ) ) {
					$response['data']['series'] = array( $response['data']['series'][0] );
					if ( is_array( $response['data']['series'][0]['data'] ) ) {
						$response['data']['series'][0]['data'] = array_slice( $response['data']['series'][0]['data'], 0, $series_count );
						$response['data']['category']          = array_slice( $response['data']['category'], 0, $series_count );
					}
				}

				$gradient_count           = count( $gradient );
				$second_gradient_count    = count( $second_gradient );
				$response['chart_option'] = array(
					'series' => $response['data']['series'],
					'chart'  => array(
						'animations' => array(
							'enabled' => $settings[ 'iq_' . $type . '_chart_animation' ] === 'yes',
						),
					),
					'noData' => array(
						'text' => ( ! empty( $settings[ 'iq_' . $type . '_chart_no_data_text' ] ) ? $settings[ 'iq_' . $type . '_chart_no_data_text' ] : '' ),
					),
					'stroke' => array(
						'width'     => $stock_width,
						'dashArray' => $stock_dash_array,
					),
					'colors' => $gradient_count === 0 ? array( '#ffffff' ) : $gradient,
					'fill'   => array(
						'colors'   => $gradient_count === 0 ? array( '#ffffff' ) : $gradient,
						'gradient' => array(
							'gradientToColors' => $second_gradient_count === 0 ? array( '#ffffff' ) : $second_gradient,
						),
					),
				);

				if ( $type === 'radar' ) {
					unset( $response['chart_option']['stroke'] );
				}

				if ( $type === 'radar' && $response['category_count'] > 0 ) {
					$response['chart_option']['xaxis']['labels']['style']['colors'] = array_fill( 0, $response['category_count'], strval( $settings[ 'iq_' . $type . '_chart_font_color' ] ) );
				}

				if ( $data_type !== 'bubble' ) {
					$response['chart_option']['chart']['dropShadow'] = array( 'enabledOnSeries' => $drop_shadow_series );
				}
				if($type=='counter'){
					if(!empty($response['chart_option']['series'])){
						switch ($settings['iq_' . $type . '_element_counter_operation']) {
							case 'sum':
								if (count($response['chart_option']['series'][0]['multi']) > 0) {
									$response['data']['counter_end'] = array_sum($response['chart_option']['series'][0]['multi']);
								}
								break;
							case 'avg':
								if (count($response['chart_option']['series'][0]['multi']) > 0) {
									$response['data']['counter_end'] = number_format((float)(array_sum($response['chart_option']['series'][0]['multi']) / count($response['chart_option']['series'][0]['multi'])), 2, '.', '');
								}
							
								break;
							case 'percentage':
								if (count($response['chart_option']['series'][0]['multi']) > 0) {
									$sum = array_sum($response['chart_option']['series'][0]['multi']);
									$response['data']['counter_end'] = number_format((float)(($sum * 100) / pow(10, strlen($sum))), 2, '.', '');
								} 
								break;
							default:
								$response['data']['counter_end'] = $response['chart_option']['series'][0]['end'];
							break;
						}
							 
	
						$response['chart_option']['series']= array_map(function($arr){
							return ['name' => $arr['title'],'data'=>$arr['multi'] ] ;
						},$response['chart_option']['series']);
						$response['chart_option']['series'] = [$response['chart_option']['series'][0]];
						$response['category_count'] = count(($response['chart_option']['series']));
					}

				}

				if ( ! in_array( $data_type, array( 'candle', 'bubble', 'circle' ), true ) ) {
					$response['chart_option']['xaxis']['categories'] = ( $response['category_count'] > 0 ? $response['data']['category'] : array() );
				}

				if ( $data_type === 'circle' ) {
					$response['chart_option']['fill']['pattern'] = array(
						'style'       => $fill_pattern,
						'width'       => 6,
						'height'      => 6,
						'strokeWidth' => 2,
					);

					$response['chart_option']['fill']['gradient']['gradientToColors'] = $second_gradient_count === 0 ? array( '#ffffff' ) : $second_gradient;
					$response['chart_option']['stroke']                               = array( 'width' => ( ! empty( $settings[ 'iq_' . $type . '_chart_stroke_width' ] ) ? (int) $settings[ 'iq_' . $type . '_chart_stroke_width' ] : 0 ) );
					$response['chart_option']['labels']                               = ( $response['category_count'] > 0 ? $response['data']['category'] : array() );
					$response['chart_option']['legend']                               = array( 'show' => ! empty( $settings[ 'iq_' . $type . '_chart_legend_show' ] ) && $settings[ 'iq_' . $type . '_chart_legend_show' ] === 'yes' && count( $response['data']['series'] ) > 0 && $response['category_count'] > 0 );
				}

				if ( $type === 'heatmap' ) {
					$response['chart_option']['stroke']['show']  = $settings[ 'iq_' . $type . '_chart_stroke_show' ] === 'yes';
					$response['chart_option']['stroke']['width'] = $settings[ 'iq_' . $type . '_chart_stroke_show' ] === 'yes' && ! empty( $settings[ 'iq_' . $type . '_chart_stroke_width' ] ) ? $settings[ 'iq_' . $type . '_chart_stroke_width' ] : 0;
				}

				if ( count( $response['data']['series'] ) > 0 && isset( $response['data']['series'][0]['data'] ) && count( $response['data']['series'][0]['data'] ) > 1000 ) {
					$response['chart_option']['chart']['animations'] = array(
						'enabled'          => false,
						'dynamicAnimation' => array( 'enabled' => false ),
					);
					$response['instant_init']                        = ! ( ! empty( $settings[ 'iq_' . $type . '_chart_filter_enable' ] ) && $settings[ 'iq_' . $type . '_chart_filter_enable' ] === 'yes' );
					$response['instant_init']                        = apply_filters( 'graphina_chart_redraw', $response['instant_init'] );
				}
			}//end if

			$response['filter_enable'] = ! empty( $settings[ 'iq_' . $type . '_chart_filter_enable' ] ) && $settings[ 'iq_' . $type . '_chart_filter_enable' ] === 'yes';
			$response['status']        = true;
			$response['chart_id']      = $id;
			$response['extra']         = $response['data'];
			unset( $response['data'] );
			wp_send_json( $response );
		} catch ( Exception $exception ) {
			$response['error_exception'] = $exception->getMessage();
			wp_send_json( $response );
		}
	}

	/**
	 * Handles AJAX request to fetch jQuery datatable data.
	 *
	 * Retrieves data based on the provided chart ID and settings.
	 * Supports manual, dynamic, Forminator, and Firebase data options.
	 *
	 * @return void
	 */
	public function action_get_jquery_datatable_data(): void {

		$id       = ! empty( $_POST['chart_id'] ) ? sanitize_text_field( wp_unslash( $_POST['chart_id'] ) ) : '';
		$response = array(
			'status'   => false,
			'table_id' => $id,
			'data'     => array(
				'head' => array(),
				'body' => array(),
			),
		);
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'get_jquery_datatable_data' ) ) {
			wp_send_json( $response );
		}
		$request_data = graphina_recursive_sanitize_textfield( $_POST );
		try {
			$settings        = $request_data['fields'];
			$type            = $request_data['chart_type'];
			$data_option     = $settings[ 'iq_' . $type . '_chart_data_option' ];
			$data            = array();
			$this->widget_id = $id;
			$this->settings  = $settings;
			$class           = esc_attr( apply_filters( 'graphina_widget_table_url_class', '', $settings, $id ) );

			switch ( $data_option ) {
				case 'manual':
					for ( $i = 0; $i < $settings[ 'iq_' . $type . '_element_columns' ]; $i++ ) {
						$data['header'][] = $settings[ 'iq_' . $type . '_chart_header_title_' . $i ];
					}

					for ( $i = 0; $i < $settings[ 'iq_' . $type . '_element_rows' ]; $i++ ) {
						$row_list = $settings[ 'iq_' . $type . '_row_list' . $i ];
						foreach ( $row_list as $row ) {
							$row_value = $row[ 'iq_' . $type . '_row_value' ];
							if ( $row[ 'iq_' . $type . '_row_url' ] === 'yes' && ! empty( $row[ 'iq_' . $type . '_row_link_text' ] ) ) {
								$url       = esc_url( $row[ 'iq_' . $type . '_row_link_text' ] );
								$value     = esc_html( $row[ 'iq_' . $type . '_row_value' ] );
								$row_value = "<a href='{$url}' target='_blank' class='{$class}'>{$value}</a>";
							}

							$data['body'][ $i ][] = $row_value;
						}
					}
					break;

				case 'dynamic':
					if ( graphina_pro_active() ) {
						$data = graphina_pro_datatable_content( $this, $settings, $type );
					}
					break;

				case 'forminator':
					if ( graphina_forminator_addon_active() ) {
						$data = apply_filters( 'graphina_forminator_addon_data', $data, $type, $settings );
					}
					break;

				case 'firebase':
					$data = apply_filters( 'graphina_addons_render_section', $data, $type, $settings );
					break;
			}

			if ( empty( $data['header'] ) || ! is_array( $data['header'] ) ) {
				wp_send_json( $response );
			}

			$data['body'] = array_map(
				function ( $value ) use ( $data, $class ) {
					if ( count( $value ) !== count( $data['header'] ) ) {
						$diff = ( count( $data['header'] ) - count( $value ) );
						if ( $diff < 0 ) {
							$value = array_slice( $value, 0, count( $data['header'] ) );
						} else {
							$empty_value = array_fill( 0, $diff, '-' );
							$value       = array_merge( $value, $empty_value );
						}
					}

					return array_map(
						function ( $item ) use ( $class ) {
							if ( preg_match( '/\[(.*?)\]\((.*?)\)/', $item, $matches ) ) {
								$url = $matches[2];
								// Check if URL is missing protocol, add it if necessary.
								if ( ! preg_match( '~^(?:f|ht)tps?://~i', $url ) ) {
									$url = 'http://' . $url;
								}
								$url   = esc_url( $url );
								$value = esc_html( $matches[1] );

								return "<a href='{$url}' target='_blank' class='{$class}'>{$value}</a>";
							}

							return $item;
						},
						$value
					);
				},
				$data['body']
			);

			$response['status'] = true;
			$response['data']   = $data;
			wp_send_json( $response );
		} catch ( Exception $exception ) {
			$response['error'] = $exception->getMessage();
			wp_send_json( $response );
		}
	}

	/**
	 * Handle AJAX request to restrict access to a Graphina chart by password.
	 *
	 * This function checks the nonce and password to ensure valid access to a specific Graphina chart.
	 * If the nonce or password is invalid, it sends a JSON response with a status of false.
	 * If the validation passes, it sends a JSON response with a status of true and the chart identifier.
	 *
	 * @return void
	 */
	public function action_graphina_restrict_password_ajax(): void {
		// Verify the nonce to ensure the request is legitimate.
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'graphina_restrict_password_ajax' ) ) {
			wp_send_json(
				array(
					'status'  => false,
					'message' => esc_html__( 'Security error', 'graphina-charts-for-elementor' ),
				)
			);
		}

		// Sanitize the entire $_POST array.
		$request_data = graphina_recursive_sanitize_textfield( $_POST );

		// Validate the action and password.
		if ( ! isset( $request_data['action'] ) || $request_data['action'] !== 'graphina_restrict_password_ajax' ||
			! wp_check_password( $request_data['graphina_password'], $request_data['chart_password'] ) ) {
			wp_send_json(
				array(
					'status'  => false,
					'message' => esc_html__( 'Invalid password', 'graphina-charts-for-elementor' ),
				)
			);
		}

		// Send a success response with the chart identifier.
		wp_send_json(
			array(
				'status' => true,
				'chart'  => 'graphina_' . $request_data['chart_type'] . '_' . $request_data['chart_id'],
			)
		);
	}

	/**
	 * Retrieve widget settings.
	 *
	 * This function retrieves the widget settings from the request data. If the settings are empty or insufficient,
	 * it attempts to fetch the settings from the Elementor data for the specified page and element.
	 *
	 * @param array $request_data The request data containing the widget settings and chart ID.
	 *
	 * @return array|null The retrieved or fetched widget settings.
	 */
	public function get_widget_setting( array $request_data ): array|null {
		// Get the settings from the request data.
		$settings = ! empty( $request_data['fields'] ) ? $request_data['fields'] : array();

		// If settings are empty or too few, fetch them from Elementor data.
		if ( empty( $settings ) || count( $settings ) <= 2 ) {
			// Split the chart_id to get the element and page IDs.
			list($element_id, $page_id) = explode( '_', $request_data['chart_id'] );

			$request_data['page_id'] = ! empty( $request_data['page_id'] ) ? $request_data['page_id'] : $page_id;

			$get_settings = new ElementorWidgetSettings( $request_data['page_id'], $element_id, $settings,$page_id );

			$settings = $get_settings->get_settings();
		}

		// Return the settings.
		return $settings;
	}

	/**
	 * Convert data into Google Chart format.
	 *
	 * This function takes data and settings arrays, along with a chart type string,
	 * and formats the data according to the requirements of Google Charts.
	 *
	 * @param array  $data     The data to be formatted. Expected to have 'series' and 'category' keys.
	 * @param array  $settings The settings for the chart. Expected to have specific keys based on the chart type.
	 * @param string $type     The type of Google Chart (e.g., 'pie_google', 'donut_google', etc.).
	 *
	 * @return array Formatted data ready for Google Charts.
	 */
	public function get_google_chart_format_data( array $data, array $settings, string $type ): array {
		$google_chart_data          = array(
			'count'           => 0,
			'title_array'     => array(),
			'data'            => array(),
			'annotation_show' => ! empty( $settings[ 'iq_' . $type . '_chart_annotation_show' ] ) ? $settings[ 'iq_' . $type . '_chart_annotation_show' ] : 'no',
		);
		$google_chart_data['title'] = ! empty( $settings[ 'iq_' . $type . '_chart_haxis_title' ] ) ? (string) $settings[ 'iq_' . $type . '_chart_haxis_title' ] : '';
		if ( ! empty( $data['series'] ) && count( $data['series'] ) > 0
			&& ! empty( $data['category'] ) && count( $data['category'] ) > 0
		) {
			if ( in_array( $type, array( 'pie_google', 'donut_google', 'gauge_google', 'geo_google' ), true ) ) {
				foreach ( $data['category'] as $key => $va ) {
					$google_chart_data['data'][] = array(
						$va,
						$data['series'][ $key ],
					);
				}
			} elseif ( $type === 'org_google' ) {
				foreach ( $data['category'] as $key => $value ) {
					if ( $key >= $settings[ 'iq_' . $type . '_chart_data_series_count' ] ) {
						break;
					}

					if ( ! empty( $value ) && ! empty( $data['series'][0]['data'][ $key ] ) ) {
						$temp = array(
							$value,
							$data['series'][0]['data'][ $key ],
						);
						if ( ! empty( $data['series'][1]['data'][ $key ] ) ) {
							$temp[] = $data['series'][1]['data'][ $key ];
						}

						$google_chart_data['data'][] = $temp;
					}
				}
			} else {
				$google_chart_data['count'] = count( $data['series'] );
				$series_name                = array();
				$x_prefix                   = '';
				$x_postfix                  = '';
				if ( ! empty( $settings[ 'iq_' . $type . '_chart_haxis_label_prefix_postfix' ] ) ) {
					$x_prefix  = $settings[ 'iq_' . $type . '_chart_haxis_label_prefix' ];
					$x_postfix = $settings[ 'iq_' . $type . '_chart_haxis_label_postfix' ];
				}

				foreach ( $data['category'] as $key => $value ) {
					$update_data   = array();
					$series_name   = array();
					$value         = $x_prefix . $value . $x_postfix;
					$update_data[] = $value;
					foreach ( $data['series'] as $value3 ) {
						$series_name[] = $value3['name'];
						$update_data[] = (float) $value3['data'][ $key ];
						if ( $settings[ 'iq_' . $type . '_chart_annotation_show' ] === 'yes' ) {
							if ( ! empty( $settings[ 'iq_' . $type . '_chart_annotation_prefix_postfix' ] ) ) {
								$update_data[] = $settings[ 'iq_' . $type . '_chart_annotation_prefix' ] . (float) $value3['data'][ $key ] . $settings[ 'iq_' . $type . '_chart_annotation_postfix' ];
							} else {
								$update_data[] = strval( $value3['data'][ $key ] );
							}
						}
					}

					$google_chart_data['data'][] = $update_data;
				}

				$google_chart_data['title_array'] = $series_name;
			}
		}

		return $google_chart_data;
	}


	/**
	 * Gets the ID of the widget.
	 *
	 * @return string The widget ID.
	 */
	public function get_id(): string {
		return $this->widget_id;
	}

	/**
	 * Gets the settings for display.
	 *
	 * @return array The settings array for display.
	 */
	public function get_settings_for_display(): array {
		return $this->settings;
	}
}

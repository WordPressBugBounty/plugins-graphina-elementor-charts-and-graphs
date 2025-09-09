<?php

namespace Graphina\Public;

use Exception;
use Graphina\Charts\Elementor\GraphinaElementorWidgetSettings;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * GraphinaFrontend Class
 *
 * Handles the public-facing aspects of the Graphina plugin. This includes:
 * - AJAX actions for chart-related functionality.
 * - Enqueuing frontend scripts.
 * - Managing dynamic chart data and restricted access.
 */
if ( ! class_exists( 'GraphinaFrontend' ) ) {
	class GraphinaFrontend {

		/**
		 * Constructor
		 *
		 * Initializes the class and hooks into WordPress actions for AJAX handling
		 * and script enqueueing.
		 */
		public function __construct() {
			$this->event_Handler();
		}

		/**
		 * Event Handler
		 *
		 * Registers WordPress hooks for AJAX actions and script enqueueing.
		 */
		public function event_Handler() {
			// AJAX for password-restricted charts (logged-in and non-logged-in users).
			add_action( 'wp_ajax_graphina_restrict_password', array( $this, 'graphina_restrict_password' ) );
			add_action( 'wp_ajax_nopriv_graphina_restrict_password', array( $this, 'graphina_restrict_password' ) );

			// Enqueue public scripts.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			// AJAX for retrieving dynamic chart data (logged-in and non-logged-in users).
			add_action( 'wp_ajax_graphina_get_dynamic_data', array( $this, 'graphina_get_dynamic_data' ) );
			add_action( 'wp_ajax_nopriv_graphina_get_dynamic_data', array( $this, 'graphina_get_dynamic_data' ) );
			
			// AJAX for retrieving tree dynamic chart data (logged-in and non-logged-in users).
			add_action( 'wp_ajax_graphina_get_dynamic_tree_data', array( $this, 'graphina_get_dynamic_tree_data' ) );
			add_action( 'wp_ajax_nopriv_graphina_get_dynamic_tree_data', array( $this, 'graphina_get_dynamic_tree_data' ) );

			// AJAX for retrieving dynamic Table data (logged-in and non-logged-in users).
			add_action( 'wp_ajax_get_jquery_datatable_data', array( $this, 'get_jquery_datatable_data' ) );
			add_action( 'wp_ajax_nopriv_get_jquery_datatable_data', array( $this, 'get_jquery_datatable_data' ) );

			// Localize
			add_action( 'init', array( $this, 'include_i18n' ) );
		}

		/**
         * Include i18n
         *
         * Loads the plugin's internationalization files.
         */
		public function include_i18n() {
			include_once GRAPHINA_PATH . 'static/gcfe-i18n.php';
		}


		/**
		 * Enqueue Scripts
		 *
		 * Loads the required JavaScript for the public-facing side of the plugin.
		 * Registers localized script data for AJAX endpoints and other settings.
		 */
		public function enqueue_scripts() {
			// Register and enqueue the main public-facing script using Kucrut Vite.
			\Kucrut\Vite\graphina_enqueue_asset(
				GRAPHINA_PATH . 'dist',
				'assets/js/public-main.js',
				array(
					'handle'           => 'graphina-public',
					'dependencies'     => array(),
					'css-dependencies' => array(),
					'css-media'        => 'all',
					'version'          => GRAPHINA_VERSION,
					'css-only'         => false,
					'in-footer'        => true,
				)
			);

			$localize_data = array(
					'ajaxurl'               		=> admin_url( 'admin-ajax.php' ),
					'nonce'                 		=> wp_create_nonce( 'graphina_get_dynamic_data' ),
					'tree_nonce'					=> wp_create_nonce('graphina_get_dynamic_tree_data'),
					'table_nonce'           		=> wp_create_nonce( 'get_jquery_datatable_data' ),
					'locale_with_hyphen'    		=> graphina_common_setting_get('thousand_seperator_local'),
					'graphinaChartSettings' 		=> array(), // Placeholder for chart settings.
					'view_port'             		=> graphina_common_setting_get( 'view_port' ),
					'enable_chart_filter'           => graphina_common_setting_get( 'enable_chart_filter' ),
					'no_data_available'     		=> esc_html__( 'No Data Available', 'graphina-charts-for-elementor' ),
					'provinceSupportedCountries' 	=> array('US', 'CA', 'MX', 'BR', 'AR', 'DE', 'IT', 'ES', 'GB', 'AU', 'IN', 'CN', 'JP', 'RU', 'FR'),
					'loading_btn'          	 		=> esc_html__( 'Loading...', 'graphina-charts-for-elementor' ),
			);

			// Apply the hook to allow modifications
			$localize_data = apply_filters( 'gcfe_localize_graphina_settings', $localize_data );

			// Prepare localized data for the public script.
			wp_localize_script(
				'graphina-public',
				'gcfe_public_localize',
				$localize_data
			);
		}

		/**
		 * Restrict Password
		 *
		 * Handles password protection for charts. Validates requests using nonces
		 * and ensures passwords match before granting access.
		 *
		 * AJAX Action: `graphina_restrict_password`
		 */
		public function graphina_restrict_password() {
			// Verify nonce for security.
			if ( ! isset( $_GET['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_GET['nonce'] ), 'graphina_restrict_password' ) ) {
				wp_send_json(
					array(
						'status'  => array( $_GET['nonce'] ),
						'message' => esc_html__( 'Security error', 'graphina-charts-for-elementor' ),
					)
				);
			}

			// Sanitize request data.
			$request_data = graphina_recursive_sanitize_textfield( $_GET );

			// Validate action and password.
			if (
				! isset( $request_data['action'] ) || $request_data['action'] !== 'graphina_restrict_password' ||
				! wp_check_password( $request_data['graphina_password'], $request_data['chart_password'] )
			) {
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
		 * Retrieve Elementor widget settings.
		 *
		 * This method fetches the widget settings from the provided request data. If the settings
		 * are missing or insufficient, it retrieves them from the Elementor widget data.
		 *
		 * @param array $request_data An associative array containing request data, including widget settings and IDs.
		 * @return array|null The widget settings if available; null otherwise.
		 */
		public function get_widget_setting( array $request_data ): array|null {
			// Extract settings from the request data if present, or default to an empty array.
			$settings = isset($_POST['settings']) ? json_decode(stripslashes($_POST['settings']), true) :  array();
			
			// If settings are missing or insufficient, fetch them using the Elementor data.
			if ( empty( $settings ) || count( $settings ) <= 2 ) {
				$element_id = $request_data['element_id'];
				$post_id    = $request_data['post_id'] ?? get_queried_object_id();

				// Initialize the Graphina Elementor Widget Settings class.
				$widget_settings = new GraphinaElementorWidgetSettings( $post_id, $element_id, $settings);

				// Retrieve settings from the Elementor widget.
				$settings = $widget_settings->get_settings();
			}

			// Return the resolved settings.
			return $settings;
		}

		/**
		 * Retrieves and processes data for jQuery DataTables.
		 *
		 * This function fetches and returns table data for different sources such as dynamic data,
		 * Forminator, and Firebase. It ensures data integrity and security using nonce verification
		 * and sanitization before processing.
		 *
		 * @since 1.0.0
		 */
		public function get_jquery_datatable_data(): void {
			// Verify nonce for security
			if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'get_jquery_datatable_data' ) ) {
				wp_send_json_error(
					array(
						'status'  => false,
						'message' => __( 'Invalid nonce.', 'graphina-charts-for-elementor' ),
					)
				);
			}

			// Sanitize and fetch request data
			$request_data = graphina_recursive_sanitize_textfield( $_POST );
			$id           = ! empty( $request_data['element_id'] ) ? sanitize_text_field( $request_data['element_id'] ) : '';

			// Default response structure
			$response = array(
				'status'   => false,
				'table_id' => $id,
				'data'     => array(
					'header' => array(),
					'body' => array(),
				),
			);

			try {
				// Fetch widget settings
				$settings = $this->get_widget_setting( $request_data );

				// Determine table type and data source
				$table_type  = $request_data['chartType'] ?? '';

				$data_option = ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_element_data_option' ] ) ? $settings[ GRAPHINA_PREFIX . $table_type . '_element_data_option' ] : '';
				if( empty( $data_option ) ) {
					$data_option = ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_chart_data_option' ] ) ? $settings[ GRAPHINA_PREFIX . $table_type . '_chart_data_option' ] : '';
				}
				$selected_item = array();
				// Handle chart filter defaults if no field is selected in the request.
				if ( empty( $request_data['selected_field'] ) && ! empty( $settings[ GRAPHINA_PREFIX . "{$table_type}_chart_filter_list" ] ) ) {
					foreach ( $settings[ GRAPHINA_PREFIX . "{$table_type}_chart_filter_list" ] as $item ) {
						if ( isset( $item[ GRAPHINA_PREFIX . "{$table_type}_chart_filter_type" ] ) && $item[ GRAPHINA_PREFIX . "{$table_type}_chart_filter_type" ] === 'date' ) {
							list($first_value) = explode( ' ', $item[ GRAPHINA_PREFIX . "{$table_type}_chart_filter_datetime_default" ] );
						} else {
							$first_value = explode( ',', $item[ GRAPHINA_PREFIX . "{$table_type}_chart_filter_value" ] )[0];
						}
						$selected_item[] = $first_value;
					}
				} else {
					$selected_item = $request_data['selected_field'] ?? array();
				}

				$data        = array();
				$class       = esc_attr( apply_filters( 'graphina_widget_table_url_class', '', $settings, $id ) );

				// Retrieve table data based on data option
				switch ( $data_option ) {
					case 'dynamic':
						if ( graphina_pro_active() ) {
							$data = apply_filters( 'graphina_pro_datatable_content', $settings, $table_type, $id, $selected_item );
						}
						break;
					case 'forminator':
						$data = apply_filters( 'graphina_forminator_addon_data', $data, $table_type, $settings );
						break;
					case 'firebase':
						$data = apply_filters( 'graphina_addons_render_section', $data, $table_type, $settings );
						break;
				}

				if ( 'counter' === $table_type ) {
					$operation = ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_element_counter_operation' ] )
					? sanitize_text_field( $settings[ GRAPHINA_PREFIX . $table_type . '_element_counter_operation' ] )
					: 'none';

					$column_no = $settings[ GRAPHINA_PREFIX . $table_type . '_element_column_no' ];
					$title 	   = match ($settings[ GRAPHINA_PREFIX . $table_type . '_element_column_no' ]) {
						'1' 	=> $data[intval($column_no) - 1 ]['title'],
						'2' 	=> $data[intval($column_no) - 1 ]['title'],
						'3' 	=> $data[intval($column_no) - 1 ]['title'],
						'4' 	=> $data[intval($column_no) - 1 ]['title'],
						'5' 	=> $data[intval($column_no) - 1 ]['title'],
						'6' 	=> $data[intval($column_no) - 1 ]['title'],
						'7' 	=> $data[intval($column_no) - 1 ]['title'],
						'8' 	=> $data[intval($column_no) - 1 ]['title'],
						'9' 	=> $data[intval($column_no) - 1 ]['title'],
						'10' 	=> $data[intval($column_no) - 1 ]['title'],
						'11' 	=> $data[intval($column_no) - 1 ]['title'],
						'12' 	=> $data[intval($column_no) - 1 ]['title'],
						'13' 	=> $data[intval($column_no) - 1 ]['title'],
						'14' 	=> $data[intval($column_no) - 1 ]['title'],
						'15' 	=> $data[intval($column_no) - 1 ]['title'],
						'16' 	=> $data[intval($column_no) - 1 ]['title'],
						'17' 	=> $data[intval($column_no) - 1 ]['title'],
						'18' 	=> $data[intval($column_no) - 1 ]['title'],
						'19' 	=> $data[intval($column_no) - 1 ]['title'],
						'20' 	=> $data[intval($column_no) - 1 ]['title'],
						'21' 	=> $data[intval($column_no) - 1 ]['title'],
						'22' 	=> $data[intval($column_no) - 1 ]['title'],
						'23' 	=> $data[intval($column_no) - 1 ]['title'],
						'24' 	=> $data[intval($column_no) - 1 ]['title'],
						'25' 	=> $data[intval($column_no) - 1 ]['title'],
						'26' 	=> $data[intval($column_no) - 1 ]['title'],
						default => $settings[ GRAPHINA_PREFIX . $table_type . '_element_column_no' ],
					};
					$series    = $columns = array();
					$end       = '';
					$i         = $j = 0;
					$chart_title = '';
					if(empty($title)){
						$title = $data[0]['title'];
					}
					foreach ( $data as $key => $value ) {
						$data_title    = strtolower( str_replace( ' ', '', $data[ $key ]['title'] ) );
						$columns[ $j ] = $data_title;
						if (empty($value['multi']) || (is_array($value['multi']) && count($value['multi']) === 0)) {
							continue;
						}
						if ( $data_title === strtolower( str_replace( ' ', '', $title ) ) ) {
							$chart_title = $data[ $key ]['title'];
							$series[ $i ]['name'] = $data[ $key ]['title'];
							$series[ $i ]['data'] = $data[ $key ]['multi'];
							if ( $operation === 'sum' ) {
								$end = array_sum( $value['multi'] );
							} elseif ( $operation === 'avg' && ! empty( $values ) ) {
								// Calculate the average
								$end = count( $value['multi'] ) > 0 ? array_sum( $value['multi'] ) / count( $value['multi'] ) : 0;
							} elseif ( $operation === 'percentage' ) {
								$total_sum = array_sum( $value['multi'] );
								$end       = number_format( (float) ( ( $total_sum * 100 ) / pow( 10, strlen( $total_sum ) ) ), 2, '.', '' );
							} else {
								$end = max( $value['multi'] );
							}
							++$i;
						}
						++$j;
						$data[ $key ]['end'] = max( $value['multi'] );
					}
					$columns = array_merge(array( __( 'Select Column', 'graphina-charts-for-elementor' )),$columns);
					if ( count( $columns ) === 0 ) {
						$columns = array( __( 'Empty', 'graphina-charts-for-elementor' ) );
					}
					$response['extra'] = array(
						'series'  => $series,
						'end'     => floatval( $end ),
						'columns' => $columns,
						'title'	  => $chart_title
					);

					$response['status'] = true;
					$response['data']   = $data;
					wp_send_json( $response );
				}
				// Validate data structure
				if ( empty( $data['header'] ) || ! is_array( $data['header'] ) ) {
					wp_send_json( $response );
				}

				// Process table body data
				$data['body'] = array_map(
					function ( $row ) use ( $data,$table_type, $class ) {
						$header_count = count( $data['header'] );
						$row_count    = count( $row );

						// Ensure each row matches the header column count
						if ( $row_count !== $header_count ) {
							$diff = $header_count - $row_count;
							$row  = ( $diff > 0 )
								? array_merge( $row, array_fill( 0, $diff, '-' ) )
								: array_slice( $row, 0, $header_count );
						}

						if( 'data_table_lite' === $table_type ){
							$row = array_map(function($row_value){
								return apply_filters('graphina_jquery_row_value',$row_value);
							},$row);
						}
						// Sanitize and format each row item
						return array_map(
							function ( $item ) use ( $class ) {
						
								// Replace markdown links inline while keeping other text
								$item = preg_replace_callback(
									'/\[(.*?)\]\((.*?)\)/',
									function ( $match ) use ( $class ) {
										$url  = esc_url( filter_var( $match[2], FILTER_VALIDATE_URL ) ? $match[2] : 'http://' . $match[2] );
										$text = esc_html( $match[1] );
										return "<a href='{$url}' target='_blank' class='{$class}'>{$text}</a>";
									},
									$item
								);
						
								// Allowed HTML tags
								$allowed_html = array(
									'a'    => array(
										'href'   => array(),
										'target' => array(),
										'class'  => array()
									),
									'div'  => array( 'class' => array(), 'style' => array() ),
									'span' => array( 'class' => array(), 'style' => array() )
								);
						
								return wp_kses( $item, $allowed_html );
							},
							$row
						);
						
					},
					$data['body']
				);

				// Update response and return success
				$response['status'] = true;
				$response['data']   = $data;
				wp_send_json( $response );

			}  catch ( Exception $exception ) {
				// Handle errors gracefully
				wp_send_json(
					array(
						'status'  => false,
						'message' => $exception->getMessage(),
					)
				);
			}
		}

		/**
		 * Retrieve Dynamic data.
		 *
		 * @param array $request_data An associative array containing request data, including widget settings and IDs.
		 * @param array $widget_data An associative array containing
		 * Handles AJAX requests to retrieve dynamic chart data.
		 *
		 * This method processes incoming requests, validates them, retrieves the relevant
		 * chart data based on the type, and returns the formatted response.
		 *
		 * The response includes chart data, options, Google Chart-specific configurations,
		 * and other necessary details for rendering the chart dynamically on the frontend.
		 *
		 * @return void Sends a JSON response back to the AJAX request.
		 */
		public function graphina_get_dynamic_data() {
			// Initialize the response array with default values.
			$response = array(
				'status'            => false,  // Indicates whether the request was successful.
				'instant_init'      => false,  // Reserved for any instant initialization flag.
				'fail'              => false,  // Indicates if the request failed.
				'fail_message'      => '',     // Message describing the failure reason.
				'chart_id'          => -1,     // Default chart ID (overwritten if valid data is found).
				'chart_option'      => array(  // Default chart options.
					'chart' => array(
						'dropShadow' => array(
							'enabledOnSeries' => array(), // Placeholder for enabled series shadow.
						),
					),
				),
				'filter_enable'     => false,  // Indicates if filtering is enabled for the chart.
				'google_chart_data' => array( // Placeholder for Google Chart-specific data.
					'count'       => 0,
					'title_array' => array(),
					'data'        => array(),
					'title'       => '',
				),
				'category_count'    => 0,     // Count of categories in the chart.
				'data'              => array( // Placeholder for Apex chart-specific data.
					'series'       => array(),
					'category'     => array(),
					'fail_message' => '',
					'fail'         => false,
				),
			);

			// Verify the nonce for security.
			if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'graphina_get_dynamic_data' ) ) {
				wp_send_json( $response );
			}

			// Allow filters to modify the default response before further processing.
			$response = apply_filters( 'graphina_get_dynamic_data', $response );

			try {
				// Sanitize and parse the incoming request data.
				$request_data = graphina_recursive_sanitize_textfield( $_POST );

				// Retrieve widget settings for the requested chart.
				$settings = $this->get_widget_setting( $request_data );

				// Determine the chart type and element ID.
				$chart_type = $request_data['chartType'];
				$id         = $request_data['element_id'];

				// Handle chart filter defaults if no field is selected in the request.
				$selected_item = array();
				if ( empty( $request_data['selected_field'] ) && ! empty( $settings[ GRAPHINA_PREFIX . "{$chart_type}_chart_filter_list" ] ) ) {
					foreach ( $settings[ GRAPHINA_PREFIX . "{$chart_type}_chart_filter_list" ] as $item ) {
						if ( isset( $item[ GRAPHINA_PREFIX . "{$chart_type}_chart_filter_type" ] ) && $item[ GRAPHINA_PREFIX . "{$chart_type}_chart_filter_type" ] === 'date' ) {
							list($first_value) = explode( ' ', $item[ GRAPHINA_PREFIX . "{$chart_type}_chart_filter_datetime_default" ] );
						} else {
							$first_value = explode( ',', $item[ GRAPHINA_PREFIX . "{$chart_type}_chart_filter_value" ] )[0];
						}
						$selected_item[] = $first_value;
					}
				} else {
					$selected_item = $request_data['selected_field'] ?? array();
				}

				// Match chart types to their corresponding data formats.
				$data_type = match ( $chart_type ) {
					'distributed_column', 'line', 'area', 'column', 'heatmap', 'radar', 'line_google',
					'column_google', 'bar_google', 'scatter', 'mixed', 'area_google' => 'area',
					'donut', 'polar', 'pie', 'data-tables', 'radial', 'pie_google',
					'donut_google', 'gauge_google', 'geo_google' => 'circle',
					'timeline' => 'timeline',
					'org_google' => 'org_google',
					'brush' => 'area',
					default => $chart_type,
				};

				$series_count = $request_data['series_count'];
				// Process dynamic chart data if enabled in settings.
				if ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_option' ] !== 'manual' ) {
					if ( graphina_pro_active() && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_option' ] !== 'forminator' ) {
						$response['data'] = apply_filters( 'graphina_pro_dynamic_chart_content', $settings, $id, $chart_type, $data_type, $selected_item, $series_count );
					}
					if ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_option' ] === 'forminator' ) {
							$response['data'] = apply_filters( 'graphina_forminator_addon_data', $response['data'], $chart_type, $settings );
					}

					// Handle permission-related failures.
					if ( ! empty( $response['data']['fail'] ) && $response['data']['fail'] === 'permission' ) {
						$response['fail']         = true;
						$response['status']       = true;
						$response['fail_message'] = $response['data']['fail_message'] ?? '';
						$response['chart_id']     = $id;
						$response['chart_option'] = array();
						wp_send_json( $response );
					}
				}

				// Count the number of categories in the chart.
				$response['category_count'] = ! empty( $response['data']['category'] ) && is_array( $response['data']['category'] )
					? count( $response['data']['category'] )
					: 0;

				// Determine whether the chart is a Google Chart or Apex Chart and format accordingly.
				if ( in_array( $chart_type, graphina_google_chart_lists() ) ) {
					$response['google_chart_data'] = $this->graphina_google_chart_data_format( $response['data'], $settings, $chart_type );
				} else {
					$response['chart_option'] = $this->graphina_apex_chart_data_format( $response, $settings, $chart_type );
					if ( 'mixed' === $chart_type ) {
						$response['data']['series'] = $response['chart_option']['series'];
					}
					if ( $chart_type === 'distributed_column' && isset( $response['data']['series'][0]['data'] ) ) {
						$response['data']['series'] = array( $response['data']['series'][0] );
						if ( is_array( $response['data']['series'][0]['data'] ) ) {
							$response['data']['series'][0]['data'] = array_slice( $response['data']['series'][0]['data'], 0, $series_count );
							$response['data']['category']          = array_slice( $response['data']['category'], 0, $series_count );
						}
					}
				}

				// Enable filter flag if specified in settings.
				$response['filter_enable'] = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_enable' ] )
					&& $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_enable' ] === 'yes';

				// Finalize the response with additional details.
				$response['status']   = true;
				$response['chart_id'] = $id;
				$response['extra']    = $response['data'];
				unset( $response['data'] );

				// Send the JSON response.
				wp_send_json( $response );

			} catch ( Exception $exception ) {
				// Handle exceptions and include error details in the response.
				$response['error_exception'] = $exception->getMessage();
				wp_send_json( $response );
			}
		}

		public function graphina_get_dynamic_tree_data(){

			$response = array(
				'status'            => false,  // Indicates whether the request was successful.
				'instant_init'      => false,  // Reserved for any instant initialization flag.
				'fail'              => false,  // Indicates if the request failed.
				'fail_message'      => '',     // Message describing the failure reason.
				'chart_id'          => -1,     // Default chart ID (overwritten if valid data is found).
				'chart_option'      => array(  // Default chart options.
					'chart' => array(
						'dropShadow' => array(
							'enabledOnSeries' => array(), // Placeholder for enabled series shadow.
						),
					),
				),
				'filter_enable'     => false,  // Indicates if filtering is enabled for the chart.
				'google_chart_data' => array( // Placeholder for Google Chart-specific data.
					'count'       => 0,
					'title_array' => array(),
					'data'        => array(),
					'title'       => '',
				),
				'category_count'    => 0,     // Count of categories in the chart.
				'data'              => array( // Placeholder for Apex chart-specific data.
					'series'       => array(),
					'category'     => array(),
					'fail_message' => '',
					'fail'         => false,
				),
			);
			

			// Sanitize and fetch request data
			$request_data = graphina_recursive_sanitize_textfield( $_POST );
			$id           = ! empty( $request_data['element_id'] ) ? sanitize_text_field( $request_data['element_id'] ) : '';
			$chart_type   = ! empty( $request_data['chartType'] ) ? sanitize_text_field( $request_data['chartType'] ) : '';	
			// Fetch widget settings
			$settings = $this->get_widget_setting( $request_data );

			$selected_item = array();
			// Handle chart filter defaults if no field is selected in the request.
			if ( empty( $request_data['selected_field'] ) && ! empty( $settings[ GRAPHINA_PREFIX . "{$chart_type}_chart_filter_list" ] ) ) {
				foreach ( $settings[ GRAPHINA_PREFIX . "{$chart_type}_chart_filter_list" ] as $item ) {
					if ( isset( $item[ GRAPHINA_PREFIX . "{$chart_type}_chart_filter_type" ] ) && $item[ GRAPHINA_PREFIX . "{$chart_type}_chart_filter_type" ] === 'date' ) {
						list($first_value) = explode( ' ', $item[ GRAPHINA_PREFIX . "{$chart_type}_chart_filter_datetime_default" ] );
					} else {
						$first_value = explode( ',', $item[ GRAPHINA_PREFIX . "{$chart_type}_chart_filter_value" ] )[0];
					}
					$selected_item[] = $first_value;
				}
			} else {
				$selected_item = $request_data['selected_field'] ?? array();
			}
			$series_count = isset($settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' ]) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' ] : 0;
			$response['chart_data'] = apply_filters( 'graphina_pro_dynamic_tree_chart_content', $settings, $id, $chart_type, $series_count, $selected_item );
		
			$response['status']   = true;
			$response['chart_id'] = $id;
			
			// Send the JSON response.
			wp_send_json( $response );
		}
		/**
		 * Summary of graphina_apex_chart_data_format
		 * @param mixed $response
		 * @param mixed $settings
		 * @param mixed $chart_type
		 * @return array[]|array{chart: array, dataLabels: array, legend: array{horizontalAlign: mixed, position: mixed, show: bool, showForSingleSeries: bool, noData: array{text: mixed}, series: mixed, tooltip: array{enabled: mixed, theme: mixed}, xaxis: array, yaxis: array}}
		 *
		 * Get widget settings for a specific chart.
         *
         * @param array $request_data Incoming request data.
         * @return array Widget settings for the requested chart.
		 * @throws Exception
		 */
		private function graphina_apex_chart_data_format( $response, $settings, $chart_type ) {
			$gradient           = array();
			$second_gradient    = array();
			$drop_shadow_series = array();
			$stock_width        = array();
			$stock_dash_array   = array();
			$fill_pattern       = array();
			$yaxisYesCount      = 0;
			$defaultChartType   = 'line';

			if ( 'mixed' === $chart_type ) {
				$defaultYaxis = array(
					'style' => array(
						'colors'     => strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ] ),
						'fontSize'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px',
						'fontFamily' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ],
						'fontWeight' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight' ],
					),
				);
			}

			$series_count = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' ] : 0;
			for ( $i = 0; $i < $series_count; $i++ ) {
				$drop_shadow_series[] = $i;
				$gradient[]           = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_1_' . $i ] ) ? strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_1_' . $i ] ) : '';
				$second_gradient[]    = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_2_' . $i ] ) ? strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_2_' . $i ] ) : ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_1_' . $i ] ) ? strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_1_' . $i ] ) : '' );
				$stock_width[]        = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_width_3_' . $i ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_width_3_' . $i ] : 0;
				$stock_dash_array[]   = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_dash_3_' . $i ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_dash_3_' . $i ] : 0;
				$fill_pattern[]       = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_bg_pattern_' . $i ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_bg_pattern_' . $i ] : 'verticalLines';

				// mixed chart
				if ( 'mixed' === $chart_type ) {
					$chartTypes[]        = $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_type_3_' . $i ];
					$fillType[]          = ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_type_3_' . $i ] === 'line' && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type_' . $i ] === 'pattern' ) ? 'classic' : $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type_' . $i ];
					$fillOpacity[]       = ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_type_3_' . $i ] === 'line' && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_fill_style_type_' . $i ] === 'pattern' ) ? 1 : $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_fill_opacity_' . $i ];
					$color1[]            = strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_3_1_' . $i ] );
					$color2[]            = strval( isset( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_3_2_' . $i ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_3_2_' . $i ] : '#ffffff' );
					$fill_pattern[]      = $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_pattern_3_' . $i ];
					$opacityFrom[]       = isset( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_fill_opacityFrom_' . $i ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_fill_opacityFrom_' . $i ] : 1;
					$opacityTo[]         = isset( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_fill_opacityTo_' . $i ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_fill_opacityTo_' . $i ] : 1;
					$strokeCurves[]      = $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_stroke_curve_3_' . $i ];
					$strokeWidths[]      = $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_stroke_width_3_' . $i ];
					$strokeDashArray[]   = $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_stroke_dash_3_' . $i ];
					$markerSize[]        = $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_marker_size_' . $i ];
					$markerStrokeColor[] = strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_marker_stroke_color_' . $i ] );
					$markerStokeWidth[]  = $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_marker_stroke_width_' . $i ];
					$markerShape[]       = strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_chart_marker_stroke_shape_' . $i ] );
					if ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_drop_shadow_enabled_3_' . $i ] === 'yes' ) {
						$dropShadowColor[]     = strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_drop_shadow_color_3_' . $i ] );
						$dropShadowEnabledOn[] = $i;
					} else {
						$dropShadowColor[] = strval( '#FFFFFF00' );
					}
					if ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show_3_' . $i ] === 'yes' ) {
						$dataLabelEnabledOn[] = $i;
					}
					if ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_show_multiple_yaxis' ] === 'yes' ) {
						$yaxis[] = array(
							'show'            => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_show_3_' . $i ] === 'yes',
							'opposite'        => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_opposite_3_' . $i ] === 'yes',
							'tickAmount'      => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_tick_amount' ],
							'decimalsInFloat' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_decimals_in_float' ],
							'title'           => array(
								'text' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title_3_' . $i ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title_3_' . $i ] : '',
							),
							'labels'          => $defaultYaxis,
							'tooltip'         => array(
								'enabled' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_tooltip_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_tooltip_show' ] === 'yes',
							),
							'crosshairs'      => array(
								'show' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_crosshairs_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_crosshairs_show' ] === 'yes',
							),
						);
						if ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_show_3_' . $i ] === 'yes' ) {
							++$yaxisYesCount;
						}
					}
					if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared' ] === 'yes' ) {
						if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_enabled_on_1_' . $i ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_enabled_on_1_' . $i ] === 'yes' ) {
							$tooltipSeries[] = $i;
						}
					} else {
						$tooltipSeries[] = $i;
					}
				}
			}

			if ( $chart_type === 'distributed_column' && isset( $response['data']['series'][0]['data'] ) ) {
				$response['data']['series'] = array( $response['data']['series'][0] );
				if ( is_array( $response['data']['series'][0]['data'] ) ) {
					$response['data']['series'][0]['data'] = array_slice( $response['data']['series'][0]['data'], 0, $series_count );
					$response['data']['category']          = array_slice( $response['data']['category'], 0, $series_count );
				}
			}

			if ( 'nested_column' === $chart_type ) {
				$gradient_new = array();
				while ( count( $gradient_new ) < count( $response['data']['series'] ) ) {
					$gradient_new = array_merge( $gradient_new, $gradient );
				}
				foreach ( $response['data']['series'] as $key => $val ) {
					$sum = 0;
					foreach ( $val['quarters'] as $k1 => $v1 ) {
						$sum += (float) $v1['y'];
					}
					$response['data']['series'][ $key ]['y']     = $sum;
					$response['data']['series'][ $key ]['color'] = $gradient_new[ $key ];
				}
			}

			// Mixed Chart
			if ( 'mixed' === $chart_type ) {
				if ( count( $chartTypes ) > 0 && $defaultChartType === $chartTypes[0] && $chartTypes[0] === 'line' ) {
					$defaultChartType = 'area';
				}

				$new_data = array(
					'chart_type'             => array(),
					'fill_type'              => array(),
					'fill_opacity'           => array(),
					'opacity_from'           => array(),
					'opacity_to'             => array(),
					'drop_shadow_color'      => array(),
					'drop_shadow_enabled_on' => array(),
					'data_label_enabled_on'  => array(),
					'stroke_curves'          => array(),
					'stroke_widths'          => array(),
					'stroke_dash_array'      => array(),
					'color1'                 => array(),
					'color2'                 => array(),
					'fill_pattern'           => array(),
				);

				if ( is_array( $response['data']['series'] ) ) {
					$desiredLength = count( $response['data']['series'] );
				}
				while ( count( $new_data['chart_type'] ) < $desiredLength ) {
					$new_data['chart_type']        = array_merge( $new_data['chart_type'], $chartTypes );
					$new_data['fill_type']         = array_merge( $new_data['fill_type'], $fillType );
					$new_data['fill_opacity']      = array_merge( $new_data['fill_opacity'], $fillOpacity );
					$new_data['opacity_from']      = array_merge( $new_data['opacity_from'], $opacityFrom );
					$new_data['opacity_to']        = array_merge( $new_data['opacity_to'], $opacityTo );
					$new_data['stroke_curves']     = array_merge( $new_data['stroke_curves'], $strokeCurves );
					$new_data['stroke_widths']     = array_merge( $new_data['stroke_widths'], $strokeWidths );
					$new_data['stroke_dash_array'] = array_merge( $new_data['stroke_dash_array'], $strokeDashArray );
					$new_data['color1']            = array_merge( $new_data['color1'], $color1 );
					$new_data['color2']            = array_merge( $new_data['color2'], $color2 );
					$new_data['fill_pattern']      = array_merge( $new_data['fill_pattern'], $fill_pattern );
				}
				$chartTypes = array_slice( $new_data['chart_type'], 0, $desiredLength );
				foreach ( $response['data']['series'] as $index => $info ) {
					$response['data']['series'][ $index ]['type'] = $chartTypes[ $index ];
				}
			}

			// Chart Options
			$export_file_name = $settings[ GRAPHINA_PREFIX . $chart_type . '_export_filename' ] ?? '';
			$legend_show      = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_show' ] === 'yes' ? true : false;

			$locales       = array(
				generate_chart_locales( get_locale() ),
			);
			$type_of_chart = '';
			if ( 'column' === $chart_type ) {
				$type_of_chart = 'bar';
			} elseif ( 'timeline' === $chart_type ) {
				$type_of_chart = 'rangeBar';
			} elseif ( 'nested_column' === $chart_type ) {
				$type_of_chart = 'bar';
			} else {
				$type_of_chart = $chart_type;
			}
			$chart_options = array(
				'series'     => $response['data']['series'],
				'chart'      => array(
					'background'    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_background_color1' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_background_color1' ] : '',
					'height'        => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_height' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_height' ] : 350,
					'type'          => $type_of_chart,
					'stacked'       => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_area_stacked' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_area_stacked' ] : '',
					'toolbar'       => array(
						'offsetX' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_offsetx' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_offsetx' ] ) : 0,
						'offsetY' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_offsety' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_offsety' ] ) : 0,
						'show'    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_can_chart_show_toolbar' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_can_chart_show_toolbar' ] : '',
						'export'  => array(
							'csv' => array(
								'filename' => esc_js( $export_file_name ),
							),
							'svg' => array(
								'filename' => esc_js( $export_file_name ),
							),
							'png' => array(
								'filename' => esc_js( $export_file_name ),
							),
						),
						'tools'   => array(
							'download' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_download' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_toolbar_download' ] === 'yes' ? true : false,
						),
					),
					'dropShadow'    => array(
						'enabled' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow' ] === 'yes' ? true : false,
						'top'     => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_top' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_top' ] : 0,
						'left'    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_left' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_left' ] : 0,
						'blur'    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_blur' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_blur' ] : 0,
						'color'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_color' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_color' ] : '',
						'opacity' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_opacity' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_opacity' ] : 0,
					),
					'animations'    => array(
						'enabled' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_animation' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_animation' ] === 'yes' ? true : false,
						'speed'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_animation_speed' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_animation_speed' ] : '',
						'delay'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_animation_delay' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_animation_delay' ] : '',
					),

					'locales'       => $locales,
					'defaultLocale' => get_locale(),
				),
				'xaxis'      => array(
					'tickAmount'    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_tick_amount' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_tick_amount' ] ) : 0,
					'tickPlacement' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_tick_placement' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_tick_placement' ] : '',
					'position'      => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_position' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_position' ] : 'buttom',
					'labels'        => array(
						'show'         => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' ] === 'yes' ? true : false,
						'rotateAlways' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_auto_rotate' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_auto_rotate' ] === 'yes' ? true : false,
						'rotate'       => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_rotate' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_rotate' ] ) : 0,
						'offsetX'      => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_offset_x' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_offset_x' ] ) : 0,
						'offsetY'      => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_offset_y' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_offset_y' ] ) : 0,
						'trim'         => true,
					),
					'tooltip'       => array(
						'enabled' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_tooltip_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_tooltip_show' ] === 'yes' ? true : false,
					),
					'crosshairs'    => array(
						'show' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_crosshairs_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_crosshairs_show' ] === 'yes' ? true : false,
					),
				),
				'yaxis'      => array(
					'tickAmount'      => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_tick_amount' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_tick_amount' ] ) : 6,
					'decimalsInFloat' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_decimals_in_float' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_decimals_in_float' ] ) : 1,
					'labels'          => array(
						'show'    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' ] === 'yes' ? true : false,
						'offsetX' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_offset_x' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_offset_x' ] ) : 0,
						'offsetY' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_offset_y' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_offset_y' ] ) : 0,
						'style'   => array(
							'colors' => array( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_card_yaxis_title_font_color' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_card_yaxis_title_font_color' ] : '' ),
						),
					),
					'tooltip'         => array(
						'enabled' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_tooltip_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_tooltip_show' ] === 'yes' ? true : false,
					),
					'crosshairs'      => array(
						'show' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_crosshairs_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_crosshairs_show' ] ? true : false,
					),
				),
				'legend'     => array(
					'showForSingleSeries' => true,
					'show'                => $legend_show,
					'position'            => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_position' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_position' ] : 'buttom',
					'horizontalAlign'     => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_horizontal_align' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_horizontal_align' ] : 'center',
				),
				'dataLabels' => array(
					'enabled'    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_show' ] : false,
					'style'      => array(
						'fontSize'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px',
						'fontFamily' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ] : 'popins',
						'fontWeight' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight' ] : '',
						'colors'     => array( ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show' ] === 'yes' ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_font_color_1' ] : $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ] ) ),
					),
					'background' => array(
						'enabled'      => ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_show' ] === 'yes' ),
						'borderRadius' => intval( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_radius' ] ) ? ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_radius' ] ) : 0 ),
						'foreColor'    => array( ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_background_color' ] ) ),
						'borderWidth'  => intval( ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_width' ] ) ),
						'borderColor'  => ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_border_color' ] ),
					),
				),
				'noData'     => array(
					'text' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_no_data_text' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_no_data_text' ] : '',
				),
				'tooltip'    => array(
					'enabled' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip' ] : '',
					'theme'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_theme' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_theme' ] : '',
				),
			);

			// Mixed Chart
			if ( 'mixed' === $chart_type ) {
				$color1                  = array_slice( $new_data['color1'], 0, $desiredLength );
				$chart_options['colors'] = $color1;
				$chart_options['grid']   = array(
					'borderColor' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_line_grid_color' ] ) ? strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_line_grid_color' ] ) : '#90A4AE',
					'yaxis'       => array(
						'lines' => array(
							'show' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_line_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_line_show' ] === 'yes' ? true : false,
						),
					),
				);

				$chart_options['plotOptions'] = array(
					'bar' => array(
						'borderRadius' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_plot_border_radius' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_plot_border_radius' ] : 0,
						'dataLabels'   => array(
							'position' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_plot_datalabel_position_show' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_plot_datalabel_position_show' ] : 'top',
						),
					),
				);
				$chart_options['stroke']      = array(
					'curve'     => $strokeCurves,
					'lineCap'   => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_stroke_line_cap' ],
					'colors'    => $color1,
					'width'     => $strokeWidths,
					'dashArray' => $strokeDashArray,
				);
				$chart_options['fill']        = array(
					'type'     => $fillType,
					'opacity'  => $fillOpacity,
					'colors'   => $color1,
					'gradient' => array(
						'inverseColors'    => $settings[ GRAPHINA_PREFIX . $chart_type . '_can_chart_fill_inverse_color' ] === 'yes',
						'gradientToColors' => $color2,
						'type'             => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_fill_gradient_type' ],
						'opacityFrom'      => $opacityFrom,
						'opacityTo'        => $opacityTo,
					),
					'pattern'  => array(
						'style'       => $fill_pattern,
						'width'       => 6,
						'height'      => 6,
						'strokeWidth' => 2,
					),
				);
			}

			if ( $chart_type !== 'bubble' ) {
				$chart_options['xaxis']['categories'] = $response['data']['category'];
			}
			if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_area_curve' ] ) ) {
				$chart_options['stroke']['curve'] = $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_area_curve' ];
			}

			if ( $chart_type !== 'column' ) {
				$chart_options['tooltip']['shared'] = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_shared' ] === 'yes' ? true : false;
			}

			$xaxis_title_show = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title_enable' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title_enable' ] === 'yes' ? true : false;

			if ( $xaxis_title_show && ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title' ] ) ) {

				$chart_options['xaxis']['title'] = array(
					'text'    => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title' ],
					'offsetX' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title_offset_x' ],
					'offsetY' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_title_offset_y' ],
					'style'   => array(
						'color'      => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ],
						'fontSize'   => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'],
						'fontFamily' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ],
						'fontWeight' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight' ],
					),
				);
			}

			$yaxis_title_show = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title_enable' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title_enable' ] === 'yes' ? true : false;
			if ( $yaxis_title_show && ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title' ] ) ) {

				$chart_options['yaxis']['title'] = array(
					'text'  => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_title' ],
					'style' => array(
						'color'      => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ],
						'fontSize'   => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'],
						'fontFamily' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ],
						'fontWeight' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight' ],
					),
				);
			}

			$yaxis_enable_min_man = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_enable_min_max' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_enable_min_max' ] === 'yes' ? true : false;

			if ( $yaxis_enable_min_man ) {
				$chart_options['yaxis']['min'] = floatval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_min_value' ] ) ?? 0;
				$chart_options['yaxis']['max'] = floatval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_max_value' ] ) ?? 250;
			}

			if ( ! $legend_show ) {
				$chart_options['legend'] = array(
					'showForSingleSeries' => true,
					'show'                => false,
				);
			}

			$is_zero_indicator = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_show' ] === 'yes' ? true : false;

			if ( $is_zero_indicator ) {
				$chart_options['annotations']['yaxis'] = array(
					array(
						'y'               => 0,
						'strokeDashArray' => intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_stroke_dash' ] ) ?? 6,
						'borderColor'     => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_stroke_color' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_0_indicator_stroke_color' ] : '#000000',
					),
				);
			}

			return $chart_options;
		}

		/**
		 * Prepare and format data for Google Charts.
		 *
		 * This function processes the chart data based on the settings and chart type,
		 * preparing it for rendering in Google Charts. It supports various chart types
		 * like pie, donut, gauge, geo, org, and others, handling their specific data requirements.
		 *
		 * @param array  $data      The chart data containing series and categories.
		 * @param array  $settings  The chart settings defined by the user.
		 * @param string $chart_type The type of Google Chart (e.g., pie_google, org_google).
		 *
		 * @return array The formatted data for Google Charts.
		 */
		private function graphina_google_chart_data_format( $data, $settings, $chart_type ) {
			$google_chart_data = array(
				'count'           => 0,
				'title_array'     => array(),
				'data'            => array(),
				'annotation_show' => ! empty( $settings[ GRAPHINA_PREFIX . "{$chart_type}_chart_annotation_show" ] ) && $settings[ GRAPHINA_PREFIX . "{$chart_type}_chart_annotation_show" ] === 'yes' ? true : false,
				'title'           => ! empty( $settings[ GRAPHINA_PREFIX . "{$chart_type}_chart_haxis_title" ] ) ? $settings[ GRAPHINA_PREFIX . "{$chart_type}_chart_haxis_title" ] : '',
			);

			// Handle specific chart types
			if ( in_array( $chart_type, array( 'pie_google', 'donut_google', 'gauge_google' ), true ) ) {
				// Pie, Donut, Gauge, and Geo Charts: Map category to series data
				foreach ( $data['category'] as $key => $category ) {
					$google_chart_data['data'][] = array(
						$category,
						$data['series'][ $key ] ?? 0,
					);
				}
			} else if( 'geo_google' === $chart_type ){
				$i = 0;
				foreach ( $data['category'] as $key => $category ) {
					$google_chart_data['data'][] = array(
						$category,
						$data['series'][ $i ] ?? 0,
					);
					$i++;
				}
			} elseif ( $chart_type === 'org_google') {
				// Organizational Chart: Prepare hierarchical data
				$series_count = $settings[ GRAPHINA_PREFIX . "{$chart_type}_chart_data_series_count" ] ?? count( $data['series'][0]['data'] );
				foreach ( $data['category'] as $key => $category ) {
					if ( $key >= $series_count ) {
						break;
					}

					$temp = array(
						$category,
						$data['series'][0]['data'][ $key ] ?? '',
					);

					if ( ! empty( $data['series'][1]['data'][ $key ] ) ) {
						$temp[] = $data['series'][1]['data'][ $key ];
					}

					$google_chart_data['data'][] = $temp;
				}
			} else {
				$google_chart_data['count'] = isset($data['series']) ? count($data['series']) : 0;
				$series_names               = array();
				$x_prefix                   = $settings[ GRAPHINA_PREFIX . "{$chart_type}_chart_haxis_label_prefix" ] ?? '';
				$x_postfix                  = $settings[ GRAPHINA_PREFIX . "{$chart_type}_chart_haxis_label_postfix" ] ?? '';
				if (isset($data['category']) && is_array($data['category'])) {
					foreach ($data['category'] as $key => $category) {
						$row_data = array($x_prefix . $category . $x_postfix);

						foreach ($data['series'] as $series) {
							$series_names[] = $series['name'] ?? '';
							$row_data[] = (float) ($series['data'][$key] ?? 0);

							// Add annotation if enabled
							if ($google_chart_data['annotation_show'] === true) {
								$annotation_prefix = $settings[GRAPHINA_PREFIX . "{$chart_type}_chart_annotation_prefix"] ?? '';
								$annotation_postfix = $settings[GRAPHINA_PREFIX . "{$chart_type}_chart_annotation_postfix"] ?? '';
								$annotation_value = (float) ($series['data'][$key] ?? 0);

								$row_data[] = $annotation_prefix . $annotation_value . $annotation_postfix;
							}
						}

						$google_chart_data['data'][] = $row_data;
					}

					$google_chart_data['title_array'] = array_unique($series_names);
				}
			}
			return $google_chart_data;
		}
	}
}

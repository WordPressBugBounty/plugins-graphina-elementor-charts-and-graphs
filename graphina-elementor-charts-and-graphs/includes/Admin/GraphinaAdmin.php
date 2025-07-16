<?php

namespace Graphina\Admin;

use Graphina\Admin\GraphinaAdminMenu;
use Elementor\Modules\ElementManager\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Main Admin Class for the Graphina WordPress Plugin
 *
 * This class is responsible for handling all administrative tasks for the Graphina plugin.
 * It includes methods for registering admin pages, managing settings, handling AJAX requests,
 * and enqueuing necessary assets. This serves as the entry point for admin functionalities.
 */
if ( ! class_exists( 'GraphinaAdmin' ) ) :
	/**
	 * Class GraphinaAdmin
	 */
	class GraphinaAdmin {


		/**
		 * Constructor for the GraphinaAdmin class.
		 *
		 * Initializes the class and hooks into WordPress actions to set up admin functionalities.
		 */
		public function __construct() {
			$this->event_Handler(); // Hook into WordPress actions
			$this->remove_all_notices();
		}

		/**
		 * Registers WordPress hooks and actions.
		 *
		 * This function sets up AJAX handlers, admin menu registration,
		 * and asset enqueuing for the Graphina plugin.
		 */
		public function event_Handler() {
			add_action( 'wp_ajax_graphina_setting_data', array( $this, 'graphina_save_setting' ) );
			add_action( 'wp_ajax_graphina_external_database', array( $this, 'graphina_save_external_database' ) );
			add_action( 'wp_ajax_graphina_save_disabled_widgets', array( $this, 'graphina_save_disabled_widgets' ) );
			add_action( 'wp_ajax_graphina_save_enabled_widgets', array( $this, 'graphina_save_enabled_widgets' ) );
			add_action( 'wp_ajax_graphina_get_disabled_widgets', array( $this, 'graphina_get_disabled_widgets' ) );
			add_action( 'admin_menu', array( $this, 'register_admin_page' ), 100, 1 );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			add_action( 'wp_ajax_graphina_dismiss_notice', array( $this, 'graphina_dismiss_notice' ) );
			add_action( 'admin_notices', array( $this, 'iqonic_sale_banner_notice' ) );
			add_action( 'wp_ajax_graphina_clear_db_cache', array( $this, 'graphina_pro_handle_cache_clear_ajax' ) );
		}


		/**
		 * Function to delete/clear the database schema cache
		 * 
		 * @return bool True if cache was successfully deleted, false otherwise
		 */
		public function graphina_pro_clear_database_cache() {
			$internal_deleted = delete_transient( 'graphina_pro_db_tables' );
			$external_deleted = delete_transient( 'graphina_pro_external_db_tables' );
			
			// Return true if at least one cache was deleted successfully
			return $internal_deleted || $external_deleted;
		}

		/**
		 * Function to refresh the database schema cache
		 * This deletes the existing cache and forces a fresh retrieval on next access
		 * 
		 * @return bool True if cache was successfully cleared
		 */
		public function graphina_pro_refresh_database_cache() {
			return $this->graphina_pro_clear_database_cache();
		}

		/**
		 * AJAX handler for clearing database cache (admin only)
		 */
		public function graphina_pro_handle_cache_clear_ajax() {
			// Check user permissions
			if ( ! current_user_can( 'manage_options' ) || ! isset( $_GET['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_GET['nonce'] ), 'cache-nonce' ) ) {
				wp_send_json_error(
					array(
						'message' => __('Permission Denied', 'graphina-charts-for-elementor'),
						'subMessage' => __('You do not have sufficient permissions to perform this action.', 'graphina-charts-for-elementor')
					),
					403
				);
				return;
			}
			$result = $this->graphina_pro_clear_database_cache();
			
			if ( $result ) {
				wp_send_json_success( array( 'message' => 'Database cache cleared successfully' ) );
			} else {
				wp_send_json_error( array( 'message' => 'Failed to clear database cache' ) );
			}
		}

		/**
		 * [remove_all_notices] remove addmin notices
		 * @return [void]
		 */
		public function remove_all_notices(){
			add_action('in_admin_header', function (){
				$current_screen = get_current_screen();
				$hide_screen = ['toplevel_page_graphina-chart'];
				if(  in_array( $current_screen->id, $hide_screen) ){
					remove_all_actions('admin_notices');
					remove_all_actions('all_admin_notices');
				}
			}, 1000);
		}

		/**
		 * Dismisses a notice for the current user based on nonce verification and user meta update.
		 *
		 * @return void
		 */
		public function graphina_dismiss_notice(): void {
			// Check if nonce is set and verify it.
			if ( ! current_user_can( 'manage_options' ) || ! isset( $_GET['nounce'] ) || ! wp_verify_nonce( sanitize_key( $_GET['nounce'] ), 'graphina-dismiss-notice' ) ) {
				wp_send_json( array( 'status' => false ) ); // Send JSON response with status false if nonce verification fails.
			}

			// Sanitize and retrieve request data.
			$request_data = graphina_recursive_sanitize_textfield( $_GET );

			// Update user meta to dismiss the notice.
			update_user_meta( get_current_user_id(), $request_data['key'], 1 );

			// Send JSON response with status true after successful update.
			wp_send_json( array( 'status' => true ) );
		}


		/**
		 * Displays a sale banner notice based on conditions.
		 *
		 * @return void
		 */
		public function iqonic_sale_banner_notice(): void {
			$type            = 'plugins';
			$product         = 'graphina';
			$get_sale_detail = get_transient( 'graphina-notice' );
			if ( is_null( $get_sale_detail ) || $get_sale_detail === false ) {
				$get_sale_detail = wp_remote_get( 'https://assets.iqonic.design/wp-product-notices/notices.json?ver=' . wp_rand() );
				set_transient( 'graphina-notice', $get_sale_detail, 3600 );
			}

			if ( ! is_wp_error( $get_sale_detail ) ) {
				$content = json_decode( wp_remote_retrieve_body( $get_sale_detail ), true );
				if ( get_user_meta( get_current_user_id(), $content['data']['notice-id'], true ) ) {
					return;
				}
				
				$current_time = current_datetime();
				if ( ( $content['data']['start-sale-timestamp'] < $current_time->getTimestamp() && $current_time->getTimestamp() < $content['data']['end-sale-timestamp'] ) && isset( $content[ $type ][ $product ] ) ) {
					?>
					<div class="graphina-notice notice notice-success is-dismissible" style="padding: 0;">
						<a target="_blank" href="<?php echo esc_url( ! empty( $content[ $type ][ $product ]['sale-ink'] ) ? $content[ $type ][ $product ]['sale-ink'] : '#' ); ?>">
							<img src="<?php echo esc_url( ! empty( $content[ $type ][ $product ]['banner-img'] ) ? $content[ $type ][ $product ]['banner-img'] : '#' ); ?>" style="object-fit: contain;padding: 0;margin: 0;display: block;" width="100%" alt="">
						</a>
						<input type="hidden" id="graphina-notice-id" value="<?php echo esc_html( $content['data']['notice-id'] ); ?>">
						<input type="hidden" id="graphina-notice-nounce" value="<?php echo esc_html( wp_create_nonce( 'graphina-dismiss-notice' ) ); ?>">
					</div>
					<?php
				}
			}
		}

		/**
		 * Enqueue necessary scripts and styles for the admin area.
		 */
		public function enqueue_assets() {
			wp_enqueue_media();

			self::enqueue_kucrut();
			$localize_data = array(
				'ajaxurl'    => admin_url( 'admin-ajax.php' ),
				'adminurl'   => admin_url(),
				'pro_active' => apply_filters( 'graphina_is_pro_active', false ) === true ? '1' : '0',
				'nonce'      => wp_create_nonce( 'ajax-nonce' ),
			);

			// Apply the hook to allow modifications
			$localize_data = apply_filters( 'gcfe_localize_graphina_settings', $localize_data );

			wp_localize_script( 'graphina-settings', 'gcfe_localize', $localize_data );
		}

		/**
		 * Enqueue assets using the Kucrut helper library.
		 */
		public function enqueue_kucrut() {
			\Kucrut\Vite\enqueue_asset(
				GRAPHINA_PATH . 'dist',
				'assets/admin/js/main.js',
				array(
					'handle'           => 'graphina-settings',
					'dependencies'     => array(),
					'css-dependencies' => array( 'graphina-settings-css' ),
					'css-media'        => 'all',
					'css-only'         => false,
					'in-footer'        => true,
				)
			);
		}

		/**
		 * Retrieves the list of disabled widgets for Graphina.
		 *
		 * This function fetches the disabled elements (widgets) stored in options and returns them
		 * as a JSON response. It is primarily used to manage which widgets are disabled in the
		 * Graphina plugin's settings.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return void Outputs a JSON response with the list of disabled widgets.
		 */
		public function graphina_get_disabled_widgets() {
			
			// Check if the current user has the 'manage_options' capability.
			if ( ! current_user_can( 'manage_options' ) || ! isset( $_GET['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_GET['nonce'] ), 'ajax-nonce-element' ) ) {
				wp_send_json_error(
					array(
						'message' => __('Permission Denied', 'graphina-charts-for-elementor'),
						'subMessage' => __('You do not have sufficient permissions to perform this action.', 'graphina-charts-for-elementor')
					),
					403
				);
			}
			wp_send_json_success( Options::get_disabled_elements() );
		}

		/**
		 * Saves the enabled widgets for Graphina.
		 *
		 * This function processes the list of enabled widgets from the AJAX request,
		 * updates the disabled widgets list accordingly, and saves the changes to options.
		 * It ensures that only the widgets that should remain disabled are kept in the
		 * options while removing the ones that were re-enabled by the user.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return void Outputs a JSON response indicating success or failure.
		 */
		public function graphina_save_enabled_widgets() {


			// Check if the current user has the 'manage_options' capability.
			if ( ! current_user_can( 'manage_options' ) || ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'ajax-nonce-element' ) ) {
				wp_send_json_error(
					array(
						'message' => __('Permission Denied', 'graphina-charts-for-elementor'),
						'subMessage' => __('You do not have sufficient permissions to perform this action.', 'graphina-charts-for-elementor')
					),
					403
				);
				return;
			}

			// Get the posted widgets data
			$widgets = isset( $_POST['widgets'] ) ? json_decode( wp_unslash( $_POST['widgets'] ), true ) : array();

			// If the received data is '1', fetch all chart types instead
			if ( $widgets === 1 ) {
				$widgets = graphina_get_chart_name();
			}

			// Validate the widgets array format
			if ( ! is_array( $widgets ) ) {
				wp_send_json_error( __( 'Invalid data format.', 'graphina-charts-for-elementor' ) );
			}

			// Retrieve the existing disabled widgets list
			$existing_disable_widget = Options::get_disabled_elements();

			// Remove enabled widgets from the disabled list
			$result = array_diff( $existing_disable_widget, $widgets );
			$result = array_values( $result );

			// Save the updated disabled widgets list
			Options::update_disabled_elements( $result );

			// Optional: Trigger an action for hooks
			do_action( 'graphina/save_disabled_widgets', $widgets );

			// Prepare success messages
			$subMessage = __( 'Widgets enabled successfully.', 'graphina-charts-for-elementor' );
			$message    = __( 'Success', 'graphina-charts-for-elementor' );

			// Send success response
			wp_send_json_success(
				array(
					'message'    => $message,
					'subMessage' => $subMessage,
				)
			);
		}

		/**
		 * Saves the disabled widgets for Graphina.
		 *
		 * This function processes the list of disabled widgets received from the AJAX request,
		 * merges them with the existing disabled widgets list, and updates the options.
		 * It allows users to dynamically disable widgets from the Graphina settings.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return void Outputs a JSON response indicating success or failure.
		 */
		public function graphina_save_disabled_widgets() {

			// Check if the current user has the 'manage_options' capability.
			if ( ! current_user_can( 'manage_options' ) || ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'ajax-nonce-element' ) ) {
				wp_send_json_error(
					array(
						'message' => __('Permission Denied', 'graphina-charts-for-elementor'),
						'subMessage' => __('You do not have sufficient permissions to perform this action.', 'graphina-charts-for-elementor')
					),
					403
				);
				return;
			}

			// Get the posted widgets data
			$widgets = isset( $_POST['widgets'] ) ? json_decode( wp_unslash( $_POST['widgets'] ), true ) : array();

			// If the received data is '1', fetch all chart types instead
			if ( $widgets === 1 ) {
				$widgets = graphina_get_chart_name();
			}

			// Validate the widgets array format
			if ( ! is_array( $widgets ) ) {
				wp_send_json_error( __( 'Invalid data format.', 'graphina-charts-for-elementor' ) );
			}

			// Retrieve the existing disabled widgets list
			$existing_disable_widget = Options::get_disabled_elements();

			// Merge the new disabled widgets with the existing list and update options
			Options::update_disabled_elements( array_merge( $existing_disable_widget, $widgets ) );

			// Optional: Trigger an action for hooks
			do_action( 'graphina/save_disabled_widgets', $widgets );

			// Prepare success messages
			$subMessage = __( 'Widgets disabled successfully.', 'graphina-charts-for-elementor' );
			$message    = __( 'Success', 'graphina-charts-for-elementor' );

			// Send success response
			wp_send_json_success(
				array(
					'message'    => $message,
					'subMessage' => $subMessage,
				)
			);
		}

		/**
		 * Handle saving Graphina Database Settings via AJAX.
		 *
		 * This function checks user permissions, sanitizes the input, and updates
		 * the 'graphina_save_external_database' option in the database if valid data is received.
		 *
		 * @return void Outputs JSON response with status, message, and sub-message.
		 */
		public function graphina_save_external_database() {
			// Default response values
			$status     = false;
			$message    = esc_html__( 'Error', 'graphina-charts-for-elementor' );
			$subMessage = esc_html__( 'Action not found', 'graphina-charts-for-elementor' );

			// Check if the current user has the 'manage_options' capability
			if ( ! current_user_can( 'manage_options' ) || ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'ajax-nonce' ) ) {
				$subMessage = esc_html__( 'You don\'t have required permission or security error.', 'graphina-charts-for-elementor' );
				wp_send_json(
					array(
						'message'    => $message,
						'subMessage' => $subMessage,
						'status'     => $status,
					)
				);
			}

			// Sanitize incoming data
			$database_data = graphina_recursive_sanitize_textfield( $_POST );

			// Determine the action type (save, edit, con_test)
			$action_type = ! empty( $database_data['type'] ) ? $database_data['type'] : 'no_action';
			unset( $database_data['type'] );

			if ( $action_type !== 'delete' ) {
				// Validation rules
				$rules = array(
					'con_name'  => 'required',
					'vendor'    => 'required',
					'db_name'   => 'required',
					'host'      => 'required',
					'user_name' => 'required',
					'pass'      => 'required',
				);

				// Validation messages
				$messages = array(
					'con_name'  => esc_html__( 'Connection Name is required', 'graphina-charts-for-elementor' ),
					'vendor'    => esc_html__( 'Vendor is required', 'graphina-charts-for-elementor' ),
					'db_name'   => esc_html__( 'Database Name is required', 'graphina-charts-for-elementor' ),
					'host'      => esc_html__( 'Host is required', 'graphina-charts-for-elementor' ),
					'user_name' => esc_html__( 'User Name is required', 'graphina-charts-for-elementor' ),
					'pass'      => esc_html__( 'Password is required', 'graphina-charts-for-elementor' ),
				);

				// Validate input fields
				$validation_result = graphina_validate_required_fields( $database_data, $rules, $messages );

				// Check for validation errors and send a response if validation fails
				if ( ! $validation_result['status'] ) {
					wp_send_json(
						array(
							'status'     => false,
							'message'    => esc_html__( 'Missing Field', 'graphina-charts-for-elementor' ),
							'subMessage' => $validation_result['message'],
						)
					);
				}
			}

			// Handle database operations based on action
			if ( isset( $database_data['action'] ) && $database_data['action'] === 'graphina_external_database' ) {
				// Remove unnecessary fields from the data
				unset( $database_data['action'], $database_data['nonce'] );

				// Retrieve current database settings
				$data        = graphina_check_external_database( 'data' );
				$data_exists = ! empty( $data ) && is_array( $data );

				// Handle different actions based on the action type
				if ( in_array( $action_type, array( 'save', 'edit', 'con_test' ), true ) ) {
					// Check the database connection
					$connection_detail = $this->check_db_connection( $database_data );
					$status            = $connection_detail['status'];
					$message           = $connection_detail['message'];
					$subMessage        = $connection_detail['subMessage'];

					// If connection fails, send error response
					if ( ! $connection_detail['status'] ) {
						wp_send_json(
							array(
								'status'     => $status,
								'subMessage' => $subMessage,
								'message'    => $message,
							)
						);
						return;
					}

					// If the action is 'con_test', send a success response
					if ( $action_type === 'con_test' ) {
						wp_send_json(
							array(
								'status'     => $status,
								'subMessage' => $subMessage,
								'message'    => $message,
							)
						);
						return;
					}
				}

				// Handle database operations based on specific actions (delete, edit, save)
				switch ( $action_type ) {
					case 'delete':
						// Delete the existing database setting from options
						if ( $data_exists && array_key_exists( $database_data['value'], $data ) ) {
							unset( $data[ $database_data['value'] ] );
							update_option( 'graphina_mysql_database_setting', $data );
							$status     = true;
							$message    = esc_html__( 'Deleted!', 'graphina-charts-for-elementor' );
							$subMessage = esc_html__( 'Connection name deleted', 'graphina-charts-for-elementor' );
						} else {
							$subMessage = esc_html__( 'Error!', 'graphina-charts-for-elementor' );
							$message    = esc_html__( 'Connection Name not found', 'graphina-charts-for-elementor' );
						}
						break;

					case 'edit':
						// Edit existing database connection details
						if ( $data_exists && array_key_exists( $database_data['con_name'], $data ) ) {
							$data[ $database_data['con_name'] ] = $database_data;
							update_option( 'graphina_mysql_database_setting', $data );
							$status  = true;
							$message = esc_html__( 'Connection updated', 'graphina-charts-for-elementor' );
							$message = esc_html__( 'Database connection details updated', 'graphina-charts-for-elementor' );
						}
						break;

					case 'save':
						// Save new database connection details
						if ( $data_exists ) {
							// Check if connection name already exists before saving
							if ( ! array_key_exists( $database_data['con_name'], $data ) ) {
								update_option( 'graphina_mysql_database_setting', array_merge( $data, array( $database_data['con_name'] => $database_data ) ) );
								$status     = true;
								$message    = esc_html__( 'Database Saved!', 'graphina-charts-for-elementor' );
								$subMessage = esc_html__( 'Connection details saved!', 'graphina-charts-for-elementor' );
							}
						} else {
							update_option( 'graphina_mysql_database_setting', array( $database_data['con_name'] => $database_data ) );
							$status  = true;
							$message = esc_html__( 'Database Saved!', 'graphina-charts-for-elementor' );
							$message = esc_html__( 'Connection details saved!', 'graphina-charts-for-elementor' );
						}
						break;
				}
			}

			// Send the final response
			wp_send_json(
				array(
					'message'    => $message,
					'subMessage' => $subMessage,
					'status'     => $status,
				)
			);
		}

		/**
		 * Check database connection details.
		 *
		 * @param array $data Database connection parameters.
		 * @return array Status,message and sub message of the connection test.
		 */
		private function check_db_connection( array $data ): array {
			// Default response
			$response = array(
				'status'  => false,
				'message' => esc_html__( 'Connection details not found', 'graphina-charts-for-elementor' ),
			);

			if (! current_user_can( 'manage_options' ) ) {
				wp_send_json_error(
					array(
						'message' => __('Permission Denied', 'graphina-charts-for-elementor'),
						'subMessage' => __('You do not have sufficient permissions to perform this action.', 'graphina-charts-for-elementor')
					),
					403
				);
			}

			// Validate required fields for connection
			if ( empty( $data['host'] ) || empty( $data['user_name'] ) || empty( $data['pass'] ) || empty( $data['db_name'] ) || empty( $data['con_name'] ) ) {
				return $response;
			}

			try {
				// Test the database connection using mysqli_connect
				$dc_con = mysqli_connect( $data['host'], $data['user_name'], $data['pass'], $data['db_name'] );
				if ( ! $dc_con ) {
					$response['message']    = esc_html( 'Error', 'graphina-charts-for-elementor' );
					$response['subMessage'] = esc_html( mysqli_connect_error(), 'graphina-charts-for-elementor' );
				} else {
					$response['status']     = true;
					$response['message']    = esc_html__( 'Connected', 'graphina-charts-for-elementor' );
					$response['subMessage'] = esc_html__( 'Database successfully Connected!', 'graphina-charts-for-elementor' );
				}
			} catch ( \Exception $e ) {
				$response['message'] = $e->getMessage();
			}

			return $response;
		}


		/**
		 * Handle saving Graphina settings via AJAX.
		 *
		 * This function checks user permissions, sanitizes the input, and updates
		 * the 'graphina_common_setting' option in the database if valid data is received.
		 *
		 * @return void Outputs JSON response with status, message, and sub-message.
		 */
		public function graphina_save_setting() {
			// Default response values
			$status     = false;
			$message    = esc_html__( 'Error', 'graphina-charts-for-elementor' );
			$subMessage = esc_html__( 'Action not found', 'graphina-charts-for-elementor' );

			// Check if the current user has the 'manage_options' capability
			if ( ! current_user_can( 'manage_options' ) || ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'ajax-nonce' ) ) {
				$subMessage = esc_html__( 'You don\'t have required permission or security error.', 'graphina-charts-for-elementor' );
				wp_send_json(
					array(
						'message'    => $message,
						'subMessage' => $subMessage,
						'status'     => $status,
					)
				);
			}

			// Sanitize and retrieve POST data
			$setting_data = graphina_recursive_sanitize_textfield( $_POST );

			// Verify the action and process data if valid
			if ( isset( $setting_data['action'] ) && $setting_data['action'] === 'graphina_setting_data' ) {
				unset( $setting_data['action'], $setting_data['nonce'] ); // Remove unneeded fields

				// Check if there is data to save
				if ( ! empty( $setting_data ) ) {
					update_option( 'graphina_common_setting', $setting_data ); // Save the sanitized settings
					$status     = true;
					$message    = esc_html__( 'Setting saved', 'graphina-charts-for-elementor' );
					$subMessage = esc_html__( 'Your setting has been saved!', 'graphina-charts-for-elementor' );
				} else {
					$message = esc_html__( 'Setting not saved', 'graphina-charts-for-elementor' );
				}
			}

			// Return the response in JSON format
			wp_send_json(
				array(
					'message'    => $message,
					'subMessage' => $subMessage,
					'status'     => $status,
				)
			);
		}

		/**
		 * Register the admin menu and sub-menu pages for the plugin.
		 */
		public function register_admin_page() {
			$this->add_main_menu_page();
			$this->add_sub_menu_pages();
		}

		/**
		 * Add the main menu page for Graphina in the WordPress admin dashboard.
		 */
		private function add_main_menu_page() {
			add_menu_page(
				esc_html__( 'Graphina Charts', 'graphina-charts-for-elementor' ),
				esc_html__( 'Graphina', 'graphina-charts-for-elementor' ),
				'manage_options',
				'graphina-chart',
				array( $this, 'load_graphina_general_settings' ),
				GRAPHINA_URL . '/assets/admin/images/graphina.svg',
				100
			);
		}

		/**
		 * Add sub-menu pages under the main menu for additional features and settings.
		 */
		private function add_sub_menu_pages() {
			$menu_items = apply_filters(
				'gcfe_settings_tabs_array',
				array(
					'settings'        => array(
						'label'    => __( 'Graphina Charts Setting', 'graphina-charts-for-elementor' ),
						'title'    => __( 'Settings', 'graphina-charts-for-elementor' ),
						'callback' => array( $this, 'load_graphina_general_settings' ),
						'tab'      => 'graphina-chart',
					),
					'documentation'   => array(
						'label' => __( 'Graphina Charts Documentation', 'graphina-charts-for-elementor' ),
						'title' => __( 'Documentation', 'graphina-charts-for-elementor' ),
						'url'   => esc_url('https://documentation.iqonic.design/graphina/'),
					),
					'request_feature' => array(
						'label' => __( 'Graphina Charts Request Feature', 'graphina-charts-for-elementor' ),
						'title' => __( 'Request Feature', 'graphina-charts-for-elementor' ),
						'url'   => esc_url('https://iqonic.design/feature-request/?for_product=graphina'),
					),
				)
			);

			// Adding a conditional Pro feature menu item if not active
			if ( ! graphina_pro_active() ) {
				$menu_items['upgrade_to_pro'] = array(
					'label'    => __( 'Upgrade To Pro', 'graphina-charts-for-elementor' ),
					'title'    => __( 'Upgrade To Pro', 'graphina-charts-for-elementor' ),
					'callback' => array( $this, 'graphina_pro_page' ),
					'tab'      => 'graphina-chart-pro',
				);
			}

			foreach ( $menu_items as $page_id => $page ) {
				if ( is_array( $page ) && isset( $page['label'] ) ) {
					if ( isset( $page['url'] ) ) {
						// For external links like documentation or request feature
						add_submenu_page(
							'graphina-chart',
							$page['label'],
							$page['title'],
							'manage_options',
							$page['url']
						);
					} else {
						// For internal settings pages with a callback function
						add_submenu_page(
							'graphina-chart',
							$page['label'],
							$page['title'],
							'manage_options',
							$page['tab'],
							$page['callback']
						);
					}
				}
			}
		}

		/**
		 * Graphina Pro ads page.
		 */
		public function graphina_pro_page() {
			require_once GRAPHINA_PATH . 'includes/Admin/Menu/views/html-pro-pramotion.php';
		}


		/**
		 * Load the Graphina general settings page.
		 */
		public function load_graphina_general_settings() {
			GraphinaAdminMenu::output();
		}
	}

endif;

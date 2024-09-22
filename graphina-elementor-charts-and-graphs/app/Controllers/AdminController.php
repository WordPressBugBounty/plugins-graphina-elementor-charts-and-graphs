<?php
/**
 * AdminController class load all admin ajax routes
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina_Charts_For_Elementor
 */

namespace GraphinaElementor\App\Controllers;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Something went wrong' );
}

use Exception;

/**
 * Class AdminController
 *
 * This class handles the administration functionalities for Graphina Charts plugin.
 */
class AdminController {


	/**
	 * Constructor for initializing actions related to Graphina plugin.
	 * Hooks AJAX actions for dismissing notices and saving settings.
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'wp_ajax_iq_dismiss_notice', array( $this, 'iq_dismiss_notice' ) );
		add_action( 'wp_ajax_graphina_setting_data', array( $this, 'graphina_save_setting' ) );
		add_action( 'wp_ajax_graphina_external_database', array( $this, 'graphina_save_external_database_setting' ) );
	}

	/**
	 * Saves Graphina plugin common settings based on POST data.
	 * Sends JSON response with status and messages based on operation result.
	 *
	 * @return void
	 */
	public function graphina_save_setting(): void {
		$status      = false;
		$message     = esc_html__( 'Action not found', 'graphina-charts-for-elementor' );
		$sub_message = '';
		if ( ! current_user_can( 'manage_options' ) || ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'ajax-nonce' ) ) {
			wp_send_json(
				array(
					'status'  => false,
					'message' => esc_html__( 'You don\'t have required permission or security error.', 'graphina-charts-for-elementor' ),
				)
			);
		}
		$request_data = graphina_recursive_sanitize_textfield( $_POST );
		if ( isset( $request_data['action'] ) && $request_data['action'] === 'graphina_setting_data' ) {
			unset( $request_data['action'] );
			unset( $request_data['nonce'] );
			if ( ! empty( $request_data ) ) {
				update_option( 'graphina_common_setting', $request_data );
				$status      = true;
				$message     = esc_html__( 'Setting saved', 'graphina-charts-for-elementor' );
				$sub_message = esc_html__( 'Your setting has been saved!', 'graphina-charts-for-elementor' );
			} else {
				$message = esc_html__( 'Setting not saved', 'graphina-charts-for-elementor' );
			}
		}

		wp_send_json(
			array(
				'status'      => $status,
				'message'     => $message,
				'sub_message' => $sub_message,
			)
		);
	}

	/**
	 * Saves, edits, tests, or deletes external database connection settings based on POST data.
	 * Sends JSON response with status and message based on operation result.
	 *
	 * @return void
	 */
	public function graphina_save_external_database_setting(): void {
		$status  = false;
		$message = esc_html__( 'not saved', 'graphina-charts-for-elementor' );
		if ( ! current_user_can( 'manage_options' ) || ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'ajax-nonce' ) ) {
			wp_send_json(
				array(
					'status'  => false,
					'message' => esc_html__( 'You don\'t have required permission or security error.', 'graphina-charts-for-elementor' ),
				)
			);
			die;
		}

		$post_data = graphina_recursive_sanitize_textfield( $_POST );

		if ( isset( $post_data['action'] ) && $post_data['action'] === 'graphina_external_database' ) {
			unset( $post_data['action'] );
			unset( $post_data['nonce'] );
			$data        = graphina_check_external_database( 'data' );
			$data_exists = ! empty( $data ) && is_array( $data );
			$action_type = ! empty( $post_data['type'] ) ? $post_data['type'] : 'no_action';
			unset( $post_data['type'] );

			if ( in_array( $action_type, array( 'save', 'edit', 'con_test' ), true ) ) {

				$connection_detail = $this->check_db_connection( $post_data );
				$status            = $connection_detail['status'];
				$message           = $connection_detail['message'];

				if ( ! $connection_detail['status'] ) {
					wp_send_json(
						array(
							'data'    => '',
							'status'  => $status,
							'message' => $message,
						)
					);
					die;
				}

				if ( $action_type === 'con_test' ) {
					wp_send_json(
						array(
							'data'    => '',
							'status'  => $status,
							'message' => $message,
						)
					);
					die;
				}
			}

			switch ( $action_type ) {
				case 'delete':
					// delete exists database setting from options.
					if ( $data_exists ) {
						if ( array_key_exists( $post_data['value'], $data ) ) {
							unset( $data[ $post_data['value'] ] );
							update_option( 'graphina_mysql_database_setting', $data );
							$status  = true;
							$message = esc_html__( 'Connection name delete', 'graphina-charts-for-elementor' );
						} else {
							$message = esc_html__( 'Connection Name not found', 'graphina-charts-for-elementor' );
						}
					}
					break;
				case 'edit':
					// edit exists database connection details.
					if ( $data_exists ) {
						if ( array_key_exists( $post_data['con_name'], $data ) ) {
							$data[ $post_data['con_name'] ] = $post_data;
							update_option( 'graphina_mysql_database_setting', $data );
							$status  = true;
							$message = esc_html__( 'Connection detail Updated', 'graphina-charts-for-elementor' );
						}
					}
					break;
				case 'save':
					if ( $data_exists ) {
						// check if same connection name exists while save new connection detail.
						if ( ! array_key_exists( $post_data['con_name'], $data ) ) {
							// save database connection detail.
							update_option( 'graphina_mysql_database_setting', array_merge( $data, array( $post_data['con_name'] => $post_data ) ) );
							$status  = true;
							$message = esc_html__( 'Connection Details Saved', 'graphina-charts-for-elementor' );
						}
					} else {
						// save database connection detail.
						update_option( 'graphina_mysql_database_setting', array( $post_data['con_name'] => $post_data ) );
						$status  = true;
						$message = esc_html__( 'Connection Details Saved', 'graphina-charts-for-elementor' );
					}
					break;
			}
		}

		wp_send_json(
			array(
				'data'       => '',
				'status'     => $status,
				'message'    => $message,
				'subMessage' => esc_html__( 'Your setting has been saved!', 'graphina-charts-for-elementor' ),
			)
		);
	}

	/**
	 * Dismisses a notice for the current user based on nonce verification and user meta update.
	 *
	 * @return void
	 */
	public function iq_dismiss_notice(): void {
		// Check if nonce is set and verify it.
		if ( ! current_user_can( 'manage_options' ) || ! isset( $_GET['nounce'] ) || ! wp_verify_nonce( sanitize_key( $_GET['nounce'] ), 'iq-dismiss-notice' ) ) {
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
	 * Checks the database connection using provided connection details.
	 *
	 * @param array $data An array containing database connection details.
	 *                    Requires 'host', 'user_name', 'pass', 'db_name', and 'con_name'.
	 * @return array An array containing the status of the database connection check.
	 *               Keys:
	 *               - 'data': Data placeholder.
	 *               - 'status': Boolean indicating connection status (true for success, false for failure).
	 *               - 'message': Status message describing the result of the connection check.
	 */
	public function check_db_connection( array $data ): array {

		$response = array(
			'data'    => '',
			'status'  => false,
			'message' => esc_html__( 'Connection detail not found', 'graphina-charts-for-elementor' ),
		);

		if ( empty( $data['host'] ) || ! empty( $data['user_name'] ) || empty( $data['pass'] )
			|| empty( $data['db_name'] ) || empty( $data['con_name'] ) ) {
			return $response;
		}

		try {
			// To test db connection mysqli_connect used instead of WordPress wpdb class.
            $dc_con = mysqli_connect( $data['host'], $data['user_name'], $data['pass'], $data['db_name'] ); //@phpcs:ignore
			if ( ! $dc_con ) {
                $response['message'] = esc_html__( mysqli_connect_error(), 'graphina-charts-for-elementor' ); //@phpcs:ignore
			} else {
				$response['status']  = true;
				$response['message'] = esc_html__( 'Successfully connected', 'graphina-charts-for-elementor' );
			}
			return $response;
		} catch ( Exception $e ) {
			$response['message'] = $e->getMessage();
			return $response;
		}
	}
}

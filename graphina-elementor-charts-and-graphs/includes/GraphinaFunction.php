<?php


// Check if the function graphina_get_template already exists to avoid redeclaration.

use Elementor\Utils;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'graphina_get_template' ) ) {
	/**
	 * Loads a template file for rendering with optional arguments.
	 *
	 * This function locates a template file, first checking in the child theme,
	 * and then falling back to a default path. It extracts any provided arguments
	 * for use within the template and triggers actions before and after including the template.
	 *
	 * @param string $template_name The name of the template file to load.
	 * @param array  $args          Optional. An associative array of variables to pass to the template. Default is an empty array.
	 * @param string $default_path  Optional. The default path to look for the template if not found in the theme. Default is ''.
	 *
	 * @return void|WP_Error Returns a WP_Error object if the template file does not exist, otherwise includes the template file.
	 */
	function graphina_get_template( $template_name, $args = array(), $default_path = '' ) {
		// Set default path if not provided
		if ( empty( $default_path ) ) {
			$default_path = GRAPHINA_PATH . 'templates/';
		}
		// Locate the template in the child theme or fallback to default path
		$template = locate_template(
			array(
				trailingslashit( 'graphina-elementor-charts-and-graphs' ) . $template_name,
				$template_name,
			)
		);

		if ( empty( $template ) ) {
			$template = $default_path . $template_name;
		}

		// Check if the template file exists
		if ( ! file_exists( $template ) ) {

			return new WP_Error(
				'error',
				sprintf(
					/* translators: %s: template name */
					__( '%s does not exist.', 'graphina-elementor-charts-and-graphs' ),
					'<code>' . $template . '</code>'
				)
			);
		}

		// Trigger before template part action
		do_action( 'graphina_before_template_part', $template, $args, $default_path );

		// Extract arguments to variables
		if ( ! empty( $args ) && is_array( $args ) ) {
			extract( $args );
		}

		// Include the template file
		include $template;

		// Trigger after template part action
		do_action( 'graphina_after_template_part', $template, $args, $default_path );
	}
}


// Check if the function graphina_get_card already exists to avoid redeclaration.
if ( ! function_exists( 'graphina_get_card' ) ) {
	/**
	 * Render a chart card template based on provided settings.
	 *
	 * This function determines the visibility and content of the chart card
	 * (including heading and description) based on the settings and then
	 * includes the `card.php` template for rendering.
	 *
	 * @param array  $settings   The settings for the chart card.
	 * @param string $chart_type The type of the chart for which the card is being rendered.
	 *
	 * @return void
	 */
	function graphina_get_card( $settings, $chart_type, $template_path, $chart_data ) {
		// Determine the CSS class for the chart card based on the settings.
		$chart_card_class = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_card_show' ] )
			&& $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_card_show' ] === 'yes'
			? 'chart-card'
			: '';

		// Check if the heading should be displayed.
		$show_heading = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_is_card_heading_show' ] )
			&& $settings[ GRAPHINA_PREFIX . $chart_type . '_is_card_heading_show' ] === 'yes';

		// Check if the description should be displayed.
		$show_description = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_is_card_desc_show' ] )
			&& $settings[ GRAPHINA_PREFIX . $chart_type . '_is_card_desc_show' ] === 'yes';

		// Get the sanitized chart title if provided in the settings.
		$chart_title = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_heading' ] )
			? sanitize_text_field( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_heading' ] )
			: '';

		// Get the sanitized chart description if provided in the settings.
		$chart_description = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_content' ] )
			? sanitize_text_field( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_content' ] )
			: '';

		// Include the card.php template with the calculated data.
		graphina_get_template(
			'card.php',
			array(
				'chart_card_class'  => $chart_card_class,
				'show_heading'      => $show_heading,
				'chart_title'       => $chart_title,
				'show_description'  => $show_description,
				'chart_description' => $chart_description,
				'template_path'		=> $template_path,
				'chart_data'		=> $chart_data,
                'chart_type'        => $chart_type,
                'settings'          => $settings,
			)
		);
	}
}


// Check if the function graphina_get_google_chart_type_options already exists to avoid redeclaration.
if ( ! function_exists( 'graphina_get_google_chart_type_options' ) ) {
	/**
	 * Load and render the Google Chart type options template.
	 *
	 * This function includes the `google-chart-options.php` template and passes the
	 * chart type and element ID as parameters for rendering specific chart options.
	 *
	 * @param string $chart_type The type of Google Chart to render options for.
	 * @param string $element_id The ID of the element associated with the chart.
	 *
	 * @return void
	 */
	function graphina_get_google_chart_type_options( $chart_type, $element_id ) {
		// Include the google-chart-options.php template with the provided data.
		graphina_get_template(
			'google-chart-options.php',
			array(
				'chart_type' => $chart_type,
				'element_id' => $element_id,
			)
		);
	}
}

// Check if the function graphina_get_apex_chart_type_options already exists to avoid redeclaration.
if ( ! function_exists( 'graphina_get_apex_chart_type_options' ) ) {
	/**
	 * Load and render the Apex Chart type options template.
	 *
	 * This function includes the `apex-chart-options.php` template and passes the
	 * chart type and element ID as parameters for rendering specific chart options.
	 *
	 * @param string $chart_type The type of Apex Chart to render options for.
	 * @param string $element_id The ID of the element associated with the chart.
	 *
	 * @return void
	 */
	function graphina_get_apex_chart_type_options( $chart_type, $element_id ) {
		// Include the apex-chart-options.php template with the provided data.
		graphina_get_template(
			'apex-chart-options.php',
			array(
				'chart_type' => $chart_type,
				'element_id' => $element_id,
			)
		);
	}
}


// Check if the function graphina_default_setting already exists to avoid redeclaration.
if ( ! function_exists( 'graphina_default_setting' ) ) {

	/**
	 * Retrieves default settings for Graphina.
	 *
	 * This function returns a default value based on the provided key.
	 * It also allows specifying the expected data type for cases where the key is not found.
	 *
	 * @param string $key The key to retrieve the default value for.
	 * @param string $data_type The expected data type ('int' or 'float').
	 *
	 * @return mixed Returns the value for the provided key, or a default value based on the data type.
	 */
	function graphina_default_setting( $key, $data_type = 'int' ) {
		// Default settings list for Graphina.
		$list = array(
			// The maximum value for series data, with a filter for custom overrides.
			'max_series_value' => apply_filters( 'graphina_max_series_value', 31 ),
			'max_column_value' => apply_filters( 'graphina_max_column_value', 31 ),
			'max_row_value'    => apply_filters( 'graphina_max_row_value', 25 ),
			'categories'       => apply_filters( 'gcfe_default_category', array(), 12 ),
		);

		// Return the value from the list if the key exists.
		if ( isset( $list[ $key ] ) ) {
			return $list[ $key ];
		}

		// Return 0 if the expected data type is 'int' or 'float' and the key is not found.
		if ( in_array( $data_type, array( 'int', 'float' ), true ) ) {
			return 0;
		}

		// Return an empty string as a fallback for other data types.
		return '';
	}
}


// Check if the function graphina_fetch_roles_options already exists to avoid redeclaration.
if ( ! function_exists( 'graphina_fetch_roles_options' ) ) {

	/**
	 * Fetches a list of editable roles and formats them into an options array.
	 *
	 * This function retrieves all roles available in the WordPress installation
	 * and returns their IDs and names for use in dropdowns or other UI elements.
	 *
	 * @return array An associative array of role IDs and names.
	 */
	function graphina_fetch_roles_options() {
		// Default value when not in admin context.
		$roles_options = array( 'test' );

		if ( is_admin() ) {
			// Retrieve all editable roles in WordPress.
			$roles         = get_editable_roles();
			$roles_options = array();

			// Loop through each role and map its ID to its display name.
			foreach ( $roles as $role_id => $role_data ) {
				$roles_options[ $role_id ] = $role_data['name'];
			}
		}

		return $roles_options;
	}
}

// Check if the function graphina_fetch_user_name_options already exists to avoid redeclaration.
if ( ! function_exists( 'graphina_fetch_user_name_options' ) ) {

	/**
	 * Fetches a list of WordPress users and formats their names.
	 *
	 * This function retrieves all WordPress users and formats their names to include
	 * first name, last name, and display name for use in dropdowns or other UI elements.
	 *
	 * @return array An associative array of user logins and formatted names.
	 */
	function graphina_fetch_user_name_options() {
		// Retrieve all WordPress users.
		$all_users     = get_users();
		$users_options = array();

		// Loop through each user to construct a formatted name.
		foreach ( $all_users as $user ) {
			$first_name   = get_user_meta( $user->ID, 'first_name', true );
			$last_name    = get_user_meta( $user->ID, 'last_name', true );
			$display_name = $user->display_name;

			// Combine the names into a formatted string.
			$formatted_name = $first_name . ' ' . $last_name . ' (' . $display_name . ')';

			// Map the user login to the formatted name.
			$users_options[ $user->user_login ] = $formatted_name;
		}

		return $users_options;
	}
}

// Check if the function graphina_default_restrict_content_template already exists to avoid redeclaration.
if ( ! function_exists( 'graphina_default_restrict_content_template' ) ) {

	/**
	 * Loads and returns the default restrict content template.
	 *
	 * This function uses output buffering to capture the contents of
	 * the 'restrict-content.php' template and return it as a string.
	 *
	 * @return string The HTML content of the restrict content template.
	 */
	function graphina_default_restrict_content_template() {
		ob_start();
		// Load the restrict-content.php template.
		graphina_get_template( 'restrict-content.php' );
		return ob_get_clean();
	}
}

// Check if the function graphina_fetch_user_roles already exists to avoid redeclaration.
if ( ! function_exists( 'graphina_fetch_user_roles' ) ) {

	/**
	 * Fetches the roles of the current user.
	 *
	 * This function retrieves the roles assigned to the currently logged-in user.
	 * It can return either a single role as a string or an array of roles based on the parameter.
	 *
	 * @param bool $single_role If true, returns a single role as a string; otherwise, returns an array of roles.
	 * @return array|string An array of roles or a single role string. Returns an empty string or array if no roles are found.
	 */
	function graphina_fetch_user_roles( bool $single_role = true ): array|string {
		// Get the current user's ID.
		$user_id = get_current_user_id();

		// If no user is logged in, return an empty string or empty array based on $single_role.
		if ( empty( $user_id ) ) {
			return $single_role ? '' : array();
		}

		// Create a WP_User object for the current user.
		$user_obj  = new WP_User( $user_id );
		$user_role = ! empty( $user_obj->roles ) ? $user_obj->roles : array();

		// If roles are found, process them.
		if ( ! empty( $user_role ) && is_array( $user_role ) && count( $user_role ) > 0 ) {
			$user_role = array_values( $user_role ); // Reindex the array.
			// Return a single role or array of roles based on $single_role.
			return $single_role ? $user_role[0] : $user_role;
		}

		// If no roles are found, return an empty string or array based on $single_role.
		return $single_role ? '' : array();
	}
}

// Check if the function graphina_fetch_user_name already exists to avoid redeclaration.
if ( ! function_exists( 'graphina_fetch_user_name' ) ) {

	/**
	 * Fetches the login name of the current user.
	 *
	 * This function retrieves the username (user_login) of the currently logged-in user.
	 *
	 * @return string The username of the current user. Returns an empty string if no user is logged in.
	 */
	function graphina_fetch_user_name(): string {
		// Retrieve the current user object.
		$user = wp_get_current_user();

		// Return the user's login name or an empty string if not available.
		return ! empty( $user->user_login ) ? $user->user_login : '';
	}
}

// Check if the function graphina_is_preview_mode already exists to avoid redeclaration.
if ( ! function_exists( 'graphina_is_preview_mode' ) ) {

	/**
	 * Determines whether the current page is in Elementor's preview or edit mode.
	 *
	 * This function checks if the Elementor plugin is active and if the page
	 * is being previewed or edited using Elementor.
	 *
	 * @return bool True if not in Elementor's preview or edit mode; false otherwise.
	 */
	function graphina_is_preview_mode(): bool {
		// Ensure Elementor plugin's class exists.
		if ( ! class_exists( '\Elementor\Plugin' ) ) {
			return true; // Return true if Elementor is not active.
		}

		// Check if Elementor is in preview or edit mode.
		return ! ( Elementor\Plugin::$instance->preview->is_preview_mode() || Elementor\Plugin::$instance->editor->is_edit_mode() );
	}
}

// Check if the function graphina_restricted_access already exists to avoid redeclaration.
if ( ! function_exists( 'graphina_restricted_access' ) ) {
	/**
	 * Determines if a chart's content should be restricted based on various conditions.
	 *
	 * This function checks if the content of a chart should be restricted based on user roles, user names, or passwords.
	 * It considers the settings defined for the chart type and applies the restrictions accordingly.
	 *
	 * @param string $type The type of the chart (e.g., 'line', 'bar').
	 * @param string $chart_id The unique identifier for the chart.
	 * @param array  $settings The settings array containing restriction rules.
	 * @param bool   $flag Optional flag to indicate if additional content should be loaded.
	 *
	 * @return bool Returns true if the content is restricted, false otherwise.
	 */
	function graphina_restricted_access( string $type, string $chart_id, array $settings, bool $flag = false ): bool {
		// Default value for restricted template. Set to false initially.
		$restricted_template = false;

		// Check if any restriction type is set for the current chart type.
		if (
			! empty( $settings[ GRAPHINA_PREFIX . $type . '_restriction_content_type' ] )
			&& $settings[ GRAPHINA_PREFIX . $type . '_restriction_content_type' ] !== ''
		) {
			// Set the template as restricted initially.
			$restricted_template = true;

			// Check if the user is logged in to handle access based on user role or username.
			if ( is_user_logged_in() ) {
				$restricted_template = false; // Reset restriction as the user is logged in.

				// Handle access based on user roles.
				if ( $settings[ GRAPHINA_PREFIX . $type . '_restriction_content_type' ] === 'role' ) {
					// Fetch the current user's role.
					$current_user_role = graphina_fetch_user_roles( true );

					// Check if the user role is not in the allowed roles list.
					if ( ! empty( $settings[ GRAPHINA_PREFIX . $type . '_restriction_content_role_type' ] ) ){
						if (
							! is_array( $settings[ GRAPHINA_PREFIX . $type . '_restriction_content_role_type' ] )
							|| ! in_array( $current_user_role, $settings[ GRAPHINA_PREFIX . $type . '_restriction_content_role_type' ], true )
						) {
							// Set template as restricted if user role is not allowed.
							$restricted_template = true;
						}
					}
				}

				// Handle access based on specific user names.
				if ( $settings[ GRAPHINA_PREFIX . $type . '_restriction_content_type' ] === 'userName' ) {
					// Fetch the current user's username.
					$current_user_name = graphina_fetch_user_name();

					// Check if the user name is not in the allowed names list.
					if (
						! is_array( $settings[ GRAPHINA_PREFIX . $type . '_restriction_content_user_name_based' ] )
						|| ! in_array( $current_user_name, $settings[ GRAPHINA_PREFIX . $type . '_restriction_content_user_name_based' ], true )
					) {
						// Set template as restricted if user name is not allowed.
						$restricted_template = true;
					}
				}
			}

			// Handle access based on password restriction.
			if (
				$settings[ GRAPHINA_PREFIX . $type . '_restriction_content_type' ] === 'password'
				&& ( empty( $_COOKIE[ 'graphina_' . $type . '_' . $chart_id ] ) || ! sanitize_text_field( wp_unslash( $_COOKIE[ 'graphina_' . $type . '_' . $chart_id ] ) ) )
			) {
				// If password protection is enabled and the user has not entered the password yet.
				if ( $flag ) {
					// Prepare data to display the password entry form.
					$temp_data['heading']         = $settings[ GRAPHINA_PREFIX . $type . '_password_content_headline' ];
					$temp_data['chart_id']        = $chart_id;
					$temp_data['chart_type']      = $type;
					$temp_data['instructions']    = ! empty( $settings[ GRAPHINA_PREFIX . $type . '_password_instructions_text' ] ) ? $settings[ GRAPHINA_PREFIX . $type . '_password_instructions_text' ] : '';
					$temp_data['hash_pass']       = ! empty( $settings[ GRAPHINA_PREFIX . $type . '_restriction_content_password' ] ) ? $settings[ GRAPHINA_PREFIX . $type . '_restriction_content_password' ] : '';
					$temp_data['button_lbl']      = ! empty( $settings[ GRAPHINA_PREFIX . $type . '_password_button_label' ] ) ? $settings[ GRAPHINA_PREFIX . $type . '_password_button_label' ] : '';
					$temp_data['error_msg_show']  = ! empty( $settings[ GRAPHINA_PREFIX . $type . '_password_error_message_show' ] ) ? $settings[ GRAPHINA_PREFIX . $type . '_password_error_message_show' ] : '';
					$temp_data['error_msg']       = ! empty( $settings[ GRAPHINA_PREFIX . $type . '_password_error_message' ] ) ? $settings[ GRAPHINA_PREFIX . $type . '_password_error_message' ] : '';
					$temp_data['is_preview_mode'] = graphina_is_preview_mode();

					// Load the template for password protection form.
					graphina_get_template( 'restrict-content-access.php', $temp_data );
				}

				// Set the template as restricted due to password requirement.
				$restricted_template = true;
			} elseif ( $settings[ GRAPHINA_PREFIX . $type . '_restriction_content_type' ] === 'password' ) {
				// If the password protection is satisfied, remove restriction.
				$restricted_template = false;
			}
		}

		// Return the final restriction status.
		return $restricted_template;
	}
}

// Check if the function graphina_check_external_database already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_check_external_database' ) ) {
	/**
	 * Checks the external database connection settings.
	 *
	 * This function retrieves the external database configuration saved in WordPress options and
	 * returns information based on the specified type. It ensures that the settings are valid and
	 * available for use in the plugin.
	 *
	 * @param string $type The type of check to perform:
	 *                     - 'status': Returns true if the settings are available and valid.
	 *                     - Other: Returns the raw settings array.
	 *
	 * @return mixed Returns a boolean (for 'status') or the settings array (for other types).
	 */
	function graphina_check_external_database( string $type ): mixed {
		// Retrieve the external database settings from WordPress options.
		$data = get_option( 'graphina_mysql_database_setting', true );

		// Check the type and return the appropriate value.
		return $type === 'status'
			? is_array( $data ) && count( $data ) > 0 // Return true if the data is a non-empty array.
			: $data; // Otherwise, return the raw settings data.
	}
}

// Check if the function graphina_check_external_database already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_recursive_sanitize_textfield' ) ) {
	/**
	 * Recursively sanitizes an array of values for secure processing.
	 *
	 * @param array $request_data The array to sanitize.
	 * @return array Sanitized array with filtered values.
	 */
	function graphina_recursive_sanitize_textfield( array $request_data ): array {
		$filter_parameters = array();
		foreach ( $request_data as $key => $value ) {

			if ( $value === '' ) {
				$filter_parameters[ $key ] = null;
			} elseif ( is_array( $value ) ) {
				$filter_parameters[ $key ] = graphina_recursive_sanitize_textfield( $value );
			} elseif ( is_object( $value ) ) {
				$filter_parameters[ $key ] = $value;
			} elseif ( preg_match( '/<[^<]+>/', $value, $m ) !== 0 ) {
				$filter_parameters[ $key ] = wp_kses_post( $value );
			} elseif ( $key === 'graphina_loader' ) {
				$filter_parameters[ $key ] = sanitize_url( $value );
			} elseif ( $key === 'nonce' ) {
				$filter_parameters[ $key ] = sanitize_key( $value );
			} elseif ( filter_var( $value, FILTER_VALIDATE_URL ) !== false ) {
					$filter_parameters[ $key ] = sanitize_url( $value );
			} else {
				$filter_parameters[ $key ] = sanitize_text_field( $value );
			}
		}

		return $filter_parameters;
	}
}


// Check if the function graphina_validate_required_fields already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_validate_required_fields' ) ) {
	/**
	 * Validate required fields and return error messages if fields are missing.
	 *
	 * @param array $data The input data to validate.
	 * @param array $rules The validation rules specifying required fields.
	 * @param array $messages The error messages for each field.
	 *
	 * @return array An array containing the validation status, individual errors, and a combined error message.
	 */
	function graphina_validate_required_fields( $data, $rules, $messages ) {
		$errors                 = array();
		$combined_error_message = '';

		// Loop through the rules to check if required fields are missing
		foreach ( $rules as $field => $rule ) {
			if ( $rule === 'required' && empty( $data[ $field ] ) ) {
				// If the field is missing, add the corresponding error message
				$error_message    = isset( $messages[ $field ] ) ? $messages[ $field ] : esc_html__( 'This field is required', 'graphina-charts-for-elementor' );
				$errors[ $field ] = $error_message;

				// Append each error message to the combined error message string
				$combined_error_message .= $error_message . ' ';
			}
		}

		// Return the validation result with combined error message
		if ( ! empty( $errors ) ) {
			return array(
				'status'  => false,
				'errors'  => $errors,
				'message' => trim( $combined_error_message ), // Trim any extra space at the end
			);
		}

		return array(
			'status'  => true,
			'message' => esc_html__( 'All fields are valid', 'graphina-charts-for-elementor' ),
		);
	}
}

// Check if the function graphina_position_type already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_position_type' ) ) {
	/**
	 * Get position type options for Graphina.
	 *
	 * This function returns an array of position type options based on the provided type.
	 * If $first is true, it returns only the first key of the options array.
	 *
	 * @param string $type  The type of position options to retrieve. Defaults to 'vertical'.
	 * @param bool   $first Whether to return only the first key of the options array. Defaults to false.
	 *
	 * @return array|int|string|null The array of position type options or the first key of the options array.
	 */
	function graphina_position_type( string $type = 'vertical', bool $first = false ): array|int|string|null {
		$result = array();
		switch ( $type ) {
			case 'vertical':
				$result = array(
					'top'    => esc_html__( 'Top', 'graphina-charts-for-elementor' ),
					'center' => esc_html__( 'Center', 'graphina-charts-for-elementor' ),
					'bottom' => esc_html__( 'Bottom', 'graphina-charts-for-elementor' ),
				);
				break;
			case 'horizontal_boolean':
				$result = array(
					''    => array(
						'title' => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-arrow-left',
					),
					'yes' => array(
						'title' => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
						'icon'  => 'eicon-arrow-right',
					),
				);
				break;

			case 'placement':
				$result = array(
					'on'      => esc_html__( 'On', 'graphina-charts-for-elementor' ),
					'between' => esc_html__( 'Between', 'graphina-charts-for-elementor' ),
				);
				break;
			case 'in_out':
				$result = array(
					'in'  => esc_html__( 'In', 'graphina-charts-for-elementor' ),
					'out' => esc_html__( 'Out', 'graphina-charts-for-elementor' ),
				);
				break;
			case 'google_chart_legend_position':
				$result = array(
					'top'    => esc_html__( 'Top', 'graphina-charts-for-elementor' ),
					'bottom' => esc_html__( 'Bottom', 'graphina-charts-for-elementor' ),
					'left'   => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
					'right'  => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
					'in'     => esc_html__( 'Inside', 'graphina-charts-for-elementor' ),
				);
				break;
			case 'google_piechart_legend_position':
				$result = array(
					'top'     => esc_html__( 'Top', 'graphina-charts-for-elementor' ),
					'bottom'  => esc_html__( 'Bottom', 'graphina-charts-for-elementor' ),
					'left'    => esc_html__( 'Left', 'graphina-charts-for-elementor' ),
					'right'   => esc_html__( 'Right', 'graphina-charts-for-elementor' ),
					'labeled' => esc_html__( 'Labeled', 'graphina-charts-for-elementor' ),
				);
				break;
			case 'orientation':
				$result = array(
					'horizontal' => esc_html__( 'Horizontal', 'graphina-charts-for-elementor' ),
					'vertical'   => esc_html__( 'Vertical', 'graphina-charts-for-elementor' ),
				);
				break;
		}
		// Return the first key if $first is true, otherwise return the options array.
		return $first ? array_key_first( $result ) : $result;
	}
}

// Check if the function graphina_stroke_curve_type already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_stroke_curve_type' ) ) {
	/**
	 * Get stroke curve type options for Graphina.
	 *
	 * This function returns an array of stroke curve type options, or the first key if specified.
	 *
	 * @param bool $first Whether to return only the first key of the options array. Defaults to false.
	 *
	 * @return array|string The array of stroke curve type options or the first key of the options array.
	 */
	function graphina_stroke_curve_type( bool $first = false ): array|string {
		// Define the stroke curve type options.
		$options = array(
			'smooth'   => esc_html__( 'Smooth', 'graphina-charts-for-elementor' ),
			'straight' => esc_html__( 'Straight', 'graphina-charts-for-elementor' ),
			'stepline' => esc_html__( 'Stepline', 'graphina-charts-for-elementor' ),
		);

		// Return the first key if $first is true, otherwise return the options array.
		return $first ? 'smooth' : $options;
	}
}

// Check if the function graphina_get_dynamic_tag_data already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_get_dynamic_tag_data' ) ) {
	/**
	 * Get dynamic tag data from element settings.
	 *
	 * @param array  $ele_setting_vals Array of element setting values.
	 * @param string $main_key The main key to retrieve from the settings array.
	 * @return string|null The sanitized dynamic tag data.
	 */
	function graphina_get_dynamic_tag_data( array $ele_setting_vals, string $main_key ): string {
		return isset( $ele_setting_vals[ $main_key ] ) ? str_replace( "'", "\'", (string) $ele_setting_vals[ $main_key ] ) : '';
	}
}

// Check if the function generate_chart_locales already exists to avoid redeclaration errors.
if ( ! function_exists( 'generate_chart_locales' ) ) {
	/**
	 * Generate the locales configuration for the chart toolbar and additional date-related labels.
	 *
	 * This function dynamically creates localization settings for the chart, including toolbar labels,
	 * month names, and day names, with support for WordPress internationalization.
	 *
	 * @param string $locale The locale code (e.g., 'en', 'fr').
	 * @return array The configuration array for the toolbar's localization and date-related labels.
	 */
	function generate_chart_locales( $locale = 'en' ) {
		$options = apply_filters( 'gcfe_chart_locales_options', array(), 12 );
		return array(
			'name'    => $locale, // Set the locale code (e.g., 'en' for English).
			'options' => $options,
		);
	}
}

// Check if the function graphina_prepare_chart_responsive_options already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_prepare_chart_responsive_options' ) ) {
	/**
	 * Prepare common chart responsive options for Apex Chart.
	 *
	 * @param array  $settings Chart settings array.
	 * @param string $chart_type The type of the chart (e.g., column, bar, etc.).
	 * @return array $chart_responsive_options Prepared chart options array.
	 */
	function graphina_prepare_chart_responsive_options( $settings, $chart_type ) {
		$chart_responsive_options = array(
			array(
				'breakpoint' => 1024,
				'options'    => array(
					'chart' => array(
						'height' => !empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_height_tablet']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_height_tablet'] : 350,
					),
					'xaxis' => array(
						'title' => array(
							'style' => array(
								'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['unit'] : '12px',

							)
						),
						'labels' => array(
							'style' => array(
								'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['unit'] : '12px',

							)
						)
					),
					'yaxis' => array(
						'title' => array(
							'style' => array(
								'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['unit'] : '12px',

							)
						),
						'labels' => array(
							'style' => array(
								'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['unit'] : '12px',

							)
						)
					),
					'legend' => array(
						'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['unit'] : '12px',

					),
					'dataLabels' => array(
						'style' => array(
							'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_tablet']['unit'] : '12px',

						)
					)
				),
			),

			array(
				'breakpoint' => 674,
				'options'    => array(
					'chart' => array(
						'height' => !empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_height_mobile']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_height_mobile'] : 350,
					),
					'xaxis' => array(
						'title' => array(
							'style' => array(
								'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['unit'] : '12px',

							)
						),
						'labels' => array(
							'style' => array(
								'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['unit'] : '12px',

							)
						)
					),
					'yaxis' => array(
						'title' => array(
							'style' => array(
								'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['unit'] : '12px',

							)
						),
						'labels' => array(
							'style' => array(
								'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['unit'] : '12px',

							)
						)
					),
					'legend' => array(
						'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['unit'] : '12px',

					),
					'dataLabels' => array(
						'style' => array(
							'fontSize'   => ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['size']) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['size'] . $settings[GRAPHINA_PREFIX . $chart_type . '_chart_font_size_mobile']['unit'] : '12px',

						)
					)
				),
			),
		);

		return $chart_responsive_options;
	}
}



/**
 * Generate a random number within a specified range.
 *
 * This function generates a random integer between the specified minimum
 * and maximum values, inclusive.
 *
 * @param int $min The minimum value for the random number.
 * @param int $max The maximum value for the random number.
 *
 * @return int A random integer between the specified minimum and maximum values.
 */
function graphina_generate_random_number( int $min, int $max ): int {
	// Ensure that the minimum and maximum values are cast to integers.
	return wp_rand( $min, $max );
}

// Check if the function graphina_prepare_extra_data_for_google_chart already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_prepare_extra_data_for_google_chart' ) ) {
	/**
	 * Prepares extra data for Google Charts based on chart settings.
	 *
	 * This function extracts and formats additional settings for a Google Chart from the provided settings array
	 * and chart type. It ensures all required properties are set and provides default values where necessary.
	 *
	 * @param array  $settings   The settings array containing configuration for the chart.
	 * @param string $chart_type The type of the chart (e.g., 'line', 'bar', etc.).
	 *
	 * @return array An associative array of prepared settings ready to be used in the Google Chart.
	 */
	function graphina_prepare_extra_data_for_google_chart( $settings, $chart_type ) {

		$response = array(
			'show_annotation'                       => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_annotation_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_annotation_show' ] == 'yes' ? true : false,
			'chart_annotation_prefix_postfix'       => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_annotation_prefix_postfix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_annotation_prefix_postfix' ] : false,
			'chart_annotation_prefix'               => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_annotation_prefix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_annotation_prefix' ] : '',
			'chart_data_series_count_dynamic'       => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' ] ) : 1,
			'chart_annotation_postfix'              => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_annotation_postfix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_annotation_postfix' ] : '',
			'chart_data_option'                     => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_option' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_option' ] === 'dynamic' ? true : false,
			'chart_csv_column_wise_enable'          => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_csv_column_wise_enable' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_csv_column_wise_enable' ] === 'yes' ? true : false,
			'chart_dynamic_data_option'             => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_dynamic_data_option' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_dynamic_data_option' ] : '',
			'chart_csv_x_columns'                   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_csv_x_columns' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_csv_x_columns' ] : '',
			'chart_csv_y_columns'                   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_csv_y_columns' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_csv_y_columns' ] : '',
			'chart_csv_x_columns_sql'               => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_sql_builder_x_columns' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_sql_builder_x_columns' ] : '',
			'chart_csv_y_columns_sql'               => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_sql_builder_y_columns' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_sql_builder_y_columns' ] : '',
			'element_import_from_table_dynamic_key' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_element_import_from_table_dynamic_key' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_element_import_from_table_dynamic_key' ] : '',
			'current_post_id'                       => get_the_ID(),
			'graphina_prefix'                       => GRAPHINA_PREFIX,
			'can_chart_reload_ajax'              => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_can_chart_reload_ajax' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_can_chart_reload_ajax' ] === 'yes' ? true : false,
			'interval_data_refresh'              => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_interval_data_refresh' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_interval_data_refresh' ] ) : 15,
			'is_chart_horizontal'                => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_horizontal' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_horizontal' ] === 'yes' ? true : false,
		);
		if ( $chart_type === 'gauge_google' ) {
			$response['ballColor']        = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_round_ball_color' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_round_ball_color' ] : '';
			$response['innerCircleColor'] = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_inner_circle_color' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_inner_circle_color' ] : '';
			$response['outerCircleColor'] = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_outer_circle_color' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_outer_circle_color' ] : '';
			$response['needleColor']      = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_needle_color' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_needle_color' ] : '';
			$response['prefix'] = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_value_prefix'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_value_prefix'] : '';
            $response['suffix'] = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_value_postfix'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_value_postfix'] : '';
            $response['fractionDigits'] = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_value_decimal'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_value_decimal'] : 0;
        }
		
		if( 'geo_google' === $chart_type ){
			$response['geo_label']		=	! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_label_text'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_label_text'] : '';
		}

        if(in_array($chart_type,array('donut_google','pie_google')))
        {
            $response['prefix'] = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label_prefix'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label_prefix'] : '';
            $response['suffix'] = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label_postfix'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label_postfix'] : '';    
        }

		if ( $chart_type === 'gantt_google' ) {
			$dependColumn = [];
			if (!empty($settings[ GRAPHINA_PREFIX . $chart_type . '_value_list_3_1_repeaters'] )) {
                foreach ($settings[ GRAPHINA_PREFIX . $chart_type . '_value_list_3_1_repeaters' ] as $key => $value) {
                    $dependColumn[$value["_id"]] = $value[ GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_name' ];
                }
            }
			$response['dependColumn'] = $dependColumn;
		} 
		return $response;
	}
}

// Check if the function graphina_prepare_google_chart_data already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_prepare_google_chart_data' ) ) {
	/**
	 * Prepares data for Google Charts based on settings and chart type.
	 *
	 * This function extracts and formats the series data and categories required for rendering
	 * a Google Chart. It ensures data integrity and dynamically retrieves values using
	 * Graphina's utility functions.
	 *
	 * @param array  $settings   The settings array containing chart configuration.
	 * @param string $chart_type The type of the chart (e.g., 'line', 'bar', etc.).
	 *
	 * @return array An associative array containing 'categories' and 'series' data for the chart.
	 */
	function graphina_prepare_google_chart_data( $settings, $chart_type ) {

		$series_count = $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' ] ?? 0;
		$response     = array();
		// Prepare series data
		$series_temp = array();
		if ( in_array( $chart_type, array( 'area_google', 'column_google', 'line_google', 'bar_google' ) ) ) {
			$columns = array( 'Category' );
			$rows    = array();

			$series_temp = array();

			// Prepare series data
			for ( $i = 0; $i < $series_count; $i++ ) {
				$title     = esc_html( graphina_get_dynamic_tag_data( $settings, GRAPHINA_PREFIX . $chart_type . '_chart_title_3_' . $i ) );
				$columns[] = $title; // Add series name to columns

				$value_list = $settings[ GRAPHINA_PREFIX . $chart_type . '_value_list_3_1_' . $i ] ?? array();
				$values     = array_map(
					fn( $v ) => (float) graphina_get_dynamic_tag_data( $v, GRAPHINA_PREFIX . $chart_type . '_chart_value_3_' . $i ),
					$value_list
				);

				$series_temp[] = $values;
			}

			// Prepare categories and combine into rows
			if ( ! in_array( $chart_type, array( 'gauge_google' ) ) ) {
				$category_list = $settings[ GRAPHINA_PREFIX . $chart_type . '_category_list' ] ?? array();
				if ( $settings[  GRAPHINA_PREFIX . $chart_type  . '_chart_data_option' ] === 'manual' ) {
					
					$xaxis_prefix   = '';
					$xaxis_postfix  = '';
					if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type  . '_chart_haxis_label_prefix_postfix' ] ) ) {
						$xaxis_prefix  = $settings[ GRAPHINA_PREFIX . $chart_type  . '_chart_haxis_label_prefix' ];
						$xaxis_postfix = $settings[ GRAPHINA_PREFIX . $chart_type  . '_chart_haxis_label_postfix' ];
					}
				}
				$categories    = array_map(
					fn( $v ) => $xaxis_prefix.htmlspecialchars_decode( esc_html( graphina_get_dynamic_tag_data( $v, GRAPHINA_PREFIX . $chart_type . '_chart_category' ) ) ).$xaxis_postfix,
					$category_list
				);

				foreach ( $categories as $index => $category ) {
					$row = array( $category );
					foreach ( $series_temp as $series ) {
						$row[] = $series[ $index ] ?? null; // Ensure proper alignment
					}
					$rows[] = $row;
				}
			}

			$modified_columns 	= array();
			$modified_rows    	= array();
			$annotation_postfix = '';
			$annotation_prefix  = '';

			if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_annotation_prefix_postfix' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_annotation_prefix_postfix' ] === 'yes' ) {
				$annotation_prefix = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_annotation_prefix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_annotation_prefix' ] : '' ;
				$annotation_postfix  = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_annotation_postfix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_annotation_postfix' ] : '' ;
			}

			$annotation_enabled = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_annotation_show' ] ) 
				&& 'yes' === $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_annotation_show' ];

			foreach ( $columns as $index => $column ) {
				$modified_columns[] = array(
					'type'  => ( 0 === $index ) ? 'string' : 'number',
					'label' => $column,
				);

				if ( $annotation_enabled && 0 !== $index ) {
					$modified_columns[] = array(
						'type' => 'string',
						'role' => 'annotation',
					);
				}
			}

			foreach ( $rows as $row ) {
				$new_row = array();
				foreach ( $row as $key => $value ) {
					$new_row[] = $value;
					if ( $annotation_enabled && 0 !== $key ) {
						$new_row[] = $annotation_prefix . (string) $value . $annotation_postfix;
					}
				}
				$modified_rows[] = $new_row;
			}

			// Prepare response in desired format.
			$response = array(
				'columns' => $modified_columns,
				'rows'    => $modified_rows,
			);
		} elseif ( 'gantt_google' === $chart_type ) {
			$lineData     = array();
			$dependColumn = array();
			if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_value_list_3_1_repeaters' ] ) ) {
				foreach ( $settings[ GRAPHINA_PREFIX . $chart_type . '_value_list_3_1_repeaters' ] as $key => $value ) {
					// Depended values
					$dependColumn[ $value['_id'] ] = $value[ GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_name' ];
					$depend                        = '';
					if ( ! empty( $value[ GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_dependencies' ] ) ) {
						$depend = implode( ',', $value[ GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_dependencies' ] );
					}
					$temp       = array(
						$value['_id'],
						$value[ GRAPHINA_PREFIX . 'gantt_google_chart_value_3_element_name' ],
						! empty( $value[ GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_resource' ] ) ? $value[ GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_resource' ] : 'resources' . $key,
						$value[ GRAPHINA_PREFIX . 'gantt_google_chart_value_3_element_start_date' ],
						$value[ GRAPHINA_PREFIX . 'gantt_google_chart_value_3_element_end_date' ],
						'null',
						$value[ GRAPHINA_PREFIX . 'gantt_google_chart_value_3_element_percent_complete' ],
						$depend,
					);
					$lineData[] = $temp;
				}
			}
			return $lineData;
		} elseif ( 'org_google' === $chart_type ) {
			if ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_option' ] === 'manual' ) {
				for ( $j = 0; $j < $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' ]; $j++ ) {
					$orgData[] = array(
						$settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_child' . $j ],
						$settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_parent' . $j ],
						$settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_tooltip' . $j ],
					);
				}
				return $orgData;
			}
		} elseif ( in_array( $chart_type, array( 'pie_google', 'donut_google' ) ) ) {
			$donut_data = array();
			$postfix = '';
			$prefix  = '';

			if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label_prefix_postfix' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label_prefix_postfix' ] === 'yes' ) {
				$prefix = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label_prefix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label_prefix' ] : '' ;
				$postfix  = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label_postfix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label_postfix' ] : '' ;
			}
			for ( $i = 0; $i < $series_count; $i++ ) {
				if ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_option' ] === 'manual' ) {
					$donut_data['rows'][] = array( $prefix . esc_html( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label' . $i ] ) . $postfix, (float) $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_value' . $i ] );
				}
			}
			$donut_data['columns'] = array(
				array( 'string', ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_columnone_title' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_columnone_title' ] : 'Month' ),
				array( 'number', ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_columntwo_title' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_columntwo_title' ] : 'Sales' ),
			);
			return $donut_data;
		} elseif ( 'gauge_google' === $chart_type ) {
			$gauge_data = array();
			for ( $i = 0; $i < $series_count; $i++ ) {
				if ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_option' ] === 'manual' ) {
					$gauge_data['rows'][] = array( esc_html( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_element_setting_title_' . $i ] ), (float) $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_element_setting_value_' . $i ] );
				}
			}
			$gauge_data['columns'] = array(
				array( 'string', 'Name' ),
				array( 'number', 'Meter' ),
			);
			return $gauge_data;
		} elseif ( 'geo_google' === $chart_type ) {
			$geo_data = array();
			if ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_option' ] === 'manual' ) {
				foreach ( $settings[ GRAPHINA_PREFIX . $chart_type . '_category_list' ] as $key => $value ) {
					$geo_data['rows'][] = array(
						$value[ GRAPHINA_PREFIX . $chart_type . '_chart_category' ],
						isset( $settings[ GRAPHINA_PREFIX . $chart_type . '_value_list_3_1_element_setting' ][ $key ][ GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_value_list_3_1_element_setting' ][ $key ][ GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting' ] : rand( 0, 200 ),
					);
				}
			}
			$geo_data['columns'] = array(
				array( 'string', ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_title_3_element_setting' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_title_3_element_setting' ] : 'Region' ),
				array( 'number', ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_label_text' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_google_chart_label_text' ] : 'Value' ),
			);
			if ( $settings[ GRAPHINA_PREFIX . $chart_type . '_can_geo_have_more_element' ] ){
				$total_elements = $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' ];
				$row_temp = $geo_data['rows'] = array();
				for ($i = 0; $i < $total_elements; $i++) {
					$value_list    = $settings[GRAPHINA_PREFIX . $chart_type . '_value_list_3_1_element_setting_' . $i] ?? array();
					$values        = array_map(
						fn($v) => (float) graphina_get_dynamic_tag_data($v, GRAPHINA_PREFIX . $chart_type . '_chart_value_3_element_setting_' . $i),
						$value_list
					);
					$row_temp[] = $values;
				}
				foreach ( $settings[ GRAPHINA_PREFIX . $chart_type . '_category_list' ] as $key => $value ) {
					$geo_data['rows'][] = array(
						$value[ GRAPHINA_PREFIX . $chart_type . '_chart_category' ],
					);
				}
				$result = [];

				foreach ($geo_data['rows'] as $index => $country_row) {
					$new_row = [$country_row[0]];
					
					foreach ($row_temp as $values) {
						if (isset($values[$index])) {
							$new_row[] = $values[$index];
						}
					}
					
					$result[] = $new_row;
				}

				$geo_data['rows'] = $result;

				$geo_data['columns'] = array(
					array( 'string', 'Region' ),
				);
				$temp_column = array();
				for ($i=0; $i < $total_elements; $i++) { 
					$temp_column[] 	= array( 'number', ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_title_3_element_setting_' . $i ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_title_3_element_setting_' . $i ] : 'Value' );
				}
				$geo_data['columns'] = array_merge($geo_data['columns'],$temp_column);
			}
			return $geo_data;
		}
		return $response;
	}
}

// Ensure the function does not already exist before defining it
if ( ! function_exists( 'graphina_prepare_table_extra_data' ) ) {
	/**
	 * Prepares extra table data for dynamic tables.
	 *
	 * This function determines whether the table data is dynamic and retrieves
	 * the current post ID. It is used primarily for handling data table settings
	 * in Graphina tables.
	 *
	 * @param array  $settings   The settings array containing table configurations.
	 * @param string $table_type The type of table being used.
	 *
	 * @return array Returns an array with dynamic table status and the current post ID.
	 */
	function graphina_prepare_table_extra_data( $settings, $table_type ) {
		$table_options = array(
			'current_post_id' => get_the_ID(),
			'prefix'          => GRAPHINA_PREFIX,
		);
		if ( 'data_table_lite' === $table_type ) {
			$header_align 	= isset( $settings[ GRAPHINA_PREFIX . $table_type . '_table_header_align' ] ) ? $settings[ GRAPHINA_PREFIX . $table_type . '_table_header_align' ] : 'center';
			$table_options['header_class']			= "dt-head-$header_align";
			$table_options['table_data_direct'] 	= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . 'table_data_direct' ] ) && $settings[ GRAPHINA_PREFIX . $table_type . 'table_data_direct' ] === 'yes' ? true : false;
			$table_options['table_footer'] 			= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . 'table_footer' ] ) && $settings[ GRAPHINA_PREFIX . $table_type . 'table_footer' ] === 'yes' ? true : false;
			$table_options['is_dynamic_table'] 		= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_chart_data_option' ] ) && $settings[ GRAPHINA_PREFIX . $table_type . '_chart_data_option' ] === 'dynamic' ? true : false;
			$table_options['hide_column_header']	= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_hide_table_header' ] ) && $settings[ GRAPHINA_PREFIX . $table_type . '_hide_table_header' ] === 'yes' ? false : true;
		}
		if ( 'advance-datatable' === $table_type ) {
			$table_options['pagination_text_color']  	= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_pagination_text_color' ] ) ? $settings[ GRAPHINA_PREFIX . $table_type . '_pagination_text_color' ] : '';
			$table_options['pagination_button_height']  = ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_pagination_button_height' ] ) ? $settings[ GRAPHINA_PREFIX . $table_type . '_pagination_button_height' ]['size'] : 12;
			$table_options['pagination_align'] 			= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_pagination_align' ] ) ? $settings[ GRAPHINA_PREFIX . $table_type . '_pagination_align' ] : 'right';
			$table_options['is_dynamic_table'] 			= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_element_data_option' ] ) && $settings[ GRAPHINA_PREFIX . $table_type . '_element_data_option' ] === 'dynamic' ? true : false;
			$table_options['is_pagination']    			= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_table_pagination' ] ) && $settings[ GRAPHINA_PREFIX . $table_type . '_table_pagination' ] === 'yes' ? true : false;
			$table_options['pagination_type']  			= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_pagination_type' ] ) ? $settings[ GRAPHINA_PREFIX . $table_type . '_pagination_type' ] : 'numbers';
			$table_options['page_range']       			= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_page_range' ] ) ? $settings[ GRAPHINA_PREFIX . $table_type . '_page_range' ] : 0;
			$table_options['pagination_row']   			= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_pagination_row' ] ) ? $settings[ GRAPHINA_PREFIX . $table_type . '_pagination_row' ] : 0;
			$table_options['pagination_info']  			= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_pagination_info' ] ) && $settings[ GRAPHINA_PREFIX . $table_type . '_pagination_info' ] === 'yes' ? true : false;
			$table_options['is_header']        			= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_can_show_header' ] ) && $settings[ GRAPHINA_PREFIX . $table_type . '_can_show_header' ] === 'yes' ? true : false;
			$table_options['header_in_body']   			= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_can_include_in_body' ] ) && $settings[ GRAPHINA_PREFIX . $table_type . '_can_include_in_body' ] === 'yes' ? true : false;
			$table_options['is_index']         			= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_can_show_index' ] ) && $settings[ GRAPHINA_PREFIX . $table_type . '_can_show_index' ] === 'yes' ? true : false;
			$table_options['index_header']     			= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_index_title' ] ) ? $settings[ GRAPHINA_PREFIX . $table_type . '_index_title' ] : '#';
			$table_options['index_type']       			= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_index_value_type' ] ) ? $settings[ GRAPHINA_PREFIX . $table_type . '_index_value_type' ] : 'number';
			$table_options['columns']          			= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_element_columns' ] ) ? $settings[ GRAPHINA_PREFIX . $table_type . '_element_columns' ] : 0;
			$table_options['rows']             			= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_element_rows' ] ) ? $settings[ GRAPHINA_PREFIX . $table_type . '_element_rows' ] : 0;
			$table_options['search']           			= ! empty( $settings[ GRAPHINA_PREFIX . $table_type . '_can_show_filter' ] ) && $settings[ GRAPHINA_PREFIX . $table_type . '_can_show_filter' ] === 'yes' ? true : false;
		}

		return $table_options;
	}
}

// Ensure the function does not already exist before defining it
if ( ! function_exists( 'graphina_prepare_table_data' ) ) {
	/**
	 * Prepares and formats table data for Graphina Elementor Charts plugin.
	 *
	 * This function processes table data for different chart types, handling:
	 * - JSON data parsing for header and body
	 * - Index column addition with customizable format (numeric/roman)
	 * - Header visibility and positioning options
	 *
	 * @param array  $settings    Elementor widget settings
	 * @param string $table_type  Type of table/chart being rendered
	 * @param string $element_id  Unique identifier for the Elementor element
	 *
	 * @return array Processed table data with 'header' and 'body' keys
	 */
	function graphina_prepare_table_data( $settings, $table_type, $element_id ) {
		// Initialize empty arrays for header and body
		$table_data = array(
			'header' => array(),
			'body'   => array(),
		);

		// Get the settings prefix for current table type
		$prefix = GRAPHINA_PREFIX . $table_type;

		// Parse JSON data if available
		$json_setting = $prefix . '_element_data_json';
		if ( isset( $settings[ $json_setting ] ) && is_string( $settings[ $json_setting ] ) ) {
			$parsed_data = json_decode( $settings[ $json_setting ], true );
			if ( json_last_error() === JSON_ERROR_NONE ) {
				$table_data['header'] = $parsed_data['header'] ?? array();
				$table_data['body']   = $parsed_data['body'] ?? array();
			}
		}

		// Add index column if enabled and not in editor mode
		if ( $settings[ $prefix . '_can_show_index' ] === 'yes' &&
			! ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) ) {

			// Add index column to header
			$index_title          = ! empty( $settings[ $prefix . '_index_title' ] )
				? $settings[ $prefix . '_index_title' ]
				: '#';
			$table_data['header'] = array_merge( array( $index_title ), $table_data['header'] );

			// Add index values to each row
			foreach ( $table_data['body'] as $index => $row ) {
				$index_value                  = ( $settings[ $prefix . '_index_value_type' ] === 'roman' )
					? graphina_integer_to_roman( $index + 1 )
					: $index + 1;
				$table_data['body'][ $index ] = array_merge( array( $index_value ), $row );
			}
		}

		// Handle header inclusion in body if enabled
		if ( $settings[ $prefix . '_can_include_in_body' ] === 'yes' ) {
			$table_data['body']   = array_merge( array( $table_data['header'] ), $table_data['body'] );
			$table_data['header'] = array();
		}

		// Remove header if disabled
		if ( $settings[ $prefix . '_can_show_header' ] !== 'yes' ) {
			$table_data['header'] = array();
		}
		
		return $table_data;

	}
}

// Ensure the function does not already exist before defining it
if ( ! function_exists( 'graphina_integer_to_roman' ) ) {
	/**
	 * Converts integers to Roman numerals for Graphina chart index display.
	 *
	 * Used in Graphina charts to display Roman numeral indices when the
	 * 'index_value_type' is set to 'roman'. Handles numbers from 1 to 3999.
	 *
	 * @since 1.0.0
	 *
	 * @param int $integer The number to convert (1-3999)
	 * @return string The Roman numeral representation
	 *
	 * @throws InvalidArgumentException If input is less than 1 or greater than 3999
	 */
	function graphina_integer_to_roman( $integer ) {
		// Validate input range (Roman numerals typically go up to 3999)
		$integer = intval( $integer );
		if ( $integer < 1 || $integer > 3999 ) {
			return (string) $integer; // Fallback to regular numbers if out of range
		}

		// Static array for Roman numeral conversion to improve performance
		static $ROMAN_NUMERALS = array(
			'M'  => 1000,
			'CM' => 900,
			'D'  => 500,
			'CD' => 400,
			'C'  => 100,
			'XC' => 90,
			'L'  => 50,
			'XL' => 40,
			'X'  => 10,
			'IX' => 9,
			'V'  => 5,
			'IV' => 4,
			'I'  => 1,
		);

		$result = '';

		// Convert to Roman numerals using integer division and modulus
		foreach ( $ROMAN_NUMERALS as $roman => $value ) {
			$count = intval( $integer / $value );
			if ( $count > 0 ) {
				$result  .= str_repeat( $roman, $count );
				$integer %= $value;
			}

			// Early exit if we've processed all digits
			if ( $integer <= 0 ) {
				break;
			}
		}

		return $result;
	}
}
// Ensure the function does not already exist before defining it
if ( ! function_exists( 'graphina_prepare_jqeury_table_data' ) ) {
	/**
	 * Prepares data for rendering a jQuery DataTable based on chart type and settings.
	 *
	 * This function processes the settings passed to it and formats the table's header, body, and other options
	 * needed for the DataTable. It also includes support for links in rows, custom button menus, and language settings.
	 *
	 * @param array  $settings  The settings array containing chart and table configurations.
	 * @param string $chart_type  The type of chart (e.g., 'area_chart', 'bubble_chart').
	 * @param string $element_id  The ID of the element (usually for widget or element identification).
	 *
	 * @return array  The options to configure the jQuery DataTable.
	 */
	function graphina_prepare_jqeury_table_data( $settings, $chart_type, $element_id ) {
		// Ensure necessary settings exist before proceeding
		if ( empty( $settings ) || empty( $chart_type ) ) {
			return array();
		}

		// Initialize header data array.
		$header_data  	= array();
		$column_count 	= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_element_columns' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_element_columns' ] ) : 0;

		$columnDefs 	= array();
		// Loop to prepare header titles.
		for ( $i = 0; $i < $column_count; $i++ ) {
			$title_key     = GRAPHINA_PREFIX . $chart_type . '_chart_header_title_' . $i;
			$title         = isset( $settings[ $title_key ] ) ? esc_html( $settings[ $title_key ] ) : '';
			if( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . 'has_column_width' . $i ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . 'has_column_width' . $i ] === 'yes') {
				$col_width     = GRAPHINA_PREFIX . $chart_type . '_table_column_width_' . $i; 
				$width         = isset( $settings[ $col_width ] ) ? esc_html( $settings[ $col_width ] ) : ''; 
				$width 		   = intval($width) - 40; // -40 for adjust width of jquery table columns.
				$columnDefs[]  = array('targets' => $i, 'width' => $width.'px' );
			}
			if( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_jquery_manual_column_wise_alignment' . $i ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_jquery_manual_column_wise_alignment' . $i ] === 'yes'){
				$body_align 	= isset( $settings[ GRAPHINA_PREFIX . $chart_type . '_table_manual_body_align' . $i ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_table_manual_body_align' . $i ] : 'center';
				$columnDefs[]     = [ 'className' => "dt-$body_align", 'targets' => $i ];
				$columnDefs[]     = [ 'className' => "dt-head-$body_align", 'targets' => $i ];
			}
			$header_data[] = array( 'title' => $title );
		}
		if ( 'dynamic' === $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_option' ] ){
			$dynamic_column_count 	= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_jquery_table_column_count' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_jquery_table_column_count' ] ) : 0;
			$columnDefs 			= array();
			for ( $i = 0; $i < $dynamic_column_count; $i++ ) {
				if( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_jquery_has_column_width' . $i ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_jquery_has_column_width' . $i ] === 'yes') {
					$col_width     	= GRAPHINA_PREFIX . $chart_type . '_jquery_table_column_width_' . $i; 
					$width         	= isset( $settings[ $col_width ] ) ? esc_html( $settings[ $col_width ] ) : ''; 
					$width 		   	= intval($width) - 40; // -40 for adjust width of jquery table columns.
					$columnDefs[]  	= array('targets' => $i, 'width' => $width.'px' );
				}
				if( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_jquery_column_wise_alignment' . $i ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_jquery_column_wise_alignment' . $i ] === 'yes' ){
					$body_align 	= isset( $settings[ GRAPHINA_PREFIX . $chart_type . '_table_body_align' . $i ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_table_body_align' . $i ] : 'center';
					$columnDefs[]     = [ 'className' => "dt-$body_align", 'targets' => $i ];
					$columnDefs[]     = [ 'className' => "dt-head-$body_align", 'targets' => $i ];
				}
			}

		}

		// Prepare body data (rows).
		$body_data = array();
		$class     = esc_attr( apply_filters( 'graphina_widget_table_url_class', '', $settings, $element_id ) );
		$row_count = isset( $settings[ GRAPHINA_PREFIX . $chart_type . '_element_rows' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_element_rows' ] ) : 0;

		for ( $i = 0; $i < $row_count; $i++ ) {
			$row_list_key = GRAPHINA_PREFIX . $chart_type . '_row_list' . $i;

			// Ensure row list exists and is an array.
			if ( ! isset( $settings[ $row_list_key ] ) || ! is_array( $settings[ $row_list_key ] ) ) {
				continue; // Skip this iteration if data is missing.
			}

			$row_list = $settings[ $row_list_key ];
			$row_data = array();

			foreach ( $row_list as $row ) {
				// Ensure 'row_value' key exists.
				$row_value_key = GRAPHINA_PREFIX . $chart_type . '_row_value';
				$row_value     = isset( $row[ $row_value_key ] ) ? esc_html( $row[ $row_value_key ] ) : '';

				// Handle row URL if conditions match.
				$row_url_key       = GRAPHINA_PREFIX . $chart_type . '_row_url';
				$row_link_text_key = GRAPHINA_PREFIX . $chart_type . '_row_link_text';

				if ( ! empty( $row[ $row_url_key ] ) && 'yes' === $row[ $row_url_key ] && ! empty( $row[ $row_link_text_key ] ) ) {
					$url       = esc_url( $row[ $row_link_text_key ] );
					$row_value = sprintf(
						'<a href="%s" target="_blank" class="%s">%s</a>',
						esc_url( $url ),
						esc_attr( $class ),
						esc_html( $row_value )
					);
				}
				$row_value  = apply_filters('graphina_jquery_row_value',$row_value);
				$row_data[] = $row_value;
			}

			// Ensure each row has the correct number of columns.
			while ( count( $row_data ) < $column_count ) {
				$row_data[] = ''; // Fill missing columns with empty values.
			}

			$body_data[] = $row_data;
		}


		// Handle button menu, ensuring it's set and is an array
		if ( isset( $settings[ GRAPHINA_PREFIX . $chart_type . '_button_menu' ] ) && ! is_array( $settings[ GRAPHINA_PREFIX . $chart_type . '_button_menu' ] ) ) {
			$button = array( $settings[ GRAPHINA_PREFIX . $chart_type . '_button_menu' ] );
		} else {
			$button = isset( $settings[ GRAPHINA_PREFIX . $chart_type . '_button_menu' ] )
				? $settings[ GRAPHINA_PREFIX . $chart_type . '_button_menu' ]
				: array();
		}

		$header_align 	= isset( $settings[ GRAPHINA_PREFIX . $chart_type . '_table_header_align' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_table_header_align' ] : 'center';
		$body_align 	= isset( $settings[ GRAPHINA_PREFIX . $chart_type . '_table_body_align' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_table_body_align' ] : 'center';

		$column_classes = [
			[ 'className' => "dt-head-$header_align", 'targets' => '_all' ],
			[ 'className' => "dt-$body_align", 'targets' => '_all' ],
		];

		$columnDefs     = array_merge($column_classes, $columnDefs);
		
		// Prepare the final DataTable options
		$table_options = array(
			'columns'      => $header_data,
			'data'         => $body_data,
			'searching'    => isset( $settings[ GRAPHINA_PREFIX . $chart_type . 'table_search' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . 'table_search' ] === 'yes',
			'paging'       => isset( $settings[ GRAPHINA_PREFIX . $chart_type . 'table_pagination' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . 'table_pagination' ] === 'yes',
			'info'         => isset( $settings[ GRAPHINA_PREFIX . $chart_type . 'table_pagination_info' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . 'table_pagination_info' ] === 'yes',
			'lengthChange' => false,
			'sort'         => isset( $settings[ GRAPHINA_PREFIX . $chart_type . 'table_sort' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . 'table_sort' ] === 'yes',
			'pagingType'   => isset( $settings[ GRAPHINA_PREFIX . $chart_type . 'pagination_type' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . 'pagination_type' ] : 'full',
			'scrollX'      => isset( $settings[ GRAPHINA_PREFIX . $chart_type . 'table_scroll' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . 'table_scroll' ] === 'yes' ? false : true,
			'scrollY'      => isset( $settings[ GRAPHINA_PREFIX . $chart_type . '_table_scroll_y' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_table_scroll_y' ] . 'px' : '',
			'pageLength'   => isset( $settings[ GRAPHINA_PREFIX . $chart_type . '_pagelength' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_pagelength' ] ) : 10,
			'responsive'   => isset( $settings[ GRAPHINA_PREFIX . $chart_type . 'table_scroll' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . 'table_scroll' ] === 'yes' ? false : true,
			'dom'          => 'Bfrtip',
			'lengthMenu'   => array( array( 10, 50, 100, -1 ), array( 10, 50, 100, 'All' ) ),
			'buttons'      => $button,
			'columnDefs' => $columnDefs,
			'deferRender'  => true,
			'language'     => array(
				'search'            => '',
				'info'              => esc_html__( 'Showing', 'graphina-charts-for-elementor' ). ' ' . '_START_' . ' '
					. esc_html__( 'to', 'graphina-charts-for-elementor' ) . ' '
					. '_END_' . ' ' . esc_html__( 'of', 'graphina-charts-for-elementor' ) . ' ' . '_TOTAL_' . ' ' .
					esc_html__( 'entries', 'graphina-charts-for-elementor' ),
				'searchPlaceholder' => esc_html__( 'Search....', 'graphina-charts-for-elementor' ),
				'emptyTable'        => esc_html__( 'No data available in table', 'graphina-charts-for-elementor' ),
				'zeroRecords'       => esc_html__( 'No matching records found', 'graphina-charts-for-elementor' ),
				'paginate'          => array(
					'first'    => esc_html__( 'First', 'graphina-charts-for-elementor' ),
					'last'     => esc_html__( 'Last', 'graphina-charts-for-elementor' ),
					'next'     => esc_html__( 'Next', 'graphina-charts-for-elementor' ),
					'previous' => esc_html__( 'Previous', 'graphina-charts-for-elementor' ),
				),
				'buttons'           => array(
					'copy'       => esc_html__( 'Copy', 'graphina-charts-for-elementor' ),
					'pdf'        => esc_html__( 'PDF', 'graphina-charts-for-elementor' ),
					'print'      => esc_html__( 'Print', 'graphina-charts-for-elementor' ),
					'excel'      => esc_html__( 'Excel', 'graphina-charts-for-elementor' ),
					'pageLength' => array(
						'-1' => esc_html__( 'Show all rows', 'graphina-charts-for-elementor' ),
						'_'  => esc_html__( 'Show ', 'graphina-charts-for-elementor' ) . '%d' . esc_html__( ' rows', 'graphina-charts-for-elementor' ),
					),
				),
			),
		);
		return $table_options;
	}
}

// Check if the function graphina_prepare_extra_data already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_prepare_extra_data' ) ) {
	/**
	 * Prepares extra data for Apex Charts based on chart settings.
	 *
	 * This function extracts and formats additional settings for a Apex Chart from the provided settings array
	 * and chart type. It ensures all required properties are set and provides default values where necessary.
	 *
	 * @param array  $settings   The settings array containing configuration for the chart.
	 * @param string $chart_type The type of the chart (e.g., 'line', 'bar', etc.).
	 *
	 * @return array An associative array of prepared settings ready to be used in the Apex Chart.
	 */
	function graphina_prepare_extra_data( $settings, $chart_type ) {
		$loading_text        = esc_html( ( isset( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_no_data_text' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_no_data_text' ] : '' ) );
		$extra_data = array(
			'no_data_text'						 => $loading_text,
			'legend_show_series_value'           => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_show_series_value' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_show_series_value' ] === 'yes' ? true : false,
			'xaxis_label_prefix_show'            => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_show' ] === 'yes' ? true : false,
			'xaxis_label_prefix'                 => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_prefix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_prefix' ] : '',
			'xaxis_label_postfix'                => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_postfix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_postfix' ] : '',
			'xaxis_show_time'                    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_show_time' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_show_time' ] === 'yes' ? true : false,
			'xaxis_show_date'                    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_show_date' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_show_date' ] === 'yes' ? true : false,
			'yaxis_label_prefix_show'            => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_show' ] === 'yes' ? true : false,
			'yaxis_label_format'                 => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_number_format' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_number_format' ] === 'yes' ? true : false,
			'yaxis_label_prefix'                 => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_prefix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_prefix' ] : '',
			'yaxis_label_postfix'                => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_postfix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_postfix' ] : '',
			'decimal_in_float'                   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_decimals_in_float' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_decimals_in_float' ] ) : 0,
			'chart_datalabel_decimals_in_float'  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_decimals_in_float' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_decimals_in_float' ] ) : 0,
			'chart_number_format_commas'         => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_number_format_commas' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_number_format_commas' ] === 'yes' ? true : false,
			'chart_yaxis_label_pointer'          => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_pointer' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_pointer' ] === 'yes' ? true : false,
			'chart_yaxis_label_pointer_number'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_pointer_number' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_label_pointer_number' ] ) : 0,
			'chart_opposite_yaxis_title_enable'  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title_enable' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_title_enable' ] === 'yes' ? true : false,
			'chart_opposite_yaxis_format_number' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_format_number' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_format_number' ] === 'yes' ? true : false,
			'chart_opposite_yaxis_label_show'    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_label_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_label_show' ] === 'yes' ? true : false,
			'chart_opposite_yaxis_label_prefix'  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_label_prefix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_label_prefix' ] : '',
			'chart_opposite_yaxis_label_postfix' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_label_postfix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_opposite_yaxis_label_postfix' ] : '',
			'chart_datalabel_prefix'             => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_prefix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_prefix' ] : '',
			'chart_tooltip_prefix_val'           => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_prefix_val' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_prefix_val' ] : '',
			'chart_datalabel_postfix'            => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_postfix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_postfix' ] : '',
			'chart_tooltip_postfix_val'          => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_postfix_val' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_postfix_val' ] : '',
			'chart_data_option'                  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_option' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_option' ] === 'dynamic' ? true : false,
			'dynamic_type'                       => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_option' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_option' ] : ',manual',
			'chart_dynamic_data_option'          => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_dynamic_data_option' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_dynamic_data_option' ] : '',
			'chart_data_series_count_dynamic'    => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' ] ) : 1,
			'chart_csv_column_wise_enable'       => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_csv_column_wise_enable' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_csv_column_wise_enable' ] === 'yes' ? true : false,
			'chart_csv_x_columns'                => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_csv_x_columns' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_csv_x_columns' ] : '',
			'chart_csv_y_columns'                => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_csv_y_columns' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_csv_y_columns' ] : '',
			'chart_csv_x_columns_sql'            => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_sql_builder_x_columns' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_sql_builder_x_columns' ] : '',
			'chart_csv_y_columns_sql'            => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_sql_builder_y_columns' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_sql_builder_y_columns' ] : '',
			'can_chart_reload_ajax'              => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_can_chart_reload_ajax' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_can_chart_reload_ajax' ] === 'yes' ? true : false,
			'interval_data_refresh'              => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_interval_data_refresh' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_interval_data_refresh' ] ) : 15,
			'is_chart_horizontal'                => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_horizontal' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_horizontal' ] === 'yes' ? true : false,
			'current_post_id'                    => get_the_ID(),
			'graphina_prefix'                    => GRAPHINA_PREFIX,
		);
		if ( $extra_data['dynamic_type'] === 'forminator' ) {
			$extra_data['section_chart_forminator_x_axis_columns']   = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_section_chart_forminator_x_axis_columns' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_section_chart_forminator_x_axis_columns' ] : '';
			$extra_data['section_chart_forminator_y_axis_columns']   = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_section_chart_forminator_y_axis_columns' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_section_chart_forminator_y_axis_columns' ] : '';
			$extra_data['section_chart_forminator_aggregate']        = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_section_chart_forminator_aggregate' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_section_chart_forminator_aggregate' ] === 'yes' ? true : false;
			$extra_data['section_chart_forminator_aggregate_column'] = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_section_chart_forminator_aggregate_column' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_section_chart_forminator_aggregate_column' ] : '';
			$extra_data['chart_data_option']                         = true;
		} elseif ( $extra_data['dynamic_type'] === 'firebase' ) {
			$extra_data['chart_data_option'] = true;
		}

		if ( $chart_type === 'counter' )
		{
			$color           = '';
			$headingColor    = '';
			$subHeadingColor = '';
			if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_counter_color_condition_based' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_counter_color_condition_based' ] === 'yes' ) {
				if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_counter_min_value' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_element_to_count' ] < (float) $settings[ GRAPHINA_PREFIX . $chart_type . '_counter_min_value' ] ) {
					$color = strval( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_counter_min_value_color' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_counter_min_value_color' ] : '' );
				}
				if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_counter_max_value' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_element_to_count' ] > (float) $settings[ GRAPHINA_PREFIX . $chart_type . '_counter_max_value' ] ) {
					$color = strval( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_counter_max_value_color' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_counter_max_value_color' ] : '' );
				}

				if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_counter_heading_color_condition_based' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_counter_heading_color_condition_based' ] === 'yes' ) {
					$headingColor = $color;
				}
				if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_counter_subheading_color_condition_based' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_counter_subheading_color_condition_based' ] === 'yes' ) {
					$subHeadingColor = $color;
				}
			}
			$extra_data['seperator']		  = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_counter_separator' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_counter_separator' ] : '';
			$extra_data['color']			  = $color;	
			$extra_data['headingColor']       = $headingColor;
			$extra_data['subHeadingColor']    = $subHeadingColor;
			$extra_data['show_counter_chart'] = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_element_show_chart' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_element_show_chart' ] === 'yes' ? true : false;
			$extra_data['element_column_no']  = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_element_column_no' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_element_column_no' ] : '';
			$extra_data['chart_data_option']  = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_element_data_option' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_element_data_option' ] === 'dynamic' ? true : false;
		}

		if( in_array( $chart_type, array( 'donut', 'pie', 'polar' ) ) )
		{
			$extra_data['chart_datalabel_decimals_in_float']  	= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label_pointer_number' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label_pointer_number' ] ) : 0;
			$extra_data['chart_number_format_commas']         	= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format' ] === 'yes' ? true : false;
			$extra_data['chart_data_label_pointer']				= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label_pointer' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label_pointer' ] === 'yes' ? true : false;
			$extra_data['chart_datalabel_prefix']				= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_format_prefix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_format_prefix' ] : '';
			$extra_data['chart_datalabel_postfix']				= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_format_postfix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabel_format_postfix' ] : '';
			$extra_data['chart_legend_show_series_postfix']				= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_show_series_postfix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_show_series_postfix' ] : '';
			$extra_data['chart_legend_show_series_prefix']				= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_show_series_prefix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_show_series_prefix' ] : '';
			$extra_data['chart_datalabels_format_showValue']     = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format_showValue' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format_showValue' ] === 'yes' ? true : false;
            $extra_data['chart_datalabels_format_showlabel']     = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format_showlabel' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_datalabels_format_showlabel' ] === 'yes' ? true : false;    
		}
		
		if ( in_array($chart_type, array('polar', 'radar')) )
		{
			$extra_data['yaxis_label_format']	= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_yaxis_chart_number_format_commas' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_yaxis_chart_number_format_commas' ] === 'yes' ? true : false;
			$extra_data['decimal_in_float']		= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_prefix_postfix_decimal_point' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_prefix_postfix_decimal_point' ] ) : 0;
			$extra_data['yaxis_label_prefix']  	= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_format_prefix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_format_prefix' ] : '';
			$extra_data['yaxis_label_postfix']  = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_format_postfix' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_format_postfix' ] : '';
		}
		
		if( in_array( $chart_type , ['heatmap', 'radial','radar','brush','distributed_column'])) {
			$extra_data['chart_label_pointer_number_for_label']	= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label_pointer_number_for_label' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label_pointer_number_for_label' ] : 0;
			$extra_data['string_format']						= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label_pointer_for_label' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_label_pointer_for_label' ] === 'yes' ? true : false;
		}

		if ( 'column' === $chart_type ){
			$extra_data['xaxis_label_pointer_number']	= 	! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_xaxis_label_pointer_number' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_xaxis_label_pointer_number' ] : 0;
			$extra_data['chart_xaxis_format_number']	=	! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_format_number' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_format_number' ] === 'yes' ? true : false;
			$extra_data['is_chart_horizontal']			=	! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_horizontal' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_horizontal' ] === 'yes' ? true : false;
			$extra_data['chart_xaxis_label_pointer']	=	! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_pointer' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_label_pointer' ] === 'yes' ? true : false;
		}

		if ( in_array( $chart_type, array( 'nested_column' ) ) )
		{
			$extra_data['tooltip_formatter']			= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_number_formatter' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_number_formatter' ] === 'yes' ? true : false;
			$extra_data['chart_tooltip_prefix_val']  	= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_prefix_val' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_prefix_val' ] : '';
			$extra_data['chart_tooltip_postfix_val']  	= ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_postfix_val' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_tooltip_postfix_val' ] : '';

		}

		if( 'tree' === $chart_type ){
			$extra_data['tree_template']	=	$settings[ GRAPHINA_PREFIX . $chart_type . '_tree_chart_template' ];
		}
		return $extra_data;
	}
}

// Check if the function graphina_chart_data_enter_options already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_chart_data_enter_options' ) ) {
	/**
	 * Retrieve chart data entry options based on chart type.
	 *
	 * @param string $chart_type The type of the chart.
	 *
	 * @return array The list of data entry options.
	 */
	function graphina_chart_data_enter_options( $chart_type ) {
		// Define default options
		$options = array(
			'csv'          => esc_html__( 'CSV', 'graphina-charts-for-elementor' ),
			'remote-csv'   => esc_html__( 'Remote CSV', 'graphina-charts-for-elementor' ),
			'google-sheet' => esc_html__( 'Google Sheet', 'graphina-charts-for-elementor' ),
			'api'          => esc_html__( 'API', 'graphina-charts-for-elementor' ),
		);

		if ( graphina_pro_active() ) {
			$options['filter'] = esc_html__( 'Data From Filter', 'graphina-charts-for-elementor' );
		}

		// Conditionally add the SQL Builder option for non-bubble charts
		if ( ! in_array( $chart_type, array( ' bubble', 'timeline', 'candle', 'nested_column', 'gantt_google', 'org_google', 'counter' ) ) ) {
			$options['sql-builder'] = esc_html__( 'SQL Builder', 'graphina-charts-for-elementor' );
		}
		if('counter' === $chart_type){
			$options['database'] = esc_html__('SQL Builder', 'graphina-charts-for-elementor');
		}
		/**
		 * Filter the chart data entry options.
		 *
		 * Allows plugins or themes to modify the data entry options.
		 *
		 * @param array  $options    The default data entry options.
		 * @param string $chart_type The type of the chart.
		 */
		return apply_filters( 'graphina_chart_data_enter_options', $options, $chart_type );
	}
}

// Check if the function graphina_get_random_date already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_get_random_date' ) ) {
	/**
	 * Generate a random date based on the given start date and adjustments.
	 *
	 * @param string $start The starting date in strtotime() compatible format.
	 * @param string $format The format in which the date should be returned.
	 * @param array  $add Associative array of units to add to the start date (e.g., ['day' => 2, 'month' => 1]).
	 * @param array  $minus Associative array of units to subtract from the start date (e.g., ['year' => 1]).
	 *
	 * @return string Formatted random date based on adjustments.
	 */
	function graphina_get_random_date( string $start, string $format, array $add = array(), array $minus = array() ): string {
		$date = '';
		foreach ( $add as $i => $a ) {
			$date .= ' + ' . $a . ' ' . $i;
		}
		foreach ( $minus as $j => $b ) {
			$date .= ' - ' . $b . ' ' . $j;
		}
		$timestamp = strtotime( $date, strtotime( $start ) );
		return date($format, $timestamp); //@phpcs:ignore
	}
}

// Check if the function graphina_chart_dynamic_options already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_chart_dynamic_options' ) ) {
	/**
	 * Provides dynamic options for Graphina charts.
	 *
	 * This function defines the available options for chart data types, such as 'Manual' and 'Dynamic',
	 * and allows developers to extend or modify these options using the 'graphina_chart_dynamic_options' filter.
	 *
	 * @return array An associative array of dynamic options with keys as identifiers and values as labels.
	 */
	function graphina_chart_dynamic_options( $chart_type ) {
		$options = array(
			'manual'  => esc_html__( 'Manual', 'graphina-charts-for-elementor' ),
			'dynamic' => esc_html__( 'Dynamic', 'graphina-charts-for-elementor' ),
		);

		/**
		 * Apply a filter to allow extending or modifying the dynamic options.
		 *
		 * Developers can use the 'graphina_chart_dynamic_options' filter to add, modify, or remove options
		 * dynamically based on their specific requirements.
		 *
		 * Example:
		 * add_filter('graphina_chart_dynamic_options', function($options) {
		 *     $options['custom'] = esc_html__('Custom Option', 'your-text-domain');
		 *     return $options;
		 * });
		 *
		 * @param array $options The default dynamic options.
		 */
		return apply_filters( 'graphina_chart_dynamic_options', $options, $chart_type );
	}
}



// Check if the function graphina_get_sheet already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_get_sheet' ) ) {
	/**
	 * Retrieves a Google Sheets CSV URL based on the specified chart type.
	 *
	 * This function maps different chart types to specific Google Sheets URLs, allowing data to be fetched
	 * dynamically for various chart visualizations. If the provided chart type doesn't match any specific case,
	 * a default sheet URL is returned.
	 *
	 * @param string $type The chart type for which the Google Sheets URL is required. Defaults to 'area'.
	 *
	 * @return string The Google Sheets CSV URL corresponding to the chart type.
	 */
	function graphina_get_sheet( $type = 'area' ) {

		$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ3m3MVzrfGLpJ5gCpTUMcPWCRwRo5hJ4HnJLXaEDUgMH0uxGTC0ch2INSN-3lSzB0h4fER5irvAUnf/pub?output=csv';

		switch ( $type ) {

			case 'donut':
			case 'pie':
			case 'polar':
			case 'radial':
			case 'gauge_google':
			case 'pie_google':
			case 'donut_google':
				$sheet = 'https://docs.google.com/spreadsheets/d/1OFfUoQIiECsypw29HokGibyEcVj1n9LjjRxgwSL9S-0/pub?gid=0&single=true&output=csv';
				break;
			case 'bubble':
				$sheet = 'https://docs.google.com/spreadsheets/d/1fbNhtw0lZY4VywF0Fg2dDsaExXBWfsGIQe1q2jbUrDs/pub?gid=0&single=true&output=csv';
				break;
			case 'timeline':
				$sheet = 'https://docs.google.com/spreadsheets/d/1iMQbNuJP-RlaN-lkZFFvT_DoESYHLoh3EmeyFHgz-X0/pub?gid=0&single=true&output=csv';
				break;
			case 'nested_column':
				$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRtcQwQfnOojZNt5wwJLJwcT4ZrPgw4JgcGgqysYpjOY6oxgA4FDHbrUraqTwZhRYqgFLxjuVs4hHIl/pub?output=csv';
				break;
			case 'counter':
				$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRRnlD17zCipwfBF592dhJWkxHqKXIrp7t4euWrljsk_TImRwwQV2avvvfqSVY-eGqMvuVwRORJTJvN/pub?gid=0&single=true&output=csv';
				break;
			case 'advance-datatable':
			case 'data_table_lite':
				$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ91TgvINoFUAdVlSRnf4S2S70S_Nj49ZwcBwccK3WR8jZOBDySzsGGeT5b1lGYBxIkTHsT0SwBxX92/pub?gid=0&single=true&output=csv';
				break;
			case 'brush':
				$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRqodXa_v_nsa5NYxKiY8SNN00mMRcS9uFxATmuR8u08o1wCN__8JVsvyiTj0eISFzQ-2Ve2rj2hU4Y/pub?gid=0&single=true&output=csv';
				break;
			case 'candle':
				$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSklaa28gAa5NML-Hz50jjnabdlrw5k464ygMf_mbjC85TXWZxCXocw5VJqBQ-m3U-n2F5Qxw1QjUCI/pub?gid=0&single=true&output=csv';
				break;
			case 'heatmap':
				$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRQGsswKt1EG0j0DjJGD2Ta7g_KFCln5EWa72yQqUsamMa1gsWdDyypcr3U7V6v4yOlFX6Uhz3w0O8D/pub?gid=0&single=true&output=csv';
				break;
			case 'mixed':
				$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vR8Ri1UvlaNp3pzHwVHTdDiP6w0ZIHmc-Y32wKL96oB2fX0eQn7XChivD5y_FPY8T0X6a9W_Ufc8DsI/pub?gid=1070616461&single=true&output=csv';
				break;
			case 'distributed_column':
				$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRMi5OyoH9vXs7jrgrNpkkndMnpD2gCbDvvvDIhXyB0TQRjN5mh0YI4i16zhwRiflwP2e9pUpM-gCZA/pub?gid=0&single=true&output=csv';
				break;
			case 'geo_google':
				$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQDeYPE5Y_2p8Zoze8KCfpxn4RClBLTqahQ-nGeDWLGaYb1iXLMMvcxC_cSClsXY8MMAQi9shxqm-Dj/pub?gid=0&single=true&output=csv';
				break;
			case 'org_google':
				$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vTEjHr5pBlNQASbKwjvh9uqzUpGWn6cG9Jfb6DO5Ov1p1SxHPv9HzHtjAA0yv-j5-TnSz6qE6VZ60mN/pub?gid=0&single=true&output=csv';
				break;
			case 'gantt_google':
				$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSp0m7C4UftLCn_eUgEBstLpEe29NK43ZA9q-VlMqQVOh3K3lrIXPVHnt5kIbJkZG6yPmketLY8oS3Q/pub?gid=0&single=true&output=csv';
				break;
			case 'tree':
				$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vTlZ0es19GnP-b7z12CIMfYnD4MblkNNXbDKyAuPhS4eUlXnjKRRKJ_345wVjVxg7xiIiLg_xy5zAGn/pub?gid=0&single=true&output=csv';
				break;
		}

		return $sheet;
	}
}

// Check if the function graphina_get_element_sheet already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_get_element_sheet' ) ) {
	/**
	 * Retrieves Google Sheets template URLs for different Graphina elements.
	 *
	 * This function provides template Google Spreadsheet URLs that users can reference
	 * when formatting their data for different Graphina chart types. These templates
	 * demonstrate the expected data structure for each chart type.
	 *
	 * @since 1.0.0
	 *
	 * @param string $type The chart type ('counter', 'advance-datatable', 'data_table_lite')
	 * @return string URL of the template Google Sheet or '#' if type is not supported
	 */
	function graphina_get_element_sheet( $type = '' ) {

		$sheet = '#';
		switch ( $type ) {

			case 'counter';
				$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRRnlD17zCipwfBF592dhJWkxHqKXIrp7t4euWrljsk_TImRwwQV2avvvfqSVY-eGqMvuVwRORJTJvN/pub?gid=0&single=true&output=csv';
				break;
			case 'advance-datatable';
			case 'data_table_lite':
				$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ91TgvINoFUAdVlSRnf4S2S70S_Nj49ZwcBwccK3WR8jZOBDySzsGGeT5b1lGYBxIkTHsT0SwBxX92/pub?gid=0&single=true&output=csv';
				break;
		}

		return $sheet;
	}
}

// Check if the function graphina_get_spreadsheet_column_wise already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_get_spreadsheet_column_wise' ) ) {
	/**
	 * Retrieves a Google Sheets CSV URL based on the specified chart type.
	 *
	 * This function maps different chart types to specific Google Sheets URLs, allowing data to be fetched
	 * dynamically for various chart visualizations. If the provided chart type doesn't match any specific case,
	 * a default sheet URL is returned.
	 *
	 * @param string $type The chart type for which the Google Sheets URL is required. Defaults to 'area'.
	 *
	 * @return string The Google Sheets CSV URL corresponding to the chart type.
	 */
	function graphina_get_spreadsheet_column_wise( $type = 'area' ) {

		$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQkRrVoxIkQ1yv1B16OvDRe8pey4wKM04lnPKoaOLbaf8NFOjf7gO_C1AJMJ5LK2uIz90SbIQ81LmHh/pub?gid=0&single=true&output=csv';

		switch ( $type ) {

			case 'donut':
			case 'pie':
			case 'polar':
			case 'radial':
			case 'gauge_google':
			case 'pie_google':
			case 'donut_google':
				$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQuWcxll6R12zsnNBneuYGCqky8T_H49GxrcDNowu2jGwmqaRKVajUe3WGMYXDEAFWJzNKCkSgTMAPT/pub?gid=0&single=true&output=csv';
				break;
			case 'distributed_column':
				$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQM-_3q7LO5aFHrKx1oEZQTDzAgzGjtmKZLTEi6LH7pcG4xRjp4swLjTd-BOlPpi_KKJ5nBUnqdZLfJ/pub?gid=0&single=true&output=csv';
				break;
			case 'brush':
				$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQkRrVoxIkQ1yv1B16OvDRe8pey4wKM04lnPKoaOLbaf8NFOjf7gO_C1AJMJ5LK2uIz90SbIQ81LmHh/pub?gid=0&single=true&output=csv';
				break;
			case 'geo_google':
				$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQkRrVoxIkQ1yv1B16OvDRe8pey4wKM04lnPKoaOLbaf8NFOjf7gO_C1AJMJ5LK2uIz90SbIQ81LmHh/pub?gid=872716505&single=true&output=csv';
				break;
		}

		return $sheet;
	}
}


// Check if the function graphina_google_chart_lists already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_google_chart_lists' ) ) {
	/**
	 * Retrieves a list of Google chart types supported by Graphina.
	 *
	 * This function returns an array of chart types that are specific to Google Charts.
	 * Each chart type is identified by its unique key.
	 *
	 * @return array An array of Google chart type identifiers.
	 */
	function graphina_google_chart_lists() {
		return array(
			'area_google',
			'bar_google',
			'column_google',
			'line_google',
			'pie_google',
			'donut_google',
			'gauge_google',
			'geo_google',
			'gantt_google',
			'org_google',
		);
	}
}


// Check if the function graphina_filter_common already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_filter_common' ) ) {
	/**
	 * Handles the rendering and customization of chart filters for Graphina charts.
	 *
	 * This function checks if chart filters are enabled for a specific chart type
	 * and includes the appropriate template for rendering the filters. It also triggers
	 * a custom action for further filter handling or customization.
	 *
	 * @param array  $settings   The settings array containing configuration for the chart.
	 * @param string $chart_type The type of chart (e.g., 'bar', 'line').
	 * @param string $element_id Optional. The unique identifier for the chart element.
	 */
	function graphina_filter_common( $settings, $chart_type, $chart_data,$element_id = '' ) {
		// Check if chart filtering is enabled for the given chart type.
		if (
			! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_enable' ] )
			&& $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_enable' ] === 'yes'
		) {

			// Load the chart filter template with the provided settings.
			graphina_get_template( 'chart-filter.php', compact( 'settings', 'chart_type', 'chart_data', 'element_id' ) );
		}

		// Trigger a custom action for additional filter customization or processing.
		do_action( 'graphina_custom_filter', $settings, $chart_type, $element_id );
	}
}

// Check if the function graphina_prepare_nested_column_chart_options already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_prepare_nested_column_chart_options' ) ) {
	/**
	 * Prepares the configuration options for a nested column chart.
	 *
	 * This function generates an array of chart options based on the settings and data provided.
	 * It includes options for chart appearance, data labels, toolbars, export functionality,
	 * and axes configurations.
	 *
	 * The function checks if the chart is already defined to avoid redeclaration errors.
	 * The generated chart options are used by the Graphina plugin for rendering nested column charts.
	 *
	 * @param array $chart_data  The chart data and settings to configure the chart options.
	 *                           This includes element ID, chart type, and any specific settings.
	 *
	 * @return array  The configuration options for rendering the chart.
	 */
	function graphina_prepare_nested_column_chart_options( $chart_data ) {
		// Ensure that chart_data is valid and contains necessary keys
		if ( empty( $chart_data ) || ! isset( $chart_data['settings'] ) || ! isset( $chart_data['chart_type'] ) ) {
			return array(); // Return an empty array if the data is insufficient
		}

		// Generate chart locale settings
		$locales = array( generate_chart_locales( get_locale() ) );

		// Build the chart options array
		$second_chart_options = array(
			'series'      => array( array( 'data' => array() ) ),
			'chart'       => array(
				'id'            => 'barQuarter-' . $chart_data['element_id'],
				'background'    => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_background_color1' ] )
					? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_background_color1' ]
					: '',
				'height'        => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_height' ] )
					? intval( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_height' ] )
					: 400, // Default to 400px if not set
				'width'         => '100%',
				'type'          => 'bar',
				'fontFamily'    => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_family' ] )
					? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_family' ]
					: 'Arial', // Default font
				'locales'       => $locales,
				'defaultLocale' => get_locale(),
				'stacked'       => true,
				'toolbar'       => array(
					'show'   => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_can_chart_show_toolbar' ] )
						? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_can_chart_show_toolbar' ]
						: 'false',
					'export' => array(
						'csv' => array(
							'filename' => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_export_filename' ] )
								? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_export_filename' ] . ' Sub Chart'
								: 'Chart_Sub_Chart',
						),
						'svg' => array(
							'filename' => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_export_filename' ] )
								? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_export_filename' ] . ' Sub Chart'
								: 'Chart_Sub_Chart',
						),
						'png' => array(
							'filename' => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_export_filename' ] )
								? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_export_filename' ] . ' Sub Chart'
								: 'Chart_Sub_Chart',
						),
					),
				),
			),
			'plotOptions' => array(
				'bar' => array(
					'columnWidth' => '50%',
					'horizontal'  => false,
				),
			),
			'noData'      => array(
				'text'          => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_no_data_text' ] )
					? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_no_data_text' ]
					: 'No data available',
				'align'         => 'center',
				'verticalAlign' => 'middle',
				'style'         => array(
					'fontSize'   => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_size' ]['size'] )
						? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_size' ]['size'] . $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_size' ]['unit']
						: '12px',
					'fontFamily' => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_family' ] )
						? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_family' ]
						: 'Arial',
					'color'      => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_color' ] )
						? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_color' ]
						: '#000000', // Default to black
				),
			),
			'legend'      => array(
				'show' => false,
			),
			'grid'        => array(
				'yaxis' => array(
					'lines' => array(
						'show' => false,
					),
				),
				'xaxis' => array(
					'lines' => array(
						'show' => true,
					),
				),
			),
			'yaxis'       => array(
				'labels' => array(
					'show' => false,
				),
			),
			'xaxis'       => array(
				'labels' => array(
					'trim'  => true,
					'style' => array(
						'colors'     => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_color' ] )
							? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_color' ]
							: '#000000', // Default to black
						'fontSize'   => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_size' ]['size'] )
							? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_size' ]['size'] . $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_size' ]['unit']
							: '12px',
						'fontFamily' => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_family' ] )
							? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_family' ]
							: 'Arial',
						'fontWeight' => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_weight' ] )
							? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_weight' ]
							: 'normal',
					),
				),
			),
			'dataLabels'  => array(
				'enabled'    => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_can_sub_chart_datalabel_show' ] )
					&& $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_can_sub_chart_datalabel_show' ] === 'yes'
					? true
					: false,
				'textAnchor' => 'middle',
				'style'      => array(
					'fontSize'   => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_size' ]['size'] )
						? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_size' ]['size'] . $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_size' ]['unit']
						: '12px',
					'fontFamily' => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_family' ] )
						? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_family' ]
						: 'Arial',
					'fontWeight' => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_weight' ] )
						? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_font_weight' ]
						: 'normal',
					'colors'     => array(
						isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_datalabel_background_show' ] ) && $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_datalabel_background_show' ] === 'yes'
							? ( ! empty( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_datalabel_font_color_1' ] ) ? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_datalabel_font_color_1' ] : '#000000' )
							: ( ! empty( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_datalabel_font_color' ] ) ? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_datalabel_font_color' ] : '#000000' ),
					),
				),
				'background' => array(
					'enabled'     => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_datalabel_background_show' ] ) && $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_datalabel_background_show' ] === 'yes',
					'foreColor'   => array( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_datalabel_background_color' ] ),
					'borderWidth' => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_datalabel_border_width' ] )
						? intval( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_datalabel_border_width' ] )
						: 1,
					'borderColor' => isset( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_datalabel_border_color' ] )
						? $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_chart_datalabel_border_color' ]
						: '#000000',
				),
			),
			'title'       => array(
				'text'    => '',
				'offsetX' => 10,
			),
		);

		return $second_chart_options; // Return the configured chart options
	}
}

// Check if the function graphina_prepare_brush_chart_options already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_prepare_brush_chart_options' ) ) {
	/**
	 * Prepares and configures options for Graphina brush charts.
	 *
	 * This function generates configuration options for brush charts in the Graphina plugin,
	 * including series data, styling, animations, and responsive behavior. Brush charts
	 * allow users to select and zoom into specific data ranges.
	 *
	 * @param array  $settings    Elementor widget settings
	 * @param string $chart_type  Type of chart being rendered
	 * @param string $element_id  Unique identifier for the Elementor element
	 *
	 * @return array Complete configuration array for the brush chart
	 */
	function graphina_prepare_brush_chart_options( $settings, $chart_type, $element_id ) {
		$series_count = $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' ] ?? 0;
		$series_temp  = $chart2Gradient = $dropShadowSeries = $second_gradient = $chart2StocKDash = $chart2StockWidth = $gradient = array();
		$type2        = 'brush_2';
		for ( $i = 0; $i < $series_count; $i++ ) {
			$dropShadowSeries[] = $i;
			$value_list         = $settings[ GRAPHINA_PREFIX . $chart_type . '_value_list_3_1_' . $i ] ?? array();
			$values             = array_map(
				fn( $v ) => (float) graphina_get_dynamic_tag_data( $v, GRAPHINA_PREFIX . $chart_type . '_chart_value_3_' . $i ),
				$value_list
			);

			$series_temp[]    = array(
				'name' => esc_html( graphina_get_dynamic_tag_data( $settings, GRAPHINA_PREFIX . $chart_type . '_chart_title_3_' . $i ) ),
				'data' => $values,
			);
			$chart2Gradient[] = ! empty( $settings[ GRAPHINA_PREFIX . $type2 . '_chart_gradient_1_' . $i ] ) ? strval( $settings[ GRAPHINA_PREFIX . $type2 . '_chart_gradient_1_' . $i ] ) : '';
			$gradient[]       = ! empty( $settings[ GRAPHINA_PREFIX . $type2 . '_chart_gradient_1_' . $i ] ) ? strval( $settings[ GRAPHINA_PREFIX . $type2 . '_chart_gradient_1_' . $i ] ) : '';
			if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_2_' . $i ] ) && strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_2_' . $i ] ) === '' ) {
				$second_gradient[] = strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_1_' . $i ] );
			} else {
				$second_gradient[] = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_2_' . $i ] ) ? strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_2_' . $i ] ) : '';
			}
			if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_bg_pattern_' . $i ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_bg_pattern_' . $i ] !== '' ) {
				$fill_pattern[] = $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_bg_pattern_' . $i ];
			} else {
				$fill_pattern[] = 'verticalLines';
			}

			if ( ! empty( $settings[ GRAPHINA_PREFIX . $type2 . '_chart_gradient_2_' . $i ] ) && strval( $settings[ GRAPHINA_PREFIX . $type2 . '_chart_gradient_2_' . $i ] ) === '' ) {
				$chart2SecondGradient[] = strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_gradient_1_' . $i ] );
			} else {
				$chart2SecondGradient[] = ! empty( $settings[ GRAPHINA_PREFIX . $type2 . '_chart_gradient_2_' . $i ] ) ? strval( $settings[ GRAPHINA_PREFIX . $type2 . '_chart_gradient_2_' . $i ] ) : '';
			}
			if ( ! empty( $settings[ GRAPHINA_PREFIX . 'brush_2' . '_chart_bg_pattern_' . $i ] ) && $settings[ GRAPHINA_PREFIX . 'brush_2' . '_chart_bg_pattern_' . $i ] !== '' ) {
				$chart2FillPattern[] = $settings[ GRAPHINA_PREFIX . 'brush_2' . '_chart_bg_pattern_' . $i ];
			} else {
				$chart2FillPattern[] = 'verticalLines';
			}

			$chart2StockWidth[] = ! empty( $settings[ GRAPHINA_PREFIX . 'brush_2' . '_chart_width_3_' . $i ] ) && $settings[ GRAPHINA_PREFIX . 'brush_2' . '_chart_width_3_' . $i ] !== '' ? $settings[ GRAPHINA_PREFIX . 'brush_2' . '_chart_width_3_' . $i ] : 0;
			$chart2StocKDash[]  = ! empty( $settings[ GRAPHINA_PREFIX . 'brush_2' . '_chart_dash_3_' . $i ] ) && $settings[ GRAPHINA_PREFIX . 'brush_2' . '_chart_dash_3_' . $i ] !== '' ? $settings[ GRAPHINA_PREFIX . 'brush_2' . '_chart_dash_3_' . $i ] : 0;

		}
		$gradient_new       = $second_gradient_new = $fill_pattern_new = array();
		$chart2gradient_new = $chart2second_gradient_new = $chart2fill_pattern_new = array();

		$desiredLength = count( $series_temp );

		while ( count( $gradient_new ) < $desiredLength ) {
			$gradient_new        = array_merge( $gradient_new, $gradient );
			$second_gradient_new = array_merge( $second_gradient_new, $second_gradient );
			$fill_pattern_new    = array_merge( $fill_pattern_new, $fill_pattern );
			// chart 2
			$chart2gradient_new        = array_merge( $chart2gradient_new, $chart2Gradient );
			$chart2second_gradient_new = array_merge( $chart2second_gradient_new, $chart2SecondGradient );
			$chart2fill_pattern_new    = array_merge( $chart2fill_pattern_new, $chart2FillPattern );
		}

		$gradient        = array_slice( $gradient_new, 0, $desiredLength );
		$second_gradient = array_slice( $second_gradient_new, 0, $desiredLength );
		$fill_pattern    = array_slice( $fill_pattern_new, 0, $desiredLength );
		// chart 2
		$chart2Gradient       = array_slice( $chart2gradient_new, 0, $desiredLength );
		$chart2SecondGradient = array_slice( $chart2second_gradient_new, 0, $desiredLength );
		$chart2FillPattern    = array_slice( $chart2fill_pattern_new, 0, $desiredLength );

		$category_list    = $settings[ GRAPHINA_PREFIX . $chart_type . '_category_list' ] ?? array();
		$categories       = array_map(
			fn( $v ) => intval( htmlspecialchars_decode( esc_html( graphina_get_dynamic_tag_data( $v, GRAPHINA_PREFIX . $chart_type . '_chart_category' ) ) ) ),
			$category_list
		);
		$locales          = array(
			generate_chart_locales( get_locale() ),
		);
		$loadingText      = esc_html__( ( isset( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_no_data_text' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_no_data_text' ] : '' ), 'graphina-charts-for-elementor' );
		$brush_chart_type = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_type_2' ] ) ? strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_type_2' ] ) : 'area';
		$chart_options    = array(
			'series'     => $series_temp,
			'chart'      => array(
				'id'            => "brush-chart-$element_id-2",
				'background'    => strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_background_color1' ] ),
				'foreColor'     => '#ccc',
				'fontFamily'    => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ],
				'locales'       => $locales,
				'defaultLocale' => get_locale(),
				'height'        => intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_height' ] ),
				'type'          => $brush_chart_type,
				'brush'         => array(
					'target'  => $element_id,
					'enabled' => true,
				),
				'selection'     => array(
					'enabled' => true,
					'type'    => 'x',
					'fill'    => array(
						'color'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_selection_fill_color' ] ) ? strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_selection_fill_color' ] ) : '#fff',
						'opacity' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_selection_fill_opacity' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_selection_fill_opacity' ] : 0.4,
					),
					'stroke'  => array(
						'width'     => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_selection_stroke_width' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_selection_stroke_width' ] : 1,
						'dashArray' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_selection_stroke_dasharray' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_selection_stroke_dasharray' ] : 3,
						'color'     => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_selection_stroke_color' ] ) ? strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_selection_stroke_color' ] ) : '#24292e',
						'opacity'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_selection_stroke_opacity' ] ) ?  $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_selection_stroke_opacity' ] : 0.4,
					),
				),
				'dropShadow'    => array(
					'enabled' => $settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow'] ?? false,
					'top'     => $settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_top'] ?? 0,
					'left'    => $settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_left'] ?? 0,
					'blur'    => $settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_blur'] ?? 0,
					'color'   => $settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_color'] ?? '',
					'opacity' => $settings[GRAPHINA_PREFIX . $chart_type . '_is_chart_dropshadow_opacity'] ?? 0,
				),
				'animation'     => array(
					'enabled' => ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_animation' ] === 'yes' ),
					'speed'   => intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_animation_speed' ] ),
					'delay'   => intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_animation_delay' ] ),
				),
			),
			'xaxis'      => array(
				'type'       => 'numeric',
				'categories' => $categories,
				'position'   => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_position' ],
				'labels'     => array(
					'show'         => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_show' ] === 'yes',
					'rotateAlways' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_auto_rotate' ] === 'yes',
					'rotate'       => intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_rotate' ] ) || 0,
					'offsetX'      => intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_offset_x' ] ) || 0,
					'offsetY'      => intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_offset_y' ] ) || 0,
					'trim'         => true,
					'style'        => array(
						'colors'     => strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ] ),
						'fontSize'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px',
						'fontFamily' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ],
						'fontWeight' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight' ],
					),

				),
				'crosshairs' => array(
					'show' => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_crosshairs_show' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_crosshairs_show' ] === 'yes',
				),
			),
			'yaxis'      => array(
				'tickAmount'      => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_tick_amount_2' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_tick_amount_2' ] : 0,
				'decimalsInFloat' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_decimals_in_float' ],
				'opposite' 		  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_position' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_position' ] === 'yes' ? true : false,
				'labels'          => array(
					'show'     => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_show' ] === 'yes',
					'rotate'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_rotate' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_rotate' ] ) : 0,
					'offsetX'  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_offset_x' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_offset_x' ] ) : 0,
					'offsetY'  => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_offset_y' ] ) ? intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_yaxis_datalabel_offset_y' ] ) : 0,
					'style'    => array(
						'colors'     => strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ] ),
						'fontSize'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px',
						'fontFamily' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ],
						'fontWeight' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight' ],
					),
				),
			),
			'colors'     => $chart2Gradient,
			'fill'       => array(
				'type'     => ! empty( $settings[ GRAPHINA_PREFIX . $type2 . '_chart_fill_style_type' ] ) ? $settings[ GRAPHINA_PREFIX . $type2 . '_chart_fill_style_type' ] : 'classic',
				'colors'   => $chart2Gradient,
				'gradient' => array(
					'gradientToColors' => $chart2SecondGradient,
					'type'             => ! empty( $settings[ GRAPHINA_PREFIX . $type2 . '_chart_gradient_type' ] ) ? $settings[ GRAPHINA_PREFIX . $type2 . '_chart_gradient_type' ] : 'vertical',
					'inverseColors'    => ! empty($settings[ GRAPHINA_PREFIX . $type2 . '_chart_gradient_inversecolor' ] ) && $settings[ GRAPHINA_PREFIX . $type2 . '_chart_gradient_inversecolor' ] === 'yes' ? true : false,
					'opacityFrom'      => ! empty( $settings[ GRAPHINA_PREFIX . $type2 . '_chart_gradient_opacityFrom' ] ) ? floatval( $settings[ GRAPHINA_PREFIX . $type2 . '_chart_gradient_opacityFrom' ] ) : 1,
					'opacityTo'        => ! empty( $settings[ GRAPHINA_PREFIX . $type2 . '_chart_gradient_opacityTo' ] ) ? floatval( $settings[ GRAPHINA_PREFIX . $type2 . '_chart_gradient_opacityTo' ] ) :1,
				),
			),
			'noData'     => array(
				'text'          => $loadingText,
				'align'         => 'center',
				'verticalAlign' => 'middle',
				'style'         => array(
					'fontSize'   => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px',
					'fontFamily' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ],
					'color'      => strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ] ),
				),
			),
			'legend'     => array(
				'showForSingleSeries' => true,
				'show'                => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_show' ] === 'yes',
				'position'            => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_position' ] ) ? esc_html( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_position' ] ) : 'bottom',
				'horizontalAlign'     => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_horizontal_align' ] ) ? esc_html( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_legend_horizontal_align' ] ) : 'center',
				'fontSize'            => ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['size'] . $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_size' ]['unit'] : '12px',
				'fontFamily'          => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_family' ],
				'fontWeight'          => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_weight' ],
				'labels'              => array(
					'colors' => strval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_font_color' ] ),
				),
			),
			'responsive' => array(
				array(
					'breakpoint' => 1024,
					'options'    => array(
						'chart' => array(
							'height' => intval( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_height_tablet' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_height_tablet' ] : $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_height' ] ),
						),
					),
				),
				array(
					'breakpoint' => 674,
					'options'    => array(
						'chart' => array(
							'height' => intval( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_height_mobile' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_height_mobile' ] : $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_height' ] ),
						),
					),
				),
			),

		);

		if ( $brush_chart_type === 'area' ) {
			$chart_options['stroke']['curve'] = ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_area_curve_2' ] ) ? $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_area_curve_2' ] : 'smooth';
		} elseif ( 'line' === $brush_chart_type ) {
			$chart_options['stroke']['curve'] = $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_line_curve_2' ];
		}

		if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_selection_xaxis' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_selection_xaxis' ] === 'yes' ) {
			$chart_options['chart']['selection']['xaxis'] = array(
				'min' => intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_selection_xaxis_min' ] ),
				'max' => intval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_selection_xaxis_max' ] ),
			);
		}

		if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_tick_amount_dataPoints' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_xaxis_datalabel_tick_amount_dataPoints' ] == 'yes' ) {
			$chart_options['xaxis']['tickAmount'] = 'dataPoints';
		}

		if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_type_2' ]) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_type_2' ] === 'area' ) {
			$chart_options['fill']['opacity']     = floatval( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_fill_opacity' ] );
				$chart_options['fill']['pattern'] = array(
					'style'       => $chart2FillPattern,
					'width'       => $chart2StockWidth,
					'height'      => 6,
					'strokeWidth' => 2,
				);
				$chart_options['stroke']          = array(
					'curve' => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_area_curve_2' ],
				);
		} elseif ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_type_2' ]) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_type_2' ] === 'line' ) {
			$chart_options['fill']['opacity'] = 1;
				$chart_options['stroke']      = array(
					'curve'     => $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_line_curve_2' ],
					'width'     => $chart2StockWidth,
					'dashArray' => $chart2StocKDash,
				);
		} elseif ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_type_2' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_type_2' ] === 'bar' ) {
			$chart_options['plotOptions']         = array(
				'bar' => array(
					'columnWidth' => $settings[ GRAPHINA_PREFIX . $chart_type . '_is_chart_stroke_width_chart_2' ] . '%',
				),
			);
			$chart_options['fill']['opacity']     = 1;
				$chart_options['stroke']          = array(
					'show'   => true,
					'width'  => 2,
					'colors' => array( 'transparent' ),
				);
				$chart_options['fill']['pattern'] = array(
					'style'       => $chart2FillPattern,
					'width'       => 6,
					'height'      => 6,
					'strokeWidth' => 2,
				);
		}
		return $chart_options;
	}
}

// Check if the function graphina_get_chart_type already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_get_chart_type' ) ) {
	/**
	 * Retrieve a list of chart types based on the specified category.
	 *
	 * This function allows filtering of chart types into different categories:
	 * - "all"      : Returns all available chart types.
	 * - "google"   : Returns only Google Charts.
	 * - "table"    : Returns only Table/Data Charts.
	 * - "apex"     : Returns standard ApexCharts-based charts.
	 *
	 * The function ensures flexibility in fetching relevant chart types for rendering
	 * based on the required visualization framework.
	 *
	 * @param string $type The category of charts to retrieve (default: "all").
	 *                     Accepts "all", "google", "table", or "apex".
	 * @return array List of chart types belonging to the specified category.
	 *
	 * Usage Example:
	 * ```php
	 * $googleCharts = graphina_get_chart_type('google'); // Returns only Google Charts
	 * $allCharts = graphina_get_chart_type('all');       // Returns all charts
	 * ```
	 */
	function graphina_get_chart_type( $type = 'all' ) {
		$charts = array(
			'area',
			'brush',
			'bubble',
			'candle',
			'counter',
			'column',
			'distributed_column',
			'donut',
			'heatmap',
			'line',
			'mixed',
			'nested_column',
			'pie',
			'polar',
			'radar',
			'radial',
			'scatter',
			'timeline',
			'area_google',
			'bar_google',
			'column_google',
			'donut_google',
			'geo_google',
			'gauge_google',
			'gantt_google',
			'line_google',
			'pie_google',
			'org_google',
			'advance-datatable',
			'data_table_lite',
		);

		// Define categories
		$google_charts = array_filter( $charts, fn( $chart ) => strpos( $chart, '_google' ) !== false );
		$table_charts  = array_filter( $charts, fn( $chart ) => strpos( $chart, 'data_table' ) !== false || strpos( $chart, 'advance-datatable' ) !== false );
		$apex_charts   = array_diff( $charts, $google_charts, $table_charts );

		// Return the requested chart types
		switch ( $type ) {
			case 'google':
				return array_values( $google_charts );
			case 'table':
				return array_values( $table_charts );
			case 'apex':
				return array_values( $apex_charts );
			case 'all':
			default:
				return $charts;
		}
	}
}

// Check if the function graphina_get_chart_name already exists to avoid redeclaration errors.
if ( ! function_exists( 'graphina_get_chart_name' ) ) {
	/**
	 * Retrieve a list of chart names based on the specified category.
	 *
	 * This function returns a list of all available charts or filters them
	 * based on the provided type ('apex', 'google', or 'table').
	 *
	 * @param string $type (Optional) The type of charts to retrieve. Accepts 'apex', 'google', 'table', or empty for all.
	 *
	 * @return array List of chart names belonging to the specified category.
	 */
	function graphina_get_chart_name( $type = '' ) {
		// Define available chart categories
		$charts = array(
			'apex'   => array(
				'area_chart',
				'brush_chart',
				'bubble_chart',
				'candle_chart',
				'counter_chart',
				'column_chart',
				'distributed_column_chart',
				'donut_chart',
				'heatmap_chart',
				'line_chart',
				'mixed_chart',
				'nested_column_chart',
				'pie_chart',
				'polar_chart',
				'radar_chart',
				'radial_chart',
				'scatter_chart',
				'timeline_chart',
			),
			'apex-tree' => array(
				'tree',
			),
			'google' => array(
				'area_google_chart',
				'bar_google_chart',
				'column_google_chart',
				'donut_google_chart',
				'geo_google_chart',
				'gauge_google_chart',
				'gantt_google_chart',
				'line_google_chart',
				'pie_google_chart',
				'org_google_chart',
			),
			'table'  => array(
				'advance-datatable',
				'data_table_lite',
			),
		);

		// Return charts based on the type parameter
		return isset( $charts[ $type ] ) ? $charts[ $type ] : array_merge( ...array_values( $charts ) );
	}
}

/**
 * Tree Chart Data Preparation Functions
 * 
 * This file contains functions to prepare hierarchical tree chart data from manual settings.
 */

 if (!function_exists('graphina_prepare_tree_chart_data')) {
    /**
     * Prepares tree chart data from Elementor settings
     *
     * Processes manual input data and converts it into a hierarchical tree structure
     * with associated styling options for each node.
     *
     * @param array $settings The Elementor widget settings array
     * @param string $chart_type The type of chart being processed
     * @return array|null Hierarchical tree data structure or null if no root node found
     */	
	function graphina_prepare_tree_chart_data($settings,$chart_type){
		$treeData = array();
		$chart_options = array();
		if ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_option' ] === 'manual' ) {
			for ( $j = 0; $j < $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_series_count' ]; $j++ ) {
				
				$treeData[] = array(
					$settings[ GRAPHINA_PREFIX . $chart_type . '_chart_child' . $j ],
					$settings[ GRAPHINA_PREFIX . $chart_type . '_chart_parent' . $j ],
					$settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_category' . $j],
					!empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_image' . $j]['url'])
						? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_image' . $j]['url']
						: ''
				);
				$chart_options[] = array(
					'nodeBGColor'     		 	=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_element_bgcolor' . $j ]) ? esc_html($settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_element_bgcolor'. $j ]) : '#000000' ,
					'nodeBGColorHover'      	=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_element_bgcolor_hover'. $j ]) ? esc_html($settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_element_bgcolor_hover'. $j ]) : '#FFFFFF',
					'fontColor'					=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_sel_node_font_color'. $j ]) ? esc_html($settings[GRAPHINA_PREFIX . $chart_type . '_chart_sel_node_font_color'. $j ]) : '#FFFFFF',
					'fontSize'        			=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_sel_node_font_size' . $j ]) ? $settings[GRAPHINA_PREFIX . $chart_type . '_chart_sel_node_font_size' . $j ] : '12px',
					'borderColorHover'      	=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_element_color_hover'. $j ]) ? esc_html($settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_element_color_hover' . $j ]) : '#FFFFFF' ,
					'borderColor'      			=> ! empty($settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_element_color'. $j ]) ? esc_html($settings[GRAPHINA_PREFIX . $chart_type . '_chart_node_element_color' . $j ]) : '#FFFFFF',
			
				);
			}
		}

		// Build the hierarchical structure
		$hierarchicalData = buildTreeStructure($treeData, $chart_options);

		return $hierarchicalData;

	}
}

// Check if the function buildTreeStructure already exists to avoid redeclaration errors.

if (!function_exists('buildTreeStructure')) {
    /**
     * Builds hierarchical tree structure from flat data
     *
     * Identifies the root node and constructs a tree with children nodes
     *
     * @param array $flatData Array of node data in [child, parent, category, image] format
     * @param array $options Array of styling options for each node
     * @return array|null The root node with children hierarchy or null if no root found
     */
	function buildTreeStructure($flatData, $options) {
		// First, identify the root node (a node that is its own parent)
		$rootNode = null;
		foreach ($flatData as $index => $node) {
			if ($node[0] === $node[1]) {
				$rootNode = $node;
				$rootOptions = $options[$index];
				break;
			}
		}

		if (!$rootNode) {
			return null; // No root node found
		}

		// Create the root object
		$root = [
			'id' => strtolower(str_replace(' ', '_', $rootNode[0])),
			'data' => [
				'name' => $rootNode[0],
				'category' => $rootNode[2],
				'imageURL' => $rootNode[3], // Example placeholder,
			],
			'options' => $rootOptions,
			'children' => []
		];

		// Add children to the root
		$root['children'] = findChildren($rootNode[0], $flatData, $options);

		return $root;
	}
}

// Check if the function findChildren already exists to avoid redeclaration errors.
if (!function_exists('findChildren')) {
    /**
     * Recursively finds and builds children nodes for a parent
     *
     * @param string $parentName The name of the parent node to find children for
     * @param array $flatData Array of all node data
     * @param array $options Array of styling options for each node
     * @return array Array of child nodes (with their own children if any)
     */
	function findChildren($parentName, $flatData, $options) {
		$children = [];

		foreach ($flatData as $index => $node) {
			// Skip the node if it's a root node (parent of itself)
			if ($node[0] === $node[1]) {
				continue;
			}

			// If this node's parent matches the parent we're looking for
			if ($node[1] === $parentName) {
				$child = [
					'id' => strtolower(str_replace(' ', '_', $node[0])),
					'data' => [
						'name' => $node[0],
						'category' => $node[2],
						'imageURL' => $node[3], // Example placeholder,// Example dynamic placeholder
					],
					'options' => $options[$index]
				];

				// Find children of this child recursively
				$childChildren = findChildren($node[0], $flatData, $options);
				if (!empty($childChildren)) {
					$child['children'] = $childChildren;
				}

				$children[] = $child;
			}
		}

		return $children;
	}
}

// Check if the function graphina_pro_tree_chart_template already exists to avoid redeclaration.
if ( ! function_exists( 'graphina_tree_chart_template' ) ) {

	/**
	 * Loads and returns the default restrict content template.
	 *
	 * This function uses output buffering to capture the contents of
	 * the 'tree-template.php' template and return it as a string.
	 *
	 * @return string The HTML content of the restrict content template.
	 */
	function graphina_tree_chart_template() {
		ob_start();
		// Load the tree-template.php template.
		graphina_get_template( 'tree-template.php' );
		return ob_get_clean();
	}
}
// counter chart functions
/**
 * Get the difference between two arrays and return re-indexed values.
 *
 * @param array $array1 The first array.
 * @param array $array2 The second array.
 * @return array The difference between $array1 and $array2 with re-indexed values.
 */
function graphina_get_array_diff( $array1, $array2 ) {
	return array_values( array_diff( $array1, $array2 ) );
}

/**
 * Retrieve available database data sources for Graphina elements.
 *
 * @param bool $first Whether to return only the first key.
 * @return string|array The first key if $first is true, otherwise the full options array.
 */
function graphina_element_database_data_from( $first = false ) {
	$options = array(
		'table'       => esc_html__( 'Table', 'graphina-charts-for-elementor' ),
		'mysql-query' => esc_html__( 'MySQL Query', 'graphina-charts-for-elementor' ),
	);
	if ( graphina_check_external_database( 'status' ) ) {
		$options['external_database'] = esc_html__( 'External', 'graphina-charts-for-elementor' );
	}
	return $first ? array_keys( $options )[0] : $options;
}

/**
 * List database tables available for Graphina.
 *
 * @param mixed $this_ele Not used, reserved for future expansion.
 * @param mixed $type Not used, reserved for future expansion.
 * @return array An associative array of available tables.
 */
function graphina_list_db_tables( $this_ele = null, $type = null ) {
	if ( defined( 'GRAPHINA_PRO_DATABASE_TABLES' ) ) {
		$table = ! empty( GRAPHINA_PRO_DATABASE_TABLES ) ? array_keys( GRAPHINA_PRO_DATABASE_TABLES ) : array();
		return ! empty( $table ) ? array_combine( $table, $table ) : array();
	}
	return array();
}

/**
 * Retrieve the Google Sheets URL for a specific chart type.
 *
 * @param string $chart_type The type of chart.
 * @return string The corresponding Google Sheets URL.
 */
function graphina_get_element_sheet( $chart_type = '' ) {
	$sheet = '#';
	switch ( $chart_type ) {
		case 'counter':
			$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vRRnlD17zCipwfBF592dhJWkxHqKXIrp7t4euWrljsk_TImRwwQV2avvvfqSVY-eGqMvuVwRORJTJvN/pub?gid=0&single=true&output=csv';
			break;
		case 'advance-datatable':
		case 'data_table_lite':
			$sheet = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQ91TgvINoFUAdVlSRnf4S2S70S_Nj49ZwcBwccK3WR8jZOBDySzsGGeT5b1lGYBxIkTHsT0SwBxX92/pub?gid=0&single=true&output=csv';
			break;
	}
	return $sheet;
}

/**
 * Retrieve available chart types for mixed charts.
 *
 * @param bool $first Whether to return only the first key.
 * @param bool $revese Whether to return the list in reverse order.
 * @return string|array The first key if $first is true, otherwise the full options array.
 */
function graphina_mixed_chart_typeList( $first = false, $revese = false ) {
	$charts = array(
		'bar'  => esc_html__( 'Column', 'graphina-charts-for-elementor' ),
		'line' => esc_html__( 'Line', 'graphina-charts-for-elementor' ),
		'area' => esc_html__( 'Area', 'graphina-charts-for-elementor' ),
	);
	if ( $revese ) {
		$charts = array_reverse( $charts );
	}
	return $first ? array_keys( $charts )[0] : $charts;
}

/**
 * Get available line cap styles for charts.
 *
 * @param bool $first Whether to return only the first key.
 * @return string|array The first key if $first is true, otherwise the full options array.
 */
function graphina_line_cap_type( $first = false ) {
	$options = array(
		'square' => esc_html__( 'Square', 'graphina-charts-for-elementor' ),
		'butt'   => esc_html__( 'Butt', 'graphina-charts-for-elementor' ),
		'round'  => esc_html__( 'Round', 'graphina-charts-for-elementor' ),
	);
	return $first ? array_keys( $options )[0] : $options;
}

/**
 * Retrieve available fill styles for charts.
 *
 * @param array $types The fill types to include (e.g., 'classic', 'gradient', 'pattern').
 * @param bool  $first Whether to return only the first key.
 * @return array|int|string|null The first key if $first is true, otherwise the full options array.
 */
function graphina_fill_style_type( array $types, bool $first = false ): array|int|string|null {
	$options = array();

	if ( in_array( 'classic', $types, true ) ) {
		$options['classic'] = array(
			'title' => esc_html__( 'Classic', 'graphina-charts-for-elementor' ),
			'icon'  => 'fa fa-paint-brush',
		);
	}
	if ( in_array( 'gradient', $types, true ) ) {
		$options['gradient'] = array(
			'title' => esc_html__( 'Gradient', 'graphina-charts-for-elementor' ),
			'icon'  => 'fa fa-barcode',
		);
	}
	if ( in_array( 'pattern', $types, true ) ) {
		$options['pattern'] = array(
			'title' => esc_html__( 'Pattern', 'graphina-charts-for-elementor' ),
			'icon'  => 'fa fa-bars',
		);
	}
	return $first ? array_key_first( $options ) : $options;
}

/**
 * Retrieve available fill patterns for charts.
 *
 * @param bool $first Whether to return only the first key.
 * @return array|string The first key if $first is true, otherwise the full patterns array.
 */
function graphina_get_fill_patterns( bool $first = false ): array|string {
	$patterns = array(
		'verticalLines'   => esc_html__( 'VerticalLines', 'graphina-charts-for-elementor' ),
		'squares'         => esc_html__( 'Squares', 'graphina-charts-for-elementor' ),
		'horizontalLines' => esc_html__( 'HorizontalLines', 'graphina-charts-for-elementor' ),
		'circles'         => esc_html__( 'Circles', 'graphina-charts-for-elementor' ),
		'slantedLines'    => esc_html__( 'SlantedLines', 'graphina-charts-for-elementor' ),
	);
	return $first ? 'verticalLines' : $patterns;
}

/**
 * Checks if Graphina Pro plugin is active.
 *
 * @return bool True if Graphina Pro plugin is active, false otherwise.
 */
function graphina_pro_active(): bool {
	return graphina_get_plugin_value( 'graphina-charts-for-elementor', 'active' );
}


/**
 * Checks if Graphina Forminator Addon plugin is active.
 *
 * @return bool True if Graphina Forminator Addon plugin is active, false otherwise.
 */
function graphina_forminator_addon_active(): bool {
	return graphina_get_plugin_value( 'graphina-forminator-addon', 'active' );
}

/**
 * Checks if Forminator plugin is active.
 *
 * @return bool True if Forminator plugin is active, false otherwise.
 */
function graphina_forminator_addon_install(): bool {
	return graphina_get_plugin_value( 'forminator', 'active' );
}

/**
 * Retrieves the version of Graphina Pro plugin.
 *
 * @return string The version number of Graphina Pro plugin, or '0' if not found.
 */
function graphina_pro_plugin_version(): string {
	return graphina_get_plugin_value( 'graphina-charts-for-elementor', 'version' );
}

/**
 * Retrieves information about a plugin based on its text domain.
 *
 * Searches through installed plugins to find the plugin with the specified text domain
 * and returns the requested information based on the return type.
 *
 * @param string $plugin_textdomain The text domain (slug) of the plugin.
 * @param string $return_type Optional. The type of information to return
 *                             Possible values: 'active' (boolean), 'basename' (string), 'version' (string).
 * @return mixed Depending on $return_type:
 *               - 'active': Returns true if the plugin is active, false otherwise.
 *               - 'basename': Returns the plugin's directory and main file relative to the plugins' directory.
 *               - 'version': Returns the plugin's version number.
 */
function graphina_get_plugin_value( string $plugin_textdomain, string $return_type ): mixed {
	// Include plugin functions if not already loaded.
	if ( ! function_exists( 'get_plugins' ) ) {
		include_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	$basename    = '';      // Initialize variable to store plugin basename.
	$plugin_data = array(); // Initialize variable to store plugin data.
	$plugins     = get_plugins(); // Get list of installed plugins.

	// Loop through installed plugins to find the one with matching text domain.
	foreach ( $plugins as $key => $data ) {
		if ( $data['TextDomain'] === $plugin_textdomain ) {
			$basename    = $key;      // Store plugin basename (relative path to main file).
			$plugin_data = $data;     // Store full plugin data array.
			break; // Stop loop once plugin is found.
		}
	}

	// Return the requested information based on $return_type.
	if ( $return_type === 'basename' ) {
		return $basename; // Return plugin's relative path and main file name.
	}

	if ( $return_type === 'version' ) {
		// Return plugin version number or default to '0' if version is not set.
		return ! empty( $plugin_data['Version'] ) ? $plugin_data['Version'] : '0';
	}

	// Default return type is 'active': Check if plugin is active.
	return is_plugin_active( $basename ); // Return true if active, false if inactive.
}

/**
 * Summary of graphina_common_setting_get
 * Get the value of a Graphina Common Setting.
 *
 * @param string $chart_type The type of setting to retrieve (e.g., 'thousand_seperator', 'view_port', 'csv_seperator', 'graphina_loader').
 * @return string The value of the Graphina Common Setting.
 */
function graphina_common_setting_get( string $chart_type ): string {
	$data  = get_option( 'graphina_common_setting', true );
	$value = '';
	$data = is_array($data) ? $data : [];
	switch ( $chart_type ) {
		case 'thousand_seperator':
			$value = ! empty( $data['thousand_seperator_new'] ) ? $data['thousand_seperator_new'] : ',';
			break;
		case 'view_port':
			$value = ! empty( $data['view_port'] ) ? $data['view_port'] : 'off';
			break;
		case 'csv_seperator':
			$data['csv_seperator'] = ! empty( $data['csv_seperator'] ) ? $data['csv_seperator'] : ',';
			$value = match ($data['csv_seperator']) {
				'semicolon'	=> ';',
				'comma' 	=> ',',
				default		=> $data['csv_seperator']
			};
			break;
		case 'graphina_loader':
			$value = ! empty( $data['graphina_loader'] ) ? $data['graphina_loader'] : GRAPHINA_URL . '/admin/assets/images/graphina.gif';
			break;
		case 'enable_chart_filter':
			$value = ! empty( $data['enable_chart_filter'] ) ? $data['enable_chart_filter'] : 'off' ;
			break;
		case 'thousand_seperator_local':
			$value = ! empty( $data['thousand_seperator_local'] ) ? $data['thousand_seperator_local'] : 'en' ;
			break;
	}
	return $value;
}


/**
 * Generate HTML for a teaser box with title, messages, and optional link.
 *
 * @param array $texts {
 *     Array containing title, messages, and link information.
 *
 *     @type string $title    Title of the teaser box.
 *     @type array  $messages Array of messages to display inside the box.
 *     @type string $link     Optional. URL for the "Get Pro" link.
 * }
 * @return string HTML content of the teaser box.
 */
function graphina_get_teaser_template( array $texts ): string {
	ob_start();
	?>
	<div class="elementor-nerd-box">
		<div class="elementor-nerd-box-title"><?php echo esc_html( $texts['title'] ); ?></div>
		<?php foreach ( $texts['messages'] as $message ) { ?>
			<div class="elementor-nerd-box-message"><?php echo esc_html( $message ); ?></div>
			<?php
		}
		if ( $texts['link'] ) {
			?>
			<a class="elementor-nerd-box-link elementor-button elementor-button-default elementor-button-go-pro"
				href="<?php echo esc_url( Utils::get_pro_link( $texts['link'] ) ); ?>" target="_blank">
				<?php echo esc_html__( 'Get Pro', 'graphina-charts-for-elementor' ); ?>
			</a>
		<?php } else { ?>
			<div style="font-style: italic;">
				<?php echo esc_html__( 'Coming Soon...', 'graphina-charts-for-elementor' ); ?>
			</div>
		<?php } ?>
	</div>
	<?php

	return ob_get_clean();
}

if ( ! function_exists( 'graphina_allowed_html_tags' ) ) {
	/**
	 * Get allowed HTML tags for plugin output.
	 *
	 * @since 1.0.0
	 * @return array Allowed HTML tags with attributes.
	 */
	function graphina_allowed_html_tags() {
		$allowed_tags = array(
			'br'     => array(
				'class' => array(),
				'style' => array(),
			),
			'em'     => array(
				'class' => array(),
				'style' => array(),
			),
			'strong' => array(
				'class' => array(),
				'style' => array(),
			),
			'b'      => array(
				'class' => array(),
				'style' => array(),
			),
			'i'      => array(
				'class' => array(),
				'style' => array(),
			),
		);

		/**
		 * Filter: graphina_allowed_html_tags
		 * 
		 * Allow developers to modify the list of allowed HTML tags.
		 * 
		 * @since 1.0.0
		 * @param array $allowed_tags Allowed HTML tags.
		 */
		return apply_filters( 'graphina_allowed_html_tags', $allowed_tags );
	}
}
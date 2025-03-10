<?php
/**
 * Graphina general utility function (file autoload by composer)
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina_Charts_For_Elementor
 */

use Elementor\Element_Base;
use Elementor\Plugin;
use Elementor\Utils;

/**
 * Checks if Graphina Pro plugin is active.
 *
 * @return bool True if Graphina Pro plugin is active, false otherwise.
 */
function graphina_pro_active(): bool {
	return graphina_get_plugin_value( 'graphina-pro-charts-for-elementor', 'active' );
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
	return graphina_get_plugin_value( 'graphina-pro-charts-for-elementor', 'version' );
}

/**
 * Checks if Graphina Pro plugin is installed.
 *
 * @return bool True if Graphina Pro plugin is installed, false otherwise.
 */
function graphina_pro_install(): bool {
	if ( ! function_exists( 'get_plugins' ) ) {
		include_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$plugins = get_plugins();
	return isset( $plugins[ graphina_get_plugin_value( 'graphina-pro-charts-for-elementor', 'basename' ) ] );
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
 * Sends activation or deactivation request to the plugin server.
 *
 * Sends a request to a remote server indicating plugin activation or deactivation.
 * This function is used to track plugin activations and deactivations.
 *
 * @param bool $is_deactivate Optional. Indicates if the deactivation request should be sent. Default false.
 */
function graphina_plugin_activation( bool $is_deactivate = false ): void {
	$arg = array(
		'plugin'    => 'Graphina',
		'domain'    => get_bloginfo( 'wpurl' ),
		'site_name' => get_bloginfo( 'name' ),
	);

	// Append 'is_deactivated=true' to the argument if $is_deactivate is true.
	if ( $is_deactivate ) {
		$arg['is_deactivated'] = 'true';
	}

	$request_url = add_query_arg( $arg, 'https://innoquad.in/plugin-server/active-server.php' );

	// Send GET request to the remote server.
	wp_remote_get( $request_url );
}

/**
 * Check if Elementor is in preview or edit mode.
 *
 * This function checks if Elementor is currently in preview or edit mode. If Elementor is not active,
 * it returns true. If Elementor is active, it uses the Plugin instance to check if it is in preview
 * or edit mode.
 *
 * @return bool Returns true if Elementor is not in preview or edit mode, false otherwise.
 */
function graphina_is_preview_mode(): bool {
	// Check if the Elementor plugin class exists.
	if ( ! class_exists( '\Elementor\Plugin' ) ) {
		return true;
	}

	// Check if Elementor is in preview or edit mode.
	return ! ( Plugin::$instance->preview->is_preview_mode() || Plugin::$instance->editor->is_edit_mode() );
}

/**
 * Generate localized settings for ApexCharts.
 *
 * This function creates an array of localized strings for the toolbar options of ApexCharts.
 * The array is then encoded as a JSON string for use in JavaScript.
 *
 * @return string JSON encoded array of localized strings for ApexCharts.
 */
function graphina_apexchart_localization(): string {
	// Define the localization data for ApexCharts.
	$data = array(
		'name'    => 'en',
		'options' => array(
			'toolbar' => array(
				'download'      => esc_html__( 'Download SVG', 'graphina-charts-for-elementor' ),
				'selection'     => esc_html__( 'Selection', 'graphina-charts-for-elementor' ),
				'selectionZoom' => esc_html__( 'Selection Zoom', 'graphina-charts-for-elementor' ),
				'zoomIn'        => esc_html__( 'Zoom In', 'graphina-charts-for-elementor' ),
				'zoomOut'       => esc_html__( 'Zoom Out', 'graphina-charts-for-elementor' ),
				'pan'           => esc_html__( 'Panning', 'graphina-charts-for-elementor' ),
				'reset'         => esc_html__( 'Reset Zoom', 'graphina-charts-for-elementor' ),
				'menu'          => esc_html__( 'Menu', 'graphina-charts-for-elementor' ),
				'exportToSVG'   => esc_html__( 'Download SVG', 'graphina-charts-for-elementor' ),
				'exportToPNG'   => esc_html__( 'Download PNG', 'graphina-charts-for-elementor' ),
				'exportToCSV'   => esc_html__( 'Download CSV', 'graphina-charts-for-elementor' ),
			),
		),
	);

	// Return the JSON encoded array of localization data.
	return wp_json_encode( $data );
}

/**
 * Check the external database settings for Graphina.
 *
 * This function retrieves the external database settings from the WordPress options
 * and returns either a status or the data based on the provided type.
 *
 * @param string $type The type of check to perform ('status' or other).
 *
 * @return mixed Returns true if the type is 'status' and there is at least one database setting,
 *               otherwise returns the database settings data.
 */
function graphina_check_external_database( string $type ): mixed {
	// Retrieve the external database settings from the WordPress options.
	$data = get_option( 'graphina_mysql_database_setting', true );

	// Check the type and return the appropriate value.
	return $type === 'status' ? is_array( $data ) && count( $data ) > 0 : $data;
}

/**
 * Retrieve common Graphina settings based on the specified type.
 *
 * This function retrieves the common Graphina settings from the WordPress options
 * and returns a specific value based on the provided type.
 *
 * @param string $type The type of setting to retrieve.
 *
 * @return string The value of the requested setting.
 */
function graphina_common_setting_get( string $type ): string {
	$data  = get_option( 'graphina_common_setting', true );
	$value = '';
	switch ( $type ) {
		case 'thousand_seperator':
			$value = ! empty( $data['thousand_seperator_new'] ) ? $data['thousand_seperator_new'] : ',';
			break;
		case 'view_port':
			$value = ! empty( $data['view_port'] ) ? $data['view_port'] : 'off';
			break;
		case 'csv_seperator':
			$value = ! empty( $data['csv_seperator'] ) ? $data['csv_seperator'] === 'semicolon' ? ';' : ',' : ',';
			break;
		case 'graphina_loader':
			$value = ! empty( $data['graphina_loader'] ) ? $data['graphina_loader'] : GRAPHINA_URL . '/admin/assets/images/graphina.gif';
			break;
	}

	return $value;
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
		} else {
			$filter_parameters[ $key ] = sanitize_text_field( $value );
		}
	}
	return $filter_parameters;
}

/**
 * Generate a unique widget ID based on the Elementor element's ID and the queried object ID.
 *
 * This function appends the queried object ID (e.g., post ID) to the Elementor element's ID,
 * creating a unique identifier for the widget.
 *
 * @param Element_Base $this_el The current Elementor element object.
 *
 * @return string The unique widget ID.
 */
function graphina_widget_id( Element_Base $this_el ): string {
    $post = get_queried_object();
    
    $post_id = isset( $post->ID ) ? $post->ID : get_queried_object_id();
    // If the post ID is not empty, prefix it with an underscore.
    $post_id = ! empty( $post_id ) ? '_' . $post_id : '';
    // Concatenate the Elementor element's ID with the post ID and return the result.
    return $this_el->get_id() . $post_id;
}


// Disable auto-updates for a specific plugin
function disable_plugin_auto_updates($update, $item) {
	// Replace 'graphina/graphina.php' with the actual plugin path
	if ($item->slug === 'graphina-elementor-charts-and-graphs' || $item->plugin === 'graphina-elementor-charts-and-graphs/graphina-charts-for-elementor.php') {
		return false;
	}
	return $update;
}

/**
 * Update the configuration options for Graphina.
 *
 * This function updates the 'graphina_common_setting' option with default values
 * if it is not already set. It also ensures that 'graphina_select_chart_js' is
 * initialized with 'apex_chart_js' and 'google_chart_js' if it is empty.
 *
 * @return void
 */
function graphina_update_configuration_options(): void {
	$data = get_option( 'graphina_common_setting', true );

	if ( gettype( $data ) === 'boolean' ) {
		update_option( 'graphina_common_setting', array( 'graphina_select_chart_js' => array( 'apex_chart_js', 'google_chart_js' ) ) );
	} elseif ( is_array( $data ) && empty( $data['graphina_select_chart_js'] ) ) {
		if ( get_option( 'graphina_setting_save_first_time', true ) !== 'yes' ) {
			$data['graphina_select_chart_js'] = array(
				'apex_chart_js',
				'google_chart_js',
			);
			update_option( 'graphina_common_setting', $data );
		}

		update_option( 'graphina_setting_save_first_time', 'yes' );
	}
}

/**
 * Adds custom links to the plugin action links on the Plugins page.
 *
 * @param array $links An array of existing plugin action links.
 * @return array Modified array of plugin action links with custom links added.
 */
function graphina_plugin_settings_link( array $links ): array {
	// Add Settings link to the plugin action links.
	$links[] = '<a href="admin.php?page=graphina-chart">' . esc_html__( 'Settings', 'graphina-charts-for-elementor' ) . '</a>';

	// Add Documentation link to the plugin action links.
	$links[] = '<a href="https://iqonic.design/docs/product/graphina-elementor-charts-and-graphs/getting-started/" target="_blank">' . esc_html__( 'Docs', 'graphina-charts-for-elementor' ) . '</a>';

	// Check if Graphina Pro is not installed, then add Get Pro link.
	if ( ! graphina_pro_install() ) {
		$links[] = '<a href="https://codecanyon.net/item/graphinapro-elementor-dynamic-charts-datatable/28654061" target="_blank" style="font-weight: bold; color: #93003c;">' . esc_html__( 'Get Pro', 'graphina-charts-for-elementor' ) . '</a>';
	}

	return $links;
}

/**
 * Unsets the activation key and deactivates the plugin based on nonce verification.
 *
 * If the 'activate' parameter is set in the URL and the '_wpnonce' parameter is present
 * and valid, this function unsets the 'activate' parameter to prevent repeated activation attempts.
 * It then deactivates the plugin specified by GRAPHINA_BASE_PATH.
 *
 * @param bool $deactivated deactivate lite plugin is params is true.
 *
 * @return void
 */
function graphina_unset_activate_key( bool $deactivated = true ): void {
	// Check if 'activate' parameter is set and '_wpnonce' is not empty and valid.
	if ( isset( $_GET['activate'] ) && ! empty( $_GET['_wpnonce'] )
		&& wp_verify_nonce( sanitize_key( $_GET['_wpnonce'] ), 'activate-plugin_' . GRAPHINA_BASE_PATH ) ) {

		// Unset the 'activate' parameter from $_GET to prevent repeated activation attempts.
		unset( $_GET['activate'] );
	}

	if ( $deactivated ) {
		// Deactivate the plugin specified by GRAPHINA_BASE_PATH.
		deactivate_plugins( GRAPHINA_BASE_PATH );
	}
}


/**
 * Load PHP files based on a specified path pattern.
 *
 * This function uses glob() to retrieve an array of file paths matching the given pattern,
 * and includes each file if it exists.
 *
 * @param string $path The path pattern for glob() to search for files.
 * @return void
 */
function graphina_load_widget( string $path ): void {
	$files = glob( $path );
	foreach ( $files as $file ) {
		if ( is_file( $file ) ) {
			require_once $file;
		}
	}
}

/**
 * Display an admin notice in the WordPress dashboard.
 *
 * This function outputs an error notice with a custom message and a button that links
 * to a specified URL.
 *
 * @param string $message        The message to display in the notice.
 * @param string $activation_url The URL for the button to link to.
 * @param string $text           The text to display on the button.
 *
 * @return void
 */
function graphina_admin_notice( string $message, string $activation_url, string $text ): void {
	?>
	<div class="error">
		<p><?php echo wp_kses_post( $message ); ?></p>
		<p>
			<a href="<?php echo esc_url( $activation_url ); ?>" class="button-primary">
				<?php echo esc_html( $text ); ?>
			</a>
		</p>
	</div>
	<?php
}

/**
 * Outputs JavaScript code to handle AJAX reloading based on conditions.
 *
 * @param bool   $call_ajax        Whether to initiate AJAX reload.
 * @param mixed  $new_settings     New settings data for AJAX reload.
 * @param string $type             Type of AJAX request.
 * @param string $main_id          Main identifier for the element.
 * @param array  $control_settings Optional control settings.
 */
function graphina_ajax_reload( bool $call_ajax, mixed $new_settings, string $type, string $main_id, $control_settings = array() ): void {
	if ( ! $call_ajax ) {
		return;
	}
	?>
	<script>
		(function() {
			if (typeof getDataForChartsAjax !== "undefined") {
				const id = '<?php echo esc_js( $main_id ); ?>';
				const type = '<?php echo esc_js( $type ); ?>';
				const newSettingEmpty = '<?php echo empty( $new_settings ) ? 'true' : 'false'; ?>';
				const ajaxReloadEnable = newSettingEmpty === 'true' ? graphina_localize?.graphinaAllGraphsOptions[id]?.setting_date?.[`iq_${type}_can_chart_reload_ajax`] === 'yes' ? 'true' : 'false' :
					'<?php echo ( isset( $control_settings[ 'iq_' . $type . '_can_chart_reload_ajax' ] ) && $control_settings[ 'iq_' . $type . '_can_chart_reload_ajax' ] === 'yes' ) ? 'true' : 'false'; ?>';
				if (!['mixed'].includes(type)) {
					const requestField = newSettingEmpty === 'true' ? graphina_localize?.graphinaAllGraphsOptions[id]?.setting_date : <?php echo wp_json_encode( $new_settings ); ?>;
					getDataForChartsAjax(requestField, type, id);
				}

				if (ajaxReloadEnable === 'true') {
					const ajaxIntervalTime = parseInt(
						newSettingEmpty === 'true'
						? graphina_localize?.graphinaAllGraphsOptions[id]?.setting_date?.[`iq_${type}_interval_data_refresh`]
						: <?php echo ! empty( $new_settings[ "iq_{$type}_interval_data_refresh" ] ) ? esc_js( $new_settings[ "iq_{$type}_interval_data_refresh" ] ) : 20; ?>
					) * 1000 ;
					const requestField = newSettingEmpty ? graphina_localize?.graphinaAllGraphsOptions[id]?.setting_date : <?php echo wp_json_encode( $new_settings ); ?>;
					window['ajaxIntervalGraphina_' + id] = setInterval(function () {
						getDataForChartsAjax(requestField, type, id);
					}, ajaxIntervalTime);
				}
			}
		})();
	</script>
	<?php
}

/**
 * Output HTML for chart filters based on settings.
 *
 * @param Element_Base $this_ele   The Elementor element instance.
 * @param array        $settings   Settings array containing filter configurations.
 * @param string       $type       Type of chart filter to display.
 * @param string       $main_id    Optional main identifier for differentiation.
 *
 * @return void
 */
function graphina_filter_common( Element_Base $this_ele, array $settings, string $type, string $main_id = '' ): void {
	if ( ! empty( $settings[ 'iq_' . $type . '_chart_filter_enable' ] ) && $settings[ 'iq_' . $type . '_chart_filter_enable' ] === 'yes' ) {
		?>
		<div class="graphina_chart_filter" style="display: flex; flex-wrap: wrap; align-items: end;">
			<?php
			if ( ! empty( $settings[ 'iq_' . $type . '_chart_filter_list' ] ) ) {
				foreach ( $settings[ 'iq_' . $type . '_chart_filter_list' ] as $key => $value ) {
					if ( ! empty( $value[ 'iq_' . $type . '_chart_filter_type' ] ) && $value[ 'iq_' . $type . '_chart_filter_type' ] === 'date' ) {
						?>
						<div class="graphina-filter-div">
							<div>
								<label for="start-date_<?php echo esc_html( $key . $main_id ); ?>">
									<?php echo esc_html( ! empty( $value[ 'iq_' . $type . '_chart_filter_value_label' ] ) ? $value[ 'iq_' . $type . '_chart_filter_value_label' ] : '' ); ?>
								</label>
							</div>
							<?php
							if ( ! empty( $value[ 'iq_' . $type . '_chart_filter_date_type' ] ) && $value[ 'iq_' . $type . '_chart_filter_date_type' ] === 'date' ) {
								$default_date = ! empty( $value[ 'iq_' . $type . '_chart_filter_date_default' ] ) ? $value[ 'iq_' . $type . '_chart_filter_date_default' ] : current_time( 'Y-m-d h:i:s' );
								?>
								<div>
									<input  type="date"  id="start-date_<?php echo esc_html( $key . $main_id ); ?>"
											class="graphina-chart-filter-date-time graphina_datepicker_<?php echo esc_html( $main_id ); ?>
											graphina_filter_select<?php echo esc_html( $main_id ); ?>"
                                            value="<?php echo esc_html( date( 'Y-m-d', strtotime( $default_date ) ) ); //@phpcs:ignore ?>" >
								</div>
								<?php
							} else {
								$default_date = ! empty( $value[ 'iq_' . $type . '_chart_filter_datetime_default' ] ) ? $value[ 'iq_' . $type . '_chart_filter_datetime_default' ] : current_time( 'Y-m-d h:i:s' );
								?>
								<div>
									<input type="datetime-local" id="start-date_<?php echo esc_html( $key . $main_id ); ?>"
											class="graphina-chart-filter-date-time graphina_datepicker_<?php echo esc_html( $main_id ); ?>
											graphina_filter_select<?php echo esc_html( $main_id ); ?>" step="1"
                                           value="<?php echo esc_html( date( 'Y-m-d\TH:i', strtotime( $default_date ) ) ) //@phpcs:ignore; ?>" >
								</div>
								<?php
							}
							?>
						</div>
						<?php
					} elseif ( ! empty( $value[ 'iq_' . $type . '_chart_filter_value' ] ) && ! empty( $value[ 'iq_' . $type . '_chart_filter_option' ] ) ) {
						$data        = explode( ',', $value[ 'iq_' . $type . '_chart_filter_value' ] );
						$data_option = explode( ',', $value[ 'iq_' . $type . '_chart_filter_option' ] );
						if ( ! empty( $data ) && is_array( $data ) && ! empty( $data_option ) && is_array( $data_option ) ) {
							?>
							<div  class="graphina-filter-div">
								<div>
									<label for="graphina-drop_down_filter_<?php echo esc_html( $key . $main_id ); ?>" >
										<?php echo esc_html( ! empty( $value[ 'iq_' . $type . '_chart_filter_value_label' ] ) ? $value[ 'iq_' . $type . '_chart_filter_value_label' ] : '' ); ?>
									</label>
								</div>
								<div>
									<select  class="graphina_filter_select<?php echo esc_html( $main_id ); ?>"
											id="graphina-drop_down_filter_<?php echo esc_html( $key . $main_id ); ?>">
										<?php
										foreach ( $data as $key1 => $value1 ) {
											?>
											<option value="<?php echo esc_html( $value1 ); ?>" <?php echo esc_html( (int) $key1 === 0 ? 'selected' : '' ); ?>>
												<?php echo esc_html( isset( $data_option[ $key1 ] ) ? $data_option[ $key1 ] : '' ); ?>
											</option>
										<?php } ?>
									</select>
								</div>
							</div>
							<?php
						}
					}
				}
				?>
				<div  class="graphina-filter-div" >
					<input class="graphina-filter-div-button" type="button"
							value="<?php echo esc_html__( 'Apply Filter', 'graphina-charts-for-elementor' ); ?>"
							id="grapina_apply_filter_<?php echo esc_html( $main_id ); ?>"
							onclick='graphinaChartFilter("<?php echo esc_html( $type ); ?>",this,"<?php echo esc_html( $main_id ); ?>");' />
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
	do_action( 'graphina_custom_filter', $settings, $type, $main_id );
}

/**
 * Output HTML for dynamic chart type selector based on settings.
 *
 * @param array  $settings  Settings array containing chart configuration.
 * @param string $type      Type of chart to be displayed.
 * @param string $main_id   Optional main identifier for differentiation.
 *
 * @return void
 */
function graphina_change_apex_chart_type( array $settings, string $type, string $main_id ): void {
	$chart_type = $type;
	if ( $type === 'column' ) {
		$chart_type = 'bar';
	} elseif ( $type === 'polar' ) {
		$chart_type = 'polarArea';
	}
	if ( ! empty( $settings[ 'iq_' . $type . '_dynamic_change_chart_type' ] ) && $settings[ 'iq_' . $type . '_dynamic_change_chart_type' ] === 'yes' ) {
		?>
		<div class="graphina_dynamic_change_type">
			<select id="graphina-select-chart-type"
					onchange="updateChartType('<?php echo esc_html( $chart_type ); ?>',this,'<?php echo esc_html( $main_id ); ?>');">
				<option selected
						disabled><?php echo esc_html__( 'Choose Chart Type', 'graphina-charts-for-elementor' ); ?></option>
				<?php
				if ( in_array( $type, array( 'pie', 'donut', 'polar' ), true ) ) {
					?>
					<option value="donut"><?php echo esc_html__( 'Donut', 'graphina-charts-for-elementor' ); ?></option>
					<option value="pie"><?php echo esc_html__( 'Pie', 'graphina-charts-for-elementor' ); ?></option>
					<option value="polarArea"><?php echo esc_html__( 'PolarArea', 'graphina-charts-for-elementor' ); ?></option>
					<?php
				} else {
					?>
					<option value="area"><?php echo esc_html__( 'Area', 'graphina-charts-for-elementor' ); ?></option>
					<option value="bar"><?php echo esc_html__( 'Column', 'graphina-charts-for-elementor' ); ?></option>
					<option value="line"><?php echo esc_html__( 'Line', 'graphina-charts-for-elementor' ); ?></option>
					<?php
				}
				?>
			</select>
		</div>
		<?php
	}
}

/**
 * Output HTML for dynamic chart type selector based on settings.
 *
 * @param array  $settings  Settings array containing chart configuration.
 * @param string $type      Type of chart to be displayed.
 * @param string $main_id   Optional main identifier for differentiation.
 *
 * @return void
 */
function graphina_change_google_chart_type( array $settings, string $type, string $main_id ): void {
	if ( ! empty( $settings[ 'iq_' . $type . '_dynamic_change_chart_type' ] ) && $settings[ 'iq_' . $type . '_dynamic_change_chart_type' ] === 'yes' ) {
		?>
		<div class="graphina_dynamic_change_type">
			<select id="graphina-select-chart-type"
					onchange="updateGoogleChartType('<?php echo esc_html( $type ); ?>',this,'<?php echo esc_html( $main_id ); ?>');">
				<option selected
						disabled><?php echo esc_html__( 'Choose Chart Type', 'graphina-charts-for-elementor' ); ?></option>
				<?php
				if ( in_array( $type, array( 'pie_google', 'donut_google' ), true ) ) {
					?>
					<option value="PieChart"><?php echo esc_html__( 'Pie', 'graphina-charts-for-elementor' ); ?></option>
					<option value="DonutChart"><?php echo esc_html__( 'Donut', 'graphina-charts-for-elementor' ); ?></option>
					<?php
				} else {
					?>
					<option value="AreaChart"><?php echo esc_html__( 'Area', 'graphina-charts-for-elementor' ); ?></option>
					<option value="LineChart"><?php echo esc_html__( 'Line', 'graphina-charts-for-elementor' ); ?></option>
					<option value="BarChart"><?php echo esc_html__( 'Bar', 'graphina-charts-for-elementor' ); ?></option>
					<option value="ColumnChart"><?php echo esc_html__( 'Column', 'graphina-charts-for-elementor' ); ?></option>
				<?php } ?>
			</select>
		</div>
		<?php
	}
}

/**
 * Render content for the Graphina chart widget.
 *
 * @param Element_Base $this_ele   The Elementor element instance.
 * @param string       $main_id   Main identifier for the chart widget.
 * @param array        $settings  Settings array containing chart configuration.
 *
 * @return void
 */
function graphina_chart_widget_content( Element_Base $this_ele, string $main_id, array $settings ): void {
	$type                  = method_exists( $this_ele, 'get_chart_type' ) ? $this_ele->get_chart_type() : '';
	$heading_text_align    = ! empty( $settings[ 'iq_' . $type . '_card_title_align' ] ) ? ( 'text-align:' . $settings[ 'iq_' . $type . '_card_title_align' ] . ';' ) : '';
	$heading_color         = ! empty( $settings[ 'iq_' . $type . '_card_title_font_color' ] ) ? ( 'color:' . $settings[ 'iq_' . $type . '_card_title_font_color' ] . ';' ) : '';
	$subheading_text_align = ! empty( $settings[ 'iq_' . $type . '_card_subtitle_align' ] ) ? ( 'text-align:' . $settings[ 'iq_' . $type . '_card_subtitle_align' ] . ';' ) : '';
	$subheading_color      = ! empty( $settings[ 'iq_' . $type . '_card_subtitle_font_color' ] ) ? ( 'color:' . $settings[ 'iq_' . $type . '_card_subtitle_font_color' ] . ';' ) : '';
	$title                 = ! empty( $settings[ 'iq_' . $type . '_chart_heading' ] ) ? (string) $settings[ 'iq_' . $type . '_chart_heading' ] : '';
	$description           = ! empty( $settings[ 'iq_' . $type . '_chart_content' ] ) ? (string) $settings[ 'iq_' . $type . '_chart_content' ] : '';
	if ( graphina_restricted_access( $type, $main_id, $settings, true ) ) {
		if ( $settings[ 'iq_' . $type . '_restriction_content_type' ] === 'password' ) {
			return;
		}
		echo wp_kses_post( html_entity_decode( $settings[ 'iq_' . $type . '_restriction_content_template' ] ) );
		return;
	}
	?>
	<div class="<?php echo ! empty( $settings[ 'iq_' . $type . '_chart_card_show' ] ) && $settings[ 'iq_' . $type . '_chart_card_show' ] === 'yes' ? 'chart-card' : ''; ?>">
		<div class="">
			<?php
			if ( ! empty( $settings[ 'iq_' . $type . '_is_card_heading_show' ] ) && $settings[ 'iq_' . $type . '_is_card_heading_show' ] === 'yes'
				&& ! empty( $settings[ 'iq_' . $type . '_chart_card_show' ] ) && $settings[ 'iq_' . $type . '_chart_card_show' ] === 'yes' ) {
				?>
                <h4 class="heading graphina-chart-heading" style="<?php echo esc_html(isset( $_REQUEST['action'] ) ? '' : $heading_text_align . $heading_color); //@phpcs:ignore ?>">
					<?php echo wp_kses_post( html_entity_decode( $title ) ); ?>
				</h4>
				<?php
			}
			if ( ! empty( $settings[ 'iq_' . $type . '_is_card_desc_show' ] ) && $settings[ 'iq_' . $type . '_is_card_desc_show' ] === 'yes' && ! empty( $settings[ 'iq_' . $type . '_chart_card_show' ] ) && $settings[ 'iq_' . $type . '_chart_card_show' ] === 'yes' ) {
				?>
                <p class="sub-heading graphina-chart-sub-heading" style="<?php echo esc_html( isset( $_REQUEST['action'] ) ? '' : $subheading_text_align . $subheading_color ); //@phpcs:ignore ?>">
					<?php echo wp_kses_post( html_entity_decode( $description ) ); ?>
				</p>
			<?php } ?>
		</div>
		<?php
		if ( in_array(
			$type,
			array(
				'pie_google',
				'donut_google',
				'line_google',
				'area_google',
				'column_google',
				'bar_google',
			),
			true
		) ) {
			graphina_change_google_chart_type( $settings, $type, $main_id );
		} else {
			graphina_change_apex_chart_type( $settings, $type, $main_id );
		}
		graphina_filter_common( $this_ele, $settings, $type, $main_id );
		?>
		<?php
		if ( $type === 'nested_column' ) {
			?>
			<div class="chart-texture <?php echo esc_html( $type ); ?>-chart-wrapper">
				<div class="<?php echo esc_html( $type ); ?>-chart-one <?php echo esc_html( $type ); ?>-chart-one-<?php echo esc_html( $main_id ); ?>
					<?php echo ! empty( $settings[ 'iq_' . $type . '_chart_border_show' ] ) && $settings[ 'iq_' . $type . '_chart_border_show' ] === 'yes' ? 'chart-box' : ''; ?>">
				</div>
				<div class="<?php echo esc_attr( $type ); ?>-chart-two <?php echo esc_attr( $type ); ?>-chart-two-<?php echo esc_attr( $main_id ); ?>
					<?php echo ! empty( $settings[ 'iq_' . $type . '_chart_border_show' ] ) && $settings[ 'iq_' . $type . '_chart_border_show' ] === 'yes' ? 'chart-box' : ''; ?>">
				</div>
			</div>
			<?php
		} else {
			?>
			<div class="<?php echo ! empty( $settings[ 'iq_' . $type . '_chart_border_show' ] ) && $settings[ 'iq_' . $type . '_chart_border_show' ] === 'yes' ? 'chart-box' : ''; ?>">
				<?php
				if ( $type === 'brush' ) {
					?>
					<div class="brush-chart-<?php echo esc_attr( $main_id ); ?>-1">
					</div>
					<div class="brush-chart-<?php echo esc_attr( $main_id ); ?>-2">
					</div>
					<?php
				} else {
					?>
					<div class="chart-texture <?php echo esc_attr( $type ); ?>-chart-<?php echo esc_attr( $main_id ); ?>"
						style="<?php echo esc_html( ! empty( $settings[ 'iq_' . $type . '_chart_height' ] ) ? 'min-height:' . $settings[ 'iq_' . $type . '_chart_height' ] . 'px;' : '' ); ?>"
						id='<?php echo esc_attr( $type ); ?>_chart<?php echo esc_attr( $main_id ); ?>'></div>
					<?php
				}
				?>
			</div>
			<?php
		}
		?>
		<div style="<?php echo esc_html( ! empty( $settings[ 'iq_' . $type . '_chart_height' ] ) ? 'height:' . $settings[ 'iq_' . $type . '_chart_height' ] . 'px;' : '' ); ?>
				display: flex;justify-content: center;align-items: center;"
			class="d-none area-texture <?php echo esc_attr( $type ); ?>-chart-<?php echo esc_attr( $main_id ); ?>-loader" >
			<?php
			if ( ! empty( $settings[ 'iq_' . $type . '_chart_filter_enable' ] ) && $settings[ 'iq_' . $type . '_chart_filter_enable' ] === 'yes' ) {
				$val        = graphina_common_setting_get( 'graphina_loader' );
				$loader_img = ! empty( $val ) ? $val : GRAPHINA_URL . '/admin/assets/images/graphina.gif';
				$loader_img = apply_filters( 'graphina_chart_loader', $loader_img );
				$loader     = "<img class='graphina-loader d-none' src='" . esc_url( $loader_img ) . "'>";
				$loader     = apply_filters( 'graphina_chart_loader_tag', $loader );
				echo wp_kses_post( html_entity_decode( $loader ) );
			}
			?>
			<p class="graphina-filter-notext d-none" style="text-align: center;">
				<?php echo esc_html__( 'No Data Found', 'graphina-charts-for-elementor' ); ?>
			</p>
		</div>
	</div>
	<?php
}

/**
 * Determines if access to restricted content should be granted based on settings.
 *
 * Checks if access to restricted content should be granted based on the settings provided.
 * Handles role-based restrictions, user-based restrictions, and password protection.
 *
 * @param string $type         The type of content (e.g., 'chart', 'counter').
 * @param string $chart_id     The ID of the chart or counter.
 * @param array  $settings     The settings array containing restriction settings.
 * @param bool   $flag         Optional. Whether to display the restricted content directly.
 *                             Default is false (do not display).
 * @return bool Whether access to the content should be restricted (true) or not (false).
 */
function graphina_restricted_access( string $type, string $chart_id, array $settings, bool $flag = false ): bool {
	$restricted_template = false;
	if ( ! empty( $settings[ 'iq_' . $type . '_restriction_content_type' ] )
		&& $settings[ 'iq_' . $type . '_restriction_content_type' ] !== '' ) {
		$restricted_template = true;
		if ( is_user_logged_in() ) {
			$restricted_template = false;
			if ( $settings[ 'iq_' . $type . '_restriction_content_type' ] === 'role' ) {
				$current_user_role = graphina_fetch_user_roles( true );
				if ( ! is_array( $settings[ 'iq_' . $type . '_restriction_content_role_type' ] )
					|| ! in_array( $current_user_role, $settings[ 'iq_' . $type . '_restriction_content_role_type' ], true ) ) {
					$restricted_template = true;
				}
			}
			if ( $settings[ 'iq_' . $type . '_restriction_content_type' ] === 'userName' ) {
				$current_user_name = graphina_fetch_user_name();
				if ( ! is_array( $settings[ 'iq_' . $type . '_restriction_content_user_name_based' ] )
					|| ! in_array( $current_user_name, $settings[ 'iq_' . $type . '_restriction_content_user_name_based' ], true ) ) {
					$restricted_template = true;
				}
			}
		}
		if ( $settings[ 'iq_' . $type . '_restriction_content_type' ] === 'password'
			&& ( empty( $_COOKIE[ 'graphina_' . $type . '_' . $chart_id ] ) || ! sanitize_text_field( wp_unslash( $_COOKIE[ 'graphina_' . $type . '_' . $chart_id ] ) ) ) ) {
			if ( $flag ) {
				?>
				<div class="graphina-restricted-content <?php echo $type === 'counter' ? 'graphina-card counter' : 'chart-card'; ?>"
					style="padding: 20px">
					<form class="graphina-password-restricted-form" method="post" autocomplete="off" target="_top"
							onsubmit="return graphinaRestrictedPasswordAjax(this,event)">
						<h4 class="graphina-password-heading"><?php echo esc_html( $settings[ 'iq_' . $type . '_password_content_headline' ] ); ?></h4>
						<p class="graphina-password-message"><?php echo esc_html( $settings[ 'iq_' . $type . '_password_instructions_text' ] ); ?></p>
						<div class="graphina-input-wrapper">
							<input type="hidden" name="chart_password"
									value="<?php echo esc_html( wp_hash_password( $settings[ 'iq_' . $type . '_restriction_content_password' ] ) ); ?>">
							<input type="hidden" name="chart_type" value="<?php echo esc_html( $type ); ?>">
							<input type="hidden" name="chart_id" value="<?php echo esc_html( $chart_id ); ?>">
							<input type="hidden" name="nonce" value="<?php echo sanitize_key( wp_create_nonce( 'graphina_restrict_password_ajax' ) ); ?>">
							<input type="hidden" name="action" value="graphina_restrict_password_ajax">
							<input class="form-control graphina-input " type="password" name="graphina_password"
									autocomplete="off" placeholder="Enter Password" style="outline: none">
						</div>
						<div class="button-box">
							<button class="graphina-button" name="submit" type="submit"
									style="outline: none"><?php echo esc_html( $settings[ 'iq_' . $type . '_password_button_label' ] ); ?></button>
						</div>
						<div class="graphina-error-div">
							<?php
							if ( ! graphina_is_preview_mode() ) {
								?>
								<div class=" elementor-alert-danger graphina-error "
									style="display: <?php echo $settings[ 'iq_' . $type . '_password_error_message_show' ] === 'yes' ? 'flex' : 'none'; ?>;align-items:center; ">
									<span><?php echo esc_html( $settings[ 'iq_' . $type . '_password_error_message' ] ); ?></span>
								</div>
								<?php
							} else {
								?>
								<div class=" elementor-alert-danger graphina-error "
									style="display: none; align-items:center;">
									<span><?php echo esc_html( $settings[ 'iq_' . $type . '_password_error_message' ] ); ?></span>
								</div>
							<?php } ?>
						</div>
					</form>
				</div>
				<?php
			}
			$restricted_template = true;

		} elseif ( $settings[ 'iq_' . $type . '_restriction_content_type' ] === 'password' ) {
			$restricted_template = false;
		}
	}

	return $restricted_template;
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

/**
 * Generate default HTML for a content restriction template.
 *
 * @return string HTML content of the teaser box.
 */
function graphina_default_restrict_content_template(): string {
	ob_start();
	?>
	<div style="padding: 30px; text-align: center;">
		<h5>
			<?php echo esc_html__( 'You don\'t have permission to see this content.', 'graphina-charts-for-elementor' ); ?>
		</h5>
		<a class="button" href="<?php echo esc_url( wp_login_url() ); ?>">
			<?php echo esc_html__( 'Unlock Access', 'graphina-charts-for-elementor' ); ?>
		</a>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Generate chart filter controller description HTML.
 *
 * @return string HTML content of the teaser box.
 */
function graphina_chart_filter_controller_description(): string {
	ob_start();
	?>
	<strong>
		<?php echo esc_html__( 'Note: Value are seperator by comma, value is use as option ', 'graphina-charts-for-elementor' ); ?>
		<u>
			<span> <?php echo esc_html__( 'Name1', 'graphina-charts-for-elementor' ); ?> </span>
			<span> <?php echo esc_html__( 'Name2', 'graphina-charts-for-elementor' ); ?> </span>
		</u>
		<?php echo esc_html__( 'And first option will be default selected value ', 'graphina-charts-for-elementor' ); ?>
	</strong>
	<?php
	return ob_get_clean();
}
<?php
/**
 * Plugin Name:         Graphina - Elementor Charts and Graphs
 * Plugin URI:          https://iqonicthemes.com
 * Description:         Your ultimate charts and graphs solution to enhance visual effects. Create versatile, advanced and interactive charts on your website.
 * Author:              Iqonic Design
 * Author URI:          https://iqonic.design/
 * Version:             3.0.0
 * Elementor tested up to: 3.28.0
 * Elementor Pro tested up to: 3.20.2
 * Requires PHP:        8.0
 * Requires Plugins     elementor
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:         graphina-charts-for-elementor
 * Domain Path:         /languages
 * Requires Plugins     elementor
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit; // Exit if accessed directly.
endif;

// Plugin Root File.
if ( ! defined( 'GRAPHINA_PLUGIN_FILE' ) ) :
	define( 'GRAPHINA_PLUGIN_FILE', __FILE__ );
endif;

// Plugin Base.
if ( ! defined( 'GRAPHINA_PLUGIN_BASENAME' ) ) :
	define( 'GRAPHINA_PLUGIN_BASENAME', plugin_basename( GRAPHINA_PLUGIN_FILE ) );
endif;

// Plugin Version.
if ( ! defined( 'GRAPHINA_VERSION' ) ) :
	define( 'GRAPHINA_VERSION', '3.0.0' );
endif;

// Plugin Prefix.
if ( ! defined( 'GRAPHINA_PREFIX' ) ) :
	define( 'GRAPHINA_PREFIX', 'iq_' );
endif;

// Plugin Folder Path.
if ( ! defined( 'GRAPHINA_PATH' ) ) :
	define( 'GRAPHINA_PATH', plugin_dir_path( __FILE__ ) );
endif;

// Plugin Folder URL.
if ( ! defined( 'GRAPHINA_URL' ) ) :
	define( 'GRAPHINA_URL', plugin_dir_url( __FILE__ ) );
endif;

// Require once the Composer Autoload.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) :
	require __DIR__ . '/vendor/autoload.php';
endif;

// Plugin Version.
if ( ! defined( 'GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION' ) ) :
	define( 'GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION', '3.0.0' );
endif;

// Pro Version.
if ( ! defined( 'GRAPHINA_CHARTS_DEPENDENT_PRO_VERSION' ) ) :
	define( 'GRAPHINA_CHARTS_DEPENDENT_PRO_VERSION', '3.0.0' );
endif;

if ( ! function_exists( 'is_plugin_active' ) ) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

// Admin Notice if Elementor is not active.
if ( ! function_exists( 'gcfe_elementor_admin_notice' ) ) :
	function gcfe_elementor_admin_notice() {
		?>
		<div class="error">
			<p><?php esc_html_e( 'Graphina - Elementor Charts and Graphs is enabled but not effective. It requires Elementor to work.', 'graphina-charts-for-elementor' ); ?></p>
		</div>
		<?php
	}
endif;

/**
 * Graphina Plugin Loader
 *
 * Ensures the required Elementor version is active and fires the initialization hook.
 *
 * @package Graphina
 * @since 1.0.0
 */

/**
 * Load gettext translation and initialize the plugin.
 *
 * Checks if Elementor is loaded and ensures the required version is active.
 * Fires the `gcfe_init` action hook for further plugin initialization.
 *
 * @since 1.0.0
 *
 * @return void
 */
if ( ! function_exists( 'graphina_load_plugin' ) ) {
	function graphina_load_plugin() {

		// Check if Elementor is loaded, otherwise display an admin notice.
		if ( ! did_action( 'elementor/loaded' ) ) :
			add_action( 'admin_notices', 'graphina_check_required_plugin' );
			return;
		endif;

		$pro_required_version = '3.0.0'; // Change this as needed.

        // Path to the Graphina Lite plugin.
        $pro_plugin_basename = 'graphina-pro/graphina-charts-for-elementor.php';

        // Check if Graphina Lite is installed.
        if ( ! function_exists( 'get_plugins' ) ) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $installed_plugins = get_plugins();

        if ( isset( $installed_plugins[ $pro_plugin_basename ] ) ) :
            // Get the installed version
            $graphina_pro_v = $installed_plugins[ $pro_plugin_basename ]['Version'];

            // Compare versions
            if ( version_compare( $graphina_pro_v, $pro_required_version, '<' ) ) :
                // Version is incompatible, deactivate Graphina Pro
                deactivate_plugins( 'graphina-pro/graphina-charts-for-elementor.php' );
				add_action( 'admin_notices', 'graphina_fail_load_out_of_date_pro' );
				return;
			endif;
		endif;

		$elementor_version_required = '3.20.0';
		
		// Ensure Elementor meets the minimum required version.
		if ( ! version_compare( ELEMENTOR_VERSION, $elementor_version_required, '>=' ) ) :
			add_action( 'admin_notices', 'graphina_fail_load_out_of_date' );
			return;
		endif;

		$elementor_version_recommendation = '3.27.5';
		
		// Recommend updating Elementor if it's below the suggested version.
		if ( ! version_compare( ELEMENTOR_VERSION, $elementor_version_recommendation, '>=' ) ) :
			add_action( 'admin_notices', 'graphina_admin_notice_upgrade_recommendation' );
		endif;

		// Trigger plugin initialization hook.
		do_action( 'gcfe_init' );
	}
}

/**
 * Display an admin notice recommending Elementor update.
 *
 * Checks if the user has permission to update plugins and displays an admin notice
 * with a link to update Elementor.
 *
 * @since 3.0.0
 *
 * @return void
 */

if ( ! function_exists( 'graphina_admin_notice_upgrade_recommendation' ) ) {
	function graphina_admin_notice_upgrade_recommendation() {
		if ( ! current_user_can( 'update_plugins' ) ) :
			return;
		endif;

		$file_path = 'elementor/elementor.php';

		// Generate the upgrade link with nonce for security.
		$upgrade_link = wp_nonce_url( 
			self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 
			'upgrade-plugin_' . $file_path 
		);

		// Construct the admin notice message.
		$message  = '<p>' . esc_html__( 
			'A new version of Elementor is available. For better performance and compatibility of Graphina - Elementor Charts and Graphs, we recommend updating to the latest version.', 
			'graphina-charts-for-elementor' 
		) . '</p>';
		$message .= '<p>' . sprintf( 
			'<a href="%s" class="button-primary">%s</a>', 
			esc_url( $upgrade_link ), 
			esc_html__( 'Update Elementor Now', 'graphina-charts-for-elementor' ) 
		) . '</p>';

		// Output the error message.
		gcfe_print_error( $message );
	}
}


/**
 * Handles outdated Graphina Pro version notices.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'graphina_fail_load_out_of_date_pro' ) ) {
    function graphina_fail_load_out_of_date_pro() {
        if ( ! current_user_can( 'update_plugins' ) ) {
            return;
        }
        $message  = '<p>' . esc_html__( 'Graphina Pro has been deactivated because you are using an old version of Graphina – Elementor Charts and Graphs. Please update it to latest version.', 'graphina-charts-for-elementor' ) . '</p>';
        gcfe_print_error( $message );
    }
}

/**
 * Handles outdated Elementor version notices.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'graphina_fail_load_out_of_date' ) ) {
    function graphina_fail_load_out_of_date() {
        if ( ! current_user_can( 'update_plugins' ) ) {
            return;
        }

        $file_path    = 'elementor/elementor.php';
        $upgrade_link = wp_nonce_url( 
            self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 
            'upgrade-plugin_' . $file_path 
        );
        
        $message  = '<p>' . esc_html__( 'Graphina - Elementor Charts and Graphs is not working because you are using an old version of Elementor.', 'graphina-charts-for-elementor' ) . '</p>';
        $message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $upgrade_link, esc_html__( 'Update Elementor Now', 'graphina-charts-for-elementor' ) ) . '</p>';
        
        gcfe_print_error( $message );
    }
}

/**
 * Checks if Elementor is installed and activated, and displays appropriate messages.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'graphina_check_required_plugin' ) ) {
    function graphina_check_required_plugin(): void {
        if ( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }

        $file_path         = 'elementor/elementor.php';
        $installed_plugins = get_plugins();

        if ( ! isset( $installed_plugins[ $file_path ] ) ) {
            if ( ! current_user_can( 'install_plugins' ) ) {
                return;
            }

            $install_url = wp_nonce_url( 
                self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 
                'install-plugin_elementor' 
            );

            $message  = '<h3>' . esc_html__( 'Install and Activate the Elementor Plugin', 'graphina-charts-for-elementor' ) . '</h3>';
            $message .= '<p>' . esc_html__( 'Before you can use all the features of Graphina - Elementor Charts and Graphs, you need to install and activate the Elementor plugin first.', 'graphina-charts-for-elementor' ) . '</p>';
            $message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install Elementor', 'graphina-charts-for-elementor' ) ) . '</p>';
        } else {
            if ( ! current_user_can( 'activate_plugins' ) || is_plugin_active( $file_path ) ) {
                return;
            }
            
            $activation_url = wp_nonce_url( 
                'plugins.php?action=activate&amp;plugin=' . $file_path . '&amp;plugin_status=all&amp;paged=1&amp;s', 
                'activate-plugin_' . $file_path 
            );

            $message  = '<h3>' . esc_html__( 'Activate the Elementor Plugin', 'graphina-charts-for-elementor' ) . '</h3>';
            $message .= '<p>' . esc_html__( 'Before you can use all the features of Graphina - Elementor Charts and Graphs, you need to activate the Elementor plugin first.', 'graphina-charts-for-elementor' ) . '</p>';
            $message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Activate Now', 'graphina-charts-for-elementor' ) ) . '</p>';
        }

        gcfe_print_error( $message );
    }
}
if ( ! function_exists( 'gcfe_print_error' ) ) :
	function gcfe_print_error( $message ) {
		if ( ! $message ) {
			return;
		}
		// PHPCS - $message should not be escaped
		echo '<div class="error">' . $message . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

add_action( 'plugins_loaded', 'graphina_load_plugin' );
// Plugin constructor.
if ( ! function_exists( 'gcfe_constructor' ) ) :
	function gcfe_constructor() {
		// Checks if the Graphina class exists.
		if ( class_exists( 'Graphina\\Graphina' ) ) :
			if ( ! function_exists( 'gcfe' ) ) :
				/**
				 * Function to initalize.
				 */
				function gcfe() {
					return Graphina\Graphina::instance();
				}
				$GLOBALS['graphina'] = gcfe();
				// Saves the plugin's instance globally.
			endif;
		endif;
	}
	add_action( 'gcfe_init', 'gcfe_constructor' );
	// This hook is triggered only if Elementor is present.
endif;
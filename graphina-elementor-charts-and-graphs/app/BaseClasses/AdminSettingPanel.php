<?php
/**
 * Admin Class for setting panel and promo banner.
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina_Charts_For_Elementor
 */

namespace GraphinaElementor\App\BaseClasses;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Something went wrong' );
}

use GraphinaElementor\App\Controllers\AdminController;

/**
 * Class AdminSettingPanel
 *
 * Handles admin panel settings and functionalities for the Graphina Charts plugin.
 */
class AdminSettingPanel {

	/**
	 * Initializes the admin panel settings and hooks.
	 *
	 * @return void
	 */
	public function init(): void {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_action( 'admin_notices', array( $this, 'iqonic_sale_banner_notice' ) );
		( new AdminController() );
	}

	/**
	 * Adds custom JavaScript to the admin head section.
	 *
	 * @return void
	 */
	public function admin_head(): void {
		?>
		<script type="text/javascript">
			jQuery(document).ready( function($) {
				jQuery(document).find('ul.wp-submenu a[href="https://apps.iqonic.design/docs/product/graphina-elementor-charts-and-graphs"]').attr( 'target', '_blank' );
				jQuery(document).find('ul.wp-submenu a[href="https://iqonic.design/feature-request/?for_product=graphina"]').attr( 'target', '_blank' );
				jQuery(document).find('ul.wp-submenu a[href="https://codecanyon.net/item/graphinapro-elementor-dynamic-charts-datatable/28654061"]').attr( 'target', '_blank' );
			});
		</script>
		<?php
	}

	/**
	 * Enqueues necessary scripts and stylesheets on admin pages.
	 *
	 * @return void
	 */
	public function enqueue_scripts(): void {
		$current_screen      = get_current_screen();
		$graphina_menu_pages = array( 'toplevel_page_graphina-chart', 'graphina-charts_page_graphina-chart-pro' );
		// Enqueue scripts and styles only on Graphina Charts admin pages.
		if ( empty( $current_screen->id ) || ! in_array( $current_screen->id, $graphina_menu_pages, true ) ) {
			return;
		}

		wp_enqueue_media();
		wp_enqueue_style( 'sweetalert2', GRAPHINA_URL . '/admin/assets/css/sweetalert2.min.css', array(), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, false );
		wp_enqueue_style( 'graphina-custom-admin', GRAPHINA_URL . '/admin/assets/css/graphina-custom-admin.css', array(), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, false );
		wp_enqueue_script( 'sweetalert2', GRAPHINA_URL . '/admin/assets/js/sweetalert2.min.js', array( 'jquery' ), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, false );
		wp_enqueue_script( 'graphina-admin-custom', GRAPHINA_URL . '/admin/assets/js/graphina-custom-admin.js', array( 'jquery' ), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, false );
		wp_localize_script(
			'graphina-admin-custom',
			'localize',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'ajax-nonce' ),
			)
		);

		wp_localize_script(
			'graphina-admin-custom',
			'localize_admin',
			array(
				'adminurl'               => admin_url(),
				'swal_are_you_sure_text' => esc_html__( 'Are you sure?', 'graphina-charts-for-elementor' ),
				'swal_revert_this_text'  => esc_html__( 'You won\'t be able to revert this!', 'graphina-charts-for-elementor' ),
				'swal_delete_text'       => esc_html__( 'Yes, delete it!', 'graphina-charts-for-elementor' ),
				'nonce'                  => wp_create_nonce( 'ajax-nonce' ),
			)
		);
	}

	/**
	 * Adds menu and submenu pages for Graphina Charts in the WordPress admin.
	 *
	 * @return void
	 */
	public function admin_menu(): void {
		if ( current_user_can( 'manage_options' ) ) {
			add_menu_page(
				__( 'Graphina Charts', 'graphina-charts-for-elementor' ),
				__( 'Graphina Charts', 'graphina-charts-for-elementor' ),
				'manage_options',
				'graphina-chart',
				array( $this, 'general_settings' ),
				GRAPHINA_URL . '/admin/assets/images/graphina.svg',
				100
			);
			add_submenu_page(
				'graphina-chart',
				__( 'Graphina Charts Setting', 'graphina-charts-for-elementor' ),
				__( 'Settings', 'graphina-charts-for-elementor' ),
				'manage_options',
				'graphina-chart',
				array( $this, 'general_settings' ),
			);
			add_submenu_page(
				'graphina-chart',
				__( 'Graphina Charts Documentation', 'graphina-charts-for-elementor' ),
				__( 'Documentation', 'graphina-charts-for-elementor' ),
				'manage_options',
				'https://apps.iqonic.design/docs/product/graphina-elementor-charts-and-graphs/'
			);
			add_submenu_page(
				'graphina-chart',
				__( 'Graphina Charts Request Feature', 'graphina-charts-for-elementor' ),
				__( 'Request a Feature', 'graphina-charts-for-elementor' ),
				'manage_options',
				'https://iqonic.design/feature-request/?for_product=graphina'
			);
			if ( ! graphina_pro_active() ) {
				add_submenu_page(
					'graphina-chart',
					__( 'Upgrade To Pro', 'graphina-charts-for-elementor' ),
					__( 'Upgrade To Pro', 'graphina-charts-for-elementor' ),
					'manage_options',
					'graphina-chart-pro',
					array( $this, 'pro_page' )
				);
			}
		}
	}

	/**
	 * Renders the Pro upgrade page content.
	 *
	 * @return void
	 */
	public function pro_page(): void {
		require_once GRAPHINA_ROOT . 'admin/pages/pro-promotions.php';
	}

	/**
	 * Renders the general settings page content.
	 *
	 * @return void
	 */
	public function general_settings(): void {
		require_once GRAPHINA_ROOT . 'admin/pages/general-setting/index.php';
	}

	/**
	 * Displays a sale banner notice based on conditions.
	 *
	 * @return void
	 */
	public function iqonic_sale_banner_notice(): void {
		$type            = 'plugins';
		$product         = 'graphina';
		$get_sale_detail = get_transient( 'iq-notice' );
		if ( is_null( $get_sale_detail ) || $get_sale_detail === false ) {
			$get_sale_detail = wp_remote_get( 'https://assets.iqonic.design/wp-product-notices/notices.json?ver=' . wp_rand() );
			set_transient( 'iq-notice', $get_sale_detail, 3600 );
		}

		if ( ! is_wp_error( $get_sale_detail ) ) {
			$content = json_decode( wp_remote_retrieve_body( $get_sale_detail ), true );
			if ( get_user_meta( get_current_user_id(), $content['data']['notice-id'], true ) ) {
				return;
			}

			$current_time = current_datetime();
			if ( ( $content['data']['start-sale-timestamp'] < $current_time->getTimestamp() && $current_time->getTimestamp() < $content['data']['end-sale-timestamp'] ) && isset( $content[ $type ][ $product ] ) ) {

				?>
				<div class="iq-notice notice notice-success is-dismissible" style="padding: 0;">
					<a target="_blank" href="<?php echo esc_url( ! empty( $content[ $type ][ $product ]['sale-ink'] ) ? $content[ $type ][ $product ]['sale-ink'] : '#' ); ?>">
						<img src="<?php echo esc_url( ! empty( $content[ $type ][ $product ]['banner-img'] ) ? $content[ $type ][ $product ]['banner-img'] : '#' ); ?>" style="object-fit: contain;padding: 0;margin: 0;display: block;" width="100%" alt="">
					</a>
					<input type="hidden" id="iq-notice-id" value="<?php echo esc_html( $content['data']['notice-id'] ); ?>">
					<input type="hidden" id="iq-notice-nounce" value="<?php echo esc_html( wp_create_nonce( 'iq-dismiss-notice' ) ); ?>">
				</div>
				<?php
				wp_enqueue_script( 'iq-admin-notice', GRAPHINA_URL . '/admin/assets/js/iq-admin-notice.js', array( 'jquery' ), GRAPHINA_CHARTS_FOR_ELEMENTOR_VERSION, true );
			}
		}
	}
}

<?php
/**
 * Setting admin page html.
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Something went wrong' );
}

if ( ! current_user_can( 'manage_options' ) ) {
	return;
}

$active_tab = 'setting';
if ( isset( $_GET['activetab'] ) ) {
	$active_tab = sanitize_text_field( wp_unslash( $_GET['activetab'] ) );
}

$allowed_tabs = array( 'setting', 'elements', 'database', 'free-vs-pro' );

if ( ! in_array( $active_tab, $allowed_tabs, true ) ) {
	return;
}

$tab_file_name = GRAPHINA_PATH . "includes/Admin/Menu/views/html-{$active_tab}.php";
if ( ! file_exists( $tab_file_name ) ) {
	return;
}

/**
 * Generate Graphina Tab Menu URL
 * 
 * Constructs and returns the admin URL for Graphina chart settings 
 * with the specified active tab.
 * 
 * @param string $tab_name The name of the active tab.
 * @return string The generated admin URL with the active tab parameter.
 */
function graphina_tab_menu_url( string $tab_name ) {
	$admin_url = admin_url();
	return "{$admin_url}admin.php?page=graphina-chart&activetab={$tab_name}";
}

$pro_active = apply_filters( 'graphina_is_pro_active', false );

?>
	<div id="graphina-settings" class="graphina-settings" name="graphina-settings">
		<div class="graphina-main graphina-wrapper">
			<div class="graphina-tabs">
					<a class="tab " href="<?php echo esc_url( graphina_tab_menu_url( 'setting' ) ); ?>">
						<span class="graphina-tab-item <?php echo esc_html( $active_tab === 'setting' ? 'active-tab graphina-active' : '' ); ?>">
							<img src="<?php echo esc_url( GRAPHINA_URL . 'assets/admin/images/home-04.svg' ); ?>"></img>
							<?php echo esc_html__( 'General', 'graphina-charts-for-elementor' ); ?>
						</span>
					</a>
					<a class="tab " href="<?php echo esc_url( graphina_tab_menu_url( 'elements' ) ); ?>">
						<span class="graphina-tab-item <?php echo esc_html( $active_tab === 'elements' ? 'active-tab graphina-active' : '' ); ?>">
							<img src="<?php echo esc_url( GRAPHINA_URL . 'assets/admin/images/element.svg' ); ?>"></img>
							<?php echo esc_html__( 'Elements', 'graphina-charts-for-elementor' ); ?>
						</span>
					</a>
					<a class="tab" href="<?php echo esc_url( graphina_tab_menu_url( 'database' ) ); ?>">
						<span class="graphina-tab-item <?php echo esc_html( $active_tab === 'database' ? 'active-tab graphina-active' : '' ); ?>" style="position: relative ">
							<img src="<?php echo esc_url( GRAPHINA_URL . 'assets/admin/images/external-database.svg' ); ?>"></img>
							<span class="graphina-badge" <?php echo esc_html( $pro_active ? 'hidden' : '' ); ?> >
								<?php echo esc_html__( 'Pro', 'graphina-charts-for-elementor' ); ?>
							</span>
							<?php echo esc_html__( 'External Database', 'graphina-charts-for-elementor' ); ?>
						</span>
					</a>
					<a class="tab" href="<?php echo esc_url( graphina_tab_menu_url( 'free-vs-pro' ) ); ?>">
						<span class="graphina-tab-item <?php echo esc_html( $active_tab === 'free-vs-pro' ? 'active-tab graphina-active' : '' ); ?>" style="position: relative ">
							<img src="<?php echo esc_url( GRAPHINA_URL . 'assets/admin/images/compare.svg' ); ?>"></img>
							<?php echo esc_html__( 'Free Vs Pro', 'graphina-charts-for-elementor' ); ?>
						</span>
					</a>
			</div>
			<?php require_once $tab_file_name; ?>
		</div>
	</div>
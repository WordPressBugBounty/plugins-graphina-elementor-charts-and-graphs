<?php
/**
 * Setting admin page html.
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina_Charts_For_Elementor
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Something went wrong' );
}

if ( ! current_user_can( 'manage_options' ) ) {
	return;
}

$active_tab = 'setting';
if ( isset( $_GET['activetab'] ) && isset( $_GET['nonce'] ) ) {
	if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['nonce'] ) ), 'graphina-general-setting' ) ) {
		$active_tab = sanitize_text_field( wp_unslash( $_GET['activetab'] ) );
	}
}
$tab_file_name = GRAPHINA_ROOT . "admin/pages/general-setting/{$active_tab}.php";
if ( ! file_exists( $tab_file_name ) ) {
	return;
}

function graphina_tab_menu_url( string $tab_name ) {
	$nonce     = wp_create_nonce( 'graphina-general-setting' );
	$admin_url = admin_url();
	return "{$admin_url}admin.php?page=graphina-chart&activetab={$tab_name}&nonce={$nonce}";
}

$pro_active = graphina_pro_active();

?>
	<div id="graphina-settings" name="graphina-settings">
		<div class="graphina-main">
			<div class="graphina-tabs">
				<ul>
					<li class="<?php echo esc_html( $active_tab === 'setting' ? 'active-tab' : '' ); ?>">
						<a class="tab " href="<?php echo esc_url( graphina_tab_menu_url( 'setting' ) ); ?>">
							<?php echo esc_html__( 'Settings', 'graphina-charts-for-elementor' ); ?>
						</a>
					</li>
					<li class=" <?php echo esc_html( $active_tab === 'database' ? 'active-tab' : '' ); ?>" style="position: relative ">
						<span class="graphina-badge" <?php echo esc_html( $pro_active ? 'hidden' : '' ); ?> >
							<?php echo esc_html__( 'Pro', 'graphina-charts-for-elementor' ); ?>
						</span>
						<a class="tab" href="<?php echo esc_url( graphina_tab_menu_url( 'database' ) ); ?>">
							<?php echo esc_html__( 'External Database', 'graphina-charts-for-elementor' ); ?>
						</a>
					</li>
				</ul>
				<div class="graphina-tab">
					<?php require_once $tab_file_name; ?>
				</div>
			</div>
		</div>
	</div>
<?php
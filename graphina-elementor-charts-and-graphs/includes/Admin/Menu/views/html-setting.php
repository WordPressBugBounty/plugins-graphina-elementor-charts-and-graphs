<?php
/**
 * General setting page html.
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Something went wrong' );
}
$data              = ! empty( get_option( 'graphina_common_setting', true ) ) ? get_option( 'graphina_common_setting', true ) : array();
$selected_js_array = ! empty( $data['graphina_select_chart_js'] ) ? $data['graphina_select_chart_js'] : array();
$selected_apex     = ( in_array( 'apex_chart_js', $selected_js_array, true ) ) ? 'checked' : '';
$selected_google   = ( in_array( 'google_chart_js', $selected_js_array, true ) ) ? 'checked' : '';
?>
<div id="setting" class="graphina-tab-detail">
	<div class="grapgine-title-section">
		<h2><?php echo esc_html__( 'General Settings', 'graphina-charts-for-elementor' ); ?></h2>
		<p><?php echo esc_html__( 'Settings and options for your plugins.', 'graphina-charts-for-elementor' ); ?></p>
	</div>
	<form id="graphina_settings_tab">
		<div class="graphina-admin-charts-setting thousand-separator-field">
			<label for="graphina_setting_text" class="select-chart-title">
				<?php echo esc_html__( 'Thousand Separator: ', 'graphina-charts-for-elementor' ); ?>
			</label>
			<input id="graphina_setting_text" type="text"  class="graphina-form-control" name="thousand_seperator_new" value="<?php echo esc_html( ! empty( $data['thousand_seperator_new'] ) ? $data['thousand_seperator_new'] : ',' ); ?> " disabled>
		</div>
		<div class="graphina-admin-charts-setting thousand-separator-notice"><?php echo esc_html__( "NOTICE: The Thousand Separator setting is deprecated. Thousand separator values are now automatically determined based on the user's language settings.", "graphina-charts-for-elementor"); ?></div>
		<div class="graphina-admin-charts-setting">
			<label for="graphina_local_setting_text" class="select-chart-title">
				<?php echo esc_html__( 'Thousand Separator from language code: ', 'graphina-charts-for-elementor' ); ?>
			</label>
			<input id="graphina_local_setting_text" type="text" placeholder="en-US" class="graphina-form-control" name="thousand_seperator_local" value="<?php echo esc_html( ! empty( $data['thousand_seperator_local'] ) ? $data['thousand_seperator_local'] : 'en-US' ); ?> ">
		</div>
		<div class="graphina-admin-charts-setting graphina-language-code">
			<?php echo esc_html__( 'Here are some common language codes: ', 'graphina-charts-for-elementor' ); ?> 
			<a href='<?php echo esc_url('https://documentation.iqonic.design/graphina/need-help-get-support-for-graphina-plugin/need-help-get-support-lang'); ?>' target='_blank'><?php echo esc_html__('View list of language codes', 'graphina-charts-for-elementor') ?></a>
		</div>
		<div class="graphina-admin-charts-setting">
			<label for="graphina_setting_select" class="select-chart-title"><?php echo esc_html__( 'CSV Separator :', 'graphina-charts-for-elementor' ); ?>
				<span <?php echo esc_html( $pro_active ? 'hidden' : '' ); ?> class="graphina-badge"><?php echo esc_html__( 'Pro', 'graphina-charts-for-elementor' ); ?></span>
			</label>
			<input id="graphina_setting_select" type="text" placeholder="," class="graphina-form-control" name="csv_seperator" value="<?php echo esc_html( ! empty( $data['csv_seperator'] ) ? $data['csv_seperator'] : ',' ); ?> ">
		</div>
		<div class="graphina-admin-charts-setting">
			<label for="switch" class="select-chart-title"><?php echo esc_html__( 'View Port : ', 'graphina-charts-for-elementor' ); ?></label>
			<div class="">
				<input  type="checkbox" id="switch" name="view_port" <?php echo esc_html( ! empty( $data['view_port'] ) && $data['view_port'] === 'on' ? 'checked' : '' ); ?> >
				<span class="check-value"><?php echo esc_html__( 'Disable', 'graphina-charts-for-elementor' ); ?></span>	
			</div>
		</div>
		<small class="graphina-chart-note"> <?php echo esc_html__( 'Note : Disable  chart and counter render when it come in viewport ,render chart and counter when page load (default chart and counter are render when it in viewport)', 'graphina-charts-for-elementor' ); ?></small>
		<div class="graphina-admin-charts-setting">
			<label for="enable_chart_filter" class="select-chart-title">
				<?php echo esc_html__( 'Chart loader: ', 'graphina-charts-for-elementor' ); ?>
				<span <?php echo esc_html( $pro_active ? 'hidden' : '' ); ?> class="graphina-badge"><?php echo esc_html__( 'Pro', 'graphina-charts-for-elementor' ); ?></span>
			</label>
			<div class="">
				<input <?php echo esc_html( $pro_active ? '' : 'disabled' ); ?> type="checkbox" id="enable_chart_filter" name="enable_chart_filter" <?php echo esc_html( ! empty( $data['enable_chart_filter'] ) && $data['enable_chart_filter'] === 'on' ? 'checked=checked' : '' ); ?> >
				<span class="check-value"><?php echo esc_html__( 'Enable ', 'graphina-charts-for-elementor' ); ?></span>
			</div>
		</div>
		<div id="chart_filter_div" class="graphina-admin-charts-setting <?php echo esc_html( ! empty( $data['enable_chart_filter'] ) ? '' : 'graphina-d-none' ); ?>">	
			<input class="graphina_upload_loader graphina_test_btn graphina-btn graphina-btn-link" id="graphina_upload_loader" type="button" value="<?php echo esc_html__( 'Upload Loader', 'graphina-charts-for-elementor' ); ?>"/>
			<input size="36"
					id="graphina_loader_hidden"
					name="graphina_loader" type="hidden" value="<?php echo esc_url( ! empty( $data['graphina_loader'] ) ? $data['graphina_loader'] : GRAPHINA_URL . 'assets/admin/images/graphina.gif' ); ?>">
			<img <?php echo $pro_active ? '' : 'hidden'; ?> name="image_src" class="graphina_upload_image_preview" id="graphina_upload_image_preview" src="<?php echo esc_url( ! empty( $data['graphina_loader'] ) ? $data['graphina_loader'] : GRAPHINA_URL . 'assets/admin/images/graphina.gif' ); ?>" alt="graphina-loader"/>
		</div>
		<p class="graphina-chart-note" style="display: <?php echo esc_html( $pro_active ? 'none' : 'block' ); ?>"> <strong><?php echo esc_html__( 'Chart Filter working only in Graphina pro', 'graphina-charts-for-elementor' ); ?></strong></p>
		<div>
			<input type="hidden" name="action" value="graphina_setting_data">
			<input type="hidden" name="nonce" value="<?php echo esc_html( wp_create_nonce( 'ajax-nonce' ) ); ?>">
			<button type="submit" class="graphina-btn graphina-btn-primary" name="save_data" data-url='<?php echo esc_url( admin_url() ); ?>' id="graphina_setting_save_button" class="graphina_test_btn"><?php echo esc_html__( 'Save Setting', 'graphina-charts-for-elementor' ); ?></button>
		</div>
	</form>
</div>
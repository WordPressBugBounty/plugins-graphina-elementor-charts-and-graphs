<?php
/**
 * General setting page html.
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina_Charts_For_Elementor
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
	<form id="graphina_settings_tab"><br>
		<div class="graphina-admin-charts-setting">
			<label for="graphina_select_apex_chart_js" class="select-chart-title">
				<?php echo esc_html__( 'Select Chart Js :  ', 'graphina-charts-for-elementor' ); ?>
			</label>
			<input type="checkbox" id="graphina_select_apex_chart_js" name="graphina_select_chart_js[]" value='apex_chart_js' <?php echo esc_html( $selected_apex ); ?> >
			<label for="graphina_select_google_chart_js" class="check-value"><?php echo esc_html__( 'Apex Chart Js', 'graphina-charts-for-elementor' ); ?></label>
			<input type="checkbox" id="graphina_select_google_chart_js" name="graphina_select_chart_js[]" value='google_chart_js' <?php echo esc_html( $selected_google ); ?> >
			<span class="check-value"><?php echo esc_html__( 'Google Chart Js', 'graphina-charts-for-elementor' ); ?></span>
		</div>
		<div class="graphina-admin-charts-setting">
			<label for="graphina_setting_text" class="select-chart-title">
				<?php echo esc_html__( 'Thousand Seperator: ', 'graphina-charts-for-elementor' ); ?>
			</label>
			<input id="graphina_setting_text" type="text" name="thousand_seperator_new" value="<?php echo esc_html( ! empty( $data['thousand_seperator_new'] ) ? $data['thousand_seperator_new'] : ',' ); ?>">
		</div>
		<div class="graphina-admin-charts-setting">
			<label for="graphina_setting_select" class="select-chart-title"><?php echo esc_html__( 'CSV Seperator :', 'graphina-charts-for-elementor' ); ?>
				<span <?php echo esc_html( $pro_active ? 'hidden' : '' ); ?> class="graphina-badge"><?php echo esc_html__( 'Pro', 'graphina-charts-for-elementor' ); ?></span>
			</label>
			<select <?php echo esc_html( $pro_active ? '' : 'disabled' ); ?> id="graphina_setting_select" name="csv_seperator">
				<option name="comma" value="comma" <?php echo esc_html( ! empty( $data['csv_seperator'] ) && $data['csv_seperator'] === 'comma' ? 'selected' : '' ); ?> ><?php echo esc_html__( 'Comma', 'graphina-charts-for-elementor' ); ?></option>
				<option name="semicolon" value="semicolon" <?php echo esc_html( ! empty( $data['csv_seperator'] ) && $data['csv_seperator'] === 'semicolon' ? 'selected' : '' ); ?> ><?php echo esc_html__( 'Semicolon', 'graphina-charts-for-elementor' ); ?></option>
			</select>
		</div>
		<div class="graphina-admin-charts-setting">
			<label for="switch" class="select-chart-title"><?php echo esc_html__( 'View Port : ', 'graphina-charts-for-elementor' ); ?></label>
			<input  type="checkbox" id="switch" name="view_port" <?php echo esc_html( ! empty( $data['view_port'] ) && $data['view_port'] === 'on' ? 'checked' : '' ); ?> >
			<span class="check-value"><?php echo esc_html__( 'Disable', 'graphina-charts-for-elementor' ); ?></span>
			<p class="graphina-chart-note"> <?php echo esc_html__( 'Note : Disable  chart and counter render when it come in viewport ,render chart and counter when page load (default chart and counter are render when it in viewport)', 'graphina-charts-for-elementor' ); ?></p>
		</div>
		<div class="graphina-admin-charts-setting">
			<label for="enable_chart_filter" class="select-chart-title">
				<?php echo esc_html__( 'Chart Filter loader: ', 'graphina-charts-for-elementor' ); ?>
				<span <?php echo esc_html( $pro_active ? 'hidden' : '' ); ?> class="graphina-badge"><?php echo esc_html__( 'Pro', 'graphina-charts-for-elementor' ); ?></span>
			</label>
			<input <?php echo esc_html( $pro_active ? '' : 'disabled' ); ?> type="checkbox" id="enable_chart_filter" name="enable_chart_filter" <?php echo esc_html( ! empty( $data['enable_chart_filter'] ) && $data['enable_chart_filter'] === 'on' ? 'checked=checked' : '' ); ?> >
			<span class="check-value"><?php echo esc_html__( 'Enable ', 'graphina-charts-for-elementor' ); ?></span>
		</div>
		<div id="chart_filter_div" class="<?php echo esc_html( ! empty( $data['enable_chart_filter'] ) ? '' : 'graphina-d-none' ); ?>">
			<input style="margin-left: unset; background:#2a4cc9;" class="graphina_upload_loader graphina_test_btn" type="button" value="<?php echo esc_html__( 'Upload Filter Loader', 'graphina-charts-for-elementor' ); ?>"/>
			<input size="36"
					id="graphina_loader_hidden"
					name="graphina_loader" type="hidden" value="<?php echo esc_url( ! empty( $data['graphina_loader'] ) ? $data['graphina_loader'] : GRAPHINA_URL . '/admin/assets/images/graphina.gif' ); ?>">
			<img <?php echo $pro_active ? '' : 'hidden'; ?> name="image_src" class="graphina_upload_image_preview" id="graphina_upload_image_preview" src="<?php echo esc_url( ! empty( $data['graphina_loader'] ) ? $data['graphina_loader'] : GRAPHINA_URL . '/admin/assets/images/graphina.gif' ); ?>" alt="graphina-loader"/>
			<p style="display: <?php echo esc_html( $pro_active ? 'none' : 'block' ); ?>"> <strong><?php echo esc_html__( 'Chart Filter working only in Graphina pro', 'graphina-charts-for-elementor' ); ?></strong></p>
		</div>
		<div>
			<input type="hidden" name="action" value="graphina_setting_data">
			<input type="hidden" name="nonce" value="<?php echo esc_html( wp_create_nonce( 'ajax-nonce' ) ); ?>">
			<button type="submit" name="save_data" data-url='<?php echo esc_url( admin_url() ); ?>' id="graphina_setting_save_button" class="graphina_test_btn"><?php echo esc_html__( 'Save Setting', 'graphina-charts-for-elementor' ); ?></button>
		</div>
	</form>
</div>
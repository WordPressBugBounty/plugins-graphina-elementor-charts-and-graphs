<?php
/**
 * Database setting admin page html.
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Something went wrong' );
}
$option_value       = array();
$all_db_connections = graphina_check_external_database( 'data' );
$all_db_connections = ! empty( $all_db_connections ) && is_array( $all_db_connections ) ? $all_db_connections : array();
$edit_id = sanitize_text_field( wp_unslash( $_GET['data'] ) );
if ( ! empty( $all_db_connections[ $edit_id ] ) ) {
	$option_value = $all_db_connections[ $edit_id ];
}

?>
<div id="database" class="graphina-tab-detail <?php echo $pro_active === false ? esc_attr( 'graphina-pro-module' ) : ''; ?>">
	<div class="grapgine-title-section graphina-element-flex">
		<h1 class="head-border"><?php echo esc_html__( 'Connection Detail', 'graphina-charts-for-elementor' ); ?>
		</h1>
		<button type="submit" name="save" data-nonce="<?php echo esc_html( wp_create_nonce( 'cache-nonce' ) ); ?>" id="graphina-clear-cache-button" class="graphina-btn graphina-btn-primary graphina-clear-cache btn-submit" <?php echo esc_html( $pro_active ? '' : 'disabled' ); ?>><?php echo esc_html__( 'Clear Database Cache', 'graphina-charts-for-elementor' ); ?></button>
	</div>

	<form id="graphina-settings-db-tab">
		<div class="row">
			<div class="col-06">
				<div class="graphina-admin-charts-setting">
					<label class="form-label" for="con_name"><?php echo esc_html__( 'Connection Name* : ', 'graphina-charts-for-elementor' ); ?></label>
					<input type="text" id="con_name" name="con_name" class="graphina-form-control" value="<?php echo esc_html( isset( $option_value['con_name'] ) && ! empty( $option_value['con_name'] ) ? $option_value['con_name'] : '' ); ?>"
						<?php echo esc_html( ( isset( $edit_data ) && $edit_data !== '' ) || ( ! $pro_active ) ? 'readonly' : '' ); ?>>
				</div>	
			</div>
			<div class="col-06">
				<div class="graphina-admin-charts-setting">
					<label for="input1" class="form-label" for="fname"><?php echo esc_html__( 'Vendor* : ', 'graphina-charts-for-elementor' ); ?></label>
					<select id="input1" name="vendor" class="graphina-form-control" <?php echo esc_html( $pro_active ? '' : 'disabled' ); ?> style="padding: 11px;">
						<option value="mysql"><?php echo esc_html__( 'MySQL', 'graphina-charts-for-elementor' ); ?></option>
					</select>
				</div>	
			</div>
		</div>

		<div class="row">
			<div class="col-06">
				<div class="graphina-admin-charts-setting">
					<label class="form-label" for="lname"><?php echo esc_html__( 'Database Name* : ', 'graphina-charts-for-elementor' ); ?></label>
					<input type="text" id="lname" name="db_name" class="graphina-form-control" value="<?php echo esc_html( ! empty( $option_value['db_name'] ) ? $option_value['db_name'] : '' ); ?>" <?php echo esc_html( $pro_active ? '' : 'readonly' ); ?> />
				</div>
			</div>
			<div class="col-06">
				<div class="graphina-admin-charts-setting">
					<label class="form-label" for="fname"><?php echo esc_html__( 'Host* : ', 'graphina-charts-for-elementor' ); ?></label>
					<input type="text" name="host" id="fname" class="graphina-form-control" value="<?php echo esc_html( ! empty( $option_value['host'] ) ? $option_value['host'] : '' ); ?>" <?php echo esc_html( $pro_active ? '' : 'readonly' ); ?> />
				</div>	
			</div>
		</div>

		<div class="row">
			<div class="col-06">
				<div class="graphina-admin-charts-setting">
					<label class="form-label" for="lname"><?php echo esc_html__( 'Username* : ', 'graphina-charts-for-elementor' ); ?></label>
					<input type="text" name="user_name" class="graphina-form-control" value="<?php echo esc_html( ! empty( $option_value['user_name'] ) ? $option_value['user_name'] : '' ); ?>" <?php echo esc_html( $pro_active ? '' : 'readonly' ); ?>>
				</div>
			</div>
			<div class="col-06">
				<div class="graphina-admin-charts-setting">
					<label class="form-label" for="fname"><?php echo esc_html__( 'Password* : ', 'graphina-charts-for-elementor' ); ?></label>
					<input type="password" id="fname" name="pass" class="graphina-form-control" value="<?php echo esc_html( ! empty( $option_value['pass'] ) ? $option_value['pass'] : '' ); ?>" <?php echo esc_html( $pro_active ? '' : 'readonly' ); ?> />
				</div>
			</div>
		</div>

		<input type="hidden" name="type" value="<?php echo esc_html( isset( $edit_data ) && $edit_data !== '' ? 'edit' : 'save' ); ?>" id="graphina_external_database_action_type">
		<input type="hidden" name="action" value="graphina_external_database">
		<input type="hidden" name="nonce" value="<?php echo esc_html( wp_create_nonce( 'ajax-nonce' ) ); ?>">
		<div class="btn-row">
			<button type="submit" name="save" id="graphina_database_save_button" class="graphina-btn graphina-btn-primary graphina_test_btn btn-submit" data-url="<?php echo esc_url( admin_url() ); ?>" <?php echo esc_html( $pro_active ? '' : 'disabled' ); ?>><?php echo esc_html__( 'Save Setting', 'graphina-charts-for-elementor' ); ?></button>
			<button type="button" name="graphina_con_test" id="graphina_test_db_btn" class="graphina-btn graphina-btn-primary graphina_test_db_btn graphina_test_btn btn-submit" <?php echo esc_html( $pro_active ? '' : 'disabled' ); ?>><?php echo esc_html__( 'Test DB Setting', 'graphina-charts-for-elementor' ); ?></button>
			<a href="<?php echo esc_url( admin_url() . 'admin.php?page=graphina-chart&activetab=database' ); ?>">
				<button type="button" name="btn-submit" class="graphina-btn graphina-btn-danger graphina_reset_db_btn graphina_test_btn">
					<?php echo esc_html__( 'Reset', 'graphina-charts-for-elementor' ); ?>
				</button>
			</a>
		</div>

	</form>
		<div class="graphina_form_body">
			<?php
			if ( ! empty( $all_db_connections ) ) {
				?>
				<table class="graphina-connection-table">
					<tr>
						<th><?php echo esc_html__( 'Connection Name', 'graphina-charts-for-elementor' ); ?></th>
						<th class="text-end"><?php echo esc_html__( 'Action', 'graphina-charts-for-elementor' ); ?></th>
					</tr>
					<?php
					foreach ( $all_db_connections as $key => $value ) {
						?>
						<tr>
							<td ><?php echo esc_html( $value['con_name'] ); ?></td>
							<td class="graphina-action-btn">
								<a href="<?php echo esc_url( graphina_tab_menu_url( 'database' ) . "&data={$value['con_name']}" ); ?>">
									<button class="graphina_test_btn graphina-btn graphina-btn-outline-primary"
											id="graphina_database_edit">
										<?php echo esc_html__( 'Edit', 'graphina-charts-for-elementor' ); ?>
									</button>
								</a>
							
								<button data-selected="<?php echo esc_html( $value['con_name'] ); ?>"
										class="graphina_test_btn graphina-database-delete graphina-btn graphina-btn-outline-title"
										id="graphina-database-delete"
										name="delete">
									<?php echo esc_html__( 'Delete', 'graphina-charts-for-elementor' ); ?>
								</button>
							</td>
						</tr>
						<?php
					}
					?>
				</table>
				<?php
			}
			?>
		</div>
</div>


<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
*
*   The template for displaying chart template \*
*   @link [https://codex.wordpress.org/Template\_Hierarchy](https://codex.wordpress.org/Template_Hierarchy) \*
*   @package graphina
**/
?><div class="graphina-restricted-content <?php echo $chart_type === 'counter' ? 'graphina-card counter' : 'chart-card'; ?>"
	style="padding: 20px">
	<form class="graphina-password-restricted-form" method="post" target="_top" autocomplete="off">
		<h4 class="graphina-password-heading"><?php echo esc_html( $heading ); ?></h4>
		<p class="graphina-password-message"><?php echo esc_html( $instructions ); ?></p>
		<div class="graphina-input-wrapper">
			<input type="hidden" name="chart_password"
				value="<?php echo esc_html( wp_hash_password( $hash_pass ) ); ?>">
			<input type="hidden" name="chart_type" value="<?php echo esc_html( $chart_type ); ?>">
			<input type="hidden" name="chart_id" value="<?php echo esc_html( $chart_id ); ?>">
			<input type="hidden" name="nonce" value="<?php echo sanitize_key( wp_create_nonce( 'graphina_restrict_password' ) ); ?>">
			<input type="hidden" name="action" value="graphina_restrict_password">
			<input class="form-control graphina-input " type="password" name="graphina_password"
				autocomplete="off" placeholder="Enter Password" style="outline: none">
		</div>
		<div class="button-box">
			<button class="graphina-login-btn" name="submit" type="submit"
				style="outline: none"><?php echo esc_html( $button_lbl ); ?></button>
		</div>
		<div class="graphina-error-div">
			<?php
			if ( ! $is_preview_mode ) {
				?>
				<div class=" elementor-alert-danger graphina-error "
					style="display: <?php echo esc_attr( $error_msg_show ) === 'yes' ? 'flex' : 'none'; ?>;align-items:center; ">
					<span><?php echo esc_html( $error_msg ); ?></span>
				</div>
				<?php
			} else {
				?>
				<div class=" elementor-alert-danger graphina-error "
					style="display: none; align-items:center;">
					<span><?php echo esc_html( $error_msg ); ?></span>
				</div>
			<?php } ?>
		</div>
	</form>
</div>
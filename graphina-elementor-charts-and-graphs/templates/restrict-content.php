
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
?>
<div class="graphina-restricted-content ">
	<h5>
		<?php echo esc_html__( 'You do not have permission to see this content.', 'graphina-charts-for-elementor' ); ?>
	</h5>
	<a class="graphina-btn graphina-btn-primary" href="<?php echo esc_url( wp_login_url() ); ?>"><?php echo esc_html__( 'Unlock Access', 'graphina-charts-for-elementor' ); ?></a>
</div>

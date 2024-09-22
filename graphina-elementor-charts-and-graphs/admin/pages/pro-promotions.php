<?php
/**
 * Pro promotion admin page html.
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina_Charts_For_Elementor
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Something went wrong' );
}
?>
<div style="background: #2A2A31; padding: 50px 0; border-radius: 20px; margin: 20px 20px 0  0;">
	<img src="<?php echo esc_url( GRAPHINA_URL . '/admin/assets/images/graphina_banner.jpg' ); ?>"
		style="width:80%; display: block; margin-left: auto; margin-right: auto; border-radius: 20px;" alt="graphina-banner">
	<img src="<?php echo esc_url( GRAPHINA_URL . '/admin/assets/images/graphina_pro.jpg' ); ?>"
		style="width:80%; display: block; margin-left: auto; margin-right: auto; margin-top: 20px; border-radius: 20px;" alt="promo-banner">
	<a href="https://codecanyon.net/item/graphinapro-elementor-dynamic-charts-datatable/28654061"
		style="display: block; text-align: center; margin: 50px 0 50px 0;"
		target="_blank">
		<button type="button" name="btn-submit" class="graphina_pro_btn" style="background-image: linear-gradient(329.95deg, #4D2D71 26.51%, #DB3360 94.88%); border: 0;">
			<?php echo esc_html__( 'Buy Pro', 'graphina-charts-for-elementor' ); ?>
		</button>
	</a>
</div>
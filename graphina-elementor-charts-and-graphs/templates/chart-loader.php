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
<div class="graphina-chart-loader graphina-<?php echo esc_attr( $element_id ); ?>-loader" style="height:<?php echo esc_attr($height); ?>px">
	<img src="<?php echo esc_url( $loader ); ?>"></img>
</div>
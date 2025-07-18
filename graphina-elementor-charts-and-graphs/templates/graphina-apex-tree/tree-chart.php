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
<div class="chart-box">
	<div class="graphina-tree-chart" 
		data-chart_type="<?php echo esc_html( $chart_type ); ?>"
		data-element_id="<?php echo esc_html( $element_id ); ?>"
		data-chart_options='<?php echo wp_json_encode( $chart_options ); ?>'
		data-chart_data='<?php echo wp_json_encode( $chart_data ); ?>'
		data-responsive_options='<?php echo wp_json_encode( $responsive_options ); ?>'
		data-extra_data='<?php echo esc_attr(wp_json_encode( $extra_data )); ?>'
		data-settings='<?php echo esc_attr(wp_json_encode($element_settings)); ?>'
>
	</div>
</div>
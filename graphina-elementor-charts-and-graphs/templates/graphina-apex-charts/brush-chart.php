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
	<div class="graphina-elementor-chart <?php echo isset($common_filter_class) ? esc_attr($common_filter_class) : ''; ?> graphina-brush-chart-<?php echo esc_attr( $element_id ); ?>-1"
		data-chart_type="<?php echo esc_html( $chart_type ); ?>"
		data-element_id="<?php echo esc_html( $element_id ); ?>"
		data-chart_options='<?php echo wp_json_encode( $chart_options ); ?>'
		data-responsive_options='<?php echo wp_json_encode( $responsive_options ); ?>'
		data-extra_data='<?php echo wp_json_encode( $extra_data ); ?>'
		data-settings='<?php echo esc_attr(wp_json_encode($element_settings)); ?>'>
	</div>

	<div class="graphina-brush-chart-<?php echo esc_attr( $element_id ); ?>-2"
		data-second_chart_options='<?php echo wp_json_encode( $second_chart_options ); ?>'>
	</div>
</div>
<script>
    (function($) {
        'use strict';
        $(document).ready(function() {
            if (window.graphinaBrushChart && typeof window.graphinaBrushChart.observeChartElement === 'function') {
                window.graphinaBrushChart.observeChartElement($('.graphina-elementor-chart[data-element_id="<?php echo esc_js( $element_id ); ?>"]'), 'area');
            }
        });
    })(jQuery);
</script>
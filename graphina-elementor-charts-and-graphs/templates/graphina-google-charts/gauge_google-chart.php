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
	<div class="google-chart-texture">
		<p><?php echo esc_html__( 'No Data Found', 'graphina-charts-for-elementor' ); ?></p>
	</div>
	<div class="graphina-google-chart <?php echo esc_attr($common_filter_class); ?>"
		data-chart_type="<?php echo esc_attr( $chart_type ); ?>"
		data-chart_type_static="Gauge"
		data-element_id="<?php echo esc_attr( $element_id ); ?>"
		data-chart_options='<?php echo esc_attr(wp_json_encode( $chart_options )); ?>'
		data-chart_data='<?php echo esc_attr(wp_json_encode( $chart_data )); ?>'
		data-extra_data='<?php echo esc_attr(wp_json_encode( $extra_data )); ?>'
		data-settings='<?php echo esc_attr(wp_json_encode($element_settings)); ?>'
		>
	</div>
</div>
<script>
    (function($) {
        'use strict';
        $(document).ready(function() {
            if (window.graphinaGoogleGaugeChart && typeof window.graphinaGoogleGaugeChart.observeChartElement === 'function') {
                window.graphinaGoogleGaugeChart.observeChartElement($('.graphina-google-chart[data-element_id="<?php echo esc_js( $element_id ); ?>"]'), 'Gauge');
            }
        });
    })(jQuery);
</script>
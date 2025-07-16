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
	<div class="graphina-elementor-chart nested_column-chart-one-<?php echo esc_attr( $element_id ); ?>"
		data-chart_type="<?php echo esc_html( $chart_type ); ?>"
		data-element_id="<?php echo esc_html( $element_id ); ?>"
		data-chart_options='<?php echo wp_json_encode( $chart_options ); ?>'
		data-responsive_options='<?php echo wp_json_encode( $responsive_options ); ?>'
		data-extra_data='<?php echo wp_json_encode( $extra_data ); ?>'
		data-settings='<?php echo esc_attr(wp_json_encode($element_settings)); ?>'>
	</div>

	<div class="nested_column-chart-two-<?php echo esc_attr( $element_id ); ?>"
		data-chart_type="<?php echo esc_html( $chart_type ); ?>"
		data-second_chart_options='<?php echo wp_json_encode( $second_chart_options ); ?>'
		data-element_id="<?php echo esc_html( $element_id ); ?>">
	</div>

</div>
<script>
    (function($) {
        'use strict';
        $(document).ready(function() {
            if (window.graphinaNestedcolumnChart && typeof window.graphinaNestedcolumnChart.observeChartElement === 'function') {
                window.graphinaNestedcolumnChart.observeChartElement($('.graphina-elementor-chart[data-element_id="<?php echo esc_js( $element_id ); ?>"]'), 'bar');
            }
        });
    })(jQuery);
</script>
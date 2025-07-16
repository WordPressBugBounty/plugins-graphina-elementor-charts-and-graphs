
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
    <div class="graphina-elementor-chart <?php echo esc_attr($common_filter_class); ?>"
        data-chart_type="<?php echo esc_attr( $chart_type ); ?>"
        data-element_id="<?php echo esc_attr( $element_id ); ?>"
        data-chart_options="<?php echo esc_attr( wp_json_encode( $chart_options ) ); ?>"
        data-responsive_options="<?php echo esc_attr( wp_json_encode( $responsive_options ) ); ?>"
        data-extra_data="<?php echo esc_attr( wp_json_encode( $extra_data ) ); ?>"
        data-settings="<?php echo esc_attr( wp_json_encode( $element_settings ) ); ?>"
        style="height: 350px;"
    >
    </div>
</div>
<script>
    (function($) {
        'use strict';
        $(document).ready(function() {
            if (window.graphinaRadarChart && typeof window.graphinaRadarChart.observeChartElement === 'function') {
                window.graphinaRadarChart.observeChartElement($('.graphina-elementor-chart[data-element_id="<?php echo esc_js( $element_id ); ?>"]'), 'radar');
            }
        });
    })(jQuery);
</script>
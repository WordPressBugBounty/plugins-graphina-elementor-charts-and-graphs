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
?><div class="graphina_dynamic_change_type">
	<select class="graphina-select-google-chart-type graphina-select-chart-type" data-chart_type="<?php echo esc_attr( $chart_type ); ?>" data-element_id="<?php echo esc_attr( $element_id ); ?>">
		<option selected
			disabled><?php echo esc_html__( 'Choose Chart Type', 'graphina-charts-for-elementor' ); ?></option>
		<?php
		if ( in_array( $chart_type, array( 'pie_google', 'donut_google' ), true ) ) {
			?>
			<option value="PieChart"><?php echo esc_html__( 'Pie', 'graphina-charts-for-elementor' ); ?></option>
			<option value="DonutChart"><?php echo esc_html__( 'Donut', 'graphina-charts-for-elementor' ); ?></option>
			<?php
		} else {
			?>
			<option value="AreaChart"><?php echo esc_html__( 'Area', 'graphina-charts-for-elementor' ); ?></option>
			<option value="LineChart"><?php echo esc_html__( 'Line', 'graphina-charts-for-elementor' ); ?></option>
			<option value="BarChart"><?php echo esc_html__( 'Bar', 'graphina-charts-for-elementor' ); ?></option>
			<option value="ColumnChart"><?php echo esc_html__( 'Column', 'graphina-charts-for-elementor' ); ?></option>
		<?php } ?>
	</select>
</div>
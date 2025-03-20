
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
	<select class="graphina-select-apex-chart-type graphina-select-chart-type" data-chart_type="<?php echo esc_attr( $chart_type ); ?>" data-element_id="<?php echo esc_attr( $element_id ); ?>">
		<option selected
				disabled><?php echo esc_html__( 'Choose Chart Type', 'graphina-charts-for-elementor' ); ?></option>
		<?php
		if ( in_array( $chart_type, array( 'pie', 'donut', 'polar' ), true ) ) {
			?>
			<option value="donut"><?php echo esc_html__( 'Donut', 'graphina-charts-for-elementor' ); ?></option>
			<option value="pie"><?php echo esc_html__( 'Pie', 'graphina-charts-for-elementor' ); ?></option>
			<option value="polarArea"><?php echo esc_html__( 'PolarArea', 'graphina-charts-for-elementor' ); ?></option>
			<?php
		} else {
			?>
			<option value="area"><?php echo esc_html__( 'Area', 'graphina-charts-for-elementor' ); ?></option>
			<option value="bar"><?php echo esc_html__( 'Column', 'graphina-charts-for-elementor' ); ?></option>
			<option value="line"><?php echo esc_html__( 'Line', 'graphina-charts-for-elementor' ); ?></option>
			<?php
		}
		?>
	</select>
</div>
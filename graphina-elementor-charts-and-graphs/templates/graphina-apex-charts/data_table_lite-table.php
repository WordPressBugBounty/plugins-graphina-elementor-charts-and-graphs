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
<div class="<?php echo esc_attr( $show_card === 'yes' ? 'chart-card' : '' ); ?> graphina-jquery-data-table"
	data-element_id="<?php echo esc_attr( $element_id ); ?>"
	data-chart_type="<?php echo esc_html( $chart_type ); ?>"
	data-chart_data='<?php echo wp_json_encode( $table_data ); ?>'
	data-extra_data='<?php echo wp_json_encode( $extra_data ); ?>'
	data-settings='<?php echo esc_attr(wp_json_encode($element_settings)); ?>'>
	<div class="">
		<?php if ( $show_heading ) { ?>
			<h4 class="heading graphina-chart-heading">
				<?php echo wp_kses_post( html_entity_decode( (string) $table_heading ) ); ?>
			</h4>
			<?php
		}
		if ( $show_card ) {
			?>
			<p class="sub-heading graphina-chart-sub-heading">
				<?php echo wp_kses_post( html_entity_decode( (string) $table_content ) ); ?>
			</p>
		<?php } ?>
	</div>

	<?php  
		graphina_filter_common( $settings, $chart_type, $chart_data, $element_id );
	?>

	<table id="data_table_lite_<?php echo esc_attr( $element_id ); ?>"
		class="chart-texture display wrap data_table_lite_<?php echo esc_attr( $element_id ); ?>">
	</table>
	<p id="data_table_lite_loading_<?php echo esc_attr( $element_id ); ?>" class="graphina-chart-heading table-loading-txt">
		<?php echo wp_kses_post( apply_filters( 'graphina_datatable_loader', esc_html__( 'Loading..........', 'graphina-charts-for-elementor' ) ) ); ?>
	</p>
	<p id="data_table_lite_no_data_<?php echo esc_attr( $element_id ); ?>" class="graphina-chart-heading table-data-not-available-txt">
		<?php echo esc_html__( 'The Data is Not Available', 'graphina-charts-for-elementor' ); ?>
	</p>
</div>
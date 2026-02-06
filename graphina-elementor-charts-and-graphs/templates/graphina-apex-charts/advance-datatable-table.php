<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
*
*   The template for displaying table template \*
*   @link [https://codex.wordpress.org/Template\_Hierarchy](https://codex.wordpress.org/Template_Hierarchy) \*
*   @package graphina
**/
?>
<div class="graphina-element  graphina-advance-data-table <?php echo $show_card === 'yes' ? 'element-card' : ''; ?>"
	data-element_id="<?php echo esc_attr( $element_id ); ?>"
	data-chart_type="<?php echo esc_html( $chart_type ); ?>"
	data-extra_data='<?php echo esc_attr(wp_json_encode( $extra_data )); ?>'
	data-table_data='<?php echo esc_attr(wp_json_encode( $table_data )); ?>'
	data-settings='<?php echo esc_attr(wp_json_encode($element_settings)); ?>'>
	<?php if ( $filter === 'yes' ) { ?>
		<input type="text" class="table-filter" id="table-filter-<?php esc_attr_e( $element_id ); ?>"
			placeholder="<?php esc_attr_e( 'Search ...' ); ?>">
	<?php } ?>
	<div>
	</div>
	<div class="graphina-table graphina-table-<?php esc_attr_e( $element_id ); ?> <?php echo $responsive === 'yes' ? 'table-responsive' : ''; ?> ">
	</div>
</div>
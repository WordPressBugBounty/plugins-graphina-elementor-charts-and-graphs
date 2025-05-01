
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

// Fire action before chart template starts
do_action( 'graphina_before_chart_template' );

?><div class="<?php echo esc_attr( $chart_card_class ); ?>">
	<div>
		<?php if ( $show_heading ) : ?>
			<h4 class="heading graphina-chart-heading">
				<?php echo wp_kses_post( $chart_title ); ?>
			</h4>
		<?php endif; ?>

		<?php if ( $show_description ) : ?>
			<p class="sub-heading graphina-chart-sub-heading">
				<?php echo wp_kses_post( $chart_description ); ?>
			</p>
		<?php endif; ?>
	</div>
	<?php 

	if (
		! empty( $chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_dynamic_change_chart_type' ] ) &&
		$chart_data['settings'][ GRAPHINA_PREFIX . $chart_data['chart_type'] . '_dynamic_change_chart_type' ] === 'yes'
	) {
		if ( ! empty($chart_data['is_google'] ) && $chart_data['is_google'] ) 
		{
			graphina_get_google_chart_type_options( $chart_data['chart_type'], $chart_data['element_id'] );
		} else if ( ! empty( ! empty($chart_data['is_apex'] ) ) && $chart_data['is_apex'] ) {
			graphina_get_apex_chart_type_options( $chart_data['chart_type'], $chart_data['element_id'] );
		}
	}


    // Filter before chart template
	do_action( 'graphina_before_chart_box_template', $chart_data );

	// Handle Chart Filter
	graphina_filter_common( $chart_data['settings'], $chart_data['chart_type'], $chart_data, $chart_data['element_id'] );
	
	graphina_get_template( $template_path, $chart_data );

	// Filter before chart template
	do_action( 'graphina_after_chart_box_template', $chart_data );

	$is_dynamic = false;
	if( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_option' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_data_option' ] === 'dynamic' ){
		$is_dynamic = true;
	}else if( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_element_data_option' ] ) && $settings[ GRAPHINA_PREFIX . $chart_type . '_element_data_option' ] === 'dynamic' ){
		$is_dynamic = true;
	}
	if ( $is_dynamic === true && graphina_common_setting_get('enable_chart_filter') === 'on' ) {
		graphina_get_template(
			'chart-loader.php',
			array(
				'element_id' => $chart_data['element_id'],
				'loader'     => $chart_data['loader'],
			)
		);
	} ?>
</div>
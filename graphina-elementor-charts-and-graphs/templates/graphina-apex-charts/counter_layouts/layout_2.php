<?php
/**
*
*   The template for displaying layout 2 \*
*   @link [https://codex.wordpress.org/Template\_Hierarchy](https://codex.wordpress.org/Template_Hierarchy) \*
*   @package graphina
**/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="graphina-card counter layout_2">
	<div class="text-center" style="display: flex;justify-content: center;align-items: center;">
		<h2 class="count_number myGraphinaCounter count_number-pre-postfix-<?php echo esc_attr( $element_id ); ?>">
			<?php echo esc_html($prefix); ?>
		</h2>

		<h2 class="count_number myGraphinaCounter  count_number-<?php echo esc_attr( $element_id ); ?>" 
			data-start="<?php echo esc_attr( $counter_start ); ?>" 
			data-end="<?php echo esc_attr( $counter_end ); ?>" 
			data-speed="<?php echo esc_attr( $counter_speed ); ?>" 
			data-decimals="<?php echo esc_attr( $counter_decimal ); ?>">
			<?php echo number_format( floatval( $counter_start ), $counter_decimal ); ?>
		</h2>
		
		<h2 class="count_number myGraphinaCounter count_number-pre-postfix-<?php echo esc_attr( $element_id ); ?>">
			<?php echo esc_html($postfix); ?>
		</h2>
	</div>

	<h2 class="counter-title title <?php echo esc_attr( 'counter-title-' . $element_id ); ?>"><?php echo esc_html( $counter_title ); ?></h2>

	<?php if ( isset( $counter_description ) && ! empty( $counter_description ) ) : ?>
		<p class="counter-description description"><?php echo esc_html( $counter_description ); ?></p>
	<?php endif; ?>
	
	<div class= "<?php echo isset( $show_counter_chart ) && $show_counter_chart === true ? 'chart-box' : ''; ?>">
		<div class="graphina-elementor-chart"
			data-chart_type="<?php echo esc_html( $chart_type ); ?>"
			data-element_id="<?php echo esc_html( $element_id ); ?>"
			data-chart_options='<?php echo wp_json_encode( $chart_options ); ?>'
			data-responsive_options='<?php echo wp_json_encode( $responsive_options ); ?>'
			data-extra_data='<?php echo wp_json_encode( $extra_data ); ?>'
			data-settings='<?php echo esc_attr(wp_json_encode($element_settings)); ?>'>
		</div>
		
	</div>
   
</div>

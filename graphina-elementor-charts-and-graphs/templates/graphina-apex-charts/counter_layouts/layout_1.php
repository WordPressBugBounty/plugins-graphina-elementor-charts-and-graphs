<?php
/**
*
*   The template for displaying layout 1 \*
*   @link [https://codex.wordpress.org/Template\_Hierarchy](https://codex.wordpress.org/Template_Hierarchy) \*
*   @package graphina
**/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use Elementor\Icons_Manager;
?>
<div class="graphina-card counter layout_1">
	<?php if ( isset( $counter_icon ) && ! empty( $counter_icon ) ) : ?>
		<div class="counter-icon part-1">
			<?php Icons_Manager::render_icon( $settings[ GRAPHINA_PREFIX . $chart_type . '_element_counter_icon' ], array( 'aria-hidden' => 'true' ) ); ?>
		</div>
	<?php endif; ?>

	<h2 class="count_number myGraphinaCounter count_number-pre-postfix-<?php echo esc_attr( $element_id ); ?>">
		<?php echo esc_html($prefix); ?>
	</h2>

	<h2 class="count_number myGraphinaCounter count_number-<?php echo esc_attr( $element_id ); ?>" 
		data-start="<?php echo esc_attr( $counter_start ); ?>" 
		data-end="<?php echo esc_attr( $counter_end ); ?>" 
		data-speed="<?php echo esc_attr( $counter_speed ); ?>" 
		data-decimals="<?php echo esc_attr( $counter_decimal ); ?>">
		<?php echo number_format( floatval( $counter_start ), $counter_decimal ); ?>
	</h2>

	<h2 class="count_number myGraphinaCounter count_number-pre-postfix-<?php echo esc_attr( $element_id ); ?>">
		<?php echo esc_html($postfix); ?>
	</h2>

	<?php if ( isset( $counter_title ) && ! empty( $counter_title ) ) : ?>
		<h4 class="counter-title title counter-title-<?php echo esc_attr( $element_id ); ?>"><?php echo esc_html( $counter_title ); ?></h4>
	<?php endif; ?>

	<?php if ( isset( $counter_description ) && ! empty( $counter_description ) ) : ?>
		<p class="counter-description description counter-description-<?php echo esc_attr( $element_id ); ?>"><?php echo esc_html( $counter_description ); ?></p>
	<?php endif; ?>

	<div class="chart-box">
		<div class="graphina-elementor-chart"
			data-chart_type="<?php echo esc_html( $chart_type ); ?>"
			data-element_id="<?php echo esc_html( $element_id ); ?>"
			data-chart_options='<?php echo wp_json_encode( $chart_options ); ?>'
			data-responsive_options='<?php echo wp_json_encode( $responsive_options ); ?>'
			data-extra_data='<?php echo wp_json_encode( $extra_data ); ?>'
			data-settings='<?php echo wp_json_encode( $element_settings ); ?>'>
		</div>
	</div>
	
</div>


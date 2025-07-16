
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
?><?php

$is_apex = '';
$is_google = '';
if ( ! empty( $chart_data['is_apex'] ) && $chart_data['is_apex'] ){
	$is_apex = 'apex';
}
if ( ! empty( $chart_data['is_google'] ) && $chart_data['is_google'] ){
	$is_google = 'google';
}

if ( ! empty( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_list' ] ) ) {
	?>
	<div class="graphina_chart_filter" id="graphina_chart_filter_<?php echo esc_attr( $element_id ); ?>" data-total_filter="<?php echo esc_attr( count( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_list' ] ) ); ?>">
		<?php
		foreach ( $settings[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_list' ] as $key => $value ) {
			if ( ! empty( $value[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_type' ] ) && $value[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_type' ] === 'date' ) {
				?>
				<div class="">
					<div>
						<label for="graphina-start-date_<?php echo esc_html( $key . $element_id ); ?>">
							<?php echo esc_html( ! empty( $value[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_value_label' ] ) ? $value[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_value_label' ] : '' ); ?>
						</label>
					</div>
					<?php
					if ( ! empty( $value[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_date_type' ] ) && $value[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_date_type' ] === 'date' ) {
						$default_date = ! empty( $value[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_date_default' ] ) ? $value[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_date_default' ] : current_time( 'Y-m-d h:i:s' );
						?>
						<div>
							<input type="date" id="graphina-start-date_<?php echo esc_html($key . $element_id); ?>" 
	   							class="graphina-chart-filter-date-time graphina_datepicker_<?php echo esc_html($element_id); ?> graphina_filter_select<?php echo esc_html($element_id); ?>" 
	   							value="<?php
									 echo esc_html(date('Y-m-d', strtotime($default_date)));
						 		?>">
						</div>
						<?php
					} else {
						$default_date = ! empty( $value[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_datetime_default' ] ) ? $value[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_datetime_default' ] : current_time( 'Y-m-d h:i:s' );
						?>
						<div>
								<input type="datetime-local" id="graphina-start-date_<?php echo esc_html($key . $element_id); ?>" 
		   								class="graphina-chart-filter-date-time graphina_datepicker_<?php echo esc_html($element_id); ?> graphina_filter_select<?php echo esc_html($element_id); ?>" 
		   								step="1"
		   								value="<?php echo esc_html(date('Y-m-d\TH:i:s', strtotime($default_date))); ?>">
							</div>
						<?php
					}
					?>
				</div>
				<?php
			} elseif ( ! empty( $value[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_value' ] ) && ! empty( $value[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_option' ] ) ) {
				$data        = explode( ',', $value[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_value' ] );
				$data_option = explode( ',', $value[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_option' ] );
				if ( ! empty( $data ) && is_array( $data ) && ! empty( $data_option ) && is_array( $data_option ) ) {
					?>
					<div class="graphina-filter-div">
						<div>
							<label for="graphina-drop_down_filter_<?php echo esc_html( $key . $element_id ); ?>">
								<?php echo esc_html( ! empty( $value[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_value_label' ] ) ? $value[ GRAPHINA_PREFIX . $chart_type . '_chart_filter_value_label' ] : '' ); ?>
							</label>
						</div>
						<div>
							<select class="form-select graphina_filter_select<?php echo esc_html( $element_id ); ?>"
								id="graphina-drop_down_filter_<?php echo esc_html( $key . $element_id ); ?>">
								<?php
								foreach ( $data as $key1 => $value1 ) {
									?>
									<option value="<?php echo esc_html( $value1 ); ?>" <?php echo esc_html( (int) $key1 === 0 ? 'selected' : '' ); ?>>
										<?php echo esc_html( isset( $data_option[ $key1 ] ) ? $data_option[ $key1 ] : '' ); ?>
									</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<?php
				}
			}
		}
		?>
		<div class="graphina-filter-div">
			<button class="graphina-filter-div-button <?php echo esc_attr($is_apex); echo esc_attr($is_google); ?>" type="button" id="grapina_apply_filter_<?php echo esc_html( $element_id ); ?>" data-element_id=<?php echo esc_attr( $element_id ); ?>>
				<?php echo esc_html__( 'Apply Filter', 'graphina-charts-for-elementor' ); ?>
			</button>
		</div>
	</div>
	<?php
}
?>
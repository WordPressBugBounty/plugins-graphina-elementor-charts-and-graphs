<?php

/**
 * Help admin page html.
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina
 */


// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Something went wrong' );
}
$pro_active = apply_filters( 'graphina_is_pro_active', false );

$apex_charts       = graphina_get_chart_name( 'apex' );
$google_charts     = graphina_get_chart_name( 'google' );
$table_charts      = graphina_get_chart_name( 'table' );
$all_fields        = array();
$apex_charts_field = array(
	// Area Chart
	array(
		'chart_name'  => __( 'Area Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/area-chart.svg',
		'widget'      => '["area_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	// Brush Chart
	array(
		'chart_name'  => __( 'Brush Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/brush-chart.svg',
		'widget'      => '["brush_chart"]',
		'pro_field'   => 'yes',
		'chart_class' => 'graphina-pro-module-widget',
	),
	// Bubble Chart
	array(
		'chart_name'  => __( 'Bubble Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/bubble-chart.svg',
		'widget'      => '["bubble_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	// Candle Chart
	array(
		'chart_name'  => __( 'Candle Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/candle-chart.svg',
		'widget'      => '["candle_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	// Counter Chart
	array(
		'chart_name'  => __( 'Counter Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/counter-chart.svg',
		'widget'      => '["counter_chart"]',
		'pro_field'   => 'yes',
		'chart_class' => 'graphina-pro-module-widget',
	),
	// Column Chart
	array(
		'chart_name'  => __( 'Column Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/column-chart.svg',
		'widget'      => '["column_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	// Distributed Column Chart
	array(
		'chart_name'  => __( 'Distributed Column Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/distributecolumn-chart.svg',
		'widget'      => '["distributed_column_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	// Donut Chart
	array(
		'chart_name'  => __( 'Donut Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/donut-chart.svg',
		'widget'      => '["donut_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	// Heatmap Chart
	array(
		'chart_name'  => __( 'Heatmap Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/heatmap-chart.svg',
		'widget'      => '["heatmap_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	// Line Chart
	array(
		'chart_name'  => __( 'Line Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/line-chart.svg',
		'widget'      => '["line_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	// Mixed Chart
	array(
		'chart_name'  => __( 'Mixed Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/mix-chart.svg',
		'widget'      => '["mixed_chart"]',
		'pro_field'   => 'yes',
		'chart_class' => 'graphina-pro-module-widget',
	),
	// Nested Column Chart
	array(
		'chart_name'  => __( 'Nested Column Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/nestedcolumn-chart.svg',
		'widget'      => '["nested_column_chart"]',
		'pro_field'   => 'yes',
		'chart_class' => 'graphina-pro-module-widget',

	),
	// Pie Chart
	array(
		'chart_name'  => __( 'Pie Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/pie-chart.svg',
		'widget'      => '["pie_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	// Polar Chart
	array(
		'chart_name'  => __( 'Polar Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/polar-chart.svg',
		'widget'      => '["polar_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	// Radar Chart
	array(
		'chart_name'  => __( 'Radar Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/radar-chart.svg',
		'widget'      => '["radar_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	// Radial Chart
	array(
		'chart_name'  => __( 'Radial Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/radial-chart.svg',
		'widget'      => '["radial_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	// Scatter Chart
	array(
		'chart_name'  => __( 'Scatter Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/scatter-chart.svg',
		'widget'      => '["scatter_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	// Timeline Chart
	array(
		'chart_name'  => __( 'Timeline Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/timeline-chart.svg',
		'widget'      => '["timeline_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
);

$all_fields = $apex_charts_field;

$google_charts_field = array(
	array(
		'chart_name'  => __( 'Area Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/area-chart.svg',
		'widget'      => '["area_google_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	array(
		'chart_name'  => __( 'Bar Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/bar-chart.svg',
		'widget'      => '["bar_google_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	array(
		'chart_name'  => __( 'Column Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/column-chart.svg',
		'widget'      => '["column_google_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	array(
		'chart_name'  => __( 'Donut Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/donut-chart.svg',
		'widget'      => '["donut_google_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	array(
		'chart_name'  => __( 'Geo Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/geo-chart.svg',
		'widget'      => '["geo_google_chart"]',
		'pro_field'   => 'yes',
		'chart_class' => 'graphina-pro-module-widget',
	),
	array(
		'chart_name'  => __( 'Gauge Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/gauge-chart.svg',
		'widget'      => '["gauge_google_chart"]',
		'pro_field'   => 'yes',
		'chart_class' => 'graphina-pro-module-widget',
	),
	array(
		'chart_name'  => __( 'Gantt Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/gantt-chart.svg',
		'widget'      => '["gantt_google_chart"]',
		'pro_field'   => 'yes',
		'chart_class' => 'graphina-pro-module-widget',
	),
	array(
		'chart_name'  => __( 'Line Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/line-chart.svg',
		'widget'      => '["line_google_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	array(
		'chart_name'  => __( 'Pie Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/pie-chart.svg',
		'widget'      => '["pie_google_chart"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
	array(
		'chart_name'  => __( 'Org Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/area-chart.svg',
		'widget'      => '["org_google_chart"]',
		'pro_field'   => 'yes',
		'chart_class' => 'graphina-pro-module-widget',
	),
);

$all_fields = array_merge( $all_fields, $google_charts_field );

$table_field = array(
	array(
		'chart_name'  => __( 'Advance Data Table', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/datatable-chart.svg',
		'widget'      => '["advance-datatable"]',
		'pro_field'   => 'yes',
		'chart_class' => 'graphina-pro-module-widget',
	),
	array(
		'chart_name'  => __( 'Jquery Data Table Chart', 'graphina-charts-for-elementor' ),
		'icon_url'    => GRAPHINA_URL . 'assets/admin/images/datatable-chart.svg',
		'widget'      => '["data_table_lite"]',
		'pro_field'   => 'no',
		'chart_class' => '',
	),
);
$all_fields  = array_merge( $all_fields, $table_field );

?>
<div class="graphina-tab-detail">
	<div class="chart-types">
		<input type="hidden" name="graphina-element-nonce" id="graphina-element-nonce" value="<?php echo esc_html( wp_create_nonce( 'ajax-nonce-element' ) ); ?>">
		<div class="">
			<h1><?php echo esc_html__( 'Graphina Chart Blocks', 'graphina-charts-for-elementor' ); ?></h1>
		</div>
		<div class="actions">
			<button class="graphina-btn graphina-btn-link graphina-btn-primary graphina-enable-all-apex-chart"><?php echo esc_html__( 'Enable All', 'graphina-charts-for-elementor' ); ?></button>
			<button class="graphina-btn graphina-btn-link graphina-btn-primary graphina-disable-all-apex-chart"><?php echo esc_html__( 'Disable All', 'graphina-charts-for-elementor' ); ?></button>
		</div>
	</div>

	<div class="graphina-admin-loader">
		<img src="<?php echo esc_url( GRAPHINA_URL . 'assets/admin/images/graphina-loader.svg' ); ?>" />
	</div>

	<div id="graphina-apex-chart">
		<div class="grapgine-title-section">
			<h2 class="title"><?php echo esc_html__( 'Apex Charts', 'graphina-charts-for-elementor' ); ?></h2>
		</div>

		<div class="chart-grid">
			<?php foreach ( $apex_charts_field as $value ) : ?>
				<?php
				if ( $pro_active === false && $value['pro_field'] === 'yes' ) {
					continue;}
				?>
				<div class="chart-item">
					<div class="chart-info">
						<div class="chart-icon">
							<img src="<?php echo esc_url( $value['icon_url'] ); ?>" />
						</div>
						<div class="chart-name">
							<?php echo esc_html( $value['chart_name'] ); ?>
							<?php if ( $value['pro_field'] === 'yes' ) : ?>
								<span class="pro-badge"><?php echo esc_html__( 'Pro', 'graphina-charts-for-elementor' ); ?></span>
							<?php endif; ?>
						</div>
					</div>
					<label class="toggle graphina-apex-toggle" data-widget="<?php echo esc_attr( $value['widget'] ); ?>">
						<input type="checkbox" checked>
						<span class="toggle-slider"></span>
					</label>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<div id="graphina-google-chart">
		<div class="grapgine-title-section">
			<h2 class="title"><?php echo esc_html__( 'Google Charts', 'graphina-charts-for-elementor' ); ?></h2>
		</div>

		<div class="chart-grid">
			<?php foreach ( $google_charts_field as $value ) : ?>
				<?php
				if ( $pro_active === false && $value['pro_field'] === 'yes' ) {
					continue;}
				?>
				<div class="chart-item">
					<div class="chart-info">
						<div class="chart-icon">
							<img src="<?php echo esc_url( $value['icon_url'] ); ?>" />
						</div>
						<div class="chart-name">
							<?php echo esc_html( $value['chart_name'] ); ?>
							<?php if ( $value['pro_field'] === 'yes' ) : ?>
								<span class="pro-badge"><?php echo esc_html__( 'Pro', 'graphina-charts-for-elementor' ); ?></span>
							<?php endif; ?>
						</div>
					</div>
					<label class="toggle graphina-apex-toggle" data-widget="<?php echo esc_attr( $value['widget'] ); ?>">
						<input type="checkbox" checked>
						<span class="toggle-slider"></span>
					</label>
				</div>
			<?php endforeach; ?>

		</div>
	</div>

	<div id="graphina-table">
		<div class="grapgine-title-section">
			<h2 class="title"><?php echo esc_html__( 'Data table', 'graphina-charts-for-elementor' ); ?></h2>
		</div>

		<div class="chart-grid">

			<?php foreach ( $table_field as $value ) : ?>
				<?php
				if ( $pro_active === false && $value['pro_field'] === 'yes' ) {
					continue;}
				?>
				<div class="chart-item">
					<div class="chart-info">
						<div class="chart-icon">
							<img src="<?php echo esc_url( $value['icon_url'] ); ?>" />
						</div>
						<div class="chart-name">
							<?php echo esc_html( $value['chart_name'] ); ?>
							<?php if ( $value['pro_field'] === 'yes' ) : ?>
								<span class="pro-badge"><?php echo esc_html__( 'Pro', 'graphina-charts-for-elementor' ); ?></span>
							<?php endif; ?>
						</div>
					</div>
					<label class="toggle graphina-apex-toggle" data-widget="<?php echo esc_attr( $value['widget'] ); ?>">
						<input type="checkbox" checked>
						<span class="toggle-slider"></span>
					</label>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<div id="graphina-pro-elements">
		<div class="grapgine-title-section">
			<h2 class="title"><?php echo esc_html__( 'Graphina Pro Elements', 'graphina-charts-for-elementor' ); ?></h2>
		</div>

		<div class="chart-grid">
			<?php foreach ( $all_fields as $value ) : ?>
				<?php
				if ( $pro_active === false && $value['pro_field'] === 'yes' ) :
					?>
				<div class="chart-item <?php echo esc_attr( $value['chart_class'] ); ?>">
					<div class="chart-info">
						<div class="chart-icon">
							<img src="<?php echo esc_url( $value['icon_url'] ); ?>" />
						</div>
						<div class="chart-name">
							<?php echo esc_html( $value['chart_name'] ); ?>
							<?php if ( $value['pro_field'] === 'yes' ) : ?>
								<span class="pro-badge"><?php echo esc_html__( 'Pro', 'graphina-charts-for-elementor' ); ?></span>
							<?php endif; ?>
						</div>
					</div>
					<label class="graphina-toggle">
						<input type="checkbox" >
						<span class="toggle-slider"></span>
					</label>
				</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</div>
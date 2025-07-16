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
?>
<div id="free-vs-pro-tab" class="graphina-tab-detail">
	<div class="grapgine-title-section">
		<h1><?php echo esc_html__( 'Free VS Pro', 'graphina-charts-for-elementor' ); ?></h1>
		<p><?php echo esc_html__( 'Discover all the diffrences between the free and premium versions.', 'graphina-charts-for-elementor' ); ?></p>
	</div>
	<div class="graphina-container">
		<table class="graphina-table">
			<tr>
				<th><?php echo esc_html__( 'Features', 'graphina-charts-for-elementor' ); ?></th>
				<th><?php echo esc_html__( 'Free', 'graphina-charts-for-elementor' ); ?></th>
				<th><?php echo esc_html__( 'Pro', 'graphina-charts-for-elementor' ); ?></th>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Multiple Chart Types', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Google Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Customizable Chart Styles', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Chart Filters', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Google Sheets Integration', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'API Integration', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'CSV Integration', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>            
			<tr>
				<td><?php echo esc_html__( 'Remote CSV Integration', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'MySQL Database Integration', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'External Database Integration', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Restricted Chart Access', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'CSV Seperator', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Chart Loader', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
		</table>

		<table class="graphina-table">
			<tr>
				<th><?php echo esc_html__( 'Charts', 'graphina-charts-for-elementor' ); ?></th>
				<th><?php echo esc_html__( 'Free', 'graphina-charts-for-elementor' ); ?></th>
				<th><?php echo esc_html__( 'Pro', 'graphina-charts-for-elementor' ); ?></th>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Area Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'bubble Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Candle Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Column Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Distribute Column Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Donut Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'jQuery Data Table', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Heatmap Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>

			<tr>
				<td><?php echo esc_html__( 'Line Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Pie Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Polar Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Radar Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Radial Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Scatter Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Timeline Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Nested Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Mixed Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Counter Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Brush Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>

			<tr>
				<td><?php echo esc_html__( 'Area Google Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon  graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Bar Google Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon  graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Column Google Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon  graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Donut Google Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon  graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Line Google Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon  graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Pie Google Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon  graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Geo Google Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Gauge Google Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Gantt Google Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Org Google Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Advanced Data Table', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-cross">✘</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
			<tr>
				<td><?php echo esc_html__( 'Tree Apex Chart', 'graphina-charts-for-elementor' ); ?></td>
				<td class="graphina-icon graphina-check">✔</td>
				<td class="graphina-icon graphina-check">✔</td>
			</tr>
		</table>
	</div>
</div>
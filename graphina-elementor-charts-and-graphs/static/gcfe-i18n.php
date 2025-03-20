<?php
// Prevent direct access to this file for security.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Something went wrong' );
}

/**
 * Filter: gcfe_localize_graphina_settings
 *
 * This filter allows modification of the localized settings data for the Graphina plugin.
 * The added settings include custom SweetAlert messages and labels that can be used in the plugin's UI.
 *
 * @param array $settings The existing localized settings data.
 * @return array Modified settings with additional or overridden SweetAlert labels.
 */
add_filter(
	'gcfe_localize_graphina_settings',
	function ( $settings ) {
		// Define additional localized settings for SweetAlert messages.
		$settings['i18n'] = array(
			'swal_are_you_sure_text' => esc_html__( 'Are you sure?', 'graphina-charts-for-elementor' ),
			'swal_revert_this_text'  => esc_html__( 'You won\'t be able to revert this!', 'graphina-charts-for-elementor' ),
			'swal_delete_text'       => esc_html__( 'Yes, delete it!', 'graphina-charts-for-elementor' ),
			'swal_ok_text'           => esc_html__( 'OK', 'graphina-charts-for-elementor' ),
		);
		return $settings;
	}
);

/**
 * Filter to customize the default category labels for Graphina charts.
 *
 * This filter defines the default categories used in Graphina charts, specifically the abbreviated month names.
 * It allows developers to modify the default category array for localization or customization needs.
 *
 * @param array $category The array of default categories for charts.
 * @return array The modified array of default categories.
 */
add_filter(
	'gcfe_default_category',
	function ( $category ) {
		$category = array(
			esc_html__( 'Jan', 'graphina-charts-for-elementor' ),
			esc_html__( 'Feb', 'graphina-charts-for-elementor' ),
			esc_html__( 'Mar', 'graphina-charts-for-elementor' ),
			esc_html__( 'Apr', 'graphina-charts-for-elementor' ),
			esc_html__( 'May', 'graphina-charts-for-elementor' ),
			esc_html__( 'Jun', 'graphina-charts-for-elementor' ),
			esc_html__( 'July', 'graphina-charts-for-elementor' ),
			esc_html__( 'Aug', 'graphina-charts-for-elementor' ),
			esc_html__( 'Sep', 'graphina-charts-for-elementor' ),
			esc_html__( 'Oct', 'graphina-charts-for-elementor' ),
			esc_html__( 'Nov', 'graphina-charts-for-elementor' ),
			esc_html__( 'Dec', 'graphina-charts-for-elementor' ),
		);
		return $category;
	}
);

/**
 * Filter to define localization options for Graphina charts.
 *
 * This filter provides a comprehensive set of localization settings for Graphina charts.
 * Developers can override the default options, such as toolbar text, month names, day names, and their abbreviations.
 * These settings are essential for adapting the plugin to different languages and regions.
 *
 * @param array $options The array of default localization settings.
 * @return array The modified array of localization settings.
 */
add_filter(
	'gcfe_chart_locales_options',
	function ( $options ) {
		$options = array(
			'toolbar'     => array(
				'download'      => esc_html__( 'Download SVG', 'graphina-charts-for-elementor' ),
				'selection'     => esc_html__( 'Selection', 'graphina-charts-for-elementor' ),
				'selectionZoom' => esc_html__( 'Selection Zoom', 'graphina-charts-for-elementor' ),
				'zoomIn'        => esc_html__( 'Zoom In', 'graphina-charts-for-elementor' ),
				'zoomOut'       => esc_html__( 'Zoom Out', 'graphina-charts-for-elementor' ),
				'pan'           => esc_html__( 'Panning', 'graphina-charts-for-elementor' ),
				'reset'         => esc_html__( 'Reset Zoom', 'graphina-charts-for-elementor' ),
				'menu'          => esc_html__( 'Menu', 'graphina-charts-for-elementor' ),
				'exportToSVG'   => esc_html__( 'Download SVG', 'graphina-charts-for-elementor' ),
				'exportToPNG'   => esc_html__( 'Download PNG', 'graphina-charts-for-elementor' ),
				'exportToCSV'   => esc_html__( 'Download CSV', 'graphina-charts-for-elementor' ),
			),
			'months'      => array(
				esc_html__( 'January', 'graphina-charts-for-elementor' ),
				esc_html__( 'February', 'graphina-charts-for-elementor' ),
				esc_html__( 'March', 'graphina-charts-for-elementor' ),
				esc_html__( 'April', 'graphina-charts-for-elementor' ),
				esc_html__( 'May', 'graphina-charts-for-elementor' ),
				esc_html__( 'June', 'graphina-charts-for-elementor' ),
				esc_html__( 'July', 'graphina-charts-for-elementor' ),
				esc_html__( 'August', 'graphina-charts-for-elementor' ),
				esc_html__( 'September', 'graphina-charts-for-elementor' ),
				esc_html__( 'October', 'graphina-charts-for-elementor' ),
				esc_html__( 'November', 'graphina-charts-for-elementor' ),
				esc_html__( 'December', 'graphina-charts-for-elementor' ),
			),
			'shortMonths' => array(
				esc_html__( 'Jan', 'graphina-charts-for-elementor' ),
				esc_html__( 'Feb', 'graphina-charts-for-elementor' ),
				esc_html__( 'Mar', 'graphina-charts-for-elementor' ),
				esc_html__( 'Apr', 'graphina-charts-for-elementor' ),
				esc_html__( 'May', 'graphina-charts-for-elementor' ),
				esc_html__( 'Jun', 'graphina-charts-for-elementor' ),
				esc_html__( 'Jul', 'graphina-charts-for-elementor' ),
				esc_html__( 'Aug', 'graphina-charts-for-elementor' ),
				esc_html__( 'Sep', 'graphina-charts-for-elementor' ),
				esc_html__( 'Oct', 'graphina-charts-for-elementor' ),
				esc_html__( 'Nov', 'graphina-charts-for-elementor' ),
				esc_html__( 'Dec', 'graphina-charts-for-elementor' ),
			),
			'days'        => array(
				esc_html__( 'Sunday', 'graphina-charts-for-elementor' ),
				esc_html__( 'Monday', 'graphina-charts-for-elementor' ),
				esc_html__( 'Tuesday', 'graphina-charts-for-elementor' ),
				esc_html__( 'Wednesday', 'graphina-charts-for-elementor' ),
				esc_html__( 'Thursday', 'graphina-charts-for-elementor' ),
				esc_html__( 'Friday', 'graphina-charts-for-elementor' ),
				esc_html__( 'Saturday', 'graphina-charts-for-elementor' ),
			),
			'shortDays'   => array(
				esc_html__( 'Sun', 'graphina-charts-for-elementor' ),
				esc_html__( 'Mon', 'graphina-charts-for-elementor' ),
				esc_html__( 'Tue', 'graphina-charts-for-elementor' ),
				esc_html__( 'Wed', 'graphina-charts-for-elementor' ),
				esc_html__( 'Thu', 'graphina-charts-for-elementor' ),
				esc_html__( 'Fri', 'graphina-charts-for-elementor' ),
				esc_html__( 'Sat', 'graphina-charts-for-elementor' ),
			),
		);
		return $options;
	}
);

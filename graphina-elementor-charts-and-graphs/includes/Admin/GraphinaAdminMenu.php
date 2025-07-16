<?php

namespace Graphina\Admin;

// Prevent direct access to the file
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check if the class already exists to avoid re-declaration
if ( ! class_exists( 'GraphinaAdminMenu' ) ) {

	/**
	 * Class GraphinaAdminMenu
	 * Handles the admin menu functionality for the Graphina plugin.
	 */
	class GraphinaAdminMenu {

		/**
		 * Output the admin menu.
		 * Determines the current active tab, loads assets, and renders the menu.
		 */
		public static function output() {
			// Get the current active tab
			$current_tab = self::get_current_tab();

			// Hook for additional actions at the start of the menu
			do_action( 'wpbit_menu_start' );

			// Enqueue required admin CSS assets
			self::load_assets();

			// Retrieve and sort menu items
			$menu_items = self::get_sorted_menu_items();

			// Group menu items by their group key
			$tabs = self::group_menu_items_by_group( $menu_items );

			// Include the template to render the admin menu
			self::render_admin_menu( $tabs, $current_tab );
		}

		/**
		 * Get the current active tab.
		 *
		 * @return string Active tab slug. Defaults to 'setting' if not set.
		 */
		private static function get_current_tab() {
			return isset( $_GET['activetab'] ) ? sanitize_text_field( $_GET['activetab'] ) : 'setting';
		}

		/**
		 * Enqueue CSS assets for the admin menu.
		 */
		public static function load_assets() {
			wp_enqueue_style(
				'graphina-custom-admin-css',
				plugin_dir_url( __FILE__ ) . '../../assets/admin/css/graphina-custom-admin.css',
				array(),
				GRAPHINA_VERSION // Plugin version for cache-busting
			);
		}

		/**
		 * Get and sort the menu items by their priority.
		 *
		 * @return array Sorted menu items.
		 */
		private static function get_sorted_menu_items() {
			// Allow filtering of menu items by other plugins or themes
			$menu_items = apply_filters( 'graphina_menu_tabs_array', array() );

			// Sort menu items using the defined priority
			uasort( $menu_items, array( __CLASS__, 'sort_menu_items_by_priority' ) );

			return $menu_items;
		}

		/**
		 * Sort menu items based on their priority.
		 *
		 * @param array $a First menu item.
		 * @param array $b Second menu item.
		 * @return int Comparison result for sorting.
		 */
		private static function sort_menu_items_by_priority( $a, $b ) {
			return ( $a['priority'] ?? 0 ) - ( $b['priority'] ?? 0 );
		}

		/**
		 * Group menu items by their group key.
		 * This allows tabs to be categorized and displayed together.
		 *
		 * @param array $menu_items Array of menu items.
		 * @return array Grouped menu items.
		 */
		private static function group_menu_items_by_group( $menu_items ) {
			$tabs = array();

			// Group items by the 'group' key, defaulting to 'default'
			foreach ( $menu_items as $slug => $menu_item ) {
				$group                   = $menu_item['group'] ?? 'default';
				$tabs[ $group ][ $slug ] = $menu_item;
			}

			return $tabs;
		}

		/**
		 * Render the admin menu template.
		 *
		 * @param array  $tabs        Grouped menu items for rendering.
		 * @param string $current_tab The currently active tab.
		 */
		private static function render_admin_menu( $tabs, $current_tab ) {
			// Include the admin menu template file
			include GRAPHINA_PATH . '/includes/Admin/Menu/views/html-admin-menu.php';
		}
	}
}

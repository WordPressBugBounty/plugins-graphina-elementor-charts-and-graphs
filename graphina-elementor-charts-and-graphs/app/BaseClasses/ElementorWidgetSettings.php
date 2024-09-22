<?php
/**
 * AdminController class load all admin ajax routes
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina_Charts_For_Elementor
 */

namespace GraphinaElementor\App\BaseClasses;

use Elementor\Plugin;
use Elementor\Utils;

/**
 * Class ElementorWidgetSettings
 *
 * This class is responsible for retrieving and managing settings of Elementor widgets.
 */
class ElementorWidgetSettings {

	/**
	 * The post ID where the Elementor widget is located.
	 *
	 * @var int
	 */
	public int $post_id;

	/**
	 * The ID of the Elementor widget.
	 *
	 * @var string
	 */
	public string $widget_id;

	/**
	 * The data of the widget retrieved from Elementor.
	 *
	 * @var mixed
	 */
	public mixed $widget_data = null;

	/**
	 * The default settings for the widget if none are found in the document.
	 *
	 * @var array
	 */
	public array $default_settings = array();

	/**
	 * ElementorWidgetSettings constructor.
	 *
	 * Initializes the class with the post ID, widget ID, and default settings. It also fetches the widget data.
	 *
	 * @param int    $post_id         The ID of the post/page.
	 * @param string $widget_id       The ID of the widget.
	 * @param array  $default_settings The default settings for the widget.
	 */
	public function __construct( int $post_id, string $widget_id, array $default_settings ) {

		// Initialize class properties.
		$this->post_id          = $post_id;
		$this->widget_id        = $widget_id;
		$this->default_settings = $default_settings;

		// Fetch the widget data.
		$this->set_widget_data();
	}

	/**
	 * Retrieve the Elementor Plugin instance.
	 *
	 * @return Plugin
	 */
	public function elementor(): Plugin {

		return Plugin::$instance;
	}

	/**
	 * Set widget data for the given post and widget ID.
	 *
	 * This method fetches the Elementor document and finds the specific widget data within it.
	 */
	public function set_widget_data(): void {
		// Get the Elementor document for the specified post.
		$document = $this->elementor()->documents->get( $this->post_id );

		if ( $document ) {
			// Find widget data recursively in the document.
			$widget_data = Utils::find_element_recursive( $document->get_elements_data( 'draft' ), $this->widget_id );

			// Set widget data if found.
			if ( $widget_data ) {
				$this->widget_data = $widget_data;
			}
		}
	}

	/**
	 * Retrieve the settings of the widget for display.
	 *
	 * This method switches to the specified post, retrieves the widget's settings, and restores the post context.
	 *
	 * @return array The settings of the widget or the default settings if widget data is not found.
	 */
	public function get_settings(): array {

		// Return default settings if no widget data is set.
		if ( ! $this->widget_data ) {
			return $this->default_settings;
		}

		// Switch to the post context for the Elementor document.
		$this->elementor()->db->switch_to_post( $this->post_id );

		// Create the widget instance and retrieve its settings.
		$widget = $this->elementor()->elements_manager->create_element_instance( $this->widget_data );

		// Get settings prepared for display.
		$settings = $widget->get_settings_for_display();

		// Restore the original post context.
		$this->elementor()->db->restore_current_post();

		return is_array( $settings ) ? $settings : $this->default_settings;
	}
}

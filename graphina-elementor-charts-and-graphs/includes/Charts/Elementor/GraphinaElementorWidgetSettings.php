<?php
/**
 *
 * @link  https://iqonic.design
 *
 * @package    Graphina_Charts_For_Elementor
 */

namespace Graphina\Charts\Elementor;

use Elementor\Plugin;
use Elementor\Utils;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class GraphinaElementorWidgetSettings
 *
 * Handles the retrieval and processing of Elementor widget settings.
 *
 * @package Graphina\Charts\Elementor
 */
class GraphinaElementorWidgetSettings {

	/**
	 * The ID of the post where the widget resides.
	 *
	 * @var int
	 */
	private int $post_id;

	/**
	 * The unique ID of the widget.
	 *
	 * @var string
	 */
	private string $widget_id;

	/**
	 * Raw data of the widget retrieved from Elementor.
	 *
	 * @var mixed
	 */
	private mixed $widget_data = null;

	/**
	 * Default widget settings if none are found.
	 *
	 * @var array
	 */
	private array $default_settings;

	/**
	 * Constructor.
	 *
	 * @param int    $post_id The post ID.
	 * @param string $widget_id The widget ID.
	 * @param array  $default_settings Default widget settings.
	 */
	public function __construct( int $post_id, string $widget_id, array $default_settings ) {
		$this->post_id          = $post_id;
		$this->widget_id        = $widget_id;
		$this->default_settings = $default_settings;

		// Initialize widget data.
		$this->set_widget_data();
	}

	/**
	 * Retrieve the Elementor plugin instance.
	 *
	 * @return Plugin The Elementor plugin instance.
	 */
	private function elementor(): Plugin {
		return Plugin::$instance;
	}

	/**
	 * Fetch widget data for the specified post and widget ID.
	 *
	 * Uses Elementor's document API to retrieve widget data.
	 */
	private function set_widget_data(): void {
		$document = $this->elementor()->documents->get( $this->post_id );
		if ( $document ) {
			$widget_data = Utils::find_element_recursive(
				$document->get_elements_data( 'draft' ),
				$this->widget_id
			);
			if ( $widget_data ) {
				$this->widget_data = $widget_data;
			}
		}
	}

	/**
	 * Retrieve widget settings prepared for display.
	 *
	 * Fetches settings for the widget and resolves dynamic data (e.g., ACF fields).
	 *
	 * @return array The widget settings or default settings if none are found.
	 */
	public function get_settings(): array {
		if ( ! $this->widget_data ) {
			return $this->default_settings;
		}

		$this->elementor()->db->switch_to_post( $this->post_id );

		$widget   = $this->elementor()->elements_manager->create_element_instance( $this->widget_data );
		$settings = $widget->get_settings_for_display();
		$settings = $this->resolve_acf_dynamic_data( $settings );

		$this->elementor()->db->restore_current_post();
		return is_array( $settings ) ? $settings : $this->default_settings;
	}

	/**
	 * Resolve dynamic ACF data within the widget settings.
	 *
	 * Handles the replacement of ACF shortcode placeholders with actual field values.
	 *
	 * @param mixed $data The settings data to resolve.
	 * @return mixed The resolved data.
	 */
	private function resolve_acf_dynamic_data( $data ) {
		if ( is_array( $data ) ) {
			foreach ( $data as $key => $value ) {
				$data[ $key ] = $this->resolve_acf_dynamic_data( $value );
			}
		} elseif ( is_string( $data ) && strpos( $data, '[elementor-tag' ) !== false ) {
			preg_match( '/settings="([^"]+)"/', $data, $matches );
			if ( ! empty( $matches[1] ) ) {
				$settings      = json_decode( urldecode( $matches[1] ), true );
				$acf_field_key = $settings['key'] ?? $settings['custom_key'] ?? '';
				$acf_field_key = explode( ':', $acf_field_key )[0];
				if ( function_exists( 'get_field' ) ) {
					$data = get_field( $acf_field_key, $this->post_id );
				}
			}
		}
		return $data;
	}
}

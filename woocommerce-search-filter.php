<?php
/**
 * Plugin Name: WooCommerce Search Filter
 * Description: This is a filter plugin for WooCommerce, built with AlpineJS.
*/

class WooCommerce_Search_Filter {

	public static function instance() {
		return new self();
	}

	private function __construct() {
		require_once __DIR__ . '/vendor/autoload.php';

		$this->define_constants();
		$this->load_classes();
	}

	private function load_classes() {
		new WS_Filter\Shortcode();
		new WS_Filter\Enqueue();
		new WS_Filter\Ajax();
	}

	private function define_constants() {
		define( 'WS_FILTER__URL', plugin_dir_url( __FILE__ ) );
	}
}

WooCommerce_Search_Filter::instance();

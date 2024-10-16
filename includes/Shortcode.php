<?php
/**
 * Shortcode for frontend.
 */

namespace WS_Filter;

class Shortcode {

	public function __construct() {
		add_shortcode( 'search-filter', array( $this, 'search_filter_shortcode' ) );
	}

	public function search_filter_shortcode() {
		wp_enqueue_style( 'ws-filter-style' );
		wp_enqueue_script( 'ws-filter-alpine' );

		ob_start();

		include __DIR__ . '/templates/search-filter.php';

		return ob_get_clean();
	}
}

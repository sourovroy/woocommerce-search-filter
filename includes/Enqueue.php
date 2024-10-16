<?php
/**
 * Enqueue CSS and JS.
 */

namespace WS_Filter;

class Enqueue {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );

	}

	public function wp_enqueue_scripts() {
		wp_register_style( 'ws-filter-style', WS_FILTER__URL . 'assets/css/style.css' );
		wp_register_script( 'ws-filter-alpine', WS_FILTER__URL . 'assets/js/alpine-cdn.min.js' );

		wp_localize_script( 'ws-filter-alpine', 'WS_Filter', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
		) );
	}
}

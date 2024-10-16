<?php
/**
 * For ajax functionality.
 */

namespace WS_Filter;

use WC_Product_Query;

class Ajax {
	public function __construct() {
		add_action( 'wp_ajax_ws_filter_get_search_items', array( $this, 'get_search_items' ) );
		add_action( 'wp_ajax_nopriv_ws_filter_get_search_items', array( $this, 'get_search_items' ) );
	}

	public function get_search_items() {
		$query = new WC_Product_Query( array(
			'limit' => 10,
		) );

		$products = array();

		foreach ( $query->get_products() as $product ) {
			$products[] = array(
				'id' => $product->get_id(),
				'name' => $product->get_name(),
			);
		}

		wp_send_json_success(
			$products
		);
	}
}

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

		add_action( 'wp_ajax_ws_filter_get_categories', array( $this, 'get_categories' ) );
		add_action( 'wp_ajax_nopriv_ws_filter_get_categories', array( $this, 'get_categories' ) );
	}

	public function get_search_items() {
		$search = '';
		$cat_id = '';

		if ( isset( $_GET['search'] ) ) {
			$search = sanitize_text_field( wp_unslash( $_GET['search'] ) );
		}
		if ( isset( $_GET['cat_id'] ) ) {
			$cat_id = absint( wp_unslash( $_GET['cat_id'] ) );
		}

		$args = array(
			'limit' => 9,
		);

		if ( ! empty( $search ) ) {
			$args['s'] = $search;
		}

		if ( ! empty( $cat_id ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'product_cat',
					'field' => 'term_id',
					'terms' => $cat_id,
				),
			);
		}


		$cache_key = 'ws_filter_cache_' . $cat_id . '_' . $search;

		$products = get_transient( $cache_key );

		if ( $products === false ) {
			error_log('query run');
			$query = new WC_Product_Query( $args );

			$products = array();

			foreach ( $query->get_products() as $product ) {
				$products[] = array(
					'id'        => $product->get_id(),
					'name'      => $product->get_name(),
					'image'     => $product->get_image(),
					'permalink' => $product->get_permalink(),
				);
			}

			set_transient( $cache_key, $products, (60 * 60) );
		}

		wp_send_json_success( $products );
	}

	public function get_categories() {
		$terms = get_terms( array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => true,
		) );

		$items = array();

		foreach ( $terms as $term ) {
			$items[] = array(
				'id' => $term->term_id,
				'name' => $term->name,
			);
		}

		wp_send_json( $items );
	}
}

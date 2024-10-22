<?php
/**
 * Caching functionality
 */

namespace WS_Filter;

class Cache {

	public function __construct() {
		add_action( 'woocommerce_delete_product_transients', array( $this, 'clear_cache' ) );
		add_action( 'wp_trash_post', array( $this, 'clear_cache_after_delete' ) );
	}

	public function clear_cache() {
		global $wpdb;

		$table_name = $wpdb->prefix . "options";

		$sql = "DELETE FROM `{$table_name}` WHERE `option_name` LIKE '%ws_filter_cache%';";

		$wpdb->query( $sql );
	}

	public function clear_cache_after_delete( $post_id ) {
		if ( get_post_type( $post_id ) == 'product' ) {
			$this->clear_cache();
		}
	}
}

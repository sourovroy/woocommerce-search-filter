<?php
/**
 * Caching functionality
 */

namespace WS_Filter;

class Cache {

	public function __construct() {
		add_action( 'woocommerce_update_product', array( $this, 'clear_cache' ) );
		add_action( 'woocommerce_new_product', array( $this, 'clear_cache' ) );
		add_action( 'woocommerce_delete_product', array( $this, 'clear_cache' ) );
		add_action( 'woocommerce_trash_product', array( $this, 'clear_cache' ) );
		add_action( 'wp_trash_post', array( $this, 'clear_cache' ) );
	}

	public function clear_cache() {
		global $wpdb;

		$table_name = $wpdb->prefix . "options";

		$sql = "DELETE FROM `{$table_name}` WHERE `option_name` LIKE '%ws_filter_cache%';";

		$wpdb->query( $sql );
	}
}

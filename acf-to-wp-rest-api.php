<?php
/**
 * Plugin Name: ACF to WP REST API
 * Description: Get all ACF fields in WP REST API responses.
 * Author: Aires Gonçalves
 * Author URI: airesvsg.github.com
 * Version: 1.2
 * Plugin URI: airesvsg.github.com/acf-to-wp-rest-api
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ACF_To_WP_REST_API' ) ) {

	class ACF_To_WP_REST_API {

		private static $CLASSES = array( 'base', 'post', 'user', 'term', 'comment', 'attachment', 'options', 'custom-post-type' );

		public function __construct() {
			add_action( 'init', array( $this, 'includes' ), 90 );
		}

		public function includes() {
			foreach ( self::$CLASSES as $class ) {
				require_once "includes/class-acf-to-wp-rest-api-{$class}.php";
			}
		}

	}

}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( is_plugin_active( 'advanced-custom-fields/acf.php' ) || is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) || is_plugin_active( 'acf-pro/acf.php' ) ) {
	new ACF_To_WP_REST_API();
}
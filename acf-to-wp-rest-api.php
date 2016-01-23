<?php
/**
 * Plugin Name: ACF to WP REST API
 * Description: Get all ACF fields in WP REST API responses.
 * Author: Aires Gonçalves
 * Author URI: http://github.com/airesvsg
 * Version: 1.3
 * Plugin URI: http://github.com/airesvsg/acf-to-wp-rest-api
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ACF_To_WP_REST_API' ) ) {

	class ACF_To_WP_REST_API {

		private static $CLASSES = array( 'base', 'post', 'page', 'user', 'term', 'comment', 'attachment', 'options', 'custom-post-type' );

		public function __construct() {
			add_action( 'init', array( $this, 'includes' ), 90 );
		}

		public function includes() {
			if ( ! class_exists( 'ACF_to_REST_API' ) ) {
				add_action( 'admin_notices', array( __CLASS__, 'admin_notices' ) );
			}

			foreach ( self::$CLASSES as $class ) {
				require_once "includes/classes/class-acf-to-wp-rest-api-{$class}.php";
			}
		}

		public static function admin_notices() {
			include_once 'includes/admin/views/html-notice-upgrade.php';
		}

	}

}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( is_plugin_active( 'advanced-custom-fields/acf.php' ) || is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) || is_plugin_active( 'acf-pro/acf.php' ) ) {
	new ACF_To_WP_REST_API();
}
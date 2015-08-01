<?php
/**
 * Plugin Name: ACF to WP REST API
 * Description: Get all ACF fields in WP REST API responses.
 * Author: Aires Gonçalves
 * Author URI: airesvsg.github.com
 * Version: 0.0.1
 * Plugin URI: airesvsg.github.com/acf-to-wp-rest-api
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ACF_To_WP_REST_API' ) ) {

	class ACF_To_WP_REST_API {

		private static $CLASSES = array( 'base', 'post', 'user', 'term', 'comment', 'attachment', 'options' );

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

new ACF_To_WP_REST_API();
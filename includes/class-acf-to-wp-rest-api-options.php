<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ACF_To_WP_REST_API_Options' ) ) {
	class ACF_To_WP_REST_API_Options extends ACF_To_WP_REST_API_Base {

		public function register_routes( $routes ) {
			$routes['/acf/options'] = array( 
				array( array( __CLASS__, 'get_options' ), WP_JSON_Server::READABLE ),
			);

			return $routes;
		}

		public static function get_options() {
			if ( $options = get_fields( 'option' ) ) {
				return $options;
			}
			return array();
		}

	}
}

new ACF_To_WP_REST_API_Options();
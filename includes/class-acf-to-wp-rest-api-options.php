<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ACF_To_WP_REST_API_Options' ) ) {
	class ACF_To_WP_REST_API_Options extends ACF_To_WP_REST_API_Base {

		public function register_routes( $routes ) {
			$routes["/acf/{$this->type}"] = array( 
				array( array( __CLASS__, 'get_options' ), WP_JSON_Server::READABLE ),
			);

			$routes["/acf/{$this->type}/(?P<name>[\w\-\_]+)"] = array( 
				array( array( __CLASS__, 'get_options' ), WP_JSON_Server::READABLE ),
			);
			
			return $routes;
		}

		public static function get_options( $name = NULL ) {
			if ( $name ) {
				$option = get_field( $name, 'option' );
				return array( $name => $option );
			} else {
				return get_fields( 'option' );
			}
		}

	}
}

new ACF_To_WP_REST_API_Options();
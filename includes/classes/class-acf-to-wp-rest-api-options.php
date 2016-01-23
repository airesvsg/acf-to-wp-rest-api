<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ACF_To_WP_REST_API_Options' ) ) {
	class ACF_To_WP_REST_API_Options extends ACF_To_WP_REST_API_Base {

		public function register_routes( $routes ) {
			if ( class_exists( 'WP_JSON_Server' ) ) {
				$routes["/acf/{$this->type}"] = array( 
					array( array( $this, 'get_options' ), WP_JSON_Server::READABLE ),
				);

				$routes["/acf/{$this->type}/(?P<name>[\w\-\_]+)"] = array( 
					array( array( $this, 'get_options' ), WP_JSON_Server::READABLE ),
				);				
			} else {
				register_rest_route( 
					'acf', 
					"/{$this->type}", 
					array( 
						'methods'  => 'GET',
						'callback' => array( $this, 'get_options' ),
					)
				);

				register_rest_route( 
					'acf', 
					"/{$this->type}/(?P<name>[\w\-\_]+)",
					array( 
						'methods'  => 'GET',
						'callback' => array( $this, 'get_options' ),
					)
				);
			}
			
			return $routes;
		}

		public function get_options( $name = NULL ) {
			$data = array();
			
			if ( $name instanceof WP_REST_Request ) {
				if ( isset( $name['name'] ) ) {
					$name = $name['name'];
				} else {
					$name = NULL;
				}
			}

			if ( $name ) {
				$option = get_field( $name, 'option' );
				$data   = array( $name => $option );
			} else {
				$data = get_fields( 'option' );
			}
			
			return apply_filters( "acf_to_wp_rest_api_{$this->type}_data", $data, $name );
		}

	}
}

new ACF_To_WP_REST_API_Options();
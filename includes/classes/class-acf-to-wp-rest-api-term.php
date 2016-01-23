<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ACF_To_WP_REST_API_Term' ) ) {
	class ACF_To_WP_REST_API_Term extends ACF_To_WP_REST_API_Base {

		public function register_routes( $routes ) {
			if ( class_exists( 'WP_JSON_Server' ) ) {
				$routes["/acf/{$this->type}/(?P<id>\d+)/(?P<tax>[\w\-\_]+)"] = array(
					array( array( $this, 'get_fields_by_term' ), WP_JSON_Server::READABLE )
				);				
			} else {
				register_rest_route(
					'acf', 
					"/{$this->type}/(?P<id>\d+)/(?P<tax>[\w\-\_]+)", 
					array(
						'methods'  => 'GET',
						'callback' => array( $this, 'get_fields_by_term' ),
					)
				);
			}

			return $routes;
		}

		public function get_fields_by_term( $id, $tax = NULL ) {
			$object = new stdClass;
			
			if ( $id instanceof WP_REST_Request ) {
				$tax = $id['tax'];
				$id  = $id['id'];
			}

			$object->taxonomy = sanitize_title( $tax );
			$object->ID       = absint( $id );

			return $this->get_fields( NULL, $object );
		}

	}
}

new ACF_To_WP_REST_API_Term();
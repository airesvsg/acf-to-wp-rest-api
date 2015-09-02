<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ACF_To_WP_REST_API_Base' ) ) {	
	abstract class ACF_To_WP_REST_API_Base {

		protected $type;
		protected $id;

		public function __construct() {
			$this->type = strtolower( str_replace( 'ACF_To_WP_REST_API_', '', get_class( $this ) ) );
			if ( class_exists( 'WP_JSON_Server' ) ) {
				add_filter( "json_prepare_{$this->type}", array( $this, 'get_fields' ), 10, 3 );
				add_action( 'wp_json_server_before_serve', array( $this, 'init_routes' ) );
			} else {
				add_action( 'rest_api_init', array( $this, 'register_routes' ) );
			}
		}

		public function init_routes() {
			if ( method_exists( $this, 'register_routes' ) ) {
				add_filter( 'json_endpoints', array( $this, 'register_routes' ), 10, 1 );
			}
		}

		public function register_routes( $routes ) {			
			if ( class_exists( 'WP_JSON_Server' ) ) {
				$routes["/acf/{$this->type}/(?P<id>\d+)"] = array(
					array( array( $this, 'get_fields_by_id' ), WP_JSON_Server::READABLE ),
				);				
			} else {
				register_rest_route( 
					'acf', 
					"/{$this->type}/(?P<id>\d+)", 
					array( 
						'methods'  => 'GET',
						'callback' => array( $this, 'get_fields_by_id' ),
					)
				);
			}

			return $routes;
		}

		protected function get_id( $object ) {
			$this->id = false;

			if ( is_numeric( $object ) ) {
				$this->id = $object;
			} elseif ( $object instanceof WP_REST_Request && isset( $object['id'] ) ) {
				$this->id = $object['id'];			
			} elseif ( is_array( $object ) && array_key_exists( 'ID', $object ) ) {
				$this->id = $object['ID'];
			} elseif ( is_object( $object ) ) {
				if ( isset( $object->ID ) ) {
					$this->id = $object->ID;
				} elseif ( isset( $object->comment_ID ) ) {
					$this->id = $object->comment_ID;
				} elseif ( isset( $object->term_id ) ) {
					$this->id = $object->term_id;
				}
			}

			$this->id = absint( $this->id );
			
			return $this->id;
		}

		protected function format_id( $object ) {
			$this->get_id( $object );

			switch ( $this->type ) {
				case 'comment' :
					$this->id = "comment_{$this->id}";
					break;
				case 'user' :
					$this->id = "user_{$this->id}";
					break;
				case 'term' :
					if( isset( $object->taxonomy ) && $object->taxonomy ) {
						$this->id = "{$object->taxonomy}_{$this->id}";
					}
					break;
				case 'option' :
					$this->id = 'option';
					break;
			}

			return $this->id;
		}

		public function get_fields( $data = NULL, $object = NULL, $context = NULL ) {
			$this->format_id( $object );

			if ( ! ( $data['acf'] = get_fields( $this->id ) ) ) {
				$data['acf'] = array();
			}

			return apply_filters( "acf_to_wp_rest_api_{$this->type}_data", $data, $object, $context );
		}

		public function get_fields_by_id( $id ) {
			return $this->get_fields( NULL, $id );
		}
		
	}
}
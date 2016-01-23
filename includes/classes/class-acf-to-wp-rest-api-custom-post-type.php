<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ACF_To_WP_REST_API_Custom_Post_Type' ) ) {
	class ACF_To_WP_REST_API_Custom_Post_Type extends ACF_To_WP_REST_API_Base {

		public function __construct() {
			parent::__construct();
			
			$default    = array( 'post', 'page', 'attachment' );
			$args       = apply_filters( 'acf_to_wp_rest_api_cutom_post_type_args', array( 'public' => true ) );	
			$post_types = get_post_types( $args );	
			
			if ( ! is_array( $post_types ) ) {
				$post_types = array();
			}

			$post_types = apply_filters( 'acf_to_wp_rest_api_cutom_post_types', array_diff( $post_types, $default ) );
			
			if ( is_array( $post_types ) && count( $post_types ) > 0 ) {
				foreach ( $post_types as $pt ) {
					add_filter( "rest_prepare_{$pt}", array( $this, 'get_fields' ), 10, 3 );
				}
			}
		}

	}
}

new ACF_To_WP_REST_API_Custom_Post_Type();
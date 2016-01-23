<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ACF_To_WP_REST_API_User' ) ) {
	class ACF_To_WP_REST_API_User extends ACF_To_WP_REST_API_Base {}
}

new ACF_To_WP_REST_API_User();
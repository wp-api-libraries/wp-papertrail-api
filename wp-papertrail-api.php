<?php
/**
 * WP Papertrail API (http://help.papertrailapp.com/kb/how-it-works/http-api/)
 *
 * @package Papertrail-API
 */

/*
* Plugin Name: WP Papertrail API
* Plugin URI: https://github.com/wp-api-libraries/wp-papertrail-api
* Description: Perform API requests to Papertrail in WordPress.
* Author: WP API Libraries
* Version: 1.0.0
* Author URI: https://wp-api-libraries.com
* GitHub Plugin URI: https://github.com/wp-api-libraries/wp-papertrail-api
* GitHub Branch: master
* Text Domain: wp-papertrail-api
*/

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Check if class exists. */
if ( ! class_exists( 'PapertrailAPI' ) ) {

	/**
	 * PapertrailAPI Class.
	 */
	class PapertrailAPI {

		/**
		 * API Token.
		 *
		 * @var string
		 */
		static private $api_token;
		
		/**
		 * Base URI.
		 * 
		 * (default value: 'https://papertrailapp.com/api/')
		 * 
		 * @var string
		 * @access private
		 * @static
		 */
		static private $base_uri = 'https://papertrailapp.com/api/';

		/**
		 * Stream
		 *
		 * @var mixed
		 * @access public
		 */
		public $stream;

		/**
		 * __construct function.
		 *
		 * @access public
		 * @return void
		 */
		public function __construct(  $api_token, $stream, $papertrail_username = '', $papertrail_password = '' ) {

			static::$api_token = $api_token;
			static::$stream = $stream;

			$this->args['headers'] = array(
				'Content-Type' => 'application/json',
				'Accept' => 'application/json',
				'X-Papertrail-Token' => $api_token
			);
		}

		/**
		 * Fetch the request from the API.
		 *
		 * @access private
		 * @param mixed $request Request URL.
		 * @return $body Body.
		 */
		private function fetch( $request ) {

			$response = wp_remote_request( $request, $this->args );

			$code = wp_remote_retrieve_response_code($response );
			if ( 200 !== $code ) {
				return new WP_Error( 'response-error', sprintf( __( 'Server response code: %d', 'wp-harvest-api' ), $code ) );
			}
			$body = wp_remote_retrieve_body( $response );
			return json_decode( $body );
		}

		/**
		 * Check Rate Limit.
		 */
		private function check_rate_limit() {
			return $rate_limit = wp_remote_retrieve_header( $this->response, 'X-Rate-Limit-Limit' );
		}

		/**
		 * Check Rate Limit Remaining.
		 *
		 * @access private
		 * @return void
		 */
		private function check_rate_limit_remaining() {
			return $rate_limit_remaining = wp_remote_retrieve_header( $this->response, 'X-Rate-Limit-Remaining' );
		}

		/**
		 * Check Rate Limit Reset.
		 *
		 * @access private
		 * @return void
		 */
		private function check_rate_limit_reset() {
			return $rate_limit_reset = wp_remote_retrieve_header( $this->response, 'X-Rate-Limit-Reset' );
		}

		/**
		 * Send Remote Syslog
		 * Thanks to Troy Davis, https://gist.github.com/troy/2220679
		 *
		 * @access public
		 * @param mixed $message Message.
		 * @param string $component (default: '') Component.
		 * @param string $program (default: 'wordpress') Program.
		 * @return void
		 */
		public function send_remote_syslog( $message, $component = '', $program = 'wordpress' ) {

			$destination = array_combine( array( 'hostname', 'port' ), explode( ':', $this->options['papertrail_destination'] ) );

			$program     = parse_url( is_multisite() ? network_site_url() : site_url(), PHP_URL_HOST );
			$component   = sanitize_title( 'stream-' . $message['connector'] );

			$message = json_encode( $message );

			$syslog_message = '<22>' . date( 'M d H:i:s ' ) . $program . ' ' . $component . ': ' . $this->format( $message );

			$sock = socket_create( AF_INET, SOCK_DGRAM, SOL_UDP );
			socket_sendto( $sock, $syslog_message, strlen( $syslog_message ), 0, $destination['hostname'], $destination['port'] );
			socket_close( $sock );

		}

		/* Manage Systems. */
		
		
		/**
		 * Get all Systems.
		 * 
		 * @access public
		 * @return void
		 */
		public function get_systems() {
			// https://papertrailapp.com/api/v1/systems.json
		}
		
		/**
		 * Get System.
		 * 
		 * @access public
		 * @param mixed $system_id System ID.
		 * @return void
		 */
		public function get_system( $system_id ) {
			
		}
		
		public function register_system() {
			
		}
		
		public function update_system( $system_id ) {
			
		}
		
		public function unregister_system( $system_id ) {
			
		}
		
		public function join_group( $group_id ) {
			
		}
		
		public function leave_group( $group_id ) {
			
		}
		
		/* Managed Saved Searches. */
		
		public function get_searches() {
			
		}
		
		public function get_search( $search_id ) {
			
		}
		
		public function add_searches( $name, $query ) {
			
		}
		
		public function update_searches( $search_id ) {
			
		}
		
		public function delete_searches( $search_id ) {
			
		}
		
		/* Groups. */
		
		public function get_groups() {
			
		}
		
		public function get_group( $group_id ) {
			
		}
		
		public function add_group() {
			
		}
		
		public function update_group( $group_id ) {
			
		}
		
		public function delete_group( $group_id ) {
			
		}
		
		
		/* Log Destinations. */
		
		public function get_destinations() {
			
		}
		
		public function get_destination( $destination_id ) {
			
		}
		
		/* Users. */
		
		public function get_users() {
			
		}
		
		public function invite_user( $email, $read_only ) {
			
		}
		
		public function delete_user() {
			
		}
		
		/* Account Usage. */
		
		public function get_accounts() {
			
		}
		
		/* Archive Details. */
		
		public function get_archives() {
			
		}

	}
}

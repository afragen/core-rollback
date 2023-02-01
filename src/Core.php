<?php
/**
 * Core Rollback
 *
 * @author  Andy Fragen
 * @license MIT
 * @link    https://github.com/afragen/core-rollback
 * @package core-rollback
 */

namespace Fragen\Rollback;

/*
 * Exit if called directly.
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Core
 */
class Core {
	/**
	 * Core versions for re-installation.
	 *
	 * @var array
	 */
	public static $core_versions;

	/**
	 * Constructor.
	 */
	public function __construct() {
		static::$core_versions = $this->get_core_versions();
	}

	/**
	 * Get all core versions from Core API.
	 *
	 * @return array Array of versions and downloads.
	 */
	public function get_core_versions() {
		$versions = get_site_transient( 'core_rollback' );
		if ( ! $versions ) {
			$versions = [];
			$locale   = get_locale();
			$response = wp_remote_get( "https://api.wordpress.org/core/version-check/1.7/?locale={$locale}" );
			if ( is_wp_error( $response ) ) {
				return [];
			}
			$body   = wp_remote_retrieve_body( $response );
			$body   = json_decode( $body );
			$offers = $body->offers;
			foreach ( $offers as $offer ) {
				if ( version_compare( $offer->version, '4.0', '>=' ) ) {
					$offer->response             = 'latest';
					$versions[ $offer->version ] = $offer;
				}
			}
			set_site_transient( 'core_rollback', $versions, DAY_IN_SECONDS );
		}

		return $versions;
	}

	/**
	 * Load hooks.
	 */
	public function load_hooks() {
		add_filter( 'http_request_args', [ $this, 'filter_http_request_args' ], 10, 2 );
		add_filter( 'pre_http_request', [ $this, 'filter_http_request' ], 10, 3 );
	}

	/**
	 * Add core rollback version to http_request_args.
	 *
	 * @param array  $args Array of HTTP request args.
	 * @param string $url  URL for HTTP request.
	 *
	 * @return array
	 */
	public function filter_http_request_args( $args, $url ) {
		if ( false === strpos( $url, '//api.wordpress.org/core/version-check/' ) ) {
			return $args;
		}
		$rollback = get_site_transient( '_core_rollback' );

		if ( $rollback ) {
			$args['_rollback_version'] = $rollback['core_dropdown'];
		}

		return $args;
	}

	/**
	 * Filter 'pre_http_request' to add rollback API check.
	 *
	 * @param mixed  $result $result from filter.
	 * @param array  $args   Array of filter args.
	 * @param string $url    URL from filter.
	 *
	 * @return \stdClass $response Output from wp_remote_get().
	 */
	public function filter_http_request( $result, $args, $url ) {
		if ( $result || isset( $args['_core_rollback'] ) ) {
			return $result;
		}
		if ( false === strpos( $url, '//api.wordpress.org/core/version-check/' ) ) {
			return $result;
		}

		// It's a core-update request.
		$args['_core_rollback'] = true;

		$response = wp_remote_get( $url, $args );
		if ( is_wp_error( $response ) ) {
			return $result;
		}
		if ( isset( $args['_rollback_version'] ) ) {
			$rollback_version = sanitize_text_field( $args['_rollback_version'] );
			$response         = $this->set_rollback( $response, $rollback_version );
		}

		return $response;
	}

	/**
	 * Update Core API update response to add rollback.
	 *
	 * @param \stdClass $response         Core API response.
	 * @param string    $rollback_version Rollback version.
	 *
	 * @return \stdClass
	 */
	public function set_rollback( $response, $rollback_version ) {
		if ( ! array_key_exists( $rollback_version, static::$core_versions ) ) {
			return $response;
		}
		$body   = wp_remote_retrieve_body( $response );
		$offers = \json_decode( $body );
		$latest = false;
		$num    = count( array_keys( $offers->offers ) );
		foreach ( array_keys( $offers->offers ) as $key ) {
			if ( 0 === $key ) {
				continue;
			}

			if ( 'latest' === $offers->offers[ $key ]->response ) {
				$offers->offers[ $key ] = static::$core_versions[ $rollback_version ];
				$latest                 = true;
			}
		}

		if ( ! $latest && ( ( $key + 1 ) === $num ) ) {
			$offers->offers[ $num ] = static::$core_versions[ $rollback_version ];
		}

		$body             = \json_encode( $offers );
		$response['body'] = $body;

		return $response;
	}
}

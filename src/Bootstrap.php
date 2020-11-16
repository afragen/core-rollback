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
 * Class Bootstrap
 */
class Bootstrap {
	/**
	 * Let's get started.
	 *
	 * @return void
	 */
	public function run() {
		add_action( 'init', [ $this, 'load_textdomain' ] );
		( new Core() )->load_hooks();
		( new Settings() )->load_hooks();
	}

	/**
	 * Load textdomain.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'core-rollback' );
	}
}

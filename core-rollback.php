<?php
/**
 * Core Rollback
 *
 * @author  Andy Fragen
 * @license MIT
 * @link    https://github.com/afragen/core-rollback
 * @package core-rollback
 */

/**
 * Plugin Name:       Core Rollback
 * Plugin URI:        https://github.com/afragen/core-rollback
 * Description:       Seamless rollback of WordPress Core to latest release or any outdated, secure release using the Core Update API and core update methods.
 * Version:           0.5.0
 * Author:            Andy Fragen
 * License:           MIT
 * Domain Path:       /languages
 * Text Domain:       core-rollback
 * Network:           true
 * GitHub Plugin URI: https://github.com/afragen/core-rollback
 * Primary Branch:    main
 * Requires PHP:      5.6
 * Requires at least: 4.0
 */

namespace Fragen\Rollback;

require_once __DIR__ . '/vendor/autoload.php';

add_action(
	'init',
	function() {
		load_plugin_textdomain( 'core-rollback' );
	}
);

( new Core() )->load_hooks();
( new Settings() )->load_hooks();

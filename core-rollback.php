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
 * Description:       Rollback WordPress Core to one of the last several versions.
 * Version:           0.1.0
 * Author:            Andy Fragen
 * License:           MIT
 * Domain Path:       /languages
 * Text Domain:       core-rollback
 * GitHub Plugin URI: https://github.com/afragen/core-rollback
 * Primary Branch:    main
 * Requires at least: 4.0
 * Requires PHP:      5.4
 */

namespace Fragen\Rollback;

require_once __DIR__ . '/vendor/autoload.php';

( new Settings() )->load_hooks();
( new Core() )->load_hooks();

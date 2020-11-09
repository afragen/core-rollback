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
 * Class Settings
 */
class Settings {
	/**
	 * Load hooks.
	 *
	 * @return void
	 */
	public function load_hooks() {
		add_action( 'admin_init', [ $this, 'add_settings' ] );
		add_action( is_multisite() ? 'network_admin_menu' : 'admin_menu', [ $this, 'add_plugin_menu' ] );
		add_action( 'admin_init', [ $this, 'update_settings' ] );
		add_action( 'network_admin_edit_rollback', [ $this, 'update_settings' ] );
	}

	/**
	 * Add/register setttings.
	 *
	 * @return void
	 */
	public function add_settings() {
		register_setting( 'rollback_settings', 'rollback_settings' );
		add_settings_section(
			'core',
			null,
			[ $this, 'print_core_rollback' ],
			'rollback'
		);
		add_settings_field(
			'core_versions',
			__( 'Core Versions', 'core-rollback' ),
			[ $this, 'version_dropdown' ],
			'rollback',
			'core',
			[ 'core' => new Core() ]
		);
	}

	/**
	 * Print settings section blurb.
	 *
	 * @return void
	 */
	public function print_core_rollback() {
		echo '<div class="notice notice-warning fade">';
		echo '<p>' . wp_kses_post( __( '<strong>WARNING:</strong> Downgrading WordPress Core may leave your site in an unusable state.', 'core-rollback' ) ) . '</p>';
		echo '</div>';
		esc_html_e( 'Rollback to one of most recent WordPress core versions.', 'core-rollback' );
	}

	/**
	 * Add options page.
	 */
	public function add_plugin_menu() {
		$parent     = is_multisite() ? 'settings.php' : 'tools.php';
		$capability = is_multisite() ? 'manage_network_options' : 'manage_options';

		add_submenu_page(
			$parent,
			esc_html__( 'Rollback Core', 'core-rollback' ),
			esc_html_x( 'Rollback Core', 'Menu item', 'core-rollback' ),
			$capability,
			'rollback',
			[ $this, 'create_admin_page' ]
		);
	}

	/**
	 * Options page callback.
	 */
	public function create_admin_page() {
		$action      = is_multisite() ? 'edit.php?action=rollback' : 'options.php';
		$form_action = 'update-core.php?action=do-core-reinstall';
		$submit      = __( 'Re-install', 'core-rollback' );

		echo '<div class="wrap">';
		echo '<h2>' . esc_html__( 'Rollback Core', 'core-rollback' ) . '</h2>';
		echo '<form method="post" action="' . esc_attr( $form_action ) . '" name="upgrade" class="upgrade">';
		wp_nonce_field( 'core_rollback' );
		settings_fields( 'rollback_settings' );
		do_settings_sections( 'rollback' );
		submit_button( $submit );
		echo '</form>';
		echo '</div>';
	}

	/**
	 * Make version dropdown.
	 *
	 * @param  array $args Array of args, [ 'core' => new Core() ].
	 *
	 * @return void
	 */
	public function version_dropdown( $args ) {
		$items = array_keys( $args['core']::$core_versions );
		echo "<select id='core_dropdown' name='versions[core_dropdown]'>";
		foreach ( $items as $item ) {
			echo '<option value="' . esc_attr( $item ) . '">' . esc_attr( $item ) . '</option>';
		}
		echo '</select>';
	}

	/**
	 * Update single site and network settings.
	 * Used when plugin is network activated to save settings.
	 *
	 * @link http://wordpress.stackexchange.com/questions/64968/settings-api-in-multisite-missing-update-message
	 * @link http://benohead.com/wordpress-network-wide-plugin-settings/
	 */
	public function update_settings() {
		// phpcs:disable WordPress.Security.NonceVerification.Missing
		if ( ! isset( $_POST['_wp_http_referer'] ) ) {
			return false;
		}

		if ( isset( $_POST['option_page'] ) &&
			'rollback_settings' === sanitize_file_name( wp_unslash( $_POST['option_page'] ) )
		) {
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$options = isset( $_POST['versions'] ) ? wp_unslash( $_POST['versions'] ) : [];
			// phpcs:enable

			set_site_transient( '_core_rollback', $options, 15 );
			wp_safe_redirect( \network_admin_url( 'update-core.php?force-check=1' ) );
			exit;
		}
	}
}

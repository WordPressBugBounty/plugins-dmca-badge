<?php
/**
 * Uninstall handler for DMCA Website Protection Badge.
 *
 * When this file is present, WordPress uses it directly instead of the
 * registered uninstall callback (array( 'DMCA_Badge_Plugin', 'uninstall' )).
 *
 * That callback relied on classes/class-plugin.php being loaded, but the
 * plugin loads that class lazily on the 'plugins_loaded' hook (via the
 * Sidecar/Imperative loader). During plugin deletion WordPress includes the
 * main plugin file directly, outside the normal 'plugins_loaded' sequence,
 * so the class never gets defined and PHP throws:
 *   "class DMCA_Badge_Plugin not found"
 *
 * This file avoids that whole loading chain and just removes the plugin's
 * own stored data directly.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Delete all plugin data for a single site.
 */
function dmca_badge_uninstall_cleanup() {
	// Remove the plugin's saved settings.
	delete_option( 'dmca_badge_settings' );

	// Remove the cached API login token.
	delete_transient( 'dmca_login_token' );

	// Remove the DMCA account ID stored against every user who connected one.
	$users = get_users( array(
		'meta_key' 	=> 'dmca_account_id',
		'fields'	=> 'ID',
	) );

	foreach ( $users as $user_id ) {
		delete_user_meta( $user_id, 'dmca_account_id' );
	}
}

dmca_badge_uninstall_cleanup();

// Multisite: repeat the cleanup for every site in the network.
if ( is_multisite() ) {
	$site_ids = get_sites( array( 'fields' => 'ids' ) );

	foreach ( $site_ids as $site_id ) {
		switch_to_blog( $site_id );
		dmca_badge_uninstall_cleanup();
		restore_current_blog();
	}
}
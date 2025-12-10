<?php
/**
 * Uninstall routine.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

delete_option( 'healing_packages_settings' );


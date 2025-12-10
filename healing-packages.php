<?php
/**
 * Plugin Name:       WhatsApp Healing Trip Packages Booking
 * Description:       Create and display medical/therapeutic travel packages with WhatsApp booking.
 * Version:           1.0.0
 * Author:            Healing Trips
 * Text Domain:       healing-packages
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'HEALING_PACKAGES_VERSION', '1.0.0' );
define( 'HEALING_PACKAGES_PATH', plugin_dir_path( __FILE__ ) );
define( 'HEALING_PACKAGES_URL', plugin_dir_url( __FILE__ ) );
define( 'HEALING_PACKAGES_BASENAME', plugin_basename( __FILE__ ) );

require_once HEALING_PACKAGES_PATH . 'includes/helpers.php';
require_once HEALING_PACKAGES_PATH . 'includes/class-healing-packages-assets.php';
require_once HEALING_PACKAGES_PATH . 'includes/class-healing-packages-cpt.php';
require_once HEALING_PACKAGES_PATH . 'includes/class-healing-packages-metaboxes.php';
require_once HEALING_PACKAGES_PATH . 'includes/class-healing-packages-settings.php';
require_once HEALING_PACKAGES_PATH . 'includes/class-healing-packages-template.php';
require_once HEALING_PACKAGES_PATH . 'includes/class-healing-packages-shortcode.php';

/**
 * Initialize plugin components.
 */
function healing_packages_init() {
    $cpt        = new Healing_Packages_CPT();
    $metaboxes  = new Healing_Packages_Metaboxes();
    $settings   = new Healing_Packages_Settings();
    $assets     = new Healing_Packages_Assets();
    $template   = new Healing_Packages_Template();
    $shortcodes = new Healing_Packages_Shortcode( $template );

    $cpt->register_hooks();
    $metaboxes->register_hooks();
    $settings->register_hooks();
    $assets->register_hooks();
    $template->register_hooks();
    $shortcodes->register_hooks();
}
add_action( 'plugins_loaded', 'healing_packages_init' );

/**
 * Load text domain for translations.
 */
function healing_packages_load_textdomain() {
    load_plugin_textdomain( 'healing-packages', false, dirname( HEALING_PACKAGES_BASENAME ) . '/languages' );
}
add_action( 'init', 'healing_packages_load_textdomain' );

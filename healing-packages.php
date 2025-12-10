<?php
/**
 * Plugin Name: Healing Packages
 * Description: Create and display healing / therapy packages via custom post type and shortcode.
 * Version: 1.0.0
 * Author: ChatGPT
 * Text Domain: healing-packages
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'HEALING_PACKAGES_VERSION', '1.0.0' );
define( 'HEALING_PACKAGES_PATH', plugin_dir_path( __FILE__ ) );
define( 'HEALING_PACKAGES_URL', plugin_dir_url( __FILE__ ) );

// Includes
require_once HEALING_PACKAGES_PATH . 'includes/helpers.php';
require_once HEALING_PACKAGES_PATH . 'includes/class-healing-packages-cpt.php';
require_once HEALING_PACKAGES_PATH . 'includes/class-healing-packages-metaboxes.php';
require_once HEALING_PACKAGES_PATH . 'includes/class-healing-packages-settings.php';
require_once HEALING_PACKAGES_PATH . 'includes/class-healing-packages-assets.php';
require_once HEALING_PACKAGES_PATH . 'includes/class-healing-packages-template.php';
require_once HEALING_PACKAGES_PATH . 'includes/class-healing-packages-shortcode.php';

// Bootstrap
function healing_packages_init() {
    new Healing_Packages_CPT();
    new Healing_Packages_Metaboxes();
    new Healing_Packages_Settings();
    new Healing_Packages_Assets();
    new Healing_Packages_Shortcode();
}
add_action( 'plugins_loaded', 'healing_packages_init' );

function healing_packages_load_textdomain() {
    load_plugin_textdomain( 'healing-packages', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'healing_packages_load_textdomain' );

<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Healing_Packages_Assets {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend' ) );
    }

    public function enqueue_frontend() {
        // Load on CPT archive / single or if shortcode present
        if ( is_post_type_archive( 'healing_package' ) || is_singular( 'healing_package' ) || $this->has_shortcode_on_page() ) {
            wp_enqueue_style(
                'healing-packages-frontend',
                HEALING_PACKAGES_URL . 'assets/css/frontend.css',
                array(),
                HEALING_PACKAGES_VERSION
            );

            wp_enqueue_script(
                'healing-packages-frontend',
                HEALING_PACKAGES_URL . 'assets/js/frontend.js',
                array( 'jquery' ),
                HEALING_PACKAGES_VERSION,
                true
            );
        }
    }

    private function has_shortcode_on_page() {
        if ( is_singular() ) {
            global $post;
            if ( has_shortcode( $post->post_content, 'healing_packages' ) ) {
                return true;
            }
        }
        return false;
    }
}

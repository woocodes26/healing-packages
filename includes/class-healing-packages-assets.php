<?php
/**
 * Asset loading for Healing Packages.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Healing_Packages_Assets {
    /**
     * Register hooks.
     */
    public function register_hooks() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
    }

    /**
     * Register and enqueue assets when needed.
     */
    public function register_assets() {
        wp_register_style(
            'healing-packages-frontend',
            HEALING_PACKAGES_URL . 'assets/css/frontend.css',
            [],
            HEALING_PACKAGES_VERSION
        );

        wp_register_script(
            'healing-packages-frontend',
            HEALING_PACKAGES_URL . 'assets/js/frontend.js',
            [],
            HEALING_PACKAGES_VERSION,
            true
        );

        if ( self::should_enqueue_assets() ) {
            wp_enqueue_style( 'healing-packages-frontend' );
            wp_enqueue_script( 'healing-packages-frontend' );
        }
    }

    /**
     * Enqueue assets when needed (e.g., during shortcode rendering).
     */
    public static function enqueue_assets() {
        add_filter( 'healing_packages_should_enqueue', '__return_true' );
        wp_enqueue_style( 'healing-packages-frontend' );
        wp_enqueue_script( 'healing-packages-frontend' );
    }

    /**
     * Determine if assets should be enqueued.
     *
     * @return bool
     */
    public static function should_enqueue_assets() {
        /**
         * Filter whether to enqueue Healing Packages assets.
         *
         * @since 1.0.0
         *
         * @param bool $should_enqueue Whether to enqueue assets.
         */
        return (bool) apply_filters( 'healing_packages_should_enqueue', false );
    }
}

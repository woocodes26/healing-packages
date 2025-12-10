<?php
/**
 * Template handling for Healing Packages.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Healing_Packages_Template {
    /**
     * Register hooks.
     */
    public function register_hooks() {
        add_filter( 'plugin_action_links_' . HEALING_PACKAGES_BASENAME, [ $this, 'settings_link' ] );
    }

    /**
     * Get template path, allowing theme overrides.
     *
     * @param string $template Template filename.
     *
     * @return string
     */
    public function get_template( $template ) {
        $template_path = locate_template( 'healing-packages/' . $template );

        if ( ! $template_path ) {
            $template_path = HEALING_PACKAGES_PATH . 'templates/' . $template;
        }

        return $template_path;
    }

    /**
     * Add settings link on plugins screen.
     *
     * @param array $links Existing links.
     *
     * @return array
     */
    public function settings_link( $links ) {
        $settings_link = sprintf(
            '<a href="%s">%s</a>',
            esc_url( admin_url( 'options-general.php?page=healing_packages_settings' ) ),
            esc_html__( 'Settings', 'healing-packages' )
        );

        array_unshift( $links, $settings_link );

        return $links;
    }
}

<?php
/**
 * Helper functions for Healing Packages plugin.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get plugin settings with defaults.
 *
 * @return array
 */
function healing_packages_get_settings() {
    $defaults = [
        'default_whatsapp'   => '',
        'message_template'   => __( 'Hello, I want to book the package: {package_name}, Hospital: {hospital}, Procedure: {procedure_type}, Hotel: {hotel_category}.', 'healing-packages' ),
        'button_text'        => __( 'Book via WhatsApp', 'healing-packages' ),
    ];

    $settings = get_option( 'healing_packages_settings', [] );

    return wp_parse_args( $settings, $defaults );
}

/**
 * Build the WhatsApp booking URL.
 *
 * @param array $data Data for replacements.
 * @param array $settings Plugin settings.
 *
 * @return string
 */
function healing_packages_build_whatsapp_url( $data, $settings ) {
    $placeholders = [
        '{package_name}'   => isset( $data['package_name'] ) ? $data['package_name'] : '',
        '{hospital}'       => isset( $data['hospital'] ) ? $data['hospital'] : '',
        '{procedure_type}' => isset( $data['procedure_type'] ) ? $data['procedure_type'] : '',
        '{hotel_category}' => isset( $data['hotel_category'] ) ? $data['hotel_category'] : '',
    ];

    $template = isset( $data['message_template'] ) ? $data['message_template'] : $settings['message_template'];
    $message  = strtr( $template, $placeholders );
    $number   = isset( $data['whatsapp_number'] ) && $data['whatsapp_number'] ? $data['whatsapp_number'] : $settings['default_whatsapp'];

    $encoded_message = rawurlencode( $message );

    if ( $number ) {
        $clean_number = preg_replace( '/[^0-9+]/', '', $number );

        return sprintf( 'https://wa.me/%s?text=%s', $clean_number, $encoded_message );
    }

    return sprintf( 'https://wa.me/?text=%s', $encoded_message );
}

/**
 * Convert newline separated text into an array of items.
 *
 * @param string $text Raw text.
 *
 * @return array
 */
function healing_packages_text_to_list( $text ) {
    $items = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $text ) ) );

    return array_values( $items );
}

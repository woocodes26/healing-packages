<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function healing_packages_get_option( $key, $default = '' ) {
    $options = get_option( 'healing_packages_settings', array() );
    return isset( $options[ $key ] ) ? $options[ $key ] : $default;
}

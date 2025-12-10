<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Delete all healing_package posts
$posts = get_posts( array(
    'post_type'   => 'healing_package',
    'numberposts' => -1,
    'post_status' => 'any',
) );

foreach ( $posts as $post ) {
    wp_delete_post( $post->ID, true );
}

// Delete options
delete_option( 'healing_packages_settings' );

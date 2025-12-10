<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Healing_Packages_Template {

    public static function render_card( $post_id ) {
        $price    = get_post_meta( $post_id, '_healing_price', true );
        $duration = get_post_meta( $post_id, '_healing_duration', true );
        $features = get_post_meta( $post_id, '_healing_features', true );
        $currency = healing_packages_get_option( 'currency', '$' );

        $features_list = array_filter( array_map( 'trim', explode( "\n", $features ) ) );

        $template = locate_template( 'healing-packages/package-card.php' );
        if ( ! $template ) {
            $template = HEALING_PACKAGES_PATH . 'templates/package-card.php';
        }

        include $template;
    }
}

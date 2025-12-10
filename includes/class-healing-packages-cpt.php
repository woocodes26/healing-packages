<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Healing_Packages_CPT {

    public function __construct() {
        add_action( 'init', array( $this, 'register_cpt' ) );
        add_action( 'init', array( $this, 'register_taxonomy' ) );
    }

    public function register_cpt() {
        $labels = array(
            'name'               => __( 'Healing Packages', 'healing-packages' ),
            'singular_name'      => __( 'Healing Package', 'healing-packages' ),
            'add_new'            => __( 'Add New', 'healing-packages' ),
            'add_new_item'       => __( 'Add New Package', 'healing-packages' ),
            'edit_item'          => __( 'Edit Package', 'healing-packages' ),
            'new_item'           => __( 'New Package', 'healing-packages' ),
            'view_item'          => __( 'View Package', 'healing-packages' ),
            'search_items'       => __( 'Search Packages', 'healing-packages' ),
            'not_found'          => __( 'No packages found', 'healing-packages' ),
            'not_found_in_trash' => __( 'No packages found in Trash', 'healing-packages' ),
            'menu_name'          => __( 'Healing Packages', 'healing-packages' ),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => true,
            'show_in_rest'       => true,
            'supports'           => array( 'title', 'editor', 'thumbnail' ),
            'menu_icon'          => 'dashicons-heart',
        );

        register_post_type( 'healing_package', $args );
    }

    public function register_taxonomy() {
        $labels = array(
            'name'              => __( 'Package Categories', 'healing-packages' ),
            'singular_name'     => __( 'Package Category', 'healing-packages' ),
            'search_items'      => __( 'Search Categories', 'healing-packages' ),
            'all_items'         => __( 'All Categories', 'healing-packages' ),
            'edit_item'         => __( 'Edit Category', 'healing-packages' ),
            'update_item'       => __( 'Update Category', 'healing-packages' ),
            'add_new_item'      => __( 'Add New Category', 'healing-packages' ),
            'new_item_name'     => __( 'New Category Name', 'healing-packages' ),
            'menu_name'         => __( 'Package Categories', 'healing-packages' ),
        );

        $args = array(
            'labels'       => $labels,
            'hierarchical' => true,
            'show_in_rest' => true,
        );

        register_taxonomy( 'healing_package_cat', 'healing_package', $args );
    }
}

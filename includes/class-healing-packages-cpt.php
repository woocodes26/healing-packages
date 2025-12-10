<?php
/**
 * Custom post type and taxonomy registration.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Healing_Packages_CPT {
    /**
     * Register hooks.
     */
    public function register_hooks() {
        add_action( 'init', [ $this, 'register_post_type' ] );
        add_action( 'init', [ $this, 'register_taxonomy' ] );
    }

    /**
     * Register the Healing Packages post type.
     */
    public function register_post_type() {
        $labels = [
            'name'                  => __( 'Healing Packages', 'healing-packages' ),
            'singular_name'         => __( 'Healing Package', 'healing-packages' ),
            'menu_name'             => __( 'Healing Packages', 'healing-packages' ),
            'name_admin_bar'        => __( 'Healing Package', 'healing-packages' ),
            'add_new'               => __( 'Add New', 'healing-packages' ),
            'add_new_item'          => __( 'Add New Package', 'healing-packages' ),
            'new_item'              => __( 'New Package', 'healing-packages' ),
            'edit_item'             => __( 'Edit Package', 'healing-packages' ),
            'view_item'             => __( 'View Package', 'healing-packages' ),
            'all_items'             => __( 'All Packages', 'healing-packages' ),
            'search_items'          => __( 'Search Packages', 'healing-packages' ),
            'not_found'             => __( 'No packages found.', 'healing-packages' ),
            'not_found_in_trash'    => __( 'No packages found in Trash.', 'healing-packages' ),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'menu_icon'          => 'dashicons-heart',
            'supports'           => [ 'title', 'thumbnail' ],
            'show_in_rest'       => true,
            'rewrite'            => [ 'slug' => 'healing-packages' ],
            'has_archive'        => true,
        ];

        register_post_type( 'healing_package', $args );
    }

    /**
     * Register taxonomy for grouping packages.
     */
    public function register_taxonomy() {
        $labels = [
            'name'              => __( 'Healing Package Categories', 'healing-packages' ),
            'singular_name'     => __( 'Healing Package Category', 'healing-packages' ),
            'search_items'      => __( 'Search Categories', 'healing-packages' ),
            'all_items'         => __( 'All Categories', 'healing-packages' ),
            'parent_item'       => __( 'Parent Category', 'healing-packages' ),
            'parent_item_colon' => __( 'Parent Category:', 'healing-packages' ),
            'edit_item'         => __( 'Edit Category', 'healing-packages' ),
            'update_item'       => __( 'Update Category', 'healing-packages' ),
            'add_new_item'      => __( 'Add New Category', 'healing-packages' ),
            'new_item_name'     => __( 'New Category Name', 'healing-packages' ),
            'menu_name'         => __( 'Package Categories', 'healing-packages' ),
        ];

        $args = [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => [ 'slug' => 'healing-package-category' ],
            'show_in_rest'      => true,
        ];

        register_taxonomy( 'healing_package_category', [ 'healing_package' ], $args );
    }
}

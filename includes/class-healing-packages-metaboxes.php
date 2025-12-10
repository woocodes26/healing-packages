<?php
/**
 * Meta boxes for Healing Packages.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Healing_Packages_Metaboxes {
    /**
     * Fields to render and save.
     *
     * @var array
     */
    protected $fields = [
        'hospital_name'       => [ 'label' => 'Hospital Name', 'type' => 'text' ],
        'procedure_type'      => [ 'label' => 'Procedure Type', 'type' => 'text' ],
        'hotel_category'      => [ 'label' => 'Hotel Category', 'type' => 'text' ],
        'general_desc'        => [ 'label' => 'General Description', 'type' => 'textarea' ],
        'additional_services' => [ 'label' => 'Additional Services (one per line)', 'type' => 'textarea' ],
        'trip_duration'       => [ 'label' => 'Trip Duration', 'type' => 'text' ],
        'cities'              => [ 'label' => 'Cities / Destinations', 'type' => 'text' ],
        'included_icons'      => [ 'label' => 'Included Services (icons list, one per line)', 'type' => 'textarea' ],
        'whatsapp_number'     => [ 'label' => 'WhatsApp Number (override)', 'type' => 'text' ],
        'message_template'    => [ 'label' => 'WhatsApp Message Template (override)', 'type' => 'textarea' ],
    ];

    /**
     * Register hooks.
     */
    public function register_hooks() {
        add_action( 'add_meta_boxes', [ $this, 'register_meta_boxes' ] );
        add_action( 'save_post_healing_package', [ $this, 'save_meta_boxes' ] );
    }

    /**
     * Register meta box for healing packages.
     */
    public function register_meta_boxes() {
        add_meta_box(
            'healing_packages_details',
            __( 'Package Details', 'healing-packages' ),
            [ $this, 'render_meta_box' ],
            'healing_package',
            'normal',
            'high'
        );
    }

    /**
     * Render meta box contents.
     *
     * @param WP_Post $post Post object.
     */
    public function render_meta_box( $post ) {
        wp_nonce_field( 'healing_packages_save_meta', 'healing_packages_meta_nonce' );

        echo '<div class="healing-packages-meta">';

        foreach ( $this->fields as $key => $field ) {
            $meta_key = $this->get_meta_key( $key );
            $value    = get_post_meta( $post->ID, $meta_key, true );
            $label    = esc_html( __( $field['label'], 'healing-packages' ) );

            echo '<p class="healing-packages-field">';
            echo '<label for="' . esc_attr( $meta_key ) . '"><strong>' . $label . '</strong></label><br />';

            if ( 'textarea' === $field['type'] ) {
                printf(
                    '<textarea id="%1$s" name="%1$s" rows="3" style="width:100%%;">%2$s</textarea>',
                    esc_attr( $meta_key ),
                    esc_textarea( $value )
                );
            } else {
                printf(
                    '<input type="text" id="%1$s" name="%1$s" value="%2$s" class="widefat" />',
                    esc_attr( $meta_key ),
                    esc_attr( $value )
                );
            }

            echo '</p>';
        }

        echo '</div>';
    }

    /**
     * Save meta box data.
     *
     * @param int $post_id Post ID.
     */
    public function save_meta_boxes( $post_id ) {
        if ( ! isset( $_POST['healing_packages_meta_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['healing_packages_meta_nonce'] ), 'healing_packages_save_meta' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        foreach ( $this->fields as $key => $field ) {
            $meta_key = $this->get_meta_key( $key );
            $value    = isset( $_POST[ $meta_key ] ) ? wp_unslash( $_POST[ $meta_key ] ) : '';

            if ( 'textarea' === $field['type'] ) {
                $sanitized = wp_kses_post( $value );
            } else {
                $sanitized = sanitize_text_field( $value );
            }

            if ( $sanitized ) {
                update_post_meta( $post_id, $meta_key, $sanitized );
            } else {
                delete_post_meta( $post_id, $meta_key );
            }
        }
    }

    /**
     * Prefix meta key.
     *
     * @param string $key Base key.
     *
     * @return string
     */
    protected function get_meta_key( $key ) {
        return '_hp_' . $key;
    }
}

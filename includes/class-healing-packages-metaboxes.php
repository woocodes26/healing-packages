<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Healing_Packages_Metaboxes {

    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_meta' ) );
    }

    public function add_meta_boxes() {
        add_meta_box(
            'healing_packages_details',
            __( 'Package Details', 'healing-packages' ),
            array( $this, 'render_meta_box' ),
            'healing_package',
            'normal',
            'high'
        );
    }

    public function render_meta_box( $post ) {
        wp_nonce_field( 'healing_packages_save_meta', 'healing_packages_meta_nonce' );

        $price    = get_post_meta( $post->ID, '_healing_price', true );
        $duration = get_post_meta( $post->ID, '_healing_duration', true );
        $features = get_post_meta( $post->ID, '_healing_features', true );
        ?>
        <p>
            <label for="healing_price"><strong><?php _e( 'Price', 'healing-packages' ); ?></strong></label><br>
            <input type="text" id="healing_price" name="healing_price" value="<?php echo esc_attr( $price ); ?>" class="regular-text">
        </p>
        <p>
            <label for="healing_duration"><strong><?php _e( 'Duration', 'healing-packages' ); ?></strong></label><br>
            <input type="text" id="healing_duration" name="healing_duration" value="<?php echo esc_attr( $duration ); ?>" class="regular-text">
        </p>
        <p>
            <label for="healing_features"><strong><?php _e( 'Features (one per line)', 'healing-packages' ); ?></strong></label><br>
            <textarea id="healing_features" name="healing_features" rows="5" class="large-text"><?php echo esc_textarea( $features ); ?></textarea>
        </p>
        <?php
    }

    public function save_meta( $post_id ) {
        if ( ! isset( $_POST['healing_packages_meta_nonce'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['healing_packages_meta_nonce'], 'healing_packages_save_meta' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( isset( $_POST['post_type'] ) && 'healing_package' === $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }
        }

        $price    = isset( $_POST['healing_price'] ) ? sanitize_text_field( $_POST['healing_price'] ) : '';
        $duration = isset( $_POST['healing_duration'] ) ? sanitize_text_field( $_POST['healing_duration'] ) : '';
        $features = isset( $_POST['healing_features'] ) ? wp_kses_post( $_POST['healing_features'] ) : '';

        update_post_meta( $post_id, '_healing_price', $price );
        update_post_meta( $post_id, '_healing_duration', $duration );
        update_post_meta( $post_id, '_healing_features', $features );
    }
}

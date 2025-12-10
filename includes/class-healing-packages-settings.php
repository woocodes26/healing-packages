<?php
/**
 * Settings page for Healing Packages.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Healing_Packages_Settings {
    /**
     * Register hooks.
     */
    public function register_hooks() {
        add_action( 'admin_init', [ $this, 'register_settings' ] );
        add_action( 'admin_menu', [ $this, 'add_settings_page' ] );
    }

    /**
     * Register settings fields.
     */
    public function register_settings() {
        register_setting( 'healing_packages_settings', 'healing_packages_settings', [ $this, 'sanitize_settings' ] );

        add_settings_section(
            'healing_packages_main',
            __( 'Booking Defaults', 'healing-packages' ),
            '__return_false',
            'healing_packages_settings'
        );

        add_settings_field(
            'default_whatsapp',
            __( 'Default WhatsApp Number', 'healing-packages' ),
            [ $this, 'render_input' ],
            'healing_packages_settings',
            'healing_packages_main',
            [
                'id'          => 'default_whatsapp',
                'description' => __( 'Used when a package does not provide its own number.', 'healing-packages' ),
            ]
        );

        add_settings_field(
            'message_template',
            __( 'Default Message Template', 'healing-packages' ),
            [ $this, 'render_textarea' ],
            'healing_packages_settings',
            'healing_packages_main',
            [
                'id'          => 'message_template',
                'description' => __( 'Placeholders: {package_name}, {hospital}, {procedure_type}, {hotel_category}', 'healing-packages' ),
            ]
        );

        add_settings_field(
            'button_text',
            __( 'WhatsApp Button Text', 'healing-packages' ),
            [ $this, 'render_input' ],
            'healing_packages_settings',
            'healing_packages_main',
            [
                'id'          => 'button_text',
                'description' => __( 'Text shown on the booking button.', 'healing-packages' ),
            ]
        );
    }

    /**
     * Add settings page under Settings menu.
     */
    public function add_settings_page() {
        add_options_page(
            __( 'Healing Packages', 'healing-packages' ),
            __( 'Healing Packages', 'healing-packages' ),
            'manage_options',
            'healing_packages_settings',
            [ $this, 'render_settings_page' ]
        );
    }

    /**
     * Sanitize settings before saving.
     *
     * @param array $input Raw settings.
     *
     * @return array
     */
    public function sanitize_settings( $input ) {
        $settings = healing_packages_get_settings();

        $settings['default_whatsapp'] = isset( $input['default_whatsapp'] ) ? sanitize_text_field( $input['default_whatsapp'] ) : '';
        $settings['message_template'] = isset( $input['message_template'] ) ? sanitize_textarea_field( $input['message_template'] ) : '';
        $settings['button_text']      = isset( $input['button_text'] ) ? sanitize_text_field( $input['button_text'] ) : '';

        return $settings;
    }

    /**
     * Render settings page HTML.
     */
    public function render_settings_page() {
        $settings = healing_packages_get_settings();
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'Healing Packages Settings', 'healing-packages' ); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'healing_packages_settings' );
                do_settings_sections( 'healing_packages_settings' );
                ?>
                <table class="form-table" role="presentation">
                    <tbody>
                    <tr>
                        <th scope="row"><label for="default_whatsapp"><?php esc_html_e( 'Default WhatsApp Number', 'healing-packages' ); ?></label></th>
                        <td>
                            <?php $this->render_input( [ 'id' => 'default_whatsapp' ], $settings ); ?>
                            <p class="description"><?php esc_html_e( 'Used when a package does not provide its own number.', 'healing-packages' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="message_template"><?php esc_html_e( 'Default Message Template', 'healing-packages' ); ?></label></th>
                        <td>
                            <?php $this->render_textarea( [ 'id' => 'message_template' ], $settings ); ?>
                            <p class="description"><?php esc_html_e( 'Placeholders: {package_name}, {hospital}, {procedure_type}, {hotel_category}', 'healing-packages' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="button_text"><?php esc_html_e( 'WhatsApp Button Text', 'healing-packages' ); ?></label></th>
                        <td>
                            <?php $this->render_input( [ 'id' => 'button_text' ], $settings ); ?>
                            <p class="description"><?php esc_html_e( 'Text shown on the booking button.', 'healing-packages' ); ?></p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Render a text input field.
     *
     * @param array $args Arguments.
     * @param array $settings Current settings.
     */
    public function render_input( $args, $settings = null ) {
        $settings = $settings ? $settings : healing_packages_get_settings();
        $id       = $args['id'];
        $value    = isset( $settings[ $id ] ) ? $settings[ $id ] : '';

        printf(
            '<input type="text" id="%1$s" name="healing_packages_settings[%1$s]" value="%2$s" class="regular-text" />',
            esc_attr( $id ),
            esc_attr( $value )
        );
    }

    /**
     * Render a textarea field.
     *
     * @param array $args Arguments.
     * @param array $settings Current settings.
     */
    public function render_textarea( $args, $settings = null ) {
        $settings = $settings ? $settings : healing_packages_get_settings();
        $id       = $args['id'];
        $value    = isset( $settings[ $id ] ) ? $settings[ $id ] : '';

        printf(
            '<textarea id="%1$s" name="healing_packages_settings[%1$s]" rows="4" class="large-text code">%2$s</textarea>',
            esc_attr( $id ),
            esc_textarea( $value )
        );
    }
}

<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Healing_Packages_Settings {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    public function add_settings_page() {
        add_options_page(
            __( 'Healing Packages Settings', 'healing-packages' ),
            __( 'Healing Packages', 'healing-packages' ),
            'manage_options',
            'healing-packages',
            array( $this, 'render_settings_page' )
        );
    }

    public function register_settings() {
        register_setting( 'healing_packages_settings_group', 'healing_packages_settings' );

        add_settings_section(
            'healing_packages_main',
            __( 'Main Settings', 'healing-packages' ),
            '__return_false',
            'healing-packages'
        );

        add_settings_field(
            'currency',
            __( 'Currency Symbol', 'healing-packages' ),
            array( $this, 'field_currency' ),
            'healing-packages',
            'healing_packages_main'
        );

        add_settings_field(
            'columns',
            __( 'Grid Columns (desktop)', 'healing-packages' ),
            array( $this, 'field_columns' ),
            'healing-packages',
            'healing_packages_main'
        );
    }

    public function field_currency() {
        $options  = get_option( 'healing_packages_settings', array() );
        $currency = isset( $options['currency'] ) ? $options['currency'] : '$';
        ?>
        <input type="text" name="healing_packages_settings[currency]" value="<?php echo esc_attr( $currency ); ?>" class="regular-text">
        <?php
    }

    public function field_columns() {
        $options = get_option( 'healing_packages_settings', array() );
        $columns = isset( $options['columns'] ) ? absint( $options['columns'] ) : 3;
        ?>
        <input type="number" min="1" max="4" name="healing_packages_settings[columns]" value="<?php echo esc_attr( $columns ); ?>">
        <?php
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php _e( 'Healing Packages Settings', 'healing-packages' ); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'healing_packages_settings_group' );
                do_settings_sections( 'healing-packages' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}

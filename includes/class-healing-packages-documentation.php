<?php
/**
 * Documentation page for Healing Packages.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Healing_Packages_Documentation {
    /**
     * Register hooks.
     */
    public function register_hooks() {
        add_action( 'admin_menu', [ $this, 'add_documentation_page' ] );
    }

    /**
     * Add a documentation submenu under the custom post type.
     */
    public function add_documentation_page() {
        add_submenu_page(
            'edit.php?post_type=healing_package',
            __( 'Healing Packages Documentation', 'healing-packages' ),
            __( 'Documentation', 'healing-packages' ),
            'manage_options',
            'healing_packages_docs',
            [ $this, 'render_documentation_page' ]
        );
    }

    /**
     * Render the documentation content.
     */
    public function render_documentation_page() {
        $shortcode_example = '[healing_packages columns="3" category="india"]';
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'Healing Packages Documentation', 'healing-packages' ); ?></h1>
            <p class="description"><?php esc_html_e( 'Quick reference for creating packages, using the shortcode, and customizing the WhatsApp message.', 'healing-packages' ); ?></p>

            <h2><?php esc_html_e( 'Create a Package', 'healing-packages' ); ?></h2>
            <ol>
                <li><?php esc_html_e( 'Go to Healing Packages → Add New.', 'healing-packages' ); ?></li>
                <li><?php esc_html_e( 'Fill in the hospital name, procedure type, hotel category, and short description.', 'healing-packages' ); ?></li>
                <li><?php esc_html_e( 'Add any additional services, trip duration, and cities. Each service on a new line.', 'healing-packages' ); ?></li>
                <li><?php esc_html_e( 'Set a featured image from the right sidebar if your theme supports it.', 'healing-packages' ); ?></li>
                <li><?php esc_html_e( 'Publish the package.', 'healing-packages' ); ?></li>
            </ol>

            <h2><?php esc_html_e( 'Display packages with the shortcode', 'healing-packages' ); ?></h2>
            <p>
                <?php
                printf(
                    wp_kses(
                        /* translators: %s shortcode example */
                        __( 'Place the %s shortcode inside any page or post.', 'healing-packages' ),
                        [ 'code' => [] ]
                    ),
                    '<code>[healing_packages]</code>'
                );
                ?>
            </p>
            <ul>
                <li><?php esc_html_e( 'Use the “columns” attribute to control the grid width (e.g., 2, 3, or 4).', 'healing-packages' ); ?></li>
                <li><?php esc_html_e( 'Use “category” to show a taxonomy term (slug).', 'healing-packages' ); ?></li>
                <li><?php esc_html_e( 'Use “ids” to show selected packages by ID, separated with commas.', 'healing-packages' ); ?></li>
                <li><?php esc_html_e( 'Each card now links to the full package page where visitors can view details before booking.', 'healing-packages' ); ?></li>
            </ul>
            <p><code><?php echo esc_html( $shortcode_example ); ?></code></p>

            <h2><?php esc_html_e( 'WhatsApp message placeholders', 'healing-packages' ); ?></h2>
            <p><?php esc_html_e( 'You can customize the message template from Settings → Healing Packages. Supported placeholders:', 'healing-packages' ); ?></p>
            <ul>
                <li><code>{package_name}</code></li>
                <li><code>{hospital}</code></li>
                <li><code>{procedure_type}</code></li>
                <li><code>{hotel_category}</code></li>
            </ul>
        </div>
        <?php
    }
}

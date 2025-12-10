<?php
/**
 * Shortcode rendering for Healing Packages.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Healing_Packages_Shortcode {
    /**
     * Template handler instance.
     *
     * @var Healing_Packages_Template
     */
    protected $template;

    /**
     * Constructor.
     *
     * @param Healing_Packages_Template $template Template handler.
     */
    public function __construct( Healing_Packages_Template $template ) {
        $this->template = $template;
    }

    /**
     * Register hooks.
     */
    public function register_hooks() {
        add_shortcode( 'healing_packages', [ $this, 'render_shortcode' ] );
    }

    /**
     * Render the shortcode output.
     *
     * @param array $atts Shortcode attributes.
     *
     * @return string
     */
    public function render_shortcode( $atts ) {
        Healing_Packages_Assets::enqueue_assets();

        $atts = shortcode_atts(
            [
                'columns'  => 3,
                'category' => '',
                'ids'      => '',
            ],
            $atts,
            'healing_packages'
        );

        $columns = max( 1, intval( $atts['columns'] ) );
        $ids     = $atts['ids'] ? array_map( 'intval', array_filter( array_map( 'trim', explode( ',', $atts['ids'] ) ) ) ) : [];

        $args = [
            'post_type'      => 'healing_package',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ];

        if ( $ids ) {
            $args['post__in'] = $ids;
        }

        if ( $atts['category'] ) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'healing_package_category',
                    'field'    => 'slug',
                    'terms'    => sanitize_title( $atts['category'] ),
                ],
            ];
        }

        $query = new WP_Query( $args );

        if ( ! $query->have_posts() ) {
            return '<p>' . esc_html__( 'No healing packages found.', 'healing-packages' ) . '</p>';
        }

        ob_start();

        echo '<div class="healing-packages-grid" style="--hp-columns:' . esc_attr( $columns ) . ';">';

        while ( $query->have_posts() ) {
            $query->the_post();
            $this->render_card( get_the_ID() );
        }

        echo '</div>';

        wp_reset_postdata();

        return ob_get_clean();
    }

    /**
     * Render a single package card.
     *
     * @param int $post_id Post ID.
     */
    protected function render_card( $post_id ) {
        $template = $this->template->get_template( 'package-card.php' );
        $data     = healing_packages_collect_package_data( $post_id );


        include $template;
    }
}

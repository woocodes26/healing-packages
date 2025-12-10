<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Healing_Packages_Shortcode {

    public function __construct() {
        add_shortcode( 'healing_packages', array( $this, 'render_shortcode' ) );
    }

    public function render_shortcode( $atts ) {
        $atts = shortcode_atts(
            array(
                'category' => '',
                'limit'    => -1,
                'order'    => 'DESC',
                'orderby'  => 'date',
            ),
            $atts,
            'healing_packages'
        );

        $args = array(
            'post_type'      => 'healing_package',
            'posts_per_page' => intval( $atts['limit'] ),
            'order'          => $atts['order'],
            'orderby'        => $atts['orderby'],
        );

        if ( ! empty( $atts['category'] ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'healing_package_cat',
                    'field'    => 'slug',
                    'terms'    => explode( ',', $atts['category'] ),
                ),
            );
        }

        $query = new WP_Query( $args );

        if ( ! $query->have_posts() ) {
            return '<p>' . esc_html__( 'No healing packages found.', 'healing-packages' ) . '</p>';
        }

        ob_start();

        $columns = absint( healing_packages_get_option( 'columns', 3 ) );
        $columns = $columns ? $columns : 3;
        ?>
        <div class="healing-packages-grid columns-<?php echo esc_attr( $columns ); ?>">
            <?php
            while ( $query->have_posts() ) :
                $query->the_post();
                Healing_Packages_Template::render_card( get_the_ID() );
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
        <?php

        return ob_get_clean();
    }
}

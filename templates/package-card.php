<?php
/**
 * Default package card template.
 *
 * Variables available:
 * $post_id, $price, $duration, $features_list, $currency
 */

?>
<article class="healing-package-card">
    <h3><?php echo esc_html( get_the_title( $post_id ) ); ?></h3>

    <?php if ( $price ) : ?>
        <div class="healing-package-price">
            <?php echo esc_html( $currency . ' ' . $price ); ?>
        </div>
    <?php endif; ?>

    <?php if ( $duration ) : ?>
        <div class="healing-package-duration">
            <?php echo esc_html( $duration ); ?>
        </div>
    <?php endif; ?>

    <div class="healing-package-content">
        <?php echo apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) ); ?>
    </div>

    <?php if ( ! empty( $features_list ) ) : ?>
        <ul class="healing-package-features">
            <?php foreach ( $features_list as $feature ) : ?>
                <li><?php echo esc_html( $feature ); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</article>

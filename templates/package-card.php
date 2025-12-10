<?php
/**
 * Package card template.
 *
 * @var array $data Data prepared for the template.
 */

do_action( 'healing_packages/before_card', $data );
?>
<article class="healing-package-card">
    <header class="healing-package-card__header">
        <h3 class="healing-package-card__title"><?php echo esc_html( $data['package_name'] ); ?></h3>
        <?php if ( $data['hospital_name'] ) : ?>
            <p class="healing-package-card__subtitle"><?php echo esc_html( $data['hospital_name'] ); ?></p>
        <?php endif; ?>
        <?php if ( $data['procedure_type'] ) : ?>
            <p class="healing-package-card__badge"><?php echo esc_html( $data['procedure_type'] ); ?></p>
        <?php endif; ?>
        <?php if ( $data['hotel_category'] ) : ?>
            <span class="healing-package-card__chip"><?php echo esc_html( $data['hotel_category'] ); ?></span>
        <?php endif; ?>
    </header>

    <?php if ( $data['general_desc'] ) : ?>
        <div class="healing-package-card__description">
            <?php echo wp_kses_post( wpautop( wp_trim_words( $data['general_desc'], 45, '…' ) ) ); ?>
        </div>
    <?php endif; ?>

    <?php if ( $data['services'] ) : ?>
        <ul class="healing-package-card__services">
            <?php foreach ( $data['services'] as $service ) : ?>
                <li><?php echo esc_html( $service ); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if ( $data['trip_duration'] || $data['cities'] ) : ?>
        <div class="healing-package-card__footer">
            <?php if ( $data['trip_duration'] ) : ?>
                <span class="healing-package-card__meta">
                    <?php echo esc_html( $data['trip_duration'] ); ?>
                </span>
            <?php endif; ?>
            <?php if ( $data['cities'] ) : ?>
                <span class="healing-package-card__meta">
                    <?php echo esc_html( $data['cities'] ); ?>
                </span>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ( $data['included_icons'] ) : ?>
        <ul class="healing-package-card__icons">
            <?php foreach ( $data['included_icons'] as $icon ) : ?>
                <li><?php echo esc_html( $icon ); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <div class="healing-package-card__actions">
        <a class="healing-package-card__button" href="<?php echo esc_url( $data['whatsapp_url'] ); ?>" target="_blank" rel="noopener">
            <?php echo esc_html( $data['button_text'] ); ?>
        </a>
    </div>
</article>
<?php
do_action( 'healing_packages/after_card', $data );

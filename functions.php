<?php

/**
 * SSI FANZINE Theme Setup
 */

function ssi_fanzine_setup() {

    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');

    add_theme_support('woocommerce');

    add_theme_support('wc-product-gallery-zoom');

    add_theme_support('wc-product-gallery-lightbox');

    add_theme_support('wc-product-gallery-slider');

    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'ssi-fanzine'),
        'footer'  => __('Footer Menu', 'ssi-fanzine'),
    ));
}

add_action('after_setup_theme', 'ssi_fanzine_setup');


/**
 * Load theme styles and scripts
 */

function ssi_fanzine_assets() {

    wp_enqueue_style(
        'ssi-fanzine-style',
        get_stylesheet_uri(),
        array(),
        '1.2.0'
    );

    wp_enqueue_script(
        'ssi-fanzine-menu',
        get_template_directory_uri() . '/assets/js/menu.js',
        array(),
        '1.2.0',
        true
    );
}

add_action('wp_enqueue_scripts', 'ssi_fanzine_assets');


/**
 * Output the first category label for a post.
 */

function ssi_fanzine_post_category_label() {

    $categories = get_the_category();

    if ( empty( $categories ) ) {
        return;
    }

    echo esc_html( $categories[0]->name );
}


/**
 * Reusable article card.
 */

function ssi_fanzine_article_card( $image_size = 'large' ) {
    ?>

    <article class="article-card">

        <?php if ( has_post_thumbnail() ) : ?>

            <a class="article-image" href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( $image_size ); ?>
            </a>

        <?php endif; ?>

        <div class="post-category">
            <?php ssi_fanzine_post_category_label(); ?>
        </div>

        <h3>
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>

        <p class="post-meta">
            <span class="meta-date"><?php echo esc_html( get_the_date() ); ?></span>
        </p>

    </article>

    <?php
}

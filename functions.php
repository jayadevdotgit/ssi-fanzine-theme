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
        'ssi-fanzine-fonts',
        'https://fonts.googleapis.com/css2?family=PT+Serif:wght@400;700&family=Roboto:wght@400;500;700&family=Roboto+Condensed:wght@400;500;700;800&display=swap',
        array(),
        null
    );

wp_enqueue_style(
        'ssi-fanzine-style',
        get_stylesheet_uri(),
        array(),
        filemtime( get_stylesheet_directory() . '/style.css' )
    );

    wp_enqueue_script(
        'ssi-fanzine-menu',
        get_template_directory_uri() . '/assets/js/menu.js',
        array(),
        filemtime( get_template_directory() . '/assets/js/menu.js' ),
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

function ssi_fanzine_search_icon() {
    echo '<svg class="search-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5" fill="none" stroke="currentColor" stroke-width="2"/><path d="M15.6 15.6 21 21" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>';
}

function ssi_fanzine_social_icon( $network ) {
    $paths = array(
        'facebook'  => '<path fill="currentColor" d="M14 8h3V5h-3c-2.8 0-4 1.7-4 4v2H8v3h2v6h3v-6h3l.5-3H13V9c0-.7.3-1 1-1z"/>',
        'x'         => '<path fill="currentColor" d="M5 4h3.2l3.1 4.2L14.8 4H19l-5.7 6.3L19.5 20h-3.2l-3.6-4.8L8.4 20H4l6.2-6.9L5 4zm2.5 2l8 12h1.5L9 6H7.5z"/>',
        'instagram' => '<rect x="4" y="4" width="16" height="16" rx="4" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="17.3" cy="6.8" r="1" fill="currentColor"/>',
        'youtube'   => '<path fill="currentColor" d="M21 8.2a2.8 2.8 0 00-2-2C17.2 5.7 12 5.7 12 5.7s-5.2 0-7 .5a2.8 2.8 0 00-2 2A29 29 0 002.5 12 29 29 0 003 15.8a2.8 2.8 0 002 2c1.8.5 7 .5 7 .5s5.2 0 7-.5a2.8 2.8 0 002-2 29 29 0 00.5-3.8 29 29 0 00-.5-3.8zM10 15.2V8.8l5.5 3.2-5.5 3.2z"/>',
    );
    echo '<svg class="social-svg" viewBox="0 0 24 24" aria-hidden="true">' . ( isset( $paths[ $network ] ) ? $paths[ $network ] : '' ) . '</svg>';
}

function ssi_fanzine_post_category_links() {
    $categories = get_the_category();
    if ( empty( $categories ) ) {
        return;
    }

    if ( count( $categories ) < 2 ) {
        return;
    }

    echo '<div class="post-categories">';
    foreach ( $categories as $category ) {
        echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
    }
    echo '</div>';
}


/**
 * Output a small inline sport icon (SVG) for a category slug.
 */

function ssi_fanzine_topic_icon( $slug = '' ) {

    $slug = strtolower( (string) $slug );
    $d    = '';

    switch ( $slug ) {
        case 'cricket':
            $d = 'M12 2a10 10 0 100 20 10 10 0 000-20zm0 3.2a6.8 6.8 0 110 13.6 6.8 6.8 0 010-13.6zM12 8.5l1.4.5 1.2 2.7-1.2 2.7-1.4.5-1.4-.5-1.2-2.7L10.6 9z';
            break;
        case 'football':
            $d = 'M12 2a10 10 0 100 20 10 10 0 000-20zm0 2.2l3 .9v3.4l-3 .9-3-.9V5.1zm1.5 9.6l-3 2.2-3-2.2 1.1-3.4h3.8zm-6 3.6l1.1-3.4-3-2.2-2.4.8A8 8 0 007.5 17.4zm9 0a8 8 0 005.8-4.8l-2.4-.8-3 2.2 1.1 3.4z';
            break;
        case 'hockey':
            $d = 'M4 20h4v-2H4zm5-2l10.5-10.5a2 2 0 000-2.8L18.3 3.6a2 2 0 00-2.8 0L5 14v4.8zm1.4-4.6l4.2-4.2 1.4 1.4-4.2 4.2z';
            break;
        case 'tennis':
            $d = 'M13 3a8 8 0 00-8 8c0 2 .7 3.3 1.8 4.4L14 22l2-2-7.2-7.2C7.3 11.3 7 10.2 7 9a6 6 0 116 6zm4 .5a1.2 1.2 0 101.7 1.7 1.2 1.2 0 00-1.7-1.7z';
            break;
        case 'f1':
        case 'formula':
            $d = 'M3 13l1.5-3.5L8 8l4 2h3l2.5-2H21l-2 4H7l3 2h7v2H6z';
            break;
        case 'badminton':
            $d = 'M12 3L8 7v7h2v6a2 2 0 004 0v-6h2V7z';
            break;
        case 'basketball':
            $d = 'M12 2a10 10 0 100 20 10 10 0 000-20zm-1 2.1A8 8 0 006 14.3l5-2.5V4.1zm2 0v6.1l5-2.5A8 8 0 0013 4.1zM12 14.4L6.8 16.9A8 8 0 0017.2 6.9L12.9 9.7v1.5z';
            break;
        case 'golf':
            $d = 'M12 2a5 5 0 00-5 5c0 2.2 1.4 4 3.4 4.7L9 21h2l1.2-9h-.2a3 3 0 010-4z';
            break;
        case 'motorsport':
        case 'racing':
            $d = 'M2 14h3l2-2h4l1 2h6a2 2 0 002-2v-2h-3l-3-3H9l-2 2H2z';
            break;
        default:
            $d = 'M12 2a10 10 0 100 20 10 10 0 000-20zm0 4a6 6 0 110 12 6 6 0 010-12z';
    }

    echo '<svg class="topic-svg" viewBox="0 0 24 24" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="' . esc_attr( $d ) . '"/></svg>';
}


/**
 * URL of the default placeholder image used when a post has no featured image.
 */

function ssi_fanzine_placeholder_url() {
    return get_template_directory_uri() . '/assets/images/placeholder.svg';
}


/**
 * Extract the first image URL from a post's content.
 */

function ssi_fanzine_content_image( $post_id = 0 ) {

    $post_id = $post_id ? $post_id : get_the_ID();
    $content = get_post_field( 'post_content', $post_id );

    // Priority 1: a real <img> src.
    if ( preg_match( '/<img[^>]+src=["\']([^"\']+)["\']/i', $content, $match ) ) {
        $url = $match[1];
        if ( 0 === strpos( $url, 'data:' ) || false !== strpos( $url, 'jeg-empty' ) ) {
            return '';
        }
        return $url;
    }

    // Priority 2: any uploads image URL referenced anywhere in the content.
    if ( preg_match( '#https?://[^\s"\')<>]+/(?:wp-content/)?uploads/[^\s"\')<>]+\.(?:jpe?g|png|webp|gif)#i', $content, $match ) ) {
        return $match[0];
    }

    // Priority 3: a relative uploads path.
    if ( preg_match( '#(?:wp-content/)?uploads/[^\s"\')<>]+\.(?:jpe?g|png|webp|gif)#i', $content, $match ) ) {
        return home_url( '/' ) . ltrim( $match[0], '/' );
    }

    return '';
}


/**
 * Output a post thumbnail image. Uses the featured image if set, otherwise the
 * first image found in the post content, and finally the default placeholder.
 */

function ssi_fanzine_post_thumb( $size = 'large', $post_id = 0 ) {

    $post_id = $post_id ? $post_id : get_the_ID();

    if ( has_post_thumbnail( $post_id ) ) {
        the_post_thumbnail( $size );
        return;
    }

    $content_image = ssi_fanzine_content_image( $post_id );

    if ( $content_image ) {
        echo '<img class="ssi-author-avatar attachment-content-image" src="' . esc_url( $content_image ) . '" alt="" loading="lazy" onerror="this.onerror=null;this.src=\'' . esc_url( ssi_fanzine_placeholder_url() ) . '\';">';
        return;
    }

    echo '<img class="attachment-placeholder" src="' . esc_url( ssi_fanzine_placeholder_url() ) . '" alt="" loading="lazy">';
}


/**
 * Output a small clock icon used beside post dates.
 */

function ssi_fanzine_clock_icon() {
    echo '<svg class="meta-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="8.5" fill="none" stroke="currentColor" stroke-width="1.7"/><path fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" d="M12 7.5V12l3 1.8"/></svg>';
}


/**
 * Handle newsletter subscription.
 */

function ssi_fanzine_handle_newsletter() {

    $redirect = wp_get_referer() ? wp_get_referer() : home_url( '/' );

    if (
        ! isset( $_POST['_wpnonce'] ) ||
        ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'ssi_fanzine_newsletter' )
    ) {
        wp_safe_redirect( add_query_arg( 'newsletter', 'invalid', $redirect ) );
        exit;
    }

    $email = isset( $_POST['ssi_fanzine_email'] ) ? sanitize_email( wp_unslash( $_POST['ssi_fanzine_email'] ) ) : '';

    if ( ! is_email( $email ) ) {
        wp_safe_redirect( add_query_arg( 'newsletter', 'invalid', $redirect ) );
        exit;
    }

    $emails = get_option( 'ssi_fanzine_newsletter_emails', array() );

    if ( ! in_array( $email, $emails, true ) ) {
        $emails[] = $email;
        update_option( 'ssi_fanzine_newsletter_emails', $emails, false );
    }

    wp_safe_redirect( add_query_arg( 'newsletter', 'success', $redirect ) );
    exit;
}

add_action( 'admin_post_ssi_fanzine_newsletter', 'ssi_fanzine_handle_newsletter' );
add_action( 'admin_post_nopriv_ssi_fanzine_newsletter', 'ssi_fanzine_handle_newsletter' );


/**
 * Newsletter subscription box.
 */

function ssi_fanzine_newsletter_box() {

    $status = isset( $_GET['newsletter'] ) ? sanitize_key( wp_unslash( $_GET['newsletter'] ) ) : '';
    ?>

    <section class="sidebar-section newsletter-section">

        <div class="section-title">
            <h2>Newsletter</h2>
        </div>

        <div class="newsletter-box">

            <?php if ( 'success' === $status ) : ?>
                <p class="newsletter-msg newsletter-msg-success">Thank you for subscribing!</p>
            <?php elseif ( 'invalid' === $status ) : ?>
                <p class="newsletter-msg newsletter-msg-error">Please enter a valid email address.</p>
            <?php endif; ?>

            <p class="newsletter-text">Get the latest sports stories straight to your inbox.</p>

            <form class="newsletter-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <input type="hidden" name="action" value="ssi_fanzine_newsletter">
                <?php wp_nonce_field( 'ssi_fanzine_newsletter' ); ?>
                <input class="newsletter-input" type="email" name="ssi_fanzine_email" placeholder="Enter your email" required>
                <button class="newsletter-button" type="submit">Subscribe</button>
            </form>

        </div>

    </section>

    <?php
}


/**
 * Build a term_id => count map for every category with at least one published post.
 * Cached for 12 hours on the front end.
 */

function ssi_fanzine_category_counts() {

    $counts = get_transient( 'ssi_fanzine_category_counts' );

    if ( false === $counts ) {

        $counts = array();
        $post_ids = get_posts(
            array(
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'fields'         => 'ids',
                'no_found_rows'  => true,
            )
        );

        foreach ( $post_ids as $post_id ) {
            foreach ( (array) get_the_category( $post_id ) as $cat ) {
                if ( 'uncategorized' === strtolower( $cat->slug ) ) {
                    continue;
                }

                $counts[ $cat->term_id ] = isset( $counts[ $cat->term_id ] ) ? $counts[ $cat->term_id ] + 1 : 1;
            }
        }

        set_transient( 'ssi_fanzine_category_counts', $counts, 12 * HOUR_IN_SECONDS );
    }

    return $counts;
}

/**
 * Remove width/height attributes from WooCommerce images to prevent forced cropping
 */
add_filter( 'woocommerce_single_product_image_thumbnail_html', function ( $html ) {
    return preg_replace( '/(width|height)="\d+"/i', '', $html );
}, 10, 1 );

add_filter( 'wp_get_attachment_image_attributes', function ( $attr ) {
    if ( isset( $attr['width'] ) && isset( $attr['height'] ) ) {
        unset( $attr['width'], $attr['height'] );
    }
    return $attr;
}, 999 );

/**
 * Disable WooCommerce hard crop for thumbnails
 */
add_filter( 'woocommerce_get_image_size_thumbnail', function ( $size ) {
    $size['crop'] = 0;
    return $size;
} );

add_filter( 'woocommerce_get_image_size_single', function ( $size ) {
    $size['crop'] = 0;
    return $size;
} );

add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function ( $size ) {
    $size['crop'] = 0;
    return $size;
} );

add_filter( 'woocommerce_get_image_size_shop_catalog', function ( $size ) {
    $size['crop'] = 0;
    return $size;
} );

add_filter( 'woocommerce_get_image_size_shop_single', function ( $size ) {
    $size['crop'] = 0;
    return $size;
} );

/**
 * Force the correct ₹ symbol for INR. Something outside this theme
 * (a plugin or a code snippet) appears to be overriding it with the
 * wrong character.
 *
 * The 'woocommerce_currency_symbol' filter alone wasn't enough — whatever
 * is introducing the wrong character is winning at that stage. So this
 * also catches it at the very last step: the final HTML string wc_price()
 * returns for every price on the site (shop, single product, cart,
 * checkout, emails). Whatever produced the wrong symbol, replacing it
 * right before it's output can't be overridden by anything upstream.
 */
add_filter( 'woocommerce_currency_symbol', function ( $currency_symbol, $currency ) {
    if ( 'INR' === $currency ) {
        return '&#8377;'; // ₹
    }
    return $currency_symbol;
}, PHP_INT_MAX, 2 );

add_filter( 'wc_price', function ( $return, $price, $args ) {
    // U+20B1 (₱ Philippine Peso) shown in place of U+20B9 (₹ Indian Rupee).
    $return = str_replace( array( '₱', '&#8369;', '&#x20B1;' ), '₹', $return );
    return $return;
}, PHP_INT_MAX, 3 );

/**
 * Keep the two cart-count badges (main nav + mobile bottom-tab-bar) in
 * sync after an AJAX add-to-cart. They're rendered once in PHP on page
 * load, so with no page reload nothing was telling them to update — this
 * registers them as WooCommerce "cart fragments", which the built-in
 * add-to-cart script automatically re-fetches and swaps in after every
 * successful add, no page refresh needed.
 */
add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {

    if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
        return $fragments;
    }

    $count = WC()->cart->get_cart_contents_count();

    $fragments['span.nav-cart-count']    = '<span class="nav-cart-count">' . esc_html( $count ) . '</span>';
    $fragments['span.bottom-cart-count'] = '<span class="bottom-cart-count">' . esc_html( $count ) . '</span>';

    return $fragments;
} );



/**
 * Resolve the permalink for a WordPress page by slug, falling back to a URL.
 */

function ssi_fanzine_page_url( $slug = '', $fallback = '' ) {

    if ( $slug ) {
        $page = get_page_by_path( $slug );
        if ( $page ) {
            return get_permalink( $page );
        }
    }

    return $fallback ? $fallback : home_url( '/' );
}


/**
 * Resolve the posts index / magazine URL.
 */

function ssi_fanzine_posts_url() {

    $posts_page_id = get_option( 'page_for_posts' );

    if ( $posts_page_id ) {
        return get_permalink( $posts_page_id );
    }

    return home_url( '/?post_type=post' );
}


/**
 * Normalize a category name for display: title-case each word but keep
 * common acronyms (F1, IPL, MMA, etc.) uppercase.
 */

function ssi_fanzine_cat_title( $name = '' ) {

    $name    = (string) $name;
    $acronyms = array( 'f1', 'ipl', 'mma', 'ufc', 'wwe', 'ufa', 'uefa', 'nba', 'nfl', 'nhl', 'bwf', 'u17', 'u20', 'fifa' );
    $parts   = preg_split( '/(\s+)/', $name, -1, PREG_SPLIT_DELIM_CAPTURE );

    foreach ( $parts as &$part ) {
        if ( '' === trim( $part ) ) {
            continue;
        }
        if ( in_array( strtolower( $part ), $acronyms, true ) ) {
            $part = strtoupper( $part );
        } else {
            $part = ucwords( strtolower( $part ) );
        }
    }

    return implode( '', $parts );
}


/**
 * Return the top N categories by real post count, sorted descending.
 * Each entry: name, slug, link, count.
 */

function ssi_fanzine_top_categories( $number = 6 ) {

    $counts = ssi_fanzine_category_counts();

    if ( empty( $counts ) ) {
        $cats = get_categories( array( 'hide_empty' => true, 'number' => $number, 'exclude' => get_cat_ID( 'Uncategorized' ) ) );
        $out  = array();
        foreach ( $cats as $cat ) {
            $out[] = array(
                'name'  => ssi_fanzine_cat_title( $cat->name ),
                'slug'  => $cat->slug,
                'link'  => get_category_link( $cat->term_id ),
                'count' => $cat->count,
            );
        }
        return $out;
    }

    arsort( $counts, SORT_NUMERIC );
    $out       = array();
    $counter   = 0;
    foreach ( $counts as $term_id => $count ) {
        if ( $counter >= $number ) {
            break;
        }
        $term = get_term( $term_id );
        if ( ! $term || 'uncategorized' === strtolower( $term->slug ) ) {
            continue;
        }
        $out[] = array(
            'name'  => ssi_fanzine_cat_title( $term->name ),
            'slug'  => $term->slug,
            'link'  => get_category_link( $term_id ),
            'count' => $count,
        );
        $counter++;
    }

    return $out;
}


/**
 * Extract a YouTube video ID from post content.
 */

function ssi_fanzine_video_id_from_content( $content = '' ) {

    if ( preg_match( '#(?:youtube\.com/(?:embed|shorts|v)/|youtu\.be/)([A-Za-z0-9_-]{6,15})#i', (string) $content, $match ) ) {
        return $match[1];
    }

    return '';
}


/**
 * Reusable video card.
 */

function ssi_fanzine_video_card() {

    $post_id    = get_the_ID();
    $content    = get_post_field( 'post_content', $post_id );
    $video_id   = ssi_fanzine_video_id_from_content( $content );
    $thumbnail  = '';

    if ( $video_id ) {
        $thumbnail = 'https://i.ytimg.com/vi/' . $video_id . '/hqdefault.jpg';
    } elseif ( has_post_thumbnail( $post_id ) ) {
        $thumbnail = get_the_post_thumbnail_url( $post_id, 'medium_large' );
    } else {
        $thumbnail = ssi_fanzine_placeholder_url();
    }
    ?>

    <article class="video-card">

        <a class="video-thumb" href="<?php the_permalink(); ?>">
            <img class="video-image" src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy">
            <span class="video-play" aria-hidden="true"></span>
        </a>

        <div class="post-category"><?php ssi_fanzine_post_category_label(); ?></div>

        <h3>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <p class="post-meta">
            <span class="meta-date"><span class="meta-date-inner"><?php ssi_fanzine_clock_icon(); ?><?php echo esc_html( get_the_date() ); ?></span></span>
        </p>

    </article>

    <?php
}


/**
 * Estimated read time for a post in minutes.
 */

function ssi_fanzine_read_time( $post_id = 0 ) {

    $post_id = $post_id ? $post_id : get_the_ID();
    $content = wp_strip_all_tags( get_post_field( 'post_content', $post_id ) );
    $words   = str_word_count( $content );
    $minutes = max( 1, (int) round( $words / 200 ) );

    return sprintf( _n( '%d min read', '%d min read', $minutes, 'ssi-fanzine' ), $minutes );
}


/**
 * Relative "x ago" time for a post.
 */

function ssi_fanzine_relative_time( $post_id = 0 ) {

    $post_id = $post_id ? $post_id : get_the_ID();
    $diff    = human_time_diff( get_post_time( 'U', true, $post_id ), current_time( 'timestamp' ) );

    return $diff . ' ago';
}


/**
 * Compact author byline (avatar + name).
 */

function ssi_fanzine_author_byline( $post_id = 0 ) {
    $post_id = $post_id ? $post_id : get_the_ID();
    ?>
    <span class="entry-author">
        <span class="entry-avatar"><?php echo ssi_fanzine_author_avatar_html( get_post_field( 'post_author', $post_id ), 22, 'ssi-card-author-avatar' ); ?></span>
        <span class="entry-name"><?php echo esc_html( get_the_author_meta( 'display_name', get_post_field( 'post_author', $post_id ) ) ); ?></span>
    </span>
    <?php
}


/**
 * Output a premium card meta row: byline, date, read time.
 */

function ssi_fanzine_card_meta() {
    ?>
    <p class="card-meta">
        <span class="card-byline"><?php ssi_fanzine_author_byline(); ?></span>
        <span class="card-date"><?php echo esc_html( ssi_fanzine_relative_time() ); ?></span>
        <span class="card-read"><?php echo esc_html( ssi_fanzine_read_time() ); ?></span>
    </p>
    <?php
}


/**
 * Reusable article card.
 */

function ssi_fanzine_article_card( $image_size = 'large' ) {
    ?>

    <article class="article-card">

        <a class="article-image" href="<?php the_permalink(); ?>">
            <?php ssi_fanzine_post_thumb( $image_size ); ?>
        </a>

        <div class="post-category">
            <?php ssi_fanzine_post_category_label(); ?>
        </div>

        <h3>
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>

        <?php ssi_fanzine_post_category_links(); ?>

        <?php ssi_fanzine_card_meta(); ?>

    </article>

    <?php
}


/**
 * Render a single magazine (WooCommerce product) card for the homepage carousel.
 */

function ssi_fanzine_magazine_card( $product ) {

    if ( ! $product instanceof WC_Product ) {
        return;
    }

    $badge = '';
    if ( $product->is_on_sale() ) {
        $badge = __( 'Sale', 'ssi-fanzine' );
    } elseif ( ( time() - get_post_time( 'U', true, $product->get_id() ) ) < ( 30 * DAY_IN_SECONDS ) ) {
        $badge = __( 'New', 'ssi-fanzine' );
    }
    ?>

    <article class="magazine-item">

        <a class="magazine-thumb" href="<?php echo esc_url( $product->get_permalink() ); ?>">
            <?php if ( $badge ) : ?>
                <span class="magazine-item-badge"><?php echo esc_html( $badge ); ?></span>
            <?php endif; ?>
            <?php echo wp_kses_post( $product->get_image( 'medium' ) ); ?>
        </a>

        <div class="magazine-item-body">
            <h4><a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h4>
            <div class="magazine-item-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
            <a class="magazine-item-cta" href="<?php echo esc_url( $product->get_permalink() ); ?>">
                <?php echo $product->is_purchasable() && $product->is_in_stock() ? esc_html__( 'View Issue', 'ssi-fanzine' ) : esc_html__( 'View', 'ssi-fanzine' ); ?>
            </a>
        </div>

    </article>

    <?php
}


/**
 * Render a manually curated external video card.
 */

function ssi_fanzine_external_video_card( $title, $url, $video_id = '', $category = 'Videos', $image_url = '' ) {

    $thumbnail = $image_url ? $image_url : ( $video_id ? 'https://i.ytimg.com/vi/' . $video_id . '/hqdefault.jpg' : ssi_fanzine_placeholder_url() );
    ?>

    <article class="video-card">
        <a class="video-thumb" href="<?php echo esc_url( $url ); ?>">
            <img class="video-image" src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy">
            <span class="video-play" aria-hidden="true"></span>
        </a>
        <div class="post-category"><?php echo esc_html( $category ); ?></div>
        <h3><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $title ); ?></a></h3>
    </article>

    <?php
}

/* SSI FANZINE POST SUBTITLE */

/**
 * Display the SSI FANZINE subtitle field directly below the title
 * on the Classic Editor post edit screen.
 */
if ( ! function_exists( 'ssi_fanzine_post_subtitle_field' ) ) {
    function ssi_fanzine_post_subtitle_field( $post ) {
        if ( ! $post || 'post' !== $post->post_type ) {
            return;
        }

        $subtitle = get_post_meta( $post->ID, '_ssi_fanzine_subtitle', true );
        $nonce    = wp_create_nonce( 'ssi_fanzine_subtitle_' . $post->ID );
        ?>
        <div id="ssi-fanzine-subtitle-wrap" style="margin: 12px 0 16px;">
            <label for="ssi_fanzine_subtitle" class="screen-reader-text"><?php esc_html_e( 'Add subtitle', 'ssi-fanzine' ); ?></label>
            <input
                type="text"
                id="ssi_fanzine_subtitle"
                name="ssi_fanzine_subtitle"
                value="<?php echo esc_attr( $subtitle ); ?>"
                placeholder="<?php echo esc_attr__( 'Add subtitle', 'ssi-fanzine' ); ?>"
                autocomplete="off"
                style="width:100%;box-sizing:border-box;padding:8px 10px;font-size:16px;line-height:1.5;border:1px solid #8c8f94;border-radius:3px;background:#fff;"
            />
            <input type="hidden" name="ssi_fanzine_subtitle_nonce" value="<?php echo esc_attr( $nonce ); ?>">
        </div>
        <?php
    }
}

/*
 * edit_form_after_title is supported by the Classic Editor and places
 * the field after the title/permalink area and before the main editor.
 */
add_action( 'edit_form_after_title', 'ssi_fanzine_post_subtitle_field' );


if ( ! function_exists( 'ssi_fanzine_save_post_subtitle' ) ) {
    function ssi_fanzine_save_post_subtitle( $post_id ) {
        if ( ! isset( $_POST['ssi_fanzine_subtitle_nonce'] ) ) {
            return;
        }

        $nonce = sanitize_text_field( wp_unslash( $_POST['ssi_fanzine_subtitle_nonce'] ) );

        if ( ! wp_verify_nonce( $nonce, 'ssi_fanzine_subtitle_' . $post_id ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( wp_is_post_revision( $post_id ) ) {
            return;
        }

        if ( 'post' !== get_post_type( $post_id ) ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        $subtitle = isset( $_POST['ssi_fanzine_subtitle'] )
            ? sanitize_text_field( wp_unslash( $_POST['ssi_fanzine_subtitle'] ) )
            : '';

        if ( '' === $subtitle ) {
            delete_post_meta( $post_id, '_ssi_fanzine_subtitle' );
        } else {
            update_post_meta( $post_id, '_ssi_fanzine_subtitle', $subtitle );
        }
    }
}

add_action( 'save_post_post', 'ssi_fanzine_save_post_subtitle' );

/* =========================================================
 * SSI FANZINE ARCHIVE POSTS PER PAGE
 * =========================================================
 *
 * Keep the archive grid aligned with the desktop 4-column layout.
 * Twelve posts per page gives three complete rows.
 */
if ( ! function_exists( 'ssi_fanzine_archive_posts_per_page' ) ) {
    function ssi_fanzine_archive_posts_per_page( $query ) {
        if ( is_admin() || ! $query->is_main_query() ) {
            return;
        }

        /*
         * Apply to front-end post archives where the theme's 4-column
         * grid is used. This includes author, category, tag, date,
         * search and the main blog/home archive query.
         */
        if (
            $query->is_home() ||
            $query->is_archive() ||
            $query->is_search()
        ) {
            $query->set( 'posts_per_page', 12 );
        }
    }
}
add_action( 'pre_get_posts', 'ssi_fanzine_archive_posts_per_page', 20 );

/* =========================================================
 * SSI FANZINE AUTHOR PROFILE PICTURE
 * ========================================================= */

if ( ! function_exists( 'ssi_fanzine_author_profile_picture_field' ) ) {
    function ssi_fanzine_author_profile_picture_field( $user ) {
        if ( ! current_user_can( 'upload_files' ) ) {
            return;
        }

        $attachment_id = (int) get_user_meta( $user->ID, '_ssi_fanzine_author_profile_picture', true );
        $image_url     = $attachment_id ? wp_get_attachment_image_url( $attachment_id, 'thumbnail' ) : '';
        ?>
        <h2><?php esc_html_e( 'SSI FANZINE Author Profile Picture', 'ssi-fanzine' ); ?></h2>
        <table class="form-table" role="presentation">
            <tr>
                <th><label for="ssi_fanzine_author_profile_picture"><?php esc_html_e( 'Profile Picture', 'ssi-fanzine' ); ?></label></th>
                <td>
                    <div id="ssi-fanzine-author-picture-preview" style="margin-bottom:10px;">
                        <?php if ( $image_url ) : ?>
                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( get_the_author_meta( 'display_name', $author->ID ) ); ?>" width="120" height="120" loading="lazy" style="width:120px;height:120px;object-fit:cover;border-radius:50%;display:block;">
                        <?php else : ?>
                            <div style="width:120px;height:120px;background:#f0f0f1;border:1px solid #dcdcde;display:flex;align-items:center;justify-content:center;border-radius:50%;color:#646970;">No photo</div>
                        <?php endif; ?>
                    </div>

                    <input type="hidden" id="ssi_fanzine_author_profile_picture" name="ssi_fanzine_author_profile_picture" value="<?php echo esc_attr( $attachment_id ); ?>">

                    <button type="button" class="button" id="ssi-fanzine-upload-author-picture">
                        <?php echo $attachment_id ? esc_html__( 'Change Profile Picture', 'ssi-fanzine' ) : esc_html__( 'Upload Profile Picture', 'ssi-fanzine' ); ?>
                    </button>

                    <?php if ( $attachment_id ) : ?>
                        <button type="button" class="button" id="ssi-fanzine-remove-author-picture" style="margin-left:6px;">Remove</button>
                    <?php endif; ?>

                    <p class="description">Upload an author photo from the WordPress Media Library. Recommended: square image, at least 300 × 300 px.</p>
                </td>
            </tr>
        </table>
        <?php
    }
}
add_action( 'show_user_profile', 'ssi_fanzine_author_profile_picture_field' );
add_action( 'edit_user_profile', 'ssi_fanzine_author_profile_picture_field' );

if ( ! function_exists( 'ssi_fanzine_save_author_profile_picture' ) ) {
    function ssi_fanzine_save_author_profile_picture( $user_id ) {
        if ( ! current_user_can( 'edit_user', $user_id ) || ! isset( $_POST['ssi_fanzine_author_profile_picture'] ) ) {
            return;
        }

        $attachment_id = absint( $_POST['ssi_fanzine_author_profile_picture'] );

        if ( $attachment_id ) {
            update_user_meta( $user_id, '_ssi_fanzine_author_profile_picture', $attachment_id );
        } else {
            delete_user_meta( $user_id, '_ssi_fanzine_author_profile_picture' );
        }
    }
}
add_action( 'personal_options_update', 'ssi_fanzine_save_author_profile_picture' );
add_action( 'edit_user_profile_update', 'ssi_fanzine_save_author_profile_picture' );

if ( ! function_exists( 'ssi_fanzine_author_profile_picture_admin_assets' ) ) {
    function ssi_fanzine_author_profile_picture_admin_assets( $hook_suffix ) {
        if ( 'profile.php' !== $hook_suffix && 'user-edit.php' !== $hook_suffix ) {
            return;
        }

        wp_enqueue_media();
        wp_enqueue_script( 'jquery' );

        $js = <<<'JS'
jQuery(function($) {
    var frame;

    $(document).on('click', '#ssi-fanzine-upload-author-picture', function(e) {
        e.preventDefault();

        if (frame) {
            frame.open();
            return;
        }

        frame = wp.media({
            title: 'Choose Author Profile Picture',
            button: { text: 'Use This Picture' },
            multiple: false,
            library: { type: 'image' }
        });

        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            $('#ssi_fanzine_author_profile_picture').val(attachment.id);

            var url = attachment.sizes && attachment.sizes.thumbnail
                ? attachment.sizes.thumbnail.url
                : attachment.url;

            var img = $('<img>', {
                src: url,
                alt: ''
            }).css({
                width: '120px',
                height: '120px',
                objectFit: 'cover',
                borderRadius: '50%',
                display: 'block'
            });

            $('#ssi-fanzine-author-picture-preview').empty().append(img);
            $('#ssi-fanzine-upload-author-picture').text('Change Profile Picture');

            if (!$('#ssi-fanzine-remove-author-picture').length) {
                $('#ssi-fanzine-upload-author-picture').after(
                    '<button type="button" class="button" id="ssi-fanzine-remove-author-picture" style="margin-left:6px;">Remove</button>'
                );
            }
        });

        frame.open();
    });

    $(document).on('click', '#ssi-fanzine-remove-author-picture', function(e) {
        e.preventDefault();

        $('#ssi_fanzine_author_profile_picture').val('');
        $('#ssi-fanzine-author-picture-preview').html(
            '<div style="width:120px;height:120px;background:#f0f0f1;border:1px solid #dcdcde;display:flex;align-items:center;justify-content:center;border-radius:50%;color:#646970;">No photo</div>'
        );

        $(this).remove();
        $('#ssi-fanzine-upload-author-picture').text('Upload Profile Picture');
    });
});
JS;

        wp_add_inline_script( 'jquery', $js );
    }
}
add_action( 'admin_enqueue_scripts', 'ssi_fanzine_author_profile_picture_admin_assets' );

if ( ! function_exists( 'ssi_fanzine_get_author_profile_picture_url' ) ) {
    function ssi_fanzine_get_author_profile_picture_url( $user_id = 0, $size = 'thumbnail' ) {
        $user_id = $user_id ? absint( $user_id ) : get_the_author_meta( 'ID' );
        $attachment_id = (int) get_user_meta( $user_id, '_ssi_fanzine_author_profile_picture', true );

        return $attachment_id ? wp_get_attachment_image_url( $attachment_id, $size ) : '';
    }
}

if ( ! function_exists( 'ssi_fanzine_avatar_url_override' ) ) {
    function ssi_fanzine_avatar_url_override( $args ) {
        if ( empty( $args['user_id'] ) ) {
            return $args;
        }

        $custom_url = ssi_fanzine_get_author_profile_picture_url( (int) $args['user_id'], 'thumbnail' );

        if ( $custom_url ) {
            $args['url'] = $custom_url;
        }

        return $args;
    }
}
add_filter( 'pre_get_avatar_data', 'ssi_fanzine_avatar_url_override', 10, 1 );

/* =========================================================
 * SSI FANZINE AUTHOR AVATAR HTML HELPER
 * ========================================================= */

if ( ! function_exists( 'ssi_fanzine_author_avatar_html' ) ) {
    function ssi_fanzine_author_avatar_html( $user_id = 0, $size = 32, $class = 'ssi-card-author-avatar' ) {
        $user_id = $user_id ? absint( $user_id ) : get_the_author_meta( 'ID' );
        $custom_url = ssi_fanzine_get_author_profile_picture_url( $user_id, 'thumbnail' );

        if ( $custom_url ) {
            $name = get_the_author_meta( 'display_name', $user_id );

            return sprintf(
                '<img class="%1$s" src="%2$s" alt="%3$s" width="%4$d" height="%4$d" loading="lazy">',
                esc_attr( $class ),
                esc_url( $custom_url ),
                esc_attr( $name ),
                absint( $size )
            );
        }

        return get_avatar( $user_id, $size, '', '', array(
            'class' => $class,
        ) );
    }
}

/* =========================================================
 * SSI FANZINE DYNAMIC AUTHORS DIRECTORY
 * ========================================================= */

if ( ! function_exists( 'ssi_fanzine_render_authors_directory' ) ) {
    function ssi_fanzine_render_authors_directory() {
        if ( is_admin() ) {
            return;
        }

        $request_path = wp_parse_url( $_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH );
        $request_path = trim( (string) $request_path, '/' );

        if ( 'authors' !== $request_path || ! is_404() ) {
            return;
        }

        status_header( 200 );
        nocache_headers();

        $authors_template = get_theme_file_path( 'authors.php' );

        if ( file_exists( $authors_template ) ) {
            include $authors_template;
            exit;
        }
    }
}
add_action( 'template_redirect', 'ssi_fanzine_render_authors_directory', 1 );


/* SSI FANZINE VIDEO CATEGORY ARCHIVE */
if ( ! function_exists( 'ssi_fanzine_render_video_category_cards' ) ) {
    function ssi_fanzine_render_video_category_cards() {
        $featured_videos = array(
            array( 'title' => 'Groundbreaking ACL Reconstruction | Jewel ACL Technology in Action | Dr. Sarthak Patnaik', 'url' => 'https://youtu.be/-L5wW_lPmUM', 'id' => '-L5wW_lPmUM', 'cat' => 'Sports Science' ),
            array( 'title' => 'What Causes PCL Tears, and How Can They Be Treated? Dr. Sarthak Patnaik Explains', 'url' => 'https://youtu.be/z1_9wM8FdU4', 'id' => 'z1_9wM8FdU4', 'cat' => 'Injury & Recovery' ),
            array( 'title' => 'Posterior Shoulder Pain | Posterior Bankart Repair | Posterior SLAP Tear', 'url' => 'https://youtu.be/IS_G1RWmp3w', 'id' => 'IS_G1RWmp3w', 'cat' => 'Injury & Recovery' ),
            array( 'title' => 'ACL Reconstruction | Meniscus Repair | Both Knee | Dr. Sarthak Patnaik', 'url' => 'https://youtu.be/GQanF1HLwFo', 'id' => 'GQanF1HLwFo', 'cat' => 'Videos' ),
        );

        foreach ( $featured_videos as $featured_video ) {
            ssi_fanzine_external_video_card(
                $featured_video['title'],
                $featured_video['url'],
                $featured_video['id'],
                $featured_video['cat'],
                isset( $featured_video['image'] ) ? $featured_video['image'] : ''
            );
        }
    }
}


/* =========================================================
 * SSI FANZINE SEO ENHANCEMENTS
 * ========================================================= */

/**
 * Output a lightweight breadcrumb trail on singular posts.
 */
if ( ! function_exists( 'ssi_fanzine_breadcrumbs' ) ) {
    function ssi_fanzine_breadcrumbs() {
        if ( ! is_singular( 'post' ) ) {
            return;
        }

        $categories = get_the_category();
        ?>
        <nav class="ssi-breadcrumbs" aria-label="Breadcrumb">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
            <span aria-hidden="true">/</span>
            <?php if ( ! empty( $categories ) ) : ?>
                <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>">
                    <?php echo esc_html( $categories[0]->name ); ?>
                </a>
                <span aria-hidden="true">/</span>
            <?php endif; ?>
            <span aria-current="page"><?php echo esc_html( get_the_title() ); ?></span>
        </nav>
        <?php
    }
}

/**
 * Related posts: prefer shared tags, then same category, then recent posts.
 * This replaces random recommendations with deterministic, relevant links.
 */
if ( ! function_exists( 'ssi_fanzine_get_related_posts' ) ) {
    function ssi_fanzine_get_related_posts( $post_id = 0, $limit = 4 ) {
        $post_id = $post_id ? absint( $post_id ) : get_the_ID();
        $limit   = max( 1, absint( $limit ) );
        $related_ids = array();

        $tag_ids = wp_get_post_terms( $post_id, 'post_tag', array( 'fields' => 'ids' ) );
        if ( ! is_wp_error( $tag_ids ) && ! empty( $tag_ids ) ) {
            $tag_query = new WP_Query( array(
                'post_type'              => 'post',
                'post_status'            => 'publish',
                'posts_per_page'         => $limit * 2,
                'post__not_in'           => array( $post_id ),
                'tag__in'                => array_map( 'absint', $tag_ids ),
                'orderby'                => 'date',
                'order'                  => 'DESC',
                'ignore_sticky_posts'    => true,
                'no_found_rows'          => true,
                'fields'                 => 'ids',
                'update_post_meta_cache' => false,
                'update_post_term_cache' => false,
            ) );
            $related_ids = array_map( 'absint', $tag_query->posts );
        }

        if ( count( $related_ids ) < $limit ) {
            $category_ids = wp_get_post_categories( $post_id );
            if ( ! empty( $category_ids ) ) {
                $category_query = new WP_Query( array(
                    'post_type'              => 'post',
                    'post_status'            => 'publish',
                    'posts_per_page'         => $limit * 2,
                    'post__not_in'           => array_merge( array( $post_id ), $related_ids ),
                    'category__in'           => array_map( 'absint', $category_ids ),
                    'orderby'                => 'date',
                    'order'                  => 'DESC',
                    'ignore_sticky_posts'    => true,
                    'no_found_rows'          => true,
                    'fields'                 => 'ids',
                    'update_post_meta_cache' => false,
                    'update_post_term_cache' => false,
                ) );
                $related_ids = array_merge( $related_ids, array_map( 'absint', $category_query->posts ) );
            }
        }

        // Final fallback keeps the component populated on very small sites/categories.
        if ( count( $related_ids ) < $limit ) {
            $recent_query = new WP_Query( array(
                'post_type'              => 'post',
                'post_status'            => 'publish',
                'posts_per_page'         => $limit - count( $related_ids ),
                'post__not_in'           => array_merge( array( $post_id ), $related_ids ),
                'orderby'                => 'date',
                'order'                  => 'DESC',
                'ignore_sticky_posts'    => true,
                'no_found_rows'          => true,
                'fields'                 => 'ids',
                'update_post_meta_cache' => false,
                'update_post_term_cache' => false,
            ) );
            $related_ids = array_merge( $related_ids, array_map( 'absint', $recent_query->posts ) );
        }

        return array_slice( array_values( array_unique( $related_ids ) ), 0, $limit );
    }
}


/* =========================================================
 * SSI FANZINE IMAGE ACCESSIBILITY / PERFORMANCE HELPERS
 * ========================================================= */

if ( ! function_exists( 'ssi_fanzine_image_attributes' ) ) {
    function ssi_fanzine_image_attributes( $attr, $attachment, $size ) {
        if ( empty( $attr['alt'] ) ) {
            $alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
            if ( '' === $alt ) {
                $alt = get_the_title( $attachment->ID );
            }
            if ( $alt ) {
                $attr['alt'] = wp_strip_all_tags( $alt );
            }
        }

        return $attr;
    }
}
add_filter( 'wp_get_attachment_image_attributes', 'ssi_fanzine_image_attributes', 10, 3 );

/**
 * Fallback structured data for installations where SEOPress is not active.
 * If SEOPress is active, its schema system remains the single source of truth.
 */
if ( ! function_exists( 'ssi_fanzine_fallback_schema' ) ) {
    function ssi_fanzine_fallback_schema() {
        if ( is_admin() || defined( 'SEOPRESS_VERSION' ) || function_exists( 'seopress_get_service' ) ) {
            return;
        }

        $graph = array();
        $logo_url = '';
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        if ( $custom_logo_id ) {
            $logo_url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
        }

        $publisher = array(
            '@type' => 'Organization',
            '@id'   => home_url( '/#organization' ),
            'name'  => get_bloginfo( 'name' ),
            'url'   => home_url( '/' ),
        );
        if ( $logo_url ) {
            $publisher['logo'] = array( '@type' => 'ImageObject', 'url' => $logo_url );
        }

        if ( is_singular( 'post' ) ) {
            $post_id = get_queried_object_id();
            $image = get_the_post_thumbnail_url( $post_id, 'full' );
            $description = wp_strip_all_tags( get_the_excerpt( $post_id ) );
            $article = array(
                '@type'            => 'NewsArticle',
                '@id'              => get_permalink( $post_id ) . '#article',
                'mainEntityOfPage' => array( '@type' => 'WebPage', '@id' => get_permalink( $post_id ) ),
                'headline'         => wp_strip_all_tags( get_the_title( $post_id ) ),
                'description'      => $description,
                'datePublished'    => get_the_date( DATE_W3C, $post_id ),
                'dateModified'     => get_the_modified_date( DATE_W3C, $post_id ),
                'author'           => array(
                    '@type' => 'Person',
                    'name'  => get_the_author_meta( 'display_name', (int) get_post_field( 'post_author', $post_id ) ),
                    'url'   => get_author_posts_url( (int) get_post_field( 'post_author', $post_id ) ),
                ),
                'publisher'        => $publisher,
            );
            if ( $image ) {
                $article['image'] = array( $image );
            }
            $graph[] = $article;
        } elseif ( is_front_page() || is_home() ) {
            $graph[] = array(
                '@type' => 'WebSite',
                '@id'   => home_url( '/#website' ),
                'url'   => home_url( '/' ),
                'name'  => get_bloginfo( 'name' ),
                'publisher' => $publisher,
            );
            $graph[] = $publisher;
        }

        if ( empty( $graph ) ) {
            return;
        }

        echo '<script type="application/ld+json">' . wp_json_encode( array(
            '@context' => 'https://schema.org',
            '@graph'   => $graph,
        ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>\n';
    }
}
add_action( 'wp_head', 'ssi_fanzine_fallback_schema', 5 );

<?php
/**
 * SSI FANZINE Footer
 */
?>

</main>

<footer class="site-footer">

    <div class="site-container footer-inner">

        <div class="footer-brand">

            <a
                class="site-logo"
                href="<?php echo esc_url( home_url( '/' ) ); ?>"
            >
                <span class="logo-mark">
                    <span class="logo-rule" aria-hidden="true"></span>
                    <span class="logo-ssi">SSI</span>
                    <span class="logo-rule" aria-hidden="true"></span>
                </span>
                <span class="logo-title">Fanzine</span>
            </a>

            <p class="footer-description">
                <?php bloginfo( 'description' ); ?>
            </p>

        </div>

        <nav class="footer-links" aria-label="<?php esc_attr_e( 'Footer navigation', 'ssi-fanzine' ); ?>">
            <strong>Quick Links</strong>
            <?php
            $quick_links_menu = wp_nav_menu(
                array(
                    'theme_location' => 'footer',
                    'container'      => false,
                    'fallback_cb'    => false,
                    'items_wrap'     => '%3$s',
                    'depth'          => 1,
                    'echo'           => false,
                )
            );
            echo $quick_links_menu; // phpcs:ignore WordPress.Security.EscapeOutput
            ?>
            <?php if ( empty( $quick_links_menu ) ) : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
                <a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>">Magazine</a>
                <a href="<?php echo esc_url( ssi_fanzine_page_url( 'about-us', home_url( '/about-us/' ) ) ); ?>">About Us</a>
                <a href="<?php echo esc_url( ssi_fanzine_page_url( 'contact', home_url( '/contact/' ) ) ); ?>">Contact</a>
                <a href="<?php echo esc_url( ssi_fanzine_page_url( 'advertise', home_url( '/advertise/' ) ) ); ?>">Advertise</a>
                <a href="<?php echo esc_url( ssi_fanzine_posts_url() ); ?>">Latest Stories</a>
            <?php endif; ?>
        </nav>

        <div class="footer-categories">
            <strong>Categories</strong>
            <?php
            $footer_categories = get_categories(
                array(
                    'hide_empty' => false,
                    'number'     => 12,
                    'exclude'    => get_cat_ID( 'Uncategorized' ),
                )
            );
            ?>
            <?php foreach ( $footer_categories as $category ) : ?>
                <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
            <?php endforeach; ?>
        </div>

        <div class="footer-right">
            <strong>Follow Us</strong>
            <div class="social-links">
                <a href="https://www.facebook.com/sportscienceindia/" aria-label="Facebook" target="_blank" rel="noopener"><?php ssi_fanzine_social_icon( 'facebook' ); ?></a><a href="https://x.com/SSI__India" aria-label="X" target="_blank" rel="noopener"><?php ssi_fanzine_social_icon( 'x' ); ?></a><a href="https://www.instagram.com/sports_science_india/" aria-label="Instagram" target="_blank" rel="noopener"><?php ssi_fanzine_social_icon( 'instagram' ); ?></a><a href="https://www.youtube.com/@sportsscienceindia" aria-label="YouTube" target="_blank" rel="noopener"><?php ssi_fanzine_social_icon( 'youtube' ); ?></a>
            </div>

        </div>

    </div>

</footer>

<div class="footer-bottom"><div class="site-container"><span>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> SSI Fanzine. All Rights Reserved.</span><span class="footer-credit">Designed by <a href="mailto:jayadevpradhan9@gmail.com">Jayadev</a></span><span class="footer-legal"><a href="<?php echo esc_url( ssi_fanzine_page_url( 'privacy-policy', home_url( '/privacy-policy/' ) ) ); ?>">Privacy Policy</a><a href="<?php echo esc_url( ssi_fanzine_page_url( 'terms-and-conditions', '#' ) ); ?>">Terms &amp; Conditions</a></span></div></div>

<?php
$posts_page_id  = get_option( 'page_for_posts' );
$magazine_url   = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$authors_url    = ssi_fanzine_page_url( 'authors', home_url( '/authors/' ) );
$search_url     = home_url( '/?s=' );
$live_score_url = ssi_fanzine_page_url( 'live-score', home_url( '/live-score/' ) );
$is_posts_index = is_home() || is_archive() || is_single();
?>

<nav class="bottom-tab-bar" aria-label="<?php esc_attr_e( 'Mobile quick navigation', 'ssi-fanzine' ); ?>">

    <a class="bottom-tab <?php echo is_front_page() ? 'is-active' : ''; ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>">
        <span class="bottom-tab-icon bottom-tab-home" aria-hidden="true"></span>
        <span>Home</span>
    </a>

    <a class="bottom-tab <?php echo $is_posts_index && ! is_front_page() ? 'is-active' : ''; ?>" href="<?php echo esc_url( $magazine_url ); ?>">
        <span class="bottom-tab-icon bottom-tab-magazine" aria-hidden="true"></span>
        <span>Magazine</span>
    </a>

    <?php if ( function_exists( 'wc_get_cart_url' ) ) : ?>
    <a class="bottom-tab bottom-tab-cart" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php esc_attr_e( 'Cart', 'ssi-fanzine' ); ?>">
        <span class="bottom-tab-icon bottom-tab-cart-icon" aria-hidden="true">🛒</span>
        <span>Cart</span>
        <?php if ( function_exists( 'WC' ) && WC()->cart ) : ?>
            <span class="bottom-cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
        <?php endif; ?>
    </a>
    <?php endif; ?>

    <a class="bottom-tab <?php echo is_author() ? 'is-active' : ''; ?>" href="<?php echo esc_url( $authors_url ); ?>">
        <span class="bottom-tab-icon bottom-tab-authors" aria-hidden="true"></span>
        <span>Authors</span>
    </a>

    <a class="bottom-tab <?php echo is_search() ? 'is-active' : ''; ?>" href="<?php echo esc_url( $search_url ); ?>">
        <span class="bottom-tab-icon bottom-tab-search" aria-hidden="true"></span>
        <span>Search</span>
    </a>

</nav>

<a class="live-score-fab" href="<?php echo esc_url( $live_score_url ); ?>">
    <span>Live</span>
    <strong>Score</strong>
</a>


<?php wp_footer(); ?>

</body>
</html>

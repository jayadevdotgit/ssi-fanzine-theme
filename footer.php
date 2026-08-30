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
                <span><span class="logo-accent">SSI</span> FANZINE</span>
            </a>

            <p class="footer-description">
                <?php bloginfo( 'description' ); ?>
            </p>

        </div>

        <nav class="footer-links" aria-label="<?php esc_attr_e( 'Footer navigation', 'ssi-fanzine' ); ?>">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'footer',
                    'container'      => false,
                    'fallback_cb'    => false,
                    'items_wrap'     => '%3$s',
                    'depth'          => 1,
                )
            );
            ?>
        </nav>

        <div class="footer-right">

            <p class="footer-description">
                &copy; <?php echo esc_html( wp_date( 'Y' ) ); ?>
                SSI FANZINE
            </p>

        </div>

    </div>

</footer>

<?php
$posts_page_id  = get_option( 'page_for_posts' );
$magazine_url   = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/magazine/' );
$authors_url    = home_url( '/authors/' );
$search_url     = home_url( '/?s=' );
$live_score_url = home_url( '/live-score/' );
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

    <a class="bottom-tab <?php echo is_author() ? 'is-active' : ''; ?>" href="<?php echo esc_url( $authors_url ); ?>">
        <span class="bottom-tab-icon bottom-tab-authors" aria-hidden="true"></span>
        <span>Authors</span>
    </a>

    <a class="bottom-tab <?php echo is_search() ? 'is-active' : ''; ?>" href="<?php echo esc_url( $search_url ); ?>">
        <span class="bottom-tab-icon bottom-tab-search" aria-hidden="true"></span>
        <span>Search</span>
    </a>

    <button class="bottom-tab bottom-menu-toggle" type="button" aria-label="<?php esc_attr_e( 'Open menu', 'ssi-fanzine' ); ?>" aria-expanded="false" aria-controls="mobile-navigation">
        <span class="bottom-tab-icon bottom-tab-menu" aria-hidden="true"></span>
        <span>Menu</span>
    </button>

</nav>

<a class="live-score-fab" href="<?php echo esc_url( $live_score_url ); ?>">
    <span>Live</span>
    <strong>Score</strong>
</a>


<?php wp_footer(); ?>

</body>
</html>

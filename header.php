<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<header class="site-header">

    <div class="header-top">

        <div class="site-container header-top-inner">

            <span><?php echo esc_html( wp_date( 'l, j F Y' ) ); ?></span>

            <nav class="utility-navigation" aria-label="<?php esc_attr_e( 'Utility navigation', 'ssi-fanzine' ); ?>">
                <a href="<?php echo esc_url( ssi_fanzine_page_url( 'about-us', home_url( '/about-us/' ) ) ); ?>">About Us</a>
                <a href="<?php echo esc_url( ssi_fanzine_page_url( 'authors', home_url( '/authors/' ) ) ); ?>">Authors</a>
                <a href="<?php echo esc_url( ssi_fanzine_page_url( 'contact', home_url( '/contact/' ) ) ); ?>">Contact</a>
                <a href="<?php echo esc_url( ssi_fanzine_page_url( 'advertise', home_url( '/advertise/' ) ) ); ?>">Advertise</a>
            </nav>

            <div class="social-links" aria-label="Social media">
                <a href="https://www.facebook.com/sportscienceindia/" aria-label="Facebook" target="_blank" rel="noopener"><?php ssi_fanzine_social_icon( 'facebook' ); ?></a>
                <a href="https://x.com/SSI__India" aria-label="X" target="_blank" rel="noopener"><?php ssi_fanzine_social_icon( 'x' ); ?></a>
                <a href="https://www.instagram.com/sports_science_india/" aria-label="Instagram" target="_blank" rel="noopener"><?php ssi_fanzine_social_icon( 'instagram' ); ?></a>
                <a href="https://www.youtube.com/@sportsscienceindia" aria-label="YouTube" target="_blank" rel="noopener"><?php ssi_fanzine_social_icon( 'youtube' ); ?></a>
            </div>

        </div>

    </div>

    <?php
    $navigation_categories = array();
    $navigation_slugs      = array( 'cricket', 'soccer', 'hockey', 'tennis', 'formula-one', 'injury-recovery', 'miscellaneous', 'sports-tech', 'videos' );

    foreach ( $navigation_slugs as $navigation_slug ) {
        $navigation_category = get_category_by_slug( $navigation_slug );
        if ( $navigation_category ) {
            $navigation_categories[] = array(
                'name' => $navigation_category->name,
                'link' => get_category_link( $navigation_category->term_id ),
            );
        }
    }
    $all_sports_url        = ssi_fanzine_posts_url();
    $live_score_url        = ssi_fanzine_page_url( 'live-score', home_url( '/live-score/' ) );
    ?>

    <div class="site-container header-main">

        <button
            class="mobile-menu-button"
            type="button"
            aria-label="<?php esc_attr_e( 'Open menu', 'ssi-fanzine' ); ?>"
            aria-expanded="false"
            aria-controls="mobile-navigation"
        >
            <span aria-hidden="true"></span>
        </button>

        <a
            class="site-logo"
            href="<?php echo esc_url( home_url( '/' ) ); ?>"
            aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
        >
            <span class="logo-mark">
                <span class="logo-rule" aria-hidden="true"></span>
                <span class="logo-ssi">SSI</span>
                <span class="logo-rule" aria-hidden="true"></span>
            </span>
            <span class="logo-title">Fanzine</span>
            <small><?php bloginfo( 'description' ); ?></small>
        </a>

        <a class="header-banner" href="<?php echo esc_url( ssi_fanzine_page_url( 'advertise', home_url( '/advertise/' ) ) ); ?>">
            <span>SPORTS STORIES <strong>THAT INSPIRE</strong></span>
            <b>EXPLORE NOW</b>
        </a>

        <div class="header-actions">
            <a class="header-search mobile-header-search" href="<?php echo esc_url( home_url( '/?s=' ) ); ?>" aria-label="<?php esc_attr_e( 'Search articles', 'ssi-fanzine' ); ?>"><?php ssi_fanzine_search_icon(); ?></a>

            <button
                class="theme-toggle"
                type="button"
                aria-label="<?php esc_attr_e( 'Switch to dark mode', 'ssi-fanzine' ); ?>"
                aria-pressed="false"
            >
                <span class="theme-toggle-icon" aria-hidden="true">
                    <svg class="toggle-icon icon-sun" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4.4" fill="currentColor"/><g stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="12" y1="2.5" x2="12" y2="4.5"/><line x1="12" y1="19.5" x2="12" y2="21.5"/><line x1="2.5" y1="12" x2="4.5" y2="12"/><line x1="19.5" y1="12" x2="21.5" y2="12"/><line x1="5.3" y1="5.3" x2="6.7" y2="6.7"/><line x1="17.3" y1="17.3" x2="18.7" y2="18.7"/><line x1="18.7" y1="5.3" x2="17.3" y2="6.7"/><line x1="6.7" y1="17.3" x2="5.3" y2="18.7"/></g></svg>
                    <svg class="toggle-icon icon-moon" viewBox="0 0 24 24"><path d="M20 14.5A8.5 8.5 0 0 1 9.5 4a8.5 8.5 0 1 0 10.5 10.5z" fill="currentColor"/></svg>
                </span>
            </button>
        </div>

    </div>

    <div class="nav-shell">

        <div class="site-container nav-row">

            <nav class="main-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'ssi-fanzine' ); ?>">

                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>

                <a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>">Magazine</a>

                <?php if ( ! empty( $navigation_categories ) ) : ?>

                    <?php foreach ( $navigation_categories as $category ) : ?>

                        <a href="<?php echo esc_url( $category['link'] ); ?>">
                            <?php echo esc_html( $category['name'] ); ?>
                        </a>

                    <?php endforeach; ?>

                <?php endif; ?>

                <a href="<?php echo esc_url( $all_sports_url ); ?>">More</a> 

                <?php if ( class_exists( 'WooCommerce' ) ) : ?>


                <?php endif; ?>

                <?php if ( function_exists( 'wc_get_cart_url' ) ) : ?>
                    <a class="nav-cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php esc_attr_e( 'Cart', 'ssi-fanzine' ); ?>">
                        <span class="nav-cart-icon" aria-hidden="true">🛒</span>
                        <span>Cart</span>
                        <?php if ( function_exists( 'WC' ) && WC()->cart ) : ?>
                            <span class="nav-cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>

                <a class="header-search" href="<?php echo esc_url( home_url( '/?s=' ) ); ?>" aria-label="<?php esc_attr_e( 'Search articles', 'ssi-fanzine' ); ?>"><?php ssi_fanzine_search_icon(); ?></a>
                <?php if ( is_user_logged_in() ) : ?>
                    <a class="header-login-button" href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>">Logout</a>
                <?php else : ?>
                    <a class="header-login-button" href="<?php echo esc_url( home_url( '/login/' ) ); ?>">Login</a>
                <?php endif; ?>

            </nav>

        </div>

    </div>

    <nav
        id="mobile-navigation"
        class="mobile-navigation"
        aria-label="<?php esc_attr_e( 'Mobile navigation', 'ssi-fanzine' ); ?>"
    >

        <div class="site-container">

            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>

            <a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>">Magazine</a>

            <?php if ( ! empty( $navigation_categories ) ) : ?>

                <?php foreach ( $navigation_categories as $category ) : ?>

                    <a href="<?php echo esc_url( $category['link'] ); ?>">
                        <?php echo esc_html( $category['name'] ); ?>
                    </a>

                <?php endforeach; ?>

            <?php endif; ?>

            <a href="<?php echo esc_url( $all_sports_url ); ?>">More / All Sports</a>

            <a href="<?php echo esc_url( home_url( '/?s=' ) ); ?>">Search</a>
            <?php if ( is_user_logged_in() ) : ?>
                <a class="mobile-login-link" href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>">Logout</a>
            <?php else : ?>
                <a class="mobile-login-link" href="<?php echo esc_url( home_url( '/login/' ) ); ?>">Login</a>
            <?php endif; ?>

            <?php if ( class_exists( 'WooCommerce' ) ) : ?>


            <?php endif; ?>

        </div>

    </nav>

    <div class="site-ticker">
        <span class="ticker-label">Breaking</span>
        <div class="ticker-viewport">
            <div class="ticker-track">
                <?php
                $ticker_query = new WP_Query(
                    array(
                        'post_type'      => 'post',
                        'posts_per_page' => 8,
                        'post_status'    => 'publish',
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                        'no_found_rows'  => true,
                    )
                );
                while ( $ticker_query->have_posts() ) :
                    $ticker_query->the_post();
                    ?>
                    <a class="ticker-item" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
            <div class="ticker-track" aria-hidden="true">
                <?php
                $ticker_query = new WP_Query(
                    array(
                        'post_type'      => 'post',
                        'posts_per_page' => 8,
                        'post_status'    => 'publish',
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                        'no_found_rows'  => true,
                    )
                );
                while ( $ticker_query->have_posts() ) :
                    $ticker_query->the_post();
                    ?>
                    <a class="ticker-item" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </div>

</header>

<main class="site-main">

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
                <a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>">About Us</a>
                <a href="<?php echo esc_url( home_url( '/authors/' ) ); ?>">Authors</a>
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a>
                <a href="<?php echo esc_url( home_url( '/advertise/' ) ); ?>">Advertise</a>
            </nav>

        </div>

    </div>

    <?php
    $navigation_categories = get_categories(
        array(
            'hide_empty' => true,
            'parent'     => 0,
            'orderby'    => 'name',
            'order'      => 'ASC',
        )
    );
    $live_score_url = home_url( '/live-score/' );
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
            <span><span class="logo-accent">SSI</span> FANZINE</span>
            <small><?php bloginfo( 'description' ); ?></small>
        </a>

        <a
            class="header-search"
            href="<?php echo esc_url( home_url( '/?s=' ) ); ?>"
            aria-label="<?php esc_attr_e( 'Search articles', 'ssi-fanzine' ); ?>"
        ></a>

        <button
            class="theme-toggle"
            type="button"
            aria-label="<?php esc_attr_e( 'Switch to dark mode', 'ssi-fanzine' ); ?>"
            aria-pressed="false"
        >
            <span class="theme-toggle-icon" aria-hidden="true"></span>
        </button>

    </div>

    <div class="nav-shell">

        <div class="site-container nav-row">

            <nav class="main-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'ssi-fanzine' ); ?>">

                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>

                <a class="special-nav-link" href="<?php echo esc_url( $live_score_url ); ?>">Live Score</a>

                <?php if ( ! empty( $navigation_categories ) ) : ?>

                    <?php foreach ( $navigation_categories as $category ) : ?>

                        <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
                            <?php echo esc_html( $category->name ); ?>
                        </a>

                    <?php endforeach; ?>

                <?php endif; ?>

                <?php if ( class_exists( 'WooCommerce' ) ) : ?>

                    <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">Shop</a>

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

            <a class="special-nav-link" href="<?php echo esc_url( $live_score_url ); ?>">Live Score</a>

            <?php if ( ! empty( $navigation_categories ) ) : ?>

                <?php foreach ( $navigation_categories as $category ) : ?>

                    <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
                        <?php echo esc_html( $category->name ); ?>
                    </a>

                <?php endforeach; ?>

            <?php endif; ?>

            <a href="<?php echo esc_url( home_url( '/?s=' ) ); ?>">Search</a>

            <?php if ( class_exists( 'WooCommerce' ) ) : ?>

                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">Shop</a>

            <?php endif; ?>

        </div>

    </nav>

</header>

<main class="site-main">

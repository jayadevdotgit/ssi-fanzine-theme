<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<header class="site-header">

    <div class="site-container header-main">

        <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>">
            SSI FANZINE
        </a>

        <nav class="main-navigation" aria-label="Primary navigation">

            <a href="<?php echo esc_url(home_url('/')); ?>">
                Latest
            </a>

            <?php
            $navigation_categories = array(
                'Cricket',
                'Football',
                'Athletics',
                'Hockey'
            );

            foreach ($navigation_categories as $category_name) :

                $category = get_category_by_slug(
                    sanitize_title($category_name)
                );

                if ($category) :
            ?>

                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                    <?php echo esc_html($category->name); ?>
                </a>

            <?php
                endif;
            endforeach;
            ?>

            <a href="<?php echo esc_url(home_url('/?s=')); ?>">
                Search
            </a>

        </nav>

        <button
            class="mobile-menu-button"
            type="button"
            aria-label="Open menu"
        >
            ☰
        </button>

    </div>

</header>

<main class="site-main">
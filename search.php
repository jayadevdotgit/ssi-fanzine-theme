<?php
/**
 * SSI FANZINE Search Results
 */

get_header();
?>

<div class="site-container">

    <header class="archive-header">

        <div class="post-category">
            SEARCH
        </div>

        <h1>
            <?php
            printf(
                'Results for: %s',
                esc_html(get_search_query())
            );
            ?>
        </h1>

    </header>

    <form class="site-search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <label class="screen-reader-text" for="ssi-search-input">Search articles</label>
        <input id="ssi-search-input" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="Search sports stories...">
        <button type="submit">Search</button>
    </form>


    <div class="article-grid">

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <article class="article-card archive-card">

                    <a class="article-image" href="<?php the_permalink(); ?>">
                        <?php ssi_fanzine_post_thumb('large'); ?>
                    </a>

                    <div class="post-category">

                        <?php
                        $categories = get_the_category();

                        if (!empty($categories)) {
                            echo esc_html($categories[0]->name);
                        }
                        ?>

                    </div>

                    <h3>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>

                    <?php ssi_fanzine_post_category_links(); ?>

                    <p class="post-meta">
                        By <?php echo esc_html(get_the_author()); ?>
                        ·
                        <?php echo esc_html(get_the_date()); ?>
                    </p>

                    <div class="post-excerpt">
                        <?php
                        echo esc_html(
                            wp_trim_words(
                                get_the_excerpt(),
                                20
                            )
                        );
                        ?>
                    </div>

                </article>

            <?php endwhile; ?>

        <?php else : ?>

            <p>
                No articles matched your search.
            </p>

        <?php endif; ?>

    </div>


    <?php
    the_posts_pagination(
        array(
            'mid_size'  => 2,
            'prev_text' => '← Previous',
            'next_text' => 'Next →',
        )
    );
    ?>

</div>

<?php get_footer(); ?>

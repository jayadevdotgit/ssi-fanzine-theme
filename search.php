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


    <div class="article-grid">

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <article class="article-card">

                    <?php if (has_post_thumbnail()) : ?>

                        <a
                            class="article-image"
                            href="<?php the_permalink(); ?>"
                        >
                            <?php the_post_thumbnail('large'); ?>
                        </a>

                    <?php endif; ?>

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
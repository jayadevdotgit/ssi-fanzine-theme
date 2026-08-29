<?php
/**
 * SSI FANZINE Archive / Category Page
 */

get_header();
?>

<div class="site-container">

    <header class="archive-header">

        <div class="post-category">
            <?php
            if (is_category()) {
                echo 'SPORTS';
            } elseif (is_author()) {
                echo 'AUTHOR';
            } else {
                echo 'NEWS';
            }
            ?>
        </div>

        <h1>
            <?php the_archive_title(); ?>
        </h1>

        <?php
        $description = get_the_archive_description();

        if ($description) :
        ?>

            <div class="archive-description">
                <?php echo wp_kses_post($description); ?>
            </div>

        <?php endif; ?>

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

            <p>No articles found.</p>

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
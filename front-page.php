<?php
/**
 * SSI FANZINE Homepage
 */

get_header();
?>

<div class="site-container">

    <?php
    /*
     * Featured Story
     *
     * Gets the latest published article.
     */
    $featured_query = new WP_Query(array(
        'post_type'      => 'post',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    ));

    if ($featured_query->have_posts()) :
        while ($featured_query->have_posts()) :
            $featured_query->the_post();
    ?>

        <section class="featured-story">

            <div class="featured-image">

                <?php if (has_post_thumbnail()) : ?>

                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('large'); ?>
                    </a>

                <?php endif; ?>

            </div>

            <div class="featured-content">

                <div class="post-category">

                    <?php
                    $categories = get_the_category();

                    if (!empty($categories)) {
                        echo esc_html($categories[0]->name);
                    }
                    ?>

                </div>

                <h1>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h1>

                <div class="post-excerpt">
                    <?php echo esc_html(wp_trim_words(get_the_excerpt(), 25)); ?>
                </div>

                <div class="post-meta">
                    By <?php echo esc_html(get_the_author()); ?>
                    ·
                    <?php echo esc_html(get_the_date()); ?>
                </div>

            </div>

        </section>

    <?php
        endwhile;
        wp_reset_postdata();
    endif;
    ?>


    <!-- Latest Stories -->

    <section>

        <div class="section-title">

            <h2>Latest Stories</h2>

            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">
                View all →
            </a>

        </div>


        <div class="article-grid">

            <?php
            $latest_query = new WP_Query(array(
                'post_type'      => 'post',
                'posts_per_page' => 6,
                'post_status'    => 'publish',
                'offset'         => 1,
            ));

            if ($latest_query->have_posts()) :

                while ($latest_query->have_posts()) :
                    $latest_query->the_post();
            ?>

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

                        <?php echo esc_html(get_the_author()); ?>

                        ·

                        <?php echo esc_html(get_the_date()); ?>

                    </p>


                    <div class="post-excerpt">

                        <?php
                        echo esc_html(
                            wp_trim_words(
                                get_the_excerpt(),
                                18
                            )
                        );
                        ?>

                    </div>

                </article>

            <?php
                endwhile;

                wp_reset_postdata();

            else :
            ?>

                <p>No articles found.</p>

            <?php endif; ?>

        </div>

    </section>


    <!-- Sports Categories -->

    <?php
    /*
     * These are only displayed if the categories actually exist.
     */

    $homepage_categories = array(
        'Cricket',
        'Football',
        'Athletics',
    );


    foreach ($homepage_categories as $category_name) :

        $category = get_category_by_slug(
            sanitize_title($category_name)
        );

        if (!$category) {
            continue;
        }


        $category_query = new WP_Query(array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'post_status'    => 'publish',
            'cat'            => $category->term_id,
        ));


        if (!$category_query->have_posts()) {
            continue;
        }
    ?>

        <section class="category-section">

            <div class="section-title">

                <h2>
                    <?php echo esc_html($category->name); ?>
                </h2>

                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                    View all →
                </a>

            </div>


            <div class="article-grid">

                <?php
                while ($category_query->have_posts()) :
                    $category_query->the_post();
                ?>

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
                            <?php echo esc_html($category->name); ?>
                        </div>


                        <h3>

                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>

                        </h3>


                        <p class="post-meta">

                            <?php echo esc_html(get_the_author()); ?>

                            ·

                            <?php echo esc_html(get_the_date()); ?>

                        </p>

                    </article>

                <?php
                endwhile;

                wp_reset_postdata();
                ?>

            </div>

        </section>

    <?php endforeach; ?>

</div>

<?php get_footer(); ?>
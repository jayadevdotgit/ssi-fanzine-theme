<?php
/**
 * SSI FANZINE Author Page
 */

get_header();

$author_id = get_queried_object_id();
$author    = get_userdata($author_id);
?>

<div class="site-container">

    <header class="author-header">

        <div class="author-avatar">

            <?php echo get_avatar($author_id, 120); ?>

        </div>

        <div class="author-info">

            <div class="post-category">
                AUTHOR
            </div>

            <h1>
                <?php echo esc_html($author->display_name); ?>
            </h1>

            <?php if (!empty($author->description)) : ?>

                <p>
                    <?php echo esc_html($author->description); ?>
                </p>

            <?php endif; ?>

        </div>

    </header>


    <section>

        <div class="section-title">
            <h2>Articles by <?php echo esc_html($author->display_name); ?></h2>
        </div>


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
                            <?php echo esc_html(get_the_date()); ?>
                        </p>

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

    </section>

</div>

<?php get_footer(); ?>
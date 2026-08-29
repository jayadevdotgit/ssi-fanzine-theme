<?php
/**
 * SSI FANZINE Single Article
 */

get_header();
?>

<div class="site-container">

    <?php if (have_posts()) : ?>

        <?php while (have_posts()) : the_post(); ?>

            <article class="single-article">

                <header class="single-header">

                    <div class="post-category">

                        <?php
                        $categories = get_the_category();

                        if (!empty($categories)) {
                            echo esc_html($categories[0]->name);
                        }
                        ?>

                    </div>

                    <h1>
                        <?php the_title(); ?>
                    </h1>

                    <div class="single-meta">

                        By
                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                            <?php echo esc_html(get_the_author()); ?>
                        </a>

                        ·

                        <?php echo esc_html(get_the_date()); ?>

                    </div>

                </header>


                <?php if (has_post_thumbnail()) : ?>

                    <figure class="single-featured-image">

                        <?php the_post_thumbnail('full'); ?>

                    </figure>

                <?php endif; ?>


                <div class="single-content">

                    <?php the_content(); ?>

                </div>


                <footer class="single-footer">

                    <div class="post-category">
                        Categories
                    </div>

                    <div class="article-categories">

                        <?php
                        the_category(' ');
                        ?>

                    </div>

                </footer>

            </article>

        <?php endwhile; ?>

    <?php endif; ?>

</div>

<?php get_footer(); ?>
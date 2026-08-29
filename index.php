<?php get_header(); ?>

<div class="site-container">

    <div class="section-title">
        <h2>Latest Stories</h2>
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
                        <?php echo esc_html(get_the_author()); ?>
                        ·
                        <?php echo esc_html(get_the_date()); ?>
                    </p>

                    <div class="post-excerpt">
                        <?php the_excerpt(); ?>
                    </div>

                </article>

            <?php endwhile; ?>

        <?php else : ?>

            <p>No articles found.</p>

        <?php endif; ?>

    </div>

</div>

<?php get_footer(); ?>
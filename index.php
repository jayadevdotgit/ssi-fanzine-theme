<?php
/**
 * SSI FANZINE Posts Index / Latest Stories
 */

get_header();
?>

<div class="site-container">

    <header class="archive-header">
        <div class="post-category">STORIES</div>
        <h1>Latest Stories</h1>
    </header>

    <div class="article-grid index-grid">

        <?php if ( have_posts() ) : ?>

            <?php while ( have_posts() ) : the_post(); ?>

                <article class="article-card archive-card">

                    <a class="article-image" href="<?php the_permalink(); ?>">
                        <?php ssi_fanzine_post_thumb( 'large' ); ?>
                    </a>

                    <div class="post-category">
                        <?php ssi_fanzine_post_category_label(); ?>
                    </div>

                    <h3>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>

                    <?php ssi_fanzine_post_category_links(); ?>

                    <p class="post-meta">
                        By <?php echo esc_html( get_the_author() ); ?>
                        ·
                        <?php echo esc_html( get_the_date() ); ?>
                    </p>

                    <div class="post-excerpt">
                        <?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?>
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
            'prev_text' => 'Previous',
            'next_text' => 'Next',
        )
    );
    ?>

</div>

<?php get_footer(); ?>

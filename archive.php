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


    <div class="archive-layout">

        <aside class="archive-side archive-dont-miss">
            <div class="archive-side-title">Don't Miss It</div>
            <?php
            $dont_miss_query = new WP_Query(
                array(
                    'post_type'      => 'post',
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                    'orderby'        => 'rand',
                    'ignore_sticky_posts' => true,
                    'no_found_rows'  => true,
                )
            );
            ?>
            <?php while ( $dont_miss_query->have_posts() ) : $dont_miss_query->the_post(); ?>
                <article class="archive-side-card">
                    <a class="archive-side-image" href="<?php the_permalink(); ?>"><?php ssi_fanzine_post_thumb( 'thumbnail' ); ?></a>
                    <div class="post-category"><?php ssi_fanzine_post_category_label(); ?></div>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p class="post-meta"><?php echo esc_html( ssi_fanzine_relative_time() ); ?></p>
                </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </aside>

        <div class="archive-main-column">
            <div class="article-grid">

                <?php if ( is_category( 'videos' ) ) : ?>

                    <?php ssi_fanzine_render_video_category_cards(); ?>

                <?php elseif (have_posts()) : ?>

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
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <?php ssi_fanzine_post_category_links(); ?>
                            <p class="post-meta">
                                By <?php echo esc_html(get_the_author()); ?> · <?php echo esc_html(get_the_date()); ?>
                            </p>
                            <div class="post-excerpt">
                                <?php echo esc_html(wp_trim_words(get_the_excerpt(),20)); ?>
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

        <aside class="archive-side archive-popular-news">
            <div class="archive-side-title">Popular News</div>
            <?php
            $popular_query = new WP_Query(
                array(
                    'post_type'      => 'post',
                    'posts_per_page' => 4,
                    'post_status'    => 'publish',
                    'orderby'        => 'rand',
                    'ignore_sticky_posts' => true,
                    'no_found_rows'  => true,
                )
            );
            ?>
            <?php while ( $popular_query->have_posts() ) : $popular_query->the_post(); ?>
                <article class="archive-side-card">
                    <a class="archive-side-image" href="<?php the_permalink(); ?>"><?php ssi_fanzine_post_thumb( 'thumbnail' ); ?></a>
                    <div class="post-category"><?php ssi_fanzine_post_category_label(); ?></div>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p class="post-meta"><?php echo esc_html( ssi_fanzine_relative_time() ); ?></p>
                </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </aside>

    </div>

    <?php if ( is_category() ) : ?>
        <?php
        $archive_recommended = new WP_Query(
            array(
                'post_type'      => 'post',
                'posts_per_page' => 4,
                'category__in'   => array( get_queried_object_id() ),
                'post_status'    => 'publish',
                'orderby'        => 'rand',
                'no_found_rows'  => true,
            )
        );
        ?>
        <?php if ( $archive_recommended->have_posts() ) : ?>
            <section class="recommended-section">
                <div class="section-title"><h2>Recommended Articles</h2></div>
                <div class="article-grid recommended-grid">
                    <?php while ( $archive_recommended->have_posts() ) : $archive_recommended->the_post(); ssi_fanzine_article_card(); endwhile; wp_reset_postdata(); ?>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>

</div>

<?php get_footer(); ?>

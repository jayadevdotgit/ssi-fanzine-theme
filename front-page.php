<?php
/**
 * SSI FANZINE Homepage
 */

get_header();

$featured_post_id = 0;
$posts_page_id    = get_option( 'page_for_posts' );
$posts_page_url   = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/?post_type=post' );
$featured_query   = new WP_Query(
    array(
        'post_type'      => 'post',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    )
);
?>

<div class="site-container home-layout">

    <div class="home-primary">

        <?php if ( $featured_query->have_posts() ) : ?>

            <?php
            while ( $featured_query->have_posts() ) :
                $featured_query->the_post();
                $featured_post_id = get_the_ID();
                ?>

                <section class="featured-story">

                    <?php if ( has_post_thumbnail() ) : ?>

                        <a class="featured-image" href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail( 'large' ); ?>
                        </a>

                    <?php endif; ?>

                    <div class="featured-content">

                        <div class="post-category"><?php ssi_fanzine_post_category_label(); ?></div>

                        <h1>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h1>

                        <div class="post-excerpt">
                            <?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?>
                        </div>

                        <div class="post-meta">
                            <span><?php echo esc_html( get_the_author() ); ?></span>
                            <span><?php echo esc_html( get_the_date() ); ?></span>
                        </div>

                    </div>

                </section>

            <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>

        <?php endif; ?>

        <section>

            <div class="section-title">
                <h2>Latest Articles</h2>
                <a href="<?php echo esc_url( $posts_page_url ); ?>">View All Articles</a>
            </div>

            <div class="article-grid">

                <?php
                $latest_args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => 6,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                );

                if ( $featured_post_id > 0 ) {
                    $latest_args['post__not_in'] = array( $featured_post_id );
                }

                $latest_query = new WP_Query( $latest_args );
                ?>

                <?php if ( $latest_query->have_posts() ) : ?>

                    <?php
                    while ( $latest_query->have_posts() ) :
                        $latest_query->the_post();
                        ssi_fanzine_article_card();
                    endwhile;
                    ?>

                    <?php wp_reset_postdata(); ?>

                <?php else : ?>

                    <p>No articles found.</p>

                <?php endif; ?>

            </div>

        </section>

    </div>

    <aside class="home-sidebar">

        <section class="sidebar-section">

            <div class="section-title">
                <h2>Latest News</h2>
            </div>

            <?php
            $news_query = new WP_Query(
                array(
                    'post_type'      => 'post',
                    'posts_per_page' => 4,
                    'post_status'    => 'publish',
                    'post__not_in'   => $featured_post_id ? array( $featured_post_id ) : array(),
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                )
            );
            ?>

            <div class="news-list">

                <?php if ( $news_query->have_posts() ) : ?>

                    <?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>

                        <article class="news-item">

                            <?php if ( has_post_thumbnail() ) : ?>

                                <a class="news-image" href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'thumbnail' ); ?>
                                </a>

                            <?php endif; ?>

                            <div>
                                <div class="post-category"><?php ssi_fanzine_post_category_label(); ?></div>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <p class="post-meta"><?php echo esc_html( get_the_date() ); ?></p>
                            </div>

                        </article>

                    <?php endwhile; ?>

                    <?php wp_reset_postdata(); ?>

                <?php endif; ?>

            </div>

        </section>

        <section class="sidebar-section">

            <div class="section-title">
                <h2>Popular Topics</h2>
            </div>

            <div class="topic-list">

                <?php
                $topics = get_categories(
                    array(
                        'hide_empty' => true,
                        'orderby'    => 'count',
                        'order'      => 'DESC',
                        'number'     => 8,
                    )
                );
                ?>

                <?php foreach ( $topics as $topic ) : ?>

                    <a class="topic-item" href="<?php echo esc_url( get_category_link( $topic->term_id ) ); ?>">
                        <span><?php echo esc_html( $topic->name ); ?></span>
                        <em><?php echo esc_html( $topic->count ); ?></em>
                    </a>

                <?php endforeach; ?>

            </div>

        </section>

    </aside>

</div>

<?php
$featured_categories = get_categories(
    array(
        'hide_empty' => true,
        'orderby'    => 'count',
        'order'      => 'DESC',
        'number'     => 5,
    )
);
?>

<?php if ( ! empty( $featured_categories ) ) : ?>

    <section class="site-container featured-categories">

        <div class="section-title">
            <h2>Featured Categories</h2>
        </div>

        <div class="category-strip">

            <?php foreach ( $featured_categories as $category ) : ?>

                <?php
                $category_posts = get_posts(
                    array(
                        'category'    => $category->term_id,
                        'numberposts' => 1,
                    )
                );
                $category_image = $category_posts ? get_the_post_thumbnail_url( $category_posts[0]->ID, 'medium_large' ) : '';
                ?>

                <a class="category-tile" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
                    <?php if ( $category_image ) : ?>
                        <img src="<?php echo esc_url( $category_image ); ?>" alt="">
                    <?php endif; ?>
                    <span><?php echo esc_html( $category->name ); ?></span>
                    <small>View All</small>
                </a>

            <?php endforeach; ?>

        </div>

    </section>

<?php endif; ?>

<?php get_footer(); ?>

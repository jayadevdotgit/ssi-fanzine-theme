<?php
/**
 * SSI FANZINE Homepage
 */

get_header();

$featured_post_id  = 0;
$displayed_post_ids = array();
$posts_page_url   = ssi_fanzine_posts_url();
$featured_query   = new WP_Query(
    array(
        'post_type'      => 'post',
        'posts_per_page' => 4,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    )
);
?>

<?php
$trending = array();
if ( function_exists( 'ssi_fanzine_category_counts' ) ) {
    $trending_counts = ssi_fanzine_category_counts();
    arsort( $trending_counts );
    $trending_i = 0;
    foreach ( $trending_counts as $trend_tid => $trend_count ) {
        if ( $trending_i >= 12 ) {
            break;
        }
        $trend_term = get_term( $trend_tid );
        if ( ! $trend_term || 'uncategorized' === strtolower( $trend_term->slug ) ) {
            continue;
        }
        $trending[] = array(
            'name' => $trend_term->name,
            'link' => get_category_link( $trend_tid ),
        );
        $trending_i++;
    }
}
?>

<?php if ( ! empty( $trending ) ) : ?>
    <section class="site-container trending-strip">
        <span class="trending-label">Trending</span>
        <div class="trending-list">
            <?php foreach ( $trending as $tag ) : ?>
                <a class="trending-tag" href="<?php echo esc_url( $tag['link'] ); ?>"><?php echo esc_html( $tag['name'] ); ?></a>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

<div class="site-container home-layout">

    <div class="home-primary">

        <?php if ( $featured_query->have_posts() ) : ?>

            <?php $featured_count = 0; ?>

            <section class="featured-slider">

                <div class="featured-track">

                    <?php
                    while ( $featured_query->have_posts() ) :
                        $featured_query->the_post();
                        $featured_count++;
                        if ( 1 === $featured_count ) {
                            $featured_post_id = get_the_ID();
                        }
                        $displayed_post_ids[] = get_the_ID();
                        ?>

                        <article class="featured-story">

                            <a class="featured-image" href="<?php the_permalink(); ?>">
                                <?php ssi_fanzine_post_thumb( 'large' ); ?>
                            </a>

                            <div class="featured-content">

                                <div class="post-category"><?php ssi_fanzine_post_category_label(); ?></div>

                                <h1>
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h1>

                                <div class="post-excerpt">
                                    <?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?>
                                </div>

                                <div class="post-meta">
                                    <span class="featured-author"><?php echo ssi_fanzine_author_avatar_html( get_the_author_meta( 'ID' ), 28 ); ?><?php echo esc_html( get_the_author() ); ?></span>
                                    <span><?php echo esc_html( get_the_date() ); ?></span>
                                </div>

                            </div>

                        </article>

                    <?php endwhile; ?>

                    <?php wp_reset_postdata(); ?>

                </div>

                <?php if ( $featured_count > 1 ) : ?>
                    <div class="featured-dots" aria-hidden="true">
                        <?php for ( $i = 0; $i < $featured_count; $i++ ) : ?>
                            <button class="featured-dot" type="button" aria-label="Slide <?php echo esc_attr( $i + 1 ); ?>"></button>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>

            </section>

        <?php endif; ?>

        <section class="latest-articles-section">

            <div class="section-title">
                <h2>Latest Articles</h2>
                <a href="<?php echo esc_url( $posts_page_url ); ?>">View All Articles</a>
            </div>

            <div class="article-grid">

                <?php
                $latest_args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => 8,
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
                        $displayed_post_ids[] = get_the_ID();
                        ssi_fanzine_article_card();
                    endwhile;
                    ?>

                    <?php wp_reset_postdata(); ?>

                <?php else : ?>

                    <p>No articles found.</p>

                <?php endif; ?>

            </div>

        </section>

        <section class="more-stories-section">

            <div class="section-title">
                <h2>More Stories</h2>
                <a href="<?php echo esc_url( $posts_page_url ); ?>">View All</a>
            </div>

            <div class="more-stories-list">
                <?php
                $more_stories = new WP_Query(
                    array(
                        'post_type'      => 'post',
                        'posts_per_page' => 10,
                        'post_status'    => 'publish',
                        'category__in'   => array_map( 'intval', wp_list_pluck( get_categories( array( 'hide_empty' => false, 'slug' => array( 'blog', 'sports-science-blogs', 'sports-science', 'sports-science-india', 'sports-science-magazine' ) ) ), 'term_id' ) ),
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                        'no_found_rows'  => true,
                    )
                );
                while ( $more_stories->have_posts() ) : $more_stories->the_post();
                    ?>
                    <article class="more-story-item">
                        <a class="more-story-thumb" href="<?php the_permalink(); ?>"><?php ssi_fanzine_post_thumb( 'thumbnail' ); ?></a>
                        <div class="more-story-body">
                            <div class="post-category"><?php ssi_fanzine_post_category_label(); ?></div>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p class="post-meta"><?php echo esc_html( ssi_fanzine_relative_time() ); ?> · <?php echo esc_html( ssi_fanzine_read_time() ); ?></p>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>

        </section>

        <section class="spotlight-section">

            <div class="section-title">
                <h2>Editor's Picks</h2>
                <a href="<?php echo esc_url( $posts_page_url ); ?>">More</a>
            </div>

            <div class="spotlight-grid">
                <?php
                $spotlight_query = new WP_Query(
                    array(
                        'post_type'      => 'post',
                        'posts_per_page' => 3,
                        'post_status'    => 'publish',
                        'offset'         => 5,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                        'no_found_rows'  => true,
                    )
                );
                ?>

                <?php while ( $spotlight_query->have_posts() ) : $spotlight_query->the_post(); ?>
                    <article class="spotlight-card">
                        <a class="spotlight-thumb" href="<?php the_permalink(); ?>">
                            <?php ssi_fanzine_post_thumb( 'thumbnail' ); ?>
                        </a>
                        <div class="post-category"><?php ssi_fanzine_post_category_label(); ?></div>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>

        </section>

        <section class="briefs-section">

            <div class="section-title">
                <h2>Sports Brief</h2>
            </div>

            <div class="briefs-list">
                <?php
                $brief_query = new WP_Query(
                    array(
                        'post_type'      => 'post',
                        'posts_per_page' => 3,
                        'post_status'    => 'publish',
                        'offset'         => 8,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                        'no_found_rows'  => true,
                    )
                );
                ?>
                <?php while ( $brief_query->have_posts() ) : $brief_query->the_post(); ?>
                    <a class="brief-item" href="<?php the_permalink(); ?>">
                        <span class="brief-category"><?php ssi_fanzine_post_category_label(); ?></span>
                        <strong><?php the_title(); ?></strong>
                        <small><?php echo esc_html( ssi_fanzine_relative_time() ); ?></small>
                    </a>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>

        </section>

        <section class="radar-section">
            <div class="section-title">
                <h2>On The Radar</h2>
                <a href="<?php echo esc_url( $posts_page_url ); ?>">View All</a>
            </div>
            <div class="radar-list">
                <?php
                $radar_query = new WP_Query(
                    array(
                        'post_type'      => 'post',
                        'posts_per_page' => 6,
                        'post_status'    => 'publish',
                        'offset'         => 11,
                        'orderby'        => 'rand',
                        'no_found_rows'  => true,
                    )
                );
                while ( $radar_query->have_posts() ) : $radar_query->the_post();
                    ?>
                    <a class="radar-item" href="<?php the_permalink(); ?>">
                        <span class="radar-number"><?php echo esc_html( str_pad( (string) ( $radar_query->current_post + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
                        <span><small><?php ssi_fanzine_post_category_label(); ?></small><strong><?php the_title(); ?></strong></span>
                    </a>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </section>

    </div>

    <aside class="home-sidebar">

        <section class="sidebar-section latest-news-section">

            <div class="section-title">
                <h2>Latest News</h2>
                <a href="<?php echo esc_url( $posts_page_url ); ?>">View All News</a>
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

                    <?php while ( $news_query->have_posts() ) : $news_query->the_post(); $displayed_post_ids[] = get_the_ID(); ?>

                        <article class="news-item">

                            <a class="news-image" href="<?php the_permalink(); ?>">
                                <?php ssi_fanzine_post_thumb( 'thumbnail' ); ?>
                            </a>

                            <div>
                                <div class="post-category"><?php ssi_fanzine_post_category_label(); ?></div>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <p class="post-meta"><span class="meta-date-inner"><?php echo esc_html( ssi_fanzine_relative_time() ); ?></span></p>
                            </div>

                        </article>

                    <?php endwhile; ?>

                    <?php wp_reset_postdata(); ?>

                <?php endif; ?>

            </div>

            <a class="news-view-all" href="<?php echo esc_url( $posts_page_url ); ?>">View All News</a>

        </section>

        <?php
        $sidebar_sections = array(
            array( 'title' => 'Blogs', 'slugs' => array( 'blog' ) ),
            array( 'title' => 'Sports Science Blogs', 'slugs' => array( 'sports-science-blogs', 'sports-science-india' ) ),
        );
        $sidebar_index = 0;
        foreach ( $sidebar_sections as $sidebar_section ) {
            $sidebar_category = false;
            foreach ( $sidebar_section['slugs'] as $sidebar_slug ) {
                $sidebar_category = get_category_by_slug( $sidebar_slug );
                if ( $sidebar_category ) {
                    break;
                }
            }
            if ( ! $sidebar_category ) {
                continue;
            }
            $sidebar_query = new WP_Query(
                array(
                    'post_type'      => 'post',
                    'posts_per_page' => 4,
                    'category__in'   => array( $sidebar_category->term_id ),
                    'post_status'    => 'publish',
                    'orderby'        => 'rand',
                    'no_found_rows'  => true,
                )
            );
            if ( ! $sidebar_query->have_posts() ) {
                wp_reset_postdata();
                continue;
            }
            ?>
            <section class="sidebar-section sidebar-topic-section sidebar-topic-<?php echo esc_attr( $sidebar_index ); ?>">
                <div class="section-title">
                    <h2><?php echo esc_html( $sidebar_section['title'] ); ?></h2>
                    <a href="<?php echo esc_url( get_category_link( $sidebar_category->term_id ) ); ?>">View All</a>
                </div>
                <div class="sidebar-topic-list">
                    <?php while ( $sidebar_query->have_posts() ) : $sidebar_query->the_post(); ?>
                        <article class="sidebar-topic-card">
                            <a class="sidebar-topic-image" href="<?php the_permalink(); ?>"><?php ssi_fanzine_post_thumb( 'thumbnail' ); ?></a>
                            <div>
                                <div class="post-category"><?php ssi_fanzine_post_category_label(); ?></div>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <p class="post-meta"><?php echo esc_html( ssi_fanzine_relative_time() ); ?></p>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </section>
            <?php
            $sidebar_index++;
        }
        ?>

        <section class="sidebar-section popular-topics-section">

            <div class="section-title">
                <h2>Popular Topics</h2>
            </div>

            <div class="topic-list">

                <?php
                $used_categories  = array();
                $category_counts  = ssi_fanzine_category_counts();

                foreach ( get_categories( array( 'hide_empty' => false, 'exclude' => get_cat_ID( 'Uncategorized' ) ) ) as $cat ) {
                    $count = isset( $category_counts[ $cat->term_id ] ) ? (int) $category_counts[ $cat->term_id ] : 0;
                    if ( $count < 1 ) {
                        continue;
                    }
                    $used_categories[ $cat->term_id ] = array(
                        'name'  => ssi_fanzine_cat_title( $cat->name ),
                        'slug'  => $cat->slug,
                        'link'  => get_category_link( $cat->term_id ),
                        'count' => $count,
                    );
                }

                uasort(
                    $used_categories,
                    function ( $a, $b ) {
                        return $b['count'] <=> $a['count'];
                    }
                );
                ?>

                <?php foreach ( array_slice( $used_categories, 0, 8 ) as $topic ) : ?>

                    <a class="topic-item topic-<?php echo esc_attr( sanitize_title( $topic['slug'] ) ); ?>" href="<?php echo esc_url( $topic['link'] ); ?>">
                        <span class="topic-icon"><?php ssi_fanzine_topic_icon( $topic['slug'] ); ?></span>
                        <span class="topic-name"><?php echo esc_html( $topic['name'] ); ?></span>
                        <em><?php echo esc_html( $topic['count'] ); ?></em>
                    </a>

                <?php endforeach; ?>

                <a class="topic-item topic-item-more" href="<?php echo esc_url( $posts_page_url ); ?>">
                    <span class="topic-icon topic-icon-more" aria-hidden="true"><i></i><i></i><i></i></span>
                    <span class="topic-name">More</span>
                </a>

            </div>

        </section>

        <?php ssi_fanzine_newsletter_box(); ?>

    </aside>

</div>

<?php
if ( empty( $used_categories ) ) {
    foreach ( get_categories( array( 'hide_empty' => true, 'number' => 6 ) ) as $cat ) {
        $used_categories[ $cat->term_id ] = array(
            'name'  => $cat->name,
            'slug'  => $cat->slug,
            'link'  => get_category_link( $cat->term_id ),
            'count' => $cat->count,
        );
    }
}

$featured_category_ids = array_slice( array_keys( $used_categories ), 0, 6 );
?>

<?php
$magazine_products = array();
if ( class_exists( 'WooCommerce' ) && function_exists( 'wc_get_products' ) ) {
    $magazine_products = wc_get_products(
        array(
            'status'  => 'publish',
            'limit'   => 16,
            'orderby' => 'date',
            'order'   => 'DESC',
        )
    );
}
?>

<?php if ( ! empty( $magazine_products ) ) : ?>

    <section class="site-container magazine-section">

        <div class="section-title">
            <h2><span class="magazine-badge">Magazine</span>All Issues</h2>
            <div class="section-title-actions">
                <div class="editorial-controls">
                    <button class="editorial-nav editorial-prev" type="button" aria-label="Previous issues">&#8249;</button>
                    <button class="editorial-nav editorial-next" type="button" aria-label="Next issues">&#8250;</button>
                </div>
                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">View All Magazines</a>
            </div>
        </div>

        <div class="editorial-carousel">
            <div class="editorial-grid magazine-grid">
                <?php foreach ( $magazine_products as $magazine_product ) : ssi_fanzine_magazine_card( $magazine_product ); endforeach; ?>
            </div>
        </div>

    </section>

<?php endif; ?>

<section class="site-container video-section">

    <div class="section-title">
        <h2>Latest Videos</h2>
        <a href="https://www.youtube.com/@sportsscienceindia/videos" target="_blank" rel="noopener">View All Videos</a>
    </div>

    <div class="video-grid">

        <?php
        $featured_videos = array(
            array( 'title' => 'Groundbreaking ACL Reconstruction | Jewel ACL Technology in Action | Dr. Sarthak Patnaik', 'url' => 'https://youtu.be/-L5wW_lPmUM', 'id' => '-L5wW_lPmUM', 'cat' => 'Sports Science' ),
            array( 'title' => 'What Causes PCL Tears, and How Can They Be Treated? Dr. Sarthak Patnaik Explains', 'url' => 'https://youtu.be/z1_9wM8FdU4', 'id' => 'z1_9wM8FdU4', 'cat' => 'Injury & Recovery' ),
            array( 'title' => 'Posterior Shoulder Pain | Posterior Bankart Repair | Posterior SLAP Tear', 'url' => 'https://youtu.be/IS_G1RWmp3w', 'id' => 'IS_G1RWmp3w', 'cat' => 'Injury & Recovery' ),
            array( 'title' => 'ACL Reconstruction | Meniscus Repair | Both Knee | Dr. Sarthak Patnaik', 'url' => 'https://youtu.be/GQanF1HLwFo', 'id' => 'GQanF1HLwFo', 'cat' => 'Videos' ),
        );
        foreach ( $featured_videos as $featured_video ) {
            ssi_fanzine_external_video_card( $featured_video['title'], $featured_video['url'], $featured_video['id'], $featured_video['cat'], isset( $featured_video['image'] ) ? $featured_video['image'] : '' );
        }
        ?>

    </div>

</section>

<?php if ( ! empty( $featured_category_ids ) ) : ?>

    <section class="site-container featured-categories">

        <div class="section-title">
            <h2>Featured Categories</h2>
        </div>

        <div class="category-strip">

            <?php foreach ( $featured_category_ids as $category_term_id ) : ?>

                <?php
                $category        = $used_categories[ $category_term_id ];
                $category_posts  = get_posts(
                    array(
                        'category'    => $category_term_id,
                        'numberposts' => 1,
                    )
                );
                $category_image = $category_posts ? get_the_post_thumbnail_url( $category_posts[0]->ID, 'medium_large' ) : '';
                ?>

                <a class="category-tile" href="<?php echo esc_url( $category['link'] ); ?>">
                    <?php if ( $category_image ) : ?>
                        <img src="<?php echo esc_url( $category_image ); ?>" alt="">
                    <?php endif; ?>
                    <span><?php echo esc_html( $category['name'] ); ?></span>
                    <small>View All</small>
                </a>

            <?php endforeach; ?>

        </div>

    </section>

<?php endif; ?>

<?php
$editorial_cats = array_slice( array_keys( $used_categories ), 0, 8 );
?>

<?php if ( ! empty( $editorial_cats ) ) : ?>

    <?php foreach ( $editorial_cats as $ecat_id ) : ?>

        <?php
        $ecat       = $used_categories[ $ecat_id ];
        $lead_query = new WP_Query(
            array(
                'post_type'      => 'post',
                'cat'            => $ecat_id,
                'posts_per_page' => 8,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
                'no_found_rows'  => true,
            )
        );
        ?>

        <?php if ( $lead_query->have_posts() ) : ?>

            <section class="site-container editorial-section editorial-<?php echo esc_attr( sanitize_title( $ecat['slug'] ) ); ?>">

                <div class="section-title">
                    <h2><?php echo esc_html( $ecat['name'] ); ?></h2>
                    <div class="section-title-actions">
                        <div class="editorial-controls">
                            <button class="editorial-nav editorial-prev" type="button" aria-label="Previous stories">&#8249;</button>
                            <button class="editorial-nav editorial-next" type="button" aria-label="Next stories">&#8250;</button>
                        </div>
                        <a href="<?php echo esc_url( $ecat['link'] ); ?>">More</a>
                    </div>
                </div>

                <div class="editorial-carousel">

                <div class="editorial-grid">

                    <?php while ( $lead_query->have_posts() ) : $lead_query->the_post(); ?>

                        <article class="editorial-item">
                            <a class="editorial-item-thumb" href="<?php the_permalink(); ?>">
                                <?php ssi_fanzine_post_thumb( 'medium' ); ?>
                            </a>
                            <div class="editorial-item-body">
                                <div class="post-category"><?php ssi_fanzine_post_category_label(); ?></div>
                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <p class="post-meta"><span class="meta-date-inner"><?php echo esc_html( ssi_fanzine_relative_time() ); ?></span></p>
                            </div>
                        </article>

                    <?php endwhile; ?>

                    <?php wp_reset_postdata(); ?>

                </div>

                </div>

            </section>

        <?php endif; ?>

    <?php endforeach; ?>

<?php endif; ?>

<?php get_footer(); ?>

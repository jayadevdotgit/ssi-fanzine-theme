<?php
/**
 * SSI FANZINE Single Article
 */

get_header();
$current_post_id = 0;
?>

<div class="site-container single-layout">

    <?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>

            <?php $current_post_id = get_the_ID(); ?>

            <aside class="single-sidebar single-sidebar-left" aria-label="Article navigation">

                <section class="single-side-section">
                    <div class="section-title"><h2>Trending Now</h2></div>
                    <div class="single-side-list">
                        <?php
                        $left_query = new WP_Query(
                            array(
                                'post_type'      => 'post',
                                'posts_per_page' => 5,
                                'post__not_in'   => array( get_the_ID() ),
                                'post_status'    => 'publish',
                                'orderby'        => 'date',
                                'order'          => 'DESC',
                                'no_found_rows'  => true,
                            )
                        );
                        while ( $left_query->have_posts() ) : $left_query->the_post();
                            ?>
                            <article class="single-side-story">
                                <a class="single-side-thumb" href="<?php the_permalink(); ?>">
                                    <?php ssi_fanzine_post_thumb( 'thumbnail' ); ?>
                                </a>
                                <div>
                                    <div class="post-category"><?php ssi_fanzine_post_category_label(); ?></div>
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <p class="post-meta"><?php echo esc_html( get_the_date() ); ?></p>
                                </div>
                            </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </section>

                <section class="single-side-section single-side-categories">
                    <div class="section-title"><h2>Categories</h2></div>
                    <?php
                    $side_categories = get_categories(
                        array(
                            'hide_empty' => true,
                            'number'     => 8,
                            'exclude'    => get_cat_ID( 'Uncategorized' ),
                        )
                    );
                    foreach ( $side_categories as $side_category ) :
                        ?>
                        <a class="single-category-link" href="<?php echo esc_url( get_category_link( $side_category->term_id ) ); ?>">
                            <span><?php echo esc_html( $side_category->name ); ?></span>
                            <strong><?php echo esc_html( $side_category->count ); ?></strong>
                        </a>
                    <?php endforeach; ?>
                </section>

            </aside>

            <main class="single-main-column">

                <?php ssi_fanzine_breadcrumbs(); ?>

                <article class="single-article">

                    <header class="single-header">

                        <div class="post-category">
                            <?php ssi_fanzine_post_category_label(); ?>
                        </div>

                        <h1><?php the_title(); ?></h1>

                        <?php
                        $ssi_fanzine_subtitle = get_post_meta( get_the_ID(), '_ssi_fanzine_subtitle', true );
                        if ( $ssi_fanzine_subtitle ) :
                        ?>
                            <div class="ssi-fanzine-subtitle" aria-label="Subtitle">
                                <?php echo esc_html( $ssi_fanzine_subtitle ); ?>
                            </div>
                        <?php endif; ?>

                        <div class="single-meta">
                            By
                            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                                <?php echo esc_html( get_the_author() ); ?>
                            </a>
                            ·
                            <?php echo esc_html( get_the_date() ); ?>
                        </div>

                    </header>

                    <?php $single_image = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'large' ) : ssi_fanzine_content_image(); ?>

                    <?php if ( $single_image ) : ?>
                        <figure class="single-featured-image">
                            <img src="<?php echo esc_url( $single_image ); ?>" alt="<?php the_title_attribute(); ?>" fetchpriority="high" decoding="async" onerror="this.onerror=null;this.src='<?php echo esc_url( ssi_fanzine_placeholder_url() ); ?>';">
                        </figure>
                    <?php endif; ?>

                    <div class="single-content">
                        <?php the_content(); ?>
                    </div>

                    <?php
                    $contextual_ids = ssi_fanzine_get_related_posts( $current_post_id, 3 );
                    if ( ! empty( $contextual_ids ) ) :
                        $contextual_query = new WP_Query(
                            array(
                                'post_type'      => 'post',
                                'posts_per_page' => 3,
                                'post__in'       => $contextual_ids,
                                'orderby'        => 'post__in',
                                'post_status'    => 'publish',
                                'no_found_rows'  => true,
                            )
                        );
                        if ( $contextual_query->have_posts() ) :
                            ?>
                            <section class="contextual-links" aria-labelledby="more-on-topic">
                                <div class="section-title"><h2 id="more-on-topic">More on this topic</h2></div>
                                <div class="contextual-link-list">
                                    <?php while ( $contextual_query->have_posts() ) : $contextual_query->the_post(); ?>
                                        <a class="contextual-link" href="<?php the_permalink(); ?>">
                                            <span class="post-category"><?php ssi_fanzine_post_category_label(); ?></span>
                                            <strong><?php the_title(); ?></strong>
                                        </a>
                                    <?php endwhile; wp_reset_postdata(); ?>
                                </div>
                            </section>
                            <?php
                        endif;
                    endif;
                    ?>

                    <footer class="single-footer">
                        <div class="post-category">Categories</div>
                        <div class="article-categories"><?php the_category( ' ' ); ?></div>
                    </footer>

                </article>

            </main>

            <aside class="single-sidebar single-sidebar-right" aria-label="More from SSI Fanzine">

                <section class="single-side-section follow-section">
                    <div class="section-title"><h2>Follow Us</h2></div>
                    <div class="single-social-links">
                        <a href="https://www.facebook.com/sportscienceindia/" target="_blank" rel="noopener" aria-label="Facebook"><?php ssi_fanzine_social_icon( 'facebook' ); ?></a>
                        <a href="https://x.com/SSI__India" target="_blank" rel="noopener" aria-label="X"><?php ssi_fanzine_social_icon( 'x' ); ?></a>
                        <a href="https://www.instagram.com/sports_science_india/" target="_blank" rel="noopener" aria-label="Instagram"><?php ssi_fanzine_social_icon( 'instagram' ); ?></a>
                        <a href="https://www.youtube.com/@sportsscienceindia" target="_blank" rel="noopener" aria-label="YouTube"><?php ssi_fanzine_social_icon( 'youtube' ); ?></a>
                    </div>
                </section>

                <?php ssi_fanzine_newsletter_box(); ?>

                <section class="single-side-section">
                    <div class="section-title"><h2>Editor's Pick</h2></div>
                    <div class="single-side-list editor-pick-list">
                        <?php
                        $right_ids = ssi_fanzine_get_related_posts( $current_post_id, 3 );
                        $right_query = new WP_Query(
                            array(
                                'post_type'      => 'post',
                                'posts_per_page' => 3,
                                'post__in'       => $right_ids,
                                'orderby'        => 'post__in',
                                'post_status'    => 'publish',
                                'no_found_rows'  => true,
                            )
                        );
                        while ( $right_query->have_posts() ) : $right_query->the_post();
                            ?>
                            <article class="editor-pick-story">
                                <a class="editor-pick-thumb" href="<?php the_permalink(); ?>">
                                    <?php ssi_fanzine_post_thumb( 'medium' ); ?>
                                </a>
                                <div class="post-category"><?php ssi_fanzine_post_category_label(); ?></div>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </section>

                <?php $post_tags = get_the_tags(); ?>
                <?php if ( $post_tags ) : ?>
                    <section class="single-side-section single-tags-section">
                        <div class="section-title"><h2>Tags</h2></div>
                        <div class="single-tags">
                            <?php foreach ( $post_tags as $post_tag ) : ?>
                                <a href="<?php echo esc_url( get_tag_link( $post_tag->term_id ) ); ?>"><?php echo esc_html( $post_tag->name ); ?></a>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

            </aside>

        <?php endwhile; ?>

    <?php endif; ?>

</div>

<?php
$recommended_ids = ssi_fanzine_get_related_posts( $current_post_id, 4 );
$recommended_query = new WP_Query(
    array(
        'post_type'      => 'post',
        'posts_per_page' => 4,
        'post__in'       => $recommended_ids,
        'orderby'        => 'post__in',
        'post_status'    => 'publish',
        'no_found_rows'  => true,
    )
);
?>

<?php if ( $recommended_query->have_posts() ) : ?>
    <section class="site-container recommended-section">
        <div class="section-title"><h2>Recommended Articles</h2></div>
        <div class="article-grid recommended-grid">
            <?php while ( $recommended_query->have_posts() ) : $recommended_query->the_post(); ssi_fanzine_article_card(); endwhile; wp_reset_postdata(); ?>
        </div>
    </section>
<?php endif; ?>

<?php get_footer(); ?>

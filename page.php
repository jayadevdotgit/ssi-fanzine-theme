<?php
/**
 * SSI FANZINE Dedicated Page
 */

get_header();

if ( 'authors' === get_post_field( 'post_name', get_queried_object_id() ) ) {
    $authors_template = get_theme_file_path( 'authors.php' );

    if ( file_exists( $authors_template ) ) {
        include $authors_template;
        return;
    }
}
?>

<div class="site-container">

    <?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>

            <article class="single-article">

                <header class="single-header">

                    <div class="post-category">
                        PAGE
                    </div>

                    <h1>
                        <?php the_title(); ?>
                    </h1>

                </header>

                <?php if ( has_post_thumbnail() ) : ?>

                    <figure class="single-featured-image">
                        <?php the_post_thumbnail( 'full' ); ?>
                    </figure>

                <?php endif; ?>

                <div class="single-content">
                    <?php the_content(); ?>
                </div>

            </article>

        <?php endwhile; ?>

    <?php endif; ?>

</div>

<?php get_footer(); ?>

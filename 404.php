<?php
/**
 * SSI FANZINE 404 Page
 */

get_header();
?>

<div class="site-container">

    <section class="error-page">

        <div class="post-category">
            SSI FANZINE
        </div>

        <h1>Page not found.</h1>

        <p>
            The page you're looking for doesn't exist or may have been moved.
        </p>

        <a
            class="error-home-link"
            href="<?php echo esc_url(home_url('/')); ?>"
        >
            ← Back to homepage
        </a>

    </section>

</div>

<?php get_footer(); ?>
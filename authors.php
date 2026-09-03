<?php
/**
 * SSI FANZINE Authors Directory
 *
 * Dynamic author directory. Authors are pulled from WordPress users
 * who have at least one published post.
 *
 * @package SSI_Fanzine
 */

defined( 'ABSPATH' ) || exit;

get_header();

$all_authors = get_users(
    array(
        'has_published_posts' => array( 'post' ),
        'orderby'             => 'display_name',
        'order'               => 'ASC',
    )
);

$allowed_author_names = array(
    'Vishesh Shukla',
    'Sohini Mukherjee',
);

$authors = array_values(
    array_filter(
        $all_authors,
        static function ( $author ) use ( $allowed_author_names ) {
            return in_array( trim( $author->display_name ), $allowed_author_names, true );
        }
    )
);
?>

<main class="ssi-authors-page">
    <div class="site-container">
        <header class="ssi-authors-heading">
            <div class="post-category">SSI FANZINE</div>
            <h1>Our Authors</h1>
            <p>Meet the journalists and contributors behind SSI FANZINE.</p>
        </header>

        <?php if ( ! empty( $authors ) ) : ?>
            <div class="ssi-authors-grid">
                <?php foreach ( $authors as $author ) : ?>
                    <?php
                    $author_id    = (int) $author->ID;
                    $author_url   = get_author_posts_url( $author_id );
                    $author_name  = $author->display_name;
                    $author_bio   = trim( get_the_author_meta( 'description', $author_id ) );
                    $post_count   = (int) count_user_posts( $author_id, 'post', true );
                    $avatar       = ssi_fanzine_author_avatar_html( $author_id, 120, 'ssi-author-directory-avatar' );
                    ?>
                    <article class="ssi-author-card">
                        <a class="ssi-author-card-avatar" href="<?php echo esc_url( $author_url ); ?>" aria-label="<?php echo esc_attr( 'View articles by ' . $author_name ); ?>">
                            <?php echo $avatar; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </a>

                        <div class="ssi-author-card-content">
                            <div class="post-category">AUTHOR</div>
                            <h2>
                                <a href="<?php echo esc_url( $author_url ); ?>">
                                    <?php echo esc_html( $author_name ); ?>
                                </a>
                            </h2>

                            <?php if ( $author_bio ) : ?>
                                <p><?php echo esc_html( wp_trim_words( $author_bio, 28 ) ); ?></p>
                            <?php endif; ?>

                            <div class="ssi-author-card-meta">
                                <span><?php echo esc_html( number_format_i18n( $post_count ) ); ?> <?php echo esc_html( 1 === $post_count ? 'article' : 'articles' ); ?></span>
                                <a href="<?php echo esc_url( $author_url ); ?>">View profile →</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="ssi-authors-empty">
                <p>No authors with published articles were found.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>

<?php
/**
 * SSI FANZINE - Custom Login Page
 *
 * Uses WordPress' native authentication form and security handling.
 */

if ( is_user_logged_in() ) {
    wp_safe_redirect( home_url( '/' ) );
    exit;
}

get_header();
?>

<section class="ssi-login-page">
    <div class="ssi-login-shell">
        <div class="ssi-login-brand">
            <span class="ssi-login-rule" aria-hidden="true"></span>
            <span class="ssi-login-ssi">SSI</span>
            <span class="ssi-login-rule" aria-hidden="true"></span>
        </div>

        <div class="ssi-login-title">Fanzine</div>
        <p class="ssi-login-kicker">Sports stories that inspire</p>

        <div class="ssi-login-card">
            <div class="ssi-login-card-heading">
                <span class="ssi-login-label">Member Access</span>
                <h1>Welcome Back</h1>
                <p>Sign in to continue to SSI Fanzine.</p>
            </div>

            <?php
            wp_login_form(
                array(
                    'echo'           => true,
                    'redirect'       => home_url( '/' ),
                    'form_id'        => 'ssi-loginform',
                    'label_username' => __( 'Username or Email Address', 'ssi-fanzine' ),
                    'label_password' => __( 'Password', 'ssi-fanzine' ),
                    'label_remember' => __( 'Remember Me', 'ssi-fanzine' ),
                    'label_log_in'   => __( 'Log In', 'ssi-fanzine' ),
                    'remember'       => true,
                    'value_username' => '',
                    'value_remember' => false,
                )
            );
            ?>

            <div class="ssi-login-links">
                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">Forgot Password?</a>
            </div>
        </div>

        <a class="ssi-login-back" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <span aria-hidden="true">←</span> Back to SSI Fanzine
        </a>
    </div>
</section>

<?php get_footer(); ?>

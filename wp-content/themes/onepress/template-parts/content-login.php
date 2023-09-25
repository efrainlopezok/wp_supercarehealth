<?php
/**
 * Template part for displaying page content in login.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package OnePress
 */

function redirect_login_page() {
  $login_page  = home_url( '/login/' );
  $page_viewed = basename($_SERVER['REQUEST_URI']);
 
  if( $page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
    wp_redirect($login_page);
    exit;
  }
}
add_action('init','redirect_login_page');

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		
		<div class="row">
            <div class="col-md-6">
                <div class="content-l-template">
                <?php the_content(); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="container-custom-form">
                    <h3><?php echo get_field('login_right_title'); ?></h3>
                    <p><?php echo get_field('login_right_description'); ?></p>
                    <?php
                    $args = array(
                        'redirect' => get_site_url(), 
                        'form_id' => 'loginform-custom',
                        'label_username' => __( 'Email' ),
                        'label_password' => __( 'Password' ),
                        'label_remember' => __( 'Remember Me' ),
                        'label_log_in' => __( 'Login' ),
                        'remember' => true
                    );
                    wp_login_form( $args ); ?>
                </div>
            </div>
        </div>
	</div><!-- .entry-content -->
</article><!-- #post-## -->


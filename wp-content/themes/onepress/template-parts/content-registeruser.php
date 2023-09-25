<?php
/**
 * Template part for displaying page content in registeruser.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package OnePress
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content content-register">
        <div class="header-register">
            <div class="container">
                <h2 class="text-center">Register</h2>
            </div>
        </div>
        <div class="tab-content container">
            <div id="menu1" class="tab-pane active in">
                <div class="container-register-fields">
                    <?php echo do_shortcode('[gravityform id=28 title=false description=false ajax=false]'); ?>
                </div>
            </div>
        </div>
        
		<?php the_content(); ?>
		
	</div><!-- .entry-content -->
</article><!-- #post-## -->

<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package OnePress
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php //the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<div class="faq-container">
			<div class="icon-top">
				<?php
				$image_top = get_field('top_faq_icon');
				?>
				<img src="<?php echo $image_top; ?>" />
			</div>
			<div class="faq-items">
				<?php
				if(have_rows('faq_questions')) :
					while( have_rows('faq_questions') ): the_row();
						echo '<div class="item-faq">';
							echo '<h4 class="item-question">'.get_sub_field('question').'</h4>';
							echo '<div class="item-answer">'.do_shortcode(get_sub_field('answer')).'</div>';
						echo '</div>';
					endwhile;
				endif;
				?>
			</div>
		</div>
		<?php

		?>
	</div><!-- .entry-content -->
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('.faq-items .item-faq .item-question').on('click', function(){
				if (jQuery(this).parent().hasClass('active')) {
					jQuery('.faq-items .item-faq').removeClass('active');
					jQuery('.faq-items .item-faq .item-answer').hide(500);
				}else{
					jQuery('.faq-items .item-faq').removeClass('active');
					jQuery('.faq-items .item-faq .item-answer').hide(500);
					jQuery(this).parent().addClass('active');
					jQuery(this).parent().find('.item-answer').show(500);
				}
			});
		});
	</script>
</article><!-- #post-## -->


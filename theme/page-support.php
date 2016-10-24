<?php
/**
 * Page with support for support comments.
 *
 * @package @@name
 */

/*
 * Template Name: Commentaires de soutien
 */
?>
<?php get_header(); ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

					<header>
						<?php the_post_thumbnail( 'full' ); ?>
					</header> <!-- end article header -->

					<section class="post_content clearfix" itemprop="articleBody">
						<?php the_content(); ?>
						<?php get_template_part( 'elements/comments', 'fight' ); ?>
					</section> <!-- end article section -->

				</article> <!-- end article -->
					
	<?php endwhile; ?>		
	<?php else : ?>

		<?php get_template_part( 'templates/404' ); ?>

	<?php endif; ?>

<?php get_footer(); ?>

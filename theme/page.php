<?php get_header(); ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

					<header>
						<?php the_post_thumbnail( 'full' ); ?>
					</header> <!-- end article header -->

					<section class="post_content clearfix" itemprop="articleBody">
						<?php the_content(); ?>
					</section> <!-- end article section -->

				</article> <!-- end article -->
					
	<?php endwhile; ?>		
	<?php else : ?>

		<?php get_template_part( 'templates/404' ); ?>

	<?php endif; ?>

<?php get_footer(); ?>

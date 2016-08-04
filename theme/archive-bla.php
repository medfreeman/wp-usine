<?php get_header(); ?>

	<?php
		get_template_part( 'elements/content', 'home' );
	?>

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'single' , 'bla' ); ?>

		<?php endwhile; ?>	

		<?php usine_pagination(); ?>

	<?php else : ?>

		<?php get_template_part( 'templates/404' ); ?>

	<?php endif; ?>

<?php get_footer(); ?>

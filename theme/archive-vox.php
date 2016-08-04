<?php get_header(); ?>

	<?php
		get_template_part( 'elements/content', 'vox' );
	?>

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'single' , 'vox' ); ?>

		<?php endwhile; ?>

		<?php if ( function_exists( 'vox_pagination' ) ) : // if expirimental feature is active ?>

			<?php vox_pagination(); // use the page navi function ?>

		<?php endif; ?>

	<?php else : ?>

		<?php get_template_part( 'templates/404' ); ?>

	<?php endif; ?>

<?php get_footer(); ?>

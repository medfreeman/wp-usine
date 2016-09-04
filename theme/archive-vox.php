<?php
/**
 * Archive page for vox post type.
 *
 * @package @@name
 */

?>
<?php get_header(); ?>

	<?php
	if ( function_exists( 'vox_is_paged' ) && ! vox_is_paged() ) { // Show content only in first page.
		get_template_part( 'elements/content', 'vox' );
	}
	?>

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'single' , 'vox' ); ?>

		<?php endwhile; ?>

		<?php if ( function_exists( 'vox_pagination' ) ) : // If pagination function exists. ?>

			<?php vox_pagination(); // Use the page navi function. ?>

		<?php endif; ?>

	<?php else : ?>

		<?php get_template_part( 'templates/404' ); ?>

	<?php endif; ?>

<?php get_footer();

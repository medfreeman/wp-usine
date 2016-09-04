<?php
/**
 * Single page for vox post type.
 *
 * @package @@name
 */

?>
<?php if ( is_single() ) : ?>
	<?php get_header(); ?>
	<?php the_post(); ?>
<?php endif; ?>

<?php
global $current_year;
$year = get_post_meta( get_the_ID(), 'vox_year', true );
if ( $year !== $current_year ) :
	$current_year = $year;
?>
				<div class="vox__year"><h4 class="vox__year_heading"><?php echo esc_html( $year ); ?></h4></div>
<?php
endif;
?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'vox__article' ); ?> role="article">

					<header>
						<figure>
							<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" rel="<?php echo esc_attr( $year ); ?>" class="vox__link"><?php the_post_thumbnail( 'vox-thumb' ); ?></a>
						</figure>
						<span class="vox__title"><?php the_title(); ?></span>
					</header> <!-- end article header -->

				</article>

<?php if ( is_single() ) : ?>
	<?php get_footer(); ?>
<?php endif; ?>

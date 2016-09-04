<?php
/**
 * Single page for bla post type.
 *
 * @package @@name
 */

?>
<?php if ( is_single() ) : ?>
	<?php get_header(); ?>
	<?php the_post(); ?>
<?php endif; ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">
					<header>

						<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'wpf-featured' ); ?></a>
							
						<h2><?php the_title(); ?></h2>

						<p class="meta"><?php esc_html_e( 'Posté le', 'usine' ); ?> <time datetime="<?php echo esc_attr( the_time( 'Y-m-j' ) ); ?>" pubdate><?php echo esc_html( date_i18n( 'j F Y', get_the_time( 'U' ) ) ); ?></time>.</p>

					</header> <!-- end article header -->

					<section class="post_content clearfix">
						<?php the_content( 'Read more &raquo;' ); ?>
					</section> <!-- end article section -->

				</article> <!-- end article -->

<?php if ( is_single() ) : ?>
	<?php get_footer(); ?>
<?php endif; ?>

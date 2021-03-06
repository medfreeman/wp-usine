<?php
/**
 * Content of the page selected to be shown over blas archive page.
 *
 * @package @@name
 */

?>
<?php
$page_id = absint( get_theme_mod( USINE_THEME_MOD_BLA_PAGE ) );
if ( ! $page_id ) {
	return;
}
$args = array(
	'post_type' => 'page',
	'page_id'   => $page_id,
);
$page_query = new WP_Query( $args );

if ( $page_query->have_posts() ) :
	$page_query->the_post();
	$post_data = $page_query->post;
	setup_postdata( $post_data );
	the_content();
	wp_reset_postdata();
endif;

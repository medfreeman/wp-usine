<?php
/**
 * Content of the page selected to be shown over vox archive page.
 *
 * @package @@name
 */

?>
<?php
	global $post;
	$args = array(
		'page_id' => absint( get_theme_mod( USINE_THEME_MOD_VOX_PAGE ) ),
	);
	$page_query = new WP_Query( $args );

	if ( $page_query->have_posts() ) :
		$page_query->the_post();
		$post_data = $page_query->post;
		setup_postdata( $post_data );

		the_content();

		wp_reset_postdata();
	endif;

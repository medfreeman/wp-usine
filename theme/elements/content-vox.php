<?php
	global $post;
	$args = array(
		'page_id' => absint( get_theme_mod( USINE_THEME_MOD_VOX_PAGE ) ),
	);
	$page_query = new WP_Query( $args );

	if ( $page_query->have_posts() ) :
		$page_query->the_post();
		$post = $page_query->post;
		setup_postdata( $post );

		the_content();

		wp_reset_postdata();
	endif;
?>

<?php
global $post;
$front_page_id = get_option( 'page_on_front' );
if ( $front_page_id ) {
	$args = array(
		'page_id' => $front_page_id,
	);
	$page_query = new WP_Query( $args );

	if ( $page_query->have_posts() ) :
		$page_query->the_post();
		$post = $page_query->post;
		setup_postdata( $post );

		the_content();

		wp_reset_postdata();
	endif;
}
?>

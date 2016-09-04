<?php
/**
 * Template for support comments.
 *
 * @package @@name
 */

?>
<?php
	$args = array(
			'comment_notes_before' => '',
			'comment_notes_after' => '',
			'title_reply' => __( 'Ecrire un message de soutien', 'usine' ),
			'label_submit'      => __( 'Publier le message', 'usine' ),
			'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Message', 'noun', 'usine' ) . '</label><br><textarea id="comment" name="comment" class="form-control" aria-required="true"></textarea></p>',
	);
	comment_form( $args );

	if ( get_comments_number() ) :
?>

		<section class="commentlist">
			<?php
				wp_list_comments( array(
					'style'             => 'div',
					'short_ping'        => true,
					'avatar_size'       => 40,
					'type'              => 'all',
					'reply_text'        => __( 'Reply', 'usine' ),
					'page'              => '',
					'per_page'          => '',
					'reverse_top_level' => null,
					'reverse_children'  => '',
					'walker'            => new MInc_Walker_Comment_ZipGun(),
				), get_comments( array( 'post_id' => get_the_ID(), 'status' => 'approve' ) ) );
			?>
		</section>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav class="navigation comment__navigation" role="navigation">
				<div class="comment-nav-prev"><?php previous_comments_link( __( '&larr; Previous Comments', 'usine' ) ); ?></div>
				<div class="comment-nav-next"><?php next_comments_link( __( 'More Comments &rarr;', 'usine' ) ); ?></div>
			</nav>
		<?php endif; ?>

		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.' , 'usine' ); ?></p>
		<?php endif; ?>

	<?php else : ?>
				<ul id="comment__list"></ul>
	<?php endif; ?>

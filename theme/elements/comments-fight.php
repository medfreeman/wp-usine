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
			'title_reply' => __( 'Ecrire un message de soutien', USINE_TEXTDOMAIN ),
			'label_submit'      => __( 'Publier le message', USINE_TEXTDOMAIN ),
			'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Message', 'noun', USINE_TEXTDOMAIN ) . '</label><br><textarea id="comment" name="comment" class="form-control" aria-required="true"></textarea></p>',
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
					'reply_text'        => __( 'Reply', USINE_TEXTDOMAIN ),
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
				<div class="comment-nav-prev"><?php previous_comments_link( __( '&larr; Previous Comments', USINE_TEXTDOMAIN ) ); ?></div>
				<div class="comment-nav-next"><?php next_comments_link( __( 'More Comments &rarr;', USINE_TEXTDOMAIN ) ); ?></div>
			</nav>
		<?php endif; ?>

		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.' , USINE_TEXTDOMAIN ); ?></p>
		<?php endif; ?>

	<?php else : ?>
				<ul id="comment__list"></ul>
	<?php endif; ?>

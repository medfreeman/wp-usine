<?php
/**
 * Walker Nav Menu extension
 * to support Usine
 * comments format
 *
 * @author Mehdi Lahlou <http://usine.ch>
 */


// make sure this file is called by wp
defined( 'ABSPATH' ) or die();



/**
 * Class MInc_ZipGun_Walker_Comment
 *
 * Prints the Html for the comments
 * list
 *
 * @since 1.0
 *
 * @uses  Walker_Comment
 */
class MInc_Walker_Comment_ZipGun extends Walker_Comment {

	// init classwide variables
	var $tree_type = 'comment';
	var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

	/** CONSTRUCTOR
	 * You'll have to use this if you plan to get to the top of the comments list, as
	 * start_lvl() only goes as high as 1 deep nested comments */
	function __construct() {
		?>

		<h3 class="comment__title"><?php esc_html_e( __( 'Vos messages de soutien', USINE_TEXTDOMAIN ) ); ?></h3>
		<ul class="comment__list">

		<?php
	}

	/** START_LVL
	 * Starts the list before the CHILD elements are added. Unlike most of the walkers,
	 * the start_lvl function means the start of a nested comment. It applies to the first
	 * new level under the comments that are not replies. Also, it appear that, by default,
	 * WordPress just echos the walk instead of passing it to &$output properly. Go figure.  */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;

		?>
				<ul class="children">
		<?php
	}

	/** END_LVL
	 * Ends the children list of after the elements are added. */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;

		?>
		</ul><!-- /.children -->
		<?php
	}

	/** START_EL */
	function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
		$depth++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment'] = $comment;
		$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' ); ?>
		
		<li <?php comment_class( $parent_class ); ?> id="comment-<?php comment_ID() ?>">
			<div id="comment-body-<?php comment_ID() ?>" class="comment__body">

				<div id="comment-content-<?php comment_ID(); ?>" class="comment__content">
					<?php if ( ! $comment->comment_approved ) : ?>
					<em class="comment__message comment-awaiting-moderation">
						<?php esc_html_e( __( 'Votre message est en attente de modération.', USINE_TEXTDOMAIN ) ); ?>
					</em>

					<?php else : comment_text(); ?>
					<?php endif; ?>
				</div><!-- /.comment-content -->

				<div class="comment__author vcard author">
					<?php
						echo ( 0 !== absint( $args['avatar_size'] ) ? get_avatar( $comment, $args['avatar_size'] ) :'' );
					?>
					<cite class="fn n comment__author"><?php echo get_comment_author_link(); ?></cite>
				</div><!-- /.comment-author -->

				<div class="reply">
					<?php

					$reply_args = array(
						'depth' => $depth,
						'max_depth' => $args['max_depth'],
					);

					comment_reply_link( array_merge( $args, $reply_args ) );  ?>
				</div><!-- /.reply -->
			</div><!-- /.comment-body -->

	<?php }

	function end_el( &$output, $comment, $depth = 0, $args = array() ) {
		?>

		</li><!-- /#comment-' . get_comment_ID() . ' -->

		<?php
	}

	/** DESTRUCTOR
	 * I just using this since we needed to use the constructor to reach the top
	 * of the comments list, just seems to balance out :) */
	function __destruct() {
		?>

		</ul><!-- /#comment-list -->

		<?php
	}
}

<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WPST
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
				printf( // WPCS: XSS OK.
					/* translators: %s: post title */
					esc_html( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'wpst' ) ),
					number_format_i18n( get_comments_number() ),
					'<span>' . get_the_title() . '</span>'
				);
			?>
		</h2><!-- .comments-title -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'wpst' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'wpst' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'wpst' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>

		<ol class="comment-list">
			<?php
				wp_list_comments(
					array(
						'style'      => 'ol',
						'short_ping' => true,
					)
				);
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'wpst' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'wpst' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'wpst' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-below -->
			<?php
		endif; // Check for comment navigation.

	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'wpst' ); ?></p>
		<?php
	endif;

	if ( is_user_logged_in() ) {
		$comments_args = array(
			'fields'              => apply_filters(
				'comment_form_default_fields',
				array(
					'author' => '<div class="comment-form-author"><label for="author">' . __( 'Name', 'wpst' ) . ' <span class="required">*</span></label><input id="author" name="author" type="text" value="' .
					esc_attr( $commenter['comment_author'] ) . '" size="30" /></div>',
					'email'  => '<div class="comment-form-email"><label for="email">' . __( 'Email', 'wpst' ) . ' <span class="required">*</span></label><input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .
					'" size="30" /></div>',
					'url'    => '<div class="comment-form-url"><label for="url">' . __( 'Website', 'wpst' ) . '</label><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>',
				)
			),
			'comment_field'       => '<div class="comment-form-comment full-width">' .
			'<label for="comment">' . __( 'Comment', 'wpst' ) . '</label>' .
			'<textarea id="comment" name="comment" rows="8" aria-required="true"></textarea>' .
			'</div>',
			'comment_notes_after' => '',
			'class_submit'        => 'button large margin-top-2',
		);
	} else {
		$comments_args = array(
			'fields'              => apply_filters(
				'comment_form_default_fields',
				array(
					'author' => '<div class="comment-form-author"><label for="author">' . __( 'Name', 'wpst' ) . ' <span class="required">*</span></label><input id="author" name="author" type="text" value="' .
					esc_attr( $commenter['comment_author'] ) . '" size="30" /></div>',
					'email'  => '<div class="comment-form-email"><label for="email">' . __( 'Email', 'wpst' ) . ' <span class="required">*</span></label><input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .
					'" size="30" /></div>',
					'url'    => '<div class="comment-form-url"><label for="url">' . __( 'Website', 'wpst' ) . '</label><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div></div>',
				)
			),
			'comment_field'       => '<div class="row"><div class="comment-form-comment">' .
			'<label for="comment">' . __( 'Comment', 'wpst' ) . '</label>' .
			'<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>' .
			'</div>',
			'comment_notes_after' => '',
			'class_submit'        => 'button large margin-top-2',
		);
	}
	comment_form( $comments_args );
	?>

</div><!-- #comments -->

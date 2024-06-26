<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.  The actual display of comments is
 * handled by a callback to if_comment which is
 * located in the framework/nvr-general-functions.php file.
 *
 * @package WordPress
 * @subpackage Constance
 * @since Constance 1.0
 */
?>

			<div id="comments">
<?php if ( post_password_required() ) : ?>
				<p class="nopassword"><?php esc_html_e( 'This post is password protected. Enter the password to view any comments.', "constance" ); ?></p>
			</div><!-- #comments -->
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if ( have_comments() ) : ?>
			<h3 id="comments-title"><?php
			printf( _n( 'One Comment', '%1$s Comments', get_comments_number(), "constance" ),
			number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );
			?></h3>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( '<span class="meta-nav">&larr;</span> '.esc_html__( 'Older Comments', "constance" ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', "constance" ).' <span class="meta-nav">&rarr;</span>' ); ?></div>
			</div> <!-- .navigation -->
<?php endif; // check for comment navigation ?>

			<ol class="commentlist">
				<?php
					/* Loop through and list the comments. Tell wp_list_comments()
					 * to use if_comment() to format the comments.
					 * If you want to overload this in a child theme then you can
					 * define if_comment() and that will be used instead.
					 * See if_comment() in engine/theme-functions.php for more.
					 */
					wp_list_comments( array( 'callback' => 'constance_comment' ) );
				?>
			</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( '<span class="meta-nav">&larr;</span> '.esc_html__( 'Older Comments', "constance" ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', "constance" ).' <span class="meta-nav">&rarr;</span>' ); ?></div>
			</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	if ( ! comments_open() ) :
?>
	<p class="nocomments"><?php esc_html_e( 'Comments are closed.', "constance" ); ?></p>
<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

<?php 
comment_form(array(
'fields'					=> array(
									'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__( 'Name', "constance" ) . '</label> ' . ( $req ? '<span 								class="required">*</span>' : '' ) .
	            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $req . ' /></p>',
	'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', "constance"  ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
	            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $req . ' /></p>',
	'url'    => '<p class="comment-form-url"><label for="url">' . esc_html__( 'Website', "constance"  ) . '</label>' .
	            '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
),
'title_reply'          => esc_html__( 'Post a Comment', "constance"  ),
'label_submit'         => esc_html__( 'Submit', "constance"  ),
'comment_notes_after' => ''

)); ?>
	<div class="clearfix"></div>
</div><!-- #comments -->

<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Constance
 * @since Constance 1.0
 */

get_header(); ?>
                        
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="entry-content">
                <?php the_content( esc_html__( 'Read More', "constance" ) ); ?>
                <?php wp_link_pages( array( 'before' => '<div class="page-link">' . esc_html__( 'Pages:', "constance" ), 'after' => '</div>' ) ); ?>
                <?php edit_post_link( esc_html__( 'Edit', "constance" ), '<span class="edit-link">', '</span>' ); ?>
                <div class="clearfix"></div>
            </div><!-- .entry-content -->
        </div><!-- #post -->

        <?php comments_template( '', true ); ?>

        <?php endwhile; ?>
        
        <div class="clearfix"></div><!-- clear float --> 
        
<?php get_footer(); ?>
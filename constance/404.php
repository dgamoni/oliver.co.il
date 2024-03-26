<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Constance
 * @since Constance 1.0
 */

get_header(); ?>

        <p><?php esc_html_e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', "constance" ); ?></p>
        <?php get_template_part('searchform'); ?>
        
        <div class="clearfix"></div><!-- clear float --> 
                    
    
<?php get_footer(); ?>
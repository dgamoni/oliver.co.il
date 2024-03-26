<?php 
/* get website title */
if(!function_exists("constance_footer_text")){
	function constance_footer_text(){
		
		$nvr_foot= stripslashes(constance_get_option( 'constance_footer',''));
		if($nvr_foot==""){
		
			esc_html_e('Copyright', "constance" ); echo ' &copy;';
			
			echo ' 2013 <a href="'.esc_url( home_url( '/') ).'">'.get_bloginfo('name') .'.</a>';
			?> 
			<?php _e('Designed by', "constance" ); ?> 
            <a href="<?php echo esc_url( 'http://www.novarostudio.com' ); ?>" title="<?php echo esc_attr__('Novaro Studio', "constance" ); ?>"><?php esc_html_e('Novaro Studio', "constance"); ?></a>
        <?php 
		}else{
        	echo wp_kses_post( $nvr_foot );
        }
		
	}/* end constance_footer_text() */
}

if(!function_exists("constance_footer_text2")){
	function constance_footer_text2(){
		
		$foot= stripslashes(constance_get_option( 'constance_footer2'));		
        echo wp_kses_post( $foot );
		
	}/* end nvr_footer_text() */
}


if(!function_exists('constance_output_footertext')){
	function constance_output_footertext(){
		echo '<div class="copyright">';
			constance_footer_text();
		echo '</div>';
	}
	add_action('constance_output_footerarea','constance_output_footertext',5);
	
}

if(!function_exists('constance_output_footertext2')){
	function constance_output_footertext2(){
		echo '<div class="footerright">';
			constance_footer_text2();
		echo '</div>';
	}
	add_action('constance_output_footerarea','constance_output_footertext2',10);
	
}

if(!function_exists("constance_wp_footer")){
	function constance_wp_footer(){
		do_action("constance_wp_footer");
	}
	add_action('wp_head', 'constance_wp_footer', 100);
}

if(!function_exists("constance_quickview_container")){
	function constance_quickview_container(){
		echo '<div class="quickview-ajax-holder">';
            echo '<a href="#" class="btnajax fa fa-times"></a>';
            echo '<div class="quickview-ajax-data">';
            echo '</div>';
        echo '</div>';
	}
	add_action('wp_footer','constance_quickview_container',10);
}
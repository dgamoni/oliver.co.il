<?php
//custom meta field
$nvr_pid = constance_get_postid();    
$nvr_custom = constance_get_customdata($nvr_pid);
$nvr_cf_pagetitle = (isset($nvr_custom["nvr_page-title"][0]))? $nvr_custom["nvr_page-title"][0] : "";

if(is_singular('portofolio') || is_attachment()){

	echo '<h1 class="pagetitle"><span>'.get_the_title().'</span></h1>';
	
}elseif( function_exists('is_woocommerce') && is_woocommerce() ){
	echo '<h1 class="pagetitle"><span>';
		woocommerce_page_title();
	echo '</span></h1>';
}elseif(is_single()){
	$nvr_postspage = get_option('page_for_posts');
	$nvr_poststitle = $nvr_postspage? get_the_title($nvr_postspage) : esc_html__("Blog", "constance");
	
	echo '<h1 class="pagetitle"><span>'.$nvr_poststitle.'</span></h1>';
	
}elseif(is_archive()){
	echo ' <h1 class="pagetitle"><span>';
	if ( is_day() ) :
	printf( esc_html__( 'Daily Archives', "constance" ).' <span>%s</span>', get_the_date() );
	elseif ( is_month() ) :
	printf( esc_html__( 'Monthly Archives', "constance" ).' <span>%s</span>', get_the_date('F Y') );
	elseif ( is_year() ) :
	printf( esc_html__( 'Yearly Archives', "constance" ).' <span>%s</span>', get_the_date('Y') );
	elseif ( is_author()) :
	printf( esc_html__( 'Author Archives %s', "constance" ), "<a class='url fn n' href='" . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . "' title='" . esc_attr( get_the_author() ) . "' rel='me'>" . get_the_author() . "</a>" );
	else :
	printf( '%s', '<span>' . single_cat_title( '', false ) . '</span>' );
	endif;
	echo '</span> </h1>';
	
}elseif(is_search()){
	echo ' <h1 class="pagetitle"><span>';
	printf( esc_html__( 'Search Results for', "constance" ).' %s', '<span>' . get_search_query() . '</span>' );
	echo '</span> </h1>';
	
}elseif(is_404()){
	echo ' <h1 class="pagetitle"><span>';
	esc_html_e( '404 Page', "constance" );
	echo '</span> </h1>';
	
}elseif( is_home() ){
	$nvr_postspage = get_option('page_for_posts');
	$nvr_poststitle = get_the_title($nvr_postspage);
	
	echo ' <h1 class="pagetitle"><span>';
	echo ($nvr_postspage)? $nvr_poststitle : esc_html__('Blog', "constance" );
	echo '</span> </h1>';
	
}else{
	
	if($nvr_cf_pagetitle == ""){
		echo '<h1 class="pagetitle"><span>'.get_the_title().'</span></h1>';
	}else{
		echo '<h1 class="pagetitle"><span>'.$nvr_cf_pagetitle.'</span></h1>';
	}

}
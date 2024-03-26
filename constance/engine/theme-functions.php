<?php
if(!function_exists('constance_get_sidebar_position')){
	function constance_get_sidebar_position($nvr_postid = ''){
		
		$nvr_pid = constance_get_postid();
		$nvr_custom = constance_get_customdata($nvr_pid);
		
		if($nvr_postid){
			$nvr_custom = constance_get_customdata($nvr_postid);
		}
		
		$nvr_pagelayoutall = array('one-col','two-col-left','two-col-right');
		
		$nvr_sidebarposition = constance_get_option( 'constance_sidebar_position' ,'two-col-left'); 
		$nvr_pagelayout = ($nvr_sidebarposition!="")? $nvr_sidebarposition : 'two-col-left';
		if(isset( $nvr_custom['_nvr_layout'][0] ) && $nvr_custom['_nvr_layout'][0]!='default'){
			$nvr_pagelayout = $nvr_custom['_nvr_layout'][0];
		}
		
		if(isset($_GET['sidebar_layout']) && in_array($_GET['sidebar_layout'],$nvr_pagelayoutall)){
			$nvr_pagelayout = esc_html($_GET['sidebar_layout']);
		}
		return $nvr_pagelayout;
	}
}

if(!function_exists("constance_is_shop")){
	function constance_is_shop(){
		if(function_exists("is_woocommerce")){
			if(is_shop() || is_product_taxonomy()){
				return true;
			}
		}
		return false;
	}
}

if(!function_exists("constance_is_product")){
	function constance_is_product(){
		if(function_exists("is_woocommerce")){
			if(is_singular('product')){
				return true;
			}
		}
		return false;
	}
}

if(!function_exists('constance_pf_get_image')){
	function constance_pf_get_image($nvr_imgsize, $nvr_postid=""){
	
		global $post;
		
		if($nvr_postid==""){
			$nvr_postid = get_the_ID();
		}
	
		$nvr_custom = get_post_custom( $nvr_postid );
		$nvr_cf_thumb = (isset($nvr_custom["custom_thumb"][0]))? $nvr_custom["custom_thumb"][0] : "";
		$nvr_cf_externallink = (isset($nvr_custom["external_link"][0]))? $nvr_custom["external_link"][0] : "";
		$nvr_cf_imagegallery	= (isset($nvr_custom["nvr_imagesgallery"][0]))? $nvr_custom["nvr_imagesgallery"][0] : "";
		
		if(isset($nvr_custom["lightbox_img"])){
			$nvr_checklightbox = $nvr_custom["lightbox_img"] ; 
			$nvr_cf_lightbox = array();
			for($i=0;$i<count($nvr_checklightbox);$i++){
				if($nvr_checklightbox[$i]){
					$nvr_cf_lightbox[] = $nvr_checklightbox[$i];
				}
			}
			if(!count($nvr_cf_lightbox)){
				$nvr_cf_lightbox = "";
			}
		}else{
			$nvr_cf_lightbox = "";
		}
		
		if($nvr_cf_imagegallery!=''){
			$nvr_attachments = $nvr_cf_imagegallery;
			$nvr_attachmentids = explode(",",$nvr_attachments);
			$nvr_qryposts = array(
				'include' => $nvr_attachmentids,
				'post_status' => 'any',
				'post_type' => 'attachment'
			);
			
			$nvr_attachments = get_posts( $nvr_qryposts );
		}else{
			$nvr_qrychildren = array(
				'post_parent' => $nvr_postid ,
				'post_status' => null,
				'post_type' => 'attachment',
				'order_by' => 'menu_order',
				'order' => 'ASC',
				'post_mime_type' => 'image'
			);
		
			$nvr_attachments = get_children( $nvr_qrychildren );
		}
		
		$nvr_cf_thumb2 = array();
		$nvr_cf_full2 = "";
		$z = 1;
		foreach ( $nvr_attachments as $nvr_att_id => $nvr_attachment ) {
			$nvr_att_id = $nvr_attachment->ID;
			$nvr_getimage = wp_get_attachment_image_src($nvr_att_id, $nvr_imgsize, true);
			$nvr_portfolioimage = $nvr_getimage[0];
			$nvr_alttext = get_post_meta( $nvr_attachment->ID , '_wp_attachment_image_alt', true);
			$nvr_image_title = $nvr_attachment->post_title;
			$nvr_caption = $nvr_attachment->post_excerpt;
			$nvr_description = $nvr_attachment->post_content;
			$nvr_cf_thumb2[] ='<img src="'.esc_url( $nvr_portfolioimage ).'" alt="'.esc_attr( $nvr_alttext ).'" title="'. esc_attr( $nvr_image_title ) .'" class="scale-with-grid" />';
			
			$nvr_getfullimage = wp_get_attachment_image_src($nvr_att_id, 'full', true);
			$nvr_fullimage = $nvr_getfullimage[0];
			
			if($z==1){
				$nvr_fullimageurl = $nvr_fullimage;
				$nvr_fullimagetitle = $nvr_image_title;
				$nvr_fullimagealt = $nvr_alttext;
			}elseif($nvr_att_id == get_post_thumbnail_id( $nvr_postid ) ){
				$nvr_cf_full2 ='<a data-rel="prettyPhoto['.esc_attr( $post->post_name ).']" href="'.esc_url( $nvr_fullimageurl ).'" title="'. esc_attr( $nvr_fullimagetitle ) .'" class="hidden"></a>'.$nvr_cf_full2;
				$nvr_fullimageurl = $nvr_fullimage;
				$nvr_fullimagetitle = $nvr_image_title;
				$nvr_fullimagealt = $nvr_alttext;
			}else{
				$nvr_cf_full2 .='<a data-rel="prettyPhoto['.esc_attr( $post->post_name ).']" href="'.esc_url( $nvr_fullimage ).'" title="'. esc_attr( $nvr_image_title ) .'" class="hidden"></a>';
			}
			$z++;
		}
		
		if($nvr_cf_thumb!=""){
			$nvr_cf_thumb = '<img src="' . esc_url( $nvr_cf_thumb ) . '" alt="'. esc_attr( get_the_title($nvr_postid) ) .'"  class="scale-with-grid" />';
		}elseif( has_post_thumbnail( $nvr_postid ) ){
			$nvr_cf_thumb = get_the_post_thumbnail($nvr_postid, $nvr_imgsize, array('class' => 'scale-with-grid'));
		}elseif( isset( $nvr_cf_thumb2[0] ) ){
			$nvr_cf_thumb = $nvr_cf_thumb2[0];
		}else{
			$nvr_cf_thumb = '<span class="nvr-noimage"></span>';
		}
		
		
		if($nvr_cf_externallink!=""){
			$nvr_golink = $nvr_cf_externallink;
			$nvr_rollover = "gotolink";
			$nvr_atext = esc_html__('More',"constance");
			$nvr_cf_full2 = '';
		}else{
			$nvr_golink = get_permalink();
			$nvr_rollover = "gotopost";
			$nvr_atext = esc_html__('More',"constance");
		}
		
		$nvr_bigimageurl = $nvr_bigimagetitle = $nvr_rel = '';
		if( is_array($nvr_cf_lightbox) ){
			$nvr_bigimageurl = $nvr_cf_lightbox[0];
			$nvr_bigimagetitle = get_the_title();
			$nvr_rel = ' data-rel="prettyPhoto['. esc_attr( $post->post_name ).']"';
			$nvr_cf_lightboxoutput = '';
			for($i=1;$i<count($nvr_cf_lightbox);$i++){
				$nvr_cf_lightboxoutput .='<a data-rel="prettyPhoto['.esc_attr( $post->post_name ).']" href="'.esc_url( $nvr_cf_lightbox[$i] ).'" title="'. esc_attr( get_the_title($nvr_postid) ) .'" class="hidden"></a>';
			}
			$nvr_cf_full2 = $nvr_cf_lightboxoutput;
		}else{
			if( isset($nvr_fullimageurl)){
				$nvr_bigimageurl = $nvr_fullimageurl; 
				$nvr_bigimagetitle = $nvr_fullimagetitle;
				$nvr_rel = ' data-rel="prettyPhoto['.esc_attr( $post->post_name ).']"';
			}
		}
		
		$nvr_return = array(
			'nvr_bigimageurl' 	=> $nvr_bigimageurl,
			'nvr_bigimagetitle'	=> $nvr_bigimagetitle,
			'nvr_rel'			=> $nvr_rel,
			'nvr_cf_full2'		=> $nvr_cf_full2,
			'nvr_golink'		=> $nvr_golink,
			'nvr_rollover'		=> $nvr_rollover,
			'nvr_atext'			=> $nvr_atext,
			'nvr_cf_thumb'		=> $nvr_cf_thumb
		);
		return $nvr_return;
	}
}

if(!function_exists("constance_pf_get_box")){
	function constance_pf_get_box( $nvr_imgsize, $nvr_postid="",$nvr_class="", $nvr_limitchar = 250 ){
	
		$nvr_output = "";
		global $post;
		
		if($nvr_postid==""){
			$nvr_postid = get_the_ID();
		}
		$nvr_taxonomy_slug = 'portfoliocat';
		
		$nvr_get_image = constance_pf_get_image($nvr_imgsize, $nvr_postid );
		extract($nvr_get_image);
		
		$nvr_output  .='<li class="'.esc_attr( $nvr_class ).'">';
			$nvr_output  .='<div class="nvr-pf-box">';
				$nvr_output  .='<div class="nvr-pf-img">';
					
					$nvr_output .='<a class="image '.esc_attr( $nvr_rollover ).'" href="'.esc_url( $nvr_golink ).'" title="'.esc_attr( get_the_title($nvr_postid) ).'"></a>';
					if($nvr_bigimageurl!=''){
						$nvr_output .='<a class="image zoom" href="'. esc_url( $nvr_bigimageurl ) .'" '.$nvr_rel.' title="'.esc_attr( $nvr_bigimagetitle ).'"></a>';
					}
					
					$nvr_output  .=$nvr_cf_thumb;
					$nvr_output  .=$nvr_cf_full2;
				$nvr_output  .='</div>';
		
				$nvr_excerpt = nvr_string_limit_char( get_the_excerpt(), $nvr_limitchar );
				$nvr_output  .='<div class="nvr-pf-text">';
				
					$nvr_output  .='<h2 class="nvr-pf-title"><a href="'.esc_url( get_permalink($nvr_postid) ).'" title="'.esc_attr( get_the_title($nvr_postid) ).'">'.get_the_title($nvr_postid).'</a></h2>';
					 // get the terms related to post
					$nvr_terms = get_the_terms( $nvr_postid, $nvr_taxonomy_slug );
					$nvr_termarr = array();
					if ( !empty( $nvr_terms ) ) {
					  foreach ( $nvr_terms as $nvr_term ) {
						$nvr_termarr[] = '<a href="'. esc_url( get_term_link( $nvr_term->slug, $nvr_taxonomy_slug ) ).'">'. $nvr_term->name ."</a>";
					  }
					  
					  $nvr_output .= '<div class="nvr-pf-cat">'.implode(", ", $nvr_termarr).'</div>';
					}
					$nvr_output .= '<div class="nvr-pf-separator"></div>';
					$nvr_output .= '<div class="nvr-pf-content">'.$nvr_excerpt.'</div>';
					
				$nvr_output  .='</div>';
				$nvr_output  .='<div class="nvr-pf-clear"></div>';
			$nvr_output  .='</div>';
		$nvr_output  .='</li>';
		
		return $nvr_output; 
	}
}

if( !function_exists('constance_section_builder') ){
	function constance_section_builder($nvr_sectionbuilders){

		if(isset($nvr_sectionbuilders) && is_array($nvr_sectionbuilders) && count($nvr_sectionbuilders)>0){ 
			$i = 1;
			foreach($nvr_sectionbuilders as $nvr_sectionbuilder){ 
				
				$nvr_sectionbgcolor = (isset($nvr_sectionbuilder['backgroundcolor']))? $nvr_sectionbuilder['backgroundcolor'] : '';
				$nvr_sectionbgimage = (isset($nvr_sectionbuilder['backgroundimage']))? $nvr_sectionbuilder['backgroundimage'] : '';
				$nvr_sectionclass   = (isset($nvr_sectionbuilder['customclass']))? $nvr_sectionbuilder['customclass'] : '';
				$nvr_sectioncontent = (isset($nvr_sectionbuilder['content']))? $nvr_sectionbuilder['content'] : '';
				
				if($nvr_sectioncontent==''){ continue; }
				
				$nvr_sectionstyle = '';
				if($nvr_sectionbgcolor!='' || $nvr_sectionbgimage!=''){
						if($nvr_sectionbgcolor!=''){
							$nvr_sectionstyle .= 'background-color:'.$nvr_sectionbgcolor.'; ';
						}
						if($nvr_sectionbgimage!=''){
							$nvr_sectionstyle .= 'background-image:url('.esc_url( $nvr_sectionbgimage ).'); ';
						}
						$nvr_sectionstyle .= 'background-repeat:no-repeat';
						$nvr_sectionstyle .= 'background-position:center';
					$nvr_sectionstyle = esc_attr( $nvr_sectionstyle );
				}
			?>
				<section id="outersection_<?php echo esc_attr( $i ); ?>" class="outersection <?php echo esc_attr( $nvr_sectionclass ); ?>" style="<?php echo esc_attr( $nvr_sectionstyle ); ?>">
					<div class="container">
						<section id="innersection_<?php echo esc_attr( $i ); ?>" class="row innersection">
							<div class="sectioncontent twelve columns">
								<?php echo do_shortcode($nvr_sectioncontent); ?>
								<div class="clearfix"></div>
							</div>
							<div class="clearfix"></div>
						</section>
					</div>
				</section>
			<?php 
				$i++;
			}//end foreach 
		}
	}
}

/*Template for comments and pingbacks. */
if ( ! function_exists( 'constance_comment' ) ) :
function constance_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="con-comment">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 65 ); ?>
		</div><!-- .comment-author .vcard -->


		<div class="comment-body">
			<?php  printf( __( '<cite class="fn">%s</cite>', "constance" ), sprintf( '%s Says:', get_comment_author_link() ) ); ?>
            <span class="time">
            <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
            <?php
                /* translators: 1: date, 2: time */
                printf( esc_html__( '%1$s %2$s', "constance" ), get_comment_date(),  get_comment_time() ); ?></a>
                <?php edit_comment_link( esc_html__( '(Edit)', "constance" ), ' ' );?>
            </span>
            
            <div class="clear"></div>
			<div class="commenttext">
			<?php comment_text(); ?>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php esc_html_e( 'Your comment is awaiting moderation.', "constance" ); ?></em>
			<?php endif; ?>
			</div>
            <span class="reply"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ,'reply_text' => esc_html__('Reply', "constance") ) ) ); ?></span>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div><!-- #comment-##  -->
    
	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
			echo '<li class="post pingback">';
				echo '<p>'. esc_html__( 'Pingback:', "constance" ).' ';
					comment_author_link();
					edit_comment_link( esc_html__('(Edit)', "constance"), ' ' );
				echo '</p>';
				
			break;
	endswitch;
}
endif;

if ( ! function_exists( 'constance_share_button_output' ) ) :

function constance_share_button_output() {
	if(function_exists('ssba_buttons')){
	echo '<div class="sharebutton-container">';
		echo do_shortcode('[ssba]');
	echo '</div>';
	}
}
add_action('constance_share_button','constance_share_button_output',1);
endif;

/*********QUICK VIEW PRODUCT**********/
add_action("wp_ajax_constance_quickviewproduct", "constance_quickviewproduct");
add_action("wp_ajax_nopriv_constance_quickviewproduct", "constance_quickviewproduct");
function constance_quickviewproduct(){
	
	if( !wp_verify_nonce( $_REQUEST['nonce'], "constance_quickviewproduct_nonce")) {
    	exit("No naughty business please");
	}
	
	$nvr_productid = (isset($_REQUEST["post_id"]) && $_REQUEST["post_id"]>0)? $_REQUEST["post_id"] : 0;
	
	$nvr_query_args = array(
		'post_type'	=> 'product',
		'p'			=> $nvr_productid
	);
	$nvr_outputraw = $nvr_output = '';
	$nvr_productquery = new WP_Query($nvr_query_args);
	if($nvr_productquery->have_posts()){ 

		while ($nvr_productquery->have_posts()){ $nvr_productquery->the_post(); setup_postdata($nvr_productquery->post);
			global $product;
			ob_start();
			woocommerce_get_template_part( 'content', 'quickview-product' );
			$nvr_outputraw = ob_get_contents();
			ob_end_clean();
		}
	}// end if ($nvr_productquery->have_posts())
	wp_reset_postdata();
	
	echo preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $nvr_outputraw);
	
	
	die();
}

/*********LOGIN FORM**********/
if(!function_exists('constance_login_form')){
	function constance_login_form() {
		 // get user dashboard link
		global $wpdb;
		$redirect='';
		$mess='';
	
		  $post_id=get_the_ID();
		  
		$nvr_nonce = wp_create_nonce("constance_login_nonce");
		$return_string=' 
			<div class="login_form" id="login-div">
				<div class="loginalert" id="login_message_area" >'.$mess.'</div>
			
				<p><label for="login_user">'. esc_html__('Username', "constance" ).'</label><input type="text" class="textbox" name="login_user" id="login_user" value="" size="20" /></p>
				<p><label for="login_pwd">'.esc_html__('Password', "constance" ).'</label><input type="password" class="textbox" name="login_pwd" id="login_pwd" size="20" /></p>
		';
			$return_string .= '<input type="hidden" name="loginpop" id="loginpop" value="0">';
			$return_string .= '<input type="hidden" name="security-login" id="security-login" value="'.esc_attr( $nvr_nonce ).'">';
			$return_string .= '<input type="submit" value="'.esc_attr__('Login', "constance" ).'" id="wp-login-but" name="submit" class="button">';
		$return_string .= '<div class="login-links">';
			
				$return_string.='<a href="'. wp_lostpassword_url() .'" id="forgot_pass">'.esc_html__('forgot password?', "constance" ).'</a>
				</div>
			</div>
		';
	
			
		$nvr_nonce = wp_create_nonce("constance_forgot_nonce");
		$return_string.='                 
			<div class="login_form" id="forgot-pass-div">
				<div class="loginalert" id="forgot_pass_area" ></div>
				<p><label for="forgot_email">'.esc_html__('Enter Your Email Address', "constance" ).'</label><input type="text" class="textbox" name="forgot_email" id="forgot_email" value="" size="20" /></p>
		';
			$return_string .='<input type="hidden" id="security-forgot" name="security-forgot" value="'.esc_attr( $nvr_nonce ).'">';
			$return_string .='<input type="hidden" id="postid" value="'.esc_attr( $post_id ).'">';
			$return_string .='<input type="submit" value="'.esc_attr__('Reset Password', "constance" ).'" id="wp-forgot-but" name="forgot" class="button">';   
				$return_string .='<div class="login-links"><a href="#" id="return_login">'.esc_html__('return to login', "constance" ).'</a></div>
			</div>
		';
		return  $return_string;
	}
}

add_action( 'wp_ajax_nopriv_constance_ajax_login', 'constance_ajax_login' );  
add_action( 'wp_ajax_constance_ajax_login', 'constance_ajax_login' );  
   
function constance_ajax_login(){
     
	if( !wp_verify_nonce( $_REQUEST['security-login'], "constance_login_nonce")) {
		exit("No naughty business please");
	}
	
	$login_user  =  esc_html ( $_POST['login_user'] ) ;
	$login_pwd   =  esc_html ( $_POST['login_pwd'] ) ;
	$ispop       =  intval($_POST['ispop']);
   
	if ($login_user=='' || $login_pwd==''){      
	  echo json_encode(array('loggedin'=>false, 'message'=> esc_html__('Username and/or Password field is empty!', "constance" )));   
	  exit();
	}
	$redirectlink			= constance_get_option( 'constance_accountlink');
	if($redirectlink==''){
		$redirectlink = esc_url( home_url( '/' ) );
	}else{
		$redirectlink = esc_url( $redirectlink );
	}
	
	$info                   = array();
	$info['user_login']     = $login_user;
	$info['user_password']  = $login_pwd;
	$info['remember']       = true;
	$user_signon            = wp_signon( $info, false );
  

	 if ( is_wp_error($user_signon) ){
		 echo json_encode(array('loggedin'=>false, 'message'=> esc_html__('Wrong username or password!', "constance" )));       
	} else {
		 echo json_encode(array('loggedin'=>true,'redirect'=>$redirectlink,'ispop'=>$ispop,'newuser'=>$user_signon->ID, 'message'=> esc_html__('Login successful, redirecting...', "constance" )));
	}
	die(); 
              
}

/*********REGISTER FORM**********/
if(!function_exists('constance_register_form')){
	function constance_register_form() {
	 
		 $nvr_nonce = wp_create_nonce("constance_register_nonce");
		 $return_string='
			  <div class="login_form">
				   <div class="loginalert" id="register_message_area" ></div>
				   
					<p><label for="user_login_register">'.esc_html__('Username', "constance" ).'</label><input type="text" name="user_login_register" id="user_login_register" class="textbox" value="" size="20" /></p>
					<p><label for="user_email_register">'.esc_html__('Email', "constance" ).'</label><input type="text" name="user_email_register" id="user_email_register" class="textbox" value="" size="20" /></p>
					 
					<p id="reg_passmail">'.esc_html__('A password will be e-mailed to you', "constance" ).'</p>
				 
					<input type="hidden" id="security-register" name="security-register" value="'.esc_attr( $nvr_nonce ).'">
					<p class="submit"><input type="submit" name="wp-submit" id="wp-submit-register" class="button" value="'.esc_attr__('Register', "constance" ).'" /></p>
					
			</div>
						 
		';
		 return  $return_string;
	}
}

add_action( 'wp_ajax_nopriv_constance_ajax_register', 'constance_ajax_register' );  
add_action( 'wp_ajax_constance_ajax_register', 'constance_ajax_register' );

function constance_ajax_register(){
		
	if( !wp_verify_nonce( $_REQUEST['security-register'], "constance_register_nonce")) {
		exit("No naughty business please");
	}

	$user_email  =   trim( $_POST['user_email_register'] ) ;
	$user_name   =   trim( $_POST['user_login_register'] ) ;
   
	if (preg_match("/^[0-9A-Za-z_]+$/", $user_name) == 0) {
		 esc_html_e('Invalid username( *do not use special characters or spaces ) ', "constance" );
		die();
	}
	
   

	
	if ($user_email=='' || $user_name==''){
	  esc_html_e('Username and/or Email field is empty!', "constance" );
	  die();
	}
	
	if(filter_var($user_email,FILTER_VALIDATE_EMAIL) === false) {
		 esc_html_e('The email doesn\'t look right !', "constance" );
		die();
	}
	
	$domain = substr(strrchr($user_email, "@"), 1);
	if( !checkdnsrr ($domain) ){
		esc_html_e('The email\'s domain doesn\'t look right.', "constance" );
		die();
	}
	
	
	$user_id     =   username_exists( $user_name );
	if ($user_id){
		esc_html_e('Username already exists.  Please choose a new one.', "constance" );
		die();
	 }
	
	 
	 
	 
	if ( !$user_id and email_exists($user_email) == false ) {
		$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
   
		$user_id  = wp_create_user( $user_name, $random_password, $user_email );
	 
		 if ( is_wp_error($user_id) ){
				print_r($user_id);
		 }else{ 
		 	
			//emailing password change request details to the user
			$headers = 'From: No Reply <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
			$thewebsite = get_option('siteurl');
			$message = '';
			$message .= $thewebsite . "\r\n\r\n";
			$message .= sprintf( esc_html__('Username: %s',"constance"), $user_name) . "\r\n\r\n";
			$message .= sprintf( esc_html__('Password: %s', "constance"), $random_password ) . "\r\n\r\n";
			if ( $message && !wp_mail($user_email, sprintf( esc_html__('User Registration at %s',"constance"), $thewebsite ), $message,  $headers) ) {
				echo "<div class='error'>".esc_html__('Email failed to send for some unknown reason.',"constance")."</div>";
				exit();
			}else{
				esc_html_e('An email with the generated password was sent!', "constance" );
			}
		 }
		 
	} else {
	   esc_html_e('Email already exists.  Please choose a new one.', "constance" );
	}


	die(); 
              
}

function constance_ajax_forgot_pass(){
    global $wpdb;
   
    //    check_ajax_referer( 'login_ajax_nonce', 'security-forgot' );
        $post_id        =   ( $_POST['postid'] ) ;
        $forgot_email   =   ( $_POST['forgot_email'] ) ;
 
       
        if ($forgot_email==''){      
          echo esc_html_e('Email field is empty!',"constance");   
          exit();
        }
       
        

        //We shall SQL escape the input
        $user_input = trim($forgot_email);
 
        if ( strpos($user_input, '@') ) {
                $user_data = get_user_by( 'email', $user_input );
                if(empty($user_data) || isset( $user_data->caps['administrator'] ) ) {
                    esc_html_e('Invalid E-mail address!',"constance");
                    exit();
                }
                            
        }
        else {
            $user_data = get_user_by( 'login', $user_input );
            if( empty($user_data) || isset( $user_data->caps['administrator'] ) ) {
               esc_html_e('Invalid Username!', "constance");
               exit();
            }
        }
        	$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;

 
        $key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
        if(empty($key)) {
                //generate reset key
                $key = wp_generate_password(20, false);
                $wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
        }
 
        //emailing password change request details to the user
        $headers = 'From: No Reply <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
        $message = esc_html__('Someone requested that the password be reset for the following account:',"constance") . "\r\n\r\n";
        $message .= get_option('siteurl') . "\r\n\r\n";
        $message .= sprintf( esc_html__('Username: %s',"constance"), $user_login) . "\r\n\r\n";
        $message .= esc_html__('If this was a mistake, just ignore this email and nothing will happen.',"constance") . "\r\n\r\n";
        $message .= esc_html__('To reset your password, visit the following address:',"constance") . "\r\n\r\n";
        $message .= tg_validate_url($post_id) . "action=reset_pwd&key=$key&login=" . rawurlencode($user_login) . "\r\n";
        if ( $message && !wp_mail($user_email, esc_html__('Password Reset Request',"constance"), $message,  $headers) ) {
                echo "<div class='error'>".esc_html__('Email failed to send for some unknown reason.',"constance")."</div>";
                exit();
        }
        else {
            echo '<div>'.esc_html__('We have just sent you an email with Password reset instructions.',"constance").'</div>';
        }
        die(); 
              
}
<?php
function constance_form_admin($nvr_optionstheme, $nvr_theslug) {
	constance_saveform_admin($nvr_optionstheme, $nvr_theslug);
	
	if ( isset($_REQUEST['saved']) && $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'. esc_html__('Settings saved.', "constance") .'</strong></p></div>';
	    
?>
	<style type="text/css">
	#optionsframework{
		max-width: 780px;
	}
	#optionsframework-submit {
		padding: 7px 10px;
		border-top: 1px solid #ECECEC;
		background-color: #F1F1F1;
		background-image: -moz-linear-gradient(center top , #F9F9F9, #ECECEC);
	}
	#optionsframework .button-primary {
		float:right;
	}
	table {width:100%;}
	table, td {font-size:13px; border:0px; }
	th {font-weight:normal; width:250px; border:0px;}
	.rowfield{padding:10px;}
	span.setting-description { font-size:11px; line-height:16px; font-style:italic;}
	.imguploader{
		position:relative;
		float:left;
	}
	.imguploader img{
		padding:3px;
		border:1px solid #f5f5f5;
	}
	a.delimguploader{
		background-image:url(<?php echo esc_url( CONSTANCE_FRAMEWORKURI );  ?>admin/images/ico-delete.png);
		background-repeat:no-repeat;
		position:absolute;
		bottom:-2px;
		right:-2px;
		width:16px;
		height:16px;
		display:none;
		z-index:7;
		cursor:pointer;
	}
	.tab_container .of-radio-img-img {
		border:3px solid #f9f9f9;
		margin:0 5px 10px 0;
		display:block;
		cursor:pointer;
		float:left;
	}
	.tab_container .of-radio-img-radio{
		display:none;
	}
	.tab_container .of-radio-img-label{
		display:none;
	}
	.tab_container .of-radio-img-selected {
		border:3px solid #ccc
	}
	.tab_container .of-radio-img-img:hover {
		opacity:.8;
	}
	/************For Text Array Type********/
	div.delcage{
		margin-top:8px;
		width:100%;
	}
	a.delbutton{
		display:block;
		background-image:url(<?php echo esc_url( CONSTANCE_FRAMEWORKURI );  ?>admin/images/delbutton.gif);
		background-repeat:no-repeat;
		background-position:right;
		padding:4px 22px 4px 4px;
		background-color:#ffffff;
		border-top:1px solid #f7f7f7;
		border-left:1px solid #f7f7f7;
		border-right:1px solid #f0f0f0;
		border-bottom:1px solid #f0f0f0;
		float:left;
		text-decoration:none;
		margin-right:8px;
		margin-bottom:5px;
	}
	a.delbutton:hover{
		background-color:#fafafa;
	}
	/************End For Text Array Type********/
	</style>
	
	<link rel="stylesheet" media="screen" type="text/css" href="<?php echo esc_url( CONSTANCE_FRAMEWORKURI ); ?>admin/css/colorpicker.css" />
	<script type="text/javascript" src="<?php echo esc_url( CONSTANCE_FRAMEWORKURI );  ?>admin/js/colorpicker.js"></script>
	<script type="text/javascript" src="<?php echo esc_url( CONSTANCE_FRAMEWORKURI );  ?>admin/js/eye.js"></script>
	<script type="text/javascript" src="<?php echo esc_url( CONSTANCE_FRAMEWORKURI ); ?>admin/js/utils.js"></script>
	<link rel="stylesheet" media="screen" type="text/css" href="<?php echo esc_url( CONSTANCE_FRAMEWORKURI );  ?>admin/css/tabs.css" />
	<!-- Javascript for the tabs -->
	<script type="text/javascript">
	jQuery(document).ready(function(){
			
			/* For Tab */
			jQuery(".tab_content").hide(); //Hide all content
			jQuery("ul.tabs li:first").addClass("active").show(); //Activate first tab
			jQuery(".tab_content:first").show(); //Show first tab content
			//On Click Event
			jQuery("ul.tabs li").click(function() {
				jQuery("ul.tabs li").removeClass("active"); //Remove any "active" class
				jQuery(this).addClass("active"); //Add "active" class to selected tab
				jQuery(".tab_content").hide(); //Hide all tab content
				var activeTab = jQuery(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
				jQuery(activeTab).fadeIn(900); //Fade in the active content
				return false;
			});
			
			/************For Text Array Type********/
			<?php 
			foreach ($nvr_optionstheme as $nvr_value) {
				if ($nvr_value['type'] == "textarray") { 
			?>
			jQuery("input#buttonarray<?php echo esc_js( $nvr_value['id'] ); ?>").click(function(evt){
				
				evt.preventDefault();
				
				<?php 
					$nvr_url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; 
				?>
				var textarrayname = jQuery('input#<?php echo esc_js( $nvr_value['id'] ); ?>').val();
				var textarrayid = jQuery.trim(textarrayname).toLowerCase().replace(" ","-");
				if(textarrayid!=""){
					jQuery.ajax({
						type : "POST",
						url : '<?php echo esc_js( $nvr_url ); ?>',
						data : "action=savearray&textarrayid=<?php echo esc_js( $nvr_value['id'] ); ?>&arrayid="+textarrayid+"&<?php echo esc_js( $nvr_value['id'] ); ?>="+textarrayname,
						success : function(data){
							var arraycage = 'div#<?php echo esc_js( $nvr_value['id']."-cage" ); ?>';
							var anchorarray = '<a href="'+textarrayid+'" rel="<?php echo esc_js( $nvr_value['id'] ); ?>" id="'+textarrayid+'" class="delbutton">'+textarrayname+'</a>';
							jQuery(arraycage).append(anchorarray);
							jQuery(arraycage + ' a.delbutton').click(delbuttononclick);
							jQuery('input#<?php echo esc_js( $nvr_value['id'] ); ?>').val('');
						}
					});
				}else{
					alert('<?php esc_html_e('Please input the textbox first!',"constance"); ?>');
				}
			});
			
			<?php 
				}//end if
			} //end foreach
			?>
			jQuery("a.delbutton").click(delbuttononclick);
			
			function delbuttononclick(evt){
				evt.preventDefault();
				<?php 
					$nvr_url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; 
				?>
				if(confirm('<?php esc_html_e('Are you sure you want to delete this item?',"constance"); ?>')){
					var arrayid = jQuery(this).attr("href");
					var textarrayid = jQuery(this).attr("rel");
					var thedelbutton = jQuery(this);
					jQuery.ajax({
						type : "POST",
						url : '<?php echo esc_js( $nvr_url ); ?>',
						data : "action=deltextarray&arrayid="+arrayid+"&textarrayid="+textarrayid,
						success : function(data){
							thedelbutton.fadeOut("slow",function(){
								thedelbutton.remove();
							});
						}
					});
				}
			};
			/************End For Text Array Type********/
	});	
	
	</script>
	<div class="wrap">
	<div id="icon-themes" class="icon32"><br></div>
	<h2 class="nav-tab-wrapper">
		<?php 
			foreach ($nvr_optionstheme as $nvr_value) {
				if ($nvr_value['type'] == "open") { 
					$nvr_valueopenname = strtolower(str_replace(" ","-",$nvr_value['name']));
					echo '<a id="of-option-'. esc_attr( $nvr_valueopenname ) .'-tab" class="nav-tab nav-tab-active" title="'. esc_attr( $nvr_value['name'] ) .'" href="#of-option-'. esc_attr( $nvr_valueopenname ) .'">';
					echo esc_html( $nvr_value['name'] );
					echo '</a>';
				}
			}
		?>
    </h2>
	<div class="bordertitle"></div>
		<div class="metabox-holder">
        	<div id="optionsframework" class="postbox">
		<form method="post">
		<div class="tab_container">
		<?php 
			foreach ($nvr_optionstheme as $nvr_value) {
			if ($nvr_value['type'] == "open") { 
				$nvr_valueopenname = strtolower(str_replace(" ","-",$nvr_value['name']));
		?>
		 
		 <div id="<?php echo esc_attr( $nvr_valueopenname ); ?>" class="tab_content" >
		<table  border="0" cellpadding="0" cellspacing="0" style="text-align:left" >
		<?php
				}
				if ($nvr_value['type'] == "close") { 
		?>
		</table></div>
		<?php
				}
				if ($nvr_value['type'] == "heading") { 
		?>
		<thead>
		<tr>
        	<td colspan="2"><h3><?php esc_html_e('Sidebar', "constance"); ?></h3><span class="setting-description"> </span></td>
        </tr>
		</thead>
		<?php
				}
				if ($nvr_value['type'] == "textarray") { 
		?>
		<tr valign="top"> 
		    <th scope="row" class="rowfield"><?php esc_html_e('Sidebar Generator', "constance"); ?>:</th>
		    <td class="rowfield">
		        <input name="<?php echo esc_attr( $nvr_value['id'] ); ?>" size="60" id="<?php echo esc_attr( $nvr_value['id'] ); ?>" type="text" value="" /> 
                <input name="buttonarray<?php echo esc_attr( $nvr_value['id'] ); ?>" id="buttonarray<?php echo esc_attr( $nvr_value['id'] ); ?>" type="button" class="button-primary" value="<?php esc_attr_e("Add", "constance"); ?>" /><br />
                <span class="setting-description"><?php esc_html_e('Please enter name of new sidebar', "constance"); ?></span><br />
 				<div id="<?php echo esc_attr( $nvr_value['id'] ); ?>-cage" class="delcage">
               	<?php 
					$nvr_textarrayval = get_option($nvr_value['id']);
					if(is_array($nvr_textarrayval)){
						foreach($nvr_textarrayval as $nvr_ids => $nvr_val){
							echo '<a href="'.esc_url( $nvr_ids ).'" rel="'.esc_attr( $nvr_value['id'] ).'" id="'.esc_attr( $nvr_ids ).'" class="delbutton">'.$nvr_val.'</a>';
						}
					}
				?>
                <div class="clear"></div>
                </div>
		    </td>
		</tr>
		<?php
				}
			}
		?>
		</table>
	</div>
	
	<div id="optionsframework-submit">
    <input name="reset" type="submit" class="button-secondary"  value="<?php esc_attr_e('Restore Defaults', "constance"); ?>" onclick="return confirm('<?php esc_attr_e('Click OK to reset. Any theme settings will be lost!', "constance")?>');"/>
	<input name="save" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes', "constance"); ?>" /> 
	<input type="hidden" id="action" name="action" value="save" />
	</div>
	</form>
    </div>
    </div>
	
<?php
}// end nvr_form_admin

function constance_saveform_admin($nvr_optionstheme, $nvr_theslug){

	$nvr_getpage = (isset($_GET['page']))? $_GET['page'] : "";
	if ( $nvr_getpage == $nvr_theslug ) {
	  if (isset($_REQUEST['reset']) ) {
		  foreach ($nvr_optionstheme as $nvr_value) {
			update_option( $nvr_value['id'],  $nvr_value['std'] ); }
		  foreach ($nvr_optionstheme as $nvr_value) {
			if( isset( $_REQUEST[ $nvr_value['id'] ] ) ) { update_option( $nvr_value['id'], $nvr_value['std'] ); } else { delete_option( $nvr_value['id'] ); } }
		  header("Location: themes.php?page=".$nvr_theslug."&saved=true");
		  die;
	  }
	  
	  /******** For Textarray Type **********/
	  if(isset($_REQUEST['action']) && $_REQUEST['action'] == "deltextarray"){
		if(isset($_REQUEST['textarrayid'])){
			$nvr_valueid = $_REQUEST['textarrayid'];
			$nvr_textarrayval = get_option($nvr_valueid);
			if(isset($_REQUEST['arrayid'])){
				unset($nvr_textarrayval[$_REQUEST['arrayid']]);
				update_option($nvr_valueid, $nvr_textarrayval);
			}
		}
		
	  }
	  if(isset($_REQUEST['action']) && $_REQUEST['action'] == "savearray"){
		if(isset($_REQUEST['textarrayid'])){
			$nvr_valueid = $_REQUEST['textarrayid'];
			$nvr_textarrayval = get_option($nvr_valueid);
			if(isset($_REQUEST['arrayid'])){
				$nvr_textarrayid = $_REQUEST['arrayid'];
				if($nvr_textarrayid!=""){
					if(is_array($nvr_textarrayval)){
						$nvr_textarrayval[$nvr_textarrayid] = $_REQUEST[$nvr_valueid];
					}else{
						$nvr_textarrayval = array($nvr_textarrayid => $_REQUEST[$nvr_valueid]);
					}
				}
				update_option($nvr_valueid, $nvr_textarrayval);
			}
		}
		
	  }
	  /******** End of Textarray Type **********/
	  if ( isset($_REQUEST['action']) && 'save' == $_REQUEST['action'] ) { 
		  foreach ($nvr_optionstheme as $nvr_value) {
			if($nvr_value["type"]=="textarray"){
				$nvr_textarrayval = get_option($nvr_value['id']);
				if(isset( $_REQUEST[ $nvr_value['id'] ] )){
					$nvr_textarrayid = str_replace(" ","-",trim(strtolower($_REQUEST[$nvr_value['id']])));
					if($nvr_textarrayid!=""){
						if(is_array($nvr_textarrayval)){
							$nvr_textarrayval[$nvr_textarrayid] = $_REQUEST[$nvr_value['id']];
						}else{
							$nvr_textarrayval = array($nvr_textarrayid => $_REQUEST[$nvr_value['id']]);
						}
					}
					update_option($nvr_value['id'], $nvr_textarrayval);
				}
			}else{
				if(isset($nvr_value['id'])){
					update_option( $nvr_value['id'], $_REQUEST[ $nvr_value['id'] ] ); 
					
					if( isset( $_REQUEST[ $nvr_value['id'] ] ) ) { 
						update_option( $nvr_value['id'], $_REQUEST[ $nvr_value['id'] ]  ); 
					} else { 
						delete_option( $nvr_value['id'] ); 
					} 
				}
			}
		  }
		  echo '<meta http-equiv="refresh" content="0;url=themes.php?page=' .$nvr_theslug. '&saved=true" />';
		  die;
		}
	}
}
?>
<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 * @subpackage Constance
 * @since Constance 1.0
 */

                $nvr_pid = constance_get_postid();
                $nvr_custom = constance_get_customdata($nvr_pid);
				
                $nvr_pagelayout = constance_get_sidebar_position($nvr_pid);
				
				if(isset( $nvr_custom['_nvr_sectionbuilder'][0] )){
                    $nvr_sectionbuilders = unserialize($nvr_custom['_nvr_sectionbuilder'][0]);
                }
				
				if(constance_is_shop() || constance_is_product()){
					$nvr_pagelayout = 'one-col';
				}
				
                if($nvr_pagelayout!='one-col'){ 
                ?>
                
                        <div class="clearfix"></div>
                    </div><!-- main -->
                </section><!-- content -->
                <aside id="sidebar" class="three columns">
                    <?php get_sidebar();?>  
                </aside><!-- sidebar -->
                
                <?php 
                } 
                ?>
            
                <div class="clearfix"></div>
            </section><!-- maincontent -->
            </div>
        </div>
        </div>
    </div>
    <!-- END MAIN CONTENT -->
    
    <?php 
	$nvr_enableaftercontent = constance_get_option( 'constance_enable_aftercontent');
	$nvr_aftercontent = constance_get_option( 'constance_aftercontent_text');
	$nvr_aftercontent 	= (isset($nvr_custom['_nvr_aftercontent_text'][0]) && $nvr_custom['_nvr_aftercontent_text'][0]!="")? $nvr_custom['_nvr_aftercontent_text'][0] : $nvr_aftercontent;
	if($nvr_enableaftercontent && $nvr_aftercontent){ 
	?>
    <!-- AFTER CONTENT -->
    <div id="outeraftercontent">
        <div class="container">
            <section id="aftercontent" class="row">
                <div class="twelve columns">
                    <?php echo do_shortcode($nvr_aftercontent); ?>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </section>
        </div>
    </div>
    <!-- END AFTER CONTENT -->
    <?php }// end if($nvr_aftercontent!="") ?>
    
    </div>
    <!-- END MIDDLE -->

<?php
$nvr_footcol_scheme = array(
	'0;none',
	'1;twelve columns',
	'2;three columns alpha-nine columns last',
	'2;six columns alpha-six columns last',
	'2;nine columns alpha-three columns last',
	'3;three columns alpha-six columns-three columns last',
	'3;three columns alpha-three columns-six columns last',
	'3;six columns alpha-three columns-three columns last',
	'3;four columns alpha-four columns-four columns last',
	'4;three columns alpha-three columns-three columns-three columns last'
);

$nvr_opt_footerLayout = intval(constance_get_option('constance_footer_sidebar_layout',8));

$nvr_disablefootersidebar = constance_get_option('constance_disable_footer_sidebar');

$nvr_custom = constance_get_customdata($nvr_pid);
$nvr_cf_footerLayout	= (isset($nvr_custom["layout_footer"][0]) && (intval($nvr_custom["layout_footer"][0])>=0 && intval($nvr_custom["layout_footer"][0])<=8) )? intval($nvr_custom["layout_footer"][0]) : $nvr_opt_footerLayout; 

$nvr_footcol = explode(';',$nvr_footcol_scheme[$nvr_cf_footerLayout]);
$nvr_footclass = explode('-',$nvr_footcol[1]);
?>
	<div id="footerwrapper">
<?php
if(!$nvr_disablefootersidebar){
?>			
        <!-- FOOTER SIDEBAR -->
        <div id="outerfootersidebar">
        	<div class="container">
                <div id="footersidebarcontainer" class="row"> 
                    <footer id="footersidebar">
                    <?php for($i=0;$i<$nvr_footcol[0];$i++){ $nvr_numfootcol = $i+1; ?>
                    
                    <div id="footcol<?php echo esc_attr( $nvr_numfootcol ); ?>"  class="<?php echo esc_attr( $nvr_footclass[$i] ); ?>">
                        <div class="widget-area">
                        	<div class="widget-bottom">
                                <ul>
                                	<?php if ( ! dynamic_sidebar( 'footer'.$nvr_numfootcol ) ) : ?><?php endif; // end general widget area ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <?php } ?>
                        <div class="clearfix"></div>
                    </footer>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- END FOOTER SIDEBAR -->
<?php
}
?>
        <!-- FOOTER -->
        <div id="outerfooter">
        	<div class="container">
                <div id="footercontainer" class="row">
                    <footer id="footer" class="twelve columns">
                        <div class="copyrightcontainer">
                            <?php 
							/***** file: engine/footer-functions.php
							- constance_output_footertext - 5
							- constance_output_footertext2 - 10
							*****/
							do_action('constance_output_footerarea');
							?>
                            <div class="clearfix"></div>
                        </div>
                    </footer>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- END FOOTER -->
	</div>
        
	</div><!-- end bodychild -->
</div><!-- end outercontainer -->
<?php 
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>

<div id="outerheaderwrapper">
    <div id="outerheader">
        <div class="topcontainer container">
            <div class="row">
                <div class="logo columns">
                    <?php constance_logo(); // print the logo html ?>
                    <div class="clearfix"></div>
                </div>
                <div class="navcontainer columns">
					<div class="searchandcart">
                    	<a href="#" id="togglesidemenu"><span><?php esc_html_e('Menu', 'constance'); ?></span><i class="fa fa-bars"></i></a>
						<?php
                        constance_output_minicart(); /* file: engine/header-functions.php */
                        constance_output_feloginregister(); /* file: engine/header-functions.php */
                        ?>
                    </div>
                    <?php
					constance_primary_menu(); /* file: engine/header-functions.php */            
                    ?>
                	<div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
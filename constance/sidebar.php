<?php
/**
 * The Sidebar containing the post widget areas.
 *
 * @package WordPress
 * @subpackage Constance
 * @since Constance 1.0
 */

global $post;

$nvr_pid = constance_get_postid();
$nvr_custom = constance_get_customdata($nvr_pid);

$nvr_defaultsidebar = "constance-sidebar";
$nvr_chosensidebar = (isset($nvr_custom['_nvr_sidebar'][0]) && !is_search())? $nvr_custom['_nvr_sidebar'][0] : $nvr_defaultsidebar;
?>
<div class="widget-area">
	<ul>
	<?php if ( ! dynamic_sidebar( $nvr_chosensidebar ) ) : ?><?php endif; // end general widget area ?>
    </ul>
</div>
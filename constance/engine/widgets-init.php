<?php
/**
 * Loads up all the widgets defined by this theme. Note that this function will not work for versions of WordPress 2.7 or lower
 *
 */

/******************from framework******************/
include_once (CONSTANCE_WIDGETPATH . 'nvr-recent-comment.php');
include_once (CONSTANCE_WIDGETPATH . 'nvr-recent-posts.php');
include_once (CONSTANCE_WIDGETPATH . 'nvr-woo-product-sort.php');
include_once (CONSTANCE_WIDGETPATH . 'nvr-woo-price-range.php');

add_action("widgets_init", "load_framework_widgets");

function load_framework_widgets() {
	register_widget("Constance_RecentCommentWidget");
	register_widget("Constance_RecentPostWidget");
	register_widget("Constance_WooProductSortingWidget");
	register_widget("Constance_WooPriceRangeWidget");
}

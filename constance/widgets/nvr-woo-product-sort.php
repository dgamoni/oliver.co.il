<?php
// =============================== Novaro Woocommerce Product Sorting widget ======================================
class Constance_WooProductSortingWidget extends WP_Widget {
    /** constructor */

	function __construct() {
		$widget_ops = array('classname' => 'widget_constance_woo_product_sorting', 'description' => esc_html__('Constance - Product Sorting', "constance") );
		parent::__construct('constance-product-sorting', esc_html__('Constance - Product Sorting', "constance"), $widget_ops);
	}


  /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
		if(!is_woocommerce()){return;}
		$current_term = is_tax() ? get_queried_object()->term_id : '';
		$current_tax  = is_tax() ? get_queried_object()->taxonomy : '';
        $title = apply_filters('widget_title', empty($instance['title']) ? esc_html__('Product Sorting', "constance") : $instance['title']);
		global $_chosen_attributes;
		$catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
			'menu_order' => __( 'Default sorting', 'woocommerce' ),
			'popularity' => __( 'Sort by popularity', 'woocommerce' ),
			'rating'     => __( 'Sort by average rating', 'woocommerce' ),
			'date'       => __( 'Sort by newness', 'woocommerce' ),
			'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
			'price-desc' => __( 'Sort by price: high to low', 'woocommerce' )
		) );
		
        ?>
              <?php echo wp_kses_post( $before_widget ); ?>
                  <?php if ( $title )
                        echo wp_kses_post( $before_title . esc_html( $title ) . $after_title ); ?>
                        		
                                <ul class="nvr-product-sorting-widget">
                                    <?php 
									foreach ( $catalog_orderby_options as $orderbyid => $orderbyname ){ 
									
									
									/*******/
									// Base Link decided by current page
									if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
										$link = home_url();
									} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id('shop') ) ) {
										$link = get_post_type_archive_link( 'product' );
									} else {
										$link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
									}
				
									// All current filters
									if ( $_chosen_attributes ) {
										foreach ( $_chosen_attributes as $name => $data ) {
							
												// Exclude query arg for current term archive term
												while ( in_array( $current_term, $data['terms'] ) ) {
													$key = array_search( $current_term, $data );
													unset( $data['terms'][$key] );
												}
				
												// Remove pa_ and sanitize
												$filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
				
												if ( ! empty( $data['terms'] ) ) {
													$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
												}
				
												if ( 'or' == $data['query_type'] ) {
													$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
												}
										}
									}
				
									// Min/Max
									if ( isset( $_GET['min_price'] ) ) {
										$link = add_query_arg( 'min_price', $_GET['min_price'], $link );
									}
				
									if ( isset( $_GET['max_price'] ) ) {
										$link = add_query_arg( 'max_price', $_GET['max_price'], $link );
									}
				
									// Orderby
									if ( isset( $_GET['orderby'] ) ) {
										$link = add_query_arg( 'orderby', $_GET['orderby'], $link );
									}
			
									// Search Arg
									if ( get_search_query() ) {
										$link = add_query_arg( 's', get_search_query(), $link );
									}
				
									// Post Type Arg
									if ( isset( $_GET['post_type'] ) ) {
										$link = add_query_arg( 'post_type', $_GET['post_type'], $link );
									}
									
									// Product Sorting Arg
									$link = add_query_arg( 'orderby', $orderbyid, $link );
									/*******/
									
									
									?>
                                    <li class="product-sorting-list">
                                        <a class="product-sorting-link" href="<?php echo esc_url( $link ); ?>" rel="bookmark" title="<?php esc_attr_e('Permanent Link to', "constance");?> <?php the_title_attribute(); ?>">
                                        <?php echo esc_html($orderbyname);?>
                                        </a>
                                    </li>
                                    <?php 
									}//end for each 
									?>
                                </ul>
								
								<?php wp_reset_postdata(); ?>

								
								
              <?php echo wp_kses_post( $after_widget ); ?>
			 
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
		$instance['title'] = (isset($instance['title']))? $instance['title'] : "";
					
        $title = esc_attr($instance['title']);
        ?>
            <p><label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:', "constance"); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
        <?php 
    }

} // class  Widget
?>
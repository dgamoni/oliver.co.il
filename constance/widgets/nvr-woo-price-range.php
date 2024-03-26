<?php
// =============================== Novaro Woocommerce Price Range widget ======================================
class Constance_WooPriceRangeWidget extends WP_Widget {
    /** constructor */

	function __construct() {
		$widget_ops = array('classname' => 'widget_constance_woo_price_range', 'description' => esc_html__('Constance - Price Range', "constance") );
		parent::__construct('constance-price-range', esc_html__('Constance - Price Range', "constance"), $widget_ops);
		if(class_exists("WC_Query")){
			$nvr_wcquery = new WC_Query();
			add_filter( 'loop_shop_post_in', array( $nvr_wcquery, 'price_filter' ) );
		}
	}


  /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
		if(!is_woocommerce()){return;}
		global $_chosen_attributes, $wpdb, $wp;

		if ( ! is_post_type_archive( 'product' ) && ! function_exists('wc_price') && ! class_exists("WC_Query") && ! is_tax( get_object_taxonomies( 'product' ) ) ) {
			return;
		}
		
		$current_term = is_tax() ? get_queried_object()->term_id : '';
		$current_tax  = is_tax() ? get_queried_object()->taxonomy : '';
        $title = apply_filters('widget_title', empty($instance['title']) ? esc_html__('Price Range', "constance") : $instance['title']);
		$rangeinterval = apply_filters('widget_rangeinterval', empty($instance['rangeinterval']) ? "100" : $instance['rangeinterval']);
		
		if(!is_numeric($rangeinterval)){
			return;
		}
		
		$min = 0;
		if ( 0 === sizeof( WC()->query->layered_nav_product_ids ) ) {
			$max = ceil( $wpdb->get_var(
				$wpdb->prepare('
					SELECT max(meta_value + 0)
					FROM %1$s
					LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
					WHERE meta_key IN ("' . implode( '","', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) . '")
				', $wpdb->posts, $wpdb->postmeta, '_price' )
			) );
		} else {
			$max = ceil( $wpdb->get_var(
				$wpdb->prepare('
					SELECT max(meta_value + 0)
					FROM %1$s
					LEFT JOIN %2$s ON %1$s.ID = %2$s.post_id
					WHERE meta_key IN ("' . implode( '","', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) . '")
					AND (
						%1$s.ID IN (' . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ')
						OR (
							%1$s.post_parent IN (' . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ')
							AND %1$s.post_parent != 0
						)
					)
				', $wpdb->posts, $wpdb->postmeta
			) ) );
		}
		
		if ( $min == $max ) {
			return;
		}
		
		$price_range = array();
		
		$a = 0;
		do{
			$z = $a+$rangeinterval;
			
			if($z>$max){
				$price_range[$max] = wc_price($max);
			}else{
				$price_range[$z] = wc_price($z);
			}
			
			$a = $z;
			
		}while($a<$max);
		
        ?>
              <?php echo wp_kses_post( $before_widget ); ?>
                  <?php if ( $title )
                        echo wp_kses_post( $before_title . esc_html( $title ) . $after_title ); ?>
                        		
                                <ul class="nvr-price-range-widget">
                                    <?php 
									$minprice = 0;
									foreach ( $price_range as $orderbyid => $orderbyname ){ 
									
									
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
									
									// Min & Max Price Arg
									$link = add_query_arg( 'min_price', $minprice, $link );
									$link = add_query_arg( 'max_price', $orderbyid, $link );
									/*******/
									
									
									?>
                                    <li class="product-sorting-list">
                                        <a class="product-sorting-link" href="<?php echo esc_url( $link ); ?>" rel="bookmark" title="<?php esc_attr_e('Permanent Link to', "constance");?> <?php the_title_attribute(); ?>">
                                        <?php 
										if($orderbyid>$max){
											echo '&gt; ' . wc_price($orderbyid);
										}else{
											echo wc_price($minprice). ' &mdash; ' . wc_price($orderbyid);
										}
										
										?>
                                        </a>
                                    </li>
                                    <?php 
										$minprice = $orderbyid;
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
		$instance['rangeinterval'] = (isset($instance['rangeinterval']))? $instance['rangeinterval'] : "";
					
        $title = esc_attr($instance['title']);
		$rangeinterval = esc_attr($instance['rangeinterval']);
        ?>
            <p><label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:', "constance"); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
            
            <p><label for="<?php echo esc_attr( $this->get_field_id('rangeinterval') ); ?>"><?php esc_html_e('Range Interval:', "constance"); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('rangeinterval') ); ?>" name="<?php echo esc_attr( $this->get_field_name('rangeinterval') ); ?>" type="text" value="<?php echo esc_attr( $rangeinterval ); ?>" /></label></p>
        <?php 
    }

} // class  Widget
?>
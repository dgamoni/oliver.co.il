<?php
// =============================== Novaro Lattest Posts widget ======================================
class Constance_RecentPostWidget extends WP_Widget {
    /** constructor */

	function __construct() {
		$widget_ops = array('classname' => 'widget_constance_lattest_posts', 'description' => esc_html__('Constance - Latest Posts', "constance") );
		parent::__construct('constance-lattest-posts', esc_html__('Constance - Latest Posts', "constance"), $widget_ops);
	}


  /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', empty($instance['title']) ? esc_html__('Latest Posts', "constance") : $instance['title']);
		$category = apply_filters('widget_category', $instance['category']);
		$showpost = apply_filters('widget_showpost', $instance['showpost']);
		$disablethumb = apply_filters('widget_disablethumb', isset($instance['disablethumb']));
		$instance['category'] = esc_attr(isset($instance['category'])? $instance['category'] : "");
		
        ?>
              <?php echo wp_kses_post( $before_widget ); ?>
                  <?php if ( $title )
                        echo wp_kses_post( $before_title . esc_html( $title ) . $after_title ); ?>
                        		<?php 
									$querycat = get_cat_name($category);
									if($showpost==""){$showpost=3;}
									$rec_query = new WP_Query();
									$rec_query->query("showposts=".$showpost."&category_name=" . $querycat);
									global $post;
								?>
								<?php  if ($rec_query->have_posts()) : ?>
                                <ul class="nvr-latest-post-widget">
                                    <?php while ($rec_query->have_posts()) : $rec_query->the_post(); ?>
                                    <li>
                                    	<?php if($disablethumb!="true") {?>
                                        <?php
                                        $nvr_theid = get_the_ID();
                                        $custom = get_post_custom( $nvr_theid );
                                        $cf_thumb = (isset($custom["custom_thumb"][0]))? $custom["custom_thumb"][0] : "";
                                        
                                        if($cf_thumb!=""){
                                            echo '<img src='. esc_url( $cf_thumb ) .' alt="'. esc_attr( get_the_title( $nvr_theid ) ) .'" width="60" height="60" class="alignleft"/>';
                                        }elseif(has_post_thumbnail($nvr_theid) ){
                                            echo get_the_post_thumbnail($nvr_theid, 'constance-post-thumb', array('class' => 'alignleft'));
                                        }
                                        ?>
                                        <?php } ?>
                                            <h6>
                                            <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php esc_attr_e('Permanent Link to', "constance");?> <?php the_title_attribute(); ?>">
                                            <?php the_title();?>
                                            </a>
                                            </h6>
                                            <span class="smalldate"><?php  the_time('F d, Y') ?></span>
                                        <div class="clearfix"></div>
                                    </li>
                                    <?php endwhile; ?>
                                </ul>
                                
								<?php endif; ?>
								
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
		$instance['category'] = (isset($instance['category']))? $instance['category'] : "";
		$instance['showpost'] = (isset($instance['showpost']))? $instance['showpost'] : "";
		$instance['disablethumb'] = (isset($instance['disablethumb']))? $instance['disablethumb'] : "";
					
        $title = esc_attr($instance['title']);
		$category = esc_attr($instance['category']);
		$showpost = esc_attr($instance['showpost']);
		$disablethumb = esc_attr($instance['disablethumb']);
        ?>
            <p><label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:', "constance"); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
			
            <p><label for="<?php echo esc_attr( $this->get_field_id('category') ); ?>"><?php esc_html_e('Category:', "constance"); ?><br />
			<?php 
			$args = array(
			'selected'         => $category,
			'echo'             => 1,
			'name'             =>$this->get_field_name('category')
			);
			wp_dropdown_categories( $args );
			?>
			</label></p>
			
            <p><label for="<?php echo esc_attr( $this->get_field_id('showpost') ); ?>"><?php esc_html_e('Number of Post:', "constance" ); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('showpost') ); ?>" name="<?php echo esc_attr( $this->get_field_name('showpost') ); ?>" type="text" value="<?php echo esc_attr( $showpost ); ?>" /></label></p>
            
            
            <p><label for="<?php echo esc_attr( $this->get_field_id('disablethumb') ); ?>"><?php esc_html_e('Disable Thumb:', "constance" ); ?> 

                            <input type="checkbox" name="<?php echo esc_attr( $this->get_field_name('disablethumb') ); ?>" id="<?php echo esc_attr( $this->get_field_id('disablethumb') ); ?>" value="true" <?php 
                            
                            if($instance['disablethumb']){
                                echo 'checked="checked"'; 
                            }else{
                                echo '';
                            }
                            ?> />			</label></p>
        <?php 
    }

} // class  Widget
?>
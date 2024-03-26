<?php
// =============================== Novaro Recent Comments  Widget ======================================
class Constance_RecentCommentWidget extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_constance_recent_comments', 'description' => esc_html__('Constance - Recent Comments', "constance") );
		parent::__construct('constance-recent-comments', esc_html__('Constance - Recent Comments',"constance"), $widget_ops);
	}
	
	function widget( $args, $instance ) {
		global $wpdb, $comments, $comment;

		extract($args, EXTR_SKIP);
		$title = apply_filters('widget_title', empty($instance['title']) ? esc_html__('Constance Recent Comments',"constance") : $instance['title']);
		if ( !$number = (int) $instance['number'] )
			$number = 5;
		else if ( $number < 1 )
			$number = 1;
		else if ( $number > 15 )
			$number = 15;
			
		$comment_len = 60;

		if ( !$comments = wp_cache_get( 'recent_comments', 'widget' ) ) {
			$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_approved = '1' and comment_type not in ('pingback','trackback') ORDER BY comment_date_gmt DESC LIMIT 15");
			wp_cache_add( 'recent_comments', $comments, 'widget' );
		}

		$comments = array_slice( (array) $comments, 0, $number );
?>
		<?php echo wp_kses_post( $before_widget ); ?>
			<?php if ( $title ) echo wp_kses_post( $before_title . esc_html( $title ) . $after_title ); ?>
			<ul class="nvr-recent-comment-widget"><?php
			if ( $comments ) : foreach ( (array) $comments as $comment) :?>
			<li class="recentcomments">
			<?php
			echo '<div class="alignleft">'.get_avatar( $comment, 40 ).'</div>';
			echo get_comment_author_link(); 
			echo '<a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">';
			echo strip_tags(substr(apply_filters('get_comment_text', $comment->comment_content), 0, $comment_len)); if (strlen($comment->comment_content) > $comment_len) echo '...'; ;
			echo '</a>';
			?>
			<span class="clear"></span>
            
            </li>
            
            <?php
			endforeach; endif;?></ul>
		<?php echo wp_kses_post( $after_widget ); ?>
<?php
	}
	
	function update($new_instance, $old_instance) {				
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
		$instance['title'] = (isset($instance['title']))? $instance['title'] : "";
		$instance['number'] = (isset($instance['number']))? $instance['number'] : "";
					
        $title = esc_attr($instance['title']);
		$number = esc_attr($instance['number']);
        ?>
            <p><label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:', "constance"); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
			
            <p><label for="<?php echo esc_attr( $this->get_field_id('number') ); ?>"><?php esc_html_e('Number of Comments:', "constance" ); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('number') ); ?>" name="<?php echo esc_attr( $this->get_field_name('number') ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" /></label></p>
        <?php 
    }
}
?>
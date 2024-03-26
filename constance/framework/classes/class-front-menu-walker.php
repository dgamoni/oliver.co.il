<?php

/**
 * Copied from Walker_Nav_Menu_Edit class in WordPress core.
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */
if ( !class_exists( 'Constance_Mega_Menu_Frontend_Walker' ) ) {
	class Constance_Mega_Menu_Frontend_Walker extends Walker_Nav_Menu {
		
		var $nummenu = 0;
		/**
		 * default_menu_item 
		 */
		function default_menu_item( &$output, $args, $item, $depth ) {
			global $constance_main_menu;
			$args = (object)$args;
			$item = (object)$item;
			$indent = str_repeat("\t", $depth);
			$class_names = $value = '';
			$this->nummenu++;
			
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			$args->_submenu_type = ( substr_count( $args->_submenu_type,   'menu_widgets_area_' ) == 1 ) 
				? 'widgets_dropdown' 
				: $args->_submenu_type;
			$class_names .= ' ' . implode(' ', array( $args->_submenu_type, $args->_item_style, $args->_submenu_drops_side, /*$args->_submenu_disable_icons, */$args->_submenu_enable_full_width, 'columns' . $args->_submenu_columns ) );
			$class_names = str_replace( ' dropdown ', ' ', $class_names );
			if($this->nummenu==1){
				$class_names .= " nvrfirstmenu";
			}
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
			

			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
			if ( $depth == '1' && get_post_meta( $args->menu_main_parent, 'submenu_type', true) == 'multicolumn_dropdown' ) {
				$columns = get_post_meta( $args->menu_main_parent, 'submenu_columns', true) 
					? get_post_meta( $args->menu_main_parent, 'submenu_columns', true) 
					: 1;
				$item_width = ' style="width:' . ( 100 / $columns ) . '%;"'; 
			} else {
				$item_width = '';
			}

			$output .= '<li' . $id . $value . $class_names . $item_width .'>';

			$_disable_text = get_post_meta( $item->ID, 'disable_text', true );
			$link_class = ( is_array( $_disable_text ) && in_array( 'true', $_disable_text ) ) ? ' menu_item_without_text' : '';

//            $link_before = '<span>' . $args->link_before;
//            $link_after = $args->link_after . '</span>';

			$item->icon = get_post_meta( $item->ID, 'item_icon', true)
				? get_post_meta( $item->ID, 'item_icon', true)
				: '';

			$item->descr = get_post_meta( $item->ID, 'item_descr', true );
//			$_disable_icon = ( empty( $item->icon ) ? true : false );
			$_disable_link = ( is_array( get_post_meta( $item->ID, 'disable_link', true ) ) && in_array( 'true', get_post_meta( $item->ID, 'disable_link', true ) ) ) ? true : false ;
			$link_class .= ( empty( $item->icon ) ) ? ' disable_icon' : ' with_icon';

			$item_icon = '<i class="' . $item->icon . '"></i> ';

			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
//            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ( !empty( $item->url ) && $_disable_link !== true ) ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
			$attributes .= ! empty( $link_class ) ? ' class="item_link ' . $link_class . '"' : '';

			$item_output = '';
//            $item_output .= $args->before;
			$item_output .= '<' . ( $_disable_link !== true ? 'a' : 'span' ) . $attributes .' tabindex="0">';
			$item_output .= $item_icon;
//            $item_output .= $link_before;
			$item_output .= '<span class="link_content">';
			$item_output .= '<span class="link_text">';
			$item_output .= apply_filters( 'the_title', $item->title, $item->ID );
			if ( !empty( $item->descr ) ) {
				$item_output .= '<span class="link_descr">';
				$item_output .= $item->descr;
				$item_output .= '</span>';
			}
			$item_output .= '</span>';
			$item_output .= '</span>';
//            $item_output .= '<span class="link_text">' . apply_filters( 'the_title', $item->title, $item->ID ) . '</span>';
//            $item_output .= $link_after;
			$item_output .= '</' . ( $_disable_link !== true ? 'a' : 'span' ) . '>';
//            $item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
		
		/**
		 * widgets_dropdown 
		 */
		function widgets_dropdown( &$output, $args ) {
			ob_start();
				dynamic_sidebar( $args['widgets_area_number'] );
				$output .= ob_get_contents();
			ob_end_clean();
		}

		function start_lvl( &$output, $depth = 0, $args = array() ) {
			global $constance_main_menu;
			$args = (object)$args;
			$img = ( (string)$depth == '0' && get_post_meta( $args->menu_main_parent, 'submenu_bg_image', true) ) 
				? get_post_meta( $args->menu_main_parent, 'submenu_bg_image', true) 
				: 'no-img';
			$style = ( is_array( $img ) && $img['background_image'] != '') ? ' style="background-image:url(' . $img['background_image'] . ');background-repeat:' . $img['background_repeat'] . ';background-attachment:' . $img['background_attachment'] . ';background-position:' . $img['background_position'] . ';background-size:' . $img['background_size'] . ';"': '';
			$output .= '<ul class="mega_dropdown"' . $style . '>';
		}

		function end_lvl( &$output, $depth = 0, $args = array() ) {
			global $constance_main_menu;
			$args = (object)$args;
			$indent = str_repeat( "\t", $depth );
				$mmm_submenu_type = ( get_post_meta( $args->menu_main_parent, 'submenu_type', true) ) ? get_post_meta( $args->menu_main_parent, 'submenu_type', true) : 'default_dropdown';
				if ( $mmm_submenu_type == 'post_type_dropdown' ) {
					$args_submenu_type = array( 'menu_item_id' => $args->menu_item_id, 'menu_main_parent' => $args->menu_main_parent );
					call_user_func_array ( array( $this, 'post_type_dropdown' ), array( &$output, $args_submenu_type, $depth ) );
				}
				if ( strpos( $mmm_submenu_type,  'menu_widgets_area_' ) == 0 && $depth == 0 ) {
					$args_submenu_type = array( 
						'menu_item_id' => $args->menu_item_id, 
						'menu_main_parent' => $args->menu_main_parent,
						'widgets_area_number' => $mmm_submenu_type,
					);
					call_user_func_array ( array( $this, 'widgets_dropdown' ), array( &$output, $args_submenu_type ) );
				}
/* for better times
				if ( $mmm_submenu_type != 'default_dropdown' && $mmm_submenu_type != 'multicolumn_dropdown' ) {
					$output .= '<div class="submenu_custom_content">' . do_shortcode( get_post_meta( $args->menu_main_parent, 'submenu_custom_content', true) ) . '</div><!-- /.submenu_custom_content -->';
				} elseif ( $mmm_submenu_type == 'multicolumn_dropdown' && $args->menu_main_parent == $args->menu_item_parent && $depth == 0 ) {
					$output .= '<div class="submenu_custom_content">' . do_shortcode( get_post_meta( $args->menu_main_parent, 'submenu_custom_content', true) ) . '</div><!-- /.submenu_custom_content -->';
				}
*/
			$output .= '</ul><!-- /.mega_dropdown -->';
		}

		function start_el( &$output, $item, $depth = 0, $args = '', $id = 0 ) {
			global $constance_main_menu;
			$args = (object)$args;
			$item = (object)$item;
			if ( get_post_meta( $item->menu_item_parent, 'submenu_type', true) == 'grid_dropdown' ) {
				call_user_func_array ( array( $this, 'grid_dropdown' ), array( &$output, $args, $item, $depth ) );
			} else {
				call_user_func_array ( array( $this, 'default_menu_item' ), array( &$output, $args, $item, $depth ) );
			}
		}

		function end_el( &$output, $item, $depth = 0, $args = '', $id = 0 ) {
			$output .= '</li>';
		}

		function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
			global $constance_main_menu;
			$args[0] = (object)$args[0];
			$element = (object)$element;

			if ( !$element and !isset( $args[0]->menu_main_parent ) )
				return;

			$id_field = $this->db_fields['id'];

			//display this element
			if ( is_array( $args[0] ) ) {
				$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
			}

			$args[0]->menu_item_id = $element->ID;
			$args[0]->menu_item_parent = $element->menu_item_parent;
			if ( $element->menu_item_parent == 0 ) {
				$args[0]->menu_main_parent = $element->ID;
			}

/*
				$args[0]->_submenu_drops_side = ( $args[0]->_submenu_type == 'default_dropdown' && $args[0]->_submenu_drops_side == 'drop_to_center' )
					? 'drop_to_right'
					: $args[0]->_submenu_drops_side;
				$_submenu_disable_icons = is_array( get_post_meta( $element->ID, 'submenu_disable_icons', true ) ) 
					? get_post_meta( $element->ID, 'submenu_disable_icons', true ) 
					: array();
				$args[0]->_submenu_disable_icons = ( in_array( 'true', $_submenu_disable_icons ) ) 
					? 'submenu_disable_icons' 
					: '';
*/
			$args[0]->_submenu_type = ( get_post_meta( $element->ID, 'submenu_type', true) ) 
				? get_post_meta( $element->ID, 'submenu_type', true) 
				: 'default_dropdown';
			$args[0]->_submenu_drops_side = ( get_post_meta( $element->ID, 'submenu_drops_side', true) ) 
				? get_post_meta( $element->ID, 'submenu_drops_side', true) 
				: 'drop_to_right';
			$_submenu_enable_full_width = is_array( get_post_meta( $element->ID, 'submenu_enable_full_width', true ) ) 
				? get_post_meta( $element->ID, 'submenu_enable_full_width', true ) 
				: array();
			$args[0]->_submenu_enable_full_width = ( in_array( 'true', $_submenu_enable_full_width ) ) 
				? 'submenu_full_width' 
				: 'submenu_default_width';
			$args[0]->_submenu_columns = ( get_post_meta( $element->ID, 'submenu_columns', true) ) 
				? get_post_meta( $element->ID, 'submenu_columns', true)
				: '1';

			$_item_visibility = get_post_meta( $element->ID, 'item_visibility', true ) 
				? get_post_meta( $element->ID, 'item_visibility', true ) 
				: 'all';
			switch ( $_item_visibility ) {
				case 'logged':
					$visibility_control = is_user_logged_in();
					break;
				case 'visitors':
					$visibility_control = !is_user_logged_in();
					break;
				default:
					$visibility_control = true;
					break;
			}

			$args[0]->_item_style = ( get_post_meta( $element->ID, 'item_style', true ) != false ) 
				? get_post_meta( $element->ID, 'item_style', true ) 
				: '';
			$mmm_submenu_type = ( get_post_meta( $args[0]->menu_main_parent, 'submenu_type', true) ) 
				? get_post_meta( $args[0]->menu_main_parent, 'submenu_type', true) 
				: 'default_dropdown';

			if ( ( ( $mmm_submenu_type != 'post_type_dropdown' ) || $element->ID == $args[0]->menu_main_parent ) && ( $visibility_control === true ) ) {
				$cb_args = array_merge( array(&$output, $element, $depth), $args);
				call_user_func_array(array($this, 'start_el'), $cb_args);

				$id = $element->$id_field;

				// descend only when the depth is right and there are childrens for this element
				if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

					foreach( $children_elements[ $id ] as $child ){

						if ( !isset($newlevel) ) {
							$newlevel = true;
							//start the child delimiter
							$cb_args = array_merge( array(&$output, $depth), $args);
							call_user_func_array(array($this, 'start_lvl'), $cb_args);
						}
						$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
					}
					unset( $children_elements[ $id ] );
				} elseif ( substr_count( $mmm_submenu_type,  'menu_widgets_area_' ) == 1 || $mmm_submenu_type == 'post_type_dropdown' /* || $mmm_submenu_type == 'custom_dropdown' || get_post_meta( $args[0]->menu_item_id, 'submenu_custom_content', true) != '' */ ) {
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array($this, 'start_lvl'), $cb_args);
					call_user_func_array(array($this, 'end_lvl'), $cb_args);
				}

				if ( isset($newlevel) && $newlevel ){
					//end the child delimiter
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array($this, 'end_lvl'), $cb_args);
				}
			} 

			//end this element
			$cb_args = array_merge( array(&$output, $element, $depth), $args);
			call_user_func_array(array($this, 'end_el'), $cb_args);
		}
	}
}

if(!function_exists('constance_set_walkers')){
	function constance_set_walkers ( $args ){
		global $constance_mega_menu;
		$args = (array)$args;
			// Default args
			$args['items_wrap'] = '<ul id="%1$s" class="%2$s">%3$s</ul>';
			$args['walker'] = new Constance_Mega_Menu_Frontend_Walker;
			$args['container'] = false;
			$args['container_id'] = '';
			$args['container_class'] = '';
			$args['menu_class'] = 'nvr_mega_menu_ul '.$args['menu_class'];
			$args['before'] = '';
			$args['after'] = '';
			$args['link_before'] = '';
			$args['link_after'] = '';
			$args['depth'] = 9;
	
			// items_wrap (container) markup
			$items_wrap = '';
			$items_wrap .= '<div class="nvr_mega_menu">';
			$items_wrap .= '<div class="menu_holder">';
			$items_wrap .= '<div class="nvr_fullwidth_container"></div><!-- class="fullwidth_container" -->';
			$items_wrap .= '<div class="menu_inner">';
			$items_wrap .= '<a class="mobile_toggle">';
			$items_wrap .= '<span class="mobile_button">';
			$items_wrap .= esc_html__( 'Menu', "constance" ) . ' &nbsp;';
			$items_wrap .= '<span class="symbol_menu">&equiv;</span>'; // "Open menu" symbol
			$items_wrap .= '<span class="symbol_cross">&#x2573;</span>'; // "Close menu" symbol
			$items_wrap .= '</span><!-- class="mobile_button" -->';
			$items_wrap .= '</a>';
			$items_wrap .= $args['items_wrap'];
			$items_wrap .= '<div class="clearfix"></div></div><!-- /class="menu_inner" -->';
			$items_wrap .= '</div><!-- /class="menu_holder" -->';
			$items_wrap .= '</div><!-- /id="nvr_mega_menu" -->';
	
			// items_wrap (container) markup
			$args['items_wrap'] = $items_wrap;
	
		return $args;
	}
	add_filter( 'wp_nav_menu_args', 'constance_set_walkers', 3000000, 8 ); 
}

?>
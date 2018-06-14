<?php
class wp_footer_navwalker extends Walker_Nav_Menu {
    var $current_menu = null;
    var $break_point  = null;
		var $break_point_2  = null;
    var $displayed = 0;
  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ){
        global $wp_query;
        if( !isset( $this->current_menu ) )
            $this->current_menu = wp_get_nav_menu_object( $args->menu );
        if( !isset( $this->break_point ) ){
            $menu_elements = wp_get_nav_menu_items( $args->menu );
            $top_level_elements = 0;
            foreach( $menu_elements as $el ) {
                if( $el->menu_item_parent === '0' ) {
                    $top_level_elements++;
                }
            }

            $this->break_point = ceil( $top_level_elements / 3 );
						$this->break_point_2 = ceil( $top_level_elements / 3 * 2 );
        }
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $class_names = $value = '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
        if( $this->break_point == $this->displayed )
            $output .= $indent . '</li></ul></div><div class="col"><ul id="menu-footer" class="menu"><li' . $id . $value . $class_names .'>';
				elseif( $this->break_point_2 == $this->displayed )
								$output .= $indent . '</li></ul></div><div class="col"><ul id="menu-footer" class="menu"><li' . $id . $value . $class_names .'>';
				else
            $output .= $indent . '<li' . $id . $value . $class_names .'>';
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        if( $item->menu_item_parent === '0' ) {
            $this->displayed++;
        }
    }
}

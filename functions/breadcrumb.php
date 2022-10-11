<?php
/**
 * breadcrumb()
 * 
 * パンくずリストを出力する関数
 * 
 * @param array{
 *      'wrapper_elm':      HTMLelement,    // ラッパー要素 (def: 'ol')
 *      'wrapper_class':    string,         // ラッパーのクラス (def: 'breadcrumb')
 *      'item_elm':         HTMLelement,    // 各ノードの要素 (def: 'li')
 *      'text_home':        string          // ホームのテキスト (def: 'Home')
 * } $args
 * @return None; echo the result
 */

function breadcrumb( $args = array() ) {
    global $post, $page_lang;

    // parse args
    $setting = array();
    $defaults = array(
        'wrapper_elm'   => 'ol',
        'wrapper_class' => 'breadcrumb',
        'item_elm'      => 'li',
        'text_home'     => 'Home'
    );
    foreach ( $defaults as $key => $value ) {
        if ( isset( $args[$key] ) ) {
            $setting[$key] = $args[$key];
        } else {
            $setting[$key] = $value;
        }
    }

    // main
    $str ='';
    if( !is_home() && !is_front_page() ) {
        $wrapper_class = empty($setting['wrapper_class']) ? '' : ' class="' . $setting['wrapper_class'] . '"';
        $str .= '<' . $setting['wrapper_elm'] . $wrapper_class . '>';
        $str .= '<' . $setting['item_elm'] . '><a href="' . home_url() . '">' . $setting['text_home'] . '</a></' . $setting['item_elm'] . '>';
        if( is_category() ) {
            // post type
            $post_type = get_query_var( 'post_type' ) == '' ? 'post' : get_query_var( 'post_type' );
            if ( is_array( $post_type ) ) {
                $post_type = reset( $post_type );
            }
            $post_type_object = get_post_type_object( $post_type );
            $str.= '<' . $setting['item_elm'] . '><a href="' .get_post_type_archive_link( $post_type ) . '">' . $post_type_object->labels->name . '</a></' . $setting['item_elm'] . '>';
            // ancestor categories
            $cat_name = single_cat_title( '', false);
            $cat_id = get_cat_ID( $cat_name );
            $cat = get_category( $cat_id );
            if ( $cat->parent != 0 ) {
                $ancestors = array_reverse( get_ancestors( $cat->term_id, 'category' ) );
                foreach( $ancestors as $ancestor ) {
                    $str.= '<' . $setting['item_elm'] . '><a href="' . get_category_link( $ancestor ) . '">' . get_cat_name( $ancestor ) . '</a> </' . $setting['item_elm'] . '>';
                }
            }
            // current title
            $str.= '<' . $setting['item_elm'] . '>' . $cat_name . '</' . $setting['item_elm'] . '>';
        } else if ( is_post_type_archive() ) {
            // post type
            $post_type = get_query_var( 'post_type' ) == '' ? 'post' : get_query_var( 'post_type' );
            if ( is_array( $post_type ) ) {
                $post_type = reset( $post_type );
            }
            $post_type_object = get_post_type_object( $post_type );
            $str.= '<' . $setting['item_elm'] . '>' . $post_type_object->labels->name . '</a></' . $setting['item_elm'] . '>';
        } else if ( is_archive() ) {
            // post type
            $post_type = get_query_var( 'post_type' ) == '' ? 'post' : get_query_var( 'post_type' );
            if ( is_array( $post_type ) ) {
                $post_type = reset( $post_type );
            }
            $post_type_object = get_post_type_object( $post_type );
            $str.= '<' . $setting['item_elm'] . '><a href="' .get_post_type_archive_link( $post_type ) . '">' . $post_type_object->labels->name . '</a></' . $setting['item_elm'] . '>';
            // current title
            $str.='<' . $setting['item_elm'] . '>' . get_the_archive_title() . '</' . $setting['item_elm'] . '>';
        } else if ( is_page() ) {
            // ancestor pages
            if ( $post->post_parent != 0 ) {
                $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
                foreach( $ancestors as $ancestor ) {
                    $str.= '<' . $setting['item_elm'] . '><a href="' . get_permalink( $ancestor ) . '">' . get_the_title( $ancestor ) . '</a></' . $setting['item_elm'] . '>';
                }
            }
            // current title
            $str.='<' . $setting['item_elm'] . '>' . get_the_title() . '</' . $setting['item_elm'] . '>';
        } else if ( is_single() ) {
            // post type
            $post_type = get_query_var( 'post_type' ) == '' ? 'post' : get_query_var( 'post_type' );
            if ( is_array( $post_type ) ) {
                $post_type = reset( $post_type );
            }
            $post_type_object = get_post_type_object( $post_type );
            $str.= '<' . $setting['item_elm'] . '><a href="' .get_post_type_archive_link( $post_type ) . '">' . $post_type_object->labels->name . '</a></' . $setting['item_elm'] . '>';
            // ancestor categories
            $cat = get_the_category( $post->ID );
            $cat = $cat[0];
            if ( isset( $cat->name ) ) {
                if ( $cat->parent != 0 ) {
                    $ancestors = array_reverse( get_ancestors( $cat->term_id, 'category' ) );
                    foreach( $ancestors as $ancestor ) {
                        $str.= '<' . $setting['item_elm'] . '><a href="' . get_category_link( $ancestor ) . '">' . get_cat_name( $ancestor ) . '</a> </' . $setting['item_elm'] . '>';
                    }
                }
                // current category
                $str.= '<' . $setting['item_elm'] . '><a href="' . get_category_link( $cat->term_id ) . '">' . $cat->name . '</a> </' . $setting['item_elm'] . '>';
            }
            // current title
            $str.='<' . $setting['item_elm'] . '>' . get_the_title() . '</' . $setting['item_elm'] . '>';
        } else if ( is_search() ) {
            if ( $page_lang == 'ja' ) {
                $str.='<' . $setting['item_elm'] . '>検索結果:「'.get_search_query().'」</' . $setting['item_elm'] . '>';
            } else {
                $str.='<' . $setting['item_elm'] . '>Search results for "'.get_search_query().'"</' . $setting['item_elm'] . '>';
            }
        } else if ( is_404() ) {
            if ( $page_lang == 'ja' ) {
                $str.='<' . $setting['item_elm'] . '>ページが見つかりません。</' . $setting['item_elm'] . '>';
            } else {
                $str.='<' . $setting['item_elm'] . '>Page not found.</' . $setting['item_elm'] . '>';
            }
        } else {
            $str.='<' . $setting['item_elm'] . '>' . wp_title('', false) . '</' . $setting['item_elm'] . '>';
        }
        $str.='</' . $setting['wrapper_elm'] . '>';
    }
    echo $str;
}
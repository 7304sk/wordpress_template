<?php
/**
 * get_meta_title()
 * 
 * メタタイトルを取得する関数
 * 
 * @return String
 */
function get_meta_title() {
    global $page_lang;
    $str = '';
    if( !is_home() && !is_front_page() ) {
        if( is_search() ) {
            if ( $page_lang == 'ja' ) {
                $title = '「'. esc_html( get_search_query( false ) ) . '」の検索結果';
            } else {
                $title = 'Search results for "'. esc_html( get_search_query( false ) ) . '"';
            }
        } else if( is_404() ) {
            $str.= '404 Not found';
        }  else if( is_archive() ) {
            $str.= get_the_archive_title();
        } else {
            $str.= get_the_title();
        }
        $str.= ' | ';
    }
    $str.= get_bloginfo('name');
    return $str;
}

/**
 * meta_title()
 * 
 * メタタイトルを出力する関数
 * 
 * @return None; echo the result
 */
function meta_title() {
    echo '<title>' . get_meta_title() . '</title>';
}
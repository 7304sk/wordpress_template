<?php
/**
 * pagination()
 * 
 * ページネーションを出力する関数
 * 
 * @param array{
 *      'range':                int,        // 前後何ページ分までリンクを表示するか
 *      'show_pagenum':         bool,       // 現在のページ番号を表示するか
 *      'show_always':          bool,       // 常にページネーションを表示するか（ページ数が1でも表示するか）
 *      'wrapper_class':        string,     // ラッパーのクラス
 *      'current_page_class':   string,     // 現在のページの要素のクラス
 *      'first_page_text':      string,     // 最初のページへのリンクのクラス
 *      'first_page_class':     string,     // 最初のページへのリンクのテキスト
 *      'prev_page_text':       string,     // 一つ前のページへのリンクのクラス
 *      'prev_page_class':      string,     // 一つ前のページへのリンクのテキスト
 *      'next_page_text':       string,     // 一つ後のページへのリンクのクラス
 *      'next_page_class':      string,     // 一つ後のページへのリンクのテキスト
 *      'last_page_text':       string,     // 最後のページへのリンクのクラス
 *      'last_page_class':      string,     // 最後のページへのリンクのテキスト
 *      'other_page_class':     string,     // その他のページへのリンクのクラス
 * } $args
 * @return None; echo the result
 */

function pagination( $args = array() ) {
    global $wp_query;

    // parse args
    $setting = array();
    $defaults = array(
        'range'                 => 3,
        'show_pagenum'          => False,
        'show_always'           => False,
        'wrapper_class'         => 'pagination',
        'current_page_class'    => 'current_page',
        'first_page_text'       => 'keyboard_double_arrow_left',
        'first_page_class'      => 'first_page material-icons',
        'prev_page_text'        => 'chevron_left',
        'prev_page_class'       => 'prev_page material-icons',
        'next_page_text'        => 'chevron_right',
        'next_page_class'       => 'next_page material-icons',
        'last_page_text'        => 'keyboard_double_arrow_right',
        'last_page_class'       => 'last_page material-icons',
        'other_page_class'      => 'other_page'
    );
    foreach ( $defaults as $key => $value ) {
        if ( isset( $args[$key] ) ) {
            $setting[$key] = $args[$key];
        } else {
            $setting[$key] = $value;
        }
    }

    $pages = ( int ) $wp_query->max_num_pages;
    $paged = get_query_var('paged') ?: 1;

    $str = '';
    if ( $pages < 2 ) {
        if ( $show_only ) $str.= '<div class="' . $setting['wrapper_class'] . '"><span class="' . $setting['current_page_class'] . '">1</span></div>';
    } else {
        $str.= '<div class="' . $setting['wrapper_class'] . '">';
        if ( $show_pagenum ) $str.= '<span class="page_num">Page '.$paged.' of '.$pages.'</span>';
        if ( $paged > $range + 1 ) {
            $str.= '<a href="' . get_pagenum_link(1) . '" class="' . $setting['first_page_class'] . '">' . $setting['first_page_text'] . '</a>';
        }
        if ( $paged > 1 ) {
            $str.= '<a href="' . get_pagenum_link( $paged - 1 ) . '" class="' . $setting['prev_page_class'] . '">' . $setting['prev_page_text'] . '</a>';
        }
        for ( $i = 1; $i <= $pages; $i++ ) {
            if ( $paged - $range <= $i && $i <= $paged + $range ) {
                if ( $paged === $i ) {
                    $str.= '<span class="' . $setting['current_page_class'] . '">' . $i . '</span>';
                } else {
                    $str.= '<a href="' . get_pagenum_link( $i ) . '" class="' . $setting['other_page_class'] . '">' . $i . '</a>';
                }
            }
        }
        if ( $paged < $pages ) {
            $str.= '<a href="' . get_pagenum_link( $paged + 1 ) . '" class="' . $setting['next_page_class'] . '">' . $setting['next_page_text'] . '</a>';
        }
        if ( $paged + $range < $pages ) {
            $str.=  '<a href="' . get_pagenum_link( $pages ) . '" class="' . $setting['last_page_class'] . '">' . $setting['last_page_text'] . '</a>';
        }
        $str .= '</div>';
    }
    echo $str;
}
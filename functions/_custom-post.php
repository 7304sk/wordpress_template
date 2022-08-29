<?php
/**
 * カスタム投稿タイプを管理します。
 * それぞれのサイトに合わせてカスタマイズしてください。
 */

/** カスタム投稿タイプの定義 */
add_action( 'init', 'register_my_custom_post_types' );
if ( !function_exists( 'register_my_custom_post_types' ) ) {
    function register_my_custom_post_types() {
        // この中を増やすことで複数定義可能
        register_post_type( 'topics', [
            'labels'            => [
                'name'          => 'トピックス'
            ],
            'public'            => true,
            'has_archive'       => true,
            'show_in_nav_menus' => false,
            'show_in_rest'      => false,
            'rewrite'           => array( 'with_front' => false ),
            'menu_icon'         => 'dashicons-admin-post',
            "menu_position"     => 5,
            'supports'          => array( 'title', 'editor', 'revisions' )
        ]);
        
        register_post_type( 'topics_en', [
            'labels'            => [
                'name'          => 'Topics',
                'singular_name' => 'Topic'
            ],
            'public'            => true,
            'has_archive'       => true,
            'show_in_nav_menus' => false,
            'show_in_rest'      => false,
            'rewrite'           => array( 'with_front' => false ),
            'menu_icon'         => 'dashicons-admin-post',
            "menu_position"     => 5,
            'supports'          => array( 'title', 'editor', 'revisions' )
        ]);
    }
}

/** カスタムフィールドを定義する場合 */
add_action('admin_menu', 'add_custom_fields');
if ( !function_exists( 'add_custom_fields' ) ) {
    function add_custom_fields(){
        // この中を増やすことで複数定義可能
        add_meta_box(
            'my_fields',
            'カスタムフィールド',
            'insert_custom_fields',  // 入力欄を出力する関数
            'topics',                // 適用対象の投稿タイプ
            'normal'
        );

        add_meta_box(
            'my_fields',
            'カスタムフィールド',
            'insert_custom_fields',
            'topics_en',
            'normal'
        );
    }
}
// カスタムフィールドの HTML の定義
// 複数のカスタムフィールドを定義する場合、関数名を変えてここを増やす
if ( !function_exists( 'insert_custom_fields' ) ) {
    function insert_custom_fields() {
        global $post;
        $str = '<table style="width:100%;"><tbody>';

        $current_date = get_post_meta($post->ID, 'topics_date', true);
        $str .= '<tr><th>日付:</th><td><input type="date" name="topics_date" value="'.$current_date.'" /></td></tr>';

        $current_cat = get_post_meta($post->ID, 'topics_category', true);
        $categories = array( 'news', 'event', 'internal' );
        $str .= '<tr><th>カテゴリ:</th><td>';
        foreach ( $categories as $cat ) {
            $str .= '<label style="margin-right:16px"><input type="radio" name="topics_category" value="'.$cat.'" ';
            if ( $cat == $current_cat ) {
                $str .= 'checked ';
            }
            $str .= '/> '.$cat.'</label>';
        }
        $str .= '</td></tr>';

        $str .= '</tbody></table>';
        echo $str;
    }
}
// カスタムフィールドの保存処理の定義
add_action( 'save_post', 'save_custom_fields' );
if ( !function_exists( 'save_custom_fields' ) ) {
    function save_custom_fields( $post_id ) {
        $field_names = array(
            // Add here the name of the custom field you want to allow to be saved at this site.
            'topics_date',
            'topics_category'
        );

        foreach($field_names as $field_name) {
            if ( isset( $_POST[$field_name] ) ) {
                update_post_meta( $post_id, $field_name, $_POST[$field_name] );
            } else {
                delete_post_meta( $post_id, $field_name );
            }
        }
    }
}
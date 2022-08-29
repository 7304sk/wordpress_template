<?php
/**
 * 各スクリプトファイルの読み込み、管理画面の管理を行います。
 * それぞれのサイトに合わせてカスタマイズしてください。
 */

/** スクリプト読み込み */
add_action( 'wp_enqueue_scripts', 'my_queue_files' );
if ( !function_exists( 'my_queue_files' ) ) {
    function my_queue_files() {
        $radix_ver = '4.0.6';
        /** css */
        wp_enqueue_style( 'style-radix', 'https://unpkg.com/radix-library@'.$radix_ver.'/radix.min.css', array(), $radix_ver);
        wp_enqueue_style( 'style-origin', get_theme_file_uri('/assets/stylesheet/style.css'), array(), '1.0.0');

        /** js */
        wp_enqueue_script( 'script-radix', 'https://unpkg.com/radix-library@'.$radix_ver.'/radix.js', array(), $radix_ver, true );
        wp_enqueue_script( 'script-origin', get_theme_file_uri('/assets/javascript/index.js'), array( 'script-radix' ), '1.0.0', true );
    }
}

/** 管理画面管理 */
// コメントアウトを解除するとその項目が管理画面上から消えます。
add_action( 'admin_menu', 'my_menu_omission' );
if ( !function_exists( 'my_menu_omission' ) ) {
    function my_menu_omission() {
        //remove_menu_page( 'index.php' );                //ダッシュボード
        //remove_menu_page( 'edit.php' );                 //投稿
        //remove_menu_page( 'upload.php' );               //メディア
        //remove_menu_page( 'edit.php?post_type=page' );  //固定ページ
        remove_menu_page( 'edit-comments.php' );        //コメントメニュー
        //remove_menu_page( 'themes.php' );               //外観メニュー
        //remove_menu_page( 'plugins.php' );              //プラグインメニュー
        //remove_menu_page( 'tools.php' );                //ツールメニュー
        //remove_menu_page( 'options-general.php' );      //設定メニュー
    }
}

/** カスタムメニューの追加 */
add_action( 'init', 'register_my_nav_menus' );
if ( !function_exists( 'register_my_nav_menus' ) ) {
    function register_my_nav_menus() {
        register_nav_menus(array(
            // 'プロクラム上でのID' => '管理画面上での表示名'
            'global-menu' => 'グローバルメニュー',
            'footer-menu' => 'フッターメニュー',
            'global-menu-en' => 'global menu',
            'footer-menu-en' => 'footer menu'
        ));
    }
}
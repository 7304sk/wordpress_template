<?php
/**
 * 各変数を設定することでログインページ（URL）を変更します。
 * 変更しない場合はこのファイル自体を削除してしまって構いません。
 */

$changeLogin_flg = False;  // ログインページの変更を行うか
$changeLogin_page = 'xxxxxxx.php';  // 変更対象のURL（実体ファイルとして WordPress ルートに設置が必要）
$changeLogin_key = 'abcdefghijklmn';  // ログインページの判別キー

/*

<?php
define( 'ALT_LOGIN', sha1( {ログインキー} ) );
require_once './wp-login.php';

*/

/** >>>>>>>>>> */
if ( $changeLogin_flg ) {
    add_action( 'login_init', 'login_change_init' );
    if ( ! function_exists( 'login_change_init' ) ) {
        function login_change_init() {
            if ( !defined( 'ALT_LOGIN' ) || sha1( $changeLogin_key ) != ALT_LOGIN ) {
                status_header(403);  exit;
            }
        }
    }
    add_filter( 'site_url', 'login_change_site_url', 10, 4 );
    if ( ! function_exists( 'login_change_site_url' ) ) {
        function login_change_site_url( $url, $path, $orig_scheme, $blog_id ) {
            if ( ( $path == 'wp-login.php' || preg_match( '/wp-login\.php\?action=\w+/', $path ) ) && ( is_user_logged_in() || strpos( $_SERVER['REQUEST_URI'],  $changeLogin_page ) !== false ) ) {
                $url = str_replace( 'wp-login.php',  $changeLogin_page, $url );
            }
            return $url;
        }
    }
    add_filter( 'wp_redirect', 'login_change_wp_redirect', 10, 2 );
    if ( ! function_exists( 'login_change_wp_redirect' ) ) {
        function login_change_wp_redirect( $location, $status ) {
            if ( strpos( $_SERVER['REQUEST_URI'],  $changeLogin_page ) !== false ) {
                $location = str_replace( 'wp-login.php',  $changeLogin_page, $location );
            }
            return $location;
        }
    }
}
<?php
/**
 * WordPress の標準をカスタマイズします。
 * 特に理由がなければ、このファイルはカスタマイズする必要がありません。
 */

add_action( 'after_setup_theme', 'theme_support_setup' );
if ( ! function_exists( 'theme_support_setup' ) ) {
	function theme_support_setup() {
        /** Let WordPress manage the document title.  */
        //add_theme_support( 'title-tag' );

        /** Enable support for Post Thumbnails on posts and pages. */
		add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 1568, 9999 );

        /** Add support for responsive embedded content. */
		add_theme_support( 'responsive-embeds' );

		/** Switch default core markup for search form, comment form, and comments to output valid HTML5. */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);

        /** Add theme support for selective refresh for widgets. */
        add_theme_support( 'customize-selective-refresh-widgets' );

        /** Add support for Block Styles. */
        add_theme_support( 'wp-block-styles' );

        /** Add support for editor styles. */
        add_theme_support( 'editor-styles' );
        add_editor_style( $editor_style );
    }
}

/** Add api to admin menu */
add_action( 'admin_enqueue_scripts', 'add_api' );
if ( ! function_exists( 'add_api' ) ) {
    function add_api() {
        wp_enqueue_media();
    }
}

/** Hide author arichves */
add_filter( 'author_rewrite_rules', '__return_empty_array' );
add_action('after_setup_theme', 'disallow_author_archive');
if ( !function_exists( 'disallow_author_archive' ) ) {
    function disallow_author_archive() {
        if( isset( $_GET['author'] ) || preg_match('#/author/.+#', $_SERVER['REQUEST_URI']) ){
            wp_redirect( home_url( '/404', ) );
            exit;
        }
    }
}

/** Remove unwanted endpoints from REST API */
add_filter( 'rest_endpoints', 'rest_endpoints_filter', 10, 1 );
if ( !function_exists( 'rest_endpoints_filter' ) ) {
    function rest_endpoints_filter( $endpoints ) {
        /** users */
        if ( isset( $endpoints['/wp/v2/users'] ) ) { unset( $endpoints['/wp/v2/users'] ); }
        if ( isset( $endpoints['/wp/v2/users/(?P[\d]+)'] ) ) {unset( $endpoints['/wp/v2/users/(?P[\d]+)'] ); }
        /** settings */
        if ( isset( $endpoints['/wp/v2/settings'] ) ) { unset( $endpoints['/wp/v2/settings'] ); }
        if ( isset( $endpoints['/wp/v2/settings/(?P[\d]+)'] ) ) { unset( $endpoints['/wp/v2/settings/(?P[\d]+)'] ); }
        return $endpoints;
    }
}

/** Turn off useless output in wp_head() */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );

/** Fix get_the_archive_title() */
add_filter( 'get_the_archive_title', function ( $title ) {
    if ( is_category() ) {
        $title = single_cat_title('',false);
    } elseif ( is_tag() ) {
        if ( $page_lang == 'ja' ) {
            $title = 'タグ：' . single_tag_title('',false);
        } else {
            $title = 'tag: ' . single_tag_title('',false);
        }
	} elseif ( is_tax() ) {
        $title = single_term_title('',false);
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title('',false);
	} elseif ( is_date() ) {
        if ( $page_lang == 'ja' ) {
            $title = get_the_time('Y年n月');
        } else {
            $title = get_the_time('Y/n');
        }
	} elseif ( is_search() ) {
        if ( $page_lang == 'ja' ) {
            $title = '「'. esc_html( get_search_query( false ) ) . '」の検索結果';
        } else {
            $title = 'Search results for "'. esc_html( get_search_query( false ) ) . '"';
        }
	} elseif ( is_404() ) {
        $title = '404 Not found';
	}
    return $title;
});
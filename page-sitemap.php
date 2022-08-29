<?php get_header(); ?>
    <main id="main" class="fb-brackets">
        <!-- ページタイトル -->
        <h1><?php the_title(); ?></h1>

        <!-- パンくずリスト -->
        <?php breadcrumb(); ?>

        <ul>
            <!-- HOME -->
            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a></li>
            <!-- 固定ページ -->
            <?php wp_list_pages('title_li=&exclude='); ?>
            <!-- アーカイブ -->
            <?php
            $post_type_names = array_keys( $wp_post_types );
            foreach( $post_type_names as $post_type_name ) :
                $obj = get_post_type_object( $post_type_name );
                $archive_link = get_post_type_archive_link( $post_type_name );
                if ( !empty( $archive_link ) && ( $post_type_name != 'post' ) ) :  ?>
            <li><a href="<?php echo $archive_link; ?>"><?php echo $obj->labels->name; ?></a></li>
            <?php endif; endforeach; ?>
        </ul>

    </main>
<?php get_footer(); ?>
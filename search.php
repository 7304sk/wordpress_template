<?php get_header(); ?>
    <main id="main" class="fb-brackets">
        <!-- ページタイトル -->
        <h1 id="pagetitle">「<?php the_search_query(); ?>」の検索結果</h1>

        <!-- パンくずリスト -->
        <?php breadcrumb(); ?>

        <!-- メインループ  -->
        <?php
        $page_num = $wp_query->max_num_pages;
        $paged = get_query_var('paged');
        if ( have_posts() ) : ?>
        <ol>
            <?php while ( have_posts() ) : the_post(); ?>
            <li>
                <a href="<?php the_permalink(); ?>">
                    <div class="title"><?php the_title(); ?></div>
                    <div class="excerpt">
                        <?php
                        $word_max = 50;
                        if( mb_strlen( $post->post_content,'UTF-8' ) > $word_max ) {
                            $content= str_replace('\n', '', mb_substr( strip_tags( $post->post_content ), 0, $word_max - 2,'UTF-8') );
                            echo $content.'……';
                        } else {
                            echo str_replace('\n', '', strip_tags($post->post_content));
                        } ?></div>
                </a>
            </li>
            <?php endwhile; ?>
        </ol>
        <?php else: ?>
        <p>検索ワード<strong>「<?php the_search_query(); ?>」</strong>に該当するページがありませんでした。別の単語での検索をお試しください。</p>
        <?php endif; ?>

        <!-- ページネーション -->
        <?php pagination(); ?>
    </main>
<?php get_footer(); ?>
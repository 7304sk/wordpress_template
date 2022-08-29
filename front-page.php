<?php get_header(); ?>
    <main id="main" class="fb-brackets">
        <!-- ページタイトル -->
        <h1><?php the_title(); ?></h1>

        <!-- メインループ（固定ページとして編集可能な部分）  -->
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); the_content(); endwhile; endif; ?>

        <!-- サブループ（トピックス） -->
        <h2>トピックス</h2>
        <?php
        $args = array(
            'paged'             => 1,           // とりあえず1
            'post_type'         => 'topics',    // 表示する投稿タイプ
            'posts_per_page'    => 6,           // 表示数
        );
        $my_query = new WP_Query( $args );
        if ( $my_query->have_posts() ) : ?>
        <ol class="topics-list">
            <?php while ( $my_query->have_posts() ) : $my_query->the_post(); ?>
            <li>
                <a href="<?php the_permalink(); ?>">
                    <div class="date"><?php echo get_post_meta(get_the_ID(), 'topics_date', true); ?></div>
                    <div class="category"><?php echo get_post_meta(get_the_ID(), 'topics_category', true) ?></div>
                    <div class="title"><?php the_title(); ?> </div>
                </a>
            </li>
            <?php endwhile; ?>
        </ol>
        <?php else: ?>
        <p>記事はありません。</p>
        <?php endif; wp_reset_query(); ?>
        <a href="<?php echo get_post_type_archive_link( 'topics' ) ?>">過去の記事一覧へ</a>
    </main>
<?php get_footer(); ?>
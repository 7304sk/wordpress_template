<?php $page_lang = 'en'; ?>

<?php get_header( 'en' ); ?>
    <main id="main" class="fb-brackets">
        <!-- ページタイトル -->
        <h1><?php echo get_the_archive_title(); ?></h1>

        <!-- パンくずリスト -->
        <?php breadcrumb(); ?>

        <!-- メインループ  -->
        <?php if ( have_posts() ) : ?>
        <ol>
            <?php while ( have_posts() ) : the_post(); ?>
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
        <p><?php echo get_the_archive_title(); ?> has no post.</p>
        <?php endif; ?>

        <!-- ページネーション -->
        <?php pagination(); ?>
    </main>
<?php get_footer( 'em' ); ?>
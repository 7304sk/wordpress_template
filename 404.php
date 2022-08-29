<?php get_header(); ?>
    <main class="fb-brackets">
        <h1>404 Not Found</h1>
        <?php breadcrumb(); ?>
        <h2>お探しのページは見つかりませんでした。</h2>
        <p>
            お探しのページは一時的にアクセスができない状況か、移動または削除された可能性があります。<br>
            トップに戻るか、サイト内検索をお試しください。
        </p>
        <p><a href="<?php echo home_url(); ?>">トップに戻る</a></p>
    </main>
<?php get_footer(); ?>
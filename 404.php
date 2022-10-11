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
        <?php /* in ENGLISH
        <h2>The page you are looking for was not found.</h2>
        <p>
            The page you are looking for may have been temporarily inaccessible, moved or deleted.
        </p>
        <p><a href="<?php echo home_url(); ?>">Back to Top Page</a></p>
        */ ?>
    </main>
<?php get_footer(); ?>
<?php
/**
 * Template Name: 固定ページ（EN）
 */
$page_lang = 'en';
?>

<?php get_header( 'en' ); ?>
    <main id="main" class="fb-brackets">
        <!-- ページタイトル -->
        <h1><?php the_title(); ?></h1>

        <!-- パンくずリスト -->
        <?php breadcrumb(); ?>

        <!-- メインループ  -->
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); the_content(); endwhile; endif; ?>
    </main>
<?php get_footer( 'en' ); ?>
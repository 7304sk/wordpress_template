<?php get_header(); ?>
    <main id="main" class="fb-brackets">
        <!-- ページタイトル -->
        <h1><?php the_title(); ?></h1>

        <!-- パンくずリスト -->
        <?php breadcrumb(); ?>

        <!-- メインループ  -->
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div>
            <div class="date"><?php get_post_meta($post->ID, 'topics_date', true); ?></div>
            <div class="category"><?php get_post_meta($post->ID, 'topics_category', true) ?></div>
        </div>
        <?php the_content(); ?>
        <?php endwhile; endif; ?>
    </main>
<?php get_footer(); ?>
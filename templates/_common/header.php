<?php 
use SANGO\App;

get_header(); 
sng_category_query();
$status = App::get('status')->get_status();
if ($status['is_top']) {
  get_template_part('parts/home/featured-header');
}
?>
  <div id="content"<?php column_class();?>>
    <div id="inner-content" class="wrap">
      <main id="main">
          <article id="entry" <?php post_class(); ?>>
            <header class="article-header entry-header page-header">
              <?php if(is_front_page()) : // ホーム固定の場合 ?>
                <h2 class="page-title"><?php the_title(); // タイトル ?></h2>
              <?php else : // 通常の場合 ?>
                <?php breadcrumb(); ?>
                <h1 class="page-title"><?php the_title(); // タイトル ?></h1>
              <?php endif; ?>
              <?php if (has_post_thumbnail() && !get_option('no_eyecatch_on_page')) : // アイキャッチ ?>
                <p class="post-thumbnail"><?php the_post_thumbnail('thumb-940');?></p>
              <?php endif; ?>
            </header>
            <section class="entry-content page-content">
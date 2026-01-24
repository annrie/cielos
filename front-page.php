<?php
/**
 * The front page template
 *
 * FoundationPressNG inspired section-based layout.
 * Sections: Hero → Features → Divider → Latest Posts
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

get_header(); ?>

<?php
// Hero section data
$hero_title = get_bloginfo('name');
$hero_description = get_bloginfo('description');
?>

<!-- ===== Hero Section ===== -->
<section class="section-hero">
  <div class="marketing">
    <div class="tagline">
      <h1 class="hero-title font-lobster">
        <div class="hero-title__sun">
          <img src="<?php echo get_template_directory_uri(); ?>/src/assets/images/hero-sun-light.png" alt="" class="hero-sun-light">
          <img src="<?php echo get_template_directory_uri(); ?>/src/assets/images/hero-sun-dark.png" alt="" class="hero-sun-dark">
        </div>
        <span class="hero-title__text"><?php echo esc_html($hero_title); ?></span>
      </h1>
      <?php if ($hero_description) : ?>
        <div class="subheader"><?php echo esc_html($hero_description); ?></div>
      <?php endif; ?>
    </div>
    <div class="section-cta">
      <a href="https://github.com/annrie/cielos" class="btn btn-lg" target="_blank" rel="noopener">
        Download cielos
        <span class="i-carbon-download" aria-hidden="true"></span>
      </a>
    </div>
  </div>
</section>

<?php do_action('cielos_after_hero'); ?>

<!-- ===== Features Section ===== -->
<section class="section-benefits">
  <header>
    <h2><?php esc_html_e('このサイトについて', 'cielos'); ?></h2>
    <h4><?php esc_html_e('様々なコンテンツをお届けします', 'cielos'); ?></h4>
  </header>

  <div class="feature-grid">
    <!-- Feature 1 -->
    <div class="feature-item">
      <div class="feature-item__icon">
        <img src="<?php echo get_template_directory_uri(); ?>/src/assets/images/feature-blog.png" alt="" class="feature-icon">
      </div>
      <h3 class="feature-item__title"><?php esc_html_e('ブログ', 'cielos'); ?></h3>
      <p class="feature-item__desc"><?php esc_html_e('日々の出来事や考えを綴っています。', 'cielos'); ?></p>
    </div>

    <!-- Feature 2 -->
    <div class="feature-item">
      <div class="feature-item__icon">
        <img src="<?php echo get_template_directory_uri(); ?>/src/assets/images/feature-review.png" alt="" class="feature-icon">
      </div>
      <h3 class="feature-item__title"><?php esc_html_e('レビュー', 'cielos'); ?></h3>
      <p class="feature-item__desc"><?php esc_html_e('本や映画、サービスのレビューを掲載。', 'cielos'); ?></p>
    </div>

    <!-- Feature 3 -->
    <div class="feature-item">
      <div class="feature-item__icon">
        <img src="<?php echo get_template_directory_uri(); ?>/src/assets/images/feature-tech.png" alt="" class="feature-icon">
      </div>
      <h3 class="feature-item__title"><?php esc_html_e('技術記事', 'cielos'); ?></h3>
      <p class="feature-item__desc"><?php esc_html_e('プログラミングや技術的なTipsを紹介。', 'cielos'); ?></p>
    </div>

    <!-- Feature 4 -->
    <div class="feature-item">
      <div class="feature-item__icon">
        <img src="<?php echo get_template_directory_uri(); ?>/src/assets/images/feature-other.png" alt="" class="feature-icon">
      </div>
      <h3 class="feature-item__title"><?php esc_html_e('その他', 'cielos'); ?></h3>
      <p class="feature-item__desc"><?php esc_html_e('様々なトピックについて発信します。', 'cielos'); ?></p>
    </div>

    <div class="feature-grid__footer">
      <a href="<?php echo esc_url(home_url('/about/')); ?>">
        <?php esc_html_e('詳しく見る', 'cielos'); ?> →
      </a>
    </div>
  </div>
</section>

<!-- ===== Section Divider ===== -->
<div class="section-divider">
  <hr />
</div>

<!-- ===== Latest Posts Section ===== -->
<?php
$featured_posts = new WP_Query([
  'posts_per_page' => 6,
  'post_status' => 'publish',
  'ignore_sticky_posts' => true,
]);

if ($featured_posts->have_posts()) :
?>
<section class="section-page">
  <div class="container-page">
    <header class="text-center mb-12">
      <h2 class="text-h3 font-300 mb-2"><?php esc_html_e('最新の記事', 'cielos'); ?></h2>
      <p class="text-[var(--c-muted)]"><?php esc_html_e('最近公開された記事をご覧ください', 'cielos'); ?></p>
    </header>

    <main id="main" role="main" tabindex="-1">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php while ($featured_posts->have_posts()) : $featured_posts->the_post(); ?>
          <article class="card card-hover">
            <?php if (has_post_thumbnail()) : ?>
              <a href="<?php the_permalink(); ?>" class="block aspect-video overflow-hidden rounded-t-[var(--card-radius)] -mx-[var(--card-padding)] -mt-[var(--card-padding)] mb-4">
                <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover transition-transform duration-300 hover:scale-105']); ?>
              </a>
            <?php endif; ?>
            <h3 class="text-lg font-semibold mb-2">
              <a href="<?php the_permalink(); ?>" class="text-[var(--c-fg)] hover:text-[var(--c-primary)] transition-colors">
                <?php the_title(); ?>
              </a>
            </h3>
            <time datetime="<?php echo get_the_date('c'); ?>" class="text-sm text-[var(--c-muted)]">
              <?php echo get_the_date(); ?>
            </time>
          </article>
        <?php endwhile; ?>
      </div>
      <?php wp_reset_postdata(); ?>

      <div class="text-center mt-10">
        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn-outline">
          <?php esc_html_e('すべての記事を見る', 'cielos'); ?>
          <span class="i-carbon-arrow-right ml-1" aria-hidden="true"></span>
        </a>
      </div>
    </main>
  </div>
</section>
<?php endif; ?>

<?php
// Static front page content (if set)
if (have_posts()) :
  while (have_posts()) :
    the_post();
    if (get_option('show_on_front') === 'page' && get_option('page_on_front') && get_the_content()) :
?>
<!-- ===== Page Content Section ===== -->
<section class="section-page section--alt">
  <div class="container-page">
    <article id="post-<?php the_ID(); ?>" <?php post_class('prose-base max-w-none'); ?>>
      <?php the_content(); ?>
    </article>
  </div>
</section>
<?php
    endif;
  endwhile;
endif;
?>

<?php get_footer(); ?>

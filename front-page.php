<?php
/**
 * The front page template
 *
 * This template displays the site's front page (static or blog).
 * Cielos uses a single-column layout for the front page to
 * provide a clean, focused experience.
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

get_header(); ?>

<?php
// Hero section for front page
$hero_title = get_bloginfo('name');
$hero_description = get_bloginfo('description');
?>
<section class="hero-section bg-gradient-to-br from-[var(--c-primary)] to-[var(--c-primary-dark)] text-white py-16 md:py-24">
  <div class="container-page text-center">
    <h1 class="text-h1 font-bold mb-4"><?php echo esc_html($hero_title); ?></h1>
    <?php if ($hero_description) : ?>
      <p class="text-lg md:text-xl opacity-90 max-w-2xl mx-auto"><?php echo esc_html($hero_description); ?></p>
    <?php endif; ?>
  </div>
</section>

<div class="container-page py-12">
  <main id="main" role="main" tabindex="-1">
    <?php
    // If a static front page is set, show that page's content
    if (have_posts()) :
      while (have_posts()) :
        the_post();
        // Only show content if this is a static page (not the posts page)
        if (get_option('show_on_front') === 'page' && get_option('page_on_front')) :
    ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class('prose-base max-w-none'); ?>>
            <?php the_content(); ?>
          </article>
    <?php
        endif;
      endwhile;
    endif;
    ?>

    <?php
    // Featured posts section
    $featured_posts = new WP_Query([
      'posts_per_page' => 6,
      'post_status' => 'publish',
      'ignore_sticky_posts' => true,
    ]);

    if ($featured_posts->have_posts()) :
    ?>
    <section class="featured-posts mt-12">
      <h2 class="text-h3 font-bold mb-8 text-center"><?php esc_html_e('最新の記事', 'cielos'); ?></h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php while ($featured_posts->have_posts()) : $featured_posts->the_post(); ?>
          <article class="card card-hover">
            <?php if (has_post_thumbnail()) : ?>
              <a href="<?php the_permalink(); ?>" class="block aspect-video overflow-hidden rounded-t-[var(--card-radius)] -mx-[var(--card-padding)] -mt-[var(--card-padding)] mb-4">
                <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover']); ?>
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

      <div class="text-center mt-8">
        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn">
          <?php esc_html_e('すべての記事を見る', 'cielos'); ?>
        </a>
      </div>
    </section>
    <?php endif; ?>

  </main>
</div>

<?php get_footer(); ?>

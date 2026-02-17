<?php
/*
Template Name: Front
 * Template Post Type: page
 *
 * Cielos theme showcase front page with hardcoded Hero (Definitive Edition).
 *
 * @package Cielos
 * @since   Cielos 1.0.0
 */

// Week-based effect toggle: odd weeks = falling, even weeks = constellation
$week_number = floor(time() / (7 * 24 * 60 * 60));
$hero_effect = ($week_number % 2 === 0) ? 'constellation' : 'falling';
$theme_uri   = get_template_directory_uri();

get_header(); ?>

<!-- ===== Hero Section (Definitive Edition - Hardcoded) ===== -->
<section class="section-hero">
  <div class="hero-definitive" id="hero-definitive">

    <!-- Subtitle (full-width centered) -->
    <p class="hero-definitive__subtitle">
      <span class="hero-definitive__subtitle-line" aria-hidden="true"></span>
      <span class="hero-definitive__subtitle-text">WordPress &times; Vue.js テーマ</span>
      <span class="hero-definitive__subtitle-line" aria-hidden="true"></span>
    </p>

    <?php if ($hero_effect === 'falling') : ?>
    <!-- Effect A: Falling Tech Icons (odd weeks) -->
    <div class="hero-definitive__falling-icons" aria-hidden="true">
      <span class="hero-definitive__fall-icon i-logos-wordpress-icon" style="left:15%;animation-delay:0s;animation-duration:12s"></span>
      <span class="hero-definitive__fall-icon i-logos-php" style="left:35%;animation-delay:2s;animation-duration:14s"></span>
      <span class="hero-definitive__fall-icon i-logos-html-5" style="left:52%;animation-delay:4.5s;animation-duration:11s"></span>
      <span class="hero-definitive__fall-icon i-logos-css-3" style="left:68%;animation-delay:1.5s;animation-duration:13s"></span>
      <span class="hero-definitive__fall-icon i-logos-javascript" style="left:82%;animation-delay:3s;animation-duration:10s"></span>
      <span class="hero-definitive__fall-icon i-logos-typescript-icon" style="left:25%;animation-delay:6s;animation-duration:15s"></span>
      <span class="hero-definitive__fall-icon i-logos-vue" style="left:45%;animation-delay:7.5s;animation-duration:12.5s"></span>
      <span class="hero-definitive__fall-icon i-logos-vitejs" style="left:75%;animation-delay:5s;animation-duration:11.5s"></span>
    </div>
    <?php else : ?>
    <!-- Effect B: Constellation Network (even weeks) -->
    <div class="hero-definitive__constellation" aria-hidden="true">
      <svg class="hero-definitive__constellation-svg" viewBox="0 0 1280 720" preserveAspectRatio="xMidYMid slice">
        <line x1="180" y1="120" x2="350" y2="80" class="hero-definitive__cline" style="animation-delay:0s" />
        <line x1="350" y1="80" x2="520" y2="160" class="hero-definitive__cline" style="animation-delay:0.12s" />
        <line x1="520" y1="160" x2="700" y2="100" class="hero-definitive__cline" style="animation-delay:0.24s" />
        <line x1="700" y1="100" x2="880" y2="180" class="hero-definitive__cline" style="animation-delay:0.36s" />
        <line x1="880" y1="180" x2="1050" y2="90" class="hero-definitive__cline" style="animation-delay:0.48s" />
        <line x1="180" y1="120" x2="250" y2="320" class="hero-definitive__cline" style="animation-delay:0.6s" />
        <line x1="250" y1="320" x2="450" y2="380" class="hero-definitive__cline" style="animation-delay:0.72s" />
        <line x1="450" y1="380" x2="640" y2="300" class="hero-definitive__cline" style="animation-delay:0.84s" />
        <line x1="640" y1="300" x2="830" y2="400" class="hero-definitive__cline" style="animation-delay:0.96s" />
        <line x1="830" y1="400" x2="1000" y2="340" class="hero-definitive__cline" style="animation-delay:1.08s" />
        <line x1="520" y1="160" x2="640" y2="300" class="hero-definitive__cline" style="animation-delay:1.2s" />
        <line x1="700" y1="100" x2="830" y2="400" class="hero-definitive__cline" style="animation-delay:1.32s" />
        <line x1="1050" y1="90" x2="1000" y2="340" class="hero-definitive__cline" style="animation-delay:1.44s" />
        <line x1="250" y1="320" x2="150" y2="520" class="hero-definitive__cline" style="animation-delay:1.56s" />
        <line x1="150" y1="520" x2="380" y2="560" class="hero-definitive__cline" style="animation-delay:1.68s" />
        <line x1="380" y1="560" x2="600" y2="500" class="hero-definitive__cline" style="animation-delay:1.8s" />
        <line x1="600" y1="500" x2="780" y2="580" class="hero-definitive__cline" style="animation-delay:1.92s" />
        <line x1="780" y1="580" x2="950" y2="520" class="hero-definitive__cline" style="animation-delay:2.04s" />
        <line x1="950" y1="520" x2="1120" y2="450" class="hero-definitive__cline" style="animation-delay:2.16s" />
        <line x1="450" y1="380" x2="600" y2="500" class="hero-definitive__cline" style="animation-delay:2.28s" />
        <line x1="640" y1="300" x2="780" y2="580" class="hero-definitive__cline" style="animation-delay:2.4s" />
        <line x1="1000" y1="340" x2="1120" y2="450" class="hero-definitive__cline" style="animation-delay:2.52s" />
        <line x1="350" y1="80" x2="450" y2="380" class="hero-definitive__cline" style="animation-delay:2.64s" />
        <line x1="880" y1="180" x2="1000" y2="340" class="hero-definitive__cline" style="animation-delay:2.76s" />
        <line x1="830" y1="400" x2="950" y2="520" class="hero-definitive__cline" style="animation-delay:2.88s" />
      </svg>
      <span class="hero-definitive__cnode-icon i-logos-wordpress-icon" style="left:14.0625%;top:16.6667%;animation-delay:0.2s"></span>
      <span class="hero-definitive__cnode-icon i-logos-php" style="left:27.3438%;top:11.1111%;animation-delay:0.5s"></span>
      <span class="hero-definitive__cnode-icon i-logos-html-5" style="left:40.625%;top:22.2222%;animation-delay:0.8s"></span>
      <span class="hero-definitive__cnode-icon i-logos-css-3" style="left:54.6875%;top:13.8889%;animation-delay:0.3s"></span>
      <span class="hero-definitive__cnode-icon i-logos-javascript" style="left:68.75%;top:25%;animation-delay:1s"></span>
      <span class="hero-definitive__cnode-icon i-logos-typescript-icon" style="left:82.0313%;top:12.5%;animation-delay:0.6s"></span>
      <span class="hero-definitive__cnode-icon i-logos-vue" style="left:19.5313%;top:44.4444%;animation-delay:1.2s"></span>
      <span class="hero-definitive__cnode-icon i-logos-vitejs" style="left:35.1563%;top:52.7778%;animation-delay:0.4s"></span>
      <span class="hero-definitive__cnode-icon i-logos-wordpress-icon" style="left:50%;top:41.6667%;animation-delay:0.9s"></span>
      <span class="hero-definitive__cnode-icon i-logos-php" style="left:64.8438%;top:55.5556%;animation-delay:0.7s"></span>
      <span class="hero-definitive__cnode-icon i-logos-html-5" style="left:78.125%;top:47.2222%;animation-delay:1.1s"></span>
      <span class="hero-definitive__cnode-icon i-logos-css-3" style="left:11.7188%;top:72.2222%;animation-delay:0.3s"></span>
      <span class="hero-definitive__cnode-icon i-logos-javascript" style="left:29.6875%;top:77.7778%;animation-delay:1.4s"></span>
      <span class="hero-definitive__cnode-icon i-logos-typescript-icon" style="left:46.875%;top:69.4444%;animation-delay:0.6s"></span>
      <span class="hero-definitive__cnode-icon i-logos-vue" style="left:60.9375%;top:80.5556%;animation-delay:1s"></span>
      <span class="hero-definitive__cnode-icon i-logos-vitejs" style="left:74.2188%;top:72.2222%;animation-delay:0.8s"></span>
      <span class="hero-definitive__cnode-icon i-logos-css-3" style="left:87.5%;top:62.5%;animation-delay:0.5s"></span>
    </div>
    <?php endif; ?>

    <!-- Main Content Area -->
    <div class="hero-definitive__content">
      <div class="hero-definitive__inner">
        <!-- Sun Image + Title Group -->
        <div class="hero-definitive__center">
          <div class="hero-definitive__sun">
            <img src="<?php echo esc_url($theme_uri); ?>/src/assets/images/hero-sun-light.png" alt="" class="hero-sun-light">
            <img src="<?php echo esc_url($theme_uri); ?>/src/assets/images/hero-sun-dark.png" alt="" class="hero-sun-dark">
          </div>
          <h1 class="hero-definitive__title font-lobster">
            <?php bloginfo('name'); ?>
          </h1>
        </div>

        <!-- Tagline -->
        <?php $tagline = get_bloginfo('description'); ?>
        <?php if ($tagline) : ?>
        <p class="hero-definitive__tagline">
          <?php echo esc_html($tagline); ?>
        </p>
        <?php endif; ?>

        <!-- Feature Pills -->
        <div class="hero-definitive__pills">
          <span class="hero-definitive__pill hero-definitive__pill--green">
            Vue 3 Composition API
          </span>
          <span class="hero-definitive__pill hero-definitive__pill--cyan">
            TypeScript
          </span>
          <span class="hero-definitive__pill hero-definitive__pill--blue">
            WordPress REST API
          </span>
        </div>

        <!-- CTA -->
        <div class="hero-definitive__cta">
          <a href="https://github.com/annrie/cielos" class="hero-definitive__btn hero-definitive__btn--primary" target="_blank" rel="noopener">
            <span class="i-carbon-download" aria-hidden="true"></span>
            ダウンロード
          </a>
          <a href="https://github.com/annrie/cielos" class="hero-definitive__btn hero-definitive__btn--secondary" target="_blank" rel="noopener">
            <span class="i-carbon-logo-github" aria-hidden="true"></span>
            GitHub
          </a>
        </div>
      </div>

      <!-- Glass Cards -->
      <div class="hero-definitive__cards">
        <div class="hero-definitive__card" style="transition-delay:300ms">
          <div class="hero-definitive__card-icon">
            <span class="i-logos-vue text-2xl" aria-hidden="true"></span>
          </div>
          <div>
            <h3 class="hero-definitive__card-title">Vue 3対応</h3>
            <p class="hero-definitive__card-desc">Composition APIとTypeScriptで型安全</p>
          </div>
        </div>
        <div class="hero-definitive__card" style="transition-delay:450ms">
          <div class="hero-definitive__card-icon">
            <span class="i-logos-unocss text-2xl" aria-hidden="true"></span>
          </div>
          <div>
            <h3 class="hero-definitive__card-title">UnoCSS</h3>
            <p class="hero-definitive__card-desc">アトミックCSSで高速スタイリング</p>
          </div>
        </div>
        <div class="hero-definitive__card" style="transition-delay:600ms">
          <div class="hero-definitive__card-icon">
            <span class="i-logos-vitejs text-2xl" aria-hidden="true"></span>
          </div>
          <div>
            <h3 class="hero-definitive__card-title">超高速</h3>
            <p class="hero-definitive__card-desc">Viteビルドで瞬時のHMR</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Reveal animation (replaces Vue's requestAnimationFrame + isVisible) -->
<script>
requestAnimationFrame(function() {
  var hero = document.getElementById('hero-definitive');
  if (hero) hero.classList.add('is-visible');
});
</script>

<?php do_action('cielos_after_hero'); ?>

<section class="intro py-16" role="main">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-8">

<?php
$myposts = get_posts(
    array(
        'post_type'      => 'post',
        'posts_per_page' => '6',
    )
);
?>
<?php
if ($myposts) :
foreach ($myposts as $post) :
        setup_postdata($post);
        ?>

<article <?php post_class('bg-[var(--c-panel)] p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300'); ?>>
<a href="<?php the_permalink(); ?>" class="block">

    <?php
        if (has_post_thumbnail()) :
        ?>
<figure class="mb-4 overflow-hidden rounded-lg">
    <?php
        the_post_thumbnail(
            'medium',
            array(
                'class' => 'w-full h-auto object-cover hover:scale-105 transition-transform duration-300',
                'alt'   => the_title_attribute('echo=0'),
                'title' => the_title_attribute('echo=0'),
                'loading' => 'lazy',
                'decoding' => 'async',
            )
        );
        ?>
</figure>
    <?php endif; ?>

<h3 class="text-xl font-bold text-[var(--c-fg)] hover:text-[var(--c-primary)] transition-colors duration-200"><?php the_title(); ?></h3>

</a>
</article>

    <?php
endforeach;
wp_reset_postdata();
endif;
?>
</div>
</div>
</section>

<div class="section-divider py-8">
  <hr class="border-t border-[var(--c-border)]" />
</div>

<section class="benefits py-16 bg-[var(--c-bg)]">
  <header class="text-center mb-12">
    <h2 class="text-3xl font-bold text-[var(--c-fg)] mb-4">Build Cielos based sites, powered by WordPress</h2>
    <h4 class="text-lg text-[var(--c-muted)]">Cielos is the professional choice for designers, developers and teams. <br /> WordPress is by far, <a href="http://trends.builtwith.com/cms" class="text-[var(--c-primary)] hover:underline">the world's most popular CMS</a> (currently powering 38% of the web).</h4>
  </header>

  <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
    <div class="semantic text-center p-6 bg-[var(--c-panel)] rounded-lg shadow-md">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/public/images/demo/semantic.svg" alt="semantic" class="mx-auto mb-4 h-24 w-auto" loading="lazy" decoding="async">
      <h3 class="text-xl font-bold text-[var(--c-fg)] mb-2">Semantic</h3>
      <p class="text-[var(--c-muted)]">Everything is semantic. You can have the cleanest markup without sacrificing the utility and speed of Cielos.</p>
    </div>

    <div class="responsive text-center p-6 bg-[var(--c-panel)] rounded-lg shadow-md">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/public/images/demo/responsive.svg" alt="responsive" class="mx-auto mb-4 h-24 w-auto" loading="lazy" decoding="async">
      <h3 class="text-xl font-bold text-[var(--c-fg)] mb-2">Responsive</h3>
      <p class="text-[var(--c-muted)]">You can build for small devices first. Then, as devices get larger and larger, layer in more complexity for a complete responsive design.</p>
    </div>

    <div class="customizable text-center p-6 bg-[var(--c-panel)] rounded-lg shadow-md">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/public/images/demo/customizable.svg" alt="customizable" class="mx-auto mb-4 h-24 w-auto" loading="lazy" decoding="async">
      <h3 class="text-xl font-bold text-[var(--c-fg)] mb-2">Customizable</h3>
      <p class="text-[var(--c-muted)]">You can customize your build to include or remove certain elements, as well as define the size of columns, colors, font size and more.</p>
    </div>

    <div class="professional text-center p-6 bg-[var(--c-panel)] rounded-lg shadow-md">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/public/images/demo/professional.svg" alt="professional" class="mx-auto mb-4 h-24 w-auto" loading="lazy" decoding="async">
      <h3 class="text-xl font-bold text-[var(--c-fg)] mb-2">Professional</h3>
      <p class="text-[var(--c-muted)]">Millions of designers and developers depend on Cielos. We have business support, training and consulting to help grow your product or service.</p>
    </div>
  </div>

  <div class="why-foundation text-center mt-12">
    <a href="/kitchen-sink" class="inline-block px-8 py-3 text-lg font-semibold text-white bg-[var(--c-primary)] rounded-lg shadow-md hover:bg-[var(--c-primary-dark)] transition-colors duration-300">See what's in Cielos out of the box →</a>
  </div>

</section>
<?php get_sidebar('full'); ?>

<?php
get_footer();

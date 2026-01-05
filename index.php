<?php get_header(); ?>

<div id="app" class="container mx-auto px-4 py-8">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <main id="main" class="lg:col-span-2" role="main" tabindex="-1">
      <div id="app"></div>
      <div id="cielos-pagination"></div>
    </main>
      <?php get_sidebar(); ?>
  </div>
</div>

<?php get_footer(); ?>

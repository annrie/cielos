<?php
/*
Template Name: Front
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage unomoon
 * @since unomoon 1.0.0
*/

get_header(); ?>

<header class="front-hero bg-gray-100 dark:bg-gray-800 py-16 text-center" role="banner">
	<div class="container mx-auto px-4">
		<div class="marketing space-y-6">
			<h1 class="text-5xl font-bold text-gray-900 dark:text-white"><?php bloginfo('name'); ?></h1>
			<h4 class="text-xl text-gray-700 dark:text-gray-300"><?php bloginfo('description'); ?></h4>
			<a role="button" class="inline-block px-8 py-3 text-lg font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 transition-colors duration-300" href="https://github.com/annrie/unomoonNG">Download unomoon</a>
		</div>

		<div class="watch mt-8 flex justify-center space-x-4">
			<span id="twitter"><a href="https://twitter.com/muraie_jin" class="text-blue-600 dark:text-blue-400 hover:underline">@muraie_jin</a></span>
		</div>
	</div>
</header>

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

<article <?php post_class('bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300'); ?>>
<a href="<?php the_permalink(); ?>" class="block">

		<?php
        if (has_post_thumbnail()) :
        ?>
<figure class="mb-4 overflow-hidden rounded-lg">
		<?php
        the_post_thumbnail(
            'medium', // Changed from 'small' for better quality
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

<h3 class="text-xl font-bold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200"><?php the_title(); ?></h3>

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

<!-- <?php do_action('cielos_before_content'); ?>
<?php
while (have_posts()) :
the_post();
?>
<section class="intro" role="main">
	<div class="fp-intro">

		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<?php do_action('cielos_page_before_entry_content'); ?>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
			<footer>
				<?php
                    wp_link_pages(
    array(
        'before' => '<nav id="page-nav"><p>' . __('Pages:', 'cielos'),
        'after'  => '</p></nav>',
    )
);
                ?>
				<p><?php the_tags(); ?></p>
			</footer>
			<?php do_action('cielos_page_before_comments'); ?>
			<?php comments_template(); ?>
			<?php do_action('cielos_page_after_comments'); ?>
		</div>

	</div>

</section>
<?php endwhile; ?>
<?php do_action('cielos_after_content'); ?> -->

<div class="section-divider py-8">
	<hr class="border-t border-gray-200 dark:border-gray-700" />
</div>


<section class="benefits py-16 bg-gray-50 dark:bg-gray-900/50">
	<header class="text-center mb-12">
		<h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Build Cielos based sites, powered by WordPress</h2>
		<h4 class="text-lg text-gray-700 dark:text-gray-300">Cielos is the professional choice for designers, developers and teams. <br /> WordPress is by far, <a href="http://trends.builtwith.com/cms" class="text-blue-600 dark:text-blue-400 hover:underline">the world's most popular CMS</a> (currently powering 38% of the web).</h4>
	</header>

	<div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
		<div class="semantic text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/public/images/demo/semantic.svg" alt="semantic" class="mx-auto mb-4 h-24 w-auto" loading="lazy" decoding="async">
			<h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Semantic</h3>
			<p class="text-gray-700 dark:text-gray-300">Everything is semantic. You can have the cleanest markup without sacrificing the utility and speed of Cielos.</p>
		</div>

		<div class="responsive text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/public/images/demo/responsive.svg" alt="responsive" class="mx-auto mb-4 h-24 w-auto" loading="lazy" decoding="async">
			<h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Responsive</h3>
			<p class="text-gray-700 dark:text-gray-300">You can build for small devices first. Then, as devices get larger and larger, layer in more complexity for a complete responsive design.</p>
		</div>

		<div class="customizable text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/public/images/demo/customizable.svg" alt="customizable" class="mx-auto mb-4 h-24 w-auto" loading="lazy" decoding="async">
			<h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Customizable</h3>
			<p class="text-gray-700 dark:text-gray-300">You can customize your build to include or remove certain elements, as well as define the size of columns, colors, font size and more.</p>
		</div>

		<div class="professional text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/public/images/demo/professional.svg" alt="professional" class="mx-auto mb-4 h-24 w-auto" loading="lazy" decoding="async">
			<h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Professional</h3>
			<p class="text-gray-700 dark:text-gray-300">Millions of designers and developers depend on Cielos. We have business support, training and consulting to help grow your product or service.</p>
		</div>
	</div>

	<div class="why-foundation text-center mt-12">
		<a href="/kitchen-sink" class="inline-block px-8 py-3 text-lg font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 transition-colors duration-300">See what's in Cielos out of the box →</a>
	</div>

</section>
<?php get_sidebar('full'); ?>

<?php
get_footer();

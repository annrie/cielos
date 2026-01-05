<?php
/*
Template Name: machaki-book
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage unomoon
 * @since unomoon 1.0
*/

get_header(); ?>

<?php do_action('cielos_before_content'); ?>

		<main class="main-content" tabindex="-1">
    <header role="banner">
        <section class="myhero" style="background-image:
                                        linear-gradient(
                                            rgba(0,0,0,0.3),
                                            rgba(0,0,0,0.3)
                                            ),
                                        url( <?php echo get_field('hero_img')['url']; ?> );">
                <h1><?php the_field('hero_main'); ?></h1>
                <p><?php the_field('hero_sub'); ?></p>
                <p><a class="button warning" href="#"><?php the_field('hero_button'); ?></a></p>
        </section>
    </header>
    <section class="mycon">
            <h2 class="sec-title">CONCEPTS</h2>
            <p>すべてが揃う。そんな場所を目指しています。</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-center">
            <div>
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/dist/assets/images/lp-custom/con1.png" alt="">
                <h3>かんたん設定</h3>
                <p>面倒な受付手続きはスキップ。オンラインで簡単スピーディに設定できます。</p>
            </div>

            <div>
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/dist/assets/images/lp-custom/con2.png" alt="">
                <h3>全天候型</h3>
                <p>天気に左右されない全天候型の施設を完備。明日の天気の心配はありません。</p>
            </div>

            <div>
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/dist/assets/images/lp-custom/con3.png" alt="">
                <h3>飲食フリー</h3>
                <p>あちこちに飲食スペースが設けてあって一息つけます。持ち込みフードもOKです。</p>
            </div>

            <div>
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/dist/assets/images/lp-custom/con4.png" alt="">
                <h3>いつでも睡眠</h3>
                <p>滞在型だからこそできるのが、いつでもベッドルームに戻って寝ることです。</p>
            </div>
        </div>
    </section>

<section class="mypoint1">
    <div class="text-center">
        <p>集中的に仕事を進めることができる、<br>
        そんな環境が整っています。</p>
    </div>
</section>

<section class="mynews">
	<h2 class="sec-title">LATEST NEWS</h2>
	<p>最新情報です</p>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

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

	<article <?php post_class(); ?>>
	<a href="<?php the_permalink(); ?>">

			<?php
            if (has_post_thumbnail()) :
            ?>
	<figure>
		<?php
            the_post_thumbnail(
                'small',
                array(
                    'class' => 'thumbnail',
                    'alt'   => the_title_attribute('echo=0'),
                    'title' => the_title_attribute('echo=0'),
                )
            );
        ?>
	</figure>
		<?php endif; ?>

	<h3><?php the_title(); ?></h3>

	</a>
	</article>

		<?php
    endforeach;
    wp_reset_postdata();
    endif;
    ?>
    </div>
</section>

<section class="mypoint2" style="background-color: <?php echo the_field('point2_bkcolor'); ?>;">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <div class="md:col-span-7">
            <figure>
                <?php echo wp_get_attachment_image(get_field('point2_img')['ID'], 'full'); ?>
            </figure>
        </div>
        <div class="md:col-span-5 self-center">
            <p><?php the_field('point2_big'); ?></p>
            <p><?php the_field('point2_small'); ?></p>
        </div>
    </div>
</section>

<section class="mytest">
	<h2 class="sec-title">TESTIMONIALS</h2>
	<p>たくさんの方にご利用いただいています</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="mytest1">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-3 md:col-span-5 self-center">
                    <figure>
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/dist/assets/images/lp-custom/test1.jpg" alt="">
                    </figure>
                </div>
                <div class="col-span-9 md:col-span-7 self-center">
                    <p>その日の気分に合わせてワークスペースを選ぶことができたのでとても便利でした。</p>
                    <p><strong>TANAKA HANAKO</strong>
                    <br>Designer</p>
                </div>
            </div>
        </div>

        <div class="mytest2">
            <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-3 md:col-span-5 self-center">
                        <figure>
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/dist/assets/images/lp-custom/test2.jpg" alt="">
                        </figure>
                    </div>
                    <div class="col-span-9 md:col-span-7 self-center">
                            <p>わからないことがあっても、テクニカルアドバイザーに質問できるので安心です。</p>
                            <p><strong>SUZUKI TARO</strong>
                            <br>Front-end Engineer</p>
                    </div>
            </div>
        </div>
    </div>
</section>

<section class="myaction" style="background-image:
                                        linear-gradient(
                                            rgba(018, 101, 156, 0.7),
                                            rgba(18, 101, 156, 0.7)
                                            ),
                                        url( <?php echo get_field('action_img')['url']; ?> );">

                <p><?php the_field('action_main'); ?></p>
                <p><?php the_field('action_sub'); ?></p>
                <p><a class="button warning" href="#"><?php the_field('action_button'); ?></a></p>
	<!-- <p>日常のその先へ</p>
	<p>いつでも、お越しをお待ちしております。</p>
	<a href="#">ワークスペースを申し込む</a> -->
</section>


    </main>
    <!-- </div>
</div> -->
<?php do_action('cielos_after_content'); ?>
		<?php get_template_part('back_to_top'); ?>
<?php
get_footer();

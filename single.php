<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package primasnab
 */

get_header();
?>

<main class="main">
	<div class="container">
		<?php get_template_part("template-parts/components/breadcrumbs"); ?>

		<?php
		while (have_posts()) :
			the_post();
		?>

			<article class="article-single sec-offset">
				<div class="article-single__wrapper">

					<h1 class="article-single__title sec-title"><?php the_title(); ?></h1>

					<?php if (has_post_thumbnail()) : ?>
						<div class="article-single__featured-image">
							<?php the_post_thumbnail('large', array('loading' => 'lazy')); ?>
						</div>
					<?php endif; ?>

					<?php
					// Получаем блоки из Flexible Content
					$article_blocks = get_field('article_blocks');

					if ($article_blocks) : ?>
						<div class="article-single__blocks">
							<?php foreach ($article_blocks as $block) : ?>

								<!-- БЛОК: ТЕКСТ -->
								<?php if ($block['acf_fc_layout'] === 'text') : ?>
									<div class="article-block article-block--text">
										<?php echo wp_kses_post($block['text']); ?>
									</div>
								<?php endif; ?>

								<!-- БЛОК: ИЗОБРАЖЕНИЕ -->
								<?php if ($block['acf_fc_layout'] === 'image') : ?>
									<figure class="article-block article-block--image">
										<img src="<?php echo esc_url($block['image']); ?>"
											alt="<?php echo esc_attr($block['caption'] ?? ''); ?>"
											loading="lazy">
										<?php if (!empty($block['caption'])) : ?>
											<figcaption><?php echo esc_html($block['caption']); ?></figcaption>
										<?php endif; ?>
									</figure>
								<?php endif; ?>

								<!-- БЛОК: ЗАГОЛОВОК -->
								<?php if ($block['acf_fc_layout'] === 'heading') : ?>
									<div class="article-block article-block--heading">
										<?php if ($block['title']) : ?>
											<h2><?php echo esc_html($block['title']); ?></h2>
										<?php endif; ?>
										<?php if ($block['subtitle']) : ?>
											<p class="subtitle"><?php echo esc_html($block['subtitle']); ?></p>
										<?php endif; ?>
									</div>
								<?php endif; ?>

								<!-- БЛОК: ВИДЕО -->
								<?php if ($block['acf_fc_layout'] === 'video') : ?>
									<div class="article-block article-block--video">
										<?php if ($block['video']) :
											$video_file = $block['video'];
											$video_url = is_array($video_file) ? $video_file['url'] : $video_file;
										?>
											<video controls preload="metadata" loading="lazy">
												<source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
												Ваш браузер не поддерживает видео.
											</video>
										<?php endif; ?>
										<?php if ($block['caption']) : ?>
											<p class="video-caption"><?php echo esc_html($block['caption']); ?></p>
										<?php endif; ?>
									</div>
								<?php endif; ?>

							<?php endforeach; ?>
						</div>
					<?php else : ?>
						<!-- Если блоков нет - выводим обычный контент -->
						<div class="article-single__content">
							<?php the_content(); ?>
						</div>
					<?php endif; ?>

				</div>
			</article>

		<?php
		// Если нужно, можно оставить навигацию или комментарии
		// the_post_navigation();
		// if ( comments_open() || get_comments_number() ) :
		//     comments_template();
		// endif;

		endwhile; // End of the loop.
		?>
	</div>
</main><!-- #main -->

<?php
get_footer();

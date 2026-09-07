<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined('ABSPATH') || exit;

get_header('shop');
?>
<main class="main">
	<div class="container">
		<?php woocommerce_breadcrumb(); ?>

		<section class="catalog">

			<!-- Заголовок страницы -->
			<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

			<div class="catalog__content">
				<?php /* ==  Боковая панель - фильтр == */ ?>
				<div class="catalog__sidebar">
					<button class="close-sidebar" aria-label="Закрыть фильтры">
						<svg class="close-sidebar__icon" width="6" height="6" aria-hidden="true" focusable="false">
							<use xlink:href="<?php echo esc_url(get_template_directory_uri()); ?>/img/sprite.svg#icon-close"></use>
						</svg>
					</button>
					<?php dynamic_sidebar('filter-product'); ?>
				</div>

				<!-- Основная область -->
				<div class="catalog__area">
					<ul class="catalog__tags tags">
						<?php
						$product_tags = get_terms(array(
							'taxonomy'   => 'product_tag',
							'hide_empty' => false, // true - скрыть теги без товаров, false - показать все
							'orderby'    => 'name', // сортировка по имени
							'order'      => 'ASC',
						));

						if (!empty($product_tags) && !is_wp_error($product_tags)) :
							foreach ($product_tags as $tag) :
								$tag_name = $tag->name;
								$tag_slug = $tag->slug;
								$tag_link = get_term_link($tag);
						?>
								<li class="tags__item"><a href="<?php echo esc_url($tag_link); ?>" class="tags__link">#<?php echo esc_html($tag_name); ?></a></li>
						<?php
							endforeach;
						endif;
						?>
					</ul>
					<div class="catalog__panel">
						<div class="catalog__sort-options"><?php woocommerce_catalog_ordering(); ?></div>

						<!-- Кнопка фильтры для мобилки -->
						<button class="filter-toggle__btn" aria-label="Открыть фильтры" aria-expanded="false">
							<svg class="filter-toggle__icon" width="15" height="15" aria-hidden="true" focusable="false">
								<use xlink:href="<?php echo esc_url(get_template_directory_uri()); ?>/img/sprite.svg#icon-filter"></use>
							</svg>
							Фильтры
						</button>

						<?php echo do_shortcode('[wcapf_active_filters]'); ?>
					</div>
					<div class="catalog__list" id="products-list">
						<?php
						if (woocommerce_product_loop()) {

							woocommerce_product_loop_start();

							if (wc_get_loop_prop('total')) {
								while (have_posts()) {
									the_post();

									/**
									 * Hook: woocommerce_shop_loop.
									 */
									do_action('woocommerce_shop_loop');

									wc_get_template_part('content', 'product');
								}
							}

							woocommerce_product_loop_end();

						?>
							<div class="catalog__paginations">
								<?php
								/**
								 * Hook: woocommerce_after_shop_loop.
								 *
								 * @hooked woocommerce_pagination - 10
								 */
								do_action('woocommerce_after_shop_loop');
								?>
							</div>

						<?php
						} else {
							/**
							 * Hook: woocommerce_no_products_found.
							 *
							 * @hooked wc_no_products_found - 10
							 */
							do_action('woocommerce_no_products_found');
						}
						?>
					</div>

				</div>
			</div>
		</section>

	</div>
</main>
<?php

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');



get_footer('shop');

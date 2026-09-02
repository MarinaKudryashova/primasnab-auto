<?php

/**
 * Single Product Template (карточка товара)
 */
defined('ABSPATH') || exit;
get_header('shop');

global $product;
if (! $product || ! is_a($product, 'WC_Product')) {
    $product = wc_get_product(get_the_ID());
}
if (! $product) {
    echo '<div class="container">Товар не найден</div>';
    get_footer('shop');
    exit;
}

// ---- Изображения для слайдера ----
$thumbnail_id = $product->get_image_id();
$gallery_ids  = $product->get_gallery_image_ids();
$all_image_ids = array_filter(array_merge([$thumbnail_id], $gallery_ids));

if (! function_exists('get_image_versions')) {
    function get_image_versions($image_id, $size = 'full')
    {
        $url = wp_get_attachment_image_url($image_id, $size);
        return [
            'original_1x' => $url,
            'webp_1x'     => '',
            'alt'         => get_post_meta($image_id, '_wp_attachment_image_alt', true)
        ];
    }
}

$slider_images = [];
foreach ($all_image_ids as $image_id) {
    $image_data = get_image_versions($image_id, 'full');
    if (! empty($image_data['original_1x'])) {
        $slider_images[] = $image_data;
    }
}
if (empty($slider_images)) {
    $placeholder_url = wc_placeholder_img_src('full');
    $slider_images[] = [
        'original_1x' => $placeholder_url,
        'webp_1x'     => '',
        'alt'         => 'Нет изображения'
    ];
}

?>

<div class="container">
    <div class="woocommerce_breadcrumb">
        <?php woocommerce_breadcrumb(); ?>
    </div>

    <div class="single-product">
        <div class="single-product__info">
            <h1 class="single-product__title page-title"><?php echo esc_html($product->get_name()); ?></h1>
            <div class="single-product__meta">
                <?php
                $lot = get_post_meta($product->get_id(), 'lot', true);
                $unique_id = get_post_meta($product->get_id(), 'unique_id', true);
                ?>
                <?php if (! empty($lot)) : ?>
                    <div class="single-product__lot"><?php echo esc_html($lot); ?></div>
                <?php endif; ?>
                <?php if (! empty($unique_id)) : ?>
                    <div class="single-product__unique-id"><?php echo esc_html($unique_id); ?></div>
                <?php endif; ?>
                <!-- 
                <span class="single-product__lot">лот</span>
                <span class="single-product__unique-id">Уникальный ID записи</span> -->
            </div>
        </div>

        <div class="single-product__wrap">
            <div class="single-product__left">
                <!-- СЛАЙДЕР -->
                <div class="single-product__gallery">
                    <div class="swiper single-product__swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($slider_images as $img) : ?>
                                <div class="swiper-slide">
                                    <?php if (! empty($img['webp_1x'])) : ?>
                                        <picture>
                                            <source srcset="<?php echo esc_url($img['webp_1x']); ?>" type="image/webp">
                                            <img src="<?php echo esc_url($img['original_1x']); ?>" alt="<?php echo esc_attr($img['alt']); ?>">
                                        </picture>
                                    <?php else : ?>
                                        <img src="<?php echo esc_url($img['original_1x']); ?>" alt="<?php echo esc_attr($img['alt']); ?>">
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <button class="sec-slider__btn-prev">
                        <svg class="sec-slider__icon">
                            <use xlink:href="<?php echo esc_url(get_template_directory_uri()); ?>/img/sprite.svg#icon-chevron-left"></use>
                        </svg>
                    </button>
                    <button class="sec-slider__btn-next">
                        <svg class="sec-slider__icon">
                            <use xlink:href="<?php echo esc_url(get_template_directory_uri()); ?>/img/sprite.svg#icon-chevron-right"></use>
                        </svg>
                    </button>
                </div>

                <button class="single-product__btn ui-btn ui-btn--pink" type="button" data-graph-path="modal-leadform">Оставить заявку</button>
            </div>

            <!-- Характеристики  -->
            <div class="single-product__specs">
                <?php
                $specs = [
                    'Марка'                   => 'car_brand',
                    'Модель'                  => 'car_model',
                    'Год выпуска'             => 'car_year',
                    'Объем двигателя (см³)'   => 'car_engine_volume',
                    'Мощность двигателя (л.с.)' => 'car_power',
                    'КПП'                     => 'car_transmission',
                    'Привод'                  => 'car_drive',
                    'Пробег (км)'             => 'car_mileage',
                    'Цвет кузова'             => 'car_color',
                    'Комплектация'            => 'car_trim',
                    'Оценка'                  => 'car_grade',
                    'Аукцион'                 => 'car_auction',
                    'Дата аукциона'           => 'car_auction_date',
                    'Стартовая цена'          => 'car_start_price',
                    'Финальная/продажная цена' => 'car_final_price',
                ];

                $product_id = $product->get_id();
                $output = '';

                foreach ($specs as $label => $field_key) {
                    $value = get_field($field_key, $product_id);
                    if (! empty($value) && $value !== '0') {
                        // Определяем, нужно ли выделение
                        $highlight = in_array($label, ['Стартовая цена', 'Финальная/продажная цена']);
                        $value_class = $highlight ? 'specs-value specs-value--highlight' : 'specs-value';

                        $output .= '<div class="specs-row">';
                        $output .= '<span class="specs-label">' . esc_html($label) . '</span>';
                        $output .= '<span class="' . esc_attr($value_class) . '">' . esc_html($value) . '</span>';
                        $output .= '</div>';
                    }
                }

                if (! empty($output)) : ?>
                    <div class="single-product__specs-grid">
                        <?php echo $output; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Дублированная кнопка для мобилок -->
            <button class="single-product__btn ui-btn ui-btn--pink single-product__btn--mobile" type="button" data-graph-path="modal-leadform">Оставить заявку</button>
        </div>
    </div>

    <!-- БЛОК "ТАКЖЕ МОЖЕТ БЫТЬ ИНТЕРЕСНО"  -->
    <div class="single-product__related">
        <h2 class="single-product__related-title sec-title">Также может быть <span class="single-product__related-highlight">интересно</span></h2>
        <ul class="single-product__list">
            <?php
            // Получаем 3 похожих товара (исключая текущий)
            $related_ids = wc_get_related_products($product->get_id(), 3);

            // Если похожих нет – берём 3 случайных товара
            if (empty($related_ids)) {
                $related_ids = wc_get_products([
                    'limit'   => 3,
                    'exclude' => [$product->get_id()],
                    'return'  => 'ids',
                ]);
            }

            foreach ($related_ids as $related_id) :
                // Передаём только ID товара в шаблон card-product
                get_template_part('template-parts/components/card-product', null, ['car' => $related_id]);
            endforeach;
            ?>
        </ul>
    </div>
</div>

<?php get_footer('shop'); ?>
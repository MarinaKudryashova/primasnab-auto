<!-- Карточка для списка статей -->
<?php
$post_id = get_the_ID();
$title = get_the_title();
$permalink = get_permalink();
$excerpt = get_the_excerpt();
$thumbnail = '';

// Проверяем миниатюру (главное изображение)
if (has_post_thumbnail($post_id)) {
    $thumbnail = get_the_post_thumbnail_url($post_id, 'medium');
} else {
    // Если миниатюры нет - ищем первое изображение в блоках ACF
    $blocks = get_field('article_blocks', $post_id);
    if ($blocks && is_array($blocks)) {
        foreach ($blocks as $block) {
            // Для макета "Изображение" с полем image
            if ($block['acf_fc_layout'] === 'image' || $block['acf_fc_layout'] === 'Изображение') {
                if (!empty($block['image'])) {
                    $thumbnail = is_array($block['image']) ? $block['image']['url'] : $block['image'];
                    break;
                }
            }
        }
    }
}

// Если отрывка нет - ищем текст в блоках ACF
if (empty(trim($excerpt))) {
    $blocks = get_field('article_blocks', $post_id);
    if ($blocks && is_array($blocks)) {
        foreach ($blocks as $block) {
            if (($block['acf_fc_layout'] === 'Текст' || $block['acf_fc_layout'] === 'text') && !empty($block['text'])) {
                $excerpt = strip_tags($block['text']);
                break;
            }
        }
    }
}

// Обрезаем текст
if (!empty($excerpt)) {
    $excerpt = wp_trim_words($excerpt, 15, '...');
}
?>

<article class="article-card">
    <a class="article-card__link" href="<?php echo esc_url($permalink); ?>" aria-label="Читать статью: <?php echo esc_attr($title); ?>"></a>

    <div class="article-card__view">
        <?php if ($thumbnail) : ?>
            <picture class="article-card__picture">
                <img class="article-card__img" src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($title); ?>" width="255" height="255" loading="lazy">
            </picture>
        <?php else : ?>
            <div class="article-card__placeholder">
                <span class="article-card__placeholder-icon">📄</span>
            </div>

        <?php endif; ?>
    </div>

    <div class="article-card__info">
        <h3 class="article-card__title"><?php echo esc_html($title); ?></h3>

        <?php if (!empty($excerpt)) : ?>
            <p class="article-card__descr"><?php echo esc_html($excerpt); ?></p>
        <?php endif; ?>
    </div>

    <span class="article-card__btn">Читать</span>
</article>
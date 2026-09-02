<?php
$slide = $args["slide"];
$partner_name = $slide['name'] ?? '';
$partner_logo = $slide['logo'] ?? null;
$partner_link = $slide['link'] ?? '';
$partner_description = $slide['description'] ?? '';
$partner_description_bottom = $slide['description_bottom'] ?? '';

// Безопасная проверка логотипа
$logo_url = '';
if (is_array($partner_logo) && isset($partner_logo['url'])) {
    $logo_url = $partner_logo['url'];
} elseif (is_numeric($partner_logo)) {
    $logo_url = wp_get_attachment_url($partner_logo);
} elseif (is_string($partner_logo) && filter_var($partner_logo, FILTER_VALIDATE_URL)) {
    $logo_url = $partner_logo;
}

// Генерируем уникальный ID для связи карточки и тултипа
$tooltip_id = 'tooltip-' . uniqid();
?>

<div class="card-partners" data-tooltip-id="<?php echo esc_attr($tooltip_id); ?>">
    <?php if ($partner_link) : ?>
        <a href="<?php echo esc_url($partner_link); ?>" class="card-partners__link" target="_blank" rel="nofollow noopener">
        <?php endif; ?>

        <div class="card-partners__content">

            <?php if ($logo_url) : ?>
                <picture class="card-partners__logo">
                    <img
                        src="<?php echo esc_url($logo_url); ?>"
                        alt="<?php echo esc_attr($partner_name); ?>"
                        width="200"
                        height="100"
                        loading="lazy">
                </picture>
            <?php else : ?>
                <span class="card-partners__name card-partners__name--large">
                    <?php echo esc_html($partner_name); ?>
                </span>
            <?php endif; ?>

            <?php if ($partner_description) : ?>
                <div class="card-partners__hover">
                    <span class="card-partners__description"><?php echo esc_html($partner_description); ?></span>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($partner_link) : ?>
        </a>
    <?php endif; ?>
</div>

<!-- ТУЛТИП ВНЕ КАРТОЧКИ (НО ВНУТРИ СЛАЙДА) -->
<?php if ($partner_description_bottom) : ?>
    <div class="card-partners__tooltip" id="<?php echo esc_attr($tooltip_id); ?>">
        <div class="card-partners__tooltip-content">
            <span class="card-partners__tooltip-text"><?php echo esc_html($partner_description_bottom); ?></span>
        </div>
    </div>
<?php endif; ?>
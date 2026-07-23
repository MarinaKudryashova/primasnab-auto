<?php
$page_id = get_the_ID();
$customs_title = get_field('customs_title', $page_id);
$customs_text = get_field('customs_text', $page_id);
$customs_video = get_field('customs_video', $page_id); // ← это просто URL
$customs_video_poster = get_field('customs_video_poster', $page_id);
$customs_steps = get_field('customs_steps', $page_id);
$customs_steps_title = get_field('customs_steps_title', $page_id);

$video_url = $customs_video ?: '';
?>

<!-- ==================== СЕКЦИЯ "ТАМОЖЕННОЕ ОФОРМЛЕНИЕ" ==================== -->
<!-- ==================== СЕКЦИЯ "ТАМОЖЕННОЕ ОФОРМЛЕНИЕ" ==================== -->
<section class="customs-section sec-offset">
    <div class="customs-section__wrapper">
        <div class="customs-section__content">
            <?php if ($customs_text) : ?>
                <div class="customs-section__text">
                    <?php
                    // Заменяем **текст** на <b>текст</b>
                    $formatted_text = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $customs_text);
                    echo wp_kses($formatted_text, array('b' => array()));
                    ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($video_url) : ?>
            <div class="customs-section__image">
                <div class="customs-section__video-wrapper">
                    <?php if ($customs_video_poster) : ?>
                        <img class="customs-section__poster" src="<?php echo esc_url($customs_video_poster['url'] ?? $customs_video_poster); ?>" alt="Превью видео" loading="lazy">
                    <?php else : ?>
                        <div class="customs-section__placeholder">
                            <span>🎬</span>
                        </div>
                    <?php endif; ?>
                    <button class="customs-section__video-btn ui-btn ui-btn--blue"
                        data-video-link="<?php echo esc_url($video_url); ?>">
                        Посмотреть видео
                        <svg width="12" height="14">
                            <use xlink:href="<?php echo get_template_directory_uri(); ?>/img/sprite.svg#icon-caret-right"></use>
                        </svg>
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ==================== ШАГИ ТАМОЖЕННОГО ОФОРМЛЕНИЯ (КАРТОЧКИ) ==================== -->
<?php if ($customs_steps && is_array($customs_steps)) : ?>
    <section class="customs-steps sec-offset">
        <h2 class="customs-steps__title sec-title">
            <?php echo esc_html($customs_steps_title) ?: 'Этапы таможенного оформления'; ?>
        </h2>
        <ul class="customs-steps__list">
            <?php foreach ($customs_steps as $index => $step) : ?>
                <li class="customs-steps__item">
                    <article class="customs-steps__card">
                        <div class="customs-steps__view">
                            <span class="customs-steps__number">
                                <?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?>
                            </span>
                        </div>
                        <div class="customs-steps__info">
                            <h3 class="customs-steps__name"><?php echo esc_html($step['title_steps']); ?></h3>
                            <?php if ($step['list_steps']) :
                                $list_items = explode("\n", trim($step['list_steps']));
                            ?>
                                <ul class="customs-steps__list-items">
                                    <?php foreach ($list_items as $item) : ?>
                                        <?php if (trim($item)) : ?>
                                            <li class="customs-steps__list-item">
                                                <?php echo esc_html(trim($item)); ?>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </article>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>
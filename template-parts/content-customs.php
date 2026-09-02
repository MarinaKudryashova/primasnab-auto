<?php
$page_id = get_the_ID();
$customs_title = get_field('customs_title', $page_id);
$customs_text = get_field('customs_text', $page_id);
$customs_video = get_field('customs_video', $page_id);
$customs_video_poster = get_field('customs_video_poster', $page_id);
$customs_steps = get_field('customs_steps', $page_id);
$customs_steps_title = get_field('customs_steps_title', $page_id);

$video_url = $customs_video ?: '';
?>

<!-- ==================== БЛОК с ЦЕНАМИ И СПИСКОМ ==================== -->
<?php
// Получаем поля
$customs_prices_title = get_field('customs_prices_title', $page_id);
$customs_prices_text = get_field('customs_prices_text', $page_id);
$customs_prices_list = get_field('customs_prices_list', $page_id);

if ($customs_prices_text || ($customs_prices_list && is_array($customs_prices_list))) :
?>
    <section class="customs-prices sec-offset">
        <div class="customs-prices__wrapper">

            <?php if ($customs_prices_title) : ?>
                <h2 class="customs-prices__title sec-title">
                    <?php echo esc_html($customs_prices_title); ?>
                </h2>
            <?php endif; ?>

            <?php if ($customs_prices_text) : ?>
                <div class="customs-prices__text">
                    <?php
                    // Заменяем **текст** на <b>текст</b>
                    $formatted_text = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $customs_prices_text);

                    // Разбиваем на абзацы по переносам строк
                    $paragraphs = explode("\n", trim($formatted_text));
                    foreach ($paragraphs as $paragraph) {
                        if (trim($paragraph)) {
                            echo '<p>' . wp_kses(trim($paragraph), array('b' => array(), 'strong' => array())) . '</p>';
                        }
                    }
                    ?>
                </div>
            <?php endif; ?>

            <?php if ($customs_prices_list && is_array($customs_prices_list)) : ?>
                <ul class="customs-prices__list">
                    <?php foreach ($customs_prices_list as $item) : ?>
                        <li class="customs-prices__item">
                            <span class="customs-prices__item-text">
                                <?php echo wp_kses($item['prices_item'], array(
                                    'a' => array(
                                        'href' => array(),
                                        'class' => array(),
                                        'data-text' => array(),
                                        'title' => array(),
                                        'target' => array(),
                                    ),
                                    'b' => array(),
                                    'strong' => array(),
                                    'br' => array(),
                                )); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        </div>
    </section>
<?php endif; ?>

<!-- ==================== СЕКЦИЯ "ВОЙТИ В ЛИЧНЫЙ КАБИНЕТ" ==================== -->
<?php
$login_title = get_field('customs_login_title', $page_id);
$login_text  = get_field('customs_login_text', $page_id);
$login_list  = get_field('customs_login_list', $page_id);

// Поля для кнопки
$login_button_text = get_field('customs_login_button_text', $page_id);
$login_button_url  = get_field('customs_login_button_url', $page_id);
?>

<?php if ($login_title || $login_text || $login_list || $video_url) : ?>
    <section class="customs-section sec-offset">
        <div class="customs-section__wrapper">

            <div class="customs-section__content">
                <div class="customs-section__text">
                    <?php if ($login_title) : ?>
                        <h2 class="customs-login__title sec-title">
                            <?php echo esc_html($login_title); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ($login_text) : ?>
                        <div class="customs-login__text">
                            <?php
                            $formatted_text = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $login_text);
                            $paragraphs = explode("\n", trim($formatted_text));
                            foreach ($paragraphs as $paragraph) {
                                if (trim($paragraph)) {
                                    echo '<p>' . wp_kses(trim($paragraph), array('b' => array(), 'strong' => array())) . '</p>';
                                }
                            }
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($login_list) : ?>
                        <ul class="customs-login__list">
                            <?php
                            $list_items = explode("\n", trim($login_list));
                            foreach ($list_items as $item) {
                                if (trim($item)) {
                                    $formatted_item = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', trim($item));
                                    echo '<li class="customs-login__item">' . wp_kses($formatted_item, array('b' => array())) . '</li>';
                                }
                            }
                            ?>
                        </ul>
                    <?php endif; ?>

                    <!-- ===== КНОПКА ===== -->
                    <?php
                    if ($login_button_text) :
                        $button_url = !empty($login_button_url) ? esc_url($login_button_url) : '#';
                    ?>
                        <a href="<?php echo $button_url; ?>" class="ui-btn ui-btn--blue customs-login__btn">
                            <?php echo esc_html($login_button_text); ?>
                        </a>
                    <?php endif; ?>
                </div>
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
<?php endif; ?>

<!-- ==================== ШАГИ ТАМОЖЕННОГО ОФОРМЛЕНИЯ (КАРТОЧКИ) ==================== -->
<?php if ($customs_steps && is_array($customs_steps)) : ?>
    <section class="customs-steps sec-offset">
        <h2 class="customs-steps__title sec-title">
            <?php echo esc_html($customs_steps_title) ?: 'Этапы таможенного оформления'; ?>
        </h2>

        <?php if ($customs_text) : ?>
            <div class="customs-section__text">
                <?php
                $formatted_text = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $customs_text);
                $paragraphs = explode("\n", trim($formatted_text));
                foreach ($paragraphs as $paragraph) {
                    if (trim($paragraph)) {
                        echo '<p>' . wp_kses(trim($paragraph), array('b' => array())) . '</p>';
                    }
                }
                ?>
            </div>
        <?php endif; ?>

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
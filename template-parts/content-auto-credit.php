<?php
$page_id = $args ?? get_the_ID();

// ---- Получаем все поля ----
$title = get_field('auto_credit_title', $page_id);
$text_before_list = get_field('auto_credit_text_before_list', $page_id);
$list_bank = get_field('auto_credit_list_bank', $page_id);
$advantages_title = get_field('auto_credit_advantages_title', $page_id);
$advantages_list = get_field('auto_credit_advantages_list', $page_id);
$text_between_lists1 = get_field('auto_credit_text_between_lists-1', $page_id);
$text_between_lists2 = get_field('auto_credit_text_between_lists-2', $page_id);
$list_steps = get_field('auto_credit_list_steps', $page_id);
$text_after = get_field('auto_credit_text_after', $page_id);
$image = get_field('auto_credit_image', $page_id); // URL

// Проверка на наличие хоть какого-то контента
if (!$title && !$text_before_list && !$list_bank && !$advantages_title && !$advantages_list && !$text_between_lists1 && !$text_between_lists2 && !$list_steps && !$text_after && !$image) {
    return;
}
?>

<section class="auto-credit-section sec-offset">
    <div class="auto-credit-section__wrapper">

        <?php if ($title) : ?>
            <h1 class="auto-credit-section__title sec-title">
                <?php echo esc_html($title); ?>
            </h1>
        <?php endif; ?>

        <?php if ($text_before_list) : ?>
            <div class="auto-credit-section__text auto-credit-section__text--before-list">
                <?php
                $formatted_text = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $text_before_list);
                $paragraphs = explode("\n", trim($formatted_text));
                foreach ($paragraphs as $paragraph) {
                    if (trim($paragraph)) {
                        echo '<p>' . wp_kses(trim($paragraph), array('b' => array(), 'strong' => array())) . '</p>';
                    }
                }
                ?>
            </div>
        <?php endif; ?>

        <?php if ($advantages_title || ($advantages_list && is_array($advantages_list))) : ?>
            <div class="auto-credit-section__text auto-credit-section__text--before-list">
                <?php if ($advantages_title) : ?>
                    <p><b><?php echo esc_html($advantages_title); ?></b></p>
                <?php endif; ?>

                <?php if ($advantages_list && is_array($advantages_list)) : ?>
                    <ul class="auto-credit-section__list auto-credit-section__list--unordered">
                        <?php foreach ($advantages_list as $item) : ?>
                            <li class="auto-credit-section__list-item">
                                <?php echo esc_html($item['advantage_item']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php
        // ---- Собираем остальной центральный блок (банки и шаги) ----
        $central_content = '';

        if ($text_between_lists1) {
            $central_content .= '<div class="auto-credit-section__text auto-credit-section__text--between-lists">';
            $formatted_text = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $text_between_lists1);
            $paragraphs = explode("\n", trim($formatted_text));
            foreach ($paragraphs as $paragraph) {
                if (trim($paragraph)) {
                    $central_content .= '<p>' . wp_kses(trim($paragraph), array('b' => array(), 'strong' => array())) . '</p>';
                }
            }
            $central_content .= '</div>';
        }

        if ($list_bank && is_array($list_bank)) {
            $central_content .= '<ul class="auto-credit-section__list auto-credit-section__list--unordered">';
            foreach ($list_bank as $item) {
                $central_content .= '<li class="auto-credit-section__list-item">' . esc_html($item['bank_item']) . '</li>';
            }
            $central_content .= '</ul>';
        }

        if ($text_between_lists2) {
            $central_content .= '<div class="auto-credit-section__text auto-credit-section__text--between-lists">';
            $formatted_text = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $text_between_lists2);
            $paragraphs = explode("\n", trim($formatted_text));
            foreach ($paragraphs as $paragraph) {
                if (trim($paragraph)) {
                    $central_content .= '<p>' . wp_kses(trim($paragraph), array('b' => array(), 'strong' => array())) . '</p>';
                }
            }
            $central_content .= '</div>';
        }

        if ($list_steps && is_array($list_steps)) {
            $central_content .= '<ol class="auto-credit-section__list auto-credit-section__list--ordered">';
            foreach ($list_steps as $item) {
                $central_content .= '<li class="auto-credit-section__list-item">' . esc_html($item['step_item']) . '</li>';
            }
            $central_content .= '</ol>';
        }

        // ---- Форматируем текст после ----
        $after_content = '';
        if ($text_after) {
            $formatted_text = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $text_after);
            $paragraphs = explode("\n", trim($formatted_text));
            $after_content = '<div class="auto-credit-section__text auto-credit-section__text--after">';
            foreach ($paragraphs as $paragraph) {
                if (trim($paragraph)) {
                    $after_content .= '<p>' . wp_kses(trim($paragraph), array('b' => array(), 'strong' => array())) . '</p>';
                }
            }
            $after_content .= '</div>';
        }

        // ---- Объединяем центральный + after ----
        $all_content = $central_content . $after_content;

        // ---- Вывод с картинкой или без ----
        if ($image && !empty($all_content)) : ?>
            <div class="auto-credit-section__columns">
                <div class="auto-credit-section__left">
                    <?php echo $all_content; ?>
                </div>
                <div class="auto-credit-section__right">
                    <img src="<?php echo esc_url($image); ?>" alt="Автокредит" class="auto-credit-section__image">
                </div>
            </div>
        <?php else : ?>
            <?php echo $all_content; ?>
        <?php endif; ?>

    </div>
</section>
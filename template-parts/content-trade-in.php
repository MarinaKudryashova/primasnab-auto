<?php
$page_id = get_the_ID();
$tradeIn_title = get_field('tradein_title', $page_id);
$tradeIn_text = get_field('tradein_text', $page_id);
$tradeIn_steps = get_field('tradein_steps', $page_id);
$tradeIn_steps_title = get_field('tradein_steps_title', $page_id);
$tradeIn_important_items = get_field('tradein_important_items', $page_id);
$tradeIn_important_title = get_field('tradein_important_title', $page_id);
?>

<!-- ==================== ЗАГОЛОВОК СТРАНИЦЫ ==================== -->
<?php if ($tradeIn_title) : ?>
    <h1 class="trade-in-section__title page-title page-title--color">
        <?php echo wp_kses($tradeIn_title, array('span' => array('class' => array()))); ?>
    </h1>
<?php endif; ?>

<section class="trade-in-section sec-offset">
    <!-- <div class="trade-in-section__wrapper"> -->
    <div class="trade-in-section__content">
        <?php if ($tradeIn_text) : ?>
            <div class="trade-in-section__text"><?php echo esc_html($tradeIn_text); ?></div>
        <?php endif; ?>

        <!-- ========== ШАГИ TRADE-IN ========== -->
        <?php if ($tradeIn_steps && is_array($tradeIn_steps)) : ?>
            <h2 class="trade-in-steps__title sec-title" data-aos="fade-up">
                <?php echo esc_html($tradeIn_steps_title); ?>
            </h2>
            <ul class="trade-in-steps">
                <?php foreach ($tradeIn_steps as $index => $step) : ?>
                    <li class="trade-in-steps__item">
                        <div class="trade-in-steps__card">
                            <span class="trade-in-steps__number">
                                <?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?>
                            </span>
                            <span class="trade-in-steps__name">
                                <?php echo esc_html($step['step_title']); ?>
                            </span>
                            <span class="trade-in-steps__text">
                                <?php echo esc_html($step['step_text']); ?>
                            </span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- ========== Важно знать ========== -->
        <?php if ($tradeIn_important_items && is_array($tradeIn_important_items)) : ?>
            <section class="trade-in-important">
                <h2 class="trade-in-important__title sec-title sec-title--center" data-aos="fade-up">
                    <?php echo esc_html($tradeIn_important_title); ?>
                </h2>

                <ul class="trade-in-important__list">
                    <?php foreach ($tradeIn_important_items as $item) :
                        // Проверяем оба варианта
                        if ($item['color'] === 'голубой' || $item['color'] === 'blue') {
                            $color = '#5aa7b9';
                        } else {
                            $color = '#c64994';
                        }
                    ?>
                        <li class="trade-in-important__item">
                            <div class="trade-in-important__card"
                                style="--card-benefits-color: <?php echo $color; ?>">
                                <span class="trade-in-important__text">
                                    <?php echo esc_html($item['text']); ?>
                                </span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>
    </div>
    <!-- </div> -->
</section>
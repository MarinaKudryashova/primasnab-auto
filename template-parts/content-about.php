<?php
$page_id = get_the_ID();
$about_title = get_field('about_title', $page_id);
$about_text = get_field('about_text', $page_id);
$about_benefits = get_field('about_benefits', $page_id);
$about_image = get_field('about_image', $page_id);
?>

<!-- ==================== ЗАГОЛОВОК СТРАНИЦЫ ==================== -->
<?php if ($about_title) : ?>
    <!-- <h1 class="sec-title page-title--about"> -->
    <h1 class="about-section__title page-title page-title--color">
        <?php echo wp_kses($about_title, array('span' => array('class' => array()))); ?>
    </h1>
<?php endif; ?>

<!-- ==================== СЕКЦИЯ "О КОМПАНИИ" ==================== -->
<section class="about-section sec-offset">
    <div class="about-section__wrapper">
        <div class="about-section__content">
            <?php if ($about_text) : ?>
                <div class="about-section__text"><?php echo esc_html($about_text); ?></div>
            <?php endif; ?>

            <?php if ($about_benefits && is_array($about_benefits)) : ?>
                <ul class="about-benefits">
                    <?php foreach ($about_benefits as $index => $benefit) :
                        $color = ($benefit['color'] === 'blue') ? '#5aa7b9' : '#c64994';
                        $reverse = ($index % 2 === 1) ? 'card-benefits--reverse' : '';
                    ?>
                        <li class="about-benefits__item">
                            <div class="card-benefits <?php echo $reverse; ?>" style="--card-benefits-color: <?php echo $color; ?>">
                                <span class="card-benefits__name"><?php echo esc_html($benefit['name']); ?></span>
                                <span class="card-benefits__text"><?php echo esc_html($benefit['text']); ?></span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <?php if ($about_image) : ?>
            <div class="about-section__image">
                <picture class="about-section__picture">
                    <?php
                    $webp_url = get_field('about_image_webp', $page_id);
                    if ($webp_url) :
                    ?>
                        <source srcset="<?php echo esc_url($webp_url); ?>" type="image/webp">
                    <?php endif; ?>
                    <img
                        class="about-section__img"
                        loading="lazy"
                        src="<?php echo esc_url($about_image); ?>"
                        width="670"
                        height="625"
                        alt="Мужчины смотрят в телефоны и планшеты">
                </picture>
            </div>
        <?php else : ?>
            <div class="about-section__image">
                <picture class="about-section__picture">
                    <source srcset="<?php echo get_template_directory_uri(); ?>/img/contacts/about_image.webp" type="image/webp">
                    <img
                        class="about-section__img"
                        loading="lazy"
                        src="<?php echo get_template_directory_uri(); ?>/img/contacts/about_image.jpg"
                        width="670"
                        height="625"
                        alt="Мужчины смотрят в телефоны и планшеты">
                </picture>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ==================== СЕКЦИЯ "КОМАНДА ПРОФЕССИОНАЛОВ" ==================== -->
<?php
$team_title = get_field('team_title', $page_id);
$team_profi = get_field('team_profi', $page_id);
if ($team_profi && is_array($team_profi)) :
?>
    <section class="team-section sec-offset">
        <h1 class="team-section__title sec-title"><?php echo esc_html($team_title); ?></h1>
        <ul class="team-section__list">
            <?php foreach ($team_profi as $index => $member) : ?>
                <li class="team-section__item">
                    <article class="team-card">
                        <?php if ($index === 0) : ?>
                            <!-- <h3 class="team-card__sticker">
                                <span>Самый главный</span>
                            </h3> -->
                        <?php endif; ?>
                        <div class="team-card__view">
                            <?php
                            $photo_url = !empty($member['photo']) ? $member['photo'] : '';
                            $photo_img = !empty($photo_url) ? get_image_versions($photo_url) : null;
                            ?>
                            <?php if ($photo_img) : ?>
                                <picture>
                                    <source srcset="<?php echo esc_url($photo_img['webp_1x']); ?>" type="image/webp">
                                    <img
                                        class="team-card__img"
                                        loading="lazy"
                                        src="<?php echo esc_url($photo_img['original_1x']); ?>"
                                        width="400"
                                        height="460"
                                        alt="<?php echo esc_attr($member['name']); ?>">
                                </picture>
                            <?php else : ?>
                                <div class="team-card__view--placeholder">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/team-placeholder.jpg" alt="Фото сотрудника">
                                </div>
                            <?php endif; ?>

                        </div>
                        <div class="team-card__info">
                            <h3 class="team-card__name"><?php echo esc_html($member['name']); ?></h3>
                            <span class="team-card__position"><?php echo esc_html($member['position']); ?></span>
                        </div>
                    </article>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>
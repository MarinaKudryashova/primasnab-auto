<?php 
$page_id = $args["id"];
$sec_name = $args["name"]["value"];

// Ссылки для соцсетей из страницы опций
$telegram_link = get_field('telegram', 'option');
$vk_link = get_field('vk', 'option');
$youtube_link = get_field('youtube', 'option');

// Значение по умолчанию если поля пустые
$telegram_link = !empty($telegram_link) ? $telegram_link : 'https://t.me/';
$vk_link = !empty($vk_link) ? $vk_link : 'https://vk.com/';
$youtube_link = !empty($youtube_link) ? $youtube_link : 'https://www.youtube.com/';

// Остальные поля секции
$title = get_field($sec_name . '_title', $page_id);
$descr = get_field($sec_name . '_descr', $page_id);
$left_image = get_field($sec_name . '_image', $page_id);
$right_image = get_field($sec_name . '_right-image', $page_id);
$right_text = get_field($sec_name . '_right_text', $page_id);

// Значение по умолчанию если поля пустые
$title = !empty($title) ? $title : 'Мы в соцсетях';
$descr = !empty($descr) ? $descr : 'Подписывайтесь и узнавайте первыми о новостях компании';
$right_text = !empty($right_text) ? $right_text : 'Автоновости, обзоры на самые крутые авто, полезная информация в наших социальных сетях';
?>

<section class="social-follow sec-offset">
  <div class="container">
      <div class="social-follow__wrap">
        <div class="social-follow__content">
          <div class="social-follow__content-up">
            <h2 class="social-follow__title sec-title" data-aos="fade-up">
              <?php echo esc_html($title); ?>
            </h2>
            <span class="social-follow__descr">
              <?php echo esc_html($descr); ?>
            </span>
          </div>

          <div class="social-follow__left">
            <div class="social-follow__image">
              <picture class="social-follow__picture">
                <?php if(!empty($left_image) && !empty($left_image['url'])) : ?>
                <img
                  class="social-follow__img"
                  src="<?php echo esc_url($left_image['url']); ?>"
                  alt="Телефон"
                  width="619"
                  height="619"
                />
                <?php else : ?>
                  <img
                    class="social-follow__img"
                    src="<?php echo get_template_directory_uri(); ?>/img/banner-social-tel.png"
                    alt="Телефон"
                    width="619"
                    height="619"
                  />
                <?php endif; ?>
              </picture>
            </div>

            <div class="social-follow__var">
              <ul class="social-follow__messanger messanges" title="messanges">
                  <li class="messanges__item">
                    <a href="<?php echo esc_url($telegram_link); ?>" target="_blank" class="messanges__link" aria-label="Telegram">
                    <img src="/wp-content/themes/primasnab/img/icon/Telegram-banner.svg" class="messanges__icon" width="95" height="96" alt="иконка Telegram">
                    </a>
                  </li>
                  <li class="messanges__item">
                    <a href="<?php echo esc_url($vk_link); ?>" target="_blank" class="messanges__link" aria-label="VK">
                    <img src="/wp-content/themes/primasnab/img/icon/VK-banner.svg" class="messanges__icon" width="95" height="96" alt="иконка VK">
                    </a>
                  </li>
                  <li class="messanges__item">
                    <a href="<?php echo esc_url($youtube_link); ?>" target="_blank" class="messanges__link" aria-label="YouTube">
                    <img src="/wp-content/themes/primasnab/img/icon/YouTube-banner.svg" class="messanges__icon" width="95" height="96" alt="иконка YouTube">
                    </a>
                  </li>
              </ul>
            </div>
          </div>

          <img
            src="/wp-content/themes/primasnab/img/icon/icon-bell.svg"
            class="social-follow__left-icon"
            width="115"
            height="115"
            alt="иконка колокольчика"
          />
        </div>

        <div class="social-follow__right">
          <?php if(!empty($right_image) && !empty($right_image['url'])) : ?>
            <img
              class="social-follow__right-image"
              src="<?php echo esc_url($right_image['url']); ?>"
              alt="Двое мужчин разговаривают"
              width="780"
              height="784"
              loading="lazy"
            />
            <?php else : ?>
            <img
              class="social-follow__right-image"
              src="<?php echo get_template_directory_uri(); ?>/img/social-follow.png"
              alt="Двое мужчин разговаривают"
              width="780"
              height="784"
              loading="lazy"
            />
          <?php endif; ?>
          <div class="social-follow__right-inner">
            <img
            src="/wp-content/themes/primasnab/img/icon/post_contact.svg" class="social-follow__right-icon" width="69" height="69" alt="иконка конверта"
              class="social-follow__right-icon"
              width="69"
              height="69"
              alt="иконка конверта"
            />
            <p class="social-follow__right-text">
              <?php echo esc_html($right_text); ?>
            </p>
          </div>
        </div>
      </div>

        <div class="social-follow__right-inner social-follow__right-inner--mobile">
            <img
            src="/wp-content/themes/primasnab/img/icon/post_contact.svg" class="social-follow__right-icon" width="69" height="69" alt="иконка конверта"
              class="social-follow__right-icon"
              width="69"
              height="69"
              alt="иконка конверта"
            />
            <p class="social-follow__right-text">
              <?php echo esc_html($right_text); ?>
            </p>
          </div>

        <div class="social-follow__var social-follow__var--mobile">
              <ul class="social-follow__messanger messanges" title="messanges">
                <li class="messanges__item">
                  <a href="<?php echo esc_url($telegram_link); ?>" target="_blank" class="messanges__link" aria-label="Telegram">
                  <img src="/wp-content/themes/primasnab/img/icon/Telegram-banner.svg" class="messanges__icon" width="95" height="96" alt="иконка Telegram">
                  </a>

                </li>
                <li class="messanges__item">
                  <a href="<?php echo esc_url($vk_link); ?>" target="_blank" class="messanges__link" aria-label="VK">
                  <img src="/wp-content/themes/primasnab/img/icon/VK-banner.svg" class="messanges__icon" width="95" height="96" alt="иконка VK">
                  </a>
                </li>
                <li class="messanges__item">
                  <a href="<?php echo esc_url($youtube_link); ?>" target="_blank" class="messanges__link" aria-label="YouTube">
                  <img src="/wp-content/themes/primasnab/img/icon/YouTube-banner.svg" class="messanges__icon" width="95" height="96" alt="иконка YouTube">
                  </a>
                </li>
              </ul>
        </div>
  </div>
</section>
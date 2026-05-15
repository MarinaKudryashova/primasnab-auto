<?php 
$page_id = $args["id"];
$sec_name = $args["name"]["value"];

// Ссылки для соцсетей из страницы опций
$telegram_link = get_field('telegram', 'option');
$vk_link = get_field('vk', 'option');
$youtube_link = get_field('youtube', 'option');

// Остальные поля секции
$field_title = $sec_name . '_title';
$title = get_field($field_title, $page_id);

$field_descr = $sec_name . '_descr';
$descr = get_field($field_descr, $page_id);

$field_left_image_url = $sec_name . '_image';
$left_image_url = get_field($field_left_image_url, $page_id)['url'] ?? '';

$field_right_image_url = $sec_name . '_right-image';
$right_image_url = get_field($field_right_image_url, $page_id)['url'] ?? '';

$field_right_text = $sec_name . '_right-text';
$right_text = get_field($field_right_text, $page_id);

// Получаем версии изображений через get_image_versions
$left_image = !empty($left_image_url) ? get_image_versions($left_image_url) : null;
$right_image = !empty($right_image_url) ? get_image_versions($right_image_url) : null;

?>

<section class="social-follow sec-offset">
  <div class="container">
      <div class="social-follow__content">
            <div class="social-follow__left">
                <h2 class="social-follow__title sec-title" data-aos="fade-up">
                  <?php echo esc_html($title); ?>
                </h2>
                <span class="social-follow__descr">
                  <?php echo esc_html($descr); ?>
                </span>
                <div class="social-follow__wrap">
                      <div class="social-follow__image">
                            <?php if($left_image) : ?>
                                    <picture class="social-follow__picture">
                                      <source srcset="<?php echo esc_url($left_image['webp_1x']); ?>" type="image/webp">
                                      <img 
                                        class="social-follow__img"
                                        loading="lazy" 
                                        src="<?php echo esc_url($left_image['original_1x']); ?>" 
                                        width="619" 
                                        height="619" 
                                        alt="Телефон"
                                      >
                                    </picture>
                                  <?php else : ?>
                                    <picture class="social-follow__picture">
                                      <!-- <source srcset="<?php echo get_template_directory_uri(); ?>/img/banner-social-tel.webp" type="image/webp"> -->
                                      <img 
                                        class="social-follow__img"
                                        loading="lazy" 
                                        src="<?php echo get_template_directory_uri(); ?>/img/banner-social-tel.png" 
                                        width="619" 
                                        height="619" 
                                        alt="Телефон"
                                      >
                                    </picture>
                              <?php endif; ?>
                      </div>
                          <div class="social-follow__var">
                              <ul class="social-follow__messanger messanges" title="messanges">
                                  <li class="messanges__item">
                                    <a href="<?php echo esc_url($telegram_link); ?>" target="_blank" class="messanges__link" aria-label="Telegram">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/icon/Telegram-banner.svg" class="messanges__icon" width="95" height="96" alt="иконка Telegram">
                                    </a>
                                  </li>
                                  <li class="messanges__item">
                                    <a href="<?php echo esc_url($vk_link); ?>" target="_blank" class="messanges__link" aria-label="VK">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/icon/VK-banner.svg" class="messanges__icon" width="95" height="96" alt="иконка VK">
                                    </a>
                                  </li>
                                  <li class="messanges__item">
                                    <a href="<?php echo esc_url($youtube_link); ?>" target="_blank" class="messanges__link" aria-label="YouTube">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/icon/YouTube-banner.svg" class="messanges__icon" width="95" height="96" alt="иконка YouTube">
                                    </a>
                                  </li>
                              </ul>
                          </div>
                            <img
                                src="<?php echo get_template_directory_uri(); ?>/img/icon/icon-bell.svg"
                                class="social-follow__left-icon"
                                width="115"
                                height="115"
                                alt="иконка колокольчика"
                              />
                    </div>
            </div>


            <div class="social-follow__right">
                    <?php if($right_image) : ?>
                    <picture class="social-follow__right-picture">
                      <source srcset="<?php echo esc_url($right_image['webp_1x']); ?>" type="image/webp">
                      <img 
                        class="social-follow__right-image"
                        loading="lazy" 
                        src="<?php echo esc_url($right_image['original_1x']); ?>" 
                        width="780" 
                        height="784" 
                        alt="Двое мужчин разговаривают"
                      >
                    </picture>
                  <?php else : ?>
                    <picture class="social-follow__right-picture">
                      <img 
                        class="social-follow__right-image"
                        loading="lazy" 
                        src="<?php echo get_template_directory_uri(); ?>/img/social-follow.png" 
                        width="780" 
                        height="784" 
                        alt="Двое мужчин разговаривают"
                      >
                    </picture>
                  <?php endif; ?>
                          <?php if(!empty($right_text)) : ?>
                              <div class="social-follow__right-inner">
                                    <img
                                    src="<?php echo get_template_directory_uri(); ?>/img/icon/post_contact.svg"
                                      class="social-follow__right-icon"
                                      width="69"
                                      height="69"
                                      alt="иконка конверта"
                                    />
                                    <p class="social-follow__right-text">
                                      <?php echo esc_html($right_text); ?>
                                    </p>
                              </div>
                        <?php endif; ?>
            </div>
              

              <?php if(!empty($right_text)) : ?>
                    <div class="social-follow__right-inner--mobile">
                        <img
                          src="<?php echo get_template_directory_uri(); ?>/img/icon/post_contact.svg"
                          class="social-follow__right-icon"
                          width="69"
                          height="69"
                          alt="иконка конверта"
                          />
                            <p class="social-follow__right-text">
                              <?php echo esc_html($right_text); ?>
                            </p>
                      </div>
                <?php endif; ?>
             <div class="social-follow__var--mobile">
                  <ul class="social-follow__messanger messanges" title="messanges">
                    <li class="messanges__item">
                      <a href="<?php echo esc_url($telegram_link); ?>" target="_blank" class="messanges__link" aria-label="Telegram">
                      <img src="<?php echo get_template_directory_uri(); ?>/img/icon/Telegram-banner.svg" class="messanges__icon" width="95" height="96" alt="иконка Telegram">
                      </a>

                    </li>
                    <li class="messanges__item">
                      <a href="<?php echo esc_url($vk_link); ?>" target="_blank" class="messanges__link" aria-label="VK">
                      <img src="<?php echo get_template_directory_uri(); ?>/img/icon/VK-banner.svg" class="messanges__icon" width="95" height="96" alt="иконка VK">
                      </a>
                    </li>
                    <li class="messanges__item">
                      <a href="<?php echo esc_url($youtube_link); ?>" target="_blank" class="messanges__link" aria-label="YouTube">
                      <img src="<?php echo get_template_directory_uri(); ?>/img/icon/YouTube-banner.svg" class="messanges__icon" width="95" height="96" alt="иконка YouTube">
                      </a>
                    </li>
                  </ul>
            </div>
      </div>

      </div>

           
           
  </div>
</section>
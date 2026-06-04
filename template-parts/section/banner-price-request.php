<?php
/**
 * Секция "Запрос цены" – форма + контакты для быстрой связи
 *
 * @package primasnab
 */

$page_id = $args['id'] ?? 0;
$sec_name = $args['name']['value'] ?? 'banner-price-request'; // префикс полей

// Получаем поля из опций ACF (можно также из конкретной страницы, если нужно)
$title = get_field($sec_name . '_title', 'option');
$form_shortcode = get_field($sec_name . '_shortkod', 'option');
$image_url = get_field($sec_name . '_image', 'option');
$image = !empty($image_url) ? get_image_versions($image_url) : null;

// Поля для контактов
$phone_text = get_field($sec_name . '_phone-text', 'option');
$phone = get_field($sec_name . '_phone', 'option');
// $messengers = get_field($sec_name . '_messengers', 'option'); // повторитель с иконками и ссылками

// Если нет заголовка, нет формы и нет картинки – ничего не выводим
// if (empty($title) && empty($form_shortcode) && empty($image) && empty($phone)) {
//     return;
// }
?>

<section class="banner-price-request sec-offset">
    <div class="container">
        <div class="banner-price-request__wrap">

            <!-- ЛЕВАЯ ЧАСТЬ: форма + контакты (2 колонки) -->
            <div class="banner-price-request__content">

                <?php if (!empty($title)) : ?>
                    <div class="banner-price-request__title-wrapper">
                        <h2 class="banner-price-request__title sec-title" data-aos="fade-up">
                            <?php echo esc_html($title); ?>
                        </h2>
                    </div>
                <?php endif; ?>

                <div class="banner-price-request__inner">
                    <!-- Левая колонка – форма -->
                    <?php if (!empty($form_shortcode)) : ?>
                        <div class="banner-price-request__form-col">
                            <?php echo do_shortcode($form_shortcode); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Правая колонка – блок "Для быстрой связи" -->
                    <div class="banner-price-request__contact-col">
                      <div class="banner-price-request__fast-contact">
                          <?php if (!empty($phone)) : ?>
                              <div class="banner-price-request__phone">
                                  <span class="banner-price-request__label"><?php echo esc_html($phone_text); ?></span>
                                  <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="banner-price-request__phone-link">
                                      <?php echo esc_html($phone); ?>
                                  </a>
                              </div>
                          <?php endif; ?>

                          <!-- Иконки мессенджеров (статические) -->
                          <ul class="banner-price-request__messengers messanges">
                              <li class="banner-price-request__messenger-item">
                                  <a href="https://t.me/primasnabavto" target="_blank" class="banner-price-request__messenger-link">
                                      <img src="<?php echo get_template_directory_uri(); ?>/img/icon/telegram.svg" alt="Telegram" width="40" height="40">
                                  </a>
                              </li>
                              <li class="banner-price-request__messenger-item">
                                  <a href="https://wa.me/79175487878" target="_blank" class="banner-price-request__messenger-link">
                                      <img src="<?php echo get_template_directory_uri(); ?>/img/icon/whatsapp.svg" alt="WhatsApp" width="40" height="40">
                                  </a>
                              </li>
                          </ul>
                      </div>
                    </div>
                </div>
            </div>

            <!-- ПРАВАЯ ЧАСТЬ – картинка -->
            <?php if(!empty($image) && is_array($image)) : ?>
          <div class="banner-price-request__image">
            <picture class="banner-price-request__picture">
              <img 
                class="banner-price-request__img"
                src="<?php echo esc_url($image ["original_1x"]); ?>"
                alt="<?php echo !empty($image['alt']) ? esc_attr($image['alt']) : esc_attr($title); ?>"
                width="412"
                height="405"
                loading="lazy"
              />
            </picture>
          </div>
        <?php endif; ?>

        </div>
    </div>
</section>

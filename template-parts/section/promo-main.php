<?php
  $page_id = $args["id"];
  
  // $promo_title = get_field('promo_bgimg', $page_id);
  $promo_bgimg_desktop = get_image_versions(get_field('promo_bgimg'));
  $promo_title = get_field('promo_title', $page_id);
  $promo_descr = get_field('promo_descr', $page_id);
  $promo_usp = get_field('promo_benefits_list', $page_id);
  $promo_benefits = get_field('promo_benefits', $page_id);

  $promo_shortkod = get_field('promo_shortkod', $page_id);
?>

<section class="promo sec-offset">
  <picture class="promo__bgimg">
    <?php if (!empty($promo_bgimg_desktop['webp_1x'])): ?>
      <source srcset="<?php echo esc_url($promo_bgimg_desktop['webp_1x']); ?>" type="image/webp">
    <?php endif; ?>
    <img src="<?php if (!empty($promo_bgimg_desktop['original_1x'])) : echo esc_url($promo_bgimg_desktop['original_1x']); else : echo esc_url(get_template_directory_uri() . '/img/promo/promo-desktop.jpg'); endif; ?>" width="1440" height="702" alt="<?php if (!empty($promo_bgimg_desktop['alt'])) : echo esc_attr($promo_bgimg_desktop['alt']); else : echo 'Фоновое изоражение'; endif; ?>" loading="eager" decoding="async" fetchpriority="high">
  </picture>

  <div class="promo__container container">
    <div class="promo__content">
      <?php if(!empty($promo_title)) : ?>
      <h1 class="promo__title page-title"><?php echo esc_html($promo_title) ?></h1>
      <?php endif; ?>
  
      <?php if(!empty($promo_descr)) : ?>
      <p class="promo__descr"><?php echo esc_html($promo_descr) ?></p>
      <?php endif; ?>
    </div>
    <div class="promo__form promo-form">
      <!-- Выводим форму через шорткод CF7 -->
      <?php if(!empty($promo_shortkod)) : ?>
      <div class="promo-form__content">
        <?php echo do_shortcode($promo_shortkod); ?>
          <!-- <form action="#">
            <div class="form__content">
            <div class="form__field form-field">
              <input type="text" class="form-field__input" name="carsMark" id="carsMark" placeholder="Марка/модель" aria-label="Введите марку/модель">
              <button type="button" value="" class="form-field__clear-reset" aria-label="Очистить поле"></button>
            </div>
            <div class="form__field form-field form-field--required">
              <input type="text" class="form-field__input" name="budget" id="budget" placeholder="Бюджет" aria-label="Введите ваш бюджет">
              <button type="button" value="" class="form-field__clear-reset" aria-label="Очистить поле"></button>
            </div>
            <div class="form__field form-field form-field--required">
              <input type="tel" class="form-field__input" name="tel" id="tel" placeholder="Телефон" required aria-label="Введите ваш телефон" autocomplete="tel">
              <button type="button" value="" class="form-field__clear-reset" aria-label="Очистить поле"></button>
            </div>
  
            <div class="form__control">
              <button type="submit" class="form__btn ui-btn ui-btn--blue">Рассчитать стоимость</button>
              <div class="form-argee">
                <label>
                  <input class="form-argee__input" type="checkbox" name="agree" id="modal-agree" value="0" required aria-invalid="false">
                  <span class="wpcf7-list-item-label">Нажимая на кнопку, вы даёте <a href="privacy-policy" target="_blank" rel="nofollow">согласие на обработку персональных данных</a></span>          
                </label>
              </div>
              <div class="form__status visually-hidden" aria-live="polite"></div>
            </div>
          </div>
        </form> -->
      </div>
      <?php endif; ?>

      <div class="promo-form__img"></div>
    </div>

    <?php if(!empty($promo_usp) && is_array($promo_usp)) : ?>
    <ul class="promo__usp">
      <?php foreach($promo_usp as $usp) : ?>
      <li class="promo__usp-item"><?php echo $usp["text"]; ?></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <?php if(!empty($promo_benefits) && is_array($promo_benefits)) : ?>
    <ul class="promo__benefits">
      <?php foreach($promo_benefits as $benefit) : ?>
      <li class="promo__benefits-item">
        <?php get_template_part('template-parts/components/card-benefits', null, ['id' => $page_id, 'benefit' => $benefit]); ?>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </div>
</section>
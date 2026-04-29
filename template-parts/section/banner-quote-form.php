<?php 
  $page_id = $args["id"];
  $sec_name = $args["name"]["value"];

  // Получаем поля из админки
  $title = get_field($sec_name . '_title', $page_id);
  $image = get_field($sec_name . '_image', $page_id);
  $form_shortcode = get_field($sec_name . '_form', $page_id);

  // Если нет заголовка, нет формы и нет картинки - ничего не выводится
if(empty($title) && empty($form_shortcode) && empty($image)) {
  return;
}
?>


<section class="banner-quote-form sec-offset">
  <div class="container">
    <div class="banner-quote-form__wrap">
      <!-- <div class="banner-quote-form__block"> -->
      <!-- Левая часть с формой -->
      <div class="banner-quote-form__content">

       <!-- Обёртка для заголовка с фоном на всю ширину -->
        <?php if(!empty($title)) : ?>
        <div class="banner-quote-form__title-wrapper">
          <h2 class="banner-quote-form__title sec-title" data-aos="fade-up">
           <?php echo esc_html($title); ?>
          </h2>
        </div>
        <?php endif; ?>
        

       <!-- Выводим форму через шорткод CF7 -->

        <?php if(!empty($form_shortcode)) : ?>
          <?php echo do_shortcode($form_shortcode); ?>
        <?php endif; ?>
      </div>

      <!-- Правая часть с картинкой -->
        <?php if(!empty($image) && !empty($image['url'])) : ?>
          <div class="banner-quote-form__image">
            <picture class="banner-quote-form__picture">
              <img 
                class="banner-quote-form__img"
                src="<?php echo esc_url($image['url']); ?>"
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
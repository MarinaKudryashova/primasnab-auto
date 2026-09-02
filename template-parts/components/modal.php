<?php
// Получаем поля из админки
$title = get_field('modal-leadform_title', 'option');
$text = get_field('modal-leadform_text', 'option');
$form_shortcode = get_field('modal-leadform_shortkod', 'option');

// Если нет заголовка, нет формы и нет картинки - ничего не выводится
if (empty($title) && empty($form_shortcode)) {
  return;
}
?>


<div class="graph-modal">
  <div class="graph-modal__container" role="dialog" aria-modal="true" data-graph-target="modal-leadform">
    <button class="btn-reset js-modal-close graph-modal__close" aria-label="Закрыть модальное окно">
      <!-- <svg>
        <use xlink:href="<?php echo get_template_directory_uri(); ?>/img/sprite.svg#close"></use>
      </svg> -->
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18" stroke="currentColor"></line>
        <line x1="6" y1="6" x2="18" y2="18" stroke="currentColor"></line>
      </svg>
    </button>
    <div class="graph-modal__content form">
      <h2 class="form__title"><?php echo esc_html($title); ?></h2>
      <?php if (!empty($text)) : ?>
        <p class="form__descr"><?php echo esc_html($text); ?></p>
      <?php endif; ?>
      <!-- Выводим форму через шорткод CF7 -->
      <?php if (!empty($form_shortcode)) : ?>
        <?php echo do_shortcode($form_shortcode); ?>
      <?php endif; ?>
    </div>
  </div>
</div>
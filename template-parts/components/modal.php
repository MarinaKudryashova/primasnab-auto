<div class="graph-modal">
  <div class="graph-modal__container" role="dialog" aria-modal="true" data-graph-target="modal-leadform">
    <button class="btn-reset js-modal-close graph-modal__close" aria-label="Закрыть модальное окно">
      <!-- <svg>
        <use xlink:href="<?php echo get_template_directory_uri();?>/img/sprite.svg#close"></use>
      </svg> -->
       <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
       </svg>
    </button>
    <div class="graph-modal__content form">
      <?php if( have_rows( 'modal_leadform', 'option') ): ?>
      <?php while( have_rows( 'modal_leadform', 'option') ): the_row(); ?>
        <?php
          $title = get_sub_field('title', 'options');
          $title = explode(PHP_EOL, $title);
        ?>
      <h2 class="form__title">
        <span><?php echo esc_html( $title[0] ); ?></span>
        <span><?php echo esc_html( $title[1] ); ?></span>
      </h2>
      <p class="form__descr"><?php echo esc_html(get_sub_field('text', 'option')); ?></p>
      <?php echo do_shortcode( get_sub_field('form_shortcode', 'option') ); ?>
    </div>
    <?php endwhile; ?>
    <?php endif; ?> 
  </div>
</div>
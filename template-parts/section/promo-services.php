<?php
/* 
* Section: Промо (услуги)
*/

  $page_id = $args["id"];
  
  $services_promo_country = get_field('services_promo_country', $page_id);
  // $dir_country_name = get_term($services_promo_country)->name;
  $services_thumbnail_id = get_term_meta( $services_promo_country, 'thumbnail_id', true );
  $services_flag_url = $services_thumbnail_id ? wp_get_attachment_image_url( $services_thumbnail_id, 'full' ) : '#';

  $services_promo_bgimg_url = get_field('services_promo_bgimg', $page_id);
  $services_promo_bgimg = $services_promo_bgimg_url ? get_image_versions($services_promo_bgimg_url) : null;

  $services_promo_title = get_field('services_promo_title', $page_id);
  $services_promo_descr = get_field('services_promo_descr', $page_id);
  $services_promo_shortkod = get_field('services_promo_shortkod', $page_id);

  $services_promo_usp = get_field('services_promo_benefits_list', $page_id);

?>

<section class="promo-services sec-offset">
  <picture class="promo__bgimg">
    <?php if (!empty($services_promo_bgimg['webp_1x'])): ?>
      <source srcset="<?php echo esc_url($services_promo_bgimg['webp_1x']); ?>" type="image/webp">
    <?php endif; ?>
    <img src="<?php if (!empty($services_promo_bgimg['original_1x'])) : echo esc_url($services_promo_bgimg['original_1x']); else : echo esc_url(get_template_directory_uri() . '/img/promo/promo-desktop.jpg'); endif; ?>" width="1440" height="702" alt="<?php if (!empty($services_promo_bgimg['alt'])) : echo esc_attr($services_promo_bgimg['alt']); else : echo 'Фоновое изоражение'; endif; ?>" loading="eager" decoding="async" fetchpriority="high">
  </picture>
  
  <div class="container">
    <?php get_template_part("template-parts/components/breadcrumbs", "", $page_id); ?>

    <div class="promo-services__container">
      <div class="promo-services__content">
        <?php if(!empty($services_promo_title)) : ?>
        <h1 class="promo-services__title page-title page-title--color">
          <?php echo wp_kses_post($services_promo_title) ?>
          <img src="<?php echo esc_url($services_flag_url); ?>" class="promo-services__flag" width="77" height="77" alt="" aria-hidden="true">
        </h1>
        <?php endif; ?>
    
        <?php if(!empty($services_promo_descr)) : ?>
        <p class="promo-services__descr"><?php echo esc_html($services_promo_descr) ?></p>
        <?php endif; ?>

        <?php if(!empty($services_promo_usp) && is_array($services_promo_usp)) : ?>
        <ul class="promo-services__usp usp">
          <?php foreach($services_promo_usp as $usp) : 
          ?>
          <li class="usp__item" style="--usp-color:<?php echo !empty($usp["color"]) ? $usp["color"] : 'var(--accent-pink)'; ?>"><?php echo $usp["text"]; ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      </div>
      <div class="promo-services__form promo-form">
        <!-- Выводим форму через шорткод CF7 -->
        <?php if(!empty($services_promo_shortkod)) : ?>
        <div class="promo-form__content">
          <?php echo do_shortcode($services_promo_shortkod); ?>
        </div>
        <?php endif; ?>

        <div class="promo-form__img"></div>
      </div>
    </div>
  </div>
</section>
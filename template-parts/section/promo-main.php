<?php
  $page_id = $args["id"];
  
  // $promo_title = get_field('promo_bgimg', $page_id);
  $promo_bgimg_desktop = get_image_versions(get_field('promo_bgimg'));
  $promo_title = get_field('promo_title', $page_id);
  $promo_descr = get_field('promo_descr', $page_id);
  $promo_usp = get_field('promo_benefits_list', $page_id);
  $promo_benefits = get_field('promo_benefits', $page_id);
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
      <h1 class="promo__title"><?php echo esc_html($promo_title) ?></h1>
      <?php endif; ?>
  
      <?php if(!empty($promo_descr)) : ?>
      <p class="promo__descr"><?php echo esc_html($promo_descr) ?></p>
      <?php endif; ?>
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
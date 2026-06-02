<?php
/* 
* Section: Почему выбирают
*/

  $page_id = $args["id"];
  $sec_name = $args["name"]["value"];
  
  $services_country = get_field('services_promo_country', $page_id);
  $services_thumbnail_id = get_term_meta( $services_country, 'thumbnail_id', true );
  $services_flag_url = $services_thumbnail_id ? wp_get_attachment_image_url( $services_thumbnail_id, 'full' ) : '#';

  $field_title = $sec_name . "_title";
  $field_descr = $sec_name . "_descr";
  $field_bgimg = $sec_name . "_bgimg";
  $field_list = $sec_name . "_list";

  $why_choose_title = get_field($field_title, $page_id);
  $why_choose_descr = get_field($field_descr, $page_id);
  $why_choose_bgimg_url = get_field($field_bgimg, $page_id);
  $why_choose_bgimg = $why_choose_bgimg_url ? get_image_versions($why_choose_bgimg_url) : null;
  $why_choose_list = get_field($field_list, $page_id);
?>

<section class="why-choose sec-offset">
  <div class="container">
    <?php if($why_choose_title) : ?>
      <h2 class="why-choose__title sec-title" data-aos="fade-up">
        <?php echo $why_choose_title; ?>
        <img src="<?php echo esc_url($services_flag_url); ?>" class="why-choose__flag" width="77" height="77" alt="Флаг страны" aria-hidden="true">
      </h2>
    <?php endif; ?>

    <div class="why-choose__content">
      <?php if(!empty($why_choose_list) && is_array($why_choose_list)) : ?>
      <ul class="why-choose__list">
        <?php foreach($why_choose_list as $item) : ?>
          <li class="why-choose__item"style="--choose-color:<?php echo !empty($item["color"]) ? $item["color"] : 'var(--accent-blue)'; ?>"><?php echo $item["text"]; ?></li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>

      <?php if($why_choose_descr) : ?>
      <div class="why-choose__inner">

        
        <?php if(!empty($why_choose_bgimg) && is_array($why_choose_bgimg)) : ?>
        <picture class="why-choose__bgimg">
          <?php if (!empty($why_choose_bgimg['webp_1x'])): ?>
            <source srcset="<?php echo esc_url($why_choose_bgimg['webp_1x']); ?>" type="image/webp">
          <?php endif; ?>
          <img src="<?php echo esc_url($why_choose_bgimg['original_1x']); ?>" width="440" height="377" alt="<?php if (!empty($why_choose_bgimg['alt'])) : echo esc_attr($promo_bgimg_desktop['alt']); else : echo 'Фоновое изоражение'; endif; ?>" loading="lazy">
        </picture>
        <?php endif; ?>
        
        <div class="why-choose__descr"><?php echo $why_choose_descr; ?></div>


      </div>
      <?php endif; ?>
    </div>

  </div>
</section>
<?php
/* 
* Section: Как привозим
*/

  $page_id = $args["id"];
  $sec_name = $args["name"]["value"];
  
  $services_country = get_field('services_promo_country', $page_id);
  $services_thumbnail_id = get_term_meta( $services_country, 'thumbnail_id', true );
  $services_flag_url = $services_thumbnail_id ? wp_get_attachment_image_url( $services_thumbnail_id, 'full' ) : '#';

  $field_title = $sec_name . "_title";
  $field_bgimg = $sec_name . "_bgimg";
  $field_steps = $sec_name . "_steps";

  $we_bring_title = get_field($field_title, $page_id);
  $we_bring_bgimg_url = get_field($field_bgimg, $page_id);
  $we_bring_bgimg = $we_bring_bgimg_url ? get_image_versions($we_bring_bgimg_url) : null;
  $we_bring_steps = get_field($field_steps, $page_id);
?>

<section class="we-bring sec-offset">
  <picture class="we-bring__bgimg">
    <?php if (!empty($we_bring_bgimg['webp_1x'])): ?>
      <source srcset="<?php echo esc_url($we_bring_bgimg['webp_1x']); ?>" type="image/webp">
    <?php endif; ?>
    <img src="<?php if (!empty($we_bring_bgimg['original_1x'])) : echo esc_url($we_bring_bgimg['original_1x']); else : echo esc_url(get_template_directory_uri() . '/img/promo/promo-desktop.jpg'); endif; ?>" width="1440" height="702" alt="<?php if (!empty($services_promo_bgimg['alt'])) : echo esc_attr($services_promo_bgimg['alt']); else : echo 'Фоновое изоражение'; endif; ?>" loading="eager" decoding="async" fetchpriority="high">
  </picture>
  
  <div class="container">
    <div class="we-bring__content">
      <?php if($we_bring_title) : ?>
      <h2 class="we-bring__title sec-title" data-aos="fade-up">
        <?php echo $we_bring_title; ?>
      </h2>
      <?php endif; ?>
    
      <?php if(!empty($we_bring_steps) && is_array($we_bring_steps)) : ?>
      <ul class="we-bring__list">
        <?php foreach($we_bring_steps as $item) : 
        ?>
        <li class="we-bring__item">
          <span class="we-bring__item-title">
            <?php echo $item["title"]; ?>
          </span>
          <span class="we-bring__item-text">
            <?php echo $item["text"]; ?>
          </span>
        </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </div>
  </div>
</section>


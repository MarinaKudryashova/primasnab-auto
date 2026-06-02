<?php
/* 
* Section: Популярные
*/

  $page_id = $args["id"];
  $sec_name = $args["name"]["value"];
  
  $services_country = get_field('services_promo_country', $page_id);
  $services_thumbnail_id = get_term_meta( $services_country, 'thumbnail_id', true );
  $services_flag_url = $services_thumbnail_id ? wp_get_attachment_image_url( $services_thumbnail_id, 'full' ) : '#';

  $field_title = $sec_name . "_title";
  $field_list = $sec_name . "_list";

  $popular_title = get_field($field_title, $page_id);
  $popular_list = get_field($field_list, $page_id);
?>
<section class="popular sec-offset">
  <div class="container">
    <?php if($popular_title) : ?>
      <h2 class="sec-title sec-title--center" data-aos="fade-up"><?php echo esc_html($popular_title); ?></h2>
    <?php endif; ?>

    <?php if(!empty($popular_list) && is_array($popular_list)) : ?>
    <ul class="popular__list">
      <?php foreach($popular_list as $model) : ?>
        <?php 
        // Пропускаем элемент, если нет mark или это не объект
        if(empty($model["mark"]) || !is_object($model["mark"])) {
          continue; // переходим к следующему элементу
        }
        
        // модель
        $model_name = $model["mark"]->name;
        $model_id = $model["mark"]->term_id;
        $model_thumbnail_id = get_term_meta($model_id, 'thumbnail_id', true);
        $model_logo = $model_thumbnail_id ? wp_get_attachment_image_url($model_thumbnail_id, 'full') : '#';
        $model_img_url = $model["img"];
        $model_img = $model_img_url ? get_image_versions($model_img_url) : null;

        // тип кузова
        $body_list = '';
        if(!empty($model["body"]) && is_array($model["body"])) {
          $body_names = array_map(function($term) {
            return $term->name;
          }, $model["body"]);
          $body_list = implode(' / ', $body_names);
        }

        // текст
        $model_text = isset($model["text"]) ? $model["text"] : '';
        ?>
        
        <li class="popular__item">
          <div class="card-popular">
            <div class="card-popular__model">
              <span class="card-popular__logo">
                <img src="<?php echo esc_url($model_logo); ?>" alt="<?php echo esc_attr($model_name); ?>" width="65" height="40">
              </span>
              <span class="card-popular__name">
                <?php echo esc_html($model_name); ?>
                <?php if(!empty($model_img) && is_array($model_img)) : ?>
                <picture class="card-popular__img">
                  <?php if (!empty($model_img['webp_1x'])): ?>
                    <source srcset="<?php echo esc_url($model_img['webp_1x']); ?>" type="image/webp">
                  <?php endif; ?>
                  <img src="<?php echo esc_url($model_img['original_1x']); ?>" width="228" height="250" alt="<?php echo esc_attr($model_name); ?>" loading="lazy">
                </picture>
                <?php endif; ?>
              </span>
            </div>
            
            <div class="card-popular__body">
              <?php echo esc_html($body_list); ?>
            </div>
            
            <div class="card-popular__text">
              <?php echo wp_kses_post($model_text); ?>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </div>
</section>
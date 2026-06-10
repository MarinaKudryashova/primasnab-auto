<?php
  $page_id = $args["id"];
  
  $howwork_title = get_field('howwork_title', $page_id);
  $howwork_list = get_field('howwork_list', $page_id);
?>
<section class="how-work sec-offset">
  <div class="container">
    <?php if($howwork_title) : ?>
      <h2 class="sec-title sec-title--center" data-aos="fade-up"><?php echo $howwork_title; ?></h2>
    <?php endif; ?>
    
    <?php if(!empty($howwork_list) && is_array($howwork_list)) : ?>
    <div class="how-work__content">
      <!-- БЛОК С ФОТО -->
      <div class="how-work__image">
        <?php foreach($howwork_list as $ids => $item) : 
          $howwork_item_url = $item["img"]["url"];
          $howwork_item_img = $howwork_item_url ? get_image_versions($howwork_item_url) : null;
        ?>
          <div class="how-work__image-item <?php if($ids == 0) echo 'active'; ?>" data-index="<?php echo $ids; ?>">
            <picture class="how-work__img">
              <?php if (!empty($howwork_item_img['webp_1x'])): ?>
                <source srcset="<?php echo esc_url($howwork_item_img['webp_1x']); ?>" type="image/webp">
              <?php endif; ?>
              <img loading="lazy" src="<?php echo esc_url($howwork_item_img['original_1x']); ?>" width="710" height="636" alt="<?php echo esc_attr($item["name"]); ?>">
            </picture>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- СПИСОК КНОПОК -->
      <ul class="how-work__list">
        <?php foreach($howwork_list as $ids => $item) : ?>
          <li class="how-work__item" data-index="<?php echo $ids; ?>">
            <button class="how-work__btn <?php if($ids == 0) echo 'active'; ?>" data-index="<?php echo $ids; ?>">
              <?php echo esc_html($item["name"]);?>
            </button>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
  </div>
</section>
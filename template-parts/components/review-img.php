<?php 
  $slide_id = $args["slide_id"];
  $reviews_img_url = $args["reviews_img_url"] ?? '';
  
  $reviews_img = $reviews_img_url ? get_image_versions($reviews_img_url) : null;

  if($reviews_img) : 
  ?>
    <picture class="card-reviews__img">
      <source srcset="<?php echo esc_url($reviews_img ["webp_1x"]); ?>" type="image/webp">
      <img loading="lazy" src="<?php echo esc_url($reviews_img["original_1x"]); ?>" width="400" height="477" alt="" aria-hidden="true">
    </picture>
  <?php endif; ?>
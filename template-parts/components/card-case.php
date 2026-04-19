<?php 
  $page_id = $args["id"];
  $slide = $args["slide"];
  $slide_img = $slide["img"] ? get_image_versions($slide["img"]) : null;
  $slide_title = $slide["title"];
  $slide_text = $slide["text"];
  $slide_video_link = $slide["video_link"];
?> 

<div class="ui-card card-case">

  <div class="card-case__heading">

    <?php if($slide_title) : ?>
      <h3 class="card-case__title">
        <span><?php echo esc_html($slide_title); ?></span>
      </h3>
    <?php endif; ?>

    <?php if($slide_img) : ?>
      <picture class="card-case__img">
        <source srcset="<?php echo esc_url($slide_img ["webp_1x"]); ?>" type="image/webp">
        <img loading="lazy" src="<?php echo esc_url($slide_img["original_1x"]); ?>" width="630" height="350" alt="" aria-hidden="true">
      </picture>
    <?php endif; ?>

    <button class="card-case__btn ui-btn ui-btn--blue" data-video-link="<?php echo esc_url($slide_video_link); ?>">
      Посмотреть видео
      <svg width="12" height="14">
        <use xlink:href="<?php echo esc_url(get_template_directory_uri()); ?>/img/sprite.svg#icon-caret-right"></use>
      </svg>
    </button>
  </div>

  <?php if($slide_text) : ?>
    <div class="card-case__text"><?php echo $slide_text; ?></div>
  <?php endif; ?>

</div>
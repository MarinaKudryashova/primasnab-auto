<?php 
  $slide_id = $args["slide_id"];
  $reviews_video_url = $args["reviews_video_url"];
  $reviews_poster = $args["reviews_poster"];
  $isFile = $args["isFile"] ?? false;;
?>
<div class="card-reviews__video video" id="video-<?php echo esc_attr($slide_id); ?>" data-video-url="<?php echo $reviews_video_url; ?>" <?php if($isFile) : ?> data-is-file="<?php echo $isFile; ?>" <?php endif; ?>>
  <img class="video__thumbnail" src="<?php echo esc_url($reviews_poster); ?>" aria-hidden="true" decoding="async" loading="lazy" alt="">
  <button class="video__play ui-btn ui-btn--blue" aria-label="Запустить видео">
    <svg width="12" height="14">
      <use xlink:href="<?php echo esc_url(get_template_directory_uri()); ?>/img/sprite.svg#icon-caret-right"></use>
    </svg>
  </button>
</div>
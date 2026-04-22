<?php 
  $page_id = $args["id"] ?? 0;
  $slide = $args["slide"] ?? null;
  $media_title = $slide["name"];
  $media_poster = $slide["poster"];
  $media_type = $slide["type"];
  $media_video_url = '';

  switch ($media_type) {
    case 'vk':
      $media_video_url = isset($slide['video_vk']) && !empty($slide['video_vk']) 
        ? $slide['video_vk'] 
        : '#';
      break;

    case 'yt':
      $media_video_url = isset($slide['video_yt']) && !empty($slide['video_yt']) 
        ? $slide['video_yt'] 
        : '#';
      break;

    case 'video':
      $media_video_url = isset($slide['video']) && !empty($slide['video']) 
        ? $slide['video'] 
        : '#';
      break;
        
    default:
      $media_video_url = '#';
      break;
  }
?> 
<div class="card-media">
  <div class="card-media__video video" id="video-<?php echo esc_attr($page_id); ?>" data-video-url="<?php echo esc_url($media_video_url); ?>" <?php if($media_type === 'video') : ?> data-is-file="true" <?php endif; ?>>
    <img class="video__thumbnail" src="<?php echo esc_url($media_poster); ?>" aria-hidden="true" decoding="async" loading="lazy" alt="">
    <button class="video__play ui-btn ui-btn--blue" aria-label="Запустить видео">
      <svg width="12" height="14">
        <use xlink:href="<?php echo esc_url(get_template_directory_uri()); ?>/img/sprite.svg#icon-caret-right"></use>
      </svg>
    </button>
  </div>

  <?php if(!empty($media_title)) : ?>
    <h3 class="card-media__title"><?php echo esc_html($media_title); ?></h3>
  <?php endif; ?>
</div>
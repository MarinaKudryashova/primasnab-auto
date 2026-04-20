<?php 
  $page_id = $args["id"]  ?? 0;
  $slide = $args["slide"] ?? null;

  if (!$slide) {
      return;
  }

  $slide_id = is_object($slide) ? ($slide->ID ?? 0) : 0;
  if (!$slide_id) {
      return;
  }

  $reviews_type = get_field( 'reviews_type', $slide_id );
?> 

<div class="ui-card card-reviews">
  <?php 
    switch ($reviews_type) {
      case 'img':
        $reviews_img_url = get_field('reviews_img', $slide_id);
        if ($reviews_img_url) {
          get_template_part('template-parts/components/review', 'img', [
            'slide_id' => $slide_id, 
            'reviews_img_url' => $reviews_img_url
          ]);
        }
        break;

      case 'vk':
        $reviews_video_url = get_field('reviews_vk', $slide_id);
        $reviews_poster = get_field('reviews_poster', $slide_id);
        if ($reviews_video_url) {
          get_template_part('template-parts/components/review', 'video', [
            'slide_id' => $slide_id, 
            'reviews_video_url' => $reviews_video_url,
            'reviews_poster' => $reviews_poster
          ]);
        }
        break;

      case 'yt':
        $reviews_video_url = get_field('reviews_yt', $slide_id);
        $reviews_poster = get_field('reviews_poster', $slide_id);
        if ($reviews_video_url) {
          get_template_part('template-parts/components/review', 'video', [
            'slide_id' => $slide_id, 
            'reviews_video_url' => $reviews_video_url,
            'reviews_poster' => $reviews_poster
          ]);
        }
        break;

      case 'video':
        $reviews_video_url = get_field('reviews_video', $slide_id);
        $reviews_poster = get_field('reviews_poster', $slide_id);
        if ($reviews_video_url) {
          get_template_part('template-parts/components/review', 'video', [
            'slide_id' => $slide_id, 
            'reviews_video_url' => $reviews_video_url,
            'reviews_poster' => $reviews_poster,
            'isFile' => true,
          ]);
        }
        break;
    }
  ?>
</div>
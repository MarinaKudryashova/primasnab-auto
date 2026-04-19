<?php
  $page_id = $args["id"];
  $direct_title = get_field('direction_title');
  $direct_list = get_field('direction_list');
?>
<section class="direction sec-offset">
  <div class="container">
    <?php if($direct_title) : ?>
      <h2 class="sec-title" data-aos="fade-up"><?php echo $direct_title; ?></h2>
    <?php endif; ?>

    <?php if(!empty($direct_list) && is_array($direct_list)) : ?>
    <ul class="direction__list">
      <?php foreach($direct_list as $item) : 
        $dir_id = $item["country"]->term_id;
        $dir_country_name = $item["country"]->name;
        $dir_country_link = get_term_link( $dir_id, 'product_cat');
        $dir_thumbnail_id = get_term_meta( $dir_id, 'thumbnail_id', true );
        $dir_flag_url = $dir_thumbnail_id ? wp_get_attachment_image_url( $dir_thumbnail_id, 'full' ) : '#';
        $dir_tags = $item["tags"];
        ?>
        <li class="direction__item">
          <div class="direction__heading">
            <a href="<?php echo esc_url($dir_country_link); ?>" class="direction__country ui-btn ui-btn--pink"><?php echo esc_html($dir_country_name); ?></a>
            <img loading="lazy" src="<?php echo esc_url($dir_flag_url); ?>" class="direction__flag" width="77" height="77" alt="" aria-hidden="true">
          </div>
          <?php if(!empty($dir_tags) && is_array($dir_tags)) : ?>
          <div class="direction__tags">
            <?php foreach($dir_tags as $tag) : 
            $dir_tag_id = $tag->term_id;
            $dir_tag_name = $tag->name;
            $dir_tag_link = get_term_link( $dir_tag_id, 'product_tag');
              ?>
              <a href="<?php echo esc_url($dir_tag_link); ?>" class="direction__tag ui-btn ui-btn--ghost"><?php echo esc_html($dir_tag_name); ?></a>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </div>
</section>
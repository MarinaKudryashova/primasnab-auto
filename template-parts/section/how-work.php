<?php
  $page_id = $args["id"];
  
  $block_title = get_field('howwork_title', $page_id);
  $block_list = get_field('howwork_list', $page_id);
?>
<section class="how-work sec-offset">
  <div class="container">
    <?php if($block_title) : ?>
      <h2 class="sec-title sec-title--center sec-title--blue" data-aos="fade-up"><?php echo $block_title; ?></h2>
    <?php endif; ?>
  </div>
</section>
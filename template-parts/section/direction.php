<?php
  $page_id = $args["id"];
  $direct_title = get_field('direction_title');
  $direct_list = get_field('direction_list');

  // var_dump($direct_list);
?>
<section class="direction sec-offset">
  <div class="container">
    <?php if($direct_title) : ?>
      <h2 class="sec-title" data-aos="fade-up"><?php echo $direct_title; ?></h2>
    <?php endif; ?>
  </div>
</section>
<?php
  $page_id = $args["id"];
  $sec_name = $args["name"]["value"];
  
  $field_title = $sec_name . "_title";
  $field_list = $sec_name;
  
  $sec_why_title = get_field($field_title, $page_id);
  $sec_why_list = get_field($field_list, $page_id);

?>
<section class="why-benefits sec-offset">
  <div class="container">
    <?php if($sec_why_title) : ?>
      <h2 class="sec-title sec-title--pink sec-title--center" data-aos="fade-up"><?php echo $sec_why_title; ?></h2>
    <?php endif; ?>

    <?php if(!empty($sec_why_list) && is_array($sec_why_list)) : ?>
    <ul class="why-benefits__list">
      <?php foreach($sec_why_list as $benefit) : ?>
        <li class="why-benefits__item">
          <?php get_template_part('template-parts/components/card-benefits', null, ['id' => $page_id, 'benefit' => $benefit]); ?>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </div>
</section>
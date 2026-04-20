<?php
  $page_id = $args["id"];
  $sec_name = $args["name"]["value"];

  $field_title = $sec_name . "_title";
  $field_list = $sec_name . "_list";

  $sec_catalog_title = get_field($field_title, $page_id);
  $sec_catalog_list = get_field($field_list, $page_id);
?>
<section class="sec-catalog sec-offset">
  <div class="container">
    <?php if($sec_catalog_title) : ?>
      <h2 class="sec-title sec-title--blue sec-title--center" data-aos="fade-up"><?php echo $sec_catalog_title; ?></h2>
    <?php endif; ?>

    <?php if(!empty($sec_catalog_list) && is_array($sec_catalog_list)) : ?>
    <ul class="sec-catalog__list">
      <?php foreach($sec_catalog_list as $car) : ?>
        <li class="sec-catalog__item">
          <?php get_template_part('template-parts/components/card-product', null, ['id' => $page_id, 'block' => $sec_name, 'car' => $car]); ?>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </div>
</section>
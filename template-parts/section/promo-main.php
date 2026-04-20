<?php
  $page_id = $args["id"];
  
  // $promo_title = get_field('', $page_id);
  $promo_benefits = get_field('promo_benefits', $page_id);
?>

<section class="promo sec-offset">
  <div class="container">
    <?php if(!empty($promo_benefits) && is_array($promo_benefits)) : ?>
    <ul class="promo__benefits">
      <?php foreach($promo_benefits as $benefit) : ?>
      <li class="promo__benefits-item">
        <?php get_template_part('template-parts/components/card-benefits', null, ['id' => $page_id, 'benefit' => $benefit]); ?>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </div>
</section>
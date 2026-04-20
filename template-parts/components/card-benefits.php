<?php 
$benefit = $args["benefit"];
$benefit_position = $benefit["settings"]["position"];
$benefit_color = $benefit["settings"]["color"];
$benefit_show_icon = $benefit["settings"]["show_icon"];

switch ($benefit_position) {
  case 'reverse':
    $benefits_class = 'card-benefits card-benefits--reverse';
    break;
    
    default:
    $benefits_class = 'card-benefits';
    break;
}

$benefit_title = $benefit["content"]["title"];
$benefit_text = $benefit["content"]["text"];

if($benefit_show_icon) {
  $benefit_icon_url = $benefit["content"]["icon"];
  $benefit_icon_pos = $benefit["content"]["icon_position"];
  ?>
  <!-- <style>
    .card-benefits[data-icon-pos]::before {
      content: "";
      position: absolute;
      width: 50px;
      height: 50px;
      background-image: url("<?php //echo esc_attr($benefit_icon_url); ?>");
      background-size: contain;
      background-repeat: no-repeat;
    }

    .card-benefits[data-icon-pos="left"]::before {
      content: "";
      position: absolute;
      width: 50px;
      height: 50px;
      background-image: url("<?php //echo esc_attr($benefit_icon_url); ?>");
      background-size: contain;
      background-repeat: no-repeat;
    }
    .card-benefits[data-icon-pos="right"]::after {
      content: "";
      position: absolute;
      width: 50px;
      height: 50px;
      background-image: url("<?php //еcho esc_attr($benefit_icon_url); ?>");
      background-size: contain;
      background-repeat: no-repeat;
    }
    .card-benefits[data-icon-pos="double"]::before,
    .card-benefits[data-icon-pos="double"]::after {
      content: "";
      position: absolute;
      width: 50px;
      height: 50px;
      background-image: url("<?php //echo esc_attr($benefit_icon_url); ?>");
      background-size: contain;
      background-repeat: no-repeat;
    } -->
  </style>
  <?php
// echo '<pre>';
// var_dump($benefit["content"]["icon_position"]);
// echo '</pre>';
}
?>
<div class="<?php echo esc_attr($benefits_class); ?>" 
  style="--card-benefits-color:<?php echo esc_attr($benefit_color); ?>; 
  <?php if($benefit_show_icon) : ?>--card-benefits-icon-url: url('<?php echo esc_attr($benefit_icon_url); ?>')<?php endif;?>"
  <?php if($benefit_show_icon) : ?> data-icon-pos="<?php echo esc_attr($benefit_icon_pos); ?>" <?php endif;?>>
  <span class="card-benefits__name"><?php echo esc_html($benefit_title); ?></span>
  <span class="card-benefits__text"><?php echo esc_html($benefit_text); ?></span>
</div>
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
}
?>
<div class="<?php echo esc_attr($benefits_class); ?>" 
  style="--card-benefits-color:<?php echo esc_attr($benefit_color); ?>; 
  <?php if($benefit_show_icon) : ?>--card-benefits-icon-url: url('<?php echo esc_attr($benefit_icon_url); ?>')<?php endif;?>"
  <?php if($benefit_show_icon) : ?> data-icon-pos="<?php echo esc_attr($benefit_icon_pos); ?>" <?php endif;?>>
  <span class="card-benefits__name"><?php echo esc_html($benefit_title); ?></span>
  <span class="card-benefits__text"><?php echo esc_html($benefit_text); ?></span>
</div>
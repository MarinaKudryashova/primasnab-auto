<?php
/*
Template Name: Контакты
Template Post Type: page
*/

$page_id = get_the_ID();
$offices = get_field("offices", $page_id);
?>

<?php get_header(); ?>
  <main class="main">
    <div class="container">
      <?php get_template_part("template-parts/components/breadcrumbs", "", $page_id); ?>

      <h1 class="page-title"><?php echo esc_html(get_the_title()); ?></h1>

      <?php if($offices && is_array($offices)) : ?>
      <div class="offices sec-offsettabs" data-tabs="offices-tabs">
        <ul class="list-reset tabs__nav offices__nav">
          <?php foreach($offices as $office) : ?>
          <li class="tabs__nav-item">
            <button class="offices__btn btn-reset tabs__nav-btn" type="button">
              <span class="offices__name"><?php echo esc_html($office['name']); ?></span>
            </button>
          </li>
          <?php endforeach; ?>
        </ul>
        <div class="tabs__content">
          <?php foreach($offices as $office): ?>
          <div class="tabs__panel">
            <div class="offices__info">

              <?php /*-- Адрес офиса --*/ ?>
              <div class="offices__contacts contacts">
                <span class="contacts__title"><?php esc_html_e( 'Адрес', 'primasnab' ); ?></span>
                <p class="contacts__value"><?php echo esc_html($office["address"]); ?></p>
              </div>

              <?php /*-- График работы офиса --*/ ?>
              <div class="offices__contacts contacts">
                <span class="contacts__title"><?php esc_html_e( 'График работы', 'primasnab' ); ?></span>
                <p class="contacts__value"><?php echo esc_html($office["timework"]); ?></p>

              </div>

              <?php /*-- Телефон --*/ ?>
              <?php
                $phone = $office["tel"];
                $phone = explode(PHP_EOL, $phone);
                $phone_href = preg_replace('![^0-9]+!', '', $phone);
              ?>
              <div class="offices__contacts contacts">
                <span class="contacts__title"><?php esc_html_e( 'Телефон', 'primasnab' ); ?></span>
                <a class="contacts__value ui-link" href="tel:<?php echo $phone_href[0]; ?>"
                  data-text="<?php echo $phone[0]; ?>"><?php echo $phone[0]; ?></a>
              </div>

              <?php /*-- Электронная почта --*/ ?>
              <div class="offices__contacts contacts">
                <span class="contacts__title"><?php esc_html_e( 'Электронная почта', 'primasnab' ); ?></span>
                <a class="contacts__value ui-link" href="mailto:<?php echo esc_attr($office["mail"]); ?>">
                  <?php echo esc_html($office["mail"]); ?>
                </a>
              </div>

            </div>

            <div class="offices__map" data-icon-href="<?php echo get_template_directory_uri(); ?>/img/icon/icon-map.svg" data-center="<?php echo esc_html($office["map"]["center"]); ?>" data-hint="<?php echo esc_html($office["map"]["hint"]); ?>" data-point="<?php echo esc_html($office["map"]["point"]); ?>"></div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </main>
  
<?php get_footer(); ?>
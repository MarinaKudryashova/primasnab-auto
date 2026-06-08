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

      <h1 class="page-title page-title--contacts"><?php echo esc_html(get_the_title()); ?></h1>

      <?php if($offices && is_array($offices)) : ?>
      <div class="offices sec-offsettabs" data-tabs="offices-tabs">

      <!-- КАСТОМНЫЙ ВЫПАДАЮЩИЙ СПИСОК (только для мобилки) -->
        <div class="offices__custom-select">
          <div class="offices__select-selected offices__btn">
            <span class="offices__select-name offices__name">
              <?php echo esc_html($offices[0]['name']); ?>
            </span>
            <svg class="offices__select-arrow" width="10" height="9">
              <use xlink:href="<?php echo esc_url(get_template_directory_uri()); ?>/img/sprite.svg#icon-caret-down"></use>
            </svg>
          </div>
          <div class="offices__select-options">
            <?php foreach($offices as $index => $office) : ?>
            <div class="offices__select-option <?php echo $index === 0 ? 'active' : ''; ?>" data-tab-index="<?php echo $index; ?>">
              <span><?php echo esc_html($office['name']); ?></span>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        
        <!-- Обычная навигация (для десктопа) -->
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

              <!-- Адрес (только если не пусто) -->
              <?php if(!empty($office["address"])) : ?>
              <div class="offices__contacts contacts">
                <span class="contacts__title"><?php esc_html_e( 'Адрес', 'primasnab' ); ?></span>
                <p class="contacts__value"><?php echo esc_html($office["address"]); ?></p>
              </div>
              <?php endif; ?>

              <!-- График работы (только если не пусто) -->
              <?php if(!empty($office["timework"])) : ?>
              <div class="offices__contacts contacts">
                <span class="contacts__title"><?php esc_html_e( 'График работы', 'primasnab' ); ?></span>
                <p class="contacts__value"><?php echo esc_html($office["timework"]); ?></p>
              </div>
              <?php endif; ?>

              <!-- Телефон (обрабатываем, только если поле не пусто) -->
              <?php if(!empty($office["tel"])) : 
                $phone = explode(PHP_EOL, $office["tel"]);
                $phone_href = preg_replace('![^0-9]+!', '', $phone);
              ?>
              <div class="offices__contacts contacts">
                <span class="contacts__title"><?php esc_html_e( 'Телефон', 'primasnab' ); ?></span>
                <a class="contacts__value ui-link" href="tel:<?php echo esc_attr($phone_href[0]); ?>"
                  data-text="<?php echo esc_attr($phone[0]); ?>"><?php echo esc_html($phone[0]); ?></a>
              </div>
              <?php endif; ?>

              <!-- Электронная почта (только если не пусто) -->
              <?php if(!empty($office["mail"])) : ?>
              <div class="offices__contacts contacts">
                <span class="contacts__title"><?php esc_html_e( 'Электронная почта', 'primasnab' ); ?></span>
                <a class="contacts__value ui-link" href="mailto:<?php echo esc_attr($office["mail"]); ?>">
                  <?php echo esc_html($office["mail"]); ?>
                </a>
              </div>
              <?php endif; ?>

            </div>

            <div class="offices__map" data-icon-href="<?php echo get_template_directory_uri(); ?>/img/icon/icon-map.svg" data-center="<?php echo esc_html($office["map"]["center"]); ?>" data-hint="<?php echo esc_html($office["map"]["hint"]); ?>"></div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </main>
  
<?php get_footer(); ?>
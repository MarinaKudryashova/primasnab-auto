<?php
/**
 * Template Name: Политика конфиденциальности
 * Template Post Type: page
 */

get_header();
$page_id = get_the_ID();
?>
<main class="main privacy-policy-page">
  <div class="page__container container">
    <?php get_template_part( "template-parts/components/breadcrumbs", "", $page_id); ?>
    <h1 class="privacy-policy-title sec-title">
      <?php echo esc_html(get_the_title($page_id)); ?>
    </h1>
    <div class="textredactor privacy-policy-content">
      <?php echo wpautop(get_the_content()); ?>
    </div>
  </div>
</main>
<?php
get_footer();
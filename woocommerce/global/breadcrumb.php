<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Если есть Yoast SEO - используем его
if ( function_exists( 'yoast_breadcrumb' ) && ! is_admin() ) {
    yoast_breadcrumb();
    return;
}

// Получаем данные WooCommerce breadcrumb
if ( empty( $breadcrumb ) ) {
    return;
}
?>

<ul class="breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">
  <?php
  $position = 1;
  foreach ( $breadcrumb as $key => $crumb ) :
    $is_last = ( count( $breadcrumb ) === $key + 1 );
    $has_url = ! empty( $crumb[1] ) && ! $is_last;
    ?>
    
    <li class="breadcrumbs__item <?php echo $is_last ? 'breadcrumbs__item--current' : ''; ?>"
      <?php echo $is_last ? 'aria-current="page"' : ''; ?>
      itemprop="itemListElement" 
      itemscope itemtype="https://schema.org/ListItem">
      
      <?php if ( $has_url ) : ?>
        <a class="breadcrumbs__link" href="<?php echo esc_url( $crumb[1] ); ?>" 
          title="<?php echo esc_attr( $crumb[0] ); ?>" itemprop="item">
          <span itemprop="name"><?php echo esc_html( $crumb[0] ); ?></span>
        </a>
      <?php else : ?>
        <span itemprop="name"><?php echo esc_html( $crumb[0] ); ?></span>
      <?php endif; ?>
      
      <meta itemprop="position" content="<?php echo $position; ?>">
        
    </li>
    
    <?php $position++; ?>
  <?php endforeach; ?>
</ul>

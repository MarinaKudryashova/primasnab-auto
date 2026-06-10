<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$id_suffix = wp_unique_id();
$icon_url = get_template_directory_uri() . '/img/icon/arrow-switch-vertical.svg';
        // <img class="message__img" src="img/icon/arrow-switch-vertical.svg" width="16" height="16" alt="icon arrow switch vertical" aria-hidden="true" loading="lazy">

?>
<form class="woocommerce-ordering" method="get">
	<?php if ( $use_label ) : ?>
		<label for="woocommerce-orderby-<?php echo esc_attr( $id_suffix ); ?>"><?php echo esc_html__( 'Sort by', 'woocommerce' ); ?></label>
	<?php endif; ?>
	<select
		name="orderby"
		class="orderby"
		<?php if ( $use_label ) : ?>
			id="woocommerce-orderby-<?php echo esc_attr( $id_suffix ); ?>"
		<?php else : ?>
			aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>"
		<?php endif; ?>
	>
		<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
	</select>
	<input type="hidden" name="paged" value="1" />
	<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
</form>

<!-- Cортировка -->
<div class="sort-options" id="sort-select">
	<span class="sort-options__label visually-hidden" id="sortLabel">Сортировка:</span>
	<div class="sort-options__dropdown">
		<button class="sort-options__btn" data-sort-btn aria-haspopup="listbox" aria-expanded="false" aria-labelledby="sortLabel sortValueText">
			<img class="sort-options__img" src="<?php echo esc_url(get_template_directory_uri()); ?>/img/icon/arrow-switch-vertical.svg" width="16" height="16" alt="icon arrow switch vertical" aria-hidden="true" loading="lazy">
			<span class="sort-options__current" data-sort-value id="sortValueText">По умолчанию</span>
			<svg class="sort-options__icon" aria-hidden="true" focusable="false">
				<use xlink:href="<?php echo esc_url(get_template_directory_uri()); ?>/img/sprite.svg#icon-chevron-down"></use>
			</svg>
		</button>
		<ul class="sort-options__menu" data-sort-menu aria-labelledby="sortLabel" aria-hidden="true" role="listbox" tabindex="-1">
			<li class="sort-options__item" role="option" aria-selected="false" data-value="default" tabindex="0">По умолчанию</li>
			<li class="sort-options__item" role="option" aria-selected="false" data-value="price-asc" tabindex="0">Дешевле</li>
			<li class="sort-options__item" role="option" aria-selected="false" data-value="price-desc" tabindex="0">Дороже</li>
		</ul>
	</div>
</div>

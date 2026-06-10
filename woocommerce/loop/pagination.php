<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
    return;
}

// Получаем массив параметров для пагинации из стандартного фильтра WooCommerce [citation:4]
$args = apply_filters( 'woocommerce_pagination_args', array(
    'base'         => $base,
    'format'       => $format,
    'add_args'     => false,
    'current'      => max( 1, $current ),
    'total'        => $total,
    'prev_text'    => '', // Текст прячем, используем иконку из вёрстки
    'next_text'    => '',
    'type'         => 'array', // Получаем массив элементов для гибкой верстки
    'end_size'     => 1,
    'mid_size'     => 1,
) );

$links = paginate_links( $args );

if ( ! $links ) {
    return;
}

$template_dir = get_template_directory_uri();

?>

<div class="page-controls">
    <?php // Кнопка "Загрузить еще" ?>
    <button class="page-controls__more-btn ui-btn ui-btn--blue" id="load-more-product" data-total="<?php echo $total; ?>" type="button">Загрузить еще</button>

    <div class="page-controls__paginations paginations">
      <?php

        foreach ( $links as $link ) {
            // Проверяем классы в HTML для определения типа ссылки
            if ( preg_match( '/class="[^"]*\bprev\b[^"]*"/', $link ) ) {
                // Ссылка "Назад"
                $link = preg_replace( '/\bprev\b/', '', $link );
                $link = preg_replace( '/\bpage-numbers\b/', 'paginations__prev', $link );
                $link = str_replace( '« Previous', '', $link );
                // Добавляем иконку
                $link = str_replace( '</a>', '<svg width="24" height="24"><use xlink:href="' . $template_dir . '/img/sprite.svg#icon-chevron-left"></use></svg></a>', $link );
                echo $link;
            } elseif ( preg_match( '/class="[^"]*\bnext\b[^"]*"/', $link ) ) {
                // Ссылка "Вперед"
                $link = preg_replace( '/\bnext\b/', '', $link );
                $link = preg_replace( '/\bpage-numbers\b/', 'paginations__next', $link );
                $link = str_replace( 'Next »', '', $link );
                $link = str_replace( '</a>', '<svg width="24" height="24"><use xlink:href="' . $template_dir . '/img/sprite.svg#icon-chevron-right"></use></svg></a>', $link );
                echo $link;
            } elseif ( preg_match( '/class="[^"]*\bcurrent\b[^"]*"/', $link ) ) {
                // Текущая страница (активная)
                $link = str_replace( 'page-numbers current', 'paginations__number is-active', $link );
                $link = str_replace( '<span', '<a', $link );
                $link = str_replace( '</span>', '</a>', $link );
                echo $link;
            } elseif ( preg_match( '/class="[^"]*\bdots\b[^"]*"/', $link ) ) {
                // Многоточие
                $link = str_replace( 'page-numbers dots', 'paginations__more', $link );
                $link = str_replace( '<span', '<a', $link );
                $link = str_replace( '</span>', '</a>', $link );
                echo $link;
            } else {
                // Обычные номера страниц
                $link = str_replace( 'page-numbers', 'paginations__number', $link );
                echo $link;
            }
        }
        ?>
    </div>
</div>

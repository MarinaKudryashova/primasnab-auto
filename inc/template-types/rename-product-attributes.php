<?php

/**
 * Переименование элементов WooCommerce в админке
 * "Атрибуты" в "Характеристики"
 */

add_filter( 'woocommerce_attribute_taxonomies_menu_items', 'rename_attributes_menu' );
add_filter( 'gettext', 'rename_attributes_text', 10, 3 );
add_filter( 'ngettext', 'rename_attributes_text_plural', 10, 5 );

function rename_attributes_menu( $menu_items ) {
    foreach ( $menu_items as $key => $item ) {
        if ( $item === 'attributes' ) {
            $menu_items[$key] = 'characteristics';
        }
    }
    return $menu_items;
}

function rename_attributes_text( $translated, $original, $domain ) {
    if ( $domain === 'woocommerce' ) {
        if ( $original === 'Product Attributes' ) {
            $translated = 'Характеристики товаров';
        }
        if ( $original === 'Attributes' ) {
            $translated = 'Характеристики';
        }
        if ( $original === 'Attribute' ) {
            $translated = 'Характеристика';
        }
        if ( $original === 'Add attribute' ) {
            $translated = 'Добавить характеристику';
        }
        if ( $original === 'Edit attribute' ) {
            $translated = 'Редактировать характеристику';
        }
        if ( $original === 'View attribute' ) {
            $translated = 'Просмотреть характеристику';
        }
        if ( $original === 'Update attribute' ) {
            $translated = 'Обновить характеристику';
        }
        if ( $original === 'New attribute name' ) {
            $translated = 'Название новой характеристики';
        }
        if ( $original === 'Attribute name' ) {
            $translated = 'Название характеристики';
        }
        if ( $original === 'Attribute slug' ) {
            $translated = 'Ярлык характеристики';
        }
        if ( $original === 'Used for variations' ) {
            $translated = 'Используется для вариаций';
        }
    }
    return $translated;
}

function rename_attributes_text_plural( $translation, $single, $plural, $number, $domain ) {
    if ( $domain === 'woocommerce' ) {
        if ( $single === 'Attribute' && $plural === 'Attributes' ) {
            $translation = $number == 1 ? 'Характеристика' : 'Характеристики';
        }
        if ( $single === 'Product Attribute' && $plural === 'Product Attributes' ) {
            $translation = $number == 1 ? 'Характеристика товара' : 'Характеристики товаров';
        }
    }
    return $translation;
}
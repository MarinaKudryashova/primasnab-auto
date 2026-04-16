<?php
/**
 * Переименование элементов WooCommerce в админке
 * "Бренды" в "Марки"
 * ПОЛНАЯ ВЕРСИЯ
 */

// Основной хук для таксономии брендов (если используется плагин)
add_filter( 'woocommerce_taxonomy_args_product_brand', 'rename_brands_to_marki' );

function rename_brands_to_marki( $args ) {
    $args['labels'] = array(
        'name'                       => 'Марки',
        'singular_name'              => 'Марка',
        'menu_name'                  => 'Марки',
        'all_items'                  => 'Все марки',
        'edit_item'                  => 'Редактировать марку',
        'view_item'                  => 'Просмотреть марку',
        'update_item'                => 'Обновить марку',
        'add_new_item'               => 'Добавить новую марку',
        'new_item_name'              => 'Название новой марки',
        'parent_item'                => 'Родительская марка',
        'parent_item_colon'          => 'Родительская марка:',
        'search_items'               => 'Искать марки',
        'popular_items'              => 'Популярные марки',
        'separate_items_with_commas' => 'Разделяйте марки запятыми',
        'add_or_remove_items'        => 'Добавить или удалить марки',
        'choose_from_most_used'      => 'Выберите из часто используемых марок',
        'not_found'                  => 'Марки не найдены',
        'back_to_items'              => '← Назад к маркам',
    );
    return $args;
}

// Дополнительная замена текстов через gettext (для метабокса и других мест)
add_filter( 'gettext', 'rename_brands_labels', 20, 3 );
add_filter( 'ngettext', 'rename_brands_labels_plural', 20, 5 );

function rename_brands_labels( $translated, $original, $domain ) {
    if ( $domain === 'woocommerce' && is_admin() ) {
        $replacements = array(
            // Основные
            'Product brands' => 'Марки товаров',
            'Brands' => 'Марки',
            'Brand' => 'Марка',
            'Add brand' => 'Добавить марку',
            'Edit brand' => 'Редактировать марку',
            'View brand' => 'Просмотреть марку',
            'Update brand' => 'Обновить марку',
            'All brands' => 'Все марки',
            'Parent brand' => 'Родительская марка',
            'New brand name' => 'Название новой марки',
            'Search brands' => 'Искать марки',
            'Popular brands' => 'Популярные марки',
            'Separate brands with commas' => 'Разделяйте марки запятыми',
            'Add or remove brands' => 'Добавить или удалить марки',
            'Choose from the most used brands' => 'Выберите из часто используемых марок',
            'No brands found.' => 'Марки не найдены',
            'Back to brands' => '← Назад к маркам',
            // Дополнительные для страницы брендов
            'Add New Brand' => 'Добавить новую марку',
            'Add New' => 'Добавить марку',
            'Add new brand' => 'Добавить новую марку',
            'Edit Brand' => 'Редактировать марку',
            'View Brand' => 'Просмотреть марку',
            'Search Brand' => 'Искать марку',
            'Search Brands' => 'Искать марки',
            'Parent Brand' => 'Родительская марка',
            'Parent Brand:' => 'Родительская марка:',
            'No brands' => 'Нет марок',
            'Choose a parent brand' => 'Выберите родительскую марку',
        );
        
        if ( isset( $replacements[$original] ) ) {
            return $replacements[$original];
        }
    }
    return $translated;
}

function rename_brands_labels_plural( $translation, $single, $plural, $number, $domain ) {
    if ( $domain === 'woocommerce' && is_admin() ) {
        if ( $single === 'Brand' && $plural === 'Brands' ) {
            return $number == 1 ? 'Марка' : 'Марки';
        }
        if ( $single === 'Product Brand' && $plural === 'Product Brands' ) {
            return $number == 1 ? 'Марка товара' : 'Марки товаров';
        }
    }
    return $translation;
}

// Меняем текст в боковом меню WooCommerce
add_action( 'admin_menu', 'rename_brands_admin_menu', 999 );

function rename_brands_admin_menu() {
    global $submenu;
    
    if ( isset( $submenu['edit.php?post_type=product'] ) ) {
        foreach ( $submenu['edit.php?post_type=product'] as $key => $item ) {
            if ( $item[0] === 'Brands' ) {
                $submenu['edit.php?post_type=product'][$key][0] = 'Марки';
            }
        }
    }
}

// Переименование в настройках постоянных ссылок
add_filter( 'gettext', 'rename_brands_in_permalink', 20, 3 );

function rename_brands_in_permalink( $translated, $original, $domain ) {
    global $pagenow;
    
    if ( $pagenow === 'options-permalink.php' && $domain === 'woocommerce' ) {
        if ( $original === 'Product brand base' ) {
            return 'База марок';
        }
        if ( $original === 'Brand base' ) {
            return 'База марок';
        }
    }
    
    return $translated;
}


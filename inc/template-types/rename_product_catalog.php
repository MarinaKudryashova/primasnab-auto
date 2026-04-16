<?php
/**
 * Переименование элементов WooCommerce в админке
 * "Категории товаров" в "Страна"
 */

// Основной хук для таксономии (правильный хук из документации)
add_filter( 'woocommerce_taxonomy_args_product_cat', 'rename_category_to_country' );

function rename_category_to_country( $args ) {
    $args['labels'] = array(
        'name'                  => 'Страна',
        'singular_name'         => 'Страна',
        'menu_name'             => 'Страны',
        'all_items'             => 'Все страны',
        'edit_item'             => 'Редактировать страну',
        'view_item'             => 'Просмотреть страну',
        'update_item'           => 'Обновить страну',
        'add_new_item'          => 'Добавить новую страну',
        'new_item_name'         => 'Название страны',
        'parent_item'           => 'Родительская страна',
        'parent_item_colon'     => 'Родительская страна:',
        'search_items'          => 'Искать страны',
        'popular_items'         => 'Популярные страны',
        'separate_items_with_commas' => 'Разделяйте страны запятыми',
        'add_or_remove_items'   => 'Добавить или удалить страны',
        'choose_from_most_used' => 'Выберите из часто используемых стран',
        'not_found'             => 'Страны не найдены',
        'back_to_items'         => '← Назад к странам',
    );
    return $args;
}

// Дополнительная замена текстов через gettext (для метабокса и других мест)
add_filter( 'gettext', 'rename_categories_labels', 20, 3 );
add_filter( 'ngettext', 'rename_categories_labels_plural', 20, 5 );

function rename_categories_labels( $translated, $original, $domain ) {
    if ( $domain === 'woocommerce' && is_admin() ) {
        if ( $original === 'Product categories' ) {
            return 'Страны';
        }
        if ( $original === 'Categories' ) {
            return 'Страна';
        }
        if ( $original === 'Category' ) {
            return 'Страна';
        }
        if ( $original === 'Add category' ) {
            return 'Добавить страну';
        }
        if ( $original === 'Edit category' ) {
            return 'Редактировать страну';
        }
        if ( $original === 'View category' ) {
            return 'Просмотреть страну';
        }
        if ( $original === 'Update category' ) {
            return 'Обновить страну';
        }
        if ( $original === 'All categories' ) {
            return 'Все страны';
        }
        if ( $original === 'Parent category' ) {
            return 'Родительская страна';
        }
        if ( $original === 'New category name' ) {
            return 'Название страны';
        }
        if ( $original === 'Search categories' ) {
            return 'Искать страны';
        }
        if ( $original === 'Popular categories' ) {
            return 'Популярные страны';
        }
        if ( $original === 'Separate categories with commas' ) {
            return 'Разделяйте страны запятыми';
        }
        if ( $original === 'Add or remove categories' ) {
            return 'Добавить или удалить страны';
        }
        if ( $original === 'Choose from the most used categories' ) {
            return 'Выберите из часто используемых стран';
        }
        if ( $original === 'No categories found.' ) {
            return 'Страны не найдены';
        }
        if ( $original === 'Back to categories' ) {
            return '← Назад к странам';
        }
    }
    return $translated;
}

function rename_categories_labels_plural( $translation, $single, $plural, $number, $domain ) {
    if ( $domain === 'woocommerce' && is_admin() ) {
        if ( $single === 'Category' && $plural === 'Categories' ) {
            return $number == 1 ? 'Страна' : 'Страны';
        }
        if ( $single === 'Product Category' && $plural === 'Product Categories' ) {
            return $number == 1 ? 'Страна' : 'Страны';
        }
    }
    return $translation;
}

// Меняем текст в боковом меню WooCommerce
add_action( 'admin_menu', 'rename_categories_admin_menu', 999 );

function rename_categories_admin_menu() {
    global $submenu;
    
    if ( isset( $submenu['edit.php?post_type=product'] ) ) {
        foreach ( $submenu['edit.php?post_type=product'] as $key => $item ) {
            if ( $item[0] === 'Categories' ) {
                $submenu['edit.php?post_type=product'][$key][0] = 'Страна';
            }
        }
    }
}

// Переименование в настройках постоянных ссылок
add_filter( 'gettext', 'rename_categories_in_permalink', 20, 3 );

function rename_categories_in_permalink( $translated, $original, $domain ) {
    global $pagenow;
    
    if ( $pagenow === 'options-permalink.php' && $domain === 'woocommerce' ) {
        if ( $original === 'Product category base' ) {
            return 'База стран';
        }
        if ( $original === 'Category base' ) {
            return 'База категорий';
        }
    }
    
    return $translated;
}
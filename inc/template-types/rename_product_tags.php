<?php
/**
 * Переименование элементов WooCommerce в админке
 * "Метки товаров" в "Теги"
 */

// Основной хук - используем правильное название хука из документации
add_filter( 'woocommerce_taxonomy_args_product_tag', 'rename_tags_to_tegi' );

function rename_tags_to_tegi( $args ) {
    $args['labels'] = array(
        'name'                  => 'Теги',
        'singular_name'         => 'Тег',
        'menu_name'             => 'Теги',
        'all_items'             => 'Все теги',
        'edit_item'             => 'Редактировать тег',
        'view_item'             => 'Просмотреть тег',
        'update_item'           => 'Обновить тег',
        'add_new_item'          => 'Добавить новый тег',
        'new_item_name'         => 'Название тега',
        'parent_item'           => 'Родительский тег',
        'parent_item_colon'     => 'Родительский тег:',
        'search_items'          => 'Искать теги',
        'popular_items'         => 'Популярные теги',
        'separate_items_with_commas' => 'Разделяйте теги запятыми',
        'add_or_remove_items'   => 'Добавить или удалить теги',
        'choose_from_most_used' => 'Выберите из часто используемых тегов',
        'not_found'             => 'Теги не найдены',
        'back_to_items'         => '← Назад к тегам',
    );
    
    return $args;
}

// Дополнительная замена текстов через gettext (для метабокса и других мест)
add_filter( 'gettext', 'rename_tags_labels', 20, 3 );
add_filter( 'ngettext', 'rename_tags_labels_plural', 20, 5 );

function rename_tags_labels( $translated, $original, $domain ) {
    if ( $domain === 'woocommerce' && is_admin() ) {
        if ( $original === 'Product Tags' ) {
            return 'Теги товара';
        }
        if ( $original === 'Tags' ) {
            return 'Теги';
        }
        if ( $original === 'Tag' ) {
            return 'Тег';
        }
        if ( $original === 'Add tag' ) {
            return 'Добавить тег';
        }
        if ( $original === 'Edit tag' ) {
            return 'Редактировать тег';
        }
        if ( $original === 'View tag' ) {
            return 'Просмотреть тег';
        }
    }
    return $translated;
}

function rename_tags_labels_plural( $translation, $single, $plural, $number, $domain ) {
    if ( $domain === 'woocommerce' && is_admin() ) {
        if ( $single === 'Tag' && $plural === 'Tags' ) {
            return $number == 1 ? 'Тег' : 'Теги';
        }
        if ( $single === 'Product Tag' && $plural === 'Product Tags' ) {
            return $number == 1 ? 'Тег товара' : 'Теги товаров';
        }
    }
    return $translation;
}

// Меняем текст в боковом меню
add_action( 'admin_menu', 'rename_tags_admin_menu', 999 );

function rename_tags_admin_menu() {
    global $submenu;
    
    if ( isset( $submenu['edit.php?post_type=product'] ) ) {
        foreach ( $submenu['edit.php?post_type=product'] as $key => $item ) {
            if ( $item[0] === 'Tags' ) {
                $submenu['edit.php?post_type=product'][$key][0] = 'Теги';
            }
        }
    }
}

// Переименование в настройках постоянных ссылок
add_filter( 'gettext', 'rename_tags_in_permalink', 20, 3 );

function rename_tags_in_permalink( $translated, $original, $domain ) {
    global $pagenow;
    
    if ( $pagenow === 'options-permalink.php' && $domain === 'woocommerce' ) {
        if ( $original === 'Product tag base' ) {
            return 'База тегов товара';
        }
        if ( $original === 'Tag base' ) {
            return 'База тегов';
        }
    }
    
    return $translated;
}
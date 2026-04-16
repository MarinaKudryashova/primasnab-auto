<?php 

// Меняем текст в боковом меню WooCommerce
add_action( 'admin_menu', 'rename_woocommerce_menu_items', 999 );

function rename_woocommerce_menu_items() {
    global $menu, $submenu;
    
    if ( isset( $submenu['edit.php?post_type=product'] ) ) {
        foreach ( $submenu['edit.php?post_type=product'] as $key => $item ) {
            // Переименовываем "Categories" в "Страна"
            if ( $item[0] === 'Categories' ) {
                $submenu['edit.php?post_type=product'][$key][0] = 'Страна';
            }
            // Переименовываем "Tags" в "Теги"
            if ( $item[0] === 'Tags' ) {
                $submenu['edit.php?post_type=product'][$key][0] = 'Теги';
            }
            // Переименовываем "Attributes" в "Характеристики"
            if ( $item[0] === 'Attributes' ) {
                $submenu['edit.php?post_type=product'][$key][0] = 'Характеристики';
            }
        }
    }
    
    // Переименовываем "Brands" в "Марки" если используется плагин брендов
    if ( isset( $submenu['edit.php?post_type=product'] ) ) {
        foreach ( $submenu['edit.php?post_type=product'] as $key => $item ) {
            if ( $item[0] === 'Brands' ) {
                $submenu['edit.php?post_type=product'][$key][0] = 'Марки';
            }
        }
    }
}

// Меняем текст в заголовках страниц таксономий
add_filter( 'wp_terms_checklist_args', 'rename_taxonomy_checklist', 10, 2 );

function rename_taxonomy_checklist( $args, $post_id ) {
    if ( isset( $args['taxonomy'] ) ) {
        if ( $args['taxonomy'] === 'product_cat' ) {
            add_filter( 'gettext', function( $translated, $original, $domain ) {
                if ( $domain === 'woocommerce' ) {
                    if ( $original === 'Categories' ) {
                        return 'Страна';
                    }
                    if ( $original === 'Category' ) {
                        return 'Страна';
                    }
                }
                return $translated;
            }, 10, 3 );
        }
        if ( $args['taxonomy'] === 'product_tag' ) {
            add_filter( 'gettext', function( $translated, $original, $domain ) {
                if ( $domain === 'woocommerce' ) {
                    if ( $original === 'Tags' ) {
                        return 'Теги';
                    }
                    if ( $original === 'Tag' ) {
                        return 'Тег';
                    }
                }
                return $translated;
            }, 10, 3 );
        }
    }
    return $args;
}

// Переименование табов на странице редактирования товара
add_filter( 'woocommerce_product_data_tabs', 'rename_product_data_tabs' );

function rename_product_data_tabs( $tabs ) {
    if ( isset( $tabs['attributes'] ) ) {
        $tabs['attributes']['label'] = 'Характеристики';
    }
    return $tabs;
}
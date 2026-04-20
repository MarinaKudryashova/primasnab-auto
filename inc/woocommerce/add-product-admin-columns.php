<?php
/**
 * Добавление колонок в админ-таблицу товаров WooCommerce
 * ПОРЯДОК КОЛОНОК:
 * cb, thumb, name, sku, price, product_cat, year_attribute, 
 * product_tag, taxonomy-product_brand, model_attribute, 
 * featured, menu_order, date
 */

// ============================================================
// 1. ВКЛЮЧАЕМ КОЛОНКУ "ПОРЯДОК" (ЕЁ НЕТ ПО УМОЛЧАНИЮ)
// ============================================================
add_filter( 'manage_edit-product_columns', 'add_menu_order_column', 5 );

function add_menu_order_column( $columns ) {
    if ( ! isset( $columns['menu_order'] ) ) {
        $new_columns = [];
        foreach ( $columns as $key => $value ) {
            $new_columns[$key] = $value;
            if ( $key === 'date' ) {
                $new_columns['menu_order'] = 'Порядок';
            }
        }
        return $new_columns;
    }
    return $columns;
}

// ============================================================
// 2. НАСТРАИВАЕМ ПОРЯДОК КОЛОНОК (ВАШ ТОЧНЫЙ ПОРЯДОК)
// ============================================================
add_filter( 'manage_edit-product_columns', 'customize_columns_order', 999 );

function customize_columns_order( $columns ) {
    // ТОЧНЫЙ ПОРЯДОК КОЛОНОК
    $desired_order = [
        'cb',                        // 1. Чекбокс
        'thumb',                     // 2. Картинка
        'name',                      // 3. Имя
        'sku',                       // 4. Артикул
        'price',                     // 5. Цена
        'product_cat',               // 6. Страна
        'year_attribute',            // 7. Год выпуска
        'product_tag',               // 8. Теги
        'taxonomy-product_brand',    // 9. Марки
        'model_attribute',           // 10. Модель
        'featured',                  // 11. Рекомендуемое
        'menu_order',                // 12. Порядок
        'date',                      // 13. Дата
    ];
    
    $new_columns = [];
    
    // Собираем колонки в заданном порядке
    foreach ( $desired_order as $col_key ) {
        if ( $col_key === 'year_attribute' ) {
            $new_columns['year_attribute'] = 'Год выпуска';
        } elseif ( $col_key === 'model_attribute' ) {
            $new_columns['model_attribute'] = 'Модель';
        } elseif ( isset( $columns[ $col_key ] ) ) {
            $new_columns[ $col_key ] = $columns[ $col_key ];
        }
    }
    
    // Добавляем остальные колонки, которые не вошли в порядок (на всякий случай)
    foreach ( $columns as $key => $value ) {
        if ( ! isset( $new_columns[ $key ] ) ) {
            $new_columns[ $key ] = $value;
        }
    }
    
    return $new_columns;
}

// ============================================================
// 3. ЗАПОЛНЯЕМ КОЛОНКИ ДАННЫМИ
// ============================================================
add_action( 'manage_product_posts_custom_column', 'render_product_attributes_columns', 10, 2 );

function render_product_attributes_columns( $column, $post_id ) {
    $product = wc_get_product( $post_id );
    
    if ( ! $product ) {
        return;
    }
    
    switch ( $column ) {
        case 'year_attribute':
            $year = $product->get_attribute( 'car-year' );
            if ( empty( $year ) ) {
                $year = get_post_meta( $post_id, 'attribute_car-year', true );
            }
            if ( empty( $year ) ) {
                $year = get_post_meta( $post_id, 'pa_car-year', true );
            }
            echo esc_html( $year );
            break;
            
        case 'model_attribute':
            $model = $product->get_attribute( 'model' );
            if ( empty( $model ) ) {
                $model = get_post_meta( $post_id, 'attribute_model', true );
            }
            if ( empty( $model ) ) {
                $model = get_post_meta( $post_id, 'pa_model', true );
            }
            echo esc_html( $model );
            break;
            
        case 'menu_order':
            $order = get_post_field( 'menu_order', $post_id );
            echo intval( $order );
            break;
    }
}

// ============================================================
// 4. ПЕРЕИМЕНОВАНИЕ ЗАГОЛОВКОВ КОЛОНОК
// ============================================================
add_filter( 'gettext', 'rename_column_headers', 20, 3 );

function rename_column_headers( $translated, $original, $domain ) {
    if ( $domain === 'woocommerce' && is_admin() ) {
        $renames = [
            'Product categories' => 'Страна',
            'Categories' => 'Страна',
            'Category' => 'Страна',
            'Product brands' => 'Марки',
            'Brands' => 'Марки',
            'Brand' => 'Марка',
            'SKU' => 'Артикул',
            'Price' => 'Цена',
            'Stock' => 'Остаток',
            'Date' => 'Дата',
            'Featured' => 'Рекомендуемое',
            'Tags' => 'Теги',
        ];
        
        if ( isset( $renames[ $original ] ) ) {
            return $renames[ $original ];
        }
    }
    return $translated;
}

// ============================================================
// 5. ДОБАВЛЯЕМ СОРТИРОВКУ ДЛЯ НОВЫХ КОЛОНОК
// ============================================================
add_filter( 'manage_edit-product_sortable_columns', 'make_custom_columns_sortable' );

function make_custom_columns_sortable( $columns ) {
    $columns['year_attribute'] = 'year_attribute';
    $columns['model_attribute'] = 'model_attribute';
    return $columns;
}

// Обработка сортировки
add_action( 'pre_get_posts', 'sort_custom_columns' );

function sort_custom_columns( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() || $query->get( 'post_type' ) !== 'product' ) {
        return;
    }
    
    $orderby = $query->get( 'orderby' );
    
    if ( $orderby === 'year_attribute' ) {
        $query->set( 'meta_key', 'attribute_car-year' );
        $query->set( 'orderby', 'meta_value' );
    }
    
    if ( $orderby === 'model_attribute' ) {
        $query->set( 'meta_key', 'attribute_model' );
        $query->set( 'orderby', 'meta_value' );
    }
}

// ============================================================
// 6. СТИЛИ ДЛЯ КОЛОНОК
// ============================================================
add_action( 'admin_head', function() {
    $screen = get_current_screen();
    if ( $screen && $screen->id === 'edit-product' ) {
        echo '<style>
            .wp-list-table .column-menu_order { width: 70px; text-align: center; }
            .wp-list-table .column-year_attribute { width: 100px; }
            .wp-list-table .column-model_attribute { width: 120px; }
            .wp-list-table .column-product_tag { width: 100px; }
            .wp-list-table .column-featured { width: 80px; text-align: center; }
        </style>';
    }
});
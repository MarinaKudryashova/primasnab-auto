<?php
/**
 * Добавление фильтра по году выпуска (атрибут car-year) 
 * на страницу "Все товары" в админке WooCommerce
 * Фильтр размещается ПОСЛЕ фильтра брендов
 */

// 1. ДОБАВЛЯЕМ ВЫПАДАЮЩИЙ СПИСОК ДЛЯ ФИЛЬТРАЦИИ ПО ГОДУ
add_action( 'restrict_manage_posts', 'add_year_filter_dropdown', 20 );

function add_year_filter_dropdown() {
    global $typenow;
    
    if ( $typenow !== 'product' ) {
        return;
    }
    
    $years = get_all_years_values();
    
    if ( empty( $years ) ) {
        return;
    }
    
    $selected_year = isset( $_GET['filter_year'] ) ? sanitize_text_field( $_GET['filter_year'] ) : '';
    
    echo '<select name="filter_year" style="margin-left: 5px;">';
    echo '<option value="">Все годы выпуска</option>';
    
    foreach ( $years as $year ) {
        if ( empty( $year ) ) {
            continue;
        }
        printf(
            '<option value="%s" %s>%s</option>',
            esc_attr( $year ),
            selected( $selected_year, $year, false ),
            esc_html( $year )
        );
    }
    
    echo '</select>';
}

// 2. ПОЛУЧАЕМ ВСЕ УНИКАЛЬНЫЕ ЗНАЧЕНИЯ АТРИБУТА "ГОД ВЫПУСКА"
function get_all_years_values() {
    global $wpdb;
    
    $years = [];
    
    // 1. Пытаемся получить из таксономии (глобальный атрибут)
    $tax_years = $wpdb->get_col( "
        SELECT DISTINCT t.name
        FROM {$wpdb->terms} t
        INNER JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id
        WHERE tt.taxonomy = 'pa_car-year'
        AND t.name != ''
        ORDER BY t.name DESC
    " );
    
    if ( ! empty( $tax_years ) ) {
        $years = $tax_years;
    }
    
    // 2. Если нет в таксономии, ищем в мета-полях
    if ( empty( $years ) ) {
        $meta_years = $wpdb->get_col( "
            SELECT DISTINCT meta_value
            FROM {$wpdb->postmeta}
            WHERE meta_key IN ( 'attribute_car-year' )
            AND meta_value != ''
            ORDER BY meta_value DESC
        " );
        $years = $meta_years;
    }
    
    return $years;
}

// 3. ОБРАБАТЫВАЕМ ФИЛЬТРАЦИЮ 
add_action( 'pre_get_posts', 'filter_products_by_year' );

function filter_products_by_year( $query ) {
    global $pagenow;
    
    if ( ! is_admin() || $pagenow !== 'edit.php' || $query->get( 'post_type' ) !== 'product' || ! $query->is_main_query() ) {
        return;
    }
    
    $filter_year = isset( $_GET['filter_year'] ) ? sanitize_text_field( $_GET['filter_year'] ) : '';
    
    if ( empty( $filter_year ) ) {
        return;
    }
    
    // ПРОВЕРЯЕМ: если атрибут глобальный (таксономия)
    $is_taxonomy = taxonomy_exists( 'pa_car-year' );
    
    if ( $is_taxonomy ) {
        // Фильтрация через таксономию (глобальный атрибут)
        $tax_query = $query->get( 'tax_query' );
        if ( ! is_array( $tax_query ) ) {
            $tax_query = [];
        }
        
        $tax_query[] = [
            'taxonomy' => 'pa_car-year',
            'field'    => 'name',
            'terms'    => $filter_year,
        ];
        
        $query->set( 'tax_query', $tax_query );
        
    } else {
        // Фильтрация через мета-поля (локальный атрибут)
        $meta_query = $query->get( 'meta_query' );
        if ( ! is_array( $meta_query ) ) {
            $meta_query = [];
        }
        
        $meta_query[] = [
            'key'     => 'attribute_car-year',
            'value'   => $filter_year,
            'compare' => '=',
        ];
        
        $query->set( 'meta_query', $meta_query );
    }
}


/**
 * Добавление кнопки "Сбросить фильтр" для всех фильтров
 * на странице "Все товары" в админке WooCommerce
 */

add_action( 'restrict_manage_posts', 'add_reset_filter_button', 30 );

function add_reset_filter_button() {
    global $typenow;
    
    // Только для товаров
    if ( $typenow !== 'product' ) {
        return;
    }
    
    // Проверяем, есть ли активные фильтры
    $has_active_filters = false;
    
    // Список параметров фильтров, которые нужно проверять
    $filter_params = [
        'product_cat',           // Страна
        'product_brand',         // Марка
        'filter_year',           // Год выпуска
        'product_type',          // Тип товара
        'stock_status',          // Статус запасов
        'post_status',           // Статус поста
    ];
    
    foreach ( $filter_params as $param ) {
        if ( isset( $_GET[ $param ] ) && ! empty( $_GET[ $param ] ) ) {
            $has_active_filters = true;
            break;
        }
    }
    
    // Если есть активные фильтры, показываем кнопку сброса
    if ( $has_active_filters ) {
        $reset_url = remove_query_arg( $filter_params );
        echo '<a href="' . esc_url( $reset_url ) . '" class="button" style="margin-left: 5px;">Сбросить все фильтры</a>';
    }
}


/**
 * Скрытие фильтров на странице "Все товары" в админке WooCommerce
 * - Скрыть фильтр "Тип товара" (product_type)
 * - Скрыть фильтр "Статус запасов" (stock_status - В наличии / Нет в наличии)
 */

add_action( 'admin_head', 'hide_product_filters_css' );

function hide_product_filters_css() {
    $screen = get_current_screen();
    
    // Применяем только на странице списка товаров
    if ( $screen && $screen->id === 'edit-product' ) {
        echo '<style>
            /* Скрываем фильтр "Все типы товаров" */
            select[name="product_type"],
            .tablenav .actions select[name="product_type"] {
                display: none !important;
            }
            
            /* Скрываем фильтр "Статус запасов" (В наличии / Нет в наличии) */
            select[name="stock_status"],
            .tablenav .actions select[name="stock_status"] {
                display: none !important;
            }
            
            /* Скрываем стандартный фильтр статуса поста (на всякий случай) */
            select[name="post_status"],
            .tablenav .actions select[name="post_status"] {
                display: none !important;
            }
        </style>';
    }
}


/**
 * Переименование фильтров на странице "Все товары" в админке WooCommerce
 * - "Выбрать категорию" → "Выбрать страну"
 * - "Выбрать бренд" → "Выбрать марку"
 */

add_filter( 'gettext', 'rename_admin_filters_labels', 999, 3 );
add_filter( 'gettext_with_context', 'rename_admin_filters_labels_with_context', 999, 4 );

function rename_admin_filters_labels( $translated, $original, $domain ) {
    if ( ! is_admin() ) {
        return $translated;
    }
    
    global $pagenow;
    
    // Только на странице списка товаров
    if ( $pagenow === 'edit.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] === 'product' ) {
        
        // Переименование фильтра категорий → страна
        $category_strings = [
            'Select category',
            'Select a category',
            'All categories',
            'Filter by category',
            'Выбрать категорию',
            'Все категории',
        ];
        
        if ( in_array( $original, $category_strings ) ) {
            return 'Выбрать страну';
        }
        
        // Переименование фильтра брендов → марка
        $brand_strings = [
            'Select brand',
            'Select a brand',
            'All brands',
            'Filter by brand',
            'Выбрать бренд',
            'Все бренды',
        ];
        
        if ( in_array( $original, $brand_strings ) ) {
            return 'Выбрать марку';
        }
        
        // Отдельные случаи
        if ( $original === 'All categories' ) {
            return 'Все страны';
        }
        
        if ( $original === 'All brands' ) {
            return 'Все марки';
        }
    }
    
    return $translated;
}

function rename_admin_filters_labels_with_context( $translated, $original, $context, $domain ) {
    if ( ! is_admin() ) {
        return $translated;
    }
    
    global $pagenow;
    
    if ( $pagenow === 'edit.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] === 'product' ) {
        
        if ( $context === 'category' && $original === 'All' ) {
            return 'Все страны';
        }
        
        if ( $context === 'brand' && $original === 'All' ) {
            return 'Все марки';
        }
        
        if ( $original === 'Select category' ) {
            return 'Выбрать страну';
        }
        
        if ( $original === 'Select brand' ) {
            return 'Выбрать марку';
        }
    }
    
    return $translated;
}

<?php 

/* Создание кастомного типа записи Лицензии */
add_action( 'init', 'licenses_register_post_types' );

function licenses_register_post_types(){

	$labels = array(
		'name'                  => _x( 'Лицензии', 'Post Type General Name', 'primasnab' ),
		'singular_name'         => _x( 'Лицензия', 'Post Type Singular Name', 'primasnab' ),
		'menu_name'             => __( 'Лицензии', 'primasnab' ),
		'name_admin_bar'        => __( 'Лицензии', 'primasnab' ),
		'add_new_item'          => __( 'Добавить новую лицензию', 'primasnab' ),
		'add_new'               => __( 'Добавить новую', 'primasnab' ),
		'new_item'              => __( 'Новая лицензия', 'primasnab' ),
		'edit_item'             => __( 'Изменить лицензию', 'primasnab' ),
		'view_item'             => __( 'Посмотреть лицензию', 'primasnab' ),
		'view_items'            => __( 'Посмотреть все лицензии', 'primasnab' ),
		'search_items'          => __( 'Поиск лицензии', 'primasnab' ),
		'not_found'             => __( 'Не найдено', 'primasnab' ),
		'not_found_in_trash'    => __( 'Не найдено в удаленных', 'primasnab' ),
);
	
	$args = array(
		'label'                 => __( 'Лицензии', 'primasnab' ),
		'labels'                => $labels,
		'description'           => __( 'Список лицензий', 'primasnab' ),
		'public'                => true,
		'publicly_queryable'    => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'show_in_rest'          => true,
		'menu_position'         => 4,
		'menu_icon'             => 'dashicons-editor-help',
		'capability_type'       => 'post',
		'supports'              => array('title', 'thumbnail', 'post-formats'), //'page-attributes', 'custom-fields'
		'taxonomies'            => array(),
		'has_archive'           => false,
		'can_export'            => true,
);
	
register_post_type( 'licenses', $args );

}

/* Добавляем колонку "Порядок" в админке */
add_filter( 'manage_licenses_posts_columns', 'licenses_add_order_column' );
function licenses_add_order_column( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $value ) {
        $new_columns[$key] = $value;
        if ( $key === 'title' ) {
            $new_columns['menu_order'] = __( 'Order', 'primasnab' );
        }
    }
    return $new_columns;
}

add_action( 'manage_licenses_posts_custom_column', 'licenses_show_order_column', 10, 2 );
function licenses_show_order_column( $column_name, $post_id ) {
    if ( $column_name === 'menu_order' ) {
        echo get_post_field( 'menu_order', $post_id );
    }
}

/* Делаем колонку "Порядок" сортируемой */
add_filter( 'manage_edit-licenses_sortable_columns', 'licenses_make_order_column_sortable' );
function licenses_make_order_column_sortable( $columns ) {
    $columns['menu_order'] = 'menu_order';
    return $columns;
}
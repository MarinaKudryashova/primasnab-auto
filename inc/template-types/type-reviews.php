<?php 

/* Создание кастомного типа записи Отзывы */

add_action( 'init', 'reviews_register_post_types' );

function reviews_register_post_types(){

	$labels = array(
		'name'                  => _x( 'Отзывы', 'Post Type General Name', 'primasnab' ),
		'singular_name'         => _x( 'Отзыв', 'Post Type Singular Name', 'primasnab' ),
		'menu_name'             => __( 'Отзывы', 'primasnab' ),
		'name_admin_bar'        => __( 'Отзывы', 'primasnab' ),
		'add_new_item'          => __( 'Добавить новый отзыв', 'primasnab' ),
		'add_new'               => __( 'Добавить новый', 'primasnab' ),
		'new_item'              => __( 'Новый отзыв', 'primasnab' ),
		'edit_item'             => __( 'Редактировать отзыв', 'primasnab' ),
		'view_item'             => __( 'Просмотреть отзыв', 'primasnab' ),
		'view_items'            => __( 'Просмотреть все отзывы', 'primasnab' ),
		'search_items'          => __( 'Искать отзывы', 'primasnab' ),
		'not_found'             => __( 'Отзывы не найдены', 'primasnab' ),
		'not_found_in_trash'    => __( 'Отзывы не найдены в корзине', 'primasnab' ),
	);
	
	$args = array(
		'label'                 => __( 'Отзывы', 'primasnab' ),
		'labels'                => $labels,
		'description'           => __( 'Отзывы клиентов', 'primasnab' ),
		'public'                => false,
		'publicly_queryable'    => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'show_in_rest'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-testimonial',
		'capability_type'       => 'post',
		'supports'              => array('title', 'custom-fields', 'page-attributes'),
		'taxonomies'            => array(),
		'has_archive'           => false,
		'can_export'            => true,
		'rewrite'               => false,
		'query_var'             => false,
	);
	
	register_post_type( 'reviews', $args );
}
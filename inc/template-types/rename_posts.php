<?php 
//события(блог, новости)
## заменим слово «записи» на «события»
add_filter('post_type_labels_post', 'rename_posts_labels');
function rename_posts_labels( $labels ){
	// заменять автоматически не пойдет например заменили: Запись = Статья, а в тесте получится так "Просмотреть статья"
	$new = array(
		'name'                  => _x( 'Блог', 'primasnab' ),
		'singular_name'         => _x( 'Статья', 'primasnab' ),
		'add_new'               => __( 'Добавить статья', 'primasnab' ),
		'add_new_item'          => __( 'Добавить новое статья', 'primasnab' ),
		'edit_item'             => __( 'Редактировать статья', 'primasnab' ),
		'new_item'              => __( 'Новое статья', 'primasnab' ),
		'view_item'             => __( 'Посмотреть статья', 'primasnab' ),
		'search_items'          => __( 'Поиск статей', 'primasnab' ),
		'not_found'             => __( 'Статей не найдено.', 'primasnab' ),
		'parent_item_colon'     => '',
		'all_items'             => __( 'Все статьи', 'primasnab' ),
		'archives'              => __( 'Архив статей', 'primasnab' ),
		'menu_name'             => __( 'Блог', 'primasnab' ),
		'name_admin_bar'        => __( 'Статья', 'primasnab' ), // пункте "добавить"
	);

	return (object) array_merge( (array) $labels, $new );
}
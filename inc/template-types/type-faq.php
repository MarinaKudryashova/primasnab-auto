<?php 

/* Создание кастомного типа записи FAQ */

add_action( 'init', 'faq_register_post_types' );

function faq_register_post_types(){

	$labels = array(
		'name'                  => _x( 'FAQ', 'Post Type General Name', 'primasnab' ),
		'singular_name'         => _x( 'Вопрос', 'Post Type Singular Name', 'primasnab' ),
		'menu_name'             => __( 'FAQ', 'primasnab' ),
		'name_admin_bar'        => __( 'FAQ', 'primasnab' ),
		'add_new_item'          => __( 'Добавить новый вопрос', 'primasnab' ),
		'add_new'               => __( 'Добавить новый', 'primasnab' ),
		'new_item'              => __( 'Новый вопрос', 'primasnab' ),
		'edit_item'             => __( 'Редактировать вопрос', 'primasnab' ),
		'view_item'             => __( 'Просмотреть вопрос', 'primasnab' ),
		'view_items'            => __( 'Просмотреть все вопросы', 'primasnab' ),
		'search_items'          => __( 'Искать вопросы', 'primasnab' ),
		'not_found'             => __( 'Вопросы не найдены', 'primasnab' ),
		'not_found_in_trash'    => __( 'Вопросы не найдены в корзине', 'primasnab' ),
	);
	
	$args = array(
		'label'                 => __( 'FAQ', 'primasnab' ),
		'labels'                => $labels,
		'description'           => __( 'Часто задаваемые вопросы', 'primasnab' ),
		'public'                => false,
		'publicly_queryable'    => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'show_in_rest'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-editor-help',
		'capability_type'       => 'post',
		'supports'              => array('title', 'editor'),
		'taxonomies'            => array('faq_category'),
		'has_archive'           => false,
		'can_export'            => true,
		'rewrite'               => false,
		'query_var'             => false,
	);
	
	register_post_type( 'faq', $args );
}

add_action( 'init', 'faq_register_taxonomy' );

function faq_register_taxonomy() {
	
	$labels = array(
		'name'                       => _x( 'Категории', 'Taxonomy General Name', 'primasnab' ),
		'singular_name'              => _x( 'Категория', 'Taxonomy Singular Name', 'primasnab' ),
		'menu_name'                  => __( 'Категории', 'primasnab' ),
		'all_items'                  => __( 'Все категории', 'primasnab' ),
		'parent_item'                => __( 'Родительская категория', 'primasnab' ),
		'parent_item_colon'          => __( 'Родительская категория:', 'primasnab' ),
		'new_item_name'              => __( 'Новое название категории', 'primasnab' ),
		'add_new_item'               => __( 'Добавить новую категорию', 'primasnab' ),
		'edit_item'                  => __( 'Редактировать категорию', 'primasnab' ),
		'update_item'                => __( 'Обновить категорию', 'primasnab' ),
		'view_item'                  => __( 'Просмотреть категорию', 'primasnab' ),
		'separate_items_with_commas' => __( 'Разделяйте категории запятыми', 'primasnab' ),
		'add_or_remove_items'        => __( 'Добавить или удалить категории', 'primasnab' ),
		'choose_from_most_used'      => __( 'Выбрать из часто используемых', 'primasnab' ),
		'popular_items'              => __( 'Популярные категории', 'primasnab' ),
		'search_items'               => __( 'Искать категории', 'primasnab' ),
		'not_found'                  => __( 'Категории не найдены', 'primasnab' ),
		'no_terms'                   => __( 'Нет категорий', 'primasnab' ),
		'items_list'                 => __( 'Список категорий', 'primasnab' ),
		'items_list_navigation'      => __( 'Навигация по списку категорий', 'primasnab' ),
	);
	
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => false,
		'publicly_queryable'         => false,
		'show_ui'                    => true,
		'show_in_menu'               => true,
		'show_in_nav_menus'          => false,
		'show_in_rest'               => true,
		'show_admin_column'          => true,
		'show_tagcloud'              => false,
		'rewrite'                    => false,
		'query_var'                  => false,
	);
	
	register_taxonomy( 'faq_category', array( 'faq' ), $args );
}

// Добавляем метабокс с полем "Порядок"
add_action( 'add_meta_boxes', 'faq_add_order_meta_box' );

function faq_add_order_meta_box() {
	add_meta_box(
		'faq_order',
		__( 'Порядок', 'primasnab' ),
		'faq_order_meta_box_callback',
		'faq',
		'side',
		'default'
	);
}

function faq_order_meta_box_callback( $post ) {
	$order = get_post_meta( $post->ID, '_faq_order', true );
	?>
	<label for="faq_order_field">
		<?php _e( 'Порядок сортировки (меньше = выше позиция):', 'primasnab' ); ?>
	</label>
	<input type="number" 
	       name="faq_order_field" 
	       id="faq_order_field" 
	       value="<?php echo esc_attr( $order ?: 0 ); ?>" 
	       style="width: 100%; margin-top: 10px;" 
	       step="1" 
	       min="0" />
	<?php
}

// Сохраняем поле "Порядок"
add_action( 'save_post_faq', 'faq_save_order_meta' );

function faq_save_order_meta( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	
	if ( isset( $_POST['faq_order_field'] ) ) {
		$order = intval( $_POST['faq_order_field'] );
		update_post_meta( $post_id, '_faq_order', $order );
	}
}

// Добавляем колонку "Порядок" после колонки "FAQ Categories"
add_filter( 'manage_faq_posts_columns', 'faq_add_order_column' );

function faq_add_order_column( $columns ) {
	$new_columns = array();
	
	foreach ( $columns as $key => $value ) {
		$new_columns[$key] = $value;
		
		// Вставляем колонку Order после колонки taxonomies (faq_category)
		if ( $key === 'taxonomy-faq_category' ) {
			$new_columns['order'] = __( 'Order', 'primasnab' );
		}
	}
	
	return $new_columns;
}

// Заполняем колонку "Порядок"
add_action( 'manage_faq_posts_custom_column', 'faq_display_order_column', 10, 2 );

function faq_display_order_column( $column, $post_id ) {
	if ( $column === 'order' ) {
		$order = get_post_meta( $post_id, '_faq_order', true );
		echo esc_html( $order ?: '—' );
	}
}

// Делаем колонку "Порядок" сортируемой
add_filter( 'manage_edit-faq_sortable_columns', 'faq_make_order_column_sortable' );

function faq_make_order_column_sortable( $columns ) {
	$columns['order'] = 'order';
	return $columns;
}

// Настраиваем сортировку по полю "Порядок"
add_action( 'pre_get_posts', 'faq_order_by_meta' );

function faq_order_by_meta( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}
	
	if ( $query->get( 'post_type' ) !== 'faq' ) {
		return;
	}
	
	$orderby = $query->get( 'orderby' );
	
	if ( $orderby === 'order' ) {
		$query->set( 'meta_key', '_faq_order' );
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'order', 'ASC' );
	}
}

// Добавляем поле Order в быстром редактировании
add_action( 'quick_edit_custom_box', 'faq_add_order_quick_edit', 10, 2 );

function faq_add_order_quick_edit( $column_name, $post_type ) {
	if ( $post_type !== 'faq' || $column_name !== 'order' ) {
		return;
	}
	
	wp_nonce_field( 'faq_quick_edit_nonce', 'faq_quick_edit_nonce' );
	?>
	<fieldset class="inline-edit-col-right">
		<div class="inline-edit-col">
			<label class="inline-edit-group">
				<span class="title"><?php _e( 'Порядок', 'primasnab' ); ?></span>
				<span class="input-text-wrap">
					<input type="number" name="faq_order" id="faq_order" value="" step="1" min="0" />
				</span>
			</label>
		</div>
	</fieldset>
	<?php
}

// Сохраняем поле Order при быстром редактировании
add_action( 'save_post_faq', 'faq_save_quick_edit_order' );

function faq_save_quick_edit_order( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	
	if ( ! isset( $_POST['faq_quick_edit_nonce'] ) || ! wp_verify_nonce( $_POST['faq_quick_edit_nonce'], 'faq_quick_edit_nonce' ) ) {
		return;
	}
	
	if ( isset( $_POST['faq_order'] ) ) {
		$order = intval( $_POST['faq_order'] );
		update_post_meta( $post_id, '_faq_order', $order );
	}
}

// Добавляем JavaScript для быстрого редактирования
add_action( 'admin_footer-edit.php', 'faq_quick_edit_javascript' );

function faq_quick_edit_javascript() {
	global $current_screen;
	
	if ( $current_screen->post_type !== 'faq' ) {
		return;
	}
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		var $wp_inline_edit = inlineEditPost.edit;
		
		inlineEditPost.edit = function(id) {
			$wp_inline_edit.apply(this, arguments);
			var post_id = 0;
			
			if (typeof(id) == 'object') {
				post_id = parseInt(this.getId(id));
			}
			
			if (post_id > 0) {
				var editRow = $('#edit-' + post_id);
				var postRow = $('#post-' + post_id);
				
				var order = postRow.find('.order').text();
				
				if (order !== '—') {
					editRow.find('input[name="faq_order"]').val(order);
				} else {
					editRow.find('input[name="faq_order"]').val('');
				}
			}
		};
	});
	</script>
	<style>
		/* Стили для колонки Order */
		.widefat .column-order {
			width: 80px;
			text-align: center;
		}
		/* Стили для поля в быстром редактировании */
		.inline-edit-group .title {
			width: 6em;
		}
		.inline-edit-group input[name="faq_order"] {
			width: 80px;
		}
	</style>
	<?php
}

// Добавляем фильтр по категориям в админке
add_action( 'restrict_manage_posts', 'faq_add_category_filter' );

function faq_add_category_filter() {
	global $typenow;
	
	if ( $typenow !== 'faq' ) {
		return;
	}
	
	$taxonomy = 'faq_category';
	$selected = isset( $_GET[$taxonomy] ) ? $_GET[$taxonomy] : '';
	
	wp_dropdown_categories( array(
		'show_option_all' => __( 'Все категории', 'primasnab' ),
		'taxonomy'        => $taxonomy,
		'name'            => $taxonomy,
		'value_field'     => 'slug',
		'selected'        => $selected,
		'show_count'      => true,
		'hide_empty'      => false,
	) );
}

// Применяем фильтр по категориям
add_filter( 'parse_query', 'faq_apply_category_filter' );

function faq_apply_category_filter( $query ) {
	global $pagenow;
	
	if ( ! is_admin() || $pagenow !== 'edit.php' ) {
		return $query;
	}
	
	if ( $query->get( 'post_type' ) !== 'faq' ) {
		return $query;
	}
	
	$taxonomy = 'faq_category';
	
	if ( isset( $_GET[$taxonomy] ) && ! empty( $_GET[$taxonomy] ) ) {
		$tax_query = array(
			array(
				'taxonomy' => $taxonomy,
				'field'    => 'slug',
				'terms'    => sanitize_text_field( $_GET[$taxonomy] ),
			),
		);
		
		$query->set( 'tax_query', $tax_query );
	}
	
	return $query;
}

// Устанавливаем сортировку по умолчанию для FAQ (по полю order)
add_action( 'wp_loaded', 'faq_set_default_sort_order' );

function faq_set_default_sort_order() {
	global $wp_query;
	
	if ( is_admin() && isset( $wp_query->query['post_type'] ) && $wp_query->query['post_type'] === 'faq' ) {
		if ( ! isset( $_GET['orderby'] ) ) {
			add_filter( 'pre_get_posts', function( $query ) {
				if ( $query->is_main_query() && $query->get( 'post_type' ) === 'faq' ) {
					$query->set( 'meta_key', '_faq_order' );
					$query->set( 'orderby', 'meta_value_num' );
					$query->set( 'order', 'ASC' );
				}
			} );
		}
	}
}
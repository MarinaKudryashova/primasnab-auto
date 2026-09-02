<?php

/**
 * primasnab functions and definitions
 * @package primasnab
 * Author: Cosmo Design
 * Telegram: @cosmo_dsgn
 * Email: info@cosmo-design.com
 * Site: http://cosmo-design.com
 */

if (! defined('_S_VERSION')) {
	$theme = wp_get_theme();
	define('_S_VERSION', $theme->get('Version'));
}

/**
 * Функцию для загрузки темы
 * 
 * Sets up theme defaults and registers support for various WordPress features.
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function primasnab_setup()
{
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_post_type_support('post', 'page-attributes');
	add_post_type_support('page', array('excerpt'));
	register_nav_menus([
		'header' => esc_html__("Main menu", 'primasnab'),
		'footer' => esc_html__("Footer menu", 'primasnab'),
		'footer_policies' => esc_html__("Policies", 'primasnab'),
	]);
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support('woocommerce');
	add_theme_support('wc-product-grid');
	// Add theme support for selective refresh for widgets.
	// add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action('after_setup_theme', 'primasnab_setup');

/**
 * Функцию для загрузки переводов
 */
function primasnab_load_textdomain()
{
	load_theme_textdomain('primasnab', get_template_directory() . '/languages');
}

add_action('init', 'primasnab_load_textdomain');


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
// function primasnab_content_width() {
// 	$GLOBALS['content_width'] = apply_filters( 'primasnab_content_width', 640 );
// }
// add_action( 'after_setup_theme', 'primasnab_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function primasnab_widgets_init()
{
	// Сайдбар "Фильтр" для товаров
	register_sidebar(
		array(
			'name'          => esc_html__('Фильтр', 'primasnab'),
			'id'            => 'filter-product',
			'description'   => esc_html__('Добавьте виджеты для фильтрации товаров.', 'primasnab'),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		)
	);

	// Сайдбар "Сортировка" для каталога
	register_sidebar(
		array(
			'name'          => esc_html__('Сортировка товаров', 'primasnab'),
			'id'            => 'sidebar-product-sort-options',
			'description'   => esc_html__('Добавьте виджеты для отображения сортировки.', 'primasnab'),
			'before_widget' => '<div id="%1$s" class="sort-options %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="sort-options__label" id="sortLabel">',
			'after_title'   => '</span>',
		)
	);

	// Сайдбар "Активные фильтры" для каталога
	register_sidebar(
		array(
			'name'          => esc_html__('Активные фильтры', 'primasnab'),
			'id'            => 'sidebar-active-filters',
			'description'   => esc_html__('Добавьте виджеты для отображения активных фильтров.', 'primasnab'),
			'before_widget' => '<div id="active-filters" class="catalog__active-filters active-filters %2$s" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="visually-hidden">',
			'after_title'   => '</span>',
		)
	);
}
add_action('widgets_init', 'primasnab_widgets_init');

/**
 * ОТКЛЮЧЕНИЕ КОММЕНТАРИЕВ ПОЛНОСТЬЮ
 */
function healthypaw_disable_comments()
{
	// 1. Отключаем поддержку комментариев
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		if (post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}

	// 2. Закрываем все комментарии
	add_filter('comments_open', '__return_false', 20, 2);
	add_filter('pings_open', '__return_false', 20, 2);

	// 3. Скрываем существующие
	add_filter('comments_array', '__return_empty_array', 10, 2);

	// 4. Удаляем из админки
	add_action('admin_menu', function () {
		remove_menu_page('edit-comments.php');
	});

	// 5. Удаляем из админ-бара
	add_action('wp_before_admin_bar_render', function () {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('comments');
	});
}

add_action('after_setup_theme', 'healthypaw_disable_comments');

/**
 * THEME STYLES & SCRIPTS
 */
function primasnab_styles_and_scripts()
{
	$css_path = get_template_directory_uri() . '/css/';
	$js_path = get_template_directory_uri() . '/js/';
	$ver = defined('_S_VERSION') ? _S_VERSION : wp_get_theme()->get('Version');
	if (defined('WP_DEBUG') && WP_DEBUG) {
		$ver = $ver . '.' . time();
	}

	// основные стили темы
	wp_enqueue_style('primasnab-style', get_stylesheet_uri(), array(), $ver);

	// дополнительные стили
	wp_enqueue_style('css-vendor', $css_path . 'vendor.css', array(), $ver); // стили (библиотеки)
	wp_enqueue_style('css-main', $css_path . 'main.css', array('css-vendor'), $ver); // основные стили темы

	// скрипт навигации	
	wp_enqueue_script('primasnab-navigation', get_template_directory_uri() . '/js/navigation.js', array(), $ver, true);

	// основные скрипты темы	
	wp_enqueue_script('js-main', $js_path . 'main.min.js', array(), $ver, array('in_footer' => true, 'strategy' => 'defer'));

	// Подключаем Яндекс.Карты на странице Контакты
	if (is_page('kontakty') || is_page_template('page-contacts.php')) {
		wp_enqueue_script(
			'yandex-maps',
			'https://api-maps.yandex.ru/2.1/?lang=ru_RU',
			array(),
			null,
			true
		);
	}

	// Локализация для JS
	wp_localize_script('primasnab-main', 'primasnab_ajax', array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('primasnab_nonce'),
		'theme_url' => get_template_directory_uri()
	));

	// Swiper на странице товара
	if (is_product()) {
		wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0');
		wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true);
	}
}
add_action('wp_enqueue_scripts', 'primasnab_styles_and_scripts');

/**
 * THEME EXTRAS
 */
// require_once get_template_directory() . '/inc/thumbnail.php'; // Подключаем функционал управления миниатюрами записей из общего списка записей в админ-панели WordPress
require_once get_template_directory() . '/inc/theme-svg.php'; // Добавляет поддержку SVG изображений в медиабиблиотеку
require_once get_template_directory() . '/inc/disable_default_image_sizes.php'; // Отключаем только конкретные стандартные размеры изображений
require_once get_template_directory() . '/inc/the_picture_element.php'; // Отключаем только конкретные стандартные размеры изображений
require_once get_template_directory() . '/inc/post-options.php';
require_once get_template_directory() . '/inc/BEM_Walker_Nav_Menu.php';
require_once get_template_directory() . '/inc/Footer_Menu_Walker.php';
require_once get_template_directory() . '/inc/theme-form-cf7.php';// модифицирует поведение Contact Form 7

/**
 * Post types & taxonomies
 */
require_once get_template_directory() . '/inc/template-types/type-faq.php'; // Подключаем функционал кастомного типа записи FAQ
require_once get_template_directory() . '/inc/template-types/type-reviews.php'; // Подключаем функционал кастомного типа записи Отзывы
// require_once get_template_directory() . '/inc/template-types/type-licenses.php'; // Подключаем функционал кастомного типа записи Лицензии

require_once get_template_directory() . '/inc/template-types/rename-product-brands.php'; // Переименовываем Woocommerce таксономии "Бренды" в "Марки"
require_once get_template_directory() . '/inc/template-types/rename-product-catalog.php'; // Переименовываем Woocommerce таксономии "Категории товаров" в "Страна"
require_once get_template_directory() . '/inc/template-types/rename-product-attributes.php'; // Переименовываем Woocommerce таксономии "Атрибуты" в "Характеристики"
require_once get_template_directory() . '/inc/template-types/rename-product-tags.php'; // Переименовываем Woocommerce таксономии "Метки" в "Теги"
// require_once get_template_directory() . '/inc/template-types/rename_posts.php'; // Переименовываем стандартный тип записи "Записи" в "Новости"/ "Блог"


/**
 * THEME EXTRAS FOR WOOCOMMERCE
 */
require_once get_template_directory() . '/inc/woocommerce/add-product-admin-columns.php';
require_once get_template_directory() . '/inc/woocommerce/add-product-admin-filters.php';
require_once get_template_directory() . '/inc/woocommerce/change_rub_currency_symbol.php'; //В WooCommerce меняем символ рубля с ₽ на р


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

add_filter('woocommerce_catalog_orderby', 'rename_sorting_options');
function rename_sorting_options($options)
{
	$options['menu_order'] = 'По умолчанию';
	$options['price']      = 'Дешевле';
	$options['price-desc'] = 'Дороже';
	return $options;
}

add_filter('woocommerce_catalog_orderby', 'remove_sorting_options');
function remove_sorting_options($options)
{
	unset($options['popularity']); // Удаляем сортировку по популярности
	unset($options['rating']);     // Удаляем сортировку по рейтингу
	unset($options['date']);     // Удаляем сортировку по дате
	return $options;
}

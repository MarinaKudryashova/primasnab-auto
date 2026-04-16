<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package primasnab
 */

$messanges = get_field('messengers_list', 'options'); /*-- Мессенджеры --*/

?>
<!doctype html>
<html <?php language_attributes(); ?> class="page">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="description" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo('description'); ?>">


  <!-- <link rel="apple-touch-icon" sizes="180x180" href="<?php //echo get_template_directory_uri();?>/favicons/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php //echo get_template_directory_uri();?>/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php //echo get_template_directory_uri();?>/favicons/favicon-16x16.png">
  <link rel="manifest" href="<?php //echo get_template_directory_uri();?>/site.webmanifest">

  <meta property="og:type" content="website">
  <meta property="og:site_name" content="<?php //echo esc_attr(get_bloginfo('name')); ?>">
  <meta property="og:title" content="<?php //echo esc_attr(wp_title('|', false, 'right') . get_bloginfo('name')); ?>">
  <meta property="og:description" content="<?php //bloginfo( 'name' ); ?> - <?php //bloginfo('description'); ?>">
  <meta property="og:image" content="<?php //echo get_template_directory_uri();?>/img/site-preview.jpg">
  <meta property="og:url" content="<?php //echo esc_url( home_url( '/' ) ); ?>">

  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="<?php //echo esc_url( home_url( '/' ) ); ?>">
  <meta name="twitter:title" content="<?php //bloginfo( 'name' ); ?>">
  <meta name="twitter:description"
    content="<?php //bloginfo( 'name' ); ?> - <?php //bloginfo('description'); ?>">
  <meta name="twitter:image" content="<?php echo get_template_directory_uri();?>/img/site-preview.jpg">

  <link rel="preload" href="<?php //echo get_template_directory_uri();?>/fonts/InterTight-Regular.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="<?php //echo get_template_directory_uri();?>/fonts/InterTight-Medium.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="<?php //echo get_template_directory_uri();?>/fonts/InterTight-SemiBold.woff2" as="font" type="font/woff2" crossorigin> -->

  <?php wp_head(); ?>
</head>

<body <?php body_class('page__body'); ?> 
	style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/bg/page-bg.png');background-repeat: repeat-y;background-position: top center;background-size: 100% auto;background-color: var(--body-bg);">
	<?php wp_body_open(); ?>
	<div class="page__container">
		<header class="header">
			<div class="header__container container" >
				<?php /*-- Логотип --*/ ?>
				<a href="<?php bloginfo('url'); ?>" class="header__logo logo">
					<img class="logo__img" src="<?php echo get_field('site_logo', 'option') ?>" alt="Logo <?php bloginfo('name'); ?>" width="152" height="50">
				</a>
				<?php /*-- Навигация --*/ ?>
				<div class="header__nav">
					<nav class="nav" title="main navigation" data-menu>
						<?php
							wp_nav_menu( [
								'theme_location'  => 'header',
								'menu'            => 'header',
								'container'       => false,
								'menu_class'      => false,
								'menu_id'         => '',
								'echo'            => true,
								'fallback_cb'     => 'wp_page_menu',
								'before'          => '',
								'after'           => '',
								'link_before'     => '  ',
								'link_after'      => '',
								'items_wrap'      => '<ul>%3$s</ul>',
								'depth'           => 2,
								'walker'          => new BEM_Walker_Nav_Menu(),
							] );
						?>
						<?php /*-- Мессенджеры --*/ ?>
						<?php if($messanges) : ?>
							<ul class="header__messanges-md messanges" title="messanges">
								<?php foreach($messanges as $li) : ?>
									<li class="messanges__item"><a href="<?php  echo get_field($li['value'], 'options'); ?>" target="_blank" class="messanges__link" aria-label="Свяжитесь с нами в <?php echo $li['label']; ?>">
										<img loading="lazy" src="<?php echo get_template_directory_uri();?>/img/icon/<?php echo esc_html__($li['value']); ?>.svg" class="messanges__icon" width="40" height="40" alt="иконка <?php  echo $li['label']; ?>" aria-hidden="true">
									</a></li>
								<?php endforeach;	?>
							</ul>
						<?php endif; ?>

						<?php /*-- Кнопка с формой --*/ ?>
						<button type="button" class="header__callback-md ui-btn ui-btn--pink" data-graph-path="modal-leadform">Рассчитать стоимость</button>
					</nav>
				</div>
				<?php /*-- СТА --*/ ?>
				<?php
					$phone = get_field('company_tel', 'options');
					$phone = explode(PHP_EOL, $phone);
					$phone_href = preg_replace('![^0-9]+!', '', $phone);
				?>
				<div class="header__action">
					<?php /*-- Телефон --*/ ?>
					<?php if(!empty($phone[0]) && is_array($phone)) : ?>
					<a href="tel:<?php echo $phone_href[0]; ?>" class="header__phone" aria-label="Позвонить нам">
						<svg>
							<use xlink:href="<?php echo get_template_directory_uri();?>/img/sprite.svg#icon-phone"></use>
						</svg>
						<span><?php echo $phone[0]; ?></span>
					</a>
					<?php endif; ?>

					<?php /*-- Мессенджеры --*/ ?>
					<?php if($messanges) : ?>
						<ul class="header__messanges messanges" title="messanges">
							<?php foreach($messanges as $li) : ?>
								<li class="messanges__item"><a href="<?php  echo get_field($li['value'], 'options'); ?>" target="_blank" class="messanges__link" aria-label="Свяжитесь с нами в <?php echo $li['label']; ?>">
									<img loading="lazy" src="<?php echo get_template_directory_uri();?>/img/icon/<?php echo esc_html__($li['value']); ?>.svg" class="messanges__icon" width="40" height="40" alt="иконка <?php  echo $li['label']; ?>" aria-hidden="true">
								</a></li>
							<?php endforeach;	?>
						</ul>
					<?php endif; ?>

					<?php /*-- Кнопка с формой --*/ ?>
					<button type="button" class="header__callback ui-btn ui-btn--pink" data-graph-path="modal-leadform">Рассчитать стоимость</button>
					
					<?php /*-- Кнопка бургер --*/ ?>
					<div class="header__burger">
						<button class="burger" aria-label="Открыть меню" aria-expanded="false" data-burger>
							<span class="burger__line"></span>
						</button>
					</div>
				</div>
  		</div>
		</header>
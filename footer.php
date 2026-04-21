<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package primasnab
 */

?>

		<footer class="footer">
			<div class="footer__container container">
				<a href="<?php bloginfo('url'); ?>" class="footer__logo footer__logo--mobile" itemprop="url">
					<img src="<?php echo get_field('footer_logo', 'option') ?>" alt="Logo <?php bloginfo('name'); ?>" width="170" height="48" itemprop="logo image">
				</a>
				<div class="footer__col">
					<a href="<?php bloginfo('url'); ?>" class="footer__logo footer__logo--desktop" itemprop="url">
						<img src="<?php echo get_field('footer_logo', 'option') ?>" alt="Logo <?php bloginfo('name'); ?>" width="170" height="48" itemprop="logo image">
					</a>
					<p class="footer__copyright">&copy; <?php echo get_bloginfo('name') . ' ' . date('Y') . ' г.'; ?> Все права защищены.</p>
					<?php    
						wp_nav_menu( [
							'theme_location'  => 'footer_policies',
							'menu'            => 'footer_policies',
							'container'       => false,
							'menu_class'      => false,
							'menu_id'         => '',
							'echo'            => true,
							'fallback_cb'     => 'wp_page_menu',
							'before'          => '',
							'after'           => '',
							'link_before'     => '',
							'link_after'      => '',
							'items_wrap'      => '<ul class="%2$s footer-policies">%3$s</ul>',
							'depth'           => 1,
							'walker'          => '',
						] );
					?>
				</div>
				<div class="footer__col">
					<?php    
						wp_nav_menu( [
							'theme_location'  => 'footer',
							'menu'            => 'footer',
							'container'       => false,
							'menu_class'      => false,
							'menu_id'         => '',
							'echo'            => true,
							'fallback_cb'     => 'wp_page_menu',
							'before'          => '',
							'after'           => '',
							'link_before'     => '',
							'link_after'      => '',
							'items_wrap'      => '<ul class="%2$s footer-menu">%3$s</ul>',
							'depth'           => 1,
							'walker'          => '',
						] );
					?>
				</div>
				<div class="footer__col">
					<div class="footer-contacts">
						<span class="footer-contacts__title"><?php esc_html_e( 'Наименование', 'primasnab' ); ?></span>
						<span class="footer-contacts__value"><?php echo get_field('company_requisite_shortname', 'option') ?></span>
					</div>

					<div class="footer__address">
						<?php
							$address_law = get_field('company_address_law', 'option');

							if ($address_law && is_array($address_law)) {
									$address_law = array_filter($address_law, function($value) {
											return !empty($value) || $value === '0';
									});
									
									$address_law_string = implode(', ', $address_law);
									
							}
							?>
						<span class="footer-contacts__title"><?php esc_html_e( 'Юридический адрес', 'primasnab' ); ?></span>
						<p class="footer-contacts__value"><?php echo esc_html($address_law_string); ?></p>
					</div>

					<?php
						$phone = get_field('company_tel', 'options');
						$phone = explode(PHP_EOL, $phone);
						$phone_href = preg_replace('![^0-9]+!', '', $phone);
					?>
					<div class="footer__phone">
						<span class="footer-contacts__title"><?php esc_html_e( 'Телефон', 'primasnab' ); ?></span>
						<a class="footer-contacts__value" href="tel:<?php echo $phone_href[0]; ?>"
							data-text="<?php echo $phone[0]; ?>"><?php echo $phone[0]; ?></a>
					</div>
				</div>

				<div class="footer__col">
					<div class="footer-contacts">
						<span class="footer-contacts__title"><?php esc_html_e( 'ИНН', 'primasnab' ); ?></span>
						<span class="footer-contacts__value"><?php echo get_field('company_requisite_inn', 'option') ?></span>
					</div>

					<div class="footer__address">
						<?php
							$address = get_field('company_office_address', 'option');

							if ($address && is_array($address)) {
									$address = array_filter($address, function($value) {
											return !empty($value) || $value === '0';
									});
									
									$address_string = implode(', ', $address_law);
									
							}
							?>
						<span class="footer-contacts__title"><?php esc_html_e( 'Головной офис продаж', 'primasnab' ); ?></span>
						<p class="footer-contacts__value"><?php echo get_field('company_office_timework', 'option') ?></p>
						<p class="footer-contacts__value"><?php echo esc_html($address_string); ?></p>

					</div>

					<div class="footer__email">
						<span class="footer-contacts__title"><?php esc_html_e( 'Электронная почта', 'primasnab' ); ?></span>
						<a class="footer-contacts__value" href="mailto:<?php echo get_field('company_mail', 'option') ?>"
							data-text="<?php echo get_field('company_mail', 'option') ?>"><?php echo get_field('company_mail', 'option') ?></a>
					</div>
				</div>

			</div>
		</footer>
		
  </div><!-- #site -->

	<?php wp_footer(); ?>

	<?php //get_template_part("template-parts/modal"); ?>
	<?php get_template_part("template-parts/components/cookie-notice"); ?>

</body>
</html>

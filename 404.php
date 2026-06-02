<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package primasnab
 */
get_header();
?>
<?php
$error_title = get_field( 'error-404_title', 'option' );
$error_text = get_field( 'error-404_text', 'option' );
$error_background_url = get_field( 'error-404_bgimg', 'option' );
$error_background = (!empty($error_background_url)) ? get_image_versions($error_background_url) : null;
$error_background_url_mobile = get_field( 'error-404_bgimg_mobile', 'option' );
$error_background_mobile = (!empty($error_background_url_mobile)) ? get_image_versions($error_background_url_mobile) : null;

$button_text = get_field( 'error-404_link_name', 'option' ) ?: esc_html__( 'На главную', 'primasnab' );
$button_custom_url = get_field( 'error-404_link', 'option' );
if ( $button_custom_url ) {
	$button_url = $button_custom_url;
} else {
	$button_url = home_url( '/' );
}

?>

	<main class="main">
		<section class="error-404 not-found">
			<div class="container">

				<div class="error-404__content">
					<?php if($error_title) : ?>
						<h1 class="error-404__title"><?php echo esc_html( $error_title ); ?></h1>
					<?php endif; ?>

					<?php if($error_text) : ?>
						<p class="error-404__decr"><?php echo esc_html( $error_text ); ?></p>
					<?php endif; ?>
					
					<?php if($button_text && $button_url) : ?>
						<a href="<?php echo esc_url( $button_url ); ?>" class="error-404__link ui-btn"><?php echo esc_html( $button_text ); ?></a>
					<?php endif; ?>
				</div>

				<?php if($error_background && is_array($error_background)) : ?>
					<picture class="error-404__img">
						<source media="(min-width: 768px)" srcset="<?php echo esc_url($error_background_mobile['webp_1x']); ?>" type="image/webp">
						<source media="(min-width: 768px)" srcset="<?php echo esc_url($error_background_mobile['original_1x']); ?>" type="image/jpg">
						<source srcset="<?php echo esc_url($error_background['webp_1x']); ?>" type="image/webp">
						<img src="<?php echo esc_url($error_background['original_1x']); ?>" width="423" height="423" aria-hidden="true" alt="">
					</picture>
				<?php endif; ?>

			</div>
		</section><!-- .error-404 -->
	</main><!-- #main -->

<?php
get_footer();


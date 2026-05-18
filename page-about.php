<?php
/*
Template Name: О компании
Template Post Type: page
*/

get_header(); ?>
	<main class="main">
		<div class="container">
			<?php get_template_part("template-parts/components/breadcrumbs", "", $page_id); ?>
      <h1 class="page-title"><?php echo esc_html(get_the_title()); ?></h1>
			
			<?php get_template_part("template-parts/content", "about", $page_id ); ?>
		</div>
	</main>

<?php
get_footer();
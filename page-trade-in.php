<?php
/*
Template Name: Trade-in
Template Post Type: page
*/

$page_id = get_the_ID();

get_header(); ?>
<main class="main">
    <div class="container">
        <?php get_template_part("template-parts/components/breadcrumbs", "", $page_id); ?>
        <?php get_template_part("template-parts/content", "trade-in", $page_id); ?>
    </div>
</main>
<?php
get_footer();

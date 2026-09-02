<?php
/*
Template Name: Список статей
*/

$page_id = get_the_ID();

// Получаем поля со страницы
$page_title = get_field('articles_page_title', $page_id);

get_header(); ?>

<main class="main">
    <div class="container">
        <?php get_template_part("template-parts/components/breadcrumbs", "", $page_id); ?>

        <section class="sec-articles sec-offset" aria-labelledby="articles-section-title">
            <h1 class="sec-articles__title sec-title" id="articles-section-title">
                <?php echo esc_html($page_title ?: 'Статьи и новости'); ?>
            </h1>

            <?php
            // Запрос на получение статей с пагинацией
            $paged = get_query_var('paged') ?: 1;
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 6, // 6 статей на страницу
                'paged' => $paged,
            );
            $query = new WP_Query($args);
            ?>

            <?php if ($query->have_posts()) : ?>
                <ul class="sec-articles__list">
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <li class="sec-articles__item">
                            <?php get_template_part("template-parts/components/article-card"); ?>
                        </li>
                    <?php endwhile; ?>
                </ul>

                <?php
                // Пагинация
                echo '<div class="sec-articles__pagination">';
                echo paginate_links(array(
                    'total' => $query->max_num_pages,
                    'current' => $paged,
                    'mid_size' => 2,
                    'prev_text' => '← Назад',
                    'next_text' => 'Далее →',
                    'type' => 'list',
                ));
                echo '</div>';
                ?>

            <?php else : ?>
                <p class="sec-articles__empty">Статей пока нет</p>
            <?php endif; ?>

            <?php wp_reset_postdata(); ?>
        </section>
    </div>
</main>

<?php get_footer(); ?>
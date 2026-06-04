<?php
/**
 * Template Name: Отзывы
 * Template Post Type: page
 */

get_header();
$page_id = get_the_ID();

// Получаем список отзывов (родственные связи)
    $reviews_list = get_field('sec-reviews_list', $page_id);
    $reviews_title = get_field('page-reviews_title', $page_id);
    

?>

<main class="main">
    <div class="container">
        <?php get_template_part('template-parts/components/breadcrumbs', '', $page_id); ?>
    </div>

    <?php if ( ! empty( $reviews_list ) ) : ?>
        <section class="reviews-page sec-offset">
            <div class="container">
                <h2 class="reviews-page__title sec-title"><?php echo esc_html( $reviews_title ); ?></h2>

                <div id="reviews-container" class="reviews-page__list">
                    <?php 
                    $index = 0;
                    foreach ( $reviews_list as $review ) : 
                        $hidden_class = ($index >= 6) ? 'reviews-page__item--hidden' : '';
                    ?>
                        <div class="reviews-page__item <?php echo $hidden_class; ?>" data-review-index="<?php echo $index; ?>">
                            <?php
                            // Используем существующую карточку отзывов
                            get_template_part( 'template-parts/components/card-reviews', null, array( 'slide' => $review ) );
                            ?>
                        </div>
                    <?php 
                        $index++;
                    endforeach; 
                    ?>
                </div>

                <?php if ( count( $reviews_list ) > 6 ) : ?>
                    <button class="reviews-page__btn ui-btn ui-btn--blue" id="load-more-reviews" data-visible="6" data-total="<?php echo count( $reviews_list ); ?>">
                        Загрузить еще
                    </button>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
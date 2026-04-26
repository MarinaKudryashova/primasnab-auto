<?php 
  $page_id = $args["id"];
  $sec_name = $args["name"]["value"];
?>

<section class="banner-quote-form sec-offset">
  <div class="container">
    <div class="banner-quote-form__wrap">
      <!-- <div class="banner-quote-form__block"> -->
      <!-- Левая часть с формой -->
      <div class="banner-quote-form__content">
        <!-- Обёртка для заголовка с фоном на всю ширину -->
        <div class="banner-quote-form__title-wrapper">
          <h2 class="banner-quote-form__title sec-title" data-aos="fade-up">
            Рассчитаем стоимость вашего автомобиля
          </h2>
        </div>

        <form class="banner-quote-form__form">
          <div class="banner-quote-form__field">
            <input type="tel" placeholder="Телефон" required />
          </div>

          <div class="banner-quote-form__field">
            <input type="text" placeholder="Комментарий" />
          </div>

          <button class="banner-quote-form__btn" type="submit">
            Получить расчет
          </button>
          <div class="banner-quote-form__checkbox">
            <label>
              <input type="checkbox" required />
              <span class="banner-quote-form__checkbox-text">
                Нажимая на кнопку, вы даёте согласие на обработку
                персональных данных
              </span>
            </label>
          </div>
        </form>
      </div>

      <!-- Правая часть с картинкой -->
      <div class="banner-quote-form__image">
        <img
          class="banner-quote-form__img"
          src="banner-image.png"
          alt="Мужчина с деньгами"
        />
      </div>
      <!-- </div> -->
    </div>
  </div>
</section>
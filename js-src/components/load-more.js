(function ($, window) {
  function getNextUrl() {
    var $controls = $(".page-controls").first();
    var href = $controls.find(".paginations__next").attr("href");

    if (!href) {
      href = $controls.find(".paginations__number:not(.is-active)").first().attr("href");
    }

    if (!href) {
      return "";
    }

    var url = new URL(href, window.location.href);
    url.protocol = window.location.protocol;
    url.host = window.location.host;

    return url.href;
  }

  function getProducts($response) {
    var $products = $response.find(".catalog__list > ul").first();

    if (!$products.length) {
      $products = $response.find(".wcapf-before-products .products").first();
    }

    return $products;
  }

  function updateControls($response) {
    var $newControls = $response.find(".page-controls").first();
    var $controls = $(".page-controls").first();

    if (!$newControls.length || !$controls.length) {
      return;
    }

    $controls.find(".page-controls__paginations").replaceWith($newControls.find(".page-controls__paginations").first());
    $controls.find(".page-controls__more-btn").attr("data-total", $newControls.find(".page-controls__more-btn").attr("data-total") || "");

    if (!$newControls.find(".paginations__next").length && !$newControls.find(".paginations__number:not(.is-active)").length) {
      $controls.find(".page-controls__more-btn").hide();
    }
  }

  $(document).on("click", "#load-more-product", function (event) {
    event.preventDefault();

    var $button = $(this);
    var nextUrl = getNextUrl();
    var $currentProducts = $(".catalog__list > ul").first();

    if (!$currentProducts.length) {
      $currentProducts = $(".wcapf-before-products .products").first();
    }

    if (!nextUrl || !$currentProducts.length) {
      return;
    }

    $button.prop("disabled", true).addClass("is-loading");

    $.ajax({
      url: nextUrl,
      success: function (response) {
        var $response = $(response);
        var $newProducts = getProducts($response);

        if ($newProducts.length) {
          $currentProducts.append($newProducts.children());
          history.replaceState({ wcapf: true }, "", nextUrl);
          updateControls($response);
        } else {
          $button.hide();
        }
      },
      complete: function () {
        $button.prop("disabled", false).removeClass("is-loading");
      },
      error: function () {
        $button.prop("disabled", false).removeClass("is-loading");
      },
    });
  });
})(jQuery, window);

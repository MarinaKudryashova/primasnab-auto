<?php

/**
 * Меняем ₽ на руб.
 */

add_filter('woocommerce_currency_symbol', 'change_rub_currency_symbol', 10, 2);

function change_rub_currency_symbol($currency_symbol, $currency) {
    if ($currency === 'RUB') {
        return 'руб.'; // Меняем ₽ на руб.
    }
    return $currency_symbol;
}
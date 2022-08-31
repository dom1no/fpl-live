<?php

if (! function_exists('price_formatted')) {
    function price_formatted($price): string
    {
        return number_format($price, 1, '.', ' ') . '£';
    }
}

<?php

if (! function_exists('price_formatted')) {
    function price_formatted($price): string
    {
        return number_format($price, 1, '.', ' ') . '£';
    }
}

if (! function_exists('double_formatted')) {
    function double_formatted($value): string
    {
        return number_format($value, 2, '.', ' ');
    }
}

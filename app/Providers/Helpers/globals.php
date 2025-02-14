<?php

if (!function_exists('blade')) {
    function blade($string): string
    {
        return \Illuminate\Support\Facades\Blade::render($string);
    }
}


<?php

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Auth;

function date_formate($birth_date)
{
    return \Carbon\Carbon::parse($birth_date)->format('d-m-Y');
}

function get_currency($currency)
{
    return '$' . number_format($currency, 2, ".", ",");
}


function get_rupee_currency($rupee_currency)
{
    return '₹' . number_format($rupee_currency, 2, ".", ",");
}

function translateToGujarati($text)
{
    $translate = new GoogleTranslate();
    $translate->setSource('en');
    $translate->setTarget('gu');
    return $translate->translate($text);
}

function gujarati_date($date)
{
    // Convert the English digit date to a Carbon instance
    $carbon = \Carbon\Carbon::parse($date);

    // Replace the English digits with Gujarati digits in the date string
    $gujarati_date = strtr($carbon->format('d-m-Y'), [
        '0' => '૦',
        '1' => '૧',
        '2' => '૨',
        '3' => '૩',
        '4' => '૪',
        '5' => '૫',
        '6' => '૬',
        '7' => '૭',
        '8' => '૮',
        '9' => '૯',
    ]);

    return $gujarati_date;
}


function gujarati_number($number)
{
    $gujarati_digits = [
        '૦',
        '૧',
        '૨',
        '૩',
        '૪',
        '૫',
        '૬',
        '૭',
        '૮',
        '૯',
    ];

    // Convert each English digit to the corresponding Gujarati digit
    $gujarati_number = '';
    $english_digits = str_split((string)$number);
    foreach ($english_digits as $digit) {
        $gujarati_number .= $gujarati_digits[$digit];
    }

    return $gujarati_number;
}



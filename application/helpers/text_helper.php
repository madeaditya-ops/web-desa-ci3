<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('potong_deskripsi_perkata')) {
    function potong_deskripsi_perkata($text, $maxLength = 150) {
        $text = strip_tags($text);
        if (strlen($text) <= $maxLength) return $text;

        $words = explode(' ', $text);
        $output = '';
        foreach ($words as $word) {
            if (strlen($output . ' ' . $word) > $maxLength) break;
            $output .= ($output ? ' ' : '') . $word;
        }
        return $output . '...';
    }
}

function potong_caption($text, $maxLength = 100) {
    $text = strip_tags($text);
    if (strlen($text) <= $maxLength) return $text;

    $words = explode(' ', $text);
    $output = '';
    foreach ($words as $word) {
        if (strlen($output . ' ' . $word) > $maxLength) break;
        $output .= ($output ? ' ' : '') . $word;
    }
    return $output;
}
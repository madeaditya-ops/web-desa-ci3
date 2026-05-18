<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!function_exists('old')) {
    function old($field)
    {
        $CI =& get_instance();
        $old = $CI->session->flashdata('old');
        return isset($old[$field]) ? $old[$field] : '';
    }
}

if (!function_exists('error')) {
    function error($field)
    {
        $CI =& get_instance();
        $errors = $CI->session->flashdata('errors');
        return isset($errors[$field]) ? $errors[$field] : '';
    }
}

if (!function_exists('error_class')) {
    function error_class($field)
    {
        return error($field) ? 'is-invalid' : '';
    }
}

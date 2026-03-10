<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('is_active')) {
    /**
     * Cek apakah segment URL sesuai, lalu return class 'active'
     *
     * @param int $segment_index Index segment URL (1 = controller, 2 = method, dst)
     * @param string $value Nilai yang dicocokkan
     * @return string 'active' jika cocok, string kosong jika tidak
     */
    function is_active($segment_index, $value) {
        /** @var CI_Controller $CI */
        $CI =& get_instance();
        $current = $CI->uri->segment($segment_index);

        return ($current === $value) ? 'active' : '';
    }
}

if (!function_exists('is_active_uri')) {
    /**
     * Cek full uri_string(), cocokkan langsung
     *
     * @param string $uri
     * @return string 'active' jika cocok
     */
    function is_active_uri($uri) {
        return (uri_string() === $uri) ? 'active' : '';
    }
}

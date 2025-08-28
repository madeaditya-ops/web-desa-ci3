<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Fungsi untuk memastikan path upload aman dipakai di semua OS
 *
 * @param string $subdir sub-folder di dalam uploads/
 * @return string
 */
function get_upload_path($subdir = '')
{
    // base path: ./uploads/
    $base_path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR;

    // tambahkan subdir jika ada
    if ($subdir !== '') {
        $base_path .= trim($subdir, '/\\') . DIRECTORY_SEPARATOR;
    }

    // pastikan folder ada
    if (!is_dir($base_path)) {
        mkdir($base_path, 0777, true);
    }

    // realpath untuk normalisasi (Windows/Linux)
    $real_path = realpath($base_path);

    // jika gagal realpath, fallback ke base_path manual
    if ($real_path === false) {
        $real_path = $base_path;
    }

    // pastikan diakhiri slash sesuai OS
    return rtrim($real_path, '/\\') . DIRECTORY_SEPARATOR;
}

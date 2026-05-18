<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('lokasi_berita')) {

  function lokasi_berita($lokasi = null) {
    $default = 'Blahbatuh, Bali';
    $hasil = !empty($lokasi) ? $lokasi : $default;

    return '<span class="lokasi-berita">'
         . htmlspecialchars($hasil, ENT_QUOTES, 'UTF-8')
         . ' — </span>';
  }

}

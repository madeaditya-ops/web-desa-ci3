<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('format_hari_jam')) {

    function format_hari_jam($nilai)
    {
        $hari = floor($nilai);
        $jam  = floor(($nilai - $hari) * 24);

        return $hari . ' hari ' . $jam . ' jam';
    }
}
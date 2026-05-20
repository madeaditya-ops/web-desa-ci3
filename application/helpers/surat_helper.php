<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * FORMAT NAMA + JENIS SURAT
 * contoh: Surat Keterangan Usaha
 */
function format_nama_jenis_surat($a)
{
    $nama  = trim($a->nama_surat ?? '');
    $jenis = trim($a->jenis_surat ?? '');

    if ($nama !== '' && $jenis !== '') {
        return $nama . ' ' . $jenis;
    }

    if ($nama !== '') return $nama;
    if ($jenis !== '') return $jenis;

    return '-';
}
/**
 * FORMAT NOMOR SURAT DENGAN TEMPLATE
 * contoh: 140/123/KEP/2023
 */


<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['lembaga'] = [

    'bpd' => [
        'nama'   => 'Badan Permusyawaratan Desa (BPD)',
        'icon'   => 'bi-bank',
        'deskripsi' => 'Lembaga perwakilan masyarakat desa yang membahas dan menyepakati Peraturan Desa serta mengawasi jalannya pemerintahan desa.',
        'model'  => 'Bpd_model',
        'method' => 'get_bpd_for_view'
    ],

    'lpm' => [
        'nama'   => 'Lembaga Pemberdayaan Masyarakat (LPM)',
        'icon'   => 'bi-people',
        'deskripsi' => 'Mitra pemerintah desa dalam perencanaan dan pelaksanaan pembangunan berbasis partisipasi masyarakat.',
        'model'  => 'Lpm_model',
        'method' => 'get_lpm_for_view'
    ],

    'pkk' => [
        'nama'   => 'Pemberdayaan dan Kesejahteraan Keluarga (PKK)',
        'icon'   => 'bi-heart',
        'deskripsi' => 'Organisasi kemasyarakatan yang berperan dalam pemberdayaan keluarga melalui program kesehatan dan ekonomi.',
        'model'  => 'Pkk_model',
        'method' => 'get_pkk_for_view'
    ],

    'karang-taruna' => [
        'nama'   => 'Karang Taruna',
        'icon'   => 'bi-people-fill',
        'deskripsi' => 'Wadah pengembangan generasi muda desa dalam bidang sosial, budaya, dan kewirausahaan.',
        'model'  => 'Karang_taruna_model',
        'method' => 'get_karang_taruna_for_view'
    ],

    'posyandu' => [
        'nama'   => 'Posyandu',
        'icon'   => 'bi-hospital',
        'deskripsi' => 'Layanan kesehatan berbasis masyarakat yang memberikan pelayanan ibu dan anak serta pemantauan gizi.',
        'model'  => 'Posyandu_model',
        'method' => 'get_posyandu_for_view'
    ],

    'subak' => [
        'nama'   => 'Subak',
        'icon'   => 'bi-droplet',
        'deskripsi' => 'Organisasi tradisional pengelolaan irigasi pertanian berbasis filosofi Tri Hita Karana di Bali.',
        'model'  => 'Subak_model',
        'method' => 'get_subak_for_view'
    ],

    'desa-adat' => [
        'nama'   => 'Kelembagaan Desa Adat',
        'icon'   => 'bi-building',
        'deskripsi' => 'Struktur organisasi adat yang mengatur kehidupan sosial dan budaya masyarakat berdasarkan awig-awig.',
        'model'  => 'Desa_adat_model',
        'method' => 'get_desa_adat_for_view'
    ]

];

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends CI_Controller {

    public function index()
    {
        header("Content-Type: text/xml; charset=UTF-8");

        $urls = [
            base_url(),
            base_url('berita'),
            base_url('galeri'),
            base_url('aparatur'),
            base_url('dusun'),
            base_url('potensi'),
            base_url('peraturan'),
            base_url('apbdes'),
            base_url('surat'),
            base_url('pengaduan'),
        ];

        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $url) {

            echo '<url>';

            echo '<loc>' .
                htmlspecialchars($url, ENT_XML1, 'UTF-8') .
                '</loc>';

            echo '<lastmod>' . date('c') . '</lastmod>';

            echo '<changefreq>weekly</changefreq>';

            echo '<priority>0.8</priority>';

            echo '</url>';
        }

        echo '</urlset>';
    }
}
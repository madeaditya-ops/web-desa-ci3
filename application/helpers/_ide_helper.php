<?php
/**
 * _ide_helper.php
 *
 * Helper khusus untuk IDE agar CodeIgniter 3 lebih mudah di-autocomplete.
 * File ini tidak dipanggil langsung dalam runtime.
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Session $session
 * @property CI_Config $config
 * @property CI_URI $uri
 * @property CI_Router $router
 * @property CI_Security $security
 * @property CI_Benchmark $benchmark
 * @property CI_Hooks $hooks
 * @property CI_Lang $lang
 * 
 * ==== Models ====
 * @property Users $Users
 * 
 * ==== Controllers ====
 * @property Auth $Auth
 * @property Dashboard $Dashboard
 * 
 * ==== Helpers ====
 * fungsi di auth_helper (cek_login, cek_role)
 */
class CI_Controller {}

class CI_Model {}

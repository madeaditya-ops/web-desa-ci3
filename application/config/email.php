<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['protocol']    = 'smtp';
$config['smtp_host']   = 'mail.desablahbatuh.site';
// $config['smtp_host']   = 'ssl://mail.desablahbatuh.site';
$config['smtp_user']   = 'no-reply@desablahbatuh.site';
$config['smtp_pass']   = 'BlahbatuhHebat0909';
// $config['smtp_port']   = 587;
$config['smtp_port']   = 465;
$config['smtp_timeout']= 30;
$config['smtp_crypto'] = 'tls';
$config['smtp_hostname'] = 'desablahbatuh.site';

$config['mailtype']    = 'html';
$config['charset']     = 'utf-8';
$config['newline']     = "\r\n";
$config['crlf']        = "\r\n";
$config['wordwrap']    = TRUE;
$config['smtp_keepalive'] = FALSE;
$config['_smtp_auth']  = TRUE;

$config['smtp_conn_options'] = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
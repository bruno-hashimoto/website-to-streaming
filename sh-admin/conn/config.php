<?php
    // Ambiente
    $ambiente = 'dev';

    // Desenvolvimento
    $conexoes['dev']['host']  = 'localhost';
    $conexoes['dev']['login'] = 'root';
    $conexoes['dev']['senha'] = '';
    $conexoes['dev']['datab'] = 'rima';

    // Produção
    $conexoes['prod']['host']  = '';
    $conexoes['prod']['login'] = '';
    $conexoes['prod']['senha'] = '';
    $conexoes['prod']['datab'] = '';

    // Url
    $pasta_site = 'private/wwwbmfilm/';

    $endereco  =  (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ?  'https' : 'http';
    $endereco .=  '://'.$_SERVER['HTTP_HOST'];
    $endereco .=  '/'.$pasta_site;

    // Constantes
    define('AMBIENTE',$ambiente);
    define('HOST' ,$conexoes[$ambiente]['host']);
    define('LOGIN',$conexoes[$ambiente]['login']);
    define('SENHA',$conexoes[$ambiente]['senha']);
    define('DATAB',$conexoes[$ambiente]['datab']);

    define('_BASE_',$endereco);
    define('_BASE_SECURE_',str_replace('http','https',_BASE_));
    define('_URL_FILES_',_BASE_.'files/');
    define('_URL_FILES_SECURE_',_BASE_SECURE_.'files/');

    date_default_timezone_set('America/Campo_Grande');
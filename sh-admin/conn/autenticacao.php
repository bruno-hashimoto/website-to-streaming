<?php
    if(isset($_SESSION['id_user'])!==true || is_numeric($_SESSION['id_user']) !==true || $_SESSION['session_id'] !== session_id() || $_SESSION['status_user']!==1 || $_SESSION['excluido_user']!==0 )
    {
        $path    = array();
        $keydir  = 0;
        $backdir = 0;
        $back    = '';

        $path   = explode('/',str_replace('\\','/',getcwd()));
        $keydir = (int) array_search('sh-admin',$path);

        $backdir = (count($path) - 1) - $keydir;

        for($dir = 0; $dir <  $backdir; $dir++)
        {
            $back .= '../';
        }

        if(isset($_GET['a']))
        {
            $_SESSION['redirectLink'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; //PÁGINA ACESSADA
            $_SESSION['redirectLinkReturnModulo'] = reset(explode('/',$_GET['a'])).'/index';
        }

        header('location: '.$back.'index.php');
        die;
    }
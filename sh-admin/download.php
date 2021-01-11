<?php
    include 'conn/session.php';
    include 'conn/autenticacao.php';
    include 'conn/config.php';
    include 'conn/funcoes.php';

    files('../files/');//DEFININDO LOCAL DOS ARQUIVOS ex: ../files/

    if ( isset( $_GET['file'] ) && !empty( $_GET['file'] ) ) {

        $file = _FILES_.$_GET['file'];

        if ( file_exists( $file ) && is_file( $file ) ) {

            $fileInfo = getimagesize($file);

            header('Content-Type: '. $fileInfo['mime']);
            header('Content-Length: '.filesize( $file ) );
            header('Content-Disposition: attachment; filename='.basename( $file ) );
            readfile( $file );
            die;
        }
    }

    header('Location:'.$_SESSION['continue']);
    die;


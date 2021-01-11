<?php
    include 'conn/session.php';
    include 'conn/autenticacao.php';
    include 'conn/config.php';
    include 'conn/class/Banco.class.php';
    include 'conn/funcoes.php';

    $sql    = new Banco();
    $ids    = $_POST['ids'];
    $idsArr = array();
    $table  = $_POST['table'];
    $del    = NULL;
    $st        = NULL;

    $idsArr = explode(',',$ids);

    if($_POST['action'] == 1)
    {
        $del = $sql->query("UPDATE `$table` SET excluido = 1 WHERE id IN ($ids)");

        $action = $del===true ? 5:6;

        foreach($idsArr as $id)
        {
            logs($action,$table,$id,$_SESSION['id_user']);
        }

        echo $del;
    }
    else if($_POST['action'] == 2 | $_POST['action'] == 3)
    {
        $status = ($_POST['action']==2) ? 1:0;

        $st = $sql->query("UPDATE `$table` SET status = '$status' WHERE id IN ($ids)");

        $action = $st===true ? 3:4;

        foreach($idsArr as $id)
        {
            logs($action,$table,$id,$_SESSION['id_user']);
        }

        echo $st;
    }
    unset($_POST);
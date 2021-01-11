<?php
    include "conn/session.php";
    include "conn/autenticacao.php";
    include "conn/config.php";
    include "conn/class/Banco.class.php";

    $sql    = new Banco();
    $bIds   = $_POST['ids'];
    $ids    = explode(',',$bIds);
    $fOrdem = $_POST['fOrdem'];
    $table  = $_POST['table'];
    $wFile  = is_numeric($_POST['id_modulo']) && $_POST['id_modulo']!='undefined' ? " and modulo='".$_POST['modulo']."' and id_modulo=".$_POST['id_modulo']:'';

    $q = $sql->query("select id from `$table` where id > 0 $wFile order by ordem asc , id desc");

    $i = 0;
    while($ln = $sql->fetch($q))
    {
        $sql->query("update `$table` set ordem =".$i++." where id NOT IN($bIds) and id = ".$ln['id']);
    }

    foreach ($ids as $id)
    {
        $sql->query("update `$table` set ordem =".$fOrdem." where id = ".$id." $wFile");
        $fOrdem++;
    }

    unset($_POST);
    exit(true);
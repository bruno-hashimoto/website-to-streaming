<?php
    include('conn/autenticacao.php');

    $sqlMenu = ($_SESSION["id_user"]==1) ? "SELECT * FROM `sh_menu` where status = 1 and excluido = 0 ORDER BY tipo ASC , nome ASC" : "SELECT m.* FROM `sh_menu` m inner join sh_menu_permissao mp on m.id=mp.idmenu where m.status = 1 and m.excluido = 0 and mp.iduser = '".$_SESSION['id_user']."' ORDER BY m.tipo ASC , m.nome ASC";
    //TODOS OS MENUS PARA USER MASTER

    $qMenu = $sql->query($sqlMenu);
    $eComm = 1;
    $sys   = 1;
?>
<div id="navega">
    <ul>
        <li><a href="" rel="?a="  title="Voltar a tela principal" alt="Voltar a tela principal" >Início</a></li>
    <?php
    if($sql->rows($qMenu) > 0)
    {
        while($lnMenu = mysql_fetch_assoc($qMenu))
        {

            if($lnMenu['tipo']==1 && $eComm==1)
            {
             ++$eComm;

             echo '<li><h3 title="Área de Comércio" style=" font-size:13pt;">E-Commerce</h3></li>';
            }

            if($lnMenu['tipo']==2 && $sys==1)
            {
                ++$sys;

                echo '<li><h3 title="Configurações do sistema">Sistema</h3></li>';
            }
    ?>
        <li title="<?php echo $lnMenu['nome'];?>">
            <a href="?a=<?php echo $lnMenu['pasta'].'/'.$lnMenu['url']?>" rel="<?php echo $lnMenu['pasta'];?>">
                <?php echo $lnMenu['nome'];?>
            </a>
        </li>
    <?php
        }
    }
    else
    {
    ?>
        <li><a href="">Nenhum menu encontrado !</a></li>
    <?php
    }
    ?>
    </ul>
</div>
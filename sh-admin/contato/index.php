<?php
    include 'config.php';

    //BUSCA
    if(!empty($_GET['q']) && !empty($busca) )
    {
        $q     = trim($sql->escapeString($_GET['q']));
        $busca = explode(',',$busca);

        foreach($busca as $i => $campo)
        {
            if($i==0)
            {
                $wBusca  = " AND ($campo LIKE '%".$q."%' ";
            }
            else
            {
                $wBusca .= " OR $campo LIKE '%".$q."%' ";
            }
        }

        $wBusca .= ')';
    }
    //FIM BUSCA

    //TIPO DO USER
    $wVisible = ($ptip == 1) ? ' AND (t.iduser = '.$_SESSION['id_user'].' or t.iduser = 0) ':'';
    //FIM TIPO DO USER

    //QUERY
    $query = $page->paginacaoArr
    ("

        SELECT

            t.*,
            u.nome as nomeuser,
            u.id as iduser

        FROM

            `$tabela` t

            LEFT JOIN
                sh_user u on t.iduser = u.id

        WHERE

            t.excluido = 0
            $wVisible
            $wBusca

        ORDER BY
            t.ordem ASC , t.id DESC

    ",

    'sh_index',//PAGINA PRINCIPAL

    0,// TIPO DA PAGINAÇÃO. 1 limpa ,0 suja

    $rPagina,//TOTAL DE REGISTROS POR PAGINA

    '?a='.$enderecoPasta.'&q='.$_GET['q'] //VARIAVEIS PASSADAS NA PAGINAÇÃO

    );
    //FIM QUERY
?>
<div id="meio">

    <div id="listagem">

        <h2><?php echo $titulo;?></h2><!--TITULO DA PAGINA -->

        <?php
            //EXPORTAR DADOS
            if($page->total()>0)
            {
        ?>
        <a href="lib/phpexcel/index.php?export=contato" target="_self" class="exporta-dados" >
            <img src="imgs_site/xls.png" alt="Exportar" title="Exportar">
        </a>


        <!-- <a class="exporta-dados" href="<?php //echo _BASE_.'admin/lib/phpexcel/index.php?table='.$tabela.'&fields=nome:asc,email,fone&name='.$titulo.'&out=xls';?>" target="_self">
            <img src="imgs_site/xls.png" alt="Exportar" title="Exportar">
        </a> -->
        <?php
            }
        ?>

        <ul class="bread"> <!-- ONDE ESTOU -->
            <li><a href="?a=home"><img src="imgs_site/homegif.gif" /></a></li>
            <li><a href="?a=<?php echo $enderecoPasta;?>"><?php echo $titulo;?></a></li>
        </ul>

        <ul class="acoes"> <!-- AÇOES -->
            <li>Ações:</li>
            <li><a class="marcar-todos-desmarcar" href="#">Marcar todos / Desmarcar todos</a></li>
            <li><a class="acoes-list actionseta"  href="#" rel="1">Excluir selecionado(s)</a></li>
        </ul>

        <ul class="busca"> <!--BUSCA-->
            <form action="" method="get" id="busca-modulo">
                <input type="hidden" name="a" value="<?php echo $enderecoPasta;?>" /> <!--ENDERECO DO MODULO ATUAL-->
                <input type="text"   name="q" placeholder="Buscando algo ?" title="Buscando algo ?" value="<?php echo $_GET['q'];?>" />
            </form>
        </ul>

    <div class="listas">

        <table width="100%" border="0" cellspacing="2" cellpadding="0" class="sortTable" id="<?php echo $tabela;?>" fOrdem="<?php echo $fOrdem;?>">

            <thead>
                <tr>
                    <th width="5%" align="center" class="no_sort">Marcar</th>

                    <!--COLUNAS-->

                    <th width="26%" align="left">Assunto</th>
                    <th width="26%" align="left">Nome</th>
                    <th width="26%" align="left">E-mail</th>
                    <th width="7%" align="left">Data</th>

                    <!--FIM COLUNAS-->

                    <?php
                        if($pVer===1 && isset($ver))
                        {
                    ?>
                        <th width="5%" align="center" class="no_sort">Ver</th>
                    <?php
                        }
                    ?>
                    <?php
                        if(isset($fotos))
                        {
                    ?>
                        <th width="5%" align="center" class="no_sort">Fotos</th>
                    <?php
                        }
                    ?>
                    <th width="5%" align="center" class="no_sort">Excluir</th>
                </tr>
            </thead>

            <tbody>
            <?php
                $registrosMostrados = 0; //CONTA O TOTAL DE REGISTROS LISTADOS

                if($page->total()>0)
                {
                    foreach($query as $ln)
                    {
                        $title  = '';
                        $clInfo = '';

                        if($_SESSION['id_user']!=$ln['iduser'] && $ln['iduser'] >1 )
                        {
                            $title = 'title="Cadastrado(a) por: '.$ln['nomeuser'].'"';
                            $clInfo = 'msgInfo';
                        }
            ?>
                <tr id="<?php echo $ln['id'];?>"  <?php echo $title;?> class="<?php echo $clInfo;?> cadPor <?php echo $pAlt!==1?' nodrag nodrop ':'';?>">
                    <td  align="center"><input type="checkbox" class="excluirMultCheck"  title="Selecionar esse registro"/></td>

                    <!--COLUNAS-->

                    <td align="left"><?php echo $ln['assunto'];?></td>
                    <td align="left"><?php echo $ln['nome'];?></td>
                    <td align="left"><a href="mailto:<?php echo $ln['email'];?>"><?php echo $ln['email'];?></a></td>
                    <td align="left"><?php echo data($ln['data'],true);?></td>

                    <!--FIM COLUNAS-->

                    <?php
                        if($pVer===1 && isset($ver))
                        {
                    ?>
                      <td  align="center">
                        <a href="?a=<?php echo $ver,'&id=',$ln['id'];?>" title="Visualizar esse registro">
                            <img src="imgs_site/look.png" width="15" height="15" />
                        </a>
                    </td>
                    <?php
                        }
                    ?>

                    <?php
                        if(isset($fotos))
                        {
                            $files = $sql->query('SELECT id FROM `sh_file` where excluido = 0 and modulo = "'.$tabela.'" and id_modulo = '.$ln['id']);
                    ?>
                    <td  align="center">
                        <a href="?a=<?php echo $fotos,'&id=',$ln['id'];?>" title="Gerenciar fotos deste registro" class="bg-icon" style=" background-image: url(imgs_site/photos.png);">
                            <span>(<?php echo $sql->rows($files);?>)</span>
                        </a>
                    </td>
                    <?php
                        }
                    ?>


                    <td align="center">
                     <a class="excluir" href="#" title="Excluir esse registro ?">
                        <img src="imgs_site/excluir.png" width="13" height="15" />
                     </a>
                    </td>
                </tr>
            <?php
                        ++$registrosMostrados;
                    }
                }
                else
                {
             ?>
                <tr class="inf-busca-reg">
                    <td  align="center">
                        <?php echo !empty($_GET['q']) ? 'Sua busca não trouxe nenhum resultado !':'Não há registros cadastrados !';?>
                    </td>
                </tr>
            <?php
                }
            ?>
            </tbody>

            <tfoot>

                <tr>
                    <th align="left"><p>Total:</p></th>
                    <th align="center" >
                        <?php
                            echo ($page->total() > $rPagina) ? $registrosMostrados.'&ndash;'.$page->total() : $registrosMostrados;
                        ?>
                    </th>
                </tr>

            </tfoot>

        </table>
    </div>

    </div>
        <?php
            echo $page->navegacao(); //CONTROLES DA PAGINAÇÃO < 1 2 3 >
        ?>
</div>
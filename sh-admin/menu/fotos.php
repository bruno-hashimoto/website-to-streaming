<?php
	include 'config.php';

	//BUSCA
	if(!empty($_GET['q']))
	{
		$q = trim($sql->escapeString($_GET['q']));

		$wBusca  = " AND (t.comentario LIKE '%".$q."%' ) ";
	}
	//FIM BUSCA

    // TIPO USER
	$wVisible = ($ptip == 1) ? ' AND t.iduser = '.$_SESSION['id_user']:'';//TIPO DO USER
    // FIM TIPO USER

    //QUERY
    $query = $page->paginacaoArr
    ("

       SELECT
            t.*,
            u.nome as nomeuser,
            u.id as iduser
        FROM
            `sh_file` t

            LEFT JOIN sh_user u on t.iduser = u.id

        WHERE

            t.excluido = 0
            $wVisible
            $wBusca and
            t.id_modulo = '".$_GET['id']."' and
            t.modulo = '$tabela'

        ORDER BY
            t.ordem ASC , id DESC

    ",

    'sh_index',//PAGINA PRINCIPAL

    0,// TIPO DA PAGINAÇÃO. 1 limpa ,0 suja

    $rPagina,//TOTAL DE REGISTROS POR PAGINA

    '?a='.$fotos.'&id='.$_GET['id'].'&q='.$_GET['q'] //VARIAVEIS PASSADAS NA PAGINACAO

    );
    //FIM QUERY
?>
<div id="meio">

    <div id="listagem">

        <h2><?php echo 'Fotos de ',$titulo;?></h2><!--TITULO DA PAGINA -->

        <a href="js/upload/index.php?id_modulo=<?php echo $_GET['id'];?>&modulo=<?php echo $tabela;?>" class="adicionar upload adicionar-fotos">Adicionar</a> <!--BOTÃO CADASTRAR -->

        <ul class="bread"> <!-- ONDE ESTOU -->
            <li><a href="?a=home"><img src="imgs_site/homegif.gif" /></a></li>
            <li><a href="<?php echo $_SESSION['continue'];?>"><?php echo $titulo;?></a></li>
            <li><a href="<?php echo $_SERVER['REQUEST_URI'];?>">Fotos</a></li>
        </ul>

        <ul class="acoes"> <!-- AÇOES -->
            <li>Ações:</li>
            <li><a class="marcar-todos-desmarcar" href="#">Marcar todos / Desmarcar todos</a></li>
            <li><a class="acoes-list actionseta"  href="#" rel="1">Excluir selecionado(s)</a></li>
            <li><a class="acoes-list actionseta"  href="#" rel="2">Ativar selecionado(s)</a></li>
            <li><a class="acoes-list actionseta"  href="#" rel="3">Desativar selecionado(s)</a></li>
        </ul>

        <ul class="busca"> <!--BUSCA-->
        	<form action="" method="get" id="busca-modulo" >
            	<input type="hidden" name="a" value="<?php echo $fotos;?>" />
                <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
            	<input type="text"   name="q" placeholder="Buscando algo ?" value="<?php echo $_GET['q'];?>" />
            </form>
        </ul>

        <div class="listas">

            <table width="100%" border="0" cellspacing="2" cellpadding="0" class="sortTable" id="sh_file" fOrdem="<?php echo $fOrdem;?>" id_modulo="<?php echo $_GET['id']?>" modulo="<?php echo $tabela;?>" >
            	<thead>
                	<tr>
                    	<th width="5%" align="center" class="no_sort" >Mover</th>
    					<th width="5%" align="center" class="no_sort" >Marcar</th>
                        <th width="5%" align="center" class="no_sort" >Principal</th>
                        <th width="5%" align="center" class="no_sort">Imagem</th>

                        <!--COLUNAS-->

                        <th width="60%" align="left">Comentário</th>

                        <!--FIM COLUNAS-->

                        <th width="5%" align="center" class="no_sort">Status</th>
                        <th width="5%" align="center" class="no_sort">Excluir</th>
                    </tr>
                </thead>
                <tbody>
    			<?php
    				$registrosMostrados = 0;

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
                        <td  class="dragHandle">&nbsp;</td> <!--DRAG DROP-->
                        <td  align="center"><input type="checkbox" class="excluirMultCheck" title="Selecionar esse registro" /></td>

                        <!--COLUNAS-->
                        <td align="left">
                        	<a href="#" class="star <?php echo $ln['principal']==1 ? ' marcarImgPrincipal':'';?>" rel="<?php echo $tabela,'-',$_GET['id'];?>" nameImg="<?php echo $ln['img'];?>" ></a>
                        </td>
                        <td align="center">
						 <?php
                            echo lightbox($ln['img'],'89x60','title="'.$ln['comentario'].'" ',true,'class="cl-img"');
                         ?>
                        </td>
                        <td align="left">
                            <textarea class="comentfoto msgInfo" <?php echo $pAlt !==1 ? 'readonly="readonly"':'';?> ><?php echo $ln['comentario'];?></textarea>
                        </td>

                        <!--FIM COLUNAS-->

                        <td  align="center" class="statusModulo">
                            <?php echo ($ln['status']==1) ? 'Ativo':'Inativo';?>
                        </td>


                        <td align="center">
                         <a class="excluir" href="#">
                            <img src="imgs_site/excluir.png" width="13" height="15" title="Excluir esse foto ?" alt="Excluir" />
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
                        <th align="center">
                            <?php
                                echo ($page->total() > $rPagina) ? $registrosMostrados.'&ndash;'.$page->total() : $registrosMostrados;
                            ?>
                        </th>
                    </tr>

                </tfoot>

            </table>
             <a href="<?php echo $_SESSION['continue'];?>" title="Voltar para <?php echo $titulo;?>" alt="Voltar para <?php echo $titulo;?>" class="avol">&lsaquo;&mdash;&nbsp;Voltar para <?php echo $titulo;?></a>
             <input type="hidden" name='up-fotos' value="0" />
        </div>

    </div>
        <?php
			echo $page->navegacao();
        ?>
</div>
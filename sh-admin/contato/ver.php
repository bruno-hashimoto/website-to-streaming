<?php
    include 'config.php';

    if($pVer!==1)//VALIDANDO A PERMISSÃO DE VER
    {
        location($_SESSION['continue']);//PARANDO O SCRIPT E REDIRECIONANDO
    }

    $ln = $sql->select("select t.* from `$tabela` t WHERE t.id = ".$_GET['id']);
    $ln = $ln[0];

    $campo = '';
?>
<div id="meio">
  <div id="listagem">
    <h2><?php echo 'Visualização de ',$titulo;?></h2> <!-- TITULO -->

    <ul class="bread">
      <li><a href="?a=home"><img src="imgs_site/homegif.gif" /></a></li>
      <li><a href="<?php echo $_SESSION['continue'];?>"><?php echo $titulo;?></a></li>
      <li><a href="<?php echo $_SERVER['REQUEST_URI'];?>">Visualização</a></li>
    </ul>

    <div id="inserir" >
         <form action="" method="post" id="formVer" enctype="multipart/form-data">
        <?php
            foreach($visualizacao as $titulo => $arr)
            {
                $campo = trim($ln[$arr['campo']]);

                if($campo!='')
                {
                    switch($arr['tipo'])
                    {
                        case 'image':
                            echo
                            '
                                <div>
                                    <label>'.$titulo.'</label>
                                    '.lightbox($campo,'640x390','','','class="cl-img"').'
                                </div>
                            ';
                        break;
                        case 'video':
                            echo
                            '
                                <div>
                                    <label>'.$titulo.'</label>
                                    '.video($campo,'640x390','',true).'
                                </div>
                            ';
                        break;
                        case 'data':
                            echo
                            '
                                <div>
                                    <label>'.$titulo.'</label>
                                    <div class="ver">'.data($campo).'</div>
                                </div>
                            ';
                        break;
                        case 'datahora':
                            echo
                            '
                                <div>
                                    <label>'.$titulo.'</label>
                                    <div class="ver">'.data($campo,true).'</div>
                                </div>
                            ';
                        break;
                        case 'valor':
                            echo
                            '
                                <div>
                                    <label>'.$titulo.'</label>
                                    '.fvalor($campo).'
                                </div>
                            ';
                        break;
                        case 'banner':
                            echo
                            '
                                <div>
                                    <label>'.$titulo.'</label>
                                    '.banner($campo,'640x390').'
                                </div>
                            ';
                        break;
                        case'download':
                            echo
                            '
                                <div class="download-ver">
                                    <label>'.$titulo.'</label>
                                    <a href="download.php?file='.$campo.'" target="_blank">
                                        Baixar arquivo
                                    <a>
                                </div>
                            ';
                        break;
                        default:
                            echo
                            '
                                <div>
                                    <label>'.$titulo.'</label>
                                    <div class="ver">'.$campo.'</div>
                                </div>
                            ';
                    }

                    $campo = '';
                }
            }

            echo
            '
                <div>
                    <label>Data de cadastro</label>
                    <div class="ver">'.data($ln['data'],true).'</div>
                </div>
            ';
            echo
            '
                <div>
                    <label>Status</label>
                    <div class="ver">'.($ln['status']==1 ? 'Ativo':'Inativo').'</div>
                </div>
            ';
        ?>
       <br />
        <input type="button" value="Voltar" class="altera" name="voltar" onclick="javascript:window.location.href='<?php echo $_SESSION['continue'];?>'" />
       </form>
    </div>
  </div>
</div>
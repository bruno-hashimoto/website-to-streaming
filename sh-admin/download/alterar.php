<?php
    include 'config.php';

    if($pAlt!==1)//VALIDANDO A PERMISSÃO DE ALTERAR
    {
        location($_SESSION['continue']);//PARANDO O SCRIPT E REDIRECIONANDO
    }

    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $img = upload('file_alt',_FILES_,1);//UPLOAD DE ARQUIVOS

        if(!empty($img))
        {
            unlink(_FILES_.$_POST['input']['arquivo']);//EXCLUINDO A IMAGEM ATUAL , SE EXISTIR UMA NOVA
            $_POST['input']['arquivo'] = $img; //ALTERANDO A IMAGEM ATUAL , SE EXISTIR UMA NOVA
        }

        $alteracao = $sql->update($tabela,' id = '.$_POST['id']);//ALTERANDO...

        if($alteracao===true)
        {

            logs(3,$tabela,$_POST['id'],$_SESSION['id_user']);
              location($_SESSION['continue'],'Alteração efetuada !',1);//REDIRECIONAMENTO
        }
        else
        {
            logs(4,$tabela,$_POST['id'],$_SESSION['id_user']);
              location($_SESSION['continue'],'Erro, ao tentar alterar !');//REDIRECIONAMENTO
        }
    }

    $ln = $sql->select("select * from `$tabela` WHERE id = ".$_GET['id']);
    $ln = $ln[0];

?>
<div id="meio">
  <div id="listagem">

    <h2><?php echo 'Alterar ',$titulo;?></h2>  <!-- TITULO -->

    <ul class="bread"> <!-- ONDE ESTOU -->
      <li><a href="?a=home"><img src="imgs_site/homegif.gif" /></a></li>
      <li><a href="<?php echo $_SESSION['continue'];?>"><?=$titulo;?></a></li>
      <li><a href="<?php echo $_SERVER['REQUEST_URI'];?>">Alterar</a></li>
    </ul>

    <div id="inserir">
      <form action="" method="post" class="validaFormulario" enctype="multipart/form-data" id="formAlterar">

        <div>
            <label>Título</label>
            <input name="input[titulo]" type="text" value="<?php echo $ln['titulo'];?>"/>
        </div>
        <div>
            <label>Descrição</label>
            <textarea name="input[texto]" class="chamada noCk"><?php echo $ln['texto'];?></textarea>
        </div>
        <div>
            <div class="download-ver" >
             <a href="download.php?file=<?php echo $ln['arquivo'];?>">Download do Arquivo</a>
             </div>
        </div>
        <div>
            <label>Alterar Arquivo</label>
            <input type="file" name="file_alt[]"/>
            <input type="hidden" name="input[arquivo]" value="<?php echo $ln['arquivo'];?>"  />
            <p>Escolha outro arquivo para trocar o atual.</p>
            <p>Você poderá fazer o upload de arquivos *.doc, *.txt, *.docx , *.pdf,*.xls .</p>
        </div>

        <div>
            <label>Status</label>
            <select name="input[status]" >
              <option value="">Selecione uma opção</option>
              <option value="1" <?php echo $ln['status']==1 ? 'selected="selected"':'';?>>Ativo</option>
              <option value="0" <?php echo $ln['status']==0 ? 'selected="selected"':'';?>>Inativo</option>
            </select>
        </div>

        <br />

        <input type="hidden" name="id" value="<?php echo $ln['id'];?>" />
        <input type="button" value="Cancelar" class="altera" name="cancelar" onclick="javascript:window.location.href='<?php echo $_SESSION['continue'];?>'" />
        <input type="submit" value="Alterar" name="alterar" class="envia"  />

      </form>
    </div>
  </div>
</div>
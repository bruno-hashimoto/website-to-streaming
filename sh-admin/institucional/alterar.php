<?php
	include 'config.php';

	if($pAlt!==1)//VALIDANDO A PERMISSÃO DE ALTERAR
	{
		location($_SESSION['continue']);//PARANDO O SCRIPT E REDIRECIONANDO
	}

	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		$img = upload('file_alt');//UPLOAD DE ARQUIVOS
		//$_POST['input']['datap'] = data($_POST['input']['datap']); // CONVERTENDO DATAS

		if(!empty($img))
		{
			unlink(_FILES_.$_POST['input']['img']);//EXCLUINDO A IMAGEM ATUAL , SE EXISTIR UMA NOVA
			$_POST['input']['img'] = $img; //ALTERANDO A IMAGEM ATUAL , SE EXISTIR UMA NOVA
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
        <!--<div>
        	<label>Chamada</label>
        	<textarea  name="input[chamada]" class="chamada"><?php echo $ln['chamada'];?></textarea>
        </div>-->
        <div>
            <label>Texto</label>
            <textarea name="input[texto]" class="texto"><?php echo $ln['texto'];?></textarea>
        </div>

         <!--  <div>
             <?php echo lightbox($ln['img'],'640x390','','','class="cl-img"');?>
          </div>
          <div>
              <label>Alterar imagem</label>
              <input type="file" name="file_alt[]"/>
              <input type="hidden" name="input[img]" value="<?php echo $ln['img'];?>"  />
              <p>Escolha outra imagem para trocar a atual.</p>
              <p>Escolha imagens com uma resolução média de 800x600px. Você poderá fazer o upload de arquivos *.jpg, *.gif, *.png.</p>
          </div> -->
      <!--

        <div>
            <label>Data de publicação</label>
            <input name="input[datap]" type="text" class="metade" value="<?php echo data($ln['datap'],true);?>" />
        </div>   -->

        <!-- <div>
       		<label>Fonte</label>
        	<input type="text" name="input[fonte]" value="<?php echo $ln['fonte'];?>" />
        </div> -->

      <!--  <div>
	        <label>Vídeo</label>
    	    <input type="text" class="metade" name="input[video]" value="<?php echo $ln['video'];?>"/>
            <p>Informe o link do vídeo. Ex : http://www.youtube.com/watch?v=YftxT3DDscI&feature=g-logo&context=G233dce5FOAAAAAAABAA </p>
        </div> -->

       <!--
        <div>
        <label>Link</label>
        <input type="text" name="input[link]" class="metade" />
         <p>Informe o link. Ex : http://www.shapeweb.com.br/ </p>
        </div>


        <div>
        <label>Destaque</label>
        <select name="input[destaque]">
          <option value="">Selecione uma opção</option>
          <option value="1" <?php echo $ln['destaque']==1 ? 'selected="selected"':'';?>>Sim</option>
          <option value="0" <?php echo $ln['destaque']==0 ? 'selected="selected"':'';?>>Não</option>
        </select>
        </div> -->
        <div>
            <label>Status</label>
            <select name="input[status]" >
              <option value="">Selecione uma opção</option>
              <option value="1" <?php echo $ln['status']==1 ? 'selected="selected"':'';?>>Ativo</option>
              <option value="0" <?php echo $ln['status']==0 ? 'selected="selected"':'';?>>Inativo</option>
            </select>
        </div>

     <!--
        <label>Categorias</label>
        <fieldset >

          <span>
          <input type="checkbox" value="<?//=$i;?>" name="categoria[]" />
          Opção 1
          </span>

        </fieldset>
     -->

     <!--
        <label>Categorias 2</label>
        <fieldset>

          <span>
          <input name="categoria2[]" type="radio" />
          Opção 1
          </span>

        </fieldset>
     -->
        <br />

        <input type="hidden" name="id" value="<?php echo $ln['id'];?>" />
        <input type="button" value="Cancelar" class="altera" name="cancelar" onclick="javascript:window.location.href='<?php echo $_SESSION['continue'];?>'" />
        <input type="submit" value="Alterar" name="alterar" class="envia"  />

      </form>
    </div>
  </div>
</div>
<?php
	include 'config.php';

	if($pAdd!==1)//VALIDANDO A PERMISSÃO DE CADASTRAR
	{
		location($_SESSION['continue']);//PARANDO O SCRIPT E REDIRECIONANDO
	}

	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		$_POST['input']['img']   = upload('file');// UPLOAD DE ARQUIVOS
		$_POST['input']['datap'] = data($_POST['input']['datap']); //CONVERTENDO DATAS

		//**CAMPOS OBRIGATÓRIOS
		$_POST['input']['iduser'] = $_SESSION['id_user'];//ID DO USER
		$_POST['input']['data'  ] = data();//DATA ATUAL DE CADASTRO
		//***

		$cadastro = $sql->insert($tabela);//CADASTRANDO

		//**CAMPO OBRIGATÓRIO
		$IDModulo = mysql_insert_id();
		//***

		if($cadastro===true)
		{
			//continueAcao('Cadastro efetuado, continuar cadastrando ? ','Cadastro efetuado , continue cadastrando !','Cadastro efetuado !',1);
			logs(1,$tabela,$IDModulo,$_SESSION['id_user']);
      		location(urlencode($_SESSION['continue']),'Cadastro efetuado !',1);//REDIRECIONAMENTO
		}
		else
		{
			//continueAcao('Erro, ao tentar cadastrar ,tentar novamente ? ','Erro, ao tentar cadastrar , tente mais uma vez !','Erro, ao tentar cadastrar !',0);
			logs(2,$tabela,$IDModulo,$_SESSION['id_user']);
      		location(urlencode($_SESSION['continue']),'Erro, ao tentar cadastrar !');//REDIRECIONAMENTO
		}
	}
?>
<div id="meio">
  <div id="listagem">

    <h2><?php echo 'Inserir ',$titulo;?></h2> <!-- TITULO -->
    <a href="<?php echo urldecode($moduloReferenciaLink);?>" title="Voltar para <?php echo $moduloReferenciaNome;?>" alt="Voltar para <?php echo $moduloReferenciaNome;?>" class="voltar-modulo" >&lsaquo;&mdash;&nbsp;Voltar para <?php echo $moduloReferenciaNome;?></a>
    <ul class="bread"> <!-- ONDE ESTOU -->
      <li><a href="?a=home"><img src="imgs_site/homegif.gif" /></a></li>
      <li><a href="<?php echo urldecode($moduloReferenciaLink);?>"><?php echo $moduloReferenciaNome;?></a></li>
      <li><a href="<?php echo $_SESSION['continue'];?>"><?php echo $titulo;?></a></li>
      <li><a href="<?php echo $_SERVER['REQUEST_URI'];?>">Inserir</a></li>
    </ul>

    <div id="inserir">
      <form action="" method="post" class="validaFormulario" enctype="multipart/form-data" id="formCadastro">

        <div>
            <label>Título</label>
            <input name="input[titulo]" type="text" />
        </div>
        <div>
        	<label>Chamada</label>
        	<textarea  name="input[chamada]" class="chamada"></textarea>
        </div>
        <div>
            <label>Texto</label>
            <textarea name="input[texto]" class="texto" ></textarea>
        </div>
        <label>Imagem</label>
        <input type="file" name="file[]" />
        <p>Escolha imagens com uma resolução média de 800x600px. Você poderá fazer o upload de arquivos *.jpg, *.gif, *.png.</p>

        <div>
            <label>Data de publicação</label>
            <input name="input[datap]" type="text" class="metade"  value="<?php echo date('d/m/Y H:i:s');?>" />
        </div>


     <!-- 	<div>
     		<label>Fonte</label>
      	<input type="text" name="input[fonte]" />
      </div>  -->

      <!-- <div>
        <label>Vídeo</label>
  	    <input type="text" class="metade" name="input[video]" />
          <p>Informe o link do vídeo. Ex : http://www.youtube.com/watch?v=YftxT3DDscI&feature=g-logo&context=G233dce5FOAAAAAAABAA </p>
      </div> -->

     	<!--
        <div>
        <label>Link</label>
        <input type="text" name="input[link]" class="metade" />
         <p>Informe o link. Ex : http://www.shapeweb.com.br/ </p>
        </div>
      -->

       <div>
        <label>Destaque</label>
        <select name="input[destaque]">
          <option value="">Selecione uma opção</option>
          <option value="1">Sim</option>
          <option value="0" selected="selected">Não</option>
        </select>
        </div>
        <div>
            <label>Status</label>
            <select name="input[status]">
              <option value="">Selecione uma opção</option>
              <option value="1" selected="selected">Ativo</option>
              <option value="0">Inativo</option>
            </select>
        </div>

         <!--
            <label>Categorias</label>
            <fieldset>

              <span>
              <input type="checkbox" value="" name="categoria[]" />
              Opção 1</span>

            </fieldset>
         -->

         <!--
            <label>Categorias 2</label>
            <fieldset>

              <span>
              <input name="categoria2[]" type="radio" />
              Opção 1</span>

            </fieldset>
        -->
        <br />
        <input type="hidden" name="input[id_modulo_refencia]" value="<?php echo $moduloReferenciaID;?>" />
        <input type="button" value="Cancelar" class="altera" name="cancelar" onclick="javascript:window.location.href='<?php echo $_SESSION['continue'];?>'" />
        <input type="submit" value="Cadastrar" class="envia" name="cadastar" />

      </form>
    </div>
  </div>
</div>
<?php
	include 'conn/autenticacao.php';

	$tabela = 'sh_user';
	$titulo = 'Minha Conta';

	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		$img = upload('file_alt');//UPLOAD DE ARQUIVOS

		$_SESSION['nome_user'] = $_POST['input']['nome'];

		if(!empty($_POST['senha_alt']))
		{
			$_POST['input']['senha'] = md5($_POST['senha_alt']);//NOVA SENHA
		}

		if(!empty($img))
		{
			unlink(_FILES_.$_POST['input']['img']);//EXCLUINDO IMAGEM ATUAL , SE EXISTIR UMA NOVA
			$_POST['input']['img'] = $img;//ALTERANDO IMAGEM ATUAL , SE EXISTIR UMA NOVA
			$_SESSION['img_user' ] = $img;
		}

		$alteracao = $sql->update($tabela,' id = '.$_POST['id']);//ALTERANDO

		if($alteracao===true)
		{
			location($_SESSION['continue'],'Alteração efetuada !',1);//REDIRECIONAMENTO
			logs(3,$tabela,$_POST['id'],$_SESSION['id_user']);
		}
		else
		{
			location($_SESSION['continue'],'Erro, ao tentar alterar !');//REDIRECIONAMENTO
			logs(4,$tabela,$_POST['id'],$_SESSION['id_user']);
		}
	}

	$ln = $sql->select("select nome,email,img,senha,id,login from `$tabela` WHERE id = ".$_SESSION['id_user']);
	$ln = $ln[0];
?>
<div id="meio">
  <div id="listagem">
    <h2><?php echo 'Alterar ',$titulo;?></h2>

    <ul class="bread">
      <li><a href="?a=home"><img src="imgs_site/homegif.gif" /></a></li>
      <li><a href="?a=<?php echo $_GET['a'],'&id=',$_GET['id'];?>">Alterar</a></li>
    </ul>

    <div id="inserir">
      <form action="" method="post" class="validaFormulario" enctype="multipart/form-data" id="formAlterar">
      	<div>
            <label>Nome</label>
            <input name="input[nome]" type="text" value="<?php echo $ln['nome'];?>"   <?php echo isset($_GET['ref']) ? 'class="nofocus"':''?> />
        </div>
         <div>
            <label>E-Mail</label>
            <input name="input[email]" type="text" value="<?php echo $ln['email'];?>" <?php echo isset($_GET['ref']) ? 'class="nofocus"':''?> />
        </div>
        <div>
            <label>Login</label>
            <input name="input[login]" type="text" value="<?php echo $ln['login'];?>" <?php echo isset($_GET['ref']) ? 'class="nofocus"':''?> />
        </div>

        <div id="pgenerator">
            <label>Alterar Senha</label>
            <input name="senha_alt" type="password" id="password" />
            <input type="button" value="Gerar Senha" id="generate-password">
            <span id="display-password"></span>
        </div>

        <div>
        	<?php echo lightbox($ln['img'],'640x390',' title="'.$ln['nome'].'" alt="'.$ln['nome'].'" ','','class="cl-img"');?>
        </div>

        <div>
            <label>Alterar Foto</label>
          <input type="file" name="file_alt[]"/>

            <input type="hidden" name="input[img]" value="<?php echo $ln['img'];?>"  />
            <p>Escolha outra imagem para trocar a atual.</p>
            <p>Escolha imagens com uma resolução média de 150x150px. Você poderá fazer o upload de arquivos .jpg, .gif, .png.</p>
        </div>
        <input type="hidden" name="id" value="<?php echo $ln['id'];?>" />
        <input type="button" value="Cancelar"  name="cancelar" class="altera" onclick="javascript:window.location.href='<?php echo $_SESSION['continue'];?>'" />
        <input type="submit" value="Alterar" name="alterar" class="envia" />
      </form>
    </div>
  </div>
</div>

<?php
	include 'config.php';

	if($pAlt!==1)//VALIDANDO A PERMISSÃO DE ALTERAR
	{
		location($_SESSION['continue']);//PARANDO O SCRIPT E REDIRECIONANDO
	}

	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		//$img = upload('file_alt');//UPLOAD DE ARQUIVOS
		//$_POST['input']['datap'] = data($_POST['input']['datap']); // CONVERTENDO DATAS

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
            <label>Nome</label>
            <input name="input[nome]" type="text" value="<?php echo $ln['nome'];?>" class="brw-nome" />
        </div>

        <div>
          <label>Destaque</label>
          <select name="input[destaque]">
            <option value="">Selecione uma opção</option>
            <option value="1" <?php echo $ln['destaque']==1 ? 'selected="selected"':'';?>>Sim</option>
            <option value="0" <?php echo $ln['destaque']==0 ? 'selected="selected"':'';?>>Não</option>
          </select>
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
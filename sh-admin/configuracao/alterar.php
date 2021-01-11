<?php
	include 'config.php';

	if($pAlt!==1) {
		location($_SESSION['continue']);//PARANDO O SCRIPT E REDIRECIONANDO
	}

	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		$alteracao = $sql->update($tabela,' id = '.$_POST['id']);//ALTERANDO...

		if ( $alteracao===true )
		{
			logs(3,$tabela,$_POST['id'],$_SESSION['id_user']);
      		setMensagem('Alteração efetuada !',1);
		}
		else
		{
			logs(4,$tabela,$_POST['id'],$_SESSION['id_user']);
      		setMensagem('Erro, ao tentar alterar !',0);
		}
	}

    $ln = $sql->select("select * from `$tabela` WHERE id = ".$_GET['id']);
    $ln = $ln[0];
?>

<script>
  setMessag('<?php echo $_SESSION['msg']['txt'];?>',<?php echo (int) $_SESSION['msg']['log'];?>);
</script>
<div id="meio">
  <div id="listagem">

    <h2><?php echo $titulo;?></h2>  <!-- TITULO -->

    <ul class="bread"> <!-- ONDE ESTOU -->
      <li><a href="?a=home"><img src="imgs_site/homegif.gif" /></a></li>
      <li><a href="<?php echo $_SESSION['continue'];?>"><?=$titulo;?></a></li>
      <li><a href="<?php echo $_SERVER['REQUEST_URI'];?>">Alterar</a></li>
    </ul>

    <div id="inserir">
      <form action="" method="post" class="validaFormulario" enctype="multipart/form-data" id="formAlterar">

        <div>
            <label>Titulo</label>
            <input name="input[titulo]" type="text" value="<?php echo $ln['titulo'];?>" />
        </div>

        <div>
            <label>Description</label>
            <input name="input[description]" type="text" value="<?php echo $ln['description'];?>" />
        </div>

        <div>
            <label>Keywords</label>
            <input name="input[keywords]" type="text" value="<?php echo $ln['keywords'];?>" />
        </div>

        <div>
            <label>Analytics ID</label>
            <input name="input[analytics_id]" type="text" value="<?php echo $ln['analytics_id'];?>" />
        </div>

        <div>
            <label>Facebook ID</label>
            <input name="input[fb_app_id]" type="text" value="<?php echo $ln['fb_app_id'];?>" />
        </div>

        <div>
            <label>Facebook secret ID</label>
            <input name="input[fb_app_secret]" type="text" value="<?php echo $ln['fb_app_secret'];?>" />
        </div>

        <br />

        <input type="hidden" name="id" value="<?php echo $ln['id'];?>" />
        <input type="button" value="Cancelar" class="altera" name="cancelar" onclick="javascript:window.location.href='<?php echo $_SESSION['continue'];?>'" />
        <input type="submit" value="Alterar" name="alterar" class="envia"  />

      </form>
    </div>
  </div>
</div>
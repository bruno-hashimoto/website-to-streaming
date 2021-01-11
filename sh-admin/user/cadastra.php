<?php
	include 'config.php';

	if($pAdd!==1)//VALIDANDO A PERMISSÃO DE CADASTRAR
	{
		location($_SESSION['continue']);//PARANDO O SCRIPT E REDIRECIONANDO
	}

	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		$_POST['input']['img']   = upload('file');// UPLOAD DE ARQUIVOS
		$_POST['input']['senha'] = md5($_POST['input']['senha']);
		//$_POST['input']['datap'] = data($_POST['input']['datap']); //CONVERTENDO DATAS

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
			//PERMISSÃO USER
			if(!empty($_POST['modulo']))
			{
				  foreach($_POST['modulo'] as $id => $op)
				  {
						if(count($_POST['modulo'][$id]) > 1)
						{
						  $ver   = $_POST['modulo'][$id]['ver'];
						  $add   = $_POST['modulo'][$id]['add'];
						  $alt   = $_POST['modulo'][$id]['alt'];
						  $del   = $_POST['modulo'][$id]['del'];
						  $tipo  = $_POST['modulo'][$id]['tipo'];

						  $sql->query("INSERT INTO `sh_menu_permissao` (`iduser`, `idmenu`,`ver`, `add`, `alt`, `del`, `tipo`) VALUES ('$IDModulo', '$id','$ver', '$add', '$alt', '$del', '$tipo')");
						}
				  }
			}
			// FIM PERMISSÃO USER

			//continueAcao('Cadastro efetuado, continuar cadastrando ? ','Cadastro efetuado , continue cadastrando !','Cadastro efetuado !',1);
			logs(1,$tabela,$IDModulo,$_SESSION['id_user']);
      		location($_SESSION['continue'],'Cadastro efetuado !',1);//REDIRECIONAMENTO
		}
		else
		{
			//continueAcao('Erro, ao tentar cadastrar ,tentar novamente ? ','Erro, ao tentar cadastrar , tente mais uma vez !','Erro, ao tentar cadastrar !',0);
			logs(2,$tabela,$IDModulo,$_SESSION['id_user']);
      		location($_SESSION['continue'],'Erro, ao tentar cadastrar !');//REDIRECIONAMENTO
		}
	}

	$select = $_SESSION['id_user'] == 1 ? "SELECT m.* FROM `sh_menu` m where m.excluido = 0 and m.id > 1 ORDER BY m.tipo asc ,m.nome ASC":
  "SELECT m.* FROM `sh_menu` m INNER JOIN `sh_menu_permissao` mp ON m.id=mp.idmenu WHERE m.excluido = 0 and  m.id > 1 and mp.iduser = ".$_SESSION['id_user']." ORDER BY m.tipo asc , m.nome ASC";

	$menus  = $sql->select($select);
?>
<div id="meio">
  <div id="listagem">

    <h2><?php echo 'Inserir ',$titulo;?></h2> <!-- TITULO -->

    <ul class="bread"> <!-- ONDE ESTOU -->
      <li><a href="?a=home"><img src="imgs_site/homegif.gif" /></a></li>
      <li><a href="<?php echo $_SESSION['continue'];?>"><?php echo $titulo;?></a></li>
      <li><a href="<?php echo $_SERVER['REQUEST_URI'];?>">Inserir</a></li>
    </ul>

    <div id="inserir">
      <form action="" method="post" class="validaFormulario" enctype="multipart/form-data" id="formCadastro">

        <div>
            <label>Nome</label>
            <input name="input[nome]" type="text"/>
        </div>
        <!-- <div>
            <label>E-Mail</label>
            <input name="input[email]" type="text"/>
        </div> -->
        <div>
            <label>Login</label>
            <input name="input[login]" type="text" />
        </div>
        <div>
            <label>Senha</label>
            <input name="input[senha]" type="password"/>
        </div>

        <label>Foto do usuário</label>
        <input type="file" name="file[]" />
        <p>Escolha imagens com uma resolução média de 150x150px. Você poderá fazer o upload de arquivos *.jpg, *.gif, *.png.</p>

        <div>
            <label>Status</label>
            <select name="input[status]">
              <option value="">Selecione uma opção</option>
              <option value="1" selected="selected">Ativo</option>
              <option value="0">Inativo</option>
            </select>
        </div>

         <label>Permissões</label>

        <div style="display:<?php echo count($menus) >=6 ? 'table':'none';?>; width:100%; margin:15px 0 10px 0;">
          <input type="button" value="Cancelar" class="altera" name="cancelar" onclick="javascript:window.location.href='<?php echo $_SESSION['continue'];?>'" />
          <input type="submit" value="Cadastrar" class="envia" name="cadastar" />
        </div>

      <?php
        $i_menu = 0;
        $i_site = 0;
        $i_syst = 0;
        $i_ecom = 0;

        foreach ($menus as $lnMenus)
        {
          $nameModulo = $lnMenus['nome'];

          if($lnMenus['tipo']==0 && $i_site==0)
          {
				$i_site++;
				echo '<label class="titleM" >Site</label>';
          }

          if($lnMenus['tipo']==2 && $i_syst==0)
          {
  				$i_syst++;
  				echo '<label class="titleM" >Sistema</label>';
          }

          if($lnMenus['tipo']==1 && $i_ecom==0)
          {
				$i_ecom++;
				echo '<label class="titleM" >E-commerce</label>';
          }
      ?>

        <fieldset class="modulos">
        	<a <?php echo ($lnMenus['status']==1) ? 'href="?a='.$lnMenus['pasta'].'/index" ':'' ?> target="_blank" class="nameModulo">
	            <?php echo $nameModulo;?>
            </a>

            <table width="730px" border="0" cellspacing="2" cellpadding="0" class="c-op-modulo">
              <tr>
              	 <td width="5%">
                  	<input type="checkbox" id="Visualizar_<?php echo $i_menu;?>" title="Visualizar <?php echo $nameModulo;?>" name="modulo[<?php echo $lnMenus['id'];?>][ver]" value="1"  />
                  </td>
                  <td>
                  	<label for="Visualizar_<?php echo $i_menu;?>" title="Visualizar <?php echo $nameModulo;?>">Visualizar</label>
                  </td>

                  <td width="5%">
                  	<input type="checkbox" id="Cadastra_<?php echo $i_menu;?>" title="Cadastra <?php echo $nameModulo;?>" name="modulo[<?php echo $lnMenus['id'];?>][add]" value="1"  />
                  </td>
                  <td>
                  	<label for="Cadastra_<?php echo $i_menu;?>" title="Cadastra <?php echo $nameModulo;?>">Cadastra</label>
                  </td>

                  <td width="5%">
                  	<input type="checkbox" id="Alterar_<?php echo $i_menu;?>" title="Alterar <?php echo $nameModulo;?>"   name="modulo[<?php echo $lnMenus['id'];?>][alt]"  value="1" />
                  </td>
                  <td>
                  	<label for="Alterar_<?php echo $i_menu;?>" title="Alterar <?=$nameModulo;?>">Alterar</label>
                  </td>

                  <td width="5%">
                  		<input type="checkbox" id="Deletar_<?php echo $i_menu;?>" title="Deletar <?php echo $nameModulo;?>"  name="modulo[<?php echo $lnMenus['id'];?>][del]" value="1" />
                  </td>
                  <td>
                  	<label for="Deletar_<?php echo $i_menu;?>" title="Deletar <?=$nameModulo;?>">Deletar</label>
                  </td>
                  <td style="padding-right:20px;">
                      <select name="modulo[<?=$lnMenus["id"];?>][tipo]" title="Selecione o tipo do usuário" style="width:100%;*width:136px;">
                        <option value="1" title="Terá acesso apenas a suas postagens">Usuário</option>
                        <option value="2" <?php echo $_SESSION['id_user']===1 ? 'selected="selected"':'';?> title="Terá acesso a todas as postagens">Administrador</option>
                      </select>
                  </td>

                  <td><a href="#" class="marcar-todos-user" title="Marcar todas as opções ">Marcar todos</a></td>
                  <td><a href="#" class="desmarcar-todos-users" title="Desmarcar todas as opções ">Desmarcar todos</a></td>
                   <td>
                  	<span style="color:#666;"><?php echo $lnMenus['status'] == 1 ?'Ativo':'Inativo';?></span>
                  </td>
              </tr>

            </table>

        </fieldset>
    <?php
      $i_menu++;
      }
    ?>
        <br />
        <input type="button" value="Cancelar" class="altera" name="cancelar" onclick="javascript:window.location.href='<?php echo $_SESSION['continue'];?>'" />
        <input type="submit" value="Cadastrar" class="envia" name="cadastar" />

      </form>
    </div>
  </div>
</div>
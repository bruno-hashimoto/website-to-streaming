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

    if(!empty($_POST['senha_alt']))
    {
      $_POST['input']['senha'] = md5($_POST['senha_alt']);//NOVA SENHA
    }

    $alteracao = $sql->update($tabela,' id = '.$_POST['id']);//ALTERANDO...


    if($alteracao===true)
    {
      //PERMISSÃO USER
      $sql->query("DELETE FROM `sh_menu_permissao` WHERE `iduser` = ".$_POST['id']);

      if(!empty($_POST['modulo']))
      {
        foreach ($_POST['modulo'] as $id => $op)
        {
        if(count($_POST['modulo'][$id]) > 1)
        {
          $ver   = $_POST['modulo'][$id]['ver'] ? 1 : 0;
          $add   = $_POST['modulo'][$id]['add'] ? 1 : 0;
          $alt   = $_POST['modulo'][$id]['alt'] ? 1 : 0;
          $del   = $_POST['modulo'][$id]['del'] ? 1 : 0;
          $tipo  = $_POST['modulo'][$id]['tipo'];

          $sql->query("INSERT INTO `sh_menu_permissao` (`iduser`, `idmenu`,`ver`, `add`, `alt`, `del`, `tipo`) VALUES ('".$_POST['id']."', '$id',$ver,$add,$alt,$del,'$tipo')");

          // print_r("INSERT INTO `sh_menu_permissao` (`iduser`, `idmenu`,`ver`, `add`, `alt`, `del`, `tipo`) VALUES ('".$_POST['id']."', '$id',$ver,$add,$alt,$del,'$tipo')"); die;
        }
        }
      }

      //FIM PERMISSÃO USER

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

  $select = $_SESSION['id_user'] == 1 ? "SELECT m.* FROM `sh_menu` m where m.excluido = 0 and m.id > 1 ORDER BY m.tipo asc , m.nome ASC":
  "SELECT m.* FROM `sh_menu` m INNER JOIN `sh_menu_permissao` mp ON m.id=mp.idmenu WHERE m.excluido = 0 and m.id>1 and mp.iduser = ".$_SESSION['id_user']." ORDER BY m.tipo asc, m.nome ASC";

  $menus  = $sql->select($select);
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
            <input name="input[nome]" type="text" value="<?php echo $ln["nome"]?>"/>
        </div>
       <!--  <div>
            <label>E-Mail</label>
            <input name="input[email]" type="text" value="<?php echo $ln["email"]?>"/>
        </div> -->
        <div>
            <label>Login</label>
            <input name="input[login]" type="text" value="<?php echo $ln["login"]?>"/>
        </div>
        <div>
            <label>Alterar Senha</label>
            <input name="senha_alt" type="password" value=""/>
            <p>* Dígite outra senha para trocar a atual.</p>
        </div>
        <div>
      <?php echo lightbox($ln['img'],'640x390','','','class="cl-img"');?>
        </div>
        <div>
            <label>Trocar foto do Usuário</label>
            <input type="file" name="file_alt[]"/>
            <input type="hidden" name="input[img]" value="<?php echo $ln["img"]?>"  />
            <p>Escolha outra imagem para trocar a atual.</p>
            <p>Escolha imagens com uma resolução média de 150x150px. Você poderá fazer o upload de arquivos *.jpg, *.gif, *.png.</p>
        </div>

        <div>
            <label>Status</label>
            <select name="input[status]" >
              <option value="">Selecione uma opção</option>
              <option value="1" <?php echo $ln['status']==1 ? 'selected="selected"':'';?>>Ativo</option>
              <option value="0" <?php echo $ln['status']==0 ? 'selected="selected"':'';?>>Inativo</option>
            </select>
        </div>

        <label>Permissões</label>

        <div style="display:<?php echo count($menus) >=6 ? 'table':'none';?>; width:100%; margin:15px 0 10px 0;">
        <input type="button" value="Cancelar" class="altera" name="cancelar" onclick="javascript:window.location.href='<?php echo $_SESSION['continue'];?>'" />
        <input type="submit" value="Alterar" name="alterar" class="envia"  />
        </div>

      <?php
        $i_menu = 0;
    $i_site = 0;
        $i_syst = 0;
        $i_ecom = 0;

        foreach($menus as $lnMenus)
        {
            $nameModulo = $lnMenus['nome'];

            $qModulo  = $sql->query("SELECT * FROM `sh_menu_permissao`  where idmenu = ".$lnMenus['id']." and iduser = ".$ln['id']." ");
            $lnModulo = $sql->fetch($qModulo);

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
        <fieldset class="modulos <?php echo $sql->rows($qModulo) > 0 ? 'bg-modulos':'';?>" >
            <a <?php echo ($lnMenus['status']==1) ? 'href="?a='.$lnMenus['pasta'].'/index" ':'' ?> target="_blank" class="nameModulo">
              <?php echo $nameModulo;?>
            </a>

            <table width="730px" border="0" cellspacing="2" cellpadding="0" class="c-op-modulo">
              <tr>
                  <td width="5%">
                    <input type="checkbox" id="Visualizar_<?php echo $i_menu;?>" title="Visualizar <?php echo $nameModulo;?>" name="modulo[<?php echo $lnMenus['id'];?>][ver]" value="1" <?php echo $lnModulo['ver'] == 1 ? 'checked="checked"':'';?>  />
                  </td>
                  <td>
                    <label for="Visualizar_<?php echo $i_menu;?>" title="Visualizar <?php echo $nameModulo;?>">Visualizar</label>
                  </td>

                  <td width="5%">
                    <input type="checkbox" id="Cadastra_<?php echo $i_menu;?>" title="Cadastra <?php echo $nameModulo;?>" name="modulo[<?php echo $lnMenus['id'];?>][add]" value="1" <?php echo $lnModulo['add'] == 1 ? 'checked="checked"':'';?>  />
                  </td>
                  <td><label for="Cadastra_<?php echo $i_menu;?>" title="Cadastra <?php echo $nameModulo;?>">Cadastra</label></td>

                  <td width="5%">
                    <input type="checkbox" id="Alterar_<?php echo $i_menu;?>" title="Alterar <?php echo $nameModulo;?>"   name="modulo[<?php echo $lnMenus['id'];?>][alt]"  value="1" <?php echo $lnModulo['alt'] == 1 ? 'checked="checked"':'';?> />
                  </td>

                  <td>
                    <label for="Alterar_<?php echo $i_menu;?>" title="Alterar <?php echo $nameModulo;?>">Alterar</label>
                  </td>

                  <td width="5%">
                    <input type="checkbox" id="Deletar_<?php echo $i_menu;?>" title="Deletar <?php echo $nameModulo;?>"  name="modulo[<?php echo $lnMenus['id'];?>][del]" value="1" <?php echo $lnModulo['del'] == 1 ? 'checked="checked"':'';?> />
                  </td>
                  <td>
                    <label for="Deletar_<?php echo $i_menu;?>" title="Deletar <?php echo $nameModulo;?>">Deletar</label>
                  </td>

                  <td style="padding-right:20px;">
                      <select name="modulo[<?=$lnMenus["id"];?>][tipo]" title="Selecione o tipo do usuário" style="width:100%; *width:136px;">
                        <option value="1" title="Terá acesso apenas a suas postagens" <?php echo $lnModulo['tipo'] == 1 ? 'selected="selected"':'';?>>Usuário</option>
                        <option value="2" title="Terá acesso a todas as postagens"    <?php echo $lnModulo['tipo'] == 2 || ($lnModulo['tipo'] != 1 && $_SESSION['id_user']===1) ? 'selected="selected"':'';?>>Administrador</option>
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

        <input type="hidden" name="id" value="<?php echo $ln['id'];?>" />
        <input type="button" value="Cancelar" class="altera" name="cancelar" onclick="javascript:window.location.href='<?php echo $_SESSION['continue'];?>'" />
        <input type="submit" value="Alterar" name="alterar" class="envia"  />

      </form>
    </div>
  </div>
</div>
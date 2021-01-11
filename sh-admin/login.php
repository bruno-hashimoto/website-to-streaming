<?php
	include("conn/session.php");
	($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['login']) && !empty($_POST['senha'])) or exit('ERROR');

		include 'conn/config.php';
		include 'conn/funcoes.php';
		include 'conn/class/Banco.class.php';

		/*VARS*/
		$sql   = new Banco();
		$ln    = array();
		$lnMenu= array();
		$login = '';
		$qMenu = NULL;
		/*FIM VARS*/

		$login = $sql->escapeString($_POST['login']);

		$ln = $sql->select("SELECT nome,img,id,status,excluido,senha FROM `sh_user` WHERE `status`=1 and `excluido` = 0 and BINARY `login` = '".$login."' ORDER BY `id` DESC LIMIT 0,1");

		(count($ln)===1) or exit('ERRORLOGIN');

        // Senha
        for ($i=0; $i < 1000; $i++) {
            $hashMd5 = md5($_POST['senha']);
        }

		($hashMd5===$ln[0]['senha']) or exit('ERRORSENHA');

		//DADOS DO USER
		session_regenerate_id(true);

		$_SESSION['session_id'   ] = session_id();
		$_SESSION['nome_user'    ] = $ln[0]['nome'];
		$_SESSION['img_user'     ] = $ln[0]['img'];
		$_SESSION['id_user'      ] = (int) $ln[0]['id'];
		$_SESSION['status_user'  ] = (int) $ln[0]['status'];
		$_SESSION['excluido_user'] = (int) $ln[0]['excluido'];
		//***

		logs(7,'sh_user',$ln[0]['id'],$ln[0]['id']); //GERANDO LOG

		($ln[0]['id'] > 1) or exit(true);

		///**PEGANDO AS PERMISSOES DO USER
		$qMenu  = $sql->query("SELECT m.pasta,mp.ver,mp.add,mp.alt,mp.del,mp.tipo FROM `sh_menu` m INNER JOIN `sh_menu_permissao` mp on m.id = mp.idmenu WHERE mp.iduser = ".$_SESSION['id_user']);

		while($lnMenu = $sql->fetch($qMenu))
		{
			$_SESSION['permissao_user'][$lnMenu['pasta']]['ver' ] = $lnMenu['ver'];
			$_SESSION['permissao_user'][$lnMenu['pasta']]['add' ] = $lnMenu['add'];
			$_SESSION['permissao_user'][$lnMenu['pasta']]['alt' ] = $lnMenu['alt'];
			$_SESSION['permissao_user'][$lnMenu['pasta']]['del' ] = $lnMenu['del'];
			$_SESSION['permissao_user'][$lnMenu['pasta']]['tipo'] = $lnMenu['tipo'];
		}
		//************
		exit(true);
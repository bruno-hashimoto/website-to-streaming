<?php
	error_reporting(0);

	($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['email']) && preg_match("/^([0-9a-zA-Z]+([_.-]?[0-9a-zA-Z]+)*@[0-9a-zA-Z]+[0-9,a-z,A-Z,.,-]*(.){1}[a-zA-Z]{2,4})+$/",$_POST['email']) !== false ) or exit();

		header('Content-Type: text/html;  charset=ISO-8859-1',true);

		include 'conn/config.php';
		include 'conn/class/Banco.class.php';
		include 'conn/funcoes.php';

		$sql = new Banco();

		$n  = array();
		$ln = array();
		$rs = '';
		$rSMD5 ='';
		$email = $_POST['email'];

		$n  = $sql ->query("select status,excluido,nome from `sh_user` where BINARY email = '$email' ");
		$ln = $sql->fetch($n);

		if(empty($ln))
		{
			exit('Você não está cadastrado no sistema !');
		}
		elseif($ln['status']!=1)
		{
			exit('Seu usuário está inativo !');
		}
		elseif($ln['excluido']!=0)
		{
			exit('Você foi excluido do sistema !');
		}
		else
		{
			$rS = geraCodigo();
			$rSMD5 = md5($rS);

			$sql->query("update `sh_user` set senha = '$rSMD5' where BINARY email = '$email' and excluido = 0 and status = 1 ") or exit('Erro , ao tentar alterar senha !');

			$html = array
			(
				'Nova Senha'=>$rS
			);

			//ENVIAR PARA
			$emails[0]['email'] = $email;
			$emails[0]['nome']  = $ln['nome'];
			//FIM ENVIAR PARA

			//RESPONDER PARA
			$replys[0]['email'] = 'contato@shapeweb.com.br';
			$replys[0]['nome']  = 'Shapeweb';
			//FIM RESPONDER PARA

			enviaemail($emails,$replys,'Nova senha Admin - Shapeweb',$html) or exit('Erro , ao tentar enviar mensagem !');

			unset($_POST);
			exit('O email com a nova senha foi enviado !');
		}
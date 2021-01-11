<?php
	include 'conn/session.php';
	include 'conn/autenticacao.php';
	include 'conn/config.php';
	include 'conn/class/Banco.class.php';
	include 'conn/funcoes.php';

	$sql = new Banco();

	$q = $sql ->query("UPDATE `sh_file` SET principal = 0 WHERE principal = 1 and id_modulo=".$_POST['id_modulo']." and modulo='".$_POST['modulo']."' ");

	if($q===true)
	{
		$marca = $sql ->query("UPDATE `sh_file` SET principal = 1 WHERE id=".$_POST['foto']." and id_modulo=".$_POST['id_modulo']." and modulo='".$_POST['modulo']."' and excluido = 0 ");
		echo $marca;
	}

	unset($_POST);
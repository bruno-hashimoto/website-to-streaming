<?php
	include 'conn/session.php';
	include 'conn/autenticacao.php';
	include 'conn/config.php';
	include 'conn/class/Banco.class.php';
	
	header("Content-Type: text/html;  charset=ISO-8859-1",true); 
	
	$sql    = new Banco();
	
	$table = $_POST['table'];
	$id    = $_POST['id'];
	
	$coment = $sql ->query("UPDATE `$table` SET comentario = '".$sql->convertQ(utf8_decode($_POST['comentario']))."' WHERE id = '$id' ");
	
	echo $coment;
	
	unset($_POST);
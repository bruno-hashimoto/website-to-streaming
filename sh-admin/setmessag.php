<?php
	include('conn/session.php');
	include('conn/autenticacao.php');
	include 'conn/config.php';
	include 'conn/funcoes.php';

	setMensagem($_POST['m'],$_POST['l']);
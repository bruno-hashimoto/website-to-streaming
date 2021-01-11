<?php
	include('conn/session.php');
	//GRAVANDO LOG
	include('conn/funcoes.php');
	logs(9,'sh_user',$_SESSION['id_user'],$_SESSION['id_user']);
	//****
	session_unset();
	session_destroy();
	session_write_close();

	header('Location: index.php');
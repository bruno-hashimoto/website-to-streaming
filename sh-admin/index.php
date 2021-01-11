<?php
	include('conn/session.php');
	include('conn/config.php');

	if(isset($_SESSION['id_user'])===true && is_numeric($_SESSION['id_user'])===true && $_SESSION['status_user']===1 && $_SESSION['excluido_user']===0 && $_SESSION['session_id'] === session_id())
    {
		header('Location: sh_index.php');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <noscript><meta http-equiv="Refresh" content="0; url=errojs.html"></noscript>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
        <title>Admin ShapeWeb</title>
        <link href="estilos.css" rel="stylesheet"  type="text/css" />
		<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
        <!--
        	<![CDATA[
        -->
        <script type="text/javascript" language="javascript" src="js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
		<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript" language="javascript" src="js/login.js"></script>
        <!--
        	]]>
        -->
    </head>

    <body>

    <div id="central">

    	<div class="top"></div>

        <div class="login">
            <img src="imgs_site/iconadmin.gif" class="icon" />
            <h1>Painel de Controle</h1>
            <form id="formLogin" method="post">
                <label>
                    Login<input type="text" name="login" alt="Login" title="Digite seu login" autocomplete=off />
                </label>
                <label>
                    Senha<input type="password" name="senha"  alt="Senha" title="Digite sua Senha"  />
                </label>
                <a href="recuperarsenha.php" rel="fancybox" title="Informe seu e-mail." alt="Informe seu e-mail.">Esqueceu sua senha ?</a>
                <p>
                	<input type="submit" value="Entrar" class="entrar" name="input" style="*margin-right:-12px;" alt="Entrar" title="Entrar" />
                	<span class="loadLogin">
                    	<img src="imgs_site/login.gif" />
                    </span>
                </p>
            </form>
        </div>
        <div class="bottom"></div>
         <a href="<?=_BASE_;?>" class="voltar-site" title="Voltar para <?=$endereco;?>" alt="Voltar para <?=$endereco;?>">&lsaquo;&mdash;&nbsp;Voltar para o site</a>
        <img src="imgs_site/assinatura.png" class="assinatura" title="Shapeweb" alt="Shapeweb" />
    </div>

    </body>
</html>
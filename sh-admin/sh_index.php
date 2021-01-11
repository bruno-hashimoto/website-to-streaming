<?php
	include('conn/session.php');
	include('conn/autenticacao.php');

	//*** PEGANDO PASTA ATUAL PARA VALIDAR A PERMISSAO
	$arrFolder = explode('/',$_GET['a']);
	$folder    = $arrFolder[0];

    (((array_key_exists($folder,$_SESSION['permissao_user']) === true && isset($_GET['a'])===true) | $_SESSION['id_user']===1 ) || $folder==='minhaconta' || !isset($_GET['a'])) or header('Location: '.$_SESSION['continue']);//VALIDANDO PERMISSAO DO MODULO
    //******

	include 'conn/config.php';
	include 'conn/class/Banco.class.php';
	include 'conn/class/Paginacao.class.php';
	include 'conn/funcoes.php';

	$page = new Paginacao();
	$sql  = new Banco();

	if(!isset($_SESSION['redirectLink']))
	{
		if($arrFolder[1] == 'index' || !isset($_SESSION['continue']))
		{
			$_SESSION['continue'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}
	}
	else
	{
		header('Location: '.$_SESSION['redirectLink']);
		$_SESSION['continue'] = _BASE_.'sh-admin/sh_index.php?a='.$_SESSION['redirectLinkReturnModulo'];
		unset($_SESSION['redirectLink'] , $_SESSION['redirectLinkReturnModulo']);
		die;
	}

    files('../files/');//DEFININDO LOCAL DOS ARQUIVOS ex: ../files/

    $global_configuracoes = $sql->fetch( $sql->query('SELECT * FROM `sh_configuracao` where id = 1') );
    $titulo = $global_configuracoes['titulo'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
        <noscript><meta http-equiv="Refresh" content="0; url=errojs.html"></noscript>

        <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600'>
        <link rel='stylesheet' type='text/css' href='js/lightbox-0.5/css/jquery.lightbox-0.5.css'>
        <link rel='stylesheet' type='text/css' href='js/jalerts/jquery.alerts.css'>
        <link rel='stylesheet' type='text/css' href='js/ui/jquery-ui-1.8.21.custom.css'>
        <link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="js/colorpicker/css/colorpicker.css" type="text/css" />

        <link rel="stylesheet" type="text/css" href="editor/summernote/dist/summernote.css" type="text/css" />
        <?php
            includeNoCache('estilos.css');
        ?>
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">

        <title>Painel de Controle <?php echo $titulo;?></title>

        <base href="<?php echo _BASE_.'sh-admin/sh_index.php';?>" />
        <!--
        	<![CDATA[
        -->
        <script type="text/javascript" language="javascript" src="js/jquery-1.8.2.min.js"></script>
        <!-- <script type="text/javascript" language="javascript" src="js/jquery-1.7.2.min.js"></script> -->
        <!-- <script type="text/javascript" language="javascript" src="js/jquery-3.3.1.min.js"></script> -->
        <script type="text/javascript" language="javascript" src="js/ui/jquery-ui-1.8.21.custom.min.js"></script>
		<script type="text/javascript" language="javascript" src="js/ui/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" language="javascript" src="js/ui/jquery-ui-sliderAccess.js"></script>
        <script type="text/javascript" language="javascript" src="js/jquery.validate.min.js"></script>
        <script type="text/javascript" language="javascript" src="js/maskedinput-1.1.4.pack.js"></script>
        <script type="text/javascript" language="javascript" src="js/jquery.tablednd_0_5.js"></script>
        <script type="text/javascript" language="javascript" src="js/jquery.tablesorter.min.js"></script>
        <script type="text/javascript" language="javascript" src="js/jquery.tools.min.js"></script>
        <script type="text/javascript" language="javascript" src="js/lightbox-0.5/js/jquery.lightbox-0.5.js"></script>
        <script type="text/javascript" language="javascript" src="js/jquery.flash.js"></script><!-- CARREGAR FLASH-->
        <!--EDITOR DE TEXTO-->
        
        <script type="text/javascript" language="javascript" src="editor/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" language="javascript" src="editor/ckeditor/ckadaptersjquery.js"></script>
		<script type="text/javascript" language="javascript" src="editor/ckfinder/ckfinder.js"></script>

        <!-- <script type="text/javascript" language="javascript" src="editor/summernote/dist/summernote.min.js"></script> -->
        <!-- <script type="text/javascript" language="javascript" src="editor/summernote/dist/lang/summernote-pt-BR.min.js"></script> -->

        <!--FIM EDITOR-->
        <script type="text/javascript" language="javascript" src="js/jalerts/jquery.alerts.js"></script><!--jALERT -->
        <script type="text/javascript" language="javascript" src="js/jquery.filestyle.js?001"></script><!--STYLE INPU FILE -->
        <script type="text/javascript" language="javascript" src="js/jquery.price_format.1.7.min.js"></script><!--PRINCE FORMAT-->
        <script type="text/javascript" language="javascript" src="js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
        <script type="text/javascript" language="javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <!--COLOR PICKER-->
		<script type="text/javascript" language="javascript" src="js/colorpicker/js/colorpicker.js"></script>
        <script type="text/javascript" language="javascript" src="js/colorpicker/js/eye.js"></script>
        <script type="text/javascript" language="javascript" src="js/colorpicker/js/utils.js"></script>
        <script type="text/javascript" language="javascript" src="js/colorpicker/js/layout.js?ver=1.0.2"></script>
        <!--FIM COLOR PICKER-->
        <script type="text/javascript" language="javascript" src="js/pgenerator.js"></script>

        <?php
			//PERMISSÕES
			unset($pVer,$pAdd,$pAlt,$pDel,$ptip);

			$pVer = ($_SESSION['id_user']===1) ? 1 :(int) $_SESSION['permissao_user'][$folder]['ver'];
			$pAdd = ($_SESSION['id_user']===1) ? 1 :(int) $_SESSION['permissao_user'][$folder]['add'];
			$pAlt = ($_SESSION['id_user']===1) ? 1 :(int) $_SESSION['permissao_user'][$folder]['alt'];
			$pDel = ($_SESSION['id_user']===1) ? 1 :(int) $_SESSION['permissao_user'][$folder]['del'];
			$ptip = ($_SESSION['id_user']===1) ? 2 :(int) $_SESSION['permissao_user'][$folder]['tipo'];
			//****
        ?>
        <script type="text/javascript" language="javascript">
			 var add = <?php echo $pAdd;?>,alt = <?php echo $pAlt;?>,del = <?php echo $pDel;?>,tip=<?php echo $ptip;?>;
        </script>

		<?php
			includeNoCache('js/permission.js');
			includeNoCache('js/functions.js' );
            includeNoCache('js/scripts.js'   );
        ?>
        <!--
        	]]>
        -->

        <style type="text/css">
			/**MARCA MENU TOPO**/
			div#menu ul li a[href*='<?php echo $_GET['a'];?>']{background:url(imgs_site/backmenuh.gif) top repeat-x!important;}
			/********/
			/**MARCA MENU LATERAL**/
			div#navega ul li a[rel='<?php echo empty($folder) ? '?a=' : (!empty($_GET['moduloReferenciaPasta']) ? $_GET['moduloReferenciaPasta'] : $folder);?>']{background:url(imgs_site/setamenu.png) #ffffff right center no-repeat!important;}
			/*******/
        </style>
    </head>

	<body onload="javascript:setMessag('<?php echo $_SESSION['msg']['txt'];?>',<?php echo (int) $_SESSION['msg']['log'];?>);">
        <div id="box-message"></div>
        <div id="topo">
            <div id="identifica">
                <h1>Painel de Controle - <?php echo $titulo;?></h1>
            </div>

            <div id="menu">
                <ul>
                    <li>
	                   <?php echo lightbox($_SESSION['img_user'],'34x30',' title="'.$_SESSION['nome_user'].'" alt="'.$_SESSION['nome_user'].'" ',true,'class="light"');?>
                    </li>
                    <li>
                    </li>
                    <li><span><?php echo $_SESSION['nome_user'];?></span></li>
                    <li><a href="?a=minhaconta" title="Deseja alterar seus dados ? " alt="Deseja alterar seus dados ? " >MINHA CONTA</a></li>
                    <li><a href="logout.php" title="Deseja sair do sistema ? " alt=" Deseja sair do sistema ? " >SAIR</a></li>
                </ul>
            </div>
        </div>

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="9%" valign="top">
                <?php include 'menu.php';?>
            </td>
            <td width="91%" valign="top">
                <?php
                    include (!empty($_GET['a']) && file_exists($_GET['a'].'.php') && is_file($_GET['a'].'.php') ) ? $_GET['a'].'.php' : 'home.php';
                ?>
            </td>
          </tr>
        </table>
        <img src="imgs_site/assinatura.png" class="assinatura" />
	</body>
</html>
<?php
	unset($_SESSION['msg'],$_SESSION['msg']['log']);//LIMPANDO MENSAGEM GERADA
?>
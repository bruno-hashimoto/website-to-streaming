<?php
	include('../conn/autenticacao.php');
	/*
	 ** CONFIG **

	 	- TODAS TABELAS DEVEM TER RELA?O COM USER. SELECT  J? PR?DEFINIDO
			EX: SELECT t.*,u.nome as nomeuser,u.id as iduser FROM `$tabela` t left join sh_user u on n.iduser = u.id WHERE n.excluido = 0 $wVisible $wBusca ORDER BY t.ordem ASC , t.id DESC , t.datap DESC

		- REGRA DE VISUALIZA?O

			ADMIN 2: V?a?es de todos os user.
			USER  1: V?apenas de suas a?es.

			$ptip // TIPO DO USER.

		- SEMPRE ORDENAR PELOS CAMPOS ordem , id , (data ou datap)
			EX:
				ORDER BY ordem ASC , id DESC , data DESC

		- LOGS
			Fun?o : logs($acao = 0,$tabela,$registro = NULL,$autor = NULL,$dir = "./logs");

				switch($acao)
				{
					case '1':$acao = "CADASTRO"       ;break;
					case '2':$acao = "ERRO CADASTRO"  ;break;
					case '3':$acao = "ALTERACAO"      ;break;
					case '4':$acao = "ERRO ALTERACAO" ;break;
					case '5':$acao = "REMOCAO"        ;break;
					case '6':$acao = "ERRO REMOCAO"   ;break;
					case '7':$acao = "LOGAR"          ;break;
					case '8':$acao = "ERRO LOGAR"     ;break;
					case '9':$acao = "SAIR"           ;break;
					default :$acao = "UNDEFINED";
				}

		- INSERT
			- TODOS CAMPO A SEREM GRAVADOS NO BANCO TEM Q ESTAR DENTRO DO ARRAY input[]

				EX: <input name="input[titulo]" type="text"/>

				OBS: os campos da tabela devem ser o mesmo do array

		- UPDATE
			- TODOS CAMPO A SEREM ALTERADOS NO BANCO TEM Q ESTAR DENTRO DO ARRAY input[]

				EX: <input name="input[titulo]" type="text" value="<?php echo $ln['titulo']?>"/>

				OBS: os campos da tabela devem ser o mesmo do array

		-CAMPOS OBRIGAT?IOS NAS TABELAS

			CAMPO		TIPO        DEFAULT
			data       	datetime    0000-00-00 00:00:00
			status	   	int(1)      0
			iduser		int(11)		None
			ordem		int(11)     0
			excluido    int(1)      0

		-IGNORAR

			CLASSS					A?O

			.ignorarCampo 			tira valida?o do campo
			.noSort					tira ordenacao de uma tabela (SORTTABLE)
			.noDrag					tira dragdrop de um tabela
			.noCk					tira editor
			.noImgFile				tira imagem do input file
			.noData					tira mascara e calendario
			.noValor				tira mascara de valor
			.nofocus 				tira foco no primeiro campo
			.noCep					tira preenchimento automatico do cep e campos relacionados ex: rua , cidade , estado
			.noMaskFone				tira mascara do telefone/celular
			.noMaskCep				tira mascara do cep
			.noMaskData				tira mascara da data
			.noMaskCnpj				tira mascara do cnpj
			.noMaskCpf				tira mascara do cpf
			.noMaskHora				tira mascara da hora

		-MASCARAS

			CLASSS					A?O

			.maskFone				coloca mascara do telefone/celular
			.maskCep				coloca mascara do cep
			.maskData				coloca mascara da data
			.maskCnpj				coloca mascara do cnpj
			.maskCpf				coloca mascara do cpf
			.maskHora				coloca mascara da hora

	*/

	//CONFIGURA?ES DO MODULO

	$titulo 		= 'Categorias';

	$tabela 		= 'categoria'; //SEM PREFIXO

	$pasta 			= $tabela;//urllimpa($tabela);

	$tabela 		= 'sh_'.$tabela; //PREFIXO + TABELA

	$enderecoPasta 	= $pasta.'/index';

	$cadastra   	= $pasta.'/cadastra';

	$alterar		= $pasta.'/alterar';

	$ver			= $pasta.'/ver';

	//$fotos			= $pasta.'/fotos'; //LIBERA O GERENCIAMENTO DE FOTOS PARA ESSE MODULO

	//BUSCA
	$busca = 't.nome';//CAMPOS A SEREM FILTRADOS NA BUSCA,SEPARADOS POR , . EX: t.nome , t.titulo , c.categoria , f.comentario
	//FIM BUSCA

	//PAGINAC?
	$rPagina  = 12;//REGISTROS POR P?GINA , default: 12
	//FIM PAGINAC?

	//VISUALIZAR
		/*
		 * EX : 'Titulo'=>array('campo'=>'titulo','tipo'=>'texto')
		 * TIPOS : image , texto , video, datahora, data, valor, banner, download
		*/

	$visualizacao = array
	(
		//'Imagem'=>array('campo'=>'img','tipo'=>'image'),
		'Nome'=>array('campo'=>'nome','tipo'=>'texto'),
		//'Chamada'=>array('campo'=>'chamada','tipo'=>'texto'),
		//'Texto'=>array('campo'=>'texto','tipo'=>'texto'),
		//'Data de Publica?o'=>array('campo'=>'datap','tipo'=>'datahora'),
		//'V?eo'=>array('campo'=>'video','tipo'=>'video'),
		//'Data'=>array('campo'=>'datap','tipo'=>'data'),
		//'Data Hora'=>array('campo'=>'datap','tipo'=>'datahora'),
		//'Valor'=>array('campo'=>'valor','tipo'=>'valor'),
		//'Banner'=>array('campo'=>'img','tipo'=>'banner'),
		//'Arquivo dwn'=>array('campo'=>'img','tipo'=>'download')
	);
	//FIM VISUALIZAR

	//ORDEM
	$fOrdem = !isset($_GET['p']) || !is_numeric($_GET['p']) || $_GET['p'] < 1 ? 0 : ($_GET['p'] -1) * $rPagina;
	//FIM ORDEM

	//FIM CONFIGURA?ES DO MODULO
<?php 
include 'conexao.php';
$nomeatual = $_GET['nome'];
$epatual = (int)$_GET['epatual'];
$tempatual = (int)$_GET['temporada'];

function existeEpisodio($cnn, $nome, $temporada, $episodio){
    $sql = mysqli_query($cnn, "select * from listadeanimes WHERE nome = '$nome' and temporada = '$temporada' and episodio = '$episodio'");
    return $sql->num_rows > 0;
}

function buscarEpisodio($cnn, $nome, $temporada, $episodio){
    $sql = mysqli_query($cnn, "select * from listadeanimes WHERE nome = '$nome' and temporada = '$temporada' and episodio = '$episodio'");
    $retorno = 0;
    while($dados = mysqli_fetch_array($sql)){
        $retorno = $dados['id'];
    }
	return $retorno;
}

if  (existeEpisodio($conexao, $nomeatual, $tempatual, $epatual + 1)) {
    $episodio = buscarEpisodio($conexao, $nomeatual, $tempatual, $epatual + 1);
    $endereco = 'Location: assistir.php?idanimeurl='.$episodio;
    header('Location: assistir.php?idanimeurl='.$episodio);
} else if (existeEpisodio($conexao, $nomeatual, $tempatual + 1, 1)) {
	$episodio = buscarEpisodio($conexao, $nomeatual, $tempatual + 1, 1);
	header('Location: assistir.php?idanimeurl='.$episodio);
} else {
  echo "não existe próximo episódio";
}

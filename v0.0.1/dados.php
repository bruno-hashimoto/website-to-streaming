<?php include 'conexao.php';

$idanime = $_GET['idanimeurl'];

$sql =mysqli_query($conexao, "select * from listadeanimes WHERE id = '$idanime'");
while($dados = mysqli_fetch_array($sql)) {
    $id = $dados['id'];
    $nome = $dados['nome'];
    $temporada = $dados['temporada'];
    $episodio = $dados['episodio'];
    $url = $dados['url'];

}


?>


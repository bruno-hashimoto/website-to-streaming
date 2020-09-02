<?php include 'conexao.php';

$nome = $_POST['nome'];
$episodio = $_POST['episodio'];
$temporada = $_POST['temporada'];
$url = $_POST['url'];

$sql2 =mysqli_query($conexao, "select * from listadeanimes where nome = '$nome' and temporada = '$temporada' and episodio = '$episodio'");
$total = mysqli_num_rows($sql2);

if($total > 0) {
    echo "Já existe um anime com esse registro no banco de dados. Contate o Administrador.";
} else {
    $sql = ("insert into listadeanimes(nome, episodio, temporada, url)values('$nome','$episodio','$temporada','$url')");
    mysqli_query($conexao, $sql);

    echo "Anime cadastrado com sucesso! <br/><a href='cadastraranime.php'> Cadastrar mais animes </a>";
}

?>
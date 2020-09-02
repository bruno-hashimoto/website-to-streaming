<?php
    include 'header.php';
    include 'conexao.php';

    $nomeanime = $_GET['anime'];
    $temporada = $_GET['temporada'];
?>
<br>
<div id="content_episodios">
   <div class="item1 text-center">
       
    <h1>
        Lista de episódios <br/>
    </h1>

<?php 
$sql =mysqli_query($conexao, "select * from listadeanimes WHERE nome = '$nomeanime' && temporada = '$temporada' order by episodio asc");
while($dados = mysqli_fetch_array($sql)) {
    echo "<a href=assistir.php?idanimeurl=".$id = $dados['id'].">";
    echo $nome = $dados['nome'].'&nbsp;'.'-'.'&nbsp;';
    echo $temporada = 'Temporada'.'&nbsp;'.$dados['temporada'].'&nbsp;'.'-'.'&nbsp;';
    echo $episodio = 'Episódio'.'&nbsp;'.$dados['episodio'].'<br>'.'<br>';
}
?>

</div>
</div>

</body>
</html>
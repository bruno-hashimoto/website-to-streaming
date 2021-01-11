<?php 
    include 'dados.php'; // inclusão da página conexão com o banco de dados e informações
    include 'header.php'; // inclusão da página header.php
?>
<div class="container">
<div id="titulo-php">
    <br>
    <h5><a style="color: white; font-size: 15px;" href="index.php">Voltar ao menu principal</a></h5>
<h1 style="color:white;"> <?php echo $nome?> / <?php echo 'Temporada'.'&nbsp;'.$temporada?> / <?php echo 'Episódio'.'&nbsp;'.$episodio?></h1>
</div>
</div>

<div class="assistircontent text-center">
    <div class="player">
    <embed src="<?php echo $url?>" autostart="1" height="500" width="900"/> 

    </div>
</div>

<div class="proximo">
    <a href="proximo.php?epatual=<?php echo $episodio?>&temporada=<?php echo $temporada ?>&nome=<?php echo $nome?>"><button>Próximo</button></a></div>

<br/>
<br/>
<footer>
        <div id="footer-line">
            BM COP
        </div>
    </footer>

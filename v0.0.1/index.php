<?php include 'conexao.php'; ?>
<?php include 'header.php'; ?>

<!-- Conteúdo da Página - 1 Categoria -->
<br>
<div class="container">
    <br>
    <div class="row d-flex justify-content-around text-center bg-row">

        <?php
        $sql = mysqli_query($conexao, "select * from listadeanimes where home = 'sim'");
        while ($dados = mysqli_fetch_array($sql)) :
        ?>
            <div class="col-md-3 col-sm-12 foto-capa">
                <img src="./assets/img/<?php echo $dados['foto']; ?>" class="img-fluid">

                <p>
                    <h1><?php echo $dados['nome']; ?></h1>
                </p>

                <a href="listadeepisodios.php?anime=<?php echo $dados['nome']; ?>&temporada=<?php echo $dados['temporada']; ?>">
                    <button class="btn btn-animes mb-3">
                        Assistir
                    </button>
                </a>
            </div>

        <?php endwhile; ?>
    </div>
</div>
<div class="container-fluid">
    <div class="row topo-other-page">

    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12 listagem">

            <?php
            $animes = $sql->select("SELECT * FROM listadeanimes where nome = 'naruto' order by id asc");
            if ($animes) :
                foreach ($animes as $animes) :
            ?>
                    <ul>
                        <li>
                            <a href="">
                                <?php echo "<h1>" . $animes['nome'] . " - Episódio " . $animes['episodio'] . " - Temporada " . $animes['temporada']; ?>
                            </a>
                        </li>
                    </ul>

            <?php
                endforeach;
            endif;
            ?>

        </div>
    </div>
</div>
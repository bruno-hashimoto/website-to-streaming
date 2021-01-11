<?php include 'conexao.php'; 
    include 'header.php'; // inclusão da página header.php
?>
<br>
<br>
<br>
<br>
<br>
<div id="areadecadastro" class="text-center" >

    <form action="cadastrar.php" method="post" style="background-color: #ffffff78;">
        
    <label> 
        Nome:
    </label><br/>
    <input type="text" name="nome" placeholder="digite o nome do anime" class="entradas" required><br/>
    <br/>
    <label> 
        Episódio:
    </label><br/>
    <input type="number" name="episodio" placeholder="digite o episódio" class="entradas" required><br/>
    <br/>
    <label> 
        INSERIR APENAS NÚMEROS - Temporada:
    </label><br/>
    <input type="number" name="temporada" placeholder="digite a temporada" class="entradas" required><br/>
    <br/>
    <label> 
        URL:
    </label><br/>
    <input type="text" name="url" placeholder="digite a url" class="entradas" required><br/>
    <br/>

<div class="cadastrar">
<button  type="submit">Cadastrar</button>
</div>

</div>
</div>

</body>
</html>


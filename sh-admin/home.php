<?php
	include('conn/autenticacao.php');
?>
<div id="meio">
  <div id="boasvindas">
    <h1>Bem Vindo</h1>
    <p>Esse é o administrador do seu site, selecione as opções no menu lateral<br />
      para alterar, excluir ou adicionar alguma informação</p>
    <ul>
      <li><a href="?a=email/index" style="border-left:1px solid #d0ced2;"><img src="imgs_site/iconemail.gif" />Email de contato</a></li>
      <li><a href="?a=user/index"><img src="imgs_site/user.gif" />Adicionar usuário</a></li>
      <li><a href="?a=minhaconta&ref=alt"><img src="imgs_site/senha.gif" />Alterar senha</a></li>
    </ul>
  </div>
</div>
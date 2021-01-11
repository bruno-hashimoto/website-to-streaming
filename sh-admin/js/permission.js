// JavaScript Document
$(document).ready(function()
{
	if(add==0)
	{
		$(".adicionar").removeAttr("href").attr("title","Você não tem permissão para adicionar !").addClass("msgInfo").attr("rel","");
		$(".adicionar-fotos").removeAttr("href").attr("title","Você não tem permissão para adicionar !").addClass("msgInfo").removeClass('upload').attr("rel","");		
	}
	
	if(alt==0)
	{
		$(".alterar").attr("title","Você não tem permissão para alterar !").removeAttr("href").attr("class","msgInfo");
	}
	
	if(del==0)
	{
		$(".excluir").attr("title","Você não tem permissão para excluir !").removeAttr("href").attr("class","msgInfo");		
	}
	
	if(tip <= 1)
	{
		$(".cadPor").removeAttr("title").removeClass("msgInfo");
	}
	
	$(".msgInfo").tooltip({opacity: 1});
});//FIM jQUERY
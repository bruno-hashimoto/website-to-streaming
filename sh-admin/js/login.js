// JavaScript Document
$(document).ready(function()
{
	focusInOut("#formLogin");

	$("input#subRecuperarSenha").live("click",function(event)
	{
		event.preventDefault();
		var el = $(this).parent("p").siblings("label").children("input[type='text'][name='email']");
		var e  = el.val();
		var er = RegExp(/^([0-9a-zA-Z]+([_.-]?[0-9a-zA-Z]+)*@[0-9a-zA-Z]+[0-9,a-z,A-Z,.,-]*(.){1}[a-zA-Z]{2,4})+$/);

		if(e.length > 0 && er.test(e)===true)
		{
			$.ajax
			({
				beforeSend:function()
				{
					$(".loginMsg").text('');
					$("span.loadLogin img").fadeIn("fast");
				},
				url:"enviarecuperarsenha.php",
				type:"post",
				data:"email="+e,
				success:function(data)
				{
					$("span.loadLogin img").fadeOut("fast",function()
					{
						$(".loginMsg").text(data);
					});
				}
			});
		}
		else
		{
			$(".loginMsg").text("E-mail inválido !");
			el.focus();
		}
	});

	$("#formLogin input[name='login']").focus();
	$(".formrecuperarsenha input[name='email']").focus();

	$("#formLogin").submit(function(a)
	{
		a.preventDefault();
		var login = $("#formLogin input[name='login']"),senha = $("#formLogin input[name='senha']");

		if(login.val().length > 0 && senha.val().length > 0)
		{
			login.parent("label").removeClass("msg-erro");
			senha.parent("label").removeClass("msg-erro");

			$.ajax
			({
				beforeSend:function()
				{
					$("span.loadLogin img").fadeIn("fast");
				},
				url:"login.php",
				type:"post",
				data:"login="+login.val()+"&senha="+senha.val(),
				success:function(dados)
				{
					if(dados==true)
					{
						login.parent("label").addClass("msg-true");
						senha.parent("label").addClass("msg-true");

						$("span.loadLogin").text("Redirecionando...");
						window.location.href="sh_index.php";
					}
					else if(dados == 'ERRORLOGIN')
					{
						animaTelaDeLogin("#central");
						login.val("").focus().parent("label").addClass("msg-erro");
					}
					else if(dados == 'ERRORSENHA')
					{
						animaTelaDeLogin("#central");
						senha.val("").focus().parent("label").addClass("msg-erro");
					}
					else
					{
						animaTelaDeLogin("#central");
						login.val("").focus().parent("label").addClass("msg-erro");
						senha.val("").parent("label").addClass("msg-erro");
					}
				},
				complete:function()
				{
					$("span.loadLogin img").fadeOut("fast");
				}
			});
		}
		else if(login.val().length == 0 && senha.val().length > 0)
		{
			senha.parent("label").removeClass("msg-erro");
			login.focus().parent("label").addClass("msg-erro");
		}
		else if(login.val().length > 0 && senha.val().length == 0)
		{
			login.parent("label").removeClass("msg-erro");
			senha.focus().parent("label").addClass("msg-erro");
		}
		else
		{
			animaTelaDeLogin("#central");
			login.focus().parent("label").addClass("msg-erro");
			senha.parent("label").addClass("msg-erro");
		}
	});

	//HACK W,Y FANCYBOX IE7
	var wf = null,hf = null;

	if($.browser.msie && $.browser.version==7.0)
	{
		wf = 380,hf = 255;
	}
	else
	{
		wf = 362,hf = 238;
	}
	// FIM HACK W,Y FANCYBOX IE7

	$("a[rel*='fancybox']").fancybox
	({
		'width': wf,
		'height': hf,
		'autoScale': false,
		'transitionIn':'none',
		'transitionOut':'none',
		'type':'iframe',
		'overlayOpacity':0.5,
		onClosed:function()
		{
			$("#formLogin input[name='login']").focus().parent("label").addClass('focus');
		}
	});

});//END JQUERY

function animaTelaDeLogin(el)
{
	var timeEffect = 80;
	var px = 40;

	$(el).stop().animate(
	{
		"margin-left":'+='+parseInt(px)+ 'px'
	},timeEffect,function()
	{
		$(this).animate(
		{
			"margin-left":'-='+parseInt(px * 2)+ 'px'
		},timeEffect,function()
		{
			$(this).animate(
			{
				"margin-left":'+='+parseInt(px * 2)+ 'px'
			},timeEffect,function()
			{
				$(this).animate(
				{
					"margin-left":'-='+parseInt(px)+ 'px'
				},timeEffect);
			});
		});
	});
}

function focusInOut(el)
{
	$(el).on('focus',"input",function(event)
	{
		event.stopPropagation();

		var el    = $(this);
		var label = el.parent('label');
		var cl    = 'focus';

		label.addClass(cl);

		el.blur(function()
		{
			label.removeClass(cl);
		});
	});
}
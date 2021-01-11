$(document).ready(function()
{
    $('#generate-password').pGenerator({
        'bind': 'click',
        'passwordElement': '#password',
        'displayElement': '#display-password',
        'passwordLength': 10,
        'uppercase': true,
        'lowercase': true,
        'numbers':   true,
        'specialChars': false,
        'onPasswordGenerated': function(password) {
        	var button = $(this);
        	console.log(password);
        }
    });

	iCorlorPicker = new implementColorPicker();
	iCorlorPicker.setElement('div.colorpickerHolder');
	iCorlorPicker.setColor('#00AFDE');//COR PADRÃO
	iCorlorPicker.setElementSetColor('input.setColorpicker');

	var objEndereco = new Endereco();
	//objEndereco.setInfo(true);
	//objEndereco.setContainerClass('');
	objEndereco.buscaEndereco();

	Ck("textarea[name*='texto']:not([class*='noCk']), textarea[class*=texto]:not([class*='noCk'])");

	formFocus(document);

	save('#formCadastro , #formAlterar , #formVer');

	comentInput("textarea.comentfoto","Deixe seu comentário...");

	ctable("table.sortTable");

	//calendar("input[type='text'][name*='data']:not([class*='noData']) , .data:not([class*='noData'])");
	calendar('.calendar');
	calendarTime('.calendarTime');

	$("input[type='text'][name*='valor']:not([class*='noValor']) , .valor:not([class*='noValor'])").priceFormat
	({
		prefix: 'R$ ',
	    centsSeparator: ',',
	    thousandsSeparator: '.'
	});

	$("input[type=file]:not([class*='noImgFile'])").filestyle
	({
		image: "imgs_site/file.png",
		imagewidth : 181,
		imageheight : 39,
		width : 250,
		margintop: -10
	});

	$("a.star").click(function(a)
	{
		a.preventDefault();

		var foto      = $(this).closest("tr").attr("id");
		var param     = $(this).attr("rel").split('-');
		var id_modulo = param[1];
		var modulo    = param[0];
		var element   = $(this);
		var msg       = null;

		if(alt==1)
		{
			if(!element.hasClass('marcarImgPrincipal'))
			{
				$.ajax
				({
					beforeSend:function()
					{
						msg = setMessag('Aguarde...',1);
					},
					url:"marcarprincipal.php",
					data:'foto='+foto+'&id_modulo='+id_modulo+'&modulo='+modulo,
					type:"post",
					success:function(data)
					{
						if(data==true)
						{
							setMessag('A imagem "'+strLower(element.attr('nameImg'),20)+'" foi definida como principal.',1);

							$("a.star").removeClass('marcarImgPrincipal');
							element.addClass("marcarImgPrincipal");
						}
						else
						{
							setMessag('Erro , ao tentar definir "'+strLower(element.attr('nameImg'),20)+'" como principal.',0);
						}
					},
					complete:function()
					{
						msg.fadeOut(300);
					}
				});
			}
			else
			{
				setMessag('A imagem "'+strLower(element.attr('nameImg'),20)+'" já está definida como principal.',2);
			}
		}
		else
		{
			setMessag('Você não tem permissão para alterar.',2);
		}
	});

	$("a[rel='lightbox']").lightBox
	({
		maxWidth:$(window).width() - parseInt(($(window).width()*40)/100),
		maxHeight:$(window).height() - parseInt(($(window).height()*40)/100) ,
		imageLoading  : 'js/lightbox-0.5/images/lightbox-ico-loading.gif',
		imageBtnClose : "js/lightbox-0.5/images/lightbox-btn-close.gif",
		imageBtnPrev  : "js/lightbox-0.5/images/lightbox-btn-prev.gif",
		imageBtnNext  : "js/lightbox-0.5/images/lightbox-btn-next.gif"
 	});

	validateGeral(".validaFormulario");

	maskFields();

	$(".excluir").click(function(l)
	{
		l.preventDefault();

		var e     = $(this);
		var table = e.parents("table").attr("id");
		var id    = e.parents("tr").attr("id");

		if( table.length>0 && id.length>0 )
		{
			if(del==1)
			{
				jConfirm("Confirmar a exclusão desse registro ?","Messagem",function(comfir)
				{
					if(comfir==true)
					{
						var returnAj = processaids(table,id,1);

						returnAj.done(function(a)
						{
							if(a==true)
							{
								var tr = e.closest("tr");

								tr.fadeOut("fast",function()
								{
									tr.remove();

									if($("table.sortTable tbody tr").length == 0)
									{
										setMessag("Registro foi excluido",a,function()
										{
											setMessag("Atualizando...",a,function()
											{
												var url = $("form#busca-modulo").serialize();
												window.location.href='sh_index.php?'+decodeURIComponent(url);
											});
										});
									}
									else
									{
										setMessag("Registro foi excluido",a);
									}
								});
							}
							else
							{
								setMessag("Erro, ao tentar excluir registro",a);
							}
						});

						id = null,table = null;
					}
				});
			}
			else
			{
				setMessag('Você não tem permissão para excluir !',2);
			}
		}
	});

	$(".acoes-list").live("click",function(l)
	{
		l.preventDefault();

		var ids = new Array() , i = 0;
		var ac  = $(this).attr("rel");
		var table = $("table.sortTable").attr("id");
		var i = 0;
		var t = 0;

		$("table.sortTable tbody tr").find("input[type='checkbox']").each(function(index,value)//CONTAGEM DE REGISTROS SELECIONADOS
		{
			if($(this).is(":checked"))
			{
				ids[i] = $(this).parent("td").parent("tr").attr("id");
				i++;
			}
			t++;
		});

		var countId = ids.length;

		if(countId > 0 && ac==1)
		{
			if(del==1)
			{
				jConfirm("Confirmar a exclusão de "+countId+" registo(s) ? ","Messagem",function(comfir)
				{
					if(comfir==true)
					{
						var returnAj = processaids(table,ids,1);

						returnAj.done(function(a)
						{
							if(a==true)
							{
								var msg = (countId > 1 ) ? countId+" registros foram excluidos":"Registro foi excluido";

								$("table.sortTable tbody tr").find("input[type='checkbox']").each(function(index,value)
								{
									if($(this).is(":checked"))
									{
										var tr = $(this).parent("td").parent("tr");

										tr.fadeOut("fast",function()
										{
											tr.remove();
										});
									}
								});

								if(i===t)
								{
									setMessag(msg,a,function()
									{
										setMessag('Atualizando...',1,function()
										{
											var url = $("form#busca-modulo").serialize();
											window.location.href='sh_index.php?'+decodeURIComponent(url);
										});
									});
								}
								else
								{
									setMessag(msg,a);
								}

								ids = null,table = null;
							}
							else
							{
								var msg = (countId > 1 ) ? "Erro, ao tentar excluir "+countId+" registros ":" Erro, ao tentar excluir registro";

								setMessag(msg,a);
							}
						});
					}
				});
			}
			else
			{
				setMessag('Você não tem permissão para excluir !',2);
			}
		}
		else if(countId > 0 && ac==2)
		{
			if(alt==1)
			{
				var returnAj = processaids(table,ids,2);

				returnAj.done(function(a)
				{
					if(a==true)
					{
						var msg = (countId > 1 ) ? countId+" registros foram ativados":"Registro foi ativado";

						$.each(ids,function(i,id)
						{
							$("#"+id).children("td.statusModulo").html("<b class='statusModuloSet'>Ativo</b>");
						});

						setMessag(msg,a);
					}
					else
					{
						var msg = (countId > 1 ) ? "Erro, ao tentar ativar "+countId+" registros ":" Erro, ao tentar ativar registro";

						setMessag(msg,a);
					}
				});
			}
			else
			{
				setMessag('Você não tem permissão para alterar.',2)
			}
		}
		else if(countId > 0 && ac==3)
		{
			if(alt==1)
			{
				var returnAj = processaids(table,ids,3);

				returnAj.done(function(a)
				{
					if(a==true)
					{
						var msg = (countId > 1 ) ? countId+" registros foram inativados":"Registro foi inativado";

						$.each(ids,function(i,id)
						{
							$("#"+id).children("td.statusModulo").html("<b class='statusModuloSet'>Inativo</b>");
						});

						setMessag(msg,a);
					}
					else
					{
						var msg = (countId > 1 ) ? "Erro, ao tentar inativar "+countId+" registros ":" Erro, ao tentar inativar registro";

						setMessag(msg,a);
					}
				});
			}
			else
			{
				setMessag('Você não tem permissão para alterar.',2);
			}
		}
	});

	bool = false;

	$("a.marcar-todos-desmarcar").click(function(a)
	{
		a.preventDefault();
	//	var element  = (del==1) ? $("a[class*='acoes-list']"):$("a[class*='acoes-list'][rel!=1]");
		var selector = $("table.sortTable tbody tr");
		bool = !bool;

		selector.find("input[type='checkbox']").each(function(index)
		{
			var dad = $(this).closest("tr");

			setBgChecked(dad,"bg-checked",bool);

			$(this).attr("checked",bool);
		});

		//(selector.find("input[type='checkbox']:checked").length > 0) ? element.fadeIn("fast"): element.fadeOut("fast");
	});

	MD("a.marcar-todos-user",true);
	MD("a.desmarcar-todos-users",false);

	function MD(element,b)
	{
		$(element).click(function(a)
		{
			a.preventDefault();

			var cl  = "bg-modulos";
			var t   = $(this).closest("table");
			var dad = t.parent("fieldset");

			$(this).closest("fieldset").find("input[type='checkbox']").each(function(index)
			{
				$(this).attr("checked",b);
			});

			(b) ? dad.addClass(cl):dad.removeClass(cl);
		});

	}

	$(".modulos").on("change","input[type='checkbox']",function()
	{
		var t   = $(this).closest("table");
		var dad = t.parent("fieldset");
		var ckd = t.find("input[type='checkbox']:checked").length;
		var cl  = "bg-modulos";

		(ckd > 0) ? dad.addClass(cl):dad.removeClass(cl);
	});

	sortTable("table.sortTable:not([class*='noSort'])");
	drag("table.sortTable:not([class*='noDrag'])");

	$("table.sortTable tbody tr td input[type='checkbox']").change(function()
	{
		var el   = $(this).closest("tr");
		var b = $(this).is(":checked");
		var marcados = $(this).closest("tbody").find("input[type='checkbox']:checked");
		var todos    = $(this).closest("tbody").find("input[type='checkbox']");

		if(marcados.length==todos.length && bool == false || marcados.length == 0)
		{
			bool = !bool;
		}

		setBgChecked(el,"bg-checked",b);

		var element = (del==1) ? $("a[class*='acoes-list']"):$("a[class*='acoes-list'][rel!=1]");
	//	marcados.length > 0 ? element.fadeIn("fast"): element.fadeOut("fast");
	});

	$("a.upload").fancybox
	({
		'width':  ($.browser.msie && $.browser.version==7.0) ? 420:420,
		'height': ($.browser.msie && $.browser.version==7.0) ? 344:342,
		'autoScale': false,
		'transitionIn':'none',
		'transitionOut':'none',
		'type':'iframe',
		'overlayOpacity':0.5,
		onClosed:function()
		{
			var fotos = $("input[type='hidden'][name='up-fotos']").val();

			if( fotos > 0)
			{
				setMessag(fotos+' foto(s) cadastrada(s).',1,function()
				{
					setMessag('Atualizando...',1,function()
					{
						window.location.reload(false);
					});
				});
			}
		}
	});

	//selectSyc("select.class-in","select.class-out","pagina.php");

	focusFirst("#inserir");

	$("ul.acoes").on("click","a.acoes-list",function()
	{
		var ckd = $("table.sortTable tbody tr td input[type='checkbox']:checked").length;

		if(ckd == 0)
		{
			setMessag("Você deve selecionar pelo menos um registro !",2);
		}
	});

	$("a[rel*='fancybox']").fancybox
	({
		'autoScale': false,
		'transitionIn':'none',
		'transitionOut':'none',
		'type':'iframe',
		'overlayOpacity':0.5
	});

	focusQ("input[type='text'][name='q']");

	nextInput();

	$.validator.addMethod('integer', function(value, element, param) {
        return (value > 0) && (value <= 100) &&  (value == parseInt(value, 10));
    }, 'Informe um numero inteiro menor ou igual a 100');

});//FIM jQUERY

function nextInput()
{
	$("table#nextInput-container").on('keydown',"input[type='text']:first-child",function()
	{
		var input = $(this);
		var tr    = input.closest('tr');
		var table = tr.closest('table');

		if(tr.next('tr').length === 0)
		{
			var newTr = tr.clone();
			newTr.children('td').children("input[type='text']:first").removeClass('focusIT');
			table.append(newTr);
		}
	});

	$("table#nextInput-container").on('click','a.removeNextInput',function(event)
	{
		event.preventDefault();
		var tr = $(this).closest('tr');
		var input = tr.find("input[type='text']:first");

		if((tr.next('tr').length > 0 || tr.prev('tr').length > 0) && input.val().length > 0)
			tr.remove();

	});
}

/*
function Ck(ta)
{
	$(ta).summernote({
		lang: 'pt-BR',
	});
}
*/

//*
function Ck(ta)
{
	$(ta).each(function(i)
	{
		var self = $(this);

		self.ckeditor();

		var editor = self.ckeditorGet();

		editor.on("instanceReady", function()
		{
			this.document.on("keyup", function()
			{
				editor.updateElement();
			});

			this.document.on("paste", function()
			{
				editor.updateElement();
			});
		});
	});
}
//*/

function formFocus(forms)
{
	$(forms).on('focus',"input[type='text'], input[type='password'], textarea",function()
	{
		var input = $(this);
		var cl    = 'focusIT';

		input.addClass(cl);

		input.blur(function()
		{
			input.removeClass(cl);
		});
	});
}

function save(form)
{
	var self = $(form);

	if(self.length > 0)
	{
		var ctrl_down = false;
		var ctrl_key = 17;
		var s_key = 83;

		$(document).keydown(function(e)
		{
		    if (e.keyCode == ctrl_key) ctrl_down = true;
		})
		.keyup(function(e)
		{
		    if (e.keyCode == ctrl_key) ctrl_down = false;
		});

		$(document).keydown(function(e)
		{
		    if (ctrl_down && (e.keyCode == s_key))
		    {
		    	e.preventDefault();

		    	if(self.triggerHandler('submit')===true)
				{
					setMessag('Salvando...',1,function()
					{
						self.trigger('submit');
					});
				}
				else
				{
					setMessag('Erro , ao tentar salvar !',0);
				}
		    }
		});
	}
}

function focusQ(el)
{
	if($(el).length && $(el).val().length > 0)
	{
		$(el).focus();
	}
}

function strLower(str,ln)
{
	if(str.length > ln)
	{
		str = str.substr(0,ln)+'...';
	}
	return str;
}

function ctable(el)
{
	var cls = $(el).children("thead").children("tr").children("th").length;
	$(el).children("tbody").children("tr.inf-busca-reg").children("td:first").attr("colspan",cls);
	$(el).children("tfoot").children("tr").children("th:first").attr("colspan",cls - 1);
}

function calendarTime(s)
{
	var date = new Date();

	$.datepicker.setDefaults
	({
		dateFormat: 'dd/mm/yy',
		dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
		dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
		monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro', 'Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set', 'Out','Nov','Dez'],
		nextText: 'Próximo',
		prevText: 'Anterior'
	});

//	$(s).datepicker();

	$.timepicker.regional['br'] =
	{
		timeOnlyTitle: 'Time',
		timeText: 'Time',
		hourText: 'Hora',
		minuteText: 'Minuto',
		secondText: 'Segundo',
		millisecText: 'Milesegundo',
		currentText: 'Hora atual',
		closeText: 'OK',
		ampm: false
	};

	$.timepicker.setDefaults($.timepicker.regional['br']);

	$(s).datetimepicker
	({
		showSecond: true,
		timeFormat: 'hh:mm:ss',
		hour: date.getHours(),
		minute: date.getMinutes(),
		second: date.getSeconds()
	});

	if(!$.browser.msie)
	{
		$('a.ui-state-default').live('click',function()
		{
			$('.ui-datepicker-close').trigger('click');
			$(s).blur();
		});
	}
}

function calendar(s)
{
	var date = new Date();

	$.datepicker.setDefaults
	({
		dateFormat: 'dd/mm/yy',
		dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
		dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
		monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro', 'Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set', 'Out','Nov','Dez'],
		nextText: 'Próximo',
		prevText: 'Anterior'
	});

	$(s).datepicker();

	if(!$.browser.msie)
	{
		$('a.ui-state-default').live('click',function()
		{
			$('.ui-datepicker-close').trigger('click');
			$(s).blur();
		});
	}
}

function focusFirst(s)
{
	var el = $(s).find("input[type='text']:not([class*='nofocus']) , input[type='password']:not([class*='nofocus'])").eq(0);
		el.focus();
}

function setBgChecked(el,cl,b)
{
	// $(el).hasClass(cl) ? $(el).removeClass(cl) : $(el).addClass(cl);
	b===false ? $(el).removeClass(cl) : $(el).addClass(cl);
}

function selectSyc(el_entrada,el_saida,file)
{
	$(el_entrada).live("change",function()
	{
		$.ajax
		({
			url:file,
			data:"id="+$(this).val(),
			type:"post",
			success:function(dados)
			{
				$(el_saida).html(dados);
			}
		});
	});
}

function comentInput(element,txt)
{
	var hgt = ($.browser.msie && $.browser.version==7.0) ? 'normal':410+'%';

	$(document).find(element).each(function(i)
	{
		if($(this).val().length==0)
		{
			$(this).css("line-height",hgt);
			$(this).text(txt);
		}
	});

	$(document).on("mousedown",element,function(event)
	{
		event.stopPropagation();

		var self = $(this), valorEntrada = self.val(), valorSaida = null;
		self.unbind();

		if(alt==1)
		{
			if(self.val()==txt)
			{
				self.val('');
				valorEntrada = '';
			}

			self.css({"background-color":"#FFFFFF","line-height":"normal"});

			self.blur(function()
			{
				valorSaida = self.val();
				idComent   = self.closest("tr").attr("id");
				table      = self.closest("table").attr("id");

				if(valorEntrada=='' && valorSaida.length=='')
				{
					self.val(txt).css("line-height",hgt);
				}
				else if(valorEntrada =='' && valorSaida !='')
				{
					gravaComent(idComent,valorSaida,table).done(function(r)
					{
						if(r==true)
						{
							setMessag('O comentário "'+strLower(valorSaida,30)+'" foi gravado.',1)
						}
						else
						{
							setMessag('Erro , ao tentar gravar o comentário "'+strLower(valorSaida,30)+'".',0)
						}
					});
				}
				else if(valorEntrada!='' && valorSaida == '')
				{
					gravaComent(idComent,valorSaida,table).done(function(r)
					{
						if(r==true)
						{
							setMessag('O comentário "'+strLower(valorEntrada,30)+'" foi removido.',1);
							self.val(txt).css("line-height",hgt);
						}
						else
						{
							setMessag('Erro , ao tentar remover o comentário "'+strLower(valorEntrada,30)+'".',0)
						}
					});
				}
				else if(valorEntrada == valorSaida)
				{
					self.val(valorEntrada);
				}
				else
				{
					gravaComent(idComent,valorSaida,table).done(function(r)
					{
						if(r==true)
						{
							setMessag('O comentário "'+strLower(valorSaida,30)+'" foi alterado.',1)
						}
						else
						{
							setMessag('Erro , ao tentar alterar o comentário "'+strLower(valorSaida,30)+'".',0)
						}
					});
				}

				self.css({"background":"none","border":"none"});

				function gravaComent(id,comen,table)
				{
					var msg = null;

					return $.ajax
					({
						beforeSend:function()
						{
							msg = setMessag('Aguarde...',1);
						},
						url:"gravacomentario.php",
						type:"post",
						cache:false,
						data:"id="+id+"&comentario="+comen+"&table="+table,
						complete:function()
						{
							msg.fadeOut(300);
						}
					});
				}
			});
		}
		else
		{
			self.focus(function()
			{
				self.removeClass('focusIT').blur();
				setMessag('Você não tem permissão para alterar !',2);
			});
		}
	});
}

function maskFields()
{
	$("input[type='text'][name*='fone'] , input[type='text'][name*='cel'] , .maskFone").not('.noMaskFone').mask("(99) 9999-9999");
	$("input[type='text'][name*='cep'] , .maskCep").not('.noMaskCep').mask("99999-999");
	//$("input[type='text'][name*='data']").mask("99/99/9999");
	$(".maskData").not('.noMaskData').mask("99/99/9999");
	$("input[type='text'][name*='cnpj'] , .maskCnpj").not('.noMaskCnpj').mask("99.999.999/9999-99");
	$("input[type='text'][name*='cpf'] , .maskCpf").not('.noMaskCpf').mask("999.999.999-99");
	$("input[type='text'][name*='hora'] , .maskHora").not('.noMaskHora').mask("99:99");
}

function drag(element)
{
	$(element).tableDnD
	({
		onDragStart: function(table, row)
		{
			if(alt!=1)
			{
				setMessag('Você não tem permissão para alterar !',2);
			}

		},
		onDrop:function(table,row)
		{
			if(alt==1)
			{
				ordemList(element);
			}
		},
		onDragClass:'rowDragSelected',
		dragHandle:"dragHandle"
	});

	$(element+" tbody tr").hover(function()
	{
          $(this).children("td.dragHandle").addClass('dragHandleSelected');
    },
	function()
	{
         $(this).children("td.dragHandle").removeClass('dragHandleSelected');
    });
}


function sortTable(element)
{
	$(element).tablesorter
	({
		cssAsc: "sort_asc",
		cssDesc:"sort_desc",
		cssHeader:"sort"
	});
}

function ordemList(element)
{
	//MARCAÇÃO DE POSIÇÕES
	var el     = $(element);
	var table  = el.attr('id');
	var ids    = new Array();
	var fOrdem = el.attr('fOrdem');
	var id_modulo = el.attr('id_modulo');
	var modulo = el.attr('modulo');

	$(element + ' tbody tr').each(function(i)
	{
		ids[i]   = $(this).attr('id');
	});

	if(ids.length > 0)
	{
		var msg = null;

		$.ajax
		({
			beforeSend:function()
			{
				msg = setMessag('Aguarde...',1);
			},
			url:'cadastraordem.php',
			type:'post',
			data:'table='+table+'&ids='+ids+'&fOrdem='+fOrdem+'&id_modulo='+id_modulo+'&modulo='+modulo,
			success:function(d)
			{
				if(d==true)
				{
					var msgS = setMessag('Os registros foram ordenados.',1,function()
					{
						setTimeout(function()
						{
							msgS.fadeOut(400);
						},2000);

					});
				}
				else
				{
					setMessag('Erro , ao tentar ordenar os registros.',0);
				}
			},
			complete:function()
			{
				msg.fadeOut(300);
			}
		});
	}
}

function processaids(table,ids,op)
{
	var msg = null;
	var aj = $.ajax
	({
		beforeSend:function()
		{
			msg = setMessag('Aguarde...',1);
		},
		url:'acoes.php',
		type:"post",
		data:'table='+table+'&ids='+ids+'&action='+op,
		//success:function(a){alert(a)},
		complete:function()
		{
			msg.fadeOut(300);
		}
	});

	return aj;
}

function setMessag(msg,cl,call)
{
	var box = $("div#box-message");
	var ch  = box.children("div").length;
	var newclss = null;
	var html =null;
	var el = null;
	var time = null;

	switch(parseInt(cl))
	{
		case 1:cl = '';break;
		case 2:cl = 'msg-warn';break;
		default: cl = 'msg-error';
	}

	if(msg.length>0)
	{
		newclss =  "msg-"+ch;
		html    =
		'\
			<div class="message '+cl+' '+newclss+' ">\
				<span>'+msg+'</span>\
				<a href="" class="close-message" title="Fechar notificação" ></a>\
			</div>\
		';

		box.append(html);

		el =  $("."+newclss);

		el.fadeIn(500,function()
		{
			call ? call():'';
		});

		time = setTimeout(function()
		{
			el.fadeOut(400);
		},8000);

		el.hover(function()
		{
			clearTimeout(time);
		},
		function()
		{
			time = setTimeout(function()
			{
				el.fadeOut(400);
			},8000);
		})

		box.on("click","a.close-message",function(event)
		{
			event.preventDefault();
			$(this).parent("div").fadeOut("fast");
		});

		return el;
	}
}

function Endereco()
{
	var self = this;
	self.containerClass   = 'infocep';
	self.containerElement = 'label';
	self.selectorInput    = "input[type='text'][name*='cep']:not([class='noCep'])";
	self.event = 'keyup';
	self.info = false;
	self.msgBeforeSend = 'Buscando CEP...';
	self.msgNotFound   = 'CEP não encontrado !';
	self.input = null;

	self.setContainerElement = function(html)
	{
		self.containerElement = html;
	}

	self.setContainerClass = function(cl)
	{
		self.containerClass = cl;
	}

	self.setSelectorInput = function(sel)
	{
		self.selectorInput = sel;
	}

	self.setEvent = function(e)
	{
		self.event = e;
	}

	self.setInfo = function(i)
	{
		self.info = i;
	}

	self.setMsgBeforeSend = function(m)
	{
		self.msgBeforeSend = m;
	}

	self.setmsgNotFound = function(m)
	{
		self.msgNotFound = m;
	}

	self.createElement = function()
	{
		if(self.input.next(self.containerElement).length==0)
		{
			var element = $('<'+self.containerElement+'>').addClass(self.containerClass);
			self.input.after(element);
		}
	}

	self.setInput = function(obj)
	{
		self.input = obj;
	}

	self.buscaEndereco = function()
	{
		$(self.selectorInput).live(self.event,function()
		{
			self.setInput($(this));

			var cep   = self.input.val().replace(/[^0-9\.]+/g,'');

			if(cep.length==8)
			{
				$.ajax
				({
					beforeSend:function()
					{
						if(self.info===true)
						{
							self.createElement();
							self.input.next(self.containerElement).text(self.msgBeforeSend);
						}
					},
					url:'http://cep.republicavirtual.com.br/web_cep.php',
					data:'formato=javascript&cep='+cep,
					type:'get',
				    dataType: 'script',
					success:function(a)
					{
						if(resultadoCEP['resultado']==true)
						{
							$("input[type='text'][name*='rua']:not(:hidden):not([value!=''])").val(unescape(resultadoCEP['tipo_logradouro'])+" "+unescape(resultadoCEP['logradouro'])).focus();
							$("input[type='text'][name*='bairro']:not(:hidden):not([value!=''])").val(unescape(resultadoCEP['bairro'])).focus();
							$("input[type='text'][name*='cidade']:not(:hidden):not([value!=''])").val(unescape(resultadoCEP['cidade'])).focus();
							$("input[type='text'][name*='estado']:not(:hidden):not([value!='']) , input[type='text'][name*='uf']:not(:hidden):not([value!=''])").val(unescape(resultadoCEP['uf'])).focus();

							self.input.next(self.containerElement).text('');
						}
						else
						{
							if(self.info===true)
							{
								self.input.next(self.containerElement).text(self.msgNotFound);
							}
						}
					},
					error:function()
					{
						self.createElement();
						self.input.next(self.containerElement).text('Erro, ao tentar se comunicar com o servidor !');
					}
				});
			}
		});
	}
}

function implementColorPicker()
{
	var self = this;
	self.element = null;
	self.color   = null;
	self.elementSetColor = null;

	self.setElement = function(el)
	{
		self.element = el;
	}

	self.getColor = function()
	{
		return self.color;
	}

	self.setColor = function(hex)
	{
		self.color = hex;
	}

	self.setElementSetColor = function(el)
	{
		self.elementSetColor = el;
	}

	self.getElementSetColor = function()
	{
		return self.elementSetColor;
	}

	self.colorPicker = function()
	{
		$(self.element).ColorPicker
		({
			flat: true,
			color:self.color,
			onChange: function(hsb, hex, rgb)
			{
				$(self.elementSetColor).val('#'+hex);
			}
		});
	}
}

function validateGeral(element)
{
	$(element).validate
	({
		rules:
		{
			'input[porcentagem]':
			{
				required:true,
				integer:true
			},
			'input[id_tamanho]':
			{
				required:true
			},
			'input[id_cor]':
			{
				required:true
			},
			'input[id_categoria]':
			{
				required:true
			},
			'input[cpf]':
			{
				required:true
			},
			'input[rg]':
			{
				required:true
			},
			'input[fone]':
			{
				required:true
			},
			'input[pasta]':
			{
				required:true
			},
			'input[tipo]':
			{
				required:true
			},
			'input[descricao]':
			{
				required:true
			},
			'input[datap]':
			{
				required:true
			},
			'input[peso]':
			{
				required:true
			},
			'input[altura]':
			{
				required:true
			},
			'input[largura]':
			{
				required:true
			},
			'input[comprimento]':
			{
				required:true
			},
			'input[valor]':
			{
				required:true
			},
			'input[idcat]':
			{
				required:true
			},
			'input[login]':
			{
				required:true,minlength:4
			},
			'input[senha]':
			{
				required:true,minlength:4
			},
			'input[nome]':
			{
				required:true
			},
			'input[titulo]':
			{
				required:true
			},
			'input[chamada]':
			{
				required:true
			},
			'input[texto]':
			{
				required:true
			}/*,
			'file[]':
			{
				required:true,minlength: 1
			}*/,
			'input[fonte]':
			{
				required:true
			},
			'input[data]':
			{
				required:true
			},
			'input[video]':
			{
				required:true
			}
			,
			'input[email]':
			{
				required:true,email:true
			}
			,
			'input[destaque]':
			{
				required:true
			}
			,
			'input[status]':
			{
				required:true
			},
			'input[pergunta]':
			{
				required:true
			},
			'input[resposta]':
			{
				required:true
			},
			'input[cep]':
			{
				required:true
			},
			'input[cidade]':
			{
				required:true
			},
			'input[rua]':
			{
				required:true
			}
			,
			'input[datap]':
			{
				required:true
			}
		},
		messages:
		{
			'input[porcentagem]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[id_tamanho]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[id_cor]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[rg]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[id_categoria]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[pasta]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[tipo]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[descricao]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[datap]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[peso]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[altura]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[largura]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[comprimento]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[valor]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[idcat]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[cep]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[cidade]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[rua]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[login]':
			{
				required:"É necessário o preenchimento do campo acima",minlength:"o login de ter pelo menos 4 dígitos"
			},
			'input[senha]':
			{
				required:"É necessário o preenchimento do campo acima",minlength:"a senha de ter pelo menos 4 dígitos"
			},
			'input[nome]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[titulo]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[chamada]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[texto]':
			{
				required:"É necessário o preenchimento do campo de texto"
			}/*,
			'file[]':
			{
				required:"A imagem destaque é necessária"
			}*/
			,
			'input[email]':
			{
				required:"É necessário o preenchimento do campo acima",email:"E-mail inválido !"
			}
			,
			'input[fonte]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[data]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[video]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[destaque]':
			{
				required:"É necessário o preenchimento do campo acima"
			}
			,
			'input[status]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'categoria2[]':
			{
				required:"Escolha pelo menos uma das opções"
			},
			'input[pergunta]':
			{
				required:"É necessário o preenchimento do campo acima"
			},
			'input[resposta]':
			{
				required:"É necessário o preenchimento do campo acima"
			}
			,
			'input[datap]':
			{
				required:"É necessário o preenchimento do campo acima"
			}

		},
		ignore:".ignorarCampo"
	});
//by: JPGM
}